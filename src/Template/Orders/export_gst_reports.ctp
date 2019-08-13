<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="GST Report".$date.'_'.$time;

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
                            <th scope="col"><?= __('S.No') ?></th>
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Variation</th>
                            <th scope="col">Category</th>
                            <th scope="col">Invoice No.</th>
                            <th scope="col">Date</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Sale AmountTaxable</th>
                            <th scope="col">GST</th>
                            <th scope="col">CGST Amount</th>
                            <th scope="col">SGST Amount</th>
                            <th scope="col">IGST Amount</th>
                            <th scope="col">Total Tax</th>
                            <th scope="col">Sales Value With Tax</th>
                        </tr>
              </thead>
              <tbody id='main_tbody' class="tab">
            <?php $i=1;foreach($gsts as $gst){
                            @$state_id=$gst->order->customer_address->state->id;
              $amount=$gst->amount;
                          $gst_per=$gst->item->gst_figure->name;
                          $tx=100+$gst_per;
              $tax=round(($amount * $gst_per)/$tx);
              ?>
              <tr>
                <td><?= $i; $i++;?></td>
                              <td> <?= $gst->item->item_code?></td>
                              <td><?= $gst->item->name ?></td>
                              <td><?= $gst->item_variation->quantity_variation?></td>
                              <td><?= $gst->item->item_category->name?></td>
                              <td><?= $gst->order->invoice_no?></td>
                              <td><?= $gst->order->invoice_date?></td>
                              <td><?= $gst->quantity ?></td>
                              <td><?php
                                echo $amount - $tax;
                               ?>
                              </td>
                              <td><?= $gst->item->gst_figure->name?></td>
                              <td><?php if($state_id == "17") 
                                echo $cgst=$tax/2 ;
                                ?></td>
                              <td><?php if($state_id == "17") 
                                echo $sgst=$tax/2 ;
                                ?></td>
                              <td><?php if($state_id != "17") 
                                echo $tax ;
                                ?></td>
                              <td><?php if($state_id == "17")
                              { 
                                    echo $cgst + $sgst;
                              }
                              if($state_id != "17") 
                              {
                                echo $tax;
                              }

                              ?></td>
                              <td><?= $gst->amount?></td>
              </tr>
            <?php 
                } ?>
              </tbody>
      </table>
			