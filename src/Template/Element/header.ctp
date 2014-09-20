<header class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?= $this->Html->link(\Cake\Core\Configure::read('Site.name'), '/', ['class' => 'navbar-brand', 'data-hover' => \Cake\Core\Configure::read('Site.name')]);?>
		</div>
		<nav class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<?= (strtolower($this->request->params['controller']) == 'pages' && strtolower($this->request->params['action']) == 'home') ? '<li class="active">' : '<li>' ?>
					<a href="<?= $this->Url->build('/');?>">
						<span data-hover="<?=__("Home");?>"><?= __("Home") ?></span>
					</a>
				</li>
				<?= (strtolower($this->request->params['controller']) == 'blog') ? '<li class="active">' : '<li>' ?>
					<a href="<?= $this->Url->build(['controller' => 'blog', 'action' => 'index']);?>">
						<span data-hover="<?=__("Blog");?>"><?= __("Blog") ?></span>
					</a>
				</li>
				<?= (strtolower($this->request->params['controller']) == 'contact') ? '<li class="active">' : '<li>' ?>
					<a href="<?= $this->Url->build(['controller' => 'contact', 'action' => 'index']);?>">
						<span data-hover="<?=__("Contact");?>"><?= __("Contact") ?></span>
					</a>
				</li>
			</ul>

			<div class="nav navbar-nav navbar-right">
				<?php if($this->Session->read('Auth.User')): ?>
					<p class="navbar-text">
						<?= __('Hello,') . '&nbsp;'; ?>
						<?= $this->Html->link($this->Session->read('Auth.User.username'), '#', ['class' => 'user-menu-trigger']);?>
					</p>
				<?php else:?>
					<?= $this->Html->link(__("Login"), ['controller' => 'users', 'action' => 'login'], ['class' => 'btn btn-outline navbar-btn']);?>
					<?= $this->Html->link(__("Sign up"), ['controller' => 'users', 'action' => 'login'], ['class' => 'btn btn-primary navbar-btn']);?>
				<?php endif;?>
			</div>
		</nav>
	</div>
</header>

<?php if($this->Session->read('Auth.User')): ?>
	<nav id="user-menu" class="user-menu menu-close">

		<?= $this->Html->image('http://xeta.io/templates/components/Xeta/1.0/img/avatar.png', ['class' => 'user-menu-img']);?>
		<ul>
			<li>
				<?= $this->Html->link('<i class="fa fa-user"></i>&nbsp;' . __('My Profil'), ['_name' => 'users-profile', 'slug' => h($this->Session->read('Auth.User.slug'))], ['escape' => false]);?>
			</li>
			<li>
				<?= $this->Html->link('<i class="fa fa-cogs"></i>&nbsp;' . __('My Account'), ['controller' => 'users', 'action' => 'account'], ['escape' => false]);?>
			</li>
			<li>
				<?= $this->Html->link('<i class="fa fa-sign-out"></i>&nbsp;' . __('Logout'), ['controller' => 'users', 'action' => 'logout'], ['escape' => false]);?>
			</li>
		</ul>
		<ul>
			<li>
				<a href="http://www.twitter.com/NozeAres"><i class="fa fa-twitter-square"></i></a>
			</li>
			<li>
				<a href="https://plus.google.com/101095823814290637419"><i class="fa fa-google-plus-square"></i></a>
			</li>
			<li>
				<a href="http://www.facebook.com/Emeric.ZoRRo"><i class="fa fa-facebook-square"></i></a>
			</li>
		</ul>
	</nav>
<?php endif; ?>
