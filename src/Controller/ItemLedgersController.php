<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemLedgers Controller
 *
 * @property \App\Model\Table\ItemLedgersTable $ItemLedgers
 *
 * @method \App\Model\Entity\ItemLedger[] paginate($object = null, array $settings = [])
 */
class ItemLedgersController extends AppController
{

	public $paginate = [
		'limit' => 100
	];
		
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function ajaxQuantity()
    {
    	$item_id=$this->request->getData('item_id');
    	$variation_id=$this->request->getData('variation_id');

    	$item_ledgers=$this->ItemLedgers->find()
    	->select(['total'=>'SUM(quantity)'])
    	->where(['item_id'=>$item_id,'item_variation_id'=>$variation_id,'status'=>'In']);

    	$item_ledgers_out=$this->ItemLedgers->find()
    	->select(['total_out'=>'SUM(quantity)'])
    	->where(['item_id'=>$item_id,'item_variation_id'=>$variation_id,'status'=>'out']);

    		foreach ($item_ledgers as $item_ledger) {
    			$total_in=$item_ledger->total;
    			foreach ($item_ledgers_out as $out) {
    				$total_out=$out->total_out;
    				echo $total_in - $total_out;
    			}
    		}
    	exit;
    }

	public function ajaxQuantityNew()
    {
    	$item_id=$this->request->getData('item_id');
    	$variation_id=$this->request->getData('variation_id');
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
		
		if($QuantityTotalStock){
			$rem=floor($QuantityTotalStock/$ItemVariations->unit_variation->quantity_factor);
			echo $rem;
			exit;
		}else{
			echo "0";
			exit;
		}
    }
	
	public function options(){
       // $item_id=$this->request->getData('input'); 
		//$item_id=$this->request->data['itm_val'];
		$item_id = $this->request->query('itm_val');
        $items=$this->ItemLedgers->ItemVariations->find()->where(['ItemVariations.item_id '=>$item_id])->contain(['Units','Items']);
           foreach($items as $show){ 
				$opt[]=['value'=>$show->id  ,'text'=>$show->quantity_variation." ".$show->unit->shortname];
			}
        $this->set(compact('opt'));
	}
    public function index()
    {
        $this->paginate = [
            'contain' => ['Items', 'Franchises', 'PurchaseInwardVouchers']
        ];
        $itemLedgers = $this->paginate($this->ItemLedgers);

        $this->set(compact('itemLedgers'));
        $this->set('_serialize', ['itemLedgers']);
    }

