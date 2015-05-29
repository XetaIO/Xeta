
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=154 ;

--
-- Table data `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, '', NULL, 'app', 1, 316),
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
(29, 1, '', NULL, 'Users', 58, 81),
(30, 29, '', NULL, 'index', 59, 60),
(31, 29, '', NULL, 'login', 61, 62),
(32, 29, '', NULL, 'logout', 63, 64),
(33, 29, '', NULL, 'account', 65, 66),
(34, 29, '', NULL, 'settings', 67, 68),
(35, 29, '', NULL, 'profile', 69, 70),
(36, 29, '', NULL, 'delete', 71, 72),
(37, 29, '', NULL, 'premium', 73, 74),
(38, 1, '', NULL, 'Groups', 82, 93),
(39, 38, '', NULL, 'index', 83, 84),
(40, 38, '', NULL, 'view', 85, 86),
(41, 38, '', NULL, 'add', 87, 88),
(42, 38, '', NULL, 'edit', 89, 90),
(43, 38, '', NULL, 'delete', 91, 92),
(44, 1, '', NULL, 'admin', 94, 201),
(45, 44, '', NULL, 'premium', 95, 118),
(46, 45, '', NULL, 'Offers', 96, 105),
(47, 46, '', NULL, 'index', 97, 98),
(48, 46, '', NULL, 'add', 99, 100),
(49, 46, '', NULL, 'edit', 101, 102),
(50, 46, '', NULL, 'delete', 103, 104),
(51, 45, '', NULL, 'Discounts', 106, 113),
(52, 51, '', NULL, 'index', 107, 108),
(53, 51, '', NULL, 'add', 109, 110),
(54, 51, '', NULL, 'edit', 111, 112),
(55, 45, '', NULL, 'Premium', 114, 117),
(56, 55, '', NULL, 'home', 115, 116),
(57, 44, '', NULL, 'Articles', 123, 132),
(58, 57, '', NULL, 'index', 124, 125),
(59, 57, '', NULL, 'add', 126, 127),
(60, 57, '', NULL, 'edit', 128, 129),
(61, 57, '', NULL, 'delete', 130, 131),
(62, 44, '', NULL, 'Attachments', 133, 142),
(63, 62, '', NULL, 'index', 134, 135),
(64, 62, '', NULL, 'add', 136, 137),
(65, 62, '', NULL, 'edit', 138, 139),
(66, 62, '', NULL, 'delete', 140, 141),
(67, 44, '', NULL, 'Categories', 143, 152),
(68, 67, '', NULL, 'index', 144, 145),
(69, 67, '', NULL, 'add', 146, 147),
(70, 67, '', NULL, 'edit', 148, 149),
(71, 67, '', NULL, 'delete', 150, 151),
(72, 44, '', NULL, 'Users', 153, 164),
(73, 72, '', NULL, 'index', 154, 155),
(74, 72, '', NULL, 'search', 156, 157),
(75, 72, '', NULL, 'edit', 158, 159),
(76, 72, '', NULL, 'delete', 160, 161),
(77, 72, '', NULL, 'deleteAvatar', 162, 163),
(78, 44, '', NULL, 'Admin', 165, 168),
(79, 78, '', NULL, 'home', 166, 167),
(80, 44, '', NULL, 'Groups', 171, 180),
(81, 80, '', NULL, 'index', 172, 173),
(82, 80, '', NULL, 'add', 174, 175),
(83, 80, '', NULL, 'edit', 176, 177),
(84, 80, '', NULL, 'delete', 178, 179),
(85, 1, '', NULL, 'forum', 202, 251),
(86, 85, '', NULL, 'Forum', 203, 212),
(87, 86, '', NULL, 'index', 204, 205),
(88, 86, '', NULL, 'categories', 206, 207),
(89, 86, '', NULL, 'home', 208, 209),
(90, 86, '', NULL, 'threads', 210, 211),
(91, 85, '', NULL, 'Threads', 213, 232),
(92, 91, '', NULL, 'close', 214, 215),
(93, 91, '', NULL, 'new', 216, 217),
(94, 85, '', NULL, 'Posts', 233, 250),
(95, 94, '', NULL, 'new', 234, 235),
(96, 91, '', NULL, 'reply', 218, 219),
(97, 91, '', NULL, 'lock', 220, 221),
(98, 91, '', NULL, 'unlock', 222, 223),
(99, 94, '', NULL, 'edit', 236, 237),
(100, 91, '', NULL, 'edit', 224, 225),
(101, 94, '', NULL, 'delete', 238, 239),
(102, 94, '', NULL, 'go', 240, 241),
(103, 94, '', NULL, 'getEditPost', 242, 243),
(104, 91, '', NULL, 'create', 226, 227),
(105, 94, '', NULL, 'quote', 244, 245),
(106, 94, '', NULL, 'like', 246, 247),
(107, 94, '', NULL, 'unlike', 248, 249),
(108, 1, '', NULL, 'chat', 252, 277),
(109, 108, '', NULL, 'Chat', 253, 264),
(110, 109, '', NULL, 'index', 254, 255),
(111, 109, '', NULL, 'getNotice', 256, 257),
(112, 109, '', NULL, 'editNotice', 258, 259),
(113, 109, '', NULL, 'shout', 260, 261),
(114, 108, '', NULL, 'Permissions', 265, 276),
(115, 114, '', NULL, 'canPrune', 266, 267),
(116, 114, '', NULL, 'canBan', 268, 269),
(117, 114, '', NULL, 'canUnban', 270, 271),
(118, 114, '', NULL, 'canDelete', 272, 273),
(119, 114, '', NULL, 'canNotice', 274, 275),
(120, 109, '', NULL, 'delete', 262, 263),
(121, 44, '', NULL, 'forum', 185, 200),
(122, 121, '', NULL, 'Categories', 186, 199),
(123, 122, '', NULL, 'index', 187, 188),
(124, 122, '', NULL, 'add', 189, 190),
(125, 122, '', NULL, 'moveup', 191, 192),
(126, 122, '', NULL, 'movedown', 193, 194),
(127, 122, '', NULL, 'delete', 195, 196),
(128, 122, '', NULL, 'edit', 197, 198),
(129, 91, '', NULL, 'follow', 228, 229),
(130, 91, '', NULL, 'unfollow', 230, 231),
(131, 29, '', NULL, 'notifications', 75, 76),
(132, 1, '', NULL, 'Notifications', 278, 281),
(133, 132, '', NULL, 'markAsRead', 279, 280),
(134, 29, '', NULL, 'forgotPassword', 77, 78),
(135, 29, '', NULL, 'resetPassword', 79, 80),
(136, 1, '', NULL, 'Conversations', 282, 315),
(137, 136, '', NULL, 'index', 283, 284),
(138, 136, '', NULL, 'action', 285, 286),
(139, 136, '', NULL, 'create', 287, 288),
(140, 136, '', NULL, 'inviteMember', 289, 290),
(141, 136, '', NULL, 'maintenance', 291, 292),
(142, 136, '', NULL, 'view', 293, 294),
(143, 136, '', NULL, 'messageEdit', 295, 296),
(145, 136, '', NULL, 'quote', 297, 298),
(146, 136, '', NULL, 'reply', 299, 300),
(147, 136, '', NULL, 'edit', 301, 302),
(148, 136, '', NULL, 'getEditMessage', 303, 304),
(149, 136, '', NULL, 'go', 305, 306),
(150, 136, '', NULL, 'kick', 307, 308),
(151, 136, '', NULL, 'invite', 309, 310),
(152, 136, '', NULL, 'leave', 311, 312),
(153, 136, '', NULL, 'search', 313, 314);

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
(1, NULL, 'Groups', 1, '', 9, 10),
(2, NULL, 'Groups', 2, '', 7, 8),
(3, NULL, 'Groups', 3, '', 5, 6),
(4, NULL, 'Groups', 4, '', 3, 4),
(5, NULL, 'Groups', 5, '', 1, 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62 ;

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
(31, 4, 1, '1', '1', '1', '1'),
(39, 4, 45, '-1', '-1', '-1', '-1'),
(40, 4, 80, '-1', '-1', '-1', '-1'),
(41, 4, 121, '-1', '-1', '-1', '-1'),
(42, 3, 85, '1', '1', '1', '1'),
(43, 3, 92, '-1', '-1', '-1', '-1'),
(44, 3, 97, '1', '1', '1', '1'),
(45, 3, 98, '1', '1', '1', '1'),
(46, 3, 100, '-1', '-1', '-1', '-1'),
(47, 3, 101, '-1', '-1', '-1', '-1'),
(48, 3, 108, '1', '1', '1', '1'),
(49, 2, 85, '1', '1', '1', '1'),
(50, 2, 92, '-1', '-1', '-1', '-1'),
(53, 2, 100, '-1', '-1', '-1', '-1'),
(54, 2, 101, '-1', '-1', '-1', '-1'),
(55, 2, 108, '1', '1', '1', '1'),
(56, 2, 120, '1', '1', '1', '1'),
(57, 2, 114, '-1', '-1', '-1', '-1'),
(58, 2, 132, '1', '1', '1', '1'),
(59, 2, 136, '1', '1', '1', '1'),
(60, 3, 132, '1', '1', '1', '1'),
(61, 3, 136, '1', '1', '1', '1');

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
-- Table structure `forum_threads_followers`
--

CREATE TABLE IF NOT EXISTS `forum_threads_followers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
-- Table structure `forum_categories_trackers`
--

