<?= $this->element('meta', [
    'title' => __("Xeta's members")
]) ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__("Home"), '/') ?>
                </li>
                <li class="active">
                    <?= __("Users") ?>
                </li>
            </ol>
            <?= $this->Flash->render() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <section class="section">
                <h3>
                    <?= __("All {0}'s members", \Cake\Core\Configure::read('Site.name')) ?>
                </h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th><?= __("Username") ?></th>
                        <th><?= __("Full Name") ?></th>
                        <th><?= __("Group") ?></th>
                        <th><?= __("Registered date") ?></th>
                        <th><?= __("Last login") ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <?= $this->Html->link(
                                    h($user->username),
                                    [
                                        '_name' => 'users-profile',
                                        'slug' => $user->username,
                                        'id' => $user->id
                                    ],
                                    [
                                        'data-toggle' => 'tooltip',
                                        'title' => __('Visit his profile.'),
                                        'escape' => false
                                    ]
                                ) ?>
                            </td>
                            <td>
                                <?= h($user->full_name) ?>
                            </td>
                            <td>
                                <?= ucfirst(h($user->group->name)) ?>
                            </td>
                            <td>
                                <?= $user->created->format('d-m-Y') ?>
                            </td>
                            <td>
                                <?= $user->last_login->format('d-m-Y') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <div class="pagination-centered">
                <ul class="pagination">
                    <?php if ($this->Paginator->hasPrev()): ?>
                        <?= $this->Paginator->prev('«'); ?>
                    <?php endif; ?>
                    <?= $this->Paginator->numbers(['modulus' => 5]); ?>
                    <?php if ($this->Paginator->hasNext()): ?>
                        <?= $this->Paginator->next('»'); ?>
                    <?php endif; ?>
                </ul>
            </div>

        </div>
    </div>
</div>
