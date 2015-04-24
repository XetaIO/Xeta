<?= $this->assign('title', __d('admin', 'Add a Category')) ?>

<div class="content-wrapper interface-blur">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render() ?>
        </div>

        <div class="col-md-12 heading">
            <h1 class="page-header">
                <i class="fa fa-add"></i> <?= __d('admin', 'Add a Category') ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Forum', '<i class="fa fa-comments-o"></i>'), ['controller' => 'forum',
                    'action' => 'home', 'prefix' => 'admin/forum'], ['escape' => false]) ?>
                </li>
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Manage Categories', '<i class="fa fa-list"></i>'), ['controller' => 'categories',
                    'action' => 'index', 'prefix' => 'admin/forum'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <i class="fa fa-plus"></i> <?= __d('admin', 'Add a Category') ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <?= __d('admin', 'Add a Category') ?>
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
                    <div class="form-group">
                        <?= $this->Form->label('description', __d('admin', 'Description'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <?= $this->Form->input('description', ['class' => 'form-control', 'label' => false]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->label('category_open', __d('admin', 'Category Open'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5 radio-check">
                            <?= $this->Form->radio('category_open', [
                                    '1' => __d('admin', 'Yes'),
                                    '0' => __d('admin', 'No')
                                ],
                                [
                                    'value' => '1',
                                    'legend' => false,
                                    'class' => 'form-control'
                                ]
                            ) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->label('parent_id', __('Parent'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <?= $this->Form->input('parent_id', ['options' => $categories, 'class' => 'form-control', 'label' => false, 'escape' => false]);?>
                        </div>
                    </div>

                    <?= $this->Form->button(__d('admin', 'Create Category'), ['class' => 'col-md-offset-2 btn btn-primary']) ?>
                    <?= $this->Form->end() ?>

                </div>

            </div>
        </div>

    </div>
</div>
