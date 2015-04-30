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
        'analytics_tracker_code' => 'UA-40328289-2'
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
        'user_per_page' => 15,
        'transaction_per_page' => 15
    ],
    'HtmlPurifier' => [
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
    ],
    'Basic-Permissions' => [
        'app',
        'app/Pages',
        'app/Pages/home',
        'app/Pages/acceptCookie',
        'app/Pages/lang',
        'app/forum/Posts/go',
        'app/forum/Posts/like',
        'app/forum/Posts/unlike',
        'app/forum/Posts/quote',
        'app/forum/Posts/getEditPost',
        'app/chat/Chat/getNotice',
    ],
    'Editable-Permissions' => [
        'Admin' => [
            'access' => 'app/admin',
        ],
        'Contact' => [
            'public access' => 'app/Contact',
        ],
        'Blog' => [
            'public blog access' => 'app/Blog',
            'delete comment' => 'app/Blog/deleteComment',
            'edit comment' => 'app/Blog/editComment',
        ],
        'Articles' => [
            'admin access' => 'app/admin/Articles',
            'add' => 'app/admin/Articles/add',
            'view' => 'app/admin/Articles/index',
            'edit' =>  'app/admin/Articles/edit',
            'delete'=> 'app/admin/Articles/delete'
        ],
        'Categories' => [
            'admin access' => 'app/admin/Categories',
            'add' => 'app/admin/Categories/add',
            'view' => 'app/admin/Categories/index',
            'edit' => 'app/admin/Categories/edit',
            'delete' => 'app/admin/Categories/delete'
        ],
        'Attachments' => [
            'admin access' => 'app/admin/Attachments',
            'add' => 'app/admin/Attachments/add',
            'edit' =>  'app/admin/Attachments/edit',
            'delete' =>  'app/admin/Attachments/delete'
        ],
        'Forums' => [
            'admin access' => 'app/admin/forum',
            'add categorie' => 'app/admin/forum/Categories/add',
            'edit categorie' => 'app/admin/forum/Categories/edit',
            'delete categorie' => 'app/admin/forum/Categories/delete',
            'delete moveup' => 'app/admin/forum/Categories/moveup',
            'delete movedown' => 'app/admin/forum/Categories/movedown',
            'show index' =>  'app/forum/Forum/index',
            'show categories' => 'app/forum/Forum/categories',
            'show threads' => 'app/forum/Forum/threads'
        ],
        'Threads' => [
            'create' =>  'app/forum/Threads/create',
            'edit' =>  'app/forum/Threads/edit',
            'reply' =>  'app/forum/Threads/reply',
            'lock' =>  'app/forum/Threads/lock',
            'unlock' =>  'app/forum/Threads/unlock'
        ],
        'Posts' => [
            'new' =>  'app/forum/Posts/new',
            'edit' =>  'app/forum/Posts/edit',
            'delete' =>  'app/forum/Posts/delete'
        ],
        'Chat' => [
            'show' => 'app/chat/Chat/index',
            'edit' => 'app/chat/Chat/editNotice',
            'shout' => 'app/chat/Chat/shout',
            'delete' => 'app/chat/Chat/delete',
            'canPrune' => 'app/chat/Permissions/canPrune',
            'canBan' => 'app/chat/Permissions/canBan',
            'canUnban' => 'app/chat/Permissions/canUnban',
            'canDelete' => 'app/chat/Permissions/canDelete',
            'canNotice' => 'app/chat/Permissions/canNotice'
        ],
        'Users' => [
            'show' => 'app/admin/Users/index',
            'edit' => 'app/admin/Users/edit',
            'delete avatar' => 'app/admin/Users/deleteAvatar',
            'delete' => 'app/admin/Users/delete'
        ],
        'Groups' => [
            'access' => 'app/admin/Groups',
            'add' => 'app/admin/Groups/add',
            'edit' => 'app/admin/Groups/edit',
            'delete' => 'app/admin/Groups/delete'
        ],
        'Premium' => [
            'subscribe' => 'app/Premium/index',
            'admin statistics' => 'app/admin/premium/Premium/home'
        ],
        'Offers' => [
            'admin access' => 'app/admin/premium/Offers',
            'add' => 'app/admin/premium/Offers/add',
            'edit' => 'app/admin/premium/Offers/edit',
            'delete' => 'app/admin/premium/Offers/delete'
        ],
        'Discounts' => [
            'admin access' => 'app/admin/premium/Discounts',
            'add' => 'app/admin/premium/Discounts/add',
            'edit' => 'app/admin/premium/Discounts/edit'
        ]
    ]
];
