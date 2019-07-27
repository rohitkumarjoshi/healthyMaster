<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemCategory[]|\Cake\Collection\CollectionInterface $itemCategories
 */
?>


<div class="row">
	<div class="col-md-5 col-sm-5">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">
						<?php  
						if(!empty($itemCategory1->id)){ ?> EDIT ITEM CATEGORY
						<?php }else{ ?>ADD ITEM CATEGORY
						<?php } ?>
					</span>
				</div>
				<div class="actions">
					<?php if(!empty($updt_id)){ ?>
						<?php echo $this->Html->link('Add New',['action' => 'index'],array('escape'=>false,'class'=>'btn btn-default')); ?>
					<?php } ?>
				</div>
			</div>
			<div class="portlet-body">
				<?= $this->Form->create($itemCategory1,['type'=>'file','id'=>'form_sample_3']) ?>
				<div class="row">
					<div class="col-md-8">
						<label class=" control-label">Item Category <span class="required" aria-required="true">*</span></label>
						<?php echo $this->Form->control('name',['placeholder'=>'Item Category name','class'=>'form-control input-sm','label'=>false,'maxlength'=>50]); ?>
					</div>
					<div class="col-md-8" style="margin-top: 10px;">
						<label class=" control-label">Parent Category </label>
							<?php echo $this->Form->control('parent_id', ['empty'=>'--select--','options' => $itemParent,'class'=>'form-control input-sm','label'=>false]); ?>
						
					</div>
					<div class="col-md-8" style="margin-top: 10px;">
						<label class=" control-label">Image<span class="required" aria-required="true"></span></label>
						 <!-- <?= $this->Form->input('image',['class'=>'form-control','type'=>'file','value'=>$itemCategory1->image]) ?> -->
						 <input type="file" name="image" class="form-control input-sm" value="<?=$itemCategory1->image?>">
					</div>
				</div>
				<br/>
				<?= $this->Form->button($this->Html->tag('i', '') . __(' Submit'),['class'=>'btn btn-success']); ?>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
	<div class="col-md-7 col-sm-7">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class=" fa fa-gift"></i>
					<span class="caption-subject">ITEM CATEGORIES</span>
				</div>
			</div>
			<div class="portlet-body">
				<div style="overflow-y: scroll;height: 400px;">
					<table class="table table-bordered table-condensed pagin-table" id="main_tble">
						<thead>
							<tr>
								<th><?=  h('Sr.no') ?></th>
								<th><?=  h('Category Name') ?></th>
								<th><?=  h('Parent') ?></th>
								<th><?=  h('Image') ?></th>
								<th class="actions"><?= __('Actions') ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$k=0;
							foreach ($itemCategories as $itemCategory):
								@$k++;
							?>
							<tr>
								<td><?= h($k) ?></td>
								<td><?= h($itemCategory->name) ?></td>
								<td><?= h(@$itemCategory->parent_item_category->name) ?></td>
								<td>
						    	<?=	$this->Html->image('/img/itemcategories/'.$itemCategory->image, ['style'=>'width:50px; height:50px;']); ?>
								</td>
								<td class="actions">
								<?php echo $this->Html->link('<i class="fa fa-pencil"></i>',['action' => 'index', $itemCategory->id],['escape'=>false,'class'=>'btn btn-xs blue']); ?>
								<?php 
									if($itemCategory->is_deleted == 0)
									{ ?>
									<?= $this->Form->postLink(__('Deactive'), ['action' => 'delete', $itemCategory->id], ['confirm' => __('Are you sure you want to Deactive # {0}?', $itemCategory->name),'class'=>'btn btn-xs green']) ?> 
									<?php }
									if($itemCategory->is_deleted == 1)
									{ ?>
										<?= $this->Form->postLink(__('Active'), ['action' => 'delete1', $itemCategory->id], ['confirm' => __('Are you sure you want to Active # {0}?', $itemCategory->name),'class'=>'btn btn-xs green']) ?>
									<?php }
								?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
	
  //--------- FORM VALIDATION
	var form3 = $('#form_sample_3');
	var error3 = $('.alert-danger', form3);
	var success3 = $('.alert-success', form3);
	form3.validate({
		
		errorElement: 'span', //default input error message container
		errorClass: 'help-block help-block-error', // default input error message class
		focusInvalid: true, // do not focus the last invalid input
		rules: {
				image:{
					required: true,					 
				},
				parent_id:{
					required: true,
				}
			},

		errorPlacement: function (error, element) { // render error placement for each input type
			if (element.parent(".input-group").size() > 0) {
				error.insertAfter(element.parent(".input-group"));
			} else if (element.attr("data-error-container")) { 
				error.appendTo(element.attr("data-error-container"));
			} else if (element.parents('.radio-list').size() > 0) { 
				error.appendTo(element.parents('.radio-list').attr("data-error-container"));
			} else if (element.parents('.radio-inline').size() > 0) { 
				error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
			} else if (element.parents('.checkbox-list').size() > 0) {
				error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
			} else if (element.parents('.checkbox-inline').size() > 0) { 
				error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
			} else {
				error.insertAfter(element); // for other inputs, just perform default behavior
			}
		},

		invalidHandler: function (event, validator) { //display error alert on form submit   
			success3.hide();
			error3.show();
		},

		highlight: function (element) { // hightlight error inputs
		   $(element)
				.closest('.form-group').addClass('has-error'); // set error class to the control group
		},

		unhighlight: function (element) { // revert the change done by hightlight
			$(element)
				.closest('.form-group').removeClass('has-error'); // set error class to the control group
		},

		success: function (label) {
			label
				.closest('.form-group').removeClass('has-error'); // set success class to the control group
		},

		submitHandler: function (form) {
			success3.show();
			error3.hide();
			form[0].submit(); // submit the form
		}

	});
});
	</script>
