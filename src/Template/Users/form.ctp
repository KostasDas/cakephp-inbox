<div style="margin-top: 5%" class="users form columns has-text-centered is-centered">
    <?= $this->Form->create($user) ?>
    <?php
    echo $this->Form->control('name');
    echo $this->Form->control('username');
    echo $this->Form->control('password');
    echo $this->Form->control('role', [
        'options' => ['admin' => 'Admin', 'author' => 'Author'],
    ]);
    ?>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
