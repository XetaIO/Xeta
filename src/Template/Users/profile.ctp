<?= $this->element('meta', [
	'title' => __("{0}'s profile", h($user->username))
]) ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__("Home"), '/') ?>
				</li>
				<li>
					<?= $this->Html->link(__("Users"), ['action' => 'index']) ?>
				</li>
				<li class="active">
					<?= h($user->username) ?>
				</li>
			</ol>
			<?= $this->Flash->render() ?>
		</div>
	</div>
	<div class="row profile">
		<div class="col-md-3">
			<section class="sidebar section">
				<?= $this->Html->image($user->avatar) ?>
				<h4>
					<?= h($user->full_name) ?>
				</h4>
				<ul class="social">
					<?php if ($user->facebook): ?>
						<li>
							<?= $this->Html->link('<i class="fa fa-facebook"></i>', 'http://facebook.com/' . h($user->facebook), ['target' => '_blank', 'escape' => false]) ?>
						</li>
					<?php endif; ?>
					<?php if ($user->twitter): ?>
						<li>
							<?= $this->Html->link('<i class="fa fa-twitter"></i>', 'http://twitter.com/' . h($user->twitter), ['target' => '_blank', 'escape' => false]) ?>
						</li>
					<?php endif; ?>
				</ul>
			</section>
		</div>

		<div class="col-md-9">
			<section class="section">
				<?php if ($user->id == $this->request->session()->read('Auth.User.id')): ?>
					<?= $this->Html->link(__("Edit my profile {0}", '<i class="fa fa-arrow-right"></i>'), ['action' => 'account'], ['class' => 'pull-right', 'escape' => false]) ?>
				<?php endif;?>
				<h4>
					<?= __("His Biography") ?>
				</h4>
				<div class="biography">
					<?= $user->biography ?>
				</div>

				<?php if (!empty($user->badges_users)): ?>
					<h4>
						<?= __("His Badges") ?>
					</h4>
					<div class="badges">
						<div class="row">
							<?php foreach ($user->badges_users as $badge): ?>
								<div class="col-md-3">
									<?= $this->Html->image($badge->badge->picture, [
										'alt' => h($badge->badge->name),
										'title' => h($badge->badge->name),
										'data-toggle' => 'tooltip'
									]) ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</section>
		</div>
	</div>
</div>
