<?php

use Cake\Core\Plugin;
use Cake\Routing\Router;

Router::extensions(['json']);

/**
 * Public routes.
 */
Router::scope('/', function($routes) {

	$routes->connect('/', ['controller' => 'Pages', 'action' => 'home']);

/**
 * Blog Routes.
 */
	$routes->connect(
		'/blog/article/:slug',
		[
			'controller' => 'Blog',
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
			'controller' => 'Blog',
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
			'controller' => 'Blog',
			'action' => 'archive',

		],
		[
			'_name' => 'blog-archive',
			'pass' => [
				'slug'
			]
		]
	);

/**
 * User profile Routes.
 */
	$routes->connect(
		'/users/profile/:slug',
		[
			'controller' => 'Users',
			'action' => 'profile',

		],
		[
			'_name' => 'users-profile',
			'pass' => [
				'slug'
			]
		]
	);

	$routes->fallbacks();
});

/**
 * Admin routes.
 */
Router::prefix('admin', function ($routes) {
	$routes->connect('/home', ['controller' => 'Admin', 'action' => 'home']);

	$routes->fallbacks();
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
	Plugin::routes();
