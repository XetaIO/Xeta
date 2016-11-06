<?= $this->element('meta', [
    'title' => __("Security")
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
                    <?= __("Security") ?>
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
                <div class="hr-divider">
                    <h3 class="hr-divider-content hr-divider-heading">
                        <?= __("Two-factor Authentication") ?>
                    </h3>
                </div>

                <p>
                    <?php if ($user->two_factor_auth_enabled == true) : ?>
                        <?= __(
                            '{0} in a safe place. It will allow you to access your account if you lose your phone.',
                            $this->Html->link(__('{0} Save your recovery code', '<i class="fa fa-warning"></i>'), ['controller' => 'tfa', 'action' => 'recoveryCode'], ['escape' => false, 'class' => 'text-primary'])
                        ) ?>
                    <?php else : ?>
                        <?= __(
                            '{0} provides another layer of security to your account.',
                            $this->Html->link(__('{0} Two-factor Authentication', '<i class="fa fa-question-circle"></i>'), ['controller' => 'tfa', 'action' => 'index'], ['escape' => false, 'class' => 'text-primary'])
                        ) ?>
                    <?php endif; ?>
                </p>

                <p>
                    <?= __('Status : ') ?>
                    <?php if ($user->two_factor_auth_enabled == true) : ?>
                        <span class="text-success">
                            <strong><?= __('On {0}', '<i class="fa fa-check"></i>') ?></strong>
                        </span>
                    <?php else : ?>
                        <span class="text-danger">
                            <strong><?= __('Off {0}', '<i class="fa fa-remove"></i>') ?></strong>
                        </span>
                    <?php endif; ?>
                </p>

                <?php if ($user->two_factor_auth_enabled == true) : ?>
                    <?= $this->Html->link(__('{0} Disable Two-factor Authentication', '<i class="fa fa-remove"></i>'), ['controller' => 'Tfa', 'action' => 'disable'], ['class' => 'btn btn-danger-outline', 'escape' => false]) ?>
                <?php else : ?>
                    <?= $this->Html->link(__('{0} Enable Two-factor Authentication', '<i class="fa fa-check"></i>'), ['controller' => 'Tfa', 'action' => 'intro'], ['class' => 'btn btn-primary-outline', 'escape' => false]) ?>
                <?php endif; ?>

            </div>

            <div class="section">
                <div class="hr-divider">
                    <h3 class="hr-divider-content hr-divider-heading">
                        <?= __("Sessions") ?>
                    </h3>
                </div>
                <span>
                    <?= __('This is a list of devices that are logged into your account.') ?>
                </span>

                <?php if (!empty($sessions)) : ?>
                    <ul class="sessions">
                        <?php foreach ($sessions as $session) : ?>
                            <li class="<?= ($this->request->session()->id() === $session->id) ? 'current' : '' ?>">
                                <span class="online"></span>

                                <span class="icon" data-toggle="tooltip" data-container="body" title="<?= h($session->user_agent) ?>">
                                    <?php if (strtolower($session->infos->device_type) === 'desktop') : ?>
                                        <i class="fa fa-desktop fa-2x"></i>
                                    <?php elseif (strtolower($session->infos->device_type) === 'mobile phone') : ?>
                                        <i class="fa fa-mobile fa-2x"></i>
                                    <?php elseif (strtolower($session->infos->device_type) === 'tablet') : ?>
                                        <i class="fa fa-tablet fa-2x"></i>
                                    <?php else : ?>
                                        <i class="fa fa-desktop fa-2x"></i>
                                    <?php endif; ?>
                                </span>

                                <div class="details">
                                    <p>
                                        <strong class="title">
                                            <?php if ($this->request->session()->id() === $session->id) : ?>
                                                <?= __('Your current session') ?>
                                            <?php else : ?>
                                                <?= __('Other session') ?>
                                            <?php endif; ?>
                                            <span><?= h($session->user_ip) ?></span>
                                        </strong>
                                    </p>

                                    <p>
                                        <strong><?= h($session->infos->browser) ?></strong>
                                        <?= __('on {0}', h($session->infos->platform)) ?>
                                    </p>

                                    <p>
                                        <strong><?= __('Last seen on') ?></strong>
                                        <?php if (empty($session->full_url)) : ?>
                                            <?= 'pages/home' ?>
                                        <?php else : ?>
                                            <?= h($session->full_url) ?>
                                        <?php endif; ?>
                                    </p>

                                    <p>
                                        <strong><?= __('Last seen') ?></strong>
                                        <?= h($session->modified->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::MEDIUM])) ?>
                                    </p>

                                    <p>
                                        <strong><?= __('Created') ?></strong>
                                        <?= h($session->created->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::MEDIUM])) ?>
                                    </p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <div class="infobox infobox-primary">
                        <?= __("There's currently no sessions online for your account.") ?>
                    </div>
                <?php endif; ?>
            </div>


            <div class="section">
                <div class="hr-divider">
                    <h3 class="hr-divider-content hr-divider-heading">
                        <?= __('Security History') ?>
                    </h3>
                </div>

                <span>
                    <?= __('This is a security log of important events involving your account.') ?>
                </span>

                <?php if (!empty($logs)) : ?>
                    <ul class="logs panel-group" id="logs" role="tablist">
                        <?php foreach ($logs as $log) : ?>
                            <li class="panel panel-logs">
                                <div class="title accordion-toggle collapsed" data-toggle="collapse" data-parent="#logs" data-target="#log-<?= h($log->id) ?>" aria-expanded="false">
                                    <span class="link">
                                        <strong><?= h($log->action) ?></strong>
                                    </span>
                                    <span class="time">
                                        <?= $log->created->timeAgoInWords([
                                            'accuracy' => [
                                                'day' => 'day',
                                                'hour' => 'hour',
                                                'minute' => 'minute',
                                                'second' => 'second',
                                            ],
                                            'end' => '1 week'
                                        ]) ?>
                                    </span>
                                </div>
                                <div class="panel-collapse collapse panel-logs-body" id="log-<?= h($log->id) ?>" role="tabpanel">
                                    <p>
                                        <strong><?= __('action') ?></strong>
                                        <span><?= h($log->action) ?></span>
                                    </p>
                                    <p>
                                        <strong><?= __('browser') ?></strong>
                                        <span><?= h($log->infos->browser) ?></span>
                                    </p>
                                    <p>
                                        <strong><?= __('plateform') ?></strong>
                                        <span><?= h($log->infos->platform) ?></span>
                                    </p>
                                    <p>
                                        <strong><?= __('username') ?></strong>
                                        <span><?= h($log->username) ?></span>
                                    </p>
                                    <p>
                                        <strong><?= __('user_ip') ?></strong>
                                        <span><?= h($log->user_ip) ?></span>
                                    </p>
                                    <p>
                                        <strong><?= __('created') ?></strong>
                                        <span><?= h($log->created->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::MEDIUM])) ?></span>
                                    </p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <?= $this->Html->link(
                        __('{0} More informations about security actions', '<i class="fa fa-link"></i>'),
                        "#more-informations",
                        [
                            'class' => 'accordion-toggle collapsed',
                            'data-toggle' => 'collapse',
                            'aria-expanded' => 'false',
                            'aria-controls' => 'more-informations',
                            'escape' => false
                        ]
                    ) ?>

                    <div class="collapse" id="more-informations">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><?= __("Action name") ?></th>
                                    <th><?= __("Action description") ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>user.connection.manual.success</td>
                                    <td><?= __("Triggered when an user login on the login page.") ?></td>
                                </tr>
                                <tr>
                                    <td>user.connection.manual.failed</td>
                                    <td><?= __("Triggered when the user failed to login on the login page.") ?></td>
                                </tr>
                                <tr>
                                    <td>user.connection.auto</td>
                                    <td><?= __("Triggered when an user is automated login with Cookies.") ?></td>
                                </tr>
                                <tr>
                                    <td>user.account.modify</td>
                                    <td><?= __("Triggered when an user has modified his account.") ?></td>
                                </tr>
                                <tr>
                                    <td>user.email</td>
                                    <td><?= __("Triggered when an user has changed his Email.") ?></td>
                                </tr>
                                <tr>
                                    <td>user.password.change</td>
                                    <td><?= __("Triggered when an user has changed his password.") ?></td>
                                </tr>
                                <tr>
                                    <td>user.password.reset</td>
                                    <td><?= __("Triggered when an user has asked a password reset.") ?></td>
                                </tr>
                                <tr>
                                    <td>user.password.reset.successful</td>
                                    <td><?= __("Triggered when an user has successfully reset his password with the Email.") ?></td>
                                </tr>
                                <tr>
                                    <td>2FA.enabled</td>
                                    <td><?= __("Triggered when an user enbale the 2FA mode.") ?></td>
                                </tr>
                                <tr>
                                    <td>2FA.disabled</td>
                                    <td><?= __("Triggered when an user disable the 2FA mode.") ?></td>
                                </tr>
                                <tr>
                                    <td>2FA.recovery_code.regenerate</td>
                                    <td><?= __("Triggered when an user regenerate a new recovery code.") ?></td>
                                </tr>
                                <tr>
                                    <td>2FA.recovery_code.used</td>
                                    <td><?= __("Triggered when an user use his recovery code.") ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?= $this->element('pagination') ?>

                <?php else : ?>
                    <div class="infobox infobox-primary">
                        <?= __("There's no logs for your account.") ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>
