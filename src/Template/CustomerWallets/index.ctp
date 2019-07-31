<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerWallet[]|\Cake\Collection\CollectionInterface $customerWallets
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Customer Wallet'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="customerWallets index large-9 medium-8 columns content">
    <h3><?= __('Customer Wallets') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('add_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('used_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cancel_to_wallet_online') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ccavvenue_tracking_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ccavvenue_order_no') ?></th>
                <th scope="col"><?= $this->Paginator->sort('appiled_from') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customerWallets as $customerWallet): ?>
            <tr>
                <td><?= $this->Number->format($customerWallet->id) ?></td>
                <td><?= $customerWallet->has('customer') ? $this->Html->link($customerWallet->customer->name, ['controller' => 'Customers', 'action' => 'view', $customerWallet->customer->id]) : '' ?></td>
                <td><?= $this->Number->format($customerWallet->order_no) ?></td>
                <td><?= $customerWallet->has('order') ? $this->Html->link($customerWallet->order->id, ['controller' => 'Orders', 'action' => 'view', $customerWallet->order->id]) : '' ?></td>
                <td><?= $this->Number->format($customerWallet->add_amount) ?></td>
                <td><?= $this->Number->format($customerWallet->used_amount) ?></td>
                <td><?= h($customerWallet->cancel_to_wallet_online) ?></td>
                <td><?= h($customerWallet->amount_type) ?></td>
                <td><?= h($customerWallet->transaction_type) ?></td>
                <td><?= h($customerWallet->created_on) ?></td>
                <td><?= h($customerWallet->transaction_date) ?></td>
                <td><?= h($customerWallet->ccavvenue_tracking_no) ?></td>
                <td><?= h($customerWallet->ccavvenue_order_no) ?></td>
                <td><?= h($customerWallet->appiled_from) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $customerWallet->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $customerWallet->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $customerWallet->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customerWallet->id)]) ?>
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
