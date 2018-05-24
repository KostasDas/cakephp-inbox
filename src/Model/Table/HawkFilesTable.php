<?php
namespace App\Model\Table;

use Cake\Collection\Collection;
use Cake\Database\Expression\QueryExpression;
use Cake\Event\Event;
use Cake\Http\Exception\UnauthorizedException;
use Cake\I18n\Time;
use Cake\ORM\Query;
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
        $validator->setProvider('hawkFile', 'App\Model\Validation\HawkFileValidator');

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('number')
            ->maxLength('number', 255)
            ->requirePresence('number', 'create')
            ->notEmpty('number', 'Παρακαλώ εισάγετε αριθμό εκδότου');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->requirePresence('type', 'create')
            ->notEmpty('type', 'Παρακαλώ εισάγετε είδος αλληλογραφίας');

        $validator
            ->scalar('topic')
            ->maxLength('topic', 255)
            ->requirePresence('topic', 'create')
            ->notEmpty('topic', 'Παρακαλώ εισάγετε Θέμα/Περίληψη');

        $validator
            ->scalar('sender')
            ->maxLength('sender', 255)
            ->requirePresence('sender', 'create')
            ->notEmpty('sender', 'Παρακαλώ εισάγετε Αποστολέα/Παραλήπτη');

        $validator
            ->add('protocol', 'validateTransitory', [
                'rule' => 'transitory',
                'provider' => 'hawkFile',
                'message' => 'Ο φάκελος πρέπει να έχει είναι της μορφής Φ.ΧΧΧ π.χ. Φ.410'
            ])
            ->maxLength('protocol', 255)
            ->requirePresence('protocol', 'create')
            ->notEmpty('protocol', 'Παρακαλώ εισάγετε Φ/SIC');
        $validator
            ->add('user_id', 'validateUsers', [
                'rule' => 'usersExist',
                'provider' => 'hawkFile',
                'message' => 'Οι χειριστές που εισήχθησαν δεν υπάρχουν'
            ])
            ->requirePresence('user_id', 'create')
            ->notEmpty('user_id', 'Παρακαλώ εισάγετε Χειριστή');

        $validator
            ->add('hawk_file', 'validateInputFile', [
                'rule' => 'fileFormat',
                'provider' => 'hawkFile',
                'message' => 'Κάτι πήγε στραβά με το εισαχθέν αρχείο'
            ])
            ->requirePresence('hawk_file', 'create')
            ->notEmpty('hawk_file', 'Παρακαλώ εισάγετε Αρχείο', 'create');

        $validator->notEmpty('file_type', 'Παρακαλώ διαλέξτε είδος αρχείου')
            ->requirePresence('file_type', 'create');

        $validator->allowEmpty('comments')
            ->requirePresence('comments', false);

        return $validator;
    }

    /**
     * @return \Search\Manager
     */
    public function searchManager()
    {
        $searchManager = $this->behaviors()->Search->searchManager();
        $searchManager
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
            ->add('protocol', 'Search.Callback', [
                'callback' => function ($query, $args, $manager) {
                    if (!$this->isTransitory($args['protocol'])) {
                        return $query->where([$this->aliasField('protocol').' LIKE ' => '%'.$args['protocol'].'%']);
                    }
                    if ($this->isExactTransitorySearch($args['protocol'])) {
                        return $query->where([$this->aliasField('protocol') => 'Φ.'.$args['protocol']]);
                    }
                    return $query->where(function (QueryExpression $exp) use ($args) {
                        $rounded = $this->roundProtocol($args['protocol'], false);
                        return $exp->between($this->aliasField('protocol'), 'Φ.'.$rounded, 'Φ.'. ($rounded+99));
                    });
                },
            ])
            ->add('before', 'Search.Callback', [
                'callback' => function ($query, $args, $manager) {
                    $today = new Time($args['before']);
                    return $query->andWhere([$this->aliasField('created') . ' <=' => $today->addDay()]);
                },
            ])
            ->add('after', 'Search.Callback', [
                'callback' => function ($query, $args, $manager) {

                    return $query->andWhere([$this->aliasField('created') . ' >=' => new Time($args['after'])]);
                },
            ])
            ->add('user', 'Search.Callback', [
                'callback' => function ($query, $args, $manager) {
                    return $query->matching('Users')->where(['Users.id' => $args['user']]);
                },
            ])
            ->value('type')
            ->value('id')
            ->value('file_type')
            ->value('sender');
        return $searchManager;
    }

    private function isTransitory($protocol)
    {
        return is_numeric($protocol);
    }

    private function isExactTransitorySearch($protocol)
    {
        return ($this->roundProtocol($protocol) !== $protocol);
    }

    private function roundProtocol($protocol):string
    {
        return round((float) $protocol, -2, PHP_ROUND_HALF_DOWN);
    }

    // src/Model/Table/ArticlesTable.php

    public function isOwnedBy($file_id, $user_id)
    {
        return $this->HawkUsers->exists(['hawk_file_id' => $file_id, 'user_id' => $user_id]);
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
