-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table tunibibi.address
CREATE TABLE IF NOT EXISTS `address` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` int NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.address: ~0 rows (approximately)

-- Dumping structure for table tunibibi.admins
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'SUPER ADMIN',
  `is_active` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.admins: ~1 rows (approximately)
INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`, `user_type`, `is_active`) VALUES
	(1, 'salauddin@gmail.com', 'salauddin@gmail.com', '$2y$10$oGPVAK3BcioVcaLheCWJf.qKwIyWGu31zhNEVA1U3amPHzTNxmXeq', '2023-07-09 21:22:48', '2023-08-05 12:46:17', 'SUPER ADMIN sss', 1),
	(2, 'Demo ', 'demo@gmail.com', '$2y$10$oGPVAK3BcioVcaLheCWJf.qKwIyWGu31zhNEVA1U3amPHzTNxmXeq', '2023-08-06 03:34:10', '2023-08-06 03:34:10', 'Editor', 1);

-- Dumping structure for table tunibibi.banner
CREATE TABLE IF NOT EXISTS `banner` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.banner: ~0 rows (approximately)
INSERT INTO `banner` (`id`, `image`, `created_at`, `updated_at`) VALUES
	(1, '64b1135590bbb.png', '2023-07-14 03:20:21', '2023-07-14 03:20:21');

-- Dumping structure for table tunibibi.business_types
CREATE TABLE IF NOT EXISTS `business_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.business_types: ~10 rows (approximately)
INSERT INTO `business_types` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
	(1, 'Casper Miller', '64ab79880bfed.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(2, 'Tierra Windler III', '64ab79880db98.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(3, 'Giles Lind', '64ab79880ddc8.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(4, 'Creola Hermiston DDS', '64ab79880df9f.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(5, 'Elinore Stehr', '64ab79880e1e4.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(6, 'Prof. Adaline Konopelski Sr.', '64ab79880e352.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(7, 'Dana Kuhlman DDS', '64ab79880e4c8.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(8, 'Kole Hackett DDS', '64ab79880e630.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(9, 'Carlos Tromp I', '64ab79880e8bc.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(10, 'Luigi Marks', '64ab79880eaac.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48');

-- Dumping structure for table tunibibi.buyers
CREATE TABLE IF NOT EXISTS `buyers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` int NOT NULL DEFAULT '1',
  `date` date NOT NULL DEFAULT '2023-07-10',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `search_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refer_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.buyers: ~1 rows (approximately)
INSERT INTO `buyers` (`id`, `name`, `number`, `password`, `country`, `email`, `address`, `city`, `postcode`, `is_active`, `date`, `created_at`, `updated_at`, `image`, `search_country`, `refer_code`) VALUES
	(3, 'Salauddin', '+8801974780794', '$2y$10$JpwCyxf2SQnIZHyYPGrNuOeqbcABp96UN6WEFDurLYRHGtio.XQJK', 'Bangladesh', NULL, 'Dhaka', NULL, NULL, 1, '2023-07-10', '2023-08-05 11:38:08', '2023-09-07 23:27:12', '64fab0b0db6f0.png', 'Bangladesh', NULL),
	(4, 'SS', '+880197478794', '$2y$10$JpwCyxf2SQnIZHyYPGrNuOeqbcABp96UN6WEFDurLYRHGtio.XQJK', 'Bangladesh', NULL, 'Dhaka', NULL, NULL, 1, '2023-07-10', '2023-08-05 11:38:08', '2023-09-07 23:27:12', '64fab0b0db6f0.png', 'Bangladesh', NULL);

-- Dumping structure for table tunibibi.buyer_banners
CREATE TABLE IF NOT EXISTS `buyer_banners` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.buyer_banners: ~1 rows (approximately)
INSERT INTO `buyer_banners` (`id`, `image`, `is_active`, `created_at`, `updated_at`, `country`) VALUES
	(1, 'abc.png', 1, '2023-07-14 09:22:03', '2023-07-14 09:22:03', '');

-- Dumping structure for table tunibibi.buyer_favourite_names
CREATE TABLE IF NOT EXISTS `buyer_favourite_names` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buyer_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buyer_favourite_names_buyer_id_foreign` (`buyer_id`),
  CONSTRAINT `buyer_favourite_names_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.buyer_favourite_names: ~0 rows (approximately)
INSERT INTO `buyer_favourite_names` (`id`, `name`, `buyer_id`, `created_at`, `updated_at`) VALUES
	(2, 'ABC', 3, '2023-08-30 03:23:57', '2023-08-30 03:23:57'),
	(3, 'ABC', 3, '2023-09-10 00:04:23', '2023-09-10 00:04:23');

