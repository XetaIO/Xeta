<?php

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::extensions(['json', 'xml']);

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

//Public routes.
Router::scope('/', function (RouteBuilder $routes) {

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
        '/blog/article/:slug.:id',
        [
            'controller' => 'blog',
            'action' => 'article'
        ],
        [
            '_name' => 'blog-article',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/blog/category/:slug.:id',
        [
            'controller' => 'blog',
            'action' => 'category',
        ],
        [
            '_name' => 'blog-category',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
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
        '/users/profile/:slug.:id',
        [
            'controller' => 'users',
            'action' => 'profile'
        ],
        [
            '_name' => 'users-profile',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );
    $routes->connect(
        '/users/resetPassword/:code.:id',
        [
            'controller' => 'users',
            'action' => 'resetPassword'
        ],
        [
            '_name' => 'users-resetpassword',
            'pass' => [
                'id',
                'code'
            ],
            'id' => '[0-9]+'
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

    //Groups Routes.
    $routes->connect(
        '/groups/view/:slug.:id',
        [
            'controller' => 'groups',
            'action' => 'view'
        ],
        [
            '_name' => 'groups-view',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );

    //Conversations Routes.
    $routes->connect(
        '/conversations/view/:slug.:id',
        [
            'controller' => 'conversations',
            'action' => 'view'
        ],
        [
            '_name' => 'conversations-view',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/conversations/messageEdit/:id',
        [
            'controller' => 'conversations',
            'action' => 'messageEdit'
        ],
        [
            '_name' => 'conversations-messageEdit',
            'pass' => [
                'id'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/conversations/quote/:id',
        [
            'controller' => 'conversations',
            'action' => 'quote'
        ],
        [
            '_name' => 'conversations-quote',
            'pass' => [
                'id'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/conversations/invite/:slug.:id',
        [
            'controller' => 'conversations',
            'action' => 'invite'
        ],
        [
            '_name' => 'conversations-invite',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/conversations/edit/:slug.:id',
        [
            'controller' => 'conversations',
            'action' => 'edit'
        ],
        [
            '_name' => 'conversations-edit',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/conversations/leave/:slug.:id',
        [
            'controller' => 'conversations',
            'action' => 'leave'
        ],
        [
            '_name' => 'conversations-leave',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/conversations/kick/:id/:user_id',
        [
            'controller' => 'conversations',
            'action' => 'kick'
        ],
        [
            '_name' => 'conversations-kick',
            'pass' => [
                'id',
                'user_id'
            ],
            'id' => '[0-9]+',
            'user_id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/conversations/reply/:slug.:id',
        [
            'controller' => 'conversations',
            'action' => 'reply'
        ],
        [
            '_name' => 'conversations-reply',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->fallbacks();
});

//Admin routes.
Router::prefix('admin', function (RouteBuilder $routes) {
    $routes->connect(
        '/',
        [
            'controller' => 'admin',
            'action' => 'home'
        ]
    );

    //Users Routes.
    $routes->connect(
        '/users/edit/:slug.:id',
        [
            'controller' => 'users',
            'action' => 'edit'
        ],
        [
            '_name' => 'users-edit',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/users/delete/:slug.:id',
        [
            'controller' => 'users',
            'action' => 'delete'
        ],
        [
            '_name' => 'users-delete',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/users/deleteAvatar/:slug.:id',
        [
            'controller' => 'users',
            'action' => 'deleteAvatar'
        ],
        [
            '_name' => 'users-deleteAvatar',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
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
    $routes->prefix('premium', function (RouteBuilder $routes) {
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
