-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2025 at 09:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timplato`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `session_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '2025-09-08 09:19:09', '2025-09-08 09:19:09'),
(2, NULL, '6N5frEpziHSV4UtfXOwdaAhyo0dmtzsrFR5e0lKu', '2025-09-09 20:15:50', '2025-09-09 20:15:50'),
(3, NULL, 'ajFuDEihYj5sRbaB6xxcGxCnTc3E7Kdxct5Z9ohE', '2025-09-11 08:09:50', '2025-09-11 08:09:50'),
(4, NULL, 'O6RhOFyUug9M5ER0atglm1k4a0lxgEII4NNPNXjR', '2025-09-19 02:11:15', '2025-09-19 02:11:15'),
(5, 2, NULL, '2025-09-19 02:16:11', '2025-09-19 02:16:11'),
(6, NULL, 'WiXsWqBnf0OsU647n7jxqNgU3gkCRTugUJbZBCSt', '2025-09-24 12:22:28', '2025-09-24 12:22:28'),
(7, 5, NULL, '2025-09-25 08:57:35', '2025-09-25 08:57:35'),
(8, 4, NULL, '2025-09-25 11:09:55', '2025-09-25 11:09:55');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(7, 2, 2, 1, '2025-09-09 20:15:50', '2025-09-09 20:15:50'),
(8, 1, 3, 4, '2025-09-11 22:28:39', '2025-09-11 22:30:50'),
(9, 1, 45, 1, '2025-09-11 22:30:01', '2025-09-11 22:30:01'),
(10, 1, 35, 15, '2025-09-11 22:33:28', '2025-09-11 22:33:28'),
(11, 4, 1, 1, '2025-09-19 02:11:15', '2025-09-19 02:11:15'),
(14, 6, 3, 1, '2025-09-24 12:22:29', '2025-09-24 12:22:29');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Cookware', NULL, '2025-09-08 16:59:19', '2025-09-08 16:59:19'),
(2, 'Kitchen Tools & Utensils', NULL, '2025-09-08 16:59:19', '2025-09-08 16:59:19'),
(3, 'Tableware & Serving', NULL, '2025-09-08 16:59:19', '2025-09-08 16:59:19'),
(4, 'Pots & Pans', 1, '2025-09-08 16:59:19', '2025-09-08 16:59:19'),
(5, 'Cookware Sets', 1, '2025-09-08 16:59:19', '2025-09-08 16:59:19'),
(6, 'Specialty Cookware', 1, '2025-09-08 16:59:19', '2025-09-08 16:59:19'),
(7, 'Cutting Tools', 2, '2025-09-08 16:59:19', '2025-09-08 16:59:19'),
(8, 'Cooking Utensils', 2, '2025-09-08 16:59:19', '2025-09-08 16:59:19'),
(9, 'Preparation Tools', 2, '2025-09-08 16:59:19', '2025-09-08 16:59:19'),
(10, 'Plates & Bowls', 3, '2025-09-08 16:59:19', '2025-09-08 16:59:19'),
(11, 'Drinkware', 3, '2025-09-08 16:59:19', '2025-09-08 16:59:19'),
(12, 'Serving Tools', 3, '2025-09-08 16:59:19', '2025-09-08 16:59:19');

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `courier_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `tracking_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_24_182912_create_personal_access_tokens_table', 1),
(5, '2025_08_24_185544_create_categories_table', 1),
(6, '2025_08_24_185641_create_products_table', 1),
(7, '2025_08_24_185730_create_product_images_table', 1),
(8, '2025_09_05_144440_create_user_addresses_table', 1),
(9, '2025_09_05_144501_create_wishlists_table', 1),
(10, '2025_09_06_195400_create_carts_table', 1),
(11, '2025_09_06_195501_create_cart_items_table', 1),
(12, '2025_09_06_201310_create_riders_table', 1),
(13, '2025_09_06_201315_create_couriers_table', 1),
(14, '2025_09_06_201327_create_orders_table', 1),
(15, '2025_09_06_201340_create_order_items_table', 1),
(16, '2025_09_06_201349_create_order_status_history_table', 1),
(17, '2025_09_07_111015_add_columns_to_orders_table', 1),
(18, '2025_09_09_152743_create_reviews_table', 2),
(19, '2025_09_09_181640_create_support_tickets_table', 3),
(22, '2025_09_10_050059_create_notifications_table', 4),
(23, '2025_09_25_174254_add_paymongo_columns_to_orders_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `read_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `title`, `message`, `read_status`, `created_at`, `updated_at`, `order_id`, `product_id`) VALUES
(1, 1, 'Order Delivered', 'Your order <b>#2</b> has been delivered.', 0, '2025-09-10 05:27:13', '2025-09-10 05:27:13', 2, NULL),
(2, 1, 'Order Shipped', 'Your order <b>#3</b> has been shipped and is on the way.', 0, '2025-09-10 05:27:13', '2025-09-10 05:27:13', 3, NULL),
(3, 1, 'Order Returned', 'Your return request for order <b>#6</b> has been processed.', 0, '2025-09-10 05:27:13', '2025-09-10 05:27:13', 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `courier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `voucher_code` varchar(255) DEFAULT NULL,
  `current_status` enum('pending','confirmed','processing','shipped','delivered','cancelled','returned','refunded') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) NOT NULL,
  `payment_intent_id` varchar(255) DEFAULT NULL,
  `client_secret` varchar(255) DEFAULT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `rider_id`, `courier_id`, `total_amount`, `discount_amount`, `voucher_code`, `current_status`, `payment_method`, `payment_intent_id`, `client_secret`, `tracking_number`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, 899.00, 0.00, NULL, 'confirmed', 'COD', NULL, NULL, NULL, '2025-09-08 09:20:45', '2025-09-08 09:20:45'),
(2, 1, NULL, NULL, 899.00, 0.00, NULL, 'delivered', 'COD', NULL, NULL, NULL, '2025-09-08 09:21:38', '2025-09-08 09:21:38'),
(3, 1, NULL, NULL, 999.00, 0.00, NULL, 'shipped', 'COD', NULL, NULL, NULL, '2025-09-08 09:22:01', '2025-09-08 09:22:01'),
(4, 1, NULL, NULL, 799.00, 0.00, NULL, 'cancelled', 'COD', NULL, NULL, NULL, '2025-09-08 09:37:56', '2025-09-08 09:37:56'),
(5, 1, NULL, NULL, 1299.00, 0.00, NULL, 'pending', 'COD', NULL, NULL, NULL, '2025-09-08 09:38:03', '2025-09-08 09:38:03'),
(6, 1, NULL, NULL, 699.00, 0.00, NULL, 'returned', 'COD', NULL, NULL, NULL, '2025-09-08 09:38:09', '2025-09-08 09:38:09'),
(7, 1, NULL, NULL, 499.00, 0.00, NULL, 'pending', 'COD', NULL, NULL, NULL, '2025-09-08 09:38:20', '2025-09-08 09:38:20'),
(8, 1, NULL, NULL, 799.00, 0.00, NULL, 'pending', 'COD', NULL, NULL, NULL, '2025-09-08 10:26:23', '2025-09-08 10:26:23'),
(9, 1, NULL, NULL, 4097.00, 0.00, NULL, 'pending', 'COD', NULL, NULL, NULL, '2025-09-08 10:38:05', '2025-09-08 10:38:05'),
(10, 1, NULL, NULL, 489.30, 209.70, 'GACUSAN30', 'pending', 'COD', NULL, NULL, NULL, '2025-09-08 10:46:11', '2025-09-08 10:46:11'),
(11, 1, NULL, NULL, 4097.00, 0.00, NULL, 'pending', 'COD', NULL, NULL, NULL, '2025-09-09 06:05:35', '2025-09-09 06:05:35'),
(12, 1, NULL, NULL, 4097.00, 0.00, NULL, 'pending', 'COD', NULL, NULL, NULL, '2025-09-09 06:12:07', '2025-09-09 06:12:07'),
(13, 1, NULL, NULL, 3297.00, 0.00, NULL, 'delivered', 'COD', NULL, NULL, NULL, '2025-09-09 07:11:26', '2025-09-09 07:11:26'),
(14, 2, NULL, NULL, 3339.00, 50.00, 'ALDEN50', 'delivered', 'COD', NULL, NULL, NULL, '2025-09-19 02:20:26', '2025-09-19 02:20:26'),
(15, 5, NULL, NULL, 799.00, 0.00, NULL, 'pending', 'COD', NULL, NULL, NULL, '2025-09-25 08:58:14', '2025-09-25 08:58:14'),
(16, 5, NULL, NULL, 949.00, 50.00, 'ALDEN50', 'pending', 'GCash', NULL, NULL, NULL, '2025-09-25 09:22:56', '2025-09-25 09:22:56'),
(17, 5, NULL, NULL, 999.00, 0.00, NULL, 'pending', 'GCash', NULL, NULL, NULL, '2025-09-25 09:41:49', '2025-09-25 09:41:49'),
(18, 5, NULL, NULL, 999.00, 0.00, NULL, 'pending', 'GCash', 'pi_CMyzFqeCFchA6Fv3SrA2rXmK', 'pi_CMyzFqeCFchA6Fv3SrA2rXmK_client_DyHPvzaGzN9C9Hb5zgDGTsZW', NULL, '2025-09-25 09:43:35', '2025-09-25 09:43:36'),
(19, 5, NULL, NULL, 1499.00, 0.00, NULL, 'pending', 'GCash', 'pi_MGMdaZWEXZoiVFzczDcyNaD4', NULL, NULL, '2025-09-25 09:50:31', '2025-09-25 09:50:31'),
(20, 5, NULL, NULL, 1499.00, 0.00, NULL, 'pending', 'GCash', 'pi_ANHqdeVwinJzg8TEXP78fv5G', NULL, NULL, '2025-09-25 09:55:50', '2025-09-25 09:55:51'),
(21, 5, NULL, NULL, 399.00, 0.00, NULL, 'pending', 'GCash', 'pi_FdnUmo6m2pNxrRyabgpB4w8f', 'pi_FdnUmo6m2pNxrRyabgpB4w8f_client_eZuWq6MEg8KsVZ3qY1Fdr4sV', NULL, '2025-09-25 10:03:51', '2025-09-25 10:03:52'),
(22, 5, NULL, NULL, 699.00, 0.00, NULL, 'pending', 'COD', NULL, NULL, NULL, '2025-09-25 10:06:32', '2025-09-25 10:06:32'),
(23, 5, NULL, NULL, 398.00, 0.00, NULL, 'pending', 'GCash', 'pi_rmVzqjAndNyMihUJZBgFEDWN', 'pi_rmVzqjAndNyMihUJZBgFEDWN_client_BkkAuwExqg1JtReWGcpkKUq4', NULL, '2025-09-25 10:06:46', '2025-09-25 10:06:46'),
(24, 4, NULL, NULL, 399.00, 0.00, NULL, 'pending', 'GCash', 'pi_hKPXtxoDhmaqJiBGAgCqzBSJ', 'pi_hKPXtxoDhmaqJiBGAgCqzBSJ_client_gu3RiPAXDwuEn1atmfrEV4SU', NULL, '2025-09-25 10:26:41', '2025-09-25 10:26:42'),
(25, 4, NULL, NULL, 149.00, 50.00, 'ALDEN50', 'pending', 'GCash', 'pi_SWZBHb4eXDPjyYhKM4LLPCVK', 'pi_SWZBHb4eXDPjyYhKM4LLPCVK_client_BRVfJk12jEaZuSGkVsnhHj4G', NULL, '2025-09-25 10:31:06', '2025-09-25 10:31:06'),
(26, 4, NULL, NULL, 899.00, 0.00, NULL, 'pending', 'GCash', 'pi_Hn8LnTeYG6Aq6bGxAqGJK7Ys', NULL, NULL, '2025-09-25 11:10:00', '2025-09-25 11:10:01'),
(27, 4, NULL, NULL, 899.00, 0.00, NULL, 'pending', 'COD', NULL, NULL, NULL, '2025-09-25 11:10:10', '2025-09-25 11:10:10'),
(28, 1, NULL, NULL, 799.00, 0.00, NULL, 'pending', 'GCash', NULL, NULL, NULL, '2025-09-25 21:57:09', '2025-09-25 21:57:09'),
(29, 1, NULL, NULL, 799.00, 0.00, NULL, 'pending', 'GCash', NULL, NULL, NULL, '2025-09-25 21:59:04', '2025-09-25 21:59:04'),
(30, 1, NULL, NULL, 799.00, 0.00, NULL, 'pending', 'GCash', NULL, NULL, NULL, '2025-09-25 22:01:16', '2025-09-25 22:01:16'),
(31, 1, NULL, NULL, 399.00, 0.00, NULL, 'pending', 'GCash', NULL, NULL, NULL, '2025-09-25 22:20:30', '2025-09-25 22:20:30'),
(32, 1, NULL, NULL, 299.00, 0.00, NULL, 'pending', 'GCash', NULL, NULL, NULL, '2025-09-25 22:21:11', '2025-09-25 22:21:11'),
(33, 1, NULL, NULL, 899.00, 0.00, NULL, 'pending', 'GCash', NULL, NULL, NULL, '2025-09-25 22:23:45', '2025-09-25 22:23:45'),
(34, 1, NULL, NULL, 899.00, 0.00, NULL, 'pending', 'GCash', NULL, NULL, NULL, '2025-09-25 22:25:53', '2025-09-25 22:25:53'),
(35, 1, NULL, NULL, 899.00, 0.00, NULL, 'pending', 'GCash', NULL, NULL, NULL, '2025-09-25 22:26:47', '2025-09-25 22:26:47'),
(36, 1, NULL, NULL, 899.00, 0.00, NULL, 'pending', 'Card', NULL, NULL, NULL, '2025-09-25 22:27:20', '2025-09-25 22:27:20'),
(37, 1, NULL, NULL, 899.00, 0.00, NULL, 'pending', 'GCash', NULL, NULL, NULL, '2025-09-25 22:28:44', '2025-09-25 22:28:44'),
(38, 1, NULL, NULL, 399.00, 0.00, NULL, 'pending', 'COD', NULL, NULL, NULL, '2025-09-25 22:50:07', '2025-09-25 22:50:07'),
(39, 1, NULL, NULL, 299.00, 0.00, NULL, 'pending', 'GCash', NULL, NULL, NULL, '2025-09-25 22:50:14', '2025-09-25 22:50:14'),
(40, 1, NULL, NULL, 699.00, 0.00, NULL, 'pending', 'GCash', NULL, NULL, NULL, '2025-09-25 22:51:59', '2025-09-25 22:51:59');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 899.00, '2025-09-08 09:20:45', '2025-09-08 09:20:45'),
(2, 2, 4, 1, 899.00, '2025-09-08 09:21:38', '2025-09-08 09:21:38'),
(3, 3, 2, 1, 999.00, '2025-09-08 09:22:01', '2025-09-08 09:22:01'),
(4, 4, 1, 1, 799.00, '2025-09-08 09:37:56', '2025-09-08 09:37:56'),
(5, 5, 12, 1, 1299.00, '2025-09-08 09:38:03', '2025-09-08 09:38:03'),
(6, 6, 45, 1, 699.00, '2025-09-08 09:38:09', '2025-09-08 09:38:09'),
(7, 7, 34, 1, 499.00, '2025-09-08 09:38:20', '2025-09-08 09:38:20'),
(8, 8, 1, 1, 799.00, '2025-09-08 10:26:23', '2025-09-08 10:26:23'),
(9, 9, 4, 1, 899.00, '2025-09-08 10:38:05', '2025-09-08 10:38:05'),
(10, 9, 11, 1, 499.00, '2025-09-08 10:38:05', '2025-09-08 10:38:05'),
(11, 9, 9, 1, 2699.00, '2025-09-08 10:38:05', '2025-09-08 10:38:05'),
(12, 10, 45, 1, 699.00, '2025-09-08 10:46:11', '2025-09-08 10:46:11'),
(13, 11, 4, 1, 899.00, '2025-09-09 06:05:35', '2025-09-09 06:05:35'),
(14, 11, 11, 1, 499.00, '2025-09-09 06:05:35', '2025-09-09 06:05:35'),
(15, 11, 9, 1, 2699.00, '2025-09-09 06:05:35', '2025-09-09 06:05:35'),
(16, 12, 4, 1, 899.00, '2025-09-09 06:12:07', '2025-09-09 06:12:07'),
(17, 12, 11, 1, 499.00, '2025-09-09 06:12:07', '2025-09-09 06:12:07'),
(18, 12, 9, 1, 2699.00, '2025-09-09 06:12:07', '2025-09-09 06:12:07'),
(19, 13, 1, 1, 799.00, '2025-09-09 07:11:26', '2025-09-09 07:11:26'),
(20, 13, 2, 1, 999.00, '2025-09-09 07:11:26', '2025-09-09 07:11:26'),
(21, 13, 3, 1, 1499.00, '2025-09-09 07:11:26', '2025-09-09 07:11:26'),
(22, 14, 4, 1, 899.00, '2025-09-19 02:20:26', '2025-09-19 02:20:26'),
(23, 14, 27, 10, 249.00, '2025-09-19 02:20:26', '2025-09-19 02:20:26'),
(24, 15, 16, 1, 799.00, '2025-09-25 08:58:14', '2025-09-25 08:58:14'),
(25, 16, 4, 1, 899.00, '2025-09-25 09:22:56', '2025-09-25 09:22:56'),
(26, 17, 2, 1, 999.00, '2025-09-25 09:41:49', '2025-09-25 09:41:49'),
(27, 18, 2, 1, 999.00, '2025-09-25 09:43:35', '2025-09-25 09:43:35'),
(28, 19, 3, 1, 1499.00, '2025-09-25 09:50:31', '2025-09-25 09:50:31'),
(29, 20, 3, 1, 1499.00, '2025-09-25 09:55:50', '2025-09-25 09:55:50'),
(30, 21, 27, 1, 249.00, '2025-09-25 10:03:51', '2025-09-25 10:03:51'),
(31, 22, 30, 1, 699.00, '2025-09-25 10:06:32', '2025-09-25 10:06:32'),
(32, 23, 28, 2, 199.00, '2025-09-25 10:06:46', '2025-09-25 10:06:46'),
(33, 24, 24, 1, 399.00, '2025-09-25 10:26:41', '2025-09-25 10:26:41'),
(34, 25, 28, 1, 199.00, '2025-09-25 10:31:06', '2025-09-25 10:31:06'),
(35, 26, 4, 1, 899.00, '2025-09-25 11:10:00', '2025-09-25 11:10:00'),
(36, 27, 4, 1, 899.00, '2025-09-25 11:10:10', '2025-09-25 11:10:10'),
(37, 28, 16, 1, 799.00, '2025-09-25 21:57:09', '2025-09-25 21:57:09'),
(38, 29, 16, 1, 799.00, '2025-09-25 21:59:04', '2025-09-25 21:59:04'),
(39, 30, 16, 1, 799.00, '2025-09-25 22:01:16', '2025-09-25 22:01:16'),
(40, 31, 24, 1, 399.00, '2025-09-25 22:20:30', '2025-09-25 22:20:30'),
(41, 32, 26, 1, 299.00, '2025-09-25 22:21:11', '2025-09-25 22:21:11'),
(42, 33, 4, 1, 899.00, '2025-09-25 22:23:45', '2025-09-25 22:23:45'),
(43, 34, 4, 1, 899.00, '2025-09-25 22:25:53', '2025-09-25 22:25:53'),
(44, 35, 4, 1, 899.00, '2025-09-25 22:26:47', '2025-09-25 22:26:47'),
(45, 36, 4, 1, 899.00, '2025-09-25 22:27:20', '2025-09-25 22:27:20'),
(46, 37, 4, 1, 899.00, '2025-09-25 22:28:44', '2025-09-25 22:28:44'),
(47, 38, 25, 1, 399.00, '2025-09-25 22:50:07', '2025-09-25 22:50:07'),
(48, 39, 26, 1, 299.00, '2025-09-25 22:50:14', '2025-09-25 22:50:14'),
(49, 40, 30, 1, 699.00, '2025-09-25 22:51:59', '2025-09-25 22:51:59');

-- --------------------------------------------------------

--
-- Table structure for table `order_status_history`
--

CREATE TABLE `order_status_history` (
  `history_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `restock_level` int(11) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `stock_quantity`, `restock_level`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Non-Stick Frying Pan – 28cm', 'Durable non-stick frying pan, 28cm size. edited', 799.00, 500, 10, 4, '2025-09-08 16:59:40', '2025-09-24 12:21:09'),
(2, 'Stainless Steel Pot with Lid – 2L', 'Stainless steel pot with glass lid, 2 liters.', 999.00, 40, 10, 4, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(3, 'Cast Iron Frying Pan – 10 inch', 'Heavy-duty 10-inch cast iron frying pan.', 1499.00, 25, 5, 4, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(4, 'Ceramic-Coated Cooking Pan', 'Non-toxic ceramic-coated cooking pan.', 899.00, 30, 5, 4, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(5, 'Large Aluminum Cooking Pot – 5L', 'Large capacity aluminum cooking pot, 5 liters.', 1299.00, 20, 5, 4, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(6, '5-Piece Non-Stick Cookware Set', 'Complete 5-piece non-stick cookware set.', 2499.00, 15, 5, 5, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(7, '7-Piece Stainless Steel Pot Set', 'Premium stainless steel 7-piece pot set.', 2999.00, 12, 3, 5, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(8, 'Induction-Compatible Cookware Set', 'Cookware set compatible with induction stoves.', 3499.00, 10, 3, 5, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(9, '4-Piece Granite Pan Set', 'Granite-coated 4-piece pan set.', 2699.00, 18, 5, 5, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(10, 'Basic Cooking Starter Set', 'Essential starter cookware set.', 1999.00, 20, 5, 5, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(11, 'Tamago Egg Pan (Japanese Style)', 'Rectangular pan for tamago omelets.', 499.00, 35, 10, 6, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(12, 'Double-Sided Grill Pan', 'Non-stick double-sided grill pan.', 1299.00, 22, 5, 6, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(13, 'Clay Pot for Traditional Dishes', 'Clay pot for slow-cooked traditional dishes.', 699.00, 28, 8, 6, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(14, 'Mini Pancake Pan – 7 Circles', 'Mini pancake pan with 7 molds.', 899.00, 25, 5, 6, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(15, 'Stainless Steel Steamer Pot', 'Multi-layer stainless steel steamer pot.', 1599.00, 18, 5, 6, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(16, 'Chef’s Knife – 8 inch', 'Professional 8-inch chef’s knife.', 799.00, 40, 10, 7, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(17, 'Multi-Purpose Kitchen Scissors', 'Heavy-duty multi-purpose kitchen scissors.', 399.00, 60, 15, 7, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(18, 'Heavy-Duty Meat Knife', 'Durable heavy-duty meat knife.', 899.00, 35, 10, 7, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(19, '3-Piece Knife Set with Cover', '3-piece knife set with protective covers.', 1299.00, 28, 8, 7, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(20, 'Manual Knife Sharpener – 2 Stage', 'Manual 2-stage knife sharpener.', 499.00, 50, 15, 7, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(21, '5-Piece Silicone Spatula Set', 'Flexible silicone spatula set, 5 pieces.', 699.00, 45, 10, 8, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(22, 'Wooden Cooking Spoon Set', 'Classic wooden cooking spoon set.', 499.00, 50, 10, 8, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(23, 'Stainless Steel Soup Ladle', 'Durable stainless steel soup ladle.', 299.00, 55, 12, 8, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(24, '12-Inch Food Tongs with Silicone Tips', 'Food tongs with silicone tips, 12 inches.', 399.00, 48, 12, 8, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(25, 'Whisk and Turner Set', 'Kitchen whisk and turner utensil set.', 399.00, 45, 10, 8, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(26, 'Manual Garlic Crusher', 'Compact manual garlic crusher.', 299.00, 60, 15, 9, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(27, '6-Piece Measuring Spoon Set', 'Measuring spoon set with 6 sizes.', 249.00, 70, 15, 9, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(28, 'Vegetable Peeler', 'Sharp and durable vegetable peeler.', 199.00, 65, 15, 9, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(29, 'Grater with Container', 'Kitchen grater with storage container.', 349.00, 55, 12, 9, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(30, 'Digital Kitchen Scale – up to 5kg', 'Digital kitchen scale, capacity 5kg.', 699.00, 40, 8, 9, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(31, 'Ceramic Dinner Plate – 10 inch', 'Elegant 10-inch ceramic dinner plate.', 349.00, 50, 15, 10, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(32, '4-Piece Plate Set', 'Durable ceramic plate set, 4 pieces.', 899.00, 35, 10, 10, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(33, 'Bamboo Fiber Bowl Set', 'Eco-friendly bamboo fiber bowl set.', 599.00, 40, 10, 10, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(34, 'Glass Salad Bowl – 1.5L', 'Clear glass salad bowl, 1.5 liters.', 499.00, 45, 12, 10, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(35, 'Rice Bowl with Local Designs', 'Rice bowl with traditional local designs.', 299.00, 60, 15, 10, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(36, 'Double-Walled Glass Mug – 350ml', 'Heat-resistant double-walled glass mug.', 399.00, 55, 15, 11, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(37, 'Stainless Steel Travel Mug – 500ml', 'Portable stainless steel travel mug, 500ml.', 599.00, 50, 12, 11, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(38, 'Ceramic Coffee Mug with Lid', 'Ceramic coffee mug with protective lid.', 449.00, 45, 12, 11, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(39, '4-Piece Reusable Bamboo Cups', 'Eco-friendly reusable bamboo cups, 4 pieces.', 699.00, 40, 10, 11, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(40, '1L Glass Pitcher with Lid', 'Glass pitcher with lid, 1 liter capacity.', 799.00, 35, 8, 11, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(41, 'Serving Tray with Handles', 'Wooden serving tray with handles.', 799.00, 30, 8, 12, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(42, 'Gravy Server with Ceramic Base', 'Gravy server with ceramic base.', 699.00, 28, 8, 12, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(43, '3-Piece Serving Spoon Set', 'Stainless steel serving spoon set, 3 pieces.', 499.00, 35, 8, 12, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(44, 'Cake Cutter and Server', 'Cake cutting and serving tool.', 399.00, 40, 8, 12, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(45, 'Wooden Serving Board', 'Multipurpose wooden serving board.', 699.00, 25, 5, 12, '2025-09-08 16:59:40', '2025-09-08 16:59:40');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `image_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_url`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 1, 'products/nonstick_frying_pan_28cm_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(2, 1, 'products/nonstick_frying_pan_28cm_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(3, 1, 'products/nonstick_frying_pan_28cm_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(4, 2, 'products/stainless_steel_pot_2l_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(5, 2, 'products/stainless_steel_pot_2l_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(6, 3, 'products/cast_iron_frying_pan_10inch_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(7, 4, 'products/ceramic_coated_pan_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(8, 4, 'products/ceramic_coated_pan_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(9, 5, 'products/large_aluminum_pot_5l_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(10, 5, 'products/large_aluminum_pot_5l_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(11, 6, 'products/5piece_non_stick_cookware_set_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(12, 6, 'products/5piece_non_stick_cookware_set_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(13, 7, 'products/7piece_stainless_steel_pot_set_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(14, 8, 'products/induction_compatible_cookware_set_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(15, 8, 'products/induction_compatible_cookware_set_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(16, 9, 'products/4piece_granite_pan_set_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(17, 9, 'products/4piece_granite_pan_set_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(18, 9, 'products/4piece_granite_pan_set_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(19, 9, 'products/4piece_granite_pan_set_4.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(20, 10, 'products/basic_cooking_starter_set_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(21, 10, 'products/basic_cooking_starter_set_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(22, 11, 'products/tamago_egg_pan_japanese_style_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(23, 11, 'products/tamago_egg_pan_japanese_style_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(24, 12, 'products/double_sided_grill_pan_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(25, 13, 'products/clay_pot_for_traditional_dishes_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(26, 13, 'products/clay_pot_for_traditional_dishes_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(27, 14, 'products/mini_pancake_pan_7circles_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(28, 14, 'products/mini_pancake_pan_7circles_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(29, 15, 'products/stainless_steel_steamer_pot_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(30, 15, 'products/stainless_steel_steamer_pot_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(31, 15, 'products/stainless_steel_steamer_pot_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(32, 16, 'products/chefs_knife_8inch_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(33, 16, 'products/chefs_knife_8inch_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(34, 16, 'products/chefs_knife_8inch_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(35, 16, 'products/chefs_knife_8inch_4.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(36, 17, 'products/multi_purpose_kitchen_scissors_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(37, 17, 'products/multi_purpose_kitchen_scissors_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(38, 17, 'products/multi_purpose_kitchen_scissors_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(39, 18, 'products/heavy_duty_meat_knife_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(40, 18, 'products/heavy_duty_meat_knife_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(41, 18, 'products/heavy_duty_meat_knife_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(42, 19, 'products/3piece_knife_set_with_cover_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(43, 19, 'products/3piece_knife_set_with_cover_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(44, 20, 'products/manual_knife_sharpener_2Stage_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(45, 20, 'products/manual_knife_sharpener_2Stage_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(46, 20, 'products/manual_knife_sharpener_2Stage_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(47, 20, 'products/manual_knife_sharpener_2Stage_4.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(48, 21, 'products/5piece_silicone_spatula_set_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(49, 21, 'products/5piece_silicone_spatula_set_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(50, 21, 'products/5piece_silicone_spatula_set_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(51, 22, 'products/wooden_cooking_spoon_set_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(52, 22, 'products/wooden_cooking_spoon_set_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(53, 23, 'products/stainless_steel_soup_ladle_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(54, 23, 'products/stainless_steel_soup_ladle_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(55, 23, 'products/stainless_steel_soup_ladle_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(56, 24, 'products/12inch_food_tongs_with_silicone_tips_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(57, 24, 'products/12inch_food_tongs_with_silicone_tips_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(58, 24, 'products/12inch_food_tongs_with_silicone_tips_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(59, 25, 'products/whisk_and_turner_set_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(60, 25, 'products/whisk_and_turner_set_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(61, 26, 'products/manual_garlic_crusher_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(62, 26, 'products/manual_garlic_crusher_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(63, 26, 'products/manual_garlic_crusher_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(64, 27, 'products/6piece_measuring_spoon_set_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(65, 27, 'products/6piece_measuring_spoon_set_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(66, 27, 'products/6piece_measuring_spoon_set_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(67, 28, 'products/vegetable_peeler_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(68, 28, 'products/vegetable_peeler_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(69, 28, 'products/vegetable_peeler_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(70, 29, 'products/grater_with_container_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(71, 29, 'products/grater_with_container_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(72, 29, 'products/grater_with_container_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(73, 30, 'products/digital_kitchen_scale_up_to_5kg_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(74, 30, 'products/digital_kitchen_scale_up_to_5kg_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(75, 30, 'products/digital_kitchen_scale_up_to_5kg_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(76, 31, 'products/ceramic_dinner_plate_10inch_1.jpg', 1, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(77, 31, 'products/ceramic_dinner_plate_10inch_2.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(78, 31, 'products/ceramic_dinner_plate_10inch_3.jpg', 0, '2025-09-08 16:59:57', '2025-09-08 16:59:57'),
(79, 32, 'products/4piece_plate_set_1.jpg', 1, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(80, 32, 'products/4piece_plate_set_2.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(81, 33, 'products/bamboo_fiber_bowl_set_1.jpg', 1, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(82, 33, 'products/bamboo_fiber_bowl_set_2.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(83, 33, 'products/bamboo_fiber_bowl_set_3.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(84, 34, 'products/glass_salad_bowl_1.5l_1.jpg', 1, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(85, 34, 'products/glass_salad_bowl_1.5l_2.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(86, 34, 'products/glass_salad_bowl_1.5l_3.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(87, 35, 'products/rice_bowl_with_local_designs_1.jpg', 1, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(88, 36, 'products/double_walled_glass_mug_350ml_1.jpg', 1, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(89, 36, 'products/double_walled_glass_mug_350ml_2.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(90, 37, 'products/stainless_steel_travel_mug_1.jpg', 1, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(91, 37, 'products/stainless_steel_travel_mug_2.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(92, 37, 'products/stainless_steel_travel_mug_3.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(93, 38, 'products/ceramic_coffee_mug_with_lid_1.jpg', 1, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(94, 39, 'products/4piece_reusable_bamboo_cups_1.jpg', 1, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(95, 39, 'products/4piece_reusable_bamboo_cups_2.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(96, 40, 'products/1lglass_pitcher_with_lid_1.jpg', 1, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(97, 40, 'products/1lglass_pitcher_with_lid_2.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(98, 41, 'products/serving_tray_with_handles_1.jpg', 1, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(99, 41, 'products/serving_tray_with_handles_2.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(100, 41, 'products/serving_tray_with_handles_3.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(101, 42, 'products/gravy_server_with_ceramic_base_1.jpg', 1, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(102, 42, 'products/gravy_server_with_ceramic_base_2.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(103, 42, 'products/gravy_server_with_ceramic_base_3.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(104, 43, 'products/3piece_serving_spoon_set_1.jpg', 1, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(105, 43, 'products/3piece_serving_spoon_set_2.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(106, 44, 'products/cake_cutter_and_server_1.jpg', 1, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(107, 44, 'products/cake_cutter_and_server_2.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(108, 44, 'products/cake_cutter_and_server_3.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(109, 45, 'products/wooden_serving_board_1.jpg', 1, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(110, 45, 'products/wooden_serving_board_2.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(111, 45, 'products/wooden_serving_board_3.jpg', 0, '2025-09-08 16:59:58', '2025-09-08 16:59:58'),
(144, 1, 'products/68d4474535fa8_Professional_Grooming.webp', 0, '2025-09-24 11:32:21', '2025-09-24 11:32:21'),
(145, 1, 'products/68d4479fe3194_SpayNeuter.jpg', 0, '2025-09-24 11:33:51', '2025-09-24 11:33:51'),
(146, 1, 'products/68d44ca420ff0_SpayNeuter.jpg', 0, '2025-09-24 11:55:16', '2025-09-24 11:55:16'),
(147, 1, 'products/68d44ca422ba3_Obedience_Training.png', 0, '2025-09-24 11:55:16', '2025-09-24 11:55:16');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 5, 'this is great', '2025-09-09 07:48:54', '2025-09-09 07:48:54'),
(2, 3, 1, 5, NULL, '2025-09-09 08:18:01', '2025-09-09 08:18:01'),
(3, 1, 1, 5, NULL, '2025-09-09 08:20:59', '2025-09-09 08:20:59'),
(4, 4, 1, 5, 'This is really nice!', '2025-09-11 08:19:40', '2025-09-11 08:19:40'),
(5, 4, 2, 5, 'This is very great! Will buy again!', '2025-09-19 02:26:03', '2025-09-19 02:26:03');

-- --------------------------------------------------------

--
-- Table structure for table `riders`
--

CREATE TABLE `riders` (
  `rider_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1wO8lCB9wI8aBvlKyrio4j2e0h2g9j9mhkrd0lMa', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:143.0) Gecko/20100101 Firefox/143.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibXhpOXdVMW9pQTJTaVA3d0VSdHRXOWkxRkRGa0tOM1V4WnJxYm45ViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9vcmRlcnMvNDAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1758869522);

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`ticket_id`, `user_id`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Sample', 'hahahahahhahaah puyat', 'open', '2025-09-09 10:39:24', '2025-09-09 10:39:24'),
(2, 1, 'sample', 'puyat again hahahahaaha', 'open', '2025-09-09 10:41:49', '2025-09-09 10:41:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `profile_picture_path` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL,
  `gender` enum('male','female','prefer_not_to_say') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `profile_picture_path`, `role`, `gender`, `date_of_birth`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'Only', 'test@only.fans', '$2y$12$w3PTRaxvKFNIWwPXC/rSw.codKOahX/dSVEwXtUugpcf0TVfOLD.a', '09123456789', NULL, 'user', 'male', '2001-09-17', '2025-09-08 09:08:20', '2025-09-08 09:08:20'),
(2, 'Alden', 'Obillo', 'aldenobillo@gmail.com', '$2y$12$FdqMw.PjOZIA1cFPMQjsV.WGncbYMQPmSyLajFlnyCiu0oJciVQ2O', '09123456789', NULL, 'user', 'male', '1995-01-03', '2025-09-19 02:15:04', '2025-09-19 02:15:04'),
(3, 'Ralph', 'Gacusan', 'gacusan.admin@timplato.shop', '$2y$12$o535E8FX6qKn82VAmjLxmeZdc2ZOe7UNfXKY0yFz8y315vaT8nuBK', '09123456789', NULL, 'admin', 'male', '2001-01-09', '2025-09-24 12:16:00', '2025-09-24 12:16:00'),
(4, 'RALPH JAYRELL', 'GACUSAN', 'qrjegacusan@tip.edu.ph', '$2y$12$c2H8AvE7vIko1SuRp39KvuQh403Nb/5ZPk89sLYlRSyx1ANmMPBMG', '09123456789', NULL, 'user', 'male', NULL, '2025-09-25 08:25:43', '2025-09-25 10:26:23'),
(5, 'Ralph', 'Gacusan', 'gacusanralph@gmail.com', '$2y$12$6F6DoSCqlI8/KnfhLaM3EeexCPJuX0fds53JTpK.6bdFJs9KCt2F6', '09123456789', NULL, 'user', 'male', NULL, '2025-09-25 08:32:13', '2025-09-25 09:21:33');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `address_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`address_id`, `user_id`, `label`, `address`, `city`, `state`, `zip_code`, `country`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 2, 'Home', 'East Kamias Street', 'Quezon City', 'Metro Manila', '2222', 'Philippines', 1, '2025-09-19 02:19:19', '2025-09-19 02:19:19'),
(2, 5, 'Home', '432 Sitio 4', 'Quezon City', 'Metro Manila', '2013', 'Philippines', 0, '2025-09-25 09:18:39', '2025-09-25 09:22:30'),
(3, 4, 'Home', '321 Pasong Tamo East Avenue', 'Quezon City', 'Metro Manila', '2013', 'Philippines', 1, '2025-09-25 10:26:13', '2025-09-25 10:26:13'),
(4, 1, 'Home', '123 Happy Street', 'Quezon City', 'Metro Manila', '2013', 'Philippines', 1, '2025-09-25 21:56:54', '2025-09-25 21:56:59');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `wishlist_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_session_id_index` (`session_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`courier_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `notifications_order_id_foreign` (`order_id`),
  ADD KEY `notifications_product_id_foreign` (`product_id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_rider_id_foreign` (`rider_id`),
  ADD KEY `orders_courier_id_foreign` (`courier_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `order_status_history_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `riders`
--
ALTER TABLE `riders`
  ADD PRIMARY KEY (`rider_id`),
  ADD UNIQUE KEY `riders_phone_unique` (`phone`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `support_tickets_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `couriers`
--
ALTER TABLE `couriers`
  MODIFY `courier_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `history_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `riders`
--
ALTER TABLE `riders`
  MODIFY `rider_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `ticket_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `address_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `wishlist_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_courier_id_foreign` FOREIGN KEY (`courier_id`) REFERENCES `couriers` (`courier_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_rider_id_foreign` FOREIGN KEY (`rider_id`) REFERENCES `riders` (`rider_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD CONSTRAINT `order_status_history_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
