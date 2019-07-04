
<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
	vertical-align: top !important;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">CREATE PURCHASE BOOKING </span>
				</div>
				
			</div>
			<div class="portlet-body">
				<?= $this->Form->create($purchaseBooking,['id'=>'form_sample_3']) ?>
				<div class="row">
					<div class="col-md-4">
						<label class=" control-label">GRN Date <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->control('transaction_date',['placeholder'=>'dd-mm-yyyy','class'=>'form-control input-sm date-picker','data-date-format'=>'dd-mm-yyyy','label'=>false,'type'=>'text','value'=>date('d-m-Y')]); ?>
						
					</div>
					<div class="col-md-4">
						<label class=" control-label">vendor <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->control('vendor_id',['options' => $vendors,'class'=>'form-control input-sm','label'=>false]); ?>
					</div>
					<div class="col-md-4">
						<label class=" control-label">Warehouse <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->control('warehouse_id',['options' => $warehouses,'class'=>'form-control input-sm','label'=>false]); ?>
					</div>
				</div><br/>
				<div class="row">
							<div class="col-md-12">
									<div class="form-group">
										<label class="col-md-6 control-label">Additional Note<span class="required" 	aria-required="true">*</span></label>
										 <?= $this->Form->input('additional_note',['class'=>'form-control input-sm','id'=>'msg','label'=>false,'placeholder'=>'','rows'=>'3','style'=>'resize: none;']) ?>
									</div>	 
								</div>
				</div>
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-10">
						<table id="main_table" class="table table-condensed table-bordered">
							<thead>
								<tr align="center">
									<td width="5%">
										<label>Sr<label>
									</td>
									<td width="30%">
										<label>item<label>
									</td>
									
									<td width="20%">
										<label>Variation<label>
									</td>
									<td width="20%">
										<label>Quantity<label>
									</td>
									<td width="20%">
										<label>Rate<label>
									</td>
									<td width="20%">
										<label>Taxable amount<label>
									</td>
									<td width="20%">
										<label>Gst Amount<label>
									</td>
									<td width="20%">
										<label>Net Amount<label>
									</td>
									<td>Delete</td>
								</tr>
							</thead>
							<tbody id="main_tbody">
							
							</tbody>
							<tfoot>
								<tr>
									<td colspan="7" style="text-align:right;">
									<a class="btn btn-default input-sm add_row" href="#" role="button"  style="float: left;"><i class="fa fa-plus"></i> Add Row</a>Total Amount</td>
									<td>
									<?php echo $this->Form->input('total_amount', ['label' => false,'class' => 'form-control input-sm number cal_amount','placeholder'=>'Total Amount','type'=>'text','readonly']); ?>
									</td>
									<td></td>
									</th>
								</tr>
								
							</tfoot>
						</table>
					</div>
					
				</div>
				 
				<br/>
				<center>
				<?= $this->Form->button($this->Html->tag('i') . __(' Submit'),['class'=>'btn btn-success']); ?>
				<?= $this->Form->end() ?>
				</center>
			</div>
		</div>
	</div>

