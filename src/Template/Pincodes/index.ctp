<style>
.table>thead>tr>th{
    font-size:12px !important;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
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
                <table class="table table-condensed table-hover table-bordered" id="main_tble">
                    <thead>
                        <tr>
                            <th>Sr</th>
                            <th>State</th>
                            <th>City</th>
                            <th>PinCode</th>
                            <th>Amount</th>
                            <th>Charge</th>
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
                            <td><?= h($pincode->state->state_name) ?></td>
                            <td><?= h($pincode->city->name) ?></td>
                            <td><?= h($pincode->pincode) ?></td>
                            <td><?php
                                if($pincode->we_deliver == "Yes")
                                {
                                    echo $pincode->delivery_charge->amount;
                                }
                                else{ echo"-";}
                                ?>
                            </td>
                            <td><?php
                                if($pincode->we_deliver == "Yes")
                                {
                                    echo $pincode->delivery_charge->charge;
                                }
                                else{ echo"-";}
                                ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $pincode->id],['class'=>'btn btn-primary  btn-condensed btn-xs','escape'=>false]) ?>
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
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->first('<< ' . __('first')) ?>
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                        <?= $this->Paginator->last(__('last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
var $rows = $('#main_tble tbody tr');
    $('#search3').on('keyup',function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
        var v = $(this).val();
        if(v){ 
            $rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
    
                return !~text.indexOf(val);
            }).hide();
        }else{
            $rows.show();
        }
    });
</script>