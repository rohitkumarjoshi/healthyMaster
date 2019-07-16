<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="font-purple-intense"></i>
                    <span class="caption-subject font-purple-intense ">
                        <i class="fa fa-plus"></i> Add Vendor Item
                    </span>
                </div>
                <div class="actions">
                </div>
            </div>
            <div class="portlet-body">
            <?= $this->Form->create($vendorRow,['type'=>'file','id'=>'form_sample_3']) ?>
                    
                <div class="row">
                        <div class="col-md-12" style="margin-top: 10px;">
                              <table class="table table-striped table-bordered">
                                  <thead>
                                      <tr>
                                          <th width="10%">S.No</th>
                                          <th width="10%">Vendor</th>
                                          <th width="10%">Item</th>
                                          <th width="10%">Actions</th>
                                      </tr>
                                  </thead>
                                  <tbody id="main-tbody">
                                  
                                  </tbody>
                              </table>
                            </div>
                        </div>
            <?= $this->Form->button(__('Add Vendor Item'),['class'=>'btn btn-success']) ?>
            <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
<table>
              <tbody id="sub-body" class="hidden">
                <tr>
                    <td style="vertical-align: bottom;" class="index"> </td>
                    <td style="vertical-align: bottom;"><?php echo $this->Form->control('vendor.0.vendor_id', ['empty'=>'--select--','options' => @$vendors,'class'=>'form-control vendor','label'=>false]); ?>
                        
                    </td>
                    <td style="vertical-align: bottom;">
                    <?php echo $this->Form->control('vendor.0.item_id', ['empty'=>'--select--','options' => @$items,'class'=>'form-control item','label'=>false]); ?>
                    </td>
                    
                    <td style="vertical-align: bottom;"> <button type="button" id="plus" class="btn btn-sm green"><i class="fa fa-plus"></i></button>
                      <button type="button" id="minus" class="btn btn-sm red"><i class="fa fa-minus"></i></button></td>
                </tr>
              </tbody>
            </table>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>

<script>
$(document).ready(function() {

add_row();

     $(document).on('click','#plus',function(){
           add_row();
      });
       $(document).on('click','#minus',function(){
           var count=$('#main-tbody').children().length;
            if(count >= 2)
            {
              $(this).parent().parent().remove();
              rename_row();
            }
        });

    function add_row()
    {

      var tr = $('#sub-body>tr:last').clone();
      $('#main-tbody').append(tr);
      rename_row();
    }
   function rename_row()
      {
        var i=0;
        var a=1;
        $('#main-tbody').find('tr').each(function()
        {
            
            $(this).find('.index').html(a);
            $(this).find('.vendor').attr('name','vendor['+i+'][vendor_id]');
            $(this).find('.item').attr('name','vendor['+i+'][item_id]');
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
                    required: true,
                },
                short_description:{
                    required: true,
                },
                benefit:{
                    required: true,
                },
                item_code:{
                    required: true,
                },
                alias_name:{
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

});
    //--     END OF VALIDATION
    
  
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