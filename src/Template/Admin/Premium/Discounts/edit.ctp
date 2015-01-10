<?= $this->assign('title', __d('admin', 'Edit a Discount')) ?>

<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Flash->render() ?>
		</div>

		<div class="col-md-12 heading">
			<h1 class="page-header">
				<i class="fa fa-edit"></i> <?= __d('admin', 'Edit a Discount') ?>
			</h1>
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__d('admin', '{0} Premium', '<i class="fa fa-trophy"></i>'), ['controller' => 'premium',
					'action' => 'home', 'prefix' => 'admin/premium'], ['escape' => false]) ?>
				</li>
				<li>
					<?= $this->Html->link(__d('admin', '{0} Manage Discount', '<i class="fa fa-gift"></i>'), ['controller' => 'discounts',
					'action' => 'index', 'prefix' => 'admin/premium'], ['escape' => false]) ?>
				</li>
				<li class="active">
					<i class="fa fa-edit"></i> <?= __d('admin', 'Edit a Discount') ?>
				</li>
			</ol>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<?= __d('admin', 'Edit a Discount') ?>
				</div>

				<div class="panel-body">
					<?= $this->Form->create($discount, [
						'class' => 'form-horizontal',
						'role' => 'form'
					]) ?>
					<div class="form-group">
						<?= $this->Form->label('premium_offer_id', __d('admin', 'Offer'), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('premium_offer_id', ['options' => $offers, 'class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('code', __d('admin', 'Code'), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('code', ['class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('discount', __d('admin', 'Discount (%)'), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('discount', ['class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('used', __d('admin', 'Used'), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('used', ['class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('max_use', __d('admin', 'Max Use'), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('max_use', ['class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>

					<?= $this->Form->button(__d('admin', 'Edit Discount'), ['class' => 'col-md-offset-2 btn btn-primary']) ?>
					<?= $this->Form->end() ?>

				</div>

			</div>
		</div>

	</div>
</div>
