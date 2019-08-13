<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Feedback Report".$date.'_'.$time;

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
			