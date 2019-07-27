<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WastageReuseVoucherRows Controller
 *
 * @property \App\Model\Table\WastageReuseVoucherRowsTable $WastageReuseVoucherRows
 *
 * @method \App\Model\Entity\WastageReuseVoucherRow[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WastageReuseVoucherRowsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['WastageReuseVouchers', 'Items']
        ];
        $wastageReuseVoucherRows = $this->paginate($this->WastageReuseVoucherRows);

        $this->set(compact('wastageReuseVoucherRows'));
    }

    /**
     * View method
     *
     * @param string|null $id Wastage Reuse Voucher Row id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wastageReuseVoucherRow = $this->WastageReuseVoucherRows->get($id, [
            'contain' => ['WastageReuseVouchers', 'Items']
        ]);

        $this->set('wastageReuseVoucherRow', $wastageReuseVoucherRow);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $wastageReuseVoucherRow = $this->WastageReuseVoucherRows->newEntity();
        if ($this->request->is('post')) {
            $wastageReuseVoucherRow = $this->WastageReuseVoucherRows->patchEntity($wastageReuseVoucherRow, $this->request->getData());
            if ($this->WastageReuseVoucherRows->save($wastageReuseVoucherRow)) {
                $this->Flash->success(__('The wastage reuse voucher row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wastage reuse voucher row could not be saved. Please, try again.'));
        }
        $wastageReuseVouchers = $this->WastageReuseVoucherRows->WastageReuseVouchers->find('list', ['limit' => 200]);
        $items = $this->WastageReuseVoucherRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('wastageReuseVoucherRow', 'wastageReuseVouchers', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Wastage Reuse Voucher Row id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wastageReuseVoucherRow = $this->WastageReuseVoucherRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wastageReuseVoucherRow = $this->WastageReuseVoucherRows->patchEntity($wastageReuseVoucherRow, $this->request->getData());
            if ($this->WastageReuseVoucherRows->save($wastageReuseVoucherRow)) {
                $this->Flash->success(__('The wastage reuse voucher row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wastage reuse voucher row could not be saved. Please, try again.'));
        }
        $wastageReuseVouchers = $this->WastageReuseVoucherRows->WastageReuseVouchers->find('list', ['limit' => 200]);
        $items = $this->WastageReuseVoucherRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('wastageReuseVoucherRow', 'wastageReuseVouchers', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wastage Reuse Voucher Row id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wastageReuseVoucherRow = $this->WastageReuseVoucherRows->get($id);
        if ($this->WastageReuseVoucherRows->delete($wastageReuseVoucherRow)) {
            $this->Flash->success(__('The wastage reuse voucher row has been deleted.'));
        } else {
            $this->Flash->error(__('The wastage reuse voucher row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
