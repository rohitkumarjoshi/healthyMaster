
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('PUSH NOTIFICATION REPORT') ?></span>
                </div>
                <div class="actions"> 
                   <?php echo $this->Html->link('Excel',['controller'=>'AppNotifications','action' => 'exportNotificationReport'],['target'=>'_blank']); ?>
                </div>
            </div>
            <div class="portlet-body">
              <table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
                            <th scope="col">Image</th>
                            <th scope="col">Type</th>
                            <th scope="col">Message</th>
                            <th scope="col">User</th>
                            <th scope="col">Create Date</th>
                            <th scope="col">No Of Person</th>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($notifications as $notification):
                                $created=$notification->app_notification->created_on;
                        ?>
                        <tr>
                            <td><?= $i; $i++;?></td>
                            <td> <?= @$this->Html->image($notification->app_notification->image, ['style'=>'width:50px; height:50px;']); ?></td>
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
                            <td><?= @$notification->app_notification->message?></td>
                            <td>Admin</td>
                            <td><?= date('d-m-Y',strtotime($created)) ?></td>
                            <td><?= @$notification->count?></td>

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
function fnExcelReport()
    {
        var tab_text='<table border=\'2px\'><tr bgcolor=\'#87AFC6\'>';
        var textRange; var j=0;
        tab = document.getElementById('sample_1'); // id of table

        for(j = 0 ; j < tab.rows.length ; j++) 
        {     
            tab_text=tab_text+tab.rows[j].innerHTML+'</tr>';
            //tab_text=tab_text+'</tr>';
        }

        tab_text=tab_text+'</table>';
        tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, '');//remove if u want links in your table
        tab_text= tab_text.replace(/<img[^>]*>/gi,''); // remove if u want images in your table
        tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ''); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf('MSIE '); 

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
        {
            txtArea1.document.open('txt/html','replace');
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus(); 
            sa=txtArea1.document.execCommand('SaveAs',true,'Say Thanks to Sumit.xls');
        }  
        else                 //other browser not tested on IE 11
            sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

        return (sa);
    }
</script>

