-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: 2016 年 4 月 16 日 18:32
-- サーバのバージョン： 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `LAA0682918-shashoku`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `colors`
--

DROP TABLE IF EXISTS `colors`;
CREATE TABLE `colors` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `color_code` varchar(100) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `colors`
--

INSERT INTO `colors` (`id`, `name`, `color_code`, `del_flg`, `created`, `modified`) VALUES
(1, '橙', '#ffb2b2', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(2, '赤', '#ffb2d8 ', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(3, 'ピンク', '#ffb2ff', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(4, '紫', '#d8b2ff', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(5, '青', '#b2b2ff', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(6, '空', '#b2d8ff', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(7, '水', '#b2ffff', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(8, 'エメラルド', '#b2ffd8', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(9, '緑', '#b2ffb2', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(10, '黄色', '#ffffb2', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `basic_price` int(11) NOT NULL,
  `monthly_coupon_count` int(11) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `companies`
--

INSERT INTO `companies` (`id`, `name`, `basic_price`, `monthly_coupon_count`, `del_flg`, `created`, `modified`) VALUES
(1, '会社kaisha1', 300, 10, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(2, '会社kaisha2', 200, 20, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `companies_departments`
--

DROP TABLE IF EXISTS `companies_departments`;
CREATE TABLE `companies_departments` (
  `id` int(11) unsigned NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL DEFAULT '',
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `companies_departments`
--

INSERT INTO `companies_departments` (`id`, `company_id`, `name`, `del_flg`, `created`, `modified`) VALUES
(1, 1, '営業', 0, '2016-02-01 00:00:00', '2016-02-01 00:00:00'),
(2, 1, '技術', 0, '2016-02-01 00:00:00', '2016-02-01 00:00:00'),
(3, 1, '人事', 0, '2016-02-01 00:00:00', '2016-02-01 00:00:00'),
(4, 2, '営業', 0, '2016-02-01 00:00:00', '2016-02-01 00:00:00'),
(5, 2, '技術', 0, '2016-02-01 00:00:00', '2016-02-01 00:00:00'),
(6, 2, '人事', 0, '2016-02-01 00:00:00', '2016-02-01 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `companies_locations`
--

DROP TABLE IF EXISTS `companies_locations`;
CREATE TABLE `companies_locations` (
  `id` int(11) unsigned NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL DEFAULT '',
  `zip_code_first` varchar(11) DEFAULT '',
  `zip_code_second` varchar(11) DEFAULT '',
  `prefecture_id` int(11) NOT NULL,
  `address` varchar(1000) NOT NULL DEFAULT '',
  `building_name` varchar(1000) DEFAULT '',
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `companies_locations`
--

INSERT INTO `companies_locations` (`id`, `company_id`, `name`, `zip_code_first`, `zip_code_second`, `prefecture_id`, `address`, `building_name`, `del_flg`, `created`, `modified`) VALUES
(1, 1, '本社', '100', '1000', 13, '渋谷区道玄坂', 'ヒューマックス', 0, '2016-02-01 00:00:00', '2016-02-01 00:00:00'),
(2, 1, '沖縄支店', '200', '2000', 47, '沖縄', 'ウチナービル', 0, '2016-02-01 00:00:00', '2016-02-01 00:00:00'),
(3, 2, '本社', '100', '1000', 13, '渋谷区道玄坂', 'ヒューマックス', 0, '2016-02-01 00:00:00', '2016-02-01 00:00:00'),
(4, 2, '沖縄支店', '200', '2000', 47, '沖縄', 'ウチナービル', 0, '2016-02-01 00:00:00', '2016-02-01 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `coupons`
--

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `priority_order` int(11) NOT NULL,
  `set_menu_id` int(11) NOT NULL,
  `additional_price` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `coupons`
--

INSERT INTO `coupons` (`id`, `restaurant_id`, `priority_order`, `set_menu_id`, `additional_price`, `start_date`, `end_date`, `del_flg`, `created`, `modified`) VALUES
(1, 1, 1, 1, 400, '2016-01-01 00:00:00', '2016-01-01 00:00:00', 0, '2017-01-01 00:00:00', '2016-01-24 23:00:11'),
(2, 1, 2, 2, 400, '2016-01-01 00:00:00', '2016-01-02 00:00:00', 0, '2017-01-01 00:00:00', '2016-01-01 00:00:00'),
(3, 1, 3, 3, 300, '2016-01-01 00:00:00', '2017-01-03 00:00:00', 0, '2017-01-01 00:00:00', '2016-01-01 00:00:00'),
(4, 2, 1, 4, 400, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(5, 2, 2, 5, 500, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(6, 2, 3, 6, 600, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(7, 3, 1, 7, 700, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(8, 3, 2, 8, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 1, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(9, 3, 3, 9, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(10, 4, 1, 10, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(11, 4, 2, 11, 300, '2016-01-01 00:00:00', '2016-01-31 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(12, 4, 3, 12, 300, '2015-12-01 00:00:00', '2015-12-31 23:59:59', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(13, 4, 4, 13, 300, '2016-01-01 00:00:00', '2016-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(14, 5, 1, 14, 400, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(15, 5, 2, 15, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(16, 5, 3, 16, 400, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(17, 6, 1, 17, 500, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(18, 6, 2, 18, 600, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(19, 6, 3, 19, 700, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(20, 7, 1, 20, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 1, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(21, 7, 2, 21, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(22, 7, 3, 22, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(23, 8, 1, 23, 300, '2016-01-01 00:00:00', '2016-01-31 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(24, 8, 2, 24, 300, '2015-12-01 00:00:00', '2015-12-31 23:59:59', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(25, 8, 3, 25, 300, '2016-01-01 00:00:00', '2016-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(26, 9, 1, 26, 400, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(27, 9, 2, 27, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(28, 9, 3, 28, 400, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(29, 10, 1, 29, 500, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(30, 10, 2, 30, 600, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(31, 10, 3, 31, 700, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(32, 11, 1, 32, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 1, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(33, 11, 2, 33, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(34, 11, 3, 34, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(35, 12, 1, 35, 300, '2016-01-01 00:00:00', '2016-01-31 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(36, 12, 2, 36, 300, '2015-12-01 00:00:00', '2015-12-31 23:59:59', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(37, 12, 3, 37, 300, '2016-01-01 00:00:00', '2016-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(38, 13, 1, 38, 400, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(39, 13, 2, 39, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(40, 13, 3, 40, 400, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(41, 14, 1, 41, 500, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(42, 14, 2, 42, 600, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(43, 14, 3, 43, 700, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(44, 15, 1, 44, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 1, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(45, 15, 2, 45, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(46, 15, 3, 46, 300, '2016-01-01 00:00:00', '2017-01-01 00:00:00', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(1000) NOT NULL DEFAULT '',
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `groups`
--

INSERT INTO `groups` (`id`, `name`, `del_flg`, `created`, `modified`) VALUES
(1, '一般ユーザー', 0, '2016-02-01 00:00:00', '2016-02-01 00:00:00'),
(2, 'デバッグユーザー', 0, '2016-02-01 00:00:00', '2016-02-01 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `log_coupons_consumptions`
--

DROP TABLE IF EXISTS `log_coupons_consumptions`;
CREATE TABLE `log_coupons_consumptions` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(500) NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `users_profile_id` int(11) NOT NULL,
  `family_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `department_ids` varchar(500) NOT NULL,
  `department_name` varchar(500) NOT NULL,
  `location_id` int(11) NOT NULL,
  `location_name` varchar(500) NOT NULL,
  `location_ids` varchar(500) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `restaurant_name` varchar(500) NOT NULL,
  `restaurants_photo_file_name` varchar(500) NOT NULL,
  `restaurants_photo_ids` varchar(500) NOT NULL,
  `restaurants_genre_ids` varchar(500) NOT NULL,
  `restaurants_tag_ids` varchar(500) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `additional_price` int(11) NOT NULL,
  `basic_price` int(11) NOT NULL,
  `set_menu_id` int(11) NOT NULL,
  `set_menu_name` varchar(500) NOT NULL,
  `set_menus_photo_file_name` varchar(500) NOT NULL,
  `set_menus_photo_ids` varchar(500) NOT NULL,
  `yearmonth` int(6) NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8
/*!50500 PARTITION BY RANGE  COLUMNS(created)
(PARTITION p201601 VALUES LESS THAN ('2016-01-01') ENGINE = InnoDB,
 PARTITION p201602 VALUES LESS THAN ('2016-02-01') ENGINE = InnoDB,
 PARTITION p201603 VALUES LESS THAN ('2016-03-01') ENGINE = InnoDB,
 PARTITION p201604 VALUES LESS THAN ('2016-04-01') ENGINE = InnoDB,
 PARTITION p201605 VALUES LESS THAN ('2016-05-01') ENGINE = InnoDB,
 PARTITION p201606 VALUES LESS THAN ('2016-06-01') ENGINE = InnoDB,
 PARTITION p201607 VALUES LESS THAN ('2016-07-01') ENGINE = InnoDB,
 PARTITION p201608 VALUES LESS THAN ('2016-08-01') ENGINE = InnoDB,
 PARTITION p201609 VALUES LESS THAN ('2016-09-01') ENGINE = InnoDB,
 PARTITION p201610 VALUES LESS THAN ('2016-10-01') ENGINE = InnoDB,
 PARTITION p201611 VALUES LESS THAN ('2016-11-01') ENGINE = InnoDB,
 PARTITION p201612 VALUES LESS THAN ('2016-12-01') ENGINE = InnoDB,
 PARTITION p201701 VALUES LESS THAN ('2017-01-01') ENGINE = InnoDB,
 PARTITION p201702 VALUES LESS THAN ('2017-02-01') ENGINE = InnoDB,
 PARTITION p201703 VALUES LESS THAN ('2017-03-01') ENGINE = InnoDB,
 PARTITION p201704 VALUES LESS THAN ('2017-04-01') ENGINE = InnoDB,
 PARTITION p201705 VALUES LESS THAN ('2017-05-01') ENGINE = InnoDB,
 PARTITION p201706 VALUES LESS THAN ('2017-06-01') ENGINE = InnoDB,
 PARTITION p201707 VALUES LESS THAN ('2017-07-01') ENGINE = InnoDB,
 PARTITION p201708 VALUES LESS THAN ('2017-08-01') ENGINE = InnoDB,
 PARTITION p201709 VALUES LESS THAN ('2017-09-01') ENGINE = InnoDB,
 PARTITION p201710 VALUES LESS THAN ('2017-10-01') ENGINE = InnoDB,
 PARTITION p201711 VALUES LESS THAN ('2017-11-01') ENGINE = InnoDB,
 PARTITION p201712 VALUES LESS THAN ('2017-12-01') ENGINE = InnoDB,
 PARTITION p201801 VALUES LESS THAN ('2018-01-01') ENGINE = InnoDB,
 PARTITION p201802 VALUES LESS THAN ('2018-02-01') ENGINE = InnoDB,
 PARTITION p201803 VALUES LESS THAN ('2018-03-01') ENGINE = InnoDB,
 PARTITION p201804 VALUES LESS THAN ('2018-04-01') ENGINE = InnoDB,
 PARTITION p201805 VALUES LESS THAN ('2018-05-01') ENGINE = InnoDB,
 PARTITION p201806 VALUES LESS THAN ('2018-06-01') ENGINE = InnoDB,
 PARTITION p201807 VALUES LESS THAN ('2018-07-01') ENGINE = InnoDB,
 PARTITION p201808 VALUES LESS THAN ('2018-08-01') ENGINE = InnoDB,
 PARTITION p201809 VALUES LESS THAN ('2018-09-01') ENGINE = InnoDB,
 PARTITION p201810 VALUES LESS THAN ('2018-10-01') ENGINE = InnoDB,
 PARTITION p201811 VALUES LESS THAN ('2018-11-01') ENGINE = InnoDB,
 PARTITION p201812 VALUES LESS THAN ('2018-12-01') ENGINE = InnoDB,
 PARTITION p201901 VALUES LESS THAN ('2019-01-01') ENGINE = InnoDB,
 PARTITION p201902 VALUES LESS THAN ('2019-02-01') ENGINE = InnoDB,
 PARTITION p201903 VALUES LESS THAN ('2019-03-01') ENGINE = InnoDB,
 PARTITION p201904 VALUES LESS THAN ('2019-04-01') ENGINE = InnoDB,
 PARTITION p201905 VALUES LESS THAN ('2019-05-01') ENGINE = InnoDB,
 PARTITION p201906 VALUES LESS THAN ('2019-06-01') ENGINE = InnoDB,
 PARTITION p201907 VALUES LESS THAN ('2019-07-01') ENGINE = InnoDB,
 PARTITION p201908 VALUES LESS THAN ('2019-08-01') ENGINE = InnoDB,
 PARTITION p201909 VALUES LESS THAN ('2019-09-01') ENGINE = InnoDB,
 PARTITION p201910 VALUES LESS THAN ('2019-10-01') ENGINE = InnoDB,
 PARTITION p201911 VALUES LESS THAN ('2019-11-01') ENGINE = InnoDB,
 PARTITION p201912 VALUES LESS THAN ('2019-12-01') ENGINE = InnoDB,
 PARTITION p202001 VALUES LESS THAN ('2020-01-01') ENGINE = InnoDB,
 PARTITION p202002 VALUES LESS THAN ('2020-02-01') ENGINE = InnoDB,
 PARTITION p202003 VALUES LESS THAN ('2020-03-01') ENGINE = InnoDB,
 PARTITION p202004 VALUES LESS THAN ('2020-04-01') ENGINE = InnoDB,
 PARTITION p202005 VALUES LESS THAN ('2020-05-01') ENGINE = InnoDB,
 PARTITION p202006 VALUES LESS THAN ('2020-06-01') ENGINE = InnoDB,
 PARTITION p202007 VALUES LESS THAN ('2020-07-01') ENGINE = InnoDB,
 PARTITION p202008 VALUES LESS THAN ('2020-08-01') ENGINE = InnoDB,
 PARTITION p202009 VALUES LESS THAN ('2020-09-01') ENGINE = InnoDB,
 PARTITION p202010 VALUES LESS THAN ('2020-10-01') ENGINE = InnoDB,
 PARTITION p202011 VALUES LESS THAN ('2020-11-01') ENGINE = InnoDB,
 PARTITION p202012 VALUES LESS THAN ('2020-12-01') ENGINE = InnoDB,
 PARTITION p202101 VALUES LESS THAN ('2021-01-01') ENGINE = InnoDB,
 PARTITION p202102 VALUES LESS THAN ('2021-02-01') ENGINE = InnoDB,
 PARTITION p202103 VALUES LESS THAN ('2021-03-01') ENGINE = InnoDB,
 PARTITION p202104 VALUES LESS THAN ('2021-04-01') ENGINE = InnoDB,
 PARTITION p202105 VALUES LESS THAN ('2021-05-01') ENGINE = InnoDB,
 PARTITION p202106 VALUES LESS THAN ('2021-06-01') ENGINE = InnoDB,
 PARTITION p202107 VALUES LESS THAN ('2021-07-01') ENGINE = InnoDB,
 PARTITION p202108 VALUES LESS THAN ('2021-08-01') ENGINE = InnoDB,
 PARTITION p202109 VALUES LESS THAN ('2021-09-01') ENGINE = InnoDB,
 PARTITION p202110 VALUES LESS THAN ('2021-10-01') ENGINE = InnoDB,
 PARTITION p202111 VALUES LESS THAN ('2021-11-01') ENGINE = InnoDB,
 PARTITION p202112 VALUES LESS THAN ('2021-12-01') ENGINE = InnoDB,
 PARTITION p202201 VALUES LESS THAN ('2022-01-01') ENGINE = InnoDB,
 PARTITION p202202 VALUES LESS THAN ('2022-02-01') ENGINE = InnoDB,
 PARTITION p202203 VALUES LESS THAN ('2022-03-01') ENGINE = InnoDB,
 PARTITION p202204 VALUES LESS THAN ('2022-04-01') ENGINE = InnoDB,
 PARTITION p202205 VALUES LESS THAN ('2022-05-01') ENGINE = InnoDB,
 PARTITION p202206 VALUES LESS THAN ('2022-06-01') ENGINE = InnoDB,
 PARTITION p202207 VALUES LESS THAN ('2022-07-01') ENGINE = InnoDB,
 PARTITION p202208 VALUES LESS THAN ('2022-08-01') ENGINE = InnoDB,
 PARTITION p202209 VALUES LESS THAN ('2022-09-01') ENGINE = InnoDB,
 PARTITION p202210 VALUES LESS THAN ('2022-10-01') ENGINE = InnoDB,
 PARTITION p202211 VALUES LESS THAN ('2022-11-01') ENGINE = InnoDB,
 PARTITION p202212 VALUES LESS THAN ('2022-12-01') ENGINE = InnoDB,
 PARTITION pmax VALUES LESS THAN (MAXVALUE) ENGINE = InnoDB) */;

--
-- テーブルのデータのダンプ `log_coupons_consumptions`
--

INSERT INTO `log_coupons_consumptions` (`id`, `employee_id`, `company_id`, `user_id`, `users_profile_id`, `family_name`, `first_name`, `department_id`, `department_ids`, `department_name`, `location_id`, `location_name`, `location_ids`, `restaurant_id`, `restaurant_name`, `restaurants_photo_file_name`, `restaurants_photo_ids`, `restaurants_genre_ids`, `restaurants_tag_ids`, `coupon_id`, `total_price`, `additional_price`, `basic_price`, `set_menu_id`, `set_menu_name`, `set_menus_photo_file_name`, `set_menus_photo_ids`, `yearmonth`, `del_flg`, `created`, `modified`) VALUES
(1, '1', 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201602, 0, '2016-02-28 15:40:40', '2016-02-28 15:40:40'),
(2, '1', 2, 1, 1, 'test1', 'test1', 6, '6,5,4', '人事', 3, '本社', '3,2', 4, 'yoncha cafe', 'restaurant_4_1.jpg', '10,11,12,13', '2,3,4,1', '10,1,2,3', 10, 500, 300, 200, 10, 'チキンと野菜のグラタンセット', 'set_menu_10_1.jpg', '10', 201603, 0, '2016-03-20 18:40:11', '2016-03-20 18:40:11'),
(3, '2', 2, 2, 2, 'test2', 'test2', 6, '6', '人事', 3, '本社', '3', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 3, 500, 300, 200, 3, 'チキンと野菜の\nグラタンセット', 'set_menu_3_1.jpg', '3', 201603, 0, '2016-03-26 13:04:48', '2016-03-26 13:04:48'),
(4, '1', 2, 1, 1, 'test1@', 'test1@', 5, '5', '技術', 3, '本社', '3', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 3, 500, 300, 200, 3, 'チキンと野菜の\nグラタンセット', 'set_menu_3_1.jpg', '3', 201603, 0, '2016-03-26 13:09:25', '2016-03-26 13:09:25');

-- --------------------------------------------------------

--
-- テーブルの構造 `log_coupons_displays`
--

DROP TABLE IF EXISTS `log_coupons_displays`;
CREATE TABLE `log_coupons_displays` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(500) NOT NULL,
  `authenticated_status_flg` tinyint(4) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `users_profile_id` int(11) NOT NULL,
  `family_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `department_id` int(11) NOT NULL,
  `department_ids` varchar(500) NOT NULL,
  `department_name` varchar(500) NOT NULL,
  `location_id` int(11) NOT NULL,
  `location_name` varchar(500) NOT NULL,
  `location_ids` varchar(500) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `restaurant_name` varchar(500) NOT NULL,
  `restaurants_photo_file_name` varchar(500) NOT NULL,
  `restaurants_photo_ids` varchar(500) NOT NULL,
  `restaurants_genre_ids` varchar(500) NOT NULL,
  `restaurants_tag_ids` varchar(500) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `additional_price` int(11) NOT NULL,
  `basic_price` int(11) NOT NULL,
  `set_menu_id` int(11) NOT NULL,
  `set_menu_name` varchar(500) NOT NULL,
  `set_menus_photo_file_name` varchar(500) NOT NULL,
  `set_menus_photo_ids` varchar(500) NOT NULL,
  `yearmonth` int(6) NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8
/*!50500 PARTITION BY RANGE  COLUMNS(created)
(PARTITION p201601 VALUES LESS THAN ('2016-01-01') ENGINE = InnoDB,
 PARTITION p201602 VALUES LESS THAN ('2016-02-01') ENGINE = InnoDB,
 PARTITION p201603 VALUES LESS THAN ('2016-03-01') ENGINE = InnoDB,
 PARTITION p201604 VALUES LESS THAN ('2016-04-01') ENGINE = InnoDB,
 PARTITION p201605 VALUES LESS THAN ('2016-05-01') ENGINE = InnoDB,
 PARTITION p201606 VALUES LESS THAN ('2016-06-01') ENGINE = InnoDB,
 PARTITION p201607 VALUES LESS THAN ('2016-07-01') ENGINE = InnoDB,
 PARTITION p201608 VALUES LESS THAN ('2016-08-01') ENGINE = InnoDB,
 PARTITION p201609 VALUES LESS THAN ('2016-09-01') ENGINE = InnoDB,
 PARTITION p201610 VALUES LESS THAN ('2016-10-01') ENGINE = InnoDB,
 PARTITION p201611 VALUES LESS THAN ('2016-11-01') ENGINE = InnoDB,
 PARTITION p201612 VALUES LESS THAN ('2016-12-01') ENGINE = InnoDB,
 PARTITION p201701 VALUES LESS THAN ('2017-01-01') ENGINE = InnoDB,
 PARTITION p201702 VALUES LESS THAN ('2017-02-01') ENGINE = InnoDB,
 PARTITION p201703 VALUES LESS THAN ('2017-03-01') ENGINE = InnoDB,
 PARTITION p201704 VALUES LESS THAN ('2017-04-01') ENGINE = InnoDB,
 PARTITION p201705 VALUES LESS THAN ('2017-05-01') ENGINE = InnoDB,
 PARTITION p201706 VALUES LESS THAN ('2017-06-01') ENGINE = InnoDB,
 PARTITION p201707 VALUES LESS THAN ('2017-07-01') ENGINE = InnoDB,
 PARTITION p201708 VALUES LESS THAN ('2017-08-01') ENGINE = InnoDB,
 PARTITION p201709 VALUES LESS THAN ('2017-09-01') ENGINE = InnoDB,
 PARTITION p201710 VALUES LESS THAN ('2017-10-01') ENGINE = InnoDB,
 PARTITION p201711 VALUES LESS THAN ('2017-11-01') ENGINE = InnoDB,
 PARTITION p201712 VALUES LESS THAN ('2017-12-01') ENGINE = InnoDB,
 PARTITION p201801 VALUES LESS THAN ('2018-01-01') ENGINE = InnoDB,
 PARTITION p201802 VALUES LESS THAN ('2018-02-01') ENGINE = InnoDB,
 PARTITION p201803 VALUES LESS THAN ('2018-03-01') ENGINE = InnoDB,
 PARTITION p201804 VALUES LESS THAN ('2018-04-01') ENGINE = InnoDB,
 PARTITION p201805 VALUES LESS THAN ('2018-05-01') ENGINE = InnoDB,
 PARTITION p201806 VALUES LESS THAN ('2018-06-01') ENGINE = InnoDB,
 PARTITION p201807 VALUES LESS THAN ('2018-07-01') ENGINE = InnoDB,
 PARTITION p201808 VALUES LESS THAN ('2018-08-01') ENGINE = InnoDB,
 PARTITION p201809 VALUES LESS THAN ('2018-09-01') ENGINE = InnoDB,
 PARTITION p201810 VALUES LESS THAN ('2018-10-01') ENGINE = InnoDB,
 PARTITION p201811 VALUES LESS THAN ('2018-11-01') ENGINE = InnoDB,
 PARTITION p201812 VALUES LESS THAN ('2018-12-01') ENGINE = InnoDB,
 PARTITION p201901 VALUES LESS THAN ('2019-01-01') ENGINE = InnoDB,
 PARTITION p201902 VALUES LESS THAN ('2019-02-01') ENGINE = InnoDB,
 PARTITION p201903 VALUES LESS THAN ('2019-03-01') ENGINE = InnoDB,
 PARTITION p201904 VALUES LESS THAN ('2019-04-01') ENGINE = InnoDB,
 PARTITION p201905 VALUES LESS THAN ('2019-05-01') ENGINE = InnoDB,
 PARTITION p201906 VALUES LESS THAN ('2019-06-01') ENGINE = InnoDB,
 PARTITION p201907 VALUES LESS THAN ('2019-07-01') ENGINE = InnoDB,
 PARTITION p201908 VALUES LESS THAN ('2019-08-01') ENGINE = InnoDB,
 PARTITION p201909 VALUES LESS THAN ('2019-09-01') ENGINE = InnoDB,
 PARTITION p201910 VALUES LESS THAN ('2019-10-01') ENGINE = InnoDB,
 PARTITION p201911 VALUES LESS THAN ('2019-11-01') ENGINE = InnoDB,
 PARTITION p201912 VALUES LESS THAN ('2019-12-01') ENGINE = InnoDB,
 PARTITION p202001 VALUES LESS THAN ('2020-01-01') ENGINE = InnoDB,
 PARTITION p202002 VALUES LESS THAN ('2020-02-01') ENGINE = InnoDB,
 PARTITION p202003 VALUES LESS THAN ('2020-03-01') ENGINE = InnoDB,
 PARTITION p202004 VALUES LESS THAN ('2020-04-01') ENGINE = InnoDB,
 PARTITION p202005 VALUES LESS THAN ('2020-05-01') ENGINE = InnoDB,
 PARTITION p202006 VALUES LESS THAN ('2020-06-01') ENGINE = InnoDB,
 PARTITION p202007 VALUES LESS THAN ('2020-07-01') ENGINE = InnoDB,
 PARTITION p202008 VALUES LESS THAN ('2020-08-01') ENGINE = InnoDB,
 PARTITION p202009 VALUES LESS THAN ('2020-09-01') ENGINE = InnoDB,
 PARTITION p202010 VALUES LESS THAN ('2020-10-01') ENGINE = InnoDB,
 PARTITION p202011 VALUES LESS THAN ('2020-11-01') ENGINE = InnoDB,
 PARTITION p202012 VALUES LESS THAN ('2020-12-01') ENGINE = InnoDB,
 PARTITION p202101 VALUES LESS THAN ('2021-01-01') ENGINE = InnoDB,
 PARTITION p202102 VALUES LESS THAN ('2021-02-01') ENGINE = InnoDB,
 PARTITION p202103 VALUES LESS THAN ('2021-03-01') ENGINE = InnoDB,
 PARTITION p202104 VALUES LESS THAN ('2021-04-01') ENGINE = InnoDB,
 PARTITION p202105 VALUES LESS THAN ('2021-05-01') ENGINE = InnoDB,
 PARTITION p202106 VALUES LESS THAN ('2021-06-01') ENGINE = InnoDB,
 PARTITION p202107 VALUES LESS THAN ('2021-07-01') ENGINE = InnoDB,
 PARTITION p202108 VALUES LESS THAN ('2021-08-01') ENGINE = InnoDB,
 PARTITION p202109 VALUES LESS THAN ('2021-09-01') ENGINE = InnoDB,
 PARTITION p202110 VALUES LESS THAN ('2021-10-01') ENGINE = InnoDB,
 PARTITION p202111 VALUES LESS THAN ('2021-11-01') ENGINE = InnoDB,
 PARTITION p202112 VALUES LESS THAN ('2021-12-01') ENGINE = InnoDB,
 PARTITION p202201 VALUES LESS THAN ('2022-01-01') ENGINE = InnoDB,
 PARTITION p202202 VALUES LESS THAN ('2022-02-01') ENGINE = InnoDB,
 PARTITION p202203 VALUES LESS THAN ('2022-03-01') ENGINE = InnoDB,
 PARTITION p202204 VALUES LESS THAN ('2022-04-01') ENGINE = InnoDB,
 PARTITION p202205 VALUES LESS THAN ('2022-05-01') ENGINE = InnoDB,
 PARTITION p202206 VALUES LESS THAN ('2022-06-01') ENGINE = InnoDB,
 PARTITION p202207 VALUES LESS THAN ('2022-07-01') ENGINE = InnoDB,
 PARTITION p202208 VALUES LESS THAN ('2022-08-01') ENGINE = InnoDB,
 PARTITION p202209 VALUES LESS THAN ('2022-09-01') ENGINE = InnoDB,
 PARTITION p202210 VALUES LESS THAN ('2022-10-01') ENGINE = InnoDB,
 PARTITION p202211 VALUES LESS THAN ('2022-11-01') ENGINE = InnoDB,
 PARTITION p202212 VALUES LESS THAN ('2022-12-01') ENGINE = InnoDB,
 PARTITION pmax VALUES LESS THAN (MAXVALUE) ENGINE = InnoDB) */;

--
-- テーブルのデータのダンプ `log_coupons_displays`
--

INSERT INTO `log_coupons_displays` (`id`, `employee_id`, `authenticated_status_flg`, `company_id`, `user_id`, `users_profile_id`, `family_name`, `first_name`, `department_id`, `department_ids`, `department_name`, `location_id`, `location_name`, `location_ids`, `restaurant_id`, `restaurant_name`, `restaurants_photo_file_name`, `restaurants_photo_ids`, `restaurants_genre_ids`, `restaurants_tag_ids`, `coupon_id`, `total_price`, `additional_price`, `basic_price`, `set_menu_id`, `set_menu_name`, `set_menus_photo_file_name`, `set_menus_photo_ids`, `yearmonth`, `del_flg`, `created`, `modified`) VALUES
(1, '1', 1, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201602, 0, '2016-02-28 15:40:40', '2016-02-28 15:40:40'),
(2, '1', 0, 2, 1, 1, 'test1', 'test1', 6, '6,5,4', '人事', 3, '本社', '3,2', 4, 'yoncha cafe', 'restaurant_4_1.jpg', '10,11,12,13', '2,3,4,1', '10,1,2,3', 10, 500, 300, 200, 10, 'チキンと野菜のグラタンセット', 'set_menu_10_1.jpg', '10', 201603, 0, '2016-03-20 18:39:52', '2016-03-20 18:39:52'),
(3, '1', 1, 2, 1, 1, 'test1', 'test1', 6, '6,5,4', '人事', 3, '本社', '3,2', 4, 'yoncha cafe', 'restaurant_4_1.jpg', '10,11,12,13', '2,3,4,1', '10,1,2,3', 10, 500, 300, 200, 10, 'チキンと野菜のグラタンセット', 'set_menu_10_1.jpg', '10', 201603, 0, '2016-03-20 18:40:11', '2016-03-20 18:40:11'),
(4, '2', 0, 2, 2, 2, 'test2', 'test2', 6, '6', '人事', 3, '本社', '3', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 3, 500, 300, 200, 3, 'チキンと野菜の\nグラタンセット', 'set_menu_3_1.jpg', '3', 201603, 0, '2016-03-26 13:04:43', '2016-03-26 13:04:43'),
(5, '2', 1, 2, 2, 2, 'test2', 'test2', 6, '6', '人事', 3, '本社', '3', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 3, 500, 300, 200, 3, 'チキンと野菜の\nグラタンセット', 'set_menu_3_1.jpg', '3', 201603, 0, '2016-03-26 13:04:48', '2016-03-26 13:04:48'),
(6, '1', 0, 2, 1, 1, 'test1@', 'test1@', 5, '5', '技術', 3, '本社', '3', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 3, 500, 300, 200, 3, 'チキンと野菜の\nグラタンセット', 'set_menu_3_1.jpg', '3', 201603, 0, '2016-03-26 13:09:12', '2016-03-26 13:09:12'),
(7, '1', 1, 2, 1, 1, 'test1@', 'test1@', 5, '5', '技術', 3, '本社', '3', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 3, 500, 300, 200, 3, 'チキンと野菜の\nグラタンセット', 'set_menu_3_1.jpg', '3', 201603, 0, '2016-03-26 13:09:25', '2016-03-26 13:09:25'),
(8, '7', 0, 2, 7, 7, 'test7', 'test7', 4, '4', '営業', 3, '本社', '3', 14, '14cha cafe', 'restaurant_14_1.jpg', '41,42,43', '2,3,4', '1,2,3', 43, 900, 700, 200, 43, 'チキンと野菜のグラタンセット', 'set_menu_43_1.jpg', '43', 201603, 0, '2016-03-26 17:58:48', '2016-03-26 17:58:48'),
(9, '7', 0, 2, 7, 7, 'test7', 'test7', 4, '4', '営業', 3, '本社', '3', 14, '14cha cafe', 'restaurant_14_1.jpg', '41,42,43', '2,3,4', '1,2,3', 43, 900, 700, 200, 43, 'チキンと野菜のグラタンセット', 'set_menu_43_1.jpg', '43', 201603, 0, '2016-03-26 17:59:05', '2016-03-26 17:59:05');

-- --------------------------------------------------------

--
-- テーブルの構造 `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `message` varchar(2000) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `important_flg` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `del_flg` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `message`, `start_date`, `end_date`, `important_flg`, `created`, `modified`, `del_flg`) VALUES
(1, '<red>test1</red>', 'test1', '2016-04-16 17:13:00', '2016-05-16 17:13:00', 1, '2016-04-16 17:13:34', '2016-04-16 17:13:34', 0),
(2, 'test2', 'test2', '2016-05-16 17:13:00', '2016-06-16 17:13:00', 0, '2016-04-16 17:14:13', '2016-04-16 17:14:13', 0),
(3, 'test3', 'test3', '2016-04-16 17:47:00', '2016-04-24 17:47:00', 0, '2016-04-16 17:48:12', '2016-04-16 17:48:24', 0),
(4, 'test4', 'test4', '2016-04-16 17:48:00', '2016-07-16 17:48:00', 1, '2016-04-16 17:48:39', '2016-04-16 17:48:39', 0),
(5, 'test5', 'test5', '2016-04-16 17:48:00', '2016-04-17 17:48:00', 0, '2016-04-16 17:48:54', '2016-04-16 17:48:54', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `prefectures`
--

DROP TABLE IF EXISTS `prefectures`;
CREATE TABLE `prefectures` (
  `id` int(11) NOT NULL,
  `name` char(12) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `prefectures`
--

INSERT INTO `prefectures` (`id`, `name`, `del_flg`, `created`, `modified`) VALUES
(1, '北海道', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, '青森県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, '岩手県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, '宮城県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, '秋田県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, '山形県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, '福島県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, '茨城県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, '栃木県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, '群馬県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, '埼玉県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, '千葉県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, '東京都', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, '神奈川県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, '新潟県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, '富山県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, '石川県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, '福井県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, '山梨県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, '長野県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, '岐阜県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, '静岡県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, '愛知県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, '三重県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, '滋賀県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, '京都府', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, '大阪府', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, '兵庫県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, '奈良県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, '和歌山県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, '鳥取県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, '島根県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, '岡山県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, '広島県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, '山口県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, '徳島県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, '香川県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, '愛媛県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, '高知県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, '福岡県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, '佐賀県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, '長崎県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, '熊本県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, '大分県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, '宮崎県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, '鹿児島県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, '沖縄県', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `address` varchar(500) NOT NULL,
  `phone_num` varchar(500) NOT NULL,
  `seats_num` varchar(500) NOT NULL,
  `regular_holiday` varchar(500) NOT NULL,
  `url` varchar(500) NOT NULL,
  `lunch_time` varchar(500) NOT NULL,
  `open_time` varchar(500) NOT NULL,
  `smoke_flg` int(11) NOT NULL,
  `reservation_flg` int(11) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `description`, `start_date`, `end_date`, `address`, `phone_num`, `seats_num`, `regular_holiday`, `url`, `lunch_time`, `open_time`, `smoke_flg`, `reservation_flg`, `del_flg`, `created`, `modified`) VALUES
(1, 'ichicha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00'),
(2, 'nicha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00'),
(3, 'sancha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00'),
(4, 'yoncha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00'),
(5, 'gocha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00'),
(6, 'rokucha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00'),
(7, 'nanacha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00'),
(8, 'hachicha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00'),
(9, 'kyucha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00'),
(10, 'jucha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00'),
(11, '11cha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00'),
(12, '12cha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00'),
(13, '13cha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00'),
(14, '14cha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00'),
(15, '15cha cafe', 'アクセスしやすい隠れ家カフェ！季節の野菜をたっぷり使ったおいしいグラタンをご用意してお待ちしています。', '2016-01-01 00:00:00', '2017-01-01 00:00:00', '東京都渋谷区若林3-11-60', '03-1234-5678', '店内10席（カウンター5席）、テラス5席', '水曜日', 'http://tabelog.com/tokyo/A1317/A131706/13101480/', '月〜金：11:30 ~ 14:00、土日：10:00 ~ 14:00', '月〜金：08:30 ~ 22:00、土日：09:00 ~ 22:00', 0, 0, 0, '2015-12-01 00:00:00', '2015-12-01 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `restaurants_genres`
--

DROP TABLE IF EXISTS `restaurants_genres`;
CREATE TABLE `restaurants_genres` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `restaurants_genres`
--

INSERT INTO `restaurants_genres` (`id`, `name`, `del_flg`, `created`, `modified`) VALUES
(1, 'イタリアン', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(2, '和食', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(3, '中華', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(4, 'フレンチ', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `restaurants_genres_relations`
--

DROP TABLE IF EXISTS `restaurants_genres_relations`;
CREATE TABLE `restaurants_genres_relations` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `priority_order` int(11) NOT NULL,
  `restaurants_genre_id` int(11) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `restaurants_genres_relations`
--

INSERT INTO `restaurants_genres_relations` (`id`, `restaurant_id`, `priority_order`, `restaurants_genre_id`, `del_flg`, `created`, `modified`) VALUES
(1, 1, 1, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(2, 1, 2, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(3, 1, 3, 4, 0, '2016-01-01 00:00:00', '2016-01-24 23:30:25'),
(4, 2, 1, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(5, 2, 2, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(6, 2, 3, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(7, 3, 1, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(8, 3, 2, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(9, 3, 3, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(10, 4, 1, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(11, 4, 2, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(12, 4, 3, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(13, 4, 4, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(14, 5, 1, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(15, 5, 2, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(16, 5, 3, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(17, 6, 1, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(18, 6, 2, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(19, 6, 3, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(20, 7, 1, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(21, 7, 2, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(22, 7, 3, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(23, 8, 1, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(24, 8, 2, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(25, 8, 3, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(26, 9, 1, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(27, 9, 2, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(28, 9, 3, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(29, 10, 1, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(30, 10, 2, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(31, 10, 3, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(32, 11, 1, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(33, 11, 2, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(34, 11, 3, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(35, 12, 1, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(36, 12, 2, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(37, 12, 3, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(38, 13, 1, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(39, 13, 2, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(40, 13, 3, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(41, 14, 1, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(42, 14, 2, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(43, 14, 3, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(44, 15, 1, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(45, 15, 2, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(46, 15, 3, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `restaurants_photos`
--

DROP TABLE IF EXISTS `restaurants_photos`;
CREATE TABLE `restaurants_photos` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `priority_order` int(11) NOT NULL,
  `file_name` varchar(500) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `restaurants_photos`
--

INSERT INTO `restaurants_photos` (`id`, `restaurant_id`, `priority_order`, `file_name`, `del_flg`, `created`, `modified`) VALUES
(1, 1, 3, 'restaurant_1_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-24 22:13:47'),
(2, 1, 2, 'restaurant_1_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-24 22:13:02'),
(3, 1, 1, 'restaurant_1_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(4, 2, 1, 'restaurant_2_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(5, 2, 4, 'restaurant_2_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-24 22:09:22'),
(6, 2, 3, 'restaurant_2_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(7, 3, 1, 'restaurant_3_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(8, 3, 2, 'restaurant_3_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(9, 3, 3, 'restaurant_3_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(10, 4, 1, 'restaurant_4_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(11, 4, 2, 'restaurant_4_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(12, 4, 3, 'restaurant_4_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(13, 4, 4, 'restaurant_4_4.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(14, 5, 1, 'restaurant_5_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(16, 5, 3, 'restaurant_5_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(17, 6, 1, 'restaurant_6_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(18, 6, 2, 'restaurant_6_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(19, 6, 3, 'restaurant_6_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(20, 7, 1, 'restaurant_7_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(21, 7, 2, 'restaurant_7_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(22, 7, 3, 'restaurant_7_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(23, 8, 1, 'restaurant_8_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(24, 8, 2, 'restaurant_8_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(25, 8, 3, 'restaurant_8_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(26, 9, 1, 'restaurant_9_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(27, 9, 2, 'restaurant_9_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(28, 9, 3, 'restaurant_9_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(29, 10, 1, 'restaurant_10_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(30, 10, 2, 'restaurant_10_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(31, 10, 3, 'restaurant_10_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(32, 11, 1, 'restaurant_11_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(33, 11, 2, 'restaurant_11_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(34, 11, 3, 'restaurant_11_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(35, 12, 1, 'restaurant_12_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(36, 12, 2, 'restaurant_12_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(37, 12, 3, 'restaurant_12_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(38, 13, 1, 'restaurant_13_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(39, 13, 2, 'restaurant_13_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(40, 13, 3, 'restaurant_13_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(41, 14, 1, 'restaurant_14_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(42, 14, 2, 'restaurant_14_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(43, 14, 3, 'restaurant_14_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(44, 15, 1, 'restaurant_15_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(45, 15, 2, 'restaurant_15_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(46, 15, 3, 'restaurant_15_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `restaurants_tags`
--

DROP TABLE IF EXISTS `restaurants_tags`;
CREATE TABLE `restaurants_tags` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `color_id` int(11) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `restaurants_tags`
--

INSERT INTO `restaurants_tags` (`id`, `name`, `color_id`, `del_flg`, `created`, `modified`) VALUES
(1, '栄養バランスばっちり', 3, 0, '2016-01-01 00:00:00', '2016-01-24 23:34:56'),
(2, '低カロリー', 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(3, 'ガッツリ！', 1, 0, '2016-01-01 00:00:00', '2016-01-24 23:35:06'),
(4, 'オシャレ', 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(5, 'カフェ系', 5, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(6, '野菜たっぷり系', 6, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(7, '静か系', 7, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(8, '華やか系', 8, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(9, '元気でる系', 9, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(10, '楽しい系', 10, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `restaurants_tags_relations`
--

DROP TABLE IF EXISTS `restaurants_tags_relations`;
CREATE TABLE `restaurants_tags_relations` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `priority_order` int(11) NOT NULL,
  `restaurants_tag_id` int(11) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `restaurants_tags_relations`
--

INSERT INTO `restaurants_tags_relations` (`id`, `restaurant_id`, `priority_order`, `restaurants_tag_id`, `del_flg`, `created`, `modified`) VALUES
(1, 1, 3, 1, 0, '2016-01-01 00:00:00', '2016-01-24 23:32:46'),
(2, 1, 2, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(3, 1, 1, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(4, 2, 1, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(5, 2, 2, 5, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(6, 2, 3, 6, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(7, 3, 1, 7, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(8, 3, 2, 8, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(9, 3, 3, 9, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(10, 4, 1, 10, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(11, 4, 2, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(12, 4, 3, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(13, 4, 4, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(14, 5, 1, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(15, 5, 2, 5, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(16, 5, 3, 6, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(17, 6, 1, 7, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(18, 6, 2, 8, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(19, 6, 3, 9, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(20, 7, 1, 10, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(21, 7, 2, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(22, 7, 3, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(23, 8, 1, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(24, 8, 2, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(25, 8, 3, 5, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(26, 9, 1, 6, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(27, 9, 2, 7, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(28, 9, 3, 8, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(29, 10, 1, 9, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(30, 10, 2, 10, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(31, 10, 3, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(32, 11, 1, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(33, 11, 2, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(34, 11, 3, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(35, 12, 1, 5, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(36, 12, 2, 6, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(37, 12, 3, 7, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(38, 13, 1, 8, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(39, 13, 2, 9, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(40, 13, 3, 10, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(41, 14, 1, 1, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(42, 14, 2, 2, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(43, 14, 3, 3, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(44, 15, 1, 4, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(45, 15, 2, 5, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(46, 15, 3, 6, 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `set_menus`
--

DROP TABLE IF EXISTS `set_menus`;
CREATE TABLE `set_menus` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `set_menus`
--

INSERT INTO `set_menus` (`id`, `name`, `description`, `del_flg`, `created`, `modified`) VALUES
(1, 'チキンと野菜の\nグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(2, 'チキンと野菜\nのグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(3, 'チキンと野菜の\nグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(4, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(5, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(6, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(7, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(8, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(9, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(10, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(11, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(12, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(13, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(14, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(15, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(16, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(17, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(18, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(19, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(20, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(21, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(22, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(23, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(24, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(25, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(26, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(27, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(28, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(29, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(30, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(31, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(32, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(33, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(34, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(35, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(36, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(37, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(38, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(39, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(40, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(41, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(42, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(43, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(44, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(45, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(46, 'チキンと野菜のグラタンセット', '栄養バランスばっちりのグラタン！ドリンクとサラダ付き！', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `set_menus_photos`
--

DROP TABLE IF EXISTS `set_menus_photos`;
CREATE TABLE `set_menus_photos` (
  `id` int(11) NOT NULL,
  `set_menu_id` int(11) NOT NULL,
  `priority_order` int(11) NOT NULL,
  `file_name` varchar(500) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `set_menus_photos`
--

INSERT INTO `set_menus_photos` (`id`, `set_menu_id`, `priority_order`, `file_name`, `del_flg`, `created`, `modified`) VALUES
(1, 1, 1, 'set_menu_1_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(2, 2, 1, 'set_menu_2_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(3, 3, 1, 'set_menu_3_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(4, 4, 1, 'set_menu_4_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(5, 5, 1, 'set_menu_5_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(6, 6, 1, 'set_menu_6_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(7, 7, 1, 'set_menu_7_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(8, 8, 1, 'set_menu_8_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(9, 9, 1, 'set_menu_9_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(10, 10, 1, 'set_menu_10_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(11, 11, 1, 'set_menu_11_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(12, 12, 1, 'set_menu_12_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(13, 13, 1, 'set_menu_13_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(14, 14, 1, 'set_menu_14_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(15, 15, 1, 'set_menu_15_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(16, 16, 1, 'set_menu_16_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(17, 17, 1, 'set_menu_17_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(18, 18, 1, 'set_menu_18_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(19, 19, 1, 'set_menu_19_4.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(20, 20, 1, 'set_menu_20_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(21, 21, 1, 'set_menu_21_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(22, 22, 1, 'set_menu_22_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(23, 23, 1, 'set_menu_23_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(24, 24, 1, 'set_menu_24_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(25, 25, 1, 'set_menu_25_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(26, 26, 1, 'set_menu_26_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(27, 27, 1, 'set_menu_27_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(28, 28, 1, 'set_menu_28_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(29, 29, 1, 'set_menu_29_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(30, 30, 1, 'set_menu_30_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(31, 31, 1, 'set_menu_31_2.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(32, 32, 1, 'set_menu_32_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(33, 33, 1, 'set_menu_33_3.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(34, 34, 1, 'set_menu_34_4.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(35, 35, 1, 'set_menu_35_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(36, 36, 1, 'set_menu_36_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(37, 37, 1, 'set_menu_37_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(38, 38, 1, 'set_menu_38_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(39, 39, 1, 'set_menu_39_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(40, 40, 1, 'set_menu_40_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(41, 41, 1, 'set_menu_41_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(42, 42, 1, 'set_menu_42_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(43, 43, 1, 'set_menu_43_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(44, 44, 1, 'set_menu_44_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(45, 45, 1, 'set_menu_45_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00'),
(46, 46, 1, 'set_menu_46_1.jpg', 0, '2016-01-01 00:00:00', '2016-01-01 00:00:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `company_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '1',
  `employee_id` varchar(500) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `company_id`, `group_id`, `employee_id`, `del_flg`, `created`, `modified`) VALUES
(1, 'test1@test1.com', 'e23810feb24f9e0e5471b64b6ad99ebfe24fda07', 2, 1, 'GEECHS1', 0, '2016-02-09 21:38:48', '2016-03-26 19:48:05'),
(2, 'test2@test2.com', '25a2e050fd251afe2df3999845bf4517c45dec5d', 2, 1, '2', 0, '2016-02-09 21:38:58', '2016-03-26 13:41:14'),
(3, 'test3@test3.com', '8ec8d79ae8d625b37c04cb43f523e500fa42d38c', 2, 1, '3', 0, '2016-02-09 21:39:06', '2016-03-26 15:14:13'),
(4, 'test4@test4.com', 'd691b1fc68d9ddc4c7b35b292b4db43acc817e40', 2, 1, '4', 0, '2016-02-09 21:39:17', '2016-03-26 15:18:14'),
(5, 'test5@test5.com', '396e0acf6d5eb358b69763a0e47051465e8f6751', 2, 1, '5', 0, '2016-02-09 21:39:26', '2016-03-26 15:19:38'),
(6, 'test6@test6.com', '8ef963e91a69e52adb3266dc0cbf3257a1ccc4b0', 2, 1, '6', 0, '2016-02-09 21:39:35', '2016-03-26 15:21:09'),
(7, 'test7@test7.com', 'b9ae2c24ad63dc52d97d9170c716fa3ec8e3d36a', 2, 1, '7', 0, '2016-03-20 23:20:13', '2016-03-26 17:58:06'),
(8, 'test8@test8.com', '5eb7bc0c8c4d5fd36b12f5023b1163fb6de64d2d', 2, 1, '8', 0, '2016-03-20 23:36:03', '2016-03-20 23:36:03'),
(9, 'test9@test9.com', 'aea4ee4599bd15a052c6e7adbca9ec9b3e638e18', 2, 1, '9', 0, '2016-03-20 23:38:04', '2016-03-20 23:38:04'),
(10, 'test10@test10.com', 'rpqwiurp23578GJKJ70873iwghsdghshgphgotesttest10', 2, 0, '10', 0, '2016-03-21 00:14:38', '2016-03-21 00:14:38'),
(11, 'test11@test11.com', '1f9c3ea7942dad611ab090127f89de7e190f2150', 2, 0, '11', 0, '2016-03-21 00:44:11', '2016-03-21 00:44:11'),
(12, 'test12@test12.com', '2dca3495207b7b05dd676d0a2339aea56f692ec4', 2, 0, '12', 0, '2016-03-21 00:55:39', '2016-03-21 00:55:39'),
(13, 'test13@test13.com', '86909ce50b274daaa4e576651a6f985c288d2694', 2, 0, '13', 0, '2016-03-21 01:07:52', '2016-03-21 01:07:52'),
(14, 'test14@test14.com', 'd2d54759ba517a139418edc558f529e638a61fd5', 2, 0, '14', 0, '2016-03-26 18:52:09', '2016-03-26 18:52:09'),
(15, 'test15@test15.com', '71aed770e519c8dc24d4e4c0f88d686c81403d3d', 2, 1, '15', 0, '2016-03-26 18:57:20', '2016-03-26 18:57:20'),
(16, 'test16@test16.com', '92a86987a7d8a1620807941c6c1eca2bd456ea76', 2, 1, '16', 0, '2016-03-26 19:00:14', '2016-03-26 19:00:14'),
(17, 'test17@test17.com', '8ad40897448e4972d6ab269d06a890e5938c5c0d', 2, 1, '17', 0, '2016-03-26 19:01:54', '2016-03-26 19:01:54'),
(19, 'test18@test18.com', 'ca33b15383b9be756aeaa7787d04445d4cc7cc98', 2, 0, '18', 0, '2016-03-26 19:30:10', '2016-03-26 19:30:10'),
(20, 'test18@test18.com', 'ca33b15383b9be756aeaa7787d04445d4cc7cc98', 2, 0, '18', 0, '2016-03-26 19:31:05', '2016-03-26 19:31:05'),
(21, 'test100@test100.com', '3025ac0316283664939fec2c60c7e0718b58e38b', 2, 0, '100', 0, '2016-03-26 19:32:00', '2016-03-26 19:32:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `users_companies_departments_relations`
--

DROP TABLE IF EXISTS `users_companies_departments_relations`;
CREATE TABLE `users_companies_departments_relations` (
  `id` int(11) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `priority_order` int(11) NOT NULL,
  `companies_department_id` int(11) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users_companies_departments_relations`
--

INSERT INTO `users_companies_departments_relations` (`id`, `user_id`, `priority_order`, `companies_department_id`, `del_flg`, `created`, `modified`) VALUES
(3, 3, 1, 4, 0, '2016-02-07 21:35:11', '2016-02-07 21:35:11'),
(5, 1, 1, 4, 0, '2016-02-09 21:34:04', '2016-03-26 19:48:05'),
(7, 2, 1, 6, 0, '2016-02-09 21:36:20', '2016-02-09 21:36:20'),
(16, 4, 1, 5, 0, '2016-02-09 21:39:17', '2016-02-09 21:39:17'),
(18, 5, 1, 5, 0, '2016-02-09 21:39:26', '2016-02-09 21:39:26'),
(20, 6, 1, 5, 0, '2016-02-09 21:39:35', '2016-02-09 21:39:35'),
(22, 7, 1, 4, 0, '2016-03-20 23:20:13', '2016-03-20 23:20:13'),
(23, 8, 1, 4, 0, '2016-03-20 23:36:03', '2016-03-20 23:36:03'),
(24, 9, 1, 5, 0, '2016-03-20 23:38:04', '2016-03-20 23:38:04'),
(25, 10, 1, 4, 0, '2016-03-21 00:44:11', '2016-03-21 00:44:11'),
(26, 11, 1, 4, 0, '2016-03-21 00:55:39', '2016-03-21 00:55:39'),
(27, 12, 1, 4, 0, '2016-03-21 01:07:52', '2016-03-21 01:07:52'),
(28, 13, 1, 4, 0, '2016-03-21 12:50:06', '2016-03-21 12:50:06'),
(29, 14, 1, 5, 0, '2016-03-26 18:44:49', '2016-03-26 18:44:49'),
(30, 15, 1, 6, 0, '2016-03-26 18:57:20', '2016-03-26 18:57:20'),
(31, 16, 1, 5, 0, '2016-03-26 19:00:14', '2016-03-26 19:00:14'),
(32, 17, 1, 5, 0, '2016-03-26 19:01:54', '2016-03-26 19:01:54'),
(34, 19, 1, 4, 0, '2016-03-26 19:30:10', '2016-03-26 19:30:10'),
(35, 20, 1, 4, 0, '2016-03-26 19:31:05', '2016-03-26 19:31:05'),
(36, 21, 1, 4, 0, '2016-03-26 19:32:00', '2016-03-26 19:32:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `users_companies_locations_relations`
--

DROP TABLE IF EXISTS `users_companies_locations_relations`;
CREATE TABLE `users_companies_locations_relations` (
  `id` int(11) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `priority_order` int(11) NOT NULL,
  `companies_location_id` int(11) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users_companies_locations_relations`
--

INSERT INTO `users_companies_locations_relations` (`id`, `user_id`, `priority_order`, `companies_location_id`, `del_flg`, `created`, `modified`) VALUES
(1, 1, 1, 3, 0, '2016-02-07 21:34:51', '2016-03-26 19:48:05'),
(2, 2, 1, 3, 0, '2016-02-07 21:35:01', '2016-02-07 21:35:01'),
(3, 3, 1, 2, 0, '2016-02-07 21:35:11', '2016-02-07 21:35:11'),
(10, 4, 1, 4, 0, '2016-02-09 21:39:17', '2016-02-09 21:39:17'),
(11, 5, 1, 4, 0, '2016-02-09 21:39:26', '2016-02-09 21:39:26'),
(12, 6, 1, 4, 0, '2016-02-09 21:39:35', '2016-02-09 21:39:35'),
(13, 7, 1, 3, 0, '2016-03-20 23:20:13', '2016-03-20 23:20:13'),
(14, 8, 1, 3, 0, '2016-03-20 23:36:03', '2016-03-20 23:36:03'),
(15, 9, 1, 4, 0, '2016-03-20 23:38:04', '2016-03-20 23:38:04'),
(16, 10, 1, 3, 0, '2016-03-21 00:44:11', '2016-03-21 00:44:11'),
(17, 11, 1, 3, 0, '2016-03-21 00:55:39', '2016-03-21 00:55:39'),
(18, 12, 1, 3, 0, '2016-03-21 01:07:52', '2016-03-21 01:07:52'),
(19, 13, 1, 3, 0, '2016-03-21 01:07:52', '2016-03-21 01:07:52'),
(20, 14, 1, 4, 0, '2016-03-26 18:44:49', '2016-03-26 18:44:49'),
(21, 18, 1, 4, 0, '2016-03-26 18:57:20', '2016-03-26 18:57:20'),
(22, 16, 1, 4, 0, '2016-03-26 19:00:14', '2016-03-26 19:00:14'),
(23, 17, 1, 4, 0, '2016-03-26 19:01:54', '2016-03-26 19:01:54'),
(25, 19, 1, 3, 0, '2016-03-26 19:30:10', '2016-03-26 19:30:10'),
(26, 20, 1, 3, 0, '2016-03-26 19:31:05', '2016-03-26 19:31:05'),
(27, 21, 1, 3, 0, '2016-03-26 19:32:00', '2016-03-26 19:32:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `users_coupons_consumptions_counts`
--

DROP TABLE IF EXISTS `users_coupons_consumptions_counts`;
CREATE TABLE `users_coupons_consumptions_counts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `yearmonth` int(6) NOT NULL,
  `count` int(11) NOT NULL,
  `last_consumed_coupon_id` int(11) NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users_coupons_consumptions_counts`
--

INSERT INTO `users_coupons_consumptions_counts` (`id`, `user_id`, `yearmonth`, `count`, `last_consumed_coupon_id`, `del_flg`, `created`, `modified`) VALUES
(1, 1, 201602, 1, 1, 0, '2016-02-28 15:40:40', '2016-02-28 15:40:40'),
(2, 1, 201603, 2, 3, 0, '2016-03-20 18:40:11', '2016-03-26 13:09:25'),
(3, 2, 201603, 1, 3, 0, '2016-03-26 13:04:48', '2016-03-26 13:04:48');

-- --------------------------------------------------------

--
-- テーブルの構造 `users_profiles`
--

DROP TABLE IF EXISTS `users_profiles`;
CREATE TABLE `users_profiles` (
  `id` int(11) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `family_name` varchar(500) NOT NULL,
  `first_name` varchar(500) NOT NULL,
  `gender` int(11) NOT NULL,
  `del_flg` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users_profiles`
--

INSERT INTO `users_profiles` (`id`, `user_id`, `family_name`, `first_name`, `gender`, `del_flg`, `created`, `modified`) VALUES
(1, 1, 'test1@@@@', 'test@@@@', 1, 0, '2016-02-07 21:34:51', '2016-03-26 19:48:05'),
(2, 2, 'test2', 'test2', 1, 0, '2016-02-07 21:35:01', '2016-02-07 21:35:01'),
(3, 3, 'test3', 'test3', 1, 0, '2016-02-07 21:35:11', '2016-02-07 21:35:11'),
(4, 4, 'test4', 'test4', 1, 0, '2016-02-09 21:34:04', '2016-02-09 21:34:04'),
(5, 5, 'test5', 'test5', 2, 0, '2016-02-09 21:36:20', '2016-02-09 21:36:20'),
(6, 6, 'test6', 'test6', 2, 0, '2016-02-09 21:38:25', '2016-02-09 21:38:25'),
(7, 7, 'test7', 'test7', 1, 0, '2016-03-20 23:20:13', '2016-03-20 23:20:13'),
(8, 8, 'test8', 'test8', 1, 0, '2016-03-20 23:36:03', '2016-03-20 23:36:03'),
(9, 9, 'test9', 'test9', 2, 0, '2016-03-20 23:38:04', '2016-03-20 23:38:04'),
(10, 10, 'test10', 'test10', 1, 0, '2016-03-21 00:14:38', '2016-03-21 00:14:38'),
(11, 11, 'test11', 'test11', 1, 0, '2016-03-21 00:44:11', '2016-03-21 00:44:11'),
(12, 12, 'test12', 'test12', 1, 0, '2016-03-21 00:55:39', '2016-03-21 00:55:39'),
(13, 13, 'test13', 'test13', 1, 0, '2016-03-21 01:07:52', '2016-03-21 01:07:52'),
(14, 14, 'test14', 'test14', 2, 0, '2016-03-26 18:44:49', '2016-03-26 18:44:49'),
(15, 15, 'test15', 'test15', 1, 0, '2016-03-26 18:57:20', '2016-03-26 18:57:20'),
(16, 16, 'test16', 'test16', 1, 0, '2016-03-26 19:00:14', '2016-03-26 19:00:14'),
(17, 17, 'test17', 'test17', 2, 0, '2016-03-26 19:01:54', '2016-03-26 19:01:54'),
(19, 19, 'test18', 'test18', 1, 0, '2016-03-26 19:30:10', '2016-03-26 19:30:10'),
(20, 20, 'test18', 'test18', 1, 0, '2016-03-26 19:31:05', '2016-03-26 19:31:05'),
(21, 21, 'test100', 'test100', 1, 0, '2016-03-26 19:32:00', '2016-03-26 19:32:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies_departments`
--
ALTER TABLE `companies_departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `companies_locations`
--
ALTER TABLE `companies_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `restaurant_id` (`restaurant_id`,`priority_order`) USING BTREE;

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_coupons_consumptions`
--
ALTER TABLE `log_coupons_consumptions`
  ADD PRIMARY KEY (`id`,`created`) USING BTREE,
  ADD KEY `company_user_idx` (`company_id`,`user_id`),
  ADD KEY `del_flg` (`del_flg`),
  ADD KEY `created` (`created`);

--
-- Indexes for table `log_coupons_displays`
--
ALTER TABLE `log_coupons_displays`
  ADD PRIMARY KEY (`id`,`created`) USING BTREE,
  ADD KEY `company_user_idx` (`company_id`,`user_id`),
  ADD KEY `del_flg` (`del_flg`),
  ADD KEY `created` (`created`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prefectures`
--
ALTER TABLE `prefectures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurants_genres`
--
ALTER TABLE `restaurants_genres`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `restaurants_genres_relations`
--
ALTER TABLE `restaurants_genres_relations`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `restaurant_id` (`restaurant_id`,`priority_order`) USING BTREE;

--
-- Indexes for table `restaurants_photos`
--
ALTER TABLE `restaurants_photos`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `restaurant_id` (`restaurant_id`,`priority_order`);

--
-- Indexes for table `restaurants_tags`
--
ALTER TABLE `restaurants_tags`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `restaurants_tags_relations`
--
ALTER TABLE `restaurants_tags_relations`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `restaurant_id` (`restaurant_id`,`priority_order`) USING BTREE;

--
-- Indexes for table `set_menus`
--
ALTER TABLE `set_menus`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `set_menus_photos`
--
ALTER TABLE `set_menus_photos`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `set_menu_id` (`set_menu_id`,`priority_order`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `multiple_idx` (`email`(255),`password`(255));

--
-- Indexes for table `users_companies_departments_relations`
--
ALTER TABLE `users_companies_departments_relations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `multiple_idx` (`user_id`,`priority_order`) USING BTREE;

--
-- Indexes for table `users_companies_locations_relations`
--
ALTER TABLE `users_companies_locations_relations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `multiple_idx` (`user_id`,`priority_order`) USING BTREE;

--
-- Indexes for table `users_coupons_consumptions_counts`
--
ALTER TABLE `users_coupons_consumptions_counts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `multiple_idx` (`user_id`,`yearmonth`) USING BTREE;

--
-- Indexes for table `users_profiles`
--
ALTER TABLE `users_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `companies_departments`
--
ALTER TABLE `companies_departments`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `companies_locations`
--
ALTER TABLE `companies_locations`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `log_coupons_consumptions`
--
ALTER TABLE `log_coupons_consumptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `log_coupons_displays`
--
ALTER TABLE `log_coupons_displays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `prefectures`
--
ALTER TABLE `prefectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `restaurants_genres`
--
ALTER TABLE `restaurants_genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `restaurants_genres_relations`
--
ALTER TABLE `restaurants_genres_relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `restaurants_photos`
--
ALTER TABLE `restaurants_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `restaurants_tags`
--
ALTER TABLE `restaurants_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `restaurants_tags_relations`
--
ALTER TABLE `restaurants_tags_relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `set_menus`
--
ALTER TABLE `set_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `set_menus_photos`
--
ALTER TABLE `set_menus_photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `users_companies_departments_relations`
--
ALTER TABLE `users_companies_departments_relations`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `users_companies_locations_relations`
--
ALTER TABLE `users_companies_locations_relations`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `users_coupons_consumptions_counts`
--
ALTER TABLE `users_coupons_consumptions_counts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users_profiles`
--
ALTER TABLE `users_profiles`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;