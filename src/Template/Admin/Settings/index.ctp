<?= $this->assign('title', __d('admin', 'Settings')) ?>

<div class="content-wrapper">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render(); ?>
        </div>

        <div class="col-md-12 heading">
            <h1 class="page-header">
                <i class="fa fa-cogs"></i> <?= __d('admin', 'Settings') ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Dashboard', '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
                            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <?= __d('admin', '{0} Settings', '<i class="fa fa-cogs"></i>') ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel panel-forum">
                <div class="panel-heading">
                    <div class="hr-divider hr-divider-panel">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __d('admin', 'Settings') ?>
                        </h3>
                    </div>
                </div>

                <div class="panel-body">
                    <?php if (\Cake\Core\Configure::read('debug') === true): ?>
                        <div class="panel-body-header">
                            <?= $this->Html->link(__d('admin', '{0} New Setting', '<i class="fa fa-plus"></i>'),
                            ['action' => 'create'],
                            ['class' => 'btn btn-primary-outline', 'escape' => false]) ?>
                        </div>
                    <?php endif; ?>

                    <?php if($settings->toArray()): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?= __d('admin', '#Id') ?></th>
                                    <th><?= __d('admin', 'Name') ?></th>
                                    <th><?= __d('admin', 'Value') ?></th>
                                    <th><?= __d('admin', 'Value Type') ?></th>
                                    <th><?= __d('admin', 'Last updated by') ?></th>
                                    <th><?= __d('admin', 'Last Updated') ?></th>
                                    <th><?= __d('admin', 'Created') ?></th>
                                    <th><?= __d('admin', 'Action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($settings as $setting):?>
                                    <tr>
                                        <td>
                                            #<?= h($setting->id) ?>
                                        </td>
                                        <td>
                                            <?= h($setting->name) ?>
                                        </td>
                                        <td>
                                            <code>
                                            <?php if (!is_null($setting->value_str)): ?>
                                                <?= h($setting->value) ?>
                                            <?php elseif (!is_null($setting->value_int)): ?>
                                                <?= h($setting->value) ?>
                                            <?php elseif (!is_null($setting->value_bool)): ?>
                                                <?= $setting->value ? 'true' : 'false' ?>
                                            <?php else: ?>
                                                <?= __d('admin', 'null') ?>
                                            <?php endif; ?>
                                            </code>
                                        </td>
                                        <td>
                                            <?php if (!is_null($setting->value_str)): ?>
                                                <?= __d('admin', 'String') ?>
                                            <?php elseif (!is_null($setting->value_int)): ?>
                                                <?= __d('admin', 'Integer') ?>
                                            <?php elseif (!is_null($setting->value_bool)): ?>
                                                <?= __d('admin', 'Boolean') ?>
                                            <?php else: ?>
                                                <?= __d('admin', 'null') ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!is_null($setting->last_updated_user)): ?>
                                                <?= $this->Html->link(
                                                    $setting->last_updated_user->full_name,
                                                    [
                                                        '_name' => 'users-edit',
                                                        'slug' => $setting->last_updated_user->username,
                                                        'id' => $setting->last_updated_user->id,
                                                        'prefix' => 'admin'
                                                    ]
                                                ) ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= $setting->modified->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT]) ?>
                                        </td>
                                        <td>
                                            <?= $setting->created->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT]) ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit"></i>',
                                                [
                                                    '_name' => 'settings-edit',
                                                    'id' => $setting->id
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-primary-outline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Edit this setting'),
                                                    'escape' => false
                                                ]
                                            ) ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-remove"></i>',
                                                '#',
                                                [
                                                    'class' => 'btn btn-sm btn-danger-outline',
                                                    'data-toggle' => 'modal',
                                                    'data-target' => '#modalDeleteSetting' . $setting->id,
                                                    'escape' => false
                                                ]
                                            ) ?>

                                            <div class="modal fade" id="modalDeleteSetting<?= h($setting->id) ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                <span aria-hidden="true">&times;</span>
                                                                <span class="sr-only"><?= __d('admin', 'Close') ?></span>
                                                            </button>
                                                            <h4 class="modal-title">
                                                                <?= __d('admin', 'Delete a Setting') ?>
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>
                                                                <?= __d('admin', 'Are you sure you want delete this setting <strong>{0}</strong> ?', h($setting->name)) ?>
                                                            </p>
                                                        </div>
                                                        <div class="modal-actions">
                                                            <?= $this->Html->link(__d('admin', '{0} Yes, I confirm !', '<i class="fa fa-remove"></i>'), ['_name' => 'settings-delete', 'id' => $setting->id], ['class' => 'ma ma-btn ma-btn-danger', 'escape' => false]) ?>
                                                            <button type="button" class="ma ma-btn ma-btn-primary" data-dismiss="modal"><?= __d('admin', '{0} Close', '<i class="fa fa-remove"></i>') ?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>

                        <div class="pagination-centered">
                            <ul class="pagination">
                                <?php if ($this->Paginator->hasPrev()): ?>
                                    <?= $this->Paginator->prev('«'); ?>
                                <?php endif; ?>
                                <?= $this->Paginator->numbers(['modulus' => 5]); ?>
                                <?php if ($this->Paginator->hasNext()): ?>
                                    <?= $this->Paginator->next('»'); ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="infobox infobox-primary">
                            <h4>
                                <?= __d('admin', 'No settings was found.') ?>
                            </h4>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>

    </div>
</div>
