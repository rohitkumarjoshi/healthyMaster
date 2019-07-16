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
                    <span class="caption-subject font-purple-intense ">
                        <i class="fa fa-plus"></i> Vendor Item List
                    </span>
                </div>
                <div class="actions">
                    <?php echo $this->Html->link('<i class="fa fa-plus"></i> Add New','/VendorRows/Add',['escape'=>false,'class'=>'btn btn-default']) ?> 
                    
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-condensed table-hover table-bordered" id="main_tble">
                    <thead>
                        <tr>
                            <th>Sr</th>
                            <th>Vendor</th>
                            <th>Item Code</th>
                            <th>Item</th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($vendorRows as $row): 
                            @$i++;
                            ?>
                        <tr>
                            <td><?= h($i) ?></td>
                            
                            <td><?= $row->vendor->name?></td>
                            <td><?= h($row->item->item_code) ?></td>
                            
                            <td><?= h($row->item->name) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $row->id]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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