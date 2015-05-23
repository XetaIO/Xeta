<?php
return [
    'Author' => [
        'full_name' => 'Emeric Fèvre',
        'pseudo' => 'Xeta',
        'twitter' => 'https://twitter.com/FMT_ZoRo',
        'facebook' => 'https://facebook.com/Emeric.ZoRRo',
        'email' => 'zoro.fmt@gmail.com',
        'address' => 'Chalon sur Saône, 71100 France'
    ],
    'Site' => [
        'name' => 'Xeta',
        'description' => 'You will find content related to web development like tutorials, my personal tests on new technologies etc',
        'github_url' => 'https://github.com/Xety/Xeta',
        'analytics_tracker_code' => 'UA-40328289-2',
        'full_url' => 'https://xeta.io'
    ],
    'Home' => [
        'articles' => 8,
        'comments' => 8
    ],
    'Blog' => [
        'article_per_page' => 10,
        'comment_per_page' => 10
    ],
    'User' => [
        'Profile' => [
            'max_blog_articles' => 5,
            'max_blog_comments' => 5,
            'max_forum_threads' => 5,
            'max_forum_posts' => 5
        ],
        'ResetPassword' => [
            'expire_code' => 10 //In minutes.
        ],
        'user_per_page' => 15,
        'transaction_per_page' => 15,
        'max_notifications' => 5,
        'notifications_per_page' => 4
    ],
    'Group' => [
        'user_per_page' => 15
    ],
    'HtmlPurifier' => [
        'Conversations' => [
            'message' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => 'p, h1, h2, h3, h4, h5, span[style], strong, em, u, img[alt|src|style|title], ol, li, ul,
                a[href], br, blockquote, pre[class]',
                'CSS.AllowedProperties' => 'font-size,height,width',
                'Attr.AllowedClasses' => 'prettyprint, linenums',
                'AutoFormat.RemoveEmpty' => true
            ],
            'message_empty' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => 'p',
                'AutoFormat.RemoveEmpty' => true
            ]
        ],
        'User' => [
            'biography' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => 'p, h1, h2, h3, h4, h5, span[style], strong, em, u, img[alt|src|style|title], ol, li, ul,
                a[href], br, blockquote',
                'CSS.AllowedProperties' => 'font-size,height,width,color',
                'AutoFormat.RemoveEmpty' => true
            ],
            'signature' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => 'p, strong, em, u, a[href], br, img[alt|src|style|title]',
                'AutoFormat.RemoveEmpty' => true
            ]
        ],
        'Blog' => [
            'comment' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => 'p, h1, h2, h3, h4, h5, span[style], strong, em, u, img[alt|src|style|title], ol, li, ul,
                a[href], br, blockquote, pre[class]',
                'CSS.AllowedProperties' => 'font-size,height,width',
                'Attr.AllowedClasses' => 'prettyprint, linenums',
                'AutoFormat.RemoveEmpty' => true
            ],
            'comment_empty' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => 'p',
                'AutoFormat.RemoveEmpty' => true
            ],
            'article' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => 'p, h1, h2, h3, h4, h5, span[style], strong, em, u, img[alt|src|style|title], ol, li, ul,
                a[href], br, blockquote, pre[class]',
                'CSS.AllowedProperties' => 'font-size,height,width',
                'Attr.AllowedClasses' => 'prettyprint, linenums',
                'AutoFormat.RemoveEmpty' => true
            ],
            'article_empty' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => 'p',
                'AutoFormat.RemoveEmpty' => true
            ],
            'article_meta' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => '',
                'AutoFormat.RemoveEmpty' => true
            ]
        ],
        'Forum' => [
            'post' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => 'p, h1, h2, h3, h4, h5, span[style], strong, em, u, img[alt|src|style|title], ol, li, ul,
                a[href], br, blockquote, pre[class]',
                'CSS.AllowedProperties' => 'font-size,height,width',
                'Attr.AllowedClasses' => 'prettyprint, linenums',
                'AutoFormat.RemoveEmpty' => true
            ],
            'post_empty' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => 'p',
                'AutoFormat.RemoveEmpty' => true
            ],
            'post_meta' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => '',
                'AutoFormat.RemoveEmpty' => true
            ],
            'thread' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => 'p, h1, h2, h3, h4, h5, span[style], strong, em, u, img[alt|src|style|title], ol, li, ul,
                a[href], br, blockquote, pre[class]',
                'CSS.AllowedProperties' => 'font-size,height,width',
                'Attr.AllowedClasses' => 'prettyprint, linenums',
                'AutoFormat.RemoveEmpty' => true
            ],
            'thread_empty' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => 'p',
                'AutoFormat.RemoveEmpty' => true
            ],
            'thread_meta' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => '',
                'AutoFormat.RemoveEmpty' => true
            ]
        ],
        'Chat' => [
            'notice' => [
                'Core.Encoding' => 'UTF-8',
                'URI.Base' => 'https://xeta.io',
                'HTML.Allowed' => 'p, strong, b, em, u, a[href|target], br, span[style], img[alt|src|style|title]',
                'CSS.AllowedProperties' => 'font-size,color,height,width',
                'AutoFormat.RemoveEmpty' => true
            ]
        ]
    ],
    'Forum' => [
        'Categories' => [
            'threads_per_page' => 15
        ],
        'Threads' => [
            'posts_per_page' => 10
        ],
        'Sidebar' => [
            'latest_threads' => 5
        ]
    ],
    'Conversations' => [
        'enabled' => true,
        'max_users_per_conversation' => 20,
        'messages_per_page' => 10
    ],
    'Premium' => [
        'color' => '#F2C732'
    ],
    'Chat' => [
        //Enable/Disable the chat.
        'enabled' => true,
        //Time out in seconds before to delete an user from the Online list.
        'usersTimeOut' => 10,
        //The refrest time in seconds.
        'refreshTime' => 3,
        //Max messages to display in the chat.
        'maxMessages' => 25,
        //Max times to retry to get the messages after an error.
        'maxRetrying' => 5,
        //The seconds to wait between sending 2 mesages.
        'floodRule' => 3,
        //The spam rule in %. (By similarity)
        'spamRule' => 95,
        //Max characters per message.
        'messageMaxLength' => 400
    ]
];
