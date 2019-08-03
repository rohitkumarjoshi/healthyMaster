<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DeliveryCharges Controller
 *
 * @property \App\Model\Table\DeliveryChargesTable $DeliveryCharges
 *
 * @method \App\Model\Entity\DeliveryCharge[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DeliveryChargesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['PromoCodes']
        ];
        $deliveryCharges = $this->paginate($this->DeliveryCharges);

        $this->set(compact('deliveryCharges'));
    }

    /**
     * View method
     *
     * @param string|null $id Delivery Charge id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $deliveryCharge = $this->DeliveryCharges->get($id, [
            'contain' => ['PromoCodes', 'Orders']
        ]);

        $this->set('deliveryCharge', $deliveryCharge);
    }

	public function updatePincodeTable()
    {
		//State Entry
		/* $DummyCities = $this->DeliveryCharges->DummyCities->find()->group('DummyCities.state_name');
		foreach($DummyCities as $data){
			$States=$this->DeliveryCharges->Pincodes->States->newEntity();
			$States->state_name=$data->state_name;
			//$States->country_id='101';
			$States->created_at='';
			$States->is_deleted='0';
			$this->DeliveryCharges->Pincodes->States->save($States);
		} */
		
		//City Entry
		
		
		//$DummyCities = $this->DeliveryCharges->DummyCities->find()->group('DummyCities.city_name');
		
		/* foreach($DummyCities as $data){
			$States=$this->DeliveryCharges->Pincodes->States->find()->where(['state_name'=>$data->state_name])->first();
			
			$Cities=$this->DeliveryCharges->Pincodes->Cities->newEntity();
			$Cities->name=$data->city_name;
			$Cities->state_id=$States->id;
			$Cities->created_at='';
			$Cities->is_deleted='0';
			$Cities->pin_code_no=$data->pin_code_number; 
			$this->DeliveryCharges->Pincodes->Cities->save($Cities);
		}
		exit; */
		
		
        $DummyCities = $this->DeliveryCharges->DummyCities->find();
		$i=0;
		
		foreach($DummyCities as $data){
			$i++;
			$States=$this->DeliveryCharges->Pincodes->States->find()->where(['States.state_name'=>$data->state_name])->first();
			$Cities=$this->DeliveryCharges->Pincodes->Cities->find()->where(['Cities.name'=>$data->city_name])->first();
			$Pincod=$this->DeliveryCharges->Pincodes->newEntity();
			$Pincod->pincode=$data->pin_code_number;
			$Pincod->state_id=$States->id;
			$Pincod->city_id=$Cities->id;
			$Pincod->we_deliver='Yes'; 
			$this->DeliveryCharges->Pincodes->save($Pincod);   
		} 
		pr($i); exit;
        $this->set('deliveryCharge', $deliveryCharge);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $deliveryCharge = $this->DeliveryCharges->newEntity();
        if ($this->request->is('post')) {
            $deliveryCharge = $this->DeliveryCharges->patchEntity($deliveryCharge, $this->request->getData());
            if ($this->DeliveryCharges->save($deliveryCharge)) {
                $this->Flash->success(__('The delivery charge has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delivery charge could not be saved. Please, try again.'));
        }
        $promoCodes = $this->DeliveryCharges->PromoCodes->find('list', ['limit' => 200]);
        $this->set(compact('deliveryCharge', 'promoCodes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Delivery Charge id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $deliveryCharge = $this->DeliveryCharges->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $deliveryCharge = $this->DeliveryCharges->patchEntity($deliveryCharge, $this->request->getData());
            if ($this->DeliveryCharges->save($deliveryCharge)) {
                $this->Flash->success(__('The delivery charge has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delivery charge could not be saved. Please, try again.'));
        }
        $promoCodes = $this->DeliveryCharges->PromoCodes->find('list', ['limit' => 200]);
        $this->set(compact('deliveryCharge', 'promoCodes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Delivery Charge id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $deliveryCharge = $this->DeliveryCharges->get($id);
        if ($this->DeliveryCharges->delete($deliveryCharge)) {
            $this->Flash->success(__('The delivery charge has been deleted.'));
        } else {
            $this->Flash->error(__('The delivery charge could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