    /**
     * View method
     *
     * @param string|null $id Item Ledger id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemLedger = $this->ItemLedgers->get($id, [
            'contain' => ['Items', 'Franchises', 'PurchaseInwardVouchers']
        ]);

        $this->set('itemLedger', $itemLedger);
        $this->set('_serialize', ['itemLedger']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout'); 
        $itemLedger = $this->ItemLedgers->newEntity();
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');

        if ($this->request->is('post')) {
			$item_ledgers=$this->request->getData('item_ledgers');

			$driver_id=$this->request->data['driver_id'];
			$warehouse_id=$this->request->data['warehouse_id'];
			$transaction_date=date('Y-m-d', strtotime($this->request->data['transaction_date'])); 
			$i=0;

			foreach($item_ledgers as $item_ledger){
				$item_ledger=(object)$item_ledger;
				$quantity=$item_ledger->quantity;
				$item_id=$item_ledger->item_id;

				$query = $this->ItemLedgers->query();
				$query->insert(['driver_id', 'warehouse_id', 'transaction_date', 'item_id', 'quantity','status','jain_thela_admin_id', 'inventory_transfer'])
						->values([
						'driver_id' => 0,
						'warehouse_id' => $warehouse_id,
						'transaction_date' => $transaction_date,
						'item_id' => $item_id,
						'quantity' => $quantity,
						'status' => 'out',
						'jain_thela_admin_id' => $jain_thela_admin_id,
						'inventory_transfer' => 'yes'
						])
				->execute();

				$query = $this->ItemLedgers->query();
				$query->insert(['driver_id', 'warehouse_id', 'transaction_date', 'item_id', 'quantity','status', 'jain_thela_admin_id', 'inventory_transfer'])
						->values([
						'driver_id' => $driver_id,
						'warehouse_id' => 0,
						'transaction_date' => $transaction_date,
						'item_id' => $item_id,
						'quantity' => $quantity,
						'status' => 'In',
						'jain_thela_admin_id' => $jain_thela_admin_id,
						'inventory_transfer' => 'yes'
						])
				->execute();
			}
			$this->Flash->success(__('The item ledger has been saved.'));
			return $this->redirect(['action' => 'add']);
            $this->Flash->error(__('The item ledger could not be saved. Please, try again.'));
        }
		$item_fetchs = $this->ItemLedgers->Items->find()->where(['Items.is_combo'=>'no', 'Items.is_virtual'=>'no', 'Items.freeze'=>0]);
			foreach($item_fetchs as $item_fetch){
			$item_name=$item_fetch->name;
			$alias_name=$item_fetch->alias_name;
			$print_quantity=$item_fetch->print_quantity;
			$unit_name=$item_fetch->unit->unit_name;
			$minimum_quantity_factor=$item_fetch->minimum_quantity_factor;
			$items[]= ['value'=>$item_fetch->id,'text'=>$item_name." (".$alias_name.")", 'print_quantity'=>$print_quantity, 'minimum_quantity_factor'=>$minimum_quantity_factor, 'unit_name'=>$unit_name];
		}
		//pr($items[]);exit;
        $drivers = $this->ItemLedgers->Drivers->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);

		$warehouses = $this->ItemLedgers->Warehouses->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
		$item = $this->ItemLedgers->Items->find('list');
        $this->set(compact('itemLedger', 'items', 'drivers', 'warehouses','item'));
        $this->set('_serialize', ['itemLedger']);
    }

	public function amountReceivable($driver_id=null)
    {
		$driver_id=$driver_id;
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$stock_return_vouchers=$this->ItemLedgers->StockReturnVouchers->find()->where(['StockReturnVouchers.jain_thela_admin_id' => $jain_thela_admin_id,'StockReturnVouchers.driver_id'=> $driver_id])->order(['StockReturnVouchers.id' => 'DESC'])->first();
		
		$query = $this->ItemLedgers->find();
		$created_on_date=date('Y-m-d h:i:s', strtotime($stock_return_vouchers->created_on_date)); 
		$totalOutCaseAmount = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out','walkin_sales_id']),
				$query->newExpr()->add(['amount']),
				'integer'
			);
		$query->select([
			'total_receive_amount' => $query->func()->sum($totalOutCaseAmount)
		])
		->where(['ItemLedgers.driver_id' => $driver_id,'ItemLedgers.jain_thela_admin_id' => $jain_thela_admin_id,'ItemLedgers.created_on >'=>$stock_return_vouchers->created_on_date])
		->group('driver_id');
        $itemLedgers = ($query->first());
		if($itemLedgers->total_receive_amount){
		$receivable_amount=$itemLedgers->total_receive_amount;
		} else {
		$receivable_amount=0;	
		}
		$this->set(compact('stock_return_voucher','itemLedgers','receivable_amount'));
        $this->set('_serialize', ['itemLedgers','stock_return_voucher']);
	}
	
	public function stockReturn()
    {
		$this->viewBuilder()->layout('index_layout'); 
        $itemLedger = $this->ItemLedgers->newEntity();
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
        if ($this->request->is('post')) {
			$item_ledgers=$this->request->getData('item_ledgers');
			 
			$driver_id=$this->request->data['driver_id'];
			$warehouse_id=$this->request->data['warehouse_id'];	
			$amount_received=$this->request->data['amount_received'];	
			$amount_receivable=$this->request->data['amount_receivable'];
			$transaction_date=date('Y-m-d', strtotime($this->request->data['transaction_date'])); 
			$created_on_date=date('Y-m-d H:i:s'); 
			$i=0;
			$query1 = 	$this->ItemLedgers->StockReturnVouchers->query();
			$stock_return_voucher=	$query1->insert(['driver_id','created_on_date',	'amount_receivable', 'amount_received', 'jain_thela_admin_id'])
							->values([
							'driver_id' => $driver_id,
							'created_on_date' => $created_on_date,
							'amount_receivable' => $amount_receivable,
							'amount_received' => $amount_received,
							'jain_thela_admin_id' => $jain_thela_admin_id
							
						])
					->execute();
			$stock_return_voucher_id =  $stock_return_voucher->lastInsertId('StockReturnVouchers');
			
			foreach($item_ledgers as $item_ledger){
				$item_ledger=(object)$item_ledger;
				$item_ledger_quantity=$item_ledger->quantity;
				$total_quantity=$item_ledger->quantity+$item_ledger->waste;
				$item_id=$item_ledger->item_id;
				$waste=$item_ledger->waste;
				
				$query = $this->ItemLedgers->query();
				$query->insert(['driver_id', 'warehouse_id', 'transaction_date', 'item_id', 'quantity','status', 'jain_thela_admin_id', 'inventory_transfer'])
						->values([
						'driver_id' => 0,
						'warehouse_id' => $warehouse_id,
						'transaction_date' => $transaction_date,
						'item_id' => $item_id,
						'quantity' => $item_ledger_quantity,
						'status' => 'In',
						'jain_thela_admin_id' => $jain_thela_admin_id,
						'inventory_transfer' => 'yes'
						])
				->execute();	
				
				$query = $this->ItemLedgers->query();
				$query->insert(['driver_id', 'warehouse_id', 'transaction_date', 'item_id', 'quantity','status', 'jain_thela_admin_id', 'inventory_transfer','stock_return_voucher_id'])
						->values([
						'driver_id' => $driver_id,
						'warehouse_id' => 0,
						'transaction_date' => $transaction_date,
						'item_id' => $item_id,
						'quantity' => $total_quantity,
						'status' => 'out',
						'jain_thela_admin_id' => $jain_thela_admin_id,
						'inventory_transfer' => 'yes',
						'stock_return_voucher_id' => $stock_return_voucher_id
						])
				->execute();
				if($waste>0){
					$query = $this->ItemLedgers->query();
					$query->insert(['driver_id', 'warehouse_id', 'transaction_date', 'item_id', 'quantity','status', 'jain_thela_admin_id','different_driver_id', 'weight_variation', 'inventory_transfer'])
							->values([
							'driver_id' => 0,
							'warehouse_id' => 0,
							'transaction_date' => $transaction_date,
							'item_id' => $item_id,
							'quantity' => $waste,
							'status' => '',
							'jain_thela_admin_id' => $jain_thela_admin_id,
							'different_driver_id' => $driver_id,
							'weight_variation' => 1,
							'inventory_transfer' => 'yes'
							])
					->execute();
				}
				
			}
			
			$this->Flash->success(__('The item ledger has been saved.'));
			return $this->redirect(['action' => 'stock_return']);         
            $this->Flash->error(__('The item ledger could not be saved. Please, try again.'));
        }
        $items = $this->ItemLedgers->Items->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
        $drivers = $this->ItemLedgers->Drivers->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
		$warehouses = $this->ItemLedgers->Warehouses->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
        $this->set(compact('itemLedger', 'items', 'drivers', 'warehouses'));
        $this->set('_serialize', ['itemLedger']);
    }

	public function ajaxStockReturn()
    {
		  $driver_id=$this->request->data['driver'];
		  $jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		  
 			$query = $this->ItemLedgers->find();
		$totalInCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$query->select([
			'total_in' => $query->func()->sum($totalInCase),
			'total_out' => $query->func()->sum($totalOutCase),'id','item_id'
		])
		->where(['ItemLedgers.driver_id' => $driver_id,'ItemLedgers.jain_thela_admin_id' => $jain_thela_admin_id])
		->group('item_id')
		->autoFields(true)
		->contain(['Items'=>['Units']])
		->order(['Items.name' => 'ASC']);
        $itemLedgers = ($query);
		//
		$count=$itemLedgers->count();
        $this->set(compact('itemLedgers','count'));
     }

	public function DriverReport()
    {
		$this->viewBuilder()->layout('index_layout'); 
        $itemLedger = $this->ItemLedgers->newEntity();
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');

        $items = $this->ItemLedgers->Items->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
        $drivers = $this->ItemLedgers->Drivers->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
		$warehouses = $this->ItemLedgers->Warehouses->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
        $this->set(compact('itemLedger', 'items', 'drivers', 'warehouses'));
        $this->set('_serialize', ['itemLedger']);
    }

	public function ajaxDriverReport()
    {
		  $driver_id=$this->request->data['driver'];
		  $jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		  
 			$query = $this->ItemLedgers->find();
		$totalInCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$query->select([
			'total_in' => $query->func()->sum($totalInCase),
			'total_out' => $query->func()->sum($totalOutCase),'id','item_id'
		])
		->where(['ItemLedgers.driver_id' => $driver_id, 'ItemLedgers.jain_thela_admin_id' => $jain_thela_admin_id])
		->group('item_id')
		->autoFields(true)
		->contain(['Items'])
		->order(['Items.name' => 'ASC']);
        $itemLedgers = ($query);
		$count=$itemLedgers->count();

        $this->set(compact('itemLedgers','count'));
     }

	 public function productReport()
    {
		$this->viewBuilder()->layout('index_layout'); 
        $itemLedger = $this->ItemLedgers->newEntity();
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');

        $items = $this->ItemLedgers->Items->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
        $drivers = $this->ItemLedgers->Drivers->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
		$warehouses = $this->ItemLedgers->Warehouses->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
        $this->set(compact('itemLedger', 'items', 'drivers', 'warehouses'));
        $this->set('_serialize', ['itemLedger']);
    }

	 public function ajaxStockIssue()
    {
		  $warehouse_id=$this->request->data['warehouse_id'];
		  $jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		  
 			$query = $this->ItemLedgers->find();
		$totalInCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$query->select([
			'total_in' => $query->func()->sum($totalInCase),
			'total_out' => $query->func()->sum($totalOutCase),'id','item_id'
		])
		->where(['ItemLedgers.warehouse_id' => $warehouse_id, 'ItemLedgers.jain_thela_admin_id' => $jain_thela_admin_id])
		->group('item_id')
		->autoFields(true)
		->contain(['Items'])
		->order(['Items.name' => 'ASC']);
        $itemLedgers = ($query);
		$count=$itemLedgers->count();
        $this->set(compact('itemLedgers','count'));
     }


	public function ajaxStockAvailable()
    {
		$item_id=$this->request->data['itm_val'];
		$warehouse_id=$this->request->data['ware_house'];
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		 
 		$query = $this->ItemLedgers->find();
		$totalInCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$query->select([
			'total_in' => $query->func()->sum($totalInCase),
			'total_out' => $query->func()->sum($totalOutCase),'id','item_id'
		])
		->where(['ItemLedgers.warehouse_id' => $warehouse_id, 'ItemLedgers.item_id' => $item_id, 'ItemLedgers.raw_meterial' =>'Yes'])
		->group('item_id')
		->autoFields(true)
		->contain(['Items'])
		->order(['Items.name' => 'ASC']);
        $itemLedgers = ($query);
		  foreach($itemLedgers as $itemLedger){
			   $available_stock=$itemLedger->total_in;
			   $stock_issue=$itemLedger->total_out;
			 echo @$remaining=number_format($available_stock-$stock_issue, 2);
		  }
		  exit;
     }
	 
	 
	 
	public function ajaxWarehouseStockAvailable()
    {
		$item_id=$this->request->data['itm_val'];
		$warehouse_id=$this->request->data['ware_house'];
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		 
 			$query = $this->ItemLedgers->find();
		$totalInCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$query->select([
			'total_in' => $query->func()->sum($totalInCase),
			'total_out' => $query->func()->sum($totalOutCase),'id','item_id'
		])
		->where(['ItemLedgers.warehouse_id' => $warehouse_id, 'ItemLedgers.jain_thela_admin_id' => $jain_thela_admin_id, 'ItemLedgers.item_id' => $item_id])
		->group('item_id')
		->autoFields(true)
		->contain(['Items'])
		->order(['Items.name' => 'ASC']);
        $itemLedgers = ($query);
		  foreach($itemLedgers as $itemLedger){
			   $available_stock=$itemLedger->total_in;
			   $stock_issue=$itemLedger->total_out;
			 echo @$remaining=$available_stock-$stock_issue;
		  }
		  exit;
     }


	 public function itemIssueReport()
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$this->viewBuilder()->layout('index_layout'); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id'); 
		
		$from=$this->request->query('from');
		$to=$this->request->query('to');
		$item_id=$this->request->query('item_id');
		$driver_id=$this->request->query('driver_id');
		if(!empty($from)){
			$where['transaction_date >=']=date('Y-m-d',strtotime($from));
		}
		if(!empty($to)){
			$where['transaction_date <=']=date('Y-m-d',strtotime($to));
		}
		if(!empty($item_id)){
			$where['item_id']=$item_id;
		}
		if(!empty($driver_id)){
			$where['driver_id']=$driver_id;
		}
		$where['driver_id !=']=0;
		$where['order_id =']=0;
		$where['inventory_transfer']='yes';
		//pr($where); exit;
 				 
		$item_ledgers=$this->paginate(
			$this->ItemLedgers->find()
			->where($where)
			->order(['ItemLedgers.id'=> 'DESC'])
			->contain(['Drivers', 'Items'=>['Units','itemCategories']])
		);
		
		//pr($item_ledgers->toArray());
		$drivers=$this->ItemLedgers->Drivers->find('list');
		
		$item_fetchs = $this->ItemLedgers->Items->find()->where(['Items.jain_thela_admin_id' => $jain_thela_admin_id, 'Items.freeze !='=>1, 'Items.is_virtual'=>'no']);

		foreach($item_fetchs as $item_fetch){
			$item_name=$item_fetch->name;
			$alias_name=$item_fetch->alias_name;
			$items[]= ['value'=>$item_fetch->id,'text'=>$item_name." (".$alias_name.")"];
		}
		$this->set(compact('item_ledgers','from','to', 'drivers', 'items','driver_id','item_id','url'));
    }
	
	public function exportExcelItem(){
		$this->viewBuilder()->layout(''); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id'); 
		
		$from=$this->request->query('from');
		$to=$this->request->query('to');
		$item_id=$this->request->query('item_id');
		$driver_id=$this->request->query('driver_id');
		if(!empty($from)){
			$where['transaction_date >=']=date('Y-m-d',strtotime($from));
		}
		if(!empty($to)){
			$where['transaction_date <=']=date('Y-m-d',strtotime($to));
		}
		if(!empty($item_id)){
			$where['item_id']=$item_id;
		}
		if(!empty($driver_id)){
			$where['driver_id']=$driver_id;
		}
		$where['driver_id !=']=0;
		$where['order_id =']=0;
		$where['inventory_transfer']='yes';
		//pr($where); exit;
 				 
		$item_ledgers=
			$this->ItemLedgers->find()
			->where($where)
			->order(['transaction_date'=> 'DESC'])
			->contain(['Drivers', 'ItemVariations'=>['Units','itemCategories','Items']]
		);
		$drivers=$this->ItemLedgers->Drivers->find('list');
		
		$item_fetchs = $this->ItemLedgers->Items->find()->where(['Items.jain_thela_admin_id' => $jain_thela_admin_id, 'Items.freeze !='=>1]);

		foreach($item_fetchs as $item_fetch){
			$item_name=$item_fetch->name;
			$alias_name=$item_fetch->alias_name;
			$items[]= ['value'=>$item_fetch->id,'text'=>$item_name." (".$alias_name.")"];
		}
		$this->set(compact('item_ledgers','from','to', 'drivers', 'items','driver_id','item_id'));
	}

	public function exportNewReportStock()
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$this->viewBuilder()->layout('');

		$transaction_date=date('Y-m-d');
		
		//Opening Stock Start
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date','unit_variation_id'])
		->contain(['UnitVariations'])
		->order(['ItemLedgers.id'=>'DESC'])
		->where(['ItemLedgers.transaction_date < '=>$transaction_date])
		->orWhere(['ItemLedgers.opening_stock'=>'Yes','ItemLedgers.transaction_date'=>$transaction_date])
		->autoFields(true);
		$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.unit_variation_id','ItemLedgers.item_id','ItemLedgers.status',])
        ;
		
		$QuantityOpeningStock=[];
		foreach($ItemLedgersData as $data){
			if($data->status=="In"){ 
				@$QuantityOpeningStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}else{
				@$QuantityOpeningStock[$data->item_id]-=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}
		}
		
		/* pr(@$QuantityOpeningStock); exit; 
		$Orders = $this->ItemLedgers->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=>['UnitVariations']]])->where(['Orders.status IN'=>['Delivered'],'Orders.curent_date < '=>$transaction_date])->toArray();
		foreach($Orders as $Order){
			foreach($Order->order_details as $order_detail){
				@$QuantityOpeningStock[$order_detail->item_id]-=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
				
			}
		} 
		pr($QuantityOpeningStock);exit; */
		//pr(@$QuantityOpeningStock); exit;
		//Opening stock End
		
		
		//Purchase stock Start
		
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date','unit_variation_id'])
		->contain(['UnitVariations'])
		->where(['ItemLedgers.transaction_date'=>$transaction_date,'wastage >=' =>1])
		->orWhere(['ItemLedgers.transaction_date'=>$transaction_date,'usable_wastage >=' => 1])
		->orWhere(['ItemLedgers.transaction_date'=>$transaction_date])
		->autoFields(true); //pr($ItemLedgersData->toArray()); exit;
		//$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')]);
		
		
		$TodayPurchaseStock=[]; $TodayWastageStock=[]; $TodayReuseStock=[];
		foreach($ItemLedgersData as $data){
			if($data->purchase_booking_id > 0){ 
				@$TodayPurchaseStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->quantity;
			}
			if($data->wastage == 1){ 
				@$TodayWastageStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->quantity;
			}
			if($data->usable_wastage == 1){ 
				@$TodayReuseStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->quantity;
			}
		}
		
