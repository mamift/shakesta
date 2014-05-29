-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `shakesta` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `shakesta`;

CREATE TABLE IF NOT EXISTS `deal` (
  `deal_id` mediumint NOT NULL AUTO_INCREMENT,
  `price_discount` decimal(2,2),
  `terms` text,
  `expires_time` float DEFAULT NULL,
  `begins_time` float DEFAULT NULL,
  `category` tinytext,
  PRIMARY KEY (`deal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` mediumint NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `description` text,
  `retailer_id` mediumint,
  `retail_price` decimal(10,2),
  `deal_id` mediumint,
  `image` varbinary(32000),
  PRIMARY KEY (`product_id`),
  KEY `retailer_product_FK1` (`retailer_id`),
  KEY `deal_product_FK1` (`deal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `retailer` (
  `retailer_id` mediumint NOT NULL AUTO_INCREMENT,
  `description` text,
  PRIMARY KEY (`retailer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `shop` (
  `shop_location` varchar(255) NOT NULL,
  `retailer_id` mediumint DEFAULT NULL,
  `beacon_id` text,
  `title` tinytext NOT NULL,
  PRIMARY KEY (`shop_location`),
  KEY `retailer_shop_FK1` (`retailer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` mediumint NOT NULL AUTO_INCREMENT,
  `username` text,
  `password` text,
  `retailer_id` mediumint DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `retailer_user_FK1` (`retailer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `product`
  ADD CONSTRAINT `deal_product_FK1` FOREIGN KEY (`deal_id`) REFERENCES `deal` (`deal_id`),
  ADD CONSTRAINT `retailer_product_FK1` FOREIGN KEY (`retailer_id`) REFERENCES `retailer` (`retailer_id`);

ALTER TABLE `shop`
  ADD CONSTRAINT `retailer_shop_FK1` FOREIGN KEY (`retailer_id`) REFERENCES `retailer` (`retailer_id`);

ALTER TABLE `user`
  ADD CONSTRAINT `retailer_user_FK1` FOREIGN KEY (`retailer_id`) REFERENCES `retailer` (`retailer_id`);

ALTER TABLE `deal` CHANGE `expires_time` `expires_time` DATETIME NULL DEFAULT NULL;
ALTER TABLE `deal` CHANGE `begins_time` `begins_time` DATETIME NULL DEFAULT NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/* Actually the constraint here is bad, the deal table must have a fk to product, not the other way around */
ALTER TABLE `product` DROP FOREIGN KEY `product`.`deal_product_FK1`;
ALTER TABLE `product` DROP `deal_id`;
ALTER TABLE `deal` ADD `product_id` MEDIUMINT NULL AFTER `deal_id`, ADD UNIQUE (`product_id`);
ALTER TABLE `deal` ADD CONSTRAINT `deal_product_FK1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

ALTER TABLE `retailer` ADD `title` TINYTEXT NULL AFTER `retailer_id`;

/* Default user */
INSERT INTO `shakesta`.`user` (`user_id`, `username`, `password`, `retailer_id`, `created_at`, `updated_at`) VALUES ('1', 'admin', '$2y$10$G52UpoIxmzf7ZkOgvP4T6eX6hdm2SuXnHUpV67GwCBRbR6zfWr2nK', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

ALTER TABLE `user` ADD `email` MEDIUMTEXT NULL AFTER `password`;
ALTER TABLE `product` ADD `image_url` TEXT NULL AFTER `image`;

ALTER TABLE `shakesta`.`deal` DROP INDEX `product_id`, ADD INDEX `product_id` (`product_id`)COMMENT '';

/* http://laravel.com/docs/security#configuration */
ALTER TABLE `user` ADD `remember_token` VARCHAR(100) NULL AFTER `retailer_id`;
ALTER TABLE `user` ADD `apikey` VARCHAR(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL AFTER `remember_token`, ADD UNIQUE (`apikey`) ;


