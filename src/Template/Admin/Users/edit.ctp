<?= $this->assign('title', __("Edit an User")); ?>

<div class="profile interface-blur">
	<div class="container-fluid">
		<div class="box-content text-center">

			<ul class="list-inline">
				<li>
					<?= $this->Html->image(h($user->avatar), ['class' => 'img-circle img-border', 'alt' => h($user->username)]) ?>
				</li>
			</ul>


			<h1 class="username">
				<?= h($user->username) ?>
			</h1>
			
			<h3 class="full-name">
				<?= h($user->full_name) ?>
			</h3>
			

			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="box-actions">
						<div class="row">
							<div class="col-md-7">
								<ul class="list-inline no-margin text-center">
									<?php if($user->facebook): ?>
										<li class="text-center">
											<h4 class="base-header">
												<?= $this->Html->link('<i class="fa fa-facebook"></i>', 'http://facebook.com/' . h($user->facebook), ['escape' => false]) ?>
											</h4>
											<h5 class="base-header major">
												<?= h($user->facebook) ?>
											</h5>
										</li>
									<?php endif; ?>
									<?php if($user->twitter): ?>
										<li class="text-center">
											<h4 class="base-header">
												<?= $this->Html->link('<i class="fa fa-twitter"></i>', 'http://twitter.com/' . h($user->twitter), ['escape' => false]) ?>
											</h4>
											<h5 class="base-header major">
												<?= h($user->twitter) ?>
											</h5>
										</li>
									<?php endif; ?>
								</ul>
							</div>

							<div class="col-md-5">
								<ul class="list-inline no-margin">
									<li class="text-center">
										<h4 class="base-header">
											<?= __("Comments") ?>
										</h4>
										<h5 class="base-header major">
											<?= $this->Number->format($user->blog_articles_comment_count, ['locale' => 'fr_FR']) ?>
										</h5>
									</li>
									<li class="text-center">
										<h4 class="base-header">
											<?= __("Articles") ?>
										</h4>
										<h5 class="base-header major">
											<?= $this->Number->format($user->blog_article_count, ['locale' => 'fr_FR']) ?>
										</h5>
									</li>
									<li class="text-center">
										<h4 class="base-header">
											<?= __("Role") ?>
										</h4>
										<h5 class="base-header major">
											<?= h(ucfirst($user->role)) ?>
										</h5>
									</li>
								</ul>
							</div>

						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

</div>

