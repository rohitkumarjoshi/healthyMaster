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
					<button class="btn btn-sm yellow" id="btnExport" onclick="fnExcelReport();"> Export </button>&nbsp;
				</div>
			</div>
			<div class="portlet-body">
				<!-- BEGIN FORM-->
				<div class="row">
					<div class="col-md-12">
						<table id="main-table" class="table table-condensed table-bordered">
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
	 function fnExcelReport()
    {
        var tab_text='<table border=\'2px\'><tr bgcolor=\'#87AFC6\'>';
        var textRange; var j=0;
        tab = document.getElementById('main-table'); // id of table

        for(j = 0 ; j < tab.rows.length ; j++) 
        {     
            tab_text=tab_text+tab.rows[j].innerHTML+'</tr>';
            //tab_text=tab_text+'</tr>';
        }

        tab_text=tab_text+'</table>';
        tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, '');//remove if u want links in your table
        tab_text= tab_text.replace(/<img[^>]*>/gi,''); // remove if u want images in your table
        tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ''); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf('MSIE '); 

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open('txt/html','replace');
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus(); 
            sa=txtArea1.document.execCommand('SaveAs',true,'Say Thanks to Sumit.xls');
        }  
        else                 //other browser not tested on IE 11
            sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

        return (sa);
    }
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
