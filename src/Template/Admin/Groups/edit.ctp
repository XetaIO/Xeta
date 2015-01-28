<?= $this->assign('title', __d('admin', 'Edit a Group')) ?>

<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Flash->render(); ?>
		</div>

		<div class="col-md-12 heading">
			<h1 class="page-header">
				<i class="fa fa-newspaper-o"></i> <?= __d('admin', 'Edit a Group') ?>
			</h1>
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__d('admin', '{0} Dashboard', '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
					'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
				</li>
				<li>
					<?= $this->Html->link(__d('admin', '{0} Manage Groups', '<i class="fa fa-newspaper-o"></i>'), ['controller' => 'groups',
					'action' => 'index', 'prefix' => 'admin'], ['escape' => false]) ?>
				</li>
				<li class="active">
					<i class="fa fa-edit"></i> <?= __d('admin', 'Edit a Group') ?>
				</li>
			</ol>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<?= __d('admin', 'Edit a Group'); ?>
				</div>

				<div class="panel-body">
					<?= $this->Form->create($group, [
						'class' => 'form-horizontal',
						'role' => 'form'
					]) ?>
					<div class="form-group">
						<?= $this->Form->label('name', __d('admin', 'Name'), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('name', ['class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<?= $this->I18n->i18nInput($group, 'name', ['class' => 'form-control']); ?>

					<?= $this->Form->button(__d('admin', 'Edit Group'), ['class' => 'col-md-offset-2 btn btn-primary']) ?>
					<?= $this->Form->end() ?>

				</div>

			</div>
		</div>

	</div>
</div>
