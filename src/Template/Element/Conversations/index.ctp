<div class="conversation-search">
    <?= $this->Form->create(null, [
        'url' => ['controller' => 'conversations', 'action' => 'search'],
        'role'=>'search'
    ]);?>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group input-group-lg">
                <span class="input-group-addon">
                    <i class="fa fa-search"></i>
                </span>
                <?= $this->Form->input('search',array(
                    'class' =>'form-control',
                    'type' =>'text',
                    'placeholder' => __d('conversations', 'Search a conversation by his name..'),
                    'label' => false,
                    'div' => false
                ));?>
            </div>
            <span class="input-group-btn">
                <?= $this->Form->button(__d('conversations', 'Search {0}', '<i class="fa fa-arrow-right"></i>'), [
                    'class'     => 'btn btn-primary'
                ]);?>
            </span>
        </div>
    </div>
    <?= $this->Form->end();?>
</div>

<?php if (!empty($conversations->toArray())) : ?>
    <?= $this->Form->create(null, [
        'url'   => ['controller'=>'conversations', 'action'=>'action'],
        'role'  => 'form',
        'id' => 'conversationsForm'
    ]);?>

    <div class="row">
        <div class="col-md-1">
            <?= $this->Html->link(
                '<i class="fa fa-check"></i>',
                '#',
                [
                    'class' => 'colorAllConversationBackground btn btn-sm btn-primary',
                    'escape' => false,
                    'data-toggle' => 'tooltip',
                    'data-container' => 'body',
                    'title' => __d('conversations', 'Mark all Conversations')
                ]
            ) ?>
        </div>
        <div class="col-md-3">
            <?= $this->Form->select('action', [
                    'star' => __d('conversations', 'Star Conversation(s)'),
                    'normal' => __d('conversations', 'Make normal Conversation(s)'),
                    'exit' => __d('conversations', 'Exit Conversation(s)')
                ],
                [
                    'empty' => __d('conversations', 'Action...'),
                    'class'=>'form-control input-sm col-sm-3 conversationActionSubmit',
                    'style' => 'margin-bottom: 0;'
                ]
            );?>
        </div>
        <div class="col-md-3 pull-right">
            <?= $this->Html->link(
                __d('conversations', 'New Conversation {0}', '<i class="fa fa-arrow-right"></i>'),
                ['controller' => 'conversations', 'action' => 'create'],
                ['class' => 'btn btn-sm btn-primary', 'escape' => false]
            );?>
        </div>
    </div>

    <table class="table tableConversations table-striped table-primary table-hover">
        <tbody>
            <?php foreach ($conversations as $conversation): ?>
                <tr id="conversation-<?= $conversation->conversation->id ?>" style="position: relative; <?= ($conversation->conversation->conversation_open == 0) ? 'color:rgb(128, 133, 138);' : '' ?>">
                    <td style="<?= ($conversation->conversation->conversation_open == 0) ? 'background-color:#FFCACA;;' : '' ?>">
                        <?= $this->Form->checkbox(
                            null,
                            [
                                'checked' => 0,
                                'value' => $conversation->conversation->id,
                                'class' => 'colorConversationBackground',
                                'style' => 'margin-top:25px;',
                                'legend' => false
                            ]
                        );?>
                    </td>
                    <td class="left" style="<?= ($conversation->conversation->conversation_open == 0) ? 'background-color:#FFCACA;;' : '' ?>">
                        <?= $this->Html->image($conversation->conversation->user->avatar, ['class' => 'avatar img-thumbnail pull-left']) ?>
                        <?= __d('conversations', 'Created by {0}', $this->Html->link($conversation->conversation->user->username, ['_name' => 'users-profile', 'id' => $conversation->conversation->user->id, 'slug' => $conversation->conversation->user->slug])) ?>
                        <br>
                        <?= __d('conversations', 'At {0}', $conversation->conversation->created->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT])) ?>
                        <br>
                        <?= __dn('conversations', 'Participant {0}', 'Participants {0}', $conversation->conversation->recipient_count, $conversation->conversation->recipient_count) ?>
                    </td>
                    <td class="middle" style="<?= ($conversation->conversation->conversation_open == 0) ? 'background-color:#FFCACA;;' : '' ?>">
                        <h5>
                            <?= $this->Html->link(
                                $this->Text->truncate(
                                    h($conversation->conversation->title),
                                    130,
                                    [
                                        'ellipsis' => '...',
                                        'exact' => false
                                    ]
                                ),
                                [
                                    'controller' => 'conversations',
                                    'action' => 'go',
                                    $conversation->conversation->last_message_id
                                ]
                            ) ?>
                        </h5>
                    </td>

                    <td class="right" style="<?= ($conversation->conversation->conversation_open == 0) ? 'background-color:#FFCACA;;' : '' ?>">
                        <?= __d('conversations', 'Last Reply {0}', $this->Html->link($conversation->conversation->last_message_user->username, ['_name' => 'users-profile', 'id' => $conversation->conversation->last_message_user->id, 'slug' => $conversation->conversation->last_message_user->slug])) ?>
                        <br>
                        <?= __d('conversations', 'At {0}', $conversation->conversation->last_message->created->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT])) ?>
                        <br>
                        <?= __dn('conversations', 'Reply {0}', 'Replies {0}', $conversation->conversation->reply_count, $conversation->conversation->reply_count) ?>

                        <?php if(!$conversation->is_read):?>
                            <strong class="new">
                                <span></span>
                                <?= __d('conversations', 'New');?>
                            </strong>
                        <?php endif;?>
                        <?php if($conversation->is_star):?>
                            <strong class="star" data-toggle="tooltip" data-placement="left" title="<?= __d('conversations', 'Stared') ?>">
                                <span></span>
                                <i class="fa fa-star"></i>
                            </strong>
                        <?php endif;?>
                        <?php if($conversation->conversation->conversation_open == 0):?>
                            <strong class="closed" data-toggle="tooltip" data-placement="left" title="<?= __d('conversations', 'Closed') ?>">
                                <span></span>
                                <i class="fa fa-lock"></i>
                            </strong>
                        <?php endif;?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?= $this->Form->end() ?>

    <div class="modal fade" id="conversationQuitModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">
                        <?= __d('conversations', 'Exit Conversations');?>
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        <?= __d('conversations', 'If you delete conversations where you are the owner, this will completely remove the conversation. Are you sure you want to delete these conversations ?');?>
                    </p>
                </div>
                <div class="modal-footer">
                    <?= $this->Html->link(__d('conversations', 'Yes'),'#',array(
                            'class'=>'btn btn-primary conversationQuitConfirm'
                        )
                    );?>
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                        <?= __d('conversations', 'Cancel'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="pagination-centered">
        <ul class="pagination">
            <?php if ($this->Paginator->hasPrev()): ?>
                <?= $this->Paginator->prev('«'); ?>
            <?php endif; ?>
            <?= $this->Paginator->numbers(['modulus' => 5]); ?>
            <?php if ($this->Paginator->hasNext()): ?>
                <?= $this->Paginator->next('»'); ?>
            <?php endif; ?>
        </ul>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-md-3">
            <?= $this->Html->link(
                __d('conversations', 'New Conversation {0}', '<i class="fa fa-arrow-right"></i>'),
                ['controller' => 'conversations', 'action' => 'create'],
                ['class' => 'btn btn-sm btn-primary', 'escape' => false]
            );?>
        </div>
    </div>
    <div class="infobox infobox-info">
        <h4>
            <?= __d('conversations', "You don't have any conversations yet."); ?>
        </h4>
    </div>
<?php endif; ?>
