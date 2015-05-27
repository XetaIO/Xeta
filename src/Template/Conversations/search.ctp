<?= $this->element('meta', [
    'title' => __d('conversations', 'Conversations - Search')
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
                <li>
                    <?= $this->Html->link(__d('conversations', 'Conversations'), ['action' => 'index']) ?>
                </li>
                <li class="active">
                    <?= __d('conversations', 'Search') ?>
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
                    <?= __d('conversations', 'Search') ?>
                    <br>
                    <small>
                        <?= __d('conversations', 'Word : {0}', h($keyword)) ?>
                    </small>
                </h4>

                <?= $this->element('Conversations/index', [
                    'conversations' => $conversations
                ]) ?>

            </div>

        </section>
    </div>
</div>
