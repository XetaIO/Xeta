<?= $this->element('meta', [
    'title' => __("{0}'s profile", h($user->username))
]) ?>

<div class="profile-container">
    <div class="profile-header">
        <div class="background-container">
            <?= $this->Html->image(h($user->background_profile), ['class' => 'background']) ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="profile-information text-center">
                    <ul class="list-inline">
                        <li>
                            <?= $this->Html->image($user->avatar, ['class' => 'img-circle img-border', 'alt' => h($user->username)]) ?>
                            <span class="status">
                                <?php if ($user->online === true) : ?>
                                    <i class="online" data-toggle="tooltip" title="<?= __("Online") ?>" data-container="body"></i>
                                    <small class="online"><?= __("Online") ?></small>
                                <?php else : ?>
                                    <i data-toggle="tooltip" title="<?= __("Offline") ?>" data-container="body"></i>
                                    <small><?= __("Offline") ?></small>
                                <?php endif; ?>
                            </span>
                            <h2 class="username">
                                <?= h($user->username) ?>
                            </h2>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-header-navbar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="statistics list-inline pull-left">
                        <li>
                            <span class="text"><?= __("Comments") ?></span>
                            <span class="number"><?= $this->Number->format($user->blog_articles_comment_count, ['locale' => 'fr_FR']) ?></span>
                        </li>
                    </ul>

                    <ul class="socials list-inline pull-right">
                        <?php if ($user->facebook) : ?>
                            <li>
                                <?= $this->Html->link('<i class="fa fa-facebook fa-2x"></i>', 'http://facebook.com/' . h($user->facebook), ['class' => 'text-primary', 'target' => '_blank', 'escape' => false, 'data-toggle' => 'tooltip', 'data-container' => 'body', 'data-placement' => 'top', 'title' => 'http://facebook.com/' . h($user->facebook)]) ?>
                            </li>
                        <?php endif; ?>
                        <?php if ($user->twitter) : ?>
                            <li>
                                <?= $this->Html->link('<i class="fa fa-twitter fa-2x"></i>', 'http://twitter.com/' . h($user->twitter), ['class' => 'text-primary', 'target' => '_blank', 'escape' => false, 'data-toggle' => 'tooltip', 'data-container' => 'body', 'data-placement' => 'top', 'title' => 'http://twitter.com/' . h($user->twitter)]) ?>
                            </li>
                        <?php endif; ?>

                        <?php if ($user->id == $this->request->session()->read('Auth.User.id')) : ?>
                            <li style="padding: 9px">
                                <?= $this->Html->link(__("{0} Edit my profile", '<i class="fa fa-edit"></i>'), ['action' => 'account'], ['class' => 'btn btn-primary-outline', 'escape' => false]) ?>
                            </li>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__("Home"), '/') ?>
                </li>
                <li>
                    <?= $this->Html->link(__("Users"), ['action' => 'index']) ?>
                </li>
                <li class="active">
                    <?= h($user->username) ?>
                </li>
            </ol>
            <?= $this->Flash->render() ?>
        </div>
    </div>
    <div class="row profile">
        <div class="col-md-3">
            <section class="sidebar-profile section">
                <div class="avatar">
                    <?= $this->Html->image($user->avatar, ['width' => '120', 'height' => '120']) ?>
                    <span class="status hidden-sm hidden-md hidden-lg">
                        <?php if ($user->online === true) : ?>
                            <i class="online" data-toggle="tooltip" title="<?= __("Online") ?>" data-container="body"></i>
                            <small class="online"><?= __("Online") ?></small>
                        <?php else : ?>
                            <i data-toggle="tooltip" title="<?= __("Offline") ?>" data-container="body"></i>
                            <small><?= __("Offline") ?></small>
                        <?php endif; ?>
                    </span>
                </div>
                <h4>
                    <?= h($user->full_name) ?>
                </h4>

                <span class="group" style="<?= h($user->group->css) ?>">
                    <?= $this->Html->link($user->group->name, ['_name' => 'groups-view', 'slug' => $user->group->name, 'id' => $user->group->id]) ?>
                </span>

                <span class="joinedDate">
                    <?= __('Joined') ?><br>
                    <?= ucwords($user->created->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE])) ?>
                </span>

                <?php if ($this->request->session()->read('Auth.User.id') != $user->id) : ?>
                    <span class="sendMessage">
                        <?= $this->Html->link(__('Send a Message'), ['controller' => 'conversations', 'action' => 'create', 'prefix' => false, '?' => ['r' => h($user->username) . ',']], ['class' => 'text-primary', 'escape' => false]) ?>
                    </span>
                <?php endif; ?>

                <ul class="social">
                    <?php if ($user->facebook) : ?>
                        <li>
                            <?= $this->Html->link('<i class="fa fa-facebook"></i>', 'http://facebook.com/' . h($user->facebook), ['target' => '_blank', 'escape' => false]) ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($user->twitter) : ?>
                        <li>
                            <?= $this->Html->link('<i class="fa fa-twitter"></i>', 'http://twitter.com/' . h($user->twitter), ['target' => '_blank', 'escape' => false]) ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </section>
        </div>

        <div class="col-md-9">
            <section class="section">
                <?php if ($this->Acl->check(['controller' => 'users', 'action' => 'index', 'prefix' => 'admin'])) : ?>
                    <?= $this->Html->link(
                        __("{0} Edit this User", '<i class="fa fa-edit"></i>'),
                        [
                            '_name' => 'users-edit',
                            'slug' => $user->username,
                            'id' => $user->id,
                            'prefix' => 'admin'
                        ],
                        ['class' => 'btn btn-primary-outline btn-sm pull-right', 'escape' => false]
                    ) ?>
                <?php endif; ?>

                <div class="hr-divider">
                    <h3 class="hr-divider-content hr-divider-heading">
                        <?php if ($user->id == $this->request->session()->read('Auth.User.id')) : ?>
                            <?= __("Your Biography") ?>
                        <?php else : ?>
                            <?= __("His Biography") ?>
                        <?php endif;?>
                    </h3>
                </div>

                <div class="biography">
                    <?php if (!empty($user->biography)) : ?>
                        <?= $user->biography ?>
                    <?php else : ?>
                        <?php if ($user->id == $this->request->session()->read('Auth.User.id')) : ?>
                            <?= __("You don't have set a biography.") ?>
                            <?= $this->Html->link(__("{0} Add one now", '<i class="fa fa-plus"></i>'), ['action' => 'account'], ['class' => 'btn btn-sm btn-primary-outline', 'escape' => false]) ?>
                        <?php else : ?>
                            <?= __("This user hasn't set a biography yet.") ?>
                        <?php endif;?>
                    <?php endif; ?>
                </div>

                <?php if (!empty($user->badges_users)) : ?>
                    <div class="hr-divider">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?php if ($user->id == $this->request->session()->read('Auth.User.id')) : ?>
                                <?= __("Your Badges") ?>
                            <?php else : ?>
                                <?= __("His Badges") ?>
                            <?php endif;?>
                        </h3>
                    </div>
                    <div class="badges">
                        <?php foreach ($user->badges_users as $badge) : ?>
                            <div class="thumbnail">
                                <?= $this->Html->image($badge->badge->picture, [
                                    'alt' => h($badge->badge->name),
                                    'title' => h($badge->badge->name),
                                    'data-toggle' => 'tooltip'
                                ]) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($user->blog_articles)) : ?>
                    <div class="hr-divider">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?php if ($user->id == $this->request->session()->read('Auth.User.id')) : ?>
                                <?= __("Your Lastest Articles in the Blog") ?>
                            <?php else : ?>
                                <?= __("His Lastest Articles in the Blog") ?>
                            <?php endif; ?>
                        </h3>
                    </div>
                    <table class="table table-striped table-profile">
                        <tbody>
                            <?php foreach ($user->blog_articles as $article) : ?>
                                <tr>
                                    <td>
                                        <?= $this->Html->image($user->avatar, ['class' => 'img-thumbnail avatar']) ?>
                                        <?= $this->Html->link(
                                            $article->title,
                                            ['_name' => 'blog-article', 'slug' => $article->title, 'id' => $article->id],
                                            ['class' => 'title text-primary']
                                        ) ?>
                                        <br>
                                        <?= $this->Text->truncate(
                                            $article->content_empty,
                                            275,
                                            [
                                                'ellipsis' => '...',
                                                'exact' => false
                                            ]
                                        ) ?>
                                        <br>
                                        <?= __('Created at {0}', $article->created->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT])) ?>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                <?php endif; ?>

                <?php if (!empty($user->blog_articles_comments)) : ?>
                    <div class="hr-divider">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?php if ($user->id == $this->request->session()->read('Auth.User.id')) : ?>
                                <?= __("Your Lastest Comments in the Blog") ?>
                            <?php else : ?>
                                <?= __("His Lastest Comments in the Blog") ?>
                            <?php endif;?>
                        </h3>
                    </div>
                    <table class="table table-striped table-profile">
                        <tbody>
                            <?php foreach ($user->blog_articles_comments as $comment) : ?>
                                <tr>
                                    <td>
                                        <?= $this->Html->image($user->avatar, ['class' => 'img-thumbnail avatar']) ?>
                                        <?= $this->Html->link(
                                            $comment->blog_article->title,
                                            ['controller' => 'blog', 'action' => 'go', $comment->id],
                                            ['class' => 'title text-primary']
                                        ) ?>
                                        <br>
                                        <?= $this->Text->truncate(
                                            $comment->content_empty,
                                            275,
                                            [
                                                'ellipsis' => '...',
                                                'exact' => false
                                            ]
                                        ) ?>
                                        <br>
                                        <?= __('Created at {0}', $comment->created->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT])) ?>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>
