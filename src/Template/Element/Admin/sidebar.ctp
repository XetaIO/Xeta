<div class="sidebar interface-blur">
	<div class="sidebar-inner">
		<ul class="sidebar-nav nav nav-pills nav-stacked">

			<?php if($this->request->params['action'] == 'home'): ?>
				<li class="active">
			<?php else:?>
				<li>
			<?php endif;?>
				<?= $this->Html->link(__("{0} Dashboard {1}", '<i class="fa fa-dashboard"></i>',
					'<i class="fa fa-chevron-right"></i>'), ['controller' => 'admin', 'action' => 'home', 'prefix' => 'admin'],
				['escape' => false]) ?>
			</li>

			<?php if($this->request->params['controller'] == 'Articles' || $this->request->params['controller'] == 'Categories')
			: ?>
				<li class="active">
			<?php else:?>
				<li>
			<?php endif;?>

				<?= $this->Html->link(__("{0} Blog {1}", '<i class="fa fa-newspaper-o"></i>',
						'<i class="fa fa-chevron-down"></i>'), '#submenu-blog', ['class' => 'active accordion-toggle collapsed',
						'data-toggle' => 'collapse', 'escape' => false]) ?>

				<ul id="submenu-blog" class="submenu nav collapse">
					<?= ($this->request->params['controller'] == 'Articles') ? '<li class="active">' : '<li>' ?>
						<?= $this->Html->link(__("Manage Articles"), ['controller' => 'articles', 'action' => 'index',
								'prefix' => 'admin']) ?>
					</li>

					<?= ($this->request->params['controller'] == 'Categories') ? '<li class="active">' : '<li>' ?>
						<?= $this->Html->link(__("Manage Categories"), ['controller' => 'categories', 'action' => 'index',
					'prefix' => 'admin']) ?>
					</li>
				</ul>
			</li>
			
			<?php if($this->request->params['controller'] == 'Users'): ?>
				<li class="active">
			<?php else:?>
				<li>
			<?php endif;?>
				<?= $this->Html->link(__("{0} Users {1}", '<i class="fa fa-users"></i>',
					'<i class="fa fa-chevron-right"></i>'), ['controller' => 'users', 'action' => 'index', 'prefix' => 'admin'],
				['escape' => false]) ?>
			</li>

		</ul>

	</div>
</div>

<div class="sidebar-bottom interface-blur">
	<div class="copyright">
		&copy; <span class="primary"><?= \Cake\Core\Configure::read('Site.name') ?></span> <?= date('Y', time()) ?>
	</div>
</div>
