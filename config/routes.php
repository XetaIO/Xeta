<?php

use Cake\Core\Plugin;
use Cake\Routing\Router;

Router::extensions(['json']);
Router::defaultRouteClass('InflectedRoute');

//Public routes.
Router::scope('/', function ($routes) {

	$routes->connect(
		'/:lang/pages/lang',
		[
			'controller' => 'pages',
			'action' => 'lang'
		],
		[
			'_name' => 'set-lang',
			'pass' => [
				'lang'
			]
		]
	);

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

//Forum routes.
Router::prefix('forum', function ($routes) {
	$routes->connect(
		'/',
		[
			'controller' => 'forum',
			'action' => 'index'
		]
	);

	$routes->connect(
		'/home',
		[
			'controller' => 'forum',
			'action' => 'home'
		]
	);

	//Forum Routes.
	$routes->connect(
		'/categories/:slug.:id',
		[
			'controller' => 'forum',
			'action' => 'categories'
		],
		[
			'_name' => 'forum-categories',
			'routeClass' => 'SlugRoute',
			'pass' => [
				'id',
				'slug'
			],
			'id' => '[0-9]+'
		]
	);

	$routes->connect(
		'/threads/:slug.:id',
		[
			'controller' => 'forum',
			'action' => 'threads'
		],
		[
			'_name' => 'forum-threads',
			'routeClass' => 'SlugRoute',
			'pass' => [
				'id',
				'slug'
			],
			'id' => '[0-9]+'
		]
	);

	//Threads Routes
	$routes->connect(
		'/threads/create/:slug.:id',
		[
			'controller' => 'threads',
			'action' => 'create'
		],
		[
			'_name' => 'threads-create',
			'routeClass' => 'SlugRoute',
			'pass' => [
				'id',
				'slug'
			],
			'id' => '[0-9]+'
		]
	);
	$routes->connect(
		'/threads/edit/:slug.:id',
		[
			'controller' => 'threads',
			'action' => 'edit'
		],
		[
			'_name' => 'threads-edit',
			'routeClass' => 'SlugRoute',
			'pass' => [
				'id',
				'slug'
			],
			'id' => '[0-9]+'
		]
	);

	$routes->connect(
		'/threads/reply/:slug.:id',
		[
			'controller' => 'threads',
			'action' => 'reply'
		],
		[
			'_name' => 'threads-reply',
			'routeClass' => 'SlugRoute',
			'pass' => [
				'id',
				'slug'
			],
			'id' => '[0-9]+'
		]
	);

	$routes->connect(
		'/threads/lock/:slug.:id',
		[
			'controller' => 'threads',
			'action' => 'lock'
		],
		[
			'_name' => 'threads-lock',
			'routeClass' => 'SlugRoute',
			'pass' => [
				'id',
				'slug'
			],
			'id' => '[0-9]+'
		]
	);

	$routes->connect(
		'/threads/unlock/:slug.:id',
		[
			'controller' => 'threads',
			'action' => 'unlock'
		],
		[
			'_name' => 'threads-unlock',
			'routeClass' => 'SlugRoute',
			'pass' => [
				'id',
				'slug'
			],
			'id' => '[0-9]+'
		]
	);

	//Posts Routes.
	$routes->connect(
		'/posts/edit/:id',
		[
			'controller' => 'posts',
			'action' => 'edit'
		],
		[
			'_name' => 'posts-edit',
			'pass' => [
				'id'
			],
			'id' => '[0-9]+'
		]
	);

	$routes->connect(
		'/posts/delete/:id',
		[
			'controller' => 'posts',
			'action' => 'delete'
		],
		[
			'_name' => 'posts-delete',
			'pass' => [
				'id'
			],
			'id' => '[0-9]+'
		]
	);

	$routes->connect(
		'/posts/quote/:id',
		[
			'controller' => 'posts',
			'action' => 'quote'
		],
		[
			'_name' => 'posts-quote',
			'pass' => [
				'id'
			],
			'id' => '[0-9]+'
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

	//Groups Routes.
	$routes->connect(
		'/groups/edit/:id',
		[
			'controller' => 'groups',
			'action' => 'edit',
		],
		[
			'_name' => 'groups-edit',
			'pass' => [
				'id'
			]
		]
	);

	$routes->connect(
		'/groups/delete/:id',
		[
			'controller' => 'groups',
			'action' => 'delete',
		],
		[
			'_name' => 'groups-delete',
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
