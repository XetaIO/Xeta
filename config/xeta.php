<?php
$config = [
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
			'max_articles' => 10,
			'max_comments' => 10,
			'max_likes' => 10
		],
		'user_per_page' => 15
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
		]
	]
];
