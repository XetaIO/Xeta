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
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Settings', '<i class="fa fa-flag-o"></i>'), ['controller' => 'settings',
                            'action' => 'index', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <?= __d('admin', '{0} Create', '<i class="fa fa-plus"></i>') ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="hr-divider hr-divider-panel">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __d('admin', 'Add a Setting') ?>
                        </h3>
                    </div>
                </div>

                <div class="panel-body">

                    <?= $this->Form->create($setting, [
                        'class' => 'form-horizontal',
                        'role' => 'form'
                    ]) ?>
                        <div class="form-group">
                            <?= $this->Form->label('name', __d('admin', 'Name'), ['class' => 'col-sm-2 control-label']) ?>
                            <div class="col-sm-10">
                                <p class="form-control-static">
                                    <?= $this->Form->input('name', ['label' => false, 'class' => 'form-control']) ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('value_int', __d('admin', 'Value Int'), ['class' => 'col-sm-2 control-label']) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->input('value_int', ['label' => false, 'class' => 'form-control']) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('value_bool', __d('admin', 'Value Bool'), ['class' => 'col-sm-2 control-label']) ?>
                            <div class="col-sm-5 checkbox checkbox-primary">
                                <?= $this->Form->checkbox('value_bool', ['id' =>'value-bool']) ?>
                                <?= $this->Form->label('value_bool', __d('admin', 'Checked for <code>true</code> or uncheck for <code>false</code> and <code>void</code>'), ['escape' => false]) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('value_str', __d('admin', 'Value Str'), ['class' => 'col-sm-2 control-label']) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->input('value_str', ['label' => false, 'class' => 'form-control']) ?>
                                <span class="text-danger">
                                    <?= __d('admin', '<strong>Note</strong> : You need to configure only one of the <strong>value_int</strong>, <strong>value_bool</strong> or <strong>value_str</strong>, regarding the type of the value. (Integer, Boolean or String)') ?>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?= $this->Form->button(__d('admin', '{0} Create', '<i class="fa fa-plus"></i>'), ['class' => 'btn btn-primary-outline']) ?>
                            </div>
                        </div>
                    <?= $this->Form->end() ?>

                </div>

            </div>
        </div>

    </div>
</div>
