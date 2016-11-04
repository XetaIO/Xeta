<?= $this->element('meta', [
    'title' => __("Forgot your Password")
]) ?>

<section class="login-features" id="login-features">
    <div class="features-overlay"></div>
    <div class="row">
        <div class="col-md-12">
            <h1 class="animated bounceInDown">
                <?= __("You have forgot your password ?") ?>
            </h1>
            <p class="animated bounceInUp">
                <?= __("Use the form below to recover your password ! An E-mail will be send to you.") ?>
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
        <div class="col-md-offset-2 col-md-8">
            <section class="section animated bounceInLeft">
                <div class="section-title">
                    <div class="hr-divider">
                        <h3 class="hr-divider-content hr-divider-heading">
                            <?= __("Forgot your Password") ?>
                        </h3>
                    </div>
                </div>

                <?= $this->Form->create() ?>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-at"></i>
                        </span>
                        <?= $this->Form->input(
                            'email',
                            [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => __("E-mail"),
                                'required' => 'required',
                                'error' => false
                            ]
                        ) ?>
                    </div>
                    <?= $this->Form->error('email') ?>
                </div>
                <div class="form-group text-center">
                    <?= $this->Recaptcha->display() ?>
                </div>
                <div class="form-group text-center">
                    <?= $this->Form->button(
                        __('Reset {0}', '<i class="fa fa-arrow-right"></i>'),
                        ['class' => 'btn btn-primary-outline']
                    ); ?>
                </div>
                <?= $this->Form->end(); ?>
            </section>
        </div>
    </div>
</div>
