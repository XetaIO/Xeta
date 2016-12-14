<?= $this->element('meta', [
    'title' => $article->title,
    'description' => $article->content_meta,
    'author' => $article->user->full_name
]) ?>

<?php $this->start('scriptBottom');

    echo $this->Html->script([
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

            <?= $this->element('Blog/polls', [
                'poll' => $article->poll,
                'article' => $article,
                'hasVoted' => $hasVoted
            ]) ?>

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
                                        'slug' => $article->blog_category->title,
                                        'id' => $article->blog_category->id
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

                    <?php if (!is_null($article->blog_attachment)) : ?>
                            <div class="attachmentFiles">
                                <div class="attachment">
                                    <div class="attachmentThumbnail">
                                        <?= $this->Html->link(
                                            '<i class="fa fa-cloud-download fa-2x"></i>',
                                            [
                                                '_name' => 'attachment-download',
                                                'type' => 'blog',
                                                'id' => $article->blog_attachment->id
                                            ],
                                            [
                                                'class' => 'attachmentThumb',
                                                'escape' => false
                                            ]
                                        ) ?>
                                    </div>
                                    <div class="attachmentInfo">
                                        <h6 class="attachmentName">
                                            <?= $this->Html->link($article->blog_attachment->name, [
                                                '_name' => 'attachment-download',
                                                'type' => 'blog',
                                                'id' => $article->blog_attachment->id
                                            ]) ?>
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
                            <?php if ($this->request->session()->read('Auth.User')) : ?>
                                <?= $this->Html->link(__("{0} Reply", '<i class="fa fa-reply"></i>'), '#comment-form', ['escape' => false]) ?>
                            <?php else : ?>
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
                            <?php if ($this->request->session()->read('Auth.User')) : ?>
                                <?php if (isset($like)) : ?>
                                    <?= $this->Html->link(
                                        '<i class="fa fa-thumbs-o-up text-primary"></i>',
                                        '#',
                                        [
                                            'class' => 'ArticleLike',
                                            'data-url' => $this->Url->build([
                                                'action' => 'articleUnlike',
                                                $article->id
                                            ]),
                                            'data-type' => 'unlike',
                                            'data-toggle' => 'tooltip',
                                            'title' => __('You {0} this article.', "<i class='fa fa-heart text-danger'></i>"),
                                            'escape' => false
                                        ]
                                    ) ?>
                                <?php else : ?>
                                    <?= $this->Html->link(
                                        '<i class="fa fa-thumbs-o-up"></i>',
                                        '#',
                                        [
                                            'class' => 'ArticleLike',
                                            'data-url' => $this->Url->build([
                                                'action' => 'articleLike',
                                                $article->id
                                            ]),
                                            'data-type' => 'like',
                                            'data-toggle' => 'tooltip',
                                            'title' => __('Like {0}', "<i class='fa fa-heart text-danger'></i>"),
                                            'escape' => false
                                        ]
                                    ) ?>
                                <?php endif; ?>
                            <?php else : ?>
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
                                    'slug' => $article->user->username,
                                    'id' => $article->user->id
                                ]
                            ) ?>
                        </h3>

                        <?php if ($article->user->signature) : ?>
                            <div class="signature">
                                <?= $article->user->signature ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($article->user->facebook || $article->user->twitter) : ?>
                            <ul class="social">
                                <?php if ($article->user->facebook) : ?>
                                    <li>
                                        <?= $this->Html->link(
                                            '<i class="fa fa-facebook"></i>',
                                            "http://facebook.com/" . h($article->user->facebook),
                                            [
                                                'target' => '_blank',
                                                'escape' => false
                                            ]
                                        ) ?>
                                    </li>
                                <?php endif; ?>

                                <?php if ($article->user->twitter) : ?>
                                    <li>
                                        <?= $this->Html->link(
                                            '<i class="fa fa-twitter"></i>',
                                            "http://twitter.com/" . h($article->user->twitter),
                                            [
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

            <?php if ($articles->toArray()) : ?>
                <section class="related-posts">
                    <div id="accordion-related-posts" class="panel-group">
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <h2 class="panel-title">
                                    <a class="panel-toggle" data-toggle="collapse" data-parent="#accordion-related-posts" href="#content-related-posts">
                                        <span><?= __("Related Articles") ?></span>
                                    </a>
                                </h2>
                            </div>

                            <div id="content-related-posts" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div id="owl-related-posts" class="owl-carousel owl-item-gap">

                                        <?php foreach ($articles as $post) : ?>
                                            <div class="item">
                                                <figure>
                                                    <figcaption>
                                                        <div class="info">
                                                            <h4>
                                                                <?= $this->Html->link(
                                                                    $this->Text->truncate(
                                                                        $post->title,
                                                                        30,
                                                                        [
                                                                            'ellipsis' => '...',
                                                                            'exact' => false
                                                                        ]
                                                                    ),
                                                                    [
                                                                        '_name' => 'blog-article',
                                                                        'slug' => $post->title,
                                                                        'id' => $post->id,
                                                                        '?' => ['page' => $post->last_page]
                                                                    ]
                                                                ) ?>
                                                            </h4>
                                                            <p>
                                                                <?= $this->Text->truncate(
                                                                    $post->content_empty,
                                                                    150,
                                                                    [
                                                                        'ellipsis' => '...',
                                                                        'exact' => false
                                                                    ]
                                                                ) ?>
                                                            </p>
                                                        </div>
                                                        <div class="meta">
                                                            <ul>
                                                                <li>
                                                                    <i class="fa fa-tag"></i>
                                                                    <?= $this->Html->link(
                                                                        h($post->blog_category->title),
                                                                        [
                                                                            '_name' => 'blog-category',
                                                                            'slug' => $post->blog_category->title,
                                                                            'id' => $post->blog_category->id
                                                                        ]
                                                                    ) ?>
                                                                </li>
                                                                <li>
                                                                    <i class="fa fa-comment"></i>
                                                                    <?= h($post->comment_count_format) ?>
                                                                </li>
                                                                <li>
                                                                    <i class="fa fa-heart"></i>
                                                                    <?= h($post->like_count_format) ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <?= $this->Html->link(
                                                            __("Read More {0}", '<i class="fa fa-arrow-right"></i>'),
                                                            [
                                                                '_name' => 'blog-article',
                                                                'slug' => $post->title,
                                                                'id' => $post->id,
                                                                '?' => ['page' => $post->last_page]
                                                            ],
                                                            [
                                                                'class' => 'btn btn-primary-outline',
                                                                'escape' => false
                                                            ]
                                                        ) ?>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                        <?php endforeach;?>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ($article->comment_count) : ?>
                <section class="post-comments">
                    <h2>
                        <?= __n('{0} Comment', '{0} Comments', $article->comment_count_format, $article->comment_count_format) ?>
                    </h2>
                    <ol class="comments-list">

                        <?php foreach ($comments as $comment) : ?>
                            <li class="comment" id="comment-<?= $comment->id ?>">

                                <?= $this->Html->link(
                                    $this->Html->image($comment->user->avatar, ['alt' => $comment->user->full_name]),
                                    [
                                        '_name' => 'users-profile',
                                        'slug' => $comment->user->username,
                                        'id' => $comment->user->id
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
                                                $comment->user->full_name,
                                                [
                                                    '_name' => 'users-profile',
                                                    'slug' => $comment->user->username,
                                                    'id' => $comment->user->id
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
                                            <?php if ($this->request->session()->read('Auth.User')) : ?>
                                                <?= $this->Html->link(
                                                    __("{0} Quote", '<i class="fa fa-reply"></i>'),
                                                    '#',
                                                    [
                                                        'class' => 'ReplyQuote',
                                                        'data-url' => $this->Url->build([
                                                            'action' => 'quote',
                                                            $article->id,
                                                            $comment->id
                                                        ]),
                                                        'escape' => false
                                                    ]
                                                ) ?>
                                            <?php else : ?>
                                                <?= $this->Html->link(
                                                    __("{0} Quote", '<i class="fa fa-reply"></i>'),
                                                    [
                                                        'controller' => 'users',
                                                        'action' => 'login'
                                                    ],
                                                    ['escape' => false]
                                                ) ?>
                                            <?php endif; ?>
                                        </li>

                                        <?php if (($this->Acl->check(['controller' => 'blog', 'action' => 'editComment', 'id' => $comment->id]) &&
                                             $this->request->session()->read('Auth.User.id') == $comment->user_id) ||
                                            (!is_null($currentUser) && $currentUser->group->is_staff)) : ?>
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
                                        <?php endif; ?>

                                        <?php if (($this->Acl->check(['controller' => 'blog', 'action' => 'deleteComment', 'id' => $comment->id]) &&
                                             $this->request->session()->read('Auth.User.id') == $comment->user_id) ||
                                            (!is_null($currentUser) && $currentUser->group->is_staff)) : ?>
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

                <?= $this->element('pagination') ?>

            <?php endif; ?>

            <?php if ($this->request->session()->read('Auth.User')) : ?>
                <section class="section post-comment-form" id="comment-form">
                    <div class="hr-divider">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __("Leave a Comment") ?>
                        </h3>
                    </div>

                    <?= $this->Form->create($formComments) ?>
                    <div class="form-group">
                        <?=
                        $this->Form->input(
                            'content',
                            [
                                'label' => false,
                                'class' => 'form-control commentBox',
                                'id' => 'commentBox'
                            ]
                        ) ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->button(__('{0} Post Comment', '<i class="fa fa-pencil"></i>'), ['class' => 'btn btn-primary-outline', 'escape' => false]); ?>
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
            <div class="modal-actions">
                <?= $this->Html->link(__("{0} Delete", '<i class="fa fa-trash-o"></i>'), '#', ['class' => 'ma ma-btn ma-btn-danger btnDeleteComment', 'escape' => false]) ?>
                <button type="button" class="ma ma-btn ma-btn-primary" data-dismiss="modal"><?= __('{0} Close', '<i class="fa fa-remove"></i>') ?></button>
            </div>
        </div>
    </div>
</div>
