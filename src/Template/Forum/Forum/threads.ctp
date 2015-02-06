<?php
use Cake\Utility\Inflector;

?>
<?= $this->element('meta', [
	'title' => $thread->title,
	'description' => $thread->message_meta,
	'author' => $thread->first_post->user->full_name
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
								'slug' => strtolower(Inflector::slug($breadcrumb->title, '-'))
							]
						) ?>
					</li>
				<?php endforeach; ?>
				<li class="active">
					<?= h($thread->title) ?>
				</li>
			</ol>
			<?= $this->Flash->render('badge') ?>
			<?= $this->Flash->render() ?>
		</div>

		<div class="col-md-10">
			<main role="main" class="main">
				<!-- Actions -->
				<?= $this->element('Forum\Thread\actions', [
					'thread' => $thread
				]) ?>

				<!-- Polls -->
				<?= $this->element('Forum\Thread\polls') ?>

				<!-- First Post -->
				<?= $this->element('Forum\Thread\posts', [
					'thread' => $thread,
					'post' => $thread->first_post,
					'firstPost' => true
				]); ?>

				<!-- All Posts -->
				<?php if (!empty($posts)): ?>
					<?php foreach ($posts as $post): ?>
						<?= $this->element('Forum\Thread\posts', [
							'post' => $post,
							'thread' => $thread,
							'firstPost' => false
						]); ?>
					<?php endforeach; ?>
				<?php endif; ?>

				<!-- Actions -->
				<?= $this->element('Forum\Thread\actions', [
					'thread' => $thread
				]) ?>

				<!-- Reply -->
				<?= $this->element('Forum\Thread\reply', [
					'thread' => $thread
				]) ?>

				<!-- Suggestions -->
				<?= $this->cell('Forum::suggestion') ?>

			</main>
		</div>

		<div class="col-md-2">
			<!-- Sidebar -->
			<?= $this->cell('Forum::sidebar') ?>
		</div>

	</div>
</div>
