<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Session->flash(); ?>
		</div>

		<div class="col-md-12 heading">
			<h1 class="page-header">
				<i class="fa fa-tag"></i> <?= __("Manage Categories");?>
			</h1>
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__("{0} Dashboard", '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
							'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
				</li>
				<li class="active">
					<i class="fa fa-tag"></i> <?= __("Manage Categories");?>
				</li>
			</ol>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<?= __("Manage Categories"); ?>
				</div>

				<div class="panel-body">

					<div class="panel-body-header">
						<?= $this->Html->link(__("{0} New Category", '<i class="fa fa-plus"></i>'),
							['controller' => 'categories', 'action' => 'add', 'prefix' => 'admin'],
							['class' => 'btn btn-primary', 'escape' => false]) ?>
					</div>

					<?php if($categories->toArray()): ?>
						<table class="table table-striped">
							<thead>
								<tr>
									<th><?= __('#Id') ?></th>
									<th><?= __('Title') ?></th>
									<th><?= __('Description') ?></th>
									<th><?= __('Articles') ?></th>
									<th><?= __('Created') ?></th>
									<th><?= __('Action') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($categories as $category):?>
									<tr>
										<td>
											#<?= $category->id ?>
										</td>
										<td>
											<?= $this->Html->link(
												$this->Text->truncate(
													$category->title,
													35,
													[
														'ellipsis' => '...',
														'exact' => false
													]
												),
												[
													'_name' => 'blog-category',
													'prefix' => false,
													'slug' => $category->slug
												],
												[
													'target' => '_blank',
													'data-toggle' => 'tooltip',
													'title' => __("View this category and its articles"),
												]
											) ?>
										</td>
										<td>
											<?= $this->Text->truncate(
												h($category->description),
												55,
												[
													'ellipsis' => '...',
													'exact' => false
												]
											) ?>
										</td>
										<td>
											<?= $category->article_count_format ?>
										</td>
										<td>
											<?= $category->created->format('d-m-Y') ?>
										</td>
										<td>
											<?= $this->Html->link(
												'<i class="fa fa-edit"></i>',
												[
													'_name' => 'categories-edit',
													'slug' => $category->slug
												],
												[
													'class' => 'btn btn-sm btn-primary',
													'data-toggle' => 'tooltip',
													'title' => __("Edit this category"),
													'escape' => false
												]
											)?>
											<?= $this->Html->link(
												'<i class="fa fa-remove"></i>',
												[
													'_name' => 'categories-delete',
													'slug' => $category->slug
												],
												[
													'class' => 'btn btn-sm btn-danger',
													'data-toggle' => 'tooltip',
													'title' => __("Delete this category"),
													'escape' => false
												]
											)?>
										</td>
									</tr>
								<?php endforeach;?>
							</tbody>
						</table>
						
						<div class="pagination-centered">
							<ul class="pagination">
								<?php if ($this->Paginator->hasPrev()): ?>
									<?= $this->Paginator->prev('«'); ?>
								<?php endif; ?>
								<?= $this->Paginator->numbers(['modulus' => 5]); ?>
								<?php if ($this->Paginator->hasNext()): ?>
									<?= $this->Paginator->next('»'); ?>
								<?php endif; ?>
							</ul>
						</div>
					<?php else: ?>
						<div class="infobox infobox-info">
							<h4>
								<?= __("No categories was found."); ?>
							</h4>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</div>

	</div>
</div>
