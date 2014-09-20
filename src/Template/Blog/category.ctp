<div class="container">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__("Home"), '/') ?>
				</li>
				<li>
					<?= $this->Html->link(__("Blog"), ['action' => 'index']) ?>
				</li>
				<li>
					<?= $this->Html->link(__("Category"), ['action' => 'index']) ?>
				</li>
				<li class="active">
					<?= h($Category->title) ?>
				</li>
			</ol>
			<?= $this->Flash->render() ?>
		</div>
	</div>

	<div class="row">
		<main class="col-md-9" role="main">
			<section class="blog-main">
				<?php foreach ($Articles as $Article): ?>
					<article class="post">

						<div class="date">
							<time>
								<div class="day">
									<?= h($Article->created->format('d')) ?>
								</div>
								<div class="month">
									<?= h($Article->created->format('M')) ?>
								</div>
							</time>
						</div>

						<header>
							<h2 class="title">
								<?= $this->Html->link(
									$Article->title, [
										'_name' => 'blog-article',
										'slug' => $Article->slug,
										'?' => ['page' => $Article->last_page]
									]
								) ?>
							</h2>
						</header>

						<aside class="meta">
							<ul>
								<li class="author">
									<i class="fa fa-user"></i>
									<?= $this->Html->link(
										$Article->user->full_name, [
											'_name' => 'users-profile',
											'slug' => $Article->user->slug
										]
									) ?>
								</li>
								<li class="comments">
									<i class="fa fa-comment"></i>
									<?= h($Article->comment_count_format) ?>
									<?= ($Article->comment_count > 1) ? __("Comments") : __("Comment") ?>
								</li>
								<li class="likes">
									<i class="fa fa-heart"></i>
									<?= h($Article->like_count_format) ?>
									<?= ($Article->like_count > 1) ? __("Likes") : __("Like") ?>
								</li>
							</ul>
						</aside>

						<div class="content">
							<?=
							$this->Text->truncate(
								$Article->content_empty,
								200,
								array(
									'ellipsis' => '...',
									'exact' => false
								)
							);?>
						</div>

						<p>
							<?= $this->Html->link(
								__('Read More'),
								[
									'_name' => 'blog-article',
									'slug' => $Article->slug,
									'?' => ['page' => $Article->last_page]
								],
								['class' => 'btn btn-primary']
							) ?>
						</p>
					</article>
				<?php endforeach; ?>
			</section>

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
		</main>

		<?= $this->cell('Blog::sidebar') ?>

	</div>
</div>
