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
			<?php debug($this->request->session()->read('Auth.User.end_subscription')) ?>
			<?php if ($this->request->session()->read('Auth.User.premium')): ?>
				<div class="infobox infobox-primary">
					<?= __("You're already Premium, but you can extend your subscription if you want ! Your Premium will be ended at {0}", $this->request->session()->read('Auth.User.end_subscription')) ?>
				</div>
			<?php endif; ?>
			
			<div class="row pricing">
				
				<?php foreach (Configure::read('Premium.offers') as $period => $price) :?>
					<div class="col-lg-3 col-sm-6 inner-top-sm">
						<div class="plan">
							
							<header>
								<h2><?= __("Premium") ?></h2>
								
								<div class="price">
									<span class="currency"><?= Configure::read('Premium.currency_symbol') ?></span>
									<span class="amount"><?= h($price) ?></span>
									<span class="period">/ <?= __("Month") ?></span>
								</div>
								
								<?= $this->Form->create(null, [
									'url' => ['action' => 'subscribe'],
									'class' => 'text-center'
								]) ?>
									<?= $this->Form->hidden('plan', ['value' => $period]) ?>
									<?= $this->Form->button(
										$this->request->session()->read('Auth.User.premium') ? __('Extend {0}', '<i class="fa fa-arrow-right"></i>') : __('Subscribe {0}', '<i class="fa fa-arrow-right"></i>'),
										['class' => 'btn btn-primary']
									); ?>
								<?= $this->Form->end(); ?>
								
							</header>
							
							<ul class="features">
								<li><i class="fa fa-cloud-download"></i> <?= __("Resources in Tutorials") ?></li>
								<li><i class="fa fa-trophy"></i> <?= __("Premium Badge") ?></li>
							</ul>
							
						</div>
					</div>
				<?php endforeach; ?>
				
			</div>
			
		</div>
	</section>

	
</main>
