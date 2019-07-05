<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HomeScreen Entity
 *
 * @property int $id
 * @property string $title
 * @property string $layout
 * @property string $section_show
 * @property int $preference
 * @property int $category_id
 * @property int $item_id
 * @property string $image
 * @property string $link_name
 * @property int $web_preference
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Item $item
 */
class HomeScreen extends Entity
{
	
	protected $_virtual = [
			'image_fullpath'
		];

		protected function _getImageFullpath()
		{
			if(!empty($this->_properties['image'])){
				return 'http://healthymaster.in/healthymaster/img/home_screen/'.$this->_properties['image'];
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
        'title' => true,
        'layout' => true,
        'section_show' => true,
        'preference' => true,
        'category_id' => true,
        'item_id' => true,
        'image' => true,
        'link_name' => true,
        'web_preference' => true,
        'category' => true,
        'item' => true
    ];
}
