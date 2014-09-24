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
			'animate.min',
			'xeta'
		]); ?>

		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<?= $this->fetch('meta'); ?>
		<?= $this->fetch('css'); ?>
		<?= $this->fetch('scriptTop'); ?>
	</head>
	<body>
		<!-- Notifications in JavaScript -->
		<div class='notifications top-right'></div>

		<?= $this->element('header'); ?>

		<?= $this->fetch('content') ?>

		<?= $this->element('footer'); ?>

		<?= $this->Html->script([
			'jquery.min',
			'bootstrap.min',
			'jquery.easing.1.3.min',
			'owl.carousel',
			'scrollUp',
			'prettify',
			'user-menu',
			'xeta'
		]); ?>

		<?= $this->fetch('scriptBottom'); ?>
	</body>
</html>
