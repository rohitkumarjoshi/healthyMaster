<?php
namespace App\Controller\Api;
use App\Controller\Api\AppController;
class WalletsController extends AppController
{
    public function walletDetails()
    {
		$this->loadModel('CustomerWallets'); 
		$customer_id=$this->request->query('customer_id');
		$wallet_details = $this->CustomerWallets->find()
		->where(['CustomerWallets.customer_id'=>$customer_id])
		->order(['CustomerWallets.id'=>'DESC'])
		->autoFields(true);
		
		$CustomerWallets=$this->CustomerWallets->find()->where(['CustomerWallets.customer_id'=>$customer_id]);
		$CustomerWallets->select(['customer_id','addAmt' => $CustomerWallets->func()->sum('CustomerWallets.add_amount'),'dedutAmt' => $CustomerWallets->func()->sum('CustomerWallets.used_amount')])
		->group('CustomerWallets.customer_id')
		->toArray();
		
		
		
		$CustomerWallts=$CustomerWallets->first();
		
		if(empty($CustomerWallts))
		{ 
			$wallet_balance=0;
		}
		else
		{
			$wallet_balance=$CustomerWallts->addAmt-$CustomerWallts->dedutAmt;
		}
		
		/* $orderDatas->select(['customer_id','amount','total' => $q->func()->sum('OrderDetails.amount')])->where(['OrderDetails.status IS NULL'])->group('OrderDetails.order_id');
		->first(); */
			
		/* 
		foreach($wallet_details as $plan_data){
			if(!$plan_data->plan){
				$plan_data->plan=(object)[];
			}
			
			if(empty($plan_data->plan_id))
			{
				$plan_data->transaction_type='Deduct';
            }
			else if(!empty($plan_data->plan_id)){
				$plan_data->transaction_type='Added';
			}
			$plan_data->create_date=date('D M j, Y H:i a', strtotime($plan_data->updated_on));
		}
        $query = $this->Wallets->find();
		$totalInCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['order_id' => '0']),
				$query->newExpr()->add(['advance']),
				'integer'
			);
		$totalOutCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['plan_id' => '0']),
				$query->newExpr()->add(['consumed']),
				'integer'
			);
			$query->select([
			'total_in' => $query->func()->sum($totalInCase),
			'total_out' => $query->func()->sum($totalOutCase),'id','customer_id'
		])
		->where(['Wallets.customer_id' => $customer_id])
		->group('customer_id')
		->autoFields(true); */
	
				
		
		
		if(empty($wallet_details->toArray()))
		{
			$status=false;
			$error="No Transaction details";
			$this->set(compact('status', 'error'));
			$this->set('_serialize', ['status', 'error']);
		}
		else
		{
			$status=true;
			$error="";
			$this->set(compact('status', 'error','wallet_details', 'wallet_balance'));
			$this->set('_serialize', ['status', 'error','wallet_details', 'wallet_balance']);
		}
		
    }
	public function addMoney()
    {
		$customer_id=$this->request->data('customer_id');
		$plan_id=$this->request->data('plan_id');
		$advance=$this->request->data('advance');
		$order_no=$this->request->data('order_no');
		
		
			$query = $this->Wallets->query();
					$query->insert(['plan_id', 'advance', 'customer_id', 'order_no'])
							->values([
							'plan_id' => $plan_id,
							'advance' => $advance,
							'customer_id' => $customer_id,
							'order_no' => $order_no
							])
					->execute();
		
		$query = $this->Wallets->find();
		$totalInCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['order_id' => '0']),
				$query->newExpr()->add(['advance']),
				'integer'
			);
		$totalOutCase = $query->newExpr()
			->addCase(
				$query->newExpr()->add(['plan_id' => '0']),
				$query->newExpr()->add(['consumed']),
				'integer'
			);
			$query->select([
			'total_in' => $query->func()->sum($totalInCase),
			'total_out' => $query->func()->sum($totalOutCase),'id','customer_id'
		])
		->where(['Wallets.customer_id' => $customer_id])
		->group('customer_id')
		->autoFields(true);
	
		if(empty($query->toArray()))
		{
			$wallet_balance=0;
		}
		else
		{
			foreach($query as $fetch_query)
		      {
			$advance=$fetch_query->total_in;
			$consumed=$fetch_query->total_out;
			$wallet_balance=$advance-$consumed;
		      }
		}		
		
		$status=true;
		$error="Thank You for add money with Jainthela.";
		$this->set(compact('status', 'error', 'wallet_balance'));
		$this->set('_serialize', ['status', 'error','wallet_balance']);		
    }

}
