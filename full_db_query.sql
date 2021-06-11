-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `check_out`;
CREATE TABLE `check_out` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` text COLLATE utf8_unicode_ci NOT NULL,
  `random_id` text COLLATE utf8_unicode_ci NOT NULL,
  `discount_id` int(11) DEFAULT NULL,
  `recive_price` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `discount_cundition`;
CREATE TABLE `discount_cundition` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `discount_code` text COLLATE utf8_unicode_ci NOT NULL,
  `discount_content` text COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `price_condition` int(11) NOT NULL,
  `price` double(8,2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `discount_cundition` (`id`, `discount_code`, `discount_content`, `type`, `price_condition`, `price`, `updated_at`, `created_at`) VALUES
(1,	'tenpErcentOff',	'if check price bigger than condition than get ten percent off',	1,	40000,	0.90,	'2021-06-11 06:00:37',	'2021-06-11 06:00:37'),
(2,	'buy30000get1000Back',	'if check price bigger than condition than get 1000 back',	2,	30000,	1000.00,	'2021-06-11 06:00:37',	'2021-06-11 06:00:37'),
(3,	'buy60000get3000Back',	'if check price bigger than condition than get 3000 back',	2,	60000,	3000.00,	'2021-06-11 06:00:37',	'2021-06-11 06:00:37');

DROP TABLE IF EXISTS `product_list`;
CREATE TABLE `product_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_name` text COLLATE utf8_unicode_ci NOT NULL,
  `img_src` text COLLATE utf8_unicode_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `product_list` (`id`, `product_name`, `img_src`, `stock`, `price`, `updated_at`, `created_at`) VALUES
(1,	'3070',	'images/3070.jpg',	1,	20000,	'2021-06-11 06:00:37',	'2021-06-11 06:00:37'),
(2,	'3080',	'images/3080.jpg',	1,	30000,	'2021-06-11 06:00:37',	'2021-06-11 06:00:37'),
(3,	'3090',	'images/3090.jpg',	2,	40000,	'2021-06-11 06:00:37',	'2021-06-11 06:00:37');

DROP TABLE IF EXISTS `purchased_product_list`;
CREATE TABLE `purchased_product_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `purchased_number` int(11) NOT NULL,
  `check_out_id` text COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- 2021-06-11 06:01:03