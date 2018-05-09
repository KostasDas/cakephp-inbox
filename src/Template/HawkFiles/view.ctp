<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HawkFile $hawkFile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Hawk File'), ['action' => 'edit', $hawkFile->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Hawk File'), ['action' => 'delete', $hawkFile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $hawkFile->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Hawk Files'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Hawk File'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="hawkFiles view large-9 medium-8 columns content">
    <h3><?= h($hawkFile->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Number') ?></th>
            <td><?= h($hawkFile->number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($hawkFile->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Topic') ?></th>
            <td><?= h($hawkFile->topic) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sender') ?></th>
            <td><?= h($hawkFile->sender) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Protocol') ?></th>
            <td><?= h($hawkFile->protocol) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Office') ?></th>
            <td><?= h($hawkFile->office) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Location') ?></th>
            <td><?= h($hawkFile->location) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($hawkFile->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($hawkFile->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($hawkFile->modified) ?></td>
        </tr>
    </table>
</div>
