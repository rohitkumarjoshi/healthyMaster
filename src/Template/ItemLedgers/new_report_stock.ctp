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
										
										<?= @$QuantityOpeningStock[$Item->id]; ?></td>
										<td style="text-align:center"><?= @$TodayPurchaseStock[$Item->id]; ?></td>
										<td style="text-align:center"><?= @$TodayWastageStock[$Item->id]; ?></td>
										<td style="text-align:center"><?= @$TodayReuseStock[$Item->id]; ?></td>
										<?php 
										$todayReadyStok=0;
										$todayReadyStok=@$QuantityOpeningStock[$Item->id]+@$TodayPurchaseStock[$Item->id]-@$TodayWastageStock[$Item->id]-@$TodayReuseStock[$Item->id];
										
										?>
										<td style="text-align:center"><?= @$todayReadyStok; ?></td>
										<td style="text-align:center"><?= @$todaySales[$Item->id]; ?></td>
										
										<td style="text-align:center"><?php echo @$todayReadyStok-@$todaySales[$Item->id]; ?></td>
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
