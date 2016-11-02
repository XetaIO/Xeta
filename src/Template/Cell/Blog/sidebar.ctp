<div class="col-md-3">
    <div class="sidebox widget">
        <h4><?= __("Search Posts") ?></h4>

        <?= $this->Form->create(
            $articleSearch,
            [
                'url' => ['action' => 'search'],
                'class' => 'navbar-form search',
                'role' => 'search'
            ]
        ) ?>
            <?= $this->Form->input('search', ['type' => 'search', 'label' => false, 'class' => 'form-control',
                    'placeholder' => __("Type your search...")]) ?>
            <?= $this->Form->button('<i class="fa fa-arrow-right"></i>', ['class' => 'btn btn-primary-outline btn-submit', 'escape' => false]) ?>
        <?= $this->Form->end();?>
    </div>

    <?php if ($featured) : ?>
        <div class="sidebox widget">
            <h4><?= __("Featured Article") ?></h4>

            <div class="featured">
                <h4 class="title">
                    <?= $this->Html->link(
                        $this->Text->truncate(
                            $featured->title,
                            60,
                            [
                                'ellipsis' => '...',
                                'exact' => false
                            ]
                        ),
                        [
                            '_name' => 'blog-article',
                            'slug' => $featured->title,
                            'id' => $featured->id,
                            '?' => ['page' => $featured->last_page]
                        ]
                    ) ?>
                </h4>

                <ul class="meta">
                    <li class="author">
                        <i class="fa fa-user"></i>
                            <?= $this->Html->link($featured->user->full_name, ['_name' => 'users-profile', 'slug' => $featured->user->username, 'id' => $featured->user->id]) ?>
                    </li>
                    <li class="date">
                        <i class="fa fa-calendar"></i>
                        <?= h($featured->created->format('d M')) ?>
                    </li>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($categories) : ?>
        <div class="sidebox widget">
            <h4><?= __("Categories") ?></h4>

            <ul class="circled">
                <?php foreach ($categories as $category) : ?>
                    <li>
                        <?= $this->Html->link($category->title . " (" . $category->article_count_format . ")", ['_name' => 'blog-category', 'slug' => $category->title, 'id' => $category->id]) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($archives) : ?>
        <div class="sidebox widget">
            <h4><?= __("Archives") ?></h4>

            <ul class="circled">
                <?php foreach ($archives as $archive) : ?>
                    <li>
                        <?= $this->Html->link(__("{0} ({1})", date('F Y', strtotime($archive->date)), $this->Number->format($archive->count, ['locale' => 'fr_FR'])), ['_name' => 'blog-archive', 'slug' => date('m-Y', strtotime($archive->date))]) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

</div>
