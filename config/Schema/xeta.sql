
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Table data `badges`
--

INSERT INTO `badges` (`id`, `name`, `picture`, `type`, `rule`, `created`) VALUES
(1, 'Premier Commentaire', 'badges/comments-1.png', 'comments', 1, '2014-11-10 14:00:00'),
(2, '10 Commentaires', 'badges/comments-10.png', 'comments', 10, '2014-11-10 14:00:00'),
(3, 'Inscrit depuis 1 an', 'badges/registration-1.png', 'registration', 1, '2014-11-10 16:00:00'),
(4, 'Inscrit depuis 2 ans', 'badges/registration-2.png', 'registration', 2, '2014-11-10 16:00:00'),
(5, 'Inscrit depuis 3 ans', 'badges/registration-3.png', 'registration', 3, '2014-11-10 16:00:00'),
(6, 'Premium', 'badges/premium.png', 'premium', 1, '2014-11-17 13:00:00'),
(7, 'Premier Post', 'badges/posts_forum-1.png', 'postsForum', 1, '2015-02-05 08:00:00'),
(8, '10 Posts', 'badges/posts_forum-10.png', 'postsForum', 10, '2015-02-05 09:00:00'),
(9, '50 Posts', 'badges/posts_forum-50.png', 'postsForum', 50, '2015-02-05 08:00:00'),
(10, '100 Posts', 'badges/posts_forum-100.png', 'postsForum', 100, '2015-02-05 08:00:00'),
(11, '500 Posts', 'badges/posts_forum-500.png', 'postsForum', 500, '2015-01-28 11:00:00'),
(12, '1000 Posts', 'badges/posts_forum-1000.png', 'postsForum', 1000, '2015-01-28 11:00:00');

-- --------------------------------------------------------

--
-- Table structure `badges_i18n`
--

