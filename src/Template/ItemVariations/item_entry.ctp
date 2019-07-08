
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
                            <th scope="col">Category</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Alias Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Gst</th>
                            <th scope="col">Variation</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Minimum Stock</th>
                            <th scope="col">Maximum Order Limit</th>
                            <th scope="col">Print Rate</th>
                            <th scope="col">Sales Rate</th>
                            <th scope="col">Returnable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($item_var as $var):
                        ?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?= $var->item->item_category->name?></td>
                            <td><?= $var->item->name?></td>
                            <td><?= $var->item->alias_name?></td>
                            <td><?= $var->item->description?></td>
                            <td><?= $var->item->gst_figure->name?></td>
                            <td><?= $var->quantity_variation?></td>
                            <td><?= $var->unit->shortname ?></td>
                            <td><?= $var->minimum_stock ?></td>
                            <td><?= $var->minimum_quantity_purchase ?></td>
                            <td><?= $var->print_rate ?></td>
                            <td><?= $var->sales_rate ?></td>
                            <td><?= $var->sales_rate ?></td>
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


