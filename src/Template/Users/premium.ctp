<?= $this->element('meta', [
    'title' => __("Premium")
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
                    <?= __("Premium") ?>
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
                    <?= __("Premium Purchases") ?>
                </h4>
                <p>
                    <?= __("You can see here all your premium purchases.") ?>
                </p>
                <?php if($transactions->toArray()): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>$<?= __('Offer') ?></th>
                                <th><?= __('Offer Amount') ?></th>
                                <th><?= __('Amount HT') ?></th>
                                <th><?= __('Tax') ?></th>
                                <th><?= __('Discount') ?></th>
                                <th><?= __('Discount Amount') ?></th>
                                <th><?= __('Date') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($transactions as $transaction):?>
                                <tr>
                                    <td>
                                        <?= __n('{0} Month', '{0} Months', $transaction->period, $transaction->period) ?>
                                    </td>
                                    <td>
                                        <?= $this->Number->format($transaction->premium_offer->price, ['precision' => 2, 'locale' => 'us_US']) . $transaction->premium_offer->currency_symbol ?>
                                    </td>
                                    <td>
                                        <?= $this->Number->format($transaction->price, ['precision' => 2, 'locale' => 'en_US']) . $transaction->premium_offer->currency_symbol ?>
                                    </td>
                                    <td>
                                        <?= $this->Number->format($transaction->tax, ['precision' => 2, 'locale' => 'en_US']) . $transaction->premium_offer->currency_symbol ?>
                                    </td>
                                    <td>
                                        <?php if (!is_null($transaction->premium_discount)): ?>
                                            <?= $transaction->premium_discount->discount . '%' ?>
                                        <?php else: ?>
                                            <span class="label label-danger">
                                                <?= __("No") ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!is_null($transaction->premium_discount)): ?>
                                            <?= $transaction->discount . $transaction->premium_offer->currency_symbol ?>
                                        <?php else: ?>
                                            <?= __("0{0}", $transaction->premium_offer->currency_symbol) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= $transaction->created->format('d-m-Y') ?>
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
                            <?= __("You haven't purchased the Premium yet. {0}", $this->html->link(
                                    __('Check the offers {0}', '<i class="fa fa-arrow-right"></i>'),
                                    ['controller' => 'premium'],
                                    ['class' => 'btn btn-sm btn-primary', 'escape' => false]
                                )
                            ); ?>
                        </h4>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>
