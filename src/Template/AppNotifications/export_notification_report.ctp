<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Notification Report".$date.'_'.$time;

	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" );
//pr($OrderAcceptances->toArray()); exit;
?>


<table border="1">
       <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
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
			