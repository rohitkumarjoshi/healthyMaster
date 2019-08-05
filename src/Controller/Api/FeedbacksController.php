<?php
namespace App\Controller\Api;
use App\Controller\Api\AppController;
class FeedbacksController extends AppController
{

	
    public function feedbackform()
    {
		$jain_thela_admin_id=1;
		$customer_id=$this->request->data('customer_id');
		$name=$this->request->data('name');
		$mobile=$this->request->data('mobile');
		$email=$this->request->data('email');
		$comments=$this->request->data('comments');
		$quality_exp=$this->request->data('quality_exp');
		$deliver_exp=$this->request->data('deliver_exp');
		$overall_exp=$this->request->data('overall_exp');
		//pr($quality_exp);exit;
		
			$query = $this->Feedbacks->query();
					$query->insert(['jain_thela_admin_id', 'customer_id', 'name', 'mobile', 'email', 'comments','quality_exp','deliver_exp','overall_exp'])
							->values([
							'jain_thela_admin_id' => $jain_thela_admin_id,
							'customer_id' => $customer_id,
							'name' => $name,
							'mobile' => $mobile,
							'email' => $email,
							'comments' => $comments,
							'quality_exp' => $quality_exp,
							'deliver_exp' => $deliver_exp,
							'overall_exp' => $overall_exp,
							])
					->execute();
		$status=true;
		$error="Thank You, Your Query Updated, we will contact soon.";
        $this->set(compact('status', 'error'));
        $this->set('_serialize', ['status', 'error']);
    }
}
