<section class="hawkFiles section">
    <?= $this->Element('Buttons/back') ?>
    <div class="columns is-centered">
        <?= $this->Form->create($task) ?>
        <h3 class="title is-3">Επεξεργασία εργασίας</h3>
        <div class="column">
            <?php
            echo $this->Form->hidden('hawk_file_id');
            echo $this->Form->hidden('owner_id');
            echo $this->Form->control('description', [
                'label' => 'Περιγραφή'
            ]);
            echo $this->Form->control('done', [
                'label'   => 'Πέρας Εργασίας',
            ]);
            $date = !empty($task->due) ? $task->due->i18nFormat('yyyy-MM-dd') : '';
            ?>
            <div class="field required">
                <label for="due" class="label">Προθεσμία</label>
                <input name="due" value="<?php echo $date ?>" id="due" class="is-dark input" type="date">
            </div>
            <?php
            echo $this->Form->button(__('Εισαγωγή'))
            ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</section>
