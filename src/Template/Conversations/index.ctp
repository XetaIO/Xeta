<?= $this->element('meta', [
    'title' => __d('conversations', 'Conversations')
]) ?>
<?php $this->start('scriptBottom');

    echo $this->Html->script([
        'conversations.min'
    ]);
$this->end() ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('conversations', 'Home'), '/') ?>
                </li>
                <li class="active">
                    <?= __d('conversations', 'Conversations') ?>
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
                    <?= __d('conversations', 'Conversations') ?>
                </h4>

                <?= $this->element('Conversations/index', [
                    'conversations' => $conversations
                ]) ?>

            </div>

        </section>
    </div>
</div>
