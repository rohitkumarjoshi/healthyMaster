<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PurchaseBookings Controller
 *
 * @property \App\Model\Table\PurchaseBookingsTable $PurchaseBookings
 *
 * @method \App\Model\Entity\PurchaseBooking[] paginate($object = null, array $settings = [])
 */
class PurchaseBookingsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

     public function exportPurchaseReport()
    {
       $this->viewBuilder()->layout('');
       $purchases=$this->PurchaseBookings->PurchaseBookingDetails->find()
       ->contain(['Items'=>['ItemCategories','GstFigures'],'UnitVariations','PurchaseBookings'=>['Vendors'=>['Cities']]])->order(['PurchaseBookingDetails.id'=>'DESC']);
         $this->set(compact('purchases','vendors','items'));
    }
    public function purchaseReport()
    {
       $this->viewBuilder()->layout('index_layout');
       $purchases=$this->PurchaseBookings->PurchaseBookingDetails->find()
       ->contain(['Items'=>['ItemCategories','GstFigures'],'UnitVariations','PurchaseBookings'=>['Vendors'=>['Cities']]])->order(['PurchaseBookingDetails.id'=>'DESC']);
        if ($this->request->is('post')) {
            $datas = $this->request->getData();
            if(!empty($datas['vendor_id']))
            {
                $purchases->where(['PurchaseBookings.vendor_id'=>$datas['vendor_id']]);
                //pr($datas['customer_id']);
                //pr($purchases->toArray());exit;
            }
             if(!empty($datas['item_id']))
            {
                $purchases->where(['PurchaseBookingDetails.item_id'=>$datas['item_id']]);
                //pr($datas['customer_id']);
                //pr($purchases->toArray());exit;
            }
            if(!empty($datas['From'])){
                $from_date=date("Y-m-d",strtotime($datas['From']));
                $purchases->where(['PurchaseBookings.transaction_date >='=> $from_date]);
            }
            if(!empty($datas['To'])){ 
                $to_date=date("Y-m-d",strtotime($datas['To']));
                $purchases->where(['PurchaseBookings.transaction_date <=' => $to_date ]);
            }
        }
       $vendors=$this->PurchaseBookings->Vendors->find('list');
        $items=$this->PurchaseBookings->PurchaseBookingDetails->Items->find('list')->where(['freeze'=>0]);
        $this->set(compact('purchases','vendors','items'));
    }
    public function index()
    {
		$this->viewBuilder()->layout('index_layout');
		
       
        $purchaseBookings = $this->PurchaseBookings->find()->contain(['Vendors'])->order(['PurchaseBookings.id'=>'DESC']);
       // pr($purchaseBookings->toArray());exit;
		
        $this->set(compact('purchaseBookings'));
        $this->set('_serialize', ['purchaseBookings']);
    }

    /**
     * View method
     *
     * @param string|null $id Purchase Booking id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $purchaseBooking = $this->PurchaseBookings->get($id, [
	'contain' => [ 'Vendors','PurchaseBookingDetails'=>['Items','UnitVariations']]
        ]);
			
    //pr($purchaseBooking->toArray());exit;
        $this->set('purchaseBooking', $purchaseBooking);
        $this->set('_serialize', ['purchaseBooking']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($grn_id = null)
    {
		$this->viewBuilder()->layout('index_layout');
		// $grn = $this->PurchaseBookings->Grns->get($grn_id, [
  //           'contain' => ['GrnDetails'=>['Items','ItemVariations'=>['Units']], 'Vendors', 'JainThelaAdmins']
  //       ]);
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
        $purchaseBooking = $this->PurchaseBookings->newEntity();
        if ($this->request->is('post')) { 
            $purchaseBooking = $this->PurchaseBookings->patchEntity($purchaseBooking, $this->request->getData());
			
			$last_voucher_no = $this->PurchaseBookings->find()->select(['voucher_no'])->order(['voucher_no'=>'DESC'])->where(['jain_thela_admin_id'=>$jain_thela_admin_id])->first();
			if($last_voucher_no){
				$purchaseBooking->voucher_no = $last_voucher_no->voucher_no+1;
			}else{
				$purchaseBooking->voucher_no=1;
			}
			$purchaseBooking->jain_thela_admin_id=$jain_thela_admin_id;
			// $purchaseBooking->vendor_id=$grn->vendor_id;
			// $purchaseBooking->grn_id=$grn->id;
			
			
			
			
			
            if ($this->PurchaseBookings->save($purchaseBooking)) { 
				
				//$this->PurchaseBookings->ItemLedgers->deleteAll(['grn_id' => $grn_id]);
				foreach($purchaseBooking->purchase_booking_details as $purchase_booking_detail)
				{
					/* $ItemVariationdata = $this->PurchaseBookings->ItemLedgers->ItemVariations->find()->select(['unit_variation_id'])->where(['id'=>$purchase_booking_detail->item_variation_id])->first(); */
					
					
					$query = $this->PurchaseBookings->ItemLedgers->query();
					$query->insert(['jain_thela_admin_id', 'driver_id', 'grn_id', 'item_id', 'warehouse_id', 'purchase_booking_id', 'rate', 'amount', 'status', 'quantity','rate_updated', 'transaction_date','item_variation_id','unit_variation_id'])
					->values([
						'jain_thela_admin_id' => $jain_thela_admin_id,
						'driver_id' => 0,
						//'grn_id' => $grn_id,
						'item_id' => $purchase_booking_detail->item_id,
						'warehouse_id' => $purchaseBooking->warehouse_id,
						'purchase_booking_id' => $purchaseBooking->id,
						'rate' => $purchase_booking_detail->rate,
						'item_variation_id' => $purchase_booking_detail->item_variation_id,
						'amount' => $purchase_booking_detail->amount,
						'status' => 'In',
						'quantity' => $purchase_booking_detail->quantity,
						'rate_updated' => 'Yes',
						'transaction_date'=>$purchaseBooking->transaction_date,
						'unit_variation_id'=>$purchase_booking_detail->unit_variation_id,
                   ]);
					$query->execute();
					
					$query=$this->PurchaseBookings->PurchaseBookingDetails->query();
					$result = $query->update()
					->set(['unit_variation_id' => $purchase_booking_detail->unit_variation_id])
					->where(['id' => $purchase_booking_detail->id])
					->execute();
					 
				}
					
				// $query=$this->PurchaseBookings->Grns->query();
				// $result = $query->update()
    //                 ->set(['purchase_booked' => 'Yes'])
    //                 ->where(['id' => $grn_id])
    //                 ->execute();
				$LedgerAccounts = $this->PurchaseBookings->LedgerAccounts->find('all')->where(['jain_thela_admin_id'=>$jain_thela_admin_id,'vendor_id'=>$purchaseBooking->vendor_id]);
				
				$query = $this->PurchaseBookings->Ledgers->query();
					$query->insert(['ledger_account_id', 'purchase_booking_id', 'debit', 'credit', 'transaction_date'])
					->values([
						'ledger_account_id' => 1,
						'purchase_booking_id' => $purchaseBooking->id,
						'debit' => $this->request->data['total_amount'],
						'credit' => 0,
						'transaction_date'=>$purchaseBooking->transaction_date
					]);
					$query->execute();	
					$query = $this->PurchaseBookings->Ledgers->query();
					$query->insert(['ledger_account_id', 'purchase_booking_id', 'debit', 'credit', 'transaction_date'])
					->values([
						'ledger_account_id' => 4,
						'purchase_booking_id' => $purchaseBooking->id,
						'debit' => 0,//$this->request->data['frieght_amount'],
						'credit' => 0,
						'transaction_date'=>$purchaseBooking->transaction_date
					]);
					$query->execute();
					$query = $this->PurchaseBookings->Ledgers->query();
					$query->insert(['ledger_account_id', 'purchase_booking_id', 'debit', 'credit', 'transaction_date'])
					->values([
						'ledger_account_id' => 5,
						'purchase_booking_id' => $purchaseBooking->id,
						'debit' =>0,// $this->request->data['gst_amount'],
						'credit' => 0,
						'transaction_date'=>$purchaseBooking->transaction_date
					]);
					$query->execute();
				foreach($LedgerAccounts as $LedgerAccount)
				{
					$query = $this->PurchaseBookings->Ledgers->query();
					$query->insert(['ledger_account_id', 'purchase_booking_id', 'debit', 'credit', 'transaction_date'])
					->values([
						'ledger_account_id' => $LedgerAccount->id,
						'purchase_booking_id' => $purchaseBooking->id,
						'debit' => 0,
						'credit' => $this->request->data['total_amount'],
						'transaction_date'=>$purchaseBooking->transaction_date
					]);
					$query->execute();	
				}
				
                $this->Flash->success(__('The purchase booking has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
			
            $this->Flash->error(__('The purchase booking could not be saved. Please, try again.'));
        }
         $vendors = $this->PurchaseBookings->Vendors->find('list');
        $warehouses = $this->PurchaseBookings->ItemLedgers->Warehouses->find('list')->where(['jain_thela_admin_id'=>$jain_thela_admin_id]);
        $item_fetchs=$this->PurchaseBookings->PurchaseBookingDetails->Items->find()->where(['Items.freeze'=>0, 'Items.ready_to_sale' => 'Yes'])->contain(['GstFigures']);
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
            
            $items[]= ['value'=>$item_fetch->id,'text'=>$item_name." (".$alias_name.")", 'print_quantity'=>$print_quantity, 'rates'=>$rates,'sales_rate' =>$sales_rates,'minimum_quantity_factor'=>$minimum_quantity_factor, 'unit_name'=>$unit_name, 'minimum_quantity_purchase'=>$minimum_quantity_purchase,'is_combo' => $is_combo,'gst_figure_id'=>@$item_fetch->gst_figure_id,'gst_name'=>@$item_fetch->gst_figure->name,'tax_percentage'=>@$item_fetch->gst_figure->tax_percentage];
        }
		//pr($grn);
		//exit;
		$UnitVariations=$this->PurchaseBookings->PurchaseBookingDetails->Items->ItemVariations->UnitVariations->find('list')->toArray();;
		//pr($UnitVariations); exit;
        $this->set(compact('purchaseBooking', 'grn','vendors','warehouses','items','UnitVariations'));
        $this->set('_serialize', ['purchaseBooking']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase Booking id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
            $jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
    	$this->viewBuilder()->layout('index_layout');
        $purchaseBooking = $this->PurchaseBookings->get($id, [
	'contain' => ['Vendors','PurchaseBookingDetails'=>['Items','ItemVariations'=>['Units']]]
        ]);
       // pr($purchaseBooking);exit;
        
         
        if ($this->request->is(['patch', 'post', 'put'])) {
        	 $purchaseBookings = $this->PurchaseBookings->get($id, [
	'contain' => ['Vendors','PurchaseBookingDetails'=>['Items','ItemVariations'=>['Units']]]
        ]);
            $purchaseBooking = $this->PurchaseBookings->patchEntity($purchaseBookings, $this->request->getData());
            //pr($purchaseBooking);exit;
            if ($this->PurchaseBookings->save($purchaseBooking)) {
                $this->Flash->success(__('The purchase booking has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase booking could not be saved. Please, try again.'));
        }
         $item_fetchs=$this->PurchaseBookings->PurchaseBookingDetails->Items->find()->where(['Items.freeze'=>0, 'Items.ready_to_sale' => 'Yes'])->contain(['GstFigures']);
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
            
            $items[]= ['value'=>$item_fetch->id,'text'=>$item_name." (".$alias_name.")", 'print_quantity'=>$print_quantity, 'rates'=>$rates,'sales_rate' =>$sales_rates,'minimum_quantity_factor'=>$minimum_quantity_factor, 'unit_name'=>$unit_name, 'minimum_quantity_purchase'=>$minimum_quantity_purchase,'is_combo' => $is_combo,'gst_figure_id'=>@$item_fetch->gst_figure_id,'gst_name'=>@$item_fetch->gst_figure->name,'tax_percentage'=>@$item_fetch->gst_figure->tax_percentage];
        }
        //$grns = $this->PurchaseBookings->Grns->find('list', ['limit' => 200]);
        //$details = $this->PurchaseBookings->PurchaseBookingDetails->find()->where(['purchase_booking_id'=>$id])->contain(['Items','ItemVariations'=>['Units']]);
        $vendors = $this->PurchaseBookings->Vendors->find('list', ['limit' => 200]);
          $warehouses = $this->PurchaseBookings->ItemLedgers->Warehouses->find('list')->where(['jain_thela_admin_id'=>$jain_thela_admin_id]);
		 $UnitVariations=$this->PurchaseBookings->PurchaseBookingDetails->Items->ItemVariations->UnitVariations->find('list')->toArray();;
        $jainThelaAdmins = $this->PurchaseBookings->JainThelaAdmins->find('list', ['limit' => 200]);
        $this->set(compact('purchaseBooking', 'vendors', 'jainThelaAdmins','warehouses','items','UnitVariations'));
        $this->set('_serialize', ['purchaseBooking']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Purchase Booking id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchaseBooking = $this->PurchaseBookings->get($id);
        if ($this->PurchaseBookings->delete($purchaseBooking)) {
            $this->Flash->success(__('The purchase booking has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase booking could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
