<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WastageReuseVoucherRow $wastageReuseVoucherRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Wastage Reuse Voucher Row'), ['action' => 'edit', $wastageReuseVoucherRow->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Wastage Reuse Voucher Row'), ['action' => 'delete', $wastageReuseVoucherRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wastageReuseVoucherRow->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Wastage Reuse Voucher Rows'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wastage Reuse Voucher Row'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wastage Reuse Vouchers'), ['controller' => 'WastageReuseVouchers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wastage Reuse Voucher'), ['controller' => 'WastageReuseVouchers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="wastageReuseVoucherRows view large-9 medium-8 columns content">
    <h3><?= h($wastageReuseVoucherRow->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Wastage Reuse Voucher') ?></th>
            <td><?= $wastageReuseVoucherRow->has('wastage_reuse_voucher') ? $this->Html->link($wastageReuseVoucherRow->wastage_reuse_voucher->id, ['controller' => 'WastageReuseVouchers', 'action' => 'view', $wastageReuseVoucherRow->wastage_reuse_voucher->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $wastageReuseVoucherRow->has('item') ? $this->Html->link($wastageReuseVoucherRow->item->name, ['controller' => 'Items', 'action' => 'view', $wastageReuseVoucherRow->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($wastageReuseVoucherRow->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Unit Variation Id') ?></th>
            <td><?= $this->Number->format($wastageReuseVoucherRow->unit_variation_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Wastage Quantity') ?></th>
            <td><?= $this->Number->format($wastageReuseVoucherRow->wastage_quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Reuse Quantity') ?></th>
            <td><?= $this->Number->format($wastageReuseVoucherRow->reuse_quantity) ?></td>
        </tr>
    </table>
</div>