		//pr($TodayReuseStock); exit;
		//Purchase stock End
		
		
		
		//closing stock Start
		
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date','unit_variation_id'])
		->contain(['UnitVariations'])
		->where(['ItemLedgers.transaction_date <= '=>$transaction_date])->autoFields(true);
		$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.unit_variation_id','ItemLedgers.item_id','ItemLedgers.status',])
        ;
		
		$QuantityTotalStock=[];
		foreach($ItemLedgersData as $data){
			if($data->status=="In"){ 
				@$QuantityTotalStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}else{
				@$QuantityTotalStock[$data->item_id]-=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}
		}
		
		/*$Orders = $this->ItemLedgers->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=>['UnitVariations']]])->where(['Orders.status NOT IN'=>['Delivered','Cancel']])->toArray();
		
		 foreach($Orders as $Order){
			foreach($Order->order_details as $order_detail){
				@$QuantityTotalStock[$order_detail->item_id]-=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
			}
		} */
		//	pr($QuantityOpeningStock);exit; TodayReuseStock
		//closing stock End
		
		//Today Sale Start\
		
		$Orders = $this->ItemLedgers->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=>['UnitVariations']]])->where(['Orders.status NOT IN'=>['Cancel','Delivered'],'Orders.curent_date <= '=>$transaction_date])->toArray();
		
		$todaySales=[];
		foreach($Orders as $Order){
			foreach($Order->order_details as $order_detail){
				if($order_detail->status != 'Cancel' && $order_detail->status != 'Delivered'){ 
					@$todaySales[$order_detail->item_id]+=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
				}
			}
		}
		//pr($todaySales); exit;
		//Today Sale End
		
		//pr($QuantityOpeningStock);exit; 
		$Items = $this->ItemLedgers->Items->find()->contain(['ItemVariations'=>['UnitVariations']]);
       
		$this->set(compact('QuantityTotalStock','Items','QuantityOpeningStock','TodayPurchaseStock','TodayWastageStock','TodayReuseStock','todaySales'));
    }
	
	
	public function NewReportStock()
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$this->viewBuilder()->layout('index_layout');

		$transaction_date=date('Y-m-d');
		//$transaction_date="2019-08-22";
		
		//Opening Stock Start
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date','unit_variation_id'])
		->contain(['UnitVariations'])
		->order(['ItemLedgers.id'=>'DESC'])
		->where(['ItemLedgers.transaction_date <'=>$transaction_date,'order_id IS NULL'])
		->orWhere(['ItemLedgers.opening_stock'=>'Yes','ItemLedgers.transaction_date'=>$transaction_date])
		->autoFields(true);
		/* $ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.unit_variation_id','ItemLedgers.item_id','ItemLedgers.status'])
        ; */
		//pr(@$QuantityOpeningStock); exit;
		$QuantityOpeningStock=[];
		foreach($ItemLedgersData as $data){
			if($data->status=="In"){ 
				@$QuantityOpeningStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->quantity;
			}else{
				@$QuantityOpeningStock[$data->item_id]-=@$data->unit_variation->quantity_factor*$data->quantity;
			} 
		}
		
		$Orders = $this->ItemLedgers->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=>['UnitVariations']]])->where(['Orders.curent_date < '=>$transaction_date])->toArray();
		
		$todaySales=[];
		
		foreach($Orders as $Order){
			foreach($Order->order_details as $order_detail){
					@$QuantityOpeningStock[$order_detail->item_id]-=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
					
			}
		}
		//pr(@$QuantityOpeningStock);  TodayPurchaseStock
		$OrdersData = $this->ItemLedgers->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=>['UnitVariations']]])->where(['Orders.cancel_date <'=>$transaction_date,'Orders.status' => "Cancel"])->toArray();
		//pr(@$QuantityOpeningStock); 
		foreach($OrdersData as $Order){
			$cancel_date=date('Y-m-d',strtotime(@$Order->cancel_date)); 
			foreach($Order->order_details as $order_detail){
			if($Order->status=="Cancel" && $cancel_date < $transaction_date){ 
					@$QuantityOpeningStock[$order_detail->item_id]+=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
				}
			}
		}
		//pr(@$QuantityOpeningStock); exit; 
		//pr(@$QuantityOpeningStock); exit; 
		//pr(@$QuantityOpeningStock); exit; 
		/* 
		$Orders = $this->ItemLedgers->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=>['UnitVariations']]])->where(['Orders.status IN'=>['Delivered'],'Orders.curent_date < '=>$transaction_date])->toArray();
		foreach($Orders as $Order){
			foreach($Order->order_details as $order_detail){
				@$QuantityOpeningStock[$order_detail->item_id]-=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
				
			}
		} 
		pr($QuantityOpeningStock);exit; */
		//pr(@$QuantityOpeningStock); exit;
		//Opening stock End
		
		
		//Purchase stock Start
		
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date','unit_variation_id'])
		->contain(['UnitVariations'])
		->where(['ItemLedgers.transaction_date'=>$transaction_date])
		->autoFields(true); 
		//$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')]);
		
		//pr($TodayReuseStock); exit;
		$TodayPurchaseStock=[]; $TodayWastageStock=[]; $TodayReuseStock=[];
		foreach($ItemLedgersData as $data){
			if($data->purchase_booking_id > 0){ 
				@$TodayPurchaseStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->quantity;
			}
			if($data->wastage == 1){ 
				@$TodayWastageStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->quantity;
			}
			if($data->usable_wastage == 1){ 
				@$TodayReuseStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->quantity;
			}
		}
		
		//pr($TodayPurchaseStock); exit;
		//Purchase stock End
		
		
		
		//closing stock Start
		
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date','unit_variation_id'])
		->contain(['UnitVariations'])
		->where(['ItemLedgers.transaction_date <= '=>$transaction_date])->autoFields(true); 
		/* $ItemLedgersData->select(['unit_variation_id','item_id','status','total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.unit_variation_id','ItemLedgers.item_id','ItemLedgers.status'])
        ; */
		
		$QuantityTotalStock=[];
		foreach($ItemLedgersData as $data){
			if($data->status=="In"){ 
				@$QuantityTotalStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->quantity;
			}else{
				@$QuantityTotalStock[$data->item_id]-=@$data->unit_variation->quantity_factor*$data->quantity;
			}
		}
		
		/*$Orders = $this->ItemLedgers->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=>['UnitVariations']]])->where(['Orders.status NOT IN'=>['Delivered','Cancel']])->toArray();
		
		 foreach($Orders as $Order){
			foreach($Order->order_details as $order_detail){
				@$QuantityTotalStock[$order_detail->item_id]-=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
			}
		} */
		//	pr($QuantityOpeningStock);exit; TodayReuseStock
		//closing stock End
		
		//Today Sale Start\
		
		$Orders = $this->ItemLedgers->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=>['UnitVariations']]])->where(['Orders.curent_date'=>$transaction_date])->toArray();
		
		$todaySales=[];
		$todaySalesCancel=[];
		foreach($Orders as $Order){
			foreach($Order->order_details as $order_detail){
				
					@$todaySales[$order_detail->item_id]+=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
				
			}
		}
		$Orders = $this->ItemLedgers->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=>['UnitVariations']]])->where(['Orders.cancel_date'=>$transaction_date])->toArray();
		
	
		foreach($Orders as $Order){
			foreach($Order->order_details as $order_detail){
				
					@$todaySalesCancel[$order_detail->item_id]+=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
				
			}
		}
		//pr($todaySalesCancel);pr($todaySales);exit; 
		//Today Sale End
		
		//pr($QuantityOpeningStock);exit; 
		$Items = $this->ItemLedgers->Items->find()->contain(['ItemVariations'=>['UnitVariations']]);
       
		$this->set(compact('QuantityTotalStock','Items','QuantityOpeningStock','TodayPurchaseStock','TodayWastageStock','TodayReuseStock','todaySales','todaySalesCancel'));
    }	

    public function NewReport()
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$this->viewBuilder()->layout('index_layout');

		$transaction_date=date('Y-m-d');
		/*  */
		
		
		//closing stock Start
		
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date','unit_variation_id'])
		->contain(['UnitVariations'])
		->order(['ItemLedgers.id'=>'DESC'])
		->where(['ItemLedgers.transaction_date <='=>$transaction_date,'order_id IS NULL'])
		->orWhere(['ItemLedgers.opening_stock'=>'Yes','ItemLedgers.transaction_date'=>$transaction_date])
		->autoFields(true);
		
		$QuantityTotalStock=[];
		foreach($ItemLedgersData as $data){
			if($data->status=="In"){ 
				@$QuantityTotalStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->quantity;
			}else{
				@$QuantityTotalStock[$data->item_id]-=@$data->unit_variation->quantity_factor*$data->quantity;
			}
		}
		
		$Orders = $this->ItemLedgers->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=>['UnitVariations']]])->where(['Orders.curent_date <= '=>$transaction_date])->toArray();
		foreach($Orders as $Order){
			foreach($Order->order_details as $order_detail){
				if($Order->status != 'Cancel'){ 
				@$QuantityTotalStock[$order_detail->item_id]-=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
				}
				
			}
		} 
		
		
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date','unit_variation_id'])
		->contain(['UnitVariations'])
		->where(['ItemLedgers.transaction_date'=>$transaction_date])->autoFields(true);
		
		$TodayPurchaseStock=[]; $TodayWastageStock=[]; $TodayReuseStock=[];
		foreach($ItemLedgersData as $data){
			if($data->wastage == 1){ 
				@$QuantityTotalStock[$data->item_id]-=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}else if($data->usable_wastage == 1){ 
				@$QuantityTotalStock[$data->item_id]-=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}
		}
		
		//closing stock End
		
		
		$Items = $this->ItemLedgers->Items->find()->contain(['ItemVariations'=>['UnitVariations']]);
       
		$this->set(compact('QuantityTotalStock','Items','QuantityOpeningStock','TodayPurchaseStock','TodayWastageStock','TodayReuseStock'));
    }
	
	
	public function reportShow()
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$this->viewBuilder()->layout('index_layout');

		$transaction_date=date('Y-m-d');
		//$transaction_date='2019-07-17';
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date'])
		->where(['ItemLedgers.transaction_date < '=>$transaction_date])
		->orWhere(['ItemLedgers.transaction_date'=>$transaction_date,'ItemLedgers.rate_updated'=>'yess']);
        
        $ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.item_variation_id','ItemLedgers.status'])
        ;

        $itemVarOpeningQt=[];
        foreach($ItemLedgersData as $data){ 
        	if($data->status=="In"){
        		@$itemVarOpeningQt[$data->item_variation_id]+=$data->total_op_qt;
        	}else{
        		@$itemVarOpeningQt[$data->item_variation_id]-=$data->total_op_qt;
        	}
        	
        }
    //
        $ItemLedgersDataNew = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date','purchase_booking_id','wastage','order_id'])->where(['ItemLedgers.transaction_date'=>$transaction_date]);
        
        $ItemLedgersDataNew->select(['total_qt' => $ItemLedgersDataNew->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.item_variation_id','ItemLedgers.purchase_booking_id','ItemLedgers.wastage','ItemLedgers.order_id'])
        ;

        $itemPurchaseQt=[];
        $itemSaleQt=[];
        foreach($ItemLedgersDataNew as $data){ 
        	if($data->purchase_booking_id > 0 ){
        		@$itemPurchaseQt[$data->item_variation_id]+=$data->total_qt;
        	}else if($data->order_id > 0 ){
        		@$itemSaleQt[$data->item_variation_id]+=$data->total_qt;
        	}
        }
        
		$ItemVariations = $this->ItemLedgers->ItemVariations->find()->contain(['Items','Units']);

		//pr($itemLedgers->toArray());exit;
		$this->set(compact('itemLedgers','url','itemVarOpeningQt','ItemVariations','itemPurchaseQt','itemSaleQt'));
    }
	
		public function ThresHoldReport()
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$this->viewBuilder()->layout('index_layout');

		$transaction_date=date('Y-m-d');
		
		//Opening Stock Start
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date','unit_variation_id'])
		->contain(['UnitVariations'])
		->where(['ItemLedgers.transaction_date <'=>$transaction_date])->autoFields(true);
		$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.unit_variation_id','ItemLedgers.item_id','ItemLedgers.status',])
        ;
		
		$QuantityOpeningStock=[];
		foreach($ItemLedgersData as $data){
			if($data->status=="In"){ 
				@$QuantityOpeningStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}else{
				@$QuantityOpeningStock[$data->item_id]-=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}
		}
		/* $Orders = $this->ItemLedgers->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=>['UnitVariations']]])->where(['Orders.status NOT IN'=>['Delivered','Cancel']])->toArray();
		foreach($Orders as $Order){
			foreach($Order->order_details as $order_detail){
				@$QuantityOpeningStock[$order_detail->item_id]-=@$order_detail->unit_variation->quantity_factor*$order_detail->quantity;
			}
		} */
		//Opening stock End
		
		
		//Purchase stock Start
		
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date','unit_variation_id'])
		->contain(['UnitVariations'])
		->where(['ItemLedgers.transaction_date'=>$transaction_date])->autoFields(true);
		$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.unit_variation_id','ItemLedgers.item_id','ItemLedgers.status',])
        ;
		
		$TodayPurchaseStock=[]; $TodayWastageStock=[]; $TodayReuseStock=[];
		foreach($ItemLedgersData as $data){
			if($data->purchase_booking_id > 0){ 
				@$TodayPurchaseStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}else if($data->wastage == 1){ 
				@$TodayWastageStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}else if($data->usable_wastage == 1){ 
				@$TodayReuseStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}
		}
		
		//pr($TodayPurchaseStock); exit;
		//Purchase stock End
		
		
		
		//closing stock Start
		
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date','unit_variation_id'])
		->contain(['UnitVariations'])
		->where(['ItemLedgers.transaction_date <= '=>$transaction_date])->autoFields(true);
		$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.unit_variation_id','ItemLedgers.item_id','ItemLedgers.status',])
        ;
		
		$QuantityTotalStock=[];
		foreach($ItemLedgersData as $data){
			if($data->status=="In"){ 
				@$QuantityTotalStock[$data->item_id]+=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}else{
				@$QuantityTotalStock[$data->item_id]-=@$data->unit_variation->quantity_factor*$data->total_op_qt;
			}
		}
		
		$Orders = $this->ItemLedgers->Orders->find()->contain(['OrderDetails'=>['ItemVariations'=>['UnitVariations']]])->where(['Orders.status NOT IN'=>['Delivered','Cancel']])->toArray();
		
		foreach($Orders as $Order){
			foreach($Order->order_details as $order_detail){
				@$QuantityTotalStock[$order_detail->item_id]-=@$order_detail->item_variation->unit_variation->quantity_factor*$order_detail->quantity;
			}
		}
		//	pr($QuantityTotalStock);exit;
		//closing stock End
		
		
		$Items = $this->ItemLedgers->Items->find()->contain(['ItemCategories','ItemVariations'=>['UnitVariations']]);
       
		$this->set(compact('QuantityTotalStock','Items','QuantityOpeningStock','TodayPurchaseStock','TodayWastageStock','TodayReuseStock'));
    }
	
	public function stockReport()
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$this->viewBuilder()->layout('index_layout');
		
		//Closing
		$transaction_date=date('Y-m-d');
		//$transaction_date='2019-07-17';
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date'])
		->where(['ItemLedgers.transaction_date < '=>$transaction_date,'ItemLedgers.raw_meterial'=>'Yes']);
		$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.item_id','ItemLedgers.status'])
        ;

        $openingQty=[];
        foreach($ItemLedgersData as $data){ 
        	if($data->status=="In"){
        		@$openingQty[$data->item_id]+=$data->total_op_qt;
        	}else{
        		@$openingQty[$data->item_id]-=$data->total_op_qt;
        	}
        }
		//pr($openingQty); exit;

		//Transaction
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date'])
		->where(['ItemLedgers.transaction_date'=>$transaction_date,'ItemLedgers.raw_meterial'=>'Yes']);
		$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.item_id','ItemLedgers.status'])
        ;
		$TransferIn=[]; $TransferOut=[];
        foreach($ItemLedgersData as $data){ 
        	if($data->status=="In"){
        		@$TransferIn[$data->item_id]+=$data->total_op_qt;
        	}else{
        		@$TransferOut[$data->item_id]+=$data->total_op_qt;
        	}
        }
		
		//Closing
		$transaction_date=date('Y-m-d');
		//$transaction_date='2019-07-17';
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date'])
		->where(['ItemLedgers.transaction_date < '=>$transaction_date])
		->orWhere(['ItemLedgers.transaction_date'=>$transaction_date,'ItemLedgers.raw_meterial'=>'Yes']);
		$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.item_id','ItemLedgers.status'])
        ;

        $closingQty=[];
        foreach($ItemLedgersData as $data){ 
        	if($data->status=="In"){
        		@$closingQty[$data->item_id]+=$data->total_op_qt;
        	}else{
        		@$closingQty[$data->item_id]-=$data->total_op_qt;
        	}
        }
		//pr($closingQty); exit;
		$ItemData = $this->ItemLedgers->Items->find();
		
		$this->set(compact('openingQty','TransferIn','TransferOut','closingQty','ItemData'));
    }
	public function stockReportVarWise()
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$this->viewBuilder()->layout('index_layout');

		//Closing
		$transaction_date=date('Y-m-d');
		//$transaction_date='2019-07-17';
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date'])
		->where(['ItemLedgers.transaction_date < '=>$transaction_date,'ItemLedgers.raw_meterial'=>'No']);
		$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.item_variation_id','ItemLedgers.status'])
        ;

        $openingQty=[];
        foreach($ItemLedgersData as $data){ 
        	if($data->status=="In"){
        		@$openingQty[$data->item_variation_id]+=$data->total_op_qt;
        	}else{
        		@$openingQty[$data->item_variation_id]-=$data->total_op_qt;
        	}
        }
		

		//Transaction
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date'])
		->where(['ItemLedgers.transaction_date'=>$transaction_date,'ItemLedgers.raw_meterial'=>'No']);
		$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.item_variation_id','ItemLedgers.status'])
        ;
		$TransferIn=[]; $TransferOut=[];
        foreach($ItemLedgersData as $data){ 
        	if($data->status=="In"){
        		@$TransferIn[$data->item_variation_id]+=$data->total_op_qt;
        	}else{
        		@$TransferOut[$data->item_variation_id]+=$data->total_op_qt;
        	}
        }
		//pr($TransferIn); pr($TransferOut);  exit;
		//Closing
		$transaction_date=date('Y-m-d');
		//$transaction_date='2019-07-17';
		$ItemLedgersData = $this->ItemLedgers->find()->select(['item_id','item_variation_id','status','quantity','transaction_date'])
		->where(['ItemLedgers.transaction_date < '=>$transaction_date])
		->orWhere(['ItemLedgers.transaction_date'=>$transaction_date,'ItemLedgers.raw_meterial'=>'No']);
		$ItemLedgersData->select(['total_op_qt' => $ItemLedgersData->func()->sum('ItemLedgers.quantity')])
       ->group(['ItemLedgers.item_variation_id','ItemLedgers.status'])
        ;
