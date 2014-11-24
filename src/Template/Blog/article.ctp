<?= $this->element('meta', [
	'title' => $article->title,
	'description' => $article->content_meta,
	'author' => $article->user->full_name
]) ?>

<?php $this->start('scriptBottom');

	echo $this->Html->script([
		'moment.min',
		'livestamp.min',
		'ckeditor/ckeditor'
	])
?>
	<script type="text/javascript">
		CKEDITOR.replace('commentBox', {
			customConfig: 'config/comment.js'
		});
		
		moment.lang('<?= \Cake\I18n\I18n::locale() ?>');
	</script>

	<script>
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	
	<script>
	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
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
					<?= h($article->title) ?>
				</li>
			</ol>
			<?= $this->Flash->render('badge') ?>
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
								<?= h($article->created->format('d')) ?>
							</div>
							<div class="month">
								<?= h($article->created->format('M')) ?>
							</div>
						</time>
					</div>

					<header>
						<h2 class="title">
							<?= h($article->title) ?>
						</h2>
					</header>

					<aside class="meta">
						<ul>
							<li class="categories">
								<i class="fa fa-tag"></i>
								<?= $this->Html->link(
									$article->blog_category->title, [
										'_name' => 'blog-category',
										'slug' => $article->blog_category->slug
									]
								) ?>
							</li>
							<li class="comments">
								<i class="fa fa-comment"></i>
								<?= h($article->comment_count_format) ?>
								<?= ($article->comment_count > 1) ? __("Comments") : __("Comment") ?>
							</li>
							<li class="likes">
								<i class="fa fa-heart"></i>
								<?= h($article->like_count_format) ?>
								<?= ($article->like_count > 1) ? __("Likes") : __("Like") ?>
							</li>
							<li class="facebook">
								<div class="fb-share-button" data-layout="button_count"></div>
							</li>
							<li class="twitter">
								<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
							</li>
						</ul>
					</aside>

					<div class="content">
						<?= $article->content; ?>
					</div>
					
					<?php if (!is_null($article->blog_attachment)): ?>
						<?php if(!$this->request->session()->read('Auth.User.premium')): ?>
							<div class="infobox infobox-info">
								<?= __("You need to be <strong>{0}</strong> to download the file.", $this->Html->link(__('Premium'),['controller' => 'premium'])) ?>
							</div>
						<?php endif; ?>
							<div class="attachmentFiles">
								<div class="attachment">
									<div class="attachmentThumbnail">
										<?php if($this->request->session()->read('Auth.User.premium')): ?>
											<?= $this->Html->link(
												'<i class="fa fa-cloud-download fa-2x"></i>',
												[
													'controller' => 'attachments',
													'action' => 'download',
													$article->blog_attachment->id
												],
												[
													'class' => 'attachmentThumb',
													'escape' => false
												]
											) ?>
										<?php else: ?>
											<?= $this->Html->link(
												'<i class="fa fa-cloud-download fa-2x"></i>',
												[
													'controller' => 'premium'
												],
												[
													'class' => 'attachmentThumb',
													'escape' => false
												]
											) ?>
										<?php endif; ?>
									</div>
									<div class="attachmentInfo">
										<h6 class="attachmentName">
											<?php if($this->request->session()->read('Auth.User.premium')): ?>
												<?= $this->Html->link($article->blog_attachment->name, [
													'controller' => 'attachments',
													'action' => 'download',
													$article->blog_attachment->id
												]) ?>
											<?php else: ?>
												<?= $this->Html->link($article->blog_attachment->name, [
													'controller' => 'premium'
												]) ?>
											<?php endif; ?>
										</h6>
										<dl>
											<dt>
												<?= __("File Size :") ?>
											</dt>
											<dd>
												<?= $this->Number->toReadableSize($article->blog_attachment->size) ?>
											</dd>
										</dl>
										<dl>
											<dt>
												<?= __("Download :") ?>
											</dt>
											<dd>
												<?= $article->blog_attachment->download ?>
											</dd>
										</dl>
									</div>
								</div>
							</div>
					<?php endif; ?>

					<ul class="actions">
						<li class="reply">
							<?php if ($this->request->session()->read('Auth.User')): ?>
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
							<?= h($article->like_count_format) ?>
						</li>
						<li class="like">
							<?php if ($this->request->session()->read('Auth.User')): ?>
								<?php if(isset($like)): ?>
									<?= $this->Html->link(
										'<i class="fa fa-thumbs-o-up text-primary"></i>',
										'#',
										[
											'class' => 'ArticleLike',
											'data-url' => $this->Url->build(
													[
														'action' => 'ArticleUnlike',
														$article->id
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
														$article->id
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
						<?= $this->Html->image($article->user->avatar, ['alt' => $article->user->full_name]) ?>
					</div>
					<figcaption class="details">
						<h3>
							<?= $this->Html->link(
								$article->user->full_name,
								[
									'_name' => 'users-profile',
									'slug' => $article->user->slug
								]
							) ?>
						</h3>

						<?php if ($article->user->signature): ?>
							<div class="signature">
								<?= $article->user->signature ?>
							</div>
						<?php endif; ?>

						<?php if ($article->user->facebook || $article->user->twitter): ?>
							<ul class="social">
								<?php if ($article->user->facebook): ?>
									<li>
										<?= $this->Html->link(
											'<i class="fa fa-facebook"></i>', "http://facebook.com/" . h($article->user->facebook), [
												'target' => '_blank',
												'escape' => false
											]
										) ?>
									</li>
								<?php endif; ?>

								<?php if ($article->user->twitter): ?>
									<li>
										<?= $this->Html->link(
											'<i class="fa fa-twitter"></i>', "http://twitter.com/" . h($article->user->twitter), [
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

			<?php if ($article->comment_count): ?>
				<section class="post-comments">
					<h2>
						<?= h($article->comment_count_format) ?>
						<?= ($article->comment_count > 1) ? __("Comments") : __("Comment") ?>
					</h2>
					<ol class="comments-list">

						<?php foreach ($comments as $comment): ?>
							<li class="comment" id="comment-<?= $comment->id ?>">

								<?= $this->Html->link(
									$this->Html->image($comment->user->avatar, ['alt' => $comment->user->full_name]),
									[
										'_name' => 'users-profile',
										'slug' => $comment->user->slug
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
												$comment->user->full_name, [
													'_name' => 'users-profile',
													'slug' => $comment->user->slug
												]
											) ?>
										</h3>
										<time class="date" data-livestamp="<?= $comment->created->timestamp ?>">
											<?= $comment->created->format('d-m-Y') ?>
										</time>
									</div>
									<div class="content">
										<?= $comment->content; ?>
									</div>
									<ul class="actions">
										<li>
											<?php if ($this->request->session()->read('Auth.User')): ?>
												<?=
												$this->Html->link(
													__("{0} Reply", '<i class="fa fa-reply"></i>'),
													'#',
													[
														'class' => 'ReplyQuote',
														'data-url' => $this->Url->build(
																[
																	'action' => 'quote',
																	$article->id,
																	$comment->id
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
										<?php if ($this->request->session()->read('Auth.User.id') == $comment->user_id ||
										$this->request->session()->read('Auth.User.role') == 'admin'): ?>
											<li>
												<?= $this->Html->link(
													__("{0} Edit", '<i class="fa fa-edit"></i>'),
													'#',
													[
														'class' => 'editComment',
														'data-url' => $this->Url->build([
															'action' => 'getEditComment'
														]),
														'data-id' => $comment->id,
														'escape' => false
													]
												) ?>
											</li>
											<li>
												<?= $this->Html->link(
													__("{0} Delete", '<i class="fa fa-remove"></i>'),
													'#',
													[
														'class' => 'confirmDeleteComment',
														'data-url' => $this->Url->build([
															'action' => 'deleteComment',
															$comment->id
														]),
														'escape' => false
													]
												) ?>
											</li>
										<?php endif; ?>
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

			<?php if ($this->request->session()->read('Auth.User')): ?>
				<section class="post-comment-form" id="comment-form">
					<h2>
						<?= __("Leave a Comment") ?>
					</h2>
					<?= $this->Form->create($formComments) ?>
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
<div class="modal fade" id="modalDeleteComment" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
			<span aria-hidden="true">&times;</span>
			<span class="sr-only"><?= __("Close") ?></span>
		</button>
        <h4 class="modal-title"><?= __("Delete a Comment") ?></h4>
      </div>
      <div class="modal-body">
		<p>
			<?= __("Are you sure you want delete this comment ?") ?>
		</p>
      </div>
      <div class="modal-footer">
		<?= $this->Html->link(__("Delete"), '#', ['class' => 'btn btn-primary btnDeleteComment']) ?>
		<button type="button" class="btn btn-danger" data-dismiss="modal"><?= __("Close") ?></button>
      </div>
    </div>
  </div>
</div>
