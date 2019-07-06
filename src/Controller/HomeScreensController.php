<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * HomeScreens Controller
 *
 * @property \App\Model\Table\HomeScreensTable $HomeScreens
 *
 * @method \App\Model\Entity\HomeScreen[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HomeScreensController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ItemCategories', 'Items']
        ];
        $homeScreens = $this->paginate($this->HomeScreens);

        $this->set(compact('homeScreens'));
    }

    /**
     * View method
     *
     * @param string|null $id Home Screen id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $homeScreen = $this->HomeScreens->get($id, [
            'contain' => ['Categories', 'Items']
        ]);

        $this->set('homeScreen', $homeScreen);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $homeScreen = $this->HomeScreens->newEntity();
        if ($this->request->is('post')) {
			$file = $this->request->data['image'];
			$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = uniqid();
            $img_name= $setNewFileName.'.'.$ext;
			
			 $homeScreen = $this->HomeScreens->patchEntity($homeScreen, $this->request->getData());
			 
			if(!empty($file['name'])){
				$homeScreen->image=$img_name;
			}
          // pr($homeScreen); exit;
            if ($this->HomeScreens->save($homeScreen)) {
				if(in_array($ext, $arr_ext)) {
                         $destination_url = WWW_ROOT . 'img/temp/'.$img_name;
                        if($ext=='png'){
                        $image = imagecreatefrompng($file['tmp_name']);
                        }else{
                        $image = imagecreatefromjpeg($file['tmp_name']);
                        }
                        imagejpeg($image, $destination_url, 10);
                        $keyname1 = 'home_screen/'.$img_name;
                        $this->AwsFile->putObjectFile($keyname1,$destination_url,$file['type']);
            
                    //move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/item_images/'.$img_name);
                }
				  
                $this->Flash->success(__('The home screen has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The home screen could not be saved. Please, try again.'));
        }
        $categories = $this->HomeScreens->ItemCategories->find('list');
		$HomeScreens=$this->HomeScreens->find()->contain(['ItemCategories','Items']);
		//pr($HomeScreens->toArray()); exit;
        $items = $this->HomeScreens->Items->find('list')->contain(['ItemVariations']);
		$items->Matching('ItemVariations', function($q) {
	                    return $q->where(['ItemVariations.ready_to_sale' =>'Yes']);
	                });
					
        $this->set(compact('homeScreen', 'categories', 'items','HomeScreens'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Home Screen id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $homeScreen = $this->HomeScreens->get($id, [
            'contain' => []
        ]);
		$old_image=$homeScreen->image;
        if ($this->request->is(['patch', 'post', 'put'])) {
			$file = $this->request->data['image'];
			$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = uniqid();
            $img_name= $setNewFileName.'.'.$ext;
			
            $homeScreen = $this->HomeScreens->patchEntity($homeScreen, $this->request->getData());
			if(!empty($file['name'])){
				$homeScreen->image=$img_name;
			}else{
				$homeScreen->image=$old_image;
			}
			
            if ($this->HomeScreens->save($homeScreen)) {
				if(in_array($ext, $arr_ext)) {
                         $destination_url = WWW_ROOT . 'img/temp/'.$img_name;
                        if($ext=='png'){
                        $image = imagecreatefrompng($file['tmp_name']);
                        }else{
                        $image = imagecreatefromjpeg($file['tmp_name']);
                        }
                        imagejpeg($image, $destination_url, 10);
                        $keyname1 = 'home_screen/'.$img_name;
                        $this->AwsFile->putObjectFile($keyname1,$destination_url,$file['type']);
            
                    //move_uploaded_file($file['tmp_name'], WWW_ROOT . 'img/item_images/'.$img_name);
                }
				
                $this->Flash->success(__('The home screen has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The home screen could not be saved. Please, try again.'));
        }
        $categories = $this->HomeScreens->ItemCategories->find('list');
        $items = $this->HomeScreens->Items->find('list');
        $this->set(compact('homeScreen', 'categories', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Home Screen id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $homeScreen = $this->HomeScreens->get($id);
        if ($this->HomeScreens->delete($homeScreen)) {
            $this->Flash->success(__('The home screen has been deleted.'));
        } else {
            $this->Flash->error(__('The home screen could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
