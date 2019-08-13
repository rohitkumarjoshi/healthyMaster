
<div class="col-md-12">
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<i class=" fa fa-gift"></i>
				<span class="caption-subject">Promo Codes</span>
			</div>
			<div class="actions">
				<?php echo $this->Html->link('Excel',['controller'=>'PromoCodes','action' => 'exportPromoReport'],['target'=>'_blank']); ?>
			</div>
		</div>
		<div class="portlet-body">
			<form method="post">
					<table width="50%" class="table table-condensed">
				<tbody>
					<tr>
						<td width="5%">
							<label>Code Name</label>
							<input type="text" name="code" value="<?= @$code;?>" class="form-control input-sm" autocomplete="off">
						</td>
						<td width="5%">
							<label>Item</label>
							<?php echo $this->Form->input('item_id', ['empty'=>'--Items--','options' => $items,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Select Item','value'=>@$item_id]); ?>
						</td>
						<td width="5%">
							<label>Status</label>
							<select name="status" class="form-control input-sm select2me">
								<option value="">-Select-</option>
								<option value="Active">Active</option>
								<option value="Deactive">Deactive</option>
							</select>
						</td>
						<td width="5%">
							<label>From</label>
							<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From" value="<?php if(!empty(@$from_date)) { echo date('d-m-Y',strtotime(@$from_date)); } ?>"  data-date-format="dd-mm-yyyy" autocomplete="off">	
						</td>	
						<td width="5%">
							<label>To</label>
							<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To" value="<?php if(!empty(@$to_date)) { echo date('d-m-Y',strtotime(@$to_date)); } ?>" data-date-format="dd-mm-yyyy" autocomplete="off">
						</td>
						<td width="10%">
							<button type="submit" class="btn btn-success btn-sm" style="margin-top: 23px !important;"><i class="fa fa-filter"></i> Filter</button>
						</td>
					</tr>
				</tbody>
			</table>
			</form>
			<div style="overflow: auto;!important">
				<table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_1">
				<thead>
					<tr>
						<th>Sr</th>
						<th>Promo Code</th>
						<th>Title</th>
						<th>Description</th>
						<th>Code Type</th>
						<th>Discount Value</th>
						<th>Discount Percent</th>
						<th>Item Code</th>
						<th>Item Name</th>
						<th>Item Category</th>
						<th>Cart Value</th>
						<th>Free Shipping</th>
						<th>Valid From</th>
						<th>Valid To</th>
						<th>Create</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=0;
					foreach (@$promoCodes as $promoCode):
					$i++;

					?>
					<tr>
						<td><?= $i ?></td>
						<td><?= h(@$promoCode->code) ?></td>
						<td><?= h(@$promoCode->title) ?></td>
						<td><?= h(@$promoCode->description) ?></td>
						<td><?= h(@$promoCode->promo_code_type) ?></td>
						<td><?php 
							$type=$promoCode->amount_type;
							if($type == "amount")
							{
								echo "Rs.";
								echo h(@$promoCode->discount_per);
							}
							
						?></td>
						<td><?php 
							$type=$promoCode->amount_type;
							if($type == "percent")
							{
								echo h(@$promoCode->discount_per);
								echo "%";
							}
							
						?></td>
						<td><?= h(@$promoCode->item->item_code) ?></td>
						<td><?= h(@$promoCode->item->name) ?></td>
						<td><?= h(@$promoCode->item_category->name) ?></td>
						<td><?= h(@$promoCode->cart_value) ?></td>
						<td><?php $freeship=@$promoCode->is_freeship;
							if($freeship == "1") 
							{
								echo"Yes";
							}
							if($freeship == "0") 
							{
								echo"No";
							}

						?>
						<td><?= h(@$promoCode->valid_from) ?>
						<td><?= h(@$promoCode->valid_to) ?>
						<span id="status_id" style="display:none;"><?php echo $promoCode->id; ?></span>
						</td>
						<td><?= h(@date('d-m-Y',strtotime($promoCode->created_on) ))?>
						<td><?= h(@$promoCode->status) ?>
					</tr>
					<?php endforeach; ?>
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
