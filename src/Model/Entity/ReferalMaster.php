<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ReferalMaster Entity
 *
 * @property int $id
 * @property float $receiver_amount
 * @property float $sender_amount
 * @property float $order_value
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created_on
 */
class ReferalMaster extends Entity
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
        'receiver_amount' => true,
        'sender_amount' => true,
        'order_value' => true,
        'status' => true,
        'created_on' => true
    ];
}
