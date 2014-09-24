<?= $this->Html->docType('html5'); ?>
<html lang="en">
    <head>
        <?= $this->Html->charset() ?>
        <?= $this->Html->meta(
			'viewport',
			'width=device-width, initial-scale=1.0, maximum-scale=1.0'
		);?>
        <title>
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>

        <!-- Styles -->
        <?= $this->Html->css([
			'http://fonts.googleapis.com/css?family=Leckerli+One',
			'bootstrap.min',
			'font-awesome.min',
			'admin'
		]); ?>

        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <?= $this->fetch('meta'); ?>
        <?= $this->fetch('css'); ?>
        <?= $this->fetch('scriptTop'); ?>
    </head>
    <body>
        <?= $this->element('Admin/header'); ?>

        <div class="container-fluid">
            <div class="row">

                <?= $this->element('Admin/sidebar'); ?>

                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <?= $this->fetch('content') ?>
                </div>

            </div>
        </div>

        <?= $this->Html->script([
			'jquery.min',
			'bootstrap.min',
			'admin'
		]); ?>

        <?= $this->fetch('scriptBottom'); ?>
    </body>
</html>
