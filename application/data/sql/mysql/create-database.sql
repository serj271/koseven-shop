DROP DATABASE IF EXISTS koseven_shop;
CREATE DATABASE koseven_shop DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL PRIVILEGES ON shop.* TO 'user_db'@'localhost';