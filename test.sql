-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.13-0ubuntu0.16.04.2 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for dresslike
CREATE DATABASE IF NOT EXISTS `dresslike` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dresslike`;


-- Dumping structure for table dresslike.add_item_to_cart_form
CREATE TABLE IF NOT EXISTS `add_item_to_cart_form` (
  `idItem` int(11) NOT NULL AUTO_INCREMENT,
  `count` int(11) DEFAULT NULL,
  `param` int(11) DEFAULT NULL,
  PRIMARY KEY (`idItem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table dresslike.add_item_to_cart_form: ~0 rows (approximately)
/*!40000 ALTER TABLE `add_item_to_cart_form` DISABLE KEYS */;
/*!40000 ALTER TABLE `add_item_to_cart_form` ENABLE KEYS */;


-- Dumping structure for table dresslike.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `item_id` int(11) DEFAULT NULL,
  `param` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(250) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table dresslike.cart: ~3 rows (approximately)
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` (`item_id`, `param`, `price`, `count`, `user_id`, `session_id`, `id`) VALUES
	(1, NULL, 456, 2, NULL, '577009182ce825.69722571', 2),
	(3, NULL, 325, 1, NULL, '577a944a97b173.08428302', 6),
	(2, NULL, 325, 2, NULL, '577a944a97b173.08428302', 7),
	(1, NULL, 456, 5, NULL, '577a944a97b173.08428302', 8);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;


-- Dumping structure for table dresslike.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `left_key` int(11) NOT NULL DEFAULT '0',
  `right_key` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `Index 2` (`name`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table dresslike.categories: ~3 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `parent_id`, `left_key`, `right_key`, `level`) VALUES
	(1, 'Купальники', 0, 5, 6, 1),
	(2, 'Нижнее белье', 0, 3, 4, 1),
	(3, 'Домашняя одежда', 0, 1, 2, 1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;


-- Dumping structure for table dresslike.extra_variations
CREATE TABLE IF NOT EXISTS `extra_variations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(250) NOT NULL,
  `opt_price` varchar(250) NOT NULL,
  `item_id` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table dresslike.extra_variations: ~8 rows (approximately)
/*!40000 ALTER TABLE `extra_variations` DISABLE KEYS */;
INSERT INTO `extra_variations` (`id`, `value`, `opt_price`, `item_id`, `rank`) VALUES
	(1, '85C', '500', 6, 0),
	(2, '90A', '10', 7, 0),
	(3, '85B', '999', 7, 1),
	(4, '85C', '500', 9, 0),
	(5, '90A', '10', 10, 0),
	(6, '85B', '999', 10, 1),
	(7, '90A', '10', 11, 0),
	(8, '85B', '999', 11, 1);
/*!40000 ALTER TABLE `extra_variations` ENABLE KEYS */;


-- Dumping structure for table dresslike.fields
CREATE TABLE IF NOT EXISTS `fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `type` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table dresslike.fields: ~0 rows (approximately)
/*!40000 ALTER TABLE `fields` DISABLE KEYS */;
INSERT INTO `fields` (`id`, `name`, `type`) VALUES
	(1, 'Размер', 'select');
/*!40000 ALTER TABLE `fields` ENABLE KEYS */;


-- Dumping structure for table dresslike.fields_to_category
CREATE TABLE IF NOT EXISTS `fields_to_category` (
  `field_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table dresslike.fields_to_category: ~0 rows (approximately)
/*!40000 ALTER TABLE `fields_to_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `fields_to_category` ENABLE KEYS */;


-- Dumping structure for table dresslike.fields_values_to_items
CREATE TABLE IF NOT EXISTS `fields_values_to_items` (
  `item_id` int(11) DEFAULT NULL,
  `value_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table dresslike.fields_values_to_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `fields_values_to_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `fields_values_to_items` ENABLE KEYS */;


-- Dumping structure for table dresslike.images_to_items
CREATE TABLE IF NOT EXISTS `images_to_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `small_image` varchar(250) NOT NULL DEFAULT '0',
  `big_image` varchar(250) NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `isThumb` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table dresslike.images_to_items: ~6 rows (approximately)
/*!40000 ALTER TABLE `images_to_items` DISABLE KEYS */;
INSERT INTO `images_to_items` (`id`, `small_image`, `big_image`, `item_id`, `rank`, `isThumb`) VALUES
	(5, '3_0_950.jpg', '3_0_950.jpg', 3, 1, 1),
	(6, '2_0_657.jpg', '2_0_657.jpg', 2, 1, 0),
	(7, '4_0_832.jpg', '4_0_832.jpg', 4, 1, 1),
	(8, '5_0_555.jpg', '5_0_555.jpg', 5, 1, 1),
	(12, '1_0_785.jpg', '1_0_785.jpg', 1, 1, 1);
/*!40000 ALTER TABLE `images_to_items` ENABLE KEYS */;


-- Dumping structure for table dresslike.items
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '0',
  `online` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price_opt` int(11) NOT NULL,
  `article` varchar(250) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `materials` varchar(250) NOT NULL DEFAULT '0',
  `id_product` int(11) NOT NULL DEFAULT '0',
  `color` varchar(50) NOT NULL DEFAULT '0',
  `color_rank` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table dresslike.items: ~0 rows (approximately)
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
/*!40000 ALTER TABLE `items` ENABLE KEYS */;


-- Dumping structure for table dresslike.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_client` varchar(250) DEFAULT NULL,
  `phone_client` varchar(250) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `items` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table dresslike.orders: ~3 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `name_client`, `phone_client`, `date`, `items`) VALUES
	(1, 'Владимир', '89137673063', '2016-07-04 21:40:21', '[{"item_id":1,"param":null,"price":456,"count":2,"user_id":null,"session_id":"577009182ce825.69722571","id":2}]'),
	(2, 'Костя', '89137673063', '2016-07-04 21:47:52', '[{"item_id":1,"param":null,"price":456,"count":2,"user_id":null,"session_id":"577009182ce825.69722571","id":2}]'),
	(4, 'gdf', 'sdfsdafsadf', '2016-07-04 22:52:49', '[{"item_id":3,"param":null,"price":325,"count":1,"user_id":null,"session_id":"577a944a97b173.08428302","id":6},{"item_id":2,"param":null,"price":325,"count":2,"user_id":null,"session_id":"577a944a97b173.08428302","id":7},{"item_id":1,"param":null,"price":456,"count":5,"user_id":null,"session_id":"577a944a97b173.08428302","id":8}]');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;


-- Dumping structure for table dresslike.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `password_hash` varchar(250) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `password` varchar(250) DEFAULT NULL,
  `auth_key` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table dresslike.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `status`, `password_hash`, `created_at`, `updated_at`, `password`, `auth_key`) VALUES
	(3, 'bobrovova@gmail.com', 0, '0', 1467463333, 1467463333, '$2y$13$tO7Ll2ROzSAA/Pg0TEZt3uzKkalcqFKa8TjeL6iI8.Us1VpGYIHLm', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table dresslike.values
CREATE TABLE IF NOT EXISTS `values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table dresslike.values: ~0 rows (approximately)
/*!40000 ALTER TABLE `values` DISABLE KEYS */;
/*!40000 ALTER TABLE `values` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
