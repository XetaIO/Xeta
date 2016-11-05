<?= $this->element('meta', [
    'title' => __("Two-factor Authentication : Recovery Code")
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
                    <?= __("Recovery Code") ?>
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
                    <?= __("Two-factor Authentication : Recovery Code") ?>
                </h4>

                <p>
                    <?= __("Recovery code can be used to access your account in the event you lose access to your device and cannot receive two-factor authentication code.") ?>
                </p>

                <div class="recovery-code">
                    <?= __('Your recovery code : {0}', "<strong>{$user->users_two_factor_auth->recovery_code}</strong>") ?><br>
                    <?= __('Code Status : ') ?>
                    <?php if ($user->users_two_factor_auth->recovery_code_used == true) : ?>
                        <span class="label label-danger"><?= __('Used {0}', '<i class="fa fa-remove"></i>') ?></span>
                    <?php else : ?>
                        <span class="label label-success"><?= __('Valid {0}', '<i class="fa fa-check"></i>') ?></span>
                    <?php endif; ?>
                    <br>
                    <strong><?= __("Printing your recovery code will keep you from permanently losing access to your {0} account.", \Cake\Core\Configure::read('Site.name')) ?></strong>
                </div>

                <hr>

                <div class="generate-new-code">
                    <p>
                        <?= __("Once you use your recovery code to regain access to your account, <strong>it cannot be reused</strong>. If you've used your recovery code, click <strong>Generate new recovery code</strong> to recreate another recovery code.") ?>
                    </p>
                    <p>
                        <?= __("When you generate a new recovery code, you must download or print the new code. Your old code won't work anymore.") ?>
                    </p>
                    <p>
                        <?= $this->Html->link(__('{0} Generate new recovery code', '<i class="fa fa-refresh"></i>'), ['controller' => 'Tfa', 'action' => 'generateRecoveryCode'], ['class' => 'btn btn-primary-outline', 'escape' => false]) ?>
                    </p>
                </div>

            </div>
        </section>

    </div>
</div>
