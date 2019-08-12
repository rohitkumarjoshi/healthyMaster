<style>
.table>thead>tr>th{
	font-size:12px !important;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">CUSTOMER WALLET REPORT
					</span>
				</div>
				<div class="actions">
					 <?php echo $this->Html->link('Excel',['controller'=>'Customers','action' => 'exportWalletReport'],['target'=>'_blank']); ?>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_1">
					<thead>
						<tr>
							<th>Sr</th>
							<th>Name</th>
							<th>Wallet Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$k=0;
						foreach ($wallet as $data):
							$k++;
						?>
						<tr>
							<td><?= $k ?></td>
							<td>
								<?php 
									$customer_id=$data->customer_id;
									echo $this->Html->link($data->customer->name,['controller'=>'Customers','action' => 'customerWallet', $customer_id],['target'=>'_blank']); ?>
							</td>
							<td><?= h($data->total_add - $data->total_deduct) ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
