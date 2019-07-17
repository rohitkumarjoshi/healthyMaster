<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">ADD PROMO CODES
					</span>
				</div>
			</div>
			<div class="portlet-body">
				<?= $this->Form->create($promoCode,['id'=>'form_sample_3']) ?>
			<div class="row">
				<div class="col-md-3">
					<label class=" control-label">Promo Code Type <span class="required" aria-required="true">*</span></label>
					<select name="promo_code_type" class="form-control select2me input-sm promo_code_type" onchange="myFunction(this.value)">
						<option value=""> Select Promo Code Type </option>
						<option value="Item Wise"> Item Wise </option>
						<option value="Category Wise"> Category Wise </option>
						<option value="Free Shipping"> Free Shipping </option>
						<option value="On Cart Value"> On Cart Value </option>
					</select>
				</div>
				<div class="col-md-3">
					<label class=" control-label">Promo Code Name <span class="required" aria-required="true">*</span></label>
					<?php echo $this->Form->control('code',['placeholder'=>'Promo Code Name','class'=>'form-control input-sm code','label'=>false]); ?>
				</div>
				<div class="col-md-3">
					<label class=" control-label">Title<span class="required" aria-required="true">*</span></label>
					<?php echo $this->Form->control('title',['placeholder'=>'Title','class'=>'form-control input-sm','label'=>false]); ?>
				</div>
				<div class="col-md-3">
					<div class="radio-list">
						<label>Type</label>
						<div class="radio-list">
							<input type="hidden" name="cash_back_flag" value=""><label for="cash-back-flag-no">
							<div class="radio-inline" style="padding-left: 0px;">

								<?php echo $this->Form->radio(
								'amount_type',
								[
									['value' => 'percent', 'text' => 'Percent','class' => 'radio-task virt','checked' => 'checked'],
									['value' => 'amount', 'text' => 'Amount','class' => 'radio-task virt']
								]
								); ?>
							</div>
                        </div>
					</div>
				</div>
			</div>
			<div class="row" style="margin-top: 10px;">
				<div class="col-md-3">
					<label class=" control-label">Discount</label>
					<?php echo $this->Form->control('discount_per',['placeholder'=>'Discount','class'=>'form-control input-sm','label'=>false,'id'=>'discount']); ?>
				</div>
				<div class="col-md-3">
					<?php echo $this->Form->control('item_category_id', ['empty'=>'-- select --','options' => $itemCategories,'class'=>'form-control input-sm select category select2me select2','id'=>'category']); ?>
				</div>
				<div class="col-md-3">
					<label class=" control-label">Item</label>
					<?php echo $this->Form->control('item_id',['empty'=>'--Select Item--','options' => $items,'class'=>'form-control input-sm select2me customer_id cstmr chosen-select','label'=>false,'id'=>'item']); ?>

				</div>
				<dsiv class="col-md-3">
					<label>Shipping</label>
					<?php echo $this->Form->input('is_freeship', array('type'=>'checkbox','id'=>'freeship'));

					?>

				</div>
			
			</div>

			<div class="row" style="margin-top: 10px;">
				<div class="col-md-3">
					<label class=" control-label">Cart Value </label>
					<?php echo $this->Form->control('cart_value',['placeholder'=>'Cart Value','class'=>'form-control input-sm cart','id'=>'cart','label'=>false]); ?>
				</div>
				
				<div class="col-md-3">
					<label class=" control-label">Valid From</label>
					<?php echo $this->Form->control('valid_from',['placeholder'=>'Valid From','class'=>'form-control input-sm date-picker','data-date-format'=>'dd-mm-yyyy','label'=>false,'type'=>'text','id'=>'start_date','onchange'=>'ValidateEndDate()']); ?>
					</div>
				<div class="col-md-3">
					<label class=" control-label">Valid To</label>
					
					<?php echo $this->Form->control('valid_to',['placeholder'=>'Valid To','class'=>'form-control input-sm date-picker','data-date-format'=>'dd-mm-yyyy','label'=>false,'type'=>'text','id'=>'end_date','onchange'=>'ValidateEndDate()']); ?>
					
				</div>
			</div>
			<div class="row" style="margin-top: 10px;">
				<div class="col-md-10">
					<label class=" control-label">Description<span class="required" aria-required="true">*</span></label>
					<textarea name="description" class="form-control"></textarea>
				</div>
			</div>
			<div style="margin-top: 10px;">
				<center><button type="submit" class="btn btn-success">Submit</button></center>
				<?= $this->Form->end() ?>
			</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class=" fa fa-gift"></i>
						<span class="caption-subject">CODE</span>
					</div>
					<div class="actions">
						<input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3"  style="width: 200px;">
					</div>
				</div>
				<div class="portlet-body">
					<div style="overflow-y: scroll;height: 400px;">
						<table class="table table-condensed table-hover table-bordered" id="main_tble">
						<thead>
							<tr>
								<th>Sr</th>
								<th>Code Name</th>
								<th>Discount</th><!-- 
								<th>Item Category</th> -->
								<th>Valid From</th>
								<th>Valid To</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							foreach ($promoCodes as $promoCode):
							$i++;
							$valid_to=$promoCode->valid_to;
							$today=date('Y-m-d');

							?>
							<tr>
								<td><?= $i ?></td>
								<td><?= h(@$promoCode->code) ?></td>
								<td><?= h(@$promoCode->discount_per) ?></td><!-- 
								<td><?= h(@$promoCode->item_category->name) ?></td> -->
								<td><?= h(@$promoCode->valid_from) ?>
								<td><?= h(@$promoCode->valid_to) ?>
								<span id="status_id" style="display:none;"><?php echo $promoCode->id; ?></span>
								</td>
								<td>
								<?php echo  $this->Form->control('status',['class'=>'form-control input-sm input-small status','options'=>['Active'=>'Active','Deactive'=>'Deactive'], 'value'=>$promoCode->status,'label'=>false]); ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>

