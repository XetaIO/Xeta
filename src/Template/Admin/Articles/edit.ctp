<?php
use Cake\I18n\I18n;
?>
<?= $this->assign('title', __d('admin', 'Edit an Article')) ?>

<?php $this->start('scriptBottom');

echo $this->Html->script('ckeditor/ckeditor') ?>
<script type="text/javascript">
    CKEDITOR.replace('articleBox', {
        customConfig: 'config/article.js'
    });
</script>
<?= $this->I18n->i18nScript(['file' => 'article']); ?>

<?php $this->end() ?>

<div class="content-wrapper interface-blur">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render(); ?>
        </div>

        <div class="col-md-12 heading">
            <h1 class="page-header">
                <i class="fa fa-newspaper-o"></i> <?= __d('admin', 'Edit an Article') ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Dashboard', '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
                            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Manage Articles', '<i class="fa fa-newspaper-o"></i>'), ['controller' => 'articles',
                            'action' => 'index', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> <?= __d('admin', 'Edit an Article') ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel panel-forum">
                <div class="panel-heading">
                    <div class="hr-divider hr-divider-panel">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __d('admin', 'Edit an Article'); ?>
                        </h3>
                    </div>
                </div>

                <div class="panel-body">
                    <?= $this->Form->create($article, [
                        'class' => 'form-horizontal',
                        'role' => 'form'
                    ]) ?>
                    <div class="form-group">
                        <?= $this->Form->label('_translations.' . I18n::defaultLocale() . '.title', __d('admin', 'Title'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <?= $this->Form->input('_translations.' . I18n::defaultLocale() . '.title', ['class' => 'form-control', 'label' => false]) ?>
                        </div>
                    </div>
                    <?= $this->I18n->i18nInput($article, 'title', ['class' => 'form-control']); ?>
                    <div class="form-group">
                        <?= $this->Form->label('category_id', __d('admin', 'Category'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <?= $this->Form->input('category_id', ['options' => $categories, 'class' => 'form-control', 'label' => false]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->label('is_display', __d('admin', 'Is display'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <?= $this->Form->radio(
                                'is_display',
                                [
                                    '1' => __d('admin', 'Yes'),
                                    '0' => __d('admin', 'No')
                                ],
                                [
                                    'legend' => false,
                                    'class' => 'form-control'
                                ]
                            ) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->label('_translations.' . I18n::defaultLocale() . '.content', __d('admin', 'Content'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-8">
                            <?= $this->Form->input(
                                '_translations.' . I18n::defaultLocale() . '.content',
                                [
                                    'label' => false,
                                    'class' => 'form-control articleBox',
                                    'id' => 'articleBox'
                                ]
                            ) ?>
                        </div>
                    </div>
                    <?= $this->I18n->i18nInput($article, 'content', ['CkEditor' => true, 'class' => 'form-control'], 'col-sm-8'); ?>

                    <?= $this->Form->button(__d('admin', '{0} Edit Article', '<i class="fa fa-edit"></i>'), ['class' => 'col-md-offset-2 btn btn-primary-outline']) ?>
                    <?= $this->Form->end() ?>

                </div>

            </div>
        </div>


    </div>
</div>
