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
					<span class="caption-subject font-purple-intense ">TOP SELLING ITEM REPORT
					</span>
				</div>
			</div>
			<div class="portlet-body">
				<form method="post">
						<table width="50%" class="table table-condensed">
					<tbody>
						<tr>
							<td width="5%">
								<label>From</label>
								<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From"  data-date-format="dd-mm-yyyy" autocomplete="false">
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
				</form>
				<table class="table table-condensed table-hover table-bordered" id="main_tble">
					<thead>
						<tr>
							<th>Sr</th>
							<th>Category</th>
							<th>Item Code</th>
							<th>Item ID</th>
							<th>Item</th>
							<th>Variation</th>
							<th>Item Code</th>
							<th>Sales</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php
						
						$i=0;
							foreach ($recently_boughts as $top) {
								 $count=$top->Count;
								 if($count > 50)
                				{
									$i++;
						?>
						<tr>
							<td><?= $i ?></td>
							<td><?= $top->item->item_category->name?></td>
							<td><?= $top->item->item_code ?></td>
							<td><?= $top->item->id ?></td>
							<td><?= $top->item->name ?></td>
							<td><?= $top->item_variation->quantity_variation ?></td>
							<td><?= $top->item->item_code ?></td>
							<td><?= $top->Count ?> Times</td>
							<td><?= $top->rate ?></td>
						</tr>
					<?php }} ?>
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