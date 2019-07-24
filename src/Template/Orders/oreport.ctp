
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('ORDER/SALES REPORT') ?></span>
                </div>
                <div class="actions"> 
                    <div><a href="javascript:void(0)" id="export-to-excel">Export to excel</a></div>
                        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" id="export-form">
                        <input type="hidden" value='' id='hidden-type' name='ExportType'/>
                      </form>
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto;!important">
                <form method="post">
                        <table width="50%" class="table table-condensed">
                    <tbody>
                        <tr>
                            <td width="5%">
                                <label>Mobile</label>
                                <?php echo $this->Form->input('mobile', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Mobile']); ?>
                            </td>
                            <td width="5%">
                                <label>Item</label>
                                <?php echo $this->Form->input('item_id', ['empty'=>'--Items--','options' => $items,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category']); ?>
                            </td>
                            <td width="5%">
                                <label class=" control-label">Apartment <span class="required" aria-required="true">*</span></label>
                                <?php echo $this->Form->input('apartment', ['empty'=>'--Apartment--','label' => false,'class' => 'form-control input-sm']); ?>
                            </td>
                            <td width="5%">
                                <label>From</label>
                                <input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From"  data-date-format="dd-mm-yyyy">
                            </td>   
                            <td width="5%">
                                <label>To</label>
                                <input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To"   data-date-format="dd-mm-yyyy" >
                            </td>
                            <td width="10%">
                                <button type="submit" class="btn btn-success btn-sm" style="margin-top: 23px !important;"><i class="fa fa-filter"></i> Filter</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Order No</th>
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Customer ID</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Flat No</th>
                            <th scope="col">Apartment</th>
                            <th scope="col">Locality</th>
                            <th scope="col">City</th>
                            <th scope="col">State</th>
                            <th scope="col">Walkin Sale</th>
                            <th scope="col">Online Sale App</th>
                            <th scope="col">Online Sale Web</th>
                            <th scope="col">Payment Mode</th>
                            <th scope="col">Variation</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Gross Amount</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Net Sales</th>
                            <th scope="col">Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($orders as $order_detail):
                        ?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?= date('d-m-Y',strtotime($order_detail->order->order_date))?></td>
                            <td><?= $order_detail->order->order_no?></td>
                            <td><?= $order_detail->item->item_code?></td>
                            <td><?= $order_detail->item->name?></td>
                            <td><?= $order_detail->item->item_category->name?></td>
                            <td><?= $order_detail->order->customer->id?></td>
                            <td><?= $order_detail->order->customer->name?></td>
                            <td><?= $order_detail->order->customer->mobile?></td>
                            <td><?= $order_detail->order->customer_address->house_no?></td>
                            <td><?= $order_detail->order->customer_address->apartment?></td>
                            <td><?= $order_detail->order->customer_address->locality?></td>
                            <td><?= @$order_detail->order->customer_address->city->name?></td>
                            <td><?= @$order_detail->order->customer_address->state->state_name?></td>
                            <td><?php if($order_detail->order->order_from == "walkinsales")
                            {
                                echo"Yes";
                            }?></td>
                            <td><?php if($order_detail->order->order_from == "Android APP")
                            {
                                echo"Yes";
                            }?></td>
                            <td><?php if($order_detail->order->order_from == "Ecommerce")
                            {
                                echo"Yes";
                            }?></td>
                            <td><?= $order_detail->order->order_type ?></td>
                            <td><?= $order_detail->item_variation->quantity_variation.' '.$order_detail->item_variation->unit->shortname?></td>
                            <td><?= $order_detail->rate?></td>
                            <td><?= $order_detail->quantity?></td>
                            <td><?= $order_detail->amount?></td>
                            <td><?= $order_detail->order->amount_from_promo_code ?></td>
                            <td><?= $order_detail->amount - $order_detail->order->amount_from_promo_code?></td>
                            <td><?= $order_detail->order->status?></td>
                        </tr>
                        <?php endforeach;  ?>
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
<script  type="text/javascript">
$(document).ready(function() {
jQuery('#Export to excel').bind("click", function() {
var target = $(this).attr('id');
switch(target) {
    case 'export-to-excel' :
    $('#hidden-type').val(target);
    //alert($('#hidden-type').val());
    $('#export-form').submit();
    $('#hidden-type').val('');
    break
}
});
    });
</script>

