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

	$routes->fallbacks();
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

	$routes->fallbacks();
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
	Plugin::routes();
