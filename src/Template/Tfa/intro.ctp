<?= $this->element('meta', [
    'title' => __("Two-factor Authentication : Intro")
]) ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__("Home"), '/') ?>
                </li>
                <li>
                    <?= $this->Html->link(__("Users"), ['controller' => 'users', 'action' => 'index']) ?>
                </li>
                <li>
                    <?= $this->Html->link(__("Security"), ['controller' => 'users', 'action' => 'security']) ?>
                </li>
                <li>
                    <?= $this->Html->link(__("Two-factor Authentication"), ['controller' => 'tfa', 'action' => 'index']) ?>
                </li>
                <li class="active">
                    <?= __("Intro") ?>
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
                    <?= __("Two-factor Authentication") ?>
                </h4>

                <p>
                    <?= __("Two-factor authentication adds an extra layer of security to your account. In addition to your username and password, you'll need to enter a code that is present in an app on your phone.") ?>
                </p>

                <div class="two-factor-graphic clearfix">
                    <div class="step">1</div>
                    <div class="line"></div>
                    <div class="step">2</div>
                    <div class="line"></div>
                    <div class="step colored"><i class="fa fa-check"></i></div>
                </div>

                <ol class="row two-factor-intro">
                    <li class="col-xs-4 step-one">
                        <?= __("When you sign into {0} you’ll enter your username and password, like always.", \Cake\Core\Configure::read('Site.name')) ?>
                    </li>
                    <li class="col-xs-4 step-two">
                        <?= __("When logging in from a new browser, you’ll need to enter an additional code from your phone or tablet.") ?>
                    </li>
                    <li class="col-xs-4 step-three">
                        <?= __("Once you enter the code on the website, you’ll be logged into {0}.", \Cake\Core\Configure::read('Site.name')) ?>
                    </li>
                </ol>

                <div class="text-center">
                    <p>
                        <?= __('Use an {0} to get two-factor authentication codes when prompted.', $this->Html->link(__('application on your phone'), ['action' => 'index', '#' => 'application-phone'], ['class' => 'text-primary'])) ?>
                    </p>

                    <?= $this->Html->link(__('{0} Enable Two-factor Authentication', '<i class="fa fa-check"></i>'), ['controller' => 'Tfa', 'action' => 'configure'], ['class' => 'btn btn-primary-outline', 'escape' => false]) ?>
                </div>

            </div>
        </section>

    </div>
</div>
