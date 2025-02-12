<?php
namespace App\Controller\Api;
use App\Controller\Api\AppController;
class CustomerAddressesController extends AppController
{
    
    public function state(){
		$States=[];
		$States=$this->CustomerAddresses->States->find()->contain(['Cities']);
	    if($States->toArray()){
			$success = true;
			$message = 'Data found';
		  }else{
			$success = false;
			$message = 'Data not found';
		  }	

		$this->set(['success' => $success,'message'=>$message,'States'=>$States,'_serialize' => ['success','message','States']]); 
		
	  }
	  
    public function addAddress()
    {
		$jain_thela_admin_id=$this->request->data('jain_thela_admin_id');
		$customer_id=$this->request->data('customer_id');
		$name=$this->request->data('name');
		$mobile=$this->request->data('mobile');
		$house_no=$this->request->data('house_no');
		$address=$this->request->data('address');
		$locality=$this->request->data('locality');
		$landmark=$this->request->data('landmark');
		$tag=$this->request->data('tag');
		$pincode=$this->request->data('pincode');
		$address_type=$this->request->data('address_type');
		$city_id=$this->request->data('city_id');
		$state_id=$this->request->data('state_id');
		$customer_address_id=$this->request->data('customer_address_id');
		$apartment_name=$this->request->data('apartment_name');
		$default_address=$this->request->data('default_address');
		//$city='1';
		
		if($tag=='add'){
		   $bydefult=0;
		   if($default_address==1){
				$query = $this->CustomerAddresses->query();
				$result = $query->update()
                    ->set(['default_address' => 0])
                    ->where(['customer_id' => $customer_id])
                    ->execute();
				$bydefult=1;
		   }
		   
		   $defaultAddres=$this->CustomerAddresses->find()->where(['CustomerAddresses.customer_id' => $customer_id,'CustomerAddresses.default_address' => 1])->first();
			if(empty($defaultAddres)){
				$bydefult=1;
			}
			$query = $this->CustomerAddresses->query();
					$query->insert(['customer_id', 'name', 'mobile', 'house_no', 'address', 'locality', 'default_address','landmark','pincode','address_type','city_id','state_id','apartment_name'])
							->values([
							'customer_id' => $customer_id,
							'name' => $name,
							'mobile' => $mobile,
							'house_no' => $house_no,
							'address' => $address,
							'locality' => $locality,
							'landmark'=>$landmark,
							'pincode' =>$pincode,
							'address_type' =>$address_type,
							'city_id'=>$city_id,
							'state_id'=> $state_id,
							'apartment_name'=> $apartment_name,
							'default_address' => $bydefult
							])
					->execute();
			$error="Added Successfully";			
		}
		if($tag=='edit'){
			$query = $this->CustomerAddresses->query();
				$result = $query->update()
                    ->set(['default_address' => 0])
                    ->where(['customer_id' => $customer_id])
                    ->execute();
					
			$query = $this->CustomerAddresses->query();
				$result = $query->update()
                    ->set(['customer_id' => $customer_id,
							'name' => $name,
							'mobile' => $mobile,
							'house_no' => $house_no,
							'address' => $address,
							'locality' => $locality,
							'landmark'=>$landmark,
							'pincode' =>$pincode,
							'city_id'=>$city_id,
							'state_id'=> $state_id,
							'address_type' =>$address_type,
							'apartment_name'=> $apartment_name,
							'default_address' => 1
							])
					->where(['id' => $customer_address_id])
					->execute();
				$error="Address Update Successfully";	
		}
		if($tag=='delete'){
		
			$query = $this->CustomerAddresses->query();
				$result = $query->delete()
					->where(['id' => $customer_address_id])
					->execute();
			$error="Address deleted Successfully";		
		}
		if($tag=='default'){
			$query = $this->CustomerAddresses->query();
				$result = $query->update()
                    ->set(['default_address' => 0])
                    ->where(['customer_id' => $customer_id])
                    ->execute();
					
			$query = $this->CustomerAddresses->query();
				$result = $query->update()
                    ->set(['default_address' => 1])
					->where(['id' => $customer_address_id])
					->execute();
			$error="Address marked selected";		
		}
		
		$customer_addresses=$this->CustomerAddresses->find()
		->where(['customer_id' => $customer_id])
		->order(['default_address' => 'DESC']);
		
		
		$status=true;
		$error="Added Successfully";
        $this->set(compact('status', 'error','customer_addresses'));
        $this->set('_serialize', ['status', 'error', 'customer_addresses']);
    }
	
	public function addressList()
	{
		$customer_id=$this->request->query('customer_id');
		$customer_addresses=$this->CustomerAddresses->find()
		->where(['customer_id' => $customer_id])
		->contain(['States','Cities','Customers'])
		->order(['default_address' => 'DESC']);
		
		if(!empty($customer_addresses->toArray()))
		{
			$status=true;
			$error="Address List found successfully";			
		}
		else{
			$status=false;
			$error="No data found";			
		}

        $this->set(compact('status', 'error','customer_addresses'));
        $this->set('_serialize', ['status', 'error', 'customer_addresses']);		
	}
	public function addressDetails()
	{
		$id=$this->request->query('id');
		$customer_addresses=$this->CustomerAddresses->find()
		->where(['CustomerAddresses.id' => $id])
		->contain(['States','Cities'])->first();
		
		if(!empty($customer_addresses))
		{
			$status=true;
			$error="Address found successfully";			
		}
		else{
			$status=false;
			$error="No data found";			
		}

        $this->set(compact('status', 'error','customer_addresses'));
        $this->set('_serialize', ['status', 'error', 'customer_addresses']);		
	}
	
	
	
}
