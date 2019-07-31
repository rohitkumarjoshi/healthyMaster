<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerWallet $customerWallet
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $customerWallet->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $customerWallet->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Customer Wallets'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="customerWallets form large-9 medium-8 columns content">
    <?= $this->Form->create($customerWallet) ?>
    <fieldset>
        <legend><?= __('Edit Customer Wallet') ?></legend>
        <?php
            echo $this->Form->control('customer_id', ['options' => $customers]);
            echo $this->Form->control('order_no');
            echo $this->Form->control('order_id', ['options' => $orders]);
            echo $this->Form->control('add_amount');
            echo $this->Form->control('used_amount');
            echo $this->Form->control('cancel_to_wallet_online');
            echo $this->Form->control('narration');
            echo $this->Form->control('amount_type');
            echo $this->Form->control('transaction_type');
            echo $this->Form->control('created_on');
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('ccavvenue_tracking_no');
            echo $this->Form->control('ccavvenue_order_no');
            echo $this->Form->control('appiled_from');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
