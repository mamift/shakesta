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