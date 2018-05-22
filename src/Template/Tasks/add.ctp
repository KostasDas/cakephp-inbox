<section class="hawkFiles section">
    <?= $this->Element('Buttons/back') ?>
    <div class="columns is-centered">
        <?= $this->Form->create($task) ?>
        <h3 class="title is-3">Εισαγωγή ενέργειας</h3>
        <div class="column">
            <?php
            echo $this->Form->hidden('hawk_file_id', [
                'default' => $hawkFile
            ]);
            echo $this->Form->hidden('owner_id', [
                'default' => $owner
            ]);
            echo $this->Form->control('user_id', [
                'label'   => 'Χειριστής',
                'empty'   => 'Εισάγετε χειριστή',
            ]);
            echo $this->Form->control('description', [
                'label' => 'Περιγραφή'
            ]);
            ?>
            <div class="field required">
                <label for="due" class="label">Προθεσμία</label>
                <input name="due" id="due" class="is-dark input" type="date">
            </div>
            <?php
            echo $this->Form->button(__('Εισαγωγή'))
            ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</section>
