<style>
.table>thead>tr>th{
	font-size:12px !important;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">ITEMS
					</span>
				</div>
				<div class="actions">
					<?php echo $this->Html->link('Add New','/Items/Add',['escape'=>false,'class'=>'btn btn-default']) ?>&nbsp;
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover dataTable no-footer" id="sample_1">
					<thead>
						<tr>
							<th>Sr</th>
							<th>Item Code</th>
							<th>Name</th>
							<th>Item Category</th>
							<th>Status</th>
							<th>Image</th>
							<th scope="col" class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody id="main_tbody">
						<?php
							$i=0;
							foreach ($items as $item): 
							$i++;
							?>
						<tr class="main_tr">
							<td><?= $i ?></td>
							<td><?= $item->item_code ?></td>
							<?php 
							$name=$item->name;
							$alias_name=$item->alias_name;
							?>
								<td><?= h($name) ?></td> 
							<td><?= $item->item_category->name ?></td>
							
							<td><?php if($item->freeze == 0)
							{
								echo"Active";
							} 
							if($item->freeze == 1)
							{
								echo"Deactive";
							} 
							?></td>
							<td>
							    
							   <?= $this->Html->image('/img/item_images/'.$item->image, ['style'=>'width:50px; height:50px;']); ?>
							    </td>
							<td class="actions">
								 <?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $item->id],['class'=>'btn btn-primary  btn-condensed btn-xs','escape'=>false]) ?>
								<?php if($item->freeze == 0){ ?>
								<?= $this->Form->postLink(__('Deactive'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to Deactive # {0}?', $item->name),'class'=>'btn btn-xs green']) ?>
								<?php } ?>
								<?php if($item->freeze == 1){ ?>
								<?= $this->Form->postLink(__('Active'), ['action' => 'delete1', $item->name], ['confirm' => __('Are you sure you want to Active # {0}?', $item->id),'class'=>'btn btn-xs green']) ?>
								<?php } ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>