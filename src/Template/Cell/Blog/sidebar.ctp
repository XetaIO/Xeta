<div class="col-md-3">
    <div class="sidebox widget">
        <h4><?= __("Search Posts") ?></h4>

	    <?= $this->Form->create($ArticleSearch,
			[
				'action' => 'search',
				'class' => 'navbar-form search',
				'role' => 'search'
			]
		) ?>
	        <?= $this->Form->input('search', ['type' => 'search', 'label' => false, 'class' => 'form-control',
					'placeholder' => __("Type your search...")]) ?>
	        <?= $this->Form->button('<i class="fa fa-arrow-right"></i>', ['class' => 'btn btn-primary btn-submit', 'escape' => false]) ?>
	    <?= $this->Form->end();?>
    </div>

    <?php if($Featured):?>
        <div class="sidebox widget">
            <h4><?= __("Featured Article") ?></h4>

            <div class="featured">
	            <h4 class="title">
		            <?= $this->Html->link(
						$this->Text->truncate(
							$Featured->title,
							60,
							[
								'ellipsis' => '...',
								'exact' => false
							]
						),
						[
							'_name' => 'blog-article',
							'slug' => $Featured->slug,
							'?' => ['page' => $Featured->last_page]
						]
					) ?>
	            </h4>

	            <ul class="meta">
		            <li class="author">
			            <i class="fa fa-user"></i>
				            <?= $this->Html->link($Featured->user->full_name, ['_name' => 'users-profile', 'slug' => $Featured->user->slug]) ?>
		            </li>
		            <li class="date">
			            <i class="fa fa-calendar"></i>
			            <?= h($Featured->created->format('d M')) ?>
		            </li>
	            </ul>
            </div>
        </div>
    <?php endif; ?>

    <?php if($Categories): ?>
        <div class="sidebox widget">
            <h4><?= __("Categories") ?></h4>

            <ul class="circled">
                <?php foreach($Categories as $Category): ?>
                    <li>
                        <?= $this->Html->link( h($Category->title) . " (" . $Category->article_count_format . ")", ['_name' => 'blog-category', 'slug' => $Category->slug]) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

	<?php if($Archives): ?>
		<div class="sidebox widget">
			<h4><?= __("Archives") ?></h4>

			<ul class="circled">
				<?php foreach($Archives as $Archive): ?>
					<li>
						<?= $this->Html->link(__("{0} ({1})", date('F Y', strtotime($Archive->date)), $this->Number->format($Archive->count, ['places' => 0, 'locale' => 'fr_FR'])), ['_name' => 'blog-archive', 'slug' => date('m-Y', strtotime($Archive->date))]) ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

</div>
