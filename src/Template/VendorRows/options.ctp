<?php
	foreach($item as $show){
		$items[$show->item_id]=$show->item->name;
	}

	echo $this->Form->control('item_id',['empty'=>'--Select Item--','options' => $items,'class'=>'form-control input-sm chosen-select item-id','label'=>false,'required'=>true]); 

?>