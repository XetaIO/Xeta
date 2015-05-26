<div class="account-sidebar">
    <ul class="nav nav-pills nav-stacked">
        <?php if($this->request->params['action'] == 'account'): ?>
            <li class="active">
        <?php else:?>
            <li>
        <?php endif;?>
            <?= $this->Html->link(__("{0} Account {1}", '<i class="fa fa-user"></i>', '<i class="fa fa-chevron-right"></i>'), ['controller' => 'users', 'action' => 'account'], ['escape' => false]) ?>
        </li>

        <?php if($this->request->params['controller'] == 'Conversations'): ?>
            <li class="active">
        <?php else:?>
            <li>
        <?php endif;?>
            <?= $this->Html->link(__("{0} Conversations {1}", '<i class="fa fa-envelope-o"></i>', '<i class="fa fa-chevron-right"></i>'), ['controller' => 'conversations', 'action' => 'index'], ['escape' => false]) ?>
        </li>

        <?php if($this->request->params['action'] == 'settings'): ?>
            <li class="active">
        <?php else:?>
            <li>
        <?php endif;?>
            <?= $this->Html->link(__("{0} Settings {1}", '<i class="fa fa-cogs"></i>', '<i class="fa fa-chevron-right"></i>'), ['controller' => 'users', 'action' => 'settings'], ['escape' => false]) ?>
        </li>

        <?php if($this->request->params['action'] == 'notifications'): ?>
            <li class="active">
        <?php else:?>
            <li>
        <?php endif;?>
            <?= $this->Html->link(__("{0} Notifications {1}", '<i class="fa fa-bell-o"></i>', '<i class="fa fa-chevron-right"></i>'), ['controller' => 'users', 'action' => 'notifications'], ['escape' => false]) ?>
        </li>

        <?php if($this->request->params['action'] == 'premium'): ?>
            <li class="active">
        <?php else:?>
            <li>
        <?php endif;?>
            <?= $this->Html->link(__("{0} Premium {1}", '<i class="fa fa-trophy"></i>', '<i class="fa fa-chevron-right"></i>'), ['controller' => 'users', 'action' => 'premium'], ['escape' => false]) ?>
        </li>
    </ul>
</div>
