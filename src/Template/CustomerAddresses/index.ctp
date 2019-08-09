<div class="row">
	<div class="col-md-5 col-sm-5">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">
						  <?php 
						if(!empty($id)){ ?> EDIT ADDRESS
						<?php }else{ ?> ADD ADDRESS
						<?php } ?>
					</span>
				</div>
				<div class="actions">
					 <?php if(!empty($id)){ ?>
						<?php echo $this->Html->link('Add New',['action' => 'index/'.$customer_id],array('escape'=>false,'class'=>'btn btn-default')); ?>
					<?php } ?>
				</div>
			</div>
			<div class="portlet-body">
				<?= $this->Form->create($customerAddress,['id'=>'form_sample_3']) ?>
				<div class="row" style="margin-top:10px;">
					<div class="col-md-8">
						<div class="form-group">
							<label class="control-label">Address Type<span class="required" aria-required="true">*</span></label>
							<div class="radio-list">
								<div class="radio-inline" style="padding-left: 0px;">
									<?php echo $this->Form->radio(
									'address_type',
									[
										['value' => 'Home', 'text' => 'Home','class' => 'radio-task virt','checked' => 'checked'],
										['value' => 'Office', 'text' => 'Office','class' => 'radio-task virt'],
										['value' => 'Work', 'text' => 'Work','class' => 'radio-task virt'],
										['value' => 'Other', 'text' => 'Other','class' => 'radio-task virt']
									]
									); ?>
								</div>
                            </div>
						</div>
					</div>
				</div>

				<div class="row" style="margin-top:5px;">
					<div class="col-md-8">
						<label class=" control-label">Name</label>
						<?php echo $this->Form->control('name',['placeholder'=>'Name','class'=>'form-control input-sm','label'=>false,'maxlength'=>'50']); ?>
						<input type="hidden" name="customer_id" id="customer_id"  value="<?= $customer_id?>">
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-md-8">
						<label class=" control-label">Mobile </label>
						<?php echo $this->Form->control('mobile',['placeholder'=>'Mobile','class'=>'form-control input-sm','label'=>false,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'minlength'=>10]); ?>
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-md-8">
						<label class=" control-label">Pincode<span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->control('pincode',['placeholder'=>'Pincode','class'=>'form-control input-sm','label'=>false,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'maxlength'=>6,'type'=>'text','required','id'=>'pincode']); ?>
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-md-8">
						<label class=" control-label">Flat/House no <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->control('house_no',['placeholder'=>'House no','class'=>'form-control input-sm','label'=>false,'maxlength'=>'50']); ?>
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-md-8">
						<label class=" control-label">Building/Apartment Name</label>
						<?php echo $this->Form->control('apartment_name',['placeholder'=>'Apartment Name','class'=>'form-control input-sm','label'=>false,'maxlength'=>'50']); ?>
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-md-8">
						<label class=" control-label">Street/Locality/Area<span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->control('locality',['placeholder'=>'locality','class'=>'form-control input-sm','label'=>false,'maxlength'=>'50']); ?>
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-md-8">
						<label class=" control-label">Landmark</label>
						<?php echo $this->Form->control('landmark',['placeholder'=>'Landmark','class'=>'form-control input-sm','label'=>false,'maxlength'=>'150','type'=>'text']); ?>
					</div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-md-8">
						<label class=" control-label">State<span class="required" aria-required="true">*</span></label>
						<select name="state_id" class="form-control input-sm select2 state" required>
                            
                            <option value="<?= @$customerAddress->state_id?>"><?= @$customerAddress->state->state_name?></option>
                            
                        </select>
					</div>
				</div>
				
				<div class="col-md-8">
                       <label class=" control-label">City <span class="required" aria-required="true">* </label>
                        <select name="city_id" class="form-control input-sm city select2 city" required>
                            
                             <option value="<?= @$customerAddress->city_id?>"><?= @$customerAddress->city->name?></option>
                            
                        </select>
                 </div>
				
				 <br>
				<div class="row" style="margin-top:10px;">
					<div class="col-md-8">
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
							
				<br/>
				<?= $this->Form->button($this->Html->tag('i', '') . __(' Save'),['class'=>'btn btn-success']); ?>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
	<div class="col-md-7 col-sm-7">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class=" fa fa-gift"></i>
					<span class="caption-subject">ADDRESSES</span>
				</div>
				<div class="actions">
					<input id="search3"  class="form-control input-sm" type="text" placeholder="Search" >
				</div>
			</div>
			<div class="portlet-body">
				<div style="overflow-y: scroll;height: 400px;">
					<table class="table table-bordered table-condensed pagin-table" id="main_tble">
						<thead>
							<tr>
								<th><?=  h('Sr.no') ?></th>
								<th><?=  h('Name') ?></th>
								<th><?=  h('Mobile') ?></th>
								<th><?=  h('House No') ?></th>
								<th><?=  h('Apartment') ?></th>
								<th><?=  h('Locality') ?></th>
								<th><?=  h('Default Address') ?></th>
								<th class="actions"><?= __('Actions') ?></th>
							</tr>
						</thead>
						<tbody id="main_tbody">
							<?php
							$k=0;
							foreach ($customerAddresses as $customer_details):
								@$k++;
							?>
							<tr class="main_tr">
								<td><?= h($k) ?></td>
								<td><?= h(@$customer_details->name) ?></td>
								<td><?= h(@$customer_details->mobile) ?></td>
								<td><?= h(@$customer_details->house_no) ?></td>
								<td><?php if(($customer_details->apartment_name == "null")||($customer_details->apartment_name == "NULL"))
								{
									echo '';
								}
								else
								{
									echo @$customer_details->apartment_name;
								}
											 ?></td>
								<td><?= h(@$customer_details->locality) ?></td>
								<td>
									<?php $default_address=$customer_details->default_address;
										  if($default_address==1){
											  $show_default='Yes';
										  }else{
											  $show_default='No';
										  }
									?>
									<?= h($show_default) ?>
								</td>
								<td class="actions">
								<?php echo $this->Html->link('<i class="fa fa-pencil"></i>',['action' => 'index', $customer_details->customer->id, $customer_details->id],['escape'=>false,'class'=>'btn btn-xs blue']); ?>
								
								<?php echo $this->Form->PostLink('<i class="fa fa-trash"></i>',['action' => 'delete', $customer_details->customer->id, $customer_details->id],[
								'escape'=>false,
								'class'=>'btn btn-xs red',
								'confirm'=> __ ('Are yousue youwant to delete this unit?',$customer_details->id)]
								)
								?>
								
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
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {

	$(document).on('keyup',"#pincode",function(){ 
		//alert();
		var input=$(this).val();
		 if(input.length>5){
		 	var m_data = new FormData();
		 	var url ="<?php echo $this->Url->build(["controller" => "Pincodes", "action" => "checkPin"]); ?>";
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
					if(response!=1)
					{
						alert("We are not delivered here");
						$('#pincode').val('');
						$('.state').html('');
						$('.city').html('');
					}
					else{
							var url ="<?php echo $this->Url->build(["controller" => "Pincodes", "action" => "check"]); ?>";
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
									$('.state').html(response);
									var url ="<?php echo $this->Url->build(["controller" => "Pincodes", "action" => "check1"]); ?>";
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
												$('.city').html(response);
											}
										});
													
								}
							});
				        }
				    }
				 });
          }
      });

	var rows = $("#main_tbody tr.main_tr");
$("#search3").on("keyup",function() {
          
    var val = $.trim($(this).val()).replace(/ +/g, " ").toLowerCase();
    var v = $(this).val();
    
    if(v){
        rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, " ").toLowerCase();

            return !~text.indexOf(val);
        }).hide();
    }else{
        rows.show();
    }
});

	$('input[name="default_address"]').on('click',function()
	{
		var default_address=$(this).val();
		alert(default_address);
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
		if(default_address == "0")
		{
			var customer_id=$('#customer_id').val();
			var url="<?php echo $this->Url->build(['controller'=>'CustomerAddresses','action'=>'defaultcheck1']); ?>";
						url=url+'/'+customer_id,

			//alert(url);	
						$.ajax({
							url: url,
						}).done(function(response) { 
							//alert(response);
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
				house_no:{
					required: true,					 
				},
				locality:{
					required: true,					 
				},
				mobile_no:{
						required:true,
						number:true,
						minlength:10,
						maxlength:10
					},
					pincode:{
						required:true,
						number:true,
						minlength:6,
						maxlength:6
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

