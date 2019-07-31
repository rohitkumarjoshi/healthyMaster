
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('FEEDBACK REPORT') ?></span>
                </div>
                <div class="actions">
                    <button class="btn btn-sm yellow" id="btnExport" onclick="fnExcelReport();"> Export </button>&nbsp;
                </div>
            </div>
            <div class="portlet-body">
                <form method="post">
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


