<?= $this->element('meta', [
	'title' => __('New Thread')
]) ?>
<?php $this->start('scriptBottom');

	echo $this->Html->script([
		'ckeditor/ckeditor'
	])
?>
	<script type="text/javascript">
		CKEDITOR.replace('postBox', {
			customConfig: 'config/forum.js'
		});
	</script>
<?php $this->end() ?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__("Home"), '/') ?>
				</li>
				<li>
					<?= $this->Html->link(__("Forum"), ['action' => 'index']) ?>
				</li>
				<?php foreach ($breadcrumbs as $breadcrumb): ?>
					<li>
						<?= $this->Html->link(
							$breadcrumb->title,
							[
								'_name' => 'forum-categories',
								'id' => $breadcrumb->id,
								'slug' => $breadcrumb->title
							]
						) ?>
					</li>
				<?php endforeach; ?>
				<li class="active">
					<?= __('New Thread') ?>
				</li>
			</ol>
			<?= $this->Flash->render('badge') ?>
			<?= $this->Flash->render() ?>
		</div>
	</div>

	<div class="row">

		<div class="col-md-10">
			<main role="main" class="main">
				<section class="section threadCreate">
					<h3 class="title text-center">
						<?= __("Create a new Thread") ?>
					</h3>

					<?= $this->Form->create($thread, [
						'class' => 'form-horizontal',
						'role' => 'form'
					]) ?>
						<div class="form-group">
							<?= $this->Form->label('title', __('Thread Title'), ['class' => 'col-sm-2 control-label']) ?>
							<div class="col-sm-6">
								<?= $this->Form->input('title', ['class' => 'form-control', 'label' => false, 'placeholder' => __('Title...')]) ?>
							</div>
						</div>
						<?php if ($this->Acl->check(['_name' => 'threads-edit', 'id' => $thread->id, 'slug' => $thread->title, 'prefix' => 'forum'])): ?>
							<div class="form-group">
								<?= $this->Form->label('sticky', __('Sticky Thread'), ['class' => 'col-sm-2 control-label']) ?>
								<div class="col-sm-8 radio-check">
									<?= $this->Form->radio('sticky', [
											'1' => __('Yes'),
											'0' => __('No')
										],
										[
											'value' => '0',
											'legend' => false,
											'class' => 'form-control'
										]
									) ?>
								</div>
							</div>
							<div class="form-group">
								<?= $this->Form->label('thread_open', __('Lock Thread'), ['class' => 'col-sm-2 control-label']) ?>
								<div class="col-sm-8 radio-check">
									<?= $this->Form->radio('thread_open', [
											'0' => __('Yes'),
											'1' => __('No')
										],
										[
											'value' => '1',
											'legend' => false,
											'class' => 'form-control'
										]
									) ?>
								</div>
							</div>
						<?php endif; ?>
						<div class="form-group">
							<?= $this->Form->label('message', __('Message'), ['class' => 'col-sm-2 control-label']) ?>
							<div class="col-sm-9">
								<?=
								$this->Form->textarea(
									'message', [
										'label' => false,
										'class' => 'form-control postBox',
										'id' => 'postBox'
									]
								) ?>
							</div>
						</div>
						<div class="form-group">
							<?= $this->Form->button(__('{0} Create Thread', '<i class="fa fa-plus"></i>'), ['class' => 'col-sm-offset-2 btn btn-primary', 'escape' => false]); ?>
							<?= $this->Form->button(__('{0} Save Draft', '<i class="fa fa-save"></i>'), ['class' => 'btn btn-primary', 'escape' => false]); ?>
							<?= $this->Html->link(__('{0} Cancel', '<i class="fa fa-remove"></i>'), '#', ['class' => 'btn btn-danger', 'escape' => false]); ?>
						</div>
					<?= $this->Form->end(); ?>

				</section>
			</main>
		</div>

		<div class="col-md-2">
			<?= $this->cell('Forum::sidebar') ?>
		</div>

	</div>
</div>
