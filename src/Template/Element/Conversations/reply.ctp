<?php if ($conversation->conversation_open == 1): ?>
    <?php if ($this->Acl->check(['_name' => 'conversations-reply', 'id' => $conversation->id, 'slug' => $conversation->title])): ?>
        <div class="panel conversationComment">
            <div class="panel-heading">
                <h4>
                    <i class="fa fa-pencil"></i> <?= __("Reply to this Conversation") ?>
                </h4>
            </div>
            <div class="panel-body">
                <?= $this->Flash->render('ConversationsReply') ?>
                <?= $this->Form->create($messageForm, [
                    'url' => ['_name' => 'conversations-reply', 'id' => $conversation->id, 'slug' => $conversation->title]
                ]) ?>
                    <div class="form-group">
                        <?=
                        $this->Form->input(
                            'message', [
                                'label' => false,
                                'class' => 'form-control messageBox',
                                'id' => 'messageBox'
                            ]
                        ) ?>
                    </div>
                    <?php if ($this->Acl->check(['_name' => 'conversations-edit', 'id' => $conversation->id, 'slug' => $conversation->title])): ?>
                        <div class="form-group">
                            <?= $this->Form->label('conversation.conversation_open', __('Close the Conversation with the response ?'), ['class' => 'control-label']) ?>
                            <div class="radio-check">
                                <?= $this->Form->radio('conversation.conversation_open', [
                                        '0' => __('Yes'),
                                        '1' => __('No')
                                    ],
                                    [
                                        'value' => '1',
                                        'legend' => false,
                                        'class' => 'form-control'
                                    ]
                                ) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <?= $this->Form->submit(__('Post Message'), ['class' => 'btn btn-primary']); ?>
                    </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    <?php endif; ?>
<?php elseif ($conversation->conversation_open == 0): ?>
    <div class="infobox infobox-danger">
        <h4>
            <?= __d('conversations', "This conversation is closed."); ?>
        </h4>
    </div>
<?php endif; ?>
