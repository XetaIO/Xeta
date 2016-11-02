
<tr>
    <td>
        <table width="100%">
            <tr>
                <td valign="middle">
                    <table width="580" style="margin:0 auto;color:#73879C;">
                        <tr>
                            <td>
                                <h1>
                                    <?= __d('mail', 'Hi {0},', \Cake\Core\Configure::read('Author.full_name')) ?>
                                </h1>
                                <p style="font-size: 18px;line-height: 21px;">
                                    <?= __d('mail', '<strong>{0}</strong> has contacted you via the contact form on the site.', h($name)) ?>
                                </p>
                                <p>
                                    <?= __d('mail', 'Subject : {0}', isset($subject) ? h($subject) : '') ?>
                                </p>
                                <p style="background: #f2f2f2;border-width: 1px 1px 2px 5px;border-style: solid;border-color: #E6E9ED;border-radius: 3px;background-color: #FFF;padding: 10px !important;border-left-color: #1ABC9C;">
                                    <?= nl2br(h($message)) ?>
                                </p>
                            </td>
                            <td class="expander"></td>
                        </tr>
                    </table>

                    <table width="580" style="margin:0 auto;color:#73879C;">
                        <tr>
                            <td style="background: #f2f2f2;border-width: 1px 1px 2px 5px;border-style: solid;border-color: #E6E9ED;border-radius: 3px;background-color: #FFF;padding: 10px !important;border-left-color: #5BC0DE;">
                                <h4>
                                    <?= __d('mail', 'Additional Informations') ?>
                                </h4>
                                <?= __d('mail', 'His Email : {0}', h($email)) ?><br />
                                <?= __d('mail', 'His IP : {0}', isset($ip) ? h($ip) : '') ?>
                            </td>
                        </tr>
                    </table>

                    <table width="580" style="margin:0 auto;color:#73879C;">
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
