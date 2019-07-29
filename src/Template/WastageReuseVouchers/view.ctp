<div class="row">
	<div class="col-md-2 col-sm-2"></div>
	<div class="col-md-8 col-sm-8">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">
						WASTAGE AND REUSE
						
					</span>
				</div>
				<div class="actions">
				<td> <?php echo $wastageReuseVoucher->created_date; ?></td>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					
					<div class="col-sm-12" style="margin-top:10px;" id="main">
						<table class="table table-bordered" id="main_table">	
							<thead class="bg_color">
								<tr align="center">
									<th width="5%" style="text-align:left;">Sr</th>
									<th width="25%" style="text-align:left;">Item</th>
									<th width="20%" style="text-align:left;">Variation</th>
									<th width="20%" style="text-align:left;">Wastage Quantity</th>
									<th width="18%" style="text-align:left;">Reuse Quantity</th>
								</tr>
							</thead>
							<tbody id="main_tbody">
							<?php $i=1; foreach($wastageReuseVoucher->wastage_reuse_voucher_rows as $data){ ?>
							<tr class="main_tr">
								<td> <?php echo $i++; ?></td>
								<td> <?php echo $data->item->name; ?></td>
								<td> <?php echo $data->unit_variation->name; ?></td>
								<td> <?php echo $data->wastage_quantity; ?></td>
								<td> <?php echo $data->reuse_quantity; ?></td>
							</tr>
							<?php } ?>
							</tbody>
							
						</table>
					</div>
				</div>
				
 						 
					
				</div> 
			</div>
		</div>
	</div>
	<div class="col-md-4 col-sm-4">
		
	</div>
</div>
