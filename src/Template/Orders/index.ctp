<style>
.table>thead>tr>th{
	font-size:12px !important;
}

 @media print
   {
     .printdata{
		 display:none;
	 }
   }

</style>
<div class="row printdata">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">ORDERS</span>

				</div>
				<div class="actions">
					<?php //echo $this->Html->link('<i class="fa fa-plus"></i> Add new','/Orders/Add/Offline',['escape'=>false,'class'=>'btn btn-default']) ?>
					&nbsp;
					<!-- <?php if($status=='process'){
						$class1="btn btn-xs blue";
						$class2="btn btn-default";
					}else {
						$class1="btn btn-default";
						$class2="btn btn-xs blue";
					}
					 ?>  -->
					 <?php echo $this->Html->link('Reset','/Orders/Index',['escape'=>false,'class'=>'btn btn-primary btn-sm']) ?>&nbsp;
						<!-- <?php echo $this->Html->link('Pending',['controller'=>'Orders','action' => 'index?status=process'],['escape'=>false,'class'=>$class1]); ?> -->
						<!-- <?php echo $this->Html->link('All',['controller'=>'Orders','action' => 'index'],['escape'=>false,'class'=>$class2]); ?>&nbsp; -->
				
				</div>
			<div class="portlet-body">
			<form method="post">
                        <table width="50%" class="table table-condensed">
                    <tbody>
                        <tr>
                            <td width="8%">
                                <label>Order No</label>
                                <?php echo $this->Form->input('order_no', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Order No','autocomplete'=>'off']); ?>
                            </td>
                            <td width="5%">
                                <label>Customer</label>
                                <?php echo $this->Form->input('customer_id', ['empty'=>'--Customer--','options' => $Customer_data,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category']); ?>
                            </td>
                           
                            <td width="5%">
                                <label class=" control-label">Status </label>
                                <select name="status" class="form-control select2me input-sm">
                                    <option value="">--Select--</option>
                                    <option value="In Process">In Process</option>
                                    <option value="Packed">Packed</option>
                                    <option value="Dispatch">Dispatch</option>
                                    <option value="Delivered">Delivered</option>
                                </select>
                            </td>
                            <td width="5%">
                                <label>From</label>
                                <input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From"  data-date-format="dd-mm-yyyy" autocomplete="off">
                            </td>   
                            <td width="5%">
                                <label>To</label>
                                <input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To"   data-date-format="dd-mm-yyyy" autocomplete="off">
                            </td>
                            <td width="10%">
                                <button type="submit" class="btn btn-success btn-sm" style="margin-top: 23px !important;"><i class="fa fa-filter"></i> Filter</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
			<?php $page_no=$this->Paginator->current('Orders'); $page_no=($page_no-1)*20; ?>
				<table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_1">
					<thead>
						<tr>
							<th scope="col">Sr. No.</th>
							<th scope="col">Order No.</th>
							<th scope="col">Cus(ID)</th>
							<th scope="col">Name</th>
							<th scope="col">Mobile</th>
							<!--<th scope="col">wallet Amount</th>-->
							<th scope="col">Locality</th>
							<th scope="col">Pincode</th>
							<th scope="col">Grand Total</th>
							<th scope="col">Mode Of Payment</th>
							<!-- <th scope="col">Payment Status</th> -->
							<th scope="col">Order Type</th>
							<th scope="col">Order Date</th>
							<!-- <th scope="col">Delivery Date</th>
							<th scope="col">Delivery Time</th> -->
							<th scope="col" class="actions"><?= __('Actions') ?></th>
							<th scope="col" class="">Invoice</th>
							<!-- <th scope="col">Edit</th> -->
						</tr>
					</thead>
					<tbody>
						<?php
						$sr_no=0; foreach ($orders as $order): 
						$delivery_date=date('d-m-Y', strtotime($order->delivery_date));
						@$actual_deliver_time=$order->actual_deliver_time; 
						if(!empty($actual_deliver_time)){
							$date_show=$delivery_date.' ('.$actual_deliver_time.')';
						}else if(empty($actual_deliver_time)){
							$date_show=$delivery_date;
						}
						$date_show;
						 
						$current_date=date('d-m-Y');
						$status=$order->status;
						$order_id=$order->id;

						?>
						<tr <?php if(($status=='In Process') || ($status=='In process')){ ?>style="background-color:#ffe4e4; "<?php } ?> >
							<td><?= ++$page_no ?></td>
							<td>
							
							<?php 
							if(!empty($order->invoice_no)){
							echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'newview', $order->id],['target'=>'_blank']);
							}else{
								echo $this->Html->link($order->order_no,['controller'=>'Orders','action' => 'view', $order->id],['target'=>'_blank']);
							}
							?>
						</td>
							<td>
								<?=
								$order->customer->id; ?>
							</td>
							<td>
							<?php
								$customer_name=$order->customer->name;
								$customer_mobile=$order->customer->mobile;
								
								$order_date=date('d-m-Y', strtotime($order->order_date));
								$prev_date=date('d-m-Y', strtotime('-1 day'));
								
								
							?>
								<?= h($customer_name) ?>
							</td>
							<td><?= $order->customer->mobile ?></td>
							<!--<td align="right"><?= $this->Number->format($order->amount_from_wallet) ?></td>-->
							<td><?= h(@$order->customer_address->locality) ?></td>
							<td><?= h(@$order->customer_address->pincode) ?></td>
							<td align="right"><?= $this->Number->format($order->grand_total) ?></td>
							<td><?= h($order->order_type) ?></td>
							<!-- Vaibhav Sir<td><?= h($order->payment_status) ?></td> -->
							<td><?= h($order->order_from) ?></td>
							<td><?php $q=explode(' ',$order->order_date); ?> <span style="font-size:11px;"><?php echo $q[0] ?></span></td>
							<!--Vaibhav Sir <td><span style="font-size:11px;"><?= h($delivery_date) ?></span></td>
							<td><span style="font-size:11px;"><?= h($actual_deliver_time) ?></span></td> -->
							
							
							<td class="actions">
							<select name="status" class="form-control select2 input-sm option_status"  style="width: auto;">
								<?php if($order->status=="In Process")
								{?>
									<option value="In Process" selected>In Process</option>
									<option value="Packed">Packed</option>
									<option value="Dispatch">Dispatch</option>
									<option value="Delivered">Delivered</option>
									<?php if($order->order_from=="walkinsales"){?>}
										<option value="Cancel">Cancel</option>
									<?php } ?>
								<?php }if($order->status=="Packed")
								{?>
									<option value="Packed" selected>Packed</option>
									<option value="In Process">In Process</option>
									<option value="Dispatch">Dispatch</option>
									<option value="Delivered">Delivered</option>
									<?php if($order->order_from=="walkinsales"){?>}
										<option value="Cancel">Cancel</option>
									<?php } ?>
								<?php }if($order->status=="Dispatch")
								{?>
									<option value="Dispatch" selected>Dispatch</option>
									<option value="In Process">In Process</option>
									<option value="Packed">Packed</option>
									<option value="Delivered">Delivered</option>
									<!-- <option value="Cancel">Cancel</option> -->
								<?php }if($order->status=="Delivered")
								{?>
								<option value="Delivered" selected>Delivered</option>
									<option value="In Process" >In Process</option>
									<option value="Packed" >Packed</option>
									<option value="Dispatch" >Dispatch</option>
									<!-- <option value="Cancel">Cancel</option> -->
						<?php }?>
					<?php if($order->status=="Cancel")
								{?>
								<option value="Cancel" selected>Cancel</option>
						<?php }?>
							</select>
							<?php if(($order->status!="Delivered")&&($order->status!="Cancel"))
							{
							?>
							<button class="btn btn-primary btn-xs ok" order_id="<?=$order->id ?>" order_from="<?= $order->order_from?>">Ok</button>
						<?php } ?>
						<?php if(($order->status =="Cancel")&&($order->order_from=="walkinsales"))
							{
							?>
							<button class="btn btn-primary btn-xs undodel" order_id="<?=$order->id ?>" order_from="<?= $order->order_from?>">Undo</button>
						<?php } ?>
						
							</td>
							<td>
								<?php if((empty($order->invoice_no))&&($order->status!="Cancel")){ ?>
									<input type="button" name="generate" order_id="<?=$order->id ?>" value="Invoice" class="btn btn-success btn-xs generate_invoice" >
								<?php } ?>
							</td>
							<!-- <?php  if(($status=='In Process') || ($status=='In process')){ 
							if(( $order_date == $current_date ) || ($order_date == $prev_date  )){?>
								<td>
									<?= $this->Html->link(__('Edit'), ['action' => 'edit', $order->id]) ?>
								
								</td>
							<?php 	}else{ ?>
								<td></td>
							<?php }}else {?>
								<td></td>
							 <?php } ?> -->
							
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<!-- <div class="paginator">
					<ul class="pagination">
						<?= $this->Paginator->first('<< ' . __('first')) ?>
						<?= $this->Paginator->prev('< ' . __('previous')) ?>
						<?= $this->Paginator->numbers() ?>
						<?= $this->Paginator->next(__('next') . ' >') ?>
						<?= $this->Paginator->last(__('last') . ' >>') ?>
					</ul>
					<p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
				</div> -->
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
$(document).ready(function() {
	$(document).on('click',".generate_invoice",function(){
		var x =$(this);
		var id=$(this).attr('order_id');
		var url="<?php echo $this->Url->build(["controller" => "Orders", "action" => "Invoice"]); ?>";
		var go_to_url="<?php echo $this->Url->build(["controller" => "Orders", "action" => "newview"]); ?>";
		go_to_url=go_to_url+'/'+id;
		url=url+'/'+id;
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'text'
		}).done(function(response) {
			if(response=='ok'){
				x.hide();
				window.open(go_to_url, '_blank');
			}
			
		});
	});

	$(document).on('click',".undodel",function(){
		var order_id=$(this).attr('order_id');
		var cancel_from=$(this).attr('order_from');
		//alert(order_id);
		$.ajax({
            url: "<?php echo $this->Url->build(["controller" => "Orders", "action" => "undodel"]); ?>",
            type: 'post',
            data: {order_id:order_id},
           success: function (data) {
           //	alert(data);
               alert("Your order in process");
                location.reload();
               }
            });
	});

	 $(document).on('click',".ok",function(){
		var status=$(this).closest('tr').find('.option_status').val();
		var order_id=$(this).attr('order_id');
		var cancel_from=$(this).attr('order_from');
		
		//alert(status);
		if(status =="Delivered")
		{
			$(this).closest('tr').find('.ok').hide();
		}
		if(status =="Cancel")
		{
			$(this).closest('tr').find('.ok').hide();
			$(this).closest('tr').find('.generate_invoice').hide();
		}
		
		
		
		// if(status == "Cancel")
		// {
		// 	$.ajax({
  //           url: "<?php echo $this->Url->build(["controller" =>"Orders", "action" => "cancelOrder"]); ?>",
  //           type: 'get',
  //           data: {cancel_from:cancel_from,order_id:order_id},
  //          success: function (data) {
  //              alert("ok");
  //              }
  //           });
		// }
		// if(status!="Cancel")
		// {
		 $.ajax({
            url: "<?php echo $this->Url->build(["controller" => "Orders", "action" => "statuses"]); ?>",
            type: 'post',
            data: {status: status,order_id:order_id},
           success: function (data) {
               //console.log(data);
               alert(status);
               location.reload();
               }
            });
		//}

	});
	
	var form3 = $('#content');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
				
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
	////
	$('.actual_quantity').die().live('keyup',function() {
	var actual_quantity=parseFloat($(this).val());
	if(!actual_quantity){ actual_quantity=0; }
	var minimum_quantity_factor=parseFloat($(this).attr('minimum_quantity_factor'));
	if(!minimum_quantity_factor){ minimum_quantity_factor=0; }
	var price=parseFloat($(this).attr('price'));
	if(!price){ price=0; }
	var total_quantity=Math.round((actual_quantity/minimum_quantity_factor)*price);
	
 	$(this).closest('tr').find('.amount').val(total_quantity);
 	});
	
	
	$('.view_order').die().live('click',function() {
		$('#popup').show();
		var order_id=$(this).attr('order_id');
		$('#popup').find('div.modal-body').html('Loading...');
		var url="<?php echo $this->Url->build(["controller" => "Orders", "action" => "view"]); ?>";
		url=url+'/'+order_id;
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'text'
		}).done(function(response) {
			$('#popup').find('div.modal-body').html(response);
		});	
	});
	$('.close').die().live('click',function() {
		$('#popup').hide();
	});
	
	$('.cncl').die().live('click',function() {
		$('#popup').show();
		var order_id=$(this).attr('order_id');
 		$('#popup').find('div.modal-body').html('Loading...');
		var url="<?php echo $this->Url->build(["controller" => "Orders", "action" => "cancel_box"]); ?>";
		url=url+'/'+order_id;
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'text'
		}).done(function(response) {
			$('#popup').find('div.modal-body').html(response);
		});	
	});
	
	$('.dlvr').die().live('click',function() {
		$('#popup').show();
		var order_id=$(this).attr('order_id');
 		$('#popup').find('div.modal-body').html('Loading...');
		var url="<?php echo $this->Url->build(["controller" => "Orders", "action" => "ajax_deliver"]); ?>";
		url=url+'/'+order_id;
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'text'
		}).done(function(response) {
			$('#popup').find('div.modal-body').html(response);
		});	
	});
	
	$('.close').die().live('click',function() {
		$('#popup').hide();
	});
	
	$('.undo').die().live('click',function() {
		
		var order_id=$(this).attr('order_id');
		
		var url="<?php echo $this->Url->build(["controller" => "Orders", "action" => "undo_box"]); ?>";
		url=url+'/'+order_id;
		
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'text'
		}).done(function(response) {
			
			location.reload();
		});	
	});
	$('.close').die().live('click',function() {
		$('#popup').hide();
	});
	
	$('.goc').die().live('click',function() 
	{ 
		$('#data').html('<i style= "margin-top: 20px;" class="fa fa-refresh fa-spin fa-3x fa-fw"></i><b> Loading... </b>');
		var odr_id = $(this).attr("value");
 		var m_data = new FormData();
		m_data.append('odr_id',odr_id);
			
		$.ajax({
			url: "<?php echo $this->Url->build(["controller" => "Orders", "action" => "ajax_order_view"]); ?>",
			data: m_data,
			processData: false,
			contentType: false,
			type: 'POST',
			dataType:'text',
			success: function(data)   // A function to be called if request succeeds
			{
				$('#data').html(data);
			}	
		});	
	});
	////
	$('.get_order').die().live('click',function(event) {
				 //event.preventDefault();		
		var order_id=$(this).attr('order_id');
		var s1 = [];
		var s2 = [];
		var s3 = [];
		$("#main_table tbody#main_tbody tr.main_tr").each(function(){ 
			 var row = [];
			 var items = [];
			 var amounts = [];
			var actual_quantity = $(this).find("td:nth-child(4) .actual_quantity").val();
			var amount = $(this).find("td:nth-child(5) .amount").val();
			var item_id = $(this).find("td:nth-child(2) .item_id").val();
			row.push(actual_quantity);
			 s1.push(row);
			 items.push(item_id);
			 s2.push(items);
			 amounts.push(amount);
			 s3.push(amounts);
		});
			
		var output=multiply(s1);
		if(output){
			if(output!=0){ 
			$('.get_order').prop('disabled', true);
			$('.get_order').text('Delivered.....');
						var url="<?php echo $this->Url->build(['controller'=>'Orders','action'=>'updateOrders']); ?>";
						url=url+'/'+order_id+'/'+s2+'/'+s1+'/'+s3,
						$.ajax({
							url: url,
						}).done(function(response) {
							var order_id=$('.get_order').attr('order_id');
							var m_data = new FormData();
							m_data.append('order_id',order_id);
							
							$.ajax({
							url: "<?php echo $this->Url->build(["controller" => "Orders", "action" => "ajax_deliver_api"]); ?>",
							data: m_data,
							processData: false,
							contentType: false,
							type: 'POST',
							dataType:'text',
							success: function(data)   // A function to be called if request succeeds
							{
								location.reload();
								//$('.setup').html(data);
							}
							});
						});	
			}
		}else{
			alert('fill all actual quantity.');
		}
		
	});	
	
	function multiply(array) {
    var sum = 1;
    for (var i = 0; i < array.length; i++) {
        sum = sum * array[i];
    }
    return sum;
}

	
	////

});
</script>
<div  class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="false" style="display: none;border:0px;" id="popup">
<div class="modal-backdrop fade in" ></div>
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="border:0px;">
			<div class="modal-body flip-scroll" style="height: auto;
    overflow-y: auto;" >
				<p >
					 Body goes here...
				</p>
			</div>
		</div>
	</div>
</div>