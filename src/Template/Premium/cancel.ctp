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
						<?= $this->Html->image('badges/premium.png', ['alt' => __("Premium")]) ?>
						<h1>
							<span class="text-danger"><i class="fa fa-remove fa-2x"></i></span><?= __("Your payment has been canceled !") ?>
						</h1>
						<p>
							<?= __("Your payment has been canceled, you can make a new payment in the page Premium. {0}",
								$this->Html->link(__("Premium {0}", '<i class="fa fa-arrow-right"></i>'), ['action' => 'index'], ['class' => 'btn btn-sm btn-primary', 'escape' => false])
							) ?>
						</p>
						<?= $this->Html->link(
							__("Go Home {0}", '<i class="fa fa-arrow-right"></i>'),
							'/',
							['class' => 'btn btn-primary', 'escape' => false]
						) ?>
					</header>
				</div>
			</div>

		</div>
	</section>
</main>
