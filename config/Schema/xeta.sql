
--
-- Table structure `badges`
--

CREATE TABLE IF NOT EXISTS `badges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `rule` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Table data `badges`
--

INSERT INTO `badges` (`id`, `name`, `picture`, `type`, `rule`, `created`) VALUES
(1, 'First Comment', 'badges/comments-1.png', 'comments', 1, '2014-11-10 14:00:00'),
(2, '10 Comments', 'badges/comments-10.png', 'comments', 10, '2014-11-10 14:00:00'),
(3, '1 year old', 'badges/registration-1.png', 'registration', 1, '2014-11-10 16:00:00'),
(4, '2 years old', 'badges/registration-2.png', 'registration', 2, '2014-11-10 16:00:00'),
(5, '3 years old', 'badges/registration-3.png', 'registration', 3, '2014-11-10 16:00:00');

-- --------------------------------------------------------

--
-- Table structure `badges_users`
--

CREATE TABLE IF NOT EXISTS `badges_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `badge_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure 'blog_articles'
--

CREATE TABLE IF NOT EXISTS blog_articles (
  id int(11) NOT NULL AUTO_INCREMENT,
  category_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  title varchar(255) NOT NULL,
  content text NOT NULL,
  slug varchar(255) NOT NULL,
  comment_count int(11) NOT NULL DEFAULT '0',
  like_count int(11) NOT NULL DEFAULT '0',
  is_display tinyint(4) NOT NULL DEFAULT '1',
  created datetime NOT NULL,
  modified datetime NOT NULL,
  PRIMARY KEY (id),
  KEY slug (slug)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Table data 'blog_articles'
--

INSERT INTO blog_articles (id, category_id, user_id, title, content, slug, comment_count, like_count, is_display, created, modified) VALUES
(1, 1, 1, 'Lorem ipsum dolor sit amet', '<p><strong>Lorem ipsum</strong> dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>\r\n\r\n<blockquote>\r\n<p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>\r\n</blockquote>\r\n\r\n<p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat : </p>\r\n\r\n<ul><li>vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto</li>\r\n	<li>odio dignissim qui blandit praesent luptatum zzril</li>\r\n	<li>delenit augue duis dolore te feugait nulla facilisi</li>\r\n</ul><p> </p>\r\n\r\n<p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. <img alt="heureux" src="http://xeta.io/js/ckeditor/plugins/smiley/images/heureux.png" style="height:19px;width:19px;" title="heureux" /></p>\r\n', 'lorem-ipsum-dolor-sit-amet', 2, 1, 1, '2014-09-22 10:10:00', '2014-09-22 10:10:00');

-- --------------------------------------------------------

--
-- Table structure `blog_articles_i18n`
--

CREATE TABLE IF NOT EXISTS `blog_articles_i18n` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`locale` varchar(6) NOT NULL,
	`model` varchar(255) NOT NULL,
	`foreign_key` int(10) NOT NULL,
	`field` varchar(255) NOT NULL,
	`content` text,
	PRIMARY KEY (`id`),
	UNIQUE KEY `I18N_LOCALE_FIELD` (`locale`,`model`,`foreign_key`,`field`),
	KEY `I18N_FIELD` (`model`,`foreign_key`,`field`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Table data 'blog_articles_i18n'
--

INSERT INTO `blog_articles_i18n` (`id`, `locale`, `model`, `foreign_key`, `field`, `content`) VALUES
(1, 'en_US', 'BlogArticles', 1, 'title', 'Title in english'),
(2, 'en_US', 'BlogArticles', 1, 'content', '<p>Content in english</p>');

-- --------------------------------------------------------

--
-- Table structure 'blog_articles_comments'
--

CREATE TABLE IF NOT EXISTS blog_articles_comments (
  id int(11) NOT NULL AUTO_INCREMENT,
  article_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  content text NOT NULL,
  created datetime NOT NULL,
  modified datetime NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Table data 'blog_articles_comments'
--

INSERT INTO blog_articles_comments (id, article_id, user_id, content, created, modified) VALUES
(1, 1, 1, '<p>Lorem i<strong>psum dolor sit amet,</strong> consectetuer adipiscing elit, sed diam nonummy nibh <u>euismod tincidunt </u>ut laoreet dolore <em>magna aliquam </em>erat volutpat.</p>\r\n', '2014-09-22 10:16:21', '2014-09-22 10:16:21'),
(2, 1, 2, '<p><a href="/blog/go/1"><strong>Admin has said :</strong> </a></p>\n\n<blockquote>\n<p>Lorem i<strong>psum dolor sit amet,</strong> consectetuer adipiscing elit, sed diam nonummy nibh <u>euismod tincidunt </u>ut laoreet dolore <em>magna aliquam </em>erat volutpat.</p>\n</blockquote>\n\n<p> </p>\n\n<p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse <strong>molestie consequat,</strong> vel illum dolore eu feugiat nulla facilisis <em>at vero eros</em> et accumsan et iusto odio dignissim qui blandit praesent <u>luptatum zzril delenit</u> augue duis dolore te feugait nulla facilisi.</p>\n', '2014-09-22 10:19:30', '2014-09-22 10:19:30');

-- --------------------------------------------------------

--
-- Table structure 'blog_articles_likes'
--

CREATE TABLE IF NOT EXISTS blog_articles_likes (
  id int(11) NOT NULL AUTO_INCREMENT,
  article_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  created datetime NOT NULL,
  modified datetime NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Table data 'blog_articles_likes'
--

INSERT INTO blog_articles_likes (id, article_id, user_id, created, modified) VALUES
(1, 1, 2, '2014-09-22 10:21:34', '2014-09-22 10:21:34');

-- --------------------------------------------------------

--
-- Table structure 'blog_categories'
--

CREATE TABLE IF NOT EXISTS blog_categories (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  description tinytext NOT NULL,
  slug varchar(255) NOT NULL,
  article_count int(11) NOT NULL DEFAULT '0',
  created datetime NOT NULL,
  modified datetime NOT NULL,
  PRIMARY KEY (id),
  KEY slug (slug)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Table data 'blog_categories'
--

INSERT INTO blog_categories (id, title, description, slug, article_count, created, modified) VALUES
(1, 'Xeta', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 'xeta', 1, '2014-09-22 10:00:00', '2014-09-22 10:00:00');

-- --------------------------------------------------------

--
-- Table structure `blog_attachments`
--

CREATE TABLE IF NOT EXISTS `blog_attachments` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`article_id` int(11) NOT NULL,
	`name` varchar(255) NOT NULL,
	`size` int(11) NOT NULL,
	`extension` varchar(15) NOT NULL,
	`url` varchar(255) NOT NULL,
	`download` bigint(20) NOT NULL DEFAULT '0',
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure `premium_discounts`
--

CREATE TABLE IF NOT EXISTS `premium_discounts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`premium_offer_id` int(11) NOT NULL,
	`code` varchar(50) NOT NULL,
	`discount` float NOT NULL,
	`used` int(11) NOT NULL DEFAULT '0',
	`max_use` int(11) NOT NULL DEFAULT '0',
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Table data `premium_discounts`
--

