<?php

use Cake\Core\Plugin;
use Cake\Routing\Router;

Router::extensions(['json']);

//Public routes.
Router::scope('/', function ($routes) {

	$routes->connect(
		'/',
		[
			'controller' => 'pages',
			'action' => 'home'
		],
		[
			'routeClass' => 'InflectedRoute'
		]
	);

	//Blog Routes.
	$routes->connect(
		'/blog/article/:slug',
		[
			'controller' => 'blog',
			'action' => 'article'
		],
		[
			'routeClass' => 'InflectedRoute',
			'_name' => 'blog-article',
			'pass' => [
				'slug'
			]
		]
	);

	$routes->connect(
		'/blog/category/:slug',
		[
			'controller' => 'blog',
			'action' => 'category',
		],
		[
			'routeClass' => 'InflectedRoute',
			'_name' => 'blog-category',
			'pass' => [
				'slug'
			]
		]
	);

	$routes->connect(
		'/blog/archive/:slug',
		[
			'controller' => 'blog',
			'action' => 'archive',
		],
		[
			'routeClass' => 'InflectedRoute',
			'_name' => 'blog-archive',
			'pass' => [
				'slug'
			]
		]
	);

	//Users Routes.
	$routes->connect(
		'/users/profile/:slug',
		[
			'controller' => 'users',
			'action' => 'profile'
		],
		[
			'routeClass' => 'InflectedRoute',
			'_name' => 'users-profile',
			'pass' => [
				'slug'
			]
		]
	);

	//Attachments Routes.
	$routes->connect(
		'/attachments/download/:type/:id',
		[
			'controller' => 'attachments',
			'action' => 'download',
		],
		[
			'routeClass' => 'InflectedRoute',
			'_name' => 'attachment-download',
			'pass' => [
				'type',
				'id'
			]
		]
	);

	$routes->fallbacks('InflectedRoute');
});

//Admin routes.
Router::prefix('admin', function ($routes) {
	$routes->connect(
		'/',
		[
			'controller' => 'admin',
			'action' => 'home'
		],
		[
			'routeClass' => 'InflectedRoute'
		]
	);

	//Users Routes.
	$routes->connect(
		'/users/edit/:slug',
		[
			'controller' => 'users',
			'action' => 'edit'
		],
		[
			'routeClass' => 'InflectedRoute',
			'_name' => 'users-edit',
			'pass' => [
				'slug'
			]
		]
	);

	$routes->connect(
		'/users/delete/:slug',
		[
			'controller' => 'users',
			'action' => 'delete'
		],
		[
			'routeClass' => 'InflectedRoute',
			'_name' => 'users-delete',
			'pass' => [
				'slug'
			]
		]
	);

	$routes->connect(
		'/users/deleteAvatar/:slug',
		[
			'controller' => 'users',
			'action' => 'deleteAvatar'
		],
		[
			'routeClass' => 'InflectedRoute',
			'_name' => 'users-deleteAvatar',
			'pass' => [
				'slug'
			]
		]
	);

	//Articles Routes.
	$routes->connect(
		'/articles/edit/:slug',
		[
			'controller' => 'articles',
			'action' => 'edit',
		],
		[
			'routeClass' => 'InflectedRoute',
			'_name' => 'articles-edit',
			'pass' => [
				'slug'
			]
		]
	);

	$routes->connect(
		'/articles/delete/:slug',
		[
			'controller' => 'articles',
			'action' => 'delete',
		],
		[
			'routeClass' => 'InflectedRoute',
			'_name' => 'articles-delete',
			'pass' => [
				'slug'
			]
		]
	);

	//Categories Routes.
	$routes->connect(
		'/categories/edit/:slug',
		[
			'controller' => 'categories',
			'action' => 'edit',
		],
		[
			'routeClass' => 'InflectedRoute',
			'_name' => 'categories-edit',
			'pass' => [
				'slug'
			]
		]
	);

	$routes->connect(
		'/categories/delete/:slug',
		[
			'controller' => 'categories',
			'action' => 'delete',
		],
		[
			'routeClass' => 'InflectedRoute',
			'_name' => 'categories-delete',
			'pass' => [
				'slug'
			]
		]
	);

	//Attachments Routes.
	$routes->connect(
		'/attachments/edit/:id',
		[
			'controller' => 'attachments',
			'action' => 'edit',
		],
		[
			'routeClass' => 'InflectedRoute',
			'_name' => 'attachments-edit',
			'pass' => [
				'id'
			]
		]
	);

	$routes->connect(
		'/attachments/delete/:id',
		[
			'controller' => 'attachments',
			'action' => 'delete',
		],
		[
			'routeClass' => 'InflectedRoute',
			'_name' => 'attachments-delete',
			'pass' => [
				'id'
			]
		]
	);

/**
 * Premium Routes.
 */
	$routes->prefix('premium', function ($routes) {
		$routes->connect(
			'/',
			[
				'controller' => 'premium',
				'action' => 'home'
			],
			[
				'routeClass' => 'InflectedRoute'
			]
		);

		//Premium/Offers Routes.
		$routes->connect(
			'/offers/edit/:id',
			[
				'controller' => 'offers',
				'action' => 'edit',
			],
			[
				'routeClass' => 'InflectedRoute',
				'_name' => 'offers-edit',
				'pass' => [
					'id'
				]
			]
		);

		$routes->connect(
			'/offers/delete/:id',
			[
				'controller' => 'offers',
				'action' => 'delete',
			],
			[
				'routeClass' => 'InflectedRoute',
				'_name' => 'offers-delete',
				'pass' => [
					'id'
				]
			]
		);

		//Premium/Discounts Routes.
		$routes->connect(
			'/discounts/edit/:id',
			[
				'controller' => 'discounts',
				'action' => 'edit',
			],
			[
				'routeClass' => 'InflectedRoute',
				'_name' => 'discounts-edit',
				'pass' => [
					'id'
				]
			]
		);

		$routes->fallbacks('InflectedRoute');
	});

	$routes->fallbacks('InflectedRoute');
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
	Plugin::routes();
