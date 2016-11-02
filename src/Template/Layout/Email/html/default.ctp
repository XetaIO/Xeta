<?php
use Cake\Core\Configure;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title><?= $this->fetch('title') ?></title>

    <meta content="width=device-width">
    <style type="text/css">
        body, td { font-family: 'Helvetica Neue', Arial, Helvetica, Geneva, sans-serif; font-size:14px; }
        h2{ padding-top:12px;color: #0d9ad9; font-size:22px; }

    </style>
</head>
<body style="margin:0px; padding:0px; -webkit-text-size-adjust:none;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#F2F5F7">
        <tr>
            <td align="center">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">

                    <tr>
                        <td>
                            <table width="100%" bgcolor="#FFF" height="66" style="border-bottom:4px solid rgba(0,0,0,0.1);border-top: 1px solid rgba(0,0,0,0.1);">
                                <tr>
                                    <td valign="middle">
                                        <table width="580" style="margin:0 auto;color:#73879C;">
                                            <tr>
                                                <td valign="middle">
                                                    <?= $this->Html->image(
                                                        'logo_and_name.png',
                                                        [
                                                            'fullBase' => true,
                                                            'height' => '23',
                                                            'valign' => 'bottom',
                                                            'alt' => Configure::read('Site.name'),
                                                            'url' => ['controller' => 'pages', 'action' => 'home', '_full' => true]
                                                        ]
                                                    ) ?>
                                                    <?= $this->Html->link(
                                                        __('Home'),
                                                        ['controller' => 'pages', 'action' => 'home', '_full' => true],
                                                        ['style' => 'text-decoration:none;color:#73879C;padding:0 5px;text-transform:uppercase;']
                                                    ) ?>
                                                    <?= $this->Html->link(
                                                        __('Blog'),
                                                        ['controller' => 'blog', 'action' => 'index', '_full' => true],
                                                        ['style' => 'text-decoration:none;color:#73879C;padding:0 5px;text-transform:uppercase;']
                                                    ) ?>
                                                    <?= $this->Html->link(
                                                        __('Contact'),
                                                        ['controller' => 'contact', 'action' => 'index', '_full' => true],
                                                        ['style' => 'text-decoration:none;color:#73879C;padding:0 5px;text-transform:uppercase;']
                                                    ) ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <?= $this->fetch('content') ?>

                    <tr>
                        <td width="100%" height="15"></td>
                    </tr>

                    <tr>
                        <td>
                            <table width="100%" bgcolor="#2f4052" height="66" style="border-top: 4px solid #283645;">
                                <tr>
                                    <td valign="middle">
                                        <table width="580" style="margin:0 auto;">
                                            <tr>
                                                <td align="center">
                                                    <?= $this->Html->image(
                                                        'logo_and_name_white_inversed.png',
                                                        [
                                                            'fullBase' => true,
                                                            'height' => '23',
                                                            'alt' => Configure::read('Site.name'),
                                                            'url' => ['controller' => 'pages', 'action' => 'home', '_full' => true]
                                                        ]
                                                    ) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                    <table>
                                                        <tr>
                                                            <td style="padding: 0px 2px;">
                                                                <?= $this->Html->image(
                                                                    'social/twitter.png',
                                                                    [
                                                                        'fullBase' => true,
                                                                        'height' => '33',
                                                                        'alt' => 'Twitter',
                                                                        'url' => Configure::read('Author.twitter')
                                                                    ]
                                                                ) ?>
                                                            </td>
                                                            <td style="padding: 0px 2px;">
                                                                <?= $this->Html->image(
                                                                    'social/github.png',
                                                                    [
                                                                        'fullBase' => true,
                                                                        'height' => '33',
                                                                        'alt' => 'GitHub',
                                                                        'url' => Configure::read('Site.github_url')
                                                                    ]
                                                                ) ?>
                                                            </td>
                                                            <td style="padding: 0px 2px;">
                                                                <?= $this->Html->image(
                                                                    'social/facebook.png',
                                                                    [
                                                                        'fullBase' => true,
                                                                        'height' => '33',
                                                                        'alt' => 'Facebook',
                                                                        'url' => Configure::read('Author.facebook')
                                                                    ]
                                                                ) ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="middle" align="middle" style="color:#FFFFFF">
                                                    <?= __('&copy; {0} {1}.', [date('Y', time()), Configure::read('Site.name')]) ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
