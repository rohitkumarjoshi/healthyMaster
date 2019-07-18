<style>
.table>thead>tr>th{
	font-size:13px !important;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense "></i> CUSTOMERS
					</span>
				</div>
				<div class="actions">
					<?php echo $this->Html->link('Add new','/Customers/Add',['escape'=>false,'class'=>'btn btn-default']) ?>&nbsp;
					
				</div>
			</div>
			<div class="portlet-body" style="overflow:auto;">
				<table class="table table-condensed table-hover table-bordered" id="main_tble">
					<thead>
						<tr>
							<th>Sr</th>
							<th>Customer ID</th>
							<th>Name</th>
							<th>Mobile</th>
							<th>Email</th>
							<th>Address</th>
							<th>Flat No.</th>
							<th>Apartment</th>
							<th>Landmark</th>
							<th>State</th>
							<th>City</th>
							<th>Pincode</th>
							<th scope="col" class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0;
						foreach ($customers as $customer){
						$i++;
						
						?>
						<tr>
							<td><?= $i ?></td>
							<td><?= $customer->id ?></td>
							<td><?php echo $this->Html->link($customer->name,['controller'=>'Customers','action' => 'customerLedger', $customer->id, 'print'],['target'=>'_blank']); ?></td>
							<td><?= h($customer->mobile) ?></td>
							<td><?= h($customer->email) ?></td>
							<td><?php
							$a=0;
							foreach ($customer->customer_addresses as $customeradd) { $a++;?>
								<label class=" control-label">Address  <?= $a?> : 
							<?php echo $customeradd->house_no.','.$customeradd->address.','.$customeradd->locality.'  ';
							}
						?></td>
							<td><?php
								//foreach ($customer->customer_addresses as $address) {
								echo h(@$customer->customer_addresses[0]->house_no);
							?></td>
							<td><?php
								//foreach ($customer->customer_addresses as $address) {
								echo h(@$customer->customer_addresses[0]->apartment);
							?></td>
							<td><?php
								//foreach ($customer->customer_addresses as $address) {
								echo h(@$customer->customer_addresses[0]->landmark);
							?></td>
							<td><?php
								//foreach ($customer->customer_addresses as $address) {
								echo h(@$customer->customer_addresses[0]->state->state_name);
							?></td>
							<td><?php
								//foreach ($customer->customer_addresses as $address) {
								echo h(@$customer->customer_addresses[0]->city->name);
							?></td>
							<td><?php
								//foreach ($customer->customer_addresses as $address) {
								echo h(@$customer->customer_addresses[0]->pincode);
							?></td>
							<td class="actions">
								<?= $this->Html->link(__('Edit'), ['action' => 'edit', $customer->id]) ?>
								<!-- <?= $this->Html->link(__('View'), ['action' => 'view', $customer->id ]) ?> -->
								<?= $this->Html->link(__('Address'), ['controller'=>'CustomerAddresses', 'action' => 'index', $customer->id ]) ?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
var $rows = $('#main_tble tbody tr');
	$('#search3').on('keyup',function() {
		var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
		var v = $(this).val();
		if(v){ 
			$rows.show().filter(function() {
				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
	
				return !~text.indexOf(val);
			}).hide();
		}else{
			$rows.show();
		}
	});
</script>