<?php
namespace App\Controller;
use Cake\Event\Event;
use Cake\View\View;
use Cake\Routing\Router;
use App\Controller\AppController;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 *
 * @method \App\Model\Entity\Order[] paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
{
	public function cancelOrder()
	{
		$order_id=$this->request->query('order_id');
		$cancel_from=$this->request->query('cancel_from');
		//echo("hello");
		//echo $cancel_from;
		$orders=$this->Orders->find()->where(['Orders.id'=>$order_id])->first();
		$orders->status="Cancel";
		$orders->cancel_from=$cancel_from;
		$orders->cancel_date=date('Y-m-d');
		//echo $order_id; echo $order_from;exit;
		
		if($this->Orders->save($orders))
		{
			//echo 'hello';
			$payment_mode=$orders->order_type;
			$customer_id=$orders->customer_id;
			$grand_total=$orders->grand_total;
			if($payment_mode =="Online" || $payment_mode =="Wallet")
			{
				$CustomerWallets=$this->Orders->CustomerWallets->newEntity();
				$CustomerWallets->customer_id=$orders->customer_id;
				$CustomerWallets->order_id=$orders->id;
				$CustomerWallets->order_no=$orders->order_no;
				$CustomerWallets->add_amount=$orders->grand_total;
				$CustomerWallets->used_amount='';
				$CustomerWallets->transaction_date=date('Y-m-d');
				$CustomerWallets->amount_type='Cancel Order';
				$CustomerWallets->transaction_type='Added';
				$CustomerWallets->appiled_from=$cancel_from;
				$this->Orders->CustomerWallets->save($CustomerWallets);
			}
		}

		exit;
	}
	 public function beforeRender(Event $event)
    {

		parent::initialize();
		$this->Auth->allow(['success','cancel','getOrderOnline']);
		
	}
	
    public function success(){
        	$this->viewBuilder()->layout('index_layout');
             require_once(ROOT . DS  .'vendor' . DS  .  'ccavenu'. DS  .'Crypto.php');
			error_reporting(0);			
			
			$workingKey='0C001564E13B3CF90CF9E4F609FA4399'; 
			$encResponse=$_POST["encResp"];
			$rcvdString=decrypt($encResponse,$workingKey);
			pr($encResponse);exit;
			$order_status="";
			$decryptValues=explode('&', $rcvdString);
			$dataSize=sizeof($decryptValues);
			$trackID = '';
			for($i = 0; $i < $dataSize; $i++) 
			{
				$information=explode('=',$decryptValues[$i]);
				if($information[0] == 'order_status') 
				{	
					$order_status=$information[1];
				}					
				if($information[0] == 'merchant_param1') 
				{ 
					$temp_web_order_id = $information[1]; 
				}
				if($information[0] == 'tracking_id') 
				{ 
					$trackID = $information[1]; 
				}				
			}

			if($order_status==="Success")
			{
				$message = "Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
				
			}
			else if($order_status==="Aborted")
			{
				$message = "Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
			
			}
			else if($order_status==="Failure")
			{
				$message =  "Thank you for shopping with us.However,the transaction has been declined.";
			}
			else
			{
				$message =  "Security Error. Illegal access detected";
			}
			
        	$this->set(compact('message','order_status','trackID'));
        
    }
    
    public function cancel(){
        	$this->viewBuilder()->layout('index_layout');
       require_once(ROOT . DS  .'vendor' . DS  .  'ccavenu'. DS  .'Crypto.php');
			error_reporting(0);
			
		
			$workingKey='8F18338FC2479AEEC244603141373F9F'; 
			
			$encResponse=$_POST["encResp"];
			$rcvdString=decrypt($encResponse,$workingKey);
		
			$order_status="";
			$decryptValues=explode('&', $rcvdString);
			
			$dataSize=sizeof($decryptValues);
			$trackID = '';
			for($i = 0; $i < $dataSize; $i++) 
			{
				$information=explode('=',$decryptValues[$i]);
				if($information[0] == 'order_status') 
				{	
					$order_status=$information[1];
				}					
				if($information[0] == 'merchant_param1') 
				{ 
					$temp_web_order_id = $information[1]; 
				}
				if($information[0] == 'tracking_id') 
				{ 
					$trackID = $information[1]; 
				}				
			}
           
			if($order_status==="Success")
			{
				$message = "Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
				
			}
			else if($order_status==="Aborted")
			{
				$message ="Thank you for shopping with us.However,the transaction has been declined.";
			
			}
			else if($order_status==="Failure")
			{
				$message =  "Thank you for shopping with us.However,the transaction has been declined.";
			}
			else
			{
				$message =  "Security Error. Illegal access detected";
			}
			
	 	$this->set(compact('message','order_status','trackID'));	
        
    }
    
    
   public function getOrderOnline($id=null)
	{		
	
		$this->viewBuilder()->layout('index_layout');
	require_once(ROOT . DS  .'vendor' . DS  .  'ccavenu'. DS  .'Crypto.php');
    	$merchant_data='';	
    	$working_key='8F18338FC2479AEEC244603141373F9F';//Shared by CCAVENUES
    	$access_code='AVXM85GF87AU99MXUA';//Shared by CCAVENUES	
    	$merchant_id='221848';
		$dataArr = array();
	
	
		$tid = uniqid();
		$order_id = uniqid();		
		
		$redirect_url = 'http://healthymaster.in/healthymaster/orders/success';
		$cancel_url = 'http://healthymaster.in/healthymaster/orders/cancel';
		
		$dataArr = array('merchant_id' => $merchant_id,'order_id' => $order_id,'amount' =>1,'currency' =>'INR','redirect_url' =>$redirect_url,'cancel_url' => $cancel_url,'language' => 'EN','merchant_param1' =>1);
	//	pr($dataArr);exit;
		foreach ($dataArr as $key => $value){
			$merchant_data.=$key.'='.$value.'&';
		}
		$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.		
			//pr($encrypted_data);exit;
		$this->set(compact('encrypted_data','working_key','access_code'));	
	}
	
	function convert_number_to_words($no) {
	
	
	 $words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five','6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten','11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen','16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty','30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy','80' => 'eighty','90' => 'ninty','100' => 'hundred','1000' => 'thousand','100000' => 'lakh','10000000' => 'crore');
	if($no == 0)
	{
		$words_blank='';
		$this->response->body($words_blank);
		return $this->response;
	}
	else{
		$novalue='';
		$highno=$no;
		$remainno=0;
		$value=100;
		$value1=1000; 
		
			
				while($no>=100){
					if(($value <= $no) &&($no  < $value1)){
					$novalue=$words["$value"];
					$highno = (int)($no/$value);
					$remainno = $no % $value;
					break;
					}
					$value= $value1;
					$value1 = $value * 100;
				}   
				 	
			  if(array_key_exists("$highno",$words))
			  {  
				 // return $words["$highno"]." ".$novalue." ".$this->convert_number_to_words($remainno);
				$this->response->body($words["$highno"]." ".$novalue." ".$this->convert_number_to_words($remainno));
				
				
				return $this->response;
				
			  }				
			  else { 
				 $unit=$highno%10;
				 $ten =(int)($highno/10)*10;            
				 $words=$words["$ten"]." ".$words["$unit"]." ".$novalue." ".$this->convert_number_to_words($remainno);
			   
			   }
			   
			}
		$this->response->body($words);
		return $this->response;
	}
	
	public function Invoice($id=null){
		
		    $query = $this->Orders->find();
			$invoice_nos=$query->select(['max_value' => $query->func()->max('invoice_no')])->toArray();
			$invoice_no=$invoice_nos[0]->max_value+1;
			$query1 = $this->Orders->query();
			$query1->update()
			->set(['invoice_no' =>$invoice_no,'invoice_date' =>date("Y-m-d")])
			->where(['id' =>$id])
			->execute();
			echo'ok';
			exit;
	}
	
	public function newview($id=null){
		
		$this->viewBuilder()->layout('index_layout');
		$order = $this->Orders->get($id, [
			'contain' => ['Customers', 'CustomerAddresses'=>['States','Cities'], 'PromoCodes', 'OrderDetails'=>['Items'=>['GstFigures'],'ItemVariations'=>['Units']]]
		]);
		
		$this->set(compact('order', 'id', 'print'));
		$this->set('_serialize', ['order']);
		
	}

	public function gstReports()
	{
		$this->viewBuilder()->layout('index_layout'); 
		$gsts=$this->Orders->OrderDetails->find()
		->where(['Orders.invoice_no !='=>' '])
		->contain(['Orders'=>['CustomerAddresses'=>['States']],'Items'=>['GstFigures','ItemCategories'],'ItemVariations'=>['Units']]);
		if ($this->request->is('post')) {
            $datas = $this->request->getData();
            if(!empty($datas['item_id']))
            {
                $gsts->where(['OrderDetails.item_id'=>$datas['item_id']]);
                //pr($datas['customer_id']);
                //pr($Carts->toArray());exit;
            }
            if(!empty($datas['invoice_no']))
            {
                $gsts->where(['Orders.invoice_no'=>$datas['invoice_no']]);
                //pr($datas['customer_id']);
                //pr($Carts->toArray());exit;
            }
             if(!empty($datas['From'])){
                $from_date=date("Y-m-d",strtotime($datas['From']));
                $gsts->where(['Orders.invoice_date >='=> $from_date]);
            }
            if(!empty($datas['To'])){ 
                $to_date=date("Y-m-d",strtotime($datas['To']));
                $gsts->where(['Orders.invoice_date <=' => $to_date ]);
            }
        }
		$items=$this->Orders->OrderDetails->Items->find('list')->where(['freeze'=>0]);
		//pr($gsts->toArray());exit;
		$this->set(compact('gsts','items'));
	}
	public function oreport()
    {
        $this->viewBuilder()->layout('index_layout'); 
        //$order=$this->Orders->OrderDetails->newEntity();
        $orders=$this->Orders->OrderDetails->find()->contain(['Orders'=>['CustomerAddresses'=>['Cities','States'],'Customers'],'Items'=>['ItemCategories'],'ItemVariations'=>['Units']]);
         if ($this->request->is('post')) {
            $datas = $this->request->getData();
            if(!empty($datas['apartment_name']))
            {
                $orders->where(['CustomerAddresses.apartment_name'=>$datas['apartment_name']]);
            }
             if(!empty($datas['item_id']))
            {
                $orders->where(['OrderDetails.item_id'=>$datas['item_id']]);
                //pr($datas['customer_id']);
                //pr($Carts->toArray());exit;
            }
              if(!empty($datas['status']))
            {
                $orders->where(['Orders.status'=>$datas['status']]);
            }
             if(!empty($datas['mobile']))
            {
                $orders->where(['Customers.mobile'=>$datas['mobile']]);
                //pr($datas['customer_id']);
                //pr($Carts->toArray());exit;
            }
           
            if(!empty($datas['From'])){
                $from_date=date("Y-m-d",strtotime($datas['From']));
                $orders->where(['Orders.order_date >='=> $from_date]);
            }
            if(!empty($datas['To'])){ 
                $to_date=date("Y-m-d",strtotime($datas['To']));
                $orders->where(['Orders.order_date <=' => $to_date ]);
            }
        }
        $items=$this->Orders->OrderDetails->Items->find('list')->where(['freeze'=>0]);
        $this->set(compact('orders','items'));
    }
	public function initialize()
	{
		parent::initialize();
		$this->Auth->allow(['logout']);
		$role_id=$this->Auth->User('role_id');
		$this->set(compact(['role_id']));
	}

	public function getPrice(){
        $item_variation_id=$this->request->getData('input'); 
        //$item_variation_id=32; 
        $items=$this->Orders->OrderDetails->ItemVariations->find()->where(['ItemVariations.id '=>$item_variation_id])->first();
        $temp=[];
        $temp[]=$items->sales_rate;	
		$maxQt=$this->currentStock($items->item_id,$item_variation_id);
		$temp[]=$maxQt;	
		
		//$temp1[]= implode(",",$temp); 
		echo implode(",",$temp);
        exit;  
    }

	public function options(){
        $item_id=$this->request->getData('input'); 

            $items=$this->Orders->OrderDetails->ItemVariations->find()->where(['ItemVariations.item_id '=>$item_id])->contain(['Units']);
            ?>
                    <option>--Select--</option>
                    <?php foreach($items as $show){ ?>
                        
                        <option value="<?= $show->id ?>"><?= $show->quantity_variation." ".$show->unit->shortname ?></option>
                    <?php } ?>
            <?php
        
        exit;  
    }
	public function optionsnew(){
        $item_id=$this->request->getData('input'); 

            $items=$this->Orders->OrderDetails->ItemVariations->find()->where(['ItemVariations.item_id '=>$item_id])->contain(['UnitVariations']);
            ?>
                    <option>--Select--</option>
                    <?php foreach($items as $show){ ?>
                        
                        <option class="item_variation_id" value="<?= $show->id ?>"><?= $show->quantity_variation ?></option>
                    <?php } ?>
            <?php
        
        exit;  
    }

    public function readyPacked($id=null,$temp_id=null)
    {
    	//$this->viewBuilder()->layout('index_layout');
    	$order = $this->Orders->get($id);
         $order->status="Packed";
         $temporaryOrder = $this->Orders->TemporaryOrders->get($temp_id);
         //pr($temporaryOrder);exit;
         $this->Orders->TemporaryOrders->delete($temporaryOrder);


        $x=$this->Orders->save($order);
         if ($x) {
                $this->Flash->success(__('The order has been packed.'));
                 return $this->redirect(['controller' => 'TemporaryOrders', 'action' => 'index']);
                }
	

    }
    public function usedPromoCodeReport()
    {
    	$this->viewBuilder()->layout('index_layout');
    	$used_promo=$this->Orders->find()
    	->where(['promo_code_id >'=>0])
    	->contain(['PromoCodes','Customers']);
    	if ($this->request->is('post')) {
            $datas = $this->request->getData();
            if(!empty($datas['mobile']))
            {
                $used_promo->where(['Customers.mobile'=>$datas['mobile']]);
                //pr($datas['customer_id']);
                //pr($Carts->toArray());exit;
            }
            if(!empty($datas['code']))
            {
                $used_promo->where(['PromoCodes.code'=>$datas['code']]);
                //pr($datas['customer_id']);
                //pr($Carts->toArray());exit;
            }
             if(!empty($datas['order_no']))
            {
                $used_promo->where(['Orders.order_no'=>$datas['order_no']]);
            }
            if(!empty($datas['From'])){
                $from_date=date("Y-m-d",strtotime($datas['From']));
                $used_promo->where(['Orders.order_date >='=> $from_date]);
            }
            if(!empty($datas['To'])){ 
                $to_date=date("Y-m-d",strtotime($datas['To']));
                $used_promo->where(['Orders.order_date <=' => $to_date ]);
            }
        }
    	//pr($used_promo->toArray());exit;
    	$this->set(compact(['used_promo']));
    }


	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow([ 'logout', 'login']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
	 
	public function dashboard()
    { 
		$this->viewBuilder()->layout('index_layout');
		$curent_date=date('Y-m-d');
		$next_date=date('Y-m-d', strtotime('+1 day'));
		$query = $this->Orders->find();
		$from_date = $this->request->query('From');
		$to_date = $this->request->query('To');
		if(!empty($from_date)){
			$from_date=date("Y-m-d",strtotime($this->request->query('From')));
		}
		if(!empty($to_date)){
			$to_date=date("Y-m-d",strtotime($this->request->query('To')));
		}
		
		if(empty($from_date)){
			$from_date=date("Y-m-d");
		}
		if(empty($to_date)){
			$to_date=date("Y-m-d");
		}
		$totalOrder=$query
		->select([
		'count' => $query->func()->count('id'),
		'total_amount' => $query->func()->sum('Orders.grand_total')])
		->where(['Orders.delivery_date >=' => $from_date, 'Orders.delivery_date <=' => $to_date,'Orders.order_type !=' =>'Bulkorder'])->first();
		$this->set(compact('totalOrder'));
		
		$query = $this->Orders->find();
		$inProcessnextdayOrder=$query->select([
		'count' => $query->func()->count('id'),
		'total_amount' => $query->func()->sum('Orders.grand_total')])
		->where(['Orders.delivery_date' => $next_date, 'Orders.status' => 'In Process', 'Orders.order_type !=' =>'Bulkorder'])->first();
		$this->set(compact('inProcessnextdayOrder'));
		
		$query = $this->Orders->find();
		$inProcessnextdayBulk=$query->select([
		'count' => $query->func()->count('id'),
		'total_amount' => $query->func()->sum('Orders.grand_total')])
		->where(['Orders.delivery_date' => $next_date, 'Orders.status' => 'In Process', 'Orders.order_type' =>'Bulkorder'])->first();
		$this->set(compact('inProcessnextdayBulk'));
		
		$query = $this->Orders->find();
		$inProcessOrder=$query->select([
		'count' => $query->func()->count('id'),
		'total_amount' => $query->func()->sum('Orders.grand_total')])
		->where(['Orders.delivery_date >=' => $from_date, 'Orders.delivery_date <=' => $to_date, 'Orders.status' => 'In Process', 'Orders.order_type !=' =>'Bulkorder'])->first();
		$this->set(compact('inProcessOrder'));
		
		
		$query = $this->Orders->find();
		$deliveredOrder=$query->select([
		'count' => $query->func()->count('id'),
		'total_amount' => $query->func()->sum('Orders.grand_total')])
		->where(['Orders.delivery_date >=' => $from_date, 'Orders.delivery_date <=' => $to_date, 'Orders.status' => 'Delivered', 'Orders.order_type !=' =>'Bulkorder'])->first();
		$this->set(compact('deliveredOrder'));
		
		
		$query = $this->Orders->find();
		$cancelOrder=$query->select([
		'count' => $query->func()->count('id'),
		'total_amount' => $query->func()->sum('Orders.grand_total')])
		->where(['Orders.delivery_date >=' => $from_date, 'Orders.delivery_date <=' => $to_date, 'Orders.status' => 'Cancel','Orders.order_type !=' =>'Bulkorder'])->first();
		$this->set(compact('cancelOrder'));
		
		$query = $this->Orders->find();
		$totalBulkOrder=$query->select([
		'count' => $query->func()->count('id'),
		'total_amount' => $query->func()->sum('Orders.grand_total')])
		->where(['Orders.delivery_date >=' => $from_date, 'Orders.delivery_date <=' => $to_date, 'Orders.order_type' =>'Bulkorder'])->first();
		
		$this->set(compact('totalBulkOrder'));
		
		$query = $this->Orders->find();
		$bulkOrderInProcess=$query->select([
		'count' => $query->func()->count('id'),
		'total_amount' => $query->func()->sum('Orders.grand_total')])
		->where(['Orders.delivery_date >=' => $from_date, 'Orders.delivery_date <=' => $to_date, 'Orders.order_type' => 'Bulkorder', 'Orders.status' => 'In Process'])->first();
		$this->set(compact('bulkOrderInProcess'));
		
		$query = $this->Orders->find();
		$bulkOrderdelivered=$query->select([
		'count' => $query->func()->count('id'),
		'total_amount' => $query->func()->sum('Orders.grand_total')])
		->where(['Orders.delivery_date >=' => $from_date, 'Orders.delivery_date <=' => $to_date, 'Orders.order_type' => 'Bulkorder', 'Orders.status' => 'Delivered'])->first();
		$this->set(compact('bulkOrderdelivered'));
		
		$query = $this->Orders->find();
		$cancelBulkOrder=$query->select([
		'count' => $query->func()->count('id'),
		'total_amount' => $query->func()->sum('Orders.grand_total')])
		->where(['Orders.delivery_date >=' => $from_date, 'Orders.delivery_date <=' => $to_date, 'Orders.status' => 'Cancel','Orders.order_type' =>'Bulkorder'])->first();
		$this->set(compact('cancelBulkOrder'));
		
		$this->loadModel('WalkinSales');
		$query = $this->WalkinSales->find();
		$walkinsales=$query->select([
		'count' => $query->func()->count('id'),
		'total_amount' => $query->func()->sum('total_amount')]) 
		->where(['WalkinSales.transaction_date >=' => $from_date,'WalkinSales.transaction_date <=' => $to_date,'WalkinSales.cancel_id' => 0])->first();
		$this->set(compact('walkinsales'));
		
		
		$query = $this->Orders->find();
		$wallet_amount=$query->select([
		'total_amount' => $query->func()->sum('Orders.amount_from_wallet')])
		->where(['Orders.delivery_date >=' => $from_date, 'Orders.delivery_date <=' => $to_date,  'Orders.status' => 'Delivered','Orders.amount_from_wallet >' => 0])->first();
		$this->set(compact('wallet_amount'));
		
		$query = $this->Orders->find();
		$online_amount=$query->select([
		'total_amount' => $query->func()->sum('Orders.online_amount')])
		->where(['Orders.delivery_date >=' => $from_date, 'Orders.delivery_date <=' => $to_date,  'Orders.status' => 'Delivered','Orders.online_amount >' => 0])->first();
		$this->set(compact('online_amount'));
		
		$query = $this->Orders->find();
		$pay_amount=$query->select([
		'total_amount' => $query->func()->sum('Orders.pay_amount')])
		->where(['Orders.delivery_date >=' => $from_date, 'Orders.delivery_date <=' => $to_date,  'Orders.status' => 'Delivered','Orders.pay_amount >' => 0])->first();
		$this->set(compact('pay_amount'));
		
		$query = $this->Orders->find();
		$total_sale_amount=$query->select([
		'total_amount' => $query->func()->sum('Orders.grand_total')])
		->where(['Orders.delivery_date >=' => $from_date, 'Orders.delivery_date <=' => $to_date,  'Orders.status' => 'Delivered','Orders.grand_total >' => 0])->first();
		$this->set(compact('total_sale_amount'));
		
		$curent_date=date('Y-m-d');
		$orders = $this->Orders->find('all')->order(['Orders.id'=>'DESC'])->where(['curent_date >=' => $from_date,'curent_date <=' => $to_date, 'Orders.status'=>'In process'])->contain(['Customers']);
		$this->set(compact('orders','from_date','to_date'));
        $this->set('_serialize', ['orders']);
    }

    public function ajaxAutocompleted(){
        $mobile=$this->request->getData('input'); 
        $searchType=$this->request->getData('searchType');
        if($searchType == 'item_name'){
            $items=$this->Orders->Customers->find()->where(['Customers.mobile Like'=>''.$mobile.'%']);
            ?>
                <ul id="item-list" style="width: 90% !important;">
                    <?php foreach($items as $show){ ?>
                        <li onClick="selectAutoCompleted('<?php echo $show->id;?>','<?php echo $show->mobile;?>')">
                            <?php echo $show->mobile?>    
                        </li>
                    <?php } ?>
                </ul>
            <?php
        }
        
        exit;  
    }

    public function statuses()
    {
    	$x=0;
    	 $status=$this->request->getData('status'); 
        $id=$this->request->getData('order_id');

        if($status == 'In Process'){
	            $packed=$this->Orders->get($id);

		         $packed->status="In Process";
		         $this->Orders->save($packed);
           }

        if($status == 'Packed'){
	            $packed=$this->Orders->get($id);

		         $packed->status="Packed";
		         $this->Orders->save($packed);
           }
           if($status == 'Dispatch'){
	            $packed=$this->Orders->get($id);

		         $packed->status="Dispatch";
		         $this->Orders->save($packed);
           }if($status == 'Delivered'){
	            $packed=$this->Orders->get($id);

		        //pr($packed);exit;
		        $packed->status="Delivered";
		        if($this->Orders->save($packed))
		        {
		        	//alert();
					
					$Ordersdatas=$this->Orders->get($id,['contain'=>['OrderDetails'=>['Items'=>['GstFigures']]]]);
					//pr($Ordersdatas);
					foreach($Ordersdatas->order_details as $data){
						$gst=0; $taxbale_amount=0;
						 $order_detail_id=$data->id;
						 $amount=$data->amount;
						 $gst_figure_id=$data->item->gst_figure_id;
						 $tax_percentage=$data->item->gst_figure->tax_percentage;
						 $gst=(($amount*$tax_percentage)/(100+$tax_percentage));
						 $gst= round($gst,2);
						 $taxbale_amount=$amount-$gst;
						 
						$query = $this->Orders->OrderDetails->query();
						$query->update()
						->set(['net_amount' =>$taxbale_amount,'gst_amount' =>$gst,'gst_figure_id' => $gst_figure_id])
						->where(['id' =>$order_detail_id])
						->execute();
						 
						 
					}
					
					
		        	$order_id=$packed->id;
		        	//pr($order_id);
		        	$order_detail=$this->Orders->OrderDetails->find()->where(['order_id'=>$order_id])->contain(['ItemVariations']);
					
					foreach ($order_detail as $detail) { 
					$unit_variation_id=$detail->item_variation->unit_variation_id; 
					
					$query = $this->Orders->ItemLedgers->query();
                    $query->insert(['jain_thela_admin_id', 'driver_id','item_id', 'warehouse_id','order_id', 'purchase_booking_id', 'rate', 'amount', 'status', 'quantity','rate_updated','item_variation_id','unit_variation_id'])
                    ->values([
                        'jain_thela_admin_id' => 1,
                        'driver_id' => 0,
                        //'grn_id' => $grn_id,
                        'item_id' => $detail->item_id,
                        'warehouse_id' => 1,
                        'order_id' => $detail->order_id,
                        'purchase_booking_id' => 0,
                        'rate' => $detail->rate,
                        'item_variation_id' => $detail->item_variation_id,
                        'amount' => $detail->amount,
                        'status' => 'Out',
                        'quantity' => $detail->quantity,
                        'rate_updated' => 'OK',
						'unit_variation_id'=>$unit_variation_id
                    ]);
                    $query->execute();	        		
					}		 
		        }
           }
           exit;
    }
	
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$curent_date=date('Y-m-d');
		$status = $this->request->query('status');
		$type = $this->request->query('type');
		$order_no = $this->request->query('order_no');
		$customer_id = $this->request->query('customer');
		$order_types = $this->request->query('order_type');
		$orderstatus = $this->request->query('orderstatus');
		$from_date = $this->request->query('From');
		$to_date = $this->request->query('To');
		$where =[];
		$orders =$this->paginate($this->Orders->find()->where(['Orders.status !='=>'Delivered'])->order(['Orders.id'=>'DESC'])->contain(['CustomerAddresses','Customers']));
		if(!empty($order_no)){
			$orders =$this->paginate($this->Orders->find()->where(['Orders.order_no Like'=>'%'.$order_no.'%'])->order(['Orders.id'=>'DESC'])->contain(['CustomerAddresses','Customers']));
		}
		if(!empty($mobile)){
			$orders =$this->paginate($this->Orders->find()->where(['Customers.mobile'=>$mobile])->order(['Orders.id'=>'DESC'])->contain(['CustomerAddresses','Customers']));
			
		}
		if(!empty($order_types)){
			$orders =$this->paginate($this->Orders->find()->where(['Orders.order_type'=>$order_type])->order(['Orders.id'=>'DESC'])->contain(['CustomerAddresses','Customers']));
		}
		if(!empty($orderstatus)){
			$orders =$this->paginate($this->Orders->find()->where(['Orders.status'=>$orderstatus])->order(['Orders.id'=>'DESC'])->contain(['CustomerAddresses','Customers']));

		}
		if(!empty($from_date)){ 
			$orders =$this->paginate($this->Orders->find()->where(['Orders.curent_date >='=>date('Y-m-d',strtotime($from_date))])->order(['Orders.id'=>'DESC'])->contain(['CustomerAddresses','Customers']));
		}
		if(!empty($to_date)){
			$orders =$this->paginate($this->Orders->find()->where(['Orders.curent_date <='=>date('Y-m-d',strtotime($to_date))])->order(['Orders.id'=>'DESC'])->contain(['CustomerAddresses','Customers']));
		}
		//pr($where); exit;
		//pr($where);exit;
		 $this->paginate = [
            'contain' => ['Customers']
        ];
		
		// if($status == 'In Process'){ 
							
		// 					$where['Orders.status']='In Process';
		// 					$cur_date = date('d-m-Y');
		// 					$orders =$this->paginate($this->Orders->find('all')
		// 					->where($where)
		// 					->order(['Orders.id'=>'DESC'])
		// 					->contain(['CustomerAddresses']));
		// 					$cur_status = 'In Process';
		// 					 $this->set(compact('orders','cur_status','cur_date','status'));
		// }else if($status == 'Delivered'){
		// 					$where['Orders.status']='Delivered';
		// 					$cur_date = date('d-m-Y');
		// 					$orders =$this->paginate($this->Orders->find('all')
		// 					->where($where)
		// 					->order(['Orders.id'=>'DESC'])
		// 					->contain(['CustomerAddresses']));
		// 					$cur_status = 'Delivered';
							
		// 					 $this->set(compact('orders','cur_status','cur_date','status'));
		// 					}
		// else if($status == 'Packed'){
		// 					$where['Orders.status']='Packed';
		// 					$cur_date = date('d-m-Y');
		// 					$orders =$this->paginate($this->Orders->find('all')
		// 					->where($where)
		// 					->order(['Orders.id'=>'DESC'])
		// 					->contain(['CustomerAddresses']));
		// 					$cur_status = 'Packed';
							
		// 					 $this->set(compact('orders','cur_status','cur_date','status'));
		// 					}
		// else if($status == 'Dispatch'){
		// 					$where['Orders.status']='Dispatch';
		// 					$cur_date = date('d-m-Y');
		// 					$orders =$this->paginate($this->Orders->find('all')
		// 					->where($where)
		// 					->order(['Orders.id'=>'DESC'])
		// 					->contain(['CustomerAddresses']));
		// 					$cur_status = 'Dispatch';
							
		// 					 $this->set(compact('orders','cur_status','cur_date','status'));
		// 					}
		// // else if($status == 'cancel'){
		// // 					$where['Orders.status']='Cancel';
		// // 					$cur_date = date('d-m-Y');
		// // 					$orders =$this->paginate($this->Orders->find('all')
		// // 					->where($where)
		// // 					->order(['Orders.id'=>'DESC'])
		// // 					->where(['jain_thela_admin_id'=>$jain_thela_admin_id,'Orders.curent_date'=>$cur_date])
		// // 					->contain(['CustomerAddresses']));
		// // 					$cur_status = 'Cancel';
			
		// // 					$this->set(compact('orders','cur_status','cur_date','status'));
		// //}
		// else if($type == 'bulkorder'){ 
		// 					$where['Orders.order_type']='Bulkorder';
		// 					$cur_date = date('d-m-Y');
		// 					$orders =$this->paginate($this->Orders->find('all')
		// 					->where($where)
		// 					->order(['Orders.id'=>'DESC'])
		// 					->where(['jain_thela_admin_id'=>$jain_thela_admin_id,'Orders.curent_date'=>$cur_date])
		// 					->contain(['CustomerAddresses']));
		// 					$cur_type = 'Bulkorder';
							
		// 					 $this->set(compact('orders','cur_date','cur_type'));
		// }else if($status == 'yes'){
		// 					$cur_date = date('d-m-Y');
		// 					$orders =$this->paginate($this->Orders->find('all')
		// 					->where($where)
		// 					->order(['Orders.id'=>'DESC'])
		// 					->where(['jain_thela_admin_id'=>$jain_thela_admin_id,'Orders.curent_date'=>$cur_date])
		// 					->contain(['CustomerAddresses']));
		// 					$this->set(compact('orders','cur_date','cur_type'));
		// }else{
							
							// $orders =$this->paginate($this->Orders->find()
							// ->where($where)
							// ->order(['Orders.id'=>'DESC'])
							// ->contain(['CustomerAddresses','Customers']));
		//}
       
		//pr($orders->toArray()); exit;
		$Customers = $this->Orders->Customers->find();
		$Customer_data=[];
		foreach($Customers as $Customer){
			$Customer_data[$Customer->id]= $Customer->name.'('.$Customer->mobile.')';
		}
		$order_type=[];
		$order_type=[['text'=>'Bulkorder','value'=>'Bulkorder'],['text'=>'Cod','value'=>'Cod'],['text'=>'Offline','value'=>'Offline'],['text'=>'Online','value'=>'Online'],['text'=>'Wallet','value'=>'Wallet']];
		
		$OrderStatus=[];
		$OrderStatus=[['text'=>'Delivered','value'=>'Delivered'],['text'=>'Packed','value'=>'Packed'],['text'=>'Dispatch','value'=>'Dispatch'],['text'=>'In Process','value'=>'In Process'],['text'=>'Cancel','value'=>'Cancel']];
        $this->set(compact('orders','Customer_data','order_type','OrderStatus','order_no','customer_id','order_types','orderstatus','from_date','to_date','status'));
        $this->set('_serialize', ['orders']);
    }

     public function orderList($status=null,$type=null)
    {
    	$order=$this->Orders->newEntity();
		$this->viewBuilder()->layout('index_layout');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$curent_date=date('Y-m-d');
		$status = $this->request->query('status');
		//pr($status);exit;
		$type = $this->request->query('type');
		$order_no = $this->request->query('order_no');
		$customer_id = $this->request->query('customer');
		$order_types = $this->request->query('order_type');
		$orderstatus = $this->request->query('orderstatus');
		$from_date = $this->request->query('From');
		$to_date = $this->request->query('To');
		$where =[];
		
		if(!empty($order_no)){
			$where['Orders.order_no Like']='%'.$order_no.'%';
		}
		if(!empty($customer_id)){
			$where['Orders.customer_id']=$customer_id;
			
		}
		if(!empty($order_types)){
			$where['Orders.order_type']=$order_types;
		}
		if(!empty($orderstatus)){
			$where['Orders.status']=$orderstatus;
		}
		if(!empty($from_date)){ 
			$where['Orders.curent_date >=']=date('Y-m-d',strtotime($from_date));
		}
		if(!empty($to_date)){
			$where['Orders.curent_date <=']=date('Y-m-d',strtotime($to_date));
		}
		//pr($where); exit;
		//pr($where);exit;
		 $this->paginate = [
            'contain' => ['Customers']
        ];
		
		if($status == 'process'){ 
							
							$where['Orders.status']='In Process';
							$cur_date = date('d-m-Y');
							$orders =$this->paginate($this->Orders->find('all')
							->where($where)
							->order(['Orders.id'=>'DESC'])
							->where(['jain_thela_admin_id'=>$jain_thela_admin_id])
							->contain(['CustomerAddresses']));
							$cur_status = 'In Process';
							 $this->set(compact('orders','cur_status','cur_date','status'));
		}else if($status =='packed'){
							$where['Orders.status']='Packed';
							$cur_date = date('d-m-Y');
							$orders =$this->paginate($this->Orders->find('all')
							->where($where)
							->order(['Orders.id'=>'DESC'])
							->where(['jain_thela_admin_id'=>$jain_thela_admin_id])
							->contain(['CustomerAddresses']));
							$cur_status = 'Packed';
							
							 $this->set(compact('orders','cur_status','cur_date','status'));
		}else
			 if($status == 'cancel'){
							$where['Orders.status']='Cancel';
							$cur_date = date('d-m-Y');
							$orders =$this->paginate($this->Orders->find('all')
							->where($where)
							->order(['Orders.id'=>'DESC'])
							->where(['jain_thela_admin_id'=>$jain_thela_admin_id,'Orders.curent_date'=>$cur_date])
							->contain(['CustomerAddresses']));
							$cur_status = 'Cancel';
			
							$this->set(compact('orders','cur_status','cur_date','status'));
		}else if($status == 'delivered'){ 
							$where['Orders.status']='Delivered';
							$cur_date = date('d-m-Y');
							$orders =$this->paginate($this->Orders->find('all')
							->where($where)
							->order(['Orders.id'=>'DESC'])
							->where(['jain_thela_admin_id'=>$jain_thela_admin_id])
							->contain(['CustomerAddresses']));
							$cur_status = 'Delivered';
							
							 $this->set(compact('orders','cur_date','cur_status'));
		}else if($status == 'dispatch'){
							$cur_date = date('d-m-Y');
							$where['Orders.status']='Dispatch';
							$orders =$this->paginate($this->Orders->find('all')
							->where($where)
							->order(['Orders.id'=>'DESC'])
							->where(['jain_thela_admin_id'=>$jain_thela_admin_id])
							->contain(['CustomerAddresses']));
							$cur_status = 'Dispatch';
							$this->set(compact('orders','cur_date','cur_status'));
		}else{
							
							$orders =$this->paginate($this->Orders->find()
							->where($where)
							->order(['Orders.id'=>'DESC'])
							->where(['jain_thela_admin_id'=>$jain_thela_admin_id])
							->contain(['CustomerAddresses']));
		}
       
		//pr($orders->toArray()); exit;
		$Customers = $this->Orders->Customers->find();
		$Customer_data=[];
		foreach($Customers as $Customer){
			$Customer_data[$Customer->id]= $Customer->name.'('.$Customer->mobile.')';
		}
		$order_type=[];
		$order_type=[['text'=>'Bulkorder','value'=>'Bulkorder'],['text'=>'Cod','value'=>'Cod'],['text'=>'Offline','value'=>'Offline'],['text'=>'Online','value'=>'Online'],['text'=>'Wallet','value'=>'Wallet']];
		
		$OrderStatus=[];
		$OrderStatus=[['text'=>'Cancel','value'=>'Cancel'],['text'=>'Delivered','value'=>'Delivered'],['text'=>'In Process','value'=>'In Process']];

		

        $this->set(compact('orders','Customer_data','order_type','OrderStatus','order_no','customer_id','order_types','orderstatus','from_date','to_date','status','order'));
        $this->set('_serialize', ['orders']);
    }

	public function manageOrder()
    {
		$this->viewBuilder()->layout('index_layout');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$curent_date=date('Y-m-d');
		$orders = $this->Orders->find('all')->order(['Orders.id'=>'DESC'])->where(['jain_thela_admin_id'=>$jain_thela_admin_id, 'curent_date'=>$curent_date, 'Orders.status'=>'In process'])->contain(['Customers']);
		
        $this->set(compact('orders'));
        $this->set('_serialize', ['orders']);
    }
	
    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
      public function view($id = null, $print= null)
    {
		$this->viewBuilder()->layout('index_layout');
        $order = $this->Orders->get($id, [
            'contain' => ['Customers', 'CustomerAddresses', 'PromoCodes', 'OrderDetails'=>['Items'=>['GstFigures'],'ItemVariations'=>['Units']]]
        ]);
       // pr($order);exit;
	
        $this->set(compact('order', 'id', 'print'));
        $this->set('_serialize', ['order']);
    }
	
	  public function report($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $order = $this->Orders->get($id, [
            'contain' => ['Customers', 'PromoCodes', 'OrderDetails'=>['Items'=>['Units']], 'CustomerAddresses']
        ]);
		
        $this->set('order', $order);
        $this->set('_serialize', ['order']);
    }
	
	public function cancelBox($id = null)
    {
		$this->viewBuilder()->layout('');
        $order = $this->Orders->get($id);
		$order_date=$order->order_date;
		$delivery_date=$order->delivery_date;
		$delivery_charge=$order->delivery_charge;
		$total_amount=$order->total_amount;
		$curent_date=$order->curent_date;
		$amount_from_wallet=$order->amount_from_wallet;
		$online_amount=$order->online_amount;
		$amount_from_jain_cash=$order->amount_from_jain_cash;
		$amount_from_promo_code=$order->amount_from_promo_code;
		$paid_amount=$amount_from_wallet+$online_amount+$amount_from_jain_cash+$amount_from_promo_code;
		$online_amount=$order->online_amount;
		$customer_id=$order->customer_id;
		$CancelReasons=$this->Orders->CancelReasons->find('list');
		if ($this->request->is(['patch', 'post', 'put'])) {
			$cancel_id=$this->request->data['cancel_id'];
			$Orders=$this->Orders->get($id);
			$Orders->order_date=$order_date;
			$Orders->delivery_date=$delivery_date;
			$Orders->curent_date=$curent_date;
			$Orders->status='Cancel';
			$Orders->cancel_id=$cancel_id;
			$this->Orders->save($Orders);
			$grand_total=$total_amount+$delivery_charge;
			$remaining_amount=$grand_total-$paid_amount;
			$remaining_paid_amount=$paid_amount-$grand_total;
			
			$this->Orders->Wallets->deleteAll(['return_order_id'=>$Orders->id]);
			
			if($remaining_amount>=0){
				$return_amount=$paid_amount;
			}
			else if($remaining_paid_amount>0){
				$return_amount=$paid_amount;
			}
			if($return_amount>0){
			$query = $this->Orders->Wallets->query();
					$query->insert(['customer_id', 'advance', 'narration', 'return_order_id'])
							->values([
							'customer_id' => $customer_id,
							'advance' => $return_amount,
							'narration' => 'Amount Return form Order',
							'return_order_id' => $id
							])
					->execute();
			}
			return $this->redirect(['action' => 'index']);
		}
        $this->set('order', $order);
        $this->set('CancelReasons', $CancelReasons);
        $this->set('_serialize', ['order', 'CancelReasons']);
    }

	public function ajaxDeliver($id = null)
    {
		$this->viewBuilder()->layout('');
         $Orders = $this->Orders->get($id, [
            'contain' => ['Customers', 'OrderDetails'=>['Items'=>['Units']]]
        ]);
        $this->set('Orders', $Orders);
        $this->set('_serialize', ['Orders']);
    }
	
	public function updateOrders($order_id = null,$item_id = null,$actual_quantity=null,$amount = null){
		
		$quantity=explode(',',$actual_quantity);
		$items=explode(',',$item_id);
		$item_amount=explode(',',$amount);
		$x=0;
		$final_amount=0;
		foreach($items as $item){ 
			$qty = $quantity[$x];
			$amt = $item_amount[$x];
			$final_amount+=$amt;
				$query = $this->Orders->OrderDetails->query();
					$query->update()
							->set(['actual_quantity' => $qty, 'amount' => $amt])
							->where(['item_id'=>$item,'order_id'=>$order_id])
							->execute();
				$x++;		
		}
		$Orders = $this->Orders->get($order_id);
		$customer_id=$Orders->customer_id;
		$amount_from_wallet=$Orders->amount_from_wallet;
		$amount_from_jain_cash=$Orders->amount_from_jain_cash;
		$amount_from_promo_code=$Orders->amount_from_promo_code;
		$online_amount=$Orders->online_amount;
		
		$paid_amount=$amount_from_wallet+$amount_from_jain_cash+$amount_from_promo_code+$online_amount;
		
		$total_amount=$final_amount;
		$discount_percent=$Orders->discount_percent;
		$discount_amount=$total_amount*($discount_percent/100);
		
		if($total_amount<100){
			$delivery_charge=50;
		}else{
			$delivery_charge=0;
		}
		$pay_amount=$Orders->pay_amount;
		$final_amount;
			
			$grand_total=$total_amount+$delivery_charge-$discount_amount;
			$remaining_amount=$grand_total-$paid_amount;
			$remaining_paid_amount=$paid_amount-$grand_total;
 			$this->Orders->Wallets->deleteAll(['return_order_id'=>$order_id]);
			
			if($remaining_amount>=0){
				$return_amount=0;
				$real_pay_amount=$remaining_amount;
			}
			else if($remaining_paid_amount>0){
				$return_amount=$remaining_paid_amount;
				$real_pay_amount=0;
				
			if($return_amount>0){
			$query = $this->Orders->Wallets->query();
					$query->insert(['customer_id', 'advance', 'narration', 'return_order_id'])
							->values([
							'customer_id' => $customer_id,
							'advance' => $return_amount,
							'narration' => 'Amount Return form Order',
							'return_order_id' => $order_id
							])
					->execute();
			}
			}
				$query = $this->Orders->query();
					$query->update()
							->set(['total_amount' => $total_amount,'grand_total' => $grand_total,'delivery_charge' => $delivery_charge,'pay_amount' => $real_pay_amount])
							->where(['id' => $order_id])
							->execute();
		
		exit;
	}
	
	public function undoBox($id = null)
    {
		$Orders = $this->Orders->get($id);
		$order_date=$Orders->order_date;
		$Orders->status='In Process';
		$Orders->order_date=$order_date;
		$Orders->cancel_id=0;
		
		$delivery_date=$Orders->delivery_date;
		$delivery_charge=$Orders->delivery_charge;
		$total_amount=$Orders->total_amount;
		$curent_date=$Orders->curent_date;
		$amount_from_wallet=$Orders->amount_from_wallet;
		$online_amount=$Orders->online_amount;
		$amount_from_jain_cash=$Orders->amount_from_jain_cash;
		$amount_from_promo_code=$Orders->amount_from_promo_code;
		$paid_amount=$amount_from_wallet+$online_amount+$amount_from_jain_cash+$amount_from_promo_code;
		$online_amount=$Orders->online_amount;
		$customer_id=$Orders->customer_id;
		
			$grand_total=$total_amount+$delivery_charge;
			$remaining_amount=$grand_total-$paid_amount;
			$remaining_paid_amount=$paid_amount-$grand_total;
 			$this->Orders->Wallets->deleteAll(['return_order_id'=>$id]);
			
		 if ($this->Orders->save($Orders)) {
			 
			if($remaining_amount>=0){
				$return_amount=0;
			}
			else if($remaining_paid_amount>0){
				$return_amount=$remaining_paid_amount;
			if($return_amount>0){
			$query = $this->Orders->Wallets->query();
					$query->insert(['customer_id', 'advance', 'narration', 'return_order_id'])
							->values([
							'customer_id' => $customer_id,
							'advance' => $return_amount,
							'narration' => 'Amount Return form Order',
							'return_order_id' => $id
							])
					->execute();
			}
			}
			
			$this->Orders->ItemLedgers->deleteAll(['order_id'=>$Orders->id]);
			
            $this->Flash->success(__('The Order has been reopened.'));
        } else {
            $this->Flash->error(__('The Order could not be Reopened. Please, try again.'));
        }
		return $this->redirect(['action' => 'index']);
    }
	
	public function ajaxOrderView()
    {
		$order_id=$this->request->data['odr_id'];
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id'); 
		$order_details=$this->Orders->OrderDetails->find()->where(['order_id'=>$order_id])->contain(['Items'=>['Units']]);

		//pr($order_details->toArray());  
 		$this->set('order_details', $order_details);
 		$this->set('order_id', $order_id);
        $this->set('_serialize', ['order_details', 'order_id']);
		 
	}

	public function ajaxDeliverApi()
    {
		$order_id=$this->request->data['order_id'];
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$this->set(compact('jain_thela_admin_id', 'order_id'));
        $this->set('_serialize', ['jain_thela_admin_id', 'order_id']);
	}
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
	 
	public function bulkorderAdd($order_type = Null,$bulkorder_id = Null)
    {
		@$bulkorder_id;
		$this->viewBuilder()->layout('index_layout');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
        $order = $this->Orders->newEntity();
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
			$curent_date=date('Y-m-d');

			$last_order_no = $this->Orders->find()->select(['order_no', 'get_auto_no'])->order(['order_no'=>'DESC'])->where(['jain_thela_admin_id'=>$jain_thela_admin_id, 'curent_date'=>$curent_date])->first();

			if(!empty($last_order_no)){
			$get_auto_no = h(str_pad(number_format($last_order_no->get_auto_no+1),6, '0', STR_PAD_LEFT));
			$next_get_auto_no=$last_order_no->get_auto_no+1;
			}else{
		    $get_auto_no=h(str_pad(number_format(1),6, '0', STR_PAD_LEFT));
			echo $next_get_auto_no=1;
			}
			$get_date=str_replace('-','',$curent_date);
			$exact_order_no=h('W'.$get_date.$get_auto_no);//orderno///
			
			$order->order_no=$exact_order_no;
 			$order->curent_date=$curent_date;
			$order->get_auto_no=$next_get_auto_no;
			if($order_type == 'Bulkorder'){
				$order->order_type=$order_type;
			}else{
				$order->order_type='Cod';
			}
			$order->jain_thela_admin_id=$jain_thela_admin_id;
			$order->grand_total=$this->request->data['total_amount'];
			$order->delivery_date=date('Y-m-d', strtotime($this->request->data['delivery_date']));
			
            if ($orderDetails = $this->Orders->save($order)) {
				  $send_data = $orderDetails->id ;
				$order_detail_fetch=$this->Orders->get($send_data);
				$order_no=$order_detail_fetch->order_no;
				$delivery_date=date('Y-m-d', strtotime($order_detail_fetch->delivery_date));
				$customer_id=$order_detail_fetch->customer_id;
				$customer_details=$this->Orders->Customers->find()
                    ->where(['Customers.id' => $customer_id])->first();
                    $mobile=$customer_details->mobile;
                    $API_ACCESS_KEY=$customer_details->notification_key;
                    $device_token=$customer_details->device_token;
                    $device_token1=rtrim($device_token);
                    $time1=date('Y-m-d G:i:s');

					if(!empty($device_token1))
					{

					$msg = array
					(
					'message'     => 'Thank you, Your order has been successfully placed.',
					'image'     => '',
					'button_text'    => 'Track Your Order',
					'link' => 'jainthela://order?id='.$send_data,
					'notification_id'    => 1,
					);

					$url = 'https://fcm.googleapis.com/fcm/send';
					$fields = array
					(
						'registration_ids'     => array($device_token1),
						'data'            => $msg
					);
					$headers = array
					(
						'Authorization: key=' .$API_ACCESS_KEY,
						'Content-Type: application/json'
					);

					  //echo json_encode($fields);
					  $ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
					$result001 = curl_exec($ch);
					if ($result001 === FALSE) {
						die('FCM Send Error: ' . curl_error($ch));
					}
					curl_close($ch);
				}  
				
				$customer = $this->Orders->Customers->get($order->customer_id);
				$ledgerAccount = $this->Orders->LedgerAccounts->newEntity();
				$ledgerAccount->name = $customer->name.$customer->mobile;
				$ledgerAccount->customer_id = $order->customer_id;
				$ledgerAccount->account_group_id = '5';
				$ledgerAccount->jain_thela_admin_id = $jain_thela_admin_id;
				$this->Orders->LedgerAccounts->save($ledgerAccount);
					$ledgers = $this->Orders->Ledgers->newEntity();
					$ledgers->ledger_account_id	 = $ledgerAccount->id;
					$ledgers->debit = $order->grand_total;
					$ledgers->credit = '0';
					$this->Orders->Ledgers->save($ledgers);

					$ledgers = $this->Orders->Ledgers->newEntity();
					$ledgers->ledger_account_id	 = 9;
					$ledgers->debit = $order->amount_from_wallet;
					$ledgers->credit = '0';
					if($order->amount_from_wallet > 0){
					$this->Orders->Ledgers->save($ledgers);
					}
					
					$ledgers = $this->Orders->Ledgers->newEntity();
					$ledgers->ledger_account_id	 = 8;
					$ledgers->debit = '0';
					$ledgers->credit = ($order->grand_total+$order->amount_from_wallet);
					$this->Orders->Ledgers->save($ledgers);
				
				$this->Flash->success(__('The order has been saved.'));
				if($order_type == 'Bulkorder'){
					return $this->redirect(['action' => 'report/'.$send_data]);
				}else{
					return $this->redirect(['action' => 'index']);
				}
               
            }

            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $customer_fetchs = $this->Orders->Customers->find('all');
		foreach($customer_fetchs as $customer_fetch){
			$customer_name=$customer_fetch->name;
			$customer_mobile=$customer_fetch->mobile;
			$customers[]= ['value'=>$customer_fetch->id,'text'=>$customer_name." (".$customer_mobile.")"];
		}
		$deliverytime_fetchs = $this->Orders->DeliveryTimes->find('all');
		foreach($deliverytime_fetchs as $deliverytime_fetch){
			$time_id=$deliverytime_fetch->id;
			$time_from=$deliverytime_fetch->time_from;
			$time_to=$deliverytime_fetch->time_to;
			$delivery_time[]= ['value'=>$time_id,'text'=>$time_from." - ".$time_to];
		}
       // $promoCodes = $this->Orders->PromoCodes->find('list');
		$item_fetchs = $this->Orders->Items->find()->where(['Items.jain_thela_admin_id' => $jain_thela_admin_id, 'Items.freeze' => 0])->contain(['Units']);

		foreach($item_fetchs as $item_fetch){
			$item_name=$item_fetch->name;
			$alias_name=$item_fetch->alias_name;
			@$unit_name=$item_fetch->unit->unit_name;
			$print_quantity=$item_fetch->print_quantity;
			$rates=$item_fetch->offline_sales_rate;
			$minimum_quantity_factor=$item_fetch->minimum_quantity_factor;
			$minimum_quantity_purchase=$item_fetch->minimum_quantity_purchase;
			$items[]= ['value'=>$item_fetch->id,'text'=>$item_name." (".$alias_name.")", 'print_quantity'=>$print_quantity, 'rates'=>$rates, 'minimum_quantity_factor'=>$minimum_quantity_factor, 'unit_name'=>$unit_name, 'minimum_quantity_purchase'=>$minimum_quantity_purchase];
		}
		$this->loadModel('BulkBookingLeads');
        $bulk_Details = $this->BulkBookingLeads->find()->where(['id' => $bulkorder_id])->toArray();
		
		$warehouses = $this->Orders->Warehouses->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
       
        $this->set(compact('order', 'customers', 'items', 'order_type', 'bulk_Details', 'bulkorder_id','delivery_time','warehouses'));
        $this->set('_serialize', ['order']);
    }
	
    public function add($order_type = Null,$bulkorder_id = Null)
    {
		@$bulkorder_id;
		$this->viewBuilder()->layout('index_layout');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
        $order = $this->Orders->newEntity();  
        //pr($this->request->getData());exit;
        if ($this->request->is('post')) 
        {

        //     $order_details_quantity=$this->request->getData('order_details.1.show_quantity');
        //     //$qu=$order_details_quantity['show_quantity'];
        // pr($order_details_quantity);exit;
        	// $R=$this->request->getData();
        	// pr($R);exit;
        	//pr($this->request->getData());exit;
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            //pr($order->toArray());exit;
            $order['transaction_order_no']=0;
            $order['amount_from_jain_cash']=0;
            $order['online_amount']=$this->request->getData('grand_total');
            $order['amount_from_promo_code']=0;
            $order['delivery_charge_id']=1;
            $order['promo_code_id']=0;
            $order['discount_percent']=0;
            $order['actual_deliver_time']=$this->request->getData('delivery_time');
            $order_details_quantity=$this->request->getData('order_details');
            $order['actual_deliver_time']=$this->request->getData('delivery_time');
            $order['cancel_id']=0;
            $order['payment_status']="Sucess";
            $order['order_from']="walkinsales";
            $order['order_time']='LocalDateTime.now()';
            $order['order_time']='';
            $order['online_payment_status']='';
            //$orders=$this->request->getData('order_details');
           //  $a=array_values($orders);
           //  $orders['actual_quantity']=$a['0']['quantity'];
           //   pr($orders);exit;

          	// pr($orders);
           //  $i=0;
           //  foreach ($orders as $ordering) {
           //  	//$ordering['actual_quantity']=$ordering['quantity'];
           //  	//$order['order_details']=$ordering;
           //  	 $i++;
           //  }

           //  	 pr($ordering);exit;

           //pr($order);exit;
            // $order['order_details']['0']['actual_quantity']=$this->request->getData('grand_total');
            // pr($order);exit;
			$curent_date=date('Y-m-d');

			$last_order_no = $this->Orders->find()->select(['order_no', 'get_auto_no'])->order(['order_no'=>'DESC'])->where(['jain_thela_admin_id'=>$jain_thela_admin_id, 'curent_date'=>$curent_date])->first();

			if(!empty($last_order_no)){
			$get_auto_no = h(str_pad(number_format($last_order_no->get_auto_no+1),6, '0', STR_PAD_LEFT));
			$next_get_auto_no=$last_order_no->get_auto_no+1;
			}else{
		    $get_auto_no=h(str_pad(number_format(1),6, '0', STR_PAD_LEFT));
			echo $next_get_auto_no=1;
			}
			$get_date=str_replace('-','',$curent_date);
			$exact_order_no=h('W'.$get_date.$get_auto_no);//orderno///
			
			$order->order_no=$exact_order_no;
 			$order->curent_date=$curent_date;
			$order->get_auto_no=$next_get_auto_no;
			if($order_type == 'Bulkorder'){
				$order->order_type=$order_type;
			}
			$order->jain_thela_admin_id=$jain_thela_admin_id;
			//$order->grand_total=$this->request->data['total_amount'];
			$order->delivery_date=date('Y-m-d', strtotime($this->request->data['delivery_date']));
			$order->order_date=date('Y-m-d H:i:s');
			//pr($order);exit;
            if ($orderDetails = $this->Orders->save($order)) {
				if($order->amount_from_wallet>0){
				$query = $this->Orders->Wallets->query();
					$query->insert(['customer_id', 'consumed', 'order_id'])
							->values([
							'customer_id' => $order->customer_id,
							'consumed' => $order->amount_from_wallet,
							'order_id' => $orderDetails->id
							])
					->execute();
				}
				 
			  	$send_data = $orderDetails->id ;
				$order_detail_fetch=$this->Orders->get($send_data);
				$order_no=$order_detail_fetch->order_no;
				$delivery_date=date('Y-m-d', strtotime($order_detail_fetch->delivery_date));
			
				$customer_id=$order_detail_fetch->customer_id;
				$customer_details=$this->Orders->Customers->find()
                    ->where(['Customers.id' => $customer_id])->first();
                    $mobile=$customer_details->mobile;
                    $API_ACCESS_KEY=$customer_details->notification_key;
                    $device_token=$customer_details->device_token;
                    $device_token1=rtrim($device_token);
                    $time1=date('Y-m-d G:i:s');

					if(!empty($device_token1))
					{

					$msg = array
					(
					'message'     => 'Thank you, Your order has been successfully placed.',
					'image'     => '',
					'button_text'    => 'Track Your Order',
					'link' => 'jainthela://order?id='.$send_data,
					'notification_id'    => 1,
					);
					
					$url = 'https://fcm.googleapis.com/fcm/send';
					$fields = array
					(
						'registration_ids'     => array($device_token1),
						'data'            => $msg
					);
					$headers = array
					(
						'Authorization: key=' .$API_ACCESS_KEY,
						'Content-Type: application/json'
					);

					json_encode($fields);
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
					$result001 = curl_exec($ch);
					
					if ($result001 === FALSE) {
						die('FCM Send Error: ' . curl_error($ch));
					}
					curl_close($ch);
				}  
				 
				$customer = $this->Orders->Customers->get($order->customer_id);
				$ledgerAccount = $this->Orders->LedgerAccounts->newEntity();
				$ledgerAccount->name = $customer->name.$customer->mobile;
				$ledgerAccount->customer_id = $order->customer_id;
				$ledgerAccount->account_group_id = '5';
				$ledgerAccount->jain_thela_admin_id = $jain_thela_admin_id;
				$this->Orders->LedgerAccounts->save($ledgerAccount);
				
				
				
					$ledgers = $this->Orders->Ledgers->newEntity();
					$ledgers->ledger_account_id	 = $ledgerAccount->id;
					$ledgers->purchase_booking_id = 0;
					$ledgers->debit = $order->grand_total;
					$ledgers->credit = '0';
					$this->Orders->Ledgers->save($ledgers);

					$ledgers = $this->Orders->Ledgers->newEntity();
					$ledgers->ledger_account_id	 = 9;
					$ledgers->purchase_booking_id = 0;
					$ledgers->debit = $order->amount_from_wallet;
					$ledgers->credit = '0';
					if($order->amount_from_wallet > 0){
					$this->Orders->Ledgers->save($ledgers);
					}
					
					$ledgers = $this->Orders->Ledgers->newEntity();
					$ledgers->ledger_account_id	 = 8;
					$ledgers->purchase_booking_id = 0;
					$ledgers->debit = '0';
					$ledgers->credit = ($order->grand_total+$order->amount_from_wallet);
					$this->Orders->Ledgers->save($ledgers);
				
				$this->Flash->success(__('The order has been saved.'));
				if($order_type == 'Bulkorder'){
					//return $this->redirect(['action' => 'report/'.$send_data]);
					return $this->redirect(['action' => 'index']);
				}else{
					return $this->redirect(['action' => 'index']);
				}
               
            }

            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $customer_fetchs = $this->Orders->Customers->find('all');
		foreach($customer_fetchs as $customer_fetch){
			$customer_name=$customer_fetch->name;
			$customer_mobile=$customer_fetch->mobile;
			$customers[]= ['value'=>$customer_fetch->id,'text'=>$customer_name." (".$customer_mobile.")"];
		}
		$deliverytime_fetchs = $this->Orders->DeliveryTimes->find('all');

       // $promoCodes = $this->Orders->PromoCodes->find('list');
	   if($order_type == 'Bulkorder'){
		   $item_fetchs = $this->Orders->Items->find()->where(['Items.freeze'=>0,'is_combo'=>'no','is_virtual'=>'no'])->contain(['GstFigures']);
	   }else{
		$item_fetchs = $this->Orders->Items->find()->where(['Items.freeze'=>0, 'Items.ready_to_sale' => 'Yes'])->contain(['GstFigures']);
	   }
	  // pr($item_fetchs->toArray()); exit;
		foreach($item_fetchs as $item_fetch){
			$item_name=$item_fetch->name;
			$item_code=$item_fetch->item_code;
			@$unit_name=$item_fetch->unit->unit_name;
			$print_quantity=$item_fetch->print_quantity;
			$rates=$item_fetch->offline_sales_rate;
			$sales_rates=$item_fetch->sales_rate;
			$minimum_quantity_factor=$item_fetch->minimum_quantity_factor;
			$minimum_quantity_purchase=$item_fetch->minimum_quantity_purchase;
			$is_combo=$item_fetch->is_combo;
			
			$items[]= ['value'=>$item_fetch->id,'text'=>" (".$item_code.") ".$item_name, 'print_quantity'=>$print_quantity, 'rates'=>$rates,'sales_rate' =>$sales_rates,'minimum_quantity_factor'=>$minimum_quantity_factor, 'unit_name'=>$unit_name, 'minimum_quantity_purchase'=>$minimum_quantity_purchase,'is_combo' => $is_combo,'gst_figure_id'=>@$item_fetch->gst_figure_id,'gst_name'=>@$item_fetch->gst_figure->name,'tax_percentage'=>@$item_fetch->gst_figure->tax_percentage];
		}
		$this->loadModel('BulkBookingLeads');
		//pr($items); exit;
        $bulk_Details = $this->BulkBookingLeads->find()->where(['id' => $bulkorder_id])->toArray();
		$warehouses = $this->Orders->Warehouses->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
		$item = $this->Orders->items->find('list')->where(['Items.freeze'=>0]);
		$statesdata = $this->Orders->Customers->CustomerAddresses->States->find('list')->where(['country_id'=>'101'])->toArray();
		//pr($states);exit;
        $this->set(compact('order', 'customers', 'items', 'order_type', 'bulk_Details', 'bulkorder_id','deliverytime_fetchs','tax', 'warehouses','item','statesdata'));
        $this->set('_serialize', ['order', 'warehouses']);
    }
	/**
     * Ajax method
     **/
	public function ajaxCustomerDiscount()
    {
		$this->viewBuilder()->layout('ajax');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$customer = $this->Orders->Customers->get($this->request->data['customer_id']);
		$this->set(compact('customer'));
	}
    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    public function printList($id=null)
    {
    	$this->viewBuilder()->layout('index_layout');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$curent_date=date('Y-m-d');
		
        $order = $this->Orders->get($id, [
            'contain' => ['Customers'=>['CustomerAddresses']]
        ]);

        pr($order);exit;
        $this->set(compact('order'));

    }

    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
		
        $order = $this->Orders->get($id, [
            'contain' => ['Customers'=>['CustomerAddresses']]
        ]);
		//$curent_date=$order
        $data=$this->request->getData();
        //pr($data['order_details']);exit;

		 //pr($data);exit;
		//pr($order->customer->customer_addresses[0]['address']); exit;
		$amount_from_wallet=$order->amount_from_wallet;
		$amount_from_jain_cash=$order->amount_from_jain_cash;
		$amount_from_promo_code=$order->amount_from_promo_code; 
		$online_amount=$order->online_amount; 
		$customer_id=$order->customer_id;
		$order_date=$order->order_date;
		$discount_perc=$order->discount_percent;
		$paid_amount=$amount_from_wallet+$amount_from_jain_cash+$amount_from_promo_code+$online_amount;
        if ($this->request->is(['patch', 'post', 'put'])) {
             $order = $this->Orders->patchEntity($order, $data);
			$total_amount=$this->request->data['total_amount'];
			$delivery_charge=$this->request->data['delivery_charge'];
			$grand_total=$this->request->data['grand_total'];
			$remaining_amount=$grand_total-$paid_amount;
			$remaining_paid_amount=$paid_amount-$grand_total;
			$this->Orders->Wallets->deleteAll(['return_order_id'=>$id]);
			if($remaining_amount>=0){
				$order->pay_amount=$remaining_amount;
			}
			else if($remaining_paid_amount>0){
				$order->pay_amount=0;
				
				$query = $this->Orders->Wallets->query();
					$query->insert(['customer_id', 'advance', 'narration', 'return_order_id'])
							->values([
							'customer_id' => $customer_id,
							'advance' => $remaining_paid_amount,
							'narration' => 'Amount Return form Order',
							'return_order_id' => $id
							])
					->execute();
			}
			//$order->grand_total=$grand_total;
			$order->order_date=$order_date;
			$order->delivery_date=date('Y-m-d', strtotime($this->request->data['delivery_date']));
             if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
		
		if($order->order_type == 'Bulkorder'){
		   $item_fetchs = $this->Orders->Items->find()->where(['Items.freeze'=>0,'is_combo'=>'no','is_virtual'=>'no']);
	   }else{
		$item_fetchs = $this->Orders->Items->find()->where(['Items.freeze'=>0, 'Items.ready_to_sale' => 'Yes']);
	   }

		foreach($item_fetchs as $item_fetch){
			$item_name=$item_fetch->name;
			$alias_name=$item_fetch->alias_name;
			@$unit_name=$item_fetch->unit->unit_name;
			$print_quantity=$item_fetch->print_quantity;
			$rates=$item_fetch->offline_sales_rate;
			$sales_rates=$item_fetch->sales_rate;
			$minimum_quantity_factor=$item_fetch->minimum_quantity_factor;
			$minimum_quantity_purchase=$item_fetch->minimum_quantity_purchase;
			$is_combo=$item_fetch->is_combo;
			$items[]= ['value'=>$item_fetch->id,'text'=>$item_name." (".$alias_name.")", 'print_quantity'=>$print_quantity, 'rates'=>$rates,'sales_rate' =>$sales_rates,'minimum_quantity_factor'=>$minimum_quantity_factor, 'unit_name'=>$unit_name, 'minimum_quantity_purchase'=>$minimum_quantity_purchase,'is_combo' => $is_combo];
		}
        $customer_fetchs = $this->Orders->Customers->find('all');
		foreach($customer_fetchs as $customer_fetch){
			$customer_name=$customer_fetch->name;
			$customer_mobile=$customer_fetch->mobile;
			$customers[]= ['value'=>$customer_fetch->id,'text'=>$customer_name." (".$customer_mobile.")"];
		}
		$deliverytime_fetchs = $this->Orders->DeliveryTimes->find('all');
		foreach($deliverytime_fetchs as $deliverytime_fetch){
			$time_id=$deliverytime_fetch->id;
			$time_from=$deliverytime_fetch->time_from;
			$time_to=$deliverytime_fetch->time_to;
			$delivery_time[]= ['value'=>$time_id,'text'=>$time_from." - ".$time_to];
		}
        $promoCodes = $this->Orders->PromoCodes->find('list', ['limit' => 200]);
        $item=$this->Orders->Items->find('list');
        $OrderDetails = $this->Orders->OrderDetails->find()->where(['order_id'=>$id])->contain(['ItemVariations'=>['Units'],'Items']);
		$warehouses = $this->Orders->Warehouses->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
        $this->set(compact('order', 'customers', 'promoCodes', 'OrderDetails', 'items','item','delivery_time', 'warehouses'));
        $this->set('_serialize', ['order', 'warehouses']);

    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function onlineSaleDetails($item_id=null,$from_date=null,$to_date=null){
				$this->viewBuilder()->layout('index_layout');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
		$ItemLedgers=$this->Orders->ItemLedgers->find()
					->where(['item_id'=>$item_id,'order_id !='=>0,'transaction_date >='=>$from_date,'transaction_date <='=>$to_date])
					->contain(['Orders','Items'=>['Units']])
					->order(['Orders.id'=>'DESC']);
					
					//pr($ItemLedgers->toArray());exit;
		/* $SumQty=0;
		foreach($ItemLedgers as $ItemLedger){
			if($ItemLedger->order->order_type!='Bulkorder '){
				$SumQty+=$ItemLedger->quantity;
			}
		} 
		*/
		$this->set(compact('ItemLedgers','from_date','to_date'));
		
	}
	
	public function bulkSaleDetails($item_id=null,$from_date=null,$to_date=null){
		
		$this->viewBuilder()->layout('index_layout');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
		
		$ItemLedgers=$this->Orders->ItemLedgers->find()
					->where(['item_id'=>$item_id,'order_id !='=>0,'transaction_date >='=>$from_date,'transaction_date <='=>$to_date])
					->contain(['Orders','Items'=>['Units']])
					->order(['Orders.id'=>'DESC'])
					->where(['order_type IN'=>['Bulkorder']]);
		
			/* $bulkSales = $this->Orders->OrderDetails->find()->contain(['Orders'=>function ($q)use($where) {
				return $q->where(['order_type IN'=>['Bulkorder']])->where($where);
			},'Items'=>['Units']])->where(['OrderDetails.item_id'=>$item_id])->order(['Orders.id'=>'Desc']); */
		
		//pr($bulkSales->toArray());exit;
		$this->set(compact('ItemLedgers','from_date','to_date'));
        $this->set('_serialize', ['bulkSales']);
	}
	
	public function alertNotification($notification_id){
		
		$this->viewBuilder()->layout('ajax');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$this->loadModel('Notifications');
		$notification_details = $this->Notifications->get($notification_id, $jain_thela_admin_id);
		$orders_quantity = $this->Orders->find()->where(['jain_thela_admin_id' => $jain_thela_admin_id])->count();
		$notification_quantity = $notification_details->order_quantity;
		$difference_quantity=$orders_quantity-$notification_quantity;
		if($difference_quantity>0){
			echo $difference_quantity;
		}else{
			echo 0;

		}
		exit;
		$this->set(compact('orders_quantity', 'notification_quantity'));
		
	}
	public function updateNotification($notification_id){
		
		$this->viewBuilder()->layout('ajax');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$this->loadModel('Notifications');
		$notification_details = $this->Notifications->get($notification_id, $jain_thela_admin_id);
		$orders_quantity = $this->Orders->find()->where(['jain_thela_admin_id' => $jain_thela_admin_id])->count();
		$notification_quantity = $notification_details->order_quantity;
		$difference_quantity=$orders_quantity-$notification_quantity;
		if($difference_quantity>0){
			$query=$this->Notifications->query();
				$result = $query->update()
                    ->set(['order_quantity' => $orders_quantity])
                    ->where(['id' => $notification_id])
                    ->execute();
		}
		
		
	}
	
	public function newCustomer(){
	$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$this->viewBuilder()->layout('index_layout');
		$customers = $this->Orders->Customers->find()->contain(['Orders'])->where(['new_scheme' => 'Yes'])->order(['Customers.id'=>'DESC']);
		foreach($customers as $customer_detail)
			{
			$customer_id=$customer_detail->id;
			$order_count=$this->Orders->find()
					->where(['customer_id'=>$customer_id, 	
							'grand_total >='=>100,
							'status'=> 'Delivered'])
							->count();
			@$total_order[$customer_id]=$order_count;
			}

			
			$this->set(compact('customers','total_order'));
	}
	public function firstOrderDiscountStop(){
		
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$this->loadModel('Users');
		$user_deatils=$this->Users->get($jain_thela_admin_id);
		$first_order_discount_amount=$user_deatils->first_order_discount_amount;
		$customer_details=$this->Orders->Customers->find()
				->where(['first_time_win_status'=> 'No']);
		
			foreach($customer_details as $customer_detail)
			{
					$customer_id=$customer_detail->id;
					$mobile=$customer_detail->mobile;
					$API_ACCESS_KEY=$customer_detail->notification_key;
					$device_token=$customer_detail->device_token;
					$device_token1=rtrim($device_token);
					$time1=date('Y-m-d G:i:s');
				
				  $order_count=$this->Orders->find()
					->where(['customer_id'=>$customer_id, 
							'grand_total >='=>100,
							'status'=> 'Delivered'])
							->count();
							
					$order_details=$this->Orders->find()
					->where(['customer_id'=>$customer_id, 
							'grand_total >='=>100,
							'status'=> 'Delivered'])
							->select(['id'])
							->order(['id'=>'ASC'])
							->first();
					@$order_id=$order_details->id;
					
				if($order_count>0){
						$query=$this->Orders->Wallets->query();
						$query->insert(['customer_id', 'return_order_id', 'narration', 'plan_id', 'advance'])
						->values([
							'customer_id' => $customer_id,
							'return_order_id' => $order_id,
							'narration' => 'First Order Discount',
							'plan_id' => 19,
							'advance' => $first_order_discount_amount
						]);
						$query->execute();
						
						$query1=$this->Orders->Customers->query();
						$result = $query1->update()
						->set(['first_time_win_status' => 'Yes'])
						->where(['id' => $customer_id])
						->execute();
						
						$query2=$this->Orders->query();
						$result1 = $query2->update()
						->set(['first_order_discount_flag' => 'Yes'])
						->where(['id' => $order_id])
						->execute();
						 
					if(!empty($device_token1))
					{
					
						$msg = array
						(
						'message' 	=> 'Congratulations You Won Rs. 100 Cash Back for Your First Order',
						'image' 	=> '',
						'button_text'	=> 'Check Wallet',
						'link' => 'jainthela://home',	
						'notification_id'	=> 1,
						);

						$url = 'https://fcm.googleapis.com/fcm/send';
						$fields = array
						(
							'registration_ids' 	=> array($device_token1),
							'data'			=> $msg
						);
						$headers = array
						(
							'Authorization: key=' .$API_ACCESS_KEY,
							'Content-Type: application/json'
						);

						  //echo json_encode($fields);
						  $ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
						$result001 = curl_exec($ch);
						if ($result001 === FALSE) {
							die('FCM Send Error: ' . curl_error($ch));
						}
						curl_close($ch);
					}
					
					
				$sms=str_replace(' ', '+', 'Congratulations You Won Rs. 100 Cash Back for Your First Order');
				$working_key='A7a76ea72525fc05bbe9963267b48dd96';
				$sms_sender='JAINTE';
				$sms=str_replace(' ', '+', $sms);
				/* file_get_contents('http://alerts.sinfini.com/api/web2sms.php?workingkey='.$working_key.'&sender='.$sms_sender.'&to='.$mobile.'&message='.$sms.''); */
				
				file_get_contents('http://103.39.134.40/api/mt/SendSMS?user=phppoetsit&password=9829041695&senderid='.$sms_sender.'&channel=Trans&DCS=0&flashsms=0&number='.$mobile.'&text='.$sms.'&route=7');

	    /////SMS AND NOTIFICATIONS///////////////////
					 	
			}
		}
		
			echo "First Order Discount Amount has been Added in Customer Wallet";
			
			echo "&nbsp;&nbsp;<a href='http://app.jainthela.in/orders/dashboard' >Back</a>";
			exit;
	}
}
