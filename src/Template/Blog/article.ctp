<?php $this->start('scriptBottom');

echo $this->Html->script('ckeditor/ckeditor') ?>
<script type="text/javascript">
	CKEDITOR.replace('commentBox', {
		customConfig: 'config/comment.js'
	});
</script>

<?php $this->end() ?>

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
				<li class="active">
					<?= h($Article->title) ?>
				</li>
			</ol>
			<?= $this->Flash->render() ?>
		</div>
	</div>

	<div class="row">
		<main class="col-md-9" role="main">

			<section class="blog-main">
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
							<?= h($Article->title) ?>
						</h2>
					</header>

					<aside class="meta">
						<ul>
							<li class="categories">
								<i class="fa fa-tag"></i>
								<?= $this->Html->link(
									$Article->blog_category->title, [
										'_name' => 'blog-category',
										'slug' => $Article->blog_category->slug
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
						<?= $Article->content; ?>
					</div>

					<ul class="actions">
						<li class="reply">
							<?php if ($this->Session->read('Auth.User')): ?>
								<?= $this->Html->link(__("{0} Reply", '<i class="fa fa-reply"></i>'), '#comment-form', ['escape' => false]) ?>
							<?php else: ?>
								<?= $this->Html->link(
									__("{0} Reply", '<i class="fa fa-reply"></i>'),
									[
										'controller' => 'users',
										'action' => 'login'
									],
									['escape' => false]
								) ?>
							<?php endif; ?>
						</li>
						<li class="like-count">
							<?= h($Article->like_count_format) ?>
						</li>
						<li class="like">
							<?php if ($this->Session->read('Auth.User')): ?>
								<?php if(isset($Like)): ?>
									<?= $this->Html->link(
										'<i class="fa fa-thumbs-o-up text-primary"></i>',
										'#',
										[
											'class' => 'ArticleLike',
											'data-url' => $this->Url->build(
													[
														'action' => 'ArticleUnlike',
														$Article->id
													]
												),
											'data-type' => 'unlike',
											'data-toggle' => 'tooltip',
											'title' => __('You {0} this article.', "<i class='fa fa-heart text-danger'></i>"),
											'escape' => false
										]
									) ?>
								<?php else: ?>
									<?= $this->Html->link(
										'<i class="fa fa-thumbs-o-up"></i>',
										'#',
										[
											'class' => 'ArticleLike',
											'data-url' => $this->Url->build(
													[
														'action' => 'ArticleLike',
														$Article->id
													]
												),
											'data-type' => 'like',
											'data-toggle' => 'tooltip',
											'title' => __('Like {0}', "<i class='fa fa-heart text-danger'></i>"),
											'escape' => false
										]
									) ?>
								<?php endif; ?>
							<?php else: ?>
								<?= $this->Html->link(
									'<i class="fa fa-thumbs-o-up"></i>',
									[
										'controller' => 'users',
										'action' => 'login'
									],
									['escape' => false]
								) ?>
							<?php endif; ?>
						</li>
					</ul>
				</article>
			</section>

			<section class="post-author">
				<figure>
					<div class="image">
						<?= $this->Html->image($Article->user->avatar, ['alt' => $Article->user->full_name]) ?>
					</div>
					<figcaption class="details">
						<h3>
							<?= $this->Html->link(
								$Article->user->full_name,
								[
									'_name' => 'users-profile',
									'slug' => $Article->user->slug
								]
							) ?>
						</h3>

						<?php if ($Article->user->signature): ?>
							<div class="signature">
								<?= $Article->user->signature ?>
							</div>
						<?php endif; ?>

						<?php if ($Article->user->facebook || $Article->user->twitter): ?>
							<ul class="social">
								<?php if ($Article->user->facebook): ?>
									<li>
										<?= $this->Html->link(
											'<i class="fa fa-facebook"></i>', "http://facebook.com/" . h($Article->user->facebook), [
												'target' => '_blank',
												'escape' => false
											]
										) ?>
									</li>
								<?php endif; ?>

								<?php if ($Article->user->twitter): ?>
									<li>
										<?= $this->Html->link(
											'<i class="fa fa-twitter"></i>', "http://twitter.com/" . h($Article->user->twitter), [
												'target' => '_blank',
												'escape' => false
											]
										) ?>
									</li>
								<?php endif; ?>
							</ul>
						<?php endif; ?>
					</figcaption>
				</figure>
			</section>

			<?php if ($Article->comment_count): ?>
				<section class="post-comments">
					<h2>
						<?= h($Article->comment_count_format) ?>
						<?= ($Article->comment_count > 1) ? __("Comments") : __("Comment") ?>
					</h2>
					<ol class="comments-list">

						<?php foreach ($Comments as $Comment): ?>
							<li class="comment" id="comment-<?= $Comment->id ?>">

								<?= $this->Html->link(
									$this->Html->image($Comment->user->avatar, ['alt' => $Comment->user->full_name]),
									[
										'_name' => 'users-profile',
										'slug' => $Comment->user->slug
									],
									[
										'class' => 'avatar',
										'escape' => false
									]
								) ?>

								<div class="body">
									<div class="meta">
										<h3 class="author">
											<?= $this->Html->link(
												$Comment->user->full_name, [
													'_name' => 'users-profile',
													'slug' => $Comment->user->slug
												]
											) ?>
										</h3>
										<time class="date">
											<?= $Comment->created->format('d-m-Y') ?>
										</time>
									</div>
									<div class="content">
										<?= $Comment->content; ?>
									</div>
									<ul class="actions">
										<li>
											<?php if ($this->Session->read('Auth.User')): ?>
												<?=
												$this->Html->link(
													__("{0} Reply", '<i class="fa fa-reply"></i>'),
													'#',
													[
														'class' => 'ReplyQuote',
														'data-url' => $this->Url->build(
																[
																	'action' => 'quote',
																	$Article->id,
																	$Comment->id
																]
															),
														'escape' => false
													]
												) ?>
											<?php else: ?>
												<?= $this->Html->link(
													__("{0} Reply", '<i class="fa fa-reply"></i>'),
													[
														'controller' => 'users',
														'action' => 'login'
													],
													['escape' => false]
												) ?>
											<?php endif; ?>
										</li>
									</ul>
								</div>
							</li>
						<?php endforeach; ?>

					</ol>
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
			<?php endif; ?>

			<?php if ($this->Session->read('Auth.User')): ?>
				<section class="post-comment-form" id="comment-form">
					<h2>
						<?= __("Leave a Comment") ?>
					</h2>
					<?= $this->Form->create($FormComments) ?>
					<div class="form-group">
						<?=
						$this->Form->input(
							'content', [
								'label' => false,
								'class' => 'form-control commentBox',
								'id' => 'commentBox'
							]
						) ?>
					</div>
					<div class="form-group">
						<?= $this->Form->submit(__('Post Comment'), ['class' => 'btn btn-primary']); ?>
					</div>
					<?= $this->Form->end(); ?>
				</section>
			<?php endif; ?>
		</main>

		<?= $this->cell('Blog::sidebar') ?>

	</div>
</div>
