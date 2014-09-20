<section class="login-features" id="login-features">
	<div class="features-overlay"></div>
	<div class="row">
		<div class="col-md-12">
			<h1 class="animated bounceInDown">
				<?= __("Why create an account ?") ?>
			</h1>
			<p class="animated bounceInUp">
				<?= __("With an account you can download all the sources provided in tutorials and you can interact with all the community !") ?>
			</p>
		</div>
	</div>
</section>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?= $this->Flash->render() ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-5">
			<section class="section animated bounceInLeft">
				<div class="section-title">
					<h3>
						<?= __("Create an Account") ?>
					</h3>
				</div>

				<?= $this->Form->create($userRegister) ?>
				<?= $this->Form->input('method', ['type' => 'hidden', 'value' => 'register']) ?>
				<div class="form-group">
					<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-user"></i>
							</span>
						<?=
							$this->Form->input(
								'username',
								[
									'label' => false,
									'class' => 'form-control',
									'placeholder' => __("Username"),
									'required' => 'required'
								]
							) ?>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-at"></i>
							</span>
						<?=
							$this->Form->input(
								'email',
								[
									'label' => false,
									'class' => 'form-control',
									'placeholder' => __("E-mail"),
									'required' => 'required'
								]
							) ?>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-lock"></i>
							</span>
						<?=
							$this->Form->input(
								'password',
								[
									'label' => false,
									'class' => 'form-control',
									'placeholder' => __("Password"),
									'required' => 'required'
								]
							) ?>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-lock"></i>
							</span>
						<?=
							$this->Form->input(
								'password_confirm',
								[
									'type' => 'password',
									'label' => false,
									'class' => 'form-control',
									'placeholder' => __("Password (Confirmation)"),
									'required' => 'required'
								]
							) ?>
					</div>
				</div>
				<div class="form-group">
					<?=
						$this->Form->button(
							__('SignUp {0}', '<i class="fa fa-arrow-right"></i>'),
							['class' => 'btn btn-primary']
						); ?>
				</div>
				<?= $this->Form->end(); ?>
			</section>
		</div>

		<div class="col-md-5 col-md-offset-1">
			<section class="section animated bounceInRight">
				<?= $this->Form->create() ?>
				<?= $this->Form->input('method', ['type' => 'hidden', 'value' => 'login']) ?>
					<div class="section-title">
						<h3>
							<?= __("Login to your Account") ?>
						</h3>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-user"></i>
							</span>
							<?= $this->Form->input(
								'username',
								[
									'label' => false,
									'class' => 'form-control',
									'placeholder' => __("Username")
								]
							) ?>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-lock"></i>
							</span>
							<?= $this->Form->input(
								'password',
								[
									'label' => false,
									'class' => 'form-control',
									'placeholder' => __("Password")
								]
							) ?>
						</div>
					</div>
					<div class="form-group">
						<?= $this->Form->button(
							__('LogIn {0}', '<i class="fa fa-arrow-right"></i>'),
							['class' => 'btn btn-primary']
						); ?>
					</div>
				<?= $this->Form->end(); ?>
			</section>
		</div>
	</div>
</div>
