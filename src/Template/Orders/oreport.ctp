
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('ORDER REPORT') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
                            <th scope="col">Order No</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Value</th>
                            <th scope="col">Payment Mode</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($orders as $order_detail):
                        ?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?= $order_detail->order->order_no?></td>
                            <td><?= date('d-m-Y',strtotime($order_detail->order->order_date))?></td>
                            <td><?= $order_detail->item->name?></td>
                            <td><?= $order_detail->amount?></td>
                            <td><?= $order_detail->order->payment_status?></td>
                            <td><?= $order_detail->order->status?></td>
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


