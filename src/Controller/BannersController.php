<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Banners Controller
 *
 * @property \App\Model\Table\BannersTable $Banners
 *
 * @method \App\Model\Entity\Banner[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BannersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $banners = $this->paginate($this->Banners);

        $this->set(compact('banners'));
    }

    /**
     * View method
     *
     * @param string|null $id Banner id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $banner = $this->Banners->get($id, [
            'contain' => []
        ]);

        $this->set('banner', $banner);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$this->viewBuilder()->layout('index_layout');
        $banner = $this->Banners->newEntity();
        if ($this->request->is('post')) {
			$file = $this->request->data['image'];
			$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = uniqid();
            $img_name= $setNewFileName.'.'.$ext;
			
            $banner = $this->Banners->patchEntity($banner, $this->request->getData());
			if(!empty($file['name'])){
				$banner->image=$img_name;
			}
			//pr($banner); exit;
			 
            if($this->Banners->save($banner)) {
				if(in_array($ext, $arr_ext)) {
                         $destination_url = WWW_ROOT . 'img/temp/'.$img_name;
                        if($ext=='png'){
                          $image = imagecreatefrompng($file['tmp_name']);
                        }else{
                          $image = imagecreatefromjpeg($file['tmp_name']);
                        }
                        imagejpeg($image, $destination_url,95);
                        $keyname1 = 'banners/'.$img_name;
                        $this->AwsFile->putObjectFile($keyname1,$destination_url,$file['type']);
            
                }
                $this->Flash->success(__('The banner has been saved.'));
				 return $this->redirect(['action' => 'add']); 
               // return $this->redirect(['action' => 'index','Controller'=>'Banners']);
				
            }
            $this->Flash->error(__('The banner could not be saved. Please, try again.'));
        }
		
		$items = $this->Banners->Items->find('list')->contain(['ItemVariations']);
		$items->Matching('ItemVariations', function($q) {
	                    return $q->where(['ItemVariations.ready_to_sale' =>'Yes']);
	                });
		$Banners=$this->Banners->find()->contain(['Items']);		
        $this->set(compact('banner','items','Banners'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Banner id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$this->viewBuilder()->layout('index_layout');
        $banner = $this->Banners->get($id, [
            'contain' => []
        ]);
		$old_image=$banner->image;
        if ($this->request->is(['patch', 'post', 'put'])) {
			$file = $this->request->data['image'];
			$ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
            $arr_ext = array('jpg', 'jpeg', 'png'); //set allowed extensions
            $setNewFileName = uniqid();
            $img_name= $setNewFileName.'.'.$ext;
            $banner = $this->Banners->patchEntity($banner, $this->request->getData());
			if(!empty($file['name'])){
				$banner->image=$img_name;
			}else{
				$banner->image=$old_image;
			}
            if ($this->Banners->save($banner)) {
				
				if(in_array($ext, $arr_ext)) {
                         $destination_url = WWW_ROOT . 'img/temp/'.$img_name;
                        if($ext=='png'){
                          $image = imagecreatefrompng($file['tmp_name']);
                        }else{
                          $image = imagecreatefromjpeg($file['tmp_name']);
                        }
                        imagejpeg($image, $destination_url, 95);
                        $keyname1 = 'banners/'.$img_name;
                        $this->AwsFile->putObjectFile($keyname1,$destination_url,$file['type']);
            
                }
				
                $this->Flash->success(__('The banner has been saved.'));

                return $this->redirect(['action' => 'add']); 
            }
            $this->Flash->error(__('The banner could not be saved. Please, try again.'));
        }
		$items = $this->Banners->Items->find('list');
        $this->set(compact('banner','items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Banner id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $banner = $this->Banners->get($id);
        if ($this->Banners->delete($banner)) {
            $this->Flash->success(__('The banner has been deleted.'));
        } else {
            $this->Flash->error(__('The banner could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
