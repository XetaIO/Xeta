<?= $this->assign('title', __d('admin', 'Add an Attachment')) ?>

<div class="content-wrapper">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render(); ?>
        </div>

        <div class="col-md-12 heading">
            <h1 class="page-header">
                <i class="fa fa-plus"></i> <?= __d('admin', 'Add an Attachment') ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Dashboard', '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
                    'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Manage Attachments', '<i class="fa fa-file-archive-o"></i>'), ['controller' => 'attachments',
                    'action' => 'index', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <i class="fa fa-plus"></i> <?= __d('admin', 'Add an Attachment') ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="hr-divider hr-divider-panel">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __d('admin', 'Add an Attachment') ?>
                        </h3>
                    </div>
                </div>

                <div class="panel-body">
                    <?= $this->Form->create($attachment, [
                        'class' => 'form-horizontal',
                        'role' => 'form',
                        'type' => 'file'
                    ]) ?>
                    <div class="form-group">
                        <?= $this->Form->label('article_id', __d('admin', 'Article'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <?= $this->Form->input('article_id', ['options' => $articles, 'class' => 'form-control', 'label' => false]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->label('url_file', __d('admin', 'File'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-8">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <span class="btn btn-primary-outline btn-file">
                                    <span class="fileinput-new"><?= __d('admin', '{0} Select file', '<i class="fa fa-plus"></i>') ?></span>
                                    <?= $this->Form->input('url_file', ['type' => 'file', 'label' => false, 'templates' => [
                                        'inputContainer' => '{{content}}</span>',
                                        'inputContainerError' => '{{content}}</span>{{error}}'
                                    ]]) ?>
                                </span>
                                <span class="fileinput-filename"></span>
                                <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
                            </div>
                        </div>
                    </div>

                    <?= $this->Form->button(__d('admin', '{0} Create Attachment', '<i class="fa fa-plus"></i>'), ['class' => 'col-md-offset-2 btn btn-primary-outline']) ?>
                    <?= $this->Form->end() ?>
                </div>

            </div>
        </div>

    </div>
</div>
