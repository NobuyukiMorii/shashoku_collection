-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: 2016 年 2 月 21 日 22:22
-- サーバのバージョン： 5.5.42
-- PHP Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `LAA0682918-shashoku`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `log_coupons_consumptions`
--

DROP TABLE IF EXISTS `log_coupons_consumptions`;
CREATE TABLE `log_coupons_consumptions` (
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8
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

INSERT INTO `log_coupons_consumptions` (`id`, `company_id`, `user_id`, `users_profile_id`, `family_name`, `first_name`, `department_id`, `department_ids`, `department_name`, `location_id`, `location_name`, `location_ids`, `restaurant_id`, `restaurant_name`, `restaurants_photo_file_name`, `restaurants_photo_ids`, `restaurants_genre_ids`, `restaurants_tag_ids`, `coupon_id`, `total_price`, `additional_price`, `basic_price`, `set_menu_id`, `set_menu_name`, `set_menus_photo_file_name`, `set_menus_photo_ids`, `yearmonth`, `del_flg`, `created`, `modified`) VALUES
(1, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201602, 0, '2016-02-21 15:05:18', '2016-02-21 15:05:18'),
(2, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201602, 0, '2016-02-21 19:43:59', '2016-02-21 19:43:59'),
(3, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201601, 0, '2016-02-21 19:44:38', '2016-02-21 19:44:38'),
(4, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201601, 0, '2016-02-21 19:45:07', '2016-02-21 19:45:07'),
(5, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201601, 0, '2016-02-21 19:45:25', '2016-02-21 19:45:25'),
(6, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201512, 0, '2016-02-21 19:45:31', '2016-02-21 19:45:31'),
(7, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201512, 0, '2016-02-21 19:45:33', '2016-02-21 19:45:33'),
(8, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201512, 0, '2016-02-21 19:45:34', '2016-02-21 19:45:34'),
(9, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201602, 0, '2016-02-21 19:45:36', '2016-02-21 19:45:36'),
(10, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201602, 0, '2016-02-21 19:45:37', '2016-02-21 19:45:37'),
(11, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201508, 0, '2016-02-21 19:45:38', '2016-02-21 19:45:38'),
(12, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201508, 0, '2016-02-21 19:45:39', '2016-02-21 19:45:39'),
(13, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201509, 0, '2016-02-21 19:45:40', '2016-02-21 19:45:40'),
(14, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201509, 0, '2016-02-21 19:45:41', '2016-02-21 19:45:41'),
(15, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201510, 0, '2016-02-21 19:45:41', '2016-02-21 19:45:41'),
(16, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201510, 0, '2016-02-21 19:45:42', '2016-02-21 19:45:42'),
(17, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201510, 0, '2016-02-21 19:45:43', '2016-02-21 19:45:43'),
(18, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201511, 0, '2016-02-21 19:45:44', '2016-02-21 19:45:44'),
(19, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201511, 0, '2016-02-21 19:45:45', '2016-02-21 19:45:45'),
(20, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201512, 0, '2016-02-21 19:45:46', '2016-02-21 19:45:46'),
(21, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201512, 0, '2016-02-21 19:45:47', '2016-02-21 19:45:47'),
(22, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201601, 0, '2016-02-21 19:45:48', '2016-02-21 19:45:48'),
(23, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201601, 0, '2016-02-21 19:45:49', '2016-02-21 19:45:49'),
(24, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201602, 0, '2016-02-21 19:45:49', '2016-02-21 19:45:49'),
(25, 2, 1, 1, 'test', 'test', 6, '6,5,4', '人事', 3, '本社', '3,2', 1, 'ichicha cafe', 'restaurant_1_3.jpg', '3,2,1', '1,2,4', '3,2,1', 1, 600, 400, 200, 1, 'チキンと野菜の\nグラタンセット', 'set_menu_1_1.jpg', '1', 201602, 0, '2016-02-21 19:45:50', '2016-02-21 19:45:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log_coupons_consumptions`
--
ALTER TABLE `log_coupons_consumptions`
  ADD PRIMARY KEY (`id`,`created`) USING BTREE,
  ADD KEY `company_user_idx` (`company_id`,`user_id`),
  ADD KEY `del_flg` (`del_flg`),
  ADD KEY `created` (`created`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log_coupons_consumptions`
--
ALTER TABLE `log_coupons_consumptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;