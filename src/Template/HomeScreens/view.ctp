<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HomeScreen $homeScreen
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Home Screen'), ['action' => 'edit', $homeScreen->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Home Screen'), ['action' => 'delete', $homeScreen->id], ['confirm' => __('Are you sure you want to delete # {0}?', $homeScreen->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Home Screens'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Home Screen'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="homeScreens view large-9 medium-8 columns content">
    <h3><?= h($homeScreen->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($homeScreen->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Layout') ?></th>
            <td><?= h($homeScreen->layout) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Section Show') ?></th>
            <td><?= h($homeScreen->section_show) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $homeScreen->has('item') ? $this->Html->link($homeScreen->item->name, ['controller' => 'Items', 'action' => 'view', $homeScreen->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Image') ?></th>
            <td><?= h($homeScreen->image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Link Name') ?></th>
            <td><?= h($homeScreen->link_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($homeScreen->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Preference') ?></th>
            <td><?= $this->Number->format($homeScreen->preference) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category Id') ?></th>
            <td><?= $this->Number->format($homeScreen->category_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Web Preference') ?></th>
            <td><?= $this->Number->format($homeScreen->web_preference) ?></td>
        </tr>
    </table>
</div>
