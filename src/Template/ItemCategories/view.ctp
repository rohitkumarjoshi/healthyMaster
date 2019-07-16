<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemCategory $itemCategory
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Item Category'), ['action' => 'edit', $itemCategory->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Item Category'), ['action' => 'delete', $itemCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemCategory->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Item Categories'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Category'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Banners'), ['controller' => 'Banners', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Banner'), ['controller' => 'Banners', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Home Screens'), ['controller' => 'HomeScreens', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Home Screen'), ['controller' => 'HomeScreens', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Carts'), ['controller' => 'Carts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cart'), ['controller' => 'Carts', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wishlists'), ['controller' => 'Wishlists', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wishlist'), ['controller' => 'Wishlists', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="itemCategories view large-9 medium-8 columns content">
    <h3><?= h($itemCategory->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($itemCategory->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Image') ?></th>
            <td><?= h($itemCategory->image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($itemCategory->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Jain Thela Admin Id') ?></th>
            <td><?= $this->Number->format($itemCategory->jain_thela_admin_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Seller Id') ?></th>
            <td><?= $this->Number->format($itemCategory->seller_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('City Id') ?></th>
            <td><?= $this->Number->format($itemCategory->city_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Parent Id') ?></th>
            <td><?= $this->Number->format($itemCategory->parent_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lft') ?></th>
            <td><?= $this->Number->format($itemCategory->lft) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rght') ?></th>
            <td><?= $this->Number->format($itemCategory->rght) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $itemCategory->is_deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Items') ?></h4>
        <?php if (!empty($itemCategory->items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Item Category Id') ?></th>
                <th scope="col"><?= __('Alias Name') ?></th>
                <th scope="col"><?= __('Short Description') ?></th>
                <th scope="col"><?= __('Benefit') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Freeze') ?></th>
                <th scope="col"><?= __('Seller Id') ?></th>
                <th scope="col"><?= __('Ready To Sale') ?></th>
                <th scope="col"><?= __('Is New') ?></th>
                <th scope="col"><?= __('Is Combo') ?></th>
                <th scope="col"><?= __('Is Virtual') ?></th>
                <th scope="col"><?= __('Image') ?></th>
                <th scope="col"><?= __('Gst Figure Id') ?></th>
                <th scope="col"><?= __('Item Code') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($itemCategory->items as $items): ?>
            <tr>
                <td><?= h($items->id) ?></td>
                <td><?= h($items->name) ?></td>
                <td><?= h($items->item_category_id) ?></td>
                <td><?= h($items->alias_name) ?></td>
                <td><?= h($items->short_description) ?></td>
                <td><?= h($items->benefit) ?></td>
                <td><?= h($items->description) ?></td>
                <td><?= h($items->freeze) ?></td>
                <td><?= h($items->seller_id) ?></td>
                <td><?= h($items->ready_to_sale) ?></td>
                <td><?= h($items->is_new) ?></td>
                <td><?= h($items->is_combo) ?></td>
                <td><?= h($items->is_virtual) ?></td>
                <td><?= h($items->image) ?></td>
                <td><?= h($items->gst_figure_id) ?></td>
                <td><?= h($items->item_code) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Items', 'action' => 'view', $items->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Items', 'action' => 'edit', $items->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Items', 'action' => 'delete', $items->id], ['confirm' => __('Are you sure you want to delete # {0}?', $items->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
