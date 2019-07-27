<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UnitVariation Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $quantity_factor
 * @property \Cake\I18n\FrozenDate $created_date
 */
class UnitVariation extends Entity
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
        'name' => true,
        'description' => true,
        'quantity_factor' => true,
        'created_date' => true
    ];
}
