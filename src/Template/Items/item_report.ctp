
<div class="row">
    <div class="col-md-12" style="width: 100%;">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('ITEM REPORT') ?></span>
                </div>
                <div class="actions">
                    <div class="actions">
                     <?php echo $this->Html->link('Excel',['controller'=>'Items','action' => 'exportItemReport'],['target'=>'_blank']); ?>
                </div>
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto;!important">
                <form method="post">
                        <table width="50%" class="table table-condensed">
                    <tbody>
                        <tr>
                            
                            <td width="5%">
                                <label>Item</label>
                                <?php echo $this->Form->input('item_id', ['empty'=>'--Items--','options' => $items,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category']); ?>
                            </td>
                            <td width="5%">
                                <label>From</label>
                                <input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From"  data-date-format="dd-mm-yyyy" autocomplete="off">
                            </td>   
                            <td width="5%">
                                <label>To</label>
                                <input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To"   data-date-format="dd-mm-yyyy" autocomplete="off">
                            </td>
                            <td width="10%">
                                <button type="submit" class="btn btn-success btn-sm" style="margin-top: 23px !important;"><i class="fa fa-filter"></i> Filter</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </form>
                <table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_1">
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

