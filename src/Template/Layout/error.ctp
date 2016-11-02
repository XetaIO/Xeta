<?php
use Cake\Core\Configure;

?>
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
        <?php if (Configure::read('debug') === false) : ?>
            <?php $version = Configure::read('Site.version') ?>
            <?= $this->Html->css([
                'https://fonts.googleapis.com/css?family=Leckerli+One',
                'bootstrap.min.css?v=' . $version,
                'font-awesome.min.css?v=' . $version,
                'xeta.min.css?e=' . $version
            ]) ?>
        <?php else : ?>
            <?= $this->Html->css([
                'https://fonts.googleapis.com/css?family=Leckerli+One',
                'bootstrap.min',
                'font-awesome.min',
                'xeta.min'
            ]) ?>
        <?php endif; ?>

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

        <?php if (Configure::read('debug') === false) : ?>
            <?= $this->Html->script([
                'lib.min.js?v=' . $version,
                'xeta.min.js?v=' . $version
            ]); ?>
        <?php else : ?>
            <?= $this->Html->script([
                'lib.min',
                'xeta.min'
            ]); ?>
        <?php endif; ?>

        <?= $this->fetch('scriptBottom') ?>

        <?php if (isset($notification)): ?>
            <script>
            $(".top-right").notify({
                message : {
                    text : "<?= h($notification['message']) ?>"
                },
                type : "<?= $notification['type'] ?>"
            }).show();
            </script>
        <?php endif; ?>
    </body>
</html>
