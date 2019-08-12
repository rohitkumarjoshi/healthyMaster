<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Order/Sales Report".$date.'_'.$time;

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
                            <th scope="col">Order Date</th>
                            <th scope="col">Order No</th>
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Customer ID</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Flat No</th>
                            <th scope="col">Apartment</th>
                            <th scope="col">Locality</th>
                            <th scope="col">City</th>
                            <th scope="col">State</th>
                            <th scope="col">Walkin Sale</th>
                            <th scope="col">Online Sale App</th>
                            <th scope="col">Online Sale Web</th>
                            <th scope="col">Payment Mode</th>
                            <th scope="col">Variation</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Gross Amount</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Net Sales</th>
                            <th scope="col">Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($orders as $order_detail):
                        ?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?= @date('d-m-Y',strtotime($order_detail->order->order_date))?></td>
                            <td><?= @$order_detail->order->order_no?></td>
                            <td><?= @$order_detail->item->item_code?></td>
                            <td><?= @$order_detail->item->name?></td>
                            <td><?= @$order_detail->item->item_category->name?></td>
                            <td><?= @$order_detail->order->customer->id?></td>
                            <td><?= @$order_detail->order->customer->name?></td>
                            <td><?= @$order_detail->order->customer->mobile?></td>
                            <td><?= @$order_detail->order->customer_address->house_no?></td>
                            <td><?= @$order_detail->order->customer_address->apartment_name?></td>
                            <td><?= @$order_detail->order->customer_address->locality?></td>
                            <td><?= @$order_detail->order->customer_address->city->name?></td>
                            <td><?= @$order_detail->order->customer_address->state->state_name?></td>
                            <td><?php if($order_detail->order->order_from == "walkinsales")
                            {
                                echo"Yes";
                            }?></td>
                            <td><?php if($order_detail->order->order_from == "Android APP")
                            {
                                echo"Yes";
                            }?></td>
                            <td><?php if($order_detail->order->order_from == "Ecommerce")
                            {
                                echo"Yes";
                            }?></td>
                            <td><?= @$order_detail->order->order_type ?></td>
                            <td><?= @$order_detail->item_variation->quantity_variation?></td>
                            <td><?= @$order_detail->rate?></td>
                            <td><?= @$order_detail->quantity?></td>
                            <td><?= @$order_detail->amount?></td>
                            <td><?= @$order_detail->order->amount_from_promo_code ?></td>
                            <td><?= @$order_detail->amount - $order_detail->order->amount_from_promo_code?></td>
                            <td><?= @$order_detail->order->status?></td>
                        </tr>
                        <?php endforeach;  ?>
                    </tbody>
      </table>
			