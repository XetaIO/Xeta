<?= $this->assign('title', __d('admin', 'Manage Attachments')) ?>

<div class="content-wrapper">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render(); ?>
        </div>

        <div class="col-md-12 heading">
            <h1 class="page-header">
                <i class="fa fa-file-archive-o"></i> <?= __d('admin', 'Manage Attachments') ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Dashboard', '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
                    'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <i class="fa fa-file-archive-o"></i> <?= __d('admin', 'Manage Attachments') ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="hr-divider hr-divider-panel">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __d('admin', 'Manage Attachments') ?>
                        </h3>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="panel-body-header">
                        <?= $this->Html->link(
                            __d('admin', '{0} New Attachment', '<i class="fa fa-plus"></i>'),
                            ['controller' => 'attachments', 'action' => 'add', 'prefix' => 'admin'],
                            ['class' => 'btn btn-primary-outline', 'escape' => false]
                        )?>
                    </div>

                    <?php if ($attachments->toArray()) : ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><?= __d('admin', '#Id') ?></th>
                                    <th><?= __d('admin', 'Author') ?></th>
                                    <th><?= __d('admin', 'Article') ?></th>
                                    <th><?= __d('admin', 'Name') ?></th>
                                    <th><?= __d('admin', 'Size') ?></th>
                                    <th><?= __d('admin', 'Extension') ?></th>
                                    <th><?= __d('admin', 'Download') ?></th>
                                    <th><?= __d('admin', 'Created') ?></th>
                                    <th><?= __d('admin', 'Action') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($attachments as $attachment) : ?>
                                    <tr>
                                        <td>
                                            #<?= $attachment->id ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link($attachment->user->full_name, ['_name' => 'users-edit',
                                            'slug' => $attachment->user->username, 'id' => $attachment->user->id]) ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link(
                                                $this->Text->truncate(
                                                    $attachment->blog_article->title,
                                                    35,
                                                    [
                                                        'ellipsis' => '...',
                                                        'exact' => false
                                                    ]
                                                ),
                                                [
                                                    '_name' => 'blog-article',
                                                    'prefix' => false,
                                                    'slug' => $attachment->blog_article->title,
                                                    'id' => $attachment->blog_article->id,
                                                    '?' => ['page' => $attachment->blog_article->last_page]
                                                ],
                                                [
                                                    'target' => '_blank',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'View this Article'),
                                                ]
                                            ) ?>
                                        </td>
                                        <td>
                                            <?= h($attachment->name) ?>
                                        </td>
                                        <td>
                                            <?= $this->Number->toReadableSize($attachment->size) ?>
                                        </td>
                                        <td>
                                            <?= h($attachment->extension) ?>
                                        </td>
                                        <td>
                                            <?= $this->Number->format($attachment->download, ['precision' => 2, 'locale' => 'en_US']) ?>
                                        </td>
                                        <td>
                                            <?= $this->Time->i18nFormat($attachment->created); ?>
                                        </td>
                                        <td>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-download"></i>',
                                                [
                                                    '_name' => 'attachment-download',
                                                    'type' => 'blog',
                                                    'id' => $attachment->id
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-info-outline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Download this attachment'),
                                                    'escape' => false
                                                ]
                                            )?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-edit"></i>',
                                                [
                                                    '_name' => 'attachments-edit',
                                                    'id' => $attachment->id
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-primary-outline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Edit this attachment'),
                                                    'escape' => false
                                                ]
                                            )?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-remove"></i>',
                                                [
                                                    '_name' => 'attachments-delete',
                                                    'id' => $attachment->id
                                                ],
                                                [
                                                    'class' => 'btn btn-sm btn-danger-outline',
                                                    'data-toggle' => 'tooltip',
                                                    'title' => __d('admin', 'Delete this attachment'),
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
                                <?= __d('admin', 'No attachments was found.') ?>
                            </h4>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>


    </div>
</div>
