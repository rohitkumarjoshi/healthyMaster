<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="UsedPromoCode Report".$date.'_'.$time;

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
                            <th scope="col">Date</th>
                            <th scope="col">Order No.</th>
                            <th scope="col">Customer ID</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Code</th>
                            <th scope="col">Title</th>
                            <th scope="col">Order Value</th>
                            <th scope="col">Discount Value</th>
                            <th scope="col">Discount Percent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($used_promo as $used_promos):
                        ?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?= date('d-m-Y',strtotime($used_promos->order_date))?></td>
                            <td><?= $used_promos->order_no?></td>
                            <td><?= $used_promos->customer->id?></td>
                            <td><?= $used_promos->customer->name?></td>
                            <td><?= $used_promos->customer->mobile?></td>
                            <td><?= $used_promos->promo_code->code?></td>
                            <td><?= $used_promos->promo_code->title?></td>
                            <td><?= $used_promos->grand_total?></td>
                            <td><?php if($used_promos->promo_code->amount_type == "amount")
                            {

                                echo $used_promos->promo_code->discount_per." ".$used_promos->promo_code->amount_type;
                            }?></td>
                            <td>
                               <?php if($used_promos->promo_code->amount_type == "percent")
                            {

                                echo $used_promos->promo_code->discount_per." ".$used_promos->promo_code->amount_type;
                            }?> 
                            </td>
                        </tr>
                        <?php endforeach;  ?>
                    </tbody>
      </table>
			