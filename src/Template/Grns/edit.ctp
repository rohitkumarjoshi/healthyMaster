<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
    vertical-align: top !important;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="font-purple-intense"></i>
                    <span class="caption-subject font-purple-intense "><i class="fa fa-plus"></i> Create New Goods Received Note </span>
                </div>
                
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($grn,['id'=>'form_sample_3']) ?>
                <div class="row">
                    <div class="col-md-4">
                        <label class=" control-label">GRN Date <span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('transaction_date',['placeholder'=>'dd-mm-yyyy','class'=>'form-control input-sm date-picker','data-date-format'=>'dd-mm-yyyy','label'=>false,'type'=>'text','value'=>date('d-m-Y')]); ?>
                        
                    </div>
                    <div class="col-md-4">
                        <label class=" control-label">vendor <span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('vendor_id',['options' => $vendors,'class'=>'form-control input-sm','label'=>false]); ?>
                        <input type="hidden" name="id" value="<?= $grn->id?>">
                    </div>
                    <div class="col-md-4">
                        <label class=" control-label">Warehouse <span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('warehouse_id',['options' => $warehouses,'class'=>'form-control input-sm','label'=>false]); ?>
                    </div>
                </div><br/>
                <div class="row">
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-6 control-label">Additional Note<span class="required"     aria-required="true">*</span></label>
                                         <?= $this->Form->input('additional_note',['class'=>'form-control input-sm','id'=>'msg','label'=>false,'placeholder'=>'','rows'=>'3','style'=>'resize: none;']) ?>
                                    </div>   
                                </div>
                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-8">
                        <table id="main_table" class="table table-condensed table-bordered">
                            <thead>
                                <tr align="center">
                                    <td>
                                        <label>Sr<label>
                                    </td>
                                    <td>
                                        <label>item<label>
                                    </td>
                                    <td>
                                        <label>Variation<label>
                                    </td>
                                    <td>
                                        <label>Quantity<label>
                                    </td>
                                    <td>
                                        <label>Action</label>
                                    </td>
                                </tr>
                            </thead>
                            <tbody id='main_tbody' class="tab">
                              <?php $k=0;
                                foreach($grn->grn_details as $grn_detail){
                                    $quantity_variation=$grn_detail->item_variation->quantity_variation;
                                    $item_id=$grn_detail->item_id;
                                    $quantity=$grn_detail->quantity;
                                    ?>
                                    <tr class="main_tr" class="tab">
                                        <td align="center" width="1px"></td>
                                        <td>
                                            <?php echo $this->Form->input('item_id', ['empty'=>'--Select-','options'=>$item,'label' => false,'class' => 'form-control input-sm attribute item_id', 'value'=>$item_id]); ?>
                                            <input type="hidden" name="grn_detail_id" value="<?= $grn_detail->id?>">
                                           
                                        </td>
                                        <td>
                                            <select name="variation" class="form-control input-sm varition ">
                                                <option value="<?=$grn_detail->item_variation_id ?>"><?= $quantity_variation?></option>
                                                
                                            </select>

                                            <span class="msg_shw2" style="color:blue;font-size:12px;"></span>
                                        </td>
                                        <td>
                                            <?php echo $this->Form->input('show_quantity', ['label' => false,'class' => 'form-control input-sm number cal_amount quant','value'=>$quantity]); ?>
                                            
                                            <!-- <span class="msg_shw2" style="color:blue;font-size:12px;"><?php echo $msg_box_show.' '.$unit_name; ?></span> -->
                                            <?php echo $this->Form->input('quantity', ['label' => false,'class' => 'form-control input-sm number mains', 'type'=>'hidden','value'=>$quantity]); ?>
                                        </td>
                                       
                                        <td>
                                            <a class="btn btn-default delete-tr input-sm" href="#" role="button" ><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                            <?php $k++; } ?>
                            </tbody>
                            <tfoot>
                                
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md-1"></div>
                    
                </div>
                 
                <br/>
                <?= $this->Form->button($this->Html->tag('i', '', ['class'=>'fa fa-plus']) . __(' Submit'),['class'=>'btn btn-success']); ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
    

     $(document).on('change','.item-id',function(){
        var input=$(this).val();
        var master = $(this); 
        
        if(input.length>0){
            var m_data = new FormData();
            var url ="<?php echo $this->Url->build(["controller" => "Grns", "action" => "options"]); ?>";
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
                                    //alert(data);
                    master.closest('tr').find("td:nth-child(3) .varition option").remove();
                    master.closest('tr').find('td:nth-child(3) .varition').append(data);
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
    $('.delete-tr').live('click',function() 
    {
        var rowCount = $('#main_table tbody#main_tbody tr').length; 
        if(rowCount>1)
        {
             $(this).closest('tr').remove();
             
        }
        rename_rows();
    });

    $('.add_row').click(function(){
        add_row();
    });

    add_row();
    function add_row(){
        var tr=$("#sample_table tbody tr.main_tr").clone();
        $("#main_table tbody#main_tbody").append(tr);

        rename_rows();
    }

    function rename_rows(){
        var i=0; 
        $("#main_table tbody#main_tbody tr.main_tr").each(function(){
            $(this).find('td:nth-child(1)').html(i+1);
            $(this).find("td:nth-child(2) select").select2().attr({name:"grn_details["+i+"][item_id]", id:"grn_details-"+i+"-item_id"}).rules('add', {
                        required: true
                    });
            $(this).find("td:nth-child(3) select").attr({name:"grn_details["+i+"][item_variation_id]"}).rules('add', {
                        required: true
                    });
            $(this).find("td:nth-child(4) input").attr({name:"grn_details["+i+"][quantity]", id:"grn_details-"+i+"-quantity"}).rules('add', {
                        required: true
                    });
            i++;
        });
    }

    $(".attribute").die().live('change',function(){
        var raw_attr_name = $('option:selected', this).attr('unit_name');
        //$(this).closest('tr').find('.quant').attr('unit_name', ''+raw_attr_name+'');
        //$(this).closest('tr').find('.msg_shw').html("Selling Factor in : " +raw_attr_name);
    });
    
    $(".quant").die().live('keyup',function(){
        var quant = parseFloat($(this).val());
        if(!quant){ quant=0; }
        var minimum_quantity_factor = parseFloat($(this).attr('minimum_quantity_factor'));
        if(!minimum_quantity_factor){ minimum_quantity_factor=0; }
        var unit_name = $(this).attr('unit_name');
        if(!unit_name){ unit_name=0; }
        var g_total = quant*minimum_quantity_factor;
        //$(this).closest('tr').find('.msg_shw2').html(quant+" "+unit_name);
    });

});
</script>
<table id="sample_table" style="display:none;" >
            <tbody>
                <tr class="main_tr" class="tab">
                    <td align="center" width="1px"></td>
                    <td>
                        <?php echo $this->Form->input('grn_details[0][item_id]', ['empty'=>'--Select-','options'=>$item,'label' => false,'class' => 'form-control input-sm attribute item-id','id'=>'item']); ?>
                         
                        <span class="msg_shw" style="color:blue;font-size:12px;"></span>

                    </td>
                    <td>
                        <select name="variation" class="form-control input-sm varition">
                        </select>
                    </td>
                    <td>
                        <?php echo $this->Form->input('grn_details[0][quantity]', ['label' => false,'class' => 'form-control input-sm number quant','placeholder'=>'Quantity']); ?>
                        <span class="msg_shw2" style="color:blue;font-size:12px;"></span>   
                    </td>
                    <td>
                       <!--  <a class="btn btn-default delete-tr input-sm" href="#" role="button" ><i class="fa fa-times"></i></a> -->
                        <button type="button" id="minus" class="minus btn btn-sm delete-tr" row_id="<?= $grn_detail['id']?>"><i class="fa fa-times"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
