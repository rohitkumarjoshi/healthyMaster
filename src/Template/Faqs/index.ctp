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
                        <i class="fa fa-plus"></i> Temporary Orders
                    </span>
                    <?php
                    echo $this->Html->link('Print',array(),['escape'=>false,'class'=>'btn  blue hidden-print fa fa-print','onclick'=>'javascript:window.print();','style'=>'margin-left : 800px;']);
    
                    ?>
                </div>
               
            </div>
            <div class="portlet-body">
        <?php 
            foreach ($temps as $temp) {
               
                ?>

        <table width="100%" style="margin-top: 20px;">    
            
            <tbody>
                <tr style="background-color:#fff; color:#000;">
                    <td align="left" colspan="5">
                        <b>
                            Order No.: <?= $temp->order->order_no ?>
                        </b>
                    </td>
                </tr>
            </table>
            <table width="100%">
                <thead>
                <tr style="background-color:#F98630; color:#fff;">
                    <th style="text-align:right;">#</th>
                    <th style="text-align:left;">Item Name</th>
                    <th style="text-align:left;">Variation</th>
                    <th style="text-align:center;">QTY</th>
                </tr>
                </thead>
                
                <?php
                foreach($temp->order->order_details as $order_detail ){ 
                    @$i++;
                    $show_variation=$order_detail->item_variation->quantity_variation.' '.$order_detail->item_variation->unit->shortname;
                    $quantity=$order_detail->quantity;
                    $actual_quantity=$order_detail->actual_quantity;
                    $minimum_quantity_factor=$order_detail->item->minimum_quantity_factor;
                    $unit_name=$order_detail->item_variation->unit->unit_name;
                    $image=$order_detail->item->image;
                    $item_name=$order_detail->item->name;
                    $sales_rate=$order_detail->rate;
                    $alias_name=$order_detail->item->alias_name;
                    $show_quantity=$quantity;
                    if(!empty($actual_quantity)){
                    $show_actual_quantity=$actual_quantity;
                    }
                    else{
                    $show_actual_quantity='-';
                    }
                    $amount=$order_detail->amount;
                    @$total_rate+=$amount;
                    if(!empty($alias_name)){
                        $show_item=$item_name.' ('.$alias_name.')';
                    }else{
                        $show_item=$item_name;
                    } ?>
                <tr style="background-color:#fff;">
                    <td align="right"><?= $i ?></td>
                    <td style="text-align:left;"><?= h($show_item) ?></td>
                    <td style="text-align:left;"><?= h($show_variation) ?></td>
                    <td style="text-align:center;"><?= h($show_quantity) ?></td>
                </tr>
                <?php } ?>
            </tbody>
            
        </table>
    <?php } ?>
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