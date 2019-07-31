<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CustomerWallets Controller
 *
 * @property \App\Model\Table\CustomerWalletsTable $CustomerWallets
 *
 * @method \App\Model\Entity\CustomerWallet[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomerWalletsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Customers', 'Orders']
        ];
        $customerWallets = $this->paginate($this->CustomerWallets);

        $this->set(compact('customerWallets'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer Wallet id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerWallet = $this->CustomerWallets->get($id, [
            'contain' => ['Customers', 'Orders']
        ]);

        $this->set('customerWallet', $customerWallet);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customerWallet = $this->CustomerWallets->newEntity();
        if ($this->request->is('post')) {
            $customerWallet = $this->CustomerWallets->patchEntity($customerWallet, $this->request->getData());
            if ($this->CustomerWallets->save($customerWallet)) {
                $this->Flash->success(__('The customer wallet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer wallet could not be saved. Please, try again.'));
        }
        $customers = $this->CustomerWallets->Customers->find('list', ['limit' => 200]);
        $orders = $this->CustomerWallets->Orders->find('list', ['limit' => 200]);
        $this->set(compact('customerWallet', 'customers', 'orders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Wallet id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customerWallet = $this->CustomerWallets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customerWallet = $this->CustomerWallets->patchEntity($customerWallet, $this->request->getData());
            if ($this->CustomerWallets->save($customerWallet)) {
                $this->Flash->success(__('The customer wallet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer wallet could not be saved. Please, try again.'));
        }
        $customers = $this->CustomerWallets->Customers->find('list', ['limit' => 200]);
        $orders = $this->CustomerWallets->Orders->find('list', ['limit' => 200]);
        $this->set(compact('customerWallet', 'customers', 'orders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Wallet id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerWallet = $this->CustomerWallets->get($id);
        if ($this->CustomerWallets->delete($customerWallet)) {
            $this->Flash->success(__('The customer wallet has been deleted.'));
        } else {
            $this->Flash->error(__('The customer wallet could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
