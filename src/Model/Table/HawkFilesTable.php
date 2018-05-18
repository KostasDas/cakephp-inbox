<?php
namespace App\Model\Table;

use Cake\Collection\Collection;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Http\Exception\UnauthorizedException;
use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\ResultSet;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HawkFiles Model
 *
 * @method \App\Model\Entity\HawkFile get($primaryKey, $options = [])
 * @method \App\Model\Entity\HawkFile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\HawkFile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HawkFile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HawkFile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HawkFile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\HawkFile findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HawkFilesTable extends Table
{

    protected $user;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     *
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Search.Search');
        $this->setTable('hawk_files');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('Users', [
            'joinTable'  => 'hawk_users',
        ]);

        $this->hasMany('HawkUsers', [
            'table'       => 'hawk_users',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     *
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('number')
            ->maxLength('number', 255)
            ->requirePresence('number', 'create')
            ->notEmpty('number');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->scalar('topic')
            ->maxLength('topic', 255)
            ->requirePresence('topic', 'create')
            ->notEmpty('topic');

        $validator
            ->scalar('sender')
            ->maxLength('sender', 255)
            ->requirePresence('sender', 'create')
            ->notEmpty('sender');

        $validator
            ->scalar('protocol')
            ->maxLength('protocol', 255)
            ->allowEmpty('protocol');

        $validator->notEmpty('file_type', 'Παρακαλώ διαλέξτε είδος αρχείου')
            ->requirePresence('file_type', 'create');

        return $validator;
    }

    /**
     * @return \Search\Manager
     */
    public function searchManager()
    {
        $searchManager = $this->behaviors()->Search->searchManager();
        $searchManager
            ->like('protocol', [
                'before' => true,
                'after'  => true,
                'field'  => $this->aliasField('protocol'),
            ])
            ->like('number', [
                'before' => true,
                'after'  => true,
                'field'  => $this->aliasField('number'),
            ])
            ->like('topic', [
                'before' => true,
                'after'  => true,
                'field'  => $this->aliasField('topic'),
            ])
            ->add('before', 'Search.Callback', [
                'callback' => function ($query, $args, $manager) {
                    return $query->andWhere([$this->aliasField('created') . ' <=' => new Time($args['before'])]);
                },
            ])
            ->add('after', 'Search.Callback', [
                'callback' => function ($query, $args, $manager) {
                    return $query->andWhere([$this->aliasField('created') . ' >=' => new Time($args['after'])]);
                },
            ])
            ->value('type')
            ->value('file_type')
            ->value('sender')
            ->value('Users.id');
        return $searchManager;
    }

    // src/Model/Table/ArticlesTable.php

    public function isOwnedBy($file_id, $user_id)
    {
        return $this->HawkUsers->exists(['file_id' => $file_id, 'user_id' => $user_id]);
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function findShared(Query $query)
    {
        $results = $query->contain('HawkUsers')->all();
        $endSet = new Collection([]);
        foreach ($results as $result) {
            if (count($result->hawk_users) > 1) {
                $endSet = $endSet->appendItem($result);
            }
        }
        return $endSet;
    }

    /**
     * @param Event        $event
     * @param Query        $query
     * @param \ArrayObject $object
     * @param              $primary
     *
     * @return Query
     */
    public function beforeFind(Event $event, Query $query, \ArrayObject $object, $primary)
    {
        if (empty($this->user)) {
            throw new UnauthorizedException('Δε μπορείτε να δείτε αρχεία αν δεν συνδεθείτε');
        }

        if ($this->user['role'] === 'author') {
            $query->matching('Users')->where(['Users.id' => $this->user['id']]);
        }

        return $query;
    }
}
