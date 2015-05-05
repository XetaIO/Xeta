<?php if (!empty($staffOnline)): ?>
    <div class="sidebox widget">
        <div class="panel panel-forum panel-staff-online">
            <div class="panel-heading">
                <?= __('Staff Online') ?>
            </div>
            <div class="panel-body">
                <ul>
                    <?php foreach ($staffOnline as $staff): ?>
                        <li>
                            <?= $this->Html->link(
                                $this->Html->image($staff->user->avatar, ['class' => 'img-thumbnail']),
                                ['_name' => 'users-profile', 'slug' => $staff->user->slug, 'id' => $staff->user->id, 'prefix' => false],
                                ['class' => 'avatar', 'escape' => false]
                            ) ?>
                            <?= $this->Html->link(
                                $staff->user->username,
                                ['_name' => 'users-profile', 'slug' => $staff->user->slug, 'id' => $staff->user->id, 'prefix' => false],
                                ['class' => 'username']
                            ) ?>
                            <small class="userGroup" style="<?= h($staff->user->group_css) ?>">
                                <?= h($staff->user->group_name) ?>
                            </small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php $params = $this->request->params; ?>
<?php if(\Cake\Core\Configure::read('Chat.enabled') === true &&
        ($params['controller'] === 'Forum' && $params['action'] === 'index' && $params['prefix'] === 'forum')
): ?>
    <div class="sidebox widget">
        <div class="panel panel-forum panel-chat-online">
            <div class="panel-heading">
                <?= __d('chat', 'Members in Chat') ?>
            </div>
            <div class="panel-body">
                <ul id="chatboxOnline">
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($lastThreads)): ?>
    <div class="sidebox widget">
        <div class="panel panel-forum panel-latest-threads">
            <div class="panel-heading">
                <?= __('Latest Threads') ?>
            </div>
            <div class="panel-body">
                <ul>
                    <?php foreach ($lastThreads as $thread): ?>
                        <li>
                            <?= $this->Html->link(
                                $this->Html->image($thread->user->avatar, ['class' => 'img-thumbnail']),
                                ['_name' => 'users-profile', 'slug' => $thread->user->slug, 'id' => $thread->user->id, 'prefix' => false],
                                [
                                    'class' => 'avatar',
                                    'escape' => false,
                                    'title' => __('Created by {0}', $thread->user->username),
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'left',
                                    'data-container' => 'body',
                                ]
                            ) ?>
                            <?= $this->Html->link(
                                $this->Text->truncate(
                                    $thread->title,
                                    30,
                                    [
                                        'ellipsis' => '...',
                                        'exact' => false
                                    ]
                                ),
                                ['controller' => 'posts', 'action' => 'go', $thread->last_post_id],
                                ['class' => 'title text-primary']
                            ) ?>
                            <small class="date">
                                <?= __('At {0}', $thread->created->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT])) ?>
                            </small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>
