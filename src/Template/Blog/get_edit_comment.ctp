<?= $this->Flash->render() ?>
<?php if (isset($comment)): ?>
	<?= $this->Form->create($comment, [
		'url' => ['action' => 'editComment']
	]) ?>
	<div class="form-group">
		<?=
		$this->Form->input(
			'content', [
				'label' => false,
				'class' => 'form-control commentBox',
				'id' => 'commentBox-' . $comment->id
			]
		) ?>
	</div>
	<div class="form-group">
		<?= $this->Form->submit(__('Update Comment'), ['class' => 'btn btn-sm btn-primary']); ?>
	</div>
	<?= $this->Form->end(); ?>
<?php endif;
