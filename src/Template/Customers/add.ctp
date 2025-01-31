<div class="row">
	<div class="col-md-9">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">ADD CUSTOMER
						
					</span>
				</div>
				
			</div>
			<div class="portlet-body">
				<?= $this->Form->create($customer,['id'=>'form_sample_3']) ?>
				<div class="row">
					<div class="col-md-3">
						<label class=" control-label">Customer Name<span class="required" aria-required="true">*</span> </label>
						<?php echo $this->Form->control('name',['placeholder'=>'Customer Name','class'=>'form-control input-sm','label'=>false,'required']); ?>
					</div>
					<div class="col-md-3">
						<label class=" control-label">Mobile No. <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->control('mobile',['placeholder'=>'Moble No.','class'=>'form-control input-sm mobile','label'=>false,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'minlength'=>10]); ?>
					</div>
					<div class="col-md-3">
						<label class=" control-label">Email</label>
						<?php echo $this->Form->control('email',['placeholder'=>'Email','class'=>'form-control input-sm','label'=>false,'type'=>'email']); ?>
					</div>
				</div>
				<br/>
				<?= $this->Form->button($this->Html->tag('i', '') . __(' Save'),['class'=>'btn btn-success']); ?>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>

</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {

	
  //--------- FORM VALIDATION
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
				name:{
					required:true
				},
				mobile_no:{
						required:true,
						number:true,
						minlength:10,
						maxlength:10
						
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
	$(document).on('keyup','.mobile',function(){
		//alert();
		var input=$(this).val();

        var master = $(this); 
		//alert(input);
		if(input.length>9){
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
						$('.mobile').val('');
						alert("No Already Exist");
					}


                }
            });
            }
	});
});
</script>

