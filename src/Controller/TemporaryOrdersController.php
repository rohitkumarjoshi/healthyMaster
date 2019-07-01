<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TemporaryOrders Controller
 *
 * @property \App\Model\Table\TemporaryOrdersTable $TemporaryOrders
 *
 * @method \App\Model\Entity\TemporaryOrder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TemporaryOrdersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->viewBuilder()->layout('index_layout');
        $this->paginate = [
            'contain' => ['Orders'=>['OrderDetails']]
        ];

        if ($this->request->is(['post', 'put'])) {
            $temporary_orders=$this->request->getData('temporary_orders');
            
            $temps=$this->TemporaryOrders->Orders->find()
            //->select(['total'=>'count(Orders.OrderDetails.item_id)'])
            ->where(['Orders.id IN'=>$temporary_orders])
            ->contain(['CustomerAddresses','OrderDetails'=>['Items','ItemVariations'=>['Units']]]);
        }
        //pr($temporary_orders);exit;

        // $temporaryOrders = $this->paginate($this->TemporaryOrders);
        // $temps=$this->TemporaryOrders->find()->
        // contain(['Orders'=>['CustomerAddresses','OrderDetails'=>['Items','ItemVariations'=>['Units']]]]);
        
        // foreach ($temps as $temp) {
        //    $count=$this->TemporaryOrders->Orders->OrderDetails->find()
        //    ->select(['total'=>'count(OrderDetails.item_id)'])
        //    ->where(['order_id'=>$temp->order_id]);
        // }

        //pr($count->toArray());exit;

        $this->set(compact('temporaryOrders','temps','count'));
    }

    /**
     * View method
     *
     * @param string|null $id Temporary Order id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $temporaryOrder = $this->TemporaryOrders->get($id, [
            'contain' => ['Orders']
        ]);

        $this->set('temporaryOrder', $temporaryOrder);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $temporaryOrder = $this->TemporaryOrders->newEntity();
        if ($this->request->is('post')) {
            $temporaryOrder = $this->TemporaryOrders->patchEntity($temporaryOrder, $this->request->getData());
            if ($this->TemporaryOrders->save($temporaryOrder)) {
                $this->Flash->success(__('The temporary order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The temporary order could not be saved. Please, try again.'));
        }
        $orders = $this->TemporaryOrders->Orders->find('list', ['limit' => 200]);
        $this->set(compact('temporaryOrder', 'orders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Temporary Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $temporaryOrder = $this->TemporaryOrders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $temporaryOrder = $this->TemporaryOrders->patchEntity($temporaryOrder, $this->request->getData());
            if ($this->TemporaryOrders->save($temporaryOrder)) {
                $this->Flash->success(__('The temporary order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The temporary order could not be saved. Please, try again.'));
        }
        $orders = $this->TemporaryOrders->Orders->find('list', ['limit' => 200]);
        $this->set(compact('temporaryOrder', 'orders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Temporary Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $temporaryOrder = $this->TemporaryOrders->get($id);
        if ($this->TemporaryOrders->delete($temporaryOrder)) {
            $this->Flash->success(__('The temporary order has been deleted.'));
        } else {
            $this->Flash->error(__('The temporary order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
