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
                <?= $this->Form->create($customerAddress,['id'=>'form_sample_3']) ?>
                <div class="row" style="margin-top:5px;">
                    <div class="col-md-8">
                        <label class=" control-label">Receiver Amount<span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('receiver_amount',['class'=>'form-control input-sm','label'=>false,'maxlength'=>'50']); ?>
                        
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-8">
                        <label class=" control-label">Mobile <span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('mobile',['placeholder'=>'Mobile','class'=>'form-control input-sm','label'=>false,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'minlength'=>10]); ?>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-8">
                        <label class=" control-label">House no <span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('house_no',['placeholder'=>'House no','class'=>'form-control input-sm','label'=>false,'maxlength'=>'50']); ?>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-8">
                        <label class=" control-label">Apartment Name</label>
                        <?php echo $this->Form->control('apartment_name',['placeholder'=>'Apartment Name','class'=>'form-control input-sm','label'=>false,'maxlength'=>'50']); ?>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-8">
                        <label class=" control-label">Landmark<span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('address',['placeholder'=>'Landmark','class'=>'form-control input-sm','label'=>false,'maxlength'=>'150']); ?>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-8">
                        <label class=" control-label">Locality</label>
                        <?php echo $this->Form->control('locality',['placeholder'=>'locality','class'=>'form-control input-sm','label'=>false,'maxlength'=>'50']); ?>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-8">
                        <label class=" control-label">Pincode<span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('pincode',['placeholder'=>'Pincode','class'=>'form-control input-sm','label'=>false,'oninput'=>"this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",'maxlength'=>6,'type'=>'text','required']); ?>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-8">
                        <label class=" control-label">State<span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('state_id', ['empty'=>'-- select --','options' => $states,'class'=>'form-control input-sm select select2me select2 state','required','label'=>false]); ?>
                    </div>
                </div>
                
                <div class="col-md-8">
                       <label class=" control-label">City <span class="required" aria-required="true">* </label>
                        <select name="city_id" class="form-control input-sm city select2" required>
                            
                            <option value="<?= @$customerAddress->city_id?>"><?= @$customerAddress->city->name?></option>
                            
                        </select>
                 </div>
                
                 <br>
                <div class="row" style="margin-top:10px;">
                    <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label">Default Address<span class="required" aria-required="true">*</span></label>
                                    <div class="radio-list">
                                        <div class="radio-inline default" style="padding-left: 0px;">
                                            <?php echo $this->Form->radio(
                                            'default_address',
                                            [
                                                ['value' => '0', 'text' => 'No','class' => 'radio-task virt ','checked' => 'checked'],
                                                ['value' => '1', 'text' => 'Yes','class' => 'radio-task virt ']
                                            ]
                                            ); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                <br/>
                <?= $this->Form->button($this->Html->tag('i', '') . __(' Submit'),['class'=>'btn btn-success']); ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
    
</div>