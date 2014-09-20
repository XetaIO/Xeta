--
-- Structure de la table 'blog_articles'
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table 'blog_articles_comments'
--

CREATE TABLE IF NOT EXISTS blog_articles_comments (
  id int(11) NOT NULL AUTO_INCREMENT,
  article_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  content text NOT NULL,
  created datetime NOT NULL,
  modified datetime NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table 'blog_articles_likes'
--

CREATE TABLE IF NOT EXISTS blog_articles_likes (
  id int(11) NOT NULL AUTO_INCREMENT,
  article_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  created datetime NOT NULL,
  modified datetime NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table 'blog_categories'
--

CREATE TABLE IF NOT EXISTS blog_categories (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  description tinytext NOT NULL,
  slug varchar(255) NOT NULL,
  article_count int(11) NOT NULL DEFAULT '0',
  last_article_id int(11) NOT NULL DEFAULT '0',
  created datetime NOT NULL,
  modified datetime NOT NULL,
  PRIMARY KEY (id),
  KEY slug (slug)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table 'users'
--

CREATE TABLE IF NOT EXISTS users (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  email varchar(50) NOT NULL,
  first_name varchar(100) NOT NULL,
  last_name varchar(100) NOT NULL,
  avatar varchar(255) NOT NULL DEFAULT '../img/avatar.png',
  biography text NOT NULL,
  signature text NOT NULL,
  facebook varchar(200) NOT NULL,
  twitter varchar(200) NOT NULL,
  role varchar(20) DEFAULT 'member',
  slug varchar(20) NOT NULL,
  blog_articles_comment_count int(11) DEFAULT '0',
  blog_article_count int(11) DEFAULT '0',
  register_ip varchar(15) DEFAULT NULL,
  last_login_ip varchar(15) DEFAULT NULL,
  last_login datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  created datetime NOT NULL,
  modified datetime NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY username (username),
  UNIQUE KEY mail (email),
  KEY slug (slug)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
