<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UnitVariation $unitVariation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Unit Variation'), ['action' => 'edit', $unitVariation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Unit Variation'), ['action' => 'delete', $unitVariation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $unitVariation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Unit Variations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit Variation'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="unitVariations view large-9 medium-8 columns content">
    <h3><?= h($unitVariation->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($unitVariation->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($unitVariation->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($unitVariation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity Factor') ?></th>
            <td><?= $this->Number->format($unitVariation->quantity_factor) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created Date') ?></th>
            <td><?= h($unitVariation->created_date) ?></td>
        </tr>
    </table>
</div>
