<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReferalMaster $referalMaster
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Referal Master'), ['action' => 'edit', $referalMaster->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Referal Master'), ['action' => 'delete', $referalMaster->id], ['confirm' => __('Are you sure you want to delete # {0}?', $referalMaster->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Referal Masters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Referal Master'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="referalMasters view large-9 medium-8 columns content">
    <h3><?= h($referalMaster->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($referalMaster->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($referalMaster->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Receiver Amount') ?></th>
            <td><?= $this->Number->format($referalMaster->receiver_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sender Amount') ?></th>
            <td><?= $this->Number->format($referalMaster->sender_amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Value') ?></th>
            <td><?= $this->Number->format($referalMaster->order_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($referalMaster->created_on) ?></td>
        </tr>
    </table>
</div>
