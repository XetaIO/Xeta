
<tr>
    <td>
        <table width="100%">
            <tr>
                <td valign="middle">
                    <table width="780" style="margin:0 auto;color:#73879C;">
                        <tr>
                            <td>
                                <h1>
                                    <?= __d('mail', 'Hi {0},', h($username)) ?>
                                </h1>
                                <p style="font-size: 18px;line-height: 21px;">
                                    <?= __d('mail', 'Someone just tried to login to your account <strong>{0}</strong>.', h($username)) ?>
                                </p>
                                <p style="font-size: 18px;line-height: 21px;">
                                    <?= __d('mail', 'If it was you, just ignore this message.') ?>
                                </p>
                            </td>
                            <td class="expander"></td>
                        </tr>
                    </table>

                    <table width="780" style="margin:0 auto;color:#73879C;">
                        <tr>
                            <td style="background: #f2f2f2;border-width: 1px 1px 2px 5px;border-style: solid;border-color: #E6E9ED;border-radius: 3px;background-color: #FFF;padding: 10px !important;border-left-color: #5BC0DE;">
                                <h4>
                                    <?= __d('mail', 'Additional Informations') ?>
                                </h4>
                                <?= __d('mail', 'His User Agent : <strong>{0}</strong>', h($user_agent)) ?><br />
                                <?= __d('mail', 'His IP : <strong>{0}</strong>', h($user_ip)) ?><br />
                                <?php $time = \Cake\I18n\Time::now(); ?>
                                <?= __d('mail', 'DateTime : <strong>{0}</strong>', $time->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::MEDIUM])) ?>
                            </td>
                        </tr>
                    </table>

                    <table width="780" style="margin:0 auto;color:#73879C;">
                        <tr>
                            <td>
                                <p>
                                    <?= __d('mail', 'Regards,') ?><br />
                                    <?= __d('mail', 'Your bot.') ?>
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
