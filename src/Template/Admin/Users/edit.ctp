<?= $this->assign('title', __d('admin', 'Edit an User')) ?>

<div class="profile">
    <div class="container-fluid">
        <div class="box-content text-center">

            <ul class="list-inline">
                <li>
                    <?= $this->Html->image(h($user->avatar), ['class' => 'img-circle img-border', 'alt' => h($user->username)]) ?>
                </li>
            </ul>

            <h1 class="username">
                <?= h($user->username) ?>
            </h1>

            <h3 class="full-name">
                <?= h($user->full_name) ?>
            </h3>

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="box-actions">
                        <div class="row">
                            <div class="col-md-7">
                                <ul class="list-inline no-margin text-center">
                                    <?php if ($user->facebook) : ?>
                                        <li class="text-center">
                                            <h4 class="base-header">
                                                <?= $this->Html->link('<i class="fa fa-facebook"></i>', 'http://facebook.com/' . h($user->facebook), ['escape' => false]) ?>
                                            </h4>
                                            <h5 class="base-header major">
                                                <?= h($user->facebook) ?>
                                            </h5>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($user->twitter) : ?>
                                        <li class="text-center">
                                            <h4 class="base-header">
                                                <?= $this->Html->link('<i class="fa fa-twitter"></i>', 'http://twitter.com/' . h($user->twitter), ['escape' => false]) ?>
                                            </h4>
                                            <h5 class="base-header major">
                                                <?= h($user->twitter) ?>
                                            </h5>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>

                            <div class="col-md-5">
                                <ul class="list-inline no-margin">
                                    <li class="text-center">
                                        <h4 class="base-header">
                                            <?= __d('admin', 'Comments') ?>
                                        </h4>
                                        <h5 class="base-header major">
                                            <?= $this->Number->format($user->blog_articles_comment_count, ['locale' => 'fr_FR']) ?>
                                        </h5>
                                    </li>
                                    <li class="text-center">
                                        <h4 class="base-header">
                                            <?= __d('admin', 'Articles') ?>
                                        </h4>
                                        <h5 class="base-header major">
                                            <?= $this->Number->format($user->blog_article_count, ['locale' => 'fr_FR']) ?>
                                        </h5>
                                    </li>
                                    <li class="text-center">
                                        <h4 class="base-header">
                                            <?= __d('admin', 'Group') ?>
                                        </h4>
                                        <h5 class="base-header major">
                                            <?= h(ucfirst($groups->toArray()[$user->group_id])) ?>
                                        </h5>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<div class="content-wrapper interface-blur">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render() ?>
        </div>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="hr-divider hr-divider-panel">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __d('admin', "{0}'s profile", h($user->username)); ?>
                        </h3>
                    </div>
                </div>

                <div class="panel-body account">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <h4>
                                <?= __d('admin', 'Avatar') ?>
                            </h4>
                            <ul class="list-inline">
                                <li>
                                    <?= $this->Html->image(h($user->avatar), ['class' => 'img-circle img-border', 'alt' => h($user->username)]) ?>
                                </li>
                            </ul>
                            <div class="delete-avatar">
                                <?= $this->Html->link(__d('admin', '{0} Delete Avatar', '<i class="fa fa-remove"></i>'), ['_name' => 'users-deleteAvatar', 'slug' => $user->username, 'id' => $user->id], ['class' => 'btn btn-danger-outline btn-sm', 'escape' => false]) ?>
                            </div>
                            <h5>
                                <?= __d('admin', 'Member since {0}', $this->Time->i18nFormat($user->created)) ?>
                            </h5>
                            <div class="delete-account">
                                <?= $this->Html->link(__d('admin', '{0} Delete Account', '<i class="fa fa-remove"></i>'), '#', ['class' => 'btn btn-danger-outline btn-sm', 'data-toggle' => 'modal', 'data-target' => '#modalDeleteAccount', 'escape' => false]) ?>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <?= $this->Form->create($user, [
                                'class' => 'form-horizontal',
                                'role' => 'form'
                            ]) ?>
                            <div class="form-group">
                                <?= $this->Form->label('username', __d('admin', 'Username'), ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-6">
                                    <?= $this->Form->input('username', ['class' => 'form-control', 'label' => false]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->label('first_name', __d('admin', 'First Name'), ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-6">
                                    <?= $this->Form->input('first_name', ['class' => 'form-control', 'label' => false]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->label('last_name', __d('admin', 'Last Name'), ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-6">
                                    <?= $this->Form->input('last_name', ['class' => 'form-control', 'label' => false]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->label('email', __d('admin', 'Email'), ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-6">
                                    <?= $this->Form->input('email', ['class' => 'form-control', 'label' => false]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->label('group_id', __d('admin', 'Group'), ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-6">
                                    <?= $this->Form->input('group_id', ['options' => $groups, 'class' => 'form-control', 'label' => false]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->label('facebook', __d('admin', 'Facebook'), ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-6">
                                    <?= $this->Form->input('facebook', ['class' => 'form-control', 'label' => false]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->label('twitter', __d('admin', 'Twitter'), ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-6">
                                    <?= $this->Form->input('twitter', ['class' => 'form-control', 'label' => false]) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->label(null, __d('admin', 'Last Login IP'), ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-6">
                                    <p class="form-control-static">
                                        <?= h($user->last_login_ip) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->label(null, __d('admin', 'Last Login'), ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-6">
                                    <p class="form-control-static">
                                        <?= $this->Time->i18nFormat($user->last_login); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->label(null, __d('admin', 'Register IP'), ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-6">
                                    <p class="form-control-static">
                                        <?= h($user->register_ip) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->label(null, __d('admin', 'Register'), ['class' => 'col-sm-2 control-label']) ?>
                                <div class="col-sm-6">
                                    <p class="form-control-static">
                                        <?= $this->Time->i18nFormat($user->created); ?>
                                    </p>
                                </div>
                            </div>

                            <?= $this->Form->button(__d('admin', '{0} Edit {1}', '<i class="fa fa-edit"></i>', h($user->username)), ['class' => 'col-md-offset-2 btn btn-primary-outline']) ?>
                            <?= $this->Form->end() ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
</div>
<div class="modal fade" id="modalDeleteAccount" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?= __d('admin', 'Close') ?></span>
                </button>
                <h4 class="modal-title">
                    <?= __d('admin', 'Delete an account') ?>
                </h4>
            </div>
            <div class="modal-body">
                <p>
                    <?= __d('admin', 'Are you sure you want delete the account <strong>{0}</strong> ?', h($user->username)) ?>
                </p>
                <small>
                    <?= __d('admin', 'Note : The User will not be able to connect to his account anymore.') ?>
                </small>
            </div>
            <div class="modal-actions">
                <?= $this->Html->link(__d('admin', '{0} Yes, I confirm !', '<i class="fa fa-remove"></i>'), ['_name' => 'users-delete', 'slug' => $user->username, 'id' => $user->id], ['class' => 'ma ma-btn ma-btn-danger', 'escape' => false]) ?>
                <button type="button" class="ma ma-btn ma-btn-primary" data-dismiss="modal"><?= __d('admin', '{0} Close', '<i class="fa fa-remove"></i>') ?></button>
            </div>
        </div>
    </div>
</div>
