
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
  (1, NULL, NULL, NULL, 'App', 1, 224),
  (2, 1, NULL, NULL, 'Attachments', 2, 5),
  (3, 2, NULL, NULL, 'download', 3, 4),
  (4, 1, NULL, NULL, 'Blog', 6, 31),
  (5, 4, NULL, NULL, 'index', 7, 8),
  (6, 4, NULL, NULL, 'category', 9, 10),
  (7, 4, NULL, NULL, 'article', 11, 12),
  (8, 4, NULL, NULL, 'quote', 13, 14),
  (9, 4, NULL, NULL, 'go', 15, 16),
  (10, 4, NULL, NULL, 'archive', 17, 18),
  (11, 4, NULL, NULL, 'search', 19, 20),
  (12, 4, NULL, NULL, 'articleLike', 21, 22),
  (13, 4, NULL, NULL, 'articleUnlike', 23, 24),
  (14, 4, NULL, NULL, 'deleteComment', 25, 26),
  (15, 4, NULL, NULL, 'getEditComment', 27, 28),
  (16, 4, NULL, NULL, 'editComment', 29, 30),
  (17, 1, NULL, NULL, 'Contact', 32, 35),
  (18, 17, NULL, NULL, 'index', 33, 34),
  (19, 1, NULL, NULL, 'Pages', 36, 43),
  (20, 19, NULL, NULL, 'home', 37, 38),
  (21, 19, NULL, NULL, 'acceptCookie', 39, 40),
  (22, 19, NULL, NULL, 'lang', 41, 42),
  (23, 1, NULL, NULL, 'Premium', 44, 55),
  (24, 23, NULL, NULL, 'index', 45, 46),
  (25, 23, NULL, NULL, 'subscribe', 47, 48),
  (26, 23, NULL, NULL, 'notify', 49, 50),
  (27, 23, NULL, NULL, 'success', 51, 52),
  (28, 23, NULL, NULL, 'cancel', 53, 54),
  (29, 1, NULL, NULL, 'Users', 56, 73),
  (30, 29, NULL, NULL, 'index', 57, 58),
  (31, 29, NULL, NULL, 'login', 59, 60),
  (32, 29, NULL, NULL, 'logout', 61, 62),
  (33, 29, NULL, NULL, 'account', 63, 64),
  (34, 29, NULL, NULL, 'settings', 65, 66),
  (35, 29, NULL, NULL, 'profile', 67, 68),
  (36, 29, NULL, NULL, 'delete', 69, 70),
  (37, 29, NULL, NULL, 'premium', 71, 72),
  (38, 1, NULL, NULL, 'Admin', 74, 171),
  (39, 38, NULL, NULL, 'Admin', 75, 78),
  (40, 39, NULL, NULL, 'home', 76, 77),
  (41, 38, NULL, NULL, 'Articles', 79, 88),
  (42, 41, NULL, NULL, 'index', 80, 81),
  (43, 41, NULL, NULL, 'add', 82, 83),
  (44, 41, NULL, NULL, 'edit', 84, 85),
  (45, 41, NULL, NULL, 'delete', 86, 87),
  (46, 38, NULL, NULL, 'Attachments', 89, 98),
  (47, 46, NULL, NULL, 'index', 90, 91),
  (48, 46, NULL, NULL, 'add', 92, 93),
  (49, 46, NULL, NULL, 'edit', 94, 95),
  (50, 46, NULL, NULL, 'delete', 96, 97),
  (51, 38, NULL, NULL, 'Categories', 99, 108),
  (52, 51, NULL, NULL, 'index', 100, 101),
  (53, 51, NULL, NULL, 'add', 102, 103),
  (54, 51, NULL, NULL, 'edit', 104, 105),
  (55, 51, NULL, NULL, 'delete', 106, 107),
  (56, 38, NULL, NULL, 'Groups', 109, 118),
  (57, 56, NULL, NULL, 'index', 110, 111),
  (58, 56, NULL, NULL, 'add', 112, 113),
  (59, 56, NULL, NULL, 'edit', 114, 115),
  (60, 56, NULL, NULL, 'delete', 116, 117),
  (61, 38, NULL, NULL, 'Users', 119, 130),
  (62, 61, NULL, NULL, 'index', 120, 121),
  (63, 61, NULL, NULL, 'search', 122, 123),
  (64, 61, NULL, NULL, 'edit', 124, 125),
  (65, 61, NULL, NULL, 'delete', 126, 127),
  (66, 61, NULL, NULL, 'deleteAvatar', 128, 129),
  (67, 38, NULL, NULL, 'Forum', 131, 146),
  (68, 67, NULL, NULL, 'Categories', 132, 145),
  (69, 68, NULL, NULL, 'index', 133, 134),
  (70, 68, NULL, NULL, 'add', 135, 136),
  (71, 68, NULL, NULL, 'moveUp', 137, 138),
  (72, 68, NULL, NULL, 'moveDown', 139, 140),
  (73, 68, NULL, NULL, 'edit', 141, 142),
  (74, 68, NULL, NULL, 'delete', 143, 144),
  (75, 38, NULL, NULL, 'Premium', 147, 170),
  (76, 75, NULL, NULL, 'Discounts', 148, 155),
  (77, 76, NULL, NULL, 'index', 149, 150),
  (78, 76, NULL, NULL, 'add', 151, 152),
  (79, 76, NULL, NULL, 'edit', 153, 154),
  (80, 75, NULL, NULL, 'Offers', 156, 165),
  (81, 80, NULL, NULL, 'index', 157, 158),
  (82, 80, NULL, NULL, 'add', 159, 160),
  (83, 80, NULL, NULL, 'edit', 161, 162),
  (84, 80, NULL, NULL, 'delete', 163, 164),
  (85, 75, NULL, NULL, 'Premium', 166, 169),
  (86, 85, NULL, NULL, 'home', 167, 168),
  (87, 1, NULL, NULL, 'Chat', 172, 185),
  (88, 87, NULL, NULL, 'Chat', 173, 184),
  (89, 88, NULL, NULL, 'index', 174, 175),
  (90, 88, NULL, NULL, 'shout', 176, 177),
  (91, 88, NULL, NULL, 'getNotice', 178, 179),
  (92, 88, NULL, NULL, 'editNotice', 180, 181),
  (93, 88, NULL, NULL, 'delete', 182, 183),
  (94, 1, NULL, NULL, 'Forum', 186, 223),
  (95, 94, NULL, NULL, 'Forum', 187, 194),
  (96, 95, NULL, NULL, 'index', 188, 189),
  (97, 95, NULL, NULL, 'categories', 190, 191),
  (98, 95, NULL, NULL, 'threads', 192, 193),
  (99, 94, NULL, NULL, 'Posts', 195, 210),
  (100, 99, NULL, NULL, 'unlike', 196, 197),
  (101, 99, NULL, NULL, 'like', 198, 199),
  (102, 99, NULL, NULL, 'delete', 200, 201),
  (103, 99, NULL, NULL, 'quote', 202, 203),
  (104, 99, NULL, NULL, 'go', 204, 205),
  (105, 99, NULL, NULL, 'edit', 206, 207),
  (106, 99, NULL, NULL, 'getEditPost', 208, 209),
  (107, 94, NULL, NULL, 'Threads', 211, 222),
  (108, 107, NULL, NULL, 'create', 212, 213),
  (109, 107, NULL, NULL, 'edit', 214, 215),
  (110, 107, NULL, NULL, 'reply', 216, 217),
  (111, 107, NULL, NULL, 'lock', 218, 219),
  (112, 107, NULL, NULL, 'unlock', 220, 221);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Table data `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
  (1, 1, 1, '1', '1', '1', '1'),
  (2, 2, 1, '0', '0', '0', '0'),
  (3, 2, 2, '0', '0', '0', '0'),
  (4, 2, 4, '0', '0', '0', '0'),
  (5, 2, 17, '0', '0', '0', '0'),
  (6, 2, 19, '0', '0', '0', '0'),
  (7, 2, 23, '0', '0', '0', '0'),
  (8, 2, 29, '0', '0', '0', '0'),
  (9, 2, 39, '0', '0', '0', '0'),
  (10, 2, 41, '0', '0', '0', '0'),
  (11, 2, 46, '0', '0', '0', '0'),
  (12, 2, 51, '0', '0', '0', '0'),
  (13, 2, 56, '0', '0', '0', '0'),
  (14, 2, 61, '0', '0', '0', '0'),
  (15, 2, 68, '0', '0', '0', '0'),
  (16, 2, 76, '0', '0', '0', '0'),
  (17, 2, 80, '0', '0', '0', '0'),
  (18, 2, 85, '0', '0', '0', '0'),
  (19, 2, 88, '0', '0', '0', '0'),
  (20, 2, 95, '0', '0', '0', '0'),
  (21, 2, 99, '0', '0', '0', '0'),
  (23, 2, 107, '0', '0', '0', '0'),
  (24, 2, 20, '0', '0', '0', '0'),
  (25, 2, 5, '0', '0', '0', '0'),
  (26, 2, 40, '0', '0', '0', '0'),
  (27, 2, 96, '0', '0', '0', '0'),
  (28, 2, 97, '0', '0', '0', '0'),
  (29, 2, 98, '0', '0', '0', '0');


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
