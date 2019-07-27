<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WastageReuseVoucher[]|\Cake\Collection\CollectionInterface $wastageReuseVouchers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Wastage Reuse Voucher'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Wastage Reuse Voucher Rows'), ['controller' => 'WastageReuseVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wastage Reuse Voucher Row'), ['controller' => 'WastageReuseVoucherRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="wastageReuseVouchers index large-9 medium-8 columns content">
    <h3><?= __('Wastage Reuse Vouchers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voucher_no') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wastageReuseVouchers as $wastageReuseVoucher): ?>
            <tr>
                <td><?= $this->Number->format($wastageReuseVoucher->id) ?></td>
                <td><?= h($wastageReuseVoucher->created_date) ?></td>
                <td><?= $this->Number->format($wastageReuseVoucher->voucher_no) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $wastageReuseVoucher->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $wastageReuseVoucher->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $wastageReuseVoucher->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wastageReuseVoucher->id)]) ?>
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
