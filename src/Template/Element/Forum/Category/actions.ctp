<div class="threadActions">
	<?php if (
			$category->category_open == true &&
			$this->Acl->check(['_name' => 'threads-create', 'id' => $category->id, 'slug' => $category->title, 'prefix' => 'forum'])
	): ?>
		<?= $this->Html->link(
			__('{0} New Thread', '<i class="fa fa-plus"></i>'),
			['_name' => 'threads-create', 'id' => $category->id, 'slug' => $category->title],
			['class' => 'btn btn-xs btn-primary', 'escape' => false]
		) ?>
	<?php endif; ?>

	<div class="pull-right">
		<ul class="pagination pagination-sm">
			<?php if ($this->Paginator->hasPrev()): ?>
				<?= $this->Paginator->prev('«'); ?>
			<?php endif; ?>
			<?= $this->Paginator->numbers(['modulus' => 5]); ?>
			<?php if ($this->Paginator->hasNext()): ?>
				<?= $this->Paginator->next('»'); ?>
			<?php endif; ?>
		</ul>
	</div>
</div>
