<?php

namespace Cake\View\Helper\TimeHelper;
namespace App\Controller\Api;
use App\Controller\Api\AppController;
use Cake\I18n\Time;
use Cake\ORM\Behavior\TimestampBehavior;

class PincodesController extends AppController
{
    public function verify()
	{
		$pincode=$this->request->query('pincode');
		 $pin_codes = $this->Pincodes->find()
		->where(['Pincodes.pincode'=>$pincode])
		->contain(['States','Cities'])
		->first();
		
		if(empty($pin_codes))
		{
			$status=false;
			$error="Data Not Found";
			$this->set(compact('status', 'error'));
			$this->set('_serialize', ['status', 'error']); 
        }
		else
		{
			$status=true;
			$error="Data found";
			$this->set(compact('status', 'error', 'pin_codes'));
			$this->set('_serialize', ['status', 'error', 'pin_codes']); 
        }
		
	}
	
	public function verifyPinCodes()
	{
		$pincode=$this->request->query('pincode'); 
		
        $pin_codes = $this->Pincodes->find()
		->where(['Pincodes.pincode'=>$pincode])
		->contain(['States','Cities'])
		->first();
		
		if(empty($pin_codes))
		{
			$status=false;
			$error="Invalid Pin Code";
			$this->set(compact('status', 'error'));
			$this->set('_serialize', ['status', 'error']); 
        }
		else
		{
			$status=true;
			$error="List found successfully";
			$this->set(compact('status', 'error', 'pin_codes'));
			$this->set('_serialize', ['status', 'error', 'pin_codes']); 
        }
	}
}
