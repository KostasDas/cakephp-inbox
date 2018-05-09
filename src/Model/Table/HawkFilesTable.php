<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
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

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('hawk_files');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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

        $validator
            ->scalar('office')
            ->maxLength('office', 255)
            ->requirePresence('office', 'create')
            ->notEmpty('office');

        $validator
            ->scalar('location')
            ->maxLength('location', 255)
            ->requirePresence('location', 'create')
            ->notEmpty('location');

        return $validator;
    }
}