CREATE TABLE IF NOT EXISTS `badges_i18n` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `I18N_LOCALE_FIELD` (`locale`,`model`,`foreign_key`,`field`),
  KEY `I18N_FIELD` (`model`,`foreign_key`,`field`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Table data `badges_i18n`
--

INSERT INTO `badges_i18n` (`id`, `locale`, `model`, `foreign_key`, `field`, `content`) VALUES
(1, 'en_US', 'Badges', 1, 'name', 'First Comments'),
(2, 'en_US', 'Badges', 2, 'name', '10 Comments'),
(3, 'en_US', 'Badges', 3, 'name', '1 year old'),
(4, 'en_US', 'Badges', 4, 'name', '2 years old'),
(5, 'en_US', 'Badges', 5, 'name', '3 years old'),
(6, 'en_US', 'Badges', 6, 'name', 'Premium'),
(7, 'en_US', 'Badges', 7, 'name', 'First Post'),
(8, 'en_US', 'Badges', 8, 'name', '10 Posts'),
(9, 'en_US', 'Badges', 9, 'name', '50 Posts'),
(10, 'en_US', 'Badges', 10, 'name', '100 Posts'),
(11, 'en_US', 'Badges', 11, 'name', '500 Posts'),
(12, 'en_US', 'Badges', 12, 'name', '1000 Posts');

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
-- Table structure `blog_categories_i18n`
--

CREATE TABLE IF NOT EXISTS `blog_categories_i18n` (
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
-- Table data 'blog_categories_i18n'
--

INSERT INTO `blog_articles_i18n` (`id`, `locale`, `model`, `foreign_key`, `field`, `content`) VALUES
(NULL, 'en_US', 'BlogCategories', 1, 'title', 'Xeta English'),
(NULL, 'en_US', 'BlogCategories', 1, 'description', 'Lorem ipsum dolor sit amet english.');

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
    `css` varchar(255) NOT NULL,
    `is_staff` int(2) NOT NULL DEFAULT '0',
    `is_member` int(2) NOT NULL COMMENT 'Used to define if we display Premium group instead of the real group',
    `created` datetime DEFAULT NULL,
    `modified` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Table data `groups`
--

INSERT INTO `groups` (`id`, `name`, `css`, `is_staff`, `is_member`, `created`, `modified`) VALUES
(1, 'Banni', 'color:#A1705D;font-weight:bold;', 0, 0, '2015-01-16 16:51:12', '2015-01-21 02:03:10'),
(2, 'Membre', 'font-weight:bold;', 0, 1, '2015-01-16 16:51:22', '2015-01-21 02:02:21'),
(3, 'Éditeur', 'color:#9ADD7D;font-weight:bold;', 1, 0, '2015-01-16 16:51:30', '2015-01-21 02:02:12'),
(4, 'Modérateur', 'color:#FF6B43;font-weight:bold;', 1, 0, '2015-01-16 16:51:51', '2015-01-21 02:02:03'),
(5, 'Administrateur', 'color:#FF4A43;font-weight:bold;', 1, 0, '2015-01-16 16:52:00', '2015-02-09 17:28:12');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=129 ;

--
-- Table data `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, '', NULL, 'app', 1, 268),
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
(44, 1, '', NULL, 'admin', 88, 195),
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
(84, 80, '', NULL, 'delete', 172, 173),
(85, 1, '', NULL, 'forum', 196, 241),
(86, 85, '', NULL, 'Forum', 197, 206),
(87, 86, '', NULL, 'index', 198, 199),
(88, 86, '', NULL, 'categories', 200, 201),
(89, 86, '', NULL, 'home', 202, 203),
(90, 86, '', NULL, 'threads', 204, 205),
(91, 85, '', NULL, 'Threads', 207, 222),
(92, 91, '', NULL, 'close', 208, 209),
(93, 91, '', NULL, 'new', 210, 211),
(94, 85, '', NULL, 'Posts', 223, 240),
(95, 94, '', NULL, 'new', 224, 225),
(96, 91, '', NULL, 'reply', 212, 213),
(97, 91, '', NULL, 'lock', 214, 215),
(98, 91, '', NULL, 'unlock', 216, 217),
(99, 94, '', NULL, 'edit', 226, 227),
(100, 91, '', NULL, 'edit', 218, 219),
(101, 94, '', NULL, 'delete', 228, 229),
(102, 94, '', NULL, 'go', 230, 231),
(103, 94, '', NULL, 'getEditPost', 232, 233),
(104, 91, '', NULL, 'create', 220, 221),
(105, 94, '', NULL, 'quote', 234, 235),
(106, 94, '', NULL, 'like', 236, 237),
(107, 94, '', NULL, 'unlike', 238, 239),
(108, 1, '', NULL, 'chat', 242, 267),
(109, 108, '', NULL, 'Chat', 243, 254),
(110, 109, '', NULL, 'index', 244, 245),
(111, 109, '', NULL, 'getNotice', 246, 247),
(112, 109, '', NULL, 'editNotice', 248, 249),
(113, 109, '', NULL, 'shout', 250, 251),
(114, 108, '', NULL, 'Permissions', 255, 266),
(115, 114, '', NULL, 'canPrune', 256, 257),
(116, 114, '', NULL, 'canBan', 258, 259),
(117, 114, '', NULL, 'canUnban', 260, 261),
(118, 114, '', NULL, 'canDelete', 262, 263),
(119, 114, '', NULL, 'canNotice', 264, 265),
(120, 109, '', NULL, 'delete', 252, 253),
(121, 44, '', NULL, 'forum', 179, 194),
(122, 121, '', NULL, 'Categories', 180, 193),
(123, 122, '', NULL, 'index', 181, 182),
(124, 122, '', NULL, 'add', 183, 184),
(125, 122, '', NULL, 'moveup', 185, 186),
(126, 122, '', NULL, 'movedown', 187, 188),
(127, 122, '', NULL, 'delete', 189, 190),
(128, 122, '', NULL, 'edit', 191, 192);

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

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
  (1, NULL, 'Groups', 1, '', 1, 4),
  (2, 1, 'Groups', 2, '', 2, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Table data `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
  (1, 1, 1, '1', '1', '1', '1'),
  (2, 1, 2, '1', '1', '1', '1'),
  (3, 1, 3, '1', '1', '1', '1'),
  (4, 1, 4, '1', '1', '1', '1'),
  (5, 1, 5, '1', '1', '1', '1'),
  (6, 1, 6, '1', '1', '1', '1'),
  (7, 1, 7, '1', '1', '1', '1'),
  (8, 1, 8, '1', '1', '1', '1'),
  (9, 1, 9, '1', '1', '1', '1'),
  (10, 1, 10, '1', '1', '1', '1'),
  (11, 1, 11, '1', '1', '1', '1'),
  (12, 1, 12, '1', '1', '1', '1'),
  (13, 1, 13, '1', '1', '1', '1'),
  (14, 1, 14, '1', '1', '1', '1'),
  (15, 1, 15, '1', '1', '1', '1'),
  (16, 1, 16, '1', '1', '1', '1'),
  (17, 1, 17, '1', '1', '1', '1'),
  (18, 1, 18, '1', '1', '1', '1'),
  (19, 1, 19, '1', '1', '1', '1'),
  (20, 1, 20, '1', '1', '1', '1'),
  (21, 1, 21, '1', '1', '1', '1'),
  (22, 1, 22, '1', '1', '1', '1'),
  (23, 1, 23, '1', '1', '1', '1'),
  (24, 1, 24, '1', '1', '1', '1'),
  (25, 1, 25, '1', '1', '1', '1'),
  (26, 1, 26, '1', '1', '1', '1'),
  (27, 1, 27, '1', '1', '1', '1'),
  (28, 1, 28, '1', '1', '1', '1'),
  (29, 1, 29, '1', '1', '1', '1'),
  (30, 1, 30, '1', '1', '1', '1'),
  (31, 1, 31, '1', '1', '1', '1'),
  (32, 1, 32, '1', '1', '1', '1'),
  (33, 1, 33, '1', '1', '1', '1'),
  (34, 1, 34, '1', '1', '1', '1'),
  (35, 1, 35, '1', '1', '1', '1'),
  (36, 1, 36, '1', '1', '1', '1'),
  (37, 1, 37, '1', '1', '1', '1'),
  (38, 1, 38, '1', '1', '1', '1'),
  (39, 1, 39, '1', '1', '1', '1'),
  (40, 1, 40, '1', '1', '1', '1'),
  (41, 1, 41, '1', '1', '1', '1'),
  (42, 1, 42, '1', '1', '1', '1'),
  (43, 1, 43, '1', '1', '1', '1'),
  (44, 1, 44, '1', '1', '1', '1'),
  (45, 1, 45, '1', '1', '1', '1'),
  (46, 1, 46, '1', '1', '1', '1'),
  (47, 1, 47, '1', '1', '1', '1'),
  (48, 1, 48, '1', '1', '1', '1'),
  (49, 1, 49, '1', '1', '1', '1'),
  (50, 1, 50, '1', '1', '1', '1'),
  (51, 1, 51, '1', '1', '1', '1'),
  (52, 1, 52, '1', '1', '1', '1'),
  (53, 1, 53, '1', '1', '1', '1'),
  (54, 1, 54, '1', '1', '1', '1'),
  (55, 1, 55, '1', '1', '1', '1'),
  (56, 1, 56, '1', '1', '1', '1'),
  (57, 1, 57, '1', '1', '1', '1'),
  (58, 1, 58, '1', '1', '1', '1'),
  (59, 1, 59, '1', '1', '1', '1'),
  (60, 1, 60, '1', '1', '1', '1'),
  (61, 1, 61, '1', '1', '1', '1'),
  (62, 1, 62, '1', '1', '1', '1'),
  (63, 1, 63, '1', '1', '1', '1'),
  (64, 1, 64, '1', '1', '1', '1'),
  (65, 1, 65, '1', '1', '1', '1'),
  (66, 1, 66, '1', '1', '1', '1'),
  (67, 1, 67, '1', '1', '1', '1'),
  (68, 1, 68, '1', '1', '1', '1'),
  (69, 1, 69, '1', '1', '1', '1'),
  (70, 1, 70, '1', '1', '1', '1'),
  (71, 1, 71, '1', '1', '1', '1'),
  (72, 1, 72, '1', '1', '1', '1'),
  (73, 1, 73, '1', '1', '1', '1'),
  (74, 1, 74, '1', '1', '1', '1'),
  (75, 1, 75, '1', '1', '1', '1'),
  (76, 1, 76, '1', '1', '1', '1'),
  (77, 1, 77, '1', '1', '1', '1'),
  (78, 1, 78, '1', '1', '1', '1'),
  (79, 1, 79, '1', '1', '1', '1'),
  (80, 1, 80, '1', '1', '1', '1'),
  (81, 1, 81, '1', '1', '1', '1'),
  (82, 1, 82, '1', '1', '1', '1'),
  (83, 1, 83, '1', '1', '1', '1'),
  (84, 1, 84, '1', '1', '1', '1'),
  (85, 1, 85, '1', '1', '1', '1'),
  (86, 1, 86, '1', '1', '1', '1'),
  (87, 1, 87, '1', '1', '1', '1'),
  (88, 1, 88, '1', '1', '1', '1'),
  (89, 1, 89, '1', '1', '1', '1'),
  (90, 1, 90, '1', '1', '1', '1'),
  (91, 1, 91, '1', '1', '1', '1'),
  (92, 1, 92, '1', '1', '1', '1'),
  (93, 1, 93, '1', '1', '1', '1'),
  (94, 1, 94, '1', '1', '1', '1'),
  (95, 1, 95, '1', '1', '1', '1'),
  (96, 1, 96, '1', '1', '1', '1'),
  (97, 1, 97, '1', '1', '1', '1'),
  (98, 1, 98, '1', '1', '1', '1'),
  (99, 1, 99, '1', '1', '1', '1'),
  (100, 1, 100, '1', '1', '1', '1'),
  (101, 1, 101, '-1', '-1', '-1', '-1'),
  (102, 1, 102, '1', '1', '1', '1'),
  (103, 1, 103, '1', '1', '1', '1'),
  (104, 1, 104, '1', '1', '1', '1'),
  (105, 1, 105, '1', '1', '1', '1'),
  (106, 1, 106, '1', '1', '1', '1'),
  (107, 1, 107, '1', '1', '1', '1'),
  (108, 1, 108, '1', '1', '1', '1'),
  (109, 1, 109, '1', '1', '1', '1'),
  (110, 1, 110, '1', '1', '1', '1'),
  (111, 1, 111, '1', '1', '1', '1'),
  (112, 1, 112, '1', '1', '1', '1'),
  (113, 1, 113, '1', '1', '1', '1'),
  (114, 1, 114, '1', '1', '1', '1'),
  (115, 1, 115, '-1', '-1', '-1', '-1'),
  (116, 1, 116, '1', '1', '1', '1'),
  (117, 1, 117, '1', '1', '1', '1'),
  (118, 1, 118, '1', '1', '1', '1'),
  (119, 1, 119, '1', '1', '1', '1'),
  (120, 1, 120, '1', '1', '1', '1'),
  (121, 1, 121, '1', '1', '1', '1'),
  (122, 1, 122, '1', '1', '1', '1'),
  (123, 1, 123, '1', '1', '1', '1'),
  (124, 1, 124, '1', '1', '1', '1'),
  (125, 1, 125, '1', '1', '1', '1'),
  (126, 1, 126, '1', '1', '1', '1'),
  (127, 1, 127, '1', '1', '1', '1'),
  (128, 1, 128, '1', '1', '1', '1'),
  (129, 2, 44, '-1', '-1', '-1', '-1'),
  (130, 2, 17, '0', '0', '0', '0'),
  (131, 2, 4, '0', '0', '0', '0'),
  (132, 2, 14, '0', '0', '0', '0'),
  (133, 2, 16, '0', '0', '0', '0'),
  (134, 2, 57, '0', '0', '0', '0'),
  (135, 2, 59, '0', '0', '0', '0'),
  (136, 2, 58, '0', '0', '0', '0'),
  (137, 2, 60, '0', '0', '0', '0'),
  (138, 2, 61, '0', '0', '0', '0'),
  (139, 2, 67, '0', '0', '0', '0'),
  (140, 2, 69, '0', '0', '0', '0'),
  (141, 2, 68, '0', '0', '0', '0'),
  (142, 2, 70, '0', '0', '0', '0'),
  (143, 2, 71, '0', '0', '0', '0'),
  (144, 2, 62, '0', '0', '0', '0'),
  (145, 2, 64, '0', '0', '0', '0'),
  (146, 2, 65, '0', '0', '0', '0'),
  (147, 2, 66, '0', '0', '0', '0'),
  (148, 2, 121, '0', '0', '0', '0'),
  (149, 2, 124, '0', '0', '0', '0'),
  (150, 2, 128, '0', '0', '0', '0'),
  (151, 2, 127, '0', '0', '0', '0'),
  (152, 2, 125, '0', '0', '0', '0'),
  (153, 2, 126, '0', '0', '0', '0'),
  (154, 2, 87, '0', '0', '0', '0'),
  (155, 2, 88, '0', '0', '0', '0'),
  (156, 2, 90, '0', '0', '0', '0'),
  (157, 2, 104, '0', '0', '0', '0'),
  (158, 2, 100, '0', '0', '0', '0'),
  (159, 2, 96, '0', '0', '0', '0'),
  (160, 2, 97, '0', '0', '0', '0'),
  (161, 2, 98, '0', '0', '0', '0'),
  (162, 2, 95, '0', '0', '0', '0'),
  (163, 2, 99, '0', '0', '0', '0'),
  (164, 2, 101, '1', '1', '1', '1'),
  (165, 2, 110, '0', '0', '0', '0'),
  (166, 2, 112, '0', '0', '0', '0'),
  (167, 2, 113, '0', '0', '0', '0'),
  (168, 2, 120, '0', '0', '0', '0'),
  (169, 2, 115, '1', '1', '1', '1'),
  (170, 2, 116, '0', '0', '0', '0'),
  (171, 2, 117, '0', '0', '0', '0'),
  (172, 2, 118, '0', '0', '0', '0'),
  (173, 2, 119, '0', '0', '0', '0'),
  (174, 2, 73, '0', '0', '0', '0'),
  (175, 2, 75, '0', '0', '0', '0'),
  (176, 2, 77, '0', '0', '0', '0'),
  (177, 2, 76, '0', '0', '0', '0'),
  (178, 2, 80, '0', '0', '0', '0'),
  (179, 2, 82, '0', '0', '0', '0'),
  (180, 2, 83, '0', '0', '0', '0'),
  (181, 2, 84, '0', '0', '0', '0'),
  (182, 2, 24, '0', '0', '0', '0'),
  (183, 2, 56, '0', '0', '0', '0'),
  (184, 2, 46, '0', '0', '0', '0'),
  (185, 2, 48, '0', '0', '0', '0'),
  (186, 2, 49, '0', '0', '0', '0'),
  (187, 2, 50, '0', '0', '0', '0'),
  (188, 2, 51, '0', '0', '0', '0'),
  (189, 2, 53, '0', '0', '0', '0'),
  (190, 2, 54, '0', '0', '0', '0'),
  (191, 2, 1, '1', '1', '1', '1'),
  (192, 2, 19, '1', '1', '1', '1'),
  (193, 2, 20, '1', '1', '1', '1'),
  (194, 2, 21, '1', '1', '1', '1'),
  (195, 2, 22, '1', '1', '1', '1'),
  (196, 2, 102, '1', '1', '1', '1'),
  (197, 2, 106, '1', '1', '1', '1'),
  (198, 2, 107, '1', '1', '1', '1'),
  (199, 2, 105, '1', '1', '1', '1'),
  (200, 2, 103, '1', '1', '1', '1'),
  (201, 2, 111, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(11) DEFAULT NULL,
  `data` text,
  `controller` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure `forum_threads`
--

CREATE TABLE IF NOT EXISTS `forum_threads` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `category_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `title` varchar(150) NOT NULL,
    `reply_count` int(11) NOT NULL,
    `view_count` bigint(20) NOT NULL,
    `thread_open` tinyint(3) NOT NULL DEFAULT '1' COMMENT 'Display: 1, Closed: 0, Deleted: 2',
    `sticky` int(3) NOT NULL DEFAULT '0' COMMENT 'Epinglé',
    `first_post_id` int(11) NOT NULL,
    `last_post_date` datetime NOT NULL,
    `last_post_id` int(11) NOT NULL,
    `last_post_user_id` int(11) NOT NULL,
    `created` datetime NOT NULL,
    `modified` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Table data `forum_threads`
--

INSERT INTO `forum_threads` (`id`, `category_id`, `user_id`, `title`, `reply_count`, `view_count`, `thread_open`, `sticky`, `first_post_id`, `last_post_date`, `last_post_id`, `last_post_user_id`, `created`, `modified`) VALUES
(1, 9, 1, 'Problem in PHP', 0, 1, 1, 0, 1, '2015-03-30 10:00:00', 1, 1, '2015-03-30 10:00:00', '2015-03-30 10:00:00');

-- --------------------------------------------------------

--
-- Table structure `forum_posts`
--

CREATE TABLE IF NOT EXISTS `forum_posts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `thread_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `message` mediumtext NOT NULL,
    `like_count` int(11) NOT NULL,
    `last_edit_date` datetime NOT NULL,
    `last_edit_user_id` int(11) NOT NULL,
    `edit_count` int(11) NOT NULL,
    `created` datetime NOT NULL,
    `modified` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Table data `forum_posts`
--

INSERT INTO `forum_posts` (`id`, `thread_id`, `user_id`, `message`, `like_count`, `last_edit_date`, `last_edit_user_id`, `edit_count`, `created`, `modified`) VALUES
(1, 1, 1, '<p>Hi, this is the first message in the forum.</p>\r\n', 1, '2015-03-30 10:30:00', 1, 1, '2015-03-30 10:00:00', '2015-03-30 10:30:00');

-- --------------------------------------------------------

--
-- Table structure `forum_posts_likes`
--

CREATE TABLE IF NOT EXISTS `forum_posts_likes` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `post_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    `receiver_id` int(11) NOT NULL,
    `created` datetime NOT NULL,
    `modified` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Table data `forum_posts_likes`
--

INSERT INTO `forum_posts_likes` (`id`, `post_id`, `user_id`, `receiver_id`, `created`, `modified`) VALUES
(1, 1, 2, 1, '2015-03-30 10:30:00', '2015-03-30 10:30:00');

-- --------------------------------------------------------

--
-- Table structure `forum_categories`
--

CREATE TABLE IF NOT EXISTS `forum_categories` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `category_open` tinyint(2) NOT NULL DEFAULT '1',
    `thread_count` int(11) NOT NULL,
    `last_post_id` int(11) NOT NULL,
    `parent_id` int(11) DEFAULT NULL,
    `lft` int(11) DEFAULT NULL,
    `rght` int(11) DEFAULT NULL,
    `created` datetime NOT NULL,
    `modified` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Table data `forum_categories`
--

INSERT INTO `forum_categories` (`id`, `title`, `description`, `category_open`, `thread_count`, `last_post_id`, `parent_id`, `lft`, `rght`, `created`, `modified`) VALUES
(1, 'Forums Généraux', 'Description Forums Généraux', 0, 0, 0, NULL, 1, 14, '2015-01-28 08:00:00', '2015-01-28 08:00:00'),
(2, 'Xeta', 'Description Xeta', 0, 0, 0, 1, 2, 13, '2015-01-28 08:01:00', '2015-01-28 08:01:00'),
(3, 'Annonces du Site', 'Description Annonces du Site', 1, 0, 0, 2, 3, 4, '2015-01-28 10:00:00', '2015-03-30 09:06:30'),
(4, 'Suggestions, bugs et aide du forum', 'Description Suggestions, bugs et aide du forum', 0, 0, 0, 2, 5, 12, '2015-01-28 11:00:00', '2015-01-28 11:00:00'),
(5, 'Suggestions', 'Description Suggestions', 1, 0, 0, 4, 6, 7, '2015-01-28 11:00:00', '2015-04-17 07:04:08'),
(6, 'Bugs', 'Description Bugs', 1, 0, 0, 4, 8, 9, '2015-01-28 11:00:00', '2015-01-28 11:00:00'),
(7, 'Aide', 'Description Aide', 1, 0, 0, 4, 10, 11, '2015-01-29 08:00:00', '2015-03-16 17:25:56'),
(8, 'Développement Web', 'Description Développement', 0, 0, 0, NULL, 15, 22, '2015-01-29 09:00:00', '2015-04-20 11:40:37'),
(9, 'PHP', 'Description PHP', 1, 1, 1, 8, 16, 17, '2015-01-29 10:00:00', '2015-04-20 10:03:32'),
(10, 'Ruby', 'Description Ruby', 1, 0, 0, 8, 18, 19, '2015-04-20 11:40:18', '2015-04-20 11:40:18'),
(11, 'Python', 'Description Python', 1, 0, 0, 8, 20, 21, '2015-04-20 11:41:00', '2015-04-20 11:41:00');

-- --------------------------------------------------------

--
-- Table structure `chat_online`
--

CREATE TABLE IF NOT EXISTS `chat_online` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `username` varchar(50) NOT NULL,
    `slug` varchar(50) NOT NULL,
    `group_id` int(11) NOT NULL,
    `css` varchar(255) NOT NULL,
    `is_banned` tinyint(1) NOT NULL DEFAULT '0',
    `created` datetime NOT NULL,
    `modified` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure `chat_messages`
--

CREATE TABLE IF NOT EXISTS `chat_messages` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `username` varchar(50) NOT NULL,
    `slug` varchar(50) NOT NULL,
    `css` varchar(255) NOT NULL,
    `group_id` tinyint(2) NOT NULL,
    `text` text NOT NULL,
    `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '0=deleted, 1=normal',
    `command` varchar(150) NOT NULL,
    `created` datetime NOT NULL,
    `modified` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Table data `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `user_id`, `username`, `slug`, `css`, `group_id`, `text`, `status`, `command`, `created`, `modified`) VALUES
(1, 1, 'Admin', 'admin', 'color:#FF4A43;font-weight:bold;', 5, 'This is a test.', 1, '', '2015-03-13 12:15:12', '2015-03-13 12:15:12');

-- --------------------------------------------------------

--
-- Table structure `chat_bans`
--

CREATE TABLE IF NOT EXISTS `chat_bans` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `banisher_id` int(11) NOT NULL,
    `end_date` datetime NOT NULL,
    `forever` tinyint(1) NOT NULL DEFAULT '0',
    `reason` tinytext NOT NULL,
    `created` datetime NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure `users`
--

CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(20) NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` varchar(50) NOT NULL,
    `first_name` varchar(100) NOT NULL,
    `last_name` varchar(100) NOT NULL,
    `avatar` varchar(255) NOT NULL DEFAULT '../img/avatar.png',
    `biography` text NOT NULL,
    `signature` text NOT NULL,
    `facebook` varchar(200) NOT NULL,
    `twitter` varchar(200) NOT NULL,
    `group_id` int(11) NOT NULL DEFAULT '2',
    `slug` varchar(20) NOT NULL,
    `language` varchar(7) NOT NULL DEFAULT 'fr_FR',
    `blog_articles_comment_count` int(11) DEFAULT '0',
    `blog_article_count` int(11) DEFAULT '0',
    `forum_thread_count` int(11) NOT NULL DEFAULT '0',
    `forum_post_count` int(11) NOT NULL DEFAULT '0',
    `forum_like_received` int(11) NOT NULL DEFAULT '0',
    `end_subscription` datetime NOT NULL,
    `register_ip` varchar(15) DEFAULT NULL,
    `last_login_ip` varchar(15) DEFAULT NULL,
    `last_login` datetime NOT NULL,
    `created` datetime NOT NULL,
    `modified` datetime NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `mail` (`email`),
    KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Table data `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `avatar`, `biography`, `signature`, `facebook`, `twitter`, `group_id`, `slug`, `language`, `blog_articles_comment_count`, `blog_article_count`, `forum_thread_count`, `forum_post_count`, `forum_like_received`, `end_subscription`, `register_ip`, `last_login_ip`, `last_login`, `created`, `modified`) VALUES
(1, 'Admin', '__ADMINPASSWORD__', 'admin@localhost.io', '', '', '../img/avatar.png', '', '', '', '', 5, 'admin', 'fr_FR', 1, 1, 1, 1, 1, '0000-00-00 00:00:00',
'::1', '::1', '2014-09-22 10:04:56', '2014-09-22 10:04:56', '2014-09-22 10:04:56'),
(2, 'Test', '__MEMBERPASSWORD__', 'test@localhost.io', '', '', '../img/avatar.png', '', '', '', '', 2, 'test', 'fr_FR', 1, 0, 0, 0, 0, '0000-00-00 00:00:00',
'::1', '::1', '2014-09-22 10:18:08', '2014-09-22 10:18:08', '2014-09-22 10:18:08');
