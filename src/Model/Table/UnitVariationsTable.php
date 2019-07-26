<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UnitVariations Model
 *
 * @method \App\Model\Entity\UnitVariation get($primaryKey, $options = [])
 * @method \App\Model\Entity\UnitVariation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UnitVariation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UnitVariation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UnitVariation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UnitVariation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UnitVariation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UnitVariation findOrCreate($search, callable $callback = null, $options = [])
 */
class UnitVariationsTable extends Table
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

        $this->setTable('unit_variations');
        $this->setDisplayField('name');
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->requirePresence('description', 'create')
            ->allowEmptyString('description', false);

        $validator
            ->integer('quantity_factor')
            ->requirePresence('quantity_factor', 'create')
            ->allowEmptyString('quantity_factor', false);

        $validator
            ->date('created_date')
            ->requirePresence('created_date', 'create')
            ->allowEmptyDate('created_date', false);

        return $validator;
    }
}
