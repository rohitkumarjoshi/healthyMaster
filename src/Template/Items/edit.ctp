<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">EDIT ITEM
					</span>
				</div>
				<div class="actions">
				</div>
			</div>
			<div class="portlet-body">
			<?= $this->Form->create($item,['type'=>'file','id'=>'form_sample_3']) ?>
				<div class="row">
					<div class="col-md-3">
						<?php echo $this->Form->control('item_code',['class'=>'form-control input-sm itemcode','placeholder'=>'Item Code','type'=>'text','maxlength'=>50]); ?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->control('name',['class'=>'form-control input-sm','placeholder'=>'Item Name','maxlength'=>50]); ?>
						<input type="hidden" name="id" value="<?= $item->id ?>">
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->control('alias_name',['class'=>'form-control input-sm','placeholder'=>'Alias Name','maxlength'=>50]); ?>
					</div>
					<!-- <div class="col-md-3">
						<?php echo $this->Form->control('unit_id', ['empty'=>'--select--','options' => $unit_option,'class'=>'form-control input-sm attribute']); ?>
					</div> -->
					<div class="col-md-3">
						<?php echo $this->Form->control('item_category_id', ['empty'=>'--select--','options' => $itemCategories,'class'=>'form-control input-sm','required']); ?>
					</div>
					<!--<div class="col-md-3">
						<div class="radio-list">
						<label>Ready To Sale</label>
						<div class="form-control input-sm" style="padding-right: 1px;">
							<label class='radio-inline'><input type='radio' name='ready_to_sale' value='yes' >Yes </label><label class='radio-inline'><input type='radio' name='ready_to_sale' value='no' checked="checked">No </label>
						</div>
					</div>
					</div>-->

				</div><br/>
				<div class="row" style="margin-top: 15px;">
					<div class="col-md-3">
						<?php echo $this->Form->control('description', ['class'=>'form-control input-sm','placeholder'=>'Description','maxlength'=>250]); ?>
						<input type="hidden" name="is_virtual" value="real">
						 <input type="hidden" name="btn_value" id="button_value">
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->control('short_description', ['class'=>'form-control input-sm','placeholder'=>'Short Description','maxlength'=>250]); ?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->control('benefit', ['class'=>'form-control input-sm','placeholder'=>'Benefits','maxlength'=>250]); ?>
					</div>

					<div class="col-md-3">
						 <?= $this->Form->input('image',['class'=>'form-control','type'=>'File']) ?>
					</div>
				</div>
				<div class="row" style="margin-top: 10px;">
					<div class="col-md-3 gst_show">
						<?php echo $this->Form->control('gst_figure_id', ['options' => $GstFigures,'class'=>'form-control input-sm attribute']); ?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->control('hsn_code', ['class'=>'form-control input-sm','placeholder'=>'HSN Code']); ?>
					</div>
					<div class="col-md-3">
						<label class=" control-label">Item Keyword </label>
						<?php
						foreach($item->item_rows as $item_row){
							@$item_row_id[]=$item_row->item_category_id;
						}
						
						echo $this->Form->control('item_keyword[]', ['empty'=>'--select--','options' => @$keywords,'class'=>'form-control input-sm select2me','multiple','label'=>false,'value'=>@$item_row_id]); ?>
					</div>
				</div>
					
				<div class="row">
                        <div class="col-md-12" style="margin-top: 10px;">
                              <table class="table table-striped table-bordered">
                                  <thead>
                                      <tr>
                                           <th width="5%">S.No</th>
                                          <th width="5%">Variation</th>
										<th width="10%">Maximum Order Limit</th>
                                          <th width="8%">Print Rate</th>
                                          <th width="8%">Sales Rate</th>
                                          <th width="8%">Opening Stock</th>
                                         <th width="8%">Actions</th>
                                      </tr>
                                  </thead>
                                  <tbody id="main-tbody">
                                  	<?php
                                  	$i=0;
                                  	$j=0;
								foreach($variations as $variation){
									//$unit=$variation->unit->id;
									$variation_id=$variation->id;
									if($variation->print_rate == null)
									    $print_rate=0;
									else
									    $print_rate=$variation->print_rate;
									if($variation->opening_stock == null)
									    $opening_stock=0;
									else
									    $opening_stock=$variation->opening_stock;
									?>
                                  	<tr>
                                  		<input type="hidden" name="item_variations[<?= $i ?>][id]" value="<?= $variation_id ?>" id="variation_id">
                                  		<input type="hidden" name="opening_stk" value="<?= $variation->opening_stock ?>">
                                  		<?php $i++; ?>
					                    <td style="vertical-align: bottom;">
					                     <?php echo $i; ?>
					                   
					                    </td>
					                    <td style="vertical-align: bottom;">
					                     <?php echo $this->Form->control('item_variations.0.unit_id', ['empty'=>'--select--','options' => @$UnitVariations,'class'=>'form-control unit_variation_id','label'=>false,'value'=>@$variation->unit_variation->id,'required']); ?>
					                   
					                    </td> 
					                    <td style="vertical-align: bottom;"> <?php echo $this->Form->control('item_variations.0.minimum_quantity_purchase',['class'=>'form-control minimum_quantity_purchase  order_limit','placeholder'=>'Maximum Order Limit', 'label'=>false,'value'=>$variation->minimum_quantity_purchase,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'maxlength'=>10,'type'=>'text','required','min'=>1]); ?></td>
					                     <td style="vertical-align: bottom;"> 
					                    	<?php echo $this->Form->control('item_variations.0.print_rate',['class'=>'form-control print_rate','placeholder'=>'Print Rate','label'=>false,'value'=>@$print_rate,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'maxlength'=>10,'type'=>'text']); ?>
					                    </td> 
					                    <td style="vertical-align: bottom;"> 
					                    	<?php echo $this->Form->control('item_variations.0.sales_rate',['class'=>'form-control sales_rate','placeholder'=>'Sales Rate','label'=>false,'value'=>$variation->sales_rate,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'maxlength'=>10,'type'=>'text','required']); ?>
					                    </td>
					                    <td style="vertical-align: bottom;"> 
					                    	<?php echo $this->Form->control('item_variations.0.opening_stock',['class'=>'form-control opening_stock','placeholder'=>'Opening Stock','label'=>false,'value'=>@$opening_stock,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'maxlength'=>10,'type'=>'text']); ?>
					                    </td>
					                    
					                    <td style="vertical-align: bottom;"> <button type="button" id="plus" class="btn btn-sm green"><i class="fa fa-plus"></i></button>
					                    <button type="button" class="btn btn-sm red deactive" row_id="<?= $variation_id?>"><i class="fa fa-minus"></i></button></td>
					                  
					                </tr>
					            <?php } ?>
					                                  </tbody>
                              </table>
                            </div>
                        </div>
			<?= $this->Form->button(__('Save'),['class'=>'btn btn-success save']) ?>
			<?= $this->Form->button(__('Save & Update On Website'),['class'=>'btn btn-success update']) ?>
			<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>
