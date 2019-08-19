<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DeliveryCharge Entity
 *
 * @property int $id
 * @property float $amount
 * @property float $charge
 * @property string $type
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $promo_code_id
 *
 * @property \App\Model\Entity\PromoCode $promo_code
 * @property \App\Model\Entity\Order[] $orders
 */
class DeliveryCharge extends Entity
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
        'id' => true,
        'pincode_no' => true,
        'state_id' => true,
        'city_id' => true,
        'hundred_gm' => true,
        'five_hundred_gm' => true,
        'one_kg' => true,
        'min_order_value' => true,
        'delivery_duration' => true
    ];
}
