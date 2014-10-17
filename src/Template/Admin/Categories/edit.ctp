<?= $this->assign('title', __("Edit a Category")); ?>

<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Session->flash(); ?>
		</div>

		<div class="col-md-12 heading">
			<h1 class="page-header">
				<i class="fa fa-tag"></i> <?= __("Edit a Category");?>
			</h1>
			<ol class="breadcrumb">
				<li>
					<?= $this->html->link(__("{0} Dashboard", '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
							'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
				</li>
				<li>
					<?= $this->html->link(__("{0} Manage Categories", '<i class="fa fa-tag"></i>'), ['controller' => 'categories',
							'action' => 'index', 'prefix' => 'admin'], ['escape' => false]) ?>
				</li>
				<li class="active">
					<i class="fa fa-edit"></i> <?= __("Edit a Category");?>
				</li>
			</ol>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<?= __("Edit a Category"); ?>
				</div>

				<div class="panel-body">
					<?= $this->Form->create($category, [
						'class' => 'form-horizontal',
						'role' => 'form'
					]) ?>
					<div class="form-group">
						<?= $this->Form->label('title', __("Title"), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('title', ['class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('description', __("Description"), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('description', ['type' => 'textarea', 'class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>

					<?= $this->Form->button(__('Edit Category'), ['class' => 'col-md-offset-2 btn btn-primary']) ?>
					<?= $this->Form->end() ?>
					
				</div>

			</div>
		</div>


	</div>
</div>
