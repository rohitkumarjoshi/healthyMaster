<?php 

	$date= date("d-m-Y"); 
	$time=date('h:i:a',time());

	$filename="Item_stock_report_".$date.'_'.$time;

	header ("Expires: 0");
	header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
	header ("Cache-Control: no-cache, must-revalidate");
	header ("Pragma: no-cache");
	header ("Content-type: application/vnd.ms-excel");
	header ("Content-Disposition: attachment; filename=".$filename.".xls");
	header ("Content-Description: Generated Report" );

?>		
				<table id="main_tble" class="table table-condensed table-bordered">
							<thead>
								<tr>
									<th width="10%">
										<label>Sr<label>
									</th>
									<th width="10%">
										<label>Item Code<label>
									</th>
									<th width="10%">
										<label>Item Name<label>
									</th>
									
									<th width="10%">
										<label>Variation<label>
									</th>
									<th width="10%">
										<label>Opening Stock<label>
									</th>
									<th width="10%">
										<label>Purchase<label>
									</th>
									<th width="10%">
										<label>Wastage<label>
									</th>
									<th width="10%">
										<label>Reuse<label>
									</th>
									<th width="10%">
										<label>Stock For Sale<label>
									</th>
									<th width="10%">
										<label>Sale Of the Day<label>
									</th>
									<th width="10%">
										<label>Closing Stock<label>
									</th>

								</tr>
							</thead>
							<tbody id='main_tbody' class="tab">
						<?php $i=0; foreach($ItemVariations as $ItemVariation){
							
								
								if(@$itemVarOpeningQt[$ItemVariation->id] > 0 || @$itemPurchaseQt[$ItemVariation->id] > 0 ) { $i++;
								?>
									<tr class="main_tr" class="tab">
										<td width="1px"><?= $i ?>.</td>
										<td><?= $ItemVariation->item->item_code?></td>
										<td>
											<a href="#" role="button" class="stock_show" itm="<?= $ItemVariation->item_id ?>"><?= $ItemVariation->item->name ?></a>	
										</td>
										<td>
											<?= $ItemVariation->quantity_variation.' '.$ItemVariation->unit->shortname ?>
										</td>
										<td><?= @$itemVarOpeningQt[$ItemVariation->id] ?></td>
										<td><?= @$itemPurchaseQt[$ItemVariation->id] ?></td>
										<td>-</td>
										<td>-</td>
										<td><?= @$itemVarOpeningQt[$ItemVariation->id]+@$itemPurchaseQt[$ItemVariation->id] ?></td>
										<td><?= @$itemSaleQt[$ItemVariation->id] ?></td>
										<td><?= @$itemVarOpeningQt[$ItemVariation->id]+@$itemPurchaseQt[$ItemVariation->id]-@$itemSaleQt[$ItemVariation->id] ?></td>
										
									</tr>
								<?php } 
								} ?>
							</tbody>
						</table>