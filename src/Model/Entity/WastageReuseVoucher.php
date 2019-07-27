<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WastageReuseVoucher Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $created_date
 * @property int $voucher_no
 *
 * @property \App\Model\Entity\WastageReuseVoucherRow[] $wastage_reuse_voucher_rows
 */
class WastageReuseVoucher extends Entity
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
        'created_date' => true,
        'voucher_no' => true,
        'wastage_reuse_voucher_rows' => true
    ];
}
