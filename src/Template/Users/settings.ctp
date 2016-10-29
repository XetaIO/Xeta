<?= $this->element('meta', [
    'title' => __("My Settings")
]) ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__("Home"), '/') ?>
                </li>
                <li>
                    <?= $this->Html->link(__("Users"), ['action' => 'index']) ?>
                </li>
                <li class="active">
                    <?= __("My Settings") ?>
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
            <?= $this->Form->create($user, ['class' => 'section']); ?>
                <?= $this->Form->input('method', ['type' => 'hidden', 'value' => 'email']) ?>
                <h4>
                    <?= __("Change your E-mail") ?>
                </h4>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $this->Form->label(null, __("E-mail")) ?>
                            <p class="form-control-static">
                                <?= $this->Form->label(null, $oldEmail) ?>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <?= $this->Form->label('email', __("New E-mail")) ?>
                            <?= $this->Form->input('email', ['class' => 'form-control', 'label' => false, 'value' => false]) ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->button(__('{0} Save', '<i class="fa fa-floppy-o"></i>'), ['class' => 'btn btn-primary-outline', 'escape' => false]) ?>
            <?= $this->Form->end() ?>

            <?= $this->Form->create($user, ['class' => 'section']); ?>
                <?= $this->Form->input('method', ['type' => 'hidden', 'value' => 'password']) ?>
                <h4>
                    <?= __("Change your Password") ?>
                </h4>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $this->Form->label('old_password', __("Current Password")) ?>
                            <?= $this->Form->input('old_password', ['type' => 'password', 'class' => 'form-control', 'label' => false, 'value' => false]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->label('password', __("New Password")) ?>
                            <?= $this->Form->input('password', ['type' => 'password', 'class' => 'form-control', 'label' => false, 'value' => false]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $this->Form->label('password_confirm', __("New Password (confirm)")) ?>
                            <?= $this->Form->input('password_confirm', ['type' => 'password', 'class' => 'form-control', 'label' => false, 'value' => false]) ?>
                        </div>
                    </div>
                </div>
                <?= $this->Form->button(__('{0} Change', '<i class="fa fa-refresh"></i>'), ['class' => 'btn btn-primary-outline', 'escape' => false]) ?>
            <?= $this->Form->end() ?>

            <div class="section">
                <h4>
                    <?= __("Delete your Account") ?>
                </h4>
                <button class="btn btn-danger-outline" data-toggle="modal" data-target="#deleteAccount">
                    <?= __("{0} Delete my Account", '<i class="fa fa-remove"></i>') ?>
                </button>
                <div class="modal fade" id="deleteAccount" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only"><?= __("Close") ?></span>
                                </button>
                                <h4 class="modal-title"><?= __("Delete my Account") ?></h4>
                            </div>
                            <?= $this->Form->create(null, [
                                'url' => ['controller' => 'users', 'action' => 'delete'],
                                'role' => 'form'
                            ]); ?>
                            <div class="modal-body">
                                <div class="form-group">
                                    <p>
                                        <?= __("Are you sure you want delete your account ? <strong>This operation is not reversible.</strong>") ?>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                        <?= $this->Form->input('password', ['class' => 'form-control', 'label' => false, 'placeholder' => __('Password'), 'required' => true]) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-actions">
                                <?= $this->Form->button(__("Yes, i confirm !"), ['class' => 'ma ma-btn ma-btn-danger']) ?>
                                <button type="button" class="ma ma-btn ma-btn-primary" data-dismiss="modal"><?= __("Close") ?></button>
                            </div>
                            <?= $this->Form->end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