<!-- <script type="text/javascript">
function ValidateEndDate() {
       var startDate = $("#start_date").val();
       
	//alert(startDate);
       var endDate = $("#end_date").val();
       if (startDate != '' && endDate !='') {
           if (startDate > endDate) {
               $("#end_date").val('');
               alert("Start date should not be greater than end date");
           }
       }
       return false;
   }
</script> -->
<script>



function myFunction(val) {
	//alert(val);
	if(val=="On Cart Value")
	{
		$('#cart').attr('required','required');
		$('#item').removeAttr('required','required');
		$('#category').removeAttr('required','required');
		$('#freeship').removeAttr('required','required');
	}
	if(val =="Item Wise")
	{
		$('#item').attr('required','required');
		$('#category').removeAttr('required','required');
		$('#freeship').removeAttr('required','required');
		$('#cart').removeAttr('required','required');
	}
	if(val=="Category Wise")
	{
		$('#category').attr('required','required');
		$('#item').removeAttr('required','required');
		$('#freeship').removeAttr('required','required');
		$('#cart').removeAttr('required','required');
	}
	if(val=="Free Shipping")
	{
		$('#freeship').attr('required','required');
		$('#item').removeAttr('required','required');
		$('#category').removeAttr('required','required');
		$('#cart').removeAttr('required','required');
	}
	


}
$(document).on('change','.code',function()
{
	var input=$(this).val();

        var master = $(this); 
		//alert(input);
		if(input.length>0){
            var m_data = new FormData();
            var url ="<?php echo $this->Url->build(["controller" => "PromoCodes", "action" => "check"]); ?>";
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
						$('.code').val('');
						alert("Enter Unique Code");
					}


                }
            });
            }
});
$(document).ready(function() {
	var radioValue = $("input[name='amount_type']:checked"). val();
	//alert(radioValue);
	if(radioValue == "percent")
	{
		$('#discount').attr('maxlength','2')
	}
	$('.virt').on('click',function(){
		var radioValue = $(this). val();

		//alert(radioValue);
		if(radioValue == "percent")
	{
		$('#discount').attr('maxlength','2')
	}
	if(radioValue == "amount")
	{
		$('#discount').attr('maxlength','200')
	}
	});

	
	$('#start_date').on("change",function() {
      var po_date= $(this).val();

      $('#end_date').val('');
      $('#end_date').datepicker('setStartDate', po_date);

   });
// $('#start_date').on('change', function() { 
// 	alert();

//     var datearray = $('#start_date').val().split("-");
//     alert(datearray);

//     var montharray = ["Jan", "Feb", "Mar","Apr", "May", "Jun","Jul", "Aug", "Sep","Oct", "Nov", "Dec"];

//     var year = "20" + datearray[2];

//     var month = montharray.indexOf(datearray[1])+1;

//     var day = datearray[0];

//     var minDate = (year +"-"+ month +"-"+ day);

//     $('#end_date').attr('min',minDate); 

//   });

  //--------- FORM VALIDATION
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
				code:{
					required: true,					 
				},
				discount_per:{
					required: true,
				},
				valid_from:{
					required: true,
				},
				title:{
					required: true,
				},
				valid_to:{
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
});
</script>
<script>
$(document).ready(function(){
	$('.status').change(function(){
		var status = $(this).val();
		var status_id = $(this).closest('tr').find('td span#status_id').text();
		var url="<?php echo $this->Url->build(['controller'=>'PromoCodes','action'=>'ajaxStatusPromoCode']);
		?>";
		url=url+'/'+status+'/'+status_id,
		$.ajax({
			url: url,
		}).done(function(response) {
			alert('Update Successfully');

		});		
    });
	
});
</script>
<script type="text/javascript">
    $(function()
    {
      $('[name="is_freeship"]').change(function()
      {
        if ($(this).is(':checked')) {
           // Do something...
           $('#freeship').val(1);
        };
        if ($(this).is(':unchecked')) {
           // Do something...
           $('#freeship').val(0);
        };
      });
    });
  </script>

