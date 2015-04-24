<div class="threadActions">
    <?php if ($thread->thread_open == true): ?>
        <?= $this->Html->link(
            __('{0} Reply', '<i class="fa fa-plus"></i>'),
            ['controller' => 'threads', 'action' => 'reply', 'id' => $thread->id, 'slug' => $thread->title],
            ['class' => 'btn btn-xs btn-primary', 'escape' => false]
        ) ?>

        <?php if ($this->Acl->check(['_name' => 'threads-lock', 'id' => $thread->id, 'slug' => $thread->title, 'prefix' => 'forum'])): ?>
            <?= $this->Html->link(
                __('{0} Lock', '<i class="fa fa-lock"></i>'),
                ['_name' => 'threads-lock', 'id' => $thread->id, 'slug' => $thread->title],
                ['class' => 'btn btn-xs btn-danger', 'escape' => false]
            ) ?>
        <?php endif; ?>
    <?php else: ?>
        <button class="btn btn-xs btn-danger"><?= __('{0} Closed', '<i class="fa fa-lock"></i>') ?></button>

        <?php if ($this->Acl->check(['_name' => 'threads-unlock', 'id' => $thread->id, 'slug' => $thread->title, 'prefix' => 'forum'])): ?>
            <?= $this->Html->link(
                __('{0} Unlock', '<i class="fa fa-unlock"></i>'),
                ['_name' => 'threads-unlock', 'id' => $thread->id, 'slug' => $thread->title],
                ['class' => 'btn btn-xs btn-success', 'escape' => false]
            ) ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($this->Acl->check(['_name' => 'threads-edit', 'id' => $thread->id, 'slug' => $thread->title, 'prefix' => 'forum'])): ?>
        <?= $this->Html->link(
            __('{0} Edit Thread', '<i class="fa fa-edit"></i>'),
            '#',
            ['class' => 'btn btn-xs btn-primary', 'data-toggle' => 'modal', 'data-target' => '#editThread', 'escape' => false]
        ) ?>

        <div class="modal fade" id="editThread" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <?= $this->Form->create($thread, [
                        'url' => ['_name' => 'threads-edit', 'id' => $thread->id, 'slug' => $thread->title, 'prefix' => 'forum']
                    ]) ?>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="<?= __('Close') ?>">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">
                        <?= __('{0} Edit Thread', '<i class="fa fa-edit"></i>') ?>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <?= $this->Form->label('title', __('Thread Title'), ['class' => 'control-label']) ?>
                            <?= $this->Form->input('title', ['class' => 'form-control', 'label' => false])?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('category_id', __('Category'), ['class' => 'control-label']) ?>
                            <?= $this->Form->input('category_id', ['options' => $categories, 'class' => 'form-control', 'label' => false, 'escape' => false]);?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('sticky', __('Sticky Thread'), ['class' => 'control-label']) ?>
                            <div class="radio-check">
                                <?= $this->Form->radio('sticky', [
                                        '1' => __('Yes'),
                                        '0' => __('No')
                                    ],
                                    [
                                        'legend' => false,
                                        'class' => 'form-control'
                                    ]
                                ) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('thread_open', __('Lock Thread'), ['class' => 'control-label']) ?>
                            <div class="radio-check">
                                <?= $this->Form->radio('thread_open', [
                                        '0' => __('Yes'),
                                        '1' => __('No')
                                    ],
                                    [
                                        'legend' => false,
                                        'class' => 'form-control'
                                    ]
                                ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?= $this->Form->button(
                            __('Save'),
                            [
                                'type' => 'submit',
                                'class' => 'btn btn-primary'
                            ]
                        ) ?>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><?= __('Close') ?></button>
                    </div>
                    <?= $this->Form->end(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="pull-right">
        <ul class="pagination pagination-sm">
            <?php if ($this->Paginator->hasPrev()): ?>
                <?= $this->Paginator->prev('«'); ?>
            <?php endif; ?>
            <?= $this->Paginator->numbers(['modulus' => 5]); ?>
            <?php if ($this->Paginator->hasNext()): ?>
                <?= $this->Paginator->next('»'); ?>
            <?php endif; ?>
        </ul>
    </div>
</div>
