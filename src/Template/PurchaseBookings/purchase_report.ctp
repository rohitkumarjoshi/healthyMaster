
<div class="row">
    <div class="col-md-12" style="width: 100%;">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('PURCHASE REPORT') ?></span>
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto;!important">
                <form method="post">
                        <table width="50%" class="table table-condensed">
                    <tbody>
                        <tr>
                            
                            <td width="5%">
                                <label>Vendor</label>
                                <?php echo $this->Form->input('vendor_id', ['empty'=>'--Vendor--','options' => $vendors,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category']); ?>
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
                            <th scope="col">Transaction Date</th>
                            <th scope="col">Vendor ID</th>
                            <th scope="col">Vendor Name</th>
                            <th scope="col">Contact No.</th>
                            <th scope="col">HSN Code</th>
                            <th scope="col">Gst No.</th>
                            <th scope="col">City</th>
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Variation</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Purchase Value</th>
                            <th scope="col">GST Rate</th>
                            <th scope="col">GST Amount</th>
                            <th scope="col">Total Amount with GST</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($purchases as $purchase):
                            $amount=$purchase->quantity * $purchase->rate ;
                            $gst_per=$purchase->item->gst_figure->name;
                            $tx=100+$gst_per;
                            $tax=round(($amount * $gst_per)/$tx);
                        ?>
                        <tr>
                            <td><?= $i; $i++;?></td>
                            <td> <?= date('d-m-Y',strtotime($purchase->purchase_booking->created_on)) ?></td>
                            <td><?= $purchase->purchase_booking->vendor->id ?></td>
                            <td><?= $purchase->purchase_booking->vendor->name ?></td>
                            <td><?= $purchase->purchase_booking->vendor->mobile ?></td>
                            <td><?= $purchase->item->hsn_code?></td>
                            <td><?= $purchase->purchase_booking->vendor->gst_no ?></td>
                            <td><?= $purchase->purchase_booking->vendor->city->name ?></td>
                            <td><?= $purchase->item->item_code?></td>
                            <td><?= $purchase->item->name?></td>
                            <td><?= $purchase->item->item_category->name?></td>
                            <td><?= $purchase->item_variation->quantity_variation.' '.$purchase->item_variation->unit->shortname?></td>
                            <td><?= $purchase->quantity ?></td>
                            <td><?= $purchase->rate ?></td>
                            <td><?= $purchase->quantity * $purchase->rate ?></td>
                            <td><?= $amount - $tax ?></td>
                            <td><?= $gst_per?></td>
                            <td><?= $tax ?></td>
                            <td><?= $purchase->quantity * $purchase->rate?></td>

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

