<?php
use Cake\Utility\Inflector;
?>
<section class="page-section">
	<div class="row text-center">
		<div class="col-md-3 col-sm-6">
			<div class="panel panel-forum" style="min-height: 170px;">
				<div class="panel-heading">
					<?=__('Statistics') ?>
				</div>
				<div class="panel-body">
					<?= __n('There are {0} user on this page.', 'There are {0} users on this page.', $online, $online) ?>
				</div>
			</div>
		</div>
		<?php if (!empty($suggestions)): ?>
			<?php foreach ($suggestions as $suggestion): ?>
				<div class="col-md-3 col-sm-6">
					<div class="panel panel-suggestions">
						<div class="blog-meta">
						<time datetime="<?= $suggestion->created->format('d-m-Y') ?>" class="entry-date">
							<span class="day">
								<?= $suggestion->created->i18nFormat('d'); ?>
							</span>
							<span class="month">
								<?= ucfirst($suggestion->created->i18nFormat('MMM')); ?>
							</span>
						</time>
						</div>
						<div class="title">
							<header class="entry-header">
								<h6 class="inverse-font">
									<?=
									$this->Html->link(
										$this->Text->truncate(
											$suggestion->title,
											40,
											[
												'ellipsis' => '...',
												'exact' => false
											]
										),
										[
											'_name' => 'forum-threads',
											'id' => $suggestion->id,
											'slug' => Inflector::slug($suggestion->title, '-')
										]
									) ?>
								</h6>
								<div class="entry-meta">
									<span class="jp-views">
										<?= __('- By {0}', $this->Html->link($suggestion->first_post->user->username, ['_name' => 'users-profile', 'slug' => $suggestion->first_post->user->slug, 'id' => $suggestion->first_post->user->id, 'prefix' => false], ['style' => h($suggestion->first_post->user->group->css)])) ?>
									</span>
								</div>
							</header>
						</div>
						<div class="content-post">
							<p>
								<?=
								$this->Text->truncate(
									$suggestion->first_post->message_empty,
									80,
									[
										'ellipsis' => '...',
										'exact' => false
									]
								) ?>
							</p>
						</div>
						<div class="panel-bottom">
							<?= $this->Html->link(
								__('Read More'),
								[
									'_name' => 'forum-threads',
									'id' => $suggestion->id,
									'slug' => Inflector::slug($suggestion->title, '-')
								]
							) ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>

	</div>
</section>
