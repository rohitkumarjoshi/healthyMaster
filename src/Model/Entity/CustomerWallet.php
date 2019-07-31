<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CustomerWallet Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property int $order_no
 * @property int $order_id
 * @property float $add_amount
 * @property float $used_amount
 * @property string $cancel_to_wallet_online
 * @property string $narration
 * @property string $amount_type
 * @property string $transaction_type
 * @property \Cake\I18n\FrozenTime $created_on
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property string $ccavvenue_tracking_no
 * @property string $ccavvenue_order_no
 * @property string $appiled_from
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Order $order
 */
class CustomerWallet extends Entity
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
        'order_no' => true,
        'order_id' => true,
        'add_amount' => true,
        'used_amount' => true,
        'cancel_to_wallet_online' => true,
        'narration' => true,
        'amount_type' => true,
        'transaction_type' => true,
        'created_on' => true,
        'transaction_date' => true,
        'ccavvenue_tracking_no' => true,
        'ccavvenue_order_no' => true,
        'appiled_from' => true,
        'customer' => true,
        'order' => true
    ];
}
