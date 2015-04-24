<?= $this->assign('title', __d('admin', 'Forum : Manage Categories')) ?>

<div class="content-wrapper interface-blur">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render() ?>
        </div>

        <div class="col-md-12 heading">
            <h1 class="page-header">
                <i class="fa fa-list"></i> <?= __d('admin', 'Forum : Manage Categories') ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Forum', '<i class="fa fa-trophy"></i>'), ['controller' => 'forum',
                    'action' => 'home', 'prefix' => 'admin/forum'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <i class="fa fa-list"></i> <?= __d('admin', 'Manage Categories') ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <?= __d('admin', 'Manage Categories') ?>
                </div>

                <div class="panel-body">

                    <div class="panel-body-header">
                        <?= $this->Html->link(__d('admin', '{0} New Category', '<i class="fa fa-plus"></i>'),
                        ['controller' => 'categories', 'action' => 'add', 'prefix' => 'admin/forum'],
                        ['class' => 'btn btn-primary', 'escape' => false]) ?>
                    </div>

                    <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?= __d('admin', '#Id') ?></th>
                                    <th><?= __d('admin', 'Title') ?></th>
                                    <th><?= __d('admin', 'Action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($categories as $index => $category):?>
                                    <tr>
                                        <td>
                                            #<?= $index ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link(
                                                $category,
                                                [
                                                    '_name' => 'forum-categories',
                                                    'slug' => str_replace('&nbsp;', '', $category),
                                                    'id' => $index,
                                                    'prefix' => 'forum'
                                                ],
                                                [
                                                    'escape' => false
                                                ]
                                            ) ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-arrow-up"></i>',
                                                [
                                                    '_name' => 'forum-categories-moveup',
                                                    'id' => $index
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-primary',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Move up this category'),
                                                    'escape' => false
                                                ]
                                            ) ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-arrow-down"></i>',
                                                [
                                                    '_name' => 'forum-categories-movedown',
                                                    'id' => $index
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-primary',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Move down this category'),
                                                    'escape' => false
                                                ]
                                            ) ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit"></i>',
                                                [
                                                    '_name' => 'forum-categories-edit',
                                                    'id' => $index
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-primary',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Edit this category'),
                                                    'escape' => false
                                                ]
                                            ) ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-remove"></i>',
                                                [
                                                    '_name' => 'forum-categories-delete',
                                                    'id' => $index
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-danger',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Delete this category'),
                                                    'escape' => false
                                                ]
                                            ) ?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>

                </div>

            </div>
        </div>

    </div>
</div>
