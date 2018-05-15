<section class="hawkFiles section">
    <div class="columns is-centered">
    <?= $this->Form->create($hawkFile) ?>
    <h3 class="title is-3">Εισαγωγή εισερχομένου</h3>
    <div class="column">
        <?php
        echo $this->Form->control('number', [
            'label'        => 'Αριθμός ταυτότητας',
            'templateVars' => [
                'icon' => 'fa-id-card',
            ],
        ]);
        echo $this->Form->control('type', [
                'label' => 'Τύπος',
                'templateVars' => [
                    'icon' => 'fa-angle-double-down',
                ],
        ]);
        echo $this->Form->control('topic', [
            'label' => 'Θέμα',
            'templateVars' => [
                'icon' => 'fa-comment',
            ],
        ]);
        echo $this->Form->control('sender', [
            'label' => 'Αποστολέας',
            'templateVars' => [
                'icon' => 'fa-user',
            ],
        ]);
        echo $this->Form->control('protocol', [
            'label' => 'Φ/SIC',
            'templateVars' => [
                'icon' => 'fa-bars',
            ],
            'default' => ''
        ]);
        echo $this->Form->control('office', [
            'label' => 'Υπόψιν γραφείου',
            'templateVars' => [
                'icon' => 'fa-briefcase',
            ],
        ]);
        echo $this->Form->control('location', [
            'label' => 'Αρχείο',
            'templateVars' => [
                'icon' => 'fa-upload',
            ],
        ]);
        echo $this->Form->button(__('Εισαγωγή'))
        ?>
    </div>
    <?= $this->Form->end() ?>
    </div>
</section>
