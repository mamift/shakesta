-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 04, 2014 at 07:21 PM
-- Server version: 5.5.33-31.1
-- PHP Version: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `chana13_shakesta`
--
CREATE DATABASE IF NOT EXISTS `chana13_shakesta`;
USE `chana13_shakesta`;
-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`name`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deal`
--

CREATE TABLE IF NOT EXISTS `deal` (
  `deal_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) DEFAULT NULL,
  `product_id` mediumint(9) DEFAULT NULL,
  `price_discount` float DEFAULT NULL,
  `terms` text,
  `expires_time` datetime DEFAULT NULL,
  `begins_time` datetime DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`deal_id`),
  KEY `product_id` (`product_id`),
  KEY `category` (`category`),
  KEY `category_2` (`category`),
  KEY `category_3` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `description` text,
  `retailer_id` mediumint(9) DEFAULT NULL,
  `retail_price` decimal(10,2) DEFAULT NULL,
  `image` varbinary(32000) DEFAULT NULL,
  `image_url` text,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`product_id`),
  KEY `retailer_product_FK1` (`retailer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `product_deals`
--
CREATE TABLE IF NOT EXISTS `product_deals` (
`id` mediumint(9)
,`title` varchar(500)
,`product_id` mediumint(9)
,`price_discount` float
,`terms` text
,`expires_time` datetime
,`begins_time` datetime
,`category` varchar(255)
,`created_at` timestamp
,`updated_at` timestamp
,`product_title` tinytext
,`product_description` text
,`original_price` decimal(10,2)
,`image_url` text
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `product_deals_retailers`
--
CREATE TABLE IF NOT EXISTS `product_deals_retailers` (
`id` mediumint(9)
,`product_id` mediumint(9)
,`title` varchar(500)
,`price_discount` float
,`terms` text
,`expires_time` datetime
,`begins_time` datetime
,`category` varchar(255)
,`created_at` timestamp
,`updated_at` timestamp
,`product_title` tinytext
,`product_description` text
,`original_price` decimal(10,2)
,`image_url` text
,`retailer_id` mediumint(9)
,`retailer` tinytext
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `product_retailers`
--
CREATE TABLE IF NOT EXISTS `product_retailers` (
`product_id` mediumint(9)
,`title` tinytext
,`description` text
,`retailer_id` mediumint(9)
,`retail_price` decimal(10,2)
,`image` varbinary(32000)
,`image_url` text
,`created_at` timestamp
,`updated_at` timestamp
,`retailer` tinytext
);
-- --------------------------------------------------------

--
-- Table structure for table `retailer`
--

CREATE TABLE IF NOT EXISTS `retailer` (
  `retailer_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`retailer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `retail_users`
--
CREATE TABLE IF NOT EXISTS `retail_users` (
`user_id` mediumint(9)
,`username` text
,`email` mediumtext
,`retailer_id` mediumint(9)
,`retailer` tinytext
,`retailer_description` text
,`created_at` timestamp
,`updated_at` timestamp
);
-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE IF NOT EXISTS `shop` (
  `shop_location` varchar(255) NOT NULL,
  `retailer_id` mediumint(9) DEFAULT NULL,
  `beacon_id` text,
  `title` tinytext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`shop_location`),
  KEY `retailer_shop_FK1` (`retailer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `username` text,
  `password` text,
  `email` mediumtext,
  `notes` text,
  `retailer_id` mediumint(9) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `apikey` varchar(34) DEFAULT NULL,
  `status` enum('enabled','disabled') DEFAULT 'disabled',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `apikey` (`apikey`),
  KEY `retailer_user_FK1` (`retailer_id`),
  KEY `apikey_2` (`apikey`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Structure for view `admin_users`
--
DROP TABLE IF EXISTS `admin_users`;

CREATE OR REPLACE VIEW `admin_users` AS (select `user`.`user_id` AS `user_id`,`user`.`username` AS `username`,`user`.`password` AS `password`,`user`.`email` AS `email`,`user`.`retailer_id` AS `retailer_id`,`user`.`remember_token` AS `remember_token`,`user`.`created_at` AS `created_at`,`user`.`updated_at` AS `updated_at` from `user` where isnull(`user`.`retailer_id`));

-- --------------------------------------------------------

--
-- Structure for view `product_deals`
--
DROP TABLE IF EXISTS `product_deals`;

CREATE OR REPLACE VIEW `product_deals` AS select `deal`.`deal_id` AS `id`,`deal`.`title` AS `title`,`deal`.`product_id` AS `product_id`,`deal`.`price_discount` AS `price_discount`,`deal`.`terms` AS `terms`,`deal`.`expires_time` AS `expires_time`,`deal`.`begins_time` AS `begins_time`,`deal`.`category` AS `category`,`deal`.`created_at` AS `created_at`,`deal`.`updated_at` AS `updated_at`,`product`.`title` AS `product_title`,`product`.`description` AS `product_description`,`product`.`retail_price` AS `original_price`,`product`.`image_url` AS `image_url` from (`deal` join `product` on((`product`.`product_id` = `deal`.`product_id`)));

-- --------------------------------------------------------

--
-- Structure for view `product_deals_retailers`
--
DROP TABLE IF EXISTS `product_deals_retailers`;

CREATE OR REPLACE VIEW `product_deals_retailers` AS select `deal`.`deal_id` AS `id`,`deal`.`product_id` AS `product_id`,`deal`.`title` AS `title`,`deal`.`price_discount` AS `price_discount`,`deal`.`terms` AS `terms`,`deal`.`expires_time` AS `expires_time`,`deal`.`begins_time` AS `begins_time`,`deal`.`category` AS `category`,`deal`.`created_at` AS `created_at`,`deal`.`updated_at` AS `updated_at`,`product`.`title` AS `product_title`,`product`.`description` AS `product_description`,`product`.`retail_price` AS `original_price`,`product`.`image_url` AS `image_url`,`product`.`retailer_id` AS `retailer_id`,`retailer`.`title` AS `retailer` from ((`deal` join `product` on((`product`.`product_id` = `deal`.`product_id`))) join `retailer` on((`product`.`retailer_id` = `retailer`.`retailer_id`)));

-- --------------------------------------------------------

--
-- Structure for view `product_retailers`
--
DROP TABLE IF EXISTS `product_retailers`;

CREATE OR REPLACE VIEW `product_retailers` AS select `product`.`product_id` AS `product_id`,`product`.`title` AS `title`,`product`.`description` AS `description`,`product`.`retailer_id` AS `retailer_id`,`product`.`retail_price` AS `retail_price`,`product`.`image` AS `image`,`product`.`image_url` AS `image_url`,`product`.`created_at` AS `created_at`,`product`.`updated_at` AS `updated_at`,`retailer`.`title` AS `retailer` from (`product` join `retailer` on((`product`.`retailer_id` = `retailer`.`retailer_id`)));

-- --------------------------------------------------------

--
-- Structure for view `retail_users`
--
DROP TABLE IF EXISTS `retail_users`;

CREATE OR REPLACE VIEW `retail_users` AS select distinct `user`.`user_id` AS `user_id`,`user`.`username` AS `username`,`user`.`email` AS `email`,`user`.`retailer_id` AS `retailer_id`,`retailer`.`title` AS `retailer`,`retailer`.`description` AS `retailer_description`,`user`.`created_at` AS `created_at`,`user`.`updated_at` AS `updated_at` from (`user` `users_table` join (`retailer` join `user` on((`user`.`retailer_id` = `retailer`.`retailer_id`))));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deal`
--
ALTER TABLE `deal`
  ADD CONSTRAINT `deal_ibfk_2` FOREIGN KEY (`category`) REFERENCES `category` (`name`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `deal_product_FK1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `retailer_product_FK1` FOREIGN KEY (`retailer_id`) REFERENCES `retailer` (`retailer_id`);

--
-- Constraints for table `shop`
--
ALTER TABLE `shop`
  ADD CONSTRAINT `retailer_shop_FK1` FOREIGN KEY (`retailer_id`) REFERENCES `retailer` (`retailer_id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `retailer_user_FK1` FOREIGN KEY (`retailer_id`) REFERENCES `retailer` (`retailer_id`);

-- Add default admin user: "admin","gizmoe99"
INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `notes`, `retailer_id`, `remember_token`, `apikey`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$PEKniW8sr8xUyNRgxVZQIOH.peO8i8BNHKCE2HdKUtrIjJDYPLhSO', 'admin@shakesta.com', 'The default and master admin user', NULL, 'B4lqwkHgddrqJ84yusyM4geWichtJmqtJzxAToPhqRpsyWJtz691ah2Bx6TA', NULL, 'enabled', '2014-06-05 02:39:36', '2014-06-05 02:39:42');

-- default categories for campaigns

INSERT INTO category (`name`) VALUES
('Automotive'),
('Computing'),
('Electrical & Electronics'),
('Entertainment'),
('Fashion & Apparel'),
('Food & Grocery'),
('Gaming'),
('Mobile'),
('Music'),
('Travel');
