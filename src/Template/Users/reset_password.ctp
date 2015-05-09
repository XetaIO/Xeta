<?= $this->element('meta', [
    'title' => __("Reset your Password")
]) ?>

<section class="login-features" id="login-features">
    <div class="features-overlay"></div>
    <div class="row">
        <div class="col-md-12">
            <h1 class="animated bounceInDown">
                <?= __("You have forgot your password ?") ?>
            </h1>
            <p class="animated bounceInUp">
                <?= __("Use the form below to reset your password !") ?>
            </p>
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?= $this->Flash->render() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <section class="section animated bounceInLeft">
                <div class="section-title">
                    <h3>
                        <?= __("Reset your Password") ?>
                    </h3>
                </div>

                <?= $this->Form->create($user) ?>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </span>
                        <?= $this->Form->input(
                            'password',
                            [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => __("Password"),
                                'required' => 'required',
                                'value' => '',
                                'error' => false
                            ]
                        ) ?>
                    </div>
                    <?= $this->Form->error('password') ?>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-lock"></i>
                        </span>
                        <?= $this->Form->input(
                            'password_confirm',
                            [
                                'type' => 'password',
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => __("Password (Confirmation)"),
                                'required' => 'required',
                                'value' => '',
                                'error' => false
                            ]
                        ) ?>
                    </div>
                    <?= $this->Form->error('password_confirm') ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->button(
                        __('Reset {0}', '<i class="fa fa-arrow-right"></i>'),
                        ['class' => 'btn btn-primary']
                    ); ?>
                </div>
                <?= $this->Form->end(); ?>
            </section>
        </div>
    </div>
</div>
