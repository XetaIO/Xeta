
<tr>
    <td>
        <table width="100%">
            <tr>
                <td valign="middle">
                    <table width="580" style="margin:0 auto;color:#73879C;">
                        <tr>
                            <td>
                                <h1>
                                    <?= __d('mail', 'Welcome on {0} !', \Cake\Core\Configure::read('Site.name')) ?>
                                </h1>
                                <p style="font-size: 18px;line-height: 21px;">
                                    <?= __d('mail', 'Hi {0},', h($name)) ?>
                                </p>
                                <p>
                                    <?= __d(
                                        'mail',
                                        "Welcome on {0} ! You can now post your first comment in the Blog {1}. You can also manage your account {2} and view your profil {3}.",
                                        \Cake\Core\Configure::read('Site.name'),
                                        $this->Html->link(
                                            __d('mail', 'here'),
                                            ['controller' => 'blog', 'action' => 'index', 'prefix' => false, '_full' => true],
                                            ['style' => 'color:#1ABC9C;text-decoration:none;']
                                        ),
                                        $this->Html->link(
                                            __d('mail', 'here'),
                                            ['controller' => 'users', 'action' => 'account', 'prefix' => false, '_full' => true],
                                            ['style' => 'color:#1ABC9C;text-decoration:none;']
                                        ),
                                        $this->Html->link(
                                            __d('mail', 'here'),
                                            ['_name' => 'users-profile', 'slug' => $user->username, 'id' => $user->id, 'prefix' => false, '_full' => true],
                                            ['style' => 'color:#1ABC9C;text-decoration:none;']
                                        )
                                    ) ?>
                                </p>
                                <p style="background: #f2f2f2;border-width: 1px 1px 2px 5px;border-style: solid;border-color: #E6E9ED;border-radius: 3px;background-color: #FFF;padding: 10px !important;border-left-color: #1ABC9C;">
                                    <?= __d(
                                        'mail',
                                        "Don't forget, if you want to report an issue or contribute to this project, {0}.",
                                        $this->Html->link(
                                            __d('mail', 'do it there please'),
                                            \Cake\Core\Configure::read('Site.github_url'),
                                            ['style' => 'color:#1ABC9C;text-decoration:none;']
                                        )
                                    ) ?>
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
