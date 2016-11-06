<?= $this->element('meta', [
    'title' => __("Two-factor Authentication : Configure")
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
                    <?= __("Configure") ?>
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
                    <?= __("You will need to install a two-factor authentication application on your phone.") ?>
                </p>

                <div class="qrcode-box">
                    <h3 class="title">
                        <?= __("1. Scan QrCode") ?>
                    </h3>

                    <img class="qrcode" src="<?= h($imgSrc) ?>">

                    <div class="qrcode-box-footer">
                      <?= __("Scan the image above with the two-factor authentication app on your phone.") ?>
                      <?= __("If you can’t use a barcode, {0}enter this text code{1} instead.", '<a href="javascript:void(0)" class="text-primary" data-toggle="popover" data-html="true" data-content="<strong>' . h($secretCode) . '</strong>" data-placement="top">', '</a>') ?>
                    </div>
                </div>

                <p>
                    <?= __("After scanning the barcode image, the app will display a six-digit code that you can enter below.") ?>
                </p>

                <hr>

                <div class="qrcode-form-box">
                    <?= $this->Form->create(null,
                        [
                            'url' => ['controller' => 'tfa', 'action' => 'enable']
                        ]
                    ) ?>
                    <?= $this->Form->label('code', __("2. Enter the six-digit code from the application")) ?>
                    <?= $this->Form->input('code', ['class' => 'form-control', 'label' => false, 'placeholder' => '123456', 'required' => true]) ?>
                    <?= $this->Form->button(__('{0} Enable Two-factor Authentication', '<i class="fa fa-check"></i>'), ['class' => 'btn btn-primary-outline', 'escape' => false]) ?>
                    <?= $this->Form->end() ?>
                </div>

            </div>
        </section>

    </div>
</div>
