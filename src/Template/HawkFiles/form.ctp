<section class="hawkFiles section">
    <?= $this->Element('Buttons/back') ?>
    <div class="columns is-centered">
        <?= $this->Form->create($hawkFile, ['enctype' => 'multipart/form-data']) ?>
        <h3 class="title is-3">Εισαγωγή αρχείου</h3>
        <div class="column">
            <?php
            echo $this->Form->control('number', [
                'label'        => 'Αριθμός Εκδότου',
                'templateVars' => [
                    'icon' => 'fas fa-id-card',
                ],
            ]);
            echo $this->Form->control('topic', [
                'label'        => 'Θέμα',
                'templateVars' => [
                    'icon' => 'fas fa-comment',
                ],
            ]);

            echo $this->Form->control('protocol', [
                'label'        => 'Φ/SIC',
                'templateVars' => [
                    'icon' => 'fas fa-bars',
                ],
                'default'      => '',
            ]);
            echo $this->Form->control('user_id', [
                'label' => 'Χειριστής',
                'multiple' => true,
                'default' => isset($userIds) ? $userIds : []
            ]);
            echo $this->Form->control('file_type', [
                'label' => 'Τύπος αρχείου',
                'options' => [
                    'εισερχομενο' => 'Εισερχόμενο',
                    'εξερχομενο' => 'Εξερχόμενο'
                ],
                'empty'   => 'Εισάγετε τύπο',
            ]);
            echo $this->Form->control('type', [
                'label'   => 'Είδος αλληλογραφίας',
                'options' => ['new' => 'Άλλο'] + $types->toArray(),
                'empty'   => 'Εισάγετε είδος',
            ]);
            echo $this->Form->control('sender', [
                'label'   => 'Αποστολέας/Παραλήπτης',
                'options' => ['new' => 'Άλλο'] + $senders->toArray(),
                'empty'   => 'Εισάγετε αποστολέα/παραλήπτη',
            ]);
            ?>
            <div class="file is-black has-name required" style="margin-bottom: 10px">
                <label class="file-label">
                    <input class="file-input" id="file-upload-input" type="file" name="hawk_file">
                    <span class="file-cta">
                      <span class="file-icon">
                        <i class="fas fa-upload"></i>
                      </span>
                      <span class="file-label">
                        Επιλέξτε Αρχείο
                      </span>
                    </span>
                    <span class="file-name" id="file-upload-name">
                        <p style="color: red">Δεν έχετε επιλέξει αρχείο</p>
                    </span>
                </label>
            </div>
            <?php
            echo $this->Form->button(__('Εισαγωγή'))
            ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</section>
<?php
echo $this->Html->script('upload');
echo $this->Html->script('select');
?>
