
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="font-purple-intense"></i>
                    <span class="caption-subject font-purple-intense ">Edit Vendor Item</span>
                </div>
                
            </div>
            <div class="portlet-body">  
                 <?= $this->Form->create($vendorRow) ?>
                <div class="row">
                    <div class="col-md-3">
                        <label class=" control-label">Vendor<span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('vendor_id',['class'=>'form-control input-sm','label'=>false,'options'=>$vendors]); ?>
                    </div>
                    <div class="col-md-3">
                        <label class=" control-label">Item<span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('item_id',['class'=>'form-control input-sm mobile','label'=>false,'options'=>$items]); ?>
                    </div>
                   
                </div>
                <br/>
                <?= $this->Form->button($this->Html->tag('i', '') . __(' Submit'),['class'=>'btn btn-success']); ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>