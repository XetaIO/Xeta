<?= $this->assign('title', __d('admin', 'Edit a Poll')) ?>

<div class="content-wrapper">
    <div class="row">

        <div class="col-md-12">
            <?= $this->Flash->render(); ?>
        </div>

        <div class="col-md-12 heading">
            <h1 class="page-header">
                <i class="fa fa-edit"></i> <?= __d('admin', 'Edit a Poll') ?>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Dashboard', '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
                    'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li>
                    <?= $this->Html->link(__d('admin', '{0} Manage Polls', '<i class="fa fa-bar-chart"></i>'), ['controller' => 'polls',
                    'action' => 'index', 'prefix' => 'admin'], ['escape' => false]) ?>
                </li>
                <li class="active">
                    <i class="fa fa-edit"></i> <?= __d('admin', 'Edit a Poll') ?>
                </li>
            </ol>
        </div>

        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="hr-divider hr-divider-panel">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __d('admin', 'Edit a Poll') ?>
                        </h3>
                    </div>
                </div>

                <div class="panel-body">
                    <?= $this->Form->create($poll, [
                        'class' => 'form-horizontal',
                        'role' => 'form'
                    ]) ?>
                    <div class="form-group">
                        <?= $this->Form->label('article_id', __d('admin', 'Article'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <?= $this->Form->input('article_id', ['options' => $articles, 'class' => 'form-control', 'label' => false]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->label('name', __d('admin', 'Poll Question'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <?= $this->Form->input('name', ['class' => 'form-control', 'label' => false]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->label('is_display', __d('admin', 'Is display'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <?= $this->Form->radio('is_display', [
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
                        <?= $this->Form->label('is_timed', __d('admin', 'Is timed'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <?= $this->Form->radio('is_timed', [
                                    '1' => __d('admin', 'Yes'),
                                    '0' => __d('admin', 'No')
                                ],
                                [
                                    'value' => '0',
                                    'legend' => false,
                                    'class' => 'form-control'
                                ]
                            ) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->label('end_date', __d('admin', 'End date'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5">
                            <?= $this->Form->dateTime('end_date', [
                                'empty' => false,
                                'day' => [
                                    'class' => 'form-control col-md-2',
                                    'style' => 'width: initial;'
                                ],
                                'month' => [
                                    'class' => 'form-control col-md-2',
                                    'style' => 'width: initial;'
                                ],
                                'year' => [
                                    'class' => 'form-control col-md-2',
                                    'style' => 'width: initial;'
                                ],
                                'hour' => [
                                    'class' => 'form-control col-md-2',
                                    'style' => 'width: initial;'
                                ],
                                'minute' => [
                                    'class' => 'form-control col-md-2',
                                    'style' => 'width: initial;'
                                ]
                            ]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->label('answers', __d('admin', 'Poll Question'), ['class' => 'col-sm-2 control-label']) ?>
                        <div class="col-sm-5" id="answers-container">
                            <div>
                                <?= $this->Form->button(
                                    '<i class="fa fa-plus"></i> ' . __d('admin', 'Add'),
                                    [
                                        'type' => 'button',
                                        'id' => 'create-answer',
                                        'class' => 'btn btn-sm btn-primary-outline',
                                        'data-toggle' => 'tooltip',
                                        'title' => __d('admin', 'Add an answer'),
                                        'style' => 'margin-bottom: 10px;',
                                        'escape' => false
                                    ]
                                )?>
                            </div>
                            <?php foreach ($poll->polls_answers as $answer) : ?>
                                <div>
                                    <?= $this->Form->input('answer', [
                                        'class' => 'form-control',
                                        'id' => 'old-answer' . $answer->id,
                                        'style' => 'width: initial; vertical-align: top;',
                                        'value' => $answer->response,
                                        'templates' => [
                                            'inputContainer' => '{{content}}'
                                        ],
                                        'label' => false,
                                        'disabled' => 'disabled'
                                    ]) ?>
                                    <?= $this->Html->link(
                                        '<i class="fa fa-remove"></i>',
                                        [
                                            '_name' => 'polls-answers-delete',
                                            'id' => $answer->id
                                        ],
                                        [
                                            'class' => 'btn btn-danger-outline delete-answer',
                                            'data-toggle' => 'tooltip',
                                            'title' => __d('admin', 'Delete this answer'),
                                            'escape' => false
                                        ]
                                    )?>
                                </div>
                                
                            <?php endforeach; ?>
                            <?= $this->Form->input('answers[]', [
                                'class' => 'form-control hidden',
                                'id' => 'duplicate-answer',
                                'templates' => [
                                    'inputContainer' => '{{content}}'
                                ],
                                'label' => false
                            ]) ?>
                            
                        </div>
                    </div>
 
                    <?= $this->Form->button(__d('admin', '{0} Edit Poll', '<i class="fa fa-plus"></i>'), ['class' => 'col-md-offset-2 btn btn-primary-outline']) ?>
                    <?= $this->Form->end() ?>
                </div>

            </div>
        </div>

    </div>
</div>
