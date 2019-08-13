<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Top Selling Report".$date.'_'.$time;

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
              <th>Item Code</th>
              <th>Item Name</th>
              <th>Category</th>
              <th>Variation</th>
              <th>Sales Count</th>
              <th>Sales Value</th>
            </tr>
          </thead>
          <tbody>
            <?php
            
            $i=0;
              foreach ($recently_boughts as $top) {
                 $count=$top->Count;
                 if($count > 50)
                        {
                  $i++;
            ?>
            <tr>
              <td><?= $i ?></td>
              <td><?= $top->item->item_code ?></td>
              <td><?= $top->item->name ?></td>
              <td><?= $top->item->item_category->name?></td>
              <td><?= $top->unit_variation->name?></td>
              <td><?= $top->Count ?> Times</td>
              <td><?= $top->rate ?></td>
            </tr>
          <?php }} ?>
          </tbody>
      </table>
			