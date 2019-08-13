<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Purchase Report".$date.'_'.$time;

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
                            <th scope="col">Transaction Date</th>
                            <th scope="col">Vendor ID</th>
                            <th scope="col">Vendor Name</th>
                            <th scope="col">Contact No.</th>
                            <th scope="col">HSN Code</th>
                            <th scope="col">Gst No.</th>
                            <th scope="col">City</th>
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Variation</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Purchase Value</th>
                            <th scope="col">GST Rate</th>
                            <th scope="col">GST Amount</th>
                            <th scope="col">Total Amount with GST</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($purchases as $purchase):
                            $amount=$purchase->quantity * $purchase->rate ;
                            $gst_per=$purchase->item->gst_figure->name;
                            $tx=100+$gst_per;
                            $tax=round(($amount * $gst_per)/$tx);
                        ?>
                        <tr>
                            <td><?= $i; $i++;?></td>
                            <td> <?= date('d-m-Y',strtotime($purchase->purchase_booking->created_on)) ?></td>
                            <td><?= $purchase->purchase_booking->vendor->id ?></td>
                            <td><?= $purchase->purchase_booking->vendor->name ?></td>
                            <td><?= $purchase->purchase_booking->vendor->mobile ?></td>
                            <td><?= $purchase->item->hsn_code?></td>
                            <td><?= $purchase->purchase_booking->vendor->gst_no ?></td>
                            <td><?= $purchase->purchase_booking->vendor->city->name ?></td>
                            <td><?= $purchase->item->item_code?></td>
                            <td><?= $purchase->item->name?></td>
                            <td><?= $purchase->item->item_category->name?></td>
                            <td><?= $purchase->unit_variation->name?></td>
                            <td><?= $purchase->quantity ?></td>
                            <td><?= $purchase->rate ?></td>
                            <td><?= $purchase->quantity * $purchase->rate ?></td>
                            <td><?= $amount - $tax ?></td>
                            <td><?= $gst_per?></td>
                            <td><?= $tax ?></td>
                            <td><?= $purchase->quantity * $purchase->rate?></td>

                        </tr>
                        <?php endforeach;  ?>
                    </tbody>
      </table>
			