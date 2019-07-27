<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UnitVariations Controller
 *
 * @property \App\Model\Table\UnitVariationsTable $UnitVariations
 *
 * @method \App\Model\Entity\UnitVariation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UnitVariationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id=null)
    {
		$this->viewBuilder()->layout('index_layout');
		
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
		if(!$id){
			$unitVariation = $this->UnitVariations->newEntity();
		}else{
			$unitVariation = $this->UnitVariations->get($id, [
				'contain' => []
			]);
		}
		
		 if ($this->request->is(['patch', 'post', 'put'])) {
            $unitVariation = $this->UnitVariations->patchEntity($unitVariation, $this->request->getData());
			$unitVariation->created_date=date('Y-m-d');
			//pr($unitVariation); exit;
            if ($this->UnitVariations->save($unitVariation)) {
                $this->Flash->success(__('The unit variation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The unit variation could not be saved. Please, try again.'));
        }
		
		
        $unitVariations = $this->paginate($this->UnitVariations);

        $this->set(compact('unitVariations','unitVariation','id'));
    }

    /**
     * View method
     *
     * @param string|null $id Unit Variation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $unitVariation = $this->UnitVariations->get($id, [
            'contain' => []
        ]);

        $this->set('unitVariation', $unitVariation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $unitVariation = $this->UnitVariations->newEntity();
        if ($this->request->is('post')) {
            $unitVariation = $this->UnitVariations->patchEntity($unitVariation, $this->request->getData());
            if ($this->UnitVariations->save($unitVariation)) {
                $this->Flash->success(__('The unit variation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The unit variation could not be saved. Please, try again.'));
        }
        $this->set(compact('unitVariation'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Unit Variation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $unitVariation = $this->UnitVariations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $unitVariation = $this->UnitVariations->patchEntity($unitVariation, $this->request->getData());
            if ($this->UnitVariations->save($unitVariation)) {
                $this->Flash->success(__('The unit variation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The unit variation could not be saved. Please, try again.'));
        }
        $this->set(compact('unitVariation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Unit Variation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $unitVariation = $this->UnitVariations->get($id);
        if ($this->UnitVariations->delete($unitVariation)) {
            $this->Flash->success(__('The unit variation has been deleted.'));
        } else {
            $this->Flash->error(__('The unit variation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
