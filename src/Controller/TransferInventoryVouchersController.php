<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TransferInventoryVouchers Controller
 *
 * @property \App\Model\Table\TransferInventoryVouchersTable $TransferInventoryVouchers
 *
 * @method \App\Model\Entity\TransferInventoryVoucher[] paginate($object = null, array $settings = [])
 */
class TransferInventoryVouchersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function options(){
        $item_id=$this->request->getData('input'); 

            $items=$this->TransferInventoryVouchers->TransferInventoryVoucherRows->ItemVariations->find()->where(['ItemVariations.item_id '=>$item_id])->contain(['Units']);
            ?>
                    <option>--Select--</option>
                    <?php foreach($items as $show){ ?>
                        
                        <option value="<?= $show->id ?>"><?= $show->quantity_variation." ".$show->unit->shortname ?></option>
                    <?php } ?>
            <?php
        
        exit;  
    }

    public function index()
    {
		$this->viewBuilder()->layout('index_layout'); 
 		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
        $this->paginate = [
            'contain' => ['Items']
        ];
        $transferInventoryVouchers = $this->paginate($this->TransferInventoryVouchers->find()->order(['TransferInventoryVouchers.voucher_no'=>'DESC'])->contain(['Items']));

        $this->set(compact('transferInventoryVouchers'));
        $this->set('_serialize', ['transferInventoryVouchers']);
    }

    /**
     * View method
     *
     * @param string|null $id Transfer Inventory Voucher id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transferInventoryVoucher = $this->TransferInventoryVouchers->get($id, [
            'contain' => ['Items', 'TransferInventoryVoucherRows']
        ]);

        $this->set('transferInventoryVoucher', $transferInventoryVoucher);
        $this->set('_serialize', ['transferInventoryVoucher']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout'); 
 		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
        $transferInventoryVoucher = $this->TransferInventoryVouchers->newEntity();
        if ($this->request->is('post')) {
			   $transferInventoryVoucher = $this->TransferInventoryVouchers->patchEntity($transferInventoryVoucher, $this->request->getData());
			   
			$last_voucher_no = $this->TransferInventoryVouchers->find()->select(['voucher_no'])->order(['voucher_no'=>'DESC'])->where(['jain_thela_admin_id'=>$jain_thela_admin_id])->first();
	
			if($last_voucher_no){
				$transferInventoryVoucher->voucher_no = $last_voucher_no->voucher_no+1;
			}else{
				$transferInventoryVoucher->voucher_no=1;
			}
			$transferInventoryVoucher->jain_thela_admin_id=$jain_thela_admin_id;
			$transferInventoryVoucher->created_on=date('Y-m-d');
			//pr($transferInventoryVoucher); exit;
            if ($inventory_data=$this->TransferInventoryVouchers->save($transferInventoryVoucher)) {
				$transfer_inventory_voucher_id=$inventory_data->id;
				$inventory_quantity=$inventory_data->quantity;
				$warehouse_id=$inventory_data->warehouse_id;
				$inventory_created_on=$inventory_data->created_on;
				$item_id=$inventory_data->item_id;
				
				
				$query = $this->TransferInventoryVouchers->ItemLedgers->query();
				$query->insert(['warehouse_id', 'transaction_date', 'item_id', 'quantity','status','jain_thela_admin_id', 'inventory_transfer', 'transfer_inventory_voucher_id','raw_meterial'])
						->values([
						'warehouse_id' => $warehouse_id,
						'transaction_date' => $inventory_created_on,
						'item_id' => $item_id,
						'quantity' => $inventory_quantity,
						'status' => 'Out',
						'jain_thela_admin_id' => $jain_thela_admin_id,
						'inventory_transfer' => 'yes',
						'raw_meterial' => 'Yes',
						'transfer_inventory_voucher_id' => $transfer_inventory_voucher_id
						])
				->execute();
				
				foreach($transferInventoryVoucher->transfer_inventory_voucher_rows as $transfer_data){			
					$transfer_item_id=$transfer_data->item_id;
					$transfer_quantity=$transfer_data->quantity;
					$transfer_inventory_voucher_id=$transfer_data->transfer_inventory_voucher_id;

					$query = $this->TransferInventoryVouchers->ItemLedgers->query();
					$query->insert(['warehouse_id', 'transaction_date', 'item_id', 'quantity','status','jain_thela_admin_id', 'inventory_transfer', 'transfer_inventory_voucher_id','item_variation_id'])
							->values([
							'warehouse_id' => $warehouse_id,
							'transaction_date' => $inventory_created_on,
							'item_id' => $transfer_item_id,
							'item_variation_id' => $transfer_data->item_variation_id,
							'quantity' => $transfer_quantity,
							'status' => 'In',
							'jain_thela_admin_id' => $jain_thela_admin_id,
							'inventory_transfer' => 'yes',
							'transfer_inventory_voucher_id' => $transfer_inventory_voucher_id
							])
							->execute();
				}
				
                $this->Flash->success(__('The transfer inventory voucher has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transfer inventory voucher could not be saved. Please, try again.'));
        }
		$item_fetchs = $this->TransferInventoryVouchers->Items->find()->where(['Items.is_combo'=>'no', 'Items.is_virtual'=>'real', 'Items.freeze !='=>1]);
		$items=[];
		foreach($item_fetchs as $item_fetch){
			$item_name=$item_fetch->name;
			$items[]= ['value'=>$item_fetch->id,'text'=>$item_name];
		}
		
		
		
        $warehouses = $this->TransferInventoryVouchers->Warehouses->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
        $this->set(compact('transferInventoryVoucher', 'items', 'warehouses'));
        $this->set('_serialize', ['transferInventoryVoucher']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Transfer Inventory Voucher id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout'); 
 		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		
        $transferInventoryVoucher = $this->TransferInventoryVouchers->get($id, [
            'contain' => ['TransferInventoryVoucherRows'=>['Items']]
        ]);
		
		$ItemVariations=$this->TransferInventoryVouchers->TransferInventoryVoucherRows->ItemVariations->find()->where(['ItemVariations.item_id '=>$transferInventoryVoucher->item_id])->contain(['Units','Items']);
           foreach($ItemVariations as $show){ 
				$opts[]=['value'=>$show->id  ,'text'=>$show->quantity_variation." ".$show->unit->shortname];
			}
		 
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transferInventoryVoucher = $this->TransferInventoryVouchers->patchEntity($transferInventoryVoucher, $this->request->getData());
            if ($inventory_data=$this->TransferInventoryVouchers->save($transferInventoryVoucher)) {
				 
				$transfer_inventory_voucher_id=$inventory_data->id;
				$inventory_quantity=$inventory_data->quantity;
				$warehouse_id=$inventory_data->warehouse_id;
				$inventory_created_on=$inventory_data->created_on;
				$item_id=$inventory_data->item_id;
				$waste_quantity=$inventory_data->waste_quantity;
				
				$query = $this->TransferInventoryVouchers->ItemLedgers->query();
				$result = $query->delete()
					->where(['transfer_inventory_voucher_id' => $transfer_inventory_voucher_id])
					->execute();
					 
				$query = $this->TransferInventoryVouchers->ItemLedgers->query();
				$query->insert(['warehouse_id', 'transaction_date', 'item_id', 'quantity','status','jain_thela_admin_id', 'inventory_transfer', 'transfer_inventory_voucher_id','raw_meterial'])
						->values([
						'warehouse_id' => $warehouse_id,
						'transaction_date' => $inventory_created_on,
						'item_id' => $item_id,
						'quantity' => $inventory_quantity,
						'status' => 'Out',
						'jain_thela_admin_id' => $jain_thela_admin_id,
						'inventory_transfer' => 'yes',
						'raw_meterial' => 'Yes',
						'transfer_inventory_voucher_id' => $transfer_inventory_voucher_id
						])
				->execute();
				
				foreach($transferInventoryVoucher->transfer_inventory_voucher_rows as $transfer_data){			
					$transfer_item_id=$transfer_data->item_id;
					$transfer_quantity=$transfer_data->quantity;
					$transfer_inventory_voucher_id=$transfer_data->transfer_inventory_voucher_id;

					$query = $this->TransferInventoryVouchers->ItemLedgers->query();
					$query->insert(['warehouse_id', 'transaction_date', 'item_id', 'quantity','status','jain_thela_admin_id', 'inventory_transfer', 'transfer_inventory_voucher_id','item_variation_id'])
							->values([
							'warehouse_id' => $warehouse_id,
							'transaction_date' => $inventory_created_on,
							'item_id' => $transfer_item_id,
							'item_variation_id' => $transfer_data->item_variation_id,
							'quantity' => $transfer_quantity,
							'status' => 'In',
							'jain_thela_admin_id' => $jain_thela_admin_id,
							'inventory_transfer' => 'yes',
							'transfer_inventory_voucher_id' => $transfer_inventory_voucher_id
							])
							->execute();
				}
				
                $this->Flash->success(__('The transfer inventory voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transfer inventory voucher could not be saved. Please, try again.'));
        }
		$item_fetchs = $this->TransferInventoryVouchers->Items->find()->where(['Items.is_combo'=>'no', 'Items.is_virtual'=>'real', 'Items.freeze !='=>1]);
		$items=[];
		foreach($item_fetchs as $item_fetch){
			$item_name=$item_fetch->name;
			$items[]= ['value'=>$item_fetch->id,'text'=>$item_name];
		}
 		$warehouses = $this->TransferInventoryVouchers->Warehouses->find('list')->where(['jain_thela_admin_id' => $jain_thela_admin_id]);
		$transferInventoryVoucherRows= $this->TransferInventoryVouchers->transferInventoryVoucherRows->find()->where(['transfer_inventory_voucher_id' => $id]);
        $this->set(compact('transferInventoryVoucher', 'items', 'warehouses', 'transferInventoryVoucherRows','opts'));
        $this->set('_serialize', ['transferInventoryVoucher']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Transfer Inventory Voucher id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transferInventoryVoucher = $this->TransferInventoryVouchers->get($id);
        if ($this->TransferInventoryVouchers->delete($transferInventoryVoucher)) {
            $this->Flash->success(__('The transfer inventory voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The transfer inventory voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
