
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('PUSH NOTIFICATION REPORT') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
                            <th scope="col">Image</th>
                            <th scope="col">Type</th>
                            <th scope="col">Message</th>
                            <th scope="col">User</th>
                            <th scope="col">No Of Person</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($notifications as $notification):
                        ?>
                        <tr>
                            <td><?= $i; $i++;?></td>
                            <td> <?= $this->Html->image($notification->app_notification->image, ['style'=>'width:50px; height:50px;']); ?></td>
                            <td><?php
                                if($notification->app_notification->item_id == null)
                                {
                                    echo "Info Message";
                                }
                                else
                                {
                                    echo"Product Description";
                                }
                            ?></td>
                            <td><?= $notification->app_notification->message?></td>
                            <td></td>
                            <td><?= $notification->count?></td>
                            <td><?= $notification->sent?></td>

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


