<div class="row">
    
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" fa fa-gift"></i>
                    <span class="caption-subject">REFERAL</span>
                </div>
            </div>
            <div class="portlet-body">
                <div style="overflow-y: scroll;height: 400px;">
                    <table class="table table-bordered table-condensed pagin-table" id="main_tble">
                        <thead>
                            <tr>
                                <th><?=  h('Sr.no') ?></th>
                                <th><?=  h('Receiver Amount') ?></th>
                                <th><?=  h('Sender Amount') ?></th>
                                <th><?=  h('Order Value') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody id="main_tbody">
                            <?php
                            $k=0;
                            foreach ($referalMasters as $referalMaster):
                                @$k++;
                            ?>
                            <tr class="main_tr">
                                <td><?= h($k) ?></td>
                                <td><?= h($referalMaster->receiver_amount) ?></td>
                                <td><?= h($referalMaster->sender_amount) ?></td>
                                <td><?= h($referalMaster->order_value) ?></td>
                                
                                <td class="actions">
                                <?php echo $this->Html->link('<i class="fa fa-pencil"></i>',['action' => 'edit', $referalMaster->id],['escape'=>false,'class'=>'btn btn-xs blue edit']); ?>
                                
                               <!-- <?php 
                                    if($referalMaster->status == 0)
                                    { ?>
                                    <?= $this->Form->postLink(__('Deactive'), ['action' => 'delete', $referalMaster->id], ['confirm' => __('Are you sure you want to Deactive # {0}?'),'class'=>'btn btn-xs green']) ?> 
                                    <?php }
                                    if($referalMaster->status == 1)
                                    { ?>
                                        <?= $this->Form->postLink(__('Active'), ['action' => 'delete1', $referalMaster->id], ['confirm' => __('Are you sure you want to Active # {0}?'),'class'=>'btn btn-xs green']) ?>
                                    <?php }
                                ?> -->
                                
                                </td>
                                
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
    // $('.edit').on('click',function()
    // {
    //     ('.add').display();
    // });
var form3 = $('#form_sample_3');
    var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
    form3.validate({
        
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: true, // do not focus the last invalid input
        rules: {
                receiver_amount:{
                    required: true,                  
                },
                sender_amount:{
                    required: true,                  
                },
                order_value:{
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
</script>