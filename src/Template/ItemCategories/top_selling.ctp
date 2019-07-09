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
				<table class="table table-condensed table-hover table-bordered" id="main_tble">
					<thead>
						<tr>
							<th>Sr</th>
							<th>Category</th>
							<th>Item</th>
							<th>Variation</th>
							<th>Item Code</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;
							foreach ($recently_bought as $top) {
								$i++;
						?>
						<tr>
							<td><?= $i ?></td>
							<td><?= $top->item->item_category->name?></td>
							<td><?= $top->item->name ?></td>
							<td><?= $top->item_variation->quantity_variation ?></td>
							<td><?= $top->item->item_code ?></td>
							<td><?= $top->rate ?></td>
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