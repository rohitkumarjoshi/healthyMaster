<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">
						<i class="fa fa-plus"></i> Home Screen
					</span>
				</div>
				<div class="actions">
				</div>
			</div>
			<div class="portlet-body">
			<?= $this->Form->create($homeScreen,['type'=>'file','id'=>'form_sample_3']) ?>
				<div class="row">
					<div class="col-md-3">
						<?php echo $this->Form->control('title',['class'=>'form-control input-sm','placeholder'=>'Title']); ?>
					</div>
					<div class="col-md-3">
						<?php 
						$options=[];
						$options['Banner']='Banner';
						$options['CategoryItems']='CategoryItems';
						$options['SingleImage']='SingleImage';
						$options['Category']='Category';
						$options['MostSelling']='MostSelling';
						echo $this->Form->control('layout', ['empty'=>'--select--','options' => $options,'class'=>'form-control input-sm attribute']); ?>
					</div>
					 <div class="col-md-3">
						<?php 
						$options=[];
						$options['Yes']='Yes';
						$options['No']='No';
						echo $this->Form->control('section_show', ['options' => $options,'class'=>'form-control input-sm attribute']); ?>
					</div> 
					<div class="col-md-3">
						<?php echo $this->Form->control('category_id', ['empty'=>'--select--','options' => $categories,'class'=>'form-control input-sm']); ?>
					</div>
				
				</div><br/>
				<div class="row">
					
					
					<div class="col-md-3">
						<?php echo $this->Form->control('item_id', ['empty'=>'--select--','options' => $items,'class'=>'form-control input-sm']); ?>
					</div>

					<div class="col-md-3">
						 <?= $this->Form->input('image',['class'=>'form-control','type'=>'File']) ?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->control('link_name', ['class'=>'form-control input-sm','placeholder'=>'link name','value'=>'Product_details']); ?>
						
					</div>
				</div>
				<?= $this->Form->button(__('Save'),['class'=>'btn btn-success']) ?>
				<?= $this->Form->end() ?>	
				
			</div>
		</div>
	</div>
</div>
