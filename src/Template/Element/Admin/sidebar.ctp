<div class="sidebar">
    <div class="sidebar-inner">
        <ul class="sidebar-nav nav nav-pills nav-stacked hidden-xs hidden-sm">
            <li>
                <div class="sidebar-header">
                    <?= $this->Html->image(h($this->request->session()->read('Auth.User.avatar')), ['class' => 'avatar']) ?>
                    <div class="information">
                        <div class="username">
                            <?= h($this->request->session()->read('Auth.User.username')) ?>
                            <?= $this->Html->link(
                                '<i class="fa fa-lock"></i>',
                                ['controller' => 'users', 'action' => 'logout', 'prefix' => false],
                                ['data-toggle' => 'tooltip', 'data-placement' => 'right', 'data-container' => 'body', 'title' => __d('admin', 'Logout'), 'escape' => false]
                            ) ?>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
                                <span class="sr-only">30% Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <?php if ($this->request->getParam('controller') == 'Admin' && $this->request->getParam('action') == 'home') : ?>
                <li class="active">
            <?php else : ?>
                <li>
            <?php endif; ?>
                <?= $this->Html->link(
                    __d(
                        'admin',
                        '{0} Dashboard {1}',
                        '<i class="fa fa-dashboard"></i>',
                        '<i class="fa fa-chevron-right"></i>'
                    ),
                    ['controller' => 'admin', 'action' => 'home', 'prefix' => 'admin'],
                    ['escape' => false]
                ) ?>
            </li>


            <?php if ($this->Acl->check(['controller' => 'articles', 'action' => 'index', 'prefix' => 'admin']) ||
                $this->Acl->check(['controller' => 'categories', 'action' => 'index', 'prefix' => 'admin']) ||
                $this->Acl->check(['controller' => 'attachments', 'action' => 'index', 'prefix' => 'admin']) ||
                $this->Acl->check(['controller' => 'polls', 'action' => 'index', 'prefix' => 'admin'])
            ) : ?>

                <?php if ($this->request->getParam('controller') == 'Articles'
                        || ($this->request->getParam('controller') == 'Categories' && $this->request->getParam('prefix') == 'admin')
                        || $this->request->getParam('controller') == 'Attachments'
                ) : ?>
                    <li class="active">
                <?php else : ?>
                    <li>
                <?php endif; ?>

                    <?= $this->Html->link(
                        __d(
                            'admin',
                            '{0} Blog {1}',
                            '<i class="fa fa-newspaper-o"></i>',
                            '<i class="fa fa-chevron-down"></i>'
                        ),
                        '#submenu-blog',
                        ['class' => 'active accordion-toggle collapsed', 'data-toggle' => 'collapse', 'escape' => false]
                    ) ?>

                    <ul id="submenu-blog" class="submenu nav collapse">
                        <?php if ($this->Acl->check(['controller' => 'articles', 'action' => 'index', 'prefix' => 'admin'])) : ?>
                            <?= ($this->request->getParam('controller') == 'Articles') ? '<li class="active">' : '<li>' ?>
                                <?= $this->Html->link(__d('admin', 'Manage Articles'), ['controller' => 'articles', 'action' => 'index',
                                        'prefix' => 'admin']) ?>
                            </li>
                        <?php endif; ?>

                        <?php if ($this->Acl->check(['controller' => 'categories', 'action' => 'index', 'prefix' => 'admin'])) : ?>
                            <?= ($this->request->getParam('controller') == 'Categories' && $this->request->getParam('prefix') == 'admin') ? '<li class="active">' : '<li>' ?>
                                <?= $this->Html->link(__d('admin', 'Manage Categories'), ['controller' => 'categories', 'action' => 'index',
                                    'prefix' => 'admin']) ?>
                            </li>
                        <?php endif; ?>

                        <?php if ($this->Acl->check(['controller' => 'attachments', 'action' => 'index', 'prefix' => 'admin'])) : ?>
                            <?= ($this->request->getParam('controller') == 'Attachments') ? '<li class="active">' : '<li>' ?>
                                <?= $this->Html->link(__d('admin', 'Manage Attachments'), ['controller' => 'attachments', 'action' => 'index',
                                    'prefix' => 'admin']) ?>
                            </li>
                        <?php endif; ?>

                        <?php if ($this->Acl->check(['controller' => 'polls', 'action' => 'index', 'prefix' => 'admin'])) : ?>
                            <?= ($this->request->getParam('controller') == 'Polls') ? '<li class="active">' : '<li>' ?>
                                <?= $this->Html->link(__d('admin', 'Manage Polls'), ['controller' => 'polls', 'action' => 'index', 'prefix' => 'admin']) ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($this->Acl->check(['controller' => 'users', 'action' => 'index', 'prefix' => 'admin'])) : ?>
                <?php if ($this->request->getParam('prefix') == 'admin' && $this->request->getParam('controller') == 'Users') : ?>
                    <li class="active">
                <?php else : ?>
                    <li>
                <?php endif; ?>
                    <?= $this->Html->link(
                        __d(
                            'admin',
                            '{0} Users {1}',
                            '<i class="fa fa-user"></i>',
                            '<i class="fa fa-chevron-right"></i>'
                        ),
                        ['controller' => 'users', 'action' => 'index', 'prefix' => 'admin'],
                        ['escape' => false]
                    ) ?>
                </li>
            <?php endif; ?>


            <?php if ($this->Acl->check(['controller' => 'groups', 'action' => 'index', 'prefix' => 'admin'])) : ?>
                <?php if ($this->request->getParam('controller') == 'Groups') : ?>
                    <li class="active">
                <?php else : ?>
                    <li>
                <?php endif; ?>
                    <?= $this->Html->link(
                        __d(
                            'admin',
                            '{0} Groups {1}',
                            '<i class="fa fa-users"></i>',
                            '<i class="fa fa-chevron-right"></i>'
                        ),
                        ['controller' => 'groups', 'action' => 'index', 'prefix' => 'admin'],
                        ['escape' => false]
                    ) ?>
                </li>
            <?php endif; ?>

            <?php if ($this->Acl->check(['controller' => 'settings', 'action' => 'index', 'prefix' => 'admin'])) : ?>
                <?php if ($this->request->getParam('controller') == 'Settings') : ?>
                    <li class="active">
                <?php else : ?>
                    <li>
                <?php endif; ?>
                    <?= $this->Html->link(
                        __d(
                            'admin',
                            '{0} Settings {1}',
                            '<i class="fa fa-cogs"></i>',
                            '<i class="fa fa-chevron-right"></i>'
                        ),
                        ['controller' => 'settings', 'action' => 'index', 'prefix' => 'admin'],
                        ['escape' => false]
                    ) ?>
                </li>
            <?php endif; ?>
        </ul>








        <ul class="sidebar-nav nav hidden-md hidden-lg">
            <li>
                <div class="sidebar-header">
                    <?= $this->Html->image(h($this->request->session()->read('Auth.User.avatar')), ['class' => 'avatar']) ?>
                </div>
            </li>

            <?php if ($this->request->getParam('controller') == 'Admin' && $this->request->getParam('action') == 'home') : ?>
                <li class="active">
            <?php else : ?>
                <li>
            <?php endif; ?>
                <?= $this->Html->link(
                    '<i class="fa fa-dashboard fa-2x"></i>',
                    ['controller' => 'admin', 'action' => 'home', 'prefix' => 'admin'],
                    ['escape' => false]
                ) ?>
            </li>

            <?php if ($this->Acl->check(['controller' => 'articles', 'action' => 'index', 'prefix' => 'admin']) ||
                $this->Acl->check(['controller' => 'categories', 'action' => 'index', 'prefix' => 'admin']) ||
                $this->Acl->check(['controller' => 'attachments', 'action' => 'index', 'prefix' => 'admin'])
            ) : ?>

                <?php if ($this->request->getParam('controller') == 'Articles'
                        || $this->request->getParam('controller') == 'Categories'
                        || $this->request->getParam('controller') == 'Attachments'
                ) : ?>
                    <li class="active">
                <?php else : ?>
                    <li>
                <?php endif;?>
                    <?= $this->Html->link('<i class="fa fa-newspaper-o fa-2x"></i>', '#', ['class' => 'dropdown-toggle',
                            'data-toggle' => 'dropdown', 'escape' => false]) ?>

                    <ul class="dropdown-menu">
                        <?php if ($this->Acl->check(['controller' => 'articles', 'action' => 'index', 'prefix' => 'admin'])) : ?>
                            <?= ($this->request->getParam('controller') == 'Articles') ? '<li class="active">' : '<li>' ?>
                                <?= $this->Html->link(__d('admin', 'Manage Articles'), ['controller' => 'articles', 'action' => 'index',
                                        'prefix' => 'admin']) ?>
                            </li>
                        <?php endif; ?>

                        <?php if ($this->Acl->check(['controller' => 'categories', 'action' => 'index', 'prefix' => 'admin'])) : ?>
                            <?= ($this->request->getParam('controller') == 'Categories') ? '<li class="active">' : '<li>' ?>
                                <?= $this->Html->link(__d('admin', 'Manage Categories'), ['controller' => 'categories', 'action' => 'index',
                                    'prefix' => 'admin']) ?>
                            </li>
                        <?php endif; ?>

                        <?php if ($this->Acl->check(['controller' => 'attachments', 'action' => 'index', 'prefix' => 'admin'])) : ?>
                            <?= ($this->request->getParam('controller') == 'Attachments') ? '<li class="active">' : '<li>' ?>
                                <?= $this->Html->link(__d('admin', 'Manage Attachments'), ['controller' => 'attachments', 'action' => 'index',
                                    'prefix' => 'admin']) ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($this->Acl->check(['controller' => 'users', 'action' => 'index', 'prefix' => 'admin'])) : ?>
                <?php if ($this->request->getParam('prefix') == 'admin' && $this->request->getParam('controller') == 'Users') : ?>
                    <li class="active">
                <?php else : ?>
                    <li>
                <?php endif;?>
                    <?= $this->Html->link(
                        '<i class="fa fa-user fa-2x"></i>',
                        ['controller' => 'users', 'action' => 'index', 'prefix' => 'admin'],
                        ['escape' => false]
                    ) ?>
                </li>
            <?php endif; ?>


            <?php if ($this->Acl->check(['controller' => 'groups', 'action' => 'index', 'prefix' => 'admin'])) : ?>
                <?php if ($this->request->getParam('controller') == 'Groups') : ?>
                    <li class="active">
                <?php else :?>
                    <li>
                <?php endif;?>
                    <?= $this->Html->link(
                        '<i class="fa fa-users fa-2x"></i>',
                        ['controller' => 'groups', 'action' => 'index', 'prefix' => 'admin'],
                        ['escape' => false]
                    ) ?>
                </li>
            <?php endif; ?>

            <?php if ($this->Acl->check(['controller' => 'settings', 'action' => 'index', 'prefix' => 'admin'])) : ?>
                <?php if ($this->request->getParam('controller') == 'Settings') : ?>
                    <li class="active">
                <?php else : ?>
                    <li>
                <?php endif; ?>
                    <?= $this->Html->link(
                        '<i class="fa fa-cogs fa-2x"></i>',
                        ['controller' => 'settings', 'action' => 'index', 'prefix' => 'admin'],
                        ['escape' => false]
                    ) ?>
                </li>
            <?php endif; ?>
        </ul>

    </div>
</div>
