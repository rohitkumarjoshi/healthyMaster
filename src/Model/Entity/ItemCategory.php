<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemCategory Entity
 *
 * @property int $id
 * @property string $name
 * @property bool $is_deleted
 * @property int $jain_thela_admin_id
 * @property int|null $seller_id
 * @property int|null $city_id
 * @property string|null $image
 * @property int $parent_id
 * @property int $lft
 * @property int $rght
 *
 * @property \App\Model\Entity\Item[] $items
 * @property \App\Model\Entity\Banner $banner
 * @property \App\Model\Entity\HomeScreen $home_screen
 * @property \App\Model\Entity\Cart $cart
 * @property \App\Model\Entity\Wishlist $wishlist
 */
class ItemCategory extends Entity
{
		protected $_virtual = [
			'image_fullpath'
		];

		protected function _getImageFullpath()
		{
			if(!empty($this->_properties['image'])){
				return 'http://healthymaster.in/healthymaster/img/itemcategories/'.$this->_properties['image'];
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
		'name' => true,
        'is_deleted' => true,
        'jain_thela_admin_id' => true,
        'seller_id' => true,
        'city_id' => true,
        'image' => true,
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'has_sub_category' => true,
       
    ];
}
