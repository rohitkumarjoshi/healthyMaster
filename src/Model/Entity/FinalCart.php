<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FinalCart Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property int $item_id
 * @property int $item_variation_id
 * @property float $quantity
 * @property float $rate
 * @property float $amount
 * @property int $cart_count
 * @property string $is_combo
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\ItemVariation $item_variation
 */
class FinalCart extends Entity
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
        'customer_id' => true,
        'item_id' => true,
        'item_variation_id' => true,
        'quantity' => true,
        'rate' => true,
        'amount' => true,
        'cart_count' => true,
        'is_combo' => true,
        'customer' => true,
        'item' => true,
        'item_variation' => true
    ];
}
