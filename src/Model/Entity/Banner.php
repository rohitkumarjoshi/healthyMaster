<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Banner Entity
 *
 * @property int $id
 * @property string $link_name
 * @property string $name
 * @property string $image
 * @property string $status
 */
class Banner extends Entity
{
	
	protected $_virtual = [
			'image_fullpath'
		];


		protected function _getImageFullpath()
		{
			if(!empty($this->_properties['image'])){
				return 'http://13.235.146.226/healthymaster/img/banners/'.$this->_properties['image'];
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
		'link_name' => true,
        'name' => true,
        'image' => true,
        'status' => true
    ];
}
