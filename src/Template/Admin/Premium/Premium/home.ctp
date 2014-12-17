<?= $this->assign('title', __("Premium : Dashboard")); ?>

<div class="content-wrapper interface-blur">
	<div class="row">

		<div class="col-md-12">
			<?= $this->Flash->render(); ?>
		</div>

		<div class="col-md-12 heading">
			<h1 class="page-header">
				<i class="fa fa-trophy"></i> <?= __("Premium : Dashboard");?>
			</h1>
			<ol class="breadcrumb">
				<li class="active">
					<i class="fa fa-dashboard"></i> <?= __("Premium : Dashboard");?>
				</li>
			</ol>
		</div>

		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3">
					<div class="info-box">
						<div class="title">
							<h5>
								<?= __("Premium Members");?>
								<i class="fa fa-users pull-right"></i>
							</h5>
						</div>
						<div class="body">
							<h1 class="number">
								<?= $usersCount ?>
							</h1>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="info-box">
						<div class="title">
							<h5>
								<?= __("Amount total");?>
								<i class="fa fa-line-chart pull-right"></i>
							</h5>
						</div>
						<div class="body">
							<h1 class="number">
								<?= $amountTotal . '€' ?>
							</h1>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="info-box">
						<div class="title">
							<h5>
								<?= __("Registered Discounts");?>
								<i class="fa fa-gift pull-right"></i>
							</h5>
						</div>
						<div class="body">
							<h1 class="number">
								<?= $registeredDiscounts ?>
							</h1>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="info-box">
						<div class="title">
							<h5>
								<?= __("Discount amount total");?>
								<i class="fa fa-euro pull-right"></i>
							</h5>
						</div>
						<div class="body">
							<h1 class="number">
								<?= $discountAmountTotal . '€' ?>
							</h1>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
