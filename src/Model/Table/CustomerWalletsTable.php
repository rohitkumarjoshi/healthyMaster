<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CustomerWallets Model
 *
 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\OrdersTable|\Cake\ORM\Association\BelongsTo $Orders
 *
 * @method \App\Model\Entity\CustomerWallet get($primaryKey, $options = [])
 * @method \App\Model\Entity\CustomerWallet newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CustomerWallet[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CustomerWallet|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CustomerWallet saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CustomerWallet patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerWallet[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CustomerWallet findOrCreate($search, callable $callback = null, $options = [])
 */
class CustomerWalletsTable extends Table
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

        $this->setTable('customer_wallets');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id',
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
            ->integer('order_no')
            ->requirePresence('order_no', 'create')
            ->allowEmptyString('order_no', false);

        $validator
            ->decimal('add_amount')
            ->requirePresence('add_amount', 'create')
            ->allowEmptyString('add_amount', false);

        $validator
            ->decimal('used_amount')
            ->requirePresence('used_amount', 'create')
            ->allowEmptyString('used_amount', false);

        $validator
            ->scalar('cancel_to_wallet_online')
            ->maxLength('cancel_to_wallet_online', 30)
            ->requirePresence('cancel_to_wallet_online', 'create')
            ->allowEmptyString('cancel_to_wallet_online', false);

        $validator
            ->scalar('narration')
            ->requirePresence('narration', 'create')
            ->allowEmptyString('narration', false);

        $validator
            ->scalar('amount_type')
            ->maxLength('amount_type', 30)
            ->requirePresence('amount_type', 'create')
            ->allowEmptyString('amount_type', false);

        $validator
            ->scalar('transaction_type')
            ->maxLength('transaction_type', 30)
            ->requirePresence('transaction_type', 'create')
            ->allowEmptyString('transaction_type', false);

        $validator
            ->dateTime('created_on')
            ->allowEmptyDateTime('created_on', false);

        $validator
            ->date('transaction_date')
            ->requirePresence('transaction_date', 'create')
            ->allowEmptyDate('transaction_date', false);

        $validator
            ->scalar('ccavvenue_tracking_no')
            ->maxLength('ccavvenue_tracking_no', 200)
            ->requirePresence('ccavvenue_tracking_no', 'create')
            ->allowEmptyString('ccavvenue_tracking_no', false);

        $validator
            ->scalar('ccavvenue_order_no')
            ->maxLength('ccavvenue_order_no', 200)
            ->requirePresence('ccavvenue_order_no', 'create')
            ->allowEmptyString('ccavvenue_order_no', false);

        $validator
            ->scalar('appiled_from')
            ->maxLength('appiled_from', 200)
            ->requirePresence('appiled_from', 'create')
            ->allowEmptyString('appiled_from', false);

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
        $rules->add($rules->existsIn(['order_id'], 'Orders'));

        return $rules;
    }
}