INSERT INTO `premium_discounts` (`id`, `user_id`, `premium_offer_id`, `code`, `discount`, `used`, `max_use`, `created`, `modified`) VALUES
(1, 1, 4, 'XETAREDUC', 50, 2, 2, '2014-11-19 06:00:00', '2014-12-15 10:06:16'),
(2, 1, 3, 'XETATEST', 11, 1, 3, '2014-11-21 06:00:00', '2014-12-19 13:44:40');

-- --------------------------------------------------------

--
-- Table structure `premium_offers`
--

CREATE TABLE IF NOT EXISTS `premium_offers` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`period` int(11) NOT NULL,
	`price` float NOT NULL,
	`tax` float NOT NULL DEFAULT '19.6',
	`currency_code` varchar(3) NOT NULL DEFAULT 'EUR',
	`currency_symbol` varchar(4) NOT NULL DEFAULT '€',
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Table data `premium_offers`
--

INSERT INTO `premium_offers` (`id`, `user_id`, `period`, `price`, `tax`, `currency_code`, `currency_symbol`, `created`, `modified`) VALUES
(1, 1, 1, 3, 19.6, 'EUR', '€', '2014-11-19 05:00:00', '2014-11-19 05:00:00'),
(2, 1, 3, 8.5, 19.6, 'EUR', '€', '2014-11-19 05:00:00', '2014-11-19 05:00:00'),
(3, 1, 6, 16.5, 19.6, 'EUR', '€', '2014-11-19 05:00:00', '2014-11-19 05:00:00'),
(4, 1, 12, 32, 19.6, 'EUR', '€', '2014-11-19 05:00:00', '2014-11-19 05:00:00');

