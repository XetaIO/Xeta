<?= $this->assign('title', __d('admin', 'Edit a Category')) ?>

<div class="content-wrapper">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render() ?>
        </div>

        <div class="col-md-12 heading">
            <h1 class="page-header">
                <i class="fa fa-tag"></i> <?= __d('admin', 'Edit a Category') ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Dashboard', '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
                            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Manage Categories', '<i class="fa fa-tag"></i>'), ['controller' => 'categories',
                            'action' => 'index', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> <?= __("Edit a Category") ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="hr-divider hr-divider-panel">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __d('admin', 'Edit a Category') ?>
                        </h3>
                    </div>
                </div>

                <div class="panel-body">
                    <?= $this->Form->create($category, [
                        'class' => 'form-horizontal',
                        'role' => 'form'
                    ]) ?>
                    <div class="form-group">
                        <?= $this->Form->label('title', __d('admin', 'Title'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <?= $this->Form->input('title', ['class' => 'form-control', 'label' => false]) ?>
                        </div>
                    </div>
                    <?= $this->I18n->i18nInput($category, 'title', ['class' => 'form-control']); ?>
                    <div class="form-group">
                        <?= $this->Form->label('description', __d('admin', 'Description'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <?= $this->Form->input('description', ['type' => 'textarea', 'class' => 'form-control', 'label' => false]) ?>
                        </div>
                    </div>
                    <?= $this->I18n->i18nInput($category, 'description', ['class' => 'form-control']); ?>

                    <?= $this->Form->button(__d('admin', '{0} Edit Category', '<i class="fa fa-edit"></i>'), ['class' => 'col-md-offset-2 btn btn-primary-outline']) ?>
                    <?= $this->Form->end() ?>

                </div>

            </div>
        </div>


    </div>
</div>
