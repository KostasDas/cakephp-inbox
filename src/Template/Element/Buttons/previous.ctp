<div>
    <?php
    $url = explode('/', $this->request->url);
    unset($url[count($url)-1]);
    echo $this->Html->link(
        '<button class=" glyphicon glyphicon-arrow-left btn btn-info"></button>',
        implode('/',$url),
        ['escape' => false]
    );
    ?>
</div>