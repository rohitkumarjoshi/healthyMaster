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
				<div class="row">
                        <div class="col-md-12" style="margin-top: 10px;">
                              <table class="table table-striped table-bordered">
                                  <thead>
                                      <tr>
                                          <th width="5%">S.No</th>
                                          <th width="5%">Name</th>
                                          <th width="8%">Item</th>
                                          <th width="8%">Image</th>
										  <th width="10%">Status</th>
                                          <th width="15%">Link Name</th>
										  <th width="15%">Description</th>
										  <th width="8%">Actions</th>
                                      </tr>
                                  </thead>
                                  <tbody id="main-tbody">
								  <?php $i=0; foreach($Banners as $data){ ?>
									  <tr>
									  <td><?= ++$i  ?></td>
									  <td><?= $data->name ?></td>
									  <td><?= @$data->item->name ?></td>
									  <td><?= $this->Html->image('/img/banners/'.$data->image, ['style'=>'width:50px; height:50px;']); ?></td>
									  <td><?= $data->status ?></td>
									  <td><?= $data->link_name ?></td>
									  <td><?= $data->description ?></td>
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
