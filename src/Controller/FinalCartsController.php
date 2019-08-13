<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FinalCarts Controller
 *
 * @property \App\Model\Table\FinalCartsTable $FinalCarts
 *
 * @method \App\Model\Entity\FinalCart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FinalCartsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Customers', 'Items', 'ItemVariations']
        ];
        $finalCarts = $this->paginate($this->FinalCarts);

        $this->set(compact('finalCarts'));
    }

    /**
     * View method
     *
     * @param string|null $id Final Cart id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $finalCart = $this->FinalCarts->get($id, [
            'contain' => ['Customers', 'Items', 'ItemVariations']
        ]);

        $this->set('finalCart', $finalCart);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $finalCart = $this->FinalCarts->newEntity();
        if ($this->request->is('post')) {
            $finalCart = $this->FinalCarts->patchEntity($finalCart, $this->request->getData());
            if ($this->FinalCarts->save($finalCart)) {
                $this->Flash->success(__('The final cart has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The final cart could not be saved. Please, try again.'));
        }
        $customers = $this->FinalCarts->Customers->find('list', ['limit' => 200]);
        $items = $this->FinalCarts->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->FinalCarts->ItemVariations->find('list', ['limit' => 200]);
        $this->set(compact('finalCart', 'customers', 'items', 'itemVariations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Final Cart id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $finalCart = $this->FinalCarts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $finalCart = $this->FinalCarts->patchEntity($finalCart, $this->request->getData());
            if ($this->FinalCarts->save($finalCart)) {
                $this->Flash->success(__('The final cart has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The final cart could not be saved. Please, try again.'));
        }
        $customers = $this->FinalCarts->Customers->find('list', ['limit' => 200]);
        $items = $this->FinalCarts->Items->find('list', ['limit' => 200]);
        $itemVariations = $this->FinalCarts->ItemVariations->find('list', ['limit' => 200]);
        $this->set(compact('finalCart', 'customers', 'items', 'itemVariations'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Final Cart id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $finalCart = $this->FinalCarts->get($id);
        if ($this->FinalCarts->delete($finalCart)) {
            $this->Flash->success(__('The final cart has been deleted.'));
        } else {
            $this->Flash->error(__('The final cart could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
