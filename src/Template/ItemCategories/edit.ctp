<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemCategory $itemCategory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $itemCategory->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $itemCategory->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Item Categories'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Banners'), ['controller' => 'Banners', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Banner'), ['controller' => 'Banners', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Home Screens'), ['controller' => 'HomeScreens', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Home Screen'), ['controller' => 'HomeScreens', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Carts'), ['controller' => 'Carts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cart'), ['controller' => 'Carts', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Wishlists'), ['controller' => 'Wishlists', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wishlist'), ['controller' => 'Wishlists', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemCategories form large-9 medium-8 columns content">
    <?= $this->Form->create($itemCategory) ?>
    <fieldset>
        <legend><?= __('Edit Item Category') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('is_deleted');
            echo $this->Form->control('jain_thela_admin_id');
            echo $this->Form->control('seller_id');
            echo $this->Form->control('city_id');
            echo $this->Form->control('image');
            echo $this->Form->control('parent_id');
            echo $this->Form->control('lft');
            echo $this->Form->control('rght');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
