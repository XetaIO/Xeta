<?php
use Cake\Core\Configure;

?>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="text-muted col-md-6">
                <div class="copyright">
                    <?= __('&copy; {0} {1}.', [date('Y', time()), Configure::read('Site.name')]) ?>
                </div>
                <div class="navigation">
                    <ul>
                        <li>
                            <?= $this->Html->link(__('Terms'), ['controller' => 'pages', 'action' => 'terms', 'prefix' => false]) ?>
                        </li>
                        <li>
                            <?= $this->Html->link(__('Contact'), ['controller' => 'contact', 'action' => 'index', 'prefix' => false]) ?>
                        </li>
                        <li>
                            <?= $this->Html->link('<i class="fa fa-github-alt" data-toggle="tooltip" title="' . __("Source Code available on Github") . '"></i>', Configure::read('Site.github_url'), ['escape' => false, 'target' => '_blank']) ?>
                        </li>
                    </ul>
                </div>
                <small><?= __('Version : {0}', h(Configure::read('Site.version'))) ?></small>
            </div>

            <div class="text-muted col-lg-5 col-lg-offset-1 col-md-6">
                <?= __('{0} with {1} and {2} by', '<i class="fa fa-code text-primary" style="font-weight: bold;"></i>', '<i class="fa fa-heart text-danger"></i>', '<i class="fa fa-coffee"></i>') ?>
                <?= $this->Html->link(
                    Configure::read('Author.pseudo'),
                    Configure::read('Author.twitter'),
                    ['target' => '_blank']
                ) ?>

                <div class="btn-group dropup">
                    <button type="button" class="btn btn-primary-outline btn-sm">
                        <?= $this->Html->image(
                            'languages/blank.gif',
                            [
                                'class' => 'flag flag-' . \Cake\I18n\I18n::locale(),
                                'alt' => \Cake\Core\Configure::read('I18n.locales.' . \Cake\I18n\I18n::locale())
                            ]
                        ) ?>
                        <?= \Cake\Core\Configure::read('I18n.locales.' . \Cake\I18n\I18n::locale()) ?>
                    </button>
                    <button type="button" class="btn btn-primary-outline btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <?php foreach (\Cake\Core\Configure::read('I18n.locales') as $key => $value): ?>
                            <?php if (\Cake\I18n\I18n::locale() != $key): ?>
                                <li class="<?= $value ?>">
                                    <?= $this->Html->link(
                                        $this->Html->image(
                                            'languages/blank.gif',
                                            [
                                                'class' => 'flag flag-' . $key,
                                                'alt' => \Cake\Core\Configure::read('I18n.locales.' . $key)
                                            ]
                                        ) . '&nbsp;' . $value,
                                        [
                                            '_name' => 'set-lang',
                                            'lang' => $key
                                        ],
                                        [
                                            'escape' => false
                                        ]
                                    ) ?>
                                </li>
                            <?php endif;?>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
