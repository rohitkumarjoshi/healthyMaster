<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WastageReuseVoucher $wastageReuseVoucher
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Wastage Reuse Voucher'), ['action' => 'edit', $wastageReuseVoucher->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Wastage Reuse Voucher'), ['action' => 'delete', $wastageReuseVoucher->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wastageReuseVoucher->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Wastage Reuse Vouchers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wastage Reuse Voucher'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Wastage Reuse Voucher Rows'), ['controller' => 'WastageReuseVoucherRows', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wastage Reuse Voucher Row'), ['controller' => 'WastageReuseVoucherRows', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="wastageReuseVouchers view large-9 medium-8 columns content">
    <h3><?= h($wastageReuseVoucher->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($wastageReuseVoucher->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Voucher No') ?></th>
            <td><?= $this->Number->format($wastageReuseVoucher->voucher_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created Date') ?></th>
            <td><?= h($wastageReuseVoucher->created_date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Wastage Reuse Voucher Rows') ?></h4>
        <?php if (!empty($wastageReuseVoucher->wastage_reuse_voucher_rows)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Wastage Reuse Voucher Id') ?></th>
                <th scope="col"><?= __('Wastage Quantity') ?></th>
                <th scope="col"><?= __('Reuse Quantity') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($wastageReuseVoucher->wastage_reuse_voucher_rows as $wastageReuseVoucherRows): ?>
            <tr>
                <td><?= h($wastageReuseVoucherRows->id) ?></td>
                <td><?= h($wastageReuseVoucherRows->wastage_reuse_voucher_id) ?></td>
                <td><?= h($wastageReuseVoucherRows->wastage_quantity) ?></td>
                <td><?= h($wastageReuseVoucherRows->reuse_quantity) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'WastageReuseVoucherRows', 'action' => 'view', $wastageReuseVoucherRows->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'WastageReuseVoucherRows', 'action' => 'edit', $wastageReuseVoucherRows->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'WastageReuseVoucherRows', 'action' => 'delete', $wastageReuseVoucherRows->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wastageReuseVoucherRows->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
