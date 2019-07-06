
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('Order Report') ?></span>
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
                            <td><?= $item_var->item->item_category->name?></td>
                            <td><?= $item_var->item->name?></td>
                            <td><?= $item_var->item->alias_name?></td>
                            <td><?= $item_var->item->description?></td>
                            <td><?= $item_var->item->gst_figure->name?></td>
                            <td><?= $item_var->quantity_variation?></td>
                            <td><?= $item_var->unit->shortname ?></td>
                            <td><?= $item_var->minimum_stock ?></td>
                            <td><?= $item_var->minimum_quantity_purchase ?></td>
                            <td><?= $item_var->print_rate ?></td>
                            <td><?= $item_var->sales_rate ?></td>
                            <td><?= $item_var->sales_rate ?></td>
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


