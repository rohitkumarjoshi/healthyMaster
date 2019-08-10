
<div class="row">
    <div class="col-md-12">
        <div class="portlet box grey-cascade">
            <div class="portlet-title">
                <div class="caption">
                    <i class="font-purple-intense"></i>
                    <span class="caption-subject font-purple-intense ">PINCODE
                    </span>
                </div>
                <div class="actions">
                    <?php echo $this->Html->link('Add new','/Pincodes/Add',['escape'=>false,'class'=>'btn btn-default']) ?>&nbsp;
                   
                </div>
            </div>
            <div class="portlet-body">
                <form method="GET" >
                    <table width="50%" class="table table-condensed">
                        <tbody>
                            <tr>
                                <td width="4%">
                                    <?php echo $this->Form->input('pincode', ['label' => false,'class' => 'form-control input-sm pincode','placeholder'=>'Pincode','type'=>'text','value'=>@$pincode]); ?>
                                </td>
                                <td width="10%">
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-filter"></i> Filter</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <?php if(!empty($pincodes))
                {?>
                <?= $this->Form->create($pin,['id'=>'form_sample_3']) ?>
                <table class="table table-condensed table-hover table-bordered" id="main_tble">
                    <thead>
                        <tr>
                            <th>Sr</th>
                            <th>State</th>
                            <th>City</th>
                            <th>PinCode</th>
                            <th>100Gm</th>
                            <th>500Gm</th>
                            <th>1Kg</th>
                            <th>Order Value</th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0;
                        foreach ($pincodes as $pincode): 
                        $i++;
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= @$pincode->state->state_name ?></td>
                            <td><?= @$pincode->city->name ?></td>
                            <td><?= @$pincode->pincode ?></td>
                            <td><?php
                                if($pincode->we_deliver == "Yes")
                                {
                                    echo @$pincode->delivery_charge->hundred_gm;
                                }
                                else{ echo"-";}
                                ?>
                            </td>
                            <td><?php
                                if($pincode->we_deliver == "Yes")
                                {
                                    echo @$pincode->delivery_charge->five_hundred_gm;
                                }
                                else{ echo"-";}
                                ?>
                            </td>
                            <td><?php
                                if($pincode->we_deliver == "Yes")
                                {
                                    echo @$pincode->delivery_charge->one_kg;
                                }
                                else{ echo"-";}
                                ?>
                            </td>
                            <td><?php
                                if($pincode->we_deliver == "Yes")
                                {
                                    echo @$pincode->delivery_charge->min_order_value;
                                }
                                else{ echo"-";}
                                ?>
                            </td>
                            <td class="actions">
                               <!--  <?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $pincode->id],['class'=>'btn btn-primary  btn-condensed btn-xs','escape'=>false]) ?> -->
                                <!-- <?php if($pincode->is_deleted == 0){ ?>
                                <?= $this->Form->postLink(__('Deactive'), ['action' => 'delete', $pincode->id], ['confirm' => __('Are you sure you want to Deactive # {0}?', $pincode->id),'class'=>'btn btn-xs green']) ?>
                                <?php } ?>
                                <?php if($pincode->is_deleted == 1){ ?>
                                <?= $this->Form->postLink(__('Active'), ['action' => 'delete1', $pincode->id], ['confirm' => __('Are you sure you want to Active # {0}?', $pincode->id),'class'=>'btn btn-xs green']) ?>
                                <?php } ?> -->
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?= $this->Form->end() ?>
            <?php } ?>
                <!-- <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->first('<< ' . __('first')) ?>
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                        <?= $this->Paginator->last(__('last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
                </div> -->
            </div>
        </div>
    </div>
</div>