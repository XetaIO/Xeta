<?= $this->element('meta', [
    'title' => __("Notifications")
]) ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb">
                <li>
                    <?= $this->Html->link(__("Home"), '/') ?>
                </li>
                <li>
                    <?= $this->Html->link(__("Users"), ['action' => 'index']) ?>
                </li>
                <li class="active">
                    <?= __("Notifications") ?>
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

            <div class="section section-notifications">
                <h4>
                    <?= __("Notifications") ?>
                </h4>

                <?php if(!empty($notifications)): ?>
                    <table class="table table-striped">
                        <tbody>
                            <?php foreach($notifications as $notification):?>
                                <tr>
                                    <td>
                                        <a href="<?= $notification->link ?>">
                                            <?= $this->Html->image($notification->data['sender']->avatar, ['class' => 'avatar img-thumbnail']) ?>

                                            <p class="info">
                                                <?= $notification->text ?>
                                            </p>

                                            <small class=date>
                                                <?= __('At {0}', $notification->created->i18nFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT])) ?>
                                            </small>

                                            <?php if (!$notification->is_read): ?>
                                                <strong class="new">
                                                    <span></span>
                                                    <?= __('New') ?>
                                                </strong>
                                            <?php endif; ?>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>

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
                <?php else: ?>
                    <div class="infobox infobox-info">
                        <h4>
                            <?= __("You don't have any notification yet."); ?>
                        </h4>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>
