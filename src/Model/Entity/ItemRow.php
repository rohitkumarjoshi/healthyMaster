<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemRow Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $item_category_id
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created_on
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\ItemCategory $item_category
 */
class ItemRow extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'item_id' => true,
        'item_category_id' => true,
        'status' => true,
        'created_on' => true,
        'item' => true,
        'item_category' => true
    ];
}
