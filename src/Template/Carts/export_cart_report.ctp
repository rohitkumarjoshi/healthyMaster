<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Cart Report".$date.'_'.$time;

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
              <th>Sr</th>
              <th>Customer ID</th>
              <th>Customer Name</th>
              <th>Mobile</th>
              <!-- <th>Item Variation</th> -->
              <th>Item Code</th>
              <th>Item Name</th>
              <th>Variation</th>
              <th>Rate</th>
              <th>Date</th>
              
            </tr>
          </thead>
          <tbody>
            <?php
            $i=0;
            foreach ($Carts as $Cart):
            $i++;

            ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= h(@$Cart->customer->id) ?></td>
              <td><?= h(@$Cart->customer->name) ?></td>
              <td><?= h(@$Cart->customer->mobile) ?></td>
              <!-- <td><?= h(@$Cart->item_variation->name) ?></td> -->
              <td><?= h(@$Cart->item->item_code) ?></td>
              <td><?= h(@$Cart->item->name) ?></td>
              <td><?= h(@$Cart->item_variation->quantity_variation)?></td>
              <td><?= h(@$Cart->item_variation->sales_rate) ?></td>
              <td><?= date('d-m-Y',strtotime($Cart->created_on)) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
			