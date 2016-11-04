<header class="navbar navbar-inverse navbar-admin navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= $this->Html->link(
                $this->Html->image('logo_and_name_white_inversed.png', ['class' => 'navbar-brand', 'alt' => \Cake\Core\Configure::read('Site.name')]),
                ['controller' => 'pages', 'action' => 'home', 'prefix' => false],
                ['escape' => false, 'class' => 'hidden-xs hidden-sm']
            ) ?>
            <svg class='navbar-brand logo hidden-md hidden-lg' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400.1 360.1" xml:space="preserve">
                <g class='icon'>
                    <path class="T" d="m 280.5,71.336441 0,-26.4 41.4,-45.30000034 0,71.70000034 0,47.099999 0,171.6 c 0.1,0.1 -41.4,51 -41.4,50.9 l 0,-222.5 z" />
                    <path class="F" d="m 56.5,71.336441 195.8,0 28.2,0 41.4,0 77.2,0 -43.3,47.099999 c 0,0 -33.9,0.1 -33.9,0 l -41.4,0 -146.8,0 -33.9,0 z" />
                    <path class="M" d="m 267.4,144.83644 -47.1,41.5 c -3.3,0.1 -26.4,0 -26.4,0 l -47.1,1.9 c 0.3,0.1 -47,0.1 -47.1,0 l -43.3,0 c -0.1,-0.1 -9.4,0 -9.4,0 0,-0.1 -46.90000002,-43 -47.10000002,-43.4 13.80000002,0 56.50000002,-0.3 56.50000002,0 70.20503,-0.71993 140.69199,0 211,0 z" />
                    <path class="M3" d="m 56.5,71.336441 43.3,47.099999 0,26.4 -0.1,43.4 0,101.8 c 0.2,-0.2 -43.3,52.8 -43.3,52.8 -0.1,0.1 0,-154.6 0,-154.6 l 0,-43.4 c 0.1,-9.6 0.1,-73.499999 0.1,-73.499999 z" />
                    <path class="M2" d="m 193.9,186.33644 0,84.9 c 0,28.2 0.3,45.5 0,45.3 0.3,0.1 -47.1,-43.3 -47.1,-43.4 l 0,-84.9 z" />
                    <path class="M1" d="m 267.4,144.83644 0,128.2 c -16.4,14.8 -47,43.3 -47.1,43.4 0,-16.3 -0.1,-130.1 0,-130.1 z" />
                </g>
            </svg>
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
