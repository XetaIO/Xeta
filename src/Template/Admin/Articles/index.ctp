<?= $this->assign('title', __("Manage Articles")); ?>

<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Flash->render(); ?>
		</div>

		<div class="col-md-12 heading">
			<h1 class="page-header">
				<i class="fa fa-newspaper-o"></i> <?= __("Manage Articles");?>
			</h1>
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__("{0} Dashboard", '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
							'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
				</li>
				<li class="active">
					<i class="fa fa-newspaper-o"></i> <?= __("Manage Articles");?>
				</li>
			</ol>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<?= __("Manage Articles"); ?>
				</div>

				<div class="panel-body">

					<div class="panel-body-header">
						<?= $this->Html->link(__("{0} New Article", '<i class="fa fa-plus"></i>'),
							['controller' => 'articles', 'action' => 'add', 'prefix' => 'admin'],
							['class' => 'btn btn-primary', 'escape' => false]) ?>
					</div>

					<?php if($articles->toArray()): ?>
						<table class="table table-striped">
							<thead>
								<tr>
									<th><?= __('#Id') ?></th>
									<th><?= __('Author') ?></th>
									<th><?= __('Title') ?></th>
									<th><?= __('Category') ?></th>
									<th><?= __('Is display') ?></th>
									<th><?= __('Created') ?></th>
									<th><?= __('Action') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($articles as $article):?>
									<tr>
										<td>
											#<?= $article->id ?>
										</td>
										<td>
											<?= $this->Html->link($article->user->full_name, ['_name' => 'users-edit',
													'slug' => $article->user->slug]) ?>
										</td>
										<td>
											<?= $this->Html->link(
												$this->Text->truncate(
													$article->title,
													35,
													[
														'ellipsis' => '...',
														'exact' => false
													]
												),
												[
													'_name' => 'blog-article',
													'prefix' => false,
													'slug' => $article->slug,
													'?' => ['page' => $article->last_page]
												],
												[
													'target' => '_blank',
													'data-toggle' => 'tooltip',
													'title' => __("View this Article"),
												]
											) ?>
										</td>
										<td>
											<?= $this->Html->link($article->blog_category->title, ['_name' => 'categories-edit',
													'slug' => $article->user->slug]) ?>
										</td>
										<td>
											<?php if($article->is_display): ?>
												<span class="label label-success">
													<?= __("Yes") ?>
												</span>
											<?php else: ?>
												<span class="label label-danger">
													<?= __("No") ?>
												</span>
											<?php endif; ?>
										</td>
										<td>
											<?= $article->created->format('d-m-Y') ?>
										</td>
										<td>
											<?= $this->Html->link(
												'<i class="fa fa-edit"></i>',
												[
													'_name' => 'articles-edit',
													'slug' => $article->slug
												],
												[
													'class' => 'btn btn-sm btn-primary',
													'data-toggle' => 'tooltip',
													'title' => __("Edit this article"),
													'escape' => false
												]
											)?>
											<?= $this->Html->link(
												'<i class="fa fa-remove"></i>',
												[
													'_name' => 'articles-delete',
													'slug' => $article->slug
												],
												[
													'class' => 'btn btn-sm btn-danger',
													'data-toggle' => 'tooltip',
													'title' => __("Delete this article"),
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
								<?= __("No articles was found."); ?>
							</h4>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</div>


	</div>
</div>