-- Dumping structure for table tunibibi.buyer_favourite_products
CREATE TABLE IF NOT EXISTS `buyer_favourite_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `buyer_favourite_names_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `buyer_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `buyer_favourite_products_product_id_foreign` (`product_id`),
  KEY `buyer_favourite_products_buyer_favourite_names_id_foreign` (`buyer_favourite_names_id`),
  CONSTRAINT `buyer_favourite_products_buyer_favourite_names_id_foreign` FOREIGN KEY (`buyer_favourite_names_id`) REFERENCES `buyer_favourite_names` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buyer_favourite_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.buyer_favourite_products: ~0 rows (approximately)
INSERT INTO `buyer_favourite_products` (`id`, `product_id`, `buyer_favourite_names_id`, `created_at`, `updated_at`, `buyer_id`) VALUES
	(9, 1, 2, '2023-09-10 00:06:40', '2023-09-10 00:06:40', 3);

-- Dumping structure for table tunibibi.buyer_payment_methods
CREATE TABLE IF NOT EXISTS `buyer_payment_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` json NOT NULL,
  `extra_note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_bank` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.buyer_payment_methods: ~4 rows (approximately)
INSERT INTO `buyer_payment_methods` (`id`, `name`, `details`, `extra_note`, `country`, `is_bank`, `created_at`, `updated_at`, `logo`) VALUES
	(1, 'bkash', '["abc"]', 'ada', 'Bangladesh', 0, NULL, NULL, 'ABC.png'),
	(2, 'nagad', '["test"]', 'none', 'Bangladesh', 0, NULL, NULL, 'abc.png'),
	(4, 'BKASH', '["1.Scan Code", "2.Then Send Money"]', 'ABC', 'Bangladesh', 1, '2023-09-23 19:51:57', '2023-09-23 19:51:57', '650f963d949fc.png');

-- Dumping structure for table tunibibi.buyer_refer_earnings
CREATE TABLE IF NOT EXISTS `buyer_refer_earnings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint unsigned NOT NULL,
  `coins` int NOT NULL,
  `refer_user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `refered_buyer_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `buyer_refer_earnings_refered_buyer_id_foreign` (`refered_buyer_id`),
  KEY `buyer_refer_earnings_buyer_id_foreign` (`buyer_id`),
  CONSTRAINT `buyer_refer_earnings_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buyer_refer_earnings_refered_buyer_id_foreign` FOREIGN KEY (`refered_buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.buyer_refer_earnings: ~1 rows (approximately)
INSERT INTO `buyer_refer_earnings` (`id`, `buyer_id`, `coins`, `refer_user_type`, `refered_buyer_id`, `created_at`, `updated_at`) VALUES
	(1, 3, 10, '4', 3, '2023-09-16 09:54:33', '2023-09-16 09:55:08');

-- Dumping structure for table tunibibi.buyer_shippings
CREATE TABLE IF NOT EXISTS `buyer_shippings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint unsigned NOT NULL,
  `shipping_package_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.buyer_shippings: ~0 rows (approximately)
INSERT INTO `buyer_shippings` (`id`, `buyer_id`, `shipping_package_id`, `created_at`, `updated_at`) VALUES
	(4, 3, 2, '2023-09-09 01:14:56', '2023-09-09 01:14:56');

-- Dumping structure for table tunibibi.buyer_shipping_addresses
CREATE TABLE IF NOT EXISTS `buyer_shipping_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apartment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` int NOT NULL DEFAULT '0',
  `buyer_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buyer_shipping_addresses_buyer_id_foreign` (`buyer_id`),
  CONSTRAINT `buyer_shipping_addresses_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.buyer_shipping_addresses: ~0 rows (approximately)
INSERT INTO `buyer_shipping_addresses` (`id`, `name1`, `name2`, `mobile`, `street`, `apartment`, `country`, `state`, `city`, `zip`, `is_default`, `buyer_id`, `created_at`, `updated_at`) VALUES
	(1, 'MD', 'Salauddin', '+8801974780794', 'South Bisil,Mirpur-1', 'Road 27', 'Bangladesh', 'Dhaka', 'Dhaka', '1032', 1, 3, '2023-08-05 06:13:08', '2023-08-05 06:13:08');

-- Dumping structure for table tunibibi.buy_nows
CREATE TABLE IF NOT EXISTS `buy_nows` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `shipping_id` bigint unsigned NOT NULL,
  `varient_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `voucher_id` bigint unsigned DEFAULT NULL,
  `varient_info` json NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.buy_nows: ~1 rows (approximately)
INSERT INTO `buy_nows` (`id`, `buyer_id`, `product_id`, `shipping_id`, `varient_id`, `quantity`, `created_at`, `updated_at`, `voucher_id`, `varient_info`) VALUES
	(36, 3, 1, 4, 1, 10, NULL, NULL, NULL, '{"size": "21-inch 16/500", "color": "red", "stock": 3434}');

-- Dumping structure for table tunibibi.buy_togethers
CREATE TABLE IF NOT EXISTS `buy_togethers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `wholesale_id` bigint unsigned NOT NULL,
  `invite_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expire_time` datetime NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `buyer_id` bigint unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `product_varient_id` bigint unsigned DEFAULT NULL,
  `size` json DEFAULT NULL,
  `is_complete` int NOT NULL DEFAULT '0',
  `voucher_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buy_togethers_product_id_foreign` (`product_id`),
  KEY `buy_togethers_wholesale_id_foreign` (`wholesale_id`),
  KEY `buy_togethers_buyer_id_foreign` (`buyer_id`),
  KEY `buy_togethers_product_varient_id_foreign` (`product_varient_id`),
  CONSTRAINT `buy_togethers_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buy_togethers_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buy_togethers_product_varient_id_foreign` FOREIGN KEY (`product_varient_id`) REFERENCES `product_varients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `buy_togethers_wholesale_id_foreign` FOREIGN KEY (`wholesale_id`) REFERENCES `wholesale_prices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.buy_togethers: ~3 rows (approximately)
INSERT INTO `buy_togethers` (`id`, `product_id`, `quantity`, `wholesale_id`, `invite_link`, `expire_time`, `country`, `buyer_id`, `created_at`, `updated_at`, `product_varient_id`, `size`, `is_complete`, `voucher_id`) VALUES
	(9, 1, 10, 2, 'ABC', '2023-09-16 07:09:02', 'Bangladesh', 3, '2023-09-15 01:44:02', '2023-09-15 07:33:27', 1, '{"size": "21-inch 8/256", "color": "red", "stock": 20}', 0, 1),
	(10, 2, 10, 2, 'ABC', '2023-09-16 07:09:22', 'Bangladesh', 3, '2023-09-15 01:44:22', '2023-09-15 13:10:39', 1, '{"size": "21-inch 8/256", "color": "red", "stock": 20}', 0, NULL),
	(11, 3, 10, 2, 'ABC', '2023-09-16 01:09:04', 'Bangladesh', 3, '2023-09-15 07:09:04', '2023-09-15 13:10:41', 1, '{"size": "21-inch 8/256", "color": "red", "stock": 20}', 0, NULL);

-- Dumping structure for table tunibibi.carts
CREATE TABLE IF NOT EXISTS `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint unsigned NOT NULL,
  `buyer_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `variant_id` bigint unsigned NOT NULL,
  `variant_info` json NOT NULL,
  `is_checkout` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `wholesale_id` int DEFAULT '0',
  `is_selected` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `carts_seller_id_foreign` (`seller_id`),
  KEY `carts_buyer_id_foreign` (`buyer_id`),
  KEY `carts_product_id_foreign` (`product_id`),
  KEY `carts_variant_id_foreign` (`variant_id`),
  KEY `carts_wholesale_id_foreign` (`wholesale_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.carts: ~5 rows (approximately)
INSERT INTO `carts` (`id`, `seller_id`, `buyer_id`, `product_id`, `quantity`, `variant_id`, `variant_info`, `is_checkout`, `created_at`, `updated_at`, `wholesale_id`, `is_selected`) VALUES
	(15, 1, 3, 10, 11, 1, '{"size": "21-inch 8/256", "color": "red", "stock": 20}', 0, '2023-09-15 07:40:55', '2023-09-15 16:53:19', 0, 1),
	(16, 1, 3, 10, 7, 1, '{"size": "21-inch 8/256", "color": "red", "stock": 20}', 0, '2023-09-15 14:09:48', '2023-09-15 17:57:24', 0, 1),
	(17, 1, 3, 1, 8, 1, '{"size": "21-inch 8/256", "color": "red", "stock": 20}', 0, '2023-09-15 16:39:55', '2023-09-15 16:48:20', 0, 0),
	(18, 4, 3, 6, 7, 1, '{"size": "21-inch 8/256", "color": "red", "stock": 20}', 0, '2023-09-15 16:40:20', '2023-09-15 16:40:20', 0, 0),
	(19, 4, 3, 6, 7, 1, '{"size": "21-inch 8/256", "color": "red", "stock": 20}', 0, '2023-09-15 17:29:34', '2023-09-15 17:29:34', 0, 0);

-- Dumping structure for table tunibibi.cart_discount_histories
CREATE TABLE IF NOT EXISTS `cart_discount_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_with` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.cart_discount_histories: ~0 rows (approximately)

-- Dumping structure for table tunibibi.catagory
CREATE TABLE IF NOT EXISTS `catagory` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `catagory_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catagory_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.catagory: ~10 rows (approximately)
INSERT INTO `catagory` (`id`, `catagory_name`, `catagory_img`, `created_at`, `updated_at`) VALUES
	(1, 'OYBzry3ffm28', '64ab79889d94f.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(2, 'aGeDhrzZ0cvD', '64ab79889ecc5.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(3, 'uU3Vr07goovB', '64ab79889f736.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(4, 'U4Da15dfLTRV', '64ab79889ff5d.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(5, 'A8ddZWWsrwRh', '64ab7988a07a0.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(6, 'viSixwUeHESJ', '64ab7988a0e26.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(7, 'DG6G5pyM1zvb', '64ab7988a161a.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(8, 'jsgi5XBmmJuZ', '64ab7988a1c8f.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(9, 'ofP1ruiRVYhF', '64ab7988a22ca.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(10, 'E3sb6IrqpFto', '64ab7988a290a.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48');

-- Dumping structure for table tunibibi.city_delivery_charges
CREATE TABLE IF NOT EXISTS `city_delivery_charges` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.city_delivery_charges: ~0 rows (approximately)
INSERT INTO `city_delivery_charges` (`id`, `country_name`, `city_name`, `amount`, `created_at`, `updated_at`) VALUES
	(1, 'Bangladesh', 'Dhaka', 100, NULL, NULL);

-- Dumping structure for table tunibibi.country
CREATE TABLE IF NOT EXISTS `country` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dollar_rate` double NOT NULL DEFAULT '0',
  `currency_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.country: ~6 rows (approximately)
INSERT INTO `country` (`id`, `name`, `created_at`, `updated_at`, `code`, `flag`, `dollar_rate`, `currency_type`) VALUES
	(1, 'Bangladesh', '2023-07-09 21:22:48', '2023-07-09 21:22:48', '+880', '64ab798812f8b.png', 80, 'BDT'),
	(2, 'India', '2023-07-09 21:22:48', '2023-07-09 21:22:48', '+91', '64ab79881376a.png', 80, 'BDT'),
	(3, 'Pakistan', '2023-07-09 21:22:48', '2023-07-09 21:22:48', '+92', '64ab798813f03.png', 80, 'BDT'),
	(4, 'China', '2023-07-09 21:22:48', '2023-07-09 21:22:48', '+86', '64ab798814591.png', 80, 'BDT'),
	(5, 'America', '2023-07-09 21:22:48', '2023-07-09 21:22:48', '+1', '64ab798814c51.png', 80, 'BDT'),
	(6, 'Japan', '2023-07-09 21:22:48', '2023-09-23 19:39:54', '+81', '64ab7988152c0.png', 1000, 'BDT');

-- Dumping structure for table tunibibi.country_flags
CREATE TABLE IF NOT EXISTS `country_flags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.country_flags: ~0 rows (approximately)

-- Dumping structure for table tunibibi.coupons
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usage_per_customer` int NOT NULL DEFAULT '1',
  `discount_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_value` int DEFAULT NULL,
  `min_qty` int DEFAULT NULL,
  `min_order_amount` int DEFAULT NULL,
  `max_disc_amount` int DEFAULT NULL,
  `show_to_customer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_public` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.coupons: ~0 rows (approximately)
INSERT INTO `coupons` (`id`, `seller_id`, `coupon_code`, `usage_per_customer`, `discount_type`, `discount_value`, `min_qty`, `min_order_amount`, `max_disc_amount`, `show_to_customer`, `created_at`, `updated_at`, `is_public`) VALUES
	(1, '1', 'ABC', 1, 'FLAT', 1000, 10, 10, 300, '1', '2023-09-02 12:01:07', '2023-09-08 06:20:44', 1);

-- Dumping structure for table tunibibi.customer_coupons
CREATE TABLE IF NOT EXISTS `customer_coupons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint unsigned NOT NULL,
  `seller_id` bigint unsigned NOT NULL,
  `coupon_id` bigint unsigned NOT NULL,
  `is_used` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.customer_coupons: ~1 rows (approximately)
INSERT INTO `customer_coupons` (`id`, `buyer_id`, `seller_id`, `coupon_id`, `is_used`, `created_at`, `updated_at`) VALUES
	(3, 3, 1, 1, 0, '2023-09-09 02:40:22', '2023-09-09 02:40:22');

-- Dumping structure for table tunibibi.delivery_times
CREATE TABLE IF NOT EXISTS `delivery_times` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `times` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `minutes` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.delivery_times: ~0 rows (approximately)
INSERT INTO `delivery_times` (`id`, `times`, `minutes`, `created_at`, `updated_at`) VALUES
	(1, '10 AM-12PM', 60, NULL, NULL),
	(2, '12 AM- 2PM', 120, NULL, NULL);

-- Dumping structure for table tunibibi.details_infos
CREATE TABLE IF NOT EXISTS `details_infos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.details_infos: ~0 rows (approximately)

-- Dumping structure for table tunibibi.extra_charges
CREATE TABLE IF NOT EXISTS `extra_charges` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.extra_charges: ~2 rows (approximately)
INSERT INTO `extra_charges` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'GST', '2023-08-05 21:53:39', '2023-08-05 21:53:39'),
	(2, 'TAX', '2023-08-05 21:53:47', '2023-08-05 21:53:47'),
	(3, 'Custom Charge', '2023-08-05 21:53:55', '2023-08-05 21:53:55');

-- Dumping structure for table tunibibi.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table tunibibi.featured_shops
CREATE TABLE IF NOT EXISTS `featured_shops` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` bigint unsigned NOT NULL,
  `video` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `products_id` json NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.featured_shops: ~1 rows (approximately)
INSERT INTO `featured_shops` (`id`, `shop_id`, `video`, `products_id`, `country`, `created_at`, `updated_at`) VALUES
	(2, 1, 'www.youtube.com', '[1, 2]', 'Bangladesh', '2023-07-17 21:51:20', '2023-07-17 21:51:20');

-- Dumping structure for table tunibibi.lives
CREATE TABLE IF NOT EXISTS `lives` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fb_rtmp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_rtmp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `products` json NOT NULL,
  `is_ended` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `lives_seller_id_foreign` (`seller_id`),
  CONSTRAINT `lives_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.lives: ~0 rows (approximately)
INSERT INTO `lives` (`id`, `seller_id`, `title`, `fb_rtmp`, `youtube_rtmp`, `products`, `is_ended`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Test Live', 'www.facebook.com', 'www.youtube.com', '[1, 2, 3, 4]', 0, '2023-07-09 21:25:49', '2023-07-09 21:25:49');

-- Dumping structure for table tunibibi.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.migrations: ~86 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2023_01_19_082710_create_sellers_table', 1),
	(6, '2023_01_19_083956_create_business_types_table', 1),
	(7, '2023_01_19_085324_create_otps_table', 1),
	(8, '2023_01_24_060939_create_banner_table', 1),
	(9, '2023_01_24_063541_create_unit_weights_table', 1),
	(10, '2023_01_24_064454_create_catagory_table', 1),
	(11, '2023_01_24_064508_create_sub_catagory_table', 1),
	(12, '2023_01_24_071229_create_products_table', 1),
	(13, '2023_01_24_071754_create_product_images_table', 1),
	(14, '2023_01_24_080325_create_coupons_table', 1),
	(15, '2023_01_24_081806_create_lives_table', 1),
	(16, '2023_01_24_081824_create_product_videos_table', 1),
	(17, '2023_01_24_141234_create_buyers_table', 1),
	(18, '2023_01_24_141502_create_sliders_table', 1),
	(19, '2023_01_24_141631_create_super_deals_table', 1),
	(20, '2023_01_24_142105_create_country_flags_table', 1),
	(21, '2023_01_24_142243_create_notifications_table', 1),
	(22, '2023_01_24_142439_create_order_trackings_table', 1),
	(23, '2023_01_24_142710_create_address_table', 1),
	(24, '2023_01_24_142942_create_wirehouses_table', 1),
	(25, '2023_01_24_143056_create_country_table', 1),
	(26, '2023_01_27_183944_create_shop_onlines_table', 1),
	(27, '2023_01_27_192804_create_shop_views_table', 1),
	(28, '2023_01_27_192827_create_product_views_table', 1),
	(29, '2023_02_05_194233_create_refers_code', 1),
	(30, '2023_02_05_195522_create_seller_refer_earnings_table', 1),
	(31, '2023_02_05_195658_create_buyer_refer_earnings_table', 1),
	(32, '2023_02_05_222709_create_product_varients_table', 1),
	(33, '2023_02_05_222815_create_wholesale_prices_table', 1),
	(34, '2023_02_07_023107_create_order_payments', 1),
	(35, '2023_02_07_023215_create_delivery_times_table', 1),
	(36, '2023_02_07_024140_create_shipping_packages_table', 1),
	(37, '2023_02_07_025030_create_orders_table', 1),
	(38, '2023_02_07_221304_create_seller_payments_table', 1),
	(39, '2023_02_07_222043_create_seller_payment_details_table', 1),
	(40, '2023_02_07_232133_create_seller_extra_charges_table', 1),
	(41, '2023_02_07_232849_create_seller_courier_charges_table', 1),
	(42, '2023_02_28_155423_add_column_on_sellers_table', 1),
	(43, '2023_04_02_231216_add_code_column_on_country_table', 1),
	(44, '2023_04_02_233056_add_country_column_on_sellers_table', 1),
	(45, '2023_04_02_235246_create_payment_methods_table', 1),
	(46, '2023_04_03_023332_create_refer_earning_policy', 1),
	(47, '2023_04_03_024112_create_seller_recharge_requests_table', 1),
	(48, '2023_04_16_191909_create_extra_charges_table', 1),
	(49, '2023_05_05_211813_create_admins_table', 1),
	(50, '2023_05_11_024601_add_weight_type_on_products_table', 1),
	(51, '2023_05_12_131504_add_products_stock_status_column', 1),
	(52, '2023_05_12_151807_add_order_status_user_status_column', 1),
	(53, '2023_05_20_042953_create_buyer_banners_table', 1),
	(54, '2023_05_21_120801_create_product_reviews_table', 1),
	(55, '2023_05_21_125343_add_shipping_type_on_shipping_packages_table', 1),
	(56, '2023_05_21_133330_create_seller_followers_table', 1),
	(57, '2023_05_21_220201_add_is_public_column_on_coupons_table', 1),
	(58, '2023_05_21_221704_add_is_featured_table_on_products', 1),
	(59, '2023_06_04_114844_create_buyer_favourite_names_table', 1),
	(60, '2023_06_04_114857_create_buyer_favourite_products_table', 1),
	(61, '2023_06_04_130450_create_buy_togethers_table', 1),
	(62, '2023_06_05_085902_add_image_column_on_buyer_table', 1),
	(63, '2023_06_05_153514_create_buyer_shipping_addresses_table', 1),
	(64, '2023_06_07_230920_add_unit_types_column_onshipping_packages_table', 1),
	(65, '2023_06_07_231954_add_sizeandcolors_column_on_buy_togethers', 1),
	(66, '2023_06_07_235421_add_flag_column_on_country_table', 1),
	(67, '2023_06_10_035652_add_color_column_on_buy_togethers', 1),
	(68, '2023_06_10_064436_create_city_delivery_charges_table', 1),
	(69, '2023_06_10_102322_add_charges_coolumn_on_orders', 1),
	(70, '2023_06_10_110145_add_orders_type_column_on_orders', 1),
	(71, '2023_06_11_043814_add_track_id_on_orders_table', 1),
	(72, '2023_06_11_063627_create_carts_table', 1),
	(73, '2023_06_11_091508_add_wholesale_id_on_carts_table', 1),
	(74, '2023_06_16_215609_add_track_id_column_on_order_trackings_table', 1),
	(75, '2023_06_16_221509_add_track_estimated_date_on_orders_table', 1),
	(76, '2023_06_21_153846_create_buyer_payment_methods_table', 1),
	(77, '2023_06_22_063930_add_varient_id_and_doller_rate', 1),
	(78, '2023_06_22_110801_add_dollar_rate_on_country', 1),
	(79, '2023_06_22_125231_add_payment_method_column_on__order_payemnt', 1),
	(80, '2023_06_22_143506_add_message_column_on__orde_tracking', 1),
	(81, '2023_06_22_145918_add_eastimate_delivery_date_column_on__orders', 1),
	(82, '2023_06_22_154002_create_tunibibi_address_table', 1),
	(83, '2023_06_22_175927_add_unit_weight_column_on__orders', 1),
	(84, '2023_06_22_215820_add_unit_type_column_on__orders', 1),
	(85, '2023_07_14_002946_create_featured_shops_table', 2),
	(86, '2023_07_14_063511_add_buyer_id_on_buyer_favourite_products', 3),
	(87, '2023_06_27_081510_add_search_column_on_buyers_table', 4),
	(88, '2023_08_04_233316_create_rms_menus_table', 5),
	(89, '2023_08_04_233336_create_rms_groups_table', 5),
	(90, '2023_08_04_233353_create_rms_group_menus', 5),
	(91, '2023_08_04_233408_create_rms_permissions', 5),
	(92, '2023_08_04_233724_add_user_type_column_on_admin', 6),
	(93, '2023_08_04_234455_add_is_active_column_on_admin', 7),
	(94, '2023_08_05_113951_create_search_histories_table', 8),
	(95, '2023_08_16_053311_add_seller_courier_info_on_orders_table', 9),
	(96, '2023_08_16_061351_add_seller_courier_charge_on_orders_table', 10),
	(97, '2023_08_16_071633_create_seller_refer_comission_table', 11),
	(98, '2023_08_16_071644_create_seller_buyer_refer_comission_table', 11),
	(99, '2023_08_16_071705_create_seller_coin_type_table', 11),
	(100, '2023_08_16_071717_create_seller_refer_coin_echange_table', 11),
	(101, '2023_08_16_071717_create_seller_refer_coin_exchange_table', 12),
	(102, '2023_08_30_090339_create_refer_earnings_table', 12),
	(103, '2023_08_30_091036_add_refer_code_column_on_buyers_table', 13),
	(104, '2023_08_30_091315_create_point_converters_table', 14),
	(105, '2023_08_30_091501_create_vouchers_table', 14),
	(106, '2023_08_30_091951_create_details_infos_table', 15),
	(107, '2023_08_30_103623_add_logo_column_on_buyer_payment_method', 16),
	(108, '2023_08_30_114314_add_voucher_column_on_order', 17),
	(109, '2023_09_01_111416_add_payment_method_id_on_orders', 18),
	(110, '2023_09_01_112611_create_cart_discount_histories_table', 19),
	(111, '2023_09_01_113012_create_orders_trees_table', 20),
	(112, '2023_09_02_094533_add_customer_order_id_column_on_orders_trees_table', 21),
	(113, '2023_09_09_062846_create_customer_coupons_table', 22),
	(114, '2023_09_09_065827_create_buy_nows_table', 23),
	(115, '2023_09_09_070554_create_buyer_shippings_table', 23),
	(116, '2023_09_15_080201_add_varients_info_on_buy_nows', 24),
	(117, '2023_09_15_125029_add_voucher_id_on_buy_togethers', 25),
	(118, '2023_09_15_155335_add_is_selected_column', 26),
	(119, '2023_09_15_223034_add_is_selected_column_on_vouchers_table', 27),
	(120, '2023_09_16_011935_add_customer_shipping_fee_column_on_orders_table', 28),
	(121, '2023_09_16_012051_add_customer_shipping_fee_column_on_orders_table', 28),
	(122, '2023_09_23_190346_add_password_column_on_wirehouses', 29),
	(123, '2023_09_23_203230_add_wirehouse_status_on_orders_table', 30),
	(124, '2023_09_23_204906_add_wirehouse_note_on_orders_table', 31),
	(125, '2023_09_23_205928_add_destionation_wirehouse_id_on_orders_table', 32),
	(126, '2023_09_24_020054_add_country_column_on_buyer_banners', 33);

-- Dumping structure for table tunibibi.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` int NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.notifications: ~0 rows (approximately)

-- Dumping structure for table tunibibi.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` int NOT NULL,
  `seller_id` int NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` double NOT NULL DEFAULT '0',
  `wholesale_info` json NOT NULL,
  `varient_info` json NOT NULL,
  `coupon_info` json DEFAULT NULL,
  `product_price` double DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `disc_amount` double DEFAULT NULL,
  `shipping_info` json DEFAULT NULL,
  `shipping_charge` double DEFAULT NULL,
  `delivery_charge` double DEFAULT NULL,
  `buyer_shipping_addresses_info` json DEFAULT NULL,
  `wirehouse_id` int DEFAULT NULL,
  `order_status_seller` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `delivery_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `date` date NOT NULL DEFAULT '2023-07-10',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `order_status_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `charges` json DEFAULT NULL,
  `orders_type` int NOT NULL DEFAULT '0',
  `track_id` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `estimated_date` date DEFAULT NULL,
  `variant_id` int NOT NULL DEFAULT '0',
  `dollar_rate` double NOT NULL DEFAULT '0',
  `estimate_delivery_date` date DEFAULT NULL,
  `unit_weight` int NOT NULL DEFAULT '0',
  `unit_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `seller_delivery_info` json DEFAULT NULL,
  `can_buytogether` int NOT NULL DEFAULT '0',
  `seller_delivery_charge` int NOT NULL DEFAULT '0',
  `voucher_id` bigint unsigned DEFAULT NULL,
  `voucher_info` json DEFAULT NULL,
  `total_amount` int NOT NULL DEFAULT '0',
  `order_with` longtext COLLATE utf8mb4_unicode_ci,
  `payment_method_id` bigint unsigned DEFAULT NULL,
  `customer_shipping_fee` double NOT NULL DEFAULT '0',
  `customer_delivery_fee` double NOT NULL DEFAULT '0',
  `status_warehouse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `wirehouse_note` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination_wirehouse_id` bigint unsigned NOT NULL,
  `destination_wirehouse_note` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_weight` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.orders: ~4 rows (approximately)
INSERT INTO `orders` (`id`, `buyer_id`, `seller_id`, `order_id`, `product_id`, `quantity`, `wholesale_info`, `varient_info`, `coupon_info`, `product_price`, `amount`, `disc_amount`, `shipping_info`, `shipping_charge`, `delivery_charge`, `buyer_shipping_addresses_info`, `wirehouse_id`, `order_status_seller`, `delivery_time`, `delivery_payment_status`, `payment_status`, `date`, `created_at`, `updated_at`, `order_status_user`, `charges`, `orders_type`, `track_id`, `estimated_date`, `variant_id`, `dollar_rate`, `estimate_delivery_date`, `unit_weight`, `unit_type`, `seller_delivery_info`, `can_buytogether`, `seller_delivery_charge`, `voucher_id`, `voucher_info`, `total_amount`, `order_with`, `payment_method_id`, `customer_shipping_fee`, `customer_delivery_fee`, `status_warehouse`, `wirehouse_note`, `destination_wirehouse_id`, `destination_wirehouse_note`, `shipping_weight`) VALUES
	(197, 3, 1, 'B4SLG4GPZDLC', '10', 11, '[{"id": 19, "unit": "KG", "amount": 300, "created_at": "2023-07-10T09:22:49.000000Z", "product_id": 10, "updated_at": "2023-09-08T11:58:22.000000Z", "max_quantity": "20", "min_quantity": "10"}, {"id": 20, "unit": "KG", "amount": 100, "created_at": "2023-07-10T09:22:49.000000Z", "product_id": 10, "updated_at": "2023-09-08T11:54:48.000000Z", "max_quantity": "10", "min_quantity": "6"}]', '[{"size": "21-inch 8/256", "color": "red", "stock": 20}]', '[{"id": 1, "min_qty": 10, "is_public": 1, "seller_id": "1", "created_at": "2023-09-02T18:01:07.000000Z", "updated_at": "2023-09-08T12:20:44.000000Z", "coupon_code": "ABC", "discount_type": "FLAT", "discount_value": 1000, "max_disc_amount": 300, "min_order_amount": 10, "show_to_customer": "1", "usage_per_customer": 1}]', 100, 1100, 1040, '[{"id": 2, "days": "12", "amount": 1200, "created_at": null, "to_country": "Bangladesh", "unit_types": "[{\\"KG\\": 100, \\"id\\": 1}]", "updated_at": null, "from_country": "Bangladesh", "shipping_type": "Air"}]', 1200, NULL, '[{"id": 1, "zip": "1032", "city": "Dhaka", "name1": "MD", "name2": "Salauddin", "state": "Dhaka", "mobile": "+8801974780794", "street": "South Bisil,Mirpur-1", "country": "Bangladesh", "buyer_id": 3, "apartment": "Road 27", "created_at": "2023-08-05T12:13:08.000000Z", "is_default": 1, "updated_at": "2023-08-05T12:13:08.000000Z"}]', 2, 'Pending', NULL, 'unpaid', 'Pending', '2023-07-10', '2023-09-16 01:39:59', '2023-09-25 08:22:31', 'Pending', '[{"name": "GST", "amount": 100}, {"name": "TAX", "amount": 100}, {"name": "Custom Charge", "amount": 100}]', 2, '5TYYVQMIZTZCBFBQ', NULL, 1, 80, NULL, 500, 'KG', NULL, 0, 0, NULL, '[{"id": 1, "amount": 40, "is_used": 0, "user_id": 3, "user_type": "buyer", "created_at": null, "min_amount": 100, "updated_at": null, "expire_date": "2023-10-02", "is_selected": 1, "voucher_code": "AVC"}]', 1420, '', 1, 100, 100, 'Delivered', 'Sakib Accepted', 2, 'Sakib Accepted', 100),
	(198, 3, 1, 'LAFWHSGWEFCA', '10', 7, '[{"id": 19, "unit": "KG", "amount": 300, "created_at": "2023-07-10T09:22:49.000000Z", "product_id": 10, "updated_at": "2023-09-08T11:58:22.000000Z", "max_quantity": "20", "min_quantity": "10"}, {"id": 20, "unit": "KG", "amount": 100, "created_at": "2023-07-10T09:22:49.000000Z", "product_id": 10, "updated_at": "2023-09-08T11:54:48.000000Z", "max_quantity": "10", "min_quantity": "6"}]', '[{"size": "21-inch 8/256", "color": "red", "stock": 20}]', '[{"id": 1, "min_qty": 10, "is_public": 1, "seller_id": "1", "created_at": "2023-09-02T18:01:07.000000Z", "updated_at": "2023-09-08T12:20:44.000000Z", "coupon_code": "ABC", "discount_type": "FLAT", "discount_value": 1000, "max_disc_amount": 300, "min_order_amount": 10, "show_to_customer": "1", "usage_per_customer": 1}]', 100, 700, 1040, '[{"id": 2, "days": "12", "amount": 1200, "created_at": null, "to_country": "Bangladesh", "unit_types": "[{\\"KG\\": 100, \\"id\\": 1}]", "updated_at": null, "from_country": "Bangladesh", "shipping_type": "Air"}]', 1200, NULL, '[{"id": 1, "zip": "1032", "city": "Dhaka", "name1": "MD", "name2": "Salauddin", "state": "Dhaka", "mobile": "+8801974780794", "street": "South Bisil,Mirpur-1", "country": "Bangladesh", "buyer_id": 3, "apartment": "Road 27", "created_at": "2023-08-05T12:13:08.000000Z", "is_default": 1, "updated_at": "2023-08-05T12:13:08.000000Z"}]', 2, 'Pending', NULL, 'unpaid', 'Pending', '2023-07-10', '2023-09-16 01:39:59', '2023-09-25 03:02:17', 'Pending', '[{"name": "GST", "amount": 100}, {"name": "TAX", "amount": 100}, {"name": "Custom Charge", "amount": 100}]', 2, 'HL1AOGEP8IZUEC6E', NULL, 1, 80, NULL, 500, 'KG', NULL, 0, 0, NULL, '[{"id": 1, "amount": 40, "is_used": 0, "user_id": 3, "user_type": "buyer", "created_at": null, "min_amount": 100, "updated_at": null, "expire_date": "2023-10-02", "is_selected": 1, "voucher_code": "AVC"}]', 1020, '', 1, 10, 10, 'Pending', '', 2, '', 0),
	(199, 3, 1, '7K1CQXHTVPQN', '10', 11, '[{"id": 19, "unit": "KG", "amount": 300, "created_at": "2023-07-10T09:22:49.000000Z", "product_id": 10, "updated_at": "2023-09-08T11:58:22.000000Z", "max_quantity": "20", "min_quantity": "10"}, {"id": 20, "unit": "KG", "amount": 100, "created_at": "2023-07-10T09:22:49.000000Z", "product_id": 10, "updated_at": "2023-09-08T11:54:48.000000Z", "max_quantity": "10", "min_quantity": "6"}]', '[{"size": "21-inch 8/256", "color": "red", "stock": 20}]', '[{"id": 1, "min_qty": 10, "is_public": 1, "seller_id": "1", "created_at": "2023-09-02T18:01:07.000000Z", "updated_at": "2023-09-08T12:20:44.000000Z", "coupon_code": "ABC", "discount_type": "FLAT", "discount_value": 1000, "max_disc_amount": 300, "min_order_amount": 10, "show_to_customer": "1", "usage_per_customer": 1}]', 100, 1100, 1040, '[{"id": 2, "days": "12", "amount": 1200, "created_at": null, "to_country": "Bangladesh", "unit_types": "[{\\"KG\\": 100, \\"id\\": 1}]", "updated_at": null, "from_country": "Bangladesh", "shipping_type": "Air"}]', 1200, NULL, '[{"id": 1, "zip": "1032", "city": "Dhaka", "name1": "MD", "name2": "Salauddin", "state": "Dhaka", "mobile": "+8801974780794", "street": "South Bisil,Mirpur-1", "country": "Bangladesh", "buyer_id": 3, "apartment": "Road 27", "created_at": "2023-08-05T12:13:08.000000Z", "is_default": 1, "updated_at": "2023-08-05T12:13:08.000000Z"}]', 2, 'Pending', NULL, 'unpaid', 'Pending', '2023-07-10', '2023-09-16 01:40:14', '2023-09-25 08:23:10', 'Pending', '[{"name": "GST", "amount": 100}, {"name": "TAX", "amount": 100}, {"name": "Custom Charge", "amount": 100}]', 2, 'U8KVEDRU2SGNQPXY', NULL, 1, 80, NULL, 500, 'KG', NULL, 0, 0, NULL, '[{"id": 1, "amount": 40, "is_used": 0, "user_id": 3, "user_type": "buyer", "created_at": null, "min_amount": 100, "updated_at": null, "expire_date": "2023-10-02", "is_selected": 1, "voucher_code": "AVC"}]', 1420, '', 1, 0, 0, 'Delivered', '', 2, '', 0),
	(200, 3, 1, 'NG7HSNJCBZWB', '10', 7, '[{"id": 19, "unit": "KG", "amount": 300, "created_at": "2023-07-10T09:22:49.000000Z", "product_id": 10, "updated_at": "2023-09-08T11:58:22.000000Z", "max_quantity": "20", "min_quantity": "10"}, {"id": 20, "unit": "KG", "amount": 100, "created_at": "2023-07-10T09:22:49.000000Z", "product_id": 10, "updated_at": "2023-09-08T11:54:48.000000Z", "max_quantity": "10", "min_quantity": "6"}]', '[{"size": "21-inch 8/256", "color": "red", "stock": 20}]', '[{"id": 1, "min_qty": 10, "is_public": 1, "seller_id": "1", "created_at": "2023-09-02T18:01:07.000000Z", "updated_at": "2023-09-08T12:20:44.000000Z", "coupon_code": "ABC", "discount_type": "FLAT", "discount_value": 1000, "max_disc_amount": 300, "min_order_amount": 10, "show_to_customer": "1", "usage_per_customer": 1}]', 100, 700, 1040, '[{"id": 2, "days": "12", "amount": 1200, "created_at": null, "to_country": "Bangladesh", "unit_types": "[{\\"KG\\": 100, \\"id\\": 1}]", "updated_at": null, "from_country": "Bangladesh", "shipping_type": "Air"}]', 1200, NULL, '[{"id": 1, "zip": "1032", "city": "Dhaka", "name1": "MD", "name2": "Salauddin", "state": "Dhaka", "mobile": "+8801974780794", "street": "South Bisil,Mirpur-1", "country": "Bangladesh", "buyer_id": 3, "apartment": "Road 27", "created_at": "2023-08-05T12:13:08.000000Z", "is_default": 1, "updated_at": "2023-08-05T12:13:08.000000Z"}]', 2, 'Pending', NULL, 'unpaid', 'Pending', '2023-07-10', '2023-09-16 01:40:14', '2023-09-25 03:02:18', 'Pending', '[{"name": "GST", "amount": 100}, {"name": "TAX", "amount": 100}, {"name": "Custom Charge", "amount": 100}]', 2, 'LOMFSVTDQSBRNULP', NULL, 1, 80, NULL, 500, 'KG', NULL, 0, 0, NULL, '[{"id": 1, "amount": 40, "is_used": 0, "user_id": 3, "user_type": "buyer", "created_at": null, "min_amount": 100, "updated_at": null, "expire_date": "2023-10-02", "is_selected": 1, "voucher_code": "AVC"}]', 1020, '', 1, 0, 0, 'Pending', '', 2, '', 0);

-- Dumping structure for table tunibibi.orders_trees
CREATE TABLE IF NOT EXISTS `orders_trees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint unsigned NOT NULL,
  `orders_id` json NOT NULL,
  `discount_amount` double(8,2) NOT NULL,
  `product_payment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `delivery_payment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_order_id` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `payable_amount` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.orders_trees: ~3 rows (approximately)
INSERT INTO `orders_trees` (`id`, `buyer_id`, `orders_id`, `discount_amount`, `product_payment`, `delivery_payment`, `created_at`, `updated_at`, `customer_order_id`, `status`, `payable_amount`) VALUES
	(99, 3, '["B4SLG4GPZDLC", "LAFWHSGWEFCA"]', 1040.00, 'Submited', 'Submited', '2023-09-15 19:39:59', '2023-09-25 08:20:53', 'JINXCU592023010916393G1YCJJ', 3, 220),
	(100, 3, '["7K1CQXHTVPQN", "NG7HSNJCBZWB"]', 1040.00, 'pending', 'pending', '2023-09-15 19:40:14', '2023-09-24 22:29:40', 'EO3HD51420230109164031IJIL3', 5, 1400);

-- Dumping structure for table tunibibi.order_payments
CREATE TABLE IF NOT EXISTS `order_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `amount` double NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trx_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1336 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.order_payments: ~11 rows (approximately)
INSERT INTO `order_payments` (`id`, `order_id`, `amount`, `payment_type`, `trx_id`, `trx_img`, `is_verified`, `created_at`, `updated_at`, `payment_method`) VALUES
	(1323, '12', 2360, 'order', 's', '64f314824f311.png', 0, '2023-09-02 04:54:58', '2023-09-02 04:54:58', 'bkash'),
	(1324, '13', 1460, 'order', 's', '64f32bcd30f23.png', 0, '2023-09-02 06:34:21', '2023-09-02 06:34:21', 'bkash'),
	(1325, '12', 2360, 'order', 'sjhsfvhiksd', '64fc34e9ba5f7.png', 0, '2023-09-09 03:03:37', '2023-09-09 03:03:37', 'bkash'),
	(1326, 'KDWWO1192023090902503FANXY4', 100, 'Delivery Fee', '1234', NULL, 0, '2023-09-09 03:14:19', '2023-09-09 03:14:19', 'BKASH'),
	(1327, 'KDWWO1192023090902503FANXY4', 100, 'Delivery Fee', '1234', NULL, 0, '2023-09-09 03:14:53', '2023-09-09 03:14:53', 'BKASH'),
	(1328, 'KDWWO1192023090902503FANXY4', 100, 'Delivery Fee', '1234', NULL, 0, '2023-09-09 03:15:24', '2023-09-09 03:15:24', 'BKASH'),
	(1329, 'JINXCU592023010916393G1YCJJ', 1400, 'order', 'sjhsfvhiksd', '65050fdc2fb79.png', 1, '2023-09-15 20:15:56', '2023-09-24 22:29:12', 'bkash'),
	(1330, '99', 1400, 'order', 'sjhsfvhiksd', '650510145abb2.png', 0, '2023-09-15 20:16:52', '2023-09-15 20:16:52', 'bkash'),
	(1331, '99', 1400, 'order', 'sjhsfvhiksd', '6505107ddecf5.png', 0, '2023-09-15 20:18:37', '2023-09-15 20:18:37', 'bkash'),
	(1332, '99', 1400, 'order', 'sjhsfvhiksd', '650510b5a3e6b.png', 0, '2023-09-15 20:19:33', '2023-09-15 20:19:33', 'bkash'),
	(1333, 'EO3HD51420230109164031IJIL3', 1200, 'Delivery Fee', '1234', NULL, 1, '2023-09-15 20:20:43', '2023-09-24 22:29:40', 'BKASH'),
	(1334, 'JINXCU592023010916393G1YCJJ', 1200, 'Delivery Fee', '1234', NULL, 0, '2023-09-15 20:21:28', '2023-09-15 20:21:28', 'BKASH'),
	(1335, 'JINXCU592023010916393G1YCJJ', 1200, 'Delivery Fee', '1234', NULL, 0, '2023-09-15 20:29:04', '2023-09-15 20:29:04', 'BKASH');

-- Dumping structure for table tunibibi.order_trackings
CREATE TABLE IF NOT EXISTS `order_trackings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL DEFAULT '2023-07-10',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `track_id` longtext COLLATE utf8mb4_unicode_ci,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.order_trackings: ~28 rows (approximately)
INSERT INTO `order_trackings` (`id`, `order_id`, `status`, `date`, `created_at`, `updated_at`, `track_id`, `message`) VALUES
	(2, 'B4SLG4GPZDLC', 'Arrived Wirehouse', '2023-09-23', '2023-09-23 14:47:34', '2023-09-23 14:47:34', NULL, 'Sakib Accepted'),
	(3, 'B4SLG4GPZDLC', 'Shipped', '2023-09-23', '2023-09-23 15:06:22', '2023-09-23 15:06:22', NULL, 'Sakib Accepted'),
	(5, 'B4SLG4GPZDLC', 'Arrived Destination Country', '2023-09-23', '2023-09-23 17:05:08', '2023-09-23 17:05:08', NULL, ''),
	(6, 'B4SLG4GPZDLC', 'Arrived Destination Country', '2023-09-23', '2023-09-23 17:11:09', '2023-09-23 17:11:09', NULL, ''),
	(7, 'B4SLG4GPZDLC', 'Arrived Destination Country', '2023-09-23', '2023-09-23 17:20:17', '2023-09-23 17:20:17', NULL, ''),
	(8, 'B4SLG4GPZDLC', 'Arrived Destination Country', '2023-09-23', '2023-09-23 17:38:02', '2023-09-23 17:38:02', NULL, ''),
	(9, 'B4SLG4GPZDLC', 'Arrived Destination Country', '2023-09-23', '2023-09-23 17:52:16', '2023-09-23 17:52:16', NULL, ''),
	(10, 'JINXCU592023010916393G1YCJJ', 'Send Courier', '2023-09-24', '2023-09-23 18:11:18', '2023-09-23 18:11:18', NULL, ''),
	(11, 'JINXCU592023010916393G1YCJJ', 'Sent Courier', '2023-09-24', '2023-09-23 18:13:44', '2023-09-23 18:13:44', NULL, ''),
	(12, 'JINXCU592023010916393G1YCJJ', 'Sent Courier', '2023-09-24', '2023-09-23 18:14:56', '2023-09-23 18:14:56', NULL, ''),
	(13, 'JINXCU592023010916393G1YCJJ', 'Delivered', '2023-09-24', '2023-09-23 18:24:29', '2023-09-23 18:24:29', NULL, ''),
	(14, 'JINXCU592023010916393G1YCJJ', 'Delivered', '2023-09-24', '2023-09-23 18:25:05', '2023-09-23 18:25:05', NULL, ''),
	(15, 'B4SLG4GPZDLC', 'SEND', '2023-09-25', '2023-09-24 21:50:08', '2023-09-24 21:50:08', NULL, 'TEST'),
	(16, 'B4SLG4GPZDLC', 'SEND', '2023-09-25', '2023-09-24 21:50:16', '2023-09-24 21:50:16', NULL, 'TEST'),
	(17, 'B4SLG4GPZDLC', 'SEND', '2023-09-25', '2023-09-24 21:50:32', '2023-09-24 21:50:32', NULL, 'TEST'),
	(18, 'B4SLG4GPZDLC', 'Arrived Wirehouse', '2023-09-25', '2023-09-24 22:10:54', '2023-09-24 22:10:54', NULL, 'Sakib Accepted'),
	(19, 'B4SLG4GPZDLC', 'Shipped', '2023-09-25', '2023-09-24 22:12:35', '2023-09-24 22:12:35', NULL, 'Sakib Accepted'),
	(20, 'B4SLG4GPZDLC', 'Arrived Destination Country', '2023-09-25', '2023-09-24 22:14:47', '2023-09-24 22:14:47', NULL, ''),
	(21, 'B4SLG4GPZDLC', 'Arrived Destination Country', '2023-09-25', '2023-09-24 22:15:08', '2023-09-24 22:15:08', NULL, ''),
	(22, 'JINXCU592023010916393G1YCJJ', 'Sent Courier', '2023-09-25', '2023-09-24 22:15:19', '2023-09-24 22:15:19', NULL, ''),
	(23, 'B4SLG4GPZDLC', 'Sent Courier', '2023-09-25', '2023-09-24 22:15:34', '2023-09-24 22:15:34', NULL, ''),
	(24, 'JINXCU592023010916393G1YCJJ', 'Sent Courier', '2023-09-25', '2023-09-24 22:16:19', '2023-09-24 22:16:19', NULL, ''),
	(25, 'JINXCU592023010916393G1YCJJ', 'Delivered', '2023-09-25', '2023-09-24 22:16:54', '2023-09-24 22:16:54', NULL, ''),
	(26, 'B4SLG4GPZDLC', 'Arrived Destination Country', '2023-09-25', '2023-09-25 08:20:53', '2023-09-25 08:20:53', NULL, ''),
	(27, 'B4SLG4GPZDLC', 'Sent Courier', '2023-09-25', '2023-09-25 08:21:43', '2023-09-25 08:21:43', NULL, ''),
	(28, 'B4SLG4GPZDLC', 'Sent Courier', '2023-09-25', '2023-09-25 08:22:14', '2023-09-25 08:22:14', NULL, ''),
	(29, 'B4SLG4GPZDLC', 'Delivered', '2023-09-25', '2023-09-25 08:22:31', '2023-09-25 08:22:31', NULL, ''),
	(30, '7K1CQXHTVPQN', 'Delivered', '2023-09-25', '2023-09-25 08:23:10', '2023-09-25 08:23:10', NULL, '');

-- Dumping structure for table tunibibi.otps
CREATE TABLE IF NOT EXISTS `otps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_used` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `date` date NOT NULL DEFAULT '2023-07-10',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.otps: ~0 rows (approximately)
INSERT INTO `otps` (`id`, `phone`, `otp`, `is_used`, `date`, `created_at`, `updated_at`) VALUES
	(1, '+8801974780794', '210741', '1', '2023-07-10', '2023-08-05 05:38:08', '2023-08-05 05:38:16');

-- Dumping structure for table tunibibi.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.password_resets: ~0 rows (approximately)

-- Dumping structure for table tunibibi.payment_methods
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `method_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method_details` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.payment_methods: ~0 rows (approximately)
INSERT INTO `payment_methods` (`id`, `method_name`, `method_details`, `created_at`, `updated_at`) VALUES
	(1, 'BKASH', '["ANCASAS"]', NULL, NULL);

-- Dumping structure for table tunibibi.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.personal_access_tokens: ~18 rows (approximately)
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
	(1, 'App\\Models\\Seller', 1, '1-724-947-4223', '334d9b851998f356028f209a9763a0fd0396963ec64b91cfd6e83033cd6a77b1', '["*"]', '2023-07-09 21:25:49', NULL, '2023-07-09 21:25:28', '2023-07-09 21:25:49'),
	(2, 'App\\Models\\admin', 1, 'salauddin@gmail.com', '16f894ef3a20f31524dc1392a14bcc57025e9c0e5b2b0494a434bc49bb407746', '["*"]', '2023-07-10 07:48:32', NULL, '2023-07-09 21:41:35', '2023-07-10 07:48:32'),
	(3, 'App\\Models\\Buyer', 1, '', '7537489aa160045a270623fe45e096d458d3ea9b5dbafc566619b91f9e418350', '["*"]', NULL, NULL, '2023-07-13 18:06:51', '2023-07-13 18:06:51'),
	(4, 'App\\Models\\Buyer', 1, '', '5fe138c16e5d66ca7b1158f5a0ef20732ca84067d5b0fd0cd2dbb818125223ef', '["*"]', '2023-07-14 03:14:34', NULL, '2023-07-13 18:14:29', '2023-07-14 03:14:34'),
	(5, 'App\\Models\\Seller', 1, '+8801975780794', '11aca2ae27e7f37787fa1d4b02f2a75a00bc859b78b62255a5567b26157b7ff5', '["*"]', '2023-07-13 18:52:57', NULL, '2023-07-13 18:48:30', '2023-07-13 18:52:57'),
	(6, 'App\\Models\\Seller', 1, '+8801975780794', 'db5d9e02b790f93c96435b1a18d44db1c8ad0251357f9ddd854ce9270d9d4cc8', '["*"]', '2023-07-14 03:18:17', NULL, '2023-07-14 03:17:32', '2023-07-14 03:18:17'),
	(7, 'App\\Models\\admin', 1, 'salauddin@gmail.com', '01c9d46fe564ebd6494880e5dc4b335a7bf684196fc9970f959d9f7172c9b8c7', '["*"]', '2023-07-14 03:20:21', NULL, '2023-07-14 03:19:50', '2023-07-14 03:20:21'),
	(8, 'App\\Models\\admin', 1, 'salauddin@gmail.com', '6e8adfe7dcf0a47ed11687b8e2f2f85c997941c16eff47e261a5f2d6ba8360e2', '["*"]', '2023-08-05 06:46:21', NULL, '2023-07-17 21:18:49', '2023-08-05 06:46:21'),
	(9, 'App\\Models\\Buyer', 3, '+8801974780794', '45bd6b8cf4320c66820fa46d82ee6c0d4c5b5a7af1337d978bcc1ef82bf0eeca', '["*"]', '2023-08-05 15:57:12', NULL, '2023-08-05 05:38:16', '2023-08-05 15:57:12'),
	(10, 'App\\Models\\Seller', 1, '+8801975780794', '868d06bafed21865c179bff941515a940447abf9928fc181cfbf73e351bbb737', '["*"]', '2023-08-05 15:54:53', NULL, '2023-08-05 15:52:18', '2023-08-05 15:54:53'),
	(11, 'App\\Models\\Seller', 1, '+8801975780794', 'b514197faaf51e7a5673b9e1db399dd25cb28b1f74129ebbc25b3ec4a9688e8e', '["*"]', '2023-09-16 04:01:02', NULL, '2023-08-15 23:05:11', '2023-09-16 04:01:02'),
	(12, 'App\\Models\\Buyer', 3, '', '354906e794ed29627314bd9d83b0fbe1f079ea213c5e51e30c50f01217ca0970', '["*"]', '2023-09-11 04:00:43', NULL, '2023-08-30 03:00:48', '2023-09-11 04:00:43'),
	(13, 'App\\Models\\Buyer', 3, '', '186d21ce81b9e570441196a4f73fc4764d38026b60cc54a222dd8eab7b454be8', '["*"]', '2023-09-16 04:26:39', NULL, '2023-09-15 01:38:00', '2023-09-16 04:26:39'),
	(14, 'App\\Models\\admin', 1, 'salauddin@gmail.com', '74769255d7128c6cdabb1e604d27490acab2b80bdc6f27b13b7230d9263a1270', '["*"]', '2023-09-24 22:31:33', NULL, '2023-09-23 08:53:01', '2023-09-24 22:31:33'),
	(15, 'App\\Models\\wirehouse', 2, '2', 'da5e306f3d35620b7f6e0bfe2ae13b444f32ac54b6cf052a874a1b237c9cc798', '["*"]', NULL, NULL, '2023-09-23 13:58:23', '2023-09-23 13:58:23'),
	(16, 'App\\Models\\wirehouse', 2, '2', '5b82b6bbb9d9048693c31739abd26eb39c2f7f32d83373622e099769fef36f67', '["*"]', NULL, NULL, '2023-09-23 13:58:28', '2023-09-23 13:58:28'),
	(17, 'App\\Models\\wirehouse', 2, '2', 'ad958bd35bd0277edde7cacd016423ed10b7d3bc2ebfa02c5a42953789801cc1', '["*"]', NULL, NULL, '2023-09-23 13:58:31', '2023-09-23 13:58:31'),
	(18, 'App\\Models\\wirehouse', 2, '2', '873cad7e1c14cff444530bd66451eb203a35c006f614af3c8809a717cc4d32b0', '["*"]', NULL, NULL, '2023-09-23 13:58:58', '2023-09-23 13:58:58'),
	(19, 'App\\Models\\wirehouse', 2, '2', '754ec04ee5d71e12d788d611f5115e4e855c9ed20b45cb901fb4d1cb6eed3bf4', '["*"]', '2023-09-24 22:16:54', NULL, '2023-09-23 13:59:06', '2023-09-24 22:16:54'),
	(20, 'App\\Models\\wirehouse', 2, '2', '4fb7742ba2960b25b88a441d2cc4b0f8645aa4b9637bd4a80d6141f083ec0c59', '["*"]', NULL, NULL, '2023-09-24 22:09:30', '2023-09-24 22:09:30'),
	(21, 'App\\Models\\wirehouse', 2, '2', 'd1f5b70f73f893e947e3c85652e67bbb83cbc34ae8de4970bd008a63d6bc4b2a', '["*"]', '2023-09-25 08:23:12', NULL, '2023-09-25 08:11:37', '2023-09-25 08:23:12'),
	(22, 'App\\Models\\wirehouse', 2, '2', '675d958b7ccd511fd6406d25aa12ed7afba9593226a4ab0ba7963295fbf0ca21', '["*"]', NULL, NULL, '2023-09-25 08:16:11', '2023-09-25 08:16:11');

-- Dumping structure for table tunibibi.point_converters
CREATE TABLE IF NOT EXISTS `point_converters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.point_converters: ~0 rows (approximately)

-- Dumping structure for table tunibibi.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catagory_id` bigint unsigned NOT NULL,
  `sub_catagory_id` bigint unsigned NOT NULL,
  `product_details` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight_unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_origin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL DEFAULT '2023-07-10',
  `is_active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `weight_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `products_catagory_id_foreign` (`catagory_id`),
  KEY `products_sub_catagory_id_foreign` (`sub_catagory_id`),
  CONSTRAINT `products_catagory_id_foreign` FOREIGN KEY (`catagory_id`) REFERENCES `catagory` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_sub_catagory_id_foreign` FOREIGN KEY (`sub_catagory_id`) REFERENCES `sub_catagory` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.products: ~10 rows (approximately)
INSERT INTO `products` (`id`, `seller_id`, `product_name`, `catagory_id`, `sub_catagory_id`, `product_details`, `weight_unit`, `product_code`, `video_url`, `product_origin`, `date`, `is_active`, `created_at`, `updated_at`, `weight_type`, `stock`, `is_featured`) VALUES
	(1, '1', 'Austyn Fisher', 1, 1, 'Quasi atque esse quia omnis soluta qui voluptas. Maxime deserunt soluta placeat odio. Iste saepe magnam voluptate qui voluptates maiores tempore.', '500', '5D7Mx', 'https://www.youtube.com', 'US', '2023-07-10', 1, '2023-07-09 21:22:48', '2023-07-09 21:22:48', 'KG', 1, 0),
	(2, '1', 'Chesley Bogan', 1, 1, 'Odit aliquam debitis voluptatum sapiente. Et sit sit aut a animi vero ad.', '500', 'kavIt', 'https://www.youtube.com', 'US', '2023-07-10', 1, '2023-07-09 21:22:48', '2023-08-05 21:54:33', 'KG', 1, 0),
	(3, '1', 'Prof. Columbus Witting II', 1, 1, 'Dicta ducimus est quis. Delectus tenetur ut cum perferendis aut dicta quas. Porro laudantium rem expedita modi sit natus.', '500', 'P02Dd', 'https://www.youtube.com', 'US', '2023-07-10', 1, '2023-07-09 21:22:48', '2023-08-05 21:54:35', 'KG', 1, 0),
	(4, '2', 'Reyes Von', 1, 1, 'Et ad facilis at quos asperiores sed. Sunt quibusdam facere totam beatae voluptas. Doloribus perspiciatis quia assumenda molestiae voluptate praesentium sunt.', '500', 'Rofvn', 'https://www.youtube.com', 'US', '2023-07-10', 1, '2023-07-09 21:22:48', '2023-09-01 10:16:11', 'KG', 1, 0),
	(5, '3', 'Hollis Schiller', 1, 1, 'Odio libero est et sit accusantium totam. Eum explicabo reiciendis nobis velit. Asperiores laudantium ea cupiditate debitis possimus porro.', '500', '3LITy', 'https://www.youtube.com', 'US', '2023-07-10', 1, '2023-07-09 21:22:48', '2023-09-01 10:16:12', 'KG', 1, 0),
	(6, '4', 'Wanda Herman', 1, 1, 'Quo quia deserunt quos autem voluptatem nisi. Quo ut illo voluptas est cum. Quidem quod et non sed eos id expedita voluptas.', '500', '04Xg4', 'https://www.youtube.com', 'US', '2023-07-10', 1, '2023-07-09 21:22:48', '2023-09-01 10:16:13', 'KG', 1, 0),
	(7, '4', 'Prof. Jena Bins DDS', 1, 1, 'Nulla possimus inventore a et suscipit ut. Tempora quia cumque adipisci dolorem quos vero. Ut quod magni veniam explicabo provident.', '500', 'dmOlb', 'https://www.youtube.com', 'US', '2023-07-10', 1, '2023-07-09 21:22:48', '2023-09-01 10:16:14', 'KG', 1, 0),
	(8, '2', 'Rhea Braun DDS', 1, 1, 'Et omnis esse placeat dolor. Error neque minima repellat accusantium. Ut aut et ducimus repudiandae.', '500', 'DgT8x', 'https://www.youtube.com', 'US', '2023-07-10', 1, '2023-07-09 21:22:48', '2023-09-01 10:16:15', 'KG', 1, 0),
	(9, '1', 'Dr. Aidan Barrows Sr.', 1, 1, 'Molestias quasi incidunt a aut qui. Fugiat sed debitis cupiditate veniam neque illo.', '500', 'jcD94', 'https://www.youtube.com', 'US', '2023-07-10', 1, '2023-07-09 21:22:49', '2023-07-09 21:22:49', 'KG', 1, 0),
	(10, '1', 'Dariana Toy', 1, 1, 'Voluptatem dolor et ut unde ullam. Repellendus voluptatem vitae et officiis dolor. Est et repellat repellat non et exercitationem eligendi.', '500', '3W4aO', 'https://www.youtube.com', 'US', '2023-07-10', 1, '2023-07-09 21:22:49', '2023-07-09 21:22:49', 'KG', 1, 0);

-- Dumping structure for table tunibibi.product_images
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.product_images: ~40 rows (approximately)
INSERT INTO `product_images` (`id`, `product_id`, `img`, `created_at`, `updated_at`) VALUES
	(1, 1, '64ab7988b9751.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(2, 2, '64ab7988bbbd1.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(3, 3, '64ab7988bc67c.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(4, 4, '64ab7988bd08a.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(5, 1, '64ab7988c7be2.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(6, 2, '64ab7988c9052.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(7, 3, '64ab7988c9d41.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(8, 4, '64ab7988ca844.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(9, 1, '64ab7988ccd1d.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(10, 2, '64ab7988cd6af.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(11, 3, '64ab7988ce151.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(12, 4, '64ab7988ceb25.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(13, 1, '64ab7988d0cb4.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(14, 2, '64ab7988d1621.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(15, 3, '64ab7988d966d.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(16, 4, '64ab7988dab94.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(17, 1, '64ab7988ddfba.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(18, 2, '64ab7988dee1a.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(19, 3, '64ab7988df84f.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(20, 4, '64ab7988e038e.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(21, 1, '64ab7988e26b1.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(22, 2, '64ab7988e30b2.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(23, 3, '64ab7988e3a7f.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(24, 4, '64ab7988e4429.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(25, 1, '64ab7988ecf0e.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(26, 2, '64ab7988ee13f.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(27, 3, '64ab7988eecf4.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(28, 4, '64ab7988ef8ff.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(29, 1, '64ab7988f21c3.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(30, 2, '64ab7988f2bc7.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(31, 3, '64ab7988f35be.png', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(32, 4, '64ab7988f3f83.png', '2023-07-10 03:22:49', '2023-07-10 03:22:49'),
	(33, 1, '64ab7989020bf.png', '2023-07-10 03:22:49', '2023-07-10 03:22:49'),
	(34, 2, '64ab798903047.png', '2023-07-10 03:22:49', '2023-07-10 03:22:49'),
	(35, 3, '64ab798903e91.png', '2023-07-10 03:22:49', '2023-07-10 03:22:49'),
	(36, 4, '64ab798904d3f.png', '2023-07-10 03:22:49', '2023-07-10 03:22:49'),
	(37, 1, '64ab79890f98e.png', '2023-07-10 03:22:49', '2023-07-10 03:22:49'),
	(38, 2, '64ab7989114ef.png', '2023-07-10 03:22:49', '2023-07-10 03:22:49'),
	(39, 3, '64ab798917a94.png', '2023-07-10 03:22:49', '2023-07-10 03:22:49'),
	(40, 4, '64ab7989195aa.png', '2023-07-10 03:22:49', '2023-07-10 03:22:49');

-- Dumping structure for table tunibibi.product_reviews
CREATE TABLE IF NOT EXISTS `product_reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `rating` int NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.product_reviews: ~0 rows (approximately)
INSERT INTO `product_reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
	(1, 3, 1, 3, 'ggdhg', '2023-07-14 07:09:41', '2023-09-10 05:45:52');

-- Dumping structure for table tunibibi.product_varients
CREATE TABLE IF NOT EXISTS `product_varients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `varients` json NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_varients_product_id_foreign` (`product_id`),
  KEY `product_varients_user_id_foreign` (`user_id`),
  CONSTRAINT `product_varients_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_varients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.product_varients: ~10 rows (approximately)
INSERT INTO `product_varients` (`id`, `user_id`, `product_id`, `name`, `color`, `varients`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 'Red', '64ab7988b1c8f.png', '[{"size": "21-inch 8/256", "color": "red", "stock": 20}, {"size": "21-inch 16/256", "color": "red", "stock": 33}, {"size": "21-inch 16/500", "color": "red", "stock": 3434}]', '2023-07-09 21:22:48', '2023-09-08 05:36:52'),
	(2, 1, 10, 'Green', '64ab7988b2e7f.png', '[{"size": "21-inch 8/256", "color": "red", "stock": 20}, {"size": "21-inch 16/256", "color": "red", "stock": 33}, {"size": "21-inch 16/500", "color": "red", "stock": 3434}]', '2023-07-09 21:22:48', '2023-09-08 05:54:10'),
	(3, 1, NULL, 'Blue', '64ab7988b39fe.png', '[{"size": "21-inch 8/256", "color": "red", "stock": 20}, {"size": "21-inch 16/256", "color": "red", "stock": 33}, {"size": "21-inch 16/500", "color": "red", "stock": 3434}]', '2023-07-09 21:22:48', '2023-07-29 17:35:02'),
	(4, 1, NULL, 'dpUPwsvkAKyr', '64ab7988b435d.png', '[{"size": "21-inch 8/256", "color": "red", "stock": 20}, {"size": "21-inch 16/256", "color": "red", "stock": 33}, {"size": "21-inch 16/500", "color": "red", "stock": 3434}]', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(5, 1, NULL, 'kh8teiDQ43X9', '64ab7988b4c2f.png', '[{"size": "21-inch 8/256", "color": "red", "stock": 20}, {"size": "21-inch 16/256", "color": "red", "stock": 33}, {"size": "21-inch 16/500", "color": "red", "stock": 3434}]', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(6, 1, NULL, 'W4UcmEmRXhSE', '64ab7988b5337.png', '[{"size": "21-inch 8/256", "color": "red", "stock": 20}, {"size": "21-inch 16/256", "color": "red", "stock": 33}, {"size": "21-inch 16/500", "color": "red", "stock": 3434}]', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(7, 1, NULL, 'LKSs54Me88dH', '64ab7988b5b36.png', '[{"size": "21-inch 8/256", "color": "red", "stock": 20}, {"size": "21-inch 16/256", "color": "red", "stock": 33}, {"size": "21-inch 16/500", "color": "red", "stock": 3434}]', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(8, 1, NULL, '2lzOW7ZTWwZG', '64ab7988b6197.png', '[{"size": "21-inch 8/256", "color": "red", "stock": 20}, {"size": "21-inch 16/256", "color": "red", "stock": 33}, {"size": "21-inch 16/500", "color": "red", "stock": 3434}]', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(9, 1, NULL, 'w8PHadnSbG4n', '64ab7988b6904.png', '[{"size": "21-inch 8/256", "color": "red", "stock": 20}, {"size": "21-inch 16/256", "color": "red", "stock": 33}, {"size": "21-inch 16/500", "color": "red", "stock": 3434}]', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(10, 1, NULL, 'N1rc7pDCNQKb', '64ab7988b6f38.png', '[{"size": "21-inch 8/256", "color": "red", "stock": 20}, {"size": "21-inch 16/256", "color": "red", "stock": 33}, {"size": "21-inch 16/500", "color": "red", "stock": 3434}]', '2023-07-09 21:22:48', '2023-07-09 21:22:48');

-- Dumping structure for table tunibibi.product_videos
CREATE TABLE IF NOT EXISTS `product_videos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `products` json DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.product_videos: ~0 rows (approximately)

-- Dumping structure for table tunibibi.product_views
CREATE TABLE IF NOT EXISTS `product_views` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` int NOT NULL,
  `buyer_id` int DEFAULT NULL,
  `product_id` int NOT NULL,
  `date` date NOT NULL DEFAULT '2023-07-10',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.product_views: ~0 rows (approximately)

-- Dumping structure for table tunibibi.refers_code
CREATE TABLE IF NOT EXISTS `refers_code` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint unsigned DEFAULT NULL,
  `buyer_id` bigint unsigned DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `refers_code_seller_id_foreign` (`seller_id`),
  KEY `refers_code_buyer_id_foreign` (`buyer_id`),
  CONSTRAINT `refers_code_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `refers_code_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.refers_code: ~0 rows (approximately)
INSERT INTO `refers_code` (`id`, `seller_id`, `buyer_id`, `code`, `user_type`, `created_at`, `updated_at`) VALUES
	(2, NULL, 3, 'ZRXYHSNK', 'BUYER', '2023-08-05 05:38:08', '2023-08-05 05:38:08');

-- Dumping structure for table tunibibi.refer_earnings
CREATE TABLE IF NOT EXISTS `refer_earnings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `refer_user_id` bigint unsigned NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `amount_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.refer_earnings: ~0 rows (approximately)

-- Dumping structure for table tunibibi.refer_earning_policy
CREATE TABLE IF NOT EXISTS `refer_earning_policy` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `policy` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.refer_earning_policy: ~2 rows (approximately)
INSERT INTO `refer_earning_policy` (`id`, `policy`, `created_at`, `updated_at`) VALUES
	(2, 'policy', NULL, NULL),
	(3, 'dfgdfg', NULL, NULL),
	(4, 'ABC', '2023-09-23 20:51:46', '2023-09-23 20:51:46');

-- Dumping structure for table tunibibi.rms_groups
CREATE TABLE IF NOT EXISTS `rms_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.rms_groups: ~2 rows (approximately)
INSERT INTO `rms_groups` (`id`, `group_name`, `created_at`, `updated_at`) VALUES
	(1, 'Editor', '2023-08-04 18:29:42', '2023-08-04 18:29:42'),
	(2, 'Sales', NULL, NULL),
	(3, 'Marketing', NULL, NULL);

-- Dumping structure for table tunibibi.rms_group_menus
CREATE TABLE IF NOT EXISTS `rms_group_menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group_id` bigint unsigned NOT NULL,
  `menus` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.rms_group_menus: ~2 rows (approximately)
INSERT INTO `rms_group_menus` (`id`, `group_id`, `menus`, `created_at`, `updated_at`) VALUES
	(2, 1, '["/Dashboard", "/Users"]', '2023-08-04 18:11:29', '2023-08-04 18:11:29'),
	(3, 2, '["/SalesReport"]', NULL, NULL),
	(4, 3, '["/MaketingDetails", "/MonthlyEarn"]', NULL, NULL);

-- Dumping structure for table tunibibi.rms_menus
CREATE TABLE IF NOT EXISTS `rms_menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.rms_menus: ~0 rows (approximately)
INSERT INTO `rms_menus` (`id`, `name`, `url`, `created_at`, `updated_at`) VALUES
	(2, 'Dashboard', '/home', '2023-08-05 06:43:12', '2023-08-05 06:43:12');

-- Dumping structure for table tunibibi.rms_permissions
CREATE TABLE IF NOT EXISTS `rms_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int unsigned NOT NULL,
  `group_id` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.rms_permissions: ~2 rows (approximately)
INSERT INTO `rms_permissions` (`id`, `admin_id`, `group_id`, `created_at`, `updated_at`) VALUES
	(2, 1, '[3]', '2023-08-04 18:30:00', '2023-08-04 18:30:00');

-- Dumping structure for table tunibibi.search_histories
CREATE TABLE IF NOT EXISTS `search_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint unsigned NOT NULL,
  `search_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.search_histories: ~18 rows (approximately)
INSERT INTO `search_histories` (`id`, `buyer_id`, `search_value`, `category_name`, `created_at`, `updated_at`) VALUES
	(1, 3, '', 'Mackbook', '2023-08-05 05:47:05', '2023-08-05 05:47:05'),
	(2, 3, '', NULL, '2023-08-05 05:48:10', '2023-08-05 05:48:10'),
	(3, 3, '', NULL, '2023-08-05 05:48:13', '2023-08-05 05:48:13'),
	(4, 3, 'MacboockPro', '', '2023-08-05 05:49:16', '2023-08-05 05:49:16'),
	(5, 3, 'MacboockPro AA', '', '2023-08-05 05:49:24', '2023-08-05 05:49:24'),
	(6, 3, 'MacboockPro AA', '', '2023-09-09 09:58:49', '2023-09-09 09:58:49'),
	(7, 3, 'Austyn Fisher', '', '2023-09-09 09:59:07', '2023-09-09 09:59:07'),
	(8, 3, '', 'Mackbook', '2023-09-09 23:36:49', '2023-09-09 23:36:49'),
	(9, 3, '', 'Mackbook', '2023-09-09 23:39:05', '2023-09-09 23:39:05'),
	(10, 3, '', 'Mackbook', '2023-09-09 23:40:17', '2023-09-09 23:40:17'),
	(11, 3, 'Austyn Fisher', '', '2023-09-10 06:20:09', '2023-09-10 06:20:09'),
	(12, 3, 'Austyn Fisher', '', '2023-09-10 06:22:24', '2023-09-10 06:22:24'),
	(13, 3, 'Aust', '', '2023-09-10 06:22:39', '2023-09-10 06:22:39'),
	(14, 3, 'Aust', '', '2023-09-11 03:36:54', '2023-09-11 03:36:54'),
	(15, 3, '', 'Mackbook', '2023-09-11 03:37:05', '2023-09-11 03:37:05'),
	(16, 3, '', 'Mackbook', '2023-09-11 03:37:43', '2023-09-11 03:37:43'),
	(17, 3, 'Aust', '', '2023-09-11 03:37:50', '2023-09-11 03:37:50'),
	(18, 3, '', 'Mackbook', '2023-09-11 03:54:30', '2023-09-11 03:54:30'),
	(19, 3, 'Aust', '', '2023-09-11 03:54:37', '2023-09-11 03:54:37');

-- Dumping structure for table tunibibi.sellers
CREATE TABLE IF NOT EXISTS `sellers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `business_type_id` int DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `date` date NOT NULL DEFAULT '2023-07-10',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_online` tinyint(1) NOT NULL DEFAULT '1',
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sellers_phone_unique` (`phone`),
  UNIQUE KEY `sellers_shop_name_unique` (`shop_name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.sellers: ~10 rows (approximately)
INSERT INTO `sellers` (`id`, `phone`, `email`, `shop_name`, `business_type_id`, `address`, `slug`, `logo`, `password`, `is_active`, `date`, `created_at`, `updated_at`, `is_online`, `country`) VALUES
	(1, '+8801975780794', 'noel87@bode.com', 'Keenan Friesen DDS', 1, '88955 Trey Coves\nMonahanville, NC 52375', 'in-commodi-voluptatem-sed-distinctio-laborum-nobis-tempora', '64ab798815c77.png', '$2y$10$JpwCyxf2SQnIZHyYPGrNuOeqbcABp96UN6WEFDurLYRHGtio.XQJK', '1', '2023-07-10', '2023-07-09 21:22:48', '2023-07-14 00:48:25', 1, 'Bangladesh'),
	(2, '+19255895996', 'brooks56@gaylord.org', 'Sabryna Lemke', 1, '301 Garrison Avenue\nCharleyville, UT 25286', 'assumenda-magnam-nulla-distinctio', '64ab798822299.png', '$2y$10$HVdOjH7B3cip3sGSwZLD/.bdS2TVJklXhr4u0nefoa1sGWq90FMxm', '1', '2023-07-10', '2023-07-09 21:22:48', '2023-07-09 21:22:48', 1, 'Bangladesh'),
	(3, '+15409638889', 'emard.elmore@bahringer.info', 'Ima Conn', 1, '16630 Mueller Road Suite 259\nNew Maiyamouth, NE 23816', 'itaque-beatae-doloremque-rerum-earum-et-blanditiis-soluta-rem', '64ab79882e70c.png', '$2y$10$nBl4OnSQVqW0XklFzXdFw.qJdjyuBmCsJ9G4fIfkIH4VDGwmWDHUq', '1', '2023-07-10', '2023-07-09 21:22:48', '2023-07-09 21:22:48', 1, 'Bangladesh'),
	(4, '828.476.5322', 'lonny.gaylord@yahoo.com', 'Magali Witting', 1, '313 Balistreri Bypass\nWest Corbintown, WV 91995', 'quo-quis-sequi-vel-veritatis-nobis-officia-ea', '64ab79883a594.png', '$2y$10$8YM5Ik5euLXy379zZbYboeJQ1XREWJPTxCja0OvO6yIWKOZe44czq', '1', '2023-07-10', '2023-07-09 21:22:48', '2023-07-09 21:22:48', 1, 'Bangladesh'),
	(5, '(940) 906-4188', 'bwalker@crona.com', 'Christop Farrell', 1, '40324 Daphne Falls\nWest Makenzie, GA 19380', 'ullam-maxime-quis-impedit-placeat-incidunt-saepe', '64ab798847007.png', '$2y$10$qIkbBHg1TKq0S5P/314YqetGAguS7uaV27c/zvqghHaJ1PulZFYny', '1', '2023-07-10', '2023-07-09 21:22:48', '2023-07-09 21:22:48', 1, 'Bangladesh'),
	(6, '+13203475310', 'casimir.bartoletti@hotmail.com', 'Flo Ankunding Sr.', 1, '718 Crawford Roads\nNew Katherinemouth, CA 98907-9321', 'occaecati-illo-perspiciatis-modi-harum-odio', '64ab798852e12.png', '$2y$10$ruH1HyWhQaq3Mx907CNs/OXbfGc/P9dovjqEyn24edM1fPJ6ewoBm', '1', '2023-07-10', '2023-07-09 21:22:48', '2023-07-09 21:22:48', 1, 'Bangladesh'),
	(7, '573-845-8331', 'ritchie.myrna@kautzer.net', 'Dario O\'Kon Jr.', 1, '593 Weber Divide Suite 162\nPort Sarah, MO 43151-9799', 'cupiditate-eum-laboriosam-ullam-laudantium-ut-ut-ipsam', '64ab79885ec8c.png', '$2y$10$P0QLnNY24xd4pqHCIe9nFeFryDoWWf2l9fSmx3WWnRxdqssBTwSpy', '1', '2023-07-10', '2023-07-09 21:22:48', '2023-07-09 21:22:48', 1, 'Bangladesh'),
	(8, '1-936-984-9525', 'denesik.eunice@hoppe.org', 'Jessy Schuster', 1, '951 Huels Center Apt. 466\nEast Jack, OR 55706', 'dolorum-est-tempore-quia-et', '64ab79886aa33.png', '$2y$10$uewqriXahYpJzcBLfW9FpOF2HdfJQDPNJE8QNi4M4S3193E/atLbu', '1', '2023-07-10', '2023-07-09 21:22:48', '2023-07-09 21:22:48', 1, 'Bangladesh'),
	(9, '385.526.7870', 'pmorissette@gmail.com', 'Lane Zboncak', 1, '76081 Malika Point\nYesseniaton, MI 28592', 'similique-recusandae-maxime-qui-quas-quia', '64ab798876e0f.png', '$2y$10$WZSzmz8oIjIdsblbLkoOgeAU1YLTTZJn0cmJGnAnsGC6R2gp8lVJO', '1', '2023-07-10', '2023-07-09 21:22:48', '2023-07-09 21:22:48', 1, 'Bangladesh'),
	(10, '(651) 859-3812', 'uzieme@weissnat.com', 'Donavon O\'Kon', 1, '98873 Jamel Estate Apt. 419\nNorth Mozelle, WA 32568-1875', 'sapiente-similique-et-culpa-quia-animi-sequi', '64ab798882c0c.png', '$2y$10$3/Ughejjwkq.ppRiJ/s4Lu1MqqX2GxzBXoFDdeeyw4s8ra1wb2MaW', '1', '2023-07-10', '2023-07-09 21:22:48', '2023-07-09 21:22:48', 1, 'Bangladesh');

-- Dumping structure for table tunibibi.seller_buyer_refer_comission
CREATE TABLE IF NOT EXISTS `seller_buyer_refer_comission` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.seller_buyer_refer_comission: ~0 rows (approximately)
INSERT INTO `seller_buyer_refer_comission` (`id`, `country`, `amount`, `created_at`, `updated_at`) VALUES
	(1, 'Bangladesh', 100, NULL, NULL);

-- Dumping structure for table tunibibi.seller_coin_type
CREATE TABLE IF NOT EXISTS `seller_coin_type` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coin_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.seller_coin_type: ~0 rows (approximately)
INSERT INTO `seller_coin_type` (`id`, `country`, `coin_name`, `created_at`, `updated_at`) VALUES
	(1, 'Bangladesh', 'TK', NULL, NULL);

-- Dumping structure for table tunibibi.seller_courier_charges
CREATE TABLE IF NOT EXISTS `seller_courier_charges` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint unsigned NOT NULL,
  `charge` double NOT NULL,
  `above_amount` double NOT NULL,
  `courier_details` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seller_courier_charges_seller_id_foreign` (`seller_id`),
  CONSTRAINT `seller_courier_charges_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.seller_courier_charges: ~2 rows (approximately)
INSERT INTO `seller_courier_charges` (`id`, `seller_id`, `charge`, `above_amount`, `courier_details`, `created_at`, `updated_at`) VALUES
	(1, 1, 200, 1000, 'Test-1', NULL, NULL),
	(2, 1, 200, 1000, 'Test-2', NULL, NULL),
	(3, 1, 200, 1000, 'Test-3', NULL, NULL);

-- Dumping structure for table tunibibi.seller_extra_charges
CREATE TABLE IF NOT EXISTS `seller_extra_charges` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint unsigned NOT NULL,
  `extra_charge_id` bigint unsigned NOT NULL,
  `catagory_id` bigint unsigned NOT NULL,
  `charge_amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seller_extra_charges_seller_id_foreign` (`seller_id`),
  KEY `seller_extra_charges_catagory_id_foreign` (`catagory_id`),
  CONSTRAINT `seller_extra_charges_catagory_id_foreign` FOREIGN KEY (`catagory_id`) REFERENCES `catagory` (`id`) ON DELETE CASCADE,
  CONSTRAINT `seller_extra_charges_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.seller_extra_charges: ~2 rows (approximately)
INSERT INTO `seller_extra_charges` (`id`, `seller_id`, `extra_charge_id`, `catagory_id`, `charge_amount`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 1, 100, '2023-08-05 15:54:13', '2023-08-05 15:54:13'),
	(2, 1, 2, 1, 100, '2023-08-05 15:54:49', '2023-08-05 15:54:49'),
	(3, 1, 3, 1, 100, '2023-08-05 15:54:53', '2023-08-05 15:54:53');

-- Dumping structure for table tunibibi.seller_followers
CREATE TABLE IF NOT EXISTS `seller_followers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint unsigned NOT NULL,
  `buyer_id` bigint unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `seller_followers_seller_id_foreign` (`seller_id`),
  KEY `seller_followers_buyer_id_foreign` (`buyer_id`),
  CONSTRAINT `seller_followers_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `buyers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `seller_followers_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.seller_followers: ~0 rows (approximately)

-- Dumping structure for table tunibibi.seller_payments
CREATE TABLE IF NOT EXISTS `seller_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint unsigned NOT NULL,
  `payment_method_id` int NOT NULL,
  `order_id` int NOT NULL,
  `amount` double NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_date` date NOT NULL DEFAULT '2023-07-10',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seller_payments_seller_id_foreign` (`seller_id`),
  CONSTRAINT `seller_payments_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.seller_payments: ~0 rows (approximately)

-- Dumping structure for table tunibibi.seller_payment_details
CREATE TABLE IF NOT EXISTS `seller_payment_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint unsigned NOT NULL,
  `method_id` int unsigned NOT NULL,
  `method_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `seller_payment_details_seller_id_foreign` (`seller_id`),
  CONSTRAINT `seller_payment_details_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.seller_payment_details: ~0 rows (approximately)

-- Dumping structure for table tunibibi.seller_recharge_requests
CREATE TABLE IF NOT EXISTS `seller_recharge_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` int unsigned NOT NULL,
  `country_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operator` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.seller_recharge_requests: ~0 rows (approximately)
INSERT INTO `seller_recharge_requests` (`id`, `seller_id`, `country_name`, `code`, `operator`, `mobile_no`, `amount`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, 'b', 'fd', 'sfd', '2342', 324, 'complete', NULL, '2023-07-09 22:21:36');

-- Dumping structure for table tunibibi.seller_refer_coin_exchange
CREATE TABLE IF NOT EXISTS `seller_refer_coin_exchange` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.seller_refer_coin_exchange: ~0 rows (approximately)
INSERT INTO `seller_refer_coin_exchange` (`id`, `country`, `amount`, `currency`) VALUES
	(1, 'Bangladesh', 100, 'BDT');

-- Dumping structure for table tunibibi.seller_refer_comission
CREATE TABLE IF NOT EXISTS `seller_refer_comission` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.seller_refer_comission: ~0 rows (approximately)
INSERT INTO `seller_refer_comission` (`id`, `country`, `amount`, `created_at`, `updated_at`) VALUES
	(1, 'Bangladesh', 23, NULL, NULL);

-- Dumping structure for table tunibibi.seller_refer_earnings
CREATE TABLE IF NOT EXISTS `seller_refer_earnings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint unsigned NOT NULL,
  `coins` int NOT NULL,
  `refered_seller_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `seller_refer_earnings_refered_seller_id_foreign` (`refered_seller_id`),
  KEY `seller_refer_earnings_seller_id_foreign` (`seller_id`),
  CONSTRAINT `seller_refer_earnings_refered_seller_id_foreign` FOREIGN KEY (`refered_seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `seller_refer_earnings_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.seller_refer_earnings: ~2 rows (approximately)
INSERT INTO `seller_refer_earnings` (`id`, `seller_id`, `coins`, `refered_seller_id`, `created_at`, `updated_at`) VALUES
	(1, 3, 1, 1, '2023-08-16 06:56:03', '2023-08-16 06:56:03'),
	(2, 8, 11, 1, '2023-08-16 06:56:11', '2023-08-16 06:56:14');

-- Dumping structure for table tunibibi.shipping_packages
CREATE TABLE IF NOT EXISTS `shipping_packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `from_country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `to_country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `days` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `shipping_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_types` json NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.shipping_packages: ~4 rows (approximately)
INSERT INTO `shipping_packages` (`id`, `from_country`, `to_country`, `amount`, `days`, `created_at`, `updated_at`, `shipping_type`, `unit_types`) VALUES
	(2, 'Bangladesh', 'Bangladesh', 100, '12', NULL, NULL, 'Air', '[{"KG": 100, "id": 1}]'),
	(3, 'ABC', 'ABC', 0, 'ABC', '2023-07-17 21:22:09', '2023-07-17 21:22:09', 'ABC', '[{"KG": 1200, "GRM": 10, "LTR": 600}]'),
	(4, 'ABC', 'ABC', 0, 'ABC', '2023-07-17 21:23:27', '2023-07-17 21:23:27', 'ABC', '[{"KG": 1200, "GRM": 10, "LTR": 600}]');

-- Dumping structure for table tunibibi.shop_onlines
CREATE TABLE IF NOT EXISTS `shop_onlines` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `from_time` time NOT NULL,
  `to_time` time DEFAULT NULL,
  `from_date` date NOT NULL,
  `to_date` date DEFAULT NULL,
  `is_active` int NOT NULL DEFAULT '1',
  `date` date NOT NULL DEFAULT '2023-07-10',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.shop_onlines: ~0 rows (approximately)

-- Dumping structure for table tunibibi.shop_views
CREATE TABLE IF NOT EXISTS `shop_views` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int NOT NULL,
  `buyer_id` int DEFAULT NULL,
  `date` date NOT NULL DEFAULT '2023-07-10',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.shop_views: ~0 rows (approximately)

-- Dumping structure for table tunibibi.sliders
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.sliders: ~0 rows (approximately)

-- Dumping structure for table tunibibi.sub_catagory
CREATE TABLE IF NOT EXISTS `sub_catagory` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `catagory_id` bigint unsigned NOT NULL,
  `sub_catagory_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_catagory_img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sub_catagory_catagory_id_foreign` (`catagory_id`),
  CONSTRAINT `sub_catagory_catagory_id_foreign` FOREIGN KEY (`catagory_id`) REFERENCES `catagory` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.sub_catagory: ~10 rows (approximately)
INSERT INTO `sub_catagory` (`id`, `catagory_id`, `sub_catagory_name`, `sub_catagory_img`, `created_at`, `updated_at`) VALUES
	(1, 1, 'uEqlz16aI6yq', '64ab7988a30b3.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(2, 1, '9mAUNsosgZrF', '64ab7988a39aa.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(3, 1, 'Rosc4omu0HzV', '64ab7988a4020.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(4, 1, 'YIekGQ6Zp5EB', '64ab7988a464c.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(5, 1, 'MJ51qL6Q6dHV', '64ab7988a4e0a.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(6, 1, 'Ek1t5JQOfuYC', '64ab7988a5449.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(7, 1, 'LRCzFnFMYhCq', '64ab7988a5afc.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(8, 1, 'i4l03EUTROfZ', '64ab7988a6296.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(9, 1, 'aTWzkxyuwVlf', '64ab7988a6a43.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(10, 1, 'Vr75P5EtX286', '64ab7988a7051.png', '2023-07-09 21:22:48', '2023-07-09 21:22:48');

-- Dumping structure for table tunibibi.super_deals
CREATE TABLE IF NOT EXISTS `super_deals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `wholesale_price_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.super_deals: ~6 rows (approximately)
INSERT INTO `super_deals` (`id`, `product_id`, `wholesale_price_id`, `from`, `to`, `date`, `created_at`, `updated_at`) VALUES
	(1, 1, '[{"min_quantity":10,"max_quantity":202,"amount":200,"unit":"KG"}]', '2023-05-11', '2023-09-11', NULL, '2023-07-14 00:50:18', '2023-07-14 00:59:03'),
	(2, 2, '[{"min_quantity":10,"max_quantity":202,"amount":200,"unit":"KG"}]', '2023-05-11', '2023-09-11', NULL, '2023-07-14 00:52:51', '2023-07-14 08:32:47'),
	(3, 3, '[{"min_quantity":10,"max_quantity":202,"amount":200,"unit":"KG"}]', '2023-05-11', '2023-09-11', NULL, '2023-07-14 00:52:57', '2023-07-14 08:47:15'),
	(4, 4, '[{"min_quantity":10,"max_quantity":202,"amount":200,"unit":"KG"}]', '2023-07-14', '2023-09-14', NULL, '2023-07-14 08:49:00', '2023-07-14 08:49:21'),
	(5, 2, '[{"min_quantity":10,"max_quantity":202,"amount":200,"unit":"KG"}]', '2023-05-11', '2023-09-11', NULL, '2023-07-14 09:18:05', '2023-07-14 09:18:05'),
	(6, 1, '[{"min_quantity":10,"max_quantity":202,"amount":200,"unit":"KG"}]', '2023-05-11', '2023-09-11', NULL, '2023-07-14 09:18:17', '2023-07-14 09:18:17');

-- Dumping structure for table tunibibi.tunibibi_address
CREATE TABLE IF NOT EXISTS `tunibibi_address` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apartment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.tunibibi_address: ~0 rows (approximately)
INSERT INTO `tunibibi_address` (`id`, `name`, `mobile`, `street`, `apartment`, `country`, `state`, `city`, `zip`, `created_at`, `updated_at`) VALUES
	(2, 'sdf', 'fsdf', 'sdf', 's', 'sdfsdf', 'sdfsd', 'fsd', 'fsdf', NULL, NULL);

-- Dumping structure for table tunibibi.unit_weights
CREATE TABLE IF NOT EXISTS `unit_weights` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.unit_weights: ~4 rows (approximately)
INSERT INTO `unit_weights` (`id`, `unit_name`, `created_at`, `updated_at`) VALUES
	(1, 'KG', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(2, 'GRM', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(3, 'LITR', '2023-07-09 21:22:48', '2023-07-09 21:22:48'),
	(4, 'ML', '2023-07-09 21:22:48', '2023-07-09 21:22:48');

-- Dumping structure for table tunibibi.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.users: ~0 rows (approximately)

-- Dumping structure for table tunibibi.vouchers
CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `voucher_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_amount` int NOT NULL,
  `amount` int NOT NULL,
  `expire_date` date NOT NULL,
  `is_used` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_selected` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.vouchers: ~10 rows (approximately)
INSERT INTO `vouchers` (`id`, `user_id`, `user_type`, `voucher_code`, `min_amount`, `amount`, `expire_date`, `is_used`, `created_at`, `updated_at`, `is_selected`) VALUES
	(1, 3, 'buyer', 'AVC', 100, 40, '2023-10-02', 0, NULL, NULL, 1),
	(2, 3, 'buyer', 'TY2ZIf', 100, 10, '2023-11-15', 0, '2023-09-16 04:23:31', '2023-09-16 04:23:31', 0),
	(4, 3, 'buyer', 'Dy5xrd', 100, 10, '2023-11-15', 0, '2023-09-16 04:25:33', '2023-09-16 04:25:33', 0),
	(5, 3, 'buyer', 'kfpzTl', 100, 10, '2023-11-15', 0, '2023-09-16 04:26:01', '2023-09-16 04:26:01', 0),
	(6, 3, 'buyer', 'kMIhu3', 100, 10, '2023-11-15', 0, '2023-09-16 04:26:19', '2023-09-16 04:26:19', 0),
	(7, 3, 'buyer', 'TJ1e1l', 100, 10, '2023-11-15', 0, '2023-09-16 04:26:27', '2023-09-16 04:26:27', 0),
	(8, 3, 'buyer', 'bAnfq6', 100, 10, '2023-11-15', 0, '2023-09-16 04:26:39', '2023-09-16 04:26:39', 0),
	(9, 3, 'buyer', 'ABCC', 1000, 100, '2023-10-02', 0, '2023-09-23 20:48:23', '2023-09-23 20:48:23', 0),
	(10, 3, 'buyer', 'ABCC', 1000, 100, '2023-10-02', 0, '2023-09-23 20:48:46', '2023-09-23 20:48:46', 0);

-- Dumping structure for table tunibibi.wholesale_prices
CREATE TABLE IF NOT EXISTS `wholesale_prices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `min_quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `max_quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `wholesale_prices_product_id_foreign` (`product_id`),
  CONSTRAINT `wholesale_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.wholesale_prices: ~20 rows (approximately)
INSERT INTO `wholesale_prices` (`id`, `product_id`, `min_quantity`, `max_quantity`, `amount`, `unit`, `created_at`, `updated_at`) VALUES
	(1, 1, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(2, 1, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(3, 2, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(4, 2, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(5, 3, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(6, 3, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(7, 4, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(8, 4, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(9, 5, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(10, 5, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(11, 6, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(12, 6, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(13, 7, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(14, 7, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(15, 8, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(16, 8, '10', '20', 200, 'KG', '2023-07-10 03:22:48', '2023-07-10 03:22:48'),
	(17, 9, '10', '20', 200, 'KG', '2023-07-10 03:22:49', '2023-07-10 03:22:49'),
	(18, 9, '10', '20', 200, 'KG', '2023-07-10 03:22:49', '2023-07-10 03:22:49'),
	(19, 10, '10', '20', 300, 'KG', '2023-07-10 03:22:49', '2023-09-08 05:58:22'),
	(20, 10, '6', '10', 100, 'KG', '2023-07-10 03:22:49', '2023-09-08 05:54:48');

-- Dumping structure for table tunibibi.wirehouses
CREATE TABLE IF NOT EXISTS `wirehouses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'COD',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table tunibibi.wirehouses: ~2 rows (approximately)
INSERT INTO `wirehouses` (`id`, `country`, `name`, `address`, `created_at`, `updated_at`, `number`, `city`, `postcode`, `password`, `payment_method`) VALUES
	(2, 'Bangladesh', 'Bangladesh Wirehouse 11', 'Dhaka', '2023-09-23 13:35:52', '2023-09-23 13:35:52', '+8801890343', 'Dhaka', '1200', '$2y$10$IxcSMu.xMVQOmFSiPdUufuxcMp1boWtvzGWJeUL4QvMgyHSrWpZui', 'COD'),
	(3, 'India', 'India Wirehouse LTD', 'Delhi', '2023-09-23 20:58:18', '2023-09-23 20:58:18', '+91 0000', 'Delhi', '620', 'erer', 'COD'),
	(4, 'Bangladesh', 'Bangladesh Wirehouse 11', 'Dhaka', '2023-09-24 22:17:23', '2023-09-24 22:17:23', '+8801890343', 'Dhaka', '1200', '$2y$10$gK/vZpRZQ2P3KNa7b6MduOjqrB0EJV8/2phqjUQaVg7eMSK15W8t2', 'COD');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
