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
                <?= (strtolower($this->request->params['controller']) == 'pages' && strtolower($this->request->params['action']) == 'home') ? '<li class="active">' : '<li>' ?>
                    <a href="<?= $this->Url->build('/') ?>">
                        <span data-hover="<?=__("Home") ?>"><?= __("Home") ?></span>
                    </a>
                </li>
                <?= (strtolower($this->request->params['controller']) == 'blog') ? '<li class="active">' : '<li>' ?>
                    <a href="<?= $this->Url->build(['controller' => 'blog', 'action' => 'index', 'prefix' => false]) ?>">
                        <span data-hover="<?=__("Blog") ?>"><?= __("Blog") ?></span>
                    </a>
                </li>
                <?= (isset($this->request->params['prefix']) && strtolower($this->request->params['prefix']) == 'forum') ? '<li class="active">' : '<li>' ?>
                    <a href="<?= $this->Url->build(['controller' => 'forum', 'action' => 'index', 'prefix' => 'forum']) ?>">
                        <span data-hover="<?=__("Forum") ?>"><?= __("Forum") ?></span>
                    </a>
                </li>
                <?= (strtolower($this->request->params['controller']) == 'premium') ? '<li class="active">' : '<li>' ?>
                    <a href="<?= $this->Url->build(['controller' => 'premium', 'action' => 'index', 'prefix' => false]) ?>">
                        <span data-hover="<?=__("Premium") ?>"><?= __("Premium") ?></span>
                    </a>
                </li>
                <?= (strtolower($this->request->params['controller']) == 'contact') ? '<li class="active">' : '<li>' ?>
                    <a href="<?= $this->Url->build(['controller' => 'contact', 'action' => 'index', 'prefix' => false]) ?>">
                        <span data-hover="<?=__("Contact") ?>"><?= __("Contact") ?></span>
                    </a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if ($this->request->session()->read('Auth.User')): ?>
                    <p class="navbar-text">
                        <?= __('Hello,') . '&nbsp;' ?>
                        <?= $this->Html->link($this->request->session()->read('Auth.User.username'), '#', ['class' => 'user-menu-trigger']) ?>
                    </p>

                    <?= $this->cell('Notification::notifications') ?>
                <?php else:?>
                    <?= $this->Html->link(__("Login"), ['controller' => 'users', 'action' => 'login', 'prefix' => false],
                        ['class' => 'btn btn-outline navbar-btn']) ?>
                    <?= $this->Html->link(__("Sign up"), ['controller' => 'users', 'action' => 'login', 'prefix' => false],
                        ['class' => 'btn btn-primary navbar-btn']) ?>
                <?php endif;?>
            </ul>
        </nav>
    </div>
</header>

<?php if($this->request->session()->read('Auth.User')): ?>
    <nav id="user-menu" class="user-menu menu-close">
        <?= $this->Html->image(h($this->request->session()->read('Auth.User.avatar')), ['class' => 'user-menu-img']) ?>
        <ul>
            <?php if ($this->Acl->check(['controller' => 'admin', 'action' => 'home', 'prefix' => 'admin'])): ?>
                <li>
                    <?= $this->Html->link('<i class="fa fa-key"></i>&nbsp;' . __('Dashboard'), ['controller' => 'admin',
                            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
            <?php endif; ?>

            <?php if ($this->Acl->check(['_name' => 'users-profile', 'slug' => h($this->request->session()->read('Auth.User.slug')), 'id' => $this->request->session()->read('Auth.User.id')])): ?>
                <li>
                    <?= $this->Html->link('<i class="fa fa-user"></i>&nbsp;' . __('My Profile'), ['_name' => 'users-profile', 'slug' => h($this->request->session()->read('Auth.User.slug')), 'id' => $this->request->session()->read('Auth.User.id')], ['escape' => false]) ?>
                </li>
            <?php endif; ?>

            <?php if ($this->Acl->check(['controller' => 'conversations', 'action' => 'index', 'prefix' => false])): ?>
                <li>
                    <?= $this->Html->link('<i class="fa fa-envelope-o"></i>&nbsp;' . __('Conversations'), ['controller' => 'conversations', 'action' => 'index', 'prefix' => false], ['escape' => false]) ?>
                </li>
            <?php endif; ?>
            <?php if ($this->Acl->check(['controller' => 'users', 'action' => 'account', 'prefix' => false])): ?>
                <li>
                    <?= $this->Html->link('<i class="fa fa-cogs"></i>&nbsp;' . __('My Account'), ['controller' => 'users', 'action' => 'account', 'prefix' => false], ['escape' => false]) ?>
                </li>
            <?php endif; ?>
            <?php if ($this->Acl->check(['controller' => 'users', 'action' => 'notifications', 'prefix' => false])): ?>
                <li>
                    <?= $this->Html->link('<i class="fa fa-bell-o"></i>&nbsp;' . __('My Notifications'), ['controller' => 'users', 'action' => 'notifications', 'prefix' => false], ['escape' => false]) ?>
                </li>
            <?php endif; ?>

            <?php if ($this->Acl->check(['controller' => 'users', 'action' => 'logout', 'prefix' => false])): ?>
                <li>
                    <?= $this->Html->link('<i class="fa fa-sign-out"></i>&nbsp;' . __('Logout'), ['controller' => 'users', 'action' => 'logout', 'prefix' => false], ['escape' => false]) ?>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
