<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerWallet $customerWallet
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Customer Wallet'), ['action' => 'edit', $customerWallet->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Customer Wallet'), ['action' => 'delete', $customerWallet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerWallet->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Customer Wallets'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer Wallet'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="customerWallets view large-9 medium-8 columns content">
    <h3><?= h($customerWallet->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $customerWallet->has('customer') ? $this->Html->link($customerWallet->customer->name, ['controller' => 'Customers', 'action' => 'view', $customerWallet->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order') ?></th>
            <td><?= $customerWallet->has('order') ? $this->Html->link($customerWallet->order->id, ['controller' => 'Orders', 'action' => 'view', $customerWallet->order->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cancel To Wallet Online') ?></th>
            <td><?= h($customerWallet->cancel_to_wallet_online) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount Type') ?></th>
            <td><?= h($customerWallet->amount_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Type') ?></th>
            <td><?= h($customerWallet->transaction_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ccavvenue Tracking No') ?></th>
            <td><?= h($customerWallet->ccavvenue_tracking_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ccavvenue Order No') ?></th>
            <td><?= h($customerWallet->ccavvenue_order_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Appiled From') ?></th>
            <td><?= h($customerWallet->appiled_from) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($customerWallet->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order No') ?></th>
            <td><?= $this->Number->format($customerWallet->order_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Add Amount') ?></th>
            <td><?= $this->Number->format($customerWallet->add_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Used Amount') ?></th>
            <td><?= $this->Number->format($customerWallet->used_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($customerWallet->created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($customerWallet->transaction_date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Narration') ?></h4>
        <?= $this->Text->autoParagraph(h($customerWallet->narration)); ?>
    </div>
</div>
