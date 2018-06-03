SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
use 'shop';

CREATE TABLE IF NOT EXISTS `b8_words` (
	`id` bigint unsigned NOT NULL auto_increment,
	`word` varchar(30) NOT NULL,
	`ham` bigint unsigned NULL,
	`spam` bigint unsigned NULL,
	PRIMARY KEY (`id`),
	INDEX (`word`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `b8_categories` (
	`id` bigint unsigned NOT NULL auto_increment,
	`category` varchar(4) NULL,
	`total` bigint unsigned NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX (`category`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO b8_categories (id, category, total) VALUES (1, 'ham', 0);
INSERT INTO b8_categories (id, category, total) VALUES (2, 'spam', 0);

CREATE TABLE IF NOT EXISTS `comments` (
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


