<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WastageReuseVoucherRow[]|\Cake\Collection\CollectionInterface $wastageReuseVoucherRows
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Wastage Reuse Voucher Row'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Wastage Reuse Vouchers'), ['controller' => 'WastageReuseVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wastage Reuse Voucher'), ['controller' => 'WastageReuseVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="wastageReuseVoucherRows index large-9 medium-8 columns content">
    <h3><?= __('Wastage Reuse Voucher Rows') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('wastage_reuse_voucher_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('unit_variation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('wastage_quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reuse_quantity') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wastageReuseVoucherRows as $wastageReuseVoucherRow): ?>
            <tr>
                <td><?= $this->Number->format($wastageReuseVoucherRow->id) ?></td>
                <td><?= $wastageReuseVoucherRow->has('wastage_reuse_voucher') ? $this->Html->link($wastageReuseVoucherRow->wastage_reuse_voucher->id, ['controller' => 'WastageReuseVouchers', 'action' => 'view', $wastageReuseVoucherRow->wastage_reuse_voucher->id]) : '' ?></td>
                <td><?= $wastageReuseVoucherRow->has('item') ? $this->Html->link($wastageReuseVoucherRow->item->name, ['controller' => 'Items', 'action' => 'view', $wastageReuseVoucherRow->item->id]) : '' ?></td>
                <td><?= $this->Number->format($wastageReuseVoucherRow->unit_variation_id) ?></td>
                <td><?= $this->Number->format($wastageReuseVoucherRow->wastage_quantity) ?></td>
                <td><?= $this->Number->format($wastageReuseVoucherRow->reuse_quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $wastageReuseVoucherRow->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $wastageReuseVoucherRow->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $wastageReuseVoucherRow->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wastageReuseVoucherRow->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
