<?php if (!empty($participants)): ?>
    <div class="sidebox widget">
        <div class="panel sidebar-conversation">
            <div class="panel-heading">
                <div class="hr-divider hr-divider-panel">
                    <h3 class="hr-divider-content hr-divider-heading">
                        <?= __d('conversations', 'Actions') ?>
                    </h3>
                </div>
            </div>
            <div class="panel-body">
                <ul class="circled">
                    <?php if ($this->Acl->check(['_name' => 'conversations-edit', 'id' => $conversation->id, 'slug' => $conversation->title])): ?>
                        <li>
                            <?= $this->Html->link(__d('conversations', 'Edit the Conversation'), '#', ['data-toggle' => 'modal', 'data-target' => '#editConversation']) ?>
                        </li>
                    <?php endif; ?>
                    <?php if (!($conversation->user_id == $this->request->session()->read('Auth.User.id'))): ?>
                        <li>
                            <?= $this->Html->link(__d('conversations', 'Leave the Conversation'), '#', ['data-toggle' => 'modal', 'data-target' => '#leaveConversation']) ?>
                        </li>
                    <?php endif; ?>
                    <?php if ($conversation->open_invite || $conversation->user_id == $this->request->session()->read('Auth.User.id') || (!is_null($currentUser) && $currentUser->group->is_staff)): ?>
                        <li>
                            <?= $this->Html->link(__d('conversations', 'Invite new Participants'), '#', ['data-toggle' => 'modal', 'data-target' => '#inviteParticipant']) ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <?php if (!($conversation->user_id == $this->request->session()->read('Auth.User.id'))): ?>
        <div class="modal fade" id="leaveConversation" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="<?= __d('conversations', 'Close') ?>">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">
                        <?= __d('conversations', '{0} Leave Conversation', '<i class="fa fa-plus"></i>') ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <p>
                            <?= __d('conversations', 'Are you sure you want to leave this conversation ?') ?>
                        </p>
                    </div>
                    <div class="modal-actions">
                        <?= $this->Html->link(
                            __d('conversations', 'Yes'),
                            ['_name' => 'conversations-leave', 'id' => $conversation->id, 'slug' => $conversation->title],
                            ['class' => 'ma ma-btn ma-btn-danger']
                        ) ?>
                        <button type="button" class="ma ma-btn ma-btn-primary" data-dismiss="modal">
                            <?= __d('conversations', 'Close') ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($conversation->open_invite || $conversation->user_id == $this->request->session()->read('Auth.User.id') || (!is_null($currentUser) && $currentUser->group->is_staff)): ?>
        <div class="modal fade" id="inviteParticipant" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <?= $this->Form->create($conversation, [
                        'url' => ['_name' => 'conversations-invite', 'id' => $conversation->id, 'slug' => $conversation->title]
                    ]) ?>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="<?= __d('conversations', 'Close') ?>">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">
                        <?= __d('conversations', '{0} Invite new Participants', '<i class="fa fa-plus"></i>') ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <?= $this->Form->label('users', __d('conversations', 'Participants in the conversation'), ['class' => 'control-label']) ?>
                            <?= $this->Form->input('users', [
                                'class' => 'form-control',
                                'label' => false,
                                'id' => 'InviteConversationUsers',
                                'type' => 'text',
                                'placeholder' => __d('conversations', 'Enter the name(s) here'),
                                'autocomplete' => 'off',
                                'required' => 'required',
                                'data-url' => \Cake\Routing\Router::url(['controller' => 'conversations', 'action' => 'inviteMember'])
                            ]) ?>
                        </div>
                    </div>
                    <div class="modal-actions">
                        <?= $this->Form->button(
                            __d('conversations', '{0} Invite', '<i class="fa fa-plus"></i>'),
                            [
                                'type' => 'submit',
                                'class' => 'ma ma-btn ma-btn-success',
                                'escape' => false
                            ]
                        ) ?>
                        <button type="button" class="ma ma-btn ma-btn-danger" data-dismiss="modal">
                            <?= __d('conversations', '{0} Cancel', '<i class="fa fa-remove"></i>') ?>
                        </button>
                    </div>
                    <?= $this->Form->end(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($this->Acl->check(['_name' => 'conversations-edit', 'id' => $conversation->id, 'slug' => $conversation->title])): ?>
        <div class="modal fade" id="editConversation" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <?= $this->Form->create($conversation, [
                        'url' => ['_name' => 'conversations-edit', 'id' => $conversation->id, 'slug' => $conversation->title]
                    ]) ?>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="<?= __d('conversations', 'Close') ?>">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">
                        <?= __d('conversations', '{0} Edit Conversation', '<i class="fa fa-edit"></i>') ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <?= $this->Form->label('title', __d('conversations', 'Conversation Title'), ['class' => 'control-label']) ?>
                            <?= $this->Form->input('title', ['class' => 'form-control', 'label' => false])?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('conversation_open', __d('conversations', 'Close Conversation'), ['class' => 'control-label']) ?>
                            <?= $this->Form->radio('conversation_open', [
                                    '1' => __d('conversations', 'No'),
                                    '0' => __d('conversations', 'Yes')
                                ],
                                [
                                    'legend' => false,
                                    'class' => 'form-control'
                                ]
                            ) ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('open_invite', __d('conversations', 'Allow anyone in the conversation to invite other users'), ['class' => 'control-label']) ?>
                            <?= $this->Form->radio('open_invite', [
                                    '1' => __d('conversations', 'No'),
                                    '0' => __d('conversations', 'Yes')
                                ],
                                [
                                    'legend' => false,
                                    'class' => 'form-control'
                                ]
                            ) ?>
                        </div>
                    </div>
                    <div class="modal-actions">
                        <?= $this->Form->button(
                            __d('conversations', '{0} Save', '<i class="fa fa-floppy-o"></i>'),
                            [
                                'type' => 'submit',
                                'class' => 'ma ma-btn ma-btn-success',
                                'escape' => false
                            ]
                        ) ?>
                        <button type="button" class="ma ma-btn ma-btn-danger" data-dismiss="modal">
                            <?= __d('conversations', '{0} Cancel', '<i class="fa fa-remove"></i>') ?>
                        </button>
                    </div>
                    <?= $this->Form->end(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="sidebox widget">
    <div class="panel sidebar-conversation">
        <div class="panel-heading">
            <div class="hr-divider hr-divider-panel">
                <h3 class="hr-divider-content hr-divider-heading">
                    <?= __d('conversations', 'Conversation Information') ?>
                </h3>
            </div>
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
                            'slug' => $conversation->last_message_user->username
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

<?php if (!empty($participants)) : ?>
    <div class="sidebox widget">
        <div class="panel panel-staff-online">
            <div class="panel-heading">
                <div class="hr-divider hr-divider-panel">
                    <h3 class="hr-divider-content hr-divider-heading">
                        <?= __d('conversations', 'Participants') ?>
                    </h3>
                </div>
            </div>
            <div class="panel-body">
                <ul>
                    <?php foreach ($participants as $participant) : ?>
                        <li id="recipient-<?= $participant->user->id ?>">
                            <?= $this->Html->link(
                                $this->Html->image($participant->user->avatar, ['class' => 'img-thumbnail']),
                                ['_name' => 'users-profile', 'slug' => $participant->user->username, 'id' => $participant->user->id, 'prefix' => false],
                                ['class' => 'avatar', 'escape' => false]
                            ) ?>
                            <?= $this->Html->link(
                                $participant->user->username,
                                ['_name' => 'users-profile', 'slug' => $participant->user->username, 'id' => $participant->user->id, 'prefix' => false],
                                ['class' => 'username']
                            ) ?>
                            <small class="userGroup">
                                <span style="<?= h($participant->user->group->css) ?>">
                                    <?= h($participant->user->group->name) ?>
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
                                ) : ?>
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
            <?php if ($conversation->open_invite || $conversation->user_id == $this->request->session()->read('Auth.User.id') || (!is_null($currentUser) && $currentUser->group->is_staff)) : ?>
                <div class="panel-footer">
                    <?= $this->Html->link(__d('conversations', '{0} Invite new participants', '<i class="fa fa-plus"></i>'), '#', ['escape' => false, 'data-toggle' => 'modal', 'data-target' => '#inviteParticipant']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
