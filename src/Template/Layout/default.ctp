<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Γραμματεία</title>
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
    <nav style="margin-bottom: 5%; background-color: black" class="navbar card is-fixed-top" role="navigation"
         aria-label="main navigation">
        <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link custom-nav">Εισερχόμενα</a>
            <div class="navbar-dropdown">
                <?= $this->Html->link('Λίστα',
                    ['controller' => 'HawkFiles', 'action' => 'inbox'],
                    ['class' => 'navbar-item']) ?>
                <?php
                if (!empty($authUser)) {
                    echo $this->Html->link('Προσθήκη', ['controller' => 'HawkFiles', 'action' => 'inboxAdd'],
                        ['class' => 'navbar-item']);
                }
                ?>
            </div>
        </div>
        <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link custom-nav">Εξερχόμενα</a>
            <div class="navbar-dropdown">
                <?= $this->Html->link('Λίστα', ['controller' => 'HawkFiles', 'action' => 'outbox'],
                    ['class' => 'navbar-item']) ?>
                <?php
                if (!empty($authUser)) {
                    echo $this->Html->link('Προσθήκη', ['controller' => 'HawkFiles', 'action' => 'outboxAdd'],
                        ['class' => 'navbar-item']);
                }
                ?>
            </div>
        </div>
        <div class="navbar-menu">
            <div class="navbar-end">
                <?php
                if ($this->request->getParam('action') != 'login') {
                    $link = empty($authUser) ?
                        $this->Html->link('Σύνδεση', ['controller' => 'users', 'action' => 'login'],
                            ['class' => 'navbar-item custom-nav'])
                        :
                        $this->Html->link('Αποσύνδεση', ['controller' => 'users', 'action' => 'logout'],
                            ['class' => 'navbar-item custom-nav']);
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

<style>
    .custom-nav {
        background-color: black !important;
        color:white !important;
    }
    .custom-nav:hover {
        background-color: black !important;
    }
</style>
