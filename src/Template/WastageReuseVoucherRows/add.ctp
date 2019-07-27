<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WastageReuseVoucherRow $wastageReuseVoucherRow
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Wastage Reuse Voucher Rows'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Wastage Reuse Vouchers'), ['controller' => 'WastageReuseVouchers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Wastage Reuse Voucher'), ['controller' => 'WastageReuseVouchers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="wastageReuseVoucherRows form large-9 medium-8 columns content">
    <?= $this->Form->create($wastageReuseVoucherRow) ?>
    <fieldset>
        <legend><?= __('Add Wastage Reuse Voucher Row') ?></legend>
        <?php
            echo $this->Form->control('wastage_reuse_voucher_id', ['options' => $wastageReuseVouchers]);
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('unit_variation_id');
            echo $this->Form->control('wastage_quantity');
            echo $this->Form->control('reuse_quantity');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