CREATE TABLE IF NOT EXISTS `forum_categories_trackers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `nbunread` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure `forum_threads_trackers`
--

CREATE TABLE IF NOT EXISTS `forum_threads_trackers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
-- Table structure `conversations`
--

CREATE TABLE IF NOT EXISTS `conversations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `open_invite` tinyint(4) DEFAULT '0' COMMENT 'Allow invitations : 0=No,1=Yes',
  `conversation_open` tinyint(2) DEFAULT '1' COMMENT 'Statut of the conversation : 0=Close,1=Open,2=Deleted',
  `reply_count` int(11) DEFAULT NULL,
  `recipient_count` int(11) DEFAULT NULL,
  `first_message_id` int(11) DEFAULT NULL,
  `last_message_date` datetime DEFAULT NULL,
  `last_message_id` int(11) DEFAULT NULL,
  `last_message_user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure `conversations_messages`
--

CREATE TABLE IF NOT EXISTS `conversations_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conversation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` mediumtext,
  `edit_count` int(11) NOT NULL DEFAULT '0',
  `last_edit_user_id` int(11) DEFAULT NULL,
  `last_edit_date` datetime NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure `conversations_users`
--

CREATE TABLE IF NOT EXISTS `conversations_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conversation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_read` tinyint(4) DEFAULT '0' COMMENT 'Is Read : 0=Unreaded,1=Readed',
  `is_star` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=No, 1=Yes',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
