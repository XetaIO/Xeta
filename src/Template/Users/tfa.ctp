<?= $this->element('meta', [
    'title' => __("Login : Two-Factor Authentication")
]) ?>

<section class="login-features" id="login-features">
    <div class="features-overlay"></div>
    <div class="row">
        <div class="col-md-12">
            <h1 class="animated bounceInDown">
                <?= __("Two-Factor Authentication required") ?>
            </h1>
            <p class="animated bounceInUp">
                <?= __("This account is protected by the Two-factor Authentication method. You need to specify below the code obtained on your phone !") ?>
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

        <div class="col-md-6 col-md-offset-3">
            <section class="section animated bounceInRight">
                <?= $this->Form->create() ?>
                    <div class="section-title">
                        <div class="hr-divider">
                            <h3 class="hr-divider-content hr-divider-heading">
                                <?= __("Two-factor Authentication") ?>
                            </h3>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-lock"></i>
                            </span>
                            <?= $this->Form->input(
                                'code',
                                [
                                    'label' => false,
                                    'class' => 'form-control',
                                    'placeholder' => __("123456"),
                                    'reqquired' => true,
                                    'value' => false
                                ]
                            ) ?>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <?= $this->Form->button(
                            __('LogIn {0}', '<i class="fa fa-arrow-right"></i>'),
                            ['class' => 'btn btn-primary-outline']
                        ); ?>
                    </div>
                <?= $this->Form->end(); ?>
            </section>
        </div>
    </div>
</div>
