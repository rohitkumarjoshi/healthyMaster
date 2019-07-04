<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HomeScreens Model
 *
 * @property \App\Model\Table\CategoriesTable|\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsTo $Items
 *
 * @method \App\Model\Entity\HomeScreen get($primaryKey, $options = [])
 * @method \App\Model\Entity\HomeScreen newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\HomeScreen[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HomeScreen|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HomeScreen saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HomeScreen patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HomeScreen[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\HomeScreen findOrCreate($search, callable $callback = null, $options = [])
 */
class HomeScreensTable extends Table
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

        $this->setTable('home_screens');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->belongsTo('ItemCategories', [
            'foreignKey' => 'category_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
            'joinType' => 'LEFT'
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
      /*   $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 200)
            ->requirePresence('title', 'create')
            ->allowEmptyString('title', false);

        $validator
            ->scalar('layout')
            ->maxLength('layout', 150)
            ->requirePresence('layout', 'create')
            ->allowEmptyString('layout', false);

        $validator
            ->scalar('section_show')
            ->maxLength('section_show', 10)
            ->requirePresence('section_show', 'create')
            ->allowEmptyString('section_show', false);

        $validator
            ->integer('preference')
            ->requirePresence('preference', 'create')
            ->allowEmptyString('preference', false);

        $validator
            ->scalar('image')
            ->maxLength('image', 255)
            ->requirePresence('image', 'create')
            ->allowEmptyFile('image', false);

        $validator
            ->scalar('link_name')
            ->maxLength('link_name', 255)
            ->requirePresence('link_name', 'create')
            ->allowEmptyString('link_name', false);

        $validator
            ->integer('web_preference')
            ->requirePresence('web_preference', 'create')
            ->allowEmptyString('web_preference', false); */

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
		//$rules->add($rules->existsIn(['category_id'], 'Categories'));
        //$rules->add($rules->existsIn(['item_id'], 'Items'));

        return $rules;
    }
}
