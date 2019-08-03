<?php
namespace App\Controller\Component;
use App\Controller\AppController;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
class PincodeComponent extends Component
{
	function initialize(array $config) 
	{
		parent::initialize($config);
	}
	
	/*     Connect to AWS S3   */
	
	public function getDeliveryCharge($pincode = null,$customer_id = null)
    { 
		
		$this->DeliveryCharges = TableRegistry::get('DeliveryCharges');
		$this->Carts = TableRegistry::get('Carts');
		
		$CartDatas=$this->Carts->find()->where(['customer_id'=>$customer_id])->contain(['ItemVariations'=>['UnitVariations']]);
		//pr($CartDatas->toArray()); exit;
		$DeliveryCharges=$this->DeliveryCharges->find()->select(['min_order_value','pincode_no','hundred_gm','five_hundred_gm','one_kg'])->where(['pincode_no'=>$pincode])->first();
		$totalQtInGram=0;
		foreach($CartDatas as $data){
			$temp=$data->cart_count*$data->item_variation->unit_variation->quantity_factor; 	
			$totalQtInGram=$totalQtInGram+$temp;
			//pr($data); 
		}
		$totalQtInGram=$totalQtInGram+100;
	 
		$deliveryAmount=0;
		if($totalQtInGram >= 1000){
			$temp=$totalQtInGram/1000;
			$BeforeDecimalQty=floor($temp);
			$AfterDeimal=$temp-$BeforeDecimalQty;
			$AfterDeimal=$AfterDeimal*1000;
			$deliveryAmount+=$DeliveryCharges->one_kg*$BeforeDecimalQty;
			
			if($AfterDeimal < 1000 && $AfterDeimal > 500){
				$deliveryAmount+=$DeliveryCharges->one_kg;
			}else if($AfterDeimal <= 500 && $AfterDeimal > 0){
				$deliveryAmount+=$DeliveryCharges->five_hundred_gm;
			}
		}else if($totalQtInGram < 1000 && $totalQtInGram > 500){
			$deliveryAmount+=$DeliveryCharges->one_kg;
		}else if($totalQtInGram <= 500 && $totalQtInGram > 0){
			$deliveryAmount+=$DeliveryCharges->five_hundred_gm;
		}
		return $deliveryAmount;
	}
	
	public function getDeliveryChargeOrder($pincode = null,$order_id = null)
    { 
		
		$this->DeliveryCharges = TableRegistry::get('DeliveryCharges');
		$this->OrderDetails = TableRegistry::get('OrderDetails');
		
		$CartDatas=$this->OrderDetails->find()->where(['OrderDetails.order_id'=>$order_id,'OrderDetails.status IS NULL'])->contain(['ItemVariations'=>['UnitVariations']]);
		
		$DeliveryCharges=$this->DeliveryCharges->find()->select(['min_order_value','pincode_no','hundred_gm','five_hundred_gm','one_kg'])->where(['pincode_no'=>$pincode])->first();
		
		$totalQtInGram=0;
		foreach($CartDatas as $data){
			$temp=$data->quantity*$data->item_variation->unit_variation->quantity_factor; 	
			$totalQtInGram=$totalQtInGram+$temp;
			//
		}
		$totalQtInGram=$totalQtInGram+100;
		//pr($totalQtInGram); exit;
		$deliveryAmount=0;
		if($totalQtInGram >= 1000){
			$temp=$totalQtInGram/1000;
			$BeforeDecimalQty=floor($temp);
			$AfterDeimal=$temp-$BeforeDecimalQty;
			$AfterDeimal=$AfterDeimal*1000;
			$deliveryAmount+=$DeliveryCharges->one_kg*$BeforeDecimalQty;
			
			if($AfterDeimal < 1000 && $AfterDeimal > 500){
				$deliveryAmount+=$DeliveryCharges->one_kg;
			}else if($AfterDeimal <= 500 && $AfterDeimal > 0){
				$deliveryAmount+=$DeliveryCharges->five_hundred_gm;
			}
		}else if($totalQtInGram < 1000 && $totalQtInGram > 500){
			$deliveryAmount+=$DeliveryCharges->one_kg;
		}else if($totalQtInGram <= 500 && $totalQtInGram > 0){
			$deliveryAmount+=$DeliveryCharges->five_hundred_gm;
		}
		return $deliveryAmount;
	}
	
}
?>