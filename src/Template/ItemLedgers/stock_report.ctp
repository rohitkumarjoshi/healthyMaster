<?php //$url_excel="/?".$url; 
//pr($url);exit;
?>

<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">MATERIAL STOCK REPORT
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
									<td rowspan="2" width="3%" style="text-align:center" >
										<label >Sr<label>
									</td>
									<td rowspan="2" width="10%" style="text-align:center">
										<label >Item Name<label>
									</td>
									<td rowspan="2" width="10%" style="text-align:center">
										<label>Opening Stock<label>
									</td>
									<td  colspan="2" width="10%" style="text-align:center">
										<label>Today's Transaction<label>
									</td>
									
									<td rowspan="2" width="10%" style="text-align:center">
										<label>Closing Stock<label>
									</td>
								</tr>
								<tr>
									<td style="text-align:center">In</td>
									<td style="text-align:center">Out</td>
								<tr>
							</thead>
							<tbody id='main_tbody' class="tab">
						<?php $i=0; foreach($ItemData as $Item){
								//pr(sizeof(@$itemVarAvailQty[$Item->id])); 
								$varSize=sizeof(@$itemVarAvailQty[$Item->id]);
								if(@$openingQty[$Item->id] > 0 ||  @$TransferIn[$Item->id] > 0||  @$TransferOut[$Item->id] > 0||  @$closingQty[$Item->id] > 0) { $i++;
								?>
									<tr class="main_tr" class="tab">
										<td style="text-align:center" width="1px"><?= $i ?>.</td>
										<td style="text-align:center"><?= $Item->name ?></td>
										<td style="text-align:center">
										
										<?php if(@$openingQty[$Item->id]){
												echo @$openingQty[$Item->id];
											} else{
											echo '0';
											} 
										?>
										</td>
										
										<td style="text-align:center">
										<?php if(@$TransferIn[$Item->id]){
												echo @$TransferIn[$Item->id];
											} else{
											echo '0';
											} 
										?>
										</td>
										<td style="text-align:center">
										<?php if(@$TransferOut[$Item->id]){
												echo @$TransferOut[$Item->id];
											} else{
											echo '0';
											} 
										?>
										</td>
										<td style="text-align:center">
										<?php if(@$closingQty[$Item->id]){
												echo @$closingQty[$Item->id];
											} else{
											echo '0';
											} 
										?>
										</td>
										
										
									</tr>
								<?php } } ?>
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
