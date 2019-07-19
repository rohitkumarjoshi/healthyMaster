<div class="row">
	<div class="col-md-9">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">ADD VENDOR
						
					</span>
				</div>
				
			</div>
			<div class="portlet-body">
				<?= $this->Form->create($vendor,['id'=>'form_sample_3']) ?>
				<div class="row">
					<div class="col-md-4">
						<label class=" control-label">Name <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->control('name',['placeholder'=>'Vendor Name','class'=>'form-control input-sm','label'=>false]); ?>
					</div>
					<div class="col-md-4">
						<label class=" control-label">Mobile No.  <span class="required" aria-required="true">*</label>
						<?php echo $this->Form->control('mobile',['placeholder'=>'Moble No.','class'=>'form-control input-sm mobile','label'=>false,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'required','minlength'=>10,'maxlength'=>10,'type'=>'number']); ?>
					</div>
					<div class="col-md-4">
						<label class=" control-label">Email  <span class="required" aria-required="true">*</label>
						<?php echo $this->Form->control('email',['placeholder'=>'Email','class'=>'form-control input-sm','label'=>false,'type'=>'email']); ?>
					</div>
				</div>
				<div class="row" style="margin-top: 12px;">
					<div class="col-md-4">
						<label class=" control-label">GST No. <span class="required" aria-required="true">* </label>
						<?php echo $this->Form->control('gst_no',['placeholder'=>'GST No.','class'=>'form-control input-sm gst_no','label'=>false,'required','type'=>'text','minlength'=>15,'maxlength'=>15]); ?>
					</div>
					<div class="col-md-4">
                        <?= $this->Form->control('id',['type'=>'hidden']); ?>
                         <span class="required" aria-required="true">
                        <?php echo $this->Form->control('state_id', ['empty'=>'-- select --','options' => $states,'class'=>'form-control input-sm select select2me select2 state','required']); ?>
                    </div>
                    <!--<div class="col-md-4">
                        <?php //echo $this->Form->control('city_id', ['empty'=>'-- select --','options' => $cities,'class'=>'form-control input-sm select select2me','required']); ?>
                    </div>-->
					 <div class="col-md-4">
                       <label class=" control-label">City <span class="required" aria-required="true">* </label>
                        <select name="city_id" class="form-control input-sm city select2" required>
                            
                            
                        </select>
                    </div>
				</div>
				<div class="row" style="margin-top: 12px;">
					<div class="col-md-6">
						<label class=" control-label">Address <span class="required" aria-required="true">* </label>
						<?php echo $this->Form->control('address',['placeholder'=>'Address','class'=>'form-control input-sm','label'=>false, 'rows'=>'2']); ?>
					</div>
				</div>
				<br/>
				<?= $this->Form->button($this->Html->tag('i', '') . __(' Submit'),['class'=>'btn btn-success']); ?>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {

	$(document).on('change','.mobile',function(){
		//alert();
		var input=$(this).val();

        var master = $(this); 
		//alert(input);
		if(input.length>0){
            var m_data = new FormData();
            var url ="<?php echo $this->Url->build(["controller" => "Vendors", "action" => "checks"]); ?>";
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
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
				name:{
					required: true,					 
				},
				// email:{
				// 	required: true,					 
				// },
				// mobile:{
				// 	required: true,					 
				// },
				state_id:{
					required: true,					 
				},
				gst_no:{
						required:true,
						
					},
				city_id:{
					required: true,					 
				},
				address:{
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

	$(document).on('change','.gst_no',function(){
		//alert();
		var input=$(this).val();

        var master = $(this); 
		//alert(input);
		if(input.length>0){
            var m_data = new FormData();
            var url ="<?php echo $this->Url->build(["controller" => "Vendors", "action" => "check"]); ?>";
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
						$('.gst_no').val('');
						alert("GST Number Already Exist");
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
	  
	
  //--------- FORM VALIDATION
	
	//--	 END OF VALIDATION
});
</script>

