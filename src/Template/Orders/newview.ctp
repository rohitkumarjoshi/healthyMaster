<style>
.invoice td{
padding:5px;	
}
@media print{
	.maindiv{
		width:100% !important;
	}	
	.hidden-print{
		display:none;
	}
}
</style>
<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding:10px;width: 100%;font-size:14px;" class="maindiv hidden-print">
<?php

	echo $this->Html->link('Print',array(),['escape'=>false,'class'=>'btn  blue hidden-print fa fa-print','onclick'=>'javascript:window.print();']);

echo $this->Html->link('Close',array(),['escape'=>false,'class'=>'btn  red hidden-print fa fa-remove pull-right','onclick'=>'javascript:window.close();']);

?>
</div>
<?php 
//pr($order); 
$html='<div style="background-color:#fff; ">
<table width="100%"  border="1" cellspacing="10" cellpadding="10" class="invoice" >
	<tr>
		<td rowspan="3" align="center" >
			TAX INVOICE
		</td>
		<td>Original for Receipient</td>
	</tr>

	<tr>
		<td>Duplicate for Supplier/Transporter</td>
	</tr>
	<tr>
		<td>Triplicate for Supplier</td> 
	</tr>
	<tr>
		<td rowspan="2"> 
		<b>Shasila Healthy Master Pvt Ltd </b><br/> 
		NO 11-3 and 11-4 FLAT NO B-406, <br/>
		ISIRI STONE CREEK APPARTMENT,<br/>
		AKSHAYA NAGAR YELENAHALLI ROAD BEGUR <br/>
		Bengaluru (Bangalore) Urban, Karnataka, 560068<br/>
		GSTIN:										
		</td>
		<td valign="top"> INVOICE NO. '.$order->invoice_no.'<br/>Dated: '.$order->invoice_date.'</td>
	</tr>
	<tr>
		<td>&nbsp;</td> 
	</tr>
	<tr>
		<td colspan="2"> 
			<b> BUYER NAME AND ADDRESS </b> <br/> 
			'.$order->customer_address->name.'  ('.$order->customer_address->mobile.')<br/>
			'.$order->customer_address->house_no.' '.$order->customer_address->address.'<br/>
			'.$order->customer_address->landmark.' '.$order->customer_address->locality.' <br/>
			'.$order->customer_address->city->name.' '.$order->customer_address->state->state_name.' <br/>
			<br/>
			<b> GSTIN : </b>
		</td>
	</tr>
	<tr>
	<td colspan="2">
		<table border="1" width="100%" style="border:none;" class="item">
			<tr>
				<td rowspan="2">Sr No.</td>
				<td rowspan="2">Description & Specification of Goods</td>
				<td rowspan="2">HSN Code</td>
				<td rowspan="2">Qty</td>
				<td rowspan="2">Unit</td>
				<td rowspan="2">Rate </td>
				<td rowspan="2">Rs.</td>
				<td colspan="2">CGST</td>
				<td colspan="2">SGST</td>
				<td colspan="2">IGST</td>
				<td>TOTAL</td>
				
			</tr>
			<tr>
				<td>Rate</td>
				<td>Amount</td>
				<td>Rate</td>
				<td>Amount</td>
				<td>Rate</td>
				<td>Amount</td>
				<td>Rs</td>
			</tr>';
		
			$i=0; $total_taxamount=0;$total_cgst=0;$total_igst=0;$total_amount=0;
			foreach($order->order_details as $order_detail){
				$gstper=0.0;$gstper1=0.0;
				$amount=$order_detail->amount;
				$total_amount+=$amount;
				$state_id=@$order_detail->customer_address->state_id;
				$gst_per=$order_detail->item->gst_figure->name;
				$tax_percentage=$order_detail->item->gst_figure->tax_percentage;
				$gst=(($amount*$tax_percentage)/(100+$tax_percentage));
				$gst= round($gst,2);
				
				$taxbale_amount=$amount-$gst;
				$total_taxamount+=$taxbale_amount;
				$rate=$taxbale_amount/$order_detail->quantity;
				
				$cgst=0;$igst=0;
				if($state_id==17){
					$cgst=$gst/2;
					$total_cgst+=$cgst;
					$gstper=$gst_per;
				}else{
					$igst=$gst;
					$total_igst+=$igst;
					$gstper1=$gst_per;
				}
				
				$i++;
				$html.='<tr>
				<td>'.$i.'</td>
				<td>'.$order_detail->item->name.'</td>
				<td>'.$order_detail->item->hsn_code.'</td>
				<td>'.$order_detail->quantity.'</td>
				<td>'.$order_detail->item_variation->unit->shortname.'</td>
				<td>'.$rate.'</td>
				<td>'.$taxbale_amount.'</td>
				<td>'.$gstper.'</td>
				<td>'.$cgst.'</td>
				<td>'.$gstper.'</td>
				<td>'.$cgst.'</td>
				<td>'.$gstper1.'</td>
				<td>'.$igst.'</td>
				
				<td>'.$order_detail->amount.'</td>
				
				</tr>';
			}
			$html.='<tr>
				<td colspan="6" align="right"><b>Total</b> &nbsp;</td>
				
				<td>'.$total_taxamount.'</td>
				<td></td>
				<td>'.$total_cgst.'</td>
				<td></td>
				<td>'.$total_cgst.'</td>
				<td></td>
				<td>'.$total_igst.'</td>
				<td>'.$total_amount.'</td>
				
			</tr>';
			
			
		$html.='</table>
	</td>
	
	
	
	</tr>';
	$html.='<tr>
				<td colspan="2"><b>RUPES: INR '.ucwords($this->requestAction(['controller'=>'Orders', 'action'=>'convert_number_to_words'],['pass'=>array($total_amount)])).' </b></td>
			</tr>';
			
	$html.='<tr>
				<td colspan="2">
					<table  border="1" width="100%" style="border:none;">
						<tr>
						<td rowspan="2">HSN/SAC</td>
						<td rowspan="2">Taxable Value</td>
						<td colspan="2">Central Tax</td>
						<td colspan="2">State Tax</td>
						<td colspan="2">IGST Tax</td>
						<td rowspan="2">Total Tax Amount</td>
						</tr>
						<tr>
							<td>Rate</td>
							<td>Amount</td>
							<td>Rate</td>
							<td>Amount</td>
							<td>Rate</td>
							<td>Amount</td>
						</tr>';
						$total_taxamount=0;$total_cgst=0;$total_igst=0;$total_amount=0;
					foreach($order->order_details as $order_detail){ 
						$gstper=0.0;$gstper1=0.0;
						$amount=$order_detail->amount;
						$total_amount+=$amount;
						$state_id=@$order_detail->customer_address->state_id;
						$gst_per=$order_detail->item->gst_figure->name;
						$tax_percentage=$order_detail->item->gst_figure->tax_percentage;
						$gst=(($amount*$tax_percentage)/(100+$tax_percentage));
						$gst= round($gst,2);

						$taxbale_amount=$amount-$gst;
						$total_taxamount+=$taxbale_amount;
						$rate=$taxbale_amount/$order_detail->quantity;

						$cgst=0;$igst=0;
						if($state_id==17){
							$cgst=$gst/2;
							$total_cgst+=$cgst;
							$gstper=$gst_per;
						}else{
							$igst=$gst;
							$total_igst+=$igst;
							$gstper1=$gst_per;
						}

					
						$html.='
							<tr>
								<td>'.$order_detail->item->hsn_code.'</td>
								<td>'.$taxbale_amount.'</td>
								<td>'.$gstper.'</td>
								<td>'.$cgst.'</td>
								<td>'.$gstper.'</td>
								<td>'.$cgst.'</td>
								<td>'.$gstper1.'</td>
								<td>'.$igst.'</td>
								<td>'.$amount.'</td>
								
							</tr>
						';
						
					}
					$html.='<tr>
							<td><b>Total</b></td>
							<td>'.$total_taxamount.'</td>
							<td></td>
							<td>'.$total_cgst.'</td>
							<td></td>
							<td>'.$total_cgst.'</td>
							<td></td>
							<td>'.$total_igst.'</td>
							<td>'.$total_amount.'</td>
					</tr>';
					$html.='</table>
				</td>
			</tr>';
			$html.='<tr>
				<td colspan="2">&nbsp;</td>
			</tr>';
			$html.='<tr>
				<td colspan="2">
					<table width="100%">
						<tr>
							<td>
							TERMS AND CONDITIONS <br/>
							1.Goods once sold will not be taken back or exchanged <br/>
							2.Seller is not responsible for any loss or damage of goods in transit <br/>
							3.Buyer undertakes to presribed salse tax declaration to the seller on demand. <br/>
							</td>
						</tr>
						<tr>
						<td><br/>
							<b> BANK DETAILS:  <br/>
							NAME: <br/>
							BANK NAME:  HDFC BANK <br/>
							A/C NO: <br/>
							BRANCH: <br/>
							IFSC CODE:
							</b>
						</td>
						<td align="center">
						<b>For  Shasila Healthy Master Pvt Ltd  <br/><br/><br/><br/>
						Authorised Signatory
						</td>
						</tr>
					</table>	
				</td>
			</tr>';
			
			
			
	
$html.='</table>
</div>';
echo $html;

