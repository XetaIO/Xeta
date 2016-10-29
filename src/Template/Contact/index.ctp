<?= $this->element('meta', [
    'title' => __("Contact me")
]) ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__("Home"), '/') ?>
                </li>
                <li class="active">
                    <?= __("Contact") ?>
                </li>
            </ol>
            <?= $this->Flash->render() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="contact section">
                <h2 class="text-center">
                    <?= __("Contact me !") ?>
                </h2>
                <p class="text-center">
                    <?= __("You have found a problem on the site or you just want to contact me ? Use the form below and i will answer you shortly !") ?>
                    <br>
                    <span class="text-danger" style="font-weight: bold;">
                        <?= __(
                            'NEW : You can now contact me directly on the web site via the Private Conversation {0} !',
                            $this->Html->link(
                                __('here'),
                                [
                                    'controller' => 'conversations',
                                    'action' => 'create',
                                    'prefix' => false,
                                    '?' => [
                                        'r' => 'Xeta,'
                                    ]
                                ],
                                [
                                    'class' => 'text-primary',
                                    'target' => '_blank'
                                ]
                            )
                        ) ?>
                    </span>
                </p>
                <div class="row">
                    <div class="col-md-6">
                        <?= $this->Form->create($contact) ?>
                        <div class="form-group">
                            <?= $this->Form->label('name', __("Name {0}", '<span class="text-danger">*</span>'), ['data-toggle' => 'tooltip', 'title' => __('Required.'), 'escape' => false]) ?>
                            <?= $this->Form->input('name', ['class' => 'form-control', 'placeholder' => __("Name"), 'label' => false]) ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('email', __("Email {0}", '<span class="text-danger">*</span>'), ['data-toggle' => 'tooltip', 'title' => __('Required.'), 'escape' => false]) ?>
                            <?= $this->Form->input('email', ['class' => 'form-control', 'placeholder' => __("Email"), 'label' => false]) ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->input('subject', ['class' => 'form-control', 'placeholder' => __("Subject")]) ?>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('message', __("Message {0}", '<span class="text-danger">*</span>'), ['data-toggle' => 'tooltip', 'title' => __('Required.'), 'escape' => false]) ?>
                            <?= $this->Form->input('message', ['type' => 'textarea', 'class' => 'form-control', 'placeholder' => __("Enter your message..."), 'label' => false]) ?>
                        </div>
                        <?= $this->Form->button(__('{0} Send', '<i class="fa fa-envelope-o"></i>'), ['class' => 'btn btn-primary-outline', 'escape' => false]) ?>
                        <?= $this->Form->end() ?>
                    </div>
                    <div class="col-md-6">
                        <h3>
                            <?= __("Contact") ?>
                        </h3>
                        <ul class="contacts">
                            <li>
                                <i class="fa fa-map-marker"></i>
                                <?= \Cake\Core\Configure::read('Author.address') ?>
                            </li>
                            <li>
                                <i class="fa fa-phone"></i>
                                <?= __("Secret") ?>
                            </li>
                            <li>
                                <i class="fa fa-envelope-o"></i>
                                <?= \Cake\Core\Configure::read('Author.email') ?>
                            </li>
                        </ul>
                        <h3>
                            <?= __("Social") ?>
                        </h3>
                        <ul class="social">
                            <li>
                                <?= $this->Html->link('<i class="fa fa-facebook"></i>', \Cake\Core\Configure::read('Author.facebook'), ['target' => '_blank', 'escape' => false]) ?>
                            </li>
                            <li>
                                <?= $this->Html->link('<i class="fa fa-twitter"></i>', \Cake\Core\Configure::read('Author.twitter'), ['target' => '_blank', 'escape' => false]) ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
