<style>

@media print{
	.maindiv{
		width:100% !important;
	}	
	.hidden-print{
		display:none;
	}
}
p{
margin-bottom: 0;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 5px !important;
	font-family:Lato !important;
}
</style>

<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0px 0px 0px 0px;  /* this affects the margin in the printer settings */
}
</style>
<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding:10px;width: 100%;font-size:14px;" class="maindiv">	
<?php
if(empty($print))
{
	echo $this->Html->link('Print',['controller'=>'Orders','action'=>'view',$id,'print'],['escape'=>false,'class'=>'btn  blue hidden-print fa fa-print','target'=>'_blank',]);
}
else
{
	echo $this->Html->link('Print',array(),['escape'=>false,'class'=>'btn  blue hidden-print fa fa-print','onclick'=>'javascript:window.print();']);
}
echo $this->Html->link('Close',array(),['escape'=>false,'class'=>'btn  red hidden-print fa fa-remove pull-right','onclick'=>'javascript:window.close();']);

?>
<div align="center" style=" font-size: 16px;font-weight: bold;">Order Details</div>
	<div style="border:solid 1px; margin-bottom:0px;"></div>
		<table width="100%">	
			
			<tbody>
				<tr style="background-color:#fff; color:#000;">
					<td align="left" colspan="5">
						<b>
							Order No.: <?= $order->order_no ?>
						</b>
					</td>
				</tr>
				
				<tr style="background-color:#fff; color:#000;">
					<td align="left" colspan="5">
					<b>Name: </b><?= h(ucwords(@$order->customer_address->name)) ?><br>
					<b>Address</b><?= h(@$order->customer_address->house_no) ?> &nbsp; <?= h(ucfirst(@$order->customer_address->address)) ?>,&nbsp;<br/><?= h(@$order->customer_address->landmark) ?> &nbsp;<?= h(ucwords(@$order->customer_address->locality)) ?><br>
					<?= h(ucwords(@$order->customer_address->city->name)) ?>&nbsp; <?= h(ucwords(@$order->customer_address->state->state_name)) ?><br/>
					<b>Mobile:</b> <?= h(@$order->customer_address->mobile) ?>	
					</td>
				</tr>
			</table>
			<table width="100%" border="1">
				<thead>
				<tr>
					<th style="text-align:left;">#</th>
					<th style="padding: 10px;">Image</th>
					<th style="padding: 10px;">Item Name</th>
					<th style="padding: 10px;">Variation</th>
					<th style="padding: 10px;">QTY</th>
					<th style="padding: 10px;">Rate</th>
					<th style="padding: 10px;">Amount</th>
				</tr>
				</thead>
				
				<?php
				$total_gst=0; $total_taxbale_amount=0;
				foreach($order->order_details as $order_detail ){ 
				    $gst=0; $taxbale_amount=0;
						$amount=$order_detail->amount;
						$tax_percentage=$order_detail->item->gst_figure->tax_percentage;
						 $gst=(($amount*$tax_percentage)/(100+$tax_percentage));
						 $gst= round($gst,2);
						 $taxbale_amount=$amount-$gst;
						 $total_taxbale_amount+=$taxbale_amount;
						 $total_gst+=$gst;
					@$i++;
					$show_variation=@$order_detail->item_variation->quantity_variation.' '.@$order_detail->item_variation->unit->shortname;
					$quantity=$order_detail->quantity;
					$actual_quantity=$order_detail->actual_quantity;
					$minimum_quantity_factor=$order_detail->item->minimum_quantity_factor;
					$unit_name=@$order_detail->item_variation->unit->unit_name;
					$image=$order_detail->item->image;
					$item_name=$order_detail->item->name;
					$sales_rate=$order_detail->rate;
					$alias_name=$order_detail->item->alias_name;
					$show_quantity=$quantity;
					if(!empty($actual_quantity)){
					$show_actual_quantity=$actual_quantity;
					}
					else{
					$show_actual_quantity='-';
					}
					$amount=$order_detail->amount;
					@$total_rate+=$amount;
					if(!empty($alias_name)){
						$show_item=$item_name.' ('.$alias_name.')';
					}else{
						$show_item=$item_name;
					} ?>
				<tr style="background-color:#fff;">
					<td style="padding: 10px;"><?= $i ?></td>
					<td style="padding: 10px;">
						<?php echo $this->Html->image('/img/item_images/'.$image, ['height' => '40px', 'width'=>'40px', 'class'=>'img-rounded img-responsive']); ?>
						
					</td>
					<td style="padding: 10px;"><?php echo $show_item;
						if($order_detail->status == "Cancel")
						{
							echo'   <span style="color:red;text-align:center;">['.$order_detail->status.']</span>';
						}
						 ?></td>
					<td style="padding: 10px;"><?= h($show_variation) ?></td>
					<td style="padding: 10px;"><?= h($show_quantity) ?></td>
					<td style="padding: 10px;"><?= h($sales_rate) ?></td>
					<td style="padding: 10px;"><?= h($amount) ?></td>
				</tr>
				<?php } ?>
				<?php
				$amount_from_promo_code=$order->amount_from_promo_code;
				$delivery_charge=$order->delivery_charge;
				$promo=$order->amount_from_promo_code;
				$amount_from_jain_cash=$order->amount_from_jain_cash;
				$online_amount=$order->online_amount;
				$amount_from_wallet=$order->amount_from_wallet;
				$pay_amount=$order->pay_amount;
				$status=$order->status;
				$grand_total=@$total_rate+$delivery_charge+$promo;
				$discount_per=$order->discount_percent;
				//$amount_from_wallet=$order->amount_from_wallet;
				?>
				 <!--<tr style="background-color:#fff; border-top:1px solid #000">
					<td colspan="5">&nbsp;</td><td style="padding-top:12px;"><b>Taxbale amount </b></td>
					<td style="padding: 10px;"><b><?= h(@$total_taxbale_amount) ?></b></td>
				 </tr>
				<?php if($order->customer_address->state_id==17){ ?>
				 <tr style="background-color:#fff; border-top:1px solid #000">
					<td colspan="5">&nbsp;</td><td style="padding-top:12px;"><b>CGST</b></td>
					<td style="padding: 10px;"><b><?= h(@$total_gst/2) ?></b></td>
				 </tr>
					<tr style="background-color:#fff; border-top:1px solid #000">
					<td colspan="5">&nbsp;</td><td style="padding-top:12px;"><b>SGST</b></td>
					<td style="padding: 10px;"><b><?= h(@$total_gst/2) ?></b></td>
				 </tr>
					
					
				<?php }else{ ?>
				 <tr style="background-color:#fff; border-top:1px solid #000">
					<td colspan="5">&nbsp;</td><td style="padding-top:12px;"><b>IGST</b></td>
					<td style="padding: 10px;"><b><?= h(@$total_gst) ?></b></td>
				 </tr>
					
				<?php } ?> -->
				<tr style="background-color:#fff; border-top:1px solid #000">
					<td colspan="5">&nbsp;</td><td style="padding-top:12px;"><b style="padding: 5px;">Amount </b></td>
					<td style="padding: 10px;"><b><?= h(@$order->total_amount) ?></b></td>
				</tr>
				
				
				<tr style="background-color:#fff;">
					<td colspan="5">&nbsp;</td>
					<td style="padding-top:12px;"><b style="padding: 5px;">Delivery Charge </b></td>
					<td style="padding: 10px;"><b><?= h($delivery_charge) ?></b></td>
				</tr>

				<tr style="background-color:#fff;">
					<td colspan="5">&nbsp;</td>
					<td style="padding-top:12px;"><b style="padding: 5px;">PromoCode Discount </b></td>
					<td style="padding: 10px;"><b><?= h($order->amount_from_promo_code) ?></b></td>
				</tr>
				
				<?php if(!empty($discount_per)){ ?>
				<tr style="background-color:#fff; border-top:1px solid #000">
					<td colspan="5">&nbsp;</td>
					<td style="padding-top:12px;"><b style="padding: 5px;">Discount </b></td>
					<td style="padding: 10px;"><b><?= h($discount_per) ?><?php echo '%'; ?></b></td>
				</tr>
				<?php } ?>
				<?php if(!empty($amount_from_wallet)){ ?>
				<tr style="background-color:#fff;">
					<td colspan="5">&nbsp;</td>
					<td style="padding-top:12px;"><b style="padding: 5px;">Wallet Amount </b></td>
					<td style="padding: 10px;"><b><?= h($amount_from_wallet) ?></b></td>
				</tr>
				<?php } ?>
				<tr style="background-color:#F5F5F5; border-top:1px solid #000; border-bottom:1px solid #000">
					<td colspan="5">&nbsp;</td>
					<td style="padding-top:12px;"><b style="padding: 5px;">Total Amount </b></td>
					<td style="padding: 10px;"><b><?= h(@$order->grand_total) ?></b></td>
				</tr>
			
			</tbody>
			<tfoot>
				
				<!--<tr>
				<td colspan="6"><a class="btn  blue hidden-print margin-bottom-5 pull-right" onclick="javascript:window.print();">Print <i class="fa fa-print"></i></a>
				</td>
				</tr>-->
			</tfoot>
		</table>
	</div>
