<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WastageReuseVouchers Model
 *
 * @property \App\Model\Table\WastageReuseVoucherRowsTable|\Cake\ORM\Association\HasMany $WastageReuseVoucherRows
 *
 * @method \App\Model\Entity\WastageReuseVoucher get($primaryKey, $options = [])
 * @method \App\Model\Entity\WastageReuseVoucher newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WastageReuseVoucher[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WastageReuseVoucher|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WastageReuseVoucher saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WastageReuseVoucher patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WastageReuseVoucher[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WastageReuseVoucher findOrCreate($search, callable $callback = null, $options = [])
 */
class WastageReuseVouchersTable extends Table
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

        $this->setTable('wastage_reuse_vouchers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('WastageReuseVoucherRows', [
            'foreignKey' => 'wastage_reuse_voucher_id'
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
            ->date('created_date')
            ->requirePresence('created_date', 'create')
            ->allowEmptyDate('created_date', false);

        $validator
            ->integer('voucher_no')
            ->requirePresence('voucher_no', 'create')
            ->allowEmptyString('voucher_no', false);

        return $validator;
    }
}
