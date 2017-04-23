<?= $this->assign('title', __d('admin', 'Manage Groups')) ?>

<div class="content-wrapper">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render() ?>
        </div>

        <div class="col-md-12 heading">
            <h1 class="page-header">
                <i class="fa fa-users"></i> <?= __d('admin', 'Manage Groups') ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Dashboard', '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
                    'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <i class="fa fa-users"></i> <?= __d('admin', 'Manage Groups') ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="hr-divider hr-divider-panel">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __d('admin', 'Manage Groups') ?>
                        </h3>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="panel-body-header">
                        <?= $this->Html->link(
                            __d('admin', '{0} New Group', '<i class="fa fa-plus"></i>'),
                            ['controller' => 'groups', 'action' => 'add', 'prefix' => 'admin'],
                            ['class' => 'btn btn-primary-outline', 'escape' => false]
                        )?>
                    </div>

                    <?php if ($groups->toArray()) : ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?= __d('admin', '#Id') ?></th>
                                    <th><?= __d('admin', 'Name') ?></th>
                                    <th><?= __d('admin', 'Created') ?></th>
                                    <th><?= __d('admin', 'Action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($groups as $group) : ?>
                                    <tr>
                                        <td>
                                            #<?= $group->id ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link($group->name, ['_name' => 'groups-edit',
                                            'id' => $group->id]) ?>
                                        </td>
                                        <td>
                                            <?= $this->Time->i18nFormat($group->created); ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit"></i>',
                                                [
                                                    '_name' => 'groups-edit',
                                                    'id' => $group->id
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-primary-outline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Edit this group'),
                                                    'escape' => false
                                                ]
                                            )?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-remove"></i>',
                                                [
                                                    '_name' => 'groups-delete',
                                                    'id' => $group->id
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-danger-outline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Delete this group'),
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
                        <div class="infobox infobox-info">
                            <h4>
                                <?= __d('admin', 'No groups was found.') ?>
                            </h4>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>
</div>
