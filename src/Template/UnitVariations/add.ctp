<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UnitVariation $unitVariation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Unit Variations'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="unitVariations form large-9 medium-8 columns content">
    <?= $this->Form->create($unitVariation) ?>
    <fieldset>
        <legend><?= __('Add Unit Variation') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('quantity_factor');
            echo $this->Form->control('created_date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
