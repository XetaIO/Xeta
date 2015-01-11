<?php

use Cake\Core\Plugin;
use Cake\Routing\Router;

Router::extensions(['json']);
Router::defaultRouteClass('InflectedRoute');

//Public routes.
Router::scope('/', function ($routes) {

	$routes->connect(
		'/',
		[
			'controller' => 'pages',
			'action' => 'home'
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
			'_name' => 'attachment-download',
			'pass' => [
				'type',
				'id'
			]
		]
	);

	$routes->fallbacks();
});

//Admin routes.
Router::prefix('admin', function ($routes) {
	$routes->connect(
		'/',
		[
			'controller' => 'admin',
			'action' => 'home'
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
				'_name' => 'discounts-edit',
				'pass' => [
					'id'
				]
			]
		);

		$routes->fallbacks();
	});

	$routes->fallbacks();
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
	Plugin::routes();
