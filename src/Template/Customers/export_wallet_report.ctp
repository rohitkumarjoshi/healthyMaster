<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Wallet Report".$date.'_'.$time;

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
              <th>Sr</th>
              <th>Name</th>
              <th>Wallet Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $k=0;
            foreach ($wallet as $data):
              $k++;
            ?>
            <tr>
              <td><?= $k ?></td>
              <td>
                <?php 
                  $customer_id=$data->customer_id;
                  echo $this->Html->link($data->customer->name,['controller'=>'Customers','action' => 'customerWallet', $customer_id],['target'=>'_blank']); ?>
              </td>
              <td><?= h($data->total_add - $data->total_deduct) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
      </table>
			