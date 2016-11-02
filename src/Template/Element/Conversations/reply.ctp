<?php if ($conversation->conversation_open == 1) : ?>
    <?php if ($this->Acl->check(['_name' => 'conversations-reply', 'id' => $conversation->id, 'slug' => $conversation->title])) : ?>
        <div class="panel panel-forum">
            <div class="panel-heading">
                <div class="hr-divider hr-divider-panel">
                    <h3 class="hr-divider-content hr-divider-heading">
                        <i class="fa fa-pencil"></i> <?= __d('conversations', 'Reply to this Conversation') ?>
                    </h3>
                </div>
            </div>
            <div class="panel-body">
                <?= $this->Flash->render('ConversationsReply') ?>
                <?= $this->Form->create($messageForm, [
                    'url' => ['_name' => 'conversations-reply', 'id' => $conversation->id, 'slug' => $conversation->title]
                ]) ?>
                    <div class="form-group">
                        <?=
                        $this->Form->input(
                            'message',
                            [
                                'label' => false,
                                'class' => 'form-control messageBox',
                                'id' => 'messageBox'
                            ]
                        ) ?>
                    </div>
                    <?php if ($this->Acl->check(['_name' => 'conversations-edit', 'id' => $conversation->id, 'slug' => $conversation->title])) : ?>
                        <div class="form-group">
                            <?= $this->Form->label('conversation.conversation_open', __d('conversations', 'Close the conversation with the response ?'), ['class' => 'control-label']) ?>
                            <?= $this->Form->radio(
                                'conversation.conversation_open',
                                [
                                    '0' => __d('conversations', 'Yes'),
                                    '1' => __d('conversations', 'No')
                                ],
                                [
                                    'value' => '1',
                                    'legend' => false,
                                    'class' => 'form-control'
                                ]
                            ) ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <?= $this->Form->button(__d('conversations', '{0} Reply', '<i class="fa fa-pencil"></i>'), ['class' => 'btn btn-primary-outline', 'escape' => false]); ?>
                    </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    <?php endif; ?>
<?php elseif ($conversation->conversation_open == 0) : ?>
    <div class="infobox infobox-danger">
        <h4>
            <?= __d('conversations', 'This conversation is closed.'); ?>
        </h4>
    </div>
<?php endif; ?>
