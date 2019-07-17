<?php $url_excel="/?".$url; 
//pr($url);exit;
?>

<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense "> STOCK REPORT
					</span>
				</div>
				<div class="actions"> 
					<?php echo $this->Html->link( '<i class="fa fa-file-excel-o"></i> Excel', '/ItemLedgers/Export-Excel-Stk/'.@$url_excel.'',['class' =>'btn btn-sm green tooltips pull-right','target'=>'_blank','escape'=>false,'data-original-title'=>'Download as excel']); ?>


					
					
				</div>
			</div>
			<div class="portlet-body">
				<!-- BEGIN FORM-->
				<div class="row">
					<div class="col-md-12">
						<table id="main_tble" class="table table-condensed table-bordered">
							<thead>
								<tr>
									<th width="10%">
										<label>Sr<label>
									</th>
									<th width="10%">
										<label>Item Code<label>
									</th>
									<th width="10%">
										<label>Item Name<label>
									</th>
									
									<th width="10%">
										<label>Variation<label>
									</th>
									<th width="10%">
										<label>Opening Stock<label>
									</th>
									<th width="10%">
										<label>Purchase<label>
									</th>
									<th width="10%">
										<label>Wastage<label>
									</th>
									<th width="10%">
										<label>Reuse<label>
									</th>
									<th width="10%">
										<label>Stock For Sale<label>
									</th>
									<th width="10%">
										<label>Sale Of the Day<label>
									</th>
									<th width="10%">
										<label>Closing Stock<label>
									</th>

								</tr>
							</thead>
							<tbody id='main_tbody' class="tab">
						<?php $i=0; foreach($ItemVariations as $ItemVariation){
							
								
								if(@$itemVarOpeningQt[$ItemVariation->id] > 0 || @$itemPurchaseQt[$ItemVariation->id] > 0 ) { $i++;
								?>
									<tr class="main_tr" class="tab">
										<td width="1px"><?= $i ?>.</td>
										<td><?= $ItemVariation->item->item_code?></td>
										<td>
											<a href="#" role="button" class="stock_show" itm="<?= $ItemVariation->item_id ?>"><?= $ItemVariation->item->name ?></a>	
										</td>
										<td>
											<?= $ItemVariation->quantity_variation.' '.$ItemVariation->unit->shortname ?>
										</td>
										<td><?= @$itemVarOpeningQt[$ItemVariation->id] ?></td>
										<td><?= @$itemPurchaseQt[$ItemVariation->id] ?></td>
										<td>-</td>
										<td>-</td>
										<td><?= @$itemVarOpeningQt[$ItemVariation->id]+@$itemPurchaseQt[$ItemVariation->id] ?></td>
										<td><?= @$itemSaleQt[$ItemVariation->id] ?></td>
										<td><?= @$itemVarOpeningQt[$ItemVariation->id]+@$itemPurchaseQt[$ItemVariation->id]-@$itemSaleQt[$ItemVariation->id] ?></td>
										
									</tr>
								<?php } 
								} ?>
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


<script>
$(document).ready(function(){

	$('.stock_show').die().live("click",function() {
		var current_entity=$(this);
		$(this).closest('td').append('<span class="loading_span">Loading...</span>');
		$(this).closest('td').find(".stock_hide").show();
		var entity=$(this).closest('tr');
		var item_id=$(this).closest('tr').find(".stock_show").attr("itm");
		var url="<?php echo $this->Url->build(['controller'=>'ItemLedgers','action'=>'ajaxItemDetails']);
		?>";
		url=url+'/'+item_id,
		$.ajax({
			url: url,
		}).done(function(response) {
			current_entity.removeClass("stock_show").addClass("stock_hide");
			entity.after(response);
			current_entity.closest('td').find('span.loading_span').remove();
		});		
    });
	
	$('.stock_hide').die().live("click",function() {
		$(this).closest('tr').next().remove();
		$(this).addClass("stock_show").removeClass("stock_hide");
	});


    });
</script>
