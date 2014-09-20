<div class="container">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__("Home"), '/') ?>
				</li>
				<li>
					<?= $this->Html->link(__("Users"), ['controller' => 'users', 'action' => 'index']) ?>
				</li>
				<li class="active">
					<?= h($User->username) ?>
				</li>
			</ol>
			<?= $this->Flash->render() ?>
		</div>
	</div>
	<div class="row profile">
		<div class="col-md-3">
			<section class="sidebar section">
				<?= $this->Html->image($User->avatar) ?>
				<h4>
					<?= h($User->full_name) ?>
				</h4>
				<ul class="social">
					<?php if ($User->facebook): ?>
						<li>
							<?= $this->Html->link('<i class="fa fa-facebook"></i>', 'http://facebook.com/' . h($User->facebook), ['target' => '_blank', 'escape' => false]) ?>
						</li>
					<?php endif; ?>
					<?php if ($User->twitter): ?>
						<li>
							<?= $this->Html->link('<i class="fa fa-twitter"></i>', 'http://twitter.com/' . h($User->twitter), ['target' => '_blank', 'escape' => false]) ?>
						</li>
					<?php endif; ?>
				</ul>
			</section>
		</div>
		<div class="col-md-9">
			<section class="section">
				<?php if ($User->id == $this->Session->read('Auth.User.id')): ?>
					<?= $this->html->link(__("Edit my profile {0}", '<i class="fa fa-arrow-right"></i>'), ['action' => 'account'], ['class' => 'pull-right', 'escape' => false]) ?>
				<?php endif;?>
				<h4>
					<?= __("His Biography") ?>
				</h4>
				<div class="biography">
					<?= $User->biography ?>
				</div>
			</section>
		</div>
	</div>
</div>