<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Flash->render(); ?>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<?= __("{0}'s profile", h($user->username)); ?>
				</div>

				<div class="panel-body account">
					<div class="row">
						<div class="col-md-3 text-center">
							<h4>
								<?= __("Avatar") ?>
							</h4>
							<ul class="list-inline">
								<li>
									<?= $this->Html->image(h($user->avatar), ['class' => 'img-circle img-border', 'alt' => h($user->username)]) ?>
								</li>
							</ul>
							<div class="delete-avatar">
								<?= $this->Html->link(__("Delete Avatar"), ['_name' => 'users-deleteAvatar', 'slug' => $user->slug], ['class' => 'btn btn-primary btn-sm']) ?>
							</div>
							<h5>
								<?= __("Member since {0}", $user->created->format('M Y')) ?>
							</h5>
							<div class="delete-account">
								<?= $this->Html->link(__("Delete Account"), '#', ['class' => 'btn btn-danger btn-sm', 'data-toggle' => 'modal', 'data-target' => '#modalDeleteAccount']) ?>
							</div>
						</div>
						<div class="col-md-9">
							<?= $this->Form->create($user, [
								'class' => 'form-horizontal',
								'role' => 'form'
							]) ?>
							<div class="form-group">
								<?= $this->Form->label('username', __("Username"), ['class' => 'col-sm-2 control-label']) ?>
								<div class="col-sm-6">
									<?= $this->Form->input('username', ['class' => 'form-control', 'label' => false]) ?>
								</div>
							</div>
							<div class="form-group">
								<?= $this->Form->label('first_name', __("First Name"), ['class' => 'col-sm-2 control-label']) ?>
								<div class="col-sm-6">
									<?= $this->Form->input('first_name', ['class' => 'form-control', 'label' => false]) ?>
								</div>
							</div>
							<div class="form-group">
								<?= $this->Form->label('last_name', __("Last Name"), ['class' => 'col-sm-2 control-label']) ?>
								<div class="col-sm-6">
									<?= $this->Form->input('last_name', ['class' => 'form-control', 'label' => false]) ?>
								</div>
							</div>
							<div class="form-group">
								<?= $this->Form->label('email', __("Email"), ['class' => 'col-sm-2 control-label']) ?>
								<div class="col-sm-6">
									<?= $this->Form->input('email', ['class' => 'form-control', 'label' => false]) ?>
								</div>
							</div>
							<div class="form-group">
								<?= $this->Form->label('role', __("Role"), ['class' => 'col-sm-2 control-label']) ?>
								<div class="col-sm-6">
									<?= $this->Form->input('role', ['class' => 'form-control', 'label' => false]) ?>
								</div>
							</div>
							<div class="form-group">
								<?= $this->Form->label('facebook', __("Facebook"), ['class' => 'col-sm-2 control-label']) ?>
								<div class="col-sm-6">
									<?= $this->Form->input('facebook', ['class' => 'form-control', 'label' => false]) ?>
								</div>
							</div>
							<div class="form-group">
								<?= $this->Form->label('twitter', __("Twitter"), ['class' => 'col-sm-2 control-label']) ?>
								<div class="col-sm-6">
									<?= $this->Form->input('twitter', ['class' => 'form-control', 'label' => false]) ?>
								</div>
							</div>
							<div class="form-group">
								<?= $this->Form->label(null, __("Last Login IP"), ['class' => 'col-sm-2 control-label']) ?>
								<div class="col-sm-6">
									<p class="form-control-static">
										<?= h($user->last_login_ip) ?>
									</p>
								</div>
							</div>
							<div class="form-group">
								<?= $this->Form->label(null, __("Last Login"), ['class' => 'col-sm-2 control-label']) ?>
								<div class="col-sm-6">
									<p class="form-control-static">
										<?= $user->last_login->format('d/m/Y h:i:s') ?>
									</p>
								</div>
							</div>
							<div class="form-group">
								<?= $this->Form->label(null, __("Register IP"), ['class' => 'col-sm-2 control-label']) ?>
								<div class="col-sm-6">
									<p class="form-control-static">
										<?= h($user->register_ip) ?>
									</p>
								</div>
							</div>
							<div class="form-group">
								<?= $this->Form->label(null, __("Register"), ['class' => 'col-sm-2 control-label']) ?>
								<div class="col-sm-6">
									<p class="form-control-static">
										<?= $user->created->format('d/m/Y h:i:s') ?>
									</p>
								</div>
							</div>
							
							<?= $this->Form->button(__('Edit {0}', h($user->username)), ['class' => 'col-md-offset-2 btn btn-primary']) ?>
							<?= $this->Form->end() ?>
						</div>
					</div>
				</div>

			</div>
		</div>


	</div>
</div>
<div class="modal fade" id="modalDeleteAccount" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">
				<span aria-hidden="true">&times;</span>
				<span class="sr-only"><?= __("Close") ?></span>
			</button>
			<h4 class="modal-title">
				<?= __("Delete an account") ?>
			</h4>
			</div>
			<div class="modal-body">
				<p>
					<?= __("Are you sure you want delete the account <strong>{0}</strong> ?", h($user->username)) ?>
				</p>
				<small>
					<?= __("Note : All his articles, comments and likes will be deleted.") ?>
				</small>
			</div>
			<div class="modal-footer">
				<?= $this->Html->link(__("Yes"), ['_name' => 'users-delete', 'slug' => $user->slug], ['class' => 'btn btn-primary']) ?>
				<button type="button" class="btn btn-danger" data-dismiss="modal"><?= __("Close") ?></button>
			</div>
		</div>
	</div>
</div>
