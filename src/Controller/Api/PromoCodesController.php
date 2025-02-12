<?php
namespace Cake\View\Helper\TimeHelper;
namespace App\Controller\Api;
use App\Controller\Api\AppController;
use Cake\I18n\Time;
use Cake\ORM\Behavior\TimestampBehavior;
class PromoCodesController extends AppController
{
	public function promoCodeList()
	{
		$ts = Time::now('Asia/Kolkata');
        $current_timestamp = date('Y-m-d H:i:s',strtotime($ts));
		$promo_codes = $this->PromoCodes->find()
		->select(['id','code','title','description'])
		->where(['PromoCodes.valid_from <' =>$current_timestamp, 'PromoCodes.valid_to >' =>$current_timestamp,'PromoCodes.status' => 'Active']);
		
		if(!empty($promo_codes->toArray()))
		{
			$status=true;
			$error="Promo List Found Successfully";			
		}else
		{
			$status=false;
			$promo_codes = [];
			$error="No data found";			
		}
		$this->set(compact('status', 'error', 'promo_codes'));
        $this->set('_serialize', ['status', 'error', 'promo_codes']); 		
	}
	
	
    public function varifyPromoCodes()
    {
		$ts = Time::now('Asia/Kolkata');
        $current_timestamp = date('Y-m-d H:i:s',strtotime($ts));
		$jain_thela_admin_id=$this->request->query('jain_thela_admin_id');
		$promo_code=$this->request->query('promo_code');
		$customer_id=$this->request->query('customer_id');

        $promo_codes = $this->PromoCodes->find()
		->where(['PromoCodes.jain_thela_admin_id'=>$jain_thela_admin_id, 'PromoCodes.valid_from <' =>$current_timestamp, 'PromoCodes.valid_to >' =>$current_timestamp, 'PromoCodes.code'=>$promo_code])->first();
		if(empty($promo_codes))
		{
			$status=false;
			$error="Invalid Promo Code";
			$this->set(compact('status', 'error'));
			$this->set('_serialize', ['status', 'error']); 
        }
		else
		{
			$status=true;
			$error="Verified Successfully";
			$this->set(compact('status', 'error', 'promo_codes'));
			$this->set('_serialize', ['status', 'error', 'promo_codes']); 
        }
    }
}
