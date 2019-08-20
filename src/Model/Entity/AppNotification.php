<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AppNotification Entity
 *
 * @property int $id
 * @property string $message
 * @property string $image
 * @property string $app_link
 * @property int $item_id
 * @property string $screen_type
 * @property \Cake\I18n\FrozenTime $created_on
 *
 * @property \App\Model\Entity\Item $item
 */
class AppNotification extends Entity
{

    protected $_virtual = [
            'image_fullpath'
        ];

        protected function _getImageFullpath()
        {
            if(!empty($this->_properties['image'])){
                return 'https://healthymaster.in/healthymaster/img/Notify_images/'.$this->_properties['image'];
            }
            else
            {
                return '';
            }
        } 
        

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
        '*' => true,
        'user_id'=>true,
        'id' => false
    ];
}
