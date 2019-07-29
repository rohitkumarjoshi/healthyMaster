<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
	vertical-align: top !important;
}
.error{
	color:#a94442;
}
#item-list{list-style:none;margin-left: 1px;padding:0;width:91%; margin-top: 10px;    position: absolute;
z-index: 1000;
background-color: #fff;}
#item-list li{padding: 7px; background: #d8d4d41a ; border: 1px solid #bbb9b933;}
#item-list li:hover{background:#d8d4d4;cursor: pointer;}
</style>
<div class="row"><div class="col-md-1"></div>
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<!--<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense "><i class="fa fa-plus"></i> Create Order </span>
				</div>-->

			</div>
			<div class="portlet-body">
				<?= $this->Form->create($order,['id'=>'form_sample_3']) ?>
				<?php 
				if(!empty($bulkorder_id)){
					foreach($bulk_Details as $bulk_Detail){
						$bulk_image=$bulk_Detail->image;
						$bulk_delivery_date=date('d-M-Y', strtotime($bulk_Detail->delivery_date));
						$bulk_delivery_time=$bulk_Detail->delivery_time;
					}
				}
					?>
				<div class="row">
					<div class="col-md-2">
						<label class=" control-label">Mobile No <span class="required" aria-required="true">*</span></label>
						<input type="number" name="customer" class="form-control input-sm selectedAutoCompleted autocompleted customer_id cstmr chosen-select" valueType="item_name" id="mobile" autocomplete="off">
						<input type="hidden" name="customer_id" id="customer_id">
						
						 <div class="suggesstion-box box"  autocomplete="off"></div>
					</div>
					<a href="#" role="button" class="pull-left plus" style="margin-top: 26px;" >
							 +</a>
						
						<?php echo $this->Form->control('warehouse_id',['options' => $warehouses,'class'=>'form-control input-sm','id'=>'customer_id','label'=>false,'type'=>'hidden']); ?>
					
					
					<div class="col-md-2">
						<label class="control-label">Customer Name<span class="required" aria-require>*</span></label>
						<?php echo $this->Form->control('customer_name',['class'=>'form-control input-sm customer_name','label'=>false,'type'=>'text']); ?>
					</div>
					

					<div class="col-md-2">
						<label>Payment Mode</label>
						<select name="order_type" class="form-control select2me input-sm">
							<option>--Select--</option>
							<option value="COD">COD</option>
							<option value="Online">Paytm</option>
							<option value="Online">Google Pay</option>
							<option value="Online">Credit Card</option>
						</select>
					</div>
					<div class="col-md-2">
						<label class="control-label">Order Date <span class="required" aria-require>*</span></label>
						<?php echo $this->Form->control('order_date1',['placeholder'=>'dd-mm-yyyy','class'=>'form-control input-sm date-picker','data-date-format'=>'dd-mm-yyyy','label'=>false,'type'=>'text','value'=>date('d-m-Y')]); ?>
					</div>
					<div class="col-md-2">
						<label class="control-label">Delivery Date<span class="required" aria-require>*</span></label>
						<?php echo $this->Form->control('delivery_date',['placeholder'=>'dd-mm-yyyy','class'=>'form-control input-sm date-picker','data-date-format'=>'dd-mm-yyyy','label'=>false,'type'=>'text','value'=>date('d-m-Y')]); ?>
						<?php echo $this->Form->control('delivery_time',['class'=>'form-control input-sm','label'=>false,'type'=>'hidden','value'=>date("G:i a")]); ?>
					</div>
					<!-- Vaibhav Sir <div class="col-md-2">
						<label class="control-label">Delivery Time <span class="required" aria-require>*</span></label>			
						<?php
						foreach($deliverytime_fetchs as $deliverytime_fetch){
							$time_id=$deliverytime_fetch->id;
							$time_from=$deliverytime_fetch->time_from;
							$time_to=$deliverytime_fetch->time_to;
							$delivery_time[]= ['value'=>$time_id,'text'=>$time_from. " - " .$time_to];?>

					<?php } ?>
										
						<?= $this->Form->input('delivery_time_id', ['empty'=>'--Select time--','class'=>'form-control input-sm select2me','id'=>'delivery_id','label'=>false,'options'=>$delivery_time]) ?>
					</div>
					<div class="col-md-1">
						<?= $this->Form->input('delivery_time', ['class'=>'form-control','label'=>false,'type'=>'hidden','id'=>'del_time']) ?>
					</div> -->
					<button class="btn btn-primary prev pull-right">Previous History</button>
					
				<!--<?php if(!empty($bulkorder_id)){ ?>
					<div class="col-md-4" align="center">
						<label class=" control-label">Delivery Date</label><br>
						<?php echo $bulk_delivery_date; ?>
					</div>
						<div class="col-md-4" align="center">
						<label class=" control-label">Delivery Time</label><br>
						<?php echo $bulk_delivery_time; ?>
					</div>
				<?php } ?>
				-->
				</div><br/>
				<div class="row">
					<!-- <?php if($order_type=="Bulkorder"){ ?>
				
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Provide Cash Back<span class="required" aria-required="true">*</span></label>
							<div class="radio-list">
								<div class="radio-inline" style="padding-right: 5px;">
									<?php echo $this->Form->radio(
									'cash_back_flag',
									[
										['value' => 'no', 'text' => 'Yes','class' => 'radio-task'],
										['value' => 'yes', 'text' => 'No','class' => 'radio-task','checked' => 'checked']
									]
									); ?>
								</div>
							</div>
						</div>
					</div>
			
				<?php } ?>
				 -->
					<div class="col-md-6">
						<label class="control-label">Address</label>
							<?php echo $this->Form->input('customer_address_id', ['type'=>'hidden','label' => false,'class' => 'form-control','placeholder' => 'Address']); ?>
							<?php echo $this->Form->input('customer_address', ['label' => false,'class' => 'form-control','placeholder' => 'Address','rows'=>'5','cols'=>'5','readonly']); ?>
							<a href="#" role="button" class="pull-left add_address"  >
							 Add Address </a>
							<a href="#" role="button" class="pull-right select_address" >
							Select Address </a>
					</div>
					
					
				</div>
				
				<div class="row">
					
				</div>
				
				<div class="col-md-12"><br/></div>
				<div class="row">
					
					<div class="col-md-12">
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
										<label>amount<label>
									</td>
									
									<td>Delete</td>
								</tr>
							</thead>
							<tbody id='main_tbody' class="tab">
								
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5" style="text-align:right;">
									<a class="btn btn-default input-sm add_row" href="#" role="button"  style="float: left;"><i class="fa fa-plus"></i> Add Row</a>
									 Total Amount</td>
									<td>
									<?php echo $this->Form->input('total_amount', ['label' => false,'class' => 'form-control input-sm number cal_amount','placeholder'=>'Total Amount','type'=>'text','readonly']); ?>
									</td>
									<td></td>
								</tr>
								<tr>
									<td colspan="5" style="text-align:right;">
									Delivery Charge
									</td>
									<td>
									<?php echo $this->Form->control('delivery_charge',['placeholder'=>'Amount From Wallet','class'=>'number form-control input-sm cal_amount dlvry','label'=>false,'type'=>'text','value'=>0,'readonly']); ?>
									</td>
									<td></td>
								</tr>
								<tr>
									<td colspan="5" style="text-align:right;">Grand Total</td>
									<td><?php echo $this->Form->input('grand_total', ['label' => false,'class' => 'form-control input-sm number ','placeholder'=>'Total Amount','type'=>'text','readonly']); ?>
									</td>
								</tr>
								<tr>
									<td colspan="5" style="text-align:right;">
									Amount From Wallet
									</td>
									<td>
									<?php echo $this->Form->control('amount_from_wallet',['placeholder'=>'Amount From Wallet','class'=>'number form-control input-sm cal_amount amount_from_wallet','label'=>false,'type'=>'text','value'=>0]); ?>
									</td>
									<td></td>
								</tr>
								
								<tr>
									<td colspan="5" style="text-align:right;">
									Paid Amount
									</td>
									<td>
									<?php echo $this->Form->input('pay_amount', ['label' => false,'class' => 'form-control input-sm number cal_amount','placeholder'=>'Total Amount','type'=>'text','readonly']); ?>
									</td>
									<td></td>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="col-md-4">
						<?php if(!empty($bulkorder_id)){ ?>
						<?php echo $this->Html->image('/img/bulkbookingimages/'.$bulk_image.'', ['height' => '200px','width' => '320px']); ?>
						<?php } ?>
					</div>
				</div>
				
				 
				<br/>
				<center>
				<?= $this->Form->button($this->Html->tag('i', '', ['class'=>'fa fa-plus']) . __(' Submit'),['class'=>'btn btn-success']); ?>
				</center>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
