<?php
use Cake\Core\Configure;

?>
<footer class="footer">
	<div class="container">
		<p class="text-muted">
			<span class="pull-left">
				<?= __('&copy; {0} {1}.', [date('Y', time()), Configure::read('Site.name')]); ?>
			</span>
			<span class="pull-right">
				<?= __('{0} with {1} by', '<i class="fa fa-code text-primary" style="font-weight: bold;"></i>', '<i class="fa fa-heart text-danger"></i>'); ?>
				<?= $this->Html->link(
					Configure::read('Author.pseudo'),
					Configure::read('Author.twitter'),
					['target' => '_blank']
					) ?>
			</span>
		</p>
	</div>
</footer>
