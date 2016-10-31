<?= $this->Html->docType('html5') ?>
<html lang="en">
    <head>
        <?= $this->Html->charset() ?>
        <?= $this->Html->meta(
            'viewport',
            'width=device-width, initial-scale=1.0, maximum-scale=1.0'
        );?>
        <title>
            <?= $this->fetch('title') . ' - ' . \Cake\Core\Configure::read('Site.name') ?>
        </title>
        <?= $this->Html->meta('icon') ?>

        <!-- Styles -->
        <?= $this->Html->css([
            'https://fonts.googleapis.com/css?family=Leckerli+One',
            'bootstrap.min',
            'font-awesome.min',
            'admin.min'
        ]) ?>

        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('scriptTop') ?>
    </head>
    <body>
        <?= $this->element('Admin/interface') ?>

        <?= $this->element('Admin/sidebar') ?>

        <div class="content">
            <?= $this->element('Admin/header') ?>

            <?= $this->fetch('content') ?>

            <?= $this->element('Admin/footer') ?>
        </div>

        <?= $this->Html->script([
            'lib.min',
            'admin.min'
        ]) ?>

        <?= $this->fetch('scriptBottom') ?>
    </body>
</html>