<table>
              <tbody id="sub-body" class="hidden">
                <tr>
                    <td style="vertical-align: bottom;" class="index"> </td>
                    
                    <td style="vertical-align: bottom;">
                    <?php echo $this->Form->control('item_variations.0.unit_id', ['empty'=>'--select--','options' => @$UnitVariations,'class'=>'form-control unit_variation_id','label'=>false,'required']); ?>
                   </td>
				   
                    <td style="vertical-align: bottom;"> <?php echo $this->Form->control('item_variations.0.minimum_quantity_purchase',['class'=>'form-control minimum_quantity_purchase  order_limit','placeholder'=>'Maximum Order Limit', 'label'=>false,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'maxlength'=>10,'type'=>'text','required','value'=>0,'min'=>1]); ?></td>
					
                     <td style="vertical-align: bottom;"> 
                    	<?php echo $this->Form->control('item_variations.0.print_rate',['class'=>'form-control print_rate','placeholder'=>'Print Rate','label'=>false,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'maxlength'=>10,'type'=>'text','value'=>0]); ?>
                    </td>
					
                    <td style="vertical-align: bottom;"> 
                    	<?php echo $this->Form->control('item_variations.0.sales_rate',['class'=>'form-control sales_rate','placeholder'=>'Sales Rate','label'=>false,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'maxlength'=>10,'type'=>'text','required','value'=>0]); ?>
                    </td>
                    <td style="vertical-align: bottom;"> 
                    	<?php echo $this->Form->control('item_variations.0.opening_stock',['class'=>'form-control opening_stock','placeholder'=>'Opening Stock','label'=>false,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'maxlength'=>10,'type'=>'text','value'=>0]); ?>
                    </td>
                    <td style="vertical-align: bottom;"> <button type="button" id="plus" class="btn btn-sm green"><i class="fa fa-plus"></i></button>
                      <button type="button" id="minus" class="btn btn-sm red"><i class="fa fa-minus"></i></button>
					</td>
                </tr>
              </tbody>
            </table>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>

