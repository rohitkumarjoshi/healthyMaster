<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
    vertical-align: top !important;
}
.error{
    color:#a94442;
}
#item-list{list-style:none;margin-left: 1px;padding:0;width:91%; margin-top: 10px;    position: absolute;
z-index: 1000;
background-color: #fff;}
#item-list li{padding: 7px; background: #d8d4d41a ; border: 1px solid #bbb9b933;}
#item-list li:hover{background:#d8d4d4;cursor: pointer;}
</style>
<div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" fa fa-gift"></i>
                    <span class="caption-subject">Used Promo Codes</span>
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
                            <td width="5%">
                                <label>Mobile</label>
                                <?php echo $this->Form->input('mobile', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Mobile','autocomplete'=>false]); ?>
                            </td>
                            <td width="5%">
                                <label>PromoCode</label>
                                <?php echo $this->Form->input('code', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Mobile','autocomplete'=>'off']); ?>
                            </td>
                            <td width="5%">
                                <label>Order</label>
                                <?php echo $this->Form->input('order_no', ['label' => false,'class' => 'form-control input-sm','placeholder'=>'Order No','autocomplete'=>'off']); ?>
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
                <div>
                     <table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
                            <th scope="col">Date</th>
                            <th scope="col">Order No.</th>
                            <th scope="col">Customer ID</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Code</th>
                            <th scope="col">Title</th>
                            <th scope="col">Order Value</th>
                            <th scope="col">Discount Value</th>
                            <th scope="col">Discount Percent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($used_promo as $used_promos):
                        ?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?= date('d-m-Y',strtotime($used_promos->order_date))?></td>
                            <td><?= $used_promos->order_no?></td>
                            <td><?= $used_promos->customer->id?></td>
                            <td><?= $used_promos->customer->name?></td>
                            <td><?= $used_promos->customer->mobile?></td>
                            <td><?= $used_promos->promo_code->code?></td>
                            <td><?= $used_promos->promo_code->title?></td>
                            <td><?= $used_promos->grand_total?></td>
                            <td><?php if($used_promos->promo_code->amount_type == "amount")
                            {

                                echo $used_promos->promo_code->discount_per." ".$used_promos->promo_code->amount_type;
                            }?></td>
                            <td>
                               <?php if($used_promos->promo_code->amount_type == "percent")
                            {

                                echo $used_promos->promo_code->discount_per." ".$used_promos->promo_code->amount_type;
                            }?> 
                            </td>
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
$(document).ready(function() {

     $(document).on('blur',".autocompleted",function(){ //alert("blur");
        $('.suggesstion-box').delay(1000).fadeOut(500);
    }); 

    $(document).on('keyup',".autocompleted",function(){// alert("keyup");
        var searchType = $(this).attr('valueType');
        var input=$(this).val();
        var master = $(this); 
        if(input.length>0){
            var m_data = new FormData();
            var url ="<?php echo $this->Url->build(["controller" => "Carts", "action" => "ajaxAutocompleted"]); ?>";
           //alert(url);
            m_data.append('input',input); 
            m_data.append('searchType',searchType); 
            $.ajax({
                url: url,
                data: m_data,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType:'text',
                success: function(data)
                { 
                    //alert(data);
                    master.closest('div').find('.suggesstion-box').show();
                    master.closest('div').find('.suggesstion-box').html(data);
                    master.css("background","#FFF");
                }
            });
        }
    });
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
});

</script>
<script>
function selectAutoCompleted(ids,value) { 
    
    $('.selectedAutoCompleted').val(value);
    $('#customer_id').val(ids);
    $(".suggesstion-box").hide();     
}
function selectAutoCompleted1(value) {  
    $('.selectedAutoCompleted1').val(value);
    $(".suggesstion-box").hide();     
}
</script>