</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {


	$(document).on('change','.show_quantity',function(){
		//alert();
		var quantity=$(this).val();
		var master = $(this); 
		master.closest('tr').find('td:nth-child(4) input.mains').val(quantity);
		master.closest('tr').find('td:nth-child(4) input.mainss').val(quantity);
		
	});

	$(document).on('change','.varition',function(){
		var input=$(this).val();

        var master = $(this); 
		//alert(input);
		if(input.length>0){
            var m_data = new FormData();
            var url ="<?php echo $this->Url->build(["controller" => "Orders", "action" => "getprice"]); ?>";
         //   alert(url);
            m_data.append('input',input); 
            $.ajax({
                url: url,
                data: m_data,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType:'text',
                success: function(response)
                { 
                	//alert(response);
					master.closest('tr').find('td:nth-child(5) .rat_value').val(response);
                }
            });
            }
			calculate_total();
	});

	$(document).on('change','.item-id',function(){
		var gst_figure_id = $('option:selected',this).attr('gst_figure_id');
		
        var input=$(this).val();
        var master = $(this); 
		master.closest('tr').find(".gst_figure_id").val(gst_figure_id);
        master.closest('tr').find("td:nth-child(3) .varition option").remove();
        if(input.length>0){
            var m_data = new FormData();
            var url ="<?php echo $this->Url->build(["controller" => "Orders", "action" => "options"]); ?>";
         //   alert(url);
            m_data.append('input',input); 
            $.ajax({
                url: url,
                data: m_data,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType:'text',
                success: function(data)
                { 
					master.closest('tr').find('td:nth-child(3) .varition').append(data);
                }
            });
        }
		
		calculate_total();
      });

	 $(document).on('blur',".autocompleted",function(){ //alert("blur");
        $('.suggesstion-box').delay(1000).fadeOut(500);
    }); 

    $(document).on('keyup',".autocompleted",function(){// alert("keyup");
        var searchType = $(this).attr('valueType');
        var input=$(this).val();
        var master = $(this); 
        if(input.length>0){
            var m_data = new FormData();
            var url ="<?php echo $this->Url->build(["controller" => "Orders", "action" => "ajaxAutocompleted"]); ?>";
         //   alert(url);
            m_data.append('input',input); 
            m_data.append('searchType',searchType); 
            $.ajax({
                url: url,
                data: m_data,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType:'text',
                success: function(data)
                { 
                	//alert(data);
                    master.closest('div').find('.suggesstion-box').show();
                    master.closest('div').find('.suggesstion-box').html(data);
                   	master.css("background","#FFF");
                }
            });
        }
    });


	
  //--------- FORM VALIDATION
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
				customer_id:{
					required: true
				},
			},

		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.parent(".input-group").size() > 0) {
				error.insertAfter(element.parent(".input-group"));
			} else if (element.attr("data-error-container")) { 
				error.appendTo(element.attr("data-error-container"));
			} else if (element.parents('.radio-list').size() > 0) { 
				error.appendTo(element.parents('.radio-list').attr("data-error-container"));
			} else if (element.parents('.radio-inline').size() > 0) { 
				error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
			} else if (element.parents('.checkbox-list').size() > 0) {
				error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
			} else if (element.parents('.checkbox-inline').size() > 0) { 
				error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
		},

		invalidHandler: function (event, validator) { //display error alert on form submit   
			success3.hide();
			error3.show();
		},

		highlight: function (element) { // hightlight error inputs
		   $(element)
				.closest('.form-group').addClass('has-error'); // set error class to the control group
		},

		unhighlight: function (element) { // revert the change done by hightlight
			$(element)
				.closest('.form-group').removeClass('has-error'); // set error class to the control group
		},

		success: function (label) {
			label
				.closest('.form-group').removeClass('has-error'); // set success class to the control group
		},

		submitHandler: function (form) {
			success3.show();
			error3.hide();
			form[0].submit(); // submit the form
		}

	});
	
	//--	 END OF VALIDATION
	$('.delete-tr').live('click',function() 
	{
		var total_amount=0;
		var rowCount = $('#main_table tbody#main_tbody tr').length; 
		if(rowCount>1)
		{
			 $(this).closest('tr').remove();
			 $("#main_table tbody#main_tbody tr.main_tr").each(function(){ 
			 
			total_amount+=parseFloat($(this).find("td:nth-child(6) input").val());
			
		});
		var amount_from_wallet=parseFloat($('input[name=amount_from_wallet]').val());
		//var total_amount=total_amount-amount_from_wallet;
		//$('input[name=total_amount]').val(total_amount);
		var delivery_charge=parseFloat($('input[name=delivery_charge]').val());
		
		var grand_total=total_amount-amount_from_wallet+delivery_charge;
		$('input[name=total_amount]').val(total_amount);
		$('input[name=pay_amount]').val(grand_total);	 
		}
		rename_rows();
		calculate_total();
    });

	$('.add_row').click(function(){
		add_row();
		calculate_total();
	});

	add_row();
	calculate_total();
	function add_row(){
		var tr=$("#sample_table tbody tr.main_tr").clone();
		$("#main_table tbody#main_tbody").append(tr);
		
		rename_rows();
		
	}



	function calculate_total(){
		var total=0; var gst=0; var gst_total=0;
		$("#main_table tbody#main_tbody tr.main_tr").each(function(){ 
		var tax_percentage=$(this).find('.item-id option:selected').attr('tax_percentage');
			if($.isNumeric(tax_percentage)){
				
			}else{
				tax_percentage=0;
			}
		var obj=$(this).closest('tr');
		var qty=obj.find('td:nth-child(4) input').val();

		// var a=obj.find('td:nth-child(4) .mains').val(qty);
		//  alert(a);
		//alert(qty);
		var rate=obj.find('td:nth-child(5) input').val();
		var amount=qty*rate;
		//alert(amount);
		gst=amount*tax_percentage/100;
		gst_total=amount+gst;
		var gs=Math.round(obj.find('td:nth-child(7) .gst_amount').val(gst));
		Math.round(obj.find('td:nth-child(8) input').val(gst_total));
		
		var rate=Math.round(obj.find('td:nth-child(6) input').val(amount));
		var total_amount=0;
		$("#main_table tbody#main_tbody tr.main_tr").each(function(){ 
			total_amount+=parseFloat($(this).find("td:nth-child(8) input").val());
		});
		var display_amount=Math.round(total_amount);
		if($('input[name=discount_percent]').val())
		{
		var discount_percent=parseFloat($('input[name=discount_percent]').val());
		var discount_amount=Math.round(total_amount*(discount_percent/100));
		var total_amount=Math.round(total_amount-discount_amount);
		}
		if(total_amount<100 && total_amount>0){
			$('input[name=delivery_charge]').val(50);
		}else{
			$('input[name=delivery_charge]').val(0);
		}
		var amount_from_wallet=parseFloat($('input[name=amount_from_wallet]').val());
		var delivery_charge=parseFloat($('input[name=delivery_charge]').val());
		if(!amount_from_wallet){
		amount_from_wallet=0;
		}
		
		var grand_total=Math.round(total_amount+delivery_charge);
		var paid_amount=Math.round(grand_total-amount_from_wallet);
		$('input[name=grand_total]').val(grand_total);
		$('input[name=total_amount]').val(display_amount);
		$('input[name=pay_amount]').val(paid_amount);
		
		});
	}
	
	function rename_rows(){
		//alert();
		var i=0; 
		$("#main_table tbody#main_tbody tr.main_tr").each(function(){ 
			$(this).find('td:nth-child(1)').html(i+1);
			$(this).find("td:nth-child(2) select").select2().attr({name:"purchase_booking_details["+i+"][item_id]", id:"purchase_booking_details-"+i+"-item_id"}).rules('add', {
						required: true
					});
			$(this).find("td:nth-child(3) select").attr({name:"purchase_booking_details["+i+"][item_variation_id]"}).rules('add', {
						required: true
					});
			$(this).find("td:nth-child(4) input").attr({name:"purchase_booking_details["+i+"][show_quantity]", id:"purchase_booking_details-"+i+"-show_quantity"}).rules('add', {
						required: true
					});
			$(this).find(".mains").attr({name:"purchase_booking_details["+i+"][quantity]", id:"purchase_booking_details-"+i+"-quantity"}).rules('add', {
						required: true
					});
			$(this).find(".mainss").attr({name:"purchase_booking_details["+i+"][invoice_quantity]", id:"purchase_booking_details-"+i+"-actual_quantity"}).rules('add', {
						required: true
					});
			$(this).find("td:nth-child(5) input").attr({name:"purchase_booking_details["+i+"][rate]", id:"purchase_booking_details-"+i+"-rate"}).rules('add', {
				required: true
			});
			$(this).find("td:nth-child(6) input").attr({name:"purchase_booking_details["+i+"][amount]", id:"purchase_booking_details-"+i+"-amount"}).rules('add', {
				required: true
			});
			$(this).find("td:nth-child(7) .gst_amount").attr({name:"purchase_booking_details["+i+"][gst_amount]", id:"purchase_booking_details-"+i+"-gst_amount"});
			$(this).find("td:nth-child(7) .gst_figure_id").attr({name:"purchase_booking_details["+i+"][gst_figure_id]", id:"purchase_booking_details-"+i+"-gst_figure_id"});
			$(this).find("td:nth-child(8) .net_amount").attr({name:"purchase_booking_details["+i+"][net_amount]", id:"purchase_booking_details-"+i+"-net_amount"});
			
			i++;
		});
		//calculate_total();
	}
	$(document).on('keyup','.cal_amount',function(){ 
	calculate_total();
		
	});

	$(".attribute").die().live('change',function(){
		var raw_attr_name = $('option:selected', this).attr('print_quantity');
		var raw_attr_rates = $('option:selected', this).attr('sales_rate');
		var raw_attr_unit_name3 = $('option:selected', this).attr('unit_name');
		var raw_attr_minimum_quantity_factor = $('option:selected', this).attr('minimum_quantity_factor');
		var raw_attr_minimum_quantity_purchase = $('option:selected', this).attr('minimum_quantity_purchase');
		var amount=raw_attr_minimum_quantity_factor*raw_attr_rates;
		var is_combo=$('option:selected', this).attr('is_combo');
		
		$(this).closest('tr').find('.msg_shw').html("selling factor in : "+ raw_attr_minimum_quantity_factor +" "+ raw_attr_unit_name3);
		$(this).closest('tr').find('.is_combo').val(is_combo);
		$(this).closest('tr').find('.rat_value').val(raw_attr_rates);
		$(this).closest('tr').find('.quant').val(1);
		
		$(this).closest('tr').find('.msg_shw2').html(raw_attr_minimum_quantity_factor+" "+raw_attr_unit_name3);
		//$(this).closest('tr').find('.mains').val(raw_attr_minimum_quantity_factor);
		$(this).closest('tr').find('.mainss').val(raw_attr_minimum_quantity_factor);
		$(this).closest('tr').find('.quant').attr('minimum_quantity_factor', +raw_attr_minimum_quantity_factor);
		$(this).closest('tr').find('.quant').attr('unit_name', ''+raw_attr_unit_name3+'');
		$(this).closest('tr').find('.show_amount').val(amount);
		//$(this).closest('tr').find('.quant').attr('max', +raw_attr_minimum_quantity_purchase);
		calculate_total();
	});


	// $(".quant").die().live('keyup',function(){
	// 	//alert();
	// 	var quant = parseFloat($(this).val());
	// 	var master=$(this)
	// 	var minimum_quantity_factor = parseFloat($(this).attr('minimum_quantity_factor'));
	// 	var item_id =$(this).closest('tr').find('td:nth-child(2) select').val();
	// 	var variation_id =$(this).closest('tr').find('td:nth-child(3) select').val();
 //        $.ajax({
 //            url: "<?php echo $this->Url->build(["controller" => "ItemLedgers", "action" => "ajaxQuantity"]); ?>",
 //            type: 'post',
 //            data: {item_id: item_id,variation_id:variation_id},
 //           success: function(data)   // A function to be called if request succeeds
	// 				{
	// 					//alert(data);
	// 					master.closest('tr').find('span.total').html(data);
	// 					if(quant > data)
	// 					{
	// 						master.closest('tr').find('.show_quantity').val('');
	// 					}
	// 				}	
 //            });



	// // 	if(!minimum_quantity_factor){ minimum_quantity_factor=0; }
	// // 	var unit_name = $(this).attr('unit_name');
	// //  if(!unit_name){ unit_name=0; }
	// // var g_total = quant*minimum_quantity_factor;
	// // alert(g_total);
 // // $(this).closest('tr').find('.msg_shw2').html(g_total.toFixed(2));
	// 	// //$(this).closest('tr').find('.mains').val(g_total.toFixed(2));
	// 	// $(this).closest('tr').find('.mainss').val(g_total.toFixed(2));
	// 	calculate_total();
	// });
	
	$(document).on('keyup', '.number', function(e)
    { 
		var mdl=$(this).val();
		var numbers =  /^[0-9]*$/;
		if(mdl.match(numbers))
		{
		}
		else
		{
			$(this).val('');
			return false;
		}
    });
	
	$("#delivery_id").die().live('change',function(){
		var raw_time_name = $('option:selected', this).text();
		$('#del_time').val(raw_time_name);
		//$(this).closest('tr').find('.quant').attr('max', +raw_attr_minimum_quantity_purchase);
	});
	
	
	
	
	
});
</script>
<script>
function selectAutoCompleted(ids,value) { 
	
    $('.selectedAutoCompleted').val(value);
    $('#customer_id').val(ids);
    $(".suggesstion-box").hide();     
}
function selectAutoCompleted1(value) {  
    $('.selectedAutoCompleted1').val(value);
    $(".suggesstion-box").hide();     
}
</script>
<table id="sample_table" style="display:none;" >
			<tbody>
				<tr class="main_tr" class="tab">
					<td align="center" width="1px"></td>
				    <td>
				    	<?php echo $this->Form->control('item_id',['empty'=>'--Select Item--','options' => $items,'class'=>'form-control input-sm chosen-select item-id','label'=>false]); ?>

					</td>
					<td>
						<select name="variation" class="form-control input-sm varition">
							
							
						</select>

						<span class="msg_shw2" style="color:blue;font-size:12px;"></span>
					</td>
					<td>
						<?php echo $this->Form->input('show_quantity', ['label' => false,'class' => 'form-control input-sm number cal_amount quant show_quantity','placeholder'=>'Quantity']); ?>
						
						<span class="msg_shw2 total"  style="color:blue;font-size:12px;"></span>
							<?php echo $this->Form->input('quantity', ['label' => false,'class' => 'form-control input-sm number mains quantity','value'=>0, 'type'=>'hidden']); ?>
							<?php echo $this->Form->input('invoice_quantity', ['label' => false,'class' => 'form-control input-sm number mainss actual_quantity','value'=>0, 'type'=>'hidden']); ?>
					</td>
					<td>
						<?php echo $this->Form->input('rate', ['label' => false,'class' => 'form-control input-sm number cal_amount rat_value']); ?>	
					</td>
					<td>
						<?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm number cal_amount show_amount','placeholder'=>'Amount','readonly','value'=>0]); ?>	
						<?php echo $this->Form->input('is_combo', ['label' => false,'class' => 'form-control input-sm is_combo','type'=>'hidden']); ?>
					</td>	
					<td>
						<?php echo $this->Form->input('gst_amount', ['label' => false,'class' => 'form-control input-sm number cal_amount gst_amount','readonly']); ?>	
						<?php echo $this->Form->input('gst_figure_id', ['label' => false,'class' => 'form-control input-sm gst_figure_id','type'=>'hidden']); ?>
					</td>
					<td>
						<?php echo $this->Form->input('net_amount', ['label' => false,'class' => 'form-control input-sm number cal_amount net_amount','readonly']); ?>	
					</td>
                    <td>
						<a class="btn btn-default delete-tr input-sm" href="#" role="button" ><i class="fa fa-times"></i></a>
					</td>
					
				</tr>
			</tbody>
		</table>
		
