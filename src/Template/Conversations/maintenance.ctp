<?= $this->element('meta', [
    'title' => __d('conversations', 'Conversations')
]) ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__d('conversations', 'Home'), '/') ?>
                </li>
                <li>
                    <?= $this->Html->link(__d('conversations', 'Conversations'), ['controller' => 'conversations', 'action' => 'index']) ?>
                </li>
                <li class="active">
                    <?= __d('conversations', 'Maintenance') ?>
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

                <div class="infobox infobox-danger">
                    <h4>
                        <?= __d('conversations', "The conversations system has been disabled for maintenance. Please, try again later."); ?>
                    </h4>
                </div>

            </div>

        </section>
    </div>
</div>
