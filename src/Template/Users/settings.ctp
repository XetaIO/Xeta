<?= $this->element('meta', [
	'title' => __("My Settings")
]) ?>

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
					<?= __("My Settings") ?>
				</li>
			</ol>
			<?= $this->Flash->render() ?>
		</div>
	</div>
	<div class="row">
		<section class="col-md-3">
			<?= $this->element('/Users/sidebar') ?>
		</section>
		<section class="col-md-9">
			<?= $this->Form->create($User, ['class' => 'section']); ?>
				<?= $this->Form->input('method', ['type' => 'hidden', 'value' => 'email']) ?>
				<h4>
					<?= __("Change your E-mail") ?>
				</h4>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<?= $this->Form->label(null, __("E-mail")) ?>
							<p class="form-control-static">
								<?= $this->Form->label(null, $oldEmail) ?>
							</p>
						</div>
						<div class="col-md-6">
							<?= $this->Form->label('email', __("New E-mail")) ?>
							<?= $this->Form->input('email', ['class' => 'form-control', 'label' => false, 'value' => false]) ?>
						</div>
					</div>
				</div>
				<?= $this->Form->button(__('Save'), ['class' => 'btn btn-primary']) ?>
			<?= $this->Form->end() ?>

			<?= $this->Form->create($User, ['class' => 'section']); ?>
				<?= $this->Form->input('method', ['type' => 'hidden', 'value' => 'password']) ?>
				<h4>
					<?= __("Change your Password") ?>
				</h4>
				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							<?= $this->Form->label('old_password', __("Current Password")) ?>
							<?= $this->Form->input('old_password', ['type' => 'password', 'class' => 'form-control', 'label' => false, 'value' => false]) ?>
						</div>
						<div class="col-md-4">
							<?= $this->Form->label('password', __("New Password")) ?>
							<?= $this->Form->input('password', ['type' => 'password', 'class' => 'form-control', 'label' => false, 'value' => false]) ?>
						</div>
						<div class="col-md-4">
							<?= $this->Form->label('password_confirm', __("New Password (confirm)")) ?>
							<?= $this->Form->input('password_confirm', ['type' => 'password', 'class' => 'form-control', 'label' => false, 'value' => false]) ?>
						</div>
					</div>
				</div>
				<?= $this->Form->button(__('Save'), ['class' => 'btn btn-primary']) ?>
			<?= $this->Form->end() ?>
			
			<div class="section">
				<h4>
					<?= __("Delete your Account") ?>
				</h4>
				<button class="btn btn-danger" data-toggle="modal" data-target="#deleteAccount">
					<?= __("Delete my Account") ?>
				</button>
				<div class="modal fade" id="deleteAccount" tabindex="-1" role="dialog" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">
									<span aria-hidden="true">&times;</span>
									<span class="sr-only"><?= __("Close") ?></span>
								</button>
								<h4 class="modal-title"><?= __("Delete my Account") ?></h4>
							</div>
							<div class="modal-body">
								<?= __("Are you sure you want delete your account ? <strong>This operation is not reversible.</strong>") ?>
							</div>
							<div class="modal-footer">
								<?= $this->Html->link(__("Yes, i confirm !"), ['controller' => 'users', 'action' => 'delete'], ['class' => 'btn btn-danger']) ?>
								<button type="button" class="btn btn-primary" data-dismiss="modal"><?= __("Close") ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>
