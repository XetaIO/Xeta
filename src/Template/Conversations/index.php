<?= $this->element('meta', [
    'title' => __("Conversations")
]) ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__("Home"), '/') ?>
                </li>
                <li class="active">
                    <?= __("Conversations") ?>
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
                    <?= __("Delete your Account") ?>
                </h4>
                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteAccount">
                    <?= __("Delete my Account") ?>
                </button>
                <div class="modal fade" id="deleteAccount" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only"><?= __("Close") ?></span>
                                </button>
                                <h4 class="modal-title"><?= __("Delete my Account") ?></h4>
                            </div>
                            <div class="modal-body">
                                <?= __("Are you sure you want delete your account ? <strong>This operation is not reversible.</strong>") ?>
                            </div>
                            <div class="modal-footer">
                                <?= $this->Html->link(__("Yes, i confirm !"), ['action' => 'delete'], ['class' => 'btn btn-danger']) ?>
                                <button type="button" class="btn btn-primary" data-dismiss="modal"><?= __("Close") ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
</div>
