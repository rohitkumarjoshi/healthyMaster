<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WastageReuseVoucher $wastageReuseVoucher
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $wastageReuseVoucher->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $wastageReuseVoucher->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Wastage Reuse Vouchers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Wastage Reuse Voucher Rows'), ['controller' => 'WastageReuseVoucherRows', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wastage Reuse Voucher Row'), ['controller' => 'WastageReuseVoucherRows', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="wastageReuseVouchers form large-9 medium-8 columns content">
    <?= $this->Form->create($wastageReuseVoucher) ?>
    <fieldset>
        <legend><?= __('Edit Wastage Reuse Voucher') ?></legend>
        <?php
            echo $this->Form->control('created_date');
            echo $this->Form->control('voucher_no');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
