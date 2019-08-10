<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WastageReuseVouchers Controller
 *
 * @property \App\Model\Table\WastageReuseVouchersTable $WastageReuseVouchers
 *
 * @method \App\Model\Entity\WastageReuseVoucher[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WastageReuseVouchersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $wastageReuseVouchers = $this->paginate($this->WastageReuseVouchers);

        $this->set(compact('wastageReuseVouchers'));
    }

    /**
     * View method
     *
     * @param string|null $id Wastage Reuse Voucher id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $wastageReuseVoucher = $this->WastageReuseVouchers->get($id, [
            'contain' => ['WastageReuseVoucherRows'=>['Items','UnitVariations']]
        ]);
		//pr($wastageReuseVoucher); exit;
        $this->set('wastageReuseVoucher', $wastageReuseVoucher);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
    	$this->viewBuilder()->layout('index_layout');
        $wastageReuseVoucher = $this->WastageReuseVouchers->newEntity();
        if ($this->request->is('post')) {
            $wastageReuseVoucher = $this->WastageReuseVouchers->patchEntity($wastageReuseVoucher, $this->request->getData());
			$wastageReuseVoucher->created_date=date('Y-m-d');
			
			$last_voucher_no = $this->WastageReuseVouchers->find()->select(['voucher_no'])->order(['voucher_no'=>'DESC'])->first();
			if($last_voucher_no){
				$wastageReuseVoucher->voucher_no = $last_voucher_no->voucher_no+1;
			}else{
				$wastageReuseVoucher->voucher_no=1;
			}
			
			if ($this->WastageReuseVouchers->save($wastageReuseVoucher)) {
				
				foreach($wastageReuseVoucher->wastage_reuse_voucher_rows as $data){
				if($data->wastage_quantity > 0){
					$ItemLedger = $this->WastageReuseVouchers->WastageReuseVoucherRows->Items->ItemLedgers->newEntity(); 
					$ItemLedger->item_id=$data->item_id;
					$ItemLedger->unit_variation_id=$data->unit_variation_id;
					$ItemLedger->status='Out';
					$ItemLedger->quantity=$data->wastage_quantity;
					$ItemLedger->wastage='1';
					$ItemLedger->wastage_reuse_voucher_id=$wastageReuseVoucher->id;
					$ItemLedger->transaction_date=date('Y-m-d');
					$ItemLedger->wastage_reuse_voucher_row_id=$data->id;  
					$dd= $this->WastageReuseVouchers->WastageReuseVoucherRows->Items->ItemLedgers->save($ItemLedger);
					
					$query=$this->WastageReuseVouchers->WastageReuseVoucherRows->Items->ItemLedgers->query();
						$result = $query->update()
						->set(['unit_variation_id' => $data->unit_variation_id])
						->where(['id' => $dd->id])
						->execute();
					
					
				}
				if($data->reuse_quantity > 0){
					$ItemLedger = $this->WastageReuseVouchers->WastageReuseVoucherRows->Items->ItemLedgers->newEntity();
					$ItemLedger->item_id=$data->item_id;
					$ItemLedger->unit_variation_id=$data->unit_variation_id;
					$ItemLedger->status='Out';
					$ItemLedger->quantity=$data->reuse_quantity;
					$ItemLedger->usable_wastage='1';
					$ItemLedger->transaction_date=date('Y-m-d');
					$ItemLedger->wastage_reuse_voucher_id=$wastageReuseVoucher->id;
					$ItemLedger->wastage_reuse_voucher_row_id=$data->id;
					$dd = $this->WastageReuseVouchers->WastageReuseVoucherRows->Items->ItemLedgers->save($ItemLedger);
					$query=$this->WastageReuseVouchers->WastageReuseVoucherRows->Items->ItemLedgers->query();
						$result = $query->update()
						->set(['unit_variation_id' => $data->unit_variation_id])
						->where(['id' => $dd->id])
						->execute();
				}
			}
				
                $this->Flash->success(__('The wastage reuse voucher has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The wastage reuse voucher could not be saved. Please, try again.'));
        }
		$wastageReuseVoucherList = $this->WastageReuseVouchers->find();
		$Items=$this->WastageReuseVouchers->WastageReuseVoucherRows->Items->find('list')->where(['Items.freeze'=>0]);
		$UnitVariations=$this->WastageReuseVouchers->WastageReuseVoucherRows->UnitVariations->find('list');
        $this->set(compact('wastageReuseVoucher','Items','UnitVariations','wastageReuseVoucherList'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Wastage Reuse Voucher id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wastageReuseVoucher = $this->WastageReuseVouchers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wastageReuseVoucher = $this->WastageReuseVouchers->patchEntity($wastageReuseVoucher, $this->request->getData());
            if ($this->WastageReuseVouchers->save($wastageReuseVoucher)) {
                $this->Flash->success(__('The wastage reuse voucher has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wastage reuse voucher could not be saved. Please, try again.'));
        }
        $this->set(compact('wastageReuseVoucher'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wastage Reuse Voucher id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wastageReuseVoucher = $this->WastageReuseVouchers->get($id);
        if ($this->WastageReuseVouchers->delete($wastageReuseVoucher)) {
            $this->Flash->success(__('The wastage reuse voucher has been deleted.'));
        } else {
            $this->Flash->error(__('The wastage reuse voucher could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
