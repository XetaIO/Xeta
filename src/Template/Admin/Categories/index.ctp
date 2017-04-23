<?= $this->assign('title', __d('admin', 'Manage Categories')) ?>

<div class="content-wrapper">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render(); ?>
        </div>

        <div class="col-md-12 heading">
            <h1 class="page-header">
                <i class="fa fa-tag"></i> <?= __d('admin', 'Manage Categories') ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Dashboard', '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
                            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <i class="fa fa-tag"></i> <?= __d('admin', 'Manage Categories') ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="hr-divider hr-divider-panel">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __d('admin', 'Manage Categories') ?>
                        </h3>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="panel-body-header">
                        <?= $this->Html->link(
                            __d('admin', '{0} New Category', '<i class="fa fa-plus"></i>'),
                            ['controller' => 'categories', 'action' => 'add', 'prefix' => 'admin'],
                            ['class' => 'btn btn-primary-outline', 'escape' => false]
                        ) ?>
                    </div>

                    <?php if ($categories->toArray()) : ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?= __d('admin', '#Id') ?></th>
                                    <th><?= __d('admin', 'Title') ?></th>
                                    <th><?= __d('admin', 'Description') ?></th>
                                    <th><?= __d('admin', 'Articles') ?></th>
                                    <th><?= __d('admin', 'Created') ?></th>
                                    <th><?= __d('admin', 'Action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category) : ?>
                                    <tr>
                                        <td>
                                            #<?= $category->id ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link(
                                                $this->Text->truncate(
                                                    $category->title,
                                                    35,
                                                    [
                                                        'ellipsis' => '...',
                                                        'exact' => false
                                                    ]
                                                ),
                                                [
                                                    '_name' => 'blog-category',
                                                    'slug' => $category->title,
                                                    'id' => $category->id,
                                                    'prefix' => false
                                                ],
                                                [
                                                    'target' => '_blank',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'View this category and its articles'),
                                                ]
                                            ) ?>
                                        </td>
                                        <td>
                                            <?= $this->Text->truncate(
                                                h($category->description),
                                                55,
                                                [
                                                    'ellipsis' => '...',
                                                    'exact' => false
                                                ]
                                            ) ?>
                                        </td>
                                        <td>
                                            <?= $category->article_count_format ?>
                                        </td>
                                        <td>
                                            <?= $this->Time->i18nFormat($category->created); ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit"></i>',
                                                [
                                                    '_name' => 'categories-edit',
                                                    'slug' => $category->title,
                                                    'id' => $category->id
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-primary-outline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Edit this category'),
                                                    'escape' => false
                                                ]
                                            )?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-remove"></i>',
                                                [
                                                    '_name' => 'categories-delete',
                                                    'slug' => $category->title,
                                                    'id' => $category->id
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-danger-outline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Delete this category'),
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
                                <?= __d('admin', 'No categories was found.') ?>
                            </h4>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    </div>
</div>
