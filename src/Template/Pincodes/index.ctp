
<div class="row">
    <div class="col-md-12">
        <div class="portlet box grey-cascade">
            <div class="portlet-title">
                <div class="caption">
                    <i class="font-purple-intense"></i>
                    <span class="caption-subject font-purple-intense ">PINCODE
                    </span>
                </div>
                <div class="actions">
                    <?php echo $this->Html->link('Add new','/Pincodes/Add',['escape'=>false,'class'=>'btn btn-default']) ?>&nbsp;
                   
                </div>
            </div>
            <div class="portlet-body">
                <form method="GET" >
                    <table width="50%" class="table table-condensed">
                        <tbody>
                            <tr>
                                <td width="20%">
								
                                    <?php echo $this->Form->input('pincode', ['label' => false,'class' => 'form-control input-sm pincode','placeholder'=>'Pincode','type'=>'text','value'=>@$pincode]); ?>
                                </td>
								<td width="20%">
									
										
										<?php echo $this->Form->control('state_id', ['empty'=>'-- select state --','options' => $states,'class'=>'form-control input-sm select select2me select2 state','label'=>false]); ?>
								  
								</td>
								<td width="20%">
									
									  
										<select name="city_id" class="form-control input-sm city select2">
											
											
										</select>
									
								</td>
                                <td width="10%">
                                    <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-filter"></i> Filter</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
                <?php if(!empty($pincodes))
                {?>
                <?= $this->Form->create($pin,['id'=>'form_sample_3']) ?>
				<?php $page_no=$this->Paginator->current('Challans'); $page_no=($page_no-1)*20; ?>
                <table class="table table-condensed table-hover table-bordered" id="main_tble">
                    <thead>
                        <tr>
                            <th>Sr</th>
                            <th>State</th>
                            <th>City</th>
                            <th>PinCode</th>
                            <th>100Gm</th>
                            <th>500Gm</th>
                            <th>1Kg</th>
                            <th>Order Value</th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0;
                        foreach ($pincodes as $pincode): 
                        $i++;
                        ?>
                        <tr>
                            <td><?= ++$page_no ?></td>
                            <td><?= @$pincode->state->state_name ?></td>
                            <td><?= @$pincode->city->name ?></td>
                            <td><?= @$pincode->pincode ?></td>
                            <td><?php
                                if($pincode->we_deliver == "Yes")
                                {
                                    echo @$pincode->delivery_charge->hundred_gm;
                                }
                                else{ echo"-";}
                                ?>
                            </td>
                            <td><?php
                                if($pincode->we_deliver == "Yes")
                                {
                                    echo @$pincode->delivery_charge->five_hundred_gm;
                                }
                                else{ echo"-";}
                                ?>
                            </td>
                            <td><?php
                                if($pincode->we_deliver == "Yes")
                                {
                                    echo @$pincode->delivery_charge->one_kg;
                                }
                                else{ echo"-";}
                                ?>
                            </td>
                            <td><?php
                                if($pincode->we_deliver == "Yes")
                                {
                                    echo @$pincode->delivery_charge->min_order_value;
                                }
                                else{ echo"-";}
                                ?>
                            </td>
                            <td class="actions">
                               <!--  <?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $pincode->id],['class'=>'btn btn-primary  btn-condensed btn-xs','escape'=>false]) ?> -->
                                <!-- <?php if($pincode->is_deleted == 0){ ?>
                                <?= $this->Form->postLink(__('Deactive'), ['action' => 'delete', $pincode->id], ['confirm' => __('Are you sure you want to Deactive # {0}?', $pincode->id),'class'=>'btn btn-xs green']) ?>
                                <?php } ?>
                                <?php if($pincode->is_deleted == 1){ ?>
                                <?= $this->Form->postLink(__('Active'), ['action' => 'delete1', $pincode->id], ['confirm' => __('Are you sure you want to Active # {0}?', $pincode->id),'class'=>'btn btn-xs green']) ?>
                                <?php } ?> -->
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?= $this->Form->end() ?>
            <?php } ?>
                <div class="paginator">
					<ul class="pagination">
						<?= $this->Paginator->prev('< ' . __('previous')) ?>
						<?= $this->Paginator->numbers() ?>
						<?= $this->Paginator->next(__('next') . ' >') ?>
					</ul>
					<p><?= $this->Paginator->counter() ?></p>
				</div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
	$(document).on('change','.state',function(){
		
		var input=$(this).val();
		var master = $(this); 
		$(".city option").remove();
		if(input.length>0){
			var m_data = new FormData();
			var url ="<?php echo $this->Url->build(["controller" => "Pincodes", "action" => "options"]); ?>";
		 //   alert(url);
			m_data.append('input',input); 
			$.ajax({
				url: url,
				data: m_data,
				processData: false,
				contentType: false,
				type: 'POST',
				dataType:'text',
				success: function(data)
				{ 
					$('.city').append(data);
				}
			});
		}
		
	}); 
});
</script>