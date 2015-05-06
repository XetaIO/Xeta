<?= $this->Html->docType('html5') ?>
<html lang="en">
    <head>
        <?= $this->Html->charset() ?>
        <?= $this->Html->meta(
            'viewport',
            'width=device-width, initial-scale=1.0, maximum-scale=1.0'
        ) ?>
        <title>
            <?= $this->fetch('title') . ' - ' . \Cake\Core\Configure::read('Site.name') ?>
        </title>
        <?= $this->Html->meta('icon') ?>

        <?= $this->fetch('meta') ?>

        <!-- Styles -->
        <?= $this->Html->css([
            'https://fonts.googleapis.com/css?family=Leckerli+One',
            'bootstrap.min',
            'font-awesome.min',
            'animate.min',
            'xeta'
        ]) ?>

        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <?= $this->fetch('css') ?>
        <?= $this->fetch('scriptTop') ?>

        <?= $this->element('google-analytics') ?>
    </head>
    <body>
        <!-- Notifications in JavaScript -->
        <div class='notifications top-right'></div>

        <?= $this->element('header') ?>

        <?= $this->fetch('content') ?>

        <?= $this->element('footer') ?>

        <?= $this->Html->script([
            'lib.min',
            'user-menu.min',
            'xeta.min'
        ]); ?>

        <?= $this->fetch('scriptBottom') ?>
    </body>
</html>
