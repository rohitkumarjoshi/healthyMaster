<div class="row">
				<div class="col-md-12">
					<!-- BEGIN EXAMPLE TABLE PORTLET-->
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="font-purple-intense"></i>
								<span class="caption-subject font-purple-intense ">Customers List
								</span>
							</div>
							<div class="actions">
								<?php echo $this->Html->link('Add New','/Customers/Add',['escape'=>false,'class'=>'btn btn-default']) ?>&nbsp;
							</div>
						</div>
						<div class="portlet-body" style="overflow: auto;">
							<table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_1">
							<thead>
								<tr>
									<th> Sr</th>
									<th>ID</th>
									<th> Name</th>
									<th> Mobile</th>
									<th> Email</th>
									<!-- <th> Address</th> -->
									<th> Flat No.</th>
									<th> Apartment</th>
									<th> Landmark</th>
									<th> State</th>
									<th> City</th>
									<th> Pincode</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php $i=0;
						foreach ($customers as $customer){
						$i++;
						
						?>
						<tr class="odd gradeX">
							<td><?= $i ?></td>
							<td><?= $customer->id ?></td>
							<td><?=$customer->name ?></td>
							<td><?php echo $this->Html->link($customer->mobile,['controller'=>'Customers','action' => 'customerLedger', $customer->id, 'print'],['target'=>'_blank']); ?></td>
							<td><?= h(@$customer->email) ?></td>
							<!-- <td><?php
							echo @$customer->customer_addresses[0]->house_no.','.@$customer->customer_addresses[0]->address.','.@$customer->customer_addresses[0]->locality
							?></td> -->
							<td><?php
							echo @$customer->customer_addresses[0]->house_no;
							?></td>
							<td><?php
								//foreach ($customer->customer_addresses as $address) {
								echo @$customer->customer_addresses[0]->apartment_name;
							?></td>
							<td><?php
								//foreach ($customer->customer_addresses as $address) {
								echo @$customer->customer_addresses[0]->landmark;
							?></td>
							<td><?php
								//foreach ($customer->customer_addresses as $address) {
								echo @$customer->customer_addresses[0]->state->state_name;
							?></td>
							<td><?php
								//foreach ($customer->customer_addresses as $address) {
								echo @$customer->customer_addresses[0]->city->name;
							?></td>
							<td><?php
								//foreach ($customer->customer_addresses as $address) {
								echo @$customer->customer_addresses[0]->pincode;
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
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>
			
	
