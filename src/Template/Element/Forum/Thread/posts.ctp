<article role="article" id="post-<?= $post->id ?>">
    <div class="threadPost clearfix">
        <div class="threadUser">

            <div class="avatar">
                <?= $this->Html->link(
                    $this->Html->image($post->user->avatar, ['width' => '100', 'height' => '100']),
                    ['_name' => 'users-profile', 'slug' => $post->user->slug, 'prefix' => false],
                    ['escape' => false]
                ) ?>
                <span class="status">
                    <?php if ($post->user->online === true): ?>
                        <i class="fa fa-circle text-primary" data-toggle="tooltip" title="<?= __("Online") ?>"></i>
                    <?php else: ?>
                        <i class="fa fa-circle text-danger" data-toggle="tooltip" title="<?= __("Offline") ?>"></i>
                    <?php endif; ?>
                </span>
            </div>

            <span class="username">
                <?= $this->Html->link($post->user->full_name, ['_name' => 'users-profile', 'slug' => $post->user->slug, 'prefix' => false]) ?>
            </span>

            <span class="group" style="<?= h($post->user->group_css) ?>">
                <?= h($post->user->group_name) ?>
            </span>

            <span class="joinedDate">
                <?= __('Joined') ?><br>
                <?= $post->user->created->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE]) ?>
            </span>

            <span class="statistics">
                <dl>
                    <dt>
                        <i class="fa fa-comment-o" data-toggle="tooltip" title="<?= __('Messsages created') ?>"></i> <?= $post->user->forum_post_count ?>
                    </dt>
                </dl>
                <dl>
                    <dt>
                        <i class="fa fa-file-o" data-toggle="tooltip" title="<?= __('Threads created') ?>"></i> <?= $post->user->forum_thread_count ?>
                    </dt>
                </dl>
                <dl>
                    <dt>
                        <i class="fa fa-thumbs-o-up" data-toggle="tooltip" title="<?= __('Likes received') ?>"></i> <?= $post->user->forum_like_received ?>
                    </dt>
                </dl>
            </span>
            <?php if (!empty($post->user->badges_users)): ?>
                <div class="badges">
                    <?= __('Badges') ?>
                    <br>
                    <?php foreach ($post->user->badges_users as $badge): ?>
                        <?= $this->Html->image($badge->badge->picture, [
                            'data-toggle' => 'tooltip',
                            'title' => $badge->badge->name,
                            'width' => '50',
                            'height' => '50'
                        ]) ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="threadMessage">
            <?php if ($firstPost === true): ?>
                <h3 class="threadTitle text-center">
                    <?= h($thread->title) ?>
                </h3>
            <?php endif; ?>

            <div class="header">
                <span class="date">
                    <?= ucwords($post->created->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::MEDIUM])) ?>
                </span>

                <span class="messageId">
                    <?= $this->Html->link(
                    '#' . $post->id,
                    'javascript:void(0);',
                    [
                        'class' => 'text-primary',
                        'data-toggle' => 'popover',
                        'title' => __('Post Link'),
                        'data-html' => true,
                        'data-placement' => 'left',
                        'data-content' => '<input class="form-control" style="min-width:440px;" value="' . $this->Url->build([
                            'controller' => 'posts',
                            'action' => 'go',
                            $post->id], true) . '" />'
                    ]
                    ) ?>
                </span>
            </div>

            <div class="postActions">
                <?php if (($this->Acl->check(['_name' => 'posts-edit', 'id' => $post->id]) && $this->request->session()->read('Auth.User.id') == $post->user_id) || $currentUser->group->is_staff): ?>
                    <?= $this->Html->link(
                        __('{0} Edit', '<i class="fa fa-edit"></i>'),
                        '#',
                        [
                            'class' => 'btn btn-sm btn-primary editPost',
                            'data-url' => $this->Url->build([
                                'controller' => 'posts',
                                'action' => 'getEditPost',
                                'prefix' => 'forum'
                            ]),
                            'data-id' => $post->id,
                            'escape' => false
                        ]
                    ) ?>
                <?php endif; ?>

                <?php if ($firstPost === false): ?>
                    <?php if ($this->Acl->check(['_name' => 'posts-delete', 'id' => $post->id])): ?>
                        <?= $this->Html->link(__('{0} Delete', '<i class="fa fa-remove"></i>'), ['_name' => 'posts-delete', 'id' => $post->id], ['class' => 'btn btn-sm btn-danger', 'escape' => false]) ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="message">
                <?= $post->message ?>
            </div>

            <div class="bottom">

                <?php if ($post->edit_count): ?>
                    <div class="edited">
                        <?= __('{0} Last Edit: {1}, {2}',
                            '<i class="fa fa-pencil"></i>',
                            $this->Html->link(
                                h($post->last_edit_user->username),
                                ['_name' => 'users-profile', 'slug' => $post->last_edit_user->slug, 'prefix' => false],
                                ['class' => 'text-primary', 'escape' => false]
                            ),
                            ucwords($post->last_edit_date->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::MEDIUM]))
                        ) ?>
                    </div>
                <?php endif; ?>

                <?php if (
                        $this->Acl->check(['_name' => 'posts-quote', 'id' => $post->id]) ||
                        $this->Acl->check(['controller' => 'posts', 'action' => 'like'])
                ): ?>
                    <div class="actions text-right">
                        <?php if ($this->Acl->check(['_name' => 'posts-quote', 'id' => $post->id])): ?>
                            <?= $this->Html->link(
                                __("{0} Quote", '<i class="fa fa-quote-left"></i>'),
                                '#',
                                [
                                    'class' => 'QuotePost btn btn-sm btn-link text-primary',
                                    'data-url' => $this->Url->build(
                                        [
                                            '_name' => 'posts-quote',
                                            'id' => $post->id
                                        ]
                                    ),
                                    'escape' => false
                                ]
                            ) ?>
                        <?php endif; ?>

                        <?php if ($this->Acl->check(['controller' => 'posts', 'action' => 'like'])): ?>
                            <span class="likeCounter-<?= $post->id ?>">
                                <?= h($post->like_count) ?>
                            </span>
                            <?php if (!empty($post->forum_posts_likes)): ?>
                                <?= $this->Html->link(
                                    __("{0} Like", '<i class="fa fa-thumbs-o-up"></i>'),
                                    '#',
                                    [
                                        'class' => 'LikePost btn btn-sm btn-link text-success',
                                        'data-id' => $post->id,
                                        'data-url' => $this->Url->build(
                                            [
                                                'controller' => 'posts',
                                                'action' => 'unlike'
                                            ]
                                        ),
                                        'data-type' => 'unlike',
                                        'data-toggle' => 'tooltip',
                                        'title' => __('You {0} this post.', "<i class='fa fa-heart text-danger'></i>"),
                                        'escape' => false
                                    ]
                                ) ?>
                            <?php else: ?>
                                <?= $this->Html->link(
                                    __("{0} Like", '<i class="fa fa-thumbs-o-up"></i>'),
                                    '#',
                                    [
                                        'class' => 'LikePost btn btn-sm btn-link text-primary',
                                        'data-id' => $post->id,
                                        'data-url' => $this->Url->build(
                                            [
                                                'controller' => 'posts',
                                                'action' => 'like'
                                            ]
                                        ),
                                        'data-type' => 'like',
                                        'data-toggle' => 'tooltip',
                                        'title' => __('Like {0}', "<i class='fa fa-heart text-danger'></i>"),
                                        'escape' => false
                                    ]
                                ) ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($post->user->signature)): ?>
                    <div class="signature">
                        <?= $post->user->signature ?>
                    </div>
                <?php endif; ?>

            </div>

        </div>

    </div>
</article>

<?php if ($firstPost === true): ?>
    <article role="ads">
        <div class="panel threadAds">
            <div class="panel-heading">
                <h4>
                    <?= __('Advertising') ?>
                </h4>
            </div>
            <div class="panel-body">
                <?= $this->Html->image('http://lorempixel.com/980/90/') ?>
            </div>
        </div>
    </article>
<?php endif; ?>
