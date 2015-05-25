<?php if (!empty($participants)): ?>
    <div class="sidebox widget">
        <div class="panel panel-forum sidebar-conversation">
            <div class="panel-heading">
                <?= __d('conversations', 'Actions') ?>
            </div>
            <div class="panel-body">
                <ul class="circled">
                    <li>
                        <?= $this->Html->link(__d('conversation', 'Edit the Conversation'), ['_name' => 'conversations-edit', 'id' => $conversation->id]) ?>
                    </li>
                    <?php if (!($conversation->user_id == $this->request->session()->read('Auth.User.id'))): ?>
                        <li>
                            <?= $this->Html->link(__d('conversation', 'Leave the Conversation'), ['_name' => 'conversations-leave', 'id' => $conversation->id]) ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($conversation->open_invite || $conversation->user_id == $this->request->session()->read('Auth.User.id') || (!is_null($currentUser) && $currentUser->group->is_staff)): ?>
                        <li>
                            <?= $this->Html->link(__d('conversations', 'Invite new Participants'), ['_name' => 'conversations-invite', 'id' => $conversation->id]) ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="sidebox widget">
    <div class="panel panel-forum sidebar-conversation">
        <div class="panel-heading">
            <?= __d('conversations', 'Conversation Information') ?>
        </div>
        <div class="panel-body">
            <dl>
                <dt>
                    <?= __d('conversations', 'Participants :') ?>
                </dt>
                <dd id="InformationNbRecipient">
                    <?= $conversation->recipient_count ?>
                </dd>
            </dl>
            <dl>
                <dt>
                <?= __d('conversations', 'Replies :') ?>
                </dt>
                <dd>
                    <?= $conversation->reply_count ?>
                </dd>
            </dl>
            <dl>
                <dt>
                    <?= __d('conversations', 'Last reply :') ?>
                </dt>
                <dd>
                    <?= ucwords($conversation->last_message_date->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::MEDIUM])) ?>
                </dd>
            </dl>
            <dl>
                <dt>
                <?= __d('conversations', 'Last reply by :') ?>
                </dt>
                <dd>
                    <?= $this->Html->link(
                        $conversation->last_message_user->username,
                        [
                            '_name' => 'users-profile',
                            'id' => $conversation->last_message_user->id,
                            'slug' => $conversation->last_message_user->slug
                        ],
                        [
                            'class' => 'text-primary'
                        ]
                    ) ?>
                </dd>
            </dl>
        </div>
    </div>
</div>

<?php if (!empty($participants)): ?>
    <div class="sidebox widget">
        <div class="panel panel-forum panel-staff-online">
            <div class="panel-heading">
                <?= __d('conversations', 'Participants') ?>
            </div>
            <div class="panel-body">
                <ul>
                    <?php foreach ($participants as $participant): ?>
                        <li id="recipient-<?= $participant->user->id ?>">
                            <?= $this->Html->link(
                                $this->Html->image($participant->user->avatar, ['class' => 'img-thumbnail']),
                                ['_name' => 'users-profile', 'slug' => $participant->user->slug, 'id' => $participant->user->id, 'prefix' => false],
                                ['class' => 'avatar', 'escape' => false]
                            ) ?>
                            <?= $this->Html->link(
                                $participant->user->username,
                                ['_name' => 'users-profile', 'slug' => $participant->user->slug, 'id' => $participant->user->id, 'prefix' => false],
                                ['class' => 'username']
                            ) ?>
                            <small class="userGroup">
                                <span style="<?= h($participant->user->group_css) ?>">
                                    <?= h($participant->user->group_name) ?>
                                </span>
                                <?php if (
                                    (
                                        $conversation->user_id == $this->request->session()->read('Auth.User.id') &&
                                        $participant->user->id != $this->request->session()->read('Auth.User.id') &&
                                        $participant->user->group->is_staff == false
                                    ) ||
                                    (
                                        $conversation->user_id != $this->request->session()->read('Auth.User.id') &&
                                        $participant->user->id != $this->request->session()->read('Auth.User.id') &&
                                        $participant->user->id != $conversation->user_id &&
                                        (!is_null($currentUser) && $currentUser->group->is_staff)
                                    )
                                ): ?>
                                    <span class="pull-right" style="margin-top: 3px;">
                                        <?= $this->Html->link(
                                            __d('conversations', 'Kick {0}', '<i class="fa fa-sign-out"></i>'),
                                            "#",
                                            [
                                                'escape' => false,
                                                'class' => 'KickRecipient',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'title' => __d('conversations', 'Kick from conversation'),
                                                'data-url' => \Cake\Routing\Router::url(['_name' => 'conversations-kick', 'id' => $conversation->id, 'user_id' => $participant->user->id]),
                                            ]
                                        ) ?>
                                    </span>
                                <?php endif; ?>
                            </small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php if ($conversation->open_invite || $conversation->user_id == $this->request->session()->read('Auth.User.id') || (!is_null($currentUser) && $currentUser->group->is_staff)): ?>
                <div class="panel-footer">
                    <?= $this->Html->link(__d('conversations', 'Invite new participants'), ['_name' => 'conversations-invite', 'id' => $conversation->id]) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
