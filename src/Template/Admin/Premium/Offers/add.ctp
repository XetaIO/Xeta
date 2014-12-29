<?= $this->assign('title', __("Add an Offer")); ?>

<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Flash->render(); ?>
		</div>

		<div class="col-md-12 heading">
			<h1 class="page-header">
				<i class="fa fa-add"></i> <?= __("Add an Offer");?>
			</h1>
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__("{0} Premium", '<i class="fa fa-trophy"></i>'), ['controller' => 'premium',
					'action' => 'home', 'prefix' => 'admin/premium'], ['escape' => false]) ?>
				</li>
				<li>
					<?= $this->Html->link(__("{0} Manage Offers", '<i class="fa fa-barcode"></i>'), ['controller' => 'offers',
					'action' => 'index', 'prefix' => 'admin/premium'], ['escape' => false]) ?>
				</li>
				<li class="active">
					<i class="fa fa-plus"></i> <?= __("Add an Offer");?>
				</li>
			</ol>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<?= __("Add an Offer"); ?>
				</div>

				<div class="panel-body">
					<?= $this->Form->create($offer, [
						'class' => 'form-horizontal',
						'role' => 'form'
					]) ?>
					<div class="form-group">
						<?= $this->Form->label('period', __("Period (Month)"), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('period', ['class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('price', __("Price (Excl VAT)"), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('price', ['class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('tax', __("Tax (%)"), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('tax', ['class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('currency_code', __("Currency Code"), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('currency_code', ['class' => 'form-control', 'label' => false, 'value' => 'EUR']) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('currency_symbol', __("Currency Symbol"), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('currency_symbol', ['class' => 'form-control', 'label' => false, 'value' => '€']) ?>
						</div>
					</div>

					<?= $this->Form->button(__('Create Offer'), ['class' => 'col-md-offset-2 btn btn-primary']) ?>
					<?= $this->Form->end() ?>

				</div>

			</div>
		</div>


	</div>
</div>
