<?= $this->element('meta', [
    'title' => __d('conversations', 'Conversations')
]) ?>
<?php $this->start('scriptBottom');

    echo $this->Html->script([
        'ckeditor/ckeditor',
        'conversations.min'
    ]); ?>

    <script type="text/javascript">
        CKEDITOR.replace('messageBox', {
            customConfig: 'config/forum.js'
        });
    </script>

<?php $this->end() ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('conversations', 'Home'), '/') ?>
                </li>
                <li>
                    <?= $this->Html->link(__d('conversations', 'Conversations'), ['controller' => 'conversations', 'action' => 'index']) ?>
                </li>
                <li class="active">
                    <?= h($conversation->conversation->title) ?>
                </li>
            </ol>
            <?= $this->Flash->render() ?>
        </div>
    </div>

    <div class="row">
        <section class="col-md-9">
            <main role="main" class="conversations main">
                <?php foreach ($messages as $message): ?>
                <div class="message clearfix" id="message-<?= $message->id ?>">
                    <div class="left">
                        <div class="avatar">
                            <?= $this->Html->link(
                                $this->Html->image($message->user->avatar, ['width' => '100', 'height' => '100']),
                                ['_name' => 'users-profile', 'slug' => $message->user->slug, 'id' => $message->user->id, 'prefix' => false],
                                ['escape' => false]
                            ) ?>
                            <span class="status">
                                <?php if ($message->user->online === true): ?>
                                    <i class="fa fa-circle text-primary" data-toggle="tooltip" title="<?= __("Online") ?>" data-container="body"></i>
                                <?php else: ?>
                                    <i class="fa fa-circle text-danger" data-toggle="tooltip" title="<?= __("Offline") ?>" data-container="body"></i>
                                <?php endif; ?>
                            </span>
                        </div>

                        <span class="username">
                            <?= $this->Html->link($message->user->full_name, ['_name' => 'users-profile', 'slug' => $message->user->slug, 'id' => $message->user->id, 'prefix' => false]) ?>
                        </span>

                        <span class="group" style="<?= h($message->user->group_css) ?>">
                            <?= h($message->user->group_name) ?>
                        </span>

                        <span class="joinedDate">
                            <?= __('Joined') ?><br>
                            <?= $message->user->created->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::NONE]) ?>
                        </span>
                    </div>
                    <div class="right">
                        <div class="header">
                            <span class="date">
                                <?= ucwords($message->created->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::MEDIUM])) ?>
                            </span>

                            <span class="messageId">
                                <?= $this->Html->link(
                                '#' . $message->id,
                                'javascript:void(0);',
                                [
                                    'class' => 'text-primary',
                                    'data-toggle' => 'popover',
                                    'title' => __('Post Link'),
                                    'data-html' => true,
                                    'data-placement' => 'left',
                                    'data-container' => 'body',
                                    'data-content' => '<input class="form-control" style="min-width:440px;" value="' . $this->Url->build([
                                        'controller' => 'posts',
                                        'action' => 'go',
                                        $message->id], true) . '" />'
                                    ]
                                ) ?>
                            </span>
                        </div>

                        <div class="actions">
                            <?php if (($this->Acl->check(['_name' => 'conversations-messageEdit', 'id' => $message->id]) && $this->request->session()->read('Auth.User.id') == $message->user_id) || (!is_null($currentUser) && $currentUser->group->is_staff)): ?>
                                <?= $this->Html->link(
                                    __('{0} Edit', '<i class="fa fa-edit"></i>'),
                                    '#',
                                    [
                                        'class' => 'btn btn-sm btn-primary editMessage',
                                        'data-url' => $this->Url->build([
                                            'controller' => 'conversations',
                                            'action' => 'getEditMessage'
                                        ]),
                                        'data-id' => $message->id,
                                        'escape' => false
                                    ]
                                ) ?>
                            <?php endif; ?>

                            <?php if ($message->id != $conversation->conversation->first_message_id): ?>
                                <?php if ($this->Acl->check(['_name' => 'conversations-messageDelete', 'id' => $message->id])): ?>
                                    <?= $this->Html->link(__('{0} Delete', '<i class="fa fa-remove"></i>'), ['_name' => 'conversations-messageDelete', 'id' => $message->id], ['class' => 'btn btn-sm btn-danger', 'escape' => false]) ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>

                        <div class="message">
                            <?= $message->message ?>
                        </div>

                        <div class="bottom">

                            <?php if ($message->edit_count): ?>
                                <div class="edited">
                                    <?= __('{0} Last Edit: {1}, {2}',
                                        '<i class="fa fa-pencil"></i>',
                                        $this->Html->link(
                                            h($message->last_edit_user->username),
                                            ['_name' => 'users-profile', 'slug' => $message->last_edit_user->slug, 'id' => $message->last_edit_user->id, 'prefix' => false],
                                            ['class' => 'text-primary', 'escape' => false]
                                        ),
                                        ucwords($message->last_edit_date->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::MEDIUM]))
                                    ) ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->Acl->check(['_name' => 'conversations-quote', 'id' => $message->id])): ?>
                                <div class="actions text-right">
                                    <?php if ($this->Acl->check(['_name' => 'conversations-quote', 'id' => $message->id]) && $conversation->conversation->conversation_open == 1): ?>
                                        <?= $this->Html->link(
                                            __("{0} Quote", '<i class="fa fa-quote-left"></i>'),
                                            '#',
                                            [
                                                'class' => 'QuoteMessage btn btn-sm btn-link text-primary',
                                                'data-url' => $this->Url->build(
                                                    [
                                                        '_name' => 'conversations-quote',
                                                        'id' => $message->id
                                                    ]
                                                ),
                                                'escape' => false
                                            ]
                                        ) ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($message->user->signature)): ?>
                                <div class="signature">
                                    <?= $message->user->signature ?>
                                </div>
                            <?php endif; ?>

                        </div>

                    </div>
                </div>
                <?php endforeach; ?>

                <?php if((int)$this->Paginator->counter('{{pages}}') > 1): ?>
                    <div class="pagination-centered">
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
                <?php endif; ?>

                <?= $this->element('Conversations/reply', [
                    'conversation' => $conversation->conversation
                ]) ?>
            </main>

        </section>
        <section class="col-md-3">
            <?= $this->cell('Conversations::sidebar') ?>
        </section>
    </div>
</div>
