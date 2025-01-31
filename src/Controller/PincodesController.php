<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Pincodes Controller
 *
 * @property \App\Model\Table\PincodesTable $Pincodes
 *
 * @method \App\Model\Entity\Pincode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PincodesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

     public function checkPin()
    {
        //$items='0';
         $pincode=$this->request->getData('input'); 
         //alert($mobile);
            if($this->Pincodes->exists(['pincode'=>$pincode]))
            {
                echo"1";
            }
    
        exit;  
    }

    public function check()
    {
         $pincode=$this->request->getData('input');
         $get_pin=$this->Pincodes->find()->where(['pincode'=>$pincode])->contain(['States','Cities']);
         //echo $get_pin;exit;
        foreach ($get_pin as $pin) {?>
             <option value="<?= $pin->state_id ?>"><?= $pin->state->state_name?></option>
       <?php  }
         
         exit;
    }

     public function check1()
    {
         $pincode=$this->request->getData('input');
         $get_pin=$this->Pincodes->find()->where(['pincode'=>$pincode])->contain(['States','Cities']);
         //echo $get_pin;exit;
        foreach ($get_pin as $pin) {?>
             <option value="<?= $pin->city_id ?>"><?= $pin->city->name?></option>
       <?php  }
         
         exit;
    }
    public function options(){
        $state_id=$this->request->getData('input'); 

            $states=$this->Pincodes->Cities->find()->where(['Cities.state_id'=>$state_id]);
            ?>
                    <option>--Select--</option>
                    <?php foreach($states as $show){ ?>
                        
                        <option value="<?= $show->id ?>"><?= $show->name?></option>
                    <?php } ?>
            <?php
        
        exit;  
    }
    public function index()
    {
        $this->viewBuilder()->layout('index_layout');
        $pincodes=[];
       $pin = $this->Pincodes->newEntity();
       
			$pincode=$this->request->query('pincode');
			$state_id=$this->request->query('state_id');
			$city_id=$this->request->query('city_id');
			if(!empty($pincode)){
				 $pincodes =$this->paginate($this->Pincodes->find()->where(['pincode'=>$pincode])->contain(['States','Cities','DeliveryCharges']));
			}
			if(!empty($state_id)){
				 $pincodes =$this->paginate($this->Pincodes->find()->where(['Pincodes.state_id'=>$state_id])->contain(['States','Cities','DeliveryCharges']));
			}
			if($city_id=='--Select--'){ 
					$city_id='';
				}
			if(!empty($city_id)){
				
				$pincodes =$this->paginate($this->Pincodes->find()
				->where(['Pincodes.city_id'=>$city_id])->contain(['States','Cities','DeliveryCharges']));
			}
			// pr($pincodes->toArray());exit;
			 
		 $states = $this->Pincodes->States->find('list');
        $this->set(compact('pincodes','states','pin'));
    }

    /**
     * View method
     *
     * @param string|null $id Pincode id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pincode = $this->Pincodes->get($id, [
            'contain' => ['States', 'Cities','DeliveryCharges']
        ]);

        $this->set('pincode', $pincode);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->layout('index_layout');
        $pincode = $this->Pincodes->newEntity();
        $DeliveryCharges = $this->Pincodes->DeliveryCharges->newEntity();
        if ($this->request->is('post')) {
            $data=$this->request->getData();
           // pr($data);
            $pincode = $this->Pincodes->patchEntity($pincode,$data);
			
            if ($this->Pincodes->save($pincode)) {
                if($data['we_deliver']=="Yes")
                {
                    $DeliveryCharges->hundred_gm=$this->request->getData('hundred_gm');
                    $DeliveryCharges->five_hundred_gm=$this->request->getData('five_hundred_gm');
                    $DeliveryCharges->one_kg=$this->request->getData('one_kg');
                    $DeliveryCharges->min_order_value=$this->request->getData('min_order_value');
                    $DeliveryCharges->pincode_no=$this->request->getData('pincode');
                    $DeliveryCharges->delivery_duration=$this->request->getData('delivery_duration');
                    $DeliveryCharges->deliver=$this->request->getData('deliver');
                    $DeliveryCharges->city_id=$pincode->city_id;
                    $DeliveryCharges->state_id=$pincode->state_id;
                    //$DeliveryCharges->pincode_id=$pincode->id;
                    //pr($DeliveryCharges);
                   $DeliveryChargeData= $this->Pincodes->DeliveryCharges->save($DeliveryCharges);
                    
					$query1 = $this->Pincodes->DeliveryCharges->query();
					$query1->update()
						->set(['city_id' =>$pincode->city_id,'state_id' =>$pincode->state_id])
						->where(['id' =>$DeliveryChargeData->id])
						->execute();
						
                        $this->Flash->success(__('The pincode has been saved.'));
                        return $this->redirect(['action' => 'index']);
                    
                }
                $this->Flash->success(__('The pincode has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pincode could not be saved. Please, try again.'));
        }
        $states = $this->Pincodes->States->find('list');
        $cities = $this->Pincodes->Cities->find('list');
        $this->set(compact('pincode', 'states', 'cities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pincode id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->layout('index_layout');
        $pincode = $this->Pincodes->get($id, [
            'contain' => ['DeliveryCharges','Cities','States']
        ]);
        //pr($pincode);exit;
        if ($this->request->is(['patch', 'post', 'put'])) {
            //pr($this->request->getData());
            $pincode = $this->Pincodes->patchEntity($pincode, $this->request->getData());
            //pr($pincode);exit;
            if ($this->Pincodes->save($pincode)) {
                $this->Flash->success(__('The pincode has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pincode could not be saved. Please, try again.'));
        }
        $states = $this->Pincodes->States->find('list')->where(['country_id'=>'1']);
        //pr($states->toArray());exit;
        $cities = $this->Pincodes->Cities->find('list');
        $this->set(compact('pincode', 'states', 'cities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pincode id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pincode = $this->Pincodes->get($id);
        $pincode->is_deleted=1;
        if ($this->Pincodes->save($pincode)) {
            $this->Flash->success(__('The pincode is made deactive.'));
        } else {
            $this->Flash->error(__('The pincode is not made deactive'));
        }

        return $this->redirect(['action' => 'index']);
    }
     public function delete1($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pincode = $this->Pincodes->get($id);
        $pincode->is_deleted=0;
        if ($this->Pincodes->save($pincode)) {
            $this->Flash->success(__('The pincode is made active.'));
        } else {
            $this->Flash->error(__('The pincode is not made active'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
