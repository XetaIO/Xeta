<li class="navbar-notification dropdown" <?= ($hasNewNotifs) ? "data-number=\"({$statistics['unread']})\"" : '' ?>>
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        <i class="icon fa fa-bell-o <?= ($hasNewNotifs) ? 'animated ringing text-danger' : '' ?>"></i>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li class="dropdown-header">
            <?= __('News Notifications') ?>
        </li>
        <li class="divider"></li>
        <?php if (!empty($notifications)): ?>

        <?php foreach ($notifications as $notification): ?>
                <li id="notification-<?= $notification->id ?>" class="notification-item" data-id="<?= $notification->id ?>" data-url="<?= $this->Url->build(['controller' => 'notifications', 'action' => 'markAsRead', 'prefix' => false]) ?>">

                    <a href="<?= $notification->link ?>">
                        <?php if ($notification->type === 'bot'): ?>
                            <?= $this->Html->image($notification->icon, ['class' => 'avatar']) ?>
                        <?php elseif ($notification->type === 'badge'): ?>
                            <?= $this->Html->image($notification->data['badge']->picture, ['class' => 'avatar']) ?>
                        <?php else: ?>
                            <?= $this->Html->image($notification->data['sender']->avatar, ['class' => 'avatar img-thumbnail']) ?>
                        <?php endif; ?>

                        <p class="info">
                            <?= $notification->text ?>
                        </p>

                        <?php if (!$notification->is_read): ?>
                            <strong class="new">
                                <span></span>
                                <?= __('New') ?>
                            </strong>
                        <?php endif; ?>
                    </a>

                </li>
            <?php endforeach; ?>

        <?php else: ?>
            <li class="dropdown-header">
                <?= __("You don't have any notifications.") ?>
            </li>
        <?php endif; ?>
        <li class="divider"></li>
        <li>
            <?= $this->Html->link(__('All Notifications'), ['controller' => 'users', 'action' => 'notifications', 'prefix' => false], ['class' => 'notification-all']) ?>
        </li>
    </ul>
</li>
