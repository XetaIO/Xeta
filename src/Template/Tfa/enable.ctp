<?= $this->element('meta', [
    'title' => __("Two-factor Authentication : Enable")
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
                    <?= __("Enable") ?>
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

                <div class="two-factor-status">
                    <p>
                        <span class="label label-success"><?= __('Enabled {0}', '<i class="fa fa-check"></i>') ?></span>
                        <?= __("Two-factor authentication is currently on.") ?>
                    </p>

                    <?= $this->Html->link(__('{0} Disable two-factor authentication', '<i class="fa fa-remove"></i>'), ['action' => 'disable'], ['class' => 'btn btn-sm btn-danger-outline', 'escape' => false]) ?>
                </div>

                <div class="two-factor-information">
                    <i class="warning fa fa-exclamation-triangle fa-2x text-danger"></i>
                    <h3><?= __("Don’t get locked out of your {0} account", \Cake\Core\Configure::read('Site.name')) ?></h3>
                    <p>
                        <?= __("<strong>Your account is now more secure, make sure you don’t get locked out</strong>.
                        If you lose your two-factor device, the {0} Support cannot restore access to accounts with two-factor authentication enabled for security reasons, <strong>printing your recovery codes will keep you from permanently losing access to your {0} account.</strong>.", \Cake\Core\Configure::read('Site.name')) ?>
                    </p>
                    <p>
                        <?= __("Recovery codes can be used to access your account in the event you lose access to your device and cannot receive two-factor authentication codes.") ?>
                    </p>
                    <p>
                        <?= $this->Html->link(__('{0} View recovery code', '<i class="fa fa-eye"></i>'), ['action' => 'recoveryCode'], ['class' => 'btn btn-primary-outline', 'escape' => false]) ?>
                    </p>
                </div>

            </div>
        </section>

    </div>
</div>
