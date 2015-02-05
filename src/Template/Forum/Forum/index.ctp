<?php
use Cake\Utility\Inflector;
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<ul class="nav navbar-nav foldres" style="float: none;text-align: center;margin-top: 20px;">
				<li style="float: none;display: inline-block;"><a href="#">Discussions</a></li>
				<li style="float: none;display: inline-block;"><a href="#">Categories</a></li>
				<li style="float: none;display: inline-block;"><a href="#">Activity</a></li>
				<li style="float: none;display: inline-block;"><a href="#">Purchase</a></li>
			</ul>
		</div>
	</div>
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
