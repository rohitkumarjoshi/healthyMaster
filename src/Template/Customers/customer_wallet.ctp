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
					<span class="caption-subject font-purple-intense ">CUSTOMER WALLET DETAILS
					</span>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-condensed table-hover table-bordered" id="main_tble">
					<thead>
						<tr>
							<th>Sr</th>
							<th>Add Amount</th>
							<th>Deduct Amount</th>
							<th>Amount Type</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$k=0;
						foreach ($wallets as $data):
							$k++;
						?>
						<tr>
							<td><?= $k ?></td>
							<td><?= $data->add_amount ?></td>
							<td><?= $data->used_amount ?></td>
							<td><?= $data->amount_type ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
