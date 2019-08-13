<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FinalCart $finalCart
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $finalCart->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $finalCart->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Final Carts'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="finalCarts form large-9 medium-8 columns content">
    <?= $this->Form->create($finalCart) ?>
    <fieldset>
        <legend><?= __('Edit Final Cart') ?></legend>
        <?php
            echo $this->Form->control('customer_id', ['options' => $customers]);
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('item_variation_id', ['options' => $itemVariations]);
            echo $this->Form->control('quantity');
            echo $this->Form->control('rate');
            echo $this->Form->control('amount');
            echo $this->Form->control('cart_count');
            echo $this->Form->control('is_combo');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
