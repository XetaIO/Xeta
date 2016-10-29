<?= $this->element('meta', [
    'title' => __("My Account")
]) ?>

<?php $this->start('scriptBottom');

echo $this->Html->script('ckeditor/ckeditor') ?>
<script type="text/javascript">
    CKEDITOR.replace('biographyBox', {
        customConfig: 'config/biography.js'
    });
    CKEDITOR.replace('signatureBox', {
        customConfig: 'config/signature.js'
    });
</script>

<?php $this->end() ?>

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
                    <?= __("My Account") ?>
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
            <?= $this->Form->create($user,
                [
                    'class' => 'section',
                    'type' => 'file'
                ]
            ) ?>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-5 col-lg-4">
                        <div class="form-group">

                            <div class="fileinput fileinput-exists" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="max-width: 200px; max-height: 150px;">
                                    <?= $this->Html->image('avatar.png', ['alt' => __("Default Avatar")]) ?>
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                    <?= $this->Html->image($user->avatar) ?>
                                </div>
                                <div>
                                    <span class="btn btn-primary-outline btn-file">
                                        <i class="fa fa-refresh"></i>
                                        <span class="fileinput-exists"><?= __("Change") ?></span>
                                        <?= $this->Form->input('avatar_file', ['type' => 'file', 'label' => false, 'templates' => [
                                            'inputContainer' => '{{content}}</span>',
                                            'inputContainerError' => '{{content}}</span>{{error}}'
                                        ]]) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-8">
                        <?= $this->Form->label('first_name', __("First Name")) ?>
                        <div class="form-group">
                            <?= $this->Form->input('first_name', ['class' => 'form-control', 'label' => false]) ?>
                        </div>
                        <?= $this->Form->label('last_name', __("Last Name")) ?>
                        <div class="form-group">
                            <?= $this->Form->input('last_name', ['class' => 'form-control', 'label' => false]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <?= $this->Form->label('twitter', __("Twitter")) ?>
                <div class="input-group">
                    <span class="input-group-addon" style="min-width: 155px;">http://twitter.com/</span>
                    <?= $this->Form->input('twitter', ['class' => 'form-control', 'label' => false]) ?>
                </div>
            </div>
            <div class="form-group">
                <?= $this->Form->label('facebook', __("Facebook")) ?>
                <div class="input-group">
                    <span class="input-group-addon" style="min-width: 155px;">http://facebook.com/</span>
                    <?= $this->Form->input('facebook', ['class' => 'form-control', 'label' => false]) ?>
                </div>
            </div>
            <div class="form-group">
                <?= $this->Form->label('biography', __("Biography")) ?>
                <div>
                    <small><?= __("The biography will be displayed on your profile page.") ?></small>
                </div>
                <?= $this->Form->input(
                        'biography', [
                            'label' => false,
                            'class' => 'form-control biographyBox',
                            'id' => 'biographyBox'
                        ]
                    ) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->label('signature') ?>
                <div>
                    <small><?= __("The signature will be displayed on each article that you have wrotten on the blog.") ?></small>
                </div>
                <?= $this->Form->input(
                        'signature', [
                            'label' => false,
                            'class' => 'form-control signatureBox',
                            'id' => 'signatureBox'
                        ]
                    ) ?>
            </div>

            <?= $this->Form->button(__('{0} Save', '<i class="fa fa-floppy-o"></i>'), ['class' => 'btn btn-primary-outline', 'escape' => false]) ?>
            <?= $this->Form->end() ?>
        </section>
    </div>
</div>
