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
					<?php echo $this->Html->link('Add new','/Customers/Add',['escape'=>false,'class'=>'btn btn-default ']) ?>&nbsp;
					<input id="search3"  class="form-control input-sm pull-right" type="text" placeholder="Search"  style="width: 200px;">
					
				</div>
			</div>
			<div class="portlet-body" style="overflow:auto;">
				<!--  <form method="post">
                        <table width="50%" class="table table-condensed">
                    <tbody>
                        <tr>
                            <td width="5%">
                                <label class=" control-label">Mobile</label>
                                <input type="number" name="mobile" class="form-control input-sm">
                            </td>
                            <td width="5%">
                                <label>From</label>
                                <input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From"  data-date-format="dd-mm-yyyy">
                            </td>   
                            <td width="5%">
                                <label>To</label>
                                <input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To"   data-date-format="dd-mm-yyyy" >
                            </td>
                            <td width="10%">
                                <button type="submit" class="btn btn-success btn-sm" style="margin-top: 23px !important;"><i class="fa fa-filter"></i> Filter</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form> -->
				<table class="table table-condensed table-hover table-bordered" id="main_tble">
					<thead>
						<tr>
							<th> Sr</th>
							<th> Customer ID</th>
							<th> Name</th>
							<th> Mobile</th>
							<th> Email</th>
							<th> Address</th>
							<th> Flat No.</th>
							<th> Apartment</th>
							<th> Landmark</th>
							<th> State</th>
							<th> City</th>
							<th> Pincode</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody id="main_tbody">
						<?php $i=0;
						foreach ($customers as $customer){
						$i++;
						
						?>
						<tr class="main_tr">
							<td><?= $i ?></td>
							<td><?= $customer->id ?></td>
							<td><?=$customer->name ?></td>
							<td><?php echo $this->Html->link($customer->mobile,['controller'=>'Customers','action' => 'customerLedger', $customer->id, 'print'],['target'=>'_blank']); ?></td>
							<td><?= h(@$customer->email) ?></td>
							<td><?php
							echo @$customer->customer_addresses[0]->house_no.','.@$customer->customer_addresses[0]->address.','.@$customer->customer_addresses[0]->locality
						?></td>
							<td><?php
								//foreach ($customer->customer_addresses as $address) {
								echo h(@$customer->customer_addresses[0]->house_no);
							?></td>
							<td><?php
								//foreach ($customer->customer_addresses as $address) {
								echo h(@$customer->customer_addresses[0]->apartment_name);
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
				<div class="paginator">
			        <ul class="pagination">
			            <?= $this->Paginator->first('<< ' . __('first')) ?>
			            <?= $this->Paginator->prev('< ' . __('previous')) ?>
			            <?= $this->Paginator->numbers() ?>
			            <?= $this->Paginator->next(__('next') . ' >') ?>
			            <?= $this->Paginator->last(__('last') . ' >>') ?>
			        </ul>
			        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
			    </div>
			</div>

		</div>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
var rows = $("#main_tbody tr.main_tr");
$("#search3").on("keyup",function() {
          
    var val = $.trim($(this).val()).replace(/ +/g, " ").toLowerCase();
    var v = $(this).val();
    
    if(v){
        rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, " ").toLowerCase();

            return !~text.indexOf(val);
        }).hide();
    }else{
        rows.show();
    }
});
</script>