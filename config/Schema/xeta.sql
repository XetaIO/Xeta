
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
