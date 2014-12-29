<?= $this->assign('title', __("Add a Discount")); ?>

<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Flash->render(); ?>
		</div>

		<div class="col-md-12 heading">
			<h1 class="page-header">
				<i class="fa fa-add"></i> <?= __("Add a Discount");?>
			</h1>
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__("{0} Premium", '<i class="fa fa-trophy"></i>'), ['controller' => 'premium',
					'action' => 'home', 'prefix' => 'admin/premium'], ['escape' => false]) ?>
				</li>
				<li>
					<?= $this->Html->link(__("{0} Manage Discounts", '<i class="fa fa-gift"></i>'), ['controller' => 'offers',
					'action' => 'index', 'prefix' => 'admin/premium'], ['escape' => false]) ?>
				</li>
				<li class="active">
					<i class="fa fa-plus"></i> <?= __("Add a Discount");?>
				</li>
			</ol>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<?= __("Add a Discount"); ?>
				</div>

				<div class="panel-body">
					<?= $this->Form->create($discount, [
						'class' => 'form-horizontal',
						'role' => 'form'
					]) ?>
					<div class="form-group">
						<?= $this->Form->label('premium_offer_id', __("Offer"), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('premium_offer_id', ['options' => $offers, 'class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('code', __("Code"), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('code', ['class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('discount', __("Discount (%)"), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('discount', ['class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('used', __("Used"), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('used', ['class' => 'form-control', 'label' => false, 'value' => 0]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('max_use', __("Max Use"), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('max_use', ['class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>

					<?= $this->Form->button(__('Create Discount'), ['class' => 'col-md-offset-2 btn btn-primary']) ?>
					<?= $this->Form->end() ?>

				</div>

			</div>
		</div>


	</div>
</div>
