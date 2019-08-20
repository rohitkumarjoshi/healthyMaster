<?php
namespace App\Controller\Api;
use Cake\Controller\Controller;
use Cake\Event\Event;
class AppController extends Controller
{
    use \Crud\Controller\ControllerTrait;
    public $components = [
        'RequestHandler',
        'Crud.Crud' => [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Crud.Delete'
            ],
            'listeners' => [
                'Crud.Api',
                'Crud.ApiPagination',
                'Crud.ApiQueryLog'
            ]
        ]
    ];
	
	public function initialize()
    {
        parent::initialize();
		
		$this->loadComponent('Pincode');
        
        
    }
	public function actualStock($item_id,$variation_id){
		$this->loadModel('FinalCarts');
		$ItemLedgersData = $this->FinalCarts->find()->select(['item_id','item_variation_id','quantity'])
		->contain(['ItemVariations'=>['UnitVariations']])
		->where(['FinalCarts.item_id'=>$item_id])->autoFields(true);
		
		$QuantityTotalStock=0;
		if($ItemLedgersData){
			$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('FinalCarts.quantity')])
		   ->group(['FinalCarts.item_id']);
		  
			$QuantityTotalStock=0;
			foreach($ItemLedgersData as $data){ 
				@$QuantityTotalStock+=@$data->item_variation->unit_variation->quantity_factor*$data->total_op_qt;
			}
		}
		
		$ItemVariations=$this->ItemLedgers->ItemVariations->find()->where(['ItemVariations.id'=>$variation_id])->contain(['UnitVariations'])->first();
		
    	$rem=floor($QuantityTotalStock);
		
		return $rem;  
    	exit;
		
		
		
		
		
	}
	
	public function currentStockNew($item_id,$variation_id)
    {
		$this->loadModel('ItemLedgers');
		//$ItemLedgers=loadModel(ItemLedgers);
    	//$item_id=$this->request->getData('item_id');
    	//$variation_id=$this->request->getData('variation_id');
		//$item_id=1;
		//$variation_id=2;
		$transaction_date=date('Y-m-d');
		//$transaction_date='2019-07-17';
		
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date','unit_variation_id'])
		->contain(['UnitVariations'])
		->where(['ItemLedgers.transaction_date <= '=>$transaction_date,'item_id'=>$item_id])->autoFields(true);
		
		$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.unit_variation_id','ItemLedgers.item_id','ItemLedgers.status',])
        ;
		
		$QuantityTotalStock=0;
		foreach($ItemLedgersData as $data){
			if($data->status=="In"){ 
				//@$QuantityTotalStock[$data->item_id]+=@$data->item_variation->unit_variation->quantity_factor*$data->total_op_qt;
				@$QuantityTotalStock+=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}else{
				//@$QuantityTotalStock[$data->item_id]-=@$data->item_variation->unit_variation->quantity_factor*$data->total_op_qt;
				@$QuantityTotalStock-=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}
		}
		
		$Orders = $this->ItemLedgers->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=>['UnitVariations']]])->where(['Orders.status NOT IN'=>['Delivered','Cancel']])->toArray();
		foreach($Orders as $Order){
			foreach($Order->order_details as $order_detail){
				if($order_detail->item_id==$item_id  && $order_detail->status != 'Cancel'){
				@$QuantityTotalStock-=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
				}
			}
		}
		
		
		$ItemVariations=$this->ItemLedgers->ItemVariations->find()->where(['ItemVariations.id'=>$variation_id])->contain(['UnitVariations'])->first();
		
    	$rem=floor($QuantityTotalStock);
		return $rem;
    	exit;
    }
	public function currentStock($item_id,$variation_id)
    {
		$this->loadModel('ItemLedgers');
		//$ItemLedgers=loadModel(ItemLedgers);
    	//$item_id=$this->request->getData('item_id');
    	//$variation_id=$this->request->getData('variation_id');
		//$item_id=1;
		//$variation_id=2;
		$transaction_date=date('Y-m-d');
		//$transaction_date='2019-07-17';
		
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date','unit_variation_id'])
		->contain(['UnitVariations'])
		->where(['ItemLedgers.transaction_date <= '=>$transaction_date,'item_id'=>$item_id])->autoFields(true);
		
		$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.unit_variation_id','ItemLedgers.item_id','ItemLedgers.status',])
        ;
		
		$QuantityTotalStock=0;
		foreach($ItemLedgersData as $data){
			if($data->status=="In"){ 
				//@$QuantityTotalStock[$data->item_id]+=@$data->item_variation->unit_variation->quantity_factor*$data->total_op_qt;
				@$QuantityTotalStock+=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}else{
				//@$QuantityTotalStock[$data->item_id]-=@$data->item_variation->unit_variation->quantity_factor*$data->total_op_qt;
				@$QuantityTotalStock-=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}
		}
		
		$Orders = $this->ItemLedgers->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=>['UnitVariations']]])->where(['Orders.status NOT IN'=>['Delivered','Cancel']])->toArray();
		foreach($Orders as $Order){
			foreach($Order->order_details as $order_detail){
				if($order_detail->item_id==$item_id  && $order_detail->status != 'Cancel'){
				@$QuantityTotalStock-=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
				}
			}
		}
		
		
		$ItemVariations=$this->ItemLedgers->ItemVariations->find()->where(['ItemVariations.id'=>$variation_id])->contain(['UnitVariations'])->first();
		
    	$rem=floor($QuantityTotalStock/$ItemVariations->unit_variation->quantity_factor);
		return $rem;
    	exit;
    }
}