//pr($ItemLedgersData->toArray()); exit;
        $closingQty=[];
        foreach($ItemLedgersData as $data){ 
        	if($data->status=="In"){
        		@$closingQty[$data->item_variation_id]+=$data->total_op_qt;
        	}else{
        		@$closingQty[$data->item_variation_id]-=$data->total_op_qt;
        	}
        }
		
		$ItemData = $this->ItemLedgers->Items->ItemVariations->find()->contain(['Items','Units']);
		//
		$this->set(compact('openingQty','TransferIn','TransferOut','closingQty','ItemData'));
    }

	public function exportExcelStk(){
		$this->viewBuilder()->layout(''); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id'); 
		
		$query = $this->ItemLedgers->find();

		$totalInWarehouseCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In', 'warehouse_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutWarehouseCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out', 'warehouse_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalInDriverCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In', 'driver_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutDriverCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out', 'driver_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$query->select([
			'totalInWarehouse' => $query->func()->sum($totalInWarehouseCase),
			'totalOutWarehouse' => $query->func()->sum($totalOutWarehouseCase),
			'totalInDriver' => $query->func()->sum($totalInDriverCase),
			'totalOutDriver' => $query->func()->sum($totalOutDriverCase),'id','item_id'
		])
		->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id])
		->group('ItemLedgers.item_id')
		->autoFields(true)
		->contain(['ItemVariations'=>['Units'],'Items'=>['itemCategories']])->order(['Items.name' => 'ASC']);

		$itemLedgers=$query;
		//pr($itemLedgers->toArray());exit;

		$this->set(compact('itemLedgers','url'));
	}


	public function itemWise($id=null)
	{
		$this->viewBuilder()->layout('index_layout');
        $order = $this->ItemLedgers->get($id, [
            'contain' => ['Customers', 'PromoCodes', 'OrderDetails'=>['Items'=>['Units']], 'CustomerAddresses']
        ]);

        $item_wise=$this->ItemLedgers->find()
        ->where(['item_id'=>$id])
        ->contain(['ItemVariations','Units','Items']);
		
        $this->set('item_wise', $item_wise);
        $this->set('_serialize', ['item_wise']);
	}
	
	public function itemStockUpdate()
    {
		$this->viewBuilder()->layout('index_layout'); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id'); 
 				$query = $this->ItemLedgers->find();
		$totalInCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$query->select([
			'total_in' => $query->func()->sum($totalInCase),
			'total_out' => $query->func()->sum($totalOutCase),'id','item_id'
		])
		->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id])
		->group('item_id')
		->autoFields(true)
		->contain(['Items'=>['Units','itemCategories']])->order(['Items.name' => 'ASC']);
        $itemLedgers = ($query);
		foreach($itemLedgers as $itemLedger){
			$item_id=$itemLedger->item_id;
			$total_in=$itemLedger->total_in;
			$total_out=$itemLedger->total_out;
			$remaining_stock=$total_in-$total_out;
			$item_data = $this->ItemLedgers->Items->find()->where(['id'=>$item_id]);
				foreach($item_data as $item_data_fetch){
					$minimum_stock=$item_data_fetch->minimum_stock;
					if($remaining_stock<$minimum_stock){
						$query=$this->ItemLedgers->Items->query();
						$result = $query->update()
							->set(['out_of_stock' => 1])
							->where(['id' => $item_id])
							->execute();
					}
				}
			}
         $this->set(compact('itemLedgers'));
    }

	
	
	public function itemSaleReports(){
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		$this->viewBuilder()->layout('index_layout'); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
		$from_date = $this->request->query('From');
		$to_date = $this->request->query('To');
		
		$where =[];
		if(!empty($from_date)){
			$from_date=date("Y-m-d",strtotime($this->request->query('From')));
			$where['ItemLedgers.transaction_date >=']=$from_date;
		}
		if(!empty($to_date)){
			$to_date=date("Y-m-d",strtotime($this->request->query('To')));
			$where['ItemLedgers.transaction_date <=']=$to_date;
		}
		
		$where1 =[];
		if(empty($from_date)){
			$from_date=date("Y-m-d");
			$where1['ItemLedgers.transaction_date >=']=$from_date;
		}
		if(empty($to_date)){
			$to_date=date("Y-m-d");
			$where1['ItemLedgers.transaction_date <=']=$to_date;
		}
		if(!empty($where)){
			$itemLedgers = $this->ItemLedgers->find()->contain(['ItemVariations'=>['Units'],'Items'=> function ($q) {
				return $q->where(['is_combo'=>'no','is_virtual'=>'no','freeze'=>0])->order(['Items.name'=>'ASC']);
			}])->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id])->where($where);
		}else{
			$itemLedgers = $this->ItemLedgers->find()->contain(['ItemVariations'=>['Units'],'Items'=> function ($q) {
				return $q->where(['is_combo'=>'no','is_virtual'=>'no','freeze'=>0])->order(['Items.name'=>'ASC']);
			}])->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id])->where($where1);
		}	
		$order_online = []; $order_online_name=[]; $order_bulk = []; $walkins_sales = []; $order_online_rate = [];
		$order_bulk_rate = []; $walkins_sales_rate = []; $Itemsexists=[]; $qty=0; $units=[];
		foreach($itemLedgers as $itemLedger){ 
			$Orders = $this->ItemLedgers->Orders->find()->where(['id'=>$itemLedger->order_id])->toArray();
			if(sizeof($Orders)>0){
				foreach($Orders as $order){
					if($order->order_type == 'Online' || $order->order_type == 'Wallet' || $order->order_type == 'Cod' || $order->order_type == 'cod'|| $order->order_type =='Offline'){
						@$order_online[$itemLedger->item_id] += $itemLedger->quantity; 
						@$order_online_rate[$itemLedger->item_id] += $itemLedger->amount; 
						@$Itemsexists[$itemLedger->item_id] = $itemLedger->item_id;
						@$units[$itemLedger->item_id] = $itemLedger->item->unit->unit_name;
						
						//pr($order_online);
					}
					if($order->order_type == 'Bulkorder'){
						@$order_bulk[$itemLedger->item_id] += $itemLedger->quantity;
						@$order_bulk_rate[$itemLedger->item_id] += $itemLedger->amount; 
						@$Itemsexists[$itemLedger->item_id] = $itemLedger->item_id;
						@$units[$itemLedger->item_id] = $itemLedger->item->unit->unit_name;
					}
				}
			}
		$WalkinSales = $this->ItemLedgers->WalkinSales->find()->where(['id'=>$itemLedger->walkin_sales_id]);	
		  foreach($WalkinSales as $WalkinSale){
				@$walkins_sales[$itemLedger->item_id] += $itemLedger->quantity; 
				@$walkins_sales_rate[$itemLedger->item_id] += @$itemLedger->amount; 
				@$Itemsexists[$itemLedger->item_id] = $itemLedger->item_id;
				@$units[$itemLedger->item_id] = $itemLedger->item->unit->unit_name;
		  }
		}
		//pr($Itemsexists);exit;
		
		$ItemList =  $this->ItemLedgers->Items->find()->order(['Items.name'=>'ASC']);

		//pr($ItemList->toArray());exit;
		
		$this->set(compact('itemLedgers','ItemList','from_date','to_date','order_online','order_bulk','order_offline'
		 ,'bulkitemrate','bulkitemqty','Offlineitemrate','Offlineitemqty','Onlineitemrate','Onlineitemqty','list_items','order_online_rate','order_bulk_rate','order_offline_rate','order_online_name','Itemsexists','walkins_sales','walkins_sales_rate','units','url'));
		 $this->set('_serialize', ['itemLedgers']);
	}
	
	public function excelAverageReport(){
	$this->viewBuilder()->layout(''); 
	$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
		$from_date = $this->request->query('From');
		$to_date = $this->request->query('To');
		
		$this->set(compact('from_date', 'to_date'));
		
		$where=[];
		if(!empty($from_date)){
			$where['ItemLedgers.transaction_date >=']=date('Y-m-d',strtotime($from_date));
			$org_from_date=date('Y-m-d',strtotime($from_date));
		}
		if(!empty($to_date)){
			$where['ItemLedgers.transaction_date <=']=date('Y-m-d',strtotime($to_date));
		}
		
		$query =$this->ItemLedgers->find();
		   
		$totalWasteCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['wastage' => '1','item_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalInQuantityPurchaseCase = $query->newExpr()
				->addCase(
					$query->newExpr()->add(['status' => 'In','purchase_booking_id']),
					$query->newExpr()->add(['quantity']),
					'integer'
				);
		$totalInAmountPurchaseCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In','purchase_booking_id']),
				$query->newExpr()->add(['amount']),
				'integer'
			);
		$totalSaleOrderQuantityCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'Out','order_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalSaleOrderAmountCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'Out','order_id']),
				$query->newExpr()->add(['amount']),
				'integer'
			);	
		$totalwalkinSaleQuantityCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'Out','walkin_sales_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalwalkinSaleAmountCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'Out','walkin_sales_id']),
				$query->newExpr()->add(['amount']),
				'integer'
			);	
		$totalweightVariatonQuantityCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['weight_variation' => '1']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$query->select([
			'totalwasteWarehouse' => $query->func()->sum($totalWasteCase),
			'totalPurchaseQuantity' => $query->func()->sum($totalInQuantityPurchaseCase),
			'totalPurchaseAmount' => $query->func()->sum($totalInAmountPurchaseCase),
			'totalOrderSale' => $query->func()->sum($totalSaleOrderQuantityCase),
			'totalOrderAmount' => $query->func()->sum($totalSaleOrderAmountCase),
			'totalWalkinSale' => $query->func()->sum($totalwalkinSaleQuantityCase),
			'totalWalkinAmount' => $query->func()->sum($totalwalkinSaleAmountCase),
			'totalWeightVariation' => $query->func()->sum($totalweightVariatonQuantityCase),'id','item_id'
		])
		->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id])
		->where($where)
		->group('item_id')
		->autoFields(true)
		->contain(['ItemVariations'=>['Items','Units']])->order(['Items.name' => 'ASC']);
        $details = ($query);
		//pr($details->toArray());
		///////////////////////////////////////////////////////////
		$query1 = $this->ItemLedgers->find();
					$totalInCase = $query1->newExpr()
					->addCase(
						$query1->newExpr()->add(['status' => 'In']),
						$query1->newExpr()->add(['quantity']),
						'integer'
					);
					$totalOutCase = $query1->newExpr()
					->addCase(
						$query1->newExpr()->add(['status' => 'out']),
						$query1->newExpr()->add(['quantity']),
						'integer'
					);
							
					$totalInCaseAmount = $query1->newExpr()
					->addCase(
						$query1->newExpr()->add(['status' => 'In','purchase_booking_id']),
						$query1->newExpr()->add(['amount']),
						'decimal'
					);
					
					$totalInCaseQuantity = $query1->newExpr()
					->addCase(
						$query1->newExpr()->add(['status' => 'In','purchase_booking_id']),
						$query1->newExpr()->add(['quantity']),
						'decimal'
					);
				
				$query1->select([
					'total_in_quantity' => $query1->func()->sum($totalInCase),
					'total_out_quantity' => $query1->func()->sum($totalOutCase),
					'total_in_purchase_amount' => $query1->func()->sum($totalInCaseAmount),
					'total_in_purchase_qty' => $query1->func()->sum($totalInCaseQuantity),
					'id','item_id'
				])
				->where(['ItemLedgers.jain_thela_admin_id' => $jain_thela_admin_id,'ItemLedgers.transaction_date <' => $org_from_date])
				->group('item_id')
				->autoFields(true);
				$itemLedgers_details = ($query1);
				//pr($itemLedgers_details->toArray());
				//exit;
				foreach($itemLedgers_details as $itemLedgers_detail){
					$item_id=$itemLedgers_detail->item_id;
					$total_in_quantity=$itemLedgers_detail->total_in_quantity;
					$total_out_quantity=$itemLedgers_detail->total_out_quantity;
					$total_in_purchase_amount=$itemLedgers_detail->total_in_purchase_amount;
					$total_in_purchase_qty=$itemLedgers_detail->total_in_purchase_qty;
					$old_purchase_average_rate=round($total_in_purchase_amount/$total_in_purchase_qty,2);
					$remaining_quantity=number_format($total_in_quantity-$total_out_quantity, 2);
					$opening_balance_quantity[$item_id]=$remaining_quantity;
					$actual_opening_amount=round($remaining_quantity*$old_purchase_average_rate, 2);
					$opening_balance_amount[$item_id]=$actual_opening_amount;
					
				}
				
				$query2 = $this->ItemLedgers->find();
				$totalInCase = $query2->newExpr()
					->addCase(
						$query2->newExpr()->add(['status' => 'In','purchase_booking_id']),
						$query2->newExpr()->add(['quantity']),
						'integer'
					);
				$totalAmountCase = $query2->newExpr()
					->addCase(
						$query2->newExpr()->add(['status' => 'In','purchase_booking_id']),
						$query2->newExpr()->add(['amount']),
						'integer'
					);
				$query2->select([
					'total_quantity' => $query2->func()->sum($totalInCase),
					'total_amount' => $query2->func()->sum($totalAmountCase),'id','item_id'
				])
				->where(['ItemLedgers.jain_thela_admin_id' => $jain_thela_admin_id])
				->group('item_id')
				->autoFields(true);
				$itemLedgers_purchase_details = ($query2);
			foreach($itemLedgers_purchase_details as $itemLedgers_purchase_detail){
			$item_id=$itemLedgers_purchase_detail->item_id;
			$total_quantity=$itemLedgers_purchase_detail->total_quantity;
			$total_amount=$itemLedgers_purchase_detail->total_amount;
			$average_amount_per=round($total_amount/$total_quantity);
			$item_average[$item_id]=$average_amount_per;
			}
				
		///////////////////////////////////////////////////////////
		$this->set(compact('details', 'url', 'opening_balance_quantity','opening_balance_amount','item_average'));
        $this->set('_serialize', ['details', 'opening_balance_quantity','opening_balance_amount']);
    }
	
	
	public function averageReport(){
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$this->viewBuilder()->layout('index_layout'); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
		$from_date = $this->request->query('From');
		$to_date = $this->request->query('To');
		
		$this->set(compact('from_date', 'to_date'));
		
		$where=[];
		if(!empty($from_date)){
			$where['ItemLedgers.transaction_date >=']=date('Y-m-d',strtotime($from_date));
			$org_from_date=date('Y-m-d',strtotime($from_date));
		}
		if(!empty($to_date)){
			$where['ItemLedgers.transaction_date <=']=date('Y-m-d',strtotime($to_date));
		}
		
		$query =$this->ItemLedgers->find();
		   
		$totalWasteCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['wastage' => '1','item_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalInQuantityPurchaseCase = $query->newExpr()
				->addCase(
					$query->newExpr()->add(['status' => 'In','purchase_booking_id']),
					$query->newExpr()->add(['quantity']),
					'integer'
				);
		$totalInAmountPurchaseCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In','purchase_booking_id']),
				$query->newExpr()->add(['amount']),
				'integer'
			);
		$totalSaleOrderQuantityCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'Out','order_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalSaleOrderAmountCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'Out','order_id']),
				$query->newExpr()->add(['amount']),
				'integer'
			);	
		$totalwalkinSaleQuantityCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'Out','walkin_sales_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalwalkinSaleAmountCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'Out','walkin_sales_id']),
				$query->newExpr()->add(['amount']),
				'integer'
			);	
		$totalweightVariatonQuantityCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['weight_variation' => '1']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$query->select([
			'totalwasteWarehouse' => $query->func()->sum($totalWasteCase),
			'totalPurchaseQuantity' => $query->func()->sum($totalInQuantityPurchaseCase),
			'totalPurchaseAmount' => $query->func()->sum($totalInAmountPurchaseCase),
			'totalOrderSale' => $query->func()->sum($totalSaleOrderQuantityCase),
			'totalOrderAmount' => $query->func()->sum($totalSaleOrderAmountCase),
			'totalWalkinSale' => $query->func()->sum($totalwalkinSaleQuantityCase),
			'totalWalkinAmount' => $query->func()->sum($totalwalkinSaleAmountCase),
			'totalWeightVariation' => $query->func()->sum($totalweightVariatonQuantityCase),'id','item_id'
		])
		->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id])
		->where($where)
		->group('item_id')
		->autoFields(true)
		->contain(['ItemVariations'=>['Items','Units']])->order(['Items.name' => 'ASC']);
        $details = ($query);
		//pr($details->toArray());
		///////////////////////////////////////////////////////////
		$query1 = $this->ItemLedgers->find();
					$totalInCase = $query1->newExpr()
					->addCase(
						$query1->newExpr()->add(['status' => 'In']),
						$query1->newExpr()->add(['quantity']),
						'integer'
					);
					$totalOutCase = $query1->newExpr()
					->addCase(
						$query1->newExpr()->add(['status' => 'out']),
						$query1->newExpr()->add(['quantity']),
						'integer'
					);
							
					$totalInCaseAmount = $query1->newExpr()
					->addCase(
						$query1->newExpr()->add(['status' => 'In','purchase_booking_id']),
						$query1->newExpr()->add(['amount']),
						'decimal'
					);
					
					$totalInCaseQuantity = $query1->newExpr()
					->addCase(
						$query1->newExpr()->add(['status' => 'In','purchase_booking_id']),
						$query1->newExpr()->add(['quantity']),
						'decimal'
					);
				
				$query1->select([
					'total_in_quantity' => $query1->func()->sum($totalInCase),
					'total_out_quantity' => $query1->func()->sum($totalOutCase),
					'total_in_purchase_amount' => $query1->func()->sum($totalInCaseAmount),
					'total_in_purchase_qty' => $query1->func()->sum($totalInCaseQuantity),
					'id','item_id'
				])
				->where(['ItemLedgers.jain_thela_admin_id' => $jain_thela_admin_id,'ItemLedgers.transaction_date <' => $org_from_date])
				->group('item_id')
				->autoFields(true);
				$itemLedgers_details = ($query1);
				//pr($itemLedgers_details->toArray());
				//exit;
				foreach($itemLedgers_details as $itemLedgers_detail){
					$item_id=$itemLedgers_detail->item_id;
					$total_in_quantity=$itemLedgers_detail->total_in_quantity;
					$total_out_quantity=$itemLedgers_detail->total_out_quantity;
					$total_in_purchase_amount=$itemLedgers_detail->total_in_purchase_amount;
					$total_in_purchase_qty=$itemLedgers_detail->total_in_purchase_qty;
					$old_purchase_average_rate=round($total_in_purchase_amount/$total_in_purchase_qty,2);
					$remaining_quantity=number_format($total_in_quantity-$total_out_quantity, 2);
					$opening_balance_quantity[$item_id]=$remaining_quantity;
					$actual_opening_amount=round($remaining_quantity*$old_purchase_average_rate, 2);
					$opening_balance_amount[$item_id]=$actual_opening_amount;
					
				}
				
				$query2 = $this->ItemLedgers->find();
				$totalInCase = $query2->newExpr()
					->addCase(
						$query2->newExpr()->add(['status' => 'In','purchase_booking_id']),
						$query2->newExpr()->add(['quantity']),
						'integer'
					);
				$totalAmountCase = $query2->newExpr()
					->addCase(
						$query2->newExpr()->add(['status' => 'In','purchase_booking_id']),
						$query2->newExpr()->add(['amount']),
						'integer'
					);
				$query2->select([
					'total_quantity' => $query2->func()->sum($totalInCase),
					'total_amount' => $query2->func()->sum($totalAmountCase),'id','item_id'
				])
				->where(['ItemLedgers.jain_thela_admin_id' => $jain_thela_admin_id])
				->group('item_id')
				->autoFields(true);
				$itemLedgers_purchase_details = ($query2);
			foreach($itemLedgers_purchase_details as $itemLedgers_purchase_detail){
			$item_id=$itemLedgers_purchase_detail->item_id;
			$total_quantity=$itemLedgers_purchase_detail->total_quantity;
			$total_amount=$itemLedgers_purchase_detail->total_amount;
			$average_amount_per=round($total_amount/$total_quantity);
			$item_average[$item_id]=$average_amount_per;
			}
				
		///////////////////////////////////////////////////////////
		$this->set(compact('details', 'url', 'opening_balance_quantity','opening_balance_amount','item_average'));
        $this->set('_serialize', ['details', 'opening_balance_quantity','opening_balance_amount']);
    }
	
	
	public function exportExcel()
	{
		$this->viewBuilder()->layout('');
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$from_date = $this->request->query('From');
		$to_date = $this->request->query('To');
		
		$where =[];
		if(!empty($from_date)){
			$from_date=date("Y-m-d",strtotime($this->request->query('From')));
			$where['ItemLedgers.transaction_date >=']=$from_date;
		}
		if(!empty($to_date)){
			$to_date=date("Y-m-d",strtotime($this->request->query('To')));
			$where['ItemLedgers.transaction_date <=']=$to_date;
		}
		
		$where1 =[];
		if(empty($from_date)){
			$from_date=date("Y-m-d");
			$where1['ItemLedgers.transaction_date >=']=$from_date;
		}
		if(empty($to_date)){
			$to_date=date("Y-m-d");
			$where1['ItemLedgers.transaction_date <=']=$to_date;
		}
		if(!empty($where)){
			$itemLedgers = $this->ItemLedgers->find()->contain(['ItemVariations'=>['Items'=> function ($q) {
				return $q->where(['is_combo'=>'no','is_virtual'=>'no','freeze'=>0])->order(['Items.name'=>'ASC']);
			},'Units']])->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id])->where($where);
		}else{
			$itemLedgers = $this->ItemLedgers->find()->contain(['ItemVariations'=>['Items'=> function ($q) {
				return $q->where(['is_combo'=>'no','is_virtual'=>'no','freeze'=>0])->order(['Items.name'=>'ASC']);
			},'Units']])->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id])->where($where1);
		}	
		$order_online = []; $order_online_name=[]; $order_bulk = []; $walkins_sales = []; $order_online_rate = [];
		$order_bulk_rate = []; $walkins_sales_rate = []; $Itemsexists=[]; $qty=0; $units=[];
		foreach($itemLedgers as $itemLedger){ 
			$Orders = $this->ItemLedgers->Orders->find()->where(['id'=>$itemLedger->order_id])->toArray();
			if(sizeof($Orders)>0){ 
				foreach($Orders as $order){
					if($order->order_type == 'Online' || $order->order_type == 'Wallet' || $order->order_type == 'Cod' || $order->order_type == 'cod'|| $order->order_type =='Offline'){
						@$order_online[$itemLedger->item_id] += $itemLedger->quantity; 
						@$order_online_rate[$itemLedger->item_id] += $itemLedger->amount; 
						@$Itemsexists[$itemLedger->item_id] = $itemLedger->item_id;
						@$units[$itemLedger->item_id] = $itemLedger->item->unit->unit_name;
						
						//pr($order_online);
					}
					if($order->order_type == 'Bulkorder'){
						@$order_bulk[$itemLedger->item_id] += $itemLedger->quantity;
						@$order_bulk_rate[$itemLedger->item_id] += $itemLedger->amount; 
						@$Itemsexists[$itemLedger->item_id] = $itemLedger->item_id;
						@$units[$itemLedger->item_id] = $itemLedger->item->unit->unit_name;
					}
				}
			}
		$WalkinSales = $this->ItemLedgers->WalkinSales->find()->where(['id'=>$itemLedger->walkin_sales_id]);	
		  foreach($WalkinSales as $WalkinSale){
				@$walkins_sales[$itemLedger->item_id] += $itemLedger->quantity; 
				@$walkins_sales_rate[$itemLedger->item_id] += @$itemLedger->amount; 
				@$Itemsexists[$itemLedger->item_id] = $itemLedger->item_id;
				@$units[$itemLedger->item_id] = $itemLedger->item->unit->unit_name;
		  }
		}
		//pr($Itemsexists);exit;
		
		$ItemList =  $this->ItemLedgers->Items->find()->order(['Items.name'=>'ASC']);
		
		$this->set(compact('itemLedgers','ItemList','from_date','to_date','order_online','order_bulk','order_offline'
		 ,'bulkitemrate','bulkitemqty','Offlineitemrate','Offlineitemqty','Onlineitemrate','Onlineitemqty','list_items','order_online_rate','order_bulk_rate','order_offline_rate','order_online_name','Itemsexists','walkins_sales','walkins_sales_rate','units','url'));
		 $this->set('_serialize', ['itemLedgers']);
	}	
	
	
	public function ajaxItemDetails($id = null)
    {
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id'); 
		   $query =$this->ItemLedgers->find();
		   
		$totalInWarehouseCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In', 'warehouse_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutWarehouseCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out', 'warehouse_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$query->select([
			'totalInWarehouse' => $query->func()->sum($totalInWarehouseCase),
			'totalOutWarehouse' => $query->func()->sum($totalOutWarehouseCase),'id','item_id'
		])
		->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id, 'item_id'=>$id, 'warehouse_id !='=>0])
		->group(['warehouse_id'])
		->autoFields(true)
		->contain(['Items'=>['Units'], 'Drivers', 'Warehouses']);
        $warehpouse_itemLedgers = ($query);
		
