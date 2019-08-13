<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FinalCart $finalCart
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Final Cart'), ['action' => 'edit', $finalCart->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Final Cart'), ['action' => 'delete', $finalCart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $finalCart->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Final Carts'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Final Cart'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="finalCarts view large-9 medium-8 columns content">
    <h3><?= h($finalCart->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $finalCart->has('customer') ? $this->Html->link($finalCart->customer->name, ['controller' => 'Customers', 'action' => 'view', $finalCart->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $finalCart->has('item') ? $this->Html->link($finalCart->item->name, ['controller' => 'Items', 'action' => 'view', $finalCart->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Variation') ?></th>
            <td><?= $finalCart->has('item_variation') ? $this->Html->link($finalCart->item_variation->id, ['controller' => 'ItemVariations', 'action' => 'view', $finalCart->item_variation->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Combo') ?></th>
            <td><?= h($finalCart->is_combo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($finalCart->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($finalCart->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $this->Number->format($finalCart->rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($finalCart->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cart Count') ?></th>
            <td><?= $this->Number->format($finalCart->cart_count) ?></td>
        </tr>
    </table>
</div>
