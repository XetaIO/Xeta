<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Session->flash() ?>
		</div>

		<div class="col-md-12 heading">
			<h1 class="page-header">
				<i class="fa fa-search"></i> <?= __("Search Users") ?>
			</h1>
			<ol class="breadcrumb">
				<li>
					<?= $this->Html->link(__("{0} Dashboard", '<i class="fa fa-dashboard"></i>'), ['controller' => 'admin',
							'action' => 'home', 'prefix' => 'admin'], ['escape' => false]) ?>
				</li>
				<li>
					<?= $this->Html->link(__("{0} Manage Users", '<i class="fa fa-users"></i>'), ['controller' => 'users',
							'action' => 'index', 'prefix' => 'admin'], ['escape' => false]) ?>
				</li>
				<li class="active">
					<i class="fa fa-search"></i> <?= __("Search Users") ?>
				</li>
			</ol>
		</div>

		<div class="col-md-12">
			<div class="panel panel-default">

				<div class="panel-heading">
					<?= __("Search Users") ?>
				</div>

				<div class="panel-body">
					
					<div class="panel-body-header">
						<p>
							<?= __("Search : {0}", h($keyword)) ?>
						</p>
						<p>
							<?= __("Type : {0}", h($type)) ?>
						</p>
					</div>
					
					<?php if($users->toArray()): ?>
						<table class="table table-striped">
							<thead>
								<tr>
									<th><?= __('#Id') ?></th>
									<th><?= __('Username') ?></th>
									<th><?= __('Email') ?></th>
									<th><?= __('Full name') ?></th>
									<th><?= __('Last login') ?></th>
									<th><?= __('Last login IP') ?></th>
									<th><?= __('Created') ?></th>
									<th><?= __('Action') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($users as $user):?>
									<tr>
										<td>
											#<?= $user->id ?>
										</td>
										<td>
											<?= h($user->username) ?>
										</td>
										<td>
											<?= h($user->email) ?>
										</td>
										<td>
											<?= $this->Html->link($user->full_name, ['_name' => 'users-edit',
													'slug' => $user->slug]) ?>
										</td>
										<td>
											<?= $user->last_login->format('d-m-Y') ?>
										</td>
										<td>
											<?= h($user->last_login_ip) ?>
										</td>
										<td>
											<?= $user->created->format('d-m-Y') ?>
										</td>
										<td>
											<?= $this->Html->link(
												'<i class="fa fa-edit"></i>',
												[
													'_name' => 'users-edit',
													'slug' => $user->slug
												],
												[
													'class' => 'btn btn-sm btn-primary',
													'data-toggle' => 'tooltip',
													'title' => __("Edit this user"),
													'escape' => false
												]
											)?>
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
							<h4><?= __("No results found"); ?></h4>
							<p>
								<?= __("No users were found for your search, please try again with a different word."); ?>
							</p>
							<?= __("Suggestions :"); ?>
							<ul>
								<li>
									<?= __("Check the spelling of your search words."); ?>
								</li>
								<li>
									<?= __("Try more general keywords."); ?>
								</li>
							</ul>
						</div>
					<?php endif; ?>
				</div>

			</div>
		</div>


	</div>
</div>
