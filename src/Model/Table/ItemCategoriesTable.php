<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemCategories Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $JainThelaAdmins
 * @property |\Cake\ORM\Association\BelongsTo $Sellers
 * @property |\Cake\ORM\Association\BelongsTo $Cities
 * @property |\Cake\ORM\Association\BelongsTo $ParentItemCategories
 * @property |\Cake\ORM\Association\HasMany $ChildItemCategories
 * @property |\Cake\ORM\Association\HasMany $ItemRows
 * @property |\Cake\ORM\Association\HasMany $ItemSubCategories
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\HasMany $Items
 * @property |\Cake\ORM\Association\HasMany $PromoCodes
 *
 * @method \App\Model\Entity\ItemCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\ItemCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ItemCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ItemCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ItemCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemCategory findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class ItemCategoriesTable extends Table
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

        $this->setTable('item_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Tree');
		$this->belongsTo('Banners');
		$this->belongsTo('HomeScreens');
		$this->belongsTo('Carts');
		$this->belongsTo('Wishlists');
        $this->belongsTo('JainThelaAdmins', [
            'foreignKey' => 'jain_thela_admin_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sellers', [
            'foreignKey' => 'seller_id'
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' => 'city_id'
        ]);
        $this->belongsTo('ParentItemCategories', [
            'className' => 'ItemCategories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildItemCategories', [
            'className' => 'ItemCategories',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ItemRows', [
            'foreignKey' => 'item_category_id'
        ]);
        $this->hasMany('ItemSubCategories', [
            'foreignKey' => 'item_category_id'
        ]);
        $this->hasMany('Items', [
            'foreignKey' => 'item_category_id'
        ]);
        $this->hasMany('PromoCodes', [
            'foreignKey' => 'item_category_id'
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->allowEmptyString('name', false);

        $validator
            ->boolean('is_deleted')
            ->allowEmptyString('is_deleted', false);

       /*  $validator
            ->scalar('image')
            ->maxLength('image', 255)
            ->allowEmptyFile('image'); */

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
        $rules->add($rules->existsIn(['jain_thela_admin_id'], 'JainThelaAdmins'));
        $rules->add($rules->existsIn(['seller_id'], 'Sellers'));
        $rules->add($rules->existsIn(['city_id'], 'Cities'));
        $rules->add($rules->existsIn(['parent_id'], 'ParentItemCategories'));

        return $rules;
    }
}