-- --------------------------------------------------------

--
-- Table structure `premium_transactions`
--

CREATE TABLE IF NOT EXISTS `premium_transactions` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`premium_offer_id` int(11) NOT NULL,
	`premium_discount_id` int(11) DEFAULT NULL,
	`price` float NOT NULL,
	`tax` float NOT NULL,
	`txn` varchar(255) NOT NULL,
	`action` enum('new','extend') NOT NULL DEFAULT 'new',
	`period` int(11) NOT NULL,
	`name` varchar(50) NOT NULL,
	`country` varchar(50) NOT NULL,
	`city` varchar(50) NOT NULL,
	`address` varchar(255) NOT NULL,
	`created` datetime NOT NULL,
	`modified` datetime NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Table data `groups`
--

INSERT INTO `groups` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Banni', '2015-01-16 16:51:12', '2015-01-21 02:03:10'),
(2, 'Membre', '2015-01-16 16:51:22', '2015-01-21 02:02:21'),
(3, 'Editeur', '2015-01-16 16:51:30', '2015-01-21 02:02:12'),
(4, 'Modérateur', '2015-01-16 16:51:51', '2015-01-21 02:02:03'),
(5, 'Administrateur', '2015-01-16 16:52:00', '2015-01-21 02:01:45');

-- --------------------------------------------------------

--
-- Table structure `groups_i18n`
--

