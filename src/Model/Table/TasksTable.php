<?php
namespace App\Model\Table;

use Cake\Event\Event;
use Cake\Http\Exception\UnauthorizedException;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tasks Model
 *
 * @property \App\Model\Table\HawkFilesTable|\Cake\ORM\Association\BelongsTo $HawkFiles
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Owners
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Task get($primaryKey, $options = [])
 * @method \App\Model\Entity\Task newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Task[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Task|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Task patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Task[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Task findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TasksTable extends Table
{

    protected $user;
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('tasks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->addBehavior('Search.Search');

        $this->addBehavior('Timestamp');

        $this->belongsTo('HawkFiles', [
            'foreignKey' => 'hawk_file_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Owners', [
            'className' => 'Users',
            'foreignKey' => 'owner_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('user_id')
            ->notEmpty('user_id')
            ->requirePresence('user_id', 'create');
        $validator
            ->integer('owner_id')
            ->notEmpty('owner_id')
            ->requirePresence('owner_id', 'create');
        $validator
            ->integer('hawk_file_id')
            ->notEmpty('hawk_file_id')
            ->requirePresence('hawk_file_id', 'create');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->date('due')
            ->allowEmpty('due');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['hawk_file_id'], 'HawkFiles'));
        $rules->add($rules->existsIn(['owner_id'], 'Users'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    public function setUser($user)
    {
        $this->user = $user;
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
            throw new UnauthorizedException('Δε μπορείτε να δείτε ενέργειες αν δεν συνδεθείτε');
        }

        if ($this->user['role'] === 'author') {
            $query->matching('Users')->where(['Users.id' => $this->user['id']]);
        }

        return $query;
    }

    /**
     * @return \Search\Manager
     */
    public function searchManager()
    {
        $searchManager = $this->behaviors()->Search->searchManager();
        $searchManager
            ->add('due', 'Search.Callback', [
                'callback' => function ($query, $args, $manager) {
                    return $query->andWhere([$this->aliasField('due') . ' <=' => new Time($args['due'])]);
                },
            ])
            ->add('user', 'Search.Callback', [
                'callback' => function ($query, $args, $manager) {
                    return $query->matching('Users')->where(['Users.id' => $args['user']]);
                },
            ])
            ->value('done')
            ->value('is_read');
        return $searchManager;
    }
}
