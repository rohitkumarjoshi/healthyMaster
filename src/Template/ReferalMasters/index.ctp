<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReferalMaster[]|\Cake\Collection\CollectionInterface $referalMasters
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Referal Master'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="referalMasters index large-9 medium-8 columns content">
    <h3><?= __('Referal Masters') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('receiver_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sender_amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('order_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($referalMasters as $referalMaster): ?>
            <tr>
                <td><?= $this->Number->format($referalMaster->id) ?></td>
                <td><?= $this->Number->format($referalMaster->receiver_amount) ?></td>
                <td><?= $this->Number->format($referalMaster->sender_amount) ?></td>
                <td><?= $this->Number->format($referalMaster->order_value) ?></td>
                <td><?= h($referalMaster->status) ?></td>
                <td><?= h($referalMaster->created_on) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $referalMaster->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $referalMaster->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $referalMaster->id], ['confirm' => __('Are you sure you want to delete # {0}?', $referalMaster->id)]) ?>
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
