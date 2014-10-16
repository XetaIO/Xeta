<header class="navbar navbar-inverse navbar-fixed-top interface-blur" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?= $this->Html->image('logo50x50.png', ['class' => 'navbar-brand', 'alt' => \Cake\Core\Configure::read('Site.name')]) ?>
	        <?= $this->Html->link(\Cake\Core\Configure::read('Site.name'), '/', ['class' => 'navbar-brand', 'data-hover' => \Cake\Core\Configure::read('Site.name')]) ?>
        </div>
	    <nav class="collapse navbar-collapse">
		    <ul class="nav navbar-nav">
			    <li>
				    <a class="btn-nav animated slideInDown" data-toggle="modal" href="#Interface">
					    <i class="fa fa-columns"></i>
				    </a>
			    </li>
		    </ul>
		    <ul class="nav navbar-nav navbar-right">
			    <li class="dropdown">
				    <?= $this->Html->link(
						__('Hello,') . '&nbsp;'
						. '<span data-hover="' . h($this->Session->read('Auth.User.username')) . '">'
						. h($this->Session->read('Auth.User.username'))
						. '</span><i class="caret"></i>',
						'#',
						['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown', 'escape' => false]) ?>
				    <ul class="dropdown-menu" role="menu">
					    <li>
						    <?= $this->Html->link('<i class="fa fa-sign-out"></i>&nbsp;' . __('Logout'),
							['controller' => 'users', 'action' => 'logout', 'prefix' => false], ['escape' => false]);?>
					    </li>
				    </ul>
			    </li>

		    </ul>
        </nav>
    </div>
</header>
