<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HawkFile $hawkFile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $hawkFile->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $hawkFile->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Hawk Files'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="hawkFiles form large-9 medium-8 columns content">
    <?= $this->Form->create($hawkFile) ?>
    <fieldset>
        <legend><?= __('Edit Hawk File') ?></legend>
        <?php
            echo $this->Form->control('number');
            echo $this->Form->control('type');
            echo $this->Form->control('topic');
            echo $this->Form->control('sender');
            echo $this->Form->control('protocol');
            echo $this->Form->control('office');
            echo $this->Form->control('location');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
