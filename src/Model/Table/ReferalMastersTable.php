<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReferalMasters Model
 *
 * @method \App\Model\Entity\ReferalMaster get($primaryKey, $options = [])
 * @method \App\Model\Entity\ReferalMaster newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ReferalMaster[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ReferalMaster|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReferalMaster saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ReferalMaster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ReferalMaster[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ReferalMaster findOrCreate($search, callable $callback = null, $options = [])
 */
class ReferalMastersTable extends Table
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

        $this->setTable('referal_masters');
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
            ->decimal('receiver_amount')
            ->requirePresence('receiver_amount', 'create')
            ->allowEmptyString('receiver_amount', false);

        $validator
            ->decimal('sender_amount')
            ->requirePresence('sender_amount', 'create')
            ->allowEmptyString('sender_amount', false);

        $validator
            ->decimal('order_value')
            ->requirePresence('order_value', 'create')
            ->allowEmptyString('order_value', false);

        $validator
            ->scalar('status')
            ->maxLength('status', 10)
            ->allowEmptyString('status', false);

        $validator
            ->dateTime('created_on')
            ->allowEmptyDateTime('created_on', false);

        return $validator;
    }
}
