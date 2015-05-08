
<tr>
    <td>
        <table width="100%">
            <tr>
                <td valign="middle">
                    <table width="580" style="margin:0 auto;color:#73879C;">
                        <tr>
                            <td>
                                <h1>
                                    <?= __d('mail', 'Hi {0},', h($name)) ?>
                                </h1>
                                <p style="font-size: 18px;line-height: 21px;">
                                    <?= __d('mail', 'You recently asked to change the password for the account <strong>{0}</strong>.', h($username)) ?>
                                </p>
                                <p>
                                    <?= __d('mail', "If you didn't asked to change your password, please ignore this mail. Also, for security reasons, it would be better if you change your account password.") ?>
                                </p>
                                <p style="background: #f2f2f2;border-width: 1px 1px 2px 5px;border-style: solid;border-color: #E6E9ED;border-radius: 3px;background-color: #FFF;padding: 10px !important;border-left-color: #1ABC9C;">
                                    <?= __d(
                                        'mail',
                                        'To complete this process, please follow this link : {0}',
                                        $this->Html->link(
                                            __d('mail', 'here'),
                                            [
                                                '_name' => 'users-resetpassword',
                                                'id' => $userId,
                                                'code' => $code,
                                                '_full' => true
                                            ],
                                            [
                                                'style' => 'color:#1ABC9C;text-decoration:none;'
                                            ]
                                        )
                                    ) ?>
                                    <br />
                                    <?= __d('mail', 'Note : This link will be expired in 10 minutes. ') ?>
                                </p>
                            </td>
                            <td class="expander"></td>
                        </tr>
                    </table>

                    <table width="580" style="margin:0 auto;color:#73879C;">
                        <tr>
                            <td>
                                <p>
                                    <?= __d('mail', 'Regards,') ?><br />
                                    <?= __d('mail', "{0}'s Team.", \Cake\Core\Configure::read('Site.name')) ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>