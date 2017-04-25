<header class="navbar navbar-inverse navbar-admin navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= $this->Html->image('logo50x50.png', ['class' => 'navbar-brand hidden-xs hidden-sm', 'alt' => \Cake\Core\Configure::read('Site.name')]) ?>
            <?= $this->Html->link(\Cake\Core\Configure::read('Site.name'), ['controller' => 'pages', 'action' => 'home', 'prefix' => false], ['class' => 'navbar-brand hidden-xs hidden-sm', 'data-hover' => \Cake\Core\Configure::read('Site.name')]) ?>
            <?= $this->Html->image('logo50x50.png', ['class' => 'navbar-brand hidden-md hidden-lg', 'alt' => \Cake\Core\Configure::read('Site.name')]) ?>
        </div>
        <nav class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a class="btn-nav" data-toggle="modal" href="#Interface">
                        <i class="fa fa-th"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="navbar-lang">
                    <a type="button" href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?= $this->Html->image(
                            'languages/blank.gif',
                            [
                                'class' => 'flag flag-' . \Cake\I18n\I18n::locale(),
                                'alt' => \Cake\Core\Configure::read('I18n.locales.' . \Cake\I18n\I18n::locale())
                            ]
                        ) ?>
                        <?= \Cake\Core\Configure::read('I18n.locales.' . \Cake\I18n\I18n::locale()) ?>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <?php foreach (\Cake\Core\Configure::read('I18n.locales') as $key => $value): ?>
                            <?php if (\Cake\I18n\I18n::locale() != $key): ?>
                                <li class="<?= $value ?>">
                                    <?= $this->Html->link(
                                        $this->Html->image(
                                            'languages/blank.gif',
                                            [
                                                'class' => 'flag flag-' . $key,
                                                'alt' => \Cake\Core\Configure::read('I18n.locales.' . $key)
                                            ]
                                        ) . '&nbsp;' . $value,
                                        [
                                            '_name' => 'set-lang',
                                            'lang' => $key
                                        ],
                                        [
                                            'escape' => false
                                        ]
                                    ) ?>
                                </li>
                            <?php endif;?>
                        <?php endforeach;?>
                    </ul>
                </li>

                <li class="dropdown">
                    <div class="navbar-text">
                        <?= __d('admin', 'Hello,') ?>
                        <?= $this->Html->link(
                            '<span data-hover="' . h($this->request->session()->read('Auth.User.username')) . '">'
                            . h($this->request->session()->read('Auth.User.username'))
                            . '</span><i class="caret"></i>',
                            '#',
                            ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false]
                        ) ?>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <?= $this->Html->link(__d('admin', '{0} Logout', '<i class="fa fa-sign-out"></i>'),
                                ['controller' => 'users', 'action' => 'logout', 'prefix' => false], ['escape' => false]);?>
                            </li>
                        </ul>
                    </div>

                </li>

            </ul>
        </nav>
    </div>
</header>
