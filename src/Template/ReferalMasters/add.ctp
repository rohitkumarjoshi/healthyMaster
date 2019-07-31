<div class="row">
    <div class="col-md-5 col-sm-5">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="font-purple-intense"></i>
                    <span class="caption-subject font-purple-intense ">
                          <?php 
                        if(!empty($id)){ ?> EDIT Referal
                        <?php }else{ ?> ADD Referal
                        <?php } ?>
                    </span>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($referalMaster,['id'=>'form_sample_3']) ?>
                <div class="row" style="margin-top:5px;">
                    <div class="col-md-8">
                        <label class=" control-label">Receiver Amount<span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('receiver_amount',['class'=>'form-control input-sm','label'=>false,'maxlength'=>'50']); ?>
                        
                    </div>
                </div>
                <div class="row" style="margin-top:5px;">
                    <div class="col-md-8">
                        <label class=" control-label">Sender Amount<span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('sender_amount',['class'=>'form-control input-sm','label'=>false,'maxlength'=>'50']); ?>
                        
                    </div>
                </div>
                <div class="row" style="margin-top:5px;">
                    <div class="col-md-8">
                        <label class=" control-label">Order Value<span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('order_value',['class'=>'form-control input-sm','label'=>false,'maxlength'=>'50']); ?>
                        
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
                                <th><?=  h('Receiver Amount') ?></th>
                                <th><?=  h('Sender Amount') ?></th>
                                <th><?=  h('Order Value') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody id="main_tbody">
                            <?php
                            $k=0;
                            foreach ($refer as $referalMaster):
                                @$k++;
                            ?>
                            <tr class="main_tr">
                                <td><?= h($k) ?></td>
                                <td><?= h($referalMaster->receiver_amount) ?></td>
                                <td><?= h($referalMaster->sender_amount) ?></td>
                                <td><?= h($referalMaster->order_value) ?></td>
                                
                                <td class="actions">
                                <?php echo $this->Html->link('<i class="fa fa-pencil"></i>',['action' => 'index', $referalMaster->id],['escape'=>false,'class'=>'btn btn-xs blue']); ?>
                                
                               <?php 
                                    if($referalMaster->status == 0)
                                    { ?>
                                    <?= $this->Form->postLink(__('Deactive'), ['action' => 'delete', $referalMaster->id], ['confirm' => __('Are you sure you want to Deactive # {0}?'),'class'=>'btn btn-xs green']) ?> 
                                    <?php }
                                    if($referalMaster->status == 1)
                                    { ?>
                                        <?= $this->Form->postLink(__('Active'), ['action' => 'delete1', $referalMaster->id], ['confirm' => __('Are you sure you want to Active # {0}?'),'class'=>'btn btn-xs green']) ?>
                                    <?php }
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