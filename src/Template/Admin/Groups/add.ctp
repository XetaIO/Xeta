<?= $this->assign('title', __d('admin', 'Add a Group')) ?>

<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Flash->render(); ?>
		</div>

		<div class="col-md-12 heading">
			<h1 class="page-header">
				<i class="fa fa-users"></i> <?= __d('admin', 'Add a Group') ?>
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
					<i class="fa fa-plus"></i> <?= __d('admin', 'Add a Group') ?>
				</li>
			</ol>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<?= __d('admin', 'Add a Group') ?>
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
					<div class="form-group">
						<?= $this->Form->label('css', __d('admin', 'CSS'), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('css', ['class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('is_staff', __d('admin', 'Is Staff'), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5 radio-check">
							<?= $this->Form->radio('is_staff', [
									'1' => __d('admin', 'Yes'),
									'0' => __d('admin', 'No')
								],
								[
									'value' => '0',
									'legend' => false,
									'class' => 'form-control'
								]
							) ?>
							<span>
								<?= __d('admin', 'Used to display the Staff Online') ?>
							</span>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('is_member', __d('admin', 'Is Member'), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5 radio-check">
							<?= $this->Form->radio('is_member', [
									'1' => __d('admin', 'Yes'),
									'0' => __d('admin', 'No')
								],
								[
									'value' => '1',
									'legend' => false,
									'class' => 'form-control'
								]
							) ?>
							<span>
								<?= __d('admin', 'Used to display the Group Premium intead of the real group.') ?>
							</span>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('Parent Group', __d('admin', 'Parent Group'), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5 radio-check">
							<?= $this->Form->select('parent', $parents,
								[
									'legend' => false,
									'class' => 'form-control'
								]
							) ?>
							<span>
								<?= __d('admin', 'Used to display the Group Premium intead of the real group.') ?>
							</span>
						</div>
					</div>

					<?= $this->Form->button(__d('admin', 'Create Group'), ['class' => 'col-md-offset-2 btn btn-primary']) ?>
					<?= $this->Form->end() ?>

				</div>

			</div>
		</div>


	</div>
</div>
