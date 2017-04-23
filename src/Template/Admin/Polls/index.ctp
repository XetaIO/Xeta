<?= $this->assign('title', __d('admin', 'Manage Polls')) ?>

<div class="content-wrapper">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render(); ?>
        </div>

        <div class="col-md-12 heading">
            <h1 class="page-header">
                <i class="fa fa-bar-chart"></i> <?= __d('admin', 'Manage Polls') ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Dashboard', '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
                    'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <i class="fa fa-bar-chart"></i> <?= __d('admin', 'Manage Polls') ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="hr-divider hr-divider-panel">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __d('admin', 'Manage Polls') ?>
                        </h3>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="panel-body-header">
                        <?= $this->Html->link(
                            __d('admin', '{0} New Poll', '<i class="fa fa-plus"></i>'),
                            ['controller' => 'polls', 'action' => 'add', 'prefix' => 'admin'],
                            ['class' => 'btn btn-primary-outline', 'escape' => false]
                        )?>
                    </div>

                    <?php if ($polls->toArray()) : ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?= __d('admin', '#Id') ?></th>
                                    <th><?= __d('admin', 'Author') ?></th>
                                    <th><?= __d('admin', 'Article') ?></th>
                                    <th><?= __d('admin', 'Name') ?></th>
                                    <th><?= __d('admin', 'Is display') ?></th>
                                    <th><?= __d('admin', 'Votes count') ?></th>
                                    <th><?= __d('admin', 'Is timed') ?></th>
                                    <th><?= __d('admin', 'End date') ?></th>
                                    <th><?= __d('admin', 'Expired') ?></th>
                                    <th><?= __d('admin', 'Created') ?></th>
                                    <th><?= __d('admin', 'Action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($polls as $poll) : ?>
                                    <tr>
                                        <td>
                                            #<?= $poll->id ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link($poll->user->full_name, ['_name' => 'users-edit',
                                            'slug' => $poll->user->username, 'id' => $poll->user->id]) ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link(
                                                $this->Text->truncate(
                                                    $poll->blog_article->title,
                                                    60,
                                                    [
                                                        'ellipsis' => '...',
                                                        'exact' => false
                                                    ]
                                                ),
                                                [
                                                    '_name' => 'blog-article',
                                                    'slug' => $poll->blog_article->title,
                                                    'id' => $poll->blog_article->id,
                                                    '?' => ['page' => $poll->blog_article->last_page]
                                                ]
                                            ) ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link(
                                                $this->Text->truncate(
                                                    $poll->name,
                                                    60,
                                                    [
                                                        'ellipsis' => '...',
                                                        'exact' => false
                                                    ]
                                                ),
                                                [
                                                    '_name' => 'polls-edit',
                                                    'slug' => $poll->name,
                                                    'id' => $poll->id
                                                ]
                                            ) ?>
                                        </td>
                                        <td>
                                            <?php if ($poll->is_display): ?>
                                                <span class="label label-success">
                                                    <?= __d('admin', 'Yes') ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="label label-danger">
                                                    <?= __d('admin', 'No') ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= $poll->user_count ?>
                                        </td>
                                        <td>
                                            <?php if ($poll->is_timed): ?>
                                                <span class="label label-success">
                                                    <?= __d('admin', 'Yes') ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="label label-danger">
                                                    <?= __d('admin', 'No') ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                        <?php if (!is_null($poll->end_date)) : ?>
                                            <?= $this->Time->i18nFormat($poll->end_date); ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                        </td>
                                        <td>
                                        <?php if ($poll->is_timed) : ?>
                                            <?php if ($poll->end_date < new \Cake\I18n\Time()): ?>
                                                <span class="label label-success">
                                                    <?= __d('admin', 'Yes') ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="label label-danger">
                                                    <?= __d('admin', 'No') ?>
                                                </span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= $this->Time->i18nFormat($poll->created); ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit"></i>',
                                                [
                                                    '_name' => 'polls-edit',
                                                    'slug' => $poll->name,
                                                    'id' => $poll->id
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-primary-outline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Edit this poll'),
                                                    'escape' => false
                                                ]
                                            )?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-remove"></i>',
                                                [
                                                    '_name' => 'polls-delete',
                                                    'slug' => $poll->name,
                                                    'id' => $poll->id
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-danger-outline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Delete this poll'),
                                                    'escape' => false
                                                ]
                                            )?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>

                        <div class="pagination-centered">
                            <ul class="pagination">
                                <?php if ($this->Paginator->hasPrev()) : ?>
                                    <?= $this->Paginator->prev('«'); ?>
                                <?php endif; ?>
                                <?= $this->Paginator->numbers(['modulus' => 5]); ?>
                                <?php if ($this->Paginator->hasNext()) : ?>
                                    <?= $this->Paginator->next('»'); ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php else : ?>
                        <div class="infobox infobox-primary">
                            <h4>
                                <?= __d('admin', 'No polls was found.') ?>
                            </h4>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>
</div>
