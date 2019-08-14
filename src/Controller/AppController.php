<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

		FrozenTime::setToStringFormat('dd-MM-yyyy hh:mm a');  // For any immutable DateTime
		FrozenDate::setToStringFormat('dd-MM-yyyy');  // For any immutable Date
        $this->loadComponent('RequestHandler');
        $this->loadComponent('AwsFile');
		$this->loadComponent('Pincode');
        $this->loadComponent('Flash');
		$this->loadComponent('Auth', [
		 'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                    ],
                      'userModel' => 'Users'
                ]
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
			'unauthorizedRedirect' => $this->referer(),
        ]);
		$this->Auth->allow(['success','cancel','getOrderOnline','updatestock']);
		
		$login_user_id=$this->Auth->User('id');
		$this->set('login_user_id',$login_user_id);
        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
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
				if($data->status=="In"){ 
					@$QuantityTotalStock+=@$data->item_variation->unit_variation->quantity_factor*$data->total_op_qt;
				}else{
					@$QuantityTotalStock-=@$data->item_variation->unit_variation->quantity_factor*$data->total_op_qt;
				}
			}
		}
		return @$QuantityTotalStock;
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
				if($order_detail->item_id==$item_id){
				@$QuantityTotalStock-=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
				}
			}
		}
		
		
		$ItemVariations=$this->ItemLedgers->ItemVariations->find()->where(['ItemVariations.id'=>$variation_id])->contain(['UnitVariations'])->first();
		
		//pr($QuantityTotalStock); pr($ItemVariations->unit_variation->quantity_factor); exit;
    	$rem=floor($QuantityTotalStock/$ItemVariations->unit_variation->quantity_factor);
		return $rem;
    	exit;
    }
	public function currentStockForWeb($item_id)
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
				if($order_detail->item_id==$item_id){
				@$QuantityTotalStock-=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
				}
			}
		}
		
		
		//$ItemVariations=$this->ItemLedgers->ItemVariations->find()->where(['ItemVariations.id'=>$variation_id])->contain(['UnitVariations'])->first();
		
		//pr($QuantityTotalStock); pr($ItemVariations->unit_variation->quantity_factor); exit;
    	$rem=floor($QuantityTotalStock);
		return $rem;
    	exit;
    }
}
