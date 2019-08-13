<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FinalCarts Model
 *
 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property \App\Model\Table\ItemVariationsTable|\Cake\ORM\Association\BelongsTo $ItemVariations
 *
 * @method \App\Model\Entity\FinalCart get($primaryKey, $options = [])
 * @method \App\Model\Entity\FinalCart newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\FinalCart[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FinalCart|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FinalCart saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FinalCart patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FinalCart[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\FinalCart findOrCreate($search, callable $callback = null, $options = [])
 */
class FinalCartsTable extends Table
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

        $this->setTable('final_carts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ItemVariations', [
            'foreignKey' => 'item_variation_id',
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
            ->allowEmptyString('id', 'create');

        $validator
            ->decimal('quantity')
            ->requirePresence('quantity', 'create')
            ->allowEmptyString('quantity', false);

        $validator
            ->decimal('rate')
            ->requirePresence('rate', 'create')
            ->allowEmptyString('rate', false);

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->allowEmptyString('amount', false);

        $validator
            ->integer('cart_count')
            ->requirePresence('cart_count', 'create')
            ->allowEmptyString('cart_count', false);

        $validator
            ->scalar('is_combo')
            ->maxLength('is_combo', 10)
            ->allowEmptyString('is_combo', false);

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['item_variation_id'], 'ItemVariations'));

        return $rules;
    }
}
