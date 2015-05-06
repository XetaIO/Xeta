<?= $this->element('meta', [
    'title' => __("Blog Search : {0}", h($keyword))
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
                <li class="active">
                    <?= __("Search : {0}", h($keyword)) ?>
                </li>
            </ol>
            <?= $this->Flash->render() ?>
        </div>
    </div>

    <div class="row">
        <main class="col-md-9" role="main">
            <?php if ($articles->toArray()): ?>
                <section class="blog-main">
                    <?php foreach ($articles as $article): ?>
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
                                        $article->title, [
                                            '_name' => 'blog-article',
                                            'slug' => $article->slug,
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
                                            $article->user->full_name, [
                                                '_name' => 'users-profile',
                                                'slug' => $article->user->slug,
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
                                </ul>
                            </aside>

                            <div class="content">
                                <?=
                                $this->Text->truncate(
                                    $article->content_empty,
                                    200,
                                    array(
                                        'ellipsis' => '...',
                                        'exact' => false
                                    )
                                );?>
                            </div>

                            <p>
                                <?= $this->Html->link(
                                    __('Read More'),
                                    [
                                        '_name' => 'blog-article',
                                        'slug' => $article->slug,
                                        'id' => $article->id,
                                        '?' => ['page' => $article->last_page]
                                    ],
                                    ['class' => 'btn btn-primary']
                                ) ?>
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

            <?php else: ?>
                <div class="infobox infobox-info">
                    <h4><?= __("No results found"); ?></h4>
                    <p>
                        <?= __("No articles were found for your search, please try again with a different word."); ?>
                    </p>
                    <?= __("Suggestions :"); ?>
                    <ul>
                        <li>
                            <?= __("Check the spelling of your search words."); ?>
                        </li>
                        <li>
                            <?= __("Try more general keywords."); ?>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </main>

        <?= $this->cell('Blog::sidebar') ?>

    </div>
</div>
