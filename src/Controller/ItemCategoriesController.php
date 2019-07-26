<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemCategories Controller
 *
 * @property \App\Model\Table\ItemCategoriesTable $ItemCategories
 *
 * @method \App\Model\Entity\ItemCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */

    public function topSelling()
    {
        $this->viewBuilder()->layout('index_layout');
       $recently_boughts=$this->ItemCategories->Items->ItemLedgers->find()
                        ->select(['Count'=>'count(ItemLedgers.item_id)','ItemCategories.name','Items.id','Items.name','ItemVariations.quantity_variation','Items.item_code','ItemLedgers.rate'])
                        ->where(['status'=>'out'])
                        ->group(['ItemLedgers.item_id','ItemLedgers.item_variation_id'])
                        ->contain(['Items'=>['ItemCategories'],'ItemVariations']);
                        //->order(['count']);

            
           //pr($recently_boughts->toArray());exit;
        if ($this->request->is('post')) {
            $datas = $this->request->getData();
           
            if(!empty($datas['From'])){
                $from_date=date("Y-m-d",strtotime($datas['From']));
                $recently_boughts->where(['ItemLedgers.created_on >='=> $from_date]);
            }
             if(!empty($datas['item_id'])){
                $recently_boughts->where(['ItemLedgers.item_id >='=>$datas['item_id']]);
            }
            if(!empty($datas['To'])){ 
                $to_date=date("Y-m-d",strtotime($datas['To']));
                $recently_boughts->where(['ItemLedgers.created_on <=' => $to_date ]);
            }
             
        }
        $items = $this->ItemCategories->Items->find('list');
        $this->set(compact('recently_boughts','items'));
    }

   	public function index($id=null)
    {
      $city_id=$this->Auth->User('city_id');
	  $this->viewBuilder()->layout('index_layout');
	  
		if(!$id){
			$itemCategory1 = $this->ItemCategories->newEntity();
		}else{
			$itemCategory1 = $this->ItemCategories->get($id, [
				'contain' => []
			]);
		}
	
		 if ($this->request->is(['patch', 'post', 'put'])) {
			 //pr($this->request->data); exit;
				$file = $this->request->data['image'];
				$file_name=$file['name'];           
				$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
				$arr_ext = array('jpg', 'jpeg','png','JPEG'); //set allowed extensions
				$setNewFileName = uniqid();
				$img_name= $setNewFileName.'.'.$ext;
				
				$itemCategory = $this->ItemCategories->patchEntity($itemCategory1, $this->request->getData());
				
				if(!empty($file_name)){
					$itemCategory->image=$img_name;
				}if(empty($file_name)){
					
				}
			
           
            if($this->ItemCategories->save($itemCategory)) {
				
				if(in_array($ext, $arr_ext)) {
                         $destination_url = WWW_ROOT . 'img/temp/'.$img_name;
                        if($ext=='png'){
                        $image = imagecreatefrompng($file['tmp_name']);
                        }else{
                        $image = imagecreatefromjpeg($file['tmp_name']);
                        }
                        imagejpeg($image, $destination_url, 95);
                        $keyname1 = 'itemcategories/'.$img_name;
                        $this->AwsFile->putObjectFile($keyname1,$destination_url,$file['type']);
                        
                    //move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/item_images/'.$img_name);
                  }
				  
                $this->Flash->success(__('The item category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item category could not be saved. Please, try again.'));
        }
		
        $itemCategories = $this->ItemCategories->find()->where(['ItemCategories.is_deleted'=>0])->contain(['ParentItemCategories']);
		//pr($itemCategories->toArray()); exit;
		$itemParent = $this->ItemCategories->find('list')->where(['parent_id IS'=>NULL]);

        $this->set(compact('itemCategory1', 'itemCategories','itemParent'));
		$this->set('_serialize', ['itemCategory1']);
        $this->set('_serialize', ['itemCategories']);
    }

    /**
     * View method
     *
     * @param string|null $id Item Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemCategory = $this->ItemCategories->get($id, [
            'contain' => []
        ]);

        $this->set('itemCategory', $itemCategory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemCategory = $this->ItemCategories->newEntity();
        if ($this->request->is('post')) {
            $itemCategory = $this->ItemCategories->patchEntity($itemCategory, $this->request->getData());
            if ($this->ItemCategories->save($itemCategory)) {
                $this->Flash->success(__('The item category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item category could not be saved. Please, try again.'));
        }
        $banners = $this->ItemCategories->Banners->find('list', ['limit' => 200]);
        $homeScreens = $this->ItemCategories->HomeScreens->find('list', ['limit' => 200]);
        $carts = $this->ItemCategories->Carts->find('list', ['limit' => 200]);
        $wishlists = $this->ItemCategories->Wishlists->find('list', ['limit' => 200]);
        $this->set(compact('itemCategory', 'banners', 'homeScreens', 'carts', 'wishlists'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemCategory = $this->ItemCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemCategory = $this->ItemCategories->patchEntity($itemCategory, $this->request->getData());
            if ($this->ItemCategories->save($itemCategory)) {
                $this->Flash->success(__('The item category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item category could not be saved. Please, try again.'));
        }
        $banners = $this->ItemCategories->Banners->find('list', ['limit' => 200]);
        $homeScreens = $this->ItemCategories->HomeScreens->find('list', ['limit' => 200]);
        $carts = $this->ItemCategories->Carts->find('list', ['limit' => 200]);
        $wishlists = $this->ItemCategories->Wishlists->find('list', ['limit' => 200]);
        $this->set(compact('itemCategory', 'banners', 'homeScreens', 'carts', 'wishlists'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemCategory = $this->ItemCategories->get($id);
        $itemCategory->is_deleted=1;
        if ($this->ItemCategories->save($itemCategory)) {
            $this->Flash->success(__('The item category is made deactive.'));
        } else {
            $this->Flash->error(__('The item category is not made deactive'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function delete1($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemCategory = $this->ItemCategories->get($id);
        $itemCategory->is_deleted=0;
        if ($this->ItemCategories->save($itemCategory)) {
            $this->Flash->success(__('The item category is made active.'));
        } else {
            $this->Flash->error(__('The item category is not made active'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
