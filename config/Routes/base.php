<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

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
            ],
            'type' => '(?i:blog)',
            'id' => '[0-9]+'
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

    //Polls Routes.
    $routes->connect(
        '/polls/vote/:slug.:id',
        [
            'controller' => 'polls',
            'action' => 'vote'
        ],
        [
            '_name' => 'polls-vote',
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
