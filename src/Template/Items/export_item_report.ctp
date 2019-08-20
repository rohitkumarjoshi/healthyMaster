<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Items Report".$date.'_'.$time;

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
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">GST Rate</th>
                            <th scope="col">Variation1</th>
                            <th scope="col">Rate Variation1</th>
                            <th scope="col">Variation2</th>
                            <th scope="col">Rate Variation2</th>
                            <th scope="col">Variation3</th>
                            <th scope="col">Rate Variation3</th>
                            <th scope="col">Variation4</th>
                            <th scope="col">Rate Variation4</th>
                            <th scope="col">Variation5</th>
                            <th scope="col">Rate Variation5</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                        foreach ($variations as $variation) {
                        ?>
                        <tr>
                            <td><?= $i; $i++;?></td>
                            <td><?= @$variation->item_code?></td>
                            <td><?= @$variation->name?></td>
                            <td><?= @$variation->item_category->name?></td>
                            <td><?= @$variation->gst_figure->name?></td>
                            <?php $a=0;
                            foreach ($variation->item_variations as $var) { 
                                
                                   $a++;
                                    
                                    if(sizeof($variation->item_variations) == 1)
                                    {
                                        echo "<td>".$var->quantity_variation."</td>";
                                        echo "<td>".$var->sales_rate."</td>";
                                        echo "<td>-</td>";
                                        echo "<td>-</td>";
                                        echo "<td>-</td>";
                                        echo "<td>-</td>";
                                        echo "<td>-</td>";
                                        echo "<td>-</td>";
                                        echo "<td>-</td>";
                                        echo "<td>-</td>";
                                    }
                                    if(sizeof($variation->item_variations) == 2)
                                    {
                                        if($a == 1)
                                        {
                                            echo "<td>".$var->quantity_variation."</td>";
                                            echo "<td>".$var->sales_rate."</td>";
                                        }
                                       if($a == 2)
                                        {
                                            echo "<td>".$var->quantity_variation."</td>";
                                            echo "<td>".$var->sales_rate."</td>";
                                            echo "<td>-</td>";
                                            echo "<td>-</td>";
                                            echo "<td>-</td>";
                                            echo "<td>-</td>";
                                            echo "<td>-</td>";
                                            echo "<td>-</td>";
                                        }
                                    }

                                    if(sizeof($variation->item_variations) == 3)
                                    {
                                        
                                        if($a == 1)
                                        {
                                            echo "<td>".$var->quantity_variation."</td>";
                                            echo "<td>".$var->sales_rate."</td>";
                                        }
                                       if($a == 2)
                                        {
                                            echo "<td>".$var->quantity_variation."</td>";
                                            echo "<td>".$var->sales_rate."</td>";
                                        }
                                        if($a == 3)
                                        {
                                            echo "<td>".$var->quantity_variation."</td>";
                                            echo "<td>".$var->sales_rate."</td>";
                                            echo "<td>-</td>";
                                            echo "<td>-</td>";
                                            echo "<td>-</td>";
                                            echo "<td>-</td>";
                                        }
                                       
                                    }
                                    if(sizeof($variation->item_variations) == 4)
                                    {
                                        
                                        if($a == 1)
                                        {
                                            echo "<td>".$var->quantity_variation."</td>";
                                            echo "<td>".$var->sales_rate."</td>";
                                        }
                                       if($a == 2)
                                        {
                                            echo "<td>".$var->quantity_variation."</td>";
                                            echo "<td>".$var->sales_rate."</td>";
                                        }
                                        if($a == 3)
                                        {
                                            echo "<td>".$var->quantity_variation."</td>";
                                            echo "<td>".$var->sales_rate."</td>";
                                        }
                                         if($a == 4)
                                        {
                                            echo "<td>".$var->quantity_variation."</td>";
                                            echo "<td>".$var->sales_rate."</td>";
                                            echo "<td>-</td>";
                                            echo "<td>-</td>";
                                        }
                                       
                                    }
                                    if(sizeof($variation->item_variations) == 5)
                                    {
                                        echo "<td>".$var->quantity_variation."</td>";
                                        echo "<td>".$var->sales_rate."</td>";
                                    }
                               } ?>
                        </tr>
                    <?php } ?>
                    </tbody>
      </table>
			