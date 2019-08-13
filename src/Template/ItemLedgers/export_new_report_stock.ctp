<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Stock Report".$date.'_'.$time;

	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" );
//pr($OrderAcceptances->toArray()); exit;
?>


<table border="1">
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
			