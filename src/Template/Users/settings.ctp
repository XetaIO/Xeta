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
			<?= $this->Form->create($User, ['class' => 'section', 'type' => 'file']); ?>
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

			<?= $this->Form->create($User, ['class' => 'section', 'type' => 'file']); ?>
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
		</section>
	</div>
</div>
