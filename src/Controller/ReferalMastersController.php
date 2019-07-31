<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ReferalMasters Controller
 *
 * @property \App\Model\Table\ReferalMastersTable $ReferalMasters
 *
 * @method \App\Model\Entity\ReferalMaster[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReferalMastersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id=null)
    {
       $this->viewBuilder()->layout('index_layout');
        if(!$id){
           $referalMaster = $this->ReferalMasters->newEntity();
        }else{
                $referalMaster = $this->ReferalMasters->get($id);
        }

        $referalMaster = $this->ReferalMasters->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $referalMaster = $this->ReferalMasters->patchEntity($referalMaster, $this->request->getData());
            if ($this->ReferalMasters->save($referalMaster)) {
                $this->Flash->success(__('The referal master has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The referal master could not be saved. Please, try again.'));
        }
         $referalMasters = $this->ReferalMasters->find();
        $this->set(compact('referalMaster','referalMasters','refer'));
    }

    /**
     * View method
     *
     * @param string|null $id Referal Master id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $referalMaster = $this->ReferalMasters->get($id, [
            'contain' => []
        ]);

        $this->set('referalMaster', $referalMaster);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id=null)
    {
        $this->viewBuilder()->layout('index_layout');

        if(!$id){
           $referalMaster = $this->ReferalMasters->newEntity();
        }else{
                $referalMaster = $this->ReferalMasters->get($id);
        }

        $referalMaster = $this->ReferalMasters->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $referalMaster = $this->ReferalMasters->patchEntity($referalMaster, $this->request->getData());
            if ($this->ReferalMasters->save($referalMaster)) {
                $this->Flash->success(__('The referal master has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The referal master could not be saved. Please, try again.'));
        }
         $referalMasters = $this->ReferalMasters->find()->where(['id'=>$id]);
        $this->set(compact('referalMaster','referalMasters'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Referal Master id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $referalMaster = $this->ReferalMasters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $referalMaster = $this->ReferalMasters->patchEntity($referalMaster, $this->request->getData());
            if ($this->ReferalMasters->save($referalMaster)) {
                $this->Flash->success(__('The referal master has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The referal master could not be saved. Please, try again.'));
        }
        $this->set(compact('referalMaster'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Referal Master id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $referalMaster = $this->ReferalMasters->get($id);
        $referalMaster->status=1;
        if ($this->ReferalMasters->save($referalMaster)) {
            $this->Flash->success(__('The referal master has been deleted.'));
        } else {
            $this->Flash->error(__('The referal master could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function delete1($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $referalMaster = $this->ReferalMasters->get($id);
        $referalMaster->status=0;
        if ($this->ReferalMasters->save($referalMaster)) {
            $this->Flash->success(__('The referal master has been deleted.'));
        } else {
            $this->Flash->error(__('The referal master could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
