<?php
namespace App\Controller\Api;
use App\Controller\Api\AppController;
class UsersController extends AppController
{
     public function flash()
	{
		$faq = $this->Users->TermConditions->find()->where(['TermConditions.term_name'=>'faq'])->first();
		$privacy = $this->Users->TermConditions->find()->where(['TermConditions.term_name'=>'privacy'])->first();
		$tcs = $this->Users->TermConditions->find()->where(['TermConditions.term_name'=>'tcs'])->first();
		$aboutus = $this->Users->TermConditions->find()->where(['TermConditions.term_name'=>'aboutus'])->first();
		$company_details = $this->Users->CompanyDetails->find()->first();
		$supplier_areas = $this->Users->SupplierAreas->find()->order(['area_name' => 'ASC']);
		
		$status=true;
		$error="Data found successfully";
		$promo_code_to_be=false;
		$this->set(compact('status', 'error', 'faq', 'privacy', 'tcs', 'aboutus', 'company_details', 'supplier_areas', 'promo_code_to_be'));
		$this->set('_serialize', ['status', 'error', 'faq', 'privacy', 'tcs', 'aboutus', 'company_details', 'supplier_areas', 'promo_code_to_be']);
	}
	public function currentApiVersion()
	{
		$api_version=$this->request->query('api_version');
		$data = $this->Users->ApiVersions->get(1);
		
		$status=true;$error='Data found';
		
		$this->set(compact('status', 'error','data'));
		$this->set('_serialize', ['status', 'error','data']);
	}
}



