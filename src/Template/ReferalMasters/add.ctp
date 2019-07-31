<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReferalMaster $referalMaster
 */
?>
<!-- <nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Referal Masters'), ['action' => 'index']) ?></li>
    </ul>
</nav> -->
<div class="referalMasters form large-9 medium-8 columns content">
    <?= $this->Form->create($referalMaster) ?>
    <fieldset>
        <legend><?= __('Add Referal Master') ?></legend>
        <?php
            echo $this->Form->control('receiver_amount');
            echo $this->Form->control('sender_amount');
            echo $this->Form->control('order_value');
            echo $this->Form->control('status');
            echo $this->Form->control('created_on');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
