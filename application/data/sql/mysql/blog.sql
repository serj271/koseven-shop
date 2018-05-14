SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
use 'shop33';
SET @basename := 'shop33'; 

DROP TABLE IF EXISTS `article_revisions`;
CREATE TABLE IF NOT EXISTS `article_revisions` (
	`id` int(11) NOT NULL auto_increment,
	`article_id` int(11) NOT NULL,
	`version` int(4) NOT NULL,
	`date` int(10) NOT NULL,
	`editor_id` int(11) NOT NULL,
	`diff` text NOT NULL,
	`comment` text NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
	`id` int(11) NOT NULL auto_increment,
	`version` int(4) NOT NULL,
	`title` varchar(128) NOT NULL,
	`slug` varchar(128) NOT NULL,
	`text` text NOT NULL,
	`date` int(10) NOT NULL,
	`state` varchar(16) NOT NULL,
	`author_id` int(11) NOT NULL,
	`category_id` int(11) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 
DROP TABLE IF EXISTS `blog_comments`;
CREATE TABLE IF NOT EXISTS `blog_comments` (
	`id` int(11) NOT NULL auto_increment,
	`parent_id` int(11) NOT NULL,
	`state` varchar(8) NOT NULL,
	`date` int(10) NOT NULL,
	`name` varchar(64) NOT NULL,
	`email` varchar(128) NOT NULL,
	`url` varchar(128) NOT NULL,
	`text` text NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 
DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
	`id` int(11) NOT NULL auto_increment,
	`name` varchar(32) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 
 
DROP TABLE IF EXISTS `statistics`;
CREATE TABLE IF NOT EXISTS `statistics` (
	`id` int(11) NOT NULL auto_increment,
	`article_id` int(11) NOT NULL,
	`total` int(11) NOT NULL,
	`views` int(11) NOT NULL,
	`data` varchar(256) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
	`id` int(11) NOT NULL auto_increment,
	`name` varchar(32) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `articles_tags`;
CREATE TABLE IF NOT EXISTS `articles_tags` (
	`article_id` int(11) NOT NULL,
	`tag_id` int(11) NOT NULL,
	PRIMARY KEY (`article_id`, `tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8; 
 
 
 
 
 
 
 