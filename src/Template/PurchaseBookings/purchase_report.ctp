
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
                            <th scope="col">Category ID</th>
                            <th scope="col">Category</th>
                            <th scope="col">Item ID</th>
                            <th scope="col">Item Code</th>
                            <th scope="col">Item</th>
                            <th scope="col">Variation</th>
                            <th scope="col">Value</th>
                            <th scope="col">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($purchases as $purchase):
                        ?>
                        <tr>
                            <td><?= $i; $i++;?></td>
                            <td> <?= date('d-m-Y',strtotime($purchase->purchase_booking->created_on)) ?></td>
                            <td><?= $purchase->purchase_booking->vendor->id ?></td>
                            <td><?= $purchase->purchase_booking->vendor->name ?></td>
                            <td><?= $purchase->item->item_category->id?></td>
                            <td><?= $purchase->item->item_category->name?></td>
                            <td><?= $purchase->item->id?></td>
                            <td><?= $purchase->item->item_code?></td>
                            <td><?= $purchase->item->name?></td>
                            <td><?= $purchase->item_variation->quantity_variation.' '.$purchase->item_variation->unit->short_name?></td>
                            <td><?= $purchase->rate?></td>
                            <td><?= $purchase->amount?></td>

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


