<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WastageReuseVoucherRow Entity
 *
 * @property int $id
 * @property int $wastage_reuse_voucher_id
 * @property int $item_id
 * @property int $unit_variation_id
 * @property float $wastage_quantity
 * @property float $reuse_quantity
 *
 * @property \App\Model\Entity\WastageReuseVoucher $wastage_reuse_voucher
 * @property \App\Model\Entity\Item $item
 */
class WastageReuseVoucherRow extends Entity
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
        'wastage_reuse_voucher_id' => true,
        'item_id' => true,
        'unit_variation_id' => true,
        'wastage_quantity' => true,
        'reuse_quantity' => true,
        'wastage_reuse_voucher' => true,
        'item' => true
    ];
}
