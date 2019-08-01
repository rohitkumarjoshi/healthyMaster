
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
                <table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_1">
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
                                <?php if($pincode->is_deleted == 0){ ?>
                                <?= $this->Form->postLink(__('Deactive'), ['action' => 'delete', $pincode->id], ['confirm' => __('Are you sure you want to Deactive # {0}?', $pincode->id),'class'=>'btn btn-xs green']) ?>
                                <?php } ?>
                                <?php if($pincode->is_deleted == 1){ ?>
                                <?= $this->Form->postLink(__('Active'), ['action' => 'delete1', $pincode->id], ['confirm' => __('Are you sure you want to Active # {0}?', $pincode->id),'class'=>'btn btn-xs green']) ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>