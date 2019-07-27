
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('FEEDBACK REPORT') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <!--<form method="post">
                        <table width="50%" class="table table-condensed">
                    <tbody>
                        <tr>
                            <tr>
                            <td width="5%">
                            <label>Mobile</label>
                            <?php echo $this->Form->input('mobile', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Mobile']); ?>
                        </td>
                            <td width="5%">
                                <label>From</label>
                                <input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From"  data-date-format="dd-mm-yyyy" autocomplete="false">
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
                </form>-->
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
                           <!-- <th scope="col">Customer ID</th>-->
                            <th scope="col">Customer Name</th>
                            <th scope="col">Email ID</th>
                            <th scope="col">Mobile</th>
                          
                            <th scope="col">Quality</th>
                            <th scope="col">Deliver</th>
                            <th scope="col">Over All</th>
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
                       
                            <td><?= $feedback->name?></td>
                            <td><?= $feedback->email?></td>
                            <td><?= $feedback->mobile?></td>
                            <td><?= $feedback->quality_exp?></td>
                            <td><?= $feedback->deliver_exp?></td>
                            <td><?= $feedback->overall_exp?></td>
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


