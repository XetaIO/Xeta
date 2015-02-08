<?php
use Cake\Utility\Inflector;

?>
<?= $this->element('meta', [
	'title' => __('Forum')
]) ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__("Home"), '/') ?>
				</li>
				<li class="active">
					<?= __("Forum") ?>
				</li>
			</ol>
			<?= $this->Flash->render('badge') ?>
			<?= $this->Flash->render() ?>
		</div>
	</div>

	<div class="row">

		<div class="col-md-10">
			<main role="main" class="main">
				<?php foreach ($categories as $category): ?>
					<?= $this->element('forum\categories', [
						'category' => $category,
						'forums' => $category->children
					]) ?>
				<?php endforeach; ?>

				<?= $this->element('Forum\Index\statistics', [
					'statistics' => $statistics
				]) ?>
			</main>
		</div>

		<div class="col-md-2">
			<?= $this->cell('Forum::sidebar') ?>
		</div>

	</div>
</div>
