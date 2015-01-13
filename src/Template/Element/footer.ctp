<?php
use Cake\Core\Configure;

?>
<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="text-muted col-md-6">
				<?= __('&copy; {0} {1}.', [date('Y', time()), Configure::read('Site.name')]) ?>
				<?= __("Source Code available on {0}", $this->Html->link('<i class="fa fa-github-alt" data-toggle="tooltip" title="GitHub"></i>', Configure::read('Site.github_url'), ['escape' => false, 'target' => '_blank'])) ?>
			</div>
			<div class="text-muted col-lg-3 col-lg-offset-3 col-md-4 col-md-offset-2 col-sm-5">
				<?= __('{0} with {1} by', '<i class="fa fa-code text-primary" style="font-weight: bold;"></i>', '<i class="fa fa-heart text-danger"></i>') ?>
				<?= $this->Html->link(
					Configure::read('Author.pseudo'),
					Configure::read('Author.twitter'),
					['target' => '_blank']
					) ?>

				<div class="btn-group dropup">
					<button type="button" class="btn btn-primary btn-sm">
						<?= $this->Html->image(
							'languages/blank.gif',
							[
								'class' => 'flag flag-' . \Cake\I18n\I18n::locale(),
								'alt' => \Cake\Core\Configure::read('I18n.locales.' . \Cake\I18n\I18n::locale())
							]
						) ?>
						<?= \Cake\Core\Configure::read('I18n.locales.' . \Cake\I18n\I18n::locale()) ?>
					</button>
					<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<?php foreach(\Cake\Core\Configure::read('I18n.locales') as $key => $value): ?>
							<?php if (\Cake\I18n\I18n::locale() != $key): ?>
								<li class="<?= $value ?>">
									<?= $this->Html->link(
										$this->Html->image(
											'languages/blank.gif',
											[
												'class' => 'flag flag-' . $key,
												'alt' => \Cake\Core\Configure::read('I18n.locales.' . $key)
											]
										) . '&nbsp;' . $value,
										[
											'_name' => 'set-lang',
											'lang' => $key
										],
										[
											'escape' => false
										]
									) ?>
								</li>
							<?php endif;?>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>
