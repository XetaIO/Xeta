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
					<?php if (isset($transaction)): ?>
						<header>
							<h1>
								<span class="text-primary"><i class="fa fa-check fa-2x"></i></span><?= __("Thanks for purchasing the Premium !") ?>
							</h1>
							<h3>
								<?= __("You have unlock the badge Premium") ?>
							</h3>
							<?= $this->Html->image('badges/premium.png', [
								'alt' => __("Premium"),
								'title' => __("Premium"),
								'data-toggle' => 'tooltip'
							]) ?>
							<div class="infobox infobox-primary">
								<?= __("Your Premium will be ended at {0}.", $user->end_subscription->format('H:i:s d-m-Y')) ?>
								<?= $this->Html->link(
									__("My Profil {0}", '<i class="fa fa-arrow-right"></i>'),
									['_name' => 'users-profile', 'slug' => $user->slug, 'id' => $user->id],
									['class' => 'btn btn-sm btn-primary', 'escape' => false]
								) ?>
							</div>
						</header>
					<?php else: ?>
						<header>
							<?= $this->Html->image('badges/premium.png', ['alt' => __("Premium")]) ?>
							<h1>
								<span class="text-primary"><i class="fa fa-check fa-2x"></i></span><?= __("Thanks for purchasing the Premium !") ?>
							</h1>
							<p><?= __("Your account will be upgraded when the transaction will be completed ! It can take 2-3 hours, it depend of Paypal.") ?></p>
							<?= $this->Html->link(
							__("Go Home {0}", '<i class="fa fa-arrow-right"></i>'),
							'/',
							['class' => 'btn btn-primary', 'escape' => false]
							) ?>
						</header>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
</main>
