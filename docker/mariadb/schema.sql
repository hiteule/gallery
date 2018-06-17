DROP TABLE IF EXISTS `hg3_cat`;
CREATE TABLE IF NOT EXISTS `hg3_cat` (
  `id` int(11) NOT NULL auto_increment,
  `id_cat` int(11) NOT NULL,
  `id_souscat` text collate utf8_unicode_ci NOT NULL,
  `nb_img` bigint(20) NOT NULL,
  `nb_souscat` bigint(20) NOT NULL,
  `link` text collate utf8_unicode_ci NOT NULL,
  `name` text collate utf8_unicode_ci NOT NULL,
  `description` text collate utf8_unicode_ci NOT NULL,
  `sort` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

DROP TABLE IF EXISTS `hg3_comment`;
CREATE TABLE IF NOT EXISTS `hg3_comment` (
  `id` int(11) NOT NULL auto_increment,
  `id_img` int(11) NOT NULL,
  `date` bigint(20) NOT NULL,
  `name` text collate utf8_unicode_ci NOT NULL,
  `comment` text collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

DROP TABLE IF EXISTS `hg3_img`;
CREATE TABLE IF NOT EXISTS `hg3_img` (
  `id` int(11) NOT NULL auto_increment,
  `id_cat` int(11) NOT NULL,
  `date_add` bigint(20) NOT NULL,
  `file` text collate utf8_unicode_ci NOT NULL,
  `name` text collate utf8_unicode_ci NOT NULL,
  `nb_view` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

DROP TABLE IF EXISTS `hg3_user`;
CREATE TABLE IF NOT EXISTS `hg3_user` (
  `id` int(11) NOT NULL auto_increment,
  `login` text collate utf8_unicode_ci NOT NULL,
  `pass` text collate utf8_unicode_ci NOT NULL,
  `hash` text collate utf8_unicode_ci NOT NULL,
  `mail` text collate utf8_unicode_ci NOT NULL,
  `ban` int(11) NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;