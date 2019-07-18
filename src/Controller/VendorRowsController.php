<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * VendorRows Controller
 *
 * @property \App\Model\Table\VendorRowsTable $VendorRows
 *
 * @method \App\Model\Entity\VendorRow[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VendorRowsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function options(){
        $vendor_id=$this->request->getData('input'); 

        $item=$this->VendorRows->find()->where(['VendorRows.vendor_id '=>$vendor_id])->contain(['Items']);
				
        $this->set(compact('item'));   
       
    }

    public function index()
    {
        $this->viewBuilder()->layout('index_layout');
        
        $vendorRows = $this->VendorRows->find()->contain(['Vendors', 'Items']);

        $this->set(compact('vendorRows'));
    }

    /**
     * View method
     *
     * @param string|null $id Vendor Row id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vendorRow = $this->VendorRows->get($id, [
            'contain' => ['Vendors', 'Items']
        ]);

        $this->set('vendorRow', $vendorRow);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->layout('index_layout');
        $vendorRow = $this->VendorRows->newEntity();
        $datas=$this->request->getData('vendor');
        if ($this->request->is('post')) {
             $vendorRow = $this->VendorRows->newEntities($datas);
            if ($this->VendorRows->saveMany($vendorRow)) {
                $this->Flash->success(__('The vendor row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor row could not be saved. Please, try again.'));
        }
        $vendors = $this->VendorRows->Vendors->find('list', ['limit' => 200]);
        $items = $this->VendorRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('vendorRow', 'vendors', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Vendor Row id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
         $this->viewBuilder()->layout('index_layout');
        $vendorRow = $this->VendorRows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vendorRow = $this->VendorRows->patchEntity($vendorRow, $this->request->getData());
            if ($this->VendorRows->save($vendorRow)) {
                $this->Flash->success(__('The vendor row has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendor row could not be saved. Please, try again.'));
        }
        $vendors = $this->VendorRows->Vendors->find('list', ['limit' => 200]);
        $items = $this->VendorRows->Items->find('list', ['limit' => 200]);
        $this->set(compact('vendorRow', 'vendors', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Vendor Row id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vendorRow = $this->VendorRows->get($id);
        if ($this->VendorRows->delete($vendorRow)) {
            $this->Flash->success(__('The vendor row has been deleted.'));
        } else {
            $this->Flash->error(__('The vendor row could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
