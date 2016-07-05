-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 18, 2015 at 10:32 AM
-- Server version: 5.5.43-0ubuntu0.14.10.1
-- PHP Version: 5.5.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dresslike`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) CHARACTER SET utf8 COLLATE utf8_estonian_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`) VALUES
(1, 'Домашняя одежда', 0),
(2, 'Женское белье', 0),
(3, 'Обувь', 0),
(4, 'Мужчинам', 0),
(5, 'Женщинам', 0),
(6, 'Детям', 0),
(7, 'Комплекты нижнего белья', 2),
(8, 'Колготки и чулки', 2),
(9, 'Бюсгальтеры', 2),
(10, 'Эротическое белье', 2),
(11, 'Трусики', 2);

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE IF NOT EXISTS `fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `type` enum('select') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`id`, `name`, `type`) VALUES
(2, 'Размер', 'select');

-- --------------------------------------------------------

--
-- Table structure for table `fields_to_category`
--

CREATE TABLE IF NOT EXISTS `fields_to_category` (
  `field_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `fields_to_category`
--

INSERT INTO `fields_to_category` (`field_id`, `category_id`, `id`) VALUES
(2, 1, 10),
(2, 3, 11),
(2, 4, 12),
(2, 5, 13),
(2, 6, 14);

-- --------------------------------------------------------

--
-- Table structure for table `fields_values_to_items`
--

CREATE TABLE IF NOT EXISTS `fields_values_to_items` (
  `item_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images_to_items`
--

CREATE TABLE IF NOT EXISTS `images_to_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `small_image` varchar(250) NOT NULL,
  `big_image` varchar(250) NOT NULL,
  `item_id` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `images_to_items`
--

INSERT INTO `images_to_items` (`id`, `small_image`, `big_image`, `item_id`, `rank`) VALUES
(1, 'images/items/bIMG_2825.jpg', 'images/items/bIMG_2825.jpg', 2, 1),
(2, 'images/items/bIMG_2825.jpg', 'images/items/bIMG_2825.jpg', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `online` tinyint(1) NOT NULL,
  `price` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price_opt` int(11) NOT NULL,
  `article` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `materials` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `online`, `price`, `category_id`, `price_opt`, `article`, `description`, `materials`) VALUES
(2, 'Халат', 1, 12000, 1, 10500, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `params_to_item_field`
--

CREATE TABLE IF NOT EXISTS `params_to_item_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `value_id` int(11) NOT NULL,
  `parent_value_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `auth_key` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`, `updated_at`, `auth_key`) VALUES
(2, 'dfs@ya.ru', '$2y$13$NAG0RAof587AE', 1439292154, 1439292154, ''),
(5, 'bobrovova@gmail.com', '$2y$13$RzcmDcCH07NC2VW7w6nnN.y4l3VRgmpM.SN8pWb3FTS/ZpG8bdnsi', 1439830592, 1439830592, '');

-- --------------------------------------------------------

--
-- Table structure for table `values`
--

CREATE TABLE IF NOT EXISTS `values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
