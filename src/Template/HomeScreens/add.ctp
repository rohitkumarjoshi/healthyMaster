<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HomeScreen $homeScreen
 */
?>
<!--<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Home Screens'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="homeScreens form large-9 medium-8 columns content">
    <?= $this->Form->create($homeScreen) ?>
    <fieldset>
        <legend><?= __('Add Home Screen') ?></legend>
        <?php
            echo $this->Form->control('title');
            echo $this->Form->control('layout');
            echo $this->Form->control('section_show');
            echo $this->Form->control('preference');
            echo $this->Form->control('category_id');
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('image');
            echo $this->Form->control('link_name');
            echo $this->Form->control('web_preference');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>-->

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
				
				<br/><br/>
				<div class="row">
                        <div class="col-md-12" style="margin-top: 10px;">
                              <table class="table table-striped table-bordered">
                                  <thead>
                                      <tr>
                                          <th width="5%">S.No</th>
                                          <th width="5%">Title</th>
                                          <th width="10%">Layout</th>
                                          <th width="10%">Section Show</th>
                                          <th width="10%">Category</th>
                                          <th width="8%">Item</th>
                                          <th width="8%">Image</th>
                                          <th width="15%">Link Name</th>
                                          <th width="8%">Actions</th>
                                      </tr>
                                  </thead>
                                  <tbody id="main-tbody">
								  <?php $i=0; foreach($HomeScreens as $data){ ?>
									  <tr>
									  <td><?= ++$i  ?></td>
									  <td><?= $data->title ?></td>
									  <td><?= $data->layout ?></td>
									  <td><?= $data->section_show ?></td>
									  <td><?= @$data->item_category->name ?></td>
									  <td><?= @$data->item->name ?></td>
									  <td><?= $this->Html->image('/img/home_screen/'.$data->image, ['style'=>'width:50px; height:50px;']); ?></td>
									   
									  <td><?= $data->link_name ?></td>
									  <td><?= $this->Html->link(__('Edit'), ['action' => 'edit', $data->id]) ?></td>
									  </tr>
								  <?php } ?>
                                  </tbody>
                              </table>
                            </div>
                </div>
			
			</div>
		</div>
	</div>
</div>
