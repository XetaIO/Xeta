<?= $this->assign('title', __("Premium : Manage Offers")); ?>

<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Flash->render(); ?>
		</div>

		<div class="col-md-12 heading">
			<h1 class="page-header">
				<i class="fa fa-barcode"></i> <?= __("Premium : Manage Offers");?>
			</h1>
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__("{0} Premium", '<i class="fa fa-trophy"></i>'), ['controller' => 'premium',
					'action' => 'home', 'prefix' => 'admin/premium'], ['escape' => false]) ?>
				</li>
				<li class="active">
					<i class="fa fa-barcode"></i> <?= __("Manage Offers");?>
				</li>
			</ol>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<?= __("Manage Offers"); ?>
				</div>

				<div class="panel-body">

					<div class="panel-body-header">
						<?= $this->Html->link(__("{0} New Offer", '<i class="fa fa-plus"></i>'),
						['controller' => 'offers', 'action' => 'add', 'prefix' => 'admin/premium'],
						['class' => 'btn btn-primary', 'escape' => false]) ?>
					</div>

					<?php if($offers->toArray()): ?>
						<table class="table table-striped">
							<thead>
								<tr>
									<th><?= __('#Id') ?></th>
									<th><?= __('Created by') ?></th>
									<th><?= __('Period') ?></th>
									<th><?= __('Price (Excl VAT)') ?></th>
									<th><?= __('Tax') ?></th>
									<th><?= __('Currency Code') ?></th>
									<th><?= __('Currency Symbol') ?></th>
									<th><?= __('Created') ?></th>
									<th><?= __('Action') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($offers as $offer):?>
									<tr>
										<td>
											#<?= $offer->id ?>
										</td>
										<td>
											<?= $this->Html->link($offer->user->full_name, ['_name' => 'users-edit',
											'slug' => $offer->user->slug]) ?>
										</td>
										<td>
											<?= $offer->period ?>
										</td>
										<td>
											<?= $offer->price . $offer->currency_symbol ?>
										</td>
										<td>
											<?= $offer->tax . '%' ?>
										</td>
										<td>
											<?= $offer->currency_code ?>
										</td>
										<td>
											<?= $offer->currency_symbol ?>
										</td>
										<td>
											<?= $offer->created->format('d-m-Y') ?>
										</td>
										<td>
											<?= $this->Html->link(
												'<i class="fa fa-edit"></i>',
												[
													'_name' => 'offers-edit',
													'id' => $offer->id
												],
												[
													'class' => 'btn btn-sm btn-primary',
													'data-toggle' => 'tooltip',
													'title' => __("Edit this offer"),
													'escape' => false
												]
											) ?>
											<?= $this->Html->link(
												'<i class="fa fa-remove"></i>',
												[
													'_name' => 'offers-delete',
													'id' => $offer->id
												],
												[
													'class' => 'btn btn-sm btn-danger',
													'data-toggle' => 'tooltip',
													'title' => __("Delete this offer"),
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
								<?= __("No offers was found."); ?>
							</h4>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</div>


	</div>
</div>
