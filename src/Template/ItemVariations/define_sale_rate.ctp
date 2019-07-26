<style>
.table>thead>tr>th{
	font-size:13px !important;
}
</style>
<div class="row">
	<div class="col-md-12">
	
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">SALES RATE UPDATE
					</span>
				</div>
			</div>
			<div class="portlet-body">
				<form method="GET" >
					<table width="50%" class="table table-condensed">
						<tbody>
							<tr>
								<td width="4%">
									<?php echo $this->Form->input('item_category_id', ['empty'=>'--Category--','options' =>$itemCategories,'label' => false,'class' => 'form-control input-sm select2me category','placeholder'=>'Category' ]); ?>
								</td>
								<td width="4%">
									
									<?php echo $this->Form->input('item', ['empty'=>'--Items--','options' => $items,'label' => false,'class' => 'form-control select2me input-sm category','placeholder'=>'Category' ]); ?>
								</td>
								<td width="10%">
									<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-filter"></i> Filter</button>
								</td>
							</tr>
						</tbody>
					</table>
				</form>
				<?php $i=0; 
				if(!empty($item_variations))
				{?>
				<?= $this->Form->create($itemvariation,['id'=>'form_sample_3']) ?>
				
			
				<table class="table table-condensed table-hover table-bordered" id="main_tble">
					<thead>
						<tr>
							<th width="5%">Sr</th>
							<th width="10%">Category</th>
							<th width="10%">Item Code</th>
							<th width="15%">Item</th>
							<th width="10%">Variation</th>
							<th width="10%">Print Rate</th>
							<th width="12%">Online Sale Rate</th>
							<th width="15%">Item Discount %</th>
							<th width="15%">
								Ready to Sale
								<!-- <?php echo  $this->Form->control('rts',['class'=>'form-control input-sm all','options'=>['empty'=>'--All--', 'Yes'=>'Yes','No'=>'No'], 'label'=>false]); ?>
 -->							</th>
							
						</tr>
					</thead>
						<?php
				foreach ($item_variations as $item_variation): ?>	
					<tbody id="main_tbody">
						<tr class="main_tr">
							<td><?php echo ++$i; $i--; ?>
							<?php echo  $this->Form->control('itemVariations['.$i.'][id]',['class'=>'form-control input-sm','value'=>$item_variation->id,'type'=>'hidden']); ?></td>
							
							</td>
							<td><?= h(@$item_variation->item->item_category->name) ?></td>
							<td>
								<?= h(@$item_variation->item->item_code) ?></td>
							<td><?php
								$item_name=$item_variation->item->name;
								$alias_name=$item_variation->item->alias_name;
								?>
								<?= h(@$item_name) ?></td>
                            
							<td style="font-size:10px;">
								 <b style="font-size:12px;"><?= $item_variation->quantity_variation." ".h($item_variation->unit->shortname) ?></b>
							</td>
							<td>
								<?php echo  $this->Form->control('itemVariations['.$i.'][print_rate]',['class'=>'form-control input-sm  print_rate','placeholder'=>'Print Rate', 'value'=>$item_variation->print_rate,'label'=>false]); ?></td>
							<td>
								<?php echo  $this->Form->control('itemVariations['.$i.'][sales_rate]',['class'=>'form-control input-sm  sales_rate','placeholder'=>'Print Rate', 'value'=>$item_variation->sales_rate,'label'=>false]); ?></td>

							<td>
								<?php echo  $this->Form->control('itemVariations['.$i.'][discount_per]',['class'=>'form-control input-sm  discount_per','placeholder'=>'Print Rate', 'value'=>$item_variation->discount_per,'label'=>false]); ?></td>								
							</td>
							
							<td>
								<?php echo  $this->Form->control('itemVariations['.$i.'][ready_to_sale]',['class'=>'form-control input-sm single','options'=>['Yes'=>'Yes','No'=>'No'], 'value'=>$item_variation->ready_to_sale,'label'=>false]); ?>
							</td>
						</tr>
						
						
					</tbody>
					<?php $i++; endforeach;  ?>
				</table>
				
				<div align="center">
					<?= $this->Form->button($this->Html->tag('') . __(' Update Sales Rate'),['class'=>'btn btn-success','id'=>'submitbtn']); ?>
				</div>
			<?= $this->Form->end() ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
var $rows = $('#main_tble tbody tr');
	$('#search3').on('keyup',function() {
		var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
		var v = $(this).val();
		if(v){ 
			$rows.show().filter(function() {
				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
	
				return !~text.indexOf(val);
			}).hide();
		}else{
			$rows.show();
		}
	});
</script>


<script>
$(document).ready(function(){
	// $('.category').on('change',function()
	// {
	// 	//alert();
	// 	var input=$(this).val();
	// 	//alert(input);
	// 	 var master = $(this); 
	// 	//alert(input);
	// 	if(input.length>0){
 //            var m_data = new FormData();
 //            var url ="<?php echo $this->Url->build(["controller" => "ItemVariations", "action" => "item"]); ?>";
 //         //   alert(url);
 //            m_data.append('input',input); 
 //            $.ajax({
 //                url: url,
 //                data: m_data,
 //                processData: false,
 //                contentType: false,
 //                type: 'POST',
 //                dataType:'text',
 //                success: function(response)
 //                { 
 //                	//alert(response);
	// 				$('.item').html(response);
 //                }
 //            });
 //            }
 //        });
	
	$(".print_rate").die().live("keyup",function(){
		 var print_rate=$(this).val();
		 discount_per=$(this).closest('tr').find('.discount_per').val();
		 t_amount=print_rate*discount_per/100;
		 sale_amt=print_rate-t_amount;
		 $(this).closest('tr').find('.sales_rate').val((sale_amt).toFixed(2));
	});

	$(".discount_per").die().live("keyup",function(){
		 var discount_per=$(this).val();
		 print_rate=$(this).closest('tr').find('.print_rate').val();
		 
		  t_amount=print_rate*discount_per/100;
		 sale_amt=print_rate-t_amount;
		 $(this).closest('tr').find('.sales_rate').val((sale_amt).toFixed(2));
		 $(this).closest('tr').find('.offline_sales_rate').val((sale_amt).toFixed(2));
	});
	
	$(".sales_rate").die().live("keyup",function(){
		 var sales_rate=$(this).val();
		 print_rate=$(this).closest('tr').find('.print_rate').val();
		 //discount_per=$(this).closest('tr').find('.discount_per').val();
		 
		 var diff_amount=print_rate-sales_rate;
		 
		 var discount_per=diff_amount*100/print_rate;
		 
		 
		 $(this).closest('tr').find('.discount_per').val((discount_per).toFixed(2));
	});

	$(".all").die().live('change',function(){
		var raw_attr_name = $('option:selected', this).val();
		$(".single option[value="+raw_attr_name+"]").attr('selected','selected');
	});
		
		
});
</script>