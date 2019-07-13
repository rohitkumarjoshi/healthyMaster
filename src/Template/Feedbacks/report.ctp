
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('FEEDBACK REPORT') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
                            <th scope="col">Customer ID</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Message</th>
                            <th scope="col">Posting Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($feedbacks as $feedback):
                        ?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?= $feedback->customer->id?></td>
                            <td><?= $feedback->customer->name?></td>
                            <td><?= $feedback->customer->mobile?></td>
                            <td><?= $feedback->comments?></td>
                            <td><?= date('d-m-Y',strtotime($feedback->created_on))?></td>
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


