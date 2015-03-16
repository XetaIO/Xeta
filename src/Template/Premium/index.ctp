<?php
use Cake\Core\Configure;

?>
<main>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?= $this->Flash->render() ?>
			</div>
		</div>
	</div>

	<section class="pricing-table">
		<div class="container inner">

			<div class="row">
				<div class="col-md-12 text-center">
					<header>
						<?= $this->Html->image('badges/premium.png', ['alt' => __("Premium")])?>
						<h1><?= __("Premium") ?></h1>
						<p><?= __("Become a Premium and access to tutorials resources, win a badge and more in the future !") ?></p>
					</header>
				</div>
			</div>

			<?php if ($user && $user->premium): ?>
				<div class="infobox infobox-primary">
					<?= __("You're already Premium, but you can extend your subscription if you want ! Your Premium will be ended at {0}.", $user->end_subscription->format('H:i:s d-m-Y')) ?>
				</div>
			<?php endif; ?>

			<?php if (!$this->request->session()->read('Auth.User')): ?>
				<div class="infobox infobox-primary">
					<?= __("You need to be connected to purchase the Premium. {0}", $this->Html->link(
						__('Login {0}', '<i class="fa fa-arrow-right"></i>'),
						[
							'controller' => 'users',
							'action' => 'login'
						],
						[
							'class' => 'btn btn-sm btn-primary',
							'escape' => false
						])
					) ?>
				</div>
			<?php endif; ?>

			<div class="row pricing">

				<?php foreach ($offers as $offer) :?>
					<div class="col-lg-3 col-sm-6 inner-top-sm">
						<div class="plan">

							<header>
								<h2><?= __("Premium") ?></h2>

								<div class="price">
									<span class="currency"><?= h($offer->currency_symbol) ?></span>
									<span class="amount"><?= h($offer->price) ?></span>
									<span class="period"><?= __x('Excluding VAT', 'Excl VAT') ?> / <?= __n('{0} Month', '{0} Months', $offer->period, $offer->period) ?></span>
								</div>


							</header>

							<ul class="features">
								<li><i class="fa fa-cloud-download"></i> <?= __("Resources in Tutorials") ?></li>
								<li><i class="fa fa-trophy"></i> <?= __("Premium Badge") ?></li>
								<li><i class="fa fa-star"></i> <?= __("Yellow color in Chat & Forum") ?></li>
								<li class="text-center">
									<?php if ($this->request->session()->read('Auth.User')): ?>
										<?= $this->Form->create(null, [
											'url' => ['action' => 'subscribe']
										]) ?>
											<?= $this->Form->hidden('period', ['value' => $offer->period]) ?>
											<?= $this->Form->input('discount', ['class' => 'form-control', 'placeholder' => __("Discount Code"), 'label' => false]) ?>
											<?= $this->Form->button(
												$this->request->session()->read('Auth.User.premium') ? __('Extend {0}', '<i class="fa fa-arrow-right"></i>') : __('Subscribe {0}', '<i class="fa fa-arrow-right"></i>'),
												['class' => 'btn btn-primary']
											); ?>
										<?= $this->Form->end(); ?>
									<?php else: ?>
										<?= $this->Html->link(
											__('Login {0}', '<i class="fa fa-arrow-right"></i>'),
											[
												'controller' => 'users',
												'action' => 'login'
											],
											[
												'class' => 'btn btn-primary',
												'escape' => false
											]) ?>
									<?php endif; ?>
								</li>
							</ul>

						</div>
					</div>
				<?php endforeach; ?>

			</div>

		</div>
	</section>
</main>
