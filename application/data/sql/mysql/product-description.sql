SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
use shop;

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS product_description;
CREATE TABLE `product_description` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`product_id` int(10) unsigned NOT NULL,
	`language_id` int(10) unsigned NOT NULL,
	`name` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
	`description` text COLLATE utf8_general_ci NOT NULL,
	`meta_description` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
	`meta_keyword` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;