<?= $this->assign('title', __d('admin', 'Manage Users')) ?>

<div class="content-wrapper">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render() ?>
        </div>

        <div class="col-md-12 heading">
            <h1 class="page-header">
                <i class="fa fa-user"></i> <?= __d('admin', 'Manage Users') ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Dashboard', '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
                            'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <i class="fa fa-user"></i> <?= __d('admin', 'Manage Users') ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="hr-divider hr-divider-panel">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __d('admin', 'Manage Users') ?>
                        </h3>
                    </div>
                </div>

                <div class="panel-body">
                    <?= $this->Form->create(null, [
                        'class' => 'form-horizontal',
                        'url' => ['action' => 'search'],
                        'role' => 'form'
                    ]) ?>
                    <div class="form-group">
                        <?= $this->Form->label('search', __d('admin', 'Search'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <?= $this->Form->input('search', ['class' => 'form-control', 'label' => false]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= $this->Form->label('type', __d('admin', 'Type'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <div class="col-sm-5">
                                <?= $this->Form->radio('type', [
                                        'username' => __d('admin', 'Username'),
                                        'ip' => __d('admin', 'IP'),
                                        'mail' => __d('admin', 'Mail'),
                                        'group' => __d('admin', 'Group')
                                    ],
                                    [
                                        'value' => 'username',
                                        'legend' => false,
                                        'class' => 'form-control'
                                    ]
                                ) ?>
                            </div>
                        </div>
                    </div>

                    <?= $this->Form->button(__d('admin', '{0} Search Users', '<i class="fa fa-search"></i>'), ['class' => 'col-md-offset-2 btn btn-primary-outline']) ?>
                    <?= $this->Form->end() ?>

                </div>

            </div>
        </div>

    </div>
</div>
