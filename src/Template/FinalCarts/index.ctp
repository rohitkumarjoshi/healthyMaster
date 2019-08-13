<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FinalCart[]|\Cake\Collection\CollectionInterface $finalCarts
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Final Cart'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['controller' => 'ItemVariations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['controller' => 'ItemVariations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="finalCarts index large-9 medium-8 columns content">
    <h3><?= __('Final Carts') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_variation_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cart_count') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_combo') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($finalCarts as $finalCart): ?>
            <tr>
                <td><?= $this->Number->format($finalCart->id) ?></td>
                <td><?= $finalCart->has('customer') ? $this->Html->link($finalCart->customer->name, ['controller' => 'Customers', 'action' => 'view', $finalCart->customer->id]) : '' ?></td>
                <td><?= $finalCart->has('item') ? $this->Html->link($finalCart->item->name, ['controller' => 'Items', 'action' => 'view', $finalCart->item->id]) : '' ?></td>
                <td><?= $finalCart->has('item_variation') ? $this->Html->link($finalCart->item_variation->id, ['controller' => 'ItemVariations', 'action' => 'view', $finalCart->item_variation->id]) : '' ?></td>
                <td><?= $this->Number->format($finalCart->quantity) ?></td>
                <td><?= $this->Number->format($finalCart->rate) ?></td>
                <td><?= $this->Number->format($finalCart->amount) ?></td>
                <td><?= $this->Number->format($finalCart->cart_count) ?></td>
                <td><?= h($finalCart->is_combo) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $finalCart->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $finalCart->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $finalCart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $finalCart->id)]) ?>
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
