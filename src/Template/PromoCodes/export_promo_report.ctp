<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="PromoCode Report".$date.'_'.$time;

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
            <th>Promo Code</th>
            <th>Title</th>
            <th>Description</th>
            <th>Code Type</th>
            <th>Discount Value</th>
            <th>Discount Percent</th>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Item Category</th>
            <th>Cart Value</th>
            <th>Free Shipping</th>
            <th>Valid From</th>
            <th>Valid To</th>
            <th>Create</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i=0;
          foreach (@$promoCodes as $promoCode):
          $i++;

          ?>
          <tr>
            <td><?= $i ?></td>
            <td><?= h(@$promoCode->code) ?></td>
            <td><?= h(@$promoCode->title) ?></td>
            <td><?= h(@$promoCode->description) ?></td>
            <td><?= h(@$promoCode->promo_code_type) ?></td>
            <td><?php 
              $type=$promoCode->amount_type;
              if($type == "amount")
              {
                echo "Rs.";
                echo h(@$promoCode->discount_per);
              }
              
            ?></td>
            <td><?php 
              $type=$promoCode->amount_type;
              if($type == "percent")
              {
                echo h(@$promoCode->discount_per);
                echo "%";
              }
              
            ?></td>
            <td><?= h(@$promoCode->item->item_code) ?></td>
            <td><?= h(@$promoCode->item->name) ?></td>
            <td><?= h(@$promoCode->item_category->name) ?></td>
            <td><?= h(@$promoCode->cart_value) ?></td>
            <td><?php $freeship=@$promoCode->is_freeship;
              if($freeship == "1") 
              {
                echo"Yes";
              }
              if($freeship == "0") 
              {
                echo"No";
              }

            ?>
            <td><?= h(@$promoCode->valid_from) ?>
            <td><?= h(@$promoCode->valid_to) ?>
            <span id="status_id" style="display:none;"><?php echo $promoCode->id; ?></span>
            </td>
            <td><?= h(@date('d-m-Y',strtotime($promoCode->created_on) ))?>
            <td><?= h(@$promoCode->status) ?>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
			