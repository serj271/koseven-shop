SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
use 'shop';
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS product_reviews;
CREATE TABLE `product_reviews` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`product_id` int(10) unsigned NOT NULL,
	`date` datetime NOT NULL,
	`name` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
	`rating` tinyint(2) unsigned NOT NULL,
	`summary` varchar(255) COLLATE utf8_general_ci NOT NULL,
	`body` text COLLATE utf8_general_ci NOT NULL,
	PRIMARY KEY (`id`),
	KEY `product_id` (`product_id`),
	KEY `date` (`date`),
	KEY `rating` (`rating`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;



DROP TABLE IF EXISTS product_specifications;
CREATE TABLE `product_specifications` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`product_id` int(10) unsigned NOT NULL,
	`name` varchar(255) COLLATE utf8_general_ci NOT NULL,
	`value` varchar(255) COLLATE utf8_general_ci NOT NULL,
	PRIMARY KEY (`id`),
	KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;

select 'prod variabl';

DROP TABLE IF EXISTS product_variations;
CREATE TABLE `product_variations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`product_id` int(10) unsigned NOT NULL,
	`name` varchar(255) COLLATE utf8_general_ci NOT NULL,
	`price` decimal(8,2) unsigned NOT NULL,
	`sale_price` decimal(8,2) unsigned DEFAULT NULL,
	`discounted_price` decimal(8,2) unsigned DEFAULT NULL,
	`quantity` mediumint(8) unsigned DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `product_id` (`product_id`),
	KEY `quantity` (`quantity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;

 SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS product_categories_products;
DROP TABLE IF EXISTS product_categories;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS order_products;
DROP TABLE IF EXISTS products;


CREATE TABLE `product_categories_products` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`product_id` int(10) unsigned NOT NULL,
	`catalog_category_id` int(10) unsigned NOT NULL,
/* 	`uri` VARCHAR(255) NOT NULL DEFAULT '',
	`delete_bit` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0', */
	PRIMARY KEY (`id`),
	KEY `fk_product` (`product_id`),
	KEY `fk_category_id` (`catalog_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS catalog_categories;
CREATE TABLE `catalog_categories` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`catalog_category_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`level` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`uri` VARCHAR(255) NOT NULL DEFAULT '',
	`code` VARCHAR(255) NOT NULL DEFAULT '',
	`title` VARCHAR(255) NOT NULL DEFAULT '',
	`image` VARCHAR(255) NOT NULL DEFAULT '',
	`text` TEXT NOT NULL,
	`active` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`position` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`title_tag` VARCHAR(255) NOT NULL DEFAULT '',
	`keywords_tag` VARCHAR(255) NOT NULL DEFAULT '',
	`description_tag` VARCHAR(255) NOT NULL DEFAULT '',
	`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
/* 	`creator_id` INT(10) NOT NULL DEFAULT '0',
	`updated` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	`updater_id` INT(10) NOT NULL DEFAULT '0',
	`deleted` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
	`deleter_id` INT(10) NOT NULL DEFAULT '0', */
	`delete_bit` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	KEY `catalog_category_id` (`catalog_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;

CREATE TABLE `order_products` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`order_id` int(10) unsigned NOT NULL,
	`product_id` int(10) unsigned NOT NULL,
	`product_name` varchar(255) COLLATE utf8_general_ci NOT NULL,
	`variation_id` int(10) unsigned DEFAULT NULL,
	`variation_name` varchar(255) COLLATE utf8_general_ci NOT NULL,
	`quantity` mediumint(8) unsigned NOT NULL,
	`price` decimal(8,2) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `order_id` (`order_id`,`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;

CREATE TABLE `product_categories` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_general_ci NOT NULL,
	`description` text COLLATE utf8_general_ci NOT NULL DEFAULT '',
	`parent_id` int(10) unsigned DEFAULT NULL,
	`uri` VARCHAR(255) NOT NULL DEFAULT '',
	`delete_bit` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
	`image` varchar(255) COLLATE utf8_general_ci DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;


CREATE TABLE `products` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_general_ci NOT NULL,
	`uri` VARCHAR(255) NOT NULL DEFAULT '',
	`description` text COLLATE utf8_general_ci NOT NULL,
	`primary_photo_id` int(10) unsigned DEFAULT NULL,
	`avg_review_rating` decimal(3,1) unsigned DEFAULT '0.0',
	`visible` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`),
	KEY `visible` (`visible`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS product_photos;
CREATE TABLE `product_photos` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`product_id` int(10) unsigned NOT NULL,
	`path_fullsize` varchar(255) COLLATE utf8_general_ci NOT NULL,
	`path_thumbnail` varchar(255) COLLATE utf8_general_ci NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `product_id_path_fullsize` (`product_id`,`path_fullsize`),
	KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;


/* Procedure to find the orderid with the largest amount
could be done with max, but just to illustrate stored procedure principles */

SET foreign_key_checks = 0;
/* ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE; */
/* 
ALTER TABLE `product_categories`
  ADD CONSTRAINT `product_categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE; */

/* ALTER TABLE `product_categories_products`
  ADD CONSTRAINT `product_categories_products_ibfk_2` FOREIGN KEY (`catalog_category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_categories_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE; */

ALTER TABLE `product_categories_products`
  ADD CONSTRAINT `product_categories_products_ibfk_2` FOREIGN KEY (`catalog_category_id`) REFERENCES `catalog_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_categories_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
  
ALTER TABLE `product_photos`
  ADD CONSTRAINT `product_photos_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

/* ALTER TABLE `product_specifications`
  ADD CONSTRAINT `product_specifications_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
 */
ALTER TABLE `product_variations`
  ADD CONSTRAINT `product_variations_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

  
SET FOREIGN_KEY_CHECKS = 1;
  