<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PromoCodes Controller
 *
 * @property \App\Model\Table\PromoCodesTable $PromoCodes
 *
 * @method \App\Model\Entity\PromoCode[] paginate($object = null, array $settings = [])
 */
class PromoCodesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
     public function check()
    {
        //$items='0';
         $code=$this->request->getData('input'); 
         //alert($mobile);
            if($this->PromoCodes->exists(['code'=>$code]))
            {
                echo"1";
            }
    
        exit;  
    }
    public function index()
    {
       $this->viewBuilder()->layout('index_layout');
    	$promoCode = $this->PromoCodes->newEntity();
        
        $data=$this->request->getData();

        $from=$this->request->getData('valid_from');
        $to=$this->request->getData('valid_to');
        $data['valid_from']=date('Y-m-d',strtotime($from));
        $data['valid_to']=date('Y-m-d',strtotime($to));
        if ($this->request->is(['patch', 'post', 'put'])) {

            $promoCode = $this->PromoCodes->patchEntity($promoCode, $data);
			$promoCode->jain_thela_admin_id=1;
			$promoCode->status='Active';
			
		
			
            if ($this->PromoCodes->save($promoCode)) {
                $this->Flash->success(__('The promo code has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The promo code could not be saved. Please, try again.'));
        }
        $promoCodes = $this->paginate($this->PromoCodes->find());
        // foreach ($promoCodes as $promo) {
        //     $valid_to=$promo->valid_to;
        //     $today=date('Y-m-d');
        //     if($valid_to == $today)
        //     {
        //         $promoCodes->status="Deactive";
        //         $this->PromoCodes->save($promoCodes);
        //     }
        // }
        $itemCategories = $this->PromoCodes->ItemCategories->find('list');
        $items = $this->PromoCodes->Items->find('list');
        $this->set(compact('promoCode', 'promoCodes', 'itemCategories','items'));
		$this->set('_serialize', ['promoCode']);
        $this->set('_serialize', ['promoCodes']);
    }
	

     public function promoCodeReport()
    {
        $this->viewBuilder()->layout('index_layout');
        $jain_thela_admin_id=1;
        $promoCodes = $this->PromoCodes->find()
        ->contain(['Items', 'ItemCategories'])
        ->leftJoinWith('Items')
        ->leftJoinWith('ItemCategories')
        ->order(['PromoCodes.id'=>'DESC']);
       
        if ($this->request->is('post')) {
            $datas = $this->request->getData();

            if(!empty($datas['code']))
            {  //pr($promoCodes->toArray());
                $promoCodes->where(['PromoCodes.code'=>$datas['code']]);
                
				$code = $datas['code'];
            }
             if(!empty($datas['status']))
            {
                $status= $datas['status'];
                $promoCodes->where(['PromoCodes.status'=>$status]);
            } 
             if(!empty($datas['item_id']))
            {
                $promoCodes->where(['PromoCodes.item_id'=>$datas['item_id']]);
				$item_id = $datas['item_id'];
            }
           if(!empty($datas['From'])){
                $from_date=date("Y-m-d",strtotime($datas['From']));
                $promoCodes->where(['PromoCodes.valid_from >='=> $from_date]);
            }
            if(!empty($datas['To'])){ 
                $to_date=date("Y-m-d",strtotime($datas['To']));
                $promoCodes->where(['PromoCodes.valid_from <=' => $to_date ]);
            }
        }
        
        //pr($promoCodes->toArray());exit;
        $itemCategories = $this->PromoCodes->ItemCategories->find('list');
        $items = $this->PromoCodes->Items->find('list');
        $this->set(compact('promoCode', 'promoCodes', 'itemCategories','items','code','item_id','from_date','to_date'));
        $this->set('_serialize', ['promoCode']);
        $this->set('_serialize', ['promoCodes','code','item_id','from_date','to_date','status']);
    }

       public function exportPromoReport()
    {
        $this->viewBuilder()->layout('');
        $jain_thela_admin_id=1;
        $promoCodes = $this->PromoCodes->find()
        ->contain(['Items', 'ItemCategories'])
        ->leftJoinWith('Items')
        ->leftJoinWith('ItemCategories')
        ->order(['PromoCodes.id'=>'DESC']);
         $this->set(compact('promoCode', 'promoCodes', 'itemCategories','items','code','item_id','from_date','to_date'));
    }
       

	public function ajaxStatusPromoCode($status,$status_id)
    {
		        $query=$this->PromoCodes->query();
				$result = $query->update()
                    ->set(['status' => $status])
                    ->where(['id' => $status_id])
                    ->execute();
    }

    /**
     * View method
     *
     * @param string|null $id Promo Code id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $promoCode = $this->PromoCodes->get($id, [
            'contain' => ['ItemCategories', 'JainThelaAdmins', 'Orders']
        ]);

        $this->set('promoCode', $promoCode);
        $this->set('_serialize', ['promoCode']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $promoCode = $this->PromoCodes->newEntity();
        if ($this->request->is('post')) {
            $promoCode = $this->PromoCodes->patchEntity($promoCode, $this->request->getData());
		
            if ($this->PromoCodes->save($promoCode)) {
                $this->Flash->success(__('The promo code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
           
            $this->Flash->error(__('The promo code could not be saved. Please, try again.'));
        }
        $itemCategories = $this->PromoCodes->ItemCategories->find('list', ['limit' => 200]);
        $jainThelaAdmins = $this->PromoCodes->JainThelaAdmins->find('list', ['limit' => 200]);
        $this->set(compact('promoCode', 'itemCategories', 'jainThelaAdmins'));
        $this->set('_serialize', ['promoCode']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Promo Code id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->layout('index_layout');
        $promoCode = $this->PromoCodes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $promoCode = $this->PromoCodes->patchEntity($promoCode, $this->request->getData());
            if ($this->PromoCodes->save($promoCode)) {
                $this->Flash->success(__('The promo code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The promo code could not be saved. Please, try again.'));
        }
        $itemCategories = $this->PromoCodes->ItemCategories->find('list', ['limit' => 200]);
        $items = $this->PromoCodes->Items->find('list', ['limit' => 200]);
        $jainThelaAdmins = $this->PromoCodes->JainThelaAdmins->find('list', ['limit' => 200]);
        $this->set(compact('promoCode', 'itemCategories', 'jainThelaAdmins','items'));
        $this->set('_serialize', ['promoCode']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Promo Code id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $promoCode = $this->PromoCodes->get($id);
        if ($this->PromoCodes->delete($promoCode)) {
            $this->Flash->success(__('The promo code has been deleted.'));
        } else {
            $this->Flash->error(__('The promo code could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
