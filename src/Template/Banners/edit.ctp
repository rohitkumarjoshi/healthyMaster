<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Banner $banner
 */
?>


<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">
						<i class="fa fa-plus"></i> Banner Screen
					</span>
				</div>
				<div class="actions">
				</div>
			</div>
			<div class="portlet-body">
			<?= $this->Form->create($banner,['type'=>'file','id'=>'form_sample_3']) ?>
				<div class="row">
					<div class="col-md-3">
						<?php echo $this->Form->control('name',['class'=>'form-control input-sm','placeholder'=>'Name']); ?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->control('link_name',['class'=>'form-control input-sm','placeholder'=>'Link Name','value'=>'healthymaster://home']); ?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->control('item_id', ['empty'=>'--select--','options' => $items,'class'=>'form-control input-sm']); ?>
					</div>
					<div class="col-md-3">
						<?php 
						$options=[];
						$options['Active']='Active';
						$options['Deactive']='Deactive';
						echo $this->Form->control('status', ['options' => $options,'class'=>'form-control input-sm attribute']); ?>
					</div> 
					
				
				</div><br/>
				<div class="row">
					<div class="col-md-3">
						<?php echo $this->Form->control('image',['class'=>'form-control input-sm','placeholder'=>'Image','type'=>'file']); ?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->control('description',['class'=>'form-control input-sm','placeholder'=>'description']); ?>
					</div>
				</div>
				<?= $this->Form->button(__('Save'),['class'=>'btn btn-success']) ?>
				<?= $this->Form->end() ?>	
				
				<br/><br/>
				
			</div>
		</div>
	</div>
</div>
