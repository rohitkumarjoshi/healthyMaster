<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VendorRow Entity
 *
 * @property int $id
 * @property int $vendor_id
 * @property int $item_id
 * @property \Cake\I18n\FrozenTime $created_on
 *
 * @property \App\Model\Entity\Vendor $vendor
 * @property \App\Model\Entity\Item $item
 */
class VendorRow extends Entity
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
		'*'=>true,
        'vendor_id' => true,
        'item_id' => true,
        'created_on' => true,
        'vendor' => true,
        'item' => true
    ];
}
