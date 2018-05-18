<div>
    <?php

    echo $this->Html->link(
        '<button class="button is-info"><i class="fas fa-arrow-left"></i></button>',
        $this->request->referer(),
        ['escape' => false]
    );
    ?>
</div>