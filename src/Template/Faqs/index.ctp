
<div class="page-content-wrap">
            
    <div class="row">
        <div class="col-md-5">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="font-purple-intense"></i>
                        <span class="caption-subject font-purple-intense ">
                              <?php 
                            if(!empty($id)){ ?> EDIT FAQ
                            <?php }else{ ?> ADD FAQ
                            <?php } ?>
                        </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <?= $this->Form->create($faq,['id'=>'form_sample_3']) ?>
                    <div class="row">
                            <div class="col-md-12">
                                <label class=" control-label">Question<span class="required" aria-required="true">*</span></label>
                                <?php echo $this->Form->control('question',['placeholder'=>'Question','class'=>'form-control input-sm','label'=>false,'required']); ?>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                            <label class=" control-label">Answer<span class="required" aria-required="true">*</span></label>
                                <?php echo $this->Form->control('answer',['placeholder'=>'Answer','class'=>'form-control input-sm','label'=>false,'required']); ?>
                            </div>
                        </div>   
                    <?= $this->Form->button($this->Html->tag('i', '') . __(' Submit'),['class'=>'btn btn-success','style'=>'margin-top:10px;']); ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">LIST FAQ</h3>
                <div class="pull-right">
                    <!-- <div class="pull-left">
                        <?= $this->Form->create('Search',['type'=>'GET']) ?>
                        <?= $this->Html->link(__('<span class="fa fa-plus"></span> Add New'), ['action' => 'add'],['style'=>'margin-top:-30px !important;','class'=>'btn btn-success','escape'=>false]) ?>
                        <div class="form-group" style="display:inline-table">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <span class="fa fa-search"></span>
                                </div>
                                <?= $this->Form->control('search',['class'=>'form-control','placeholder'=>'Search...','label'=>false]) ?>
                                <div class="input-group-btn">
                                    <?= $this->Form->button(__('Search'),['class'=>'btn btn-primary']) ?>
                                </div>
                            </div>
                        </div>
                        <?= $this->Form->end() ?>
                    </div>  -->
                </div>   
            </div>
                
            <div class="panel-body">
                <?php $page_no=$this->Paginator->current('delivery_charges'); $page_no=($page_no-1)*20; ?>
                <div class="table-responsive">
                        <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><?= ('SN.') ?></th>
                                        <th><?= ('Question') ?></th>
                                        <th><?= ('Answer') ?></th>
                                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                                    </tr>
                                </thead>
                           <tbody>                                            
                                <?php 
                                $i = $paginate_limit*($this->Paginator->counter('{{page}}')-1);
                                foreach ($faqs as $faq_data): ?>
                                <tr>
                                    <td><?= $this->Number->format(++$i) ?></td>
                                    <td><?= h($faq_data->question) ?></td>
                                    <td><?= h($faq_data->answer) ?></td>
                                    <td class="actions">
                                    
                                        <?php
                                            $faq_data_id = $faq_data->id;
                                        ?>
                                        
                                        <?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'index', $faq_data_id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
                                        <?= $this->Form->postLink('<span class="fa fa-trash"></span>', ['action' => 'delete', $faq_data_id], ['class'=>'btn btn-danger btn-condensed btn-sm red','confirm' => __('Are you sure you want to delete?'),'escape'=>false]) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                           </tbody>
                    </table>
                </div>       
            </div>      
               <div class="panel-footer">
                        <div class="paginator pull-right">
                                <ul class="pagination">
                                <?= $this->Paginator->first(__('First')) ?>
                                <?= $this->Paginator->prev(__('Previous')) ?>
                                <?= $this->Paginator->numbers() ?>
                                <?= $this->Paginator->next(__('Next')) ?>
                                <?= $this->Paginator->last(__('Last')) ?>
                                </ul>
                                <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
                        </div>
               </div>              
            </div>
        </div>
    </div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
    
  //--------- FORM VALIDATION
    var form3 = $('#form_sample_3');
    var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
    form3.validate({
        
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: true, // do not focus the last invalid input
        rules: {
                question:{
                    required: true,                  
                },
                answer:{
                    required: true,                  
                },
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
                    }
            },
       

    });
});
</script>
 