
<div class="col-md-12">
	<div class="portlet light bordered">
		<div class="portlet-title">
			<div class="caption">
				<i class=" fa fa-gift"></i>
				<span class="caption-subject">Promo Codes</span>
			</div>
			<div class="actions">
				
			</div>
		</div>
		<div class="portlet-body">
			<form method="post">
					<table width="50%" class="table table-condensed">
				<tbody>
					<tr>
						<td width="5%">
							<label>Code Name</label>
							<input type="text" name="code" value="<?= @$code;?>" class="form-control input-sm">
						</td>
						<td width="5%">
							<label>Item</label>
							<?php echo $this->Form->input('item_id', ['empty'=>'--Items--','options' => $items,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Select Item','value'=>@$item_id]); ?>
						</td>
						<td width="5%">
							<label>Status</label>
							<select name="status" class="form-control input-sm select2me">
								<option>-Select-</option>
								<option value="Active">Active</option>
								<option value="Deactive">Deactive</option>
							</select>
						</td>
						<td width="5%">
							<label>From</label>
							<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From" value="<?php if(!empty(@$from_date)) { echo date('d-m-Y',strtotime(@$from_date)); } ?>"  data-date-format="dd-mm-yyyy">	
						</td>	
						<td width="5%">
							<label>To</label>
							<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To" value="<?php if(!empty(@$to_date)) { echo date('d-m-Y',strtotime(@$to_date)); } ?>" data-date-format="dd-mm-yyyy">
						</td>
						<td width="10%">
							<button type="submit" class="btn btn-success btn-sm" style="margin-top: 23px !important;"><i class="fa fa-filter"></i> Filter</button>
						</td>
					</tr>
				</tbody>
			</table>
			</form>
			<div>
				<table class="table table-condensed table-hover table-bordered" id="main_tble">
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
						<td><?= h(@$promoCode->status) ?>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>