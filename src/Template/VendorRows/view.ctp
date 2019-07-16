<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\VendorRow $vendorRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Vendor Row'), ['action' => 'edit', $vendorRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Vendor Row'), ['action' => 'delete', $vendorRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendorRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Vendor Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vendor Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Vendors'), ['controller' => 'Vendors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vendor'), ['controller' => 'Vendors', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="vendorRows view large-9 medium-8 columns content">
    <h3><?= h($vendorRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Vendor') ?></th>
            <td><?= $vendorRow->has('vendor') ? $this->Html->link($vendorRow->vendor->name, ['controller' => 'Vendors', 'action' => 'view', $vendorRow->vendor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $vendorRow->has('item') ? $this->Html->link($vendorRow->item->name, ['controller' => 'Items', 'action' => 'view', $vendorRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($vendorRow->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($vendorRow->created_on) ?></td>
        </tr>
    </table>
</div>
