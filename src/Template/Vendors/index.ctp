
<div class="row">
	<div class="col-md-12">
		<div class="portlet box grey-cascade">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">VENDORS
					</span>
				</div>
				<div class="actions">
					<?php echo $this->Html->link('Add new','/Vendors/Add',['escape'=>false,'class'=>'btn btn-default']) ?>
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_1">
					<thead>
						<tr>
							<th>Sr</th>
							<th>Vendor Name</th>
							<th>Mobile No.</th>
							<th>Email</th>
							<th>Address</th>
							<th>City</th>
							<th>State</th>
							<th>GST No</th>
							<th width="10%"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;
						foreach ($vendors as $vendor):
						$i++;

						?>
						<tr>
							<td><?= $i ?></td>
							<td><?= @$vendor->name ?></td>
							<td><?= @$vendor->mobile ?></td>
							<td><?= @$vendor->email ?></td>
							<td><?= @$vendor->address ?></td>
							<td><?= @$vendor->city->name ?></td>
							<td><?= @$vendor->state->state_name ?></td>
							<td><?= @$vendor->gst_no ?></td>
							<td class="actions" width="12%">
								 <?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $vendor->id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
								 <?= $this->Html->link(__('<span class="fa fa-plus"> Item</span>'), ['controller'=>'VendorRows', 'action' => 'index', $vendor->id ],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
