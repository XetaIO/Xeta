<?= $this->assign('title', __("Premium : Manage Discounts")); ?>

<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Flash->render(); ?>
		</div>

		<div class="col-md-12 heading">
			<h1 class="page-header">
				<i class="fa fa-gift"></i> <?= __("Premium : Manage Discounts");?>
			</h1>
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__("{0} Premium", '<i class="fa fa-trophy"></i>'), ['controller' => 'premium',
					'action' => 'home', 'prefix' => 'admin/premium'], ['escape' => false]) ?>
				</li>
				<li class="active">
					<i class="fa fa-gift"></i> <?= __("Manage Discounts");?>
				</li>
			</ol>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<?= __("Manage Discounts"); ?>
				</div>

				<div class="panel-body">

					<div class="panel-body-header">
						<?= $this->Html->link(__("{0} New Discount", '<i class="fa fa-plus"></i>'),
						['controller' => 'discounts', 'action' => 'add', 'prefix' => 'admin/premium'],
						['class' => 'btn btn-primary', 'escape' => false]) ?>
					</div>

					<?php if($discounts->toArray()): ?>
						<table class="table table-striped">
							<thead>
								<tr>
									<th><?= __('#Id') ?></th>
									<th><?= __('Created by') ?></th>
									<th><?= __('Offer') ?></th>
									<th><?= __('Code') ?></th>
									<th><?= __('Discount (%)') ?></th>
									<th><?= __('Used') ?></th>
									<th><?= __('Max Use') ?></th>
									<th><?= __('Available') ?></th>
									<th><?= __('Created') ?></th>
									<th><?= __('Action') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($discounts as $discount):?>
									<tr>
										<td>
											#<?= $discount->id ?>
										</td>
										<td>
											<?= $this->Html->link($discount->user->full_name, ['_name' => 'users-edit',
											'slug' => $discount->user->slug]) ?>
										</td>
										<td>
											<?= __n('{0} Month', '{0} Months', $discount->premium_offer->period, $discount->premium_offer->period) . ' (' . $discount->premium_offer->price . $discount->premium_offer->currency_symbol . ')' ?>
										</td>
										<td>
											<?= $discount->code ?>
										</td>
										<td>
											<?= $discount->discount . '%' ?>
										</td>
										<td>
											<?= $discount->used ?>
										</td>
										<td>
											<?= $discount->max_use ?>
										</td>
										<td>
											<?php if ($discount->used == $discount->max_use): ?>
												<span class="label label-danger">
													<?= __('No') ?>
												</span>
											<?php else: ?>
												<span class="label label-success">
													<?= __('Yes') ?>
												</span>
											<?php endif; ?>
										</td>
										<td>
											<?= $discount->created->format('d-m-Y') ?>
										</td>
										<td>
											<?= $this->Html->link(
												'<i class="fa fa-edit"></i>',
												[
													'_name' => 'discounts-edit',
													'id' => $discount->id
												],
												[
													'class' => 'btn btn-sm btn-primary',
													'data-toggle' => 'tooltip',
													'title' => __("Edit this discount"),
													'escape' => false
												]
											) ?>
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
								<?= __("No discounts was found."); ?>
							</h4>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</div>

	</div>
</div>