<div class="col-md-1"></div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {

	$(document).on('click','.prev',function(){
		//alert();
		var customer_id=$('#customer_id').val();
			//alert(customer_id);
			if(customer_id == ""){
				alert("Please Select Customer First");
			}else{
				var url = "<?php echo $this->Url->build(["controller" => "Customers", "action" => "CustomerLedger"]); ?>";
          		 window.open(url+'/'+customer_id, '_blank');
			}
	});

	$(document).on('change','.show_quantity',function(){
		//alert();
		var quantity=$(this).val();
		var master = $(this); 
		master.closest('tr').find('td:nth-child(4) input.mains').val(quantity);
		
	});

	$(document).on('change','.varition',function(){
		var input=$(this).val();

        var master = $(this); 
		//alert(input);
		if(input.length>0){
            var m_data = new FormData();
            var url ="<?php echo $this->Url->build(["controller" => "Orders", "action" => "getprice"]); ?>";
         // alert(input);
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
					var nameArr = response.split(',');
                	var rte=(nameArr[0]);
                	var mxx=(nameArr[1]);  alert(response);
					master.closest('tr').find('td:nth-child(5) .rat_value').val(rte);
					master.closest('tr').find('td:nth-child(4) .show_quantity').val(0);
					master.closest('tr').find('span.total').html(mxx);
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
            var url ="<?php echo $this->Url->build(["controller" => "Orders", "action" => "optionsnew"]); ?>";
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
					master.closest('tr').find('span.total').html('');
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
					required: true,
				},
				order_type:{
					required: true,
				}
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

function round(value, exp) {
          if (typeof exp === 'undefined' || +exp === 0)
            return Math.round(value);

          value = +value;
          exp = +exp;

          if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
            return 0;

          // Shift
          value = value.toString().split('e');
          value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));

          // Shift back
          value = value.toString().split('e');
          return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
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
		
		gst=(amount*tax_percentage)/(parseFloat(100)+parseFloat(tax_percentage));
		
		gst=round(gst,2);
		gst_total=amount-gst;
		var gs=Math.round(obj.find('td:nth-child(6) .gst_amount').val(gst));
		Math.round(obj.find('td:nth-child(6) .net_amount').val(gst_total));
		
		var rate=Math.round(obj.find('td:nth-child(6) .show_amount').val(amount));
		var total_amount=0;
		$("#main_table tbody#main_tbody tr.main_tr").each(function(){ 
			total_amount+=parseFloat($(this).find("td:nth-child(6) .show_amount").val());
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
			$(this).find("td:nth-child(2) select").select2().attr({name:"order_details["+i+"][item_id]", id:"order_details-"+i+"-item_id"}).rules('add', {
						required: true
					});
			$(this).find("td:nth-child(3) select").attr({name:"order_details["+i+"][item_variation_id]"}).rules('add', {
						required: true
					});
			$(this).find("td:nth-child(4) input").attr({name:"order_details["+i+"][show_quantity]", id:"order_details-"+i+"-show_quantity"}).rules('add', {
						required: true
					});
			$(this).find(".mains").attr({name:"order_details["+i+"][quantity]", id:"order_details-"+i+"-quantity"}).rules('add', {
						required: true
					});
			$(this).find(".mainss").attr({name:"order_details["+i+"][actual_quantity]", id:"order_details-"+i+"-actual_quantity"}).rules('add', {
						required: true
					});
			$(this).find("td:nth-child(5) input").attr({name:"order_details["+i+"][rate]", id:"order_details-"+i+"-rate"}).rules('add', {
				required: true
			});
			$(this).find("td:nth-child(6) .show_amount").attr({name:"order_details["+i+"][amount]", id:"order_details-"+i+"-amount"}).rules('add', {
				required: true
			});
			$(this).find("td:nth-child(6) .gst_amount").attr({name:"order_details["+i+"][gst_amount]", id:"order_details-"+i+"-gst_amount"});
			$(this).find("td:nth-child(6) .gst_figure_id").attr({name:"order_details["+i+"][gst_figure_id]", id:"order_details-"+i+"-gst_figure_id"});
			$(this).find("td:nth-child(6) .net_amount").attr({name:"order_details["+i+"][net_amount]", id:"order_details-"+i+"-net_amount"});
			
			i++;
		});
		//calculate_total();
	}
	<?php
	if($order_type=='Bulkorder')
	{
	?>
		$(document).on('change','#customer_id',function(){ 
			var customer_id=$(this).val();
			$('#data').html('<i style= "margin-top: 20px;" class="fa fa-refresh fa-spin fa-3x fa-fw"></i><b> Loading... </b>');
				var m_data = new FormData();
				m_data.append('customer_id',customer_id);
				$('#discount').remove();
				$.ajax({
					url: "<?php echo $this->Url->build(["controller" => "Orders", "action" => "ajax_customer_discount"]); ?>",
					data: m_data,
					processData: false,
					contentType: false,
					type: 'POST',
					dataType:'text',
					success: function(data)   // A function to be called if request succeeds
					{
						$('#main_table tfoot').prepend(data);
						calculate_total();
					}	
				});	
				
		});
			
	<?php
	}
	?>
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

	$(".quant").die().live('keyup',function(){
		//alert();
		var quant = parseFloat($(this).val());
		var master=$(this)
		var minimum_quantity_factor = parseFloat($(this).attr('minimum_quantity_factor'));
		var item_id =$(this).closest('tr').find('td:nth-child(2) select').val();
		var variation_id =$(this).closest('tr').find('td:nth-child(3) select').val();
        $.ajax({
            url: "<?php echo $this->Url->build(["controller" => "ItemLedgers", "action" => "ajaxQuantityNew"]); ?>",
            type: 'post',
            data: {item_id: item_id,variation_id:variation_id},
           success: function(data)   // A function to be called if request succeeds
					{
						//alert(data);
						master.closest('tr').find('span.total').html(data);
						if(quant > data)
						{
							master.closest('tr').find('.show_quantity').val('');
						}
					}	
            });



	// 	if(!minimum_quantity_factor){ minimum_quantity_factor=0; }
	// 	var unit_name = $(this).attr('unit_name');
	//  if(!unit_name){ unit_name=0; }
	// var g_total = quant*minimum_quantity_factor;
	// alert(g_total);
 // $(this).closest('tr').find('.msg_shw2').html(g_total.toFixed(2));
		// //$(this).closest('tr').find('.mains').val(g_total.toFixed(2));
		// $(this).closest('tr').find('.mainss').val(g_total.toFixed(2));
		calculate_total();
	});
	
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
	///default Address
	$('.closebtn').live("click",function() { 
		$(".modal").hide();
    });
	
	$('.select_address').on("click",function() { 
		open_address();
    });
	
	$('.add_address').on("click",function() {
			var customer_id=$('#customer_id').val();
			//alert(customer_id);
			if(customer_id == ""){
				alert("Please Select Customer First");
			}else{
				$('#address').modal('show');
				var validator = $( "#myForm1" ).validate();
				//$('#form1')[0].reset();
				$("label.error").hide();
				$(".error").removeClass("error");
			}
			
			//validator.reset();
		calculate_total();	
	});
	$('.plus').on("click",function() {
			
				$('#customer').modal('show');
				//var validator = $( "#myForm1" ).validate();
				//$('#form1')[0].reset();
				$("label.error").hide();
				$(".error").removeClass("error");
	});

	$('.btnsave').on("click",function(e) {
		$("#form2").validate({ 
			submitHandler: function(form) {
					$("#form2").submit(function(e) {
						e.preventDefault();
					});
					
					var mobile=$('.number_mobile').val();
					var name_val=$('.name').val();
					//alert(name_val);
					if(name_val == '')
					{
						var name="null";
					}
					else
					{
						var name=$('.name').val();
					}
					//alert(name);
					var email_val=$('.emails').val();
					if(email_val == '')
					{
						var email="null";
					}
					else
					{
						var email=$('.emails').val();
					}
					//alert(email);
					var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'save']); ?>";
					url=url+'/'+mobile+'/'+name+'/'+email,
					//alert(url);
					$.ajax({
						url: url,
					}).done(function(response) {
						//alert(response);
						$('#customer').hide();
						$('#customer_id').val(response);
						var cus_id=response;
						//alert(cus_id);
						var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'lastinsertmobile']); ?>";
						url=url+'/'+cus_id,
						//alert(url);
						$.ajax({
							url: url,
						}).done(function(response) {
							//alert(response);
							$('#mobile').val(response);
							var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'lastinsertname']); ?>";
						url=url+'/'+cus_id,
						//alert(url);
						$.ajax({
							url: url,
						}).done(function(response) {
							//alert(response);
							$('.customer_name').val(response);
						});
						});

					});
		}		
	});
	});
	
	$('.btnsubmit').on("click",function(e) {
		$("#form1").validate({ 
			submitHandler: function(form) {
					$("#form1").submit(function(e) {
						e.preventDefault();
					});
					var customer_id=$('#customer_id').val();
					if(customer_id == ""){
						alert("Please Select Customer First");
					}
					var name=$('input[name="name"]').val();
					//alert(name);
					var mobile=$('input[name="mobile"]').val();
					var house_no=$('input[name="house_no"]').val();
					var address=$('textarea[name="address"]').val();
					var locality=$('input[name="locality"]').val();
					var pincode=$('input[name="pin_code"]').val();
					var apartment_name=$('input[name="apartment_name"]').val();
					var state_id=$('select#modal_state option').filter(":selected").val();
					var city_id=$('.city').val();
					var address_type=$('input[name="address_type"]:checked').val();
					var default_address=$('input[name="default_address"]:checked').val();
					//alert(default_address);
					var url="<?php echo $this->Url->build(['controller'=>'CustomerAddresses','action'=>'saveAddress']); ?>";
					url=url+'/'+customer_id+'/'+name+'/'+mobile+'/'+house_no+'/'+address+'/'+locality+'/'+default_address+'/'+pincode+'/'+apartment_name+'/'+address_type+'/'+state_id+'/'+city_id,
					//alert(url);
					$.ajax({
						url: url,
					}).done(function(response) {
						$('#address').hide();
						var customer_id=$('#customer_id').val();
						var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'defaultAddress']); ?>";
						url=url+'/'+customer_id,	
						$.ajax({
							url: url,
						}).done(function(response) { 
							//alert(response);
							$('textarea[name="customer_address"]').val(response);
							var customer_id=$('#customer_id').val();
							var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'defaultAddress1']); ?>";
							url=url+'/'+customer_id,
							$.ajax({
								url: url,
							}).done(function(response) { 
								//alert(response);
								$('input[name="customer_address_id"]').val(response);
							});
							$('#address').modal('toggle');
							//$('#address input').val('');
							//$('#address textarea').val('');
						});
					});
		}});		
	});
	
	
	function open_address(){
		var customer_id=$('#customer_id').val();
		$("#result_ajax").html('<div align="center"><?php echo $this->Html->image('/img/wait.gif', ['alt' => 'wait']); ?> Loading</div>');
		var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'addressList']); ?>";
		url=url+'/'+customer_id,
		$("#myModal1").show();
		$.ajax({
			url: url,
		}).done(function(response) {
			$("#result_ajax").html(response);
		});
	}
	
	
	// $('.insert_address').die().live("click",function() { 
	// 	var addr=$(this).text();
	// 	var addr_id=$(this).attr('addressid');
	// 	$('textarea[name="customer_address"]').val(addr);
	// 	$('input[name="customer_address_id"]').val(addr_id);
	// 	$("#myModal1").hide();
	// 	var customer_id=$('#customer_id').val();
	// 	var url="<?php echo $this->Url->build(['controller'=>'CustomerAddresses','action'=>'adddefaultAddress']); ?>";
	// 	url=url+'/'+customer_id+'/'+addr_id,
	// 	$.ajax({
	// 		url: url,
	// 	}).done(function(response) { 
	// 	});
 //    });
	
	
	$('.box').on("click",function() {
		//alert();
		var customer_id=$('#customer_id').val();
		//alert(customer_id);
		var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'defaultAddress']); ?>";
		url=url+'/'+customer_id,
		
		$.ajax({
			url: url,
		}).done(function(response) { 
			//alert(response);
			if(response == ' '){
				$('#address').modal({ keyboard: false, backdrop: 'static'}).show();
				var validator = $( "#myForm1" ).validate();
			$('#form1')[0].reset();
			$("label.error").hide();
			$(".error").removeClass("error");
			//validator.reset();
  			}else{	
 				$('textarea[name="customer_address"]').val(response);
 				var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'defaultAddress1']); ?>";
							url=url+'/'+customer_id,
							$.ajax({
								url: url,
							}).done(function(response) { 
								//alert(response);
								$('input[name="customer_address_id"]').val(response);
							});
			}
			var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'lastinsertname']); ?>";
			url=url+'/'+customer_id,
			//alert(url);
			$.ajax({
				url: url,
			}).done(function(response) { 
				//alert(response)
				$('.customer_name').val(response);
			});
		});
	});
	// $('.customer_id').on("change",function() {
	// 	var customer_id=$('#customer_id').val();
		
	// 	var url="<?php echo $this->Url->build(['controller'=>'Customers','action'=>'defaultAddress1']); ?>";
	// 	url=url+'/'+customer_id,
		
	// 	$.ajax({
	// 		url: url,
	// 	}).done(function(response) { 
	// 		if(response == ' '){
	// 			$('#address').modal({ keyboard: false, backdrop: 'static'}).show();
	// 			var validator = $( "#myForm1" ).validate();
	// 		$('#form1')[0].reset();
	// 		$("label.error").hide();
	// 		$(".error").removeClass("error");
	// 		validator.reset();
 // 			}else{	
 // 				$('input[name="customer_address_id"]').val(response);
	// 		}
	// 	});
	// });
	///wallet
	// $('.cstmr').on("click",function() {
	// 	var customer_id=$('customer_id').val();
	
	// 	var url="<?php echo $this->Url->build(['controller'=>'Wallets','action'=>'checksubtract']); ?>";
	// 	url=url+'/'+customer_id,
	// 		$.ajax({
	// 			url: url,
	// 			type: 'GET',
	// 		}).done(function(response) { 
	// 			$('.amount_from_wallet').attr('max',response);
	// 		});
	// });
	$(document).on('change','.modal_mobile',function(){
		var input=$(this).val();

        var master = $(this); 
		//alert(input);
		if(input.length>0){
            var m_data = new FormData();
            var url ="<?php echo $this->Url->build(["controller" => "Customers", "action" => "check"]); ?>";
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
                	if(response == 1)
                	{
						$('.modal_mobile').val('');
						alert("Mobile No Already Exists")
					}


                }
            });
            }
	});
	$(document).on('change','.state',function(){
        
        var input=$(this).val();
        var master = $(this); 
        $(".city option").remove();
        if(input.length>0){
            var m_data = new FormData();
            var url ="<?php echo $this->Url->build(["controller" => "Pincodes", "action" => "options"]); ?>";
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
                    $('.city').append(data);
                }
            });
        }
});
	$('input[name="default_address"]').on('click',function()
	{
		var default_address=$(this).val();
		if(default_address == "1")
		{
			var customer_id=$('#customer_id').val();
			var url="<?php echo $this->Url->build(['controller'=>'CustomerAddresses','action'=>'defaultcheck']); ?>";
						url=url+'/'+customer_id,

			//alert(url);	
						$.ajax({
							url: url,
						}).done(function(response) { 
							//alert(response);
						});
		}
		// if(default_address == "0")
		// {
		// 	var customer_id=$('#customer_id').val();
		// 	var url="<?php echo $this->Url->build(['controller'=>'CustomerAddresses','action'=>'defaultcheck1']); ?>";
		// 				url=url+'/'+customer_id,

		// 	//alert(url);	
		// 				$.ajax({
		// 					url: url,
		// 				}).done(function(response) { 
		// 					//alert(response);
		// 				});
		// }
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
							<?php echo $this->Form->input('actual_quantity', ['label' => false,'class' => 'form-control input-sm number mainss actual_quantity','value'=>0, 'type'=>'hidden']); ?>
					</td>
					<td>
						<?php echo $this->Form->input('rate', ['label' => false,'class' => 'form-control input-sm number cal_amount rat_value','readonly']); ?>	
					</td>
					<td>
						<?php echo $this->Form->input('amount', ['label' => false,'class' => 'form-control input-sm number cal_amount show_amount','placeholder'=>'Amount','readonly','value'=>0]); ?>	
						<?php echo $this->Form->input('is_combo', ['label' => false,'class' => 'form-control input-sm is_combo','type'=>'hidden']); ?>
						
						<?php echo $this->Form->input('gst_amount', ['label' => false,'class' => 'form-control input-sm number cal_amount gst_amount','readonly','type'=>'hidden']); ?>	
						<?php echo $this->Form->input('gst_figure_id', ['label' => false,'class' => 'form-control input-sm gst_figure_id','type'=>'hidden']); ?>
						<?php echo $this->Form->input('net_amount', ['label' => false,'class' => 'form-control input-sm number cal_amount net_amount','readonly','type'=>'hidden']); ?>	
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
					<div class="col-md-8">
						<div class="form-group">
							<label class="control-label">Address Type<span class="required" aria-required="true">*</span></label>
							<div class="radio-list">
								<div class="radio-inline" style="padding-left: 0px;">
									<?php echo $this->Form->radio(
									'address_type',
									[
										['value' => 'Home', 'text' => 'Home','class' => 'radio-task virt address','checked' => 'checked'],
										['value' => 'Office', 'text' => 'Office','class' => 'radio-task virt address'],
										['value' => 'Work', 'text' => 'Work','class' => 'radio-task virt address'],
										['value' => 'Other', 'text' => 'Other','class' => 'radio-task virt address']
									]
									); ?>
								</div>
                            </div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label class=" control-label">Name<span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->input('name',['placeholder'=>'Name','class'=>'form-control input-sm','label'=>false,'required']); ?>
					</div>
					<div class="col-md-6">
					<label class=" control-label">Mobile <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->input('mobile',['placeholder'=>'Mobile','class'=>'form-control input-sm','label'=>false,'required','type'=>'number','maxlength'=>10,'minlength'=>10]); ?>
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
					<div class="col-md-6">
						<label class=" control-label">Pincode<span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->input('pin_code',['placeholder'=>'Pincode','class'=>'form-control input-sm','label'=>false,'required','minlength'=>6,'maxlength'=>6]); ?>
					</div>
					<div class="col-md-6">
						<label class=" control-label">Apartment<span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->input('apartment_name',['placeholder'=>'Apartment','class'=>'form-control input-sm','label'=>false,'required']); ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<?php echo $this->Form->control('state_id', ['empty'=>'-- select --','options' => $statesdata,'class'=>'form-control input-sm select select2me select2 state','required','id'=>'modal_state','required']); ?>
					</div>
					<div class="col-md-6">
                       <label class="control-label">City <span class="required" aria-required="true">* </label>
                        <select name="city_id" class="form-control input-sm city select2" required>
                            
                           
                            
                        </select>
                 	</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<label class=" control-label">Address<span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->input('address',['placeholder'=>'Address','class'=>'form-control input-sm','label'=>false,'cols'=>1,'required']); ?>
					</div>
				
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Default Address<span class="required" aria-required="true">*</span></label>
							<div class="radio-list">
								<div class="radio-inline default" style="padding-left: 0px;">
									<?php echo $this->Form->radio(
									'default_address',
									[
										['value' => '0', 'text' => 'No','class' => 'radio-task virt ','checked' => 'checked'],
										['value' => '1', 'text' => 'Yes','class' => 'radio-task virt ']
									]
									); ?>
								</div>
                            </div>
						</div>
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
<div class="modal fade y" id="customer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Customer</h4>
			</div>
			<form id="form2">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
						<label class=" control-label">Mobile <span class="required" aria-required="true">*</span></label>
							<?php echo $this->Form->input('mobile',['placeholder'=>'Mobile','class'=>'form-control input-sm number_mobile modal_mobile','label'=>false,'required','maxlength'=>10,'minlength'=>10,'type'=>'number']); ?>
						</div>
						<div class="col-md-6">
							<label class=" control-label">Name</label>
								<?php echo $this->Form->input('name',['placeholder'=>'Name','class'=>'form-control input-sm name','label'=>false,'lettersonly'=>true]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label class=" control-label">Email</label>
								<?php echo $this->Form->input('email',['placeholder'=>'Email','class'=>'form-control input-sm emails','label'=>false,'type'=>'email']); ?>
						</div>
					</div>
				</div>	
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success btnsave">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>
