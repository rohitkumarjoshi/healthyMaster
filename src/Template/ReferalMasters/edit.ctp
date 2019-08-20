<div class="col-md-5 col-sm-5">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="font-purple-intense"></i>
                    <span class="caption-subject font-purple-intense ">
                         EDIT REFERAL
                        
                    </span>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($referalMaster,['id'=>'form_sample_3']) ?>
                <div class="row" style="margin-top:5px;">
                    <div class="col-md-8">
                        <label class=" control-label">Receiver Amount<span class="required" aria-required="true">*</span></label>
                        <input type="hidden" name="id" value="<?=$id ?>">
                        <?php echo $this->Form->control('receiver_amount',['class'=>'form-control input-sm','label'=>false,'maxlength'=>'50','type'=>'number','required']); ?>
                        
                        
                    </div>
                </div>
                <div class="row" style="margin-top:5px;">
                    <div class="col-md-8">
                        <label class=" control-label">Sender Amount<span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('sender_amount',['class'=>'form-control input-sm','label'=>false,'maxlength'=>'50','type'=>'number','required']); ?>
                        
                    </div>
                </div>
                <div class="row" style="margin-top:5px;">
                    <div class="col-md-8">
                        <label class=" control-label">Order Value<span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('order_value',['class'=>'form-control input-sm','label'=>false,'maxlength'=>'50','type'=>'number','required']); ?>
                        
                    </div>
                </div>
                <br/>
                <?= $this->Form->button($this->Html->tag('i', '') . __(' Submit'),['class'=>'btn btn-success']); ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>