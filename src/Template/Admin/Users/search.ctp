<?= $this->assign('title', __d('admin', 'Search Users')) ?>

<div class="content-wrapper">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render() ?>
        </div>

        <div class="col-md-12 heading">
            <h1 class="page-header">
                <i class="fa fa-search"></i> <?= __d('admin', 'Search Users') ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Dashboard', '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
                            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Manage Users', '<i class="fa fa-user"></i>'), ['controller' => 'users',
                            'action' => 'index', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <i class="fa fa-search"></i> <?= __d('admin', 'Search Users') ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel panel-forum">
                <div class="panel-heading">
                    <div class="hr-divider hr-divider-panel">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __d('admin', 'Search Users') ?>
                        </h3>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="panel-body-header">
                        <p>
                            <?= __d('admin', 'Search : {0}', h($keyword)) ?>
                        </p>
                        <p>
                            <?= __d('admin', 'Type : {0}', h($type)) ?>
                        </p>
                    </div>

                    <?php if($users->toArray()): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?= __d('admin', '#Id') ?></th>
                                    <th><?= __d('admin', 'Username') ?></th>
                                    <th><?= __d('admin', 'Email') ?></th>
                                    <th><?= __d('admin', 'Full name') ?></th>
                                    <th><?= __d('admin', 'Last login') ?></th>
                                    <th><?= __d('admin', 'Last login IP') ?></th>
                                    <th><?= __d('admin', 'Created') ?></th>
                                    <th><?= __d('admin', 'Action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user): ?>
                                    <tr>
                                        <td>
                                            #<?= $user->id ?>
                                        </td>
                                        <td>
                                            <?= h($user->username) ?>
                                        </td>
                                        <td>
                                            <?= h($user->email) ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link($user->full_name, ['_name' => 'users-edit',
                                                    'slug' => $user->username, 'id' => $user->id]) ?>
                                        </td>
                                        <td>
                                            <?= $this->Time->i18nFormat($user->last_login); ?>
                                        </td>
                                        <td>
                                            <?= h($user->last_login_ip) ?>
                                        </td>
                                        <td>
                                            <?= $this->Time->i18nFormat($user->created); ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit"></i>',
                                                [
                                                    '_name' => 'users-edit',
                                                    'slug' => $user->username,
                                                    'id' => $user->id
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-primary-outline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Edit this user'),
                                                    'escape' => false
                                                ]
                                            ) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <div class="pagination-centered">
                            <ul class="pagination">
                                <?php if ($this->Paginator->hasPrev()): ?>
                                    <?= $this->Paginator->prev('«') ?>
                                <?php endif; ?>
                                <?= $this->Paginator->numbers(['modulus' => 5]) ?>
                                <?php if ($this->Paginator->hasNext()): ?>
                                    <?= $this->Paginator->next('»') ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="infobox infobox-info">
                            <h4><?= __d('admin', 'No results found') ?></h4>
                            <p>
                                <?= __d('admin', 'No users were found for your search, please try again with a different word.') ?>
                            </p>
                            <?= __d('admin', 'Suggestions :') ?>
                            <ul>
                                <li>
                                    <?= __d('admin', 'Check the spelling of your search words.') ?>
                                </li>
                                <li>
                                    <?= __d('admin', 'Try more general keywords.') ?>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>


    </div>
</div>
