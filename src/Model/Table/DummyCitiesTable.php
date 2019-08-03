<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DummyCities Model
 *
 * @method \App\Model\Entity\DummyCity get($primaryKey, $options = [])
 * @method \App\Model\Entity\DummyCity newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DummyCity[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DummyCity|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DummyCity saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DummyCity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DummyCity[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DummyCity findOrCreate($search, callable $callback = null, $options = [])
 */
class DummyCitiesTable extends Table
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

        $this->setTable('dummy_cities');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('city_name')
            ->maxLength('city_name', 50)
            ->requirePresence('city_name', 'create')
            ->allowEmptyString('city_name', false);

        $validator
            ->scalar('state_name')
            ->maxLength('state_name', 50)
            ->requirePresence('state_name', 'create')
            ->allowEmptyString('state_name', false);

        return $validator;
    }
}