<div id="myModal1" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false" style="display: ; padding-right: 12px;"><div class="modal-backdrop fade in" ></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" id="result_ajax">
				
			</div>
			 <div class="modal-footer">
				<button class="btn default closebtn">Close</button>
			</div>
		</div>
	</div>
</div>
<!-----Address-->
<div class="modal fade" id="address" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Address</h4>
			</div><form id="form1">
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
						<label class=" control-label">Name<span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->input('name',['placeholder'=>'Name','class'=>'form-control input-sm','label'=>false,'required']); ?>
					</div>
					<div class="col-md-6">
					<label class=" control-label">Mobile <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->input('mobile',['placeholder'=>'Mobile','class'=>'form-control input-sm','label'=>false,'required']); ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label class=" control-label">House no <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->input('house_no',['placeholder'=>'House no','class'=>'form-control input-sm','label'=>false,'required']); ?>
					</div>
					<div class="col-md-6">
						<label class=" control-label">Locality<span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->input('locality',['placeholder'=>'locality','class'=>'form-control input-sm','label'=>false,'required']); ?>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<label class=" control-label">Address<span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->input('address',['placeholder'=>'Address','class'=>'form-control input-sm','label'=>false,'cols'=>1,'required']); ?>
					</div>
					
				</div>
				
				
			
			</div>
			<div class="modal-footer">
				<button type="button" class="btn default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success btnsubmit">Save changes</button>
			</div>
			</form>
		</div>
	</div>
</div>



