
<div class="row">
    <div class="col-md-12" style="width: 100%;">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('PURCHASE REPORT') ?></span>
                </div>
                <div class="actions">
                    <button class="btn btn-sm yellow" id="btnExport" onclick="fnExcelReport();"> Export </button>&nbsp;
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto;!important">
                <form method="post">
                        <table width="50%" class="table table-condensed">
                    <tbody>
                        <tr>
                            
                            <td width="5%">
                                <label>Vendor</label>
                                <?php echo $this->Form->input('vendor_id', ['empty'=>'--Vendor--','options' => $vendors,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category']); ?>
                            </td>
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
                            <th scope="col">Transaction Date</th>
                            <th scope="col">Vendor ID</th>
                            <th scope="col">Vendor Name</th>
                            <th scope="col">Contact No.</th>
                            <th scope="col">HSN Code</th>
                            <th scope="col">Gst No.</th>
                            <th scope="col">City</th>
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Variation</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Purchase Value</th>
                            <th scope="col">GST Rate</th>
                            <th scope="col">GST Amount</th>
                            <th scope="col">Total Amount with GST</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($purchases as $purchase):
                            $amount=$purchase->quantity * $purchase->rate ;
                            $gst_per=$purchase->item->gst_figure->name;
                            $tx=100+$gst_per;
                            $tax=round(($amount * $gst_per)/$tx);
                        ?>
                        <tr>
                            <td><?= $i; $i++;?></td>
                            <td> <?= date('d-m-Y',strtotime($purchase->purchase_booking->created_on)) ?></td>
                            <td><?= $purchase->purchase_booking->vendor->id ?></td>
                            <td><?= $purchase->purchase_booking->vendor->name ?></td>
                            <td><?= $purchase->purchase_booking->vendor->mobile ?></td>
                            <td><?= $purchase->item->hsn_code?></td>
                            <td><?= $purchase->purchase_booking->vendor->gst_no ?></td>
                            <td><?= $purchase->purchase_booking->vendor->city->name ?></td>
                            <td><?= $purchase->item->item_code?></td>
                            <td><?= $purchase->item->name?></td>
                            <td><?= $purchase->item->item_category->name?></td>
                            <td><?= $purchase->unit_variation->name?></td>
                            <td><?= $purchase->quantity ?></td>
                            <td><?= $purchase->rate ?></td>
                            <td><?= $purchase->quantity * $purchase->rate ?></td>
                            <td><?= $amount - $tax ?></td>
                            <td><?= $gst_per?></td>
                            <td><?= $tax ?></td>
                            <td><?= $purchase->quantity * $purchase->rate?></td>

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

