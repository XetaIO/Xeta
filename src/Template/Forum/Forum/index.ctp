<?= $this->element('meta', [
    'title' => __('Forum')
]) ?>
<div class="container-fluid forum-container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__("Home"), '/') ?>
                </li>
                <li class="active">
                    <?= __("Forum") ?>
                </li>
            </ol>
            <?= $this->Flash->render('badge') ?>
            <?= $this->Flash->render() ?>
        </div>
    </div>

    <div class="row">

        <div class="col-md-10">
            <?php if(\Cake\Core\Configure::read('Chat.enabled') === true): ?>
                <?= $this->element('Chat/mini-chat') ?>
            <?php endif; ?>

            <main role="main" class="main">
                <?php foreach ($categories as $category): ?>
                    <?= $this->element('Forum/categories', [
                        'category' => $category,
                        'forums' => $category->children
                    ]) ?>
                <?php endforeach; ?>

                <?= $this->element('Forum/Index/statistics', [
                    'statistics' => $statistics
                ]) ?>
            </main>
        </div>

        <div class="col-md-2">
            <?= $this->cell('Forum::sidebar') ?>
        </div>

    </div>
</div>