/////////////////////////////////
		$query1 =$this->ItemLedgers->find();
		$totalInDriverCase = $query1->newExpr()
			->addCase(
				$query1->newExpr()->add(['status' => 'In', 'driver_id']),
				$query1->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutDriverCase = $query1->newExpr()
			->addCase(
				$query1->newExpr()->add(['status' => 'out', 'driver_id']),
				$query1->newExpr()->add(['quantity']),
				'integer'
			);
		$query1->select([
			'totalInDriver' => $query->func()->sum($totalInDriverCase),
			'totalOutDriver' => $query->func()->sum($totalOutDriverCase),'id','item_id'
		])
		->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id, 'item_id'=>$id, 'driver_id !='=>0])
		->group(['driver_id'])
		->autoFields(true)
		->contain(['Items'=>['Units'], 'Drivers', 'Warehouses']);
        $driver_itemLedgers = ($query1);
		
        $this->set(compact('warehpouse_itemLedgers', 'driver_itemLedgers'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Item Ledger id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
	public function edit($id = null)
    {
        $itemLedger = $this->ItemLedgers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemLedger = $this->ItemLedgers->patchEntity($itemLedger, $this->request->getData());
            if ($this->ItemLedgers->save($itemLedger)) {
                $this->Flash->success(__('The item ledger has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item ledger could not be saved. Please, try again.'));
        }
        $items = $this->ItemLedgers->Items->find('list', ['limit' => 200]);
        $franchises = $this->ItemLedgers->Franchises->find('list', ['limit' => 200]);
        $purchaseInwardVouchers = $this->ItemLedgers->PurchaseInwardVouchers->find('list', ['limit' => 200]);
        $this->set(compact('itemLedger', 'items', 'franchises', 'purchaseInwardVouchers'));
        $this->set('_serialize', ['itemLedger']);
    }

	public function itemstockAvailable(){
		$warehouse_id=$this->request->data['warehouse_val'];
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		 
		 $Items = $this->ItemLedgers->Items->find()->where(['Items.jain_thela_admin_id' => $jain_thela_admin_id, 'Items.is_combo'=>'no', 'Items.is_virtual'=>'no', 'Items.freeze'=>0])->contain(['Units'])->order(['Items.name'=>'ASC']);
		 foreach ($Items as $item){
				$query = $this->ItemLedgers->find();
				$totalInCase = $query->newExpr()
					->addCase(
						$query->newExpr()->add(['status' => 'In','warehouse_id']),
						$query->newExpr()->add(['quantity']),
						'integer'
					);
				$totalOutCase = $query->newExpr()
					->addCase(
						$query->newExpr()->add(['status' => 'out','warehouse_id']),
						$query->newExpr()->add(['quantity']),
						'integer'
					);
				$query->select([
					'total_in' => $query->func()->sum($totalInCase),
					'total_out' => $query->func()->sum($totalOutCase),'id','item_id'
				])
				->where(['ItemLedgers.jain_thela_admin_id' => $jain_thela_admin_id, 'ItemLedgers.warehouse_id' => $warehouse_id, 'ItemLedgers.item_id' => $item->id])
				->group('warehouse_id')
				->autoFields(true)
				->contain(['Items']);
				$itemLedgers = ($query);
		 }		
		$remainingStock=[];
		  foreach($itemLedgers as $itemLedger){
			   $available_stock=$itemLedger->total_in;
			   $stock_issue=$itemLedger->total_out;
			 echo @$remainingStock[$itemLedger->item->id]=$available_stock-$stock_issue;
		  }
		  exit;
	}
	public function wastageVouchers(){
		$this->viewBuilder()->layout('index_layout'); 
        $itemLedger = $this->ItemLedgers->newEntity();
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
		 if ($this->request->is(['post', 'put'])) {
			 $ItemLedgers = $this->request->getData()['item_ledgers'];
			$transaction_date=date('Y-m-d', strtotime($this->request->getData()['transaction_date'])); 
			//$warehouse_id=$this->request->getData()['warehouse_id']; 
			
			foreach($ItemLedgers as $itemledger){ 
				if( !empty($itemledger['quantity'])){
					$query = $this->ItemLedgers->query();
					$query->insert(['transaction_date', 'item_id', 'quantity','status','jain_thela_admin_id','usable_wastage','warehouse_id'])
							->values([
							'transaction_date' => $transaction_date,
							'item_id' => $itemledger['item_id'],
							'quantity' => $itemledger['quantity'],
							'status' => 'out',
							'jain_thela_admin_id' => $jain_thela_admin_id,
							'usable_wastage' => 0,
							'warehouse_id'=> 1
							])
					->execute();
			
					$query = $this->ItemLedgers->query();
					$query->insert(['transaction_date', 'item_id', 'quantity','status','jain_thela_admin_id', 'wastage','usable_wastage'])
							->values([
							'transaction_date' => $transaction_date,
							'item_id' => $itemledger['item_id'],
							'quantity' => $itemledger['quantity'],
							'status' => ' ',
							'jain_thela_admin_id' => $jain_thela_admin_id,
							'wastage' => 1,
							'usable_wastage' => 0,
							])
					->execute();
				}
			}
			$this->Flash->success(__('The Wastage Vouchers has been saved.'));	
			return $this->redirect(['action' => 'wastageVouchers']);
		 }
		 
		$Items = $this->ItemLedgers->Items->find()->where(['Items.jain_thela_admin_id' => $jain_thela_admin_id, 'Items.is_combo'=>'no', 'Items.is_virtual'=>'no', 'Items.freeze'=>0])->contain(['Units'])->order(['Items.name'=>'ASC']);
		
		 $remainingStock=[];$itemUnit=[];
		foreach ($Items as $item){
			$query = $this->ItemLedgers->find();
			$totalInCase = $query->newExpr()
				->addCase(
					$query->newExpr()->add(['status' => 'In','warehouse_id']),
					$query->newExpr()->add(['quantity']),
					'integer'
				);
			$totalOutCase = $query->newExpr()
				->addCase(
					$query->newExpr()->add(['status' => 'out','warehouse_id']),
					$query->newExpr()->add(['quantity']),
					'integer'
				);
			$query->select([
				'total_in' => $query->func()->sum($totalInCase),
				'total_out' => $query->func()->sum($totalOutCase),'id','item_id'
			])
			->where(['ItemLedgers.jain_thela_admin_id' => $jain_thela_admin_id, 'ItemLedgers.item_id' => $item->id])
			->group('item_id')
			->autoFields(true)
			->contain(['Items'=>['Units']])->order(['Items.name' => 'ASC']);
			$itemLedgers = ($query);
			foreach($itemLedgers as $itemLedger){
				$available_stock=$itemLedger->total_in;
				$stock_issue=$itemLedger->total_out;
				$remainingStock[$itemLedger->item->id]=$available_stock-$stock_issue;
				$itemUnit[$itemLedger->item->id]=$itemLedger->item->unit->unit_name;
		  }
		} 
		
		$warehouses = $this->ItemLedgers->Warehouses->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
		
		$this->set(compact('itemLedger', 'Items','warehouses','remaining','remainingStock','itemUnit'));
        $this->set('_serialize', ['itemLedger']);
	}
	
	public function wastageReport(){
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$this->viewBuilder()->layout('index_layout'); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
		$from_date = $this->request->query('From');
		$to_date = $this->request->query('To');
		
		$this->set(compact('from_date', 'to_date'));
		
		$where=[];
		if(!empty($from_date)){
			$where['ItemLedgers.transaction_date >=']=date('Y-m-d',strtotime($from_date));
		}
		if(!empty($to_date)){
			$where['ItemLedgers.transaction_date <=']=date('Y-m-d',strtotime($to_date));
		}
		
		$query =$this->ItemLedgers->find();
		   
		$totalOutWarehouseCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['wastage' => '1','item_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
	
		$query->select([
			'totalOutWarehouse' => $query->func()->sum($totalOutWarehouseCase),'id','item_id'
		])
		->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id,'wastage'=>'1'])
		->where($where)
		->group('item_id')
		->autoFields(true)
		->contain(['Items'=>['Units']])->order(['Items.name' => 'ASC']);
        $wastageItems = ($query);
		
		///////////////////////////////////////////////////////////
		$query1 = $this->ItemLedgers->find();
				$totalInCase = $query1->newExpr()
					->addCase(
						$query1->newExpr()->add(['status' => 'In','purchase_booking_id']),
						$query1->newExpr()->add(['quantity']),
						'integer'
					);
				$totalAmountCase = $query1->newExpr()
					->addCase(
						$query1->newExpr()->add(['status' => 'In','purchase_booking_id']),
						$query1->newExpr()->add(['amount']),
						'integer'
					);
				$query1->select([
					'total_quantity' => $query1->func()->sum($totalInCase),
					'total_amount' => $query1->func()->sum($totalAmountCase),'id','item_id'
				])
				->where(['ItemLedgers.jain_thela_admin_id' => $jain_thela_admin_id])
				->group('item_id')
				->autoFields(true);
				$itemLedgers_details = ($query1);
		foreach($itemLedgers_details as $itemLedgers_detail){
			$item_id=$itemLedgers_detail->item_id;
			$total_quantity=$itemLedgers_detail->total_quantity;
			$total_amount=$itemLedgers_detail->total_amount;
			$average_amount_per=round($total_amount/$total_quantity);
			$item_average[$item_id]=$average_amount_per;
		}
		///////////////////////////////////////////////////////////
		$this->set(compact('wastageItems', 'url', 'item_average'));
        $this->set('_serialize', ['wastageItems', 'item_average']);
		
	}
	
	public function weightVariationReport(){
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$this->viewBuilder()->layout('index_layout'); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
		$driver_id = $this->request->query('driver_id');
		$from_date = $this->request->query('From');
		$to_date = $this->request->query('To');
		
		
		$this->set(compact('from_date', 'to_date','driver_id'));
		
		$where=[];
		
		if(!empty($from_date)){
			$where['ItemLedgers.transaction_date >=']=date('Y-m-d',strtotime($from_date));
		}
		if(!empty($to_date)){
			$where['ItemLedgers.transaction_date <=']=date('Y-m-d',strtotime($to_date));
		}
		
		if(!empty($driver_id)){
			$where['ItemLedgers.different_driver_id ']=$driver_id;
		}
		$query =$this->ItemLedgers->find();
		   
		$totalOutWarehouseCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['weight_variation' => '1','item_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
	
		$query->select([
			'totalOutWarehouse' => $query->func()->sum($totalOutWarehouseCase),'id','item_id'
		])
		->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id,'weight_variation'=>'1'])
		->where($where)
		->group('item_id')
		->autoFields(true)
		->contain(['Items'=>['Units']])->order(['Items.name' => 'ASC']);
        $weightvariationItems = ($query);
		//pr($weightvariationItems->toArray());exit;
		$drivers = $this->ItemLedgers->Drivers->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);

		$this->set(compact('weightvariationItems','url','drivers'));
        $this->set('_serialize', ['weightvariationItems']);
	}
	
	public function excelWeightVariation(){
		$this->viewBuilder()->layout(''); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
		$driver_id = $this->request->query('driver_id');
		$from_date = $this->request->query('From');
		$to_date = $this->request->query('To');
		
		
		$this->set(compact('from_date', 'to_date','driver_id'));
		
		$where=[];
		
		if(!empty($from_date)){
			$where['ItemLedgers.transaction_date >=']=date('Y-m-d',strtotime($from_date));
		}
		if(!empty($to_date)){
			$where['ItemLedgers.transaction_date <=']=date('Y-m-d',strtotime($to_date));
		}
		if(!empty($driver_id)){
			$where['ItemLedgers.different_driver_id ']=$driver_id;
		}
		$query =$this->ItemLedgers->find();
		   
		$totalOutWarehouseCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['weight_variation' => '1','item_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
	
		$query->select([
			'totalOutWarehouse' => $query->func()->sum($totalOutWarehouseCase),'id','item_id'
		])
		->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id,'weight_variation'=>'1'])
		->where($where)
		->group('item_id')
		->autoFields(true)
		->contain(['Items'=>['Units']])->order(['Items.name' => 'ASC']);
        $weightvariationItems = ($query);
		//pr($weightvariationItems->toArray());exit;
		$drivers = $this->ItemLedgers->Drivers->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);

		$this->set(compact('weightvariationItems','url','drivers'));
        $this->set('_serialize', ['weightvariationItems']);
	}
	
	public function excelWastage(){
		$this->viewBuilder()->layout(''); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
		$from_date = $this->request->query('From');
		$to_date = $this->request->query('To');
		
		$this->set(compact('from_date', 'to_date'));
		
		$where=[];
		if(!empty($from_date)){
			$where['ItemLedgers.transaction_date >=']=date('Y-m-d',strtotime($from_date));
		}
		if(!empty($to_date)){
			$where['ItemLedgers.transaction_date <=']=date('Y-m-d',strtotime($to_date));
		}
		
		$query =$this->ItemLedgers->find();
		   
		$totalOutWarehouseCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['wastage' => '1','item_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
	
		$query->select([
			'totalOutWarehouse' => $query->func()->sum($totalOutWarehouseCase),'id','item_id'
		])
		->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id,'wastage'=>'1'])
		->where($where)
		->group('item_id')
		->autoFields(true)
		->contain(['Items'=>['Units']])->order(['Items.name' => 'ASC']);
        $wastageItems = ($query);
		
		
		$this->set(compact('wastageItems','url'));
        $this->set('_serialize', ['wastageItems']);
	}
	
	
	public function orderEstimate()
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		 
		
		
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$this->viewBuilder()->layout('index_layout');

		if ($this->request->is('post')) {
			$check_date1=$this->request->data('dt');
			$check_date=date('Y-m-d', strtotime($check_date1));
		}else{
			
			$check_date=date('Y-m-d');
		}
			
			
		
		$query = $this->ItemLedgers->find();

		$totalInWarehouseCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In', 'warehouse_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutWarehouseCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out', 'warehouse_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalInDriverCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In', 'driver_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutDriverCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out', 'driver_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$query->select([
			'totalInWarehouse' => $query->func()->sum($totalInWarehouseCase),
			'totalOutWarehouse' => $query->func()->sum($totalOutWarehouseCase),
			'totalInDriver' => $query->func()->sum($totalInDriverCase),
			'totalOutDriver' => $query->func()->sum($totalOutDriverCase),'id','item_id'
		])
		->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id])
		->group('item_id')
		->autoFields(true)
		->contain(['Items'=>['Units','itemCategories']])->order(['Items.name' => 'ASC']);
		$itemLedgers=$query;
		
		$curent_date=$check_date;
		$before_date=date('Y-m-d', strtotime('-7 day', strtotime($check_date)));
		
		$to=$curent_date;
		$from=$before_date;
		$query1 = $this->ItemLedgers->find();
		
		$totalOrderSale = $query1->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out', 'order_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalWalkinSale = $query1->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out', 'walkin_sales_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
			
		$query1->select([
			'totalOrderSaleSum' => $query->func()->sum($totalOrderSale),
			'totalWalkinSaleSum' => $query->func()->sum($totalWalkinSale),'id','item_id'
			
		])
		->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id,'ItemLedgers.transaction_date >='=>$before_date,'ItemLedgers.transaction_date <='=>$curent_date])
		->group('item_id')
		->autoFields(true)
		->contain(['Items'=>['Units','itemCategories']]);
		$itemLedgers_details = ($query1);
	
		foreach($itemLedgers_details as $itemLedgers_detail){
			$item_id=$itemLedgers_detail->item_id;
			$total_quantity=$itemLedgers_detail->totalOrderSaleSum + $itemLedgers_detail->totalWalkinSaleSum ;
			 $total_quantity;
			$item_unit_name[$item_id]=$itemLedgers_detail->item->unit->shortname;
			$average_sale=$total_quantity/7;
			$item_average_sale[$item_id]=$average_sale;
		}
		$next_date=$check_date;
		
		$orders = $this->ItemLedgers->Orders->OrderDetails->find();

		$orders
		->contain(['Orders'=>function ($q) use($next_date){
			return $q->where(['Orders.delivery_date' => $next_date, 'Orders.status' => 'In Process']);
		}])
        ->select(['item_id','total' => $orders->func()->sum('OrderDetails.quantity')])
        ->group('OrderDetails.item_id');
		foreach($orders as $order){
			$item_id=$order->item_id;
			$next_day_item_requirement[$item_id]=$order->total;
			}
		
		
		$this->set(compact('inProcessnextdayOrder'));
		$this->set(compact('itemLedgers','url','item_average_sale','next_day_item_requirement','item_unit_name','check_date'));
    }
	
	
	
	public function orderEstimate11()
    {
		$url=$this->request->here();
		$url=parse_url($url,PHP_URL_QUERY);
		
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		$this->viewBuilder()->layout('index_layout');

		$query = $this->ItemLedgers->find();

		$totalInWarehouseCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In', 'warehouse_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutWarehouseCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out', 'warehouse_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalInDriverCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'In', 'driver_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalOutDriverCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out', 'driver_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$query->select([
			'totalInWarehouse' => $query->func()->sum($totalInWarehouseCase),
			'totalOutWarehouse' => $query->func()->sum($totalOutWarehouseCase),
			'totalInDriver' => $query->func()->sum($totalInDriverCase),
			'totalOutDriver' => $query->func()->sum($totalOutDriverCase),'id','item_id'
		])
		->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id])
		->group('item_id')
		->autoFields(true)
		->contain(['Items'=>['Units','itemCategories']])->order(['Items.name' => 'ASC']);
		$itemLedgers=$query;
		
		$curent_date=date('Y-m-d');
		$before_date=date('Y-m-d', strtotime('-7 day'));
		$query1 = $this->ItemLedgers->find();
		
		$totalOrderSale = $query1->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out', 'order_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
		$totalWalkinSale = $query1->newExpr()
			->addCase(
				$query->newExpr()->add(['status' => 'out', 'walkin_sales_id']),
				$query->newExpr()->add(['quantity']),
				'integer'
			);
			
		$query1->select([
			'totalOrderSaleSum' => $query->func()->sum($totalOrderSale),
			'totalWalkinSaleSum' => $query->func()->sum($totalWalkinSale),'id','item_id'
			
		])
		->where(['ItemLedgers.jain_thela_admin_id'=>$jain_thela_admin_id,'ItemLedgers.transaction_date >='=>$before_date,'ItemLedgers.transaction_date <='=>$curent_date])
		->group('item_id')
		->autoFields(true)
		->contain(['Items'=>['Units','itemCategories']]);
		$itemLedgers_details = ($query1);
	
		foreach($itemLedgers_details as $itemLedgers_detail){
			$item_id=$itemLedgers_detail->item_id;
			$total_quantity=$itemLedgers_detail->totalOrderSaleSum + $itemLedgers_detail->totalWalkinSaleSum ;
			 $total_quantity;
			$item_unit_name[$item_id]=$itemLedgers_detail->item->unit->shortname;
			$average_sale=$total_quantity/7;
			$item_average_sale[$item_id]=$average_sale;
		}
		$next_date=date('Y-m-d', strtotime('+1 day'));
		
		$orders = $this->ItemLedgers->Orders->OrderDetails->find();

		$orders
		->contain(['Orders'=>function ($q) use($next_date){
			return $q->where(['Orders.delivery_date' => $next_date, 'Orders.status' => 'In Process']);
		}])
        ->select(['item_id','total' => $orders->func()->sum('OrderDetails.quantity')])
        ->group('OrderDetails.item_id');
		foreach($orders as $order){
			$item_id=$order->item_id;
			$next_day_item_requirement[$item_id]=$order->total;
			}
		
		
		$this->set(compact('inProcessnextdayOrder'));
		$this->set(compact('itemLedgers','url','item_average_sale','next_day_item_requirement','item_unit_name'));
    }

	
	public function ajaxNextOrder($item_id = null,$order_qty=null){
	
	$query = $this->ItemLedgers->Items->query();
					$query->update()
							->set(['next_day_requirement' => $order_qty])
							->where(['id' => $item_id])
							->execute();
	exit;

	}
	
	public function ajaxNext(){
		$this->viewBuilder()->layout(''); 
		$query = $this->ItemLedgers->Items->query();
		$query->update()
				->set(['next_day_requirement' => 0])
				->execute();
							
				exit;
	
	}
    /**
     * Delete method
     *
     * @param string|null $id Item Ledger id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemLedger = $this->ItemLedgers->get($id);
        if ($this->ItemLedgers->delete($itemLedger)) {
            $this->Flash->success(__('The item ledger has been deleted.'));
        } else {
            $this->Flash->error(__('The item ledger could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function delOpeningStock()
	{
            $variation_id = $this->request->getData('variation_id');
            $ledger=$this->ItemLedgers->find()->where(['item_variation_id'=>$variation_id,'opening_stock'=>'Yes']);
            foreach ($ledger as $stock) {
	            $ledgers=$this->ItemLedgers->get($stock->id);
				if($this->ItemLedgers->delete($ledgers))
				{
					echo"1";
				}
			}
		exit;
	}
	
}