
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ληξιαρχείο 180 ΜΚ/Β HAWK</title>
    <?php
    echo $this->Html->meta('icon');
    echo $this->Html->css('bulma');
    echo $this->Html->script('all');


    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
</head>
<body>
<section class="section">
    <nav class="navbar is-black is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <?= $this->Html->link('Εισερχόμενα', ['controller' => 'HawkFiles', 'action' => 'inbox'], ['class' => 'navbar-item']) ?>
            <?= $this->Html->link('Εξερχόμενα', ['controller' => 'HawkFiles', 'action' => 'outbox'], ['class' => 'navbar-item']) ?>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container">
        <?= $this->fetch('content') ?>
    </div>
</section>
</body>
</html>