-- Table structure `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `foreign_key` int(11) DEFAULT NULL COMMENT 'Can be the PostId, ThreadId etc',
  `type` varchar(150) NOT NULL,
  `data` text,
  `is_read` tinyint(2) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
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
    `password_code` varchar(50) NOT NULL,
    `password_code_expire` datetime NOT NULL,
    `password_reset_count` mediumint(9) NOT NULL DEFAULT '0',
    `register_ip` varchar(15) DEFAULT NULL,
    `last_login_ip` varchar(15) DEFAULT NULL,
    `last_login` datetime NOT NULL,
    `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
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

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `avatar`, `biography`, `signature`, `facebook`, `twitter`, `group_id`, `slug`, `language`, `blog_articles_comment_count`, `blog_article_count`, `forum_thread_count`, `forum_post_count`, `forum_like_received`, `end_subscription`, `password_code`, `password_code_expire`, `password_reset_count`, `register_ip`, `last_login_ip`, `last_login`, `is_deleted`, `created`, `modified`) VALUES
(1, 'Admin', '__ADMINPASSWORD__', 'admin@localhost.io', '', '', '../img/avatar.png', '', '', '', '', 5, 'admin', 'fr_FR', 1, 1, 1, 1, 1, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0,
'::1', '::1', '2014-09-22 10:04:56', 0, '2014-09-22 10:04:56', '2014-09-22 10:04:56'),
(2, 'Test', '__MEMBERPASSWORD__', 'test@localhost.io', '', '', '../img/avatar.png', '', '', '', '', 2, 'test', 'fr_FR', 1, 0, 0, 0, 0, '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', 0,
'::1', '::1', '2014-09-22 10:18:08', 0, '2014-09-22 10:18:08', '2014-09-22 10:18:08');
