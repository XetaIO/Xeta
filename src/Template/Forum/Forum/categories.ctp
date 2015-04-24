<?= $this->element('meta', [
    'title' => $category->title,
    'description' => empty($category->description) ? null : $category->description
]) ?>

<div class="container-fluid forum-container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__("Home"), '/') ?>
                </li>
                <li>
                    <?= $this->Html->link(__("Forum"), ['action' => 'index']) ?>
                </li>
                <?php foreach ($breadcrumbs as $breadcrumb): ?>
                    <li>
                        <?= $this->Html->link(
                            $breadcrumb->title,
                            [
                                '_name' => 'forum-categories',
                                'id' => $breadcrumb->id,
                                'slug' => $breadcrumb->title
                            ]
                        ) ?>
                    </li>
                <?php endforeach; ?>
                <li class="active">
                    <?= h($category->title) ?>
                </li>
            </ol>
            <?= $this->Flash->render('badge') ?>
            <?= $this->Flash->render() ?>
        </div>

        <div class="col-md-10">
            <main role="main" class="main">

                <?= $this->element('Forum/Category/actions', [
                    'category' => $category
                ]) ?>

                <?php if (!empty($category->child_forum_categories)): ?>
                    <?= $this->element('Forum/categories', [
                        'category' => $category,
                        'forums' => $categories
                    ]) ?>
                <?php endif; ?>

                <?= $this->element('Forum/Category/threads', [
                    'threads' => $threads
                ]) ?>

                <?= $this->element('Forum/Category/actions', [
                    'category' => $category
                ]) ?>
            </main>
        </div>

        <div class="col-md-2">
            <!-- Sidebar -->
            <?= $this->cell('Forum::sidebar') ?>
        </div>

    </div>
</div>
