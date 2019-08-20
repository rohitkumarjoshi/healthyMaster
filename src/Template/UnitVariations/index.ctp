<div class="row">
	<div class="col-md-5 col-sm-5">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">
						<?php 
						if(!empty($unitVariation->id)){ ?>EDIT UNIT
						<?php }else{ ?> ADD UNIT
						<?php } ?>
					</span>
				</div>
				<div class="actions">
					
				</div>
			</div>
			<div class="portlet-body">
				<?= $this->Form->create($unitVariation,['id'=>'form_sample_3']) ?>
				
				<div class="row">
					<div class="col-md-8" style="margin-top: 10px;">
						<label class=" control-label">Name <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->control('name',['placeholder'=>'Name','class'=>'form-control input-sm shortname','label'=>false]); ?>
					</div>
				</div>
				<div class="row" style="margin-top: 15px;">
					<div class="col-md-8">
						<label class=" control-label">Discription <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->control('description',['placeholder'=>'Description','class'=>'form-control input-sm','label'=>false]); ?>
					</div>
				</div>
				<div class="row"  style="margin-top: 15px;">
					<div class="col-md-8">
						<label class=" control-label">Quantity Factor <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->control('quantity_factor',['placeholder'=>'Description','class'=>'form-control input-sm quantity','label'=>false]); ?>
					</div>
				</div>
				<br/>
				<?= $this->Form->button($this->Html->tag('i', '') . __(' Submit'),['class'=>'btn btn-success']); ?>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
	<div class="col-md-7 col-sm-7">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class=" fa fa-gift"></i>
					<span class="caption-subject">UNITS</span>
				</div>
				<div class="actions">
					<input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3"  style="width: 200px;">
				</div>
			</div>
			<div class="portlet-body">
				<div style="overflow-y: scroll;height: 400px;">
					<table class="table table-bordered table-condensed pagin-table" id="main_tble">
						<thead>
							<tr>
								<th><?=  h('Sr.no') ?></th>
								<th><?=  h('Name') ?></th>
								<th><?=  h('Description') ?></th>
								<th><?=  h('Quantity Factor') ?></th>
								<th class="actions"><?= __('Actions') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$k=0;
							foreach ($unitVariations as $unitVariation):
								@$k++;
							?>
							<tr>
								<td><?= h($k) ?></td>
								<td><?= h($unitVariation->name) ?></td>
								<td><?= h($unitVariation->description) ?></td>
								<td><?= h($unitVariation->quantity_factor) ?></td>
								<td class="actions">
								<?php echo $this->Html->link('<i class="fa fa-pencil"></i>',['action' => 'index', $unitVariation->id],['escape'=>false,'class'=>'btn btn-sm blue']); ?>
								
								
								
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
	// $('.quantity').on('keyup',function()
	// {
	// 	var factor=$(this).val();
	// 	var m_data = new FormData();
 //            var url ="<?php echo $this->Url->build(["controller" => "UnitVariations", "action" => "check"]); ?>";
 //         //   alert(url);
 //            m_data.append('factor',factor); 
 //            $.ajax({
 //                url: url,
 //                data: m_data,
 //                processData: false,
 //                contentType: false,
 //                type: 'POST',
 //                dataType:'text',
 //                success: function(response)
 //                { 
 //                	//alert(response);
 //                	if(response == 1)
 //                	{
	// 					$('.quantity').val('');
	// 					alert("Duplicate value not accepted");
	// 				}


 //                }
 //            });
	// });
	$('.shortname').on('change',function()
	{
		var input=$(this).val();

        var master = $(this); 
		//alert(input);
		if(input.length>0){
            var m_data = new FormData();
            var url ="<?php echo $this->Url->build(["Units" => "Customers", "action" => "check"]); ?>";
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
						$('.shortname').val('');
						alert("Unit Already Exist");
					}


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
				name:{
					required: true,					 
				},
				unit_id:{
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

