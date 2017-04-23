<?= $this->element('meta', [
    'title' => __("Blog Category : {0}", h($category->title))
]) ?>

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
                    <?= h($category->title) ?>
                </li>
            </ol>
            <?= $this->Flash->render() ?>
        </div>
    </div>

    <div class="row">
        <main class="col-md-9" role="main">
            <?php if ($articles->toArray()) : ?>
                <section class="blog-main">
                    <?php foreach ($articles as $article) : ?>
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
                                    <?= $this->Html->link(
                                        $article->title,
                                        [
                                            '_name' => 'blog-article',
                                            'slug' => $article->title,
                                            'id' => $article->id,
                                            '?' => ['page' => $article->last_page]
                                        ]
                                    ) ?>
                                </h2>
                            </header>

                            <aside class="meta">
                                <ul>
                                    <li class="author">
                                        <i class="fa fa-user"></i>
                                        <?= $this->Html->link(
                                            $article->user->full_name,
                                            [
                                                '_name' => 'users-profile',
                                                'slug' => $article->user->username,
                                                'id' => $article->user->id
                                            ]
                                        ) ?>
                                    </li>
                                    <li class="comments">
                                        <i class="fa fa-comment"></i>
                                        <?= __n('{0} Comment', '{0} Comments', $article->comment_count_format, $article->comment_count_format) ?>
                                    </li>
                                    <li class="likes">
                                        <i class="fa fa-heart"></i>
                                        <?= __n('{0} Like', '{0} Likes', $article->like_count_format, $article->like_count_format) ?>
                                    </li>
                                    <?php if (!is_null($article->poll)) : ?>
                                        <li class="poll">
                                            <i class="fa fa-bar-chart" data-toggle="tooltip" title="<?= __('This article has a poll') ?>"></i>
                                        </li>
                                    <?php endif; ?>

                                    <?php if (!is_null($article->blog_attachment)) : ?>
                                        <li class="attachment">
                                            <i class="fa fa-cloud-download" data-toggle="tooltip" title="<?= __('This article has an attachment') ?>"></i>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </aside>

                            <div class="content">
                                <?= $this->Text->truncate(
                                    $article->content_empty,
                                    200,
                                    [
                                        'ellipsis' => '...',
                                        'exact' => false
                                    ]
                                ) ?>
                            </div>

                            <p>
                                <?= $this->Html->link(
                                    __('{0} Read More', '<i class="fa fa-eye"></i>'),
                                    [
                                        '_name' => 'blog-article',
                                        'slug' => $article->title,
                                        'id' => $article->id,
                                        '?' => ['page' => $article->last_page]
                                    ],
                                    ['class' => 'btn btn-primary-outline', 'escape' => false]
                                ) ?>
                            </p>
                        </article>
                    <?php endforeach; ?>
                </section>

                <?= $this->element('pagination') ?>

            <?php else : ?>
                <div class="infobox infobox-primary">
                    <h4><?= __("No articles found"); ?></h4>
                    <p>
                        <?= __("No articles were found for this category."); ?>
                    </p>
                </div>
            <?php endif; ?>
        </main>

        <?= $this->cell('Blog::sidebar') ?>

    </div>
</div>
