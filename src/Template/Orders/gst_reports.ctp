	
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense "> GST REPORT
					</span>
				</div>
				
			</div>
			<div class="portlet-body">
				<form method="post">
						<table width="50%" class="table table-condensed">
					<tbody>
						<tr>
							<td width="5%">
								<label>Item</label>
								<?php echo $this->Form->input('item_id', ['empty'=>'--Items--','options' => $items,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category']); ?>
							</td>
							<td width="5%">
								<label>From</label>
								<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From"  data-date-format="dd-mm-yyyy">
							</td>	
							<td width="5%">
								<label>To</label>
								<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To"   data-date-format="dd-mm-yyyy" >
							</td>
							<td width="10%">
								<button type="submit" class="btn btn-success btn-sm" style="margin-top: 23px !important;"><i class="fa fa-filter"></i> Filter</button>
							</td>
						</tr>
					</tbody>
				</table>
				</form>
				<!-- BEGIN FORM-->
				<div class="row">
					<div class="col-md-12">
						<table id="main_tble" class="table table-condensed table-bordered">
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
                            $state_id=$gst->order->customer_address->state->id;
							$amount=$gst->amount;
	                        $gst_per=$gst->item->gst_figure->name;
	                        $tx=100+$gst_per;
							$tax=round(($amount * $gst_per)/$tx);
							?>
							<tr>
								<td><?= $i; $i++;?></td>
	                            <td> <?= $gst->item->item_code?></td>
	                            <td><?= $gst->item->name ?></td>
	                            <td><?= $gst->item_variation->quantity_variation." ".$gst->item_variation->unit->shortname ?></td>
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
					</div>
					<div class="col-md-12"><br></div>
							</div>
						<!-- END FORM-->
						<div id="view_revision">
						
						</div>
						<div class="row" style="padding-top:5px;">
							<div class="col-md-4"></div>
							<div class="col-md-4"></div>
							<div class="col-md-4"> </div>
						</div>
						 
					</div>
				</div>
 		</div>
	</div>

<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
var $rows = $('#main_tble tbody tr');
	$('#search3').on('keyup',function() {
		var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
		var v = $(this).val();
		if(v){ 
			$rows.show().filter(function() {
				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
	
				return !~text.indexOf(val);
			}).hide();
		}else{
			$rows.show();
		}
	});
</script>


<script>
$(document).ready(function(){

	$('.stock_show').die().live("click",function() {
		var current_entity=$(this);
		$(this).closest('td').append('<span class="loading_span">Loading...</span>');
		$(this).closest('td').find(".stock_hide").show();
		var entity=$(this).closest('tr');
		var item_id=$(this).closest('tr').find(".stock_show").attr("itm");
		var url="<?php echo $this->Url->build(['controller'=>'ItemLedgers','action'=>'ajaxItemDetails']);
		?>";
		url=url+'/'+item_id,
		$.ajax({
			url: url,
		}).done(function(response) {
			current_entity.removeClass("stock_show").addClass("stock_hide");
			entity.after(response);
			current_entity.closest('td').find('span.loading_span').remove();
		});		
    });
	
	$('.stock_hide').die().live("click",function() {
		$(this).closest('tr').next().remove();
		$(this).addClass("stock_show").removeClass("stock_hide");
	});


    });
</script>
