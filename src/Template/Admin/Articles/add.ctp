<?= $this->assign('title', __d('admin', 'Add an Article')) ?>

<?php $this->start('scriptBottom');

echo $this->Html->script('ckeditor/ckeditor') ?>
<script type="text/javascript">
	CKEDITOR.replace('articleBox', {
		customConfig: 'config/article.js'
	});
</script>

<?php $this->end() ?>

<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Flash->render(); ?>
		</div>

		<div class="col-md-12 heading">
			<h1 class="page-header">
				<i class="fa fa-newspaper-o"></i> <?= __d('admin', 'Add an Article') ?>
			</h1>
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__d('admin', '{0} Dashboard', '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
							'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
				</li>
				<li>
					<?= $this->Html->link(__d('admin', '{0} Manage Articles', '<i class="fa fa-newspaper-o"></i>'), ['controller' => 'articles',
							'action' => 'index', 'prefix' => 'admin'], ['escape' => false]) ?>
				</li>
				<li class="active">
					<i class="fa fa-plus"></i> <?= __d('admin', 'Add an Article') ?>
				</li>
			</ol>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<?= __d('admin', 'Add an Article') ?>
				</div>

				<div class="panel-body">
					<?= $this->Form->create($article, [
						'class' => 'form-horizontal',
						'role' => 'form'
					]) ?>
					<div class="form-group">
						<?= $this->Form->label('title', __d('admin', 'Title'), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('title', ['class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('category_id', __d('admin', 'Category'), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5">
							<?= $this->Form->input('category_id', ['options' => $categories, 'class' => 'form-control', 'label' => false]) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('is_display', __d('admin', 'Is display'), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-5 radio-check">
							<?= $this->Form->radio('is_display', [
									'1' => __d('admin', 'Yes'),
									'0' => __d('admin', 'No')
								],
								[
									'value' => '1',
									'legend' => false,
									'class' => 'form-control'
								]
							) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->label('content', __d('admin', 'Content'), ['class' => 'col-sm-2 control-label']) ?>
						<div class="col-sm-8">
							<?= $this->Form->input(
									'content', [
										'label' => false,
										'class' => 'form-control articleBox',
										'id' => 'articleBox'
									]
								) ?>
						</div>
					</div>

					<?= $this->Form->button(__d('admin', 'Create Article'), ['class' => 'col-md-offset-2 btn btn-primary']) ?>
					<?= $this->Form->end() ?>

				</div>

			</div>
		</div>


	</div>
</div>
