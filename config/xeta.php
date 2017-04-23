<?php
return [
    'Author' => [
        'full_name' => 'Emeric Fèvre',
        'pseudo' => 'Xeta',
        'twitter' => 'https://twitter.com/FMT_ZoRo',
        'facebook' => 'https://facebook.com/Emeric.ZoRRo',
        'email' => 'emeric@xeta.io',
        'address' => 'Chalon sur Saône, 71100 France'
    ],
    'Site' => [
        'name' => 'Xeta',
        'version' => '3.1.1',
        'description' => 'You will find content related to web development like tutorials, my personal tests on new technologies etc',
        'github_url' => 'https://github.com/XetaIO/Xeta',
        'contact_email' => 'contact@xeta.io',
        'analytics_tracker_code' => 'UA-40328289-2',
        'full_url' => 'https://xeta.io',
        'maintenance' => false
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
        'Login' => [
            'enabled' => true
        ],
        'Register' => [
            'enabled' => true
        ],
        'Profile' => [
            'max_blog_articles' => 5,
            'max_blog_comments' => 5
        ],
        'ResetPassword' => [
            'expire_code' => 10 //In minutes.
        ],
        'user_per_page' => 15,
        'transaction_per_page' => 15,
        'max_notifications' => 5,
        'notifications_per_page' => 15
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
        ]
    ],
    'Conversations' => [
        'enabled' => true,
        'max_users_per_conversation' => 20,
        'messages_per_page' => 10,
        'conversations_per_page' => 15
    ]
];
