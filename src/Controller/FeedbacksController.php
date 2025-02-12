<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Feedbacks Controller
 *
 * @property \App\Model\Table\FeedbacksTable $Feedbacks
 *
 * @method \App\Model\Entity\Feedback[] paginate($object = null, array $settings = [])
 */
class FeedbacksController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */

    public function exportReport()
    {
        $this->viewBuilder()->layout(''); 
          
        $feedbacks=$this->Feedbacks->find()->contain(['Customers'])->order(['Feedbacks.id'=>'DESC']);
        $this->set(compact('feedback','feedbacks'));
    }
    public function report()
    {
        $this->viewBuilder()->layout('index_layout'); 
        $feedback=$this->Feedbacks->newEntity();
          
		$feedbacks=$this->Feedbacks->find()->contain(['Customers'])->order(['Feedbacks.id'=>'DESC']);
		if ($this->request->is('post')) {
            $datas = $this->request->getData();
           
             if(!empty($datas['mobile'])){
                $feedbacks->where(['Feedbacks.mobile ='=> $datas['mobile']]);
            }
            if(!empty($datas['From'])){
                $from_date=date("Y-m-d",strtotime($datas['From']));
                $feedbacks->where(['Feedbacks.created_on >='=> $from_date]);
            }
           
            if(!empty($datas['To'])){ 
                $to_date=date("Y-m-d",strtotime($datas['To']));
                $feedbacks->where(['Feedbacks.created_on <=' => $to_date ]);
            }
        } 
        $this->set(compact('feedback','feedbacks'));
    }

    public function ajaxAutocompleted(){
        $name=$this->request->getData('input'); 
        $searchType=$this->request->getData('searchType');
        if($searchType == 'item_name'){
            $items=$this->Feedbacks->Customers->find()->where(['Customers.name Like'=>''.$name.'%']);
            //pr($items->toArray());exit;
            ?>
                <ul id="item-list" style="width: 90% !important;">
                    <?php foreach($items as $show){ ?>
                        <li onClick="selectAutoCompleted('<?php echo $show->id;?>','<?php echo $show->name;?>')">
                            <?php echo $show->name?>    
                        </li>
                    <?php } ?>
                </ul>
            <?php
        }
        
        exit;  
    }

    public function index()
    {
		$this->viewBuilder()->layout('index_layout'); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');

        $this->paginate = [
            'contain' => ['Customers']
        ];
       // $feedbacks = $this->paginate($this->Feedbacks);
        $feedbacks = $this->Feedbacks->find()->order(['Feedbacks.created_on'=> 'DESC'])->contain(['Customers']);
        $this->set(compact('feedbacks'));
        $this->set('_serialize', ['feedbacks']);
    }

    /**
     * View method
     *
     * @param string|null $id Feedback id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $feedback = $this->Feedbacks->get($id, [
            'contain' => ['Customers']
        ]);
        $this->set('feedback', $feedback);
        $this->set('_serialize', ['feedback']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout'); 
		$jain_thela_admin_id=$this->Auth->User('jain_thela_admin_id');
        $feedback = $this->Feedbacks->newEntity();
        if ($this->request->is('post')) {
            $feedback = $this->Feedbacks->patchEntity($feedback, $this->request->getData());
            $feedback->jain_thela_admin_id=$jain_thela_admin_id;
             if ($this->Feedbacks->save($feedback)) {
                $this->Flash->success(__('The feedback has been saved.'));
                 return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The feedback could not be saved. Please, try again.'));
        }
        $customer_fetchs = $this->Feedbacks->Customers->find('all');
		foreach($customer_fetchs as $customer_fetch){
			$customer_name=$customer_fetch->name;
			$customer_mobile=$customer_fetch->mobile;
			$customers[]= ['value'=>$customer_fetch->id,'text'=>$customer_name." (".$customer_mobile.")"];
		}
        $this->set(compact('feedback', 'customers'));
        $this->set('_serialize', ['feedback']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Feedback id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $feedback = $this->Feedbacks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $feedback = $this->Feedbacks->patchEntity($feedback, $this->request->getData());
            if ($this->Feedbacks->save($feedback)) {
                $this->Flash->success(__('The feedback has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The feedback could not be saved. Please, try again.'));
        }
        $customers = $this->Feedbacks->Customers->find('list', ['limit' => 200]);
        $this->set(compact('feedback', 'customers'));
        $this->set('_serialize', ['feedback']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Feedback id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $feedback = $this->Feedbacks->get($id);
        if ($this->Feedbacks->delete($feedback)) {
            $this->Flash->success(__('The feedback has been deleted.'));
        } else {
            $this->Flash->error(__('The feedback could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
