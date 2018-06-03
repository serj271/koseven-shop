SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
use 'shop33';
SET @basename := 'shop33';

DROP TABLE IF EXISTS `shopping_cart`;
CREATE TABLE `shopping_cart` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`cart_id` CHAR(32) NOT NULL,
	`product_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`attributes` VARCHAR(1000) NOT NULL DEFAULT 'a',
	`quantity` INT NOT NULL,
	`buy_now` BOOL NOT NULL DEFAULT true,
	`added_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	KEY `product_id` (`product_id`),
	KEY `idx_shopping_cart_cart_id` (`cart_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;

 
DROP PROCEDURE IF EXISTS  shopping_cart_add_product;
delimiter //
CREATE PROCEDURE shopping_cart_add_product(IN inCartId CHAR(32), IN inProductId INT, IN inAttributes VARCHAR(1000))
BEGIN
	DECLARE productQuantity INT;
	-- Obtain current shopping cart quantity for the product
	SELECT quantity	FROM shopping_cart	WHERE cart_id = inCartId AND product_id = inProductId AND attributes = inAttributes	INTO productQuantity;
	-- Create new shopping cart record, or increase quantity of existing record
	IF (productQuantity IS NULL) THEN
		INSERT INTO shopping_cart(cart_id, product_id, attributes, quantity, added_on) VALUES (inCartId, inProductId, inAttributes, 1, NOW());
	ELSE
		UPDATE shopping_cart SET quantity = quantity + 1, buy_now = true WHERE cart_id = inCartId AND product_id = inProductId	AND attributes = inAttributes;
	END IF;
	SELECT * FROM shopping_cart	WHERE cart_id = inCartId;
END 
//
delimiter ;

/* GRANT EXECUTE ON PROCEDURE shopping_cart_add_product TO 'user_db'@'localhost'; */

DROP PROCEDURE IF EXISTS  shopping_cart_remove_product_to_cart;
delimiter //
CREATE PROCEDURE shopping_cart_remove_product_to_cart(IN inItemId INT)
BEGIN
	DELETE FROM shopping_cart WHERE id = inItemId;
	SELECT 'ok';
END
//
delimiter ;
/* GRANT EXECUTE ON PROCEDURE shopping_cart_remove_product_to_cart TO 'user_db'@'localhost'; */


DROP PROCEDURE IF EXISTS  shopping_cart_update;
delimiter //
-- Create shopping_cart_update_product stored procedure
CREATE PROCEDURE shopping_cart_update(IN inItemId INT, IN inQuantity INT)
BEGIN
	IF inQuantity > 0 THEN
		UPDATE shopping_cart SET quantity = inQuantity, added_on = NOW() WHERE id = inItemId;
	ELSE
		CALL shopping_cart_remove_product_to_cart(inItemId);
	END IF;
	SELECT * FROM shopping_cart	WHERE id = inItemId;
END
//
delimiter ;
/* GRANT EXECUTE ON PROCEDURE shopping_cart_update TO 'user_db'@'localhost'; */

DROP PROCEDURE IF EXISTS  shopping_cart_get_products;
delimiter //
CREATE PROCEDURE shopping_cart_get_products(IN inCartId CHAR(32))
BEGIN
	SELECT sc.id as id, sc.cart_id, p.name, sc.attributes, p.price AS price, sc.quantity, p.price * sc.quantity AS subtotal, pr.uri, pr.id as product_id
		FROM shopping_cart sc
		INNER JOIN product_variations p
		ON sc.product_id = p.product_id
		INNER JOIN products pr
		ON pr.id = p.product_id
		WHERE sc.cart_id = inCartId AND sc.buy_now;
END
//
delimiter ;
/* GRANT EXECUTE ON PROCEDURE shopping_cart_get_products TO 'user_db'@'localhost'; */

DROP PROCEDURE IF EXISTS  shopping_cart_get_total_amount;
delimiter //
CREATE PROCEDURE shopping_cart_get_total_amount(IN inCartId CHAR(32))
BEGIN
	SELECT SUM(COALESCE(NULLIF(p.discounted_price, 0), p.price)
	* sc.quantity) AS total_amount
	FROM shopping_cart sc
	INNER JOIN product_variations p
	ON sc.product_id = p.product_id
	WHERE sc.cart_id = inCartId AND sc.buy_now;
END
//
delimiter ;
/* GRANT EXECUTE ON PROCEDURE shopping_cart_get_total_amount TO 'user_db'@'localhost'; */

DROP PROCEDURE IF EXISTS  shopping_cart_save_product_for_later;
delimiter //
CREATE PROCEDURE shopping_cart_save_product_for_later(IN inItemId INT)
BEGIN
	UPDATE shopping_cart
	SET buy_now = false, quantity = 1
	WHERE id = inItemId;
	SELECT 'ok';
END
//
delimiter ;
/* GRANT EXECUTE ON PROCEDURE shopping_cart_save_product_for_later TO 'user_db'@'localhost'; */


DROP PROCEDURE IF EXISTS  shopping_cart_move_product_to_cart;
delimiter //
-- Create shopping_cart_move_product_to_cart stored procedure
CREATE PROCEDURE shopping_cart_move_product_to_cart(IN inItemId INT)
BEGIN
	UPDATE shopping_cart
	SET buy_now = true, added_on = NOW()
	WHERE id = inItemId;
	SELECT 'ok';
END
//
delimiter ;






















