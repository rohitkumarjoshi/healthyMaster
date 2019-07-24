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
					<input id="search3"  class="form-control input-sm pull-right" type="text" placeholder="Search"  style="width: 200px;">
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-condensed table-hover table-bordered" id="main_tble">
					<thead>
						<tr>
							<th>Sr</th>
							<th>Item Code</th>
							<th>Name</th>
							<th>Alias Name</th>
							<th>Item Category</th>
							<th>Status</th>
							<th>Image</th>
							<th scope="col" class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody id="main_tbody">
						<?php
							foreach ($items as $item): 
							@$i++;
							?>
						<tr class="main_tr">
							<td><?= h($i) ?></td>
							<td><?= h($item->item_code) ?></td>
							<?php 
							$name=$item->name;
							$alias_name=$item->alias_name;
							if(!empty($alias_name)){ ?>
								<td><?php echo $name.' ('.$alias_name.')'; ?></td>
							<?php }else{ ?>
								<td><?= h($name) ?></td>
							<?php } ?>
							<td><?= $item->alias_name?></td>
							<td><?= h($item->item_category->name) ?></td>
							
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
								<?= $this->Html->link(__('Edit'), ['action' => 'edit', $item->id]) ?>
								<?php if($item->freeze == 0){ ?>
								<?= $this->Form->postLink(__('Deactive'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to Deactive # {0}?', $item->id)]) ?>
								<?php } ?>
								<?php if($item->freeze == 1){ ?>
								<?= $this->Form->postLink(__('Active'), ['action' => 'delete1', $item->id], ['confirm' => __('Are you sure you want to Active # {0}?', $item->id)]) ?>
								<?php } ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<div class="paginator">
			        <ul class="pagination">
			            <?= $this->Paginator->first('<< ' . __('first')) ?>
			            <?= $this->Paginator->prev('< ' . __('previous')) ?>
			            <?= $this->Paginator->numbers() ?>
			            <?= $this->Paginator->next(__('next') . ' >') ?>
			            <?= $this->Paginator->last(__('last') . ' >>') ?>
			        </ul>
			        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
			    </div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
var rows = $("#main_tbody tr.main_tr");
$("#search3").on("keyup",function() {
          
    var val = $.trim($(this).val()).replace(/ +/g, " ").toLowerCase();
    var v = $(this).val();
    
    if(v){
        rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, " ").toLowerCase();

            return !~text.indexOf(val);
        }).hide();
    }else{
        rows.show();
    }
});
</script>