<script>
$(document).ready(function() {

$(document).on('click','.deactive',function(){
	var count=$('#main-tbody').children().length;
	var ww=$(this);
            if(count >= 2)
            {
				var variation_id=$(this).attr('row_id');
				var url="<?php echo $this->Url->build(["controller" => "ItemVariations", "action" => "deactive"]); ?>";
						//alert(url);
						 			$.ajax({
					                    url: url,
					                    type: 'post',
					                    data: {variation_id: variation_id},
					                   success: function(response)
					                	{ 
					                		if(response == 1) 
					                		{
					                			alert("Deleted Successfully")
					                			 ww.parent().parent().remove();
                                    			rename_row(); 
				                			}
				                			
				                		}
					              });
						 		}
			else
			{
				alert("Not Deleted");
			}
	});


 $(document).on('click','.save',function(){
 	$('#button_value').val('save');
 	 // $('#main-tbody').find('tr').each(function()
   //      {
		 // 	var variation_id=$(this).find('#variation_id').val();
		 // 	alert(variation_id);
			// var url="<?php echo $this->Url->build(["controller" => "ItemLedgers", "action" => "delOpeningStock"]); ?>";
			// alert(url);
			//  			$.ajax({
		 //                    url: url,
		 //                    type: 'get',
		 //                    data: {variation_id: variation_id},
		 //                   success: function(response)
		 //                	{ 
		 //                    	alert(response);
		 //                    }
		 //              });
			// });
        });
 $(document).on('click','.update',function(){
 	$('#button_value').val('update');
 });

	/* var gst_apply = $('.gst').val();
	if(gst_apply=='Yes'){
		$('.gst_show').show();
	}else{
		$('.gst_show').hide();
	}
	
$('.gst').on('change',function(){
	var gst_apply=$(this).val();
	if(gst_apply=='Yes'){
		$('.gst_show').show();
	}else{
		$('.gst_show').hide();
	}
}); */
	
	$(".minimum_stock").die().live('keyup',function(){
		var minimum=$(this).val();
		$(this).closest('tr').find('.order_limit').attr('max',minimum);
	});
	
	rename_row();

	 var radio = "<label class='radio-inline'><input type='radio' name='item_variations[0][ready_to_sale]' class='ready' value='Yes' checked>Yes </label><label class='radio-inline'><input type='radio' name='item_variations[0][ready_to_sale]' class='ready' value='No'>No </label>";

   

	 $('.myRadio').html(radio);
	 $(document).on('click','#plus',function(){

           add_row();
      });
        $(document).on('click','#minus',function(){

           var count=$('#main-tbody').children().length;
           var url="<?php echo $this->Url->build(["controller" => "ItemVariations", "action" => "delete"]); ?>";
            if(count >= 2)
            {
                var id = $(this).attr('row_id');
                if(id)
                {
                    var confirms = confirm('Are you sure you want to Deactive this Variation ?');
                    if(confirms)
                    {
                        $.ajax({
                            url: url,
                            type: 'post',
                            data: {id: id},
                            success: function (success) {
                            	alert(success);
                                if(success == 1)
                                {
                                    
                                    $(this).parent().parent().remove();
                                    rename_row(); 
                                }
                                else
                                {
                                    alert('Not Deleted');
                                }
                            }
                        });
                    }
                }
                else
                {
                    $(this).parent().parent().remove();
                    rename_row();
                }
            }
        }); 
	function add_row()
    {

      var tr = $('#sub-body>tr:last').clone();
      $('#main-tbody').append(tr);
      $('#main-tbody>tr:last').find('.myRadio').html(radio); 
      rename_row();
    }
   function rename_row()
      {
        var i=0;
        var a=1;
        $('#main-tbody').find('tr').each(function()
        {
            
            $(this).find('.index').html(a);
            $(this).find('.unit_variation_id').attr('name','item_variations['+i+'][unit_variation_id]');
            
            $(this).find('.minimum_quantity_purchase').attr('name','item_variations['+i+'][minimum_quantity_purchase]');

            $(this).find('.print_rate').attr('name','item_variations['+i+'][print_rate]');
            $(this).find('.sales_rate').attr('name','item_variations['+i+'][sales_rate]');
            $(this).find('.opening_stock').attr('name','item_variations['+i+'][opening_stock]');
			i++;
			a++
          });
          
       }

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
				},
				image:{
					required: false,
				},
				alias_name:{
					required: false,
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
	
	$(".attribute").die().live('change',function(){
		var unt_attr_name = $('option:selected', this).attr('unit_name');	
			$("#msg").html('Minimum Stock in '+ unt_attr_name);
			if(unt_attr_name=='kg'){
				var data=$("#data_fetch").html();
				$(".set").html(data);
			}else{
				var data=$("#data_fetch2").html();
				$(".set").html(data);
			}
 	});
	$(".order_limit").die().live('keyup',function(){
	var unt_attr_name = $('.attribute option:selected').attr('unit_name');
	var limit = $(".order_limit").val();
	var final_value = $(this).val();
		if(unt_attr_name=='kg'){
				var quantity_factor = $(".qunt_factor option:selected").val();
				var total = quantity_factor*limit;
				$("#msg2").html(final_value +' '+ unt_attr_name);
			}else{
				$("#msg2").html(final_value +' '+ unt_attr_name);
			}
	});

	$(".virt").die().live('click',function(){
		var virtual = $(this).val();
			if(virtual=='yes'){
				var data=$("#fetch").html();
 				$(".set2").html(data);
				$('.virtual_box').select2();
			}else{
				$(".set2").html('');
			}
 	});
});
</script>
<?php
	$factor_select[]= ['value'=>0.10,'text'=>'100 gm'];
	$factor_select[]= ['value'=>0.25,'text'=>'250 gm'];
	$factor_select[]= ['value'=>0.50,'text'=>'500 gm'];
	$factor_select[]= ['value'=>1,'text'=>'1 kg'];
	$factor_select[]= ['value'=>2,'text'=>'2 kg'];
?>
<div id="data_fetch" style="display:none;">
	<?php echo $this->Form->control('minimum_quantity_factor', ['options' => $factor_select,'class'=>'form-control input-sm qunt_factor']); ?>
</div>

<div id="data_fetch2" style="display:none;">
	<?php echo $this->Form->control('minimum_quantity_factor', ['class'=>'form-control input-sm qunt_factor', 'placeholder'=>'Minimum Quantity Factor']); ?>
</div>

<div id="fetch" style="display:none;">
	<?php echo $this->Form->control('parent_item_id', ['options' => $item_fetchs, 'class'=>'form-control input-sm virtual_box']); ?>
</div>