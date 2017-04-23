<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

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
        '/articles/edit/:slug.:id',
        [
            'controller' => 'articles',
            'action' => 'edit',
        ],
        [
            '_name' => 'articles-edit',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/articles/delete/:slug.:id',
        [
            'controller' => 'articles',
            'action' => 'delete',
        ],
        [
            '_name' => 'articles-delete',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );

    //Categories Routes.
    $routes->connect(
        '/categories/edit/:slug.:id',
        [
            'controller' => 'categories',
            'action' => 'edit',
        ],
        [
            '_name' => 'categories-edit',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/categories/delete/:slug.:id',
        [
            'controller' => 'categories',
            'action' => 'delete',
        ],
        [
            '_name' => 'categories-delete',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
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

    //Polls Routes.
    $routes->connect(
        '/polls/edit/:slug.:id',
        [
            'controller' => 'polls',
            'action' => 'edit',
        ],
        [
            '_name' => 'polls-edit',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/polls/delete/:slug.:id',
        [
            'controller' => 'polls',
            'action' => 'delete',
        ],
        [
            '_name' => 'polls-delete',
            'routeClass' => 'SlugRoute',
            'pass' => [
                'id',
                'slug'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/polls/answers/delete/:id',
        [
            'controller' => 'pollsAnswers',
            'action' => 'delete',
        ],
        [
            '_name' => 'polls-answers-delete',
            'pass' => [
                'id'
            ],
            'id' => '[0-9]+'
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

    //Settings Routes.
    $routes->connect(
        '/settings/edit/:id',
        [
            'controller' => 'settings',
            'action' => 'edit'
        ],
        [
            '_name' => 'settings-edit',
            'pass' => [
                'id'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/settings/view/:id',
        [
            'controller' => 'settings',
            'action' => 'view'
        ],
        [
            '_name' => 'settings-view',
            'pass' => [
                'id'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->connect(
        '/settings/delete/:id',
        [
            'controller' => 'settings',
            'action' => 'delete'
        ],
        [
            '_name' => 'settings-delete',
            'pass' => [
                'id'
            ],
            'id' => '[0-9]+'
        ]
    );

    $routes->fallbacks();
});
