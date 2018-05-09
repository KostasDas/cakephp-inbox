<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ληξιαρχείο 180 ΜΚ/Β HAWK</title>
    <?php
    echo $this->Html->meta('icon');
    echo $this->Html->css('bulma');
    echo $this->Html->css('flash');
    echo $this->Html->script('all');
    echo $this->Html->script('jQuery/jquery-2.2.4.min');


    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
</head>
<body>
<section class="section">
    <nav style="margin-bottom: 5%" class="navbar is-black is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <?= $this->Html->link('Εισερχόμενα', ['controller' => 'HawkFiles', 'action' => 'inbox'],
                ['class' => 'navbar-item']) ?>
            <?= $this->Html->link('Εξερχόμενα', ['controller' => 'HawkFiles', 'action' => 'outbox'],
                ['class' => 'navbar-item']) ?>
        </div>
        <div class="navbar-menu">
            <div class="navbar-end">
                <?php
                if ($this->request->getParam('action') != 'login') {
                    $link = empty($authUser) ?
                        $this->Html->link('Σύνδεση', ['controller' => 'users', 'action' => 'login'],
                            ['class' => 'navbar-item'])
                        :
                        $this->Html->link('Αποσύνδεση', ['controller' => 'users', 'action' => 'logout'],
                            ['class' => 'navbar-item']);
                    echo $link;
                }
                ?>
            </div>

        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container">
        <?= $this->fetch('content') ?>
    </div>
</section>
</body>
</html>