CREATE TABLE IF NOT EXISTS `groups_i18n` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`locale` varchar(6) NOT NULL,
	`model` varchar(255) NOT NULL,
	`foreign_key` int(10) NOT NULL,
	`field` varchar(255) NOT NULL,
	`content` mediumtext,
	PRIMARY KEY (`id`),
	KEY `locale` (`locale`),
	KEY `model` (`model`),
	KEY `row_id` (`foreign_key`),
	KEY `field` (`field`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Table data `groups_i18n`
--

INSERT INTO `groups_i18n` (`id`, `locale`, `model`, `foreign_key`, `field`, `content`) VALUES
(1, 'en_US', 'Groups', 1, 'name', 'Banned'),
(2, 'en_US', 'Groups', 2, 'name', 'Member'),
(3, 'en_US', 'Groups', 3, 'name', 'Editor'),
(4, 'en_US', 'Groups', 4, 'name', 'Moderator'),
(5, 'en_US', 'Groups', 5, 'name', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure `acos`
--

CREATE TABLE IF NOT EXISTS `acos` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`parent_id` int(10) DEFAULT NULL,
	`model` varchar(255) DEFAULT '',
	`foreign_key` int(10) unsigned DEFAULT NULL,
	`alias` varchar(255) DEFAULT '',
	`lft` int(10) DEFAULT NULL,
	`rght` int(10) DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `idx_acos_lft_rght` (`lft`,`rght`),
	KEY `idx_acos_alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=85 ;

--
-- Table data `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, '', NULL, 'app', 1, 180),
(2, 1, '', NULL, 'Attachments', 4, 7),
(3, 2, '', NULL, 'download', 5, 6),
(4, 1, '', NULL, 'Blog', 8, 33),
(5, 4, '', NULL, 'index', 9, 10),
(6, 4, '', NULL, 'category', 11, 12),
(7, 4, '', NULL, 'article', 13, 14),
(8, 4, '', NULL, 'quote', 15, 16),
(9, 4, '', NULL, 'go', 17, 18),
(10, 4, '', NULL, 'archive', 19, 20),
(11, 4, '', NULL, 'search', 21, 22),
(12, 4, '', NULL, 'articleLike', 23, 24),
(13, 4, '', NULL, 'articleUnlike', 25, 26),
(14, 4, '', NULL, 'deleteComment', 27, 28),
(15, 4, '', NULL, 'getEditComment', 29, 30),
(16, 4, '', NULL, 'editComment', 31, 32),
(17, 1, '', NULL, 'Contact', 34, 37),
(18, 17, '', NULL, 'index', 35, 36),
(19, 1, '', NULL, 'Pages', 38, 45),
(20, 19, '', NULL, 'home', 39, 40),
(21, 19, '', NULL, 'acceptCookie', 41, 42),
(22, 19, '', NULL, 'lang', 43, 44),
(23, 1, '', NULL, 'Premium', 46, 57),
(24, 23, '', NULL, 'index', 47, 48),
(25, 23, '', NULL, 'subscribe', 49, 50),
(26, 23, '', NULL, 'notify', 51, 52),
(27, 23, '', NULL, 'success', 53, 54),
(28, 23, '', NULL, 'cancel', 55, 56),
(29, 1, '', NULL, 'Users', 58, 75),
(30, 29, '', NULL, 'index', 59, 60),
(31, 29, '', NULL, 'login', 61, 62),
(32, 29, '', NULL, 'logout', 63, 64),
(33, 29, '', NULL, 'account', 65, 66),
(34, 29, '', NULL, 'settings', 67, 68),
(35, 29, '', NULL, 'profile', 69, 70),
(36, 29, '', NULL, 'delete', 71, 72),
(37, 29, '', NULL, 'premium', 73, 74),
(38, 1, '', NULL, 'Groups', 76, 87),
(39, 38, '', NULL, 'index', 77, 78),
(40, 38, '', NULL, 'view', 79, 80),
(41, 38, '', NULL, 'add', 81, 82),
(42, 38, '', NULL, 'edit', 83, 84),
(43, 38, '', NULL, 'delete', 85, 86),
(44, 1, '', NULL, 'admin', 88, 179),
(45, 44, '', NULL, 'premium', 89, 112),
(46, 45, '', NULL, 'Offers', 90, 99),
(47, 46, '', NULL, 'index', 91, 92),
(48, 46, '', NULL, 'add', 93, 94),
(49, 46, '', NULL, 'edit', 95, 96),
(50, 46, '', NULL, 'delete', 97, 98),
(51, 45, '', NULL, 'Discounts', 100, 107),
(52, 51, '', NULL, 'index', 101, 102),
(53, 51, '', NULL, 'add', 103, 104),
(54, 51, '', NULL, 'edit', 105, 106),
(55, 45, '', NULL, 'Premium', 108, 111),
(56, 55, '', NULL, 'home', 109, 110),
(57, 44, '', NULL, 'Articles', 117, 126),
(58, 57, '', NULL, 'index', 118, 119),
(59, 57, '', NULL, 'add', 120, 121),
(60, 57, '', NULL, 'edit', 122, 123),
(61, 57, '', NULL, 'delete', 124, 125),
(62, 44, '', NULL, 'Attachments', 127, 136),
(63, 62, '', NULL, 'index', 128, 129),
(64, 62, '', NULL, 'add', 130, 131),
(65, 62, '', NULL, 'edit', 132, 133),
(66, 62, '', NULL, 'delete', 134, 135),
(67, 44, '', NULL, 'Categories', 137, 146),
(68, 67, '', NULL, 'index', 138, 139),
(69, 67, '', NULL, 'add', 140, 141),
(70, 67, '', NULL, 'edit', 142, 143),
(71, 67, '', NULL, 'delete', 144, 145),
(72, 44, '', NULL, 'Users', 147, 158),
(73, 72, '', NULL, 'index', 148, 149),
(74, 72, '', NULL, 'search', 150, 151),
(75, 72, '', NULL, 'edit', 152, 153),
(76, 72, '', NULL, 'delete', 154, 155),
(77, 72, '', NULL, 'deleteAvatar', 156, 157),
(78, 44, '', NULL, 'Admin', 159, 162),
(79, 78, '', NULL, 'home', 160, 161),
(80, 44, '', NULL, 'Groups', 165, 174),
(81, 80, '', NULL, 'index', 166, 167),
(82, 80, '', NULL, 'add', 168, 169),
(83, 80, '', NULL, 'edit', 170, 171),
(84, 80, '', NULL, 'delete', 172, 173);

-- --------------------------------------------------------

--
-- Table structure `aros`
--

CREATE TABLE IF NOT EXISTS `aros` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`parent_id` int(10) DEFAULT NULL,
	`model` varchar(255) DEFAULT '',
	`foreign_key` int(10) unsigned DEFAULT NULL,
	`alias` varchar(255) DEFAULT '',
	`lft` int(10) DEFAULT NULL,
	`rght` int(10) DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `idx_aros_lft_rght` (`lft`,`rght`),
	KEY `idx_aros_alias` (`alias`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Table data `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Groups', 1, '', 11, 12),
(2, NULL, 'Groups', 2, '', 9, 10),
(3, NULL, 'Groups', 3, '', 7, 8),
(4, NULL, 'Groups', 4, '', 5, 6),
(5, NULL, 'Groups', 5, '', 3, 4);

-- --------------------------------------------------------

--
-- Table structure `aros_acos`
--

CREATE TABLE IF NOT EXISTS `aros_acos` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`aro_id` int(10) unsigned NOT NULL,
	`aco_id` int(10) unsigned NOT NULL,
	`_create` char(2) NOT NULL DEFAULT '0',
	`_read` char(2) NOT NULL DEFAULT '0',
	`_update` char(2) NOT NULL DEFAULT '0',
	`_delete` char(2) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	KEY `idx_aco_id` (`aco_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Table data `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 5, 1, '1', '1', '1', '1'),
(2, 1, 1, '-1', '-1', '-1', '-1'),
(3, 2, 1, '-1', '-1', '-1', '-1'),
(4, 2, 2, '1', '1', '1', '1'),
(5, 2, 4, '1', '1', '1', '1'),
(6, 2, 17, '1', '1', '1', '1'),
(7, 2, 19, '1', '1', '1', '1'),
(8, 2, 23, '1', '1', '1', '1'),
(9, 2, 29, '1', '1', '1', '1'),
(20, 3, 1, '-1', '-1', '-1', '-1'),
(21, 3, 2, '1', '1', '1', '1'),
(22, 3, 4, '1', '1', '1', '1'),
(23, 3, 17, '1', '1', '1', '1'),
(24, 3, 19, '1', '1', '1', '1'),
(25, 3, 23, '1', '1', '1', '1'),
(26, 3, 29, '1', '1', '1', '1'),
(27, 3, 44, '-1', '-1', '-1', '-1'),
(28, 3, 57, '1', '1', '1', '1'),
(29, 3, 62, '1', '1', '1', '1'),
(30, 3, 78, '1', '1', '1', '1'),
(31, 4, 1, '-1', '-1', '-1', '-1'),
(32, 4, 2, '1', '1', '1', '1'),
(33, 4, 4, '1', '1', '1', '1'),
(34, 4, 17, '1', '1', '1', '1'),
(35, 4, 19, '1', '1', '1', '1'),
(36, 4, 23, '1', '1', '1', '1'),
(37, 4, 29, '1', '1', '1', '1'),
(38, 4, 44, '1', '1', '1', '1'),
(39, 4, 45, '-1', '-1', '-1', '-1'),
(40, 4, 80, '-1', '-1', '-1', '-1');

-- --------------------------------------------------------

--
-- Table structure 'users'
--

CREATE TABLE IF NOT EXISTS users (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(20) NOT NULL,
  password varchar(255) NOT NULL,
  email varchar(50) NOT NULL,
  first_name varchar(100) NOT NULL,
  last_name varchar(100) NOT NULL,
  avatar varchar(255) NOT NULL DEFAULT '../img/avatar.png',
  biography text NOT NULL,
  signature text NOT NULL,
  facebook varchar(200) NOT NULL,
  twitter varchar(200) NOT NULL,
  group_id int(11) NOT NULL DEFAULT '2',
  slug varchar(20) NOT NULL,
  blog_articles_comment_count int(11) DEFAULT '0',
  blog_article_count int(11) DEFAULT '0',
  end_subscription datetime NOT NULL,
  register_ip varchar(15) DEFAULT NULL,
  last_login_ip varchar(15) DEFAULT NULL,
  last_login datetime NOT NULL,
  created datetime NOT NULL,
  modified datetime NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY username (username),
  UNIQUE KEY mail (email),
  KEY slug (slug)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Table data 'users'
--

INSERT INTO users (id, username, password, email, first_name, last_name, avatar, biography, signature, facebook, twitter, group_id, slug, blog_articles_comment_count, blog_article_count, end_subscription, register_ip, last_login_ip, last_login, created, modified) VALUES
(1, 'Admin', '__ADMINPASSWORD__', 'admin@localhost.io', '', '', '../img/avatar.png', '', '', '', '', 5, 'admin', 1, 1, '0000-00-00 00:00:00',
'::1', '::1', '0000-00-00 00:00:00', '2014-09-22 10:04:56', '2014-09-22 10:04:56'),
(2, 'Test', '__MEMBERPASSWORD__', 'test@localhost.io', '', '', '../img/avatar.png', '', '', '', '', 2, 'test', 1, 0, '0000-00-00 00:00:00',
'::1', '::1', '0000-00-00 00:00:00', '2014-09-22 10:18:08', '2014-09-22 10:18:08');
