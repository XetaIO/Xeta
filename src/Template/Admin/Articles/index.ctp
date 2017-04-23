<?= $this->assign('title', __d('admin', 'Manage Articles')) ?>

<div class="content-wrapper">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render() ?>
        </div>

        <div class="col-md-12 heading">
            <h1 class="page-header">
                <i class="fa fa-newspaper-o"></i> <?= __d('admin', 'Manage Articles') ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Dashboard', '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
                            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <i class="fa fa-newspaper-o"></i> <?= __d('admin', 'Manage Articles') ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="hr-divider hr-divider-panel">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __d('admin', 'Manage Articles') ?>
                        </h3>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="panel-body-header">
                        <?= $this->Html->link(__d('admin', '{0} New Article', '<i class="fa fa-plus"></i>'),
                            ['controller' => 'articles', 'action' => 'add', 'prefix' => 'admin'],
                            ['class' => 'btn btn-primary-outline', 'escape' => false]) ?>
                    </div>

                    <?php if ($articles->toArray()): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?= __d('admin', '#Id') ?></th>
                                    <th><?= __d('admin', 'Author') ?></th>
                                    <th><?= __d('admin', 'Title') ?></th>
                                    <th><?= __d('admin', 'Category') ?></th>
                                    <th><?= __d('admin', 'Is display') ?></th>
                                    <th><?= __d('admin', 'Created') ?></th>
                                    <th><?= __d('admin', 'Action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($articles as $article) : ?>
                                    <tr>
                                        <td>
                                            #<?= $article->id ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link($article->user->full_name, ['_name' => 'users-edit',
                                                    'slug' => $article->user->username, 'id' => $article->user->id]) ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link(
                                                $this->Text->truncate(
                                                    $article->title,
                                                    35,
                                                    [
                                                        'ellipsis' => '...',
                                                        'exact' => false
                                                    ]
                                                ),
                                                [
                                                    '_name' => 'blog-article',
                                                    'prefix' => false,
                                                    'slug' => $article->title,
                                                    'id' => $article->id,
                                                    '?' => ['page' => $article->last_page]
                                                ],
                                                [
                                                    'target' => '_blank',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'View this Article'),
                                                ]
                                            ) ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link($article->blog_category->title, ['_name' => 'categories-edit',
                                                    'slug' => $article->blog_category->title, 'id' => $article->blog_category->id]) ?>
                                        </td>
                                        <td>
                                            <?php if ($article->is_display): ?>
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
                                            <?= $this->Time->i18nFormat($article->created); ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit"></i>',
                                                [
                                                    '_name' => 'articles-edit',
                                                    'slug' => $article->title,
                                                    'id' => $article->id
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-primary-outline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Edit this article'),
                                                    'escape' => false
                                                ]
                                            )?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-remove"></i>',
                                                [
                                                    '_name' => 'articles-delete',
                                                    'slug' => $article->title,
                                                    'id' => $article->id
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-danger-outline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Delete this article'),
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
                                <?= __d('admin', 'No articles was found.') ?>
                            </h4>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>


    </div>
</div>
