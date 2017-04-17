<header class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= $this->Html->image('logo50x50.png', ['class' => 'navbar-brand', 'alt' => \Cake\Core\Configure::read('Site.name')]) ?>
            <?= $this->Html->link(\Cake\Core\Configure::read('Site.name'), '/', ['class' => 'navbar-brand', 'data-hover' => \Cake\Core\Configure::read('Site.name')]) ?>
        </div>
        <nav class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?= (strtolower($this->request->getParam('controller')) == 'pages' && strtolower($this->request->getParam('action')) == 'home') ? '<li class="active">' : '<li>' ?>
                    <a href="<?= $this->Url->build('/') ?>">
                        <span data-hover="<?=__("Home") ?>"><?= __("Home") ?></span>
                    </a>
                </li>
                <?= (strtolower($this->request->getParam('controller')) == 'blog') ? '<li class="active">' : '<li>' ?>
                    <a href="<?= $this->Url->build(['controller' => 'blog', 'action' => 'index', 'prefix' => false]) ?>">
                        <span data-hover="<?=__("Blog") ?>"><?= __("Blog") ?></span>
                    </a>
                </li>
                <?= (strtolower($this->request->getParam('controller')) == 'contact') ? '<li class="active">' : '<li>' ?>
                    <a href="<?= $this->Url->build(['controller' => 'contact', 'action' => 'index', 'prefix' => false]) ?>">
                        <span data-hover="<?=__("Contact") ?>"><?= __("Contact") ?></span>
                    </a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if ($this->request->session()->read('Auth.User')) : ?>
                    <p class="navbar-text">
                        <?= __('Hello,') . '&nbsp;' ?>
                        <?= $this->Html->link($this->request->session()->read('Auth.User.username'), '#', ['class' => 'sidebar-trigger']) ?>
                    </p>

                    <?= $this->cell('Notification::notifications') ?>
                <?php else : ?>
                    <div class="btn-group">
                        <?= $this->Html->link(
                            __("Login"),
                            ['controller' => 'users', 'action' => 'login', 'prefix' => false],
                            ['class' => 'btn btn-primary-outline navbar-btn']
                        ) ?>
                        <?= $this->Html->link(
                            __("Sign up"),
                            ['controller' => 'users', 'action' => 'login', 'prefix' => false],
                            ['class' => 'btn btn-primary-outline navbar-btn']
                        ) ?>
                    </div>
                <?php endif;?>
            </ul>
        </nav>
    </div>
</header>

