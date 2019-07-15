
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('PURCHASE REPORT') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
                            <th scope="col">Transaction</th>
                            <th scope="col">Vendor ID</th>
                            <th scope="col">Vendor</th>
                            <th scope="col">Contact No.</th>
                            <th scope="col">HSN Code</th>
                            <th scope="col">Gst No.</th>
                            <th scope="col">City</th>
                            <th scope="col">Category ID</th>
                            <th scope="col">Category</th>
                            <th scope="col">Item</th>
                            <th scope="col">Variation</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Purchase Value</th>
                            <th scope="col">GST Rate</th>
                            <th scope="col">GST Amount</th>
                            <th scope="col">Total Amount with GST</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($purchases as $purchase):
                            $sale_rate=$purchase->rate;
                            $gst_per=$purchase->item->gst_figure->name;
                            $tx=100+$gst_per;
                            $tax=round(($sale_rate * $gst_per)/$tx);
                        ?>
                        <tr>
                            <td><?= $i; $i++;?></td>
                            <td> <?= date('d-m-Y',strtotime($purchase->purchase_booking->created_on)) ?></td>
                            <td><?= $purchase->purchase_booking->vendor->id ?></td>
                            <td><?= $purchase->purchase_booking->vendor->name ?></td>
                            <td><?= $purchase->purchase_booking->vendor->mobile ?></td>
                            <td><?= $purchase->item->item_code?></td>
                            <td><?= $purchase->purchase_booking->vendor->gst_no ?></td>
                            <td><?= $purchase->purchase_booking->vendor->city->name ?></td>
                            <td><?= $purchase->item->item_category->id?></td>
                            <td><?= $purchase->item->item_category->name?></td>
                            <td><?= $purchase->item->name?></td>
                            <td><?= $purchase->item_variation->quantity_variation.' '.$purchase->item_variation->unit->short_name?></td>
                            <td><?= $purchase->quantity ?></td>
                            <td><?= $sale_rate ?></td>
                            <td><?= $sale_rate - $tax ?></td>
                            <td><?= $gst_per?></td>
                            <td><?= $tax ?></td>
                            <td><?= $purchase->rate?></td>

                        </tr>
                        <?php endforeach;  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->element('selectpicker') ?>
<?= $this->element('validate') ?>
<?= $this->element('datepicker') ?>


