<?php //$url_excel="/?".$url; 
//pr($url);exit;
?>

<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">STOCK REPORT
					</span>
				</div>
				<div class="actions"> 
					
				</div>
			</div>
			<div class="portlet-body">
				<!-- BEGIN FORM-->
				<div class="row">
					<div class="col-md-12">
						<table id="main_tble" class="table table-condensed table-bordered">
							<thead>
								<tr>
									<td  width="3%" style="text-align:center" >
										<label >Sr<label>
									</td>
									<td  width="5%" style="text-align:center">
										<label >Item Code<label>
									</td>
									<td  width="10%" style="text-align:center">
										<label >Item Name<label>
									</td>
									<td   width="10%" style="text-align:center">
										<label>Opening STOCK <label>
									</td>
									<td   width="10%" style="text-align:center">
										<label>Purchase <label>
									</td>
									<td   width="10%" style="text-align:center">
										<label>Wastage<label>
									</td>
									<td   width="10%" style="text-align:center">
										<label>Reuse <label>
									</td>
									<td   width="10%" style="text-align:center">
										<label>Stock For Sale <label>
									</td>
									<td   width="10%" style="text-align:center">
										<label>Sale For Day<label>
									</td>
									
									<td width="10%" style="text-align:center">
										<label>Closing STOCK<label>
									</td>
								</tr>
								
							</thead>
							<tbody id='main_tbody' class="tab">
						<?php $i=0; foreach($Items as $Item){ //pr($Item); exit;
								//$varSize=sizeof(@$QuantityTotalStock[$Item->id]);
								if(@$QuantityTotalStock[$Item->id]) { 
								//$tempcolspan=(sizeof($Item->item_variations))
								?>
								<?php  $i++;?>
									<tr class="main_tr" class="tab">
										<td  style="text-align:center" width="1px"><?= $i ?>.</td>
										<td style="text-align:center"><?= $Item->item_code ?></td>
										<td style="text-align:center"><?= $Item->name ?></td>
										
										<td style="text-align:center">
										
										<?= $QuantityOpeningStock[$Item->id]; ?></td>
										<td style="text-align:center"><?= @$TodayPurchaseStock[$Item->id]; ?></td>
										<td style="text-align:center"><?= @$TodayWastageStock[$Item->id]; ?></td>
										<td style="text-align:center"><?= @$TodayReuseStock[$Item->id]; ?></td>
										
										<td style="text-align:center"><?= $QuantityOpeningStock[$Item->id]+@$TodayPurchaseStock[$Item->id]-@$TodayWastageStock[$Item->id]-@$TodayReuseStock[$Item->id]; ?></td>
										<td style="text-align:center"></td>
										
										<td style="text-align:center"><?php echo $QuantityTotalStock[$Item->id]; ?></td>
									</tr>
								<?php }  } ?>
							</tbody>
						</table>
					</div>
					<div class="col-md-12"><br></div>
							</div>
						<!-- END FORM-->
						<div id="view_revision">
						
						</div>
						<div class="row" style="padding-top:5px;">
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
							<div class="col-md-4"> </div>
						</div>
						 
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
