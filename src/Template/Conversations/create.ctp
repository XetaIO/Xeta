<?= $this->element('meta', [
    'title' => __d('conversations', 'Conversations')
]) ?>
<?php $this->start('scriptBottom');

    echo $this->Html->script([
        'ckeditor/ckeditor',
        'conversations.min'
    ]); ?>

    <script type="text/javascript">
        CKEDITOR.replace('messageBox', {
            customConfig: 'config/forum.js'
        });
    </script>

<?php $this->end() ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('conversations', 'Home'), '/') ?>
                </li>
                <li>
                    <?= $this->Html->link(__d('conversations', 'Conversations'), ['controller' => 'conversations', 'action' => 'index']) ?>
                </li>
                <li class="active">
                    <?= __d('conversations', 'Create') ?>
                </li>
            </ol>
            <?= $this->Flash->render() ?>
        </div>
    </div>

    <div class="row">
        <section class="col-md-3">
            <?= $this->element('/Users/sidebar') ?>
        </section>
        <section class="col-md-9">
            <div class="section">
                <h4>
                    <?= __d('conversations', 'Conversations') ?>
                </h4>

                <?= $this->Form->create($conversation);?>
                    <div class="form-group">
                        <?= $this->Form->label('users', __d('conversations', 'Participants in the conversation')) ?>
                        <?= $this->Form->input('users', [
                            'class' => 'form-control',
                            'label' => false,
                            'id' => 'InviteConversationUsers',
                            'type' => 'text',
                            'placeholder' => __d('conversations', 'Enter the name(s) here'),
                            'autocomplete' => 'off',
                            'required' => 'required',
                            'value' => (!is_null($this->request->getQuery('r')) && !empty(trim($this->request->getQuery('r')))) ? h(trim($this->request->getQuery('r'))) : '',
                            'data-url' => \Cake\Routing\Router::url(['controller' => 'conversations', 'action' => 'inviteMember'])
                        ]) ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->label('title', __d('conversations', 'Title of the conversation')) ?>
                        <?= $this->Form->input('title', ['class' => 'form-control', 'label' => false]) ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->label('message', __d('conversations', 'Your message')) ?>
                        <?= $this->Form->textarea('message', [
                                'label' => false,
                                'class' => 'form-control messageBox',
                                'id' => 'messageBox'
                        ]) ?>
                        <?= $this->Form->error('message') ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->label('open_invite', __d('conversations', 'Allow anyone in the conversation to invite other users')) ?>
                        <?= $this->Form->radio(
                            'open_invite',
                            [
                                '1' => __d('conversations', 'Yes'),
                                '0' => __d('conversations', 'No')
                            ],
                            [
                                'value' => '0',
                                'legend' => false,
                                'class' => 'form-control'
                            ]
                        )?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->label('conversation_open', __d('conversations', 'Lock the conversation <small>(No reply will be permitted)</small>'), ['escape' => false]) ?>
                        <?= $this->Form->radio(
                            'conversation_open',
                            [
                                '1' => __d('conversations', 'No'),
                                '0' => __d('conversations', 'Yes')
                            ],
                            [
                                'value' => '1',
                                'legend' => false,
                                'class' => 'form-control'
                            ]
                        ) ?>
                    </div>
                    <?= $this->Form->button(__d('conversations', '{0} Start the Conversation', '<i class="fa fa-plus"></i>'), ['class' => 'btn btn-primary-outline', 'escape' => false]) ?>
                <?= $this->Form->end();?>

            </div>

        </section>
    </div>
</div>
