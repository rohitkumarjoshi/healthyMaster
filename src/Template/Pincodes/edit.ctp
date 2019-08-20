<div class="row">
    <div class="col-md-9">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="font-purple-intense"></i>
                    <span class="caption-subject font-purple-intense "> EDIT PINCODE
                        
                    </span>
                </div>
                
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($pincode,['id'=>'form_sample_3']) ?>
                <div class="row">
                    <div class="col-md-3"><!-- 
                        <?php echo $this->Form->control('state_id',['placeholder'=>'State','class'=>'form-control input-sm state','label'=>false]); ?> -->
                         <?php echo $this->Form->control('state_id', ['empty'=>'-- select --','options' =>$states,'class'=>'form-control input-sm select select2me select2 state','required']); ?>
                    </div>
					<div class="col-md-3">
                         <?php echo $this->Form->control('city_id', ['empty'=>'-- select --','options' =>$cities,'class'=>'form-control input-sm city','required']); ?>
                    </div>
                    <div class="col-md-3">
                        <label class=" control-label">Pincode <span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('pincode',['placeholder'=>'pincode','class'=>'form-control input-sm','label'=>false,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'maxlength'=>6,'type'=>'text','required']); ?>
                    </div>
                    <div class="col-md-3">
                        <label>Deliver<span class="required" aria-required="true">*</span></label>
                        <!-- <input type="text" name="we_deliver" class="form-control input-sm" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" required value="<?php echo @$pincode->we_deliver; ?>"> -->
                        <select name="we_deliver" class="form-control input-sm">
                            <?php if($pincode->we_deliver == "Yes")
                            {?>
                                <option value="Yes" selected>Yes</option>
                                <!-- <option value="No">No</option>
                            <?php } if($pincode->we_deliver == "No")
                            {?>
                                <option value="Yes" >Yes</option>
                                <option value="No" selected>No</option>
                            <?php } ?> -->
                           
                        </select>
                    </div>
                </div><br>
                 <div class="row">
                    <div class="col-md-3">
                        <input type="hidden" name="delivery_charge[pincode_no]" value="<?= @$pincode->pincode ?>">
                        <label>100Gm<span class="required" aria-required="true">*</span></label>
                        <input type="text" name="delivery_charge[hundred_gm]" class="form-control input-sm" id="amt" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" required value="<?php echo @$pincode->delivery_charge->hundred_gm; ?>">
                            <input type="hidden" name="delivery_charge[state_id]" id="del_state" value="<?= @$pincode->state_id?>">
                            <input type="hidden" name="delivery_charge[city_id]" id="del_city" value="<?= @$pincode->city_id?>">
                    </div>
                     <div class="col-md-3">
                        <label>500Gm<span class="required" aria-required="true">*</span></label>
                        <input type="text" name="delivery_charge[five_hundred_gm]" class="form-control input-sm" id="amt" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" required value="<?php echo @$pincode->delivery_charge->five_hundred_gm; ?>">
                    </div>
                     <div class="col-md-3">
                        <label>1Kg<span class="required" aria-required="true">*</span></label>
                        <input type="text" name="delivery_charge[one_kg]" class="form-control input-sm" id="amt" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" required value="<?php echo @$pincode->delivery_charge->one_kg; ?>">
                    </div>
                    <div class="col-md-3">
                        <label>Minimum Order<span class="required" aria-required="true">*</span></label>
                        <input type="text" name="delivery_charge[min_order_value]" class="form-control input-sm" id="charge" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" required value="<?php echo @$pincode->delivery_charge->min_order_value; ?>">
                    </div>
                </div>
                 <div class="row" style="margin-top: 10px;">
                     <div class="col-md-3">
                        <label class=" control-label">Delivery Duration<span class="required" aria-required="true">*</span> </label>
                        <input type="text" name="delivery_charge[delivery_duration]"  class="form-control input-sm"  value="<?php echo @$pincode->delivery_charge->delivery_duration; ?>">
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

     $(document).on('change','.city',function(){
        
        var inputs=$(this).val();
        $('#del_city').val(inputs);
    });

    $(document).on('change','.state',function(){
        
        var input=$(this).val();
        $('#del_state').val(input);
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
    
      var deliver_value= $('.wedeliver').val();
      //alert(deliver_value);
       if(deliver_value == "No")
       {
            $('.delivery_reason').show();
            $('.Yesbox').hide();
       }
       if(deliver_value == "Yes")
       {
            $('.delivery_reason').hide();
            $('.Yesbox').show();
       }
    
     $('.wedeliver').on('change',function(){
       var deliver_value=$(this).val();
       if(deliver_value == "No")
       {
            $('.delivery_reason').show();
            $('.delivery_reason').attr('required','required');
            $('.Yesbox').hide();
       }
       if(deliver_value == "Yes")
       {
            $('.delivery_reason').hide();
            $('.Yesbox').show();
            $('.Yesbox').attr('required','required');
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
                franchise_id:{
                    required: true,
                },
                mobile:{
                    required: true,
                },
                address:{
                    required: true,
                },
				pincode:{
						required:true,
						number:true,
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
    //--     END OF VALIDATION
    
    
});
</script>

