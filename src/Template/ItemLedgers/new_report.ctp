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
					<button class="btn btn-sm yellow" id="btnExport" onclick="fnExcelReport();"> Export </button>&nbsp;
				</div>
			</div>
			<div class="portlet-body">
				<!-- BEGIN FORM-->
				<div class="row">
					<div class="col-md-12">
						<table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_1">
							<thead>
								<tr>
									<td  width="3%" style="text-align:center" >
										<label >Sr<label>
									</td>
									<td  width="10%" style="text-align:center">
										<label >Item Name<label>
									</td>
									<td  width="10%" style="text-align:center">
										<label>Unit Variations<label>
									</td>
									<td   width="10%" style="text-align:center">
										<label>Qty <label>
									</td>
									
									<td width="10%" style="text-align:center">
										<label>No of Pkt<label>
									</td>
								</tr>
								
							</thead>
							<tbody id='main_tbody' class="tab">
						<?php $i=0; foreach($Items as $Item){
								//$varSize=sizeof(@$QuantityTotalStock[$Item->id]);
								if(@$QuantityTotalStock[$Item->id]) { 
								//$tempcolspan=(sizeof($Item->item_variations))
								?>
								<?php  foreach($Item->item_variations as $item_variation){ $i++;?>
									<tr class="main_tr" class="tab">
										<td  style="text-align:center" width="1px"><?= $i ?>.</td>
										<td style="text-align:center"><?= $Item->name ?></td>
										<td style="text-align:center"><?= $item_variation->unit_variation->name; ?></td>
										<td style="text-align:center"><?= $QuantityTotalStock[$Item->id]; ?></td>
										<?php 
											$no_of_pkt=floor($QuantityTotalStock[$Item->id]/$item_variation->unit_variation->quantity_factor);
											
											
										?>
										<td style="text-align:center"><?php echo $no_of_pkt; ?></td>
									</tr>
								<?php } } } ?>
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
        tab = document.getElementById('sample_1'); // id of table

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
