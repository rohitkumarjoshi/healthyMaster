
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('ORDER REPORT') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <form method="post">
                        <table width="50%" class="table table-condensed">
                    <tbody>
                        <tr>
                            <td width="5%">
                                <label class=" control-label">Apartment <span class="required" aria-required="true">*</span></label>
                                <?php echo $this->Form->input('apartment', ['empty'=>'--Apartment--','label' => false,'class' => 'form-control input-sm select2me']); ?>
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
                            <th scope="col">Order No</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Address</th>
                            <th scope="col">Apartment</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Value</th>
                            <th scope="col">Payment Mode</th>
                            <th scope="col">Order From</th>
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
                            <td><?= $order_detail->order->customer->name?></td>
                            <td><?= $order_detail->order->customer->mobile?></td>
                            <td></td>
                            <td></td>
                            <td><?= $order_detail->item->name?></td>
                            <td><?= $order_detail->amount?></td>
                            <td><?= $order_detail->order->payment_status?></td>
                            <td><?= $order_detail->order->order_from?></td>
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


