-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 13, 2019 at 01:22 PM
-- Server version: 10.2.27-MariaDB
-- PHP Version: 7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u327551018_grocery`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `ads_key` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `name`, `ads_key`, `status`) VALUES
(1, 'Home : Above Top Selling Products', 'ca-app-pub-8779080242745729/3499191653', '1'),
(2, 'Home : Above Deal Of The Day', 'ca-app-pub-8779080242745729/3499191653', '1'),
(3, 'Above Footer', 'ca-app-pub-8779080242745729/3499191653', '1'),
(4, 'Product Page : Footer', 'ca-app-pub-8779080242745729/3499191653', '1'),
(5, 'Product Page : Full page', 'ca-app-pub-8779080242745729/9795214681', '1');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `slider_title` varchar(100) NOT NULL,
  `slider_url` varchar(100) NOT NULL,
  `slider_image` varchar(100) NOT NULL,
  `sub_cat` int(11) NOT NULL,
  `slider_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `slider_title`, `slider_url`, `slider_image`, `sub_cat`, `slider_status`) VALUES
(5, 'banne2', '', 'banner@2x1.jpg', 52, 0),
(6, 'easy_to_you', '', 'banner-12.png', 10, 0),
(11, 'Rbi', '', '11a954b5e18a7c1d.jpg', 0, 1),
(12, 'Surf', '', 'images-7.jpeg', 34, 1),
(13, 'Bournvita', 'Health Drinks', '85a7e2e5ea3553d8.jpg', 35, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(200) NOT NULL,
  `qty` int(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `product_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `arb_title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `parent` int(50) NOT NULL,
  `leval` int(50) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(200) NOT NULL,
  `image2` varchar(200) NOT NULL,
  `image2_status` varchar(300) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--


-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`city_id`, `city_name`) VALUES
(1, 'Noida'),
(2, 'G.Noida'),
(3, 'New Delhi'),
(4, 'Neemuch');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('342e31c354380fc9b2a9746edfd531a4642e545b', '2409:4043:28d:741c:86a0:95e6:41d8:3213', 1575477610, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537353437373631303b),
('a6a0a4f0daaeb9c62bca3710fd37b44710d48876', '182.68.45.56', 1576242241, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537363234323234313b757365725f6e616d657c733a31343a224d61696e2041646d696e20303037223b757365725f656d61696c7c733a31383a227465636d616e696340676d61696c2e636f6d223b6c6f676765645f696e7c623a313b757365725f69647c733a313a2231223b757365725f747970655f69647c733a313a2230223b),
('10f2e43b4ffb1cc90a24c15be7c36d14fb766925', '182.68.45.56', 1576242295, 0x5f5f63695f6c6173745f726567656e65726174657c693a313537363234323234313b757365725f6e616d657c733a31343a224d61696e2041646d696e20303037223b757365725f656d61696c7c733a31383a227465636d616e696340676d61696c2e636f6d223b6c6f676765645f696e7c623a313b757365725f69647c733a313a2231223b757365725f747970655f69647c733a313a2230223b);

-- --------------------------------------------------------

--
-- Table structure for table `closing_hours`
--

CREATE TABLE `closing_hours` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `from_time` time NOT NULL,
  `to_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `closing_hours`
--

INSERT INTO `closing_hours` (`id`, `date`, `from_time`, `to_time`) VALUES
(1, '2017-02-06', '10:30:00', '16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `coupon_name` varchar(200) NOT NULL,
  `coupon_code` varchar(20) NOT NULL,
  `valid_from` varchar(20) NOT NULL,
  `valid_to` varchar(20) NOT NULL,
  `validity_type` varchar(50) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `discount_type` varchar(50) NOT NULL,
  `discount_value` int(11) NOT NULL,
  `cart_value` int(11) NOT NULL,
  `uses_restriction` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupons`
--


-- --------------------------------------------------------

--
-- Table structure for table `deal_product`
--

CREATE TABLE `deal_product` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `deal_price` varchar(200) NOT NULL,
  `start_date` varchar(200) NOT NULL,
  `start_time` varchar(200) NOT NULL,
  `end_date` varchar(200) NOT NULL,
  `end_time` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `deal_product`
--


-- --------------------------------------------------------

--
-- Table structure for table `deelofday`
--

CREATE TABLE `deelofday` (
  `id` int(11) NOT NULL,
  `product_price` varchar(500) NOT NULL,
  `image_title` varchar(200) NOT NULL,
  `img_url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `delivered_order`
--

CREATE TABLE `delivered_order` (
  `sale_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `on_date` date NOT NULL,
  `delivery_time_from` varchar(200) NOT NULL,
  `delivery_time_to` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `note` longtext NOT NULL,
  `is_paid` int(11) NOT NULL,
  `total_amount` double NOT NULL,
  `total_rewards` varchar(200) NOT NULL,
  `total_kg` double NOT NULL,
  `total_items` double NOT NULL,
  `socity_id` int(11) NOT NULL,
  `delivery_address` longtext NOT NULL,
  `location_id` int(11) NOT NULL,
  `delivery_charge` double NOT NULL,
  `new_store_id` varchar(200) NOT NULL DEFAULT '0',
  `assign_to` int(11) NOT NULL DEFAULT 0,
  `payment_method` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `delivered_order`
--


-- --------------------------------------------------------

--
-- Table structure for table `delivery_boy`
--

CREATE TABLE `delivery_boy` (
  `id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `user_phone` varchar(200) NOT NULL,
  `user_status` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_boy`
--


-- --------------------------------------------------------

--
-- Table structure for table `feature_slider`
--

CREATE TABLE `feature_slider` (
  `id` int(11) NOT NULL,
  `slider_title` varchar(100) NOT NULL,
  `slider_url` varchar(100) NOT NULL,
  `slider_image` varchar(100) NOT NULL,
  `sub_cat` int(200) NOT NULL,
  `slider_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `feature_slider`
--


-- --------------------------------------------------------

--
-- Table structure for table `header_categories`
--

CREATE TABLE `header_categories` (
  `id` int(40) NOT NULL,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `parent` int(50) NOT NULL,
  `leval` int(50) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(200) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `header_products`
--

CREATE TABLE `header_products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_description` longtext NOT NULL,
  `product_image` varchar(200) NOT NULL,
  `category_id` int(11) NOT NULL,
  `in_stock` int(11) NOT NULL,
  `price` double NOT NULL,
  `unit_value` double NOT NULL,
  `unit` varchar(10) NOT NULL,
  `increament` double NOT NULL,
  `rewards` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `icons`
--

CREATE TABLE `icons` (
  `id` int(255) NOT NULL,
  `service` varchar(500) NOT NULL,
  `image_name` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `instamojo`
--

CREATE TABLE `instamojo` (
  `id` int(200) NOT NULL,
  `api_key` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `instamojo`
--


-- --------------------------------------------------------

--
-- Table structure for table `language_setting`
--

CREATE TABLE `language_setting` (
  `id` int(200) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `language_setting`
--

INSERT INTO `language_setting` (`id`, `status`) VALUES
(1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `pageapp`
--

CREATE TABLE `pageapp` (
  `id` int(11) NOT NULL,
  `pg_title` varchar(200) NOT NULL,
  `pg_slug` varchar(100) NOT NULL,
  `pg_descri` longtext NOT NULL,
  `pg_status` int(50) NOT NULL,
  `pg_foot` int(50) NOT NULL,
  `crated_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pageapp`
--

INSERT INTO `pageapp` (`id`, `pg_title`, `pg_slug`, `pg_descri`, `pg_status`, `pg_foot`, `crated_date`) VALUES
(1, 'Hello', 'hello', 'Hello', 0, 0, '2019-01-24 17:24:12'),
(2, 'About Us', 'about-us', 'Novelty retail\r\nDid you ever imagine that the freshest of fruits and vegetables, top quality pulses and food grains, dairy products and hundreds of branded items could be handpicked and delivered to your home, all at the click of a button? Neemuch’s first comprehensive online mega store, noveltyretail, brings a whopping 20000+ products with more than 1000 brands,  From household cleaning products to beauty and makeup, Noveltyretail has everything you need for your daily needs. Noveltyretail is convenience personified We’ve taken away all the stress associated with shopping for daily essentials, and you can now order all your household products and even buy groceries online without travelling long distances or standing in serpentine queues. Add to this the convenience of finding all your requirements at one single source, along with great savings, and you will realize that Noveltyretail- Neemuch\'s largest online supermarket, has revolutionized the way Neemuch shops for groceries. Online grocery shopping has never been easier. Need things fresh? Whether it’s fruits and vegetables or dairy and more online at your convenience. Hassle-free Home Delivery options\r\n\r\nSlotted Delivery: Pick the most convenient delivery slot to have your grocery delivered. From early morning delivery for early birds, to late-night delivery for people who work the late shift, Noveltyretail caters to every schedule\r\n\r\nthanks', 0, 0, '2019-12-12 15:24:37'),
(3, 'Terms of Use', 'terms-of-use', 'noveltyretail', 0, 0, '2019-12-12 15:35:55');

-- --------------------------------------------------------

--
-- Table structure for table `paypal`
--

CREATE TABLE `paypal` (
  `id` int(200) NOT NULL,
  `client_id` varchar(200) NOT NULL,
  `sb_id` varchar(200) NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `paypal`
--


-- --------------------------------------------------------

--
-- Table structure for table `pincode`
--

CREATE TABLE `pincode` (
  `pincode` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_arb_name` varchar(200) NOT NULL,
  `product_description` longtext NOT NULL,
  `product_arb_description` longtext NOT NULL,
  `product_image` varchar(200) NOT NULL,
  `category_id` int(11) NOT NULL,
  `in_stock` int(11) NOT NULL,
  `price` double NOT NULL,
  `mrp` int(200) NOT NULL,
  `unit_value` double NOT NULL,
  `unit` varchar(10) NOT NULL,
  `arb_unit` varchar(200) DEFAULT NULL,
  `increament` double NOT NULL,
  `rewards` varchar(200) NOT NULL DEFAULT '0',
  `tax` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_arb_name`, `product_description`, `product_arb_description`, `product_image`, `category_id`, `in_stock`, `price`, `mrp`, `unit_value`, `unit`, `arb_unit`, `increament`, `rewards`, `tax`) VALUES
(8, 'Ponds Body Lotion', '', 'Ponds Body Loation 300m.l.', '', 'images_(1).jpeg', 8, 1, 190.67, 250, 12, 'QTY', '', 0, '0', 34),
(9, 'Dove 3.4 out of 5 stars  706 Reviews Dove Intense Repair Shampoo, 650ml', '', 'Dove\r\n3.4 out of 5 stars  706 Reviews\r\nDove Intense Repair Shampoo, 650ml', '', '', 9, 1, 350, 450, 1, 'Nos', '', 0, '1', 0),
(10, 'Ponds Body Lotion 300m.l.', '', 'Ponds body lotion 300m.l.', '', 'images_(1)1.jpeg', 18, 1, 220, 250, 1, 'Pcs', '', 0, '0', 0),
(11, 'Vaseline Intensive Care Deep Restore Body Lotion, 400 ml', '', 'Vaseline Intensive Care Deep Restore Body Lotion, 400 ml', '', 'download-10.jpeg', 18, 1, 285, 285, 1, 'Pcs', '', 0, '0', 0),
(12, 'Joy Honey and Almonds Nourishing Body Lotion, 500ml', '', 'Joy Honey and Almonds Nourishing Body Lotion, 500ml\r\n\r\n\r\n', '', 'download-9.jpeg', 18, 1, 200, 252, 1, 'pcs', '', 0, '0', 0),
(13, 'Nivea Nourishing Body Milk with Deep Moisture Serum Almond Oil 400m.l.', '', 'Nivea Nourishing Body Milk with Deep Moisture Serum Almond Oil', '', 'download-8.jpeg', 18, 1, 300, 349, 1, 'pcs', '', 0, '0', 0),
(14, 'Red Label Tea 1kg', '', 'Red Label Tea 1kg', '', 'download-7.jpeg', 26, 1, 330, 390, 1, 'pcs', '', 0, '0', 0),
(15, 'Taj Mahel Tea 1kg', '', 'Taj Mahel Tea 1kg', '', 'download-5.jpeg', 26, 1, 445, 465, 1, 'pcs', '', 0, '0', 0),
(16, 'Nescafe classic 25g jar', '', 'Nescafe classic 25g jar', '', 'download-6.jpeg', 27, 1, 70, 75, 1, 'pcs', '', 0, '0', 0),
(17, 'Fair and Lovely 80g', '', 'Fair and Lovely 80g', '', 'download-1.jpeg', 19, 1, 140, 148, 1, 'pcs', '', 0, '0', 0),
(18, 'Himalayan Neem Facewash 50m.l.', '', '', '', 'download-12.jpeg', 19, 1, 55, 65, 1, 'pcs', '', 0, '0', 0),
(19, 'Patanjali Alovera Gel 50m.l.', '', '', '', 'download-13.jpeg', 19, 1, 40, 45, 1, 'pcs', '', 0, '0', 0),
(20, 'Harpic Liq 500m.l. 30% extra', '', 'Harpic toilet cleaner 30% extra\r\nMrp 86.00\r\nOffer price 80.00 6rs off', '', '40006902_13-harpic-power-plus-disinfectant-toilet-cleaner-rose.jpg', 29, 1, 80, 86, 1, 'pcs', '', 0, '0', 0),
(21, 'Harpic Bathroom Cleaner 200m.l.', '', '', '', '40017766_8-harpic-bathroom-cleaning-liquid-floral.jpg', 29, 1, 40, 44, 100, '', '', 0, '0', 0),
(22, 'Lizol Disinfectant Surface Cleaner - Citrus, 500 ml', '', 'Lizol Disinfectant Surface Cleaner - Citrus, 500 ml', '', '263839_10-lizol-disinfectant-surface-cleaner-citrus.jpg', 30, 1, 93, 87, 1, 'Pcs', '', 0, '0', 0),
(23, 'Dove hair fall rescue 340 ml', '', 'Dove hair fall rescue', '', '', 21, 1, 200, 215, 200, '', NULL, 0, '0', 0),
(24, 'Tata tea 1kg', '', 'Tata tea 1kg', '', 'download-23.jpeg', 26, 1, 190, 220, 1, 'Nos', '', 0, '0', 0),
(25, 'Lizol liquid 1ltr', '', 'Lizol 1tr', '', 'download-19.jpeg', 30, 1, 170, 179, 1, 'Pcs', '', 0, '0', 0),
(26, 'Kissan tomato ketchup 1ltr', '', 'Kissan tomato ketchup 1ltr', '', 'download-26.jpeg', 33, 1, 120, 130, 1, 'Nos', '', 0, '0', 0),
(27, 'Kissan tomato ketchup 500m.l.', '', 'Kissan tomato ketchup 500m.l.', '', 'download-24.jpeg', 33, 1, 44, 50, 1, 'Nos', '', 0, '0', 0),
(28, 'Kissan tomato ketchup pouch rs 15/-', '', 'Kissan tomato ketchup pouch 15/-', '', 'download-25.jpeg', 33, 1, 13, 15, 1, 'Nos', '', 0, '0', 0),
(29, 'Maggi tomato ketchup 1ltr Bottle', '', 'Maggi tomato ketchup 1ltr Bottle\r\nFree maggi noddle rs 45/-\r\n27 rs off on mrp', '', 'download-22.jpeg', 33, 1, 125, 147, 1, 'pcs', '', 0, '0', 0),
(30, 'Surf xl 1kg', '', 'Surf xl easy wash 1kg', '', 'download-32.jpeg', 34, 1, 100, 110, 1, 'Nos', '', 0, '0', 0),
(31, 'Surf xl Quick wash 1kg', '', 'Surf xl Quick wash 1kg', '', 'download-36.jpeg', 34, 1, 170, 180, 1, 'Nos', '', 0, '0', 0),
(32, 'Wheel washing powder 1kg', '', '3rs off', '', 'images-8.jpeg', 34, 1, 49, 53, 1, 'Nos', '', 0, '0', 0),
(33, 'Maggi noodle', '', 'Buy maggi noodle And get 1maagi noodle 70g free', '', 'download-21.jpeg', 32, 1, 65, 67, 1, 'Nos', NULL, 0, '0', 0),
(34, 'Tide washing powder', '', '', '', 'download-38.jpeg', 34, 1, 100, 108, 1, 'Pcs', '', 0, '0', 0),
(35, 'Horlicks chocolate 500g', '', '', '', 'download-30.jpeg', 35, 1, 200, 219, 1, 'Jar ', '', 0, '0', 0),
(36, 'Allout liquid 45Nights', '', 'Allout liquid 45 Nights \r\nMrp.75.00\r\nOffer price 65.00', '', 'images-10.jpeg', 58, 1, 65, 75, 1, 'Nos', '', 0, '0', 0),
(37, 'Clinic Plus hair shampoo 340 ml', '', 'Clinic Plus shampoo 340 ml\r\nMRP 150', '', '100090784_8-clinic-plus-strong-long-health-shampoo.jpg', 21, 1, 135, 150, 1, 'Pcs', '', 0, '0', 0),
(38, 'Clinic Plus hair shampoo 680 ml', '', 'Clinic Plus ad shampoo 680 ml pump', '', 'shopping-5.jpeg', 21, 1, 300, 385, 1, 'Pcs', NULL, 0, '0', 0),
(39, 'Nihar Naturals Shanti Badam Amla Hair Oil 500m.l.', '', 'Nihar Naturals Shanti Badam Amla Hair Oil', '', 'shopping-13.jpeg', 20, 1, 145, 155, 1, 'Pcs', '', 0, '0', 0),
(40, 'Nihar Naturals Shanti Badam Amla Hair Oil 300m.l.', '', 'Nihar Naturals Shanti Badam Amla Hair Oil 300m.l.', '', 'shopping-131.jpeg', 20, 1, 90, 99, 1, 'Pcs', '', 0, '0', 0),
(41, 'Nihar Naturals Shanti Badam Amla Hair Oil 140m.l.', '', 'Nihar Naturals Shanti Badam Amla Hair Oil 140m.l.', '', 'shopping-132.jpeg', 20, 1, 40, 44, 1, 'Pcs', '', 0, '0', 0),
(42, 'Nihar Naturals Shanti Badam Amla Hair Oil 80m.l.', '', 'Nihar Naturals Shanti Badam Amla Hair Oil 80m.l.', '', 'shopping-133.jpeg', 20, 1, 18, 20, 1, 'Pcs', '', 0, '0', 0),
(43, 'Nihar Naturals Shanti Badam Amla Hair Oil 34m.l.', '', 'Nihar Naturals Shanti Badam Amla Hair Oil 34m.l.', '', 'shopping-134.jpeg', 20, 1, 8.5, 10, 1, 'Pcs', NULL, 0, '0', 0),
(44, 'Clinic Plus hair oil 200m.l.', '', 'Clinic plus hair oil 200m.l.', '', 'shopping-11.jpeg', 20, 1, 82, 92, 1, 'Pcs', NULL, 0, '0', 0),
(45, 'Bajaj Almomd Drops Hair oil 500m.l.', '', 'Bajaj Almond Drops Hair oil 500m.l.', '', 'shopping-7.jpeg', 20, 1, 250, 280, 1, 'Pcs', NULL, 0, '0', 0),
(46, 'Bajaj Almomd Drops Hair oil 300m.l.', '', 'Bajaj Almond Drops hair oil 300m.l.', '', 'shopping-71.jpeg', 20, 1, 160, 175, 1, 'Pcs', NULL, 0, '0', 0),
(47, 'Bajaj Almomd Drops Hair oil 100m.l.', '', 'Bajaj Almond Drops Hair oil 100m.l.', '', 'shopping-72.jpeg', 20, 1, 60, 65, 1, 'Pcs', NULL, 0, '0', 0),
(48, 'Bajaj Almomd Drops Hair oil 50m.l.', '', 'Bajaj Almond Drops Hair oil 50m.l.', '', 'shopping-73.jpeg', 20, 1, 32, 35, 1, 'Pcs', NULL, 0, '0', 0),
(49, 'Hair & Care Fruit Oils Green 50m.l.', '', 'Hair & Care Fruit Oils Green 50m.l.', '', 'shopping-6.jpeg', 20, 1, 28.5, 32, 1, 'Pcs', NULL, 0, '0', 0),
(50, 'Hair & Care Fruit Oils Green 100m.l.', '', 'Hair & Care Fruit Oils Green 100m.l.', '', 'shopping-61.jpeg', 20, 1, 54, 60, 1, 'Pcs', NULL, 0, '0', 0),
(51, 'Kesh King Ayurvedic Scalp And Medicinal Hair Oil 120m.l.', '', 'Kesh King Ayurvedic Scalp And Medicinal Hair Oil 120m.l.', '', 'shopping-8.jpeg', 20, 1, 144, 160, 1, 'Pcs', NULL, 0, '0', 0),
(52, 'Sesa Hair oil 100m.l.', '', 'Sesa hair oil 100m.l.', '', 'shopping-9.jpeg', 20, 1, 120, 140, 1, 'Pcs', NULL, 0, '0', 0),
(53, 'Parachut coconut oil 200m.l.', '', 'Parachute coconut oil 200m.l.', '', 'download-55.jpeg', 20, 1, 79, 85, 1, 'Pcs', NULL, 0, '0', 0),
(54, 'Patanjali Dant Kanti Toothpaste 200g', '', 'Patanjali Dant Kanti Toothpaste 200g', '', 'images-22.jpeg', 39, 1, 70, 75, 1, 'Pcs', NULL, 0, '0', 0),
(55, 'Patanjali Dant Kanti Toothpaste 300g', '', 'Patanjali Dant Kanti Toothpaste 300g', '', 'download-56.jpeg', 39, 1, 100, 112, 1, 'Pcs', NULL, 0, '0', 0),
(56, 'Patanjali Dant Kanti Toothpaste 100g', '', 'Patanjali Dant Kanti Toothpaste 100g \r\nFree 1pcs Keshkanti shampoo 3/-', '', 'images-221.jpeg', 39, 1, 38, 42, 1, 'Pcs', NULL, 0, '0', 0),
(57, 'Sunsilk Coconut Water & Aloe Vera Shampoo, 195 ml', '', 'Sunsilk Coconut Water & Aloe Vera Shampoo, 195 ml\r\n', '', 'shopping-15.jpeg', 21, 1, 85, 95, 1, 'Pcs', NULL, 0, '0', 0),
(58, 'Sunsilk Stunning Black Shine Shampoo, 650ml', '', 'Sunsilk Stunning Black Shine Shampoo, 650ml\r\n\r\n', '', 'download-66.jpeg', 21, 1, 315, 415, 1, 'Pcs', NULL, 0, '0', 0),
(59, 'Dove Hair Fall Rescue Shampoo, 650ml', '', '\r\nDove Hair Fall Rescue Shampoo, 650ml', '', 'download-68.jpeg', 21, 1, 350, 450, 1, 'Pcs', NULL, 0, '0', 0),
(60, 'Dove Intense Repair Shampoo, 650ml', '', 'Dove Intense Repair Shampoo, 650ml', '', 'shopping-16.jpeg', 21, 1, 450, 450, 1, 'Pcs', NULL, 0, '0', 0),
(62, 'Clinic Plus hair shampoo 180m.l.', '', 'Clinic Plus Strong and Long Health Shampoo, 180ml\r\n\r\n', '', '100090784_8-clinic-plus-strong-long-health-shampoo1.jpg', 21, 1, 70, 75, 1, 'Pcs', '', 0, '0', 0),
(63, 'Indulekha Bringha Anti Hair Fall Hair Cleanser Shampoo 180m.l.', '', 'Indulekha Bringha Anti Hair Fall Hair Cleanser Shampoo', '', 'download-71.jpeg', 21, 1, 0, 234, 1, 'Pcs', NULL, 0, '0', 0),
(64, 'Colgate strong toothpaste 100g', '', 'Colgate strong toothpaste 100g', '', 'shopping-31.jpeg', 39, 1, 46, 50, 1, 'Pcs', NULL, 0, '0', 0),
(65, 'Colgate strong toothpaste 50g', '', 'Colgate strong toothpaste 50g', '', 'shopping-311.jpeg', 39, 1, 20, 20, 1, 'Pcs', NULL, 0, '0', 0),
(66, 'Colgate strong toothpaste 300g', '', 'Colgate strong toothpaste 300g', '', 'download.png', 39, 1, 132, 142, 1, 'Pcs', NULL, 0, '0', 0),
(67, 'Closeup Ever Fresh Red Hot Toothpaste, 80g', '', 'Closeup Ever Fresh Red Hot Toothpaste, 80g\r\n', '', 'download-95.jpeg', 39, 1, 37, 40, 1, 'Pcs', NULL, 0, '0', 0),
(68, 'Closeup Ever Fresh Red Hot Toothpaste, 300g', '', 'Closeup Ever Fresh Red Hot Toothpaste, 80g\r\n\r\n\r\n', '', 'download-96.jpeg', 39, 1, 76, 82, 1, 'Pcs', NULL, 0, '0', 0),
(69, 'Closeup Ever Fresh Red Hot Toothpaste, 300g', '', 'Closeup Ever Fresh Red Hot Toothpaste, 300g', '', 'images-30.jpeg', 39, 1, 144, 144, 1, 'Pcs', NULL, 0, '0', 0),
(70, 'Allout liquid 45Nights twin pack', '', 'Allout liquid 45 n3 twin pack', '', 'images-9.jpeg', 58, 1, 140, 140, 1, 'Pcs', '', 0, '0', 0),
(71, 'Pepsodent Germicheck Plus 2 in 1 Toothpaste 150g', '', 'Pepsodent Germicheck Plus 2 in 1 Toothpaste', '', 'download-97.jpeg', 39, 1, 82, 92, 1, '', NULL, 0, '0', 0),
(72, 'Vicco Vajradanti Paste-100g', '', 'Vicco Vajradanti Paste-100g\r\n', '', 'shopping-33.jpeg', 39, 1, 60, 65, 1, 'Pcs', '', 0, '0', 0),
(73, 'Colgate maxfresh  RED 150g', '', 'Colgate Max Fresh with Cooling Crystals Red Gel Toothpaste - Spicy Fresh 150 gm', '', 'download-98.jpeg', 39, 1, 82, 92, 1, 'Pcs', NULL, 0, '0', 0),
(74, 'Colgate maxfresh  BLUE 150g', '', 'Colgate Max Fresh with Cooling Crystals Blue Gel Toothpaste - Peppermint Ice 150 gm', '', 'colgate-max-fresh-with-cooling-crystals-peppermint-ice-blue-gel-toothpaste-150gm-12891905.jpg', 39, 1, 82, 92, 1, 'Pcs', NULL, 0, '0', 0),
(75, 'Colgate cibaca toothpaste 175g', '', 'Colgate cibaca toothpaste 175g', '', 'download-100.jpeg', 39, 1, 50, 55, 1, 'Pcs', NULL, 0, '0', 0),
(76, 'Clinic all clear hair oil 150m.l.', '', 'Clinic all clear hair oil ', '', 'download-101.jpeg', 20, 1, 100, 105, 1, 'Pcs', NULL, 0, '0', 0),
(77, 'Indulekha Bringha hair oil 100m.l.', '', 'Indulekha Bringha hair oil 100m.l.', '', 'shopping-34.jpeg', 20, 1, 432, 350, 1, 'Pcs', '', 0, '0', 0),
(78, 'Livion hair serum', '', 'Livion hair serum', '', 'download-103.jpeg', 20, 1, 55, 60, 1, 'Pcs', NULL, 0, '0', 0),
(79, 'Vaseline petroleum jelly 85g', '', 'Vaseline petroleum jelly 85g', '', 'download-104.jpeg', 18, 1, 120, 110, 1, 'Pcs', '', 0, '0', 0),
(80, 'Ponds Body Lotion 100m.l.', '', 'Pounds Body Lotion 100m.l.', '', 'images_(1)2.jpeg', 18, 1, 83, 89, 1, 'Pcs', NULL, 0, '0', 0),
(81, 'Vaseline Intensive Care Deep Restore Body Lotion, 100 ml', '', '', '', 'download-105.jpeg', 18, 1, 70, 75, 1, 'Pcs', NULL, 0, '0', 0),
(82, 'Vaseline Intensive Care Revitalizing Green Tea Body Lotion - 100 ml', '', 'Vaseline Intensive Care Revitalizing Green Tea Body Lotion - 100 ml', '', 'shopping-35.jpeg', 18, 1, 90, 95, 1, 'Pcs', NULL, 0, '0', 0),
(83, 'Nivea Men Roll On Deodorant - Fresh Active 25 ml', '', 'Nivea Men Roll On Deodorant - Fresh Active 25 ml', '', 'shopping-36.jpeg', 42, 1, 75, 90, 1, 'Pcs', NULL, 0, '0', 0),
(84, 'Lakme 9 To 5 Complexion Care Cream Bronze 9 gm', '', 'Lakme 9 To 5 Complexion Care Cream Bronze 9 gm', '', 'images-31.jpeg', 19, 1, 90, 99, 1, 'Pcs', NULL, 0, '0', 0),
(85, 'Fair & Lovely Bb Face Cream 9 Gm', '', 'Fair & Lovely Bb Face Cream 9 Gm', '', 'download-107.jpeg', 19, 1, 44, 49, 1, 'Pcs', NULL, 0, '0', 0),
(86, 'White Tone Soft & Smooth Face Cream', '', 'White Tone Soft & Smooth Face Cream', '', 'download-108.jpeg', 19, 1, 68, 75, 1, 'Pcs', NULL, 0, '0', 0),
(87, 'White Tone Face Powder', '', 'White Tone Face Powder', '', 'download-109.jpeg', 19, 1, 50, 55, 1, 'Pcs', NULL, 0, '0', 0),
(88, 'White Tone Face Powder 70g', '', 'White tone powder 70g', '', 'download-1091.jpeg', 19, 1, 110, 125, 1, 'Pcs', NULL, 0, '0', 0),
(89, 'Fair and Lovely 50g', '', 'Fair and Lovely cream 50g', '', 'images-33.jpeg', 19, 1, 90, 98, 1, 'Pcs', NULL, 0, '0', 0),
(90, 'Fair and Lovely 25g', '', 'Fair and Lovely cream 25g', '', 'images-331.jpeg', 19, 1, 47, 52, 1, 'Pcs', NULL, 0, '0', 0),
(91, 'Vaseline petroleum jelly 50g', '', 'Vaseline petroleum jelly 50g', '', 'download-1041.jpeg', 18, 1, 66, 72, 1, 'Pcs', NULL, 0, '0', 0),
(92, 'Vaseline petroleum jelly 25g', '', 'Vaseline petroleum jelly 25g', '', 'download-1042.jpeg', 18, 1, 38, 42, 1, 'Pcs', NULL, 0, '0', 0),
(93, 'Blue chip white petroleum jelly 55g', '', 'Blue chip white petroleum jelly', '', 'download-110.jpeg', 18, 1, 25, 45, 1, 'Pcs', NULL, 0, '0', 0),
(94, 'Blue chip white petroleum jelly 110g', '', 'Blue chip white petroleum jelly', '', 'download-1101.jpeg', 18, 1, 45, 72, 1, 'Pcs', NULL, 0, '0', 0),
(95, 'Blue chip white petroleum jelly 220g', '', 'Blue chip white petroleum jelly', '', 'download-1102.jpeg', 18, 1, 80, 120, 1, 'Pcs', NULL, 0, '0', 0),
(96, 'Emami Fair and Handsome 25g', '', 'Emami Fair and Handsome', '', 'download-83.jpeg', 19, 1, 70, 75, 1, 'Pcs', NULL, 0, '0', 0),
(97, 'Emami Fair and Handsome 15g', '', 'Emami Fair and Handsome', '', 'download-831.jpeg', 19, 1, 28, 30, 1, 'Pcs', NULL, 0, '0', 0),
(98, 'Boroplus Antiseptic Cream', '', 'Boroplus Antiseptic Cream', '', 'boroplus-antiseptic-cream-0.jpg', 19, 1, 35, 38, 1, 'Pcs', NULL, 0, '0', 0),
(99, 'Boroplus Antiseptic Cream 50g', '', 'Boroplus Antiseptic Cream', '', 'boroplus-antiseptic-cream-01.jpg', 19, 1, 65, 70, 1, 'Pcs', NULL, 0, '0', 0),
(100, 'Boroplus Antiseptic Cream 80m.l.', '', 'Boroplus Antiseptic Cream', '', 'boroplus-antiseptic-cream-02.jpg', 19, 1, 105, 115, 1, 'Pcs', NULL, 0, '0', 0),
(101, 'Tazza leaf tea 250g', '', 'Tazza leaf tea', '', 'download-111.jpeg', 26, 1, 50, 55, 1, 'Pcs', NULL, 0, '0', 0),
(103, 'Nescafé Classic Coffee, 50g Jar', '', 'Nescafé Classic Coffee, 50g Jar\r\n', '', 'download-112.jpeg', 27, 1, 140, 150, 1, 'Pcs', NULL, 0, '0', 0),
(104, 'Bournvita Health Drink, 500 g jar', '', 'Bournvita Health Drink, 500 g', '', 'download-28.jpeg', 35, 1, 200, 217, 1, 'Pcs', NULL, 0, '0', 0),
(105, 'Bournvita Health Drink, 200 g jar', '', 'Bournvita Health Drink, 200 g', '', 'download-281.jpeg', 35, 1, 99, 107, 1, 'Pcs', NULL, 0, '0', 0),
(106, 'Bournvita Health Drink, pouch 30/-', '', 'Bournvita Health Drink, 30/-', '', '', 35, 1, 26, 30, 1, 'Pcs', '', 0, '0', 0),
(107, 'Horlicks chocolate delight 100gm(75g+25g free)', '', 'Horlicks chocolate delight 100gm(75g+25g free)', '', '', 35, 1, 26, 30, 1, 'Pcs', '', 0, '0', 0),
(108, 'Boost Health, Energy and Sports Nutrition drink - 450 g Jar', '', 'Boost Health, Energy and Sports Nutrition drink - 450 g Jar\r\n', '', 'shopping-37.jpeg', 35, 1, 220, 230, 1, 'Pcs', NULL, 0, '0', 0),
(109, 'Stayfree Secure Regular 7S', '', 'Stayfree Secure Regular 7S', '', 'download-113.jpeg', 40, 1, 22, 25, 1, 'Pcs', NULL, 0, '0', 0),
(110, 'Stayfree Secure Regular 20S', '', 'Stayfree Secure Regular 20S', '', 'sta0042.jpg', 40, 1, 68, 74, 1, 'Pcs', NULL, 0, '0', 0),
(111, 'Stayfree Secure Wings Xl 20s', '', 'Stayfree Secure Wings Xl 20s', '', 'sta0561.jpg', 40, 1, 99, 108, 1, 'Pcs', NULL, 0, '0', 0),
(112, 'Stayfree Secure Cottony Wings Xl 6s', '', 'Stayfree Secure Cottony Wings Xl 6s', '', 'sta0046_2.jpg', 40, 1, 30, 34, 1, 'Pcs', NULL, 0, '0', 0),
(113, 'Stayfree All Night Pads 7S', '', 'Stayfree All Night Pads 7S', '', 'sta0083.jpg', 40, 1, 82, 88, 1, 'Pcs', NULL, 0, '0', 0),
(114, 'Stayfree Ultrathin Drymax Alnight Xl14s', '', 'Stayfree Ultrathin Drymax Alnight Xl14s', '', 'sta0519.jpg', 40, 1, 170, 175, 1, 'Pcs', NULL, 0, '0', 0),
(115, 'Whisper Choice Wings 7S', '', 'Whisper Choice Wings 7S', '', 'whi0009_1.jpg', 40, 1, 26, 29, 1, 'Pcs', NULL, 0, '0', 0),
(116, 'Whisper Choice Ultra Wings Xl 6s', '', 'Whisper Choice Ultra Wings Xl 6s', '', 'whi0208.jpg', 40, 1, 35, 39, 1, 'Pcs', NULL, 0, '0', 0),
(117, 'Whisper Ultra Clean Wings 7 Pads', '', 'Whisper Ultra Clean Wings 7Pads', '', 'whi0018.jpg', 40, 1, 78, 80, 1, 'Pcs', NULL, 0, '0', 0),
(118, 'Whisper Choice Ultra Wings Extra Large 20\'s', '', 'Whisper Choice Ultra Wings Extra Large 20\'s', '', 'whi0222.jpg', 40, 1, 113, 123, 1, 'Pcs', NULL, 0, '0', 0),
(119, 'Charry shoe polish 40g', '', 'Charry shoe polish BLACK', '', 'download-114.jpeg', 45, 1, 55, 59, 1, 'Pcs', NULL, 0, '0', 0),
(120, 'Charry liquid polish 75m.l.', '', 'Charry liquid polish BLACK', '', 'download-115.jpeg', 45, 1, 80, 85, 1, 'Pcs', NULL, 0, '0', 0),
(121, 'Pears Pure and Gentle Soap Bar, 125 g (Pack of 3)', '', 'Pears Pure and Gentle Soap Bar, 125 g (Pack of 3)\r\n', '', 'download-116.jpeg', 24, 1, 164, 164, 1, 'Pcs', NULL, 0, '0', 0),
(122, 'Lux  velvet touch soap', '', 'Lux velvet touch soap 4+1x100g,', '', 'shopping-38.jpeg', 24, 1, 95, 99, 1, 'Pcs', NULL, 0, '0', 0),
(123, 'Lux soft touch soap', '', 'Lux soft touch 4+1x1', '', 'shopping-41.jpeg', 24, 1, 83, 99, 1, 'Pcs', NULL, 0, '0', 0),
(124, 'Dove Soap 100Gm X 3S Pack', '', 'Dove Soap 100Gm X 3S Pack', '', 'shopping-42.jpeg', 24, 1, 172, 172, 1, 'Pcs', NULL, 0, '0', 0),
(125, 'Dove Soap 75Gm X 3S+1Pack', '', 'Dove Soap 75Gm X 3S+1 Pack', '', 'images-34.jpeg', 24, 1, 113, 123, 1, 'Pcs', NULL, 0, '0', 0),
(126, 'Pears Pure and Gentle Soap Bar, 125 g (Pack of 3)', '', 'Pears Pure and Gentle Soap Bar, 125 g (Pack of 3)\r\n', '', 'images-16.jpeg', 24, 1, 164, 164, 1, 'Pcs', NULL, 0, '0', 0),
(127, 'LUX International Creamy Perfection Soap 125g', '', 'LUX International Creamy Perfection Soap ', '', 'download-117.jpeg', 24, 1, 46, 51, 1, 'Pcs', NULL, 0, '0', 0),
(128, 'Liril Lemon and Tea Tree Oil Soap, 75g (Buy 4 Get 1 Free)', '', 'Liril Lemon and Tea Tree Oil Soap, 75g (Buy 4 Get 1 Free)\r\n', '', 'download-118.jpeg', 24, 1, 132, 132, 1, 'Pcs', NULL, 0, '0', 0),
(129, 'Lifebuoy Total 10 Germ Protection Soap Bar 125 gmx4', '', 'Lifebuoy Total 10 Germ Protection Soap Bar 125 gmx4', '', 'download-119.jpeg', 24, 1, 75, 75, 1, 'Pcs', NULL, 0, '0', 0),
(130, 'Medimix Classic Pack (125g,Classic) - Set of 3', '', 'Medimix Classic Pack (125g,Classic) - Set of 3', '', 'shopping-43.jpeg', 24, 1, 95, 105, 1, 'Pcs', NULL, 0, '0', 0),
(131, 'Zandu Balm 8m.l.', '', 'Zandu Balm', '', 'images-35.jpeg', 48, 1, 33, 36, 1, 'Pcs', '', 0, '0', 0),
(132, 'Iodex 10g', '', 'Iodex 10g', '', 'iod0001_1.jpg', 48, 1, 33, 36, 1, 'Pcs', '', 0, '0', 0),
(133, 'Vicks Inhaler 0.5Ml', '', 'Vicks Inhaler 0.5Ml', '', 'vic0020.jpg', 48, 1, 40, 50, 1, 'Pcs', '', 0, '0', 0),
(134, 'Vicks Vaporub 25G', '', 'Vicks Vaporub 25G', '', 'vic0024.jpg', 48, 1, 65, 75, 1, 'Pcs', '', 0, '0', 0),
(135, 'Eno Powder Lemon (6pcs)', '', 'Eno Powder Lemon (6pcs)', '', 'eno-powder-lemon-0.jpg', 49, 1, 45, 48, 1, 'Pcs ', NULL, 0, '0', 0),
(136, 'Dettol Liquid Handwash - 175 ml (Original, Buy 2 Get 1 Free', '', 'Dettol Liquid Handwash - 175 ml (Original, Buy 2 Get 1 Free', '', 'download-121.jpeg', 52, 1, 124, 134, 1, 'Pcs ', NULL, 0, '0', 0),
(137, 'Dettol Original Liquid Soap Refill - 750 ml', '', 'Dettol Original Liquid Soap Refill - 750 ml', '', 'download-1211.jpeg', 52, 1, 100, 109, 1, 'Pcs ', NULL, 0, '0', 0),
(138, 'Dettol Original Liquid Handwash', '', 'Dettol Original Liquid Handwash', '', 'download-124.jpeg', 52, 1, 90, 99, 1, 'Pcs ', NULL, 0, '0', 0),
(139, 'Lifebuoy Cool Fresh Menthol Hand Wash - 750 ml', '', 'Lifebuoy Cool Fresh Menthol Hand Wash - 750 ml', '', 'download-125.jpeg', 52, 1, 150, 175, 1, 'Pcs ', NULL, 0, '0', 0),
(140, 'Lifebuoy Mild Care Milk Cream Hand Wash, 750 ml', '', 'Lifebuoy Mild Care Milk Cream Hand Wash, 750 ml\r\n\r\n', '', 'shopping-45.jpeg', 52, 1, 150, 175, 1, 'Pcs', NULL, 0, '0', 0),
(141, 'Sanifresh Ultrashine 1L (500 + 500) Toilet Cleaner -1.5X Extra Strong Extra Clean with Odonil Room Freshner Blocks 50 g Free', '', 'Sanifresh Ultrashine 1L (500 + 500) Toilet Cleaner -1.5X Extra Strong Extra Clean with Odonil Room Freshner Blocks 50 g Free\r\n', '', 'images-37.jpeg', 29, 1, 140, 154, 1, 'Pcs ', NULL, 0, '0', 0),
(142, 'AXE Denim Lather Shaving Cream, 60 g (with 30% Extra)', '', 'AXE Denim Lather Shaving Cream, 60 g (with 30% Extra)\r\n', '', 'download-127.jpeg', 41, 1, 55, 65, 1, 'Pcs', '', 0, '0', 0),
(143, 'Godrej Shaving Cream - Sensitive,', '', 'Godrej Shaving Cream - Sensitive,', '', 'download-128.jpeg', 41, 1, 55, 59, 1, 'Pcs', NULL, 0, '0', 0),
(144, 'Vi John Classic Shaving Cream with Bacti-Guard', '', 'Vi John Classic Shaving Cream with Bacti-Guard ', '', 'download-129.jpeg', 41, 1, 37, 47, 1, 'Pcs ', NULL, 0, '0', 0),
(145, 'Vaseline Intensive Care Aloe Fresh Body Gel', '', 'Vaseline Intensive Care Aloe Fresh Body Gel', '', 'download-130.jpeg', 19, 1, 90, 95, 1, 'Pcs ', NULL, 0, '0', 0),
(146, 'Gallent II Razor', '', 'Gallent II Razor', '', 'images1.png', 41, 1, 40, 45, 1, 'Pcs ', NULL, 0, '0', 0),
(147, 'Supermax III Razor', '', 'Supermax III Razor', '', 'images-40.jpeg', 41, 1, 65, 75, 1, 'Pcs ', NULL, 0, '0', 0),
(148, 'Gillette Gaurd Razor', '', 'Gillette Gaurd Razor', '', 'download-131.jpeg', 41, 1, 20, 23, 1, 'Pcs ', NULL, 0, '0', 0),
(149, 'Gillette Guard Blade 1pcs', '', 'Gillette Guard Blade 1pcs', '', 'images-41.jpeg', 41, 1, 8.5, 10, 1, 'Pcs', NULL, 0, '0', 0),
(150, 'Gillette Guard Blade 5pcs', '', 'Gillette Guard Blade ', '', 'download-132.jpeg', 41, 1, 45, 50, 1, 'Pcs ', NULL, 0, '0', 0),
(151, 'Godrej No.1 Lime & Aloe Vera Soap (Buy 3 Get 1 Free) (Promo Pack)', '', 'Godrej No.1 Lime & Aloe Vera Soap (Buy 3 Get 1 Free) (Promo Pack)', '', 'images-45.jpeg', 24, 1, 62, 68, 1, 'Pcs ', NULL, 0, '0', 0),
(152, 'Godrej No.1 Sandal & Turmeric Soap (Buy 3 Get 1 Free) (Promo Pack)', '', 'Godrej No.1 Sandal & Turmeric Soap (Buy 3 Get 1 Free) (Promo Pack)', '', 'images-43.jpeg', 24, 1, 62, 68, 1, 'Pcs', NULL, 0, '0', 0),
(153, 'Dettol Soap - Original set 125g 4x1', '', 'Dettol Soap - Original', '', 'images-46.jpeg', 24, 1, 165, 176, 1, 'Pcs', NULL, 0, '0', 0),
(154, 'Garnier Color Naturals Creme Hair Color - 1 Natural Black', '', 'Garnier Color Naturals Creme Hair Color - 1 Natural Black', '', '', 25, 1, 140, 149, 1, 'Pcs', '', 0, '0', 0),
(155, 'Garnier Black Naturals Oil Enriched Cream Hair Colour - 3.16 Natural Burgandy', '', 'Garnier Black Naturals Oil Enriched Cream Hair Colour - 3.16 Natural Burgandy', '', 'shopping-50.jpeg', 25, 1, 34, 37, 1, 'Pcs ', '', 0, '0', 0),
(156, 'Garnier Black Naturals Oil Enriched Cream Hair Colour - 2.0 Original Black', '', 'Garnier Black Naturals Oil Enriched Cream Hair Colour - 2.0 Original Black', '', 'images-48.jpeg', 25, 1, 34, 37, 1, 'Pcs', '', 0, '0', 0),
(157, 'Garnier Black Naturals Oil Enriched Cream Hair Colour - 1.0 Deep Black', '', 'Garnier Black Naturals Oil Enriched Cream Hair Colour - 1.0 Deep Black', '', 'download-136.jpeg', 25, 1, 34, 38, 1, 'Pcs ', NULL, 0, '0', 0),
(158, 'Garnier Black Naturals Oil Enriched Cream Hair Colour - 3.0 Brown Black', '', 'Garnier Black Naturals Oil Enriched Cream Hair Colour - 3.0 Brown Black', '', 'download-137.jpeg', 25, 1, 34, 37, 1, 'Pcs ', NULL, 0, '0', 0),
(159, 'Godrej Expert Rich Crème Hair Colour - Dark Brown', '', 'Godrej Expert Rich Crème Hair Colour - Dark Brown', '', 'download-138.jpeg', 25, 1, 26, 30, 1, 'Pcs', NULL, 0, '0', 0),
(160, 'Godrej Expert Rich Crème Hair Colour - Natural Brown', '', 'Godrej Expert Rich Crème Hair Colour - Natural Brown', '', 'download-139.jpeg', 25, 1, 26, 30, 1, 'Pcs ', '', 0, '0', 0),
(161, 'Godrej Expert Rich Crème, hair color Black', '', 'Godrej Expert Rich Crème, Black ', '', 'download-141.jpeg', 25, 1, 26, 30, 1, 'P', '', 0, '0', 0),
(162, 'Godrej Rich Creme Hair Colour - Burgundy', '', 'Godrej Rich Creme Hair Colour - Burgundy ', '', 'download-142.jpeg', 25, 1, 26, 30, 1, 'Pcs ', NULL, 0, '0', 0),
(163, 'Godrej Expert Original - Natural Black', '', 'Godrej Expert Original - Natural Black ', '', 'shopping-53.jpeg', 25, 1, 17, 18, 1, 'Pcs ', NULL, 0, '0', 0),
(164, 'Indica 10 Minutes 2 In 1 Herbal Hair Colour, Natural Black,', '', 'Indica 10 Minutes 2 In 1 Herbal Hair Colour, Natural Black,', '', 'download-143.jpeg', 25, 1, 17, 18, 1, 'Pcs ', NULL, 0, '0', 0),
(165, 'Streax Insta Shampoo Hair Colour - Natural Black 1', '', 'Streax Insta Shampoo Hair Colour - Natural Black 1', '', 'download-144.jpeg', 25, 1, 18, 28, 1, 'Pcs', NULL, 0, '0', 0),
(166, 'Streax Insta Shampoo Hair Colour - Dark Brown 3', '', 'Streax Insta Shampoo Hair Colour - Dark Brown 3', '', 'download-145.jpeg', 25, 1, 18, 20, 1, 'Pcs ', '', 0, '0', 0),
(167, 'Streax Insta Shampoo Hair Colour - Natural Brown 4', '', 'Streax Insta Shampoo Hair Colour - Natural Brown 4', '', 'download-147.jpeg', 25, 1, 18, 20, 1, 'Pcs ', '', 0, '0', 0),
(168, 'Garnier Color Naturals Men and Women- 3.16 Burgundy', '', 'Garnier Color Naturals Men and Women- 3.16 Burgundy\r\n', '', 'shopping-54.jpeg', 25, 1, 60, 65, 1, 'Pcs ', NULL, 0, '0', 0),
(169, 'Garnier Color Naturals Unidose - Darkest Brown', '', 'Garnier Color Naturals Unidose - Darkest Brown', '', 'shopping-55.jpeg', 25, 1, 75, 80, 1, 'Pcs ', '', 0, '0', 0),
(170, 'Colgate Strong Teeth Anticavity Toothpaste With Amino Shakti, 200 g Pack of 2 With 100gm Free', '', 'Colgate Strong Teeth Anticavity Toothpaste With Amino Shakti, 200 g Pack of 2 With 100gm Free', '', '40057731_11-colgate-strong-teeth-anticavity-toothpaste-with-amino-shakti.jpg', 39, 1, 174, 184, 1, 'Pcs', NULL, 0, '0', 0),
(171, 'Lizol Disinfectant Surface Cleaner - Floral, 500 ml', '', 'Lizol Disinfectant Surface Cleaner - Floral, 500 ml', '', '263836_10-lizol-disinfectant-surface-cleaner-floral.jpg', 30, 1, 87, 93, 1, 'Pcs', NULL, 0, '0', 0),
(172, 'Surf xl Quick wash 500g', '', 'Surf xl Quick wash 500g', '', 'download-148.jpeg', 34, 1, 87, 90, 1, 'Pcs', NULL, 0, '0', 0),
(173, 'Surf Excel Easy Wash Detergent Powder, 4 kg', '', 'Surf Excel Easy Wash Detergent Powder, 4 kg', '', '215595_16-surf-excel-easy-wash-detergent-powder.jpg', 34, 1, 450, 480, 1, 'Pcs', NULL, 0, '0', 0),
(174, 'Surf Excel Easy Wash Detergent Powder, 500g', '', 'Surf Excel Easy Wash Detergent Powder, 500g', '', 'download-321.jpeg', 34, 1, 52, 55, 1, 'Pcs', NULL, 0, '0', 0),
(175, 'Rin Detergent Powder, 1 kg', '', 'Rin Detergent Powder, 1 kg', '', '266942_9-rin-detergent-powder.jpg', 34, 1, 71, 77, 1, 'Pcs ', NULL, 0, '0', 0),
(176, 'Ariel Detergent 500g', '', 'Ariel Detergent 500g', '', '40177925_2-ariel-complete-detergent-washing-powder-value-pack.jpg', 34, 1, 130, 135, 1, 'Pcs ', NULL, 0, '0', 0),
(177, 'Ariel Detergent Powder - Colour & Style 1kg', '', 'Ariel Detergent Powder - Colour & Style 1kg', '', '40177925_2-ariel-complete-detergent-washing-powder-value-pack1.jpg', 34, 1, 260, 270, 1, 'Pcs', NULL, 0, '0', 0),
(178, 'Ghari Detergent Powder, 1Kg', '', 'Ghari Detergent Powder, 1Kg\r\n', '', 'images-50.jpeg', 34, 1, 52, 55, 1, 'Pcs ', NULL, 0, '0', 0),
(179, 'Ghari Detergent Powder, 3Kg', '', 'Ghari Detergent Powder, 3Kg\r\n', '', 'images-501.jpeg', 34, 1, 155, 162, 1, 'Pcs', NULL, 0, '0', 0),
(180, 'Ghari Detergent Powder, 500g', '', 'Ghari Detergent Powder, 500g\r\n', '', 'images-502.jpeg', 34, 1, 27, 28, 1, 'Pcs', NULL, 0, '0', 0),
(181, 'Joy Skin Fruits Fruit Moisturizing Skin Cream, 200 ml', '', 'Joy Skin Fruits Fruit Moisturizing Skin Cream, 200 ml', '', 'shopping-56.jpeg', 19, 1, 135, 148, 1, 'Pcs', NULL, 0, '0', 0),
(182, 'Joy Skin Fruits Fruit Moisturizing Skin Cream, 50 ml', '', 'Joy Skin Fruits Fruit Moisturizing Skin Cream, 50 ml', '', 'shopping-57.jpeg', 19, 1, 48, 53, 1, 'Pcs', NULL, 0, '0', 0),
(183, 'Nivea Creme - All Season Multi-Purpose Cream 200m.l.', '', 'Nivea Creme - All Season Multi-Purpose Cream m.l.', '', '263875_4-nivea-creme-all-season-multi-purpose-cream.jpg', 19, 1, 240, 280, 1, 'Pcs', '', 0, '0', 0),
(184, 'Nivea Creme - All Season Multi-Purpose Cream 100m.l.', '', 'Nivea Creme - All Season Multi-Purpose Cream 100m.l.', '', '263875_4-nivea-creme-all-season-multi-purpose-cream1.jpg', 19, 1, 130, 149, 1, 'Pcs', NULL, 0, '0', 0),
(185, 'Nivea Creme - All Season Multi-Purpose Cream 60m.l.', '', 'Nivea Creme - All Season Multi-Purpose Cream', '', '263875_4-nivea-creme-all-season-multi-purpose-cream2.jpg', 19, 1, 85, 99, 1, 'Pcs', NULL, 0, '0', 0),
(186, 'Nivea Creme - All Season Multi-Purpose Cream 30m.l.', '', 'Nivea Creme - All Season Multi-Purpose Cream', '', '263875_4-nivea-creme-all-season-multi-purpose-cream3.jpg', 19, 1, 44, 49, 1, 'Pcs ', NULL, 0, '0', 0),
(187, 'Nivea Soft - Light Moisturiser With Vitamin 300m.l.', '', 'Nivea Soft - Light Moisturiser With Vitamin 300m.l.', '', 'download-149.jpeg', 19, 1, 300, 349, 1, 'Pcs', NULL, 0, '0', 0),
(188, 'Nivea Soft - Light Moisturiser With Vitamin 100m.l.', '', 'Nivea Soft - Light Moisturiser With Vitamin 100m.l.', '', 'download-1491.jpeg', 19, 1, 135, 160, 1, 'Pcs ', NULL, 0, '0', 0),
(189, 'Nivea Soft - Light Moisturiser With Vitamin 200m.l.', '', 'Nivea Soft - Light Moisturiser With Vitamin 200m.l.', '', 'download-1492.jpeg', 19, 1, 240, 270, 1, 'Pcs ', NULL, 0, '0', 0),
(190, 'Rexona Underarm Odour Protection Roll On - Powder Dry, 25 ml', '', '\r\nRexona Underarm Odour Protection Roll On - Powder Dry, 25 ml', '', '40063883_3-rexona-underarm-odour-protection-roll-on-powder-dry.jpg', 42, 1, 60, 67, 1, 'Pcs ', NULL, 0, '0', 0),
(191, 'Rexona Underarm Odour Protection Roll On - Shower Fresh, 50 ml', '', 'Rexona Underarm Odour Protection Roll On - Shower Fresh, 50 ml', '', '40063879_2-rexona-underarm-odour-protection-roll-on-shower-fresh.jpg', 42, 1, 60, 67, 1, 'Pcs ', NULL, 0, '0', 0),
(192, 'Rexona Underarm Odour Protection Roll On - Aloe Vera, 25 ml', '', 'Rexona Underarm Odour Protection Roll On - Aloe Vera, 25 ml', '', '40063884_4-rexona-underarm-odour-protection-roll-on-aloe-vera.jpg', 42, 1, 67, 67, 1, 'Pcs ', NULL, 0, '0', 0),
(193, 'Ponds Fairness Day Cream - White Beauty,  20g', '', 'Ponds Fairness Day Cream - White Beauty', '', '266820_14-ponds-fairness-day-cream-white-beauty-spot-less.jpg', 19, 1, 60, 67, 1, 'Pcs', NULL, 0, '0', 0),
(194, 'Ponds BB Cream - White Beauty SPF 30 Fairness, 18 g', '', 'Ponds BB Cream - White Beauty SPF 30 Fairness, 18 g', '', '40002057_4-ponds-bb-cream-white-beauty-spf-30-fairness.jpg', 19, 1, 110, 120, 1, 'Pcs ', NULL, 0, '0', 0),
(195, 'Ponds BB Cream - White Beauty  Fairness, 9g', '', 'Ponds BB Cream - White Beauty  Fairness, 18 g', '', '40002057_4-ponds-bb-cream-white-beauty-spf-30-fairness1.jpg', 19, 1, 75, 82, 1, 'Pcs ', NULL, 0, '0', 0),
(196, 'Ponds White Beauty Spotless Fairness Face Wash, 50 g', '', 'Ponds White Beauty Spotless Fairness Face Wash, 50 g ', '', '307150_13-ponds-white-beauty-spotless-fairness-face-wash.jpg', 19, 1, 70, 79, 1, 'Pcs ', NULL, 0, '0', 0),
(197, 'Ponds Pure White Anti Pollution Purity Face Wash, 50 g', '', 'Ponds Pure White Anti Pollution Purity Face Wash, 50 g', '', '286734_10-ponds-pure-white-anti-pollution-purity-face-wash.jpg', 19, 1, 72, 90, 1, 'Pcs ', NULL, 0, '0', 0),
(198, 'Ponds Pure White Face Wash+Tripple Vitamin Body Lotion, Combo 2 Items', '', 'Ponds Pure White Face Wash+Tripple Vitamin Body Lotion, Combo 2 Items\r\n', '', '1206032_1-ponds-pure-white-face-washtripple-vitamin-body-lotion.jpg', 53, 1, 272, 340, 1, 'Pcs ', NULL, 0, '0', 0),
(199, 'Himalaya Men Pimple Clear Neem Face Wash, 50m.l.', '', 'Himalaya Men Pimple Clear Neem Face Wash,', '', '40093649_2-himalaya-men-pimple-clear-neem-face-wash.jpg', 19, 1, 70, 85, 1, 'Pcs ', '', 0, '0', 0),
(200, 'Kesh King Ayurvedic Scalp And Medicinal Hair Oil 300m.l.', '', 'Kesh king Ayurvedic Scalp', '', 'shopping-81.jpeg', 20, 1, 280, 320, 1, 'Pcs', NULL, 0, '0', 0),
(201, 'Himalaya Anti Hair Fall Shampoo pomp', '', 'Himalaya Anti Hair Fall Shampoo pomp pack', '', '40177324_2-himalaya-anti-hair-fall-shampoo.jpg', 21, 1, 350, 450, 1, 'Pcs ', NULL, 0, '0', 0),
(202, 'Himalaya Anti Hair Fall Shampoo pomp', '', 'Himalaya Anti Hair Fall Shampoo', '', '40177324_2-himalaya-anti-hair-fall-shampoo1.jpg', 54, 1, 350, 450, 1, 'Pcs ', NULL, 0, '0', 0),
(203, 'Himalaya Anti Dandruff Shampoo pomp', '', 'Himalaya Anti Dandruff Shampoo', '', '40177323_2-himalaya-anti-dandruff-shampoo.jpg', 20, 1, 350, 450, 1, 'Pcs ', NULL, 0, '0', 0),
(204, 'Himalaya Anti Dandruff Shampoo pomp', '', 'Himalaya Anti Dandruff Shampoo pomp', '', '40177323_2-himalaya-anti-dandruff-shampoo1.jpg', 54, 1, 350, 450, 1, 'Pcs ', NULL, 0, '0', 0),
(205, 'Vim Dishwash Gel - Lemon, 500 ml', '', 'Vim Dishwash Gel - Lemon, 500 ml', '', '266962_8-vim-dishwash-gel-lemon.jpg', 44, 1, 100, 105, 1, 'Pcs ', NULL, 0, '0', 0),
(206, 'Vim Dishwash Gel - Lemon, 250 ml', '', 'Vim Dishwash Gel - Lemon, 250 ml', '', '266962_8-vim-dishwash-gel-lemon1.jpg', 44, 1, 42, 45, 1, 'Pcs ', NULL, 0, '0', 0),
(207, 'Vim Dishwash Bar, 200 g Pack of 3', '', 'Vim Dishwash Bar, 200 g Pack of 3', '', '266969_8-vim-dishwash-bar.jpg', 44, 1, 42, 45, 1, 'Pcs ', NULL, 0, '0', 0),
(208, 'Vim Dishwash Bar - Lemon, 500 g', '', 'Vim Dishwash Bar - Lemon, 500 g', '', '317229_9-vim-dishwash-bar-lemon.jpg', 44, 1, 45, 47, 1, 'Pcs ', NULL, 0, '0', 0),
(209, 'Vim Dishwash Bar, 130 g Pack of 3', '', 'Vim Dishwash Bar, 130 g Pack of 3', '', '307287_3-vim-dishwash-bar.jpg', 44, 1, 28, 30, 1, 'Pcs', NULL, 0, '0', 0),
(210, 'Exo Dishwash - Round, 500 g', '', 'Exo Dishwash - Round, 500 g', '', '30007300_3-exo-dishwash-round.jpg', 44, 1, 43, 48, 1, 'Pcs ', NULL, 0, '0', 0),
(211, 'Exo Dishwash Bar - Touch & Shine, 300 g', '', 'Exo Dishwash Bar - Touch & Shine, 300 g', '', '40031946_5-exo-dishwash-bar-touch-shine.jpg', 44, 1, 18, 20, 1, 'Pcs', NULL, 0, '0', 0),
(212, 'HIT Spray Crawling Insect Killer (Cockroach Killer) (CIK),  4000m.l.', '', 'HIT Spray Crawling Insect Killer (Cockroach Killer) (CIK), ', '', '215677_7-hit-spray-crawling-insect-killer-cockroach-killer-cik.jpg', 57, 1, 175, 182, 1, 'Pcs ', '', 0, '0', 0),
(213, 'All Out Ultra - Power + Slider, 45 ml', '', 'All Out Ultra - Power + Slider, 45 ml', '', '305907_6-all-out-ultra-power-slider.jpg', 58, 1, 80, 89, 1, 'Pcs ', '', 0, '0', 0),
(214, 'Odonil Toilet Air Freshener Mix (3+1), 50 g', '', 'Odonil Toilet Air Freshener Mix (3+1), 50 g', '', '268761_5-odonil-toilet-air-freshener-mix-31.jpg', 43, 1, 129, 141, 1, 'Pcs ', NULL, 0, '0', 0),
(215, 'Odonil Toilet Air Freshener Mix (3+1), 75 g', '', 'Odonil Toilet Air Freshener Mix (3+1), 75 g', '', '268761_5-odonil-toilet-air-freshener-mix-311.jpg', 43, 1, 190, 210, 1, 'Pcs ', NULL, 0, '0', 0),
(216, 'Godrej aer Home Air Freshener Spray - Morning Misty Meadows, 240 ml', '', 'Godrej aer Home Air Freshener Spray - Morning Misty Meadows, 240 ml', '', '40024977_4-godrej-aer-home-air-freshener-spray-morning-misty-meadows.jpg', 43, 1, 129, 149, 1, 'Pcs ', NULL, 0, '0', 0),
(217, 'Godrej aer Home Air Freshener Spray - Cool Surf Blue, 240 ml', '', 'Godrej aer Home Air Freshener Spray - Cool Surf Blue, 240 ml', '', '100567469_7-godrej-aer-home-air-freshener-spray-cool-surf-blue.jpg', 43, 1, 129, 149, 1, 'Pcs ', NULL, 0, '0', 0),
(218, 'Godrej aer Home Air Freshener Spray - Petal Crush Pink, 240 ml', '', 'Godrej aer Home Air Freshener Spray - Petal Crush Pink, 240 ml', '', '40006982_6-godrej-aer-home-air-freshener-spray-petal-crush-pink.jpg', 43, 1, 129, 149, 1, 'Pcs', NULL, 0, '0', 0),
(219, 'Good knight Power Activ+ Combi Pack, 45 ml 1 Mosquito Destroyer Machine + 1 Refill', '', 'Good knight Power Activ+ Combi Pack, 45 ml 1 Mosquito Destroyer Machine + 1 Refill', '', '199519_11-good-knight-power-activ-combi-pack.jpg', 58, 1, 75, 85, 1, 'Pcs ', NULL, 0, '0', 0),
(220, 'Good knight Advanced - Fast Card, 10 pcs Pouch', '', 'Good knight Advanced - Fast Card, 10 pcs Pouch', '', '40020143_1-good-knight-advanced-fast-card.jpg', 58, 1, 9, 10, 1, 'Pcs ', NULL, 0, '0', 0),
(221, 'Good knight Activ + Liquid Refill - Lavender, 45 ml', '', 'Good knight Activ + Liquid Refill - Lavender, 45 ml', '', '40052419_1-good-knight-activ-liquid-refill-lavender.jpg', 58, 1, 62, 72, 1, 'Pcs', NULL, 0, '0', 0),
(222, 'Maxo Machine - Genius, Combi, 35 ml', '', 'Maxo Machine - Genius, Combi, 35 ml', '', '40130632_2-maxo-machine-genius-combi.jpg', 58, 1, 85, 89, 1, 'Pcs ', NULL, 0, '0', 0),
(223, 'Maxo Mosquito Repellent, 45 nights', '', 'Maxo Mosquito Repellent, 45 nights', '', '30007301_3-maxo-mosquito-repellent.jpg', 58, 1, 60, 67, 1, 'Pcs ', NULL, 0, '0', 0),
(224, 'HIT Flying Insect Killer (FIK), 400 ml', '', 'HIT Flying Insect Killer (FIK), 400 ml\r\n', '', '268762_11-hit-flying-insect-killer-fik.jpg', 57, 1, 175, 182, 1, 'Pcs ', NULL, 0, '0', 0),
(225, 'HIT Flying Insect Killer (FIK), 200 ml', '', 'HIT Flying Insect Killer (FIK), 200 ml', '', '268762_11-hit-flying-insect-killer-fik1.jpg', 57, 1, 95, 98, 1, 'Pcs ', NULL, 0, '0', 0),
(226, 'HIT Spray Crawling Insect Killer (Cockroach Killer) (CIK),  200m.l.', '', 'HIT Spray Crawling Insect Killer (Cockroach Killer) (CIK),  200m.l.', '', '215677_7-hit-spray-crawling-insect-killer-cockroach-killer-cik1.jpg', 57, 1, 95, 98, 1, 'Pcs ', NULL, 0, '0', 0),
(227, 'Good knight Fabric Roll On Personal Repellent - Citrus Fragrance, 8 ml', '', 'Good knight Fabric Roll On Personal Repellent - Citrus Fragrance, 8 ml', '', '40111839_4-good-knight-fabric-roll-on-personal-repellent-citrus-fragrance.jpg', 58, 1, 70, 75, 1, 'Pcs ', NULL, 0, '0', 0),
(228, 'Fair & Lovely Daily Fairness Expert Face Wash - Advanced Multi Vitamin 50m.l.', '', 'Fair & Lovely Daily Fairness Expert Face Wash - Advanced Multi Vitamin', '', '286713_7-fair-lovely-fairness-face-wash.jpg', 19, 1, 55, 65, 1, 'Pcs ', NULL, 0, '0', 0),
(229, 'Rin Detergent Bar, 250 g (Pack of 4', '', 'Rin Detergent Bar, 250 g (Pack of 4', '', '40002071_12-rin-rin-detergent-bar.jpg', 37, 1, 60, 66, 1, 'Pcs ', NULL, 0, '0', 0),
(230, 'Rin Rin Detergent Bar, 140 g', '', 'Rin Rin Detergent Bar, 140 g', '', '40002071_12-rin-rin-detergent-bar1.jpg', 37, 1, 9, 10, 1, 'Pcs', '', 0, '0', 0),
(231, 'Surf Excel Detergent Bar, 200 g Pack of 4', '', '\r\nSurf Excel Detergent Bar, 200 g Pack of 4', '', '267011_11-surf-excel-detergent-bar.jpg', 37, 1, 88, 94, 1, 'Pcs ', NULL, 0, '0', 0),
(232, 'Surf Excel Detergent Bar, 250 g', '', '\r\nSurf Excel Detergent Bar, 250 g ', '', 'download-150.jpeg', 37, 1, 27, 29, 1, 'Pcs', NULL, 0, '0', 0),
(233, 'Wheel Green Detergent Bar, 260 g', '', '\r\nWheel Green Detergent Bar, 260 g', '', 'download-151.jpeg', 37, 1, 8.5, 10, 1, 'Pcs ', NULL, 0, '0', 0),
(234, 'Pampers New Dry Large - 2 Diapers Pants, 2 pcs', '', '\r\nPampers New Dry Large - 2 Diapers Pants, 2 pcs', '', '40128516_1-pampers-new-dry-large-2-diapers-pants.jpg', 56, 1, 25, 28, 1, 'Pcs ', NULL, 0, '0', 0),
(235, 'Pampers Baby Dry Large (9-14 kg) - 5 Diapers, 5 pcs Pouch', '', 'Pampers Baby Dry Large (9-14 kg) - 5 Diapers, 5 pcs Pouch', '', '295809_4-pampers-baby-dry-large-9-14-kg-5-diapers.jpg', 56, 1, 72, 80, 1, 'Pcs ', NULL, 0, '0', 0),
(236, 'Pampers New Medium - 2 Diaper Pants, 2 pcs', '', 'Pampers New Medium - 2 Diaper Pants, 2 pcs', '', '20004612_5-pampers-new-medium-2-diaper-pants.jpg', 56, 1, 22, 24, 1, 'Pcs ', NULL, 0, '0', 0),
(237, 'Johnson & Johnson Baby Shampoo, 100 ml', '', 'Johnson & Johnson Baby Shampoo, 100 ml', '', '262921_17-johnson-johnson-baby-shampoo.jpg', 59, 1, 80, 87, 1, 'Pcs ', NULL, 0, '0', 0),
(238, 'Johnson & Johnson Top-to-Toe Wash, 100 ml', '', 'Johnson & Johnson Top-to-Toe Wash, 100 ml', '', '20004169_9-johnson-johnson-top-to-toe-wash.jpg', 59, 1, 72, 80, 1, 'Pcs ', NULL, 0, '0', 0),
(239, 'Johnson & Johnson Baby Soap, 75 g', '', 'Johnson & Johnson Baby Soap, 75 g', '', '299670_16-johnson-johnson-baby-soap.jpg', 59, 1, 40, 45, 1, 'Pcs ', NULL, 0, '0', 0),
(240, 'Figaro Pure Olive Oil, 500 ml Tin', '', 'Figaro Pure Olive Oil, 500 ml Tin', '', '100140866_6-figaro-pure-olive-oil.jpg', 59, 1, 525, 575, 1, 'Pcs ', NULL, 0, '0', 0),
(241, 'Figaro Pure Olive Oil, 200 ml Tin', '', 'Figaro Pure Olive Oil, 200 ml Tin', '', '100140866_6-figaro-pure-olive-oil1.jpg', 59, 1, 265, 295, 1, 'Pcs ', NULL, 0, '0', 0),
(242, 'Axe Signature Dark Temptation Body Perfume, 154 ml', '', 'Axe Signature Dark Temptation Body Perfume, 154 ml', '', '40163056_1-axe-signature-dark-temptation-body-perfume.jpg', 42, 1, 170, 199, 1, 'Pcs ', NULL, 0, '0', 0),
(243, 'Axe Signature Rouge Body Perfume,', '', 'Axe Signature Rouge Body Perfume, ', '', '40158278_1-axe-signature-rouge-body-perfume.jpg', 42, 1, 170, 199, 1, 'Pcs ', NULL, 0, '0', 0),
(244, 'Axe Signature Intense Body Perfume', '', 'Axe Signature Intense Body Perfume', '', '40158276_1-axe-signature-intense-body-perfume.jpg', 42, 1, 170, 199, 1, 'Pcs ', NULL, 0, '0', 0),
(245, 'Axe Signature Maverick Body Perfume', '', 'Axe Signature Maverick Body Perfume', '', '40158274_1-axe-signature-maverick-body-perfume.jpg', 42, 1, 170, 199, 1, 'Pcs ', NULL, 0, '0', 0),
(246, 'Chings Green Chilly Sauce, 190 g Bottle', '', 'Chings Green Chilly Sauce, 190 g Bottle', '', '270516_3-chings-green-chilly-sauce.jpg', 33, 1, 45, 50, 1, 'Pcs ', NULL, 0, '0', 0),
(247, 'Chings Red Chilli Sauce, 200 g Bottle', '', 'Chings Red Chilli Sauce, 200 g Bottle', '', '270522_3-chings-red-chilli-sauce.jpg', 33, 1, 45, 50, 1, 'Pcs ', NULL, 0, '0', 0),
(248, 'Chings Schezwan Sauce, 250 g Jar', '', 'Chings Schezwan Sauce, 250 g Jar', '', '270526_1-chings-schezwan-sauce.jpg', 33, 1, 70, 75, 1, 'Pcs ', NULL, 0, '0', 0),
(249, 'Chings Chilly Vinegar, 170 ml Bottle', '', 'Chings Chilly Vinegar, 170 ml Bottle', '', '270524_2-chings-chilly-vinegar.jpg', 33, 1, 45, 45, 1, 'Pcs', NULL, 0, '0', 0),
(250, 'MAGGI 2-minute Masala Noodles, 280 g', '', 'MAGGI 2-minute Masala Noodles, 280 g', '', '266109_14-maggi-2-minute-masala-noodles.jpg', 32, 1, 42, 45, 1, 'Pcs ', NULL, 0, '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` double DEFAULT NULL,
  `qty` double NOT NULL,
  `unit` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `store` varchar(200) NOT NULL,
  `store_id_login` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `purchase`
--

-- --------------------------------------------------------

--
-- Table structure for table `razorpay`
--

CREATE TABLE `razorpay` (
  `id` int(200) NOT NULL,
  `api_key` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `razorpay`
--


-- --------------------------------------------------------

--
-- Table structure for table `registers`
--

CREATE TABLE `registers` (
  `user_id` int(11) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_fullname` varchar(100) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `pincode` int(11) NOT NULL,
  `socity_id` int(11) NOT NULL,
  `house_no` longtext NOT NULL,
  `mobile_verified` int(11) NOT NULL,
  `user_gcm_code` longtext NOT NULL,
  `user_ios_token` longtext NOT NULL,
  `varified_token` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `reg_code` int(6) NOT NULL,
  `wallet` int(11) NOT NULL,
  `rewards` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `registers`
--

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` int(200) NOT NULL,
  `point` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `point`) VALUES
(1, '10');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `sale_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `on_date` date NOT NULL,
  `delivery_time_from` varchar(200) NOT NULL,
  `delivery_time_to` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `note` longtext NOT NULL,
  `is_paid` int(11) NOT NULL,
  `total_amount` double NOT NULL,
  `total_rewards` varchar(200) NOT NULL,
  `total_kg` double NOT NULL,
  `total_items` double NOT NULL,
  `socity_id` int(11) NOT NULL,
  `delivery_address` longtext NOT NULL,
  `location_id` int(11) NOT NULL,
  `delivery_charge` double NOT NULL,
  `new_store_id` varchar(200) NOT NULL DEFAULT '0',
  `assign_to` varchar(30) NOT NULL DEFAULT '0',
  `payment_method` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sale`
--


-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `sale_item_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(250) NOT NULL,
  `qty` double NOT NULL,
  `unit` enum('gram','kg','nos') NOT NULL,
  `unit_value` double NOT NULL,
  `price` double NOT NULL,
  `qty_in_kg` double NOT NULL,
  `rewards` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sale_items`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` varchar(200) NOT NULL,
  `title` varchar(100) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `title`, `value`) VALUES
('1', 'minmum order amount', '1'),
('2', 'maxmum order amount', '7000');

-- --------------------------------------------------------

--
-- Table structure for table `signature`
--

CREATE TABLE `signature` (
  `id` int(200) NOT NULL,
  `order_id` varchar(200) NOT NULL,
  `signature` varchar(200) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `signature`
--


-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `slider_title` varchar(100) NOT NULL,
  `slider_url` varchar(100) NOT NULL,
  `slider_image` varchar(100) NOT NULL,
  `sub_cat` int(200) NOT NULL,
  `slider_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `slider`
--



-- --------------------------------------------------------

--
-- Table structure for table `socity`
--

CREATE TABLE `socity` (
  `socity_id` int(11) NOT NULL,
  `socity_name` varchar(200) NOT NULL,
  `pincode` varchar(15) NOT NULL,
  `delivery_charge` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `socity`
--

-- --------------------------------------------------------

--
-- Table structure for table `store_login`
--

CREATE TABLE `store_login` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_password` longtext NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `user_bdate` date NOT NULL,
  `is_email_varified` int(11) NOT NULL,
  `varified_token` varchar(255) NOT NULL,
  `user_gcm_code` longtext NOT NULL,
  `user_ios_token` longtext NOT NULL,
  `user_status` int(11) NOT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `user_city` int(11) NOT NULL,
  `user_login_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_numbers`
--

CREATE TABLE `tbl_numbers` (
  `id` int(200) NOT NULL,
  `whatsapp` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `calling` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_numbers`
--

INSERT INTO `tbl_numbers` (`id`, `whatsapp`, `calling`) VALUES
(1, '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL,
  `time_slot` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `time_slots`
--

-- --------------------------------------------------------

--
-- Table structure for table `top_selling`
--

CREATE TABLE `top_selling` (
  `id` int(255) NOT NULL,
  `product_price` varchar(1000) NOT NULL,
  `image_title` varchar(1000) NOT NULL,
  `img_url` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_password` longtext NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `user_bdate` date NOT NULL,
  `is_email_varified` int(11) NOT NULL,
  `varified_token` varchar(255) NOT NULL,
  `user_gcm_code` longtext NOT NULL,
  `user_ios_token` longtext NOT NULL,
  `user_status` int(11) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `user_city` int(11) NOT NULL,
  `user_login_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_phone`, `user_fullname`, `user_password`, `user_type_id`, `user_bdate`, `is_email_varified`, `varified_token`, `user_gcm_code`, `user_ios_token`, `user_status`, `user_image`, `user_city`, `user_login_status`) VALUES
(1, 'Saurabh', 'tecmanic@gmail.com', '8959061332', 'Main Admin 007', '6b15822dadec6e84cfb87d38f0e3514b', 0, '0000-00-00', 0, '', '', '', 1, 'Photo_1571002572001.png', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_location`
--

CREATE TABLE `user_location` (
  `location_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `socity_id` int(11) NOT NULL,
  `house_no` longtext NOT NULL,
  `receiver_name` varchar(255) NOT NULL,
  `receiver_mobile` varchar(15) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_location`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `user_type_id` int(11) NOT NULL,
  `user_type_title` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`user_type_id`, `user_type_title`) VALUES
(1, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `user_type_access`
--

CREATE TABLE `user_type_access` (
  `user_type_id` int(11) NOT NULL,
  `class` varchar(30) NOT NULL,
  `method` varchar(30) NOT NULL,
  `access` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_type_access`
--

INSERT INTO `user_type_access` (`user_type_id`, `class`, `method`, `access`) VALUES
(0, 'admin', '*', 1),
(0, 'child', '*', 1),
(0, 'parents', '*', 1),
(0, 'timeline', '*', 1),
(0, 'users', '*', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `closing_hours`
--
ALTER TABLE `closing_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deal_product`
--
ALTER TABLE `deal_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deelofday`
--
ALTER TABLE `deelofday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivered_order`
--
ALTER TABLE `delivered_order`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `delivery_boy`
--
ALTER TABLE `delivery_boy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feature_slider`
--
ALTER TABLE `feature_slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `header_categories`
--
ALTER TABLE `header_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `header_products`
--
ALTER TABLE `header_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `icons`
--
ALTER TABLE `icons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instamojo`
--
ALTER TABLE `instamojo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_setting`
--
ALTER TABLE `language_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pageapp`
--
ALTER TABLE `pageapp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paypal`
--
ALTER TABLE `paypal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `razorpay`
--
ALTER TABLE `razorpay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registers`
--
ALTER TABLE `registers`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`sale_item_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `signature`
--
ALTER TABLE `signature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `socity`
--
ALTER TABLE `socity`
  ADD PRIMARY KEY (`socity_id`);

--
-- Indexes for table `store_login`
--
ALTER TABLE `store_login`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `tbl_numbers`
--
ALTER TABLE `tbl_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `top_selling`
--
ALTER TABLE `top_selling`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `user_location`
--
ALTER TABLE `user_location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`user_type_id`);

--
-- Indexes for table `user_type_access`
--
ALTER TABLE `user_type_access`
  ADD UNIQUE KEY `user_type_id` (`user_type_id`,`class`,`method`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(200) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `closing_hours`
--
ALTER TABLE `closing_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deal_product`
--
ALTER TABLE `deal_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `deelofday`
--
ALTER TABLE `deelofday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_boy`
--
ALTER TABLE `delivery_boy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `feature_slider`
--
ALTER TABLE `feature_slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `header_categories`
--
ALTER TABLE `header_categories`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10005;

--
-- AUTO_INCREMENT for table `header_products`
--
ALTER TABLE `header_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100004;

--
-- AUTO_INCREMENT for table `icons`
--
ALTER TABLE `icons`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instamojo`
--
ALTER TABLE `instamojo`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `language_setting`
--
ALTER TABLE `language_setting`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pageapp`
--
ALTER TABLE `pageapp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `paypal`
--
ALTER TABLE `paypal`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT for table `razorpay`
--
ALTER TABLE `razorpay`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `registers`
--
ALTER TABLE `registers`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `sale_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `signature`
--
ALTER TABLE `signature`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `socity`
--
ALTER TABLE `socity`
  MODIFY `socity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `store_login`
--
ALTER TABLE `store_login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `tbl_numbers`
--
ALTER TABLE `tbl_numbers`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `top_selling`
--
ALTER TABLE `top_selling`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `user_location`
--
ALTER TABLE `user_location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;