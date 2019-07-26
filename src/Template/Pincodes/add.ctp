<div class="row">
    <div class="col-md-10">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="font-purple-intense"></i>
                    <span class="caption-subject font-purple-intense ">ADD PINCODE
                        
                    </span>
                </div>
                
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($pincode,['id'=>'form_sample_3']) ?>
                <div class="row">
                    <div class="col-md-3">
                        <?= $this->Form->control('id',['type'=>'hidden']); ?>
                        <label>State</label>
                        <?php echo $this->Form->control('state_id', ['empty'=>'-- select --','options' => $states,'class'=>'form-control input-sm select select2me select2 state','required','label'=>false]); ?>
                    </div>
                    <div class="col-md-3">
                       <label class=" control-label">City<span class="required" aria-required="true">*</span> </label>
                        <select name="city_id" class="form-control input-sm city" required>
                            
                            
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class=" control-label">Pincode<span class="required" aria-required="true">*</span> </label>
                        <?php echo $this->Form->control('pincode',['placeholder'=>'Pincode','class'=>'form-control input-sm','label'=>false,'maxlength'=>6,'minlength'=>6,'required']); ?>
                    </div>
                    <div class="col-md-3">
                        <label>We Deliver<span class="required" aria-required="true">*</span></label>
                        <select name="we_deliver" class="form-control input-sm wedeliver"  id="delivery">
                            <option value="">--Select--</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div><br>
                <div class="row delivery_reason display-none">
                    <div class="col-md-10">
                        <label>Delivery Reason<span class="required" aria-required="true">*</span></label>
                        <textarea name="delivery_reason" class="form-control" id="reason" ><?= @$pincode->delivery_reason?></textarea>
                    </div>
                </div>
                <div class="row Yesbox display-none">
                    <div class="col-md-3">
                        <label>Minimum Amount<span class="required" aria-required="true">*</span></label>
                        <input type="text" name="amount" class="form-control input-sm" id="amt">
                    </div>
                    <div class="col-md-3">
                        <label>Delivery Charge<span class="required" aria-required="true">*</span></label>
                        <input type="text" name="charge" class="form-control input-sm" id="charge">
                    </div>
                    <!--<div class="col-md-3">
                        <label>Type</label>
                        <input type="text" name="type" class="form-control input-sm" value="0">
                    </div>-->
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

$(document).on('change','#delivery',function(){
    var del=$(this).val();
    //alert(del);
    if(del == "No")
    {
        $('#reason').attr('required','required');
    }
    if(del == "Yes")
    {
        $('#charge').attr('required','required');
        $('#amt').attr('required','required');
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
                    city_id: true,                  
                },
                franchise_id:{
                    required: true,
                },
                mobile:{
                    required: true,
                },
                we_deliver:{
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
    //--     END OF VALIDATION
    
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