<?php if ($this->request->session()->read('Auth.User')) : ?>
    <nav class="sidebar sidebar-closed" id="sidebar">
        <div class="sidebar-container">
            <ul class="nav sidebar-menu">
                <?= $this->Html->link(
                    $this->Html->image(h($this->request->session()->read('Auth.User.avatar'))),
                    ['_name' => 'users-profile', 'slug' => h($this->request->session()->read('Auth.User.username')), 'id' => $this->request->session()->read('Auth.User.id')],
                    ['escape' => false, 'class' => 'sidebar-avatar', 'data-original-title' => __('Visit your profile !'), 'data-toggle' => 'tooltip', 'data-placement' => 'left', 'data-container' => 'body']
                ) ?>
                <?php if ($this->Acl->check(['controller' => 'admin', 'action' => 'home', 'prefix' => 'admin'])) : ?>
                    <li>
                        <?= $this->Html->link(
                            '<i class="fa fa-dashboard"></i><small class="sidebar-text">' . __('Dashboard') . '</small>',
                            ['controller' => 'admin', 'action' => 'home', 'prefix' => 'admin'],
                            ['escape' => false, 'class' => 'hidden-xs', 'data-original-title' => __('Access to the site administration.'), 'data-toggle' => 'tooltip', 'data-placement' => 'left', 'data-container' => 'body']
                        ) ?>
                        <!-- Responsive link -->
                        <?= $this->Html->link(
                            '<i class="fa fa-dashboard"></i><small class="sidebar-text">' . __('Dashboard') . '</small>',
                            ['controller' => 'admin', 'action' => 'home', 'prefix' => 'admin'],
                            ['escape' => false, 'class' => 'visible-xs-block']
                        ) ?>
                    </li>
                <?php endif; ?>
                <?php if ($this->Acl->check(['controller' => 'users', 'action' => 'account', 'prefix' => false])) : ?>
                    <li>
                        <?= $this->Html->link(
                            '<i class="fa fa-cogs"></i><small class="sidebar-text">' . __('My Account') . '</small>',
                            ['controller' => 'users', 'action' => 'account', 'prefix' => false],
                            ['escape' => false, 'class' => 'hidden-xs', 'data-original-title' => __('Manage your account settings.'), 'data-toggle' => 'tooltip', 'data-placement' => 'left', 'data-container' => 'body']
                        ) ?>
                        <!-- Responsive link -->
                        <?= $this->Html->link(
                            '<i class="fa fa-cogs"></i><small class="sidebar-text">' . __('My Account') . '</small>',
                            ['controller' => 'users', 'action' => 'account', 'prefix' => false],
                            ['escape' => false, 'class' => 'visible-xs-block']
                        ) ?>
                    </li>
                <?php endif; ?>
                <?php if ($this->Acl->check(['controller' => 'conversations', 'action' => 'index', 'prefix' => false])) : ?>
                    <li>
                        <?= $this->Html->link(
                            '<i class="fa fa-envelope-o"></i><small class="sidebar-text">' . __('Conversations') . '</small>',
                            ['controller' => 'conversations', 'action' => 'index', 'prefix' => false],
                            ['escape' => false, 'class' => 'hidden-xs', 'data-original-title' => __('Check your private messages.'), 'data-toggle' => 'tooltip', 'data-placement' => 'left', 'data-container' => 'body']
                        ) ?>
                        <!-- Responsive link -->
                        <?= $this->Html->link(
                            '<i class="fa fa-envelope-o"></i><small class="sidebar-text">' . __('Conversations') . '</small>',
                            ['controller' => 'conversations', 'action' => 'index', 'prefix' => false],
                            ['escape' => false, 'class' => 'visible-xs-block']
                        ) ?>
                    </li>
                <?php endif; ?>
                <?php if ($this->Acl->check(['controller' => 'users', 'action' => 'notifications', 'prefix' => false])) : ?>
                    <li>
                        <?= $this->Html->link(
                            '<i class="fa fa-bell-o"></i><small class="sidebar-text">' . __('Notifications') . '</small>',
                            ['controller' => 'users', 'action' => 'notifications', 'prefix' => false],
                            ['escape' => false, 'class' => 'hidden-xs', 'data-original-title' => __('Check your new and old notifications.'), 'data-toggle' => 'tooltip', 'data-placement' => 'left', 'data-container' => 'body']
                        ) ?>
                        <!-- Responsive link -->
                        <?= $this->Html->link(
                            '<i class="fa fa-bell-o"></i><small class="sidebar-text">' . __('Notifications') . '</small>',
                            ['controller' => 'users', 'action' => 'notifications', 'prefix' => false],
                            ['escape' => false, 'class' => 'visible-xs-block']
                        ) ?>
                    </li>
                <?php endif; ?>
                <?php if ($this->Acl->check(['controller' => 'users', 'action' => 'logout', 'prefix' => false])) : ?>
                    <li>
                        <?= $this->Html->link(
                            '<i class="fa fa-sign-out"></i><small class="sidebar-text">' . __('Logout') . '</small>',
                            ['controller' => 'users', 'action' => 'logout', 'prefix' => false],
                            ['escape' => false, 'class' => 'hidden-xs text-danger', 'data-original-title' => __('See you later !'), 'data-toggle' => 'tooltip', 'data-placement' => 'left', 'data-container' => 'body']
                        ) ?>
                        <!-- Responsive link -->
                        <?= $this->Html->link(
                            '<i class="fa fa-sign-out"></i><small class="sidebar-text">' . __('Logout') . '</small>',
                            ['controller' => 'users', 'action' => 'logout', 'prefix' => false],
                            ['escape' => false, 'class' => 'visible-xs-block text-danger']
                        ) ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
<?php endif; ?>
