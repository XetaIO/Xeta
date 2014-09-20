<div class="container">
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__("Home"), '/') ?>
				</li>
				<li class="active">
					<?= __("Blog") ?>
				</li>
			</ol>
			<?= $this->Flash->render() ?>
		</div>
	</div>
	<div class="row">
		<main class="col-md-9" role="main">

			<section class="blog-main">
				<?php foreach ($blogArticles as $blogArticle): ?>
					<article class="post">

						<div class="date">
							<time>
								<div class="day">
									<?= h($blogArticle->created->format('d')) ?>
								</div>
								<div class="month">
									<?= h($blogArticle->created->format('M')) ?>
								</div>
							</time>
						</div>

						<header>
							<h2 class="title">
								<?= $this->Html->link(
									$blogArticle->title, [
										'_name' => 'blog-article',
										'slug' => $blogArticle->slug,
										'?' => ['page' => $blogArticle->last_page]
									]
								) ?>
							</h2>
						</header>

						<aside class="meta">
							<ul>
								<li class="author">
									<i class="fa fa-user"></i>
									<?php if (!empty($blogArticle->user->full_name)): ?>
										<?=
										$this->Html->link(
											$blogArticle->user->full_name,
											[
												'_name' => 'users-profile',
												'slug' => $blogArticle->user->slug
											]
										) ?>
									<?php else: ?>
										<?=
										$this->Html->link(
											$blogArticle->user->username,
											[
												'_name' => 'users-profile',
												'slug' => $blogArticle->user->slug
											]
										) ?>
									<?php endif; ?>
								</li>
								<li class="categories">
									<i class="fa fa-tag"></i>
									<?=
									$this->Html->link(
										$blogArticle->blog_category->title,
										[
											'_name' => 'blog-category',
											'slug' => $blogArticle->blog_category->slug
										]
									) ?>
								</li>
								<li class="comments">
									<i class="fa fa-comment"></i>
									<?= h($blogArticle->comment_count_format) ?>
									<?= ($blogArticle->comment_count > 1) ? __("Comments") : __("Comment") ?>
								</li>
								<li class="likes">
									<i class="fa fa-heart"></i>
									<?= h($blogArticle->like_count_format) ?>
									<?= ($blogArticle->like_count > 1) ? __("Likes") : __("Like") ?>
								</li>
							</ul>
						</aside>

						<div class="content">
							<?=
							$this->Text->truncate(
								$blogArticle->content_empty,
								200,
								array(
									'ellipsis' => '...',
									'exact' => false
								)
							) ?>
						</div>
						<p>
							<?=
							$this->Html->link(
								__('Read More'),
								[
									'_name' => 'blog-article',
									'slug' => $blogArticle->slug,
									'?' => ['page' => $blogArticle->last_page]
								],
								['class' => 'btn btn-primary']
							);?>
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
