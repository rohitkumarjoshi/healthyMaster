<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WastageReuseVoucherRows Model
 *
 * @property \App\Model\Table\WastageReuseVouchersTable|\Cake\ORM\Association\BelongsTo $WastageReuseVouchers
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 * @property |\Cake\ORM\Association\BelongsTo $UnitVariations
 *
 * @method \App\Model\Entity\WastageReuseVoucherRow get($primaryKey, $options = [])
 * @method \App\Model\Entity\WastageReuseVoucherRow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\WastageReuseVoucherRow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\WastageReuseVoucherRow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WastageReuseVoucherRow saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\WastageReuseVoucherRow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\WastageReuseVoucherRow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\WastageReuseVoucherRow findOrCreate($search, callable $callback = null, $options = [])
 */
class WastageReuseVoucherRowsTable extends Table
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

        $this->setTable('wastage_reuse_voucher_rows');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('WastageReuseVouchers', [
            'foreignKey' => 'wastage_reuse_voucher_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('UnitVariations', [
            'foreignKey' => 'unit_variation_id',
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

       /*  $validator
            ->decimal('wastage_quantity')
            ->requirePresence('wastage_quantity', 'create')
            ->allowEmptyString('wastage_quantity', false);

        $validator
            ->decimal('reuse_quantity')
            ->requirePresence('reuse_quantity', 'create')
            ->allowEmptyString('reuse_quantity', false); */

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
        $rules->add($rules->existsIn(['wastage_reuse_voucher_id'], 'WastageReuseVouchers'));
        $rules->add($rules->existsIn(['item_id'], 'Items'));
        $rules->add($rules->existsIn(['unit_variation_id'], 'UnitVariations'));

        return $rules;
    }
}
