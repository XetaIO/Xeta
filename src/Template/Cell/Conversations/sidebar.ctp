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
                    <li>
                        <?= $this->Html->link(__d('conversation', 'Leave the Conversation'), ['_name' => 'conversations-leave', 'id' => $conversation->id]) ?>
                    </li>
                    <li>
                        <?= $this->Html->link(__d('conversations', 'Invite new Participants'), ['_name' => 'conversations-invite', 'id' => $conversation->id]) ?>
                    </li>
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
                <dd>
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
                        <li>
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
                                <?php if (!$participant->user->group->is_staff): ?>
                                <span class="pull-right" style="margin-top: 3px;">
                                    <a href="#">Kick <i class="fa fa-sign-out"></i></a>
                                </span>
                            <?php endif; ?>
                            </small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="panel-footer">
                <?= $this->Html->link(__d('conversations', 'Invite new participants'), ['_name' => 'conversations-invite', 'id' => $conversation->id]) ?>
            </div>
        </div>
    </div>
<?php endif; ?>
