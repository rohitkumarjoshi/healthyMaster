<div class="row">
	<div class="col-md-8 col-sm-8">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">
						<?php 
						if(!empty($unit->id)){ ?>WASTAGE AND REUSE
						<?php }else{ ?> WASTAGE AND REUSE
						<?php } ?>
					</span>
				</div>
				<div class="actions">
					<?php if(!empty($updt_id)){ ?>
						<?php echo $this->Html->link('<i class="fa fa-plus"></i> Add New',['action' => 'index'],array('escape'=>false,'class'=>'btn btn-default')); ?>
					<?php } ?>
				</div>
			</div>
			<div class="portlet-body">
				<div class="">
					<?= $this->Form->create($wastageReuseVoucher,['id'=>'CountryForm']) ?>
						<div class="row">
					
					<div class="col-sm-12" style="margin-top:10px;" id="main">
						<table class="table table-bordered" id="main_table">	
							<thead class="bg_color">
								<tr align="center">
									<th width="5%" style="text-align:left;">Sr</th>
									<th width="25%" style="text-align:left;">Item</th>
									<th width="20%" style="text-align:left;">Variation</th>
									<th width="20%" style="text-align:left;">Wastage Quantity</th>
									<th width="18%" style="text-align:left;">Reuse Quantity</th>
									<th width="10%" style="text-align:left;"></th>
								</tr>
							</thead>
							<tbody id="main_tbody">
							
							<tr class="main_tr">
								
							</tr>
							
							</tbody>
							<tfoot>
								
							</tfoot>
						</table>
					</div>
				</div>
						<div class="form-actions ">
							<div class="row">
								<div class="col-md-12" style=" text-align: center;">
									<hr></hr>
									<?php echo $this->Form->button('SUBMIT',['class'=>'btn btn-danger btn-sm']); ?> 
								</div>
							</div>
						</div>
 						 
					<?= $this->Form->end() ?>
				</div> 
			</div>
		</div>
	</div>
	<div class="col-md-4 col-sm-4">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class=" fa fa-gift"></i>
					<span class="caption-subject">WASTAGE AND REUSE</span>
				</div>
				<div class="actions">
					<input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3"  style="width: 150px;">
				</div>
			</div>
			<div class="portlet-body">
				<div style="overflow-y: scroll;height: 400px;">
					<table class="table table-bordered table-condensed pagin-table" id="main_tble">
						<thead>
							<tr>
								<th><?=  h('Sr.no') ?></th>
								<th><?=  h('Voucher No') ?></th>
								<th><?=  h('Create date') ?></th>
								<th class="actions"><?= __('Actions') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$k=0;
							foreach ($wastageReuseVoucherList as $unit):
								@$k++;
							?>
							<tr>
								<td><?= h($k) ?></td>
								<td><?= h($unit->voucher_no) ?></td>
								<td><?= h($unit->created_date) ?></td>
								
								<td class="actions">
								
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
	
	$(document).on("click", ".add_row", function(e){
			add_row();
	});
	
	$(document).on("click", ".remove_row", function(e){ 
		var rowCount = $("#main_table tbody#main_tbody tr.main_tr").length; 
		if(rowCount>1)
		{
			$(this).closest("tr").remove();
			rename_rows();
			
		}
	});
	
	add_row();
	function add_row(){
		var tr=$("#sample tbody tr.main_tr").clone();
		$("#main_table tbody#main_tbody").append(tr);
		rename_rows();
	}
	
	function rename_rows(){
		var i=0;
		$("#main_table tbody#main_tbody tr.main_tr").each(function(){
			$(this).find("td:nth-child(1)").html(i);
			 $(this).find("td:nth-child(2) select").select2().attr({name:"wastage_reuse_voucher_rows["+i+"][item_id]", id:"wastage_reuse_voucher_rows-"+i+"-item_id"
					});
			$(this).find("td:nth-child(3) select").select2().attr({name:"wastage_reuse_voucher_rows["+i+"][unit_variation_id]", id:"wastage_reuse_voucher_rows-"+i+"-unit_variation_id"
					}); 
			 $(this).find(".wastage_quantity").attr({name:"wastage_reuse_voucher_rows["+i+"][wastage_quantity]", id:"wastage_reuse_voucher_rows-"+i+"-wastage_quantity"
					}); 
			$(this).find(".reuse_quantity").attr({name:"wastage_reuse_voucher_rows["+i+"][reuse_quantity]", id:"wastage_reuse_voucher_rows-"+i+"-reuse_quantity"
					}); 
			i++;
		});
		
	}
	
});
</script>


<table id="sample" style="display:none;"  width="1500px">
	<tbody class="table_br">
		<tr class="main_tr">
			<td style="vertical-align: top !important;"></td>
			<td width="15%" align="left">
				<?php echo $this->Form->input('item_id',['options'=>$Items,'class'=>'form-control input-sm item_id select2 ','empty' => '--Select Item--','label'=>false,'required'=>'required']); ?>
			</td>
			<td width="15%" align="left">
				<?php echo $this->Form->input('unit_variation_id',['options'=>$UnitVariations,'class'=>'form-control input-sm unit_variation_id select2 ','empty' => '--Select Item--','label'=>false,'required'=>'required']); ?>
			</td>
			<td width="5%" align="center">
				<?php echo $this->Form->input('wastage_quantity', ['label' => false,'placeholder'=>'Wastage','class'=>'form-control input-sm wastage_quantity rightAligntextClass','required'=>'required','max'=>13,'value'=>0]); ?>
			</td>
			<td width="5%" align="center">
				<?php echo $this->Form->input('reuse_quantity', ['label' => false,'placeholder'=>'Reuse','class'=>'form-control input-sm reuse_quantity rightAligntextClass','required'=>'required','max'=>13,'value'=>0]); ?>
			</td>
			
			<td>
				<?php echo $this->Form->button($this->Html->tag('i', '', ['class'=>'fa fa-plus']),['class'=>'btn btn-primary btn-xs add_row','type'=>'button']); ?>
				<?php echo $this->Form->button($this->Html->tag('i', '', ['class'=>'fa fa-times']),['class'=>'btn  btn-danger btn-xs remove_row','type'=>'button']); ?>
			</td>
		</tr>
	</tbody>
</table>