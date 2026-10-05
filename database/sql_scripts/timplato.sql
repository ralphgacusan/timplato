-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2026 at 05:19 AM
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
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `target_type` varchar(255) DEFAULT NULL,
  `target_id` bigint(20) UNSIGNED DEFAULT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `admin_id`, `action`, `target_type`, `target_id`, `details`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 3, 'logout', 'Admin', 3, 'Admin logged out', '127.0.0.1', '2025-10-27 16:32:10', '2025-10-27 16:32:10'),
(2, 3, 'login', 'Admin', 3, 'Admin logged in', '127.0.0.1', '2025-10-27 16:32:18', '2025-10-27 16:32:18'),
(3, 3, 'login', 'Admin', 3, 'Admin logged in', '127.0.0.1', '2025-11-07 08:55:50', '2025-11-07 08:55:50'),
(4, 3, 'logout', 'Admin', 3, 'Admin logged out', '127.0.0.1', '2025-11-07 09:10:22', '2025-11-07 09:10:22'),
(5, 3, 'login', 'Admin', 3, 'Admin logged in', '127.0.0.1', '2025-11-07 09:14:40', '2025-11-07 09:14:40'),
(6, 3, 'Created Product', 'Product', 80, 'Added new product: Sample', '127.0.0.1', '2025-11-07 09:15:45', '2025-11-07 09:15:45'),
(7, 3, 'Updated Product', 'Product', 80, 'Updated product: Sample', '127.0.0.1', '2025-11-07 09:16:10', '2025-11-07 09:16:10'),
(8, 3, 'Deleted Product', 'Product', 80, 'Deleted product: Sample', '127.0.0.1', '2025-11-07 09:16:25', '2025-11-07 09:16:25'),
(9, 3, 'login', 'Admin', 3, 'Admin logged in', '127.0.0.1', '2025-11-12 19:46:00', '2025-11-12 19:46:00'),
(10, 3, 'Created Product', 'Product', 81, 'Added new product: sample', '127.0.0.1', '2025-11-12 19:48:32', '2025-11-12 19:48:32'),
(11, 3, 'Updated Product', 'Product', 81, 'Updated product: sample', '127.0.0.1', '2025-11-12 20:04:52', '2025-11-12 20:04:52'),
(12, 3, 'Updated Product', 'Product', 1, 'Updated product: Non-Stick Frying Pan – 28cm', '127.0.0.1', '2025-11-12 20:10:36', '2025-11-12 20:10:36'),
(13, 3, 'Updated Product', 'Product', 1, 'Updated product: Non-Stick Frying Pan – 28cm', '127.0.0.1', '2025-11-12 20:10:43', '2025-11-12 20:10:43'),
(14, 3, 'Updated Product', 'Product', 1, 'Updated product: Non-Stick Frying Pan – 28cm', '127.0.0.1', '2025-11-12 20:10:47', '2025-11-12 20:10:47'),
(15, 3, 'Updated Product', 'Product', 81, 'Updated product: sample', '127.0.0.1', '2025-11-12 20:10:56', '2025-11-12 20:10:56'),
(16, 3, 'Created Product', 'Product', 82, 'Added new product: SAMLE INACTIVE', '127.0.0.1', '2025-11-12 20:11:22', '2025-11-12 20:11:22'),
(17, 3, 'Updated Product', 'Product', 82, 'Updated product: SAMLE INACTIVE', '127.0.0.1', '2025-11-12 20:14:09', '2025-11-12 20:14:09'),
(18, 3, 'Updated Product', 'Product', 1, 'Updated product: Non-Stick Frying Pan – 28cm', '127.0.0.1', '2025-11-12 20:14:21', '2025-11-12 20:14:21'),
(19, 3, 'Updated Product', 'Product', 1, 'Updated product: Non-Stick Frying Pan – 28cm', '127.0.0.1', '2025-11-12 20:16:26', '2025-11-12 20:16:26'),
(20, 3, 'Updated Product', 'Product', 81, 'Updated product: sample', '127.0.0.1', '2025-11-12 20:19:25', '2025-11-12 20:19:25'),
(21, 3, 'logout', 'Admin', 3, 'Admin logged out', '127.0.0.1', '2025-11-12 23:45:50', '2025-11-12 23:45:50'),
(22, 3, 'login', 'Admin', 3, 'Admin logged in', '127.0.0.1', '2025-11-13 00:02:14', '2025-11-13 00:02:14'),
(23, 3, 'login', 'Admin', 3, 'Admin logged in', '127.0.0.1', '2025-11-13 00:14:42', '2025-11-13 00:14:42'),
(24, 3, 'logout', 'Admin', 3, 'Admin logged out', '127.0.0.1', '2025-11-13 00:15:56', '2025-11-13 00:15:56'),
(25, 3, 'login', 'Admin', 3, 'Admin logged in', '127.0.0.1', '2025-11-13 00:16:16', '2025-11-13 00:16:16'),
(26, 3, 'Updated Product', 'Product', 1, 'Updated product: Non-Stick Frying Pan – 28cm', '127.0.0.1', '2025-11-13 00:18:15', '2025-11-13 00:18:15'),
(27, 3, 'logout', 'Admin', 3, 'Admin logged out', '127.0.0.1', '2025-11-13 00:20:01', '2025-11-13 00:20:01'),
(28, 3, 'Add Stock', 'Product', 44, 'Added 112 units for Cake Cutter and Server', '127.0.0.1', '2025-11-13 00:21:42', '2025-11-13 00:21:42'),
(29, 3, 'Deduct Stock', 'Product', 82, 'Deducted 110 units for SAMLE INACTIVE', '127.0.0.1', '2025-11-13 00:22:00', '2025-11-13 00:22:00'),
(30, 3, 'Add Stock', 'Product', 81, 'Added 20 units for sample', '127.0.0.1', '2025-11-13 00:22:11', '2025-11-13 00:22:11'),
(31, 3, 'Deduct Stock', 'Product', 41, 'Deducted 29 units for Serving Tray with Handles', '127.0.0.1', '2025-11-13 00:22:27', '2025-11-13 00:22:27'),
(32, 3, 'login', 'Admin', 3, 'Admin logged in', '127.0.0.1', '2025-11-14 21:01:08', '2025-11-14 21:01:08'),
(33, 3, 'logout', 'Admin', 3, 'Admin logged out', '127.0.0.1', '2025-11-14 21:06:05', '2025-11-14 21:06:05'),
(34, 3, 'login', 'Admin', 3, 'Admin logged in', '127.0.0.1', '2025-11-14 21:12:12', '2025-11-14 21:12:12'),
(35, 3, 'logout', 'Admin', 3, 'Admin logged out', '127.0.0.1', '2025-11-14 21:12:27', '2025-11-14 21:12:27'),
(36, 3, 'login', 'Admin', 3, 'Admin logged in', '127.0.0.1', '2025-11-14 22:50:37', '2025-11-14 22:50:37'),
(37, 3, 'logout', 'Admin', 3, 'Admin logged out', '127.0.0.1', '2025-11-15 00:24:32', '2025-11-15 00:24:32'),
(38, 3, 'login', 'Admin', 3, 'Admin logged in', '127.0.0.1', '2025-11-15 02:39:48', '2025-11-15 02:39:48'),
(39, 3, 'logout', 'Admin', 3, 'Admin logged out', '127.0.0.1', '2025-11-15 02:43:10', '2025-11-15 02:43:10');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `page_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `section` varchar(255) NOT NULL DEFAULT 'main',
  `order` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `slug`, `page_id`, `title`, `image`, `link`, `section`, `order`, `active`, `created_at`, `updated_at`) VALUES
(6, 'home', NULL, 'Sample Promo', 'banners/1761509650_timplatoLandingBanner.png', NULL, 'main', 0, 1, '2025-10-26 20:14:10', '2025-10-26 20:14:10'),
(7, 'home', NULL, 'Sample Again', 'banners/1761509667_loginBanner.png', NULL, 'main', 0, 1, '2025-10-26 20:14:27', '2025-10-26 20:14:27'),
(9, 'home', NULL, 'sample 3', 'banners/1761509692_timplatoLoginBanner.png', NULL, 'main', 0, 1, '2025-10-26 20:14:52', '2025-10-26 20:14:52');

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
(6, NULL, 'WiXsWqBnf0OsU647n7jxqNgU3gkCRTugUJbZBCSt', '2025-09-24 12:22:28', '2025-09-24 12:22:28'),
(8, 4, NULL, '2025-09-25 11:09:55', '2025-09-25 11:09:55'),
(9, NULL, 'NIo5MKP3o0rxKo9MufFgiBootoX3vp0FcxMfsNul', '2025-09-28 05:06:43', '2025-09-28 05:06:43'),
(10, NULL, 'te4z3GrOEONPmZndfFp1pkDxb1FbkDmveZLITzIl', '2025-09-29 09:20:47', '2025-09-29 09:20:47'),
(11, NULL, '75lelzzmWnoGezldQYNSbX4FAl1sJztKb9jMAjOv', '2025-09-29 18:24:12', '2025-09-29 18:24:12'),
(12, NULL, '1PWKDxFmfXlncfQV0U2fU6pAZ5iqNqIjYz9gKuZD', '2025-10-01 03:50:37', '2025-10-01 03:50:37'),
(13, 8, NULL, '2025-10-01 03:51:55', '2025-10-01 03:51:55'),
(14, 10, NULL, '2025-10-01 08:47:30', '2025-10-01 08:47:30'),
(15, 11, NULL, '2025-10-01 09:22:07', '2025-10-01 09:22:07'),
(16, 12, NULL, '2025-10-01 09:23:17', '2025-10-01 09:23:17'),
(17, 13, NULL, '2025-10-01 14:22:17', '2025-10-01 14:22:17'),
(18, NULL, 'ouHFo372zTq2fSXARS9aPBcTKnkVCC0En2FSH2qi', '2025-10-03 06:15:54', '2025-10-03 06:15:54'),
(19, 14, NULL, '2025-10-03 06:36:15', '2025-10-03 06:36:15'),
(20, NULL, 'Tmwa44cUVCmw2XBtjoB8J52Jljq8e6IsdmH1McAl', '2025-10-03 17:28:26', '2025-10-03 17:28:26'),
(21, 16, NULL, '2025-10-03 18:09:20', '2025-10-03 18:09:20'),
(22, NULL, 'YG4HSasYEMLbiLbPuiZSAxvXlsGAPfm4qlGJJDC7', '2025-10-04 18:09:23', '2025-10-04 18:09:23'),
(23, NULL, 'o9N2Ot6HDgVId7vjFLKyHJopmhyLLHFTJ016cJFG', '2025-10-07 02:06:31', '2025-10-07 02:06:31'),
(24, NULL, 'mxXnhmRR1bBArw66naUMnXU2dgC6vrSCR8XCtvrM', '2025-10-09 05:01:03', '2025-10-09 05:01:03'),
(25, NULL, 'nFT48ZIy0MOpI9Kyh9sLbOnhcS2V5qNZTfYCd5GX', '2025-10-09 07:14:19', '2025-10-09 07:14:19'),
(26, NULL, 'GlPSiXQDHA7Y5wP8pqEsxD5SbXLI75Y3eClciWyM', '2025-10-10 16:53:41', '2025-10-10 16:53:41'),
(27, NULL, 'RCNN5tWgEp5hUtphIQQ8QjO3VT6At5cvX0Rseu2W', '2025-10-11 04:31:17', '2025-10-11 04:31:17'),
(28, NULL, 'h8EfylrcoYpBNX0kwhEyPVyNvvvYyHHajZL5KTeO', '2025-10-11 08:45:02', '2025-10-11 08:45:02'),
(29, NULL, 'tMMx8wmnR5JnMcG0apeoOPrrEEaKxBoREvRUlHyt', '2025-10-13 12:03:13', '2025-10-13 12:03:13'),
(30, NULL, 'd1PWcy2zGsIWvBg33o03NaRs4G3Eko3LE9ZcHUZl', '2025-10-14 11:37:25', '2025-10-14 11:37:25'),
(32, NULL, 'o7jMjm08kdaqQM0jStV2VkSNttyBgark6iBtI83C', '2025-10-15 15:23:58', '2025-10-15 15:23:58'),
(33, NULL, 'fME93qZWuDxSaQKFpl9NF1fkgpjmkNsEvXxCmWHt', '2025-10-17 06:17:59', '2025-10-17 06:17:59'),
(34, 3, NULL, '2025-10-26 20:07:52', '2025-10-26 20:07:52'),
(35, NULL, 'tXNnchCAU5JJOzE8DeTmvyLiIU4gZ3MfMNCscR9Y', '2025-11-12 19:15:03', '2025-11-12 19:15:03'),
(36, 26, NULL, '2025-11-12 23:56:25', '2025-11-12 23:56:25');

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
(11, 4, 1, 1, '2025-09-19 02:11:15', '2025-09-19 02:11:15'),
(14, 6, 3, 1, '2025-09-24 12:22:29', '2025-09-24 12:22:29'),
(15, 8, 31, 1, '2025-09-27 22:33:53', '2025-09-27 22:33:53'),
(16, 12, 4, 1, '2025-10-01 03:51:07', '2025-10-01 03:51:07'),
(19, 16, 17, 1, '2025-10-01 09:23:27', '2025-10-01 09:23:27'),
(20, 16, 41, 1, '2025-10-01 09:23:40', '2025-10-01 09:23:40'),
(21, 17, 8, 1, '2025-10-01 14:22:17', '2025-10-01 14:22:17'),
(22, 18, 2, 1, '2025-10-03 06:15:54', '2025-10-03 06:15:54'),
(23, 18, 4, 1, '2025-10-03 06:15:57', '2025-10-03 06:15:57'),
(37, 22, 45, 30, '2025-10-04 18:14:27', '2025-10-04 18:14:27'),
(38, 21, 19, 1, '2025-10-10 16:38:48', '2025-10-10 16:38:48'),
(39, 21, 4, 2, '2025-10-10 16:39:23', '2025-10-10 16:39:35'),
(49, 32, 2, 29, '2025-10-15 15:23:58', '2025-10-15 15:53:21'),
(53, 33, 45, 1, '2025-10-17 06:17:59', '2025-10-17 06:17:59');

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
-- Table structure for table `delivery_methods`
--

CREATE TABLE `delivery_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `fee` decimal(8,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `delivery_methods`
--

INSERT INTO `delivery_methods` (`id`, `name`, `fee`, `description`, `created_at`, `updated_at`) VALUES
(3, 'Premium Delivery', 100.00, 'Delivered in 2 days', '2025-10-25 19:38:14', '2025-10-25 19:38:14'),
(4, 'Named Day Delivery', 150.00, 'Fit for your scheduled delivery', '2025-10-25 19:38:31', '2025-10-25 19:38:31'),
(5, 'Standard Delivery', 50.00, '2-5 working days delivery', '2025-10-25 19:38:45', '2025-10-25 19:38:45');

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
(23, '2025_09_25_174254_add_paymongo_columns_to_orders_table', 5),
(24, '2025_09_27_205302_create_stock_transactions_table', 6),
(25, '2025_10_24_000459_create_payments_table', 7),
(26, '2025_10_24_132126_create_settings_table', 8),
(27, '2025_10_24_141057_create_notification_settings_table', 9),
(28, '2025_10_24_143606_create_notification_settings_table', 10),
(29, '2025_10_26_022121_create_delivery_methods_table', 11),
(30, '2025_10_26_022145_create_payment_methods_table', 11),
(31, '2025_10_26_022212_create_vouchers_table', 11),
(32, '2025_10_26_070805_create_pages_table', 12),
(33, '2025_10_26_070848_create_team_members_table', 12),
(34, '2025_10_26_070853_create_banners_table', 12),
(35, '2025_10_26_234727_create_pages_table', 13),
(36, '2025_10_26_235137_create_banners_table', 14),
(37, '2025_10_27_182006_create_notification_settings_table', 15),
(38, '2025_10_28_001801_create_admin_logs_table', 16);

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
(3, 1, 'Order Returned', 'Your return request for order <b>#6</b> has been processed.', 0, '2025-09-10 05:27:13', '2025-09-10 05:27:13', 6, NULL),
(7, 1, 'Order Status Updated', 'Your order #91 status has been updated to Confirmed.', 0, '2025-10-15 10:42:39', '2025-10-15 10:42:39', 91, NULL),
(17, 22, 'Order Placed Successfully', 'Your order <b>#95</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-22 18:24:17', '2025-10-22 18:24:17', 95, NULL),
(18, 1, 'Order Placed Successfully', 'Your order <b>#96</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-23 16:20:02', '2025-10-23 16:20:02', 96, NULL),
(19, 1, 'Order Confirmed', 'Your order <b>#96</b> has been confirmed by the seller.', 0, '2025-10-23 16:27:16', '2025-10-23 16:27:16', 96, NULL),
(20, 1, 'Order Delivered', 'Your order <b>#96</b> has been delivered.', 0, '2025-10-23 16:27:36', '2025-10-23 16:27:36', 96, NULL),
(21, 1, 'Order Placed Successfully', 'Your order <b>#99</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-23 16:29:32', '2025-10-23 16:29:32', 99, NULL),
(22, 1, 'Order Delivered', 'Your order <b>#99</b> has been delivered.', 0, '2025-10-23 16:30:39', '2025-10-23 16:30:39', 99, NULL),
(23, 1, 'Order Placed Successfully', 'Your order <b>#101</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-24 10:17:06', '2025-10-24 10:17:06', 101, NULL),
(24, 1, 'Order Placed Successfully', 'Your order <b>#102</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-25 14:35:38', '2025-10-25 14:35:38', 102, NULL),
(25, 1, 'Order Placed Successfully', 'Your order <b>#103</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-25 15:59:40', '2025-10-25 15:59:40', 103, NULL),
(26, 1, 'Order Placed Successfully', 'Your order <b>#104</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-25 16:06:37', '2025-10-25 16:06:37', 104, NULL),
(27, 1, 'Order Placed Successfully', 'Your order <b>#107</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-25 16:10:17', '2025-10-25 16:10:17', 107, NULL),
(28, 1, 'Order Placed Successfully', 'Your order <b>#109</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-25 16:11:36', '2025-10-25 16:11:36', 109, NULL),
(29, 1, 'Order Confirmed', 'Your order <b>#109</b> has been confirmed by the seller.', 0, '2025-10-25 16:13:20', '2025-10-25 16:13:20', 109, NULL),
(30, 1, 'Order Processing', 'Your order <b>#109</b> is now being processed.', 0, '2025-10-25 16:13:24', '2025-10-25 16:13:24', 109, NULL),
(31, 1, 'Order Shipped', 'Your order <b>#109</b> has been shipped and is on the way.', 0, '2025-10-25 16:13:28', '2025-10-25 16:13:28', 109, NULL),
(32, 1, 'Order Delivered', 'Your order <b>#109</b> has been delivered.', 0, '2025-10-25 16:13:30', '2025-10-25 16:13:30', 109, NULL),
(33, 1, 'Order Placed Successfully', 'Your order <b>#111</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-25 19:56:05', '2025-10-25 19:56:05', 111, NULL),
(34, 1, 'Order Placed Successfully', 'Your order <b>#112</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-25 20:01:43', '2025-10-25 20:01:43', 112, NULL),
(35, 1, 'Order Placed Successfully', 'Your order <b>#113</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-25 20:02:01', '2025-10-25 20:02:01', 113, NULL),
(37, 1, 'Order Placed Successfully', 'Your order <b>#115</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-25 20:14:42', '2025-10-25 20:14:42', 115, NULL),
(38, 1, 'Order Placed Successfully', 'Your order <b>#116</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-25 20:15:09', '2025-10-25 20:15:09', 116, NULL),
(39, 1, 'Order Placed Successfully', 'Your order <b>#119</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-25 20:26:07', '2025-10-25 20:26:07', 119, NULL),
(40, 1, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(41, 3, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(42, 4, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(43, 6, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(44, 7, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(45, 8, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(46, 9, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(47, 10, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(48, 11, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(49, 12, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(50, 13, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(51, 14, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(52, 15, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(53, 16, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(54, 22, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(55, 23, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(56, 24, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(57, 25, 'Sample Only', 'This is a sample only', 0, '2025-10-27 10:29:10', '2025-10-27 10:29:10', NULL, NULL),
(58, 1, 'Order Placed Successfully', 'Your order <b>#120</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-27 10:47:46', '2025-10-27 10:47:46', 120, NULL),
(59, 1, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(60, 3, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(61, 4, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(62, 6, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(63, 7, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(64, 8, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(65, 9, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(66, 10, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(67, 11, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(68, 12, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(69, 13, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(70, 14, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(71, 15, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(72, 16, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(73, 22, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(74, 23, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(75, 24, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(76, 25, 'New Voucher Available!', 'A new voucher <b>samopke</b> has been created. Check it out in your account!', 0, '2025-10-27 11:11:06', '2025-10-27 11:11:06', NULL, NULL),
(77, 1, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(78, 3, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(79, 4, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(80, 6, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(81, 7, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(82, 8, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(83, 9, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(84, 10, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(85, 11, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(86, 12, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(87, 13, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(88, 14, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(89, 15, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(90, 16, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(91, 22, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(92, 23, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(93, 24, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(94, 25, 'New Voucher Available!', 'New voucher <b>SAMPLE100</b> available: ₱100.00 off. ₱100 off total purchase', 0, '2025-10-27 11:23:32', '2025-10-27 11:23:32', NULL, NULL),
(95, 1, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(96, 3, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(97, 4, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(98, 6, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(99, 7, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(100, 8, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(101, 9, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(102, 10, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(103, 11, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(104, 12, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(105, 13, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(106, 14, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(107, 15, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(108, 16, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(109, 22, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(110, 23, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(111, 24, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(112, 25, 'New Voucher Available!', 'Voucher <b>SAMPLE100</b>: ₱100.00 off - ₱100 off total purchase', 0, '2025-10-27 11:24:56', '2025-10-27 11:24:56', NULL, NULL),
(113, 1, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:28', '2025-10-27 11:28:28', NULL, NULL),
(114, 3, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:28', '2025-10-27 11:28:28', NULL, NULL),
(115, 4, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:28', '2025-10-27 11:28:28', NULL, NULL),
(116, 6, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:28', '2025-10-27 11:28:28', NULL, NULL),
(117, 7, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:29', '2025-10-27 11:28:29', NULL, NULL),
(118, 8, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:29', '2025-10-27 11:28:29', NULL, NULL),
(119, 9, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:29', '2025-10-27 11:28:29', NULL, NULL),
(120, 10, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:29', '2025-10-27 11:28:29', NULL, NULL),
(121, 11, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:29', '2025-10-27 11:28:29', NULL, NULL),
(122, 12, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:29', '2025-10-27 11:28:29', NULL, NULL),
(123, 13, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:29', '2025-10-27 11:28:29', NULL, NULL),
(124, 14, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:29', '2025-10-27 11:28:29', NULL, NULL),
(125, 15, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:29', '2025-10-27 11:28:29', NULL, NULL),
(126, 16, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:29', '2025-10-27 11:28:29', NULL, NULL),
(127, 22, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:29', '2025-10-27 11:28:29', NULL, NULL),
(128, 23, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:29', '2025-10-27 11:28:29', NULL, NULL),
(129, 24, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:29', '2025-10-27 11:28:29', NULL, NULL),
(130, 25, 'New Voucher Available!', 'A new voucher <b>SAMPLE50</b> is added: ₱50.00 off - to celebrate the opoening of timplato here is a discount!. Check it out in your account!', 0, '2025-10-27 11:28:29', '2025-10-27 11:28:29', NULL, NULL),
(131, 1, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(132, 3, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(133, 4, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(134, 6, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(135, 7, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(136, 8, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(137, 9, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(138, 10, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(139, 11, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(140, 12, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(141, 13, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(142, 14, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(143, 15, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(144, 16, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(145, 22, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(146, 23, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(147, 24, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(148, 25, 'New Voucher Available!', 'New voucher <b>SAMPLE10P</b> available: 10% off. 10% off total + shipping', 0, '2025-10-27 11:30:59', '2025-10-27 11:30:59', NULL, NULL),
(149, 1, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(150, 3, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(151, 4, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(152, 6, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(153, 7, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(154, 8, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(155, 9, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(156, 10, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(157, 11, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(158, 12, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(159, 13, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(160, 14, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(161, 15, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(162, 16, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(163, 22, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(164, 23, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(165, 24, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(166, 25, 'New Voucher Available!', 'New voucher <b>WELCOME100</b> available: ₱100.00 off. Applies to all orders products.', 0, '2025-10-27 11:34:17', '2025-10-27 11:34:17', NULL, NULL),
(167, 1, 'Order Status Updated', 'Your order <b>#3</b> status has been updated.', 0, '2025-10-27 18:06:34', '2025-10-27 18:06:34', 3, NULL),
(168, 1, 'Order Status Updated', 'Your order <b>#3</b> status has been updated.', 0, '2025-10-27 18:20:11', '2025-10-27 18:20:11', 3, NULL),
(169, 1, 'Order Placed Successfully', 'Your order <b>#122</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-27 18:26:57', '2025-10-27 18:26:57', 122, NULL),
(170, 1, 'Order Confirmed', 'Your order <b>#122</b> has been confirmed by the seller.', 0, '2025-10-27 18:27:17', '2025-10-27 18:27:17', 122, NULL),
(171, 1, 'Order Processing', 'Your order <b>#122</b> is now being processed.', 0, '2025-10-27 18:27:20', '2025-10-27 18:27:20', 122, NULL),
(172, 1, 'Order Processing', 'Your order <b>#122</b> is now being processed.', 0, '2025-10-27 18:30:22', '2025-10-27 18:30:22', 122, NULL),
(173, 1, 'Order Shipped', 'Your order <b>#122</b> has been shipped and is on the way.', 0, '2025-10-27 18:30:27', '2025-10-27 18:30:27', 122, NULL),
(174, 1, 'Cancel Request Sent', 'Your cancellation request for order <b>#121</b> has been submitted.', 0, '2025-10-27 18:37:44', '2025-10-27 18:37:44', 121, NULL),
(175, 1, 'Order Placed Successfully', 'Your order <b>#123</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-27 18:46:56', '2025-10-27 18:46:56', 123, NULL),
(176, 1, 'Order Confirmed', 'Your order <b>#123</b> has been confirmed by the seller.', 0, '2025-10-27 18:47:09', '2025-10-27 18:47:09', 123, NULL),
(177, 1, 'Order Processing', 'Your order <b>#123</b> is now being processed.', 0, '2025-10-27 18:47:12', '2025-10-27 18:47:12', 123, NULL),
(178, 1, 'Order Shipped', 'Your order <b>#123</b> has been shipped and is on the way.', 0, '2025-10-27 18:48:00', '2025-10-27 18:48:00', 123, NULL),
(179, 1, 'Order Delivered', 'Your order <b>#123</b> has been delivered.', 0, '2025-10-27 18:48:03', '2025-10-27 18:48:03', 123, NULL),
(180, 1, 'Order Status Updated', 'Your order <b>#123</b> status has been updated.', 0, '2025-10-27 18:50:56', '2025-10-27 18:50:56', 123, NULL),
(181, 1, 'Order Status Updated', 'Your order <b>#123</b> status has been updated.', 0, '2025-10-27 18:56:49', '2025-10-27 18:56:49', 123, NULL),
(182, 1, 'Order Status Updated', 'Your order <b>#123</b> status has been updated.', 0, '2025-10-27 18:58:18', '2025-10-27 18:58:18', 123, NULL),
(183, 1, 'Order Status Updated', 'Your order <b>#123</b> status has been updated.', 0, '2025-10-27 18:58:32', '2025-10-27 18:58:32', 123, NULL),
(184, 1, 'Order Status Updated', 'Your order <b>#86</b> status has been updated.', 0, '2025-10-27 19:05:15', '2025-10-27 19:05:15', 86, NULL),
(185, 1, 'Order Placed Successfully', 'Your order <b>#124</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-27 19:05:27', '2025-10-27 19:05:27', 124, NULL),
(186, 1, 'Order Confirmed', 'Your order <b>#124</b> has been confirmed by the seller.', 0, '2025-10-27 19:05:45', '2025-10-27 19:05:45', 124, NULL),
(187, 1, 'Order Processing', 'Your order <b>#124</b> is now being processed.', 0, '2025-10-27 19:05:47', '2025-10-27 19:05:47', 124, NULL),
(188, 1, 'Order Shipped', 'Your order <b>#124</b> has been shipped and is on the way.', 0, '2025-10-27 19:05:50', '2025-10-27 19:05:50', 124, NULL),
(189, 1, 'Order Delivered', 'Your order <b>#124</b> has been delivered.', 0, '2025-10-27 19:05:52', '2025-10-27 19:05:52', 124, NULL),
(190, 1, 'Order Status Updated', 'Your order <b>#124</b> status has been updated.', 0, '2025-10-27 19:06:19', '2025-10-27 19:06:19', 124, NULL),
(191, 1, 'Order Status Updated', 'Your order <b>#124</b> status has been updated.', 0, '2025-10-27 19:06:39', '2025-10-27 19:06:39', 124, NULL),
(192, 1, 'Order Status Updated', 'Your order <b>#109</b> status has been updated.', 0, '2025-10-27 19:07:12', '2025-10-27 19:07:12', 109, NULL),
(193, 1, 'Order Placed Successfully', 'Your order <b>#125</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-27 19:26:34', '2025-10-27 19:26:34', 125, NULL),
(194, 1, 'Order Confirmed', 'Your order <b>#125</b> has been confirmed by the seller.', 0, '2025-10-27 19:27:18', '2025-10-27 19:27:18', 125, NULL),
(195, 1, 'Order Shipped', 'Your order <b>#125</b> has been shipped and is on the way.', 0, '2025-10-27 19:27:26', '2025-10-27 19:27:26', 125, NULL),
(196, 1, 'Order Delivered', 'Your order <b>#125</b> has been delivered.', 0, '2025-10-27 19:27:31', '2025-10-27 19:27:31', 125, NULL),
(197, 1, 'Order Status Updated', 'Your order <b>#125</b> status has been updated.', 0, '2025-10-27 19:27:59', '2025-10-27 19:27:59', 125, NULL),
(198, 1, 'Order Status Updated', 'Your order <b>#125</b> status has been updated.', 0, '2025-10-27 19:29:05', '2025-10-27 19:29:05', 125, NULL),
(199, 1, 'Order Status Updated', 'Your order <b>#125</b> status has been updated.', 0, '2025-10-27 19:29:34', '2025-10-27 19:29:34', 125, NULL),
(200, 1, 'Order Status Updated', 'Your order <b>#125</b> status has been updated.', 0, '2025-10-27 19:29:50', '2025-10-27 19:29:50', 125, NULL),
(201, 1, 'Order Returned', 'Your return request for order <b>#125</b> has been processed.', 0, '2025-10-27 19:30:23', '2025-10-27 19:30:23', 125, NULL),
(202, 1, 'Order Placed Successfully', 'Your order <b>#126</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-27 19:31:20', '2025-10-27 19:31:20', 126, NULL),
(203, 1, 'Order Confirmed', 'Your order <b>#126</b> has been confirmed by the seller.', 0, '2025-10-27 19:31:47', '2025-10-27 19:31:47', 126, NULL),
(204, 1, 'Order Processing', 'Your order <b>#126</b> is now being processed.', 0, '2025-10-27 19:31:51', '2025-10-27 19:31:51', 126, NULL),
(205, 1, 'Order Shipped', 'Your order <b>#126</b> has been shipped and is on the way.', 0, '2025-10-27 19:31:55', '2025-10-27 19:31:55', 126, NULL),
(206, 1, 'Order Delivered', 'Your order <b>#126</b> has been delivered.', 0, '2025-10-27 19:32:01', '2025-10-27 19:32:01', 126, NULL),
(207, 1, 'Order Status Updated', 'Your order <b>#126</b> status has been updated.', 0, '2025-10-27 19:32:44', '2025-10-27 19:32:44', 126, NULL),
(208, 1, 'Order Status Updated', 'Your order <b>#126</b> status has been updated.', 0, '2025-10-27 19:33:15', '2025-10-27 19:33:15', 126, NULL),
(209, 1, 'Order Status Updated', 'Your order <b>#126</b> status has been updated.', 0, '2025-10-27 19:33:30', '2025-10-27 19:33:30', 126, NULL),
(210, 1, 'Order Status Updated', 'Your order <b>#126</b> status has been updated.', 0, '2025-10-27 19:33:42', '2025-10-27 19:33:42', 126, NULL),
(211, 1, 'Order Refunded', 'Your order <b>#126</b> has been refunded successfully.', 0, '2025-10-27 19:36:19', '2025-10-27 19:36:19', 126, NULL),
(212, 1, 'Order Placed Successfully', 'Your order <b>#127</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-10-27 19:46:01', '2025-10-27 19:46:01', 127, NULL),
(213, 1, 'Order Confirmed', 'Your order <b>#127</b> has been confirmed by the seller.', 0, '2025-10-27 19:46:12', '2025-10-27 19:46:12', 127, NULL),
(214, 1, 'Order Processing', 'Your order <b>#127</b> is now being processed.', 0, '2025-10-27 19:46:24', '2025-10-27 19:46:24', 127, NULL),
(215, 1, 'Order Shipped', 'Your order <b>#127</b> has been shipped and is on the way.', 0, '2025-10-27 19:46:29', '2025-10-27 19:46:29', 127, NULL),
(216, 1, 'Order Delivered', 'Your order <b>#127</b> has been delivered.', 0, '2025-10-27 19:46:33', '2025-10-27 19:46:33', 127, NULL),
(217, 1, 'Order Status Updated', 'Your order <b>#127</b> status has been updated.', 0, '2025-10-27 19:46:59', '2025-10-27 19:46:59', 127, NULL),
(218, 1, 'Order Status Updated', 'Your order <b>#127</b> status has been updated.', 0, '2025-10-27 19:47:59', '2025-10-27 19:47:59', 127, NULL),
(219, 1, 'Order Refunded', 'Your order <b>#127</b> has been refunded successfully.', 0, '2025-10-27 19:48:01', '2025-10-27 19:48:01', 127, NULL),
(220, 26, 'Order Placed Successfully', 'Your order <b>#130</b> has been placed successfully. Thank you for shopping with us!', 0, '2025-11-13 00:07:22', '2025-11-13 00:07:22', 130, NULL),
(221, 26, 'Order Confirmed', 'Your order <b>#130</b> has been confirmed by the seller.', 0, '2025-11-13 00:11:21', '2025-11-13 00:11:21', 130, NULL),
(222, 26, 'Order Processing', 'Your order <b>#130</b> is now being processed.', 0, '2025-11-13 00:11:25', '2025-11-13 00:11:25', 130, NULL),
(223, 26, 'Order Shipped', 'Your order <b>#130</b> has been shipped and is on the way.', 0, '2025-11-13 00:11:29', '2025-11-13 00:11:29', 130, NULL),
(224, 26, 'Order Delivered', 'Your order <b>#130</b> has been delivered.', 0, '2025-11-13 00:11:34', '2025-11-13 00:11:34', 130, NULL),
(225, 26, 'Return Request Sent', 'Your return request for order <b>#130</b> has been submitted and is awaiting review.', 0, '2025-11-13 00:20:56', '2025-11-13 00:20:56', 130, NULL),
(226, 26, 'Return Request Approved', 'Your return request for order <b>#130</b> has been approved. Please follow the return instructions.', 0, '2025-11-13 00:21:20', '2025-11-13 00:21:20', 130, NULL),
(227, 1, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(228, 3, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(229, 4, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(230, 6, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(231, 7, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(232, 8, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(233, 9, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(234, 10, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(235, 11, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(236, 12, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(237, 13, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(238, 14, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(239, 15, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(240, 16, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(241, 22, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(242, 23, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(243, 24, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(244, 25, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL),
(245, 26, 'sample', 'sample', 0, '2025-11-14 23:09:08', '2025-11-14 23:09:08', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification_settings`
--

CREATE TABLE `notification_settings` (
  `setting_id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_settings`
--

INSERT INTO `notification_settings` (`setting_id`, `key`, `label`, `enabled`, `created_at`, `updated_at`) VALUES
(8, 'placed', 'Order Placed', 0, NULL, '2025-11-14 23:16:34'),
(9, 'confirmed', 'Order Confirmed', 1, NULL, NULL),
(10, 'processing', 'Order Processing', 1, NULL, NULL),
(11, 'shipped', 'Order Shipped', 1, NULL, NULL),
(12, 'delivered', 'Order Delivered', 1, NULL, NULL),
(13, 'cancelled', 'Order Cancelled', 1, NULL, NULL),
(14, 'refunded', 'Order Refunded', 1, NULL, NULL),
(15, 'voucher', 'Voucher Created', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `courier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_cost` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `voucher_code` varchar(255) DEFAULT NULL,
  `current_status` enum('pending','confirmed','processing','shipped','delivered','cancel_requested','cancelled','returned','refunded','completed','return_requested','refund_requested','refund_approved','return_approved') NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) NOT NULL,
  `delivery_method` varchar(255) NOT NULL,
  `payment_intent_id` varchar(255) DEFAULT NULL,
  `client_secret` varchar(255) DEFAULT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `cancel_reason` varchar(255) DEFAULT NULL,
  `cancel_requested_at` timestamp NULL DEFAULT NULL,
  `return_refund_type` varchar(255) DEFAULT NULL,
  `return_refund_reason` text DEFAULT NULL,
  `return_refund_requested_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `rider_id`, `courier_id`, `subtotal`, `discount_amount`, `shipping_cost`, `total_amount`, `voucher_code`, `current_status`, `payment_method`, `delivery_method`, `payment_intent_id`, `client_secret`, `tracking_number`, `cancel_reason`, `cancel_requested_at`, `return_refund_type`, `return_refund_reason`, `return_refund_requested_at`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, NULL, 0.00, NULL, 899.00, NULL, 'confirmed', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-08 09:20:45', '2025-09-08 09:20:45'),
(2, 1, NULL, NULL, NULL, 0.00, NULL, 899.00, NULL, 'delivered', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-08 09:21:38', '2025-09-08 09:21:38'),
(3, 1, NULL, NULL, NULL, 0.00, NULL, 999.00, NULL, 'delivered', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-08 09:22:01', '2025-10-27 18:20:11'),
(4, 1, NULL, NULL, NULL, 0.00, NULL, 799.00, NULL, 'cancelled', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-08 09:37:56', '2025-09-08 09:37:56'),
(5, 1, NULL, NULL, NULL, 0.00, NULL, 1299.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-08 09:38:03', '2025-09-08 09:38:03'),
(6, 1, NULL, NULL, NULL, 0.00, NULL, 699.00, NULL, 'returned', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-08 09:38:09', '2025-09-08 09:38:09'),
(7, 1, NULL, NULL, NULL, 0.00, NULL, 499.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-08 09:38:20', '2025-09-08 09:38:20'),
(8, 1, NULL, NULL, NULL, 0.00, NULL, 799.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-08 10:26:23', '2025-09-08 10:26:23'),
(9, 1, NULL, NULL, NULL, 0.00, NULL, 4097.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-08 10:38:05', '2025-09-08 10:38:05'),
(10, 1, NULL, NULL, NULL, 209.70, NULL, 489.30, 'GACUSAN30', 'pending', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-08 10:46:11', '2025-09-08 10:46:11'),
(11, 1, NULL, NULL, NULL, 0.00, NULL, 4097.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-09 06:05:35', '2025-09-09 06:05:35'),
(12, 1, NULL, NULL, NULL, 0.00, NULL, 4097.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-09 06:12:07', '2025-09-09 06:12:07'),
(13, 1, NULL, NULL, NULL, 0.00, NULL, 3297.00, NULL, 'delivered', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-09 07:11:26', '2025-09-09 07:11:26'),
(24, 4, NULL, NULL, NULL, 0.00, NULL, 399.00, NULL, 'pending', 'GCash', '', 'pi_hKPXtxoDhmaqJiBGAgCqzBSJ', 'pi_hKPXtxoDhmaqJiBGAgCqzBSJ_client_gu3RiPAXDwuEn1atmfrEV4SU', NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 10:26:41', '2025-09-25 10:26:42'),
(25, 4, NULL, NULL, NULL, 50.00, NULL, 149.00, 'ALDEN50', 'pending', 'GCash', '', 'pi_SWZBHb4eXDPjyYhKM4LLPCVK', 'pi_SWZBHb4eXDPjyYhKM4LLPCVK_client_BRVfJk12jEaZuSGkVsnhHj4G', NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 10:31:06', '2025-09-25 10:31:06'),
(26, 4, NULL, NULL, NULL, 0.00, NULL, 899.00, NULL, 'pending', 'GCash', '', 'pi_Hn8LnTeYG6Aq6bGxAqGJK7Ys', NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 11:10:00', '2025-09-25 11:10:01'),
(27, 4, NULL, NULL, NULL, 0.00, NULL, 899.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 11:10:10', '2025-09-25 11:10:10'),
(28, 1, NULL, NULL, NULL, 0.00, NULL, 799.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 21:57:09', '2025-09-25 21:57:09'),
(29, 1, NULL, NULL, NULL, 0.00, NULL, 799.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 21:59:04', '2025-09-25 21:59:04'),
(30, 1, NULL, NULL, NULL, 0.00, NULL, 799.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 22:01:16', '2025-09-25 22:01:16'),
(31, 1, NULL, NULL, NULL, 0.00, NULL, 399.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 22:20:30', '2025-09-25 22:20:30'),
(32, 1, NULL, NULL, NULL, 0.00, NULL, 299.00, NULL, 'confirmed', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 22:21:11', '2025-09-26 13:10:50'),
(33, 1, NULL, NULL, NULL, 0.00, NULL, 899.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 22:23:45', '2025-09-25 22:23:45'),
(34, 1, NULL, NULL, NULL, 0.00, NULL, 899.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 22:25:53', '2025-09-25 22:25:53'),
(35, 1, NULL, NULL, NULL, 0.00, NULL, 899.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 22:26:47', '2025-09-25 22:26:47'),
(36, 1, NULL, NULL, NULL, 0.00, NULL, 899.00, NULL, 'pending', 'Card', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 22:27:20', '2025-09-25 22:27:20'),
(37, 1, NULL, NULL, NULL, 0.00, NULL, 899.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 22:28:44', '2025-09-25 22:28:44'),
(38, 1, NULL, NULL, NULL, 0.00, NULL, 399.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 22:50:07', '2025-09-25 22:50:07'),
(39, 1, NULL, NULL, NULL, 0.00, NULL, 299.00, NULL, 'cancelled', 'GCash', '', NULL, NULL, NULL, 'i dont like it', '2025-09-27 09:20:16', NULL, NULL, NULL, '2025-09-25 22:50:14', '2025-09-27 09:27:22'),
(40, 1, NULL, NULL, NULL, 0.00, NULL, 699.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-25 22:51:59', '2025-09-25 22:51:59'),
(41, 1, NULL, NULL, NULL, 0.00, NULL, 899.00, NULL, 'confirmed', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-26 12:20:13', '2025-09-27 09:22:44'),
(42, 1, NULL, NULL, NULL, 0.00, NULL, 2097.00, NULL, 'cancel_requested', 'GCash', '', NULL, NULL, NULL, 'requested', '2025-09-26 13:49:17', NULL, NULL, NULL, '2025-09-26 12:26:43', '2025-09-26 13:49:17'),
(43, 1, NULL, NULL, NULL, 0.00, NULL, 2097.00, NULL, 'cancel_requested', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-26 12:27:20', '2025-09-26 13:40:05'),
(44, 1, NULL, NULL, NULL, 0.00, NULL, 349.00, NULL, 'cancel_requested', 'GCash', '', NULL, NULL, NULL, 'sample', '2025-09-26 13:48:32', NULL, NULL, NULL, '2025-09-26 12:27:30', '2025-09-26 13:48:32'),
(45, 1, NULL, NULL, NULL, 0.00, NULL, 349.00, NULL, 'cancel_requested', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-26 12:29:27', '2025-09-26 13:46:23'),
(46, 1, NULL, NULL, NULL, 0.00, NULL, 349.00, NULL, 'cancel_requested', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-26 12:36:30', '2025-09-26 13:43:37'),
(47, 1, NULL, NULL, NULL, 0.00, NULL, 699.00, NULL, 'confirmed', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-26 12:49:23', '2025-09-26 15:00:55'),
(48, 1, NULL, NULL, NULL, 0.00, NULL, 299.00, NULL, 'confirmed', 'GCash', '', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, '2025-09-26 13:11:26', '2025-09-26 13:12:04'),
(53, 4, NULL, NULL, NULL, 0.00, NULL, 17475.00, NULL, 'confirmed', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:22:21', '2025-09-27 22:23:09'),
(54, 4, NULL, NULL, NULL, 0.00, NULL, 14763.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:24:51', '2025-09-27 22:24:51'),
(55, 4, NULL, NULL, NULL, 0.00, NULL, 14763.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:25:48', '2025-09-27 22:25:48'),
(56, 4, NULL, NULL, NULL, 0.00, NULL, 14763.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:27:23', '2025-09-27 22:27:23'),
(57, 4, NULL, NULL, NULL, 0.00, NULL, 798.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:28:01', '2025-09-27 22:28:01'),
(58, 4, NULL, NULL, NULL, 0.00, NULL, 798.00, NULL, 'pending', 'Card', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:28:54', '2025-09-27 22:28:54'),
(59, 4, NULL, NULL, NULL, 0.00, NULL, 349.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:29:05', '2025-09-27 22:29:05'),
(60, 4, NULL, NULL, NULL, 0.00, NULL, 349.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:33:36', '2025-09-27 22:33:36'),
(61, 4, NULL, NULL, NULL, 0.00, NULL, 349.00, NULL, 'pending', 'Card', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:33:41', '2025-09-27 22:33:41'),
(62, 4, NULL, NULL, NULL, 0.00, NULL, 349.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:33:45', '2025-09-27 22:33:45'),
(63, 4, NULL, NULL, NULL, 0.00, NULL, 349.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:34:00', '2025-09-27 22:34:00'),
(64, 4, NULL, NULL, NULL, 0.00, NULL, 349.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:35:50', '2025-09-27 22:35:50'),
(65, 4, NULL, NULL, NULL, 0.00, NULL, 499.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:36:30', '2025-09-27 22:36:30'),
(66, 4, NULL, NULL, NULL, 0.00, NULL, 14763.00, NULL, 'confirmed', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:37:20', '2025-09-27 22:37:41'),
(67, 4, NULL, NULL, NULL, 0.00, NULL, 21147.00, NULL, 'cancelled', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:39:02', '2025-09-27 22:39:51'),
(68, 8, NULL, NULL, NULL, 0.00, NULL, 899.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-01 03:53:59', '2025-10-01 03:53:59'),
(69, 8, NULL, NULL, NULL, 0.00, NULL, 999.00, NULL, 'confirmed', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-01 03:54:40', '2025-10-01 03:56:03'),
(72, 10, NULL, NULL, NULL, 0.00, NULL, 2698.00, NULL, 'confirmed', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-01 08:51:28', '2025-10-01 08:53:45'),
(73, 12, NULL, NULL, NULL, 50.00, NULL, 1298.00, 'ALDEN50', 'processing', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-01 09:24:47', '2025-10-01 09:25:59'),
(74, 1, NULL, NULL, NULL, 0.00, NULL, 11180.00, NULL, 'confirmed', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-03 06:16:21', '2025-10-03 06:17:53'),
(75, 1, NULL, NULL, NULL, 0.00, NULL, 11180.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-03 06:18:45', '2025-10-03 06:18:45'),
(76, 1, NULL, NULL, NULL, 0.00, NULL, 4198.00, NULL, 'confirmed', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-03 06:21:34', '2025-10-03 06:22:09'),
(77, 1, NULL, NULL, NULL, 0.00, NULL, 399.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-03 06:23:42', '2025-10-03 06:23:42'),
(78, 14, NULL, NULL, NULL, 50.00, NULL, 7141.00, 'ALDEN50', 'cancelled', 'COD', '', NULL, NULL, NULL, 'Slow.', '2025-10-03 06:49:03', NULL, NULL, NULL, '2025-10-03 06:39:55', '2025-10-03 06:49:10'),
(79, 14, NULL, NULL, NULL, 50.00, NULL, 1449.00, 'ALDEN50', 'delivered', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-03 06:44:30', '2025-10-03 06:46:31'),
(80, 14, NULL, NULL, NULL, 0.00, NULL, 11996.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-03 06:50:07', '2025-10-03 06:50:07'),
(81, 14, NULL, NULL, NULL, 0.00, NULL, 11996.00, NULL, 'delivered', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-03 06:53:14', '2025-10-03 17:53:38'),
(82, 14, NULL, NULL, NULL, 0.00, NULL, 11996.00, NULL, 'cancelled', 'Card', '', NULL, NULL, NULL, 'Change Payment', '2025-10-03 06:56:09', NULL, NULL, NULL, '2025-10-03 06:53:18', '2025-10-03 14:58:06'),
(83, 14, NULL, NULL, NULL, 0.00, NULL, 799.00, NULL, 'delivered', 'GCash', '', NULL, NULL, NULL, 'change payment', '2025-10-03 15:18:44', NULL, NULL, NULL, '2025-10-03 15:17:25', '2025-10-03 17:53:19'),
(84, 14, NULL, NULL, NULL, 0.00, NULL, 1299.00, NULL, 'confirmed', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-03 15:21:50', '2025-10-03 15:23:36'),
(85, 1, NULL, NULL, NULL, 0.00, NULL, 4596.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-03 17:58:34', '2025-10-03 17:58:34'),
(86, 1, NULL, NULL, NULL, 0.00, NULL, 899.00, NULL, 'refund_requested', 'COD', '', NULL, NULL, NULL, NULL, NULL, 'refund', 'i hate it', '2025-10-27 19:05:15', '2025-10-03 18:13:24', '2025-10-27 19:05:15'),
(87, 1, NULL, NULL, NULL, 0.00, NULL, 299.00, NULL, 'delivered', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-03 18:14:36', '2025-10-03 18:14:54'),
(88, 16, NULL, NULL, NULL, 0.00, NULL, 9990.00, 'ALDEN 50', 'pending', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-10 16:35:01', '2025-10-10 16:35:01'),
(89, 16, NULL, NULL, NULL, 50.00, NULL, 4045.00, 'ALDEN50', 'confirmed', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-10 16:36:01', '2025-10-10 16:37:30'),
(90, 14, NULL, NULL, NULL, 50.00, NULL, 22393.00, 'ALDEN50', 'confirmed', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-10 17:17:51', '2025-10-10 17:19:23'),
(91, 1, NULL, NULL, NULL, 0.00, NULL, 799.00, NULL, 'confirmed', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-15 10:41:28', '2025-10-15 10:42:10'),
(95, 22, NULL, NULL, 799.00, 50.00, 100.00, 849.00, 'ALDEN50', 'pending', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-22 18:24:17', '2025-10-22 18:24:17'),
(96, 1, NULL, NULL, 799.00, 50.00, 100.00, 849.00, 'ALDEN50', 'delivered', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-23 16:20:02', '2025-10-23 16:27:36'),
(98, 1, NULL, NULL, 1299.00, 0.00, 150.00, 1449.00, NULL, 'confirmed', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-23 16:25:17', '2025-10-23 16:26:04'),
(99, 1, NULL, NULL, 2999.00, 0.00, 50.00, 3049.00, NULL, 'delivered', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-23 16:29:32', '2025-10-23 16:30:39'),
(100, 1, NULL, NULL, 799.00, 0.00, 50.00, 849.00, NULL, 'confirmed', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-24 09:06:36', '2025-10-24 09:13:15'),
(101, 1, NULL, NULL, 8994.00, 0.00, 50.00, 9044.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-24 10:17:06', '2025-10-24 10:17:06'),
(102, 1, NULL, NULL, 1299.00, 0.00, 50.00, 1349.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 14:35:38', '2025-10-25 14:35:38'),
(103, 1, NULL, NULL, 899.00, 0.00, 50.00, 949.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 15:59:40', '2025-10-25 15:59:40'),
(104, 1, NULL, NULL, 4389.00, 0.00, 50.00, 4439.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 16:06:37', '2025-10-25 16:06:37'),
(105, 1, NULL, NULL, 399.00, 0.00, 50.00, 449.00, NULL, 'pending', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 16:07:10', '2025-10-25 16:07:10'),
(106, 1, NULL, NULL, 399.00, 0.00, 50.00, 449.00, NULL, 'confirmed', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 16:07:12', '2025-10-25 16:07:32'),
(107, 1, NULL, NULL, 399.00, 0.00, 50.00, 449.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 16:10:17', '2025-10-25 16:10:17'),
(108, 1, NULL, NULL, 399.00, 0.00, 50.00, 449.00, NULL, 'confirmed', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 16:10:37', '2025-10-25 16:10:57'),
(109, 1, NULL, NULL, 1599.00, 0.00, 50.00, 1649.00, NULL, 'refund_requested', 'COD', '', NULL, NULL, NULL, NULL, NULL, 'refund', 'i hate it', '2025-10-27 19:07:12', '2025-10-25 16:11:36', '2025-10-27 19:07:12'),
(110, 1, NULL, NULL, 1599.00, 0.00, 150.00, 1749.00, NULL, 'confirmed', 'GCash', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 16:12:07', '2025-10-25 16:12:34'),
(111, 1, NULL, NULL, 799.00, 0.00, 150.00, 949.00, NULL, 'pending', 'COD', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 19:56:05', '2025-10-25 19:56:05'),
(112, 1, NULL, NULL, 799.00, 0.00, 50.00, 849.00, NULL, 'pending', 'COD', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 20:01:43', '2025-10-25 20:01:43'),
(113, 1, NULL, NULL, 999.00, 0.00, 150.00, 1149.00, NULL, 'pending', 'COD', 'Named Day Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 20:02:01', '2025-10-25 20:02:01'),
(115, 1, NULL, NULL, 1299.00, 50.00, 50.00, 1299.00, 'ALDEN50', 'pending', 'COD', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 20:14:42', '2025-10-25 20:14:42'),
(116, 1, NULL, NULL, 899.00, 284.70, 50.00, 664.30, 'GACUSAN30', 'pending', 'COD', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 20:15:09', '2025-10-25 20:15:09'),
(117, 1, NULL, NULL, 3499.00, 0.00, 50.00, 3549.00, NULL, 'pending', 'GCash', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 20:25:54', '2025-10-25 20:25:54'),
(118, 1, NULL, NULL, 3499.00, 0.00, 50.00, 3549.00, NULL, 'pending', 'Card', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 20:26:01', '2025-10-25 20:26:01'),
(119, 1, NULL, NULL, 3499.00, 0.00, 50.00, 3549.00, NULL, 'pending', 'COD', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-25 20:26:07', '2025-10-25 20:26:07'),
(120, 1, NULL, NULL, 799.00, 0.00, 50.00, 849.00, NULL, 'pending', 'COD', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-27 10:47:46', '2025-10-27 10:47:46'),
(121, 1, NULL, NULL, 799.00, 0.00, 50.00, 849.00, NULL, 'cancel_requested', 'COD', 'Standard Delivery', NULL, NULL, NULL, 'i dont like it', '2025-10-27 18:37:44', NULL, NULL, NULL, '2025-10-27 10:48:04', '2025-10-27 18:37:44'),
(122, 1, NULL, NULL, 799.00, 0.00, 50.00, 849.00, NULL, 'shipped', 'COD', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-27 18:26:57', '2025-10-27 18:30:27'),
(123, 1, NULL, NULL, 8596.00, 0.00, 50.00, 8646.00, NULL, 'returned', 'COD', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, 'return', 'aa', '2025-10-27 18:58:18', '2025-10-27 18:46:56', '2025-10-27 18:58:32'),
(124, 1, NULL, NULL, 799.00, 0.00, 50.00, 849.00, NULL, 'returned', 'COD', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, 'refund', 'i hate it', '2025-10-27 19:06:19', '2025-10-27 19:05:27', '2025-10-27 19:06:39'),
(125, 1, NULL, NULL, 999.00, 0.00, 50.00, 1049.00, NULL, 'returned', 'COD', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, 'return', 'sample again', '2025-10-27 19:29:34', '2025-10-27 19:26:34', '2025-10-27 19:30:23'),
(126, 1, NULL, NULL, 699.00, 0.00, 50.00, 749.00, NULL, 'refunded', 'COD', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, 'refund', 'sample', '2025-10-27 19:33:30', '2025-10-27 19:31:20', '2025-10-27 19:36:19'),
(127, 1, NULL, NULL, 999.00, 0.00, 50.00, 1049.00, NULL, 'refunded', 'COD', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, 'refund', 'sample', '2025-10-27 19:46:59', '2025-10-27 19:46:01', '2025-10-27 19:48:01'),
(128, 1, NULL, NULL, 899.00, 0.00, 50.00, 949.00, NULL, 'confirmed', 'GCash', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-12 20:24:23', '2025-11-12 20:24:44'),
(129, 26, NULL, NULL, 2697.00, 0.00, 50.00, 2747.00, NULL, 'pending', 'GCash', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-13 00:06:57', '2025-11-13 00:06:57'),
(130, 26, NULL, NULL, 2697.00, 0.00, 50.00, 2747.00, NULL, 'return_approved', 'COD', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, 'return', 'I dont like it.', '2025-11-13 00:20:56', '2025-11-13 00:07:22', '2025-11-13 00:21:20'),
(131, 26, NULL, NULL, 999.00, 0.00, 50.00, 1049.00, NULL, 'pending', 'GCash', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-15 00:29:39', '2025-11-15 00:29:39'),
(132, 26, NULL, NULL, 999.00, 0.00, 50.00, 1049.00, NULL, 'confirmed', 'GCash', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-15 00:44:52', '2025-11-15 00:45:55'),
(133, 26, NULL, NULL, 1999.00, 0.00, 50.00, 2049.00, NULL, 'pending', 'GCash', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-15 00:46:41', '2025-11-15 00:46:41'),
(134, 26, NULL, NULL, 1999.00, 0.00, 50.00, 2049.00, NULL, 'pending', 'GCash', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-15 02:17:43', '2025-11-15 02:17:43'),
(135, 26, NULL, NULL, 1499.00, 0.00, 50.00, 1549.00, NULL, 'pending', 'GCash', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-15 02:28:37', '2025-11-15 02:28:37'),
(136, 26, NULL, NULL, 1499.00, 0.00, 50.00, 1549.00, NULL, 'confirmed', 'GCash', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-15 02:29:08', '2025-11-15 02:30:27'),
(137, 1, NULL, NULL, 799.00, 0.00, 50.00, 849.00, NULL, 'confirmed', 'GCash', 'Standard Delivery', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 13:36:37', '2025-11-25 13:37:45');

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
(49, 40, 30, 1, 699.00, '2025-09-25 22:51:59', '2025-09-25 22:51:59'),
(50, 41, 4, 1, 899.00, '2025-09-26 12:20:13', '2025-09-26 12:20:13'),
(51, 42, 30, 3, 699.00, '2025-09-26 12:26:43', '2025-09-26 12:26:43'),
(52, 43, 30, 3, 699.00, '2025-09-26 12:27:20', '2025-09-26 12:27:20'),
(53, 44, 29, 1, 349.00, '2025-09-26 12:27:30', '2025-09-26 12:27:30'),
(54, 45, 29, 1, 349.00, '2025-09-26 12:29:27', '2025-09-26 12:29:27'),
(55, 46, 29, 1, 349.00, '2025-09-26 12:36:30', '2025-09-26 12:36:30'),
(56, 47, 21, 1, 699.00, '2025-09-26 12:49:23', '2025-09-26 12:49:23'),
(57, 48, 35, 1, 299.00, '2025-09-26 13:11:26', '2025-09-26 13:11:26'),
(62, 53, 45, 25, 699.00, '2025-09-27 22:22:21', '2025-09-27 22:22:21'),
(63, 54, 44, 37, 399.00, '2025-09-27 22:24:51', '2025-09-27 22:24:51'),
(64, 55, 44, 37, 399.00, '2025-09-27 22:25:48', '2025-09-27 22:25:48'),
(65, 56, 44, 37, 399.00, '2025-09-27 22:27:23', '2025-09-27 22:27:23'),
(66, 57, 44, 2, 399.00, '2025-09-27 22:28:01', '2025-09-27 22:28:01'),
(67, 58, 44, 2, 399.00, '2025-09-27 22:28:54', '2025-09-27 22:28:54'),
(68, 59, 31, 1, 349.00, '2025-09-27 22:29:05', '2025-09-27 22:29:05'),
(69, 60, 31, 1, 349.00, '2025-09-27 22:33:36', '2025-09-27 22:33:36'),
(70, 61, 31, 1, 349.00, '2025-09-27 22:33:41', '2025-09-27 22:33:41'),
(71, 62, 31, 1, 349.00, '2025-09-27 22:33:45', '2025-09-27 22:33:45'),
(72, 63, 31, 1, 349.00, '2025-09-27 22:34:00', '2025-09-27 22:34:00'),
(73, 64, 31, 1, 349.00, '2025-09-27 22:35:50', '2025-09-27 22:35:50'),
(74, 65, 43, 1, 499.00, '2025-09-27 22:36:30', '2025-09-27 22:36:30'),
(75, 66, 44, 37, 399.00, '2025-09-27 22:37:20', '2025-09-27 22:37:20'),
(76, 67, 36, 53, 399.00, '2025-09-27 22:39:02', '2025-09-27 22:39:02'),
(77, 68, 4, 1, 899.00, '2025-10-01 03:53:59', '2025-10-01 03:53:59'),
(78, 69, 2, 1, 999.00, '2025-10-01 03:54:40', '2025-10-01 03:54:40'),
(83, 72, 12, 1, 1299.00, '2025-10-01 08:51:28', '2025-10-01 08:51:28'),
(84, 72, 19, 1, 1299.00, '2025-10-01 08:51:28', '2025-10-01 08:51:28'),
(85, 73, 17, 1, 399.00, '2025-10-01 09:24:47', '2025-10-01 09:24:47'),
(86, 73, 41, 1, 799.00, '2025-10-01 09:24:47', '2025-10-01 09:24:47'),
(87, 74, 3, 4, 1499.00, '2025-10-03 06:16:21', '2025-10-03 06:16:21'),
(88, 74, 45, 1, 699.00, '2025-10-03 06:16:21', '2025-10-03 06:16:21'),
(89, 74, 35, 15, 299.00, '2025-10-03 06:16:21', '2025-10-03 06:16:21'),
(90, 75, 3, 4, 1499.00, '2025-10-03 06:18:45', '2025-10-03 06:18:45'),
(91, 75, 45, 1, 699.00, '2025-10-03 06:18:45', '2025-10-03 06:18:45'),
(92, 75, 35, 15, 299.00, '2025-10-03 06:18:45', '2025-10-03 06:18:45'),
(93, 76, 3, 1, 1499.00, '2025-10-03 06:21:34', '2025-10-03 06:21:34'),
(94, 76, 9, 1, 2699.00, '2025-10-03 06:21:34', '2025-10-03 06:21:34'),
(95, 77, 25, 1, 399.00, '2025-10-03 06:23:42', '2025-10-03 06:23:42'),
(96, 78, 1, 9, 799.00, '2025-10-03 06:39:55', '2025-10-03 06:39:55'),
(97, 79, 3, 1, 1499.00, '2025-10-03 06:44:30', '2025-10-03 06:44:30'),
(98, 80, 7, 4, 2999.00, '2025-10-03 06:50:07', '2025-10-03 06:50:07'),
(99, 81, 7, 4, 2999.00, '2025-10-03 06:53:14', '2025-10-03 06:53:14'),
(100, 82, 7, 4, 2999.00, '2025-10-03 06:53:18', '2025-10-03 06:53:18'),
(101, 83, 1, 1, 799.00, '2025-10-03 15:17:25', '2025-10-03 15:17:25'),
(102, 84, 5, 1, 1299.00, '2025-10-03 15:21:50', '2025-10-03 15:21:50'),
(103, 85, 3, 1, 1499.00, '2025-10-03 17:58:34', '2025-10-03 17:58:34'),
(104, 85, 2, 1, 999.00, '2025-10-03 17:58:34', '2025-10-03 17:58:34'),
(105, 85, 5, 1, 1299.00, '2025-10-03 17:58:34', '2025-10-03 17:58:34'),
(106, 85, 1, 1, 799.00, '2025-10-03 17:58:34', '2025-10-03 17:58:34'),
(107, 86, 4, 1, 899.00, '2025-10-03 18:13:24', '2025-10-03 18:13:24'),
(108, 87, 26, 1, 299.00, '2025-10-03 18:14:36', '2025-10-03 18:14:36'),
(109, 88, 2, 10, 999.00, '2025-10-10 16:35:01', '2025-10-10 16:35:01'),
(110, 89, 16, 5, 799.00, '2025-10-10 16:36:01', '2025-10-10 16:36:01'),
(111, 90, 5, 1, 1299.00, '2025-10-10 17:17:51', '2025-10-10 17:17:51'),
(112, 90, 8, 6, 3499.00, '2025-10-10 17:17:51', '2025-10-10 17:17:51'),
(113, 91, 1, 1, 799.00, '2025-10-15 10:41:28', '2025-10-15 10:41:28'),
(121, 95, 1, 1, 799.00, '2025-10-22 18:24:17', '2025-10-22 18:24:17'),
(122, 96, 1, 1, 799.00, '2025-10-23 16:20:02', '2025-10-23 16:20:02'),
(123, 98, 12, 1, 1299.00, '2025-10-23 16:25:18', '2025-10-23 16:25:18'),
(124, 99, 7, 1, 2999.00, '2025-10-23 16:29:32', '2025-10-23 16:29:32'),
(125, 100, 1, 1, 799.00, '2025-10-24 09:06:36', '2025-10-24 09:06:36'),
(126, 101, 3, 6, 1499.00, '2025-10-24 10:17:06', '2025-10-24 10:17:06'),
(127, 102, 5, 1, 1299.00, '2025-10-25 14:35:38', '2025-10-25 14:35:38'),
(128, 103, 32, 1, 899.00, '2025-10-25 15:59:40', '2025-10-25 15:59:40'),
(129, 104, 36, 11, 399.00, '2025-10-25 16:06:37', '2025-10-25 16:06:37'),
(130, 105, 36, 1, 399.00, '2025-10-25 16:07:10', '2025-10-25 16:07:10'),
(131, 106, 36, 1, 399.00, '2025-10-25 16:07:12', '2025-10-25 16:07:12'),
(132, 107, 36, 1, 399.00, '2025-10-25 16:10:17', '2025-10-25 16:10:17'),
(133, 108, 36, 1, 399.00, '2025-10-25 16:10:37', '2025-10-25 16:10:37'),
(134, 109, 15, 1, 1599.00, '2025-10-25 16:11:36', '2025-10-25 16:11:36'),
(135, 110, 15, 1, 1599.00, '2025-10-25 16:12:07', '2025-10-25 16:12:07'),
(136, 111, 1, 1, 799.00, '2025-10-25 19:56:05', '2025-10-25 19:56:05'),
(137, 112, 1, 1, 799.00, '2025-10-25 20:01:43', '2025-10-25 20:01:43'),
(138, 113, 2, 1, 999.00, '2025-10-25 20:02:01', '2025-10-25 20:02:01'),
(140, 115, 12, 1, 1299.00, '2025-10-25 20:14:42', '2025-10-25 20:14:42'),
(141, 116, 4, 1, 899.00, '2025-10-25 20:15:09', '2025-10-25 20:15:09'),
(142, 117, 8, 1, 3499.00, '2025-10-25 20:25:54', '2025-10-25 20:25:54'),
(143, 118, 8, 1, 3499.00, '2025-10-25 20:26:01', '2025-10-25 20:26:01'),
(144, 119, 8, 1, 3499.00, '2025-10-25 20:26:07', '2025-10-25 20:26:07'),
(145, 120, 1, 1, 799.00, '2025-10-27 10:47:46', '2025-10-27 10:47:46'),
(146, 121, 1, 1, 799.00, '2025-10-27 10:48:04', '2025-10-27 10:48:04'),
(147, 122, 1, 1, 799.00, '2025-10-27 18:26:57', '2025-10-27 18:26:57'),
(148, 123, 15, 1, 1599.00, '2025-10-27 18:46:56', '2025-10-27 18:46:56'),
(149, 123, 1, 1, 799.00, '2025-10-27 18:46:56', '2025-10-27 18:46:56'),
(150, 123, 8, 1, 3499.00, '2025-10-27 18:46:56', '2025-10-27 18:46:56'),
(151, 123, 9, 1, 2699.00, '2025-10-27 18:46:56', '2025-10-27 18:46:56'),
(152, 124, 1, 1, 799.00, '2025-10-27 19:05:27', '2025-10-27 19:05:27'),
(153, 125, 2, 1, 999.00, '2025-10-27 19:26:34', '2025-10-27 19:26:34'),
(154, 126, 30, 1, 699.00, '2025-10-27 19:31:20', '2025-10-27 19:31:20'),
(155, 127, 2, 1, 999.00, '2025-10-27 19:46:01', '2025-10-27 19:46:01'),
(156, 128, 4, 1, 899.00, '2025-11-12 20:24:23', '2025-11-12 20:24:23'),
(157, 129, 1, 1, 799.00, '2025-11-13 00:06:57', '2025-11-13 00:06:57'),
(158, 129, 17, 1, 399.00, '2025-11-13 00:06:57', '2025-11-13 00:06:57'),
(159, 129, 3, 1, 1499.00, '2025-11-13 00:06:57', '2025-11-13 00:06:57'),
(160, 130, 1, 1, 799.00, '2025-11-13 00:07:22', '2025-11-13 00:07:22'),
(161, 130, 17, 1, 399.00, '2025-11-13 00:07:22', '2025-11-13 00:07:22'),
(162, 130, 3, 1, 1499.00, '2025-11-13 00:07:22', '2025-11-13 00:07:22'),
(163, 131, 2, 1, 999.00, '2025-11-15 00:29:39', '2025-11-15 00:29:39'),
(164, 132, 2, 1, 999.00, '2025-11-15 00:44:52', '2025-11-15 00:44:52'),
(165, 133, 10, 1, 1999.00, '2025-11-15 00:46:41', '2025-11-15 00:46:41'),
(166, 134, 10, 1, 1999.00, '2025-11-15 02:17:43', '2025-11-15 02:17:43'),
(167, 135, 3, 1, 1499.00, '2025-11-15 02:28:37', '2025-11-15 02:28:37'),
(168, 136, 3, 1, 1499.00, '2025-11-15 02:29:08', '2025-11-15 02:29:08'),
(169, 137, 1, 1, 799.00, '2025-11-25 13:36:37', '2025-11-25 13:36:37');

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
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `section` varchar(255) NOT NULL DEFAULT 'main',
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `title`, `content`, `section`, `order`, `created_at`, `updated_at`) VALUES
(9, 'about-us', 'About Us', 'At Timplato, we believe that every Filipino kitchen tells a story — one filled with family, flavor, and shared moments. Our goal is to make cooking more enjoyable and accessible by offering quality kitchenware and essentials that inspire creativity in every home.\r\n\r\nMore than just an online store, Timplato is built on the passion for helping Filipinos prepare, serve, and savor meals with the perfect timpla and the right plato.', 'hero', 0, '2025-10-26 18:23:45', '2025-10-26 18:23:45'),
(10, 'contact-us', 'Contact', 'We’d love to hear from you! Whether you have questions, feedback, or need assistance with your order, the Timplato team is here to help. Reach out to us — we’re just a message away.', 'hero', 0, '2025-10-26 18:24:49', '2025-10-26 18:24:49'),
(11, 'contact-us', 'Contact', '<p><strong>Email:</strong> support@timplato.ph</p>\r\n<p><strong>Phone:</strong> +63 912 345 6789</p>\r\n<p><strong>Address:</strong> 123 Timplato St., Quezon City, Philippines</p>\r\n<p>Our team is available Monday to Friday, 9:00 AM – 6:00 PM.</p>', 'contact-info', 0, '2025-10-26 18:29:41', '2025-10-26 18:29:41'),
(14, 'privacy-policy', 'Privacy Policy', 'Your privacy is important to us. At Timplato, we are committed to protecting the personal information you share with us and ensuring that your data is handled with transparency, care, and respect every step of the way.', 'hero', 0, '2025-10-26 18:39:22', '2025-10-26 18:39:22'),
(15, 'privacy-policy', 'Privacy Policy', '<p>At Timplato, we respect your privacy and are committed to protecting your personal information. This Privacy Policy explains how we collect, use, and protect your data when you visit our website or use our services.</p>\r\n                                                                            <h3>1. Information We Collect</h3>\r\n                                                                            <p>We may collect personal information such as your name, email address, phone number, shipping address, and payment details when you make purchases or interact with our website.</p>\r\n                                                                            <h3>2. How We Use Your Information</h3>\r\n                                                                            <p>We use your information to process orders, provide customer support, improve our services, and send you promotional updates if you have opted in.</p>\r\n                                                                            <h3>3. Data Sharing</h3>\r\n                                                                            <p>We do not sell or rent your personal information to third parties. We may share your information with trusted service providers to facilitate payment processing, shipping, or other essential services.</p>\r\n                                                                            <h3>4. Cookies and Tracking</h3>\r\n                                                                            <p>We use cookies and similar technologies to enhance your browsing experience, analyze website traffic, and personalize content.</p>\r\n                                                                            <h3>5. Data Security</h3>\r\n                                                                            <p>We implement industry-standard security measures to protect your personal information from unauthorized access, disclosure, or misuse.</p>\r\n                                                                            <h3>6. Your Rights</h3>\r\n                                                                            <p>You have the right to access, correct, or delete your personal information. You may also unsubscribe from promotional emails at any time.</p>\r\n                                                                            <h3>7. Changes to This Policy</h3>\r\n                                                                            <p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with an updated effective date.</p>\r\n                                                                            <h3>Contact Us</h3>\r\n                                                                            <p>If you have any questions or concerns about this Privacy Policy, please contact us at <strong>support@timplato.com</strong>.</p>', 'privacy-content', 0, '2025-10-26 19:32:48', '2025-10-26 19:32:48'),
(16, 'customer-support', 'Help Center', 'Welcome to Timplato’s Help Center. Explore answers to common questions or reach out to us directly if you need further assistance.', 'hero', 0, '2025-10-26 19:45:51', '2025-10-26 19:45:51'),
(25, 'customer-support', 'Shop with Timplato', '[\r\n  {\r\n    \"title\": \"New to Timplato\",\r\n    \"content\": \"Timplato was founded in 2025 with the goal of providing high-quality home and kitchen products that combine functionality with modern design. We aim to make your everyday living easier and more stylish by curating items that are both affordable and durable. Whether you are setting up your first kitchen or upgrading your home essentials, Timplato ensures that every product meets our standards of quality and customer satisfaction.\"\r\n  },\r\n  {\r\n    \"title\": \"Products on Timplato\",\r\n    \"content\": \"Timplato focuses exclusively on home, kitchenware, and lifestyle products that are carefully sourced from trusted suppliers. Each item is tested for quality, usability, and value to guarantee that customers receive only the best. From cookware and dining sets to home organizers and décor, our catalog is designed to help you create a cozy and functional home environment with ease.\"\r\n  }\r\n]', 'shop', 0, '2025-10-26 20:01:01', '2025-10-26 20:01:01'),
(26, 'customer-support', 'General', '[\r\n  {\r\n    \"title\": \"How do I remove a kitchenware item?\",\r\n    \"content\": \"To remove a kitchenware item from your cart, simply go to your shopping cart page by clicking the cart icon located at the top-right corner of the website. Once there, you’ll see a list of all the items you’ve added. Find the product you want to remove, then click the \'Remove\' or \'Delete\' button beside it. The cart will automatically update to reflect the change. If you change your mind later, you can always add the item back by browsing the product page again.\"\r\n  }\r\n]', 'general', 0, '2025-10-26 20:03:45', '2025-10-26 20:03:45'),
(27, 'customer-support', 'Payment', '[\r\n  {\r\n    \"title\": \"How do I choose the payment method?\",\r\n    \"content\": \"At checkout, you’ll be prompted to select your preferred payment method before confirming your order. Timplato supports several options, including credit and debit cards, digital wallets (such as GCash and Maya), and cash-on-delivery for eligible locations. Simply tap or click your chosen method, then follow the instructions to complete the transaction. You can also save your preferred payment method for faster checkout in the future.\"\r\n  },\r\n  {\r\n    \"title\": \"Is my payment information secure?\",\r\n    \"content\": \"Yes. Timplato uses industry-standard encryption and secure payment gateways to protect your financial data. Your payment details are never stored on our servers — they are processed directly by our trusted payment partners. Always make sure you’re on the official Timplato website or app before entering your payment information.\"\r\n  }\r\n]', 'payment', 0, '2025-10-26 20:04:24', '2025-10-26 20:04:24'),
(28, 'customer-support', 'Orders & Shipping', '[\r\n  {\r\n    \"title\": \"How do I choose a delivery method?\",\r\n    \"content\": \"When you proceed to checkout, you’ll be prompted to select a delivery method before completing your purchase. You can choose from available options such as Standard Delivery, Express Shipping, or Pick-Up (if applicable). Each method will display its estimated delivery time and corresponding cost. Select the option that best suits your needs, and the system will automatically calculate the total order amount including shipping fees.\"\r\n  },\r\n  {\r\n    \"title\": \"Can I change my delivery method after placing an order?\",\r\n    \"content\": \"Once an order has been confirmed, changing the delivery method may not always be possible since processing begins immediately. However, if your order hasn’t been shipped yet, you can contact our customer support team to request a change. We’ll do our best to accommodate your request depending on the courier’s status and availability.\"\r\n  }\r\n]', 'shipping', 0, '2025-10-26 20:04:48', '2025-10-26 20:04:48'),
(29, 'customer-support', 'Coupons/Vouchers', '[\r\n  {\r\n    \"title\": \"Using Coupons\",\r\n    \"content\": \"Voucher discounts are applied automatically when you meet the required conditions for a promotion. For example, a ₱100 discount might apply if your order total reaches a minimum purchase amount. You’ll see the discount reflected in your order summary before checkout. Please note that only one coupon can be used per transaction unless otherwise stated in the promotion’s terms.\"\r\n  },\r\n  {\r\n    \"title\": \"How do I apply a coupon?\",\r\n    \"content\": \"At checkout, look for the coupon or voucher field right before you finalize your payment. Tap or click on the text field and enter your coupon code exactly as it appears—pay attention to uppercase letters and numbers. Once you click \'Apply\', the system will validate your code and automatically update your total if the coupon is valid. If your code doesn’t work, double-check the expiration date and minimum purchase requirement.\"\r\n  }\r\n]', 'coupons', 0, '2025-10-26 20:05:05', '2025-10-26 20:05:05'),
(31, 'home-hero-guest', 'WELCOME TO', 'an e-commerce platform that focuses on providing kitchenware and cooking essentials to Filipino households. The name \"Timplato\" comes from two Filipino words, \"timpla\" which means to mix or season, and \"plato\" which means plate. This reflects the brand’s goal of helping people prepare and enjoy meals with the right tools.', 'hero', 0, '2025-10-26 20:32:05', '2025-10-26 20:32:05'),
(32, 'home-hero-auth', 'WELCOME BACK,', 'We\'re glad to see you again. Browse our latest kitchenware and cooking essentials, handpicked just for you. Let’s make every meal more special with the right tools.', 'hero', 0, '2025-10-26 20:32:20', '2025-10-26 20:32:20');

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `method` varchar(50) NOT NULL,
  `status` enum('pending','completed','failed','refunded') NOT NULL DEFAULT 'pending',
  `amount` decimal(10,2) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `method`, `status`, `amount`, `transaction_id`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 96, 'COD', 'pending', 849.00, NULL, NULL, '2025-10-23 16:20:02', '2025-10-23 16:20:02'),
(2, 98, 'GCash', 'completed', 1449.00, NULL, '2025-10-23 16:26:04', '2025-10-23 16:25:18', '2025-10-23 16:26:04'),
(3, 99, 'COD', 'completed', 3049.00, NULL, '2025-10-23 16:30:39', '2025-10-23 16:29:32', '2025-10-23 16:30:39'),
(4, 100, 'GCash', 'pending', 849.00, NULL, NULL, '2025-10-24 09:06:36', '2025-10-24 09:06:36'),
(5, 101, 'COD', 'pending', 9044.00, NULL, NULL, '2025-10-24 10:17:06', '2025-10-24 10:17:06'),
(6, 102, 'COD', 'pending', 1349.00, NULL, NULL, '2025-10-25 14:35:38', '2025-10-25 14:35:38'),
(7, 103, 'COD', 'pending', 949.00, NULL, NULL, '2025-10-25 15:59:40', '2025-10-25 15:59:40'),
(8, 104, 'COD', 'pending', 4439.00, NULL, NULL, '2025-10-25 16:06:37', '2025-10-25 16:06:37'),
(9, 105, 'GCash', 'pending', 449.00, NULL, NULL, '2025-10-25 16:07:10', '2025-10-25 16:07:10'),
(10, 106, 'GCash', 'completed', 449.00, NULL, '2025-10-25 16:07:32', '2025-10-25 16:07:12', '2025-10-25 16:07:32'),
(11, 107, 'COD', 'pending', 449.00, NULL, NULL, '2025-10-25 16:10:17', '2025-10-25 16:10:17'),
(12, 108, 'GCash', 'completed', 449.00, NULL, '2025-10-25 16:10:57', '2025-10-25 16:10:37', '2025-10-25 16:10:57'),
(13, 109, 'COD', 'completed', 1649.00, NULL, '2025-10-25 16:13:30', '2025-10-25 16:11:36', '2025-10-25 16:13:30'),
(14, 110, 'GCash', 'completed', 1749.00, NULL, '2025-10-25 16:12:34', '2025-10-25 16:12:07', '2025-10-25 16:12:34'),
(15, 111, 'COD', 'pending', 949.00, NULL, NULL, '2025-10-25 19:56:05', '2025-10-25 19:56:05'),
(16, 112, 'COD', 'pending', 849.00, NULL, NULL, '2025-10-25 20:01:43', '2025-10-25 20:01:43'),
(17, 113, 'COD', 'pending', 1149.00, NULL, NULL, '2025-10-25 20:02:01', '2025-10-25 20:02:01'),
(19, 115, 'COD', 'pending', 1299.00, NULL, NULL, '2025-10-25 20:14:42', '2025-10-25 20:14:42'),
(20, 116, 'COD', 'pending', 664.30, NULL, NULL, '2025-10-25 20:15:09', '2025-10-25 20:15:09'),
(21, 117, 'GCash', 'pending', 3549.00, NULL, NULL, '2025-10-25 20:25:54', '2025-10-25 20:25:54'),
(22, 118, 'Card', 'pending', 3549.00, NULL, NULL, '2025-10-25 20:26:01', '2025-10-25 20:26:01'),
(23, 119, 'COD', 'pending', 3549.00, NULL, NULL, '2025-10-25 20:26:07', '2025-10-25 20:26:07'),
(24, 120, 'COD', 'pending', 849.00, NULL, NULL, '2025-10-27 10:47:46', '2025-10-27 10:47:46'),
(25, 121, 'COD', 'pending', 849.00, NULL, NULL, '2025-10-27 10:48:04', '2025-10-27 10:48:04'),
(26, 122, 'COD', 'pending', 849.00, NULL, NULL, '2025-10-27 18:26:57', '2025-10-27 18:26:57'),
(27, 123, 'COD', 'completed', 8646.00, NULL, '2025-10-27 18:48:03', '2025-10-27 18:46:56', '2025-10-27 18:48:03'),
(28, 124, 'COD', 'completed', 849.00, NULL, '2025-10-27 19:05:52', '2025-10-27 19:05:27', '2025-10-27 19:05:52'),
(29, 125, 'COD', 'completed', 1049.00, NULL, '2025-10-27 19:27:31', '2025-10-27 19:26:34', '2025-10-27 19:27:31'),
(30, 126, 'COD', 'refunded', 749.00, NULL, '2025-10-27 19:32:01', '2025-10-27 19:31:20', '2025-10-27 19:36:19'),
(31, 127, 'COD', 'refunded', 1049.00, NULL, '2025-10-27 19:46:33', '2025-10-27 19:46:01', '2025-10-27 19:48:01'),
(32, 128, 'GCash', 'completed', 949.00, NULL, '2025-11-12 20:24:44', '2025-11-12 20:24:23', '2025-11-12 20:24:44'),
(33, 129, 'GCash', 'pending', 2747.00, NULL, NULL, '2025-11-13 00:06:57', '2025-11-13 00:06:57'),
(34, 130, 'COD', 'completed', 2747.00, NULL, '2025-11-13 00:11:34', '2025-11-13 00:07:22', '2025-11-13 00:11:34'),
(35, 131, 'GCash', 'pending', 1049.00, NULL, NULL, '2025-11-15 00:29:39', '2025-11-15 00:29:39'),
(36, 132, 'GCash', 'completed', 1049.00, NULL, '2025-11-15 00:45:55', '2025-11-15 00:44:52', '2025-11-15 00:45:55'),
(37, 133, 'GCash', 'pending', 2049.00, NULL, NULL, '2025-11-15 00:46:41', '2025-11-15 00:46:41'),
(38, 134, 'GCash', 'pending', 2049.00, NULL, NULL, '2025-11-15 02:17:43', '2025-11-15 02:17:43'),
(39, 135, 'GCash', 'pending', 1549.00, NULL, NULL, '2025-11-15 02:28:37', '2025-11-15 02:28:37'),
(40, 136, 'GCash', 'completed', 1549.00, NULL, '2025-11-15 02:30:27', '2025-11-15 02:29:08', '2025-11-15 02:30:27'),
(41, 137, 'GCash', 'completed', 849.00, NULL, '2025-11-25 13:37:45', '2025-11-25 13:36:37', '2025-11-25 13:37:45');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(3, 'COD', 'Cash on Delivery', '2025-10-25 19:39:27', '2025-10-25 19:39:27'),
(4, 'GCash', 'Payment Center / E-Wallet', '2025-10-25 19:40:39', '2025-10-25 19:40:39'),
(5, 'Card', 'Credit / Debit Card', '2025-10-25 19:41:00', '2025-10-25 19:41:00');

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
  `sold` int(11) NOT NULL DEFAULT 0,
  `restock_level` int(11) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `stock_quantity`, `sold`, `restock_level`, `category_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Non-Stick Frying Pan – 28cm', 'Durable non-stick frying pan, 28cm size. Crafted with a premium non-stick coating that ensures effortless food release and easy cleaning, this pan is perfect for everyday cooking. It allows you to cook with minimal oil, making it healthier and more convenient. The ergonomic handle provides a comfortable grip, and the even heat distribution ensures your meals cook evenly. Ideal for frying eggs, sautéing vegetables, or searing meats, this versatile frying pan is a must-have for any kitchen. Dishwasher-safe for easy maintenance.', 799.00, 351, -1, 10, 4, 1, '2025-09-08 16:59:40', '2025-11-25 13:37:45'),
(2, 'Stainless Steel Pot with Lid – 2L', 'This high-quality 2L stainless steel pot with a glass lid is perfect for cooking a wide range of meals, from soups to pasta. Made from durable, rust-resistant stainless steel, this pot offers superior heat distribution for consistent cooking results. The heat-resistant glass lid allows you to monitor your cooking without lifting the lid, while the sturdy, cool-to-the-touch handles ensure safe handling. This versatile pot is ideal for boiling, simmering, and preparing sauces or stews, making it a great addition to any kitchen.', 999.00, 237, 3, 10, 4, 1, '2025-09-08 16:59:40', '2025-11-15 00:45:55'),
(3, 'Cast Iron Frying Pan – 10 inch', 'This heavy-duty 10-inch cast iron frying pan is perfect for serious home cooks. With its superior heat retention and even heat distribution, this pan ensures that your meals cook consistently and with great flavor. The pre-seasoned surface provides a natural, non-stick finish that improves with each use, adding depth to your dishes. This versatile pan is perfect for searing steaks, frying chicken, baking cornbread, or even cooking over a campfire. Built to last a lifetime, this cast iron pan is an essential kitchen tool for all types of cooking.', 1499.00, 118, 7, 5, 4, 1, '2025-09-08 16:59:40', '2025-11-15 02:30:27'),
(4, 'Ceramic-Coated Cooking Pan', 'Cook with confidence using this eco-friendly ceramic-coated cooking pan. Its non-toxic ceramic coating ensures that your food doesn’t stick, allowing for quick and easy cleaning. The smooth, non-stick surface reduces the need for oil, promoting healthier cooking. The durable base ensures even heat distribution, eliminating hot spots for more consistent results. The ergonomic handle provides a comfortable and secure grip, making it ideal for stir-frying, sautéing, and pan-roasting. This non-stick, chemical-free cookware is the perfect choice for health-conscious cooks.', 899.00, 127, 3, 5, 4, 1, '2025-09-08 16:59:40', '2025-11-12 20:24:44'),
(5, 'Large Aluminum Cooking Pot – 5L', 'Prepare large meals with ease using this spacious 5L aluminum cooking pot. Crafted from lightweight yet durable aluminum, this pot offers excellent heat conduction, ensuring fast and even cooking. The sturdy side handles are designed for safe, comfortable lifting, even when the pot is full. The tight-fitting lid locks in moisture and flavor, making it perfect for cooking stews, soups, pasta, or large family-sized meals. Whether you’re preparing a hearty soup or boiling pasta, this large-capacity pot is an essential kitchen companion.', 1299.00, 218, 2, 5, 4, 1, '2025-09-08 16:59:40', '2025-10-10 17:19:23'),
(6, '5-Piece Non-Stick Cookware Set', 'This 5-piece non-stick cookware set includes everything you need for everyday cooking. Designed to meet the needs of beginner and seasoned cooks alike, each piece features a durable non-stick coating that allows for easy food release and quick cleanup. The set includes a range of essential cookware items, each designed for versatility and consistency, whether you’re frying, sautéing, boiling, or simmering. The heat-resistant handles ensure a secure, comfortable grip while cooking. Ideal for any kitchen, this cookware set combines convenience and performance.', 2499.00, 15, 0, 5, 5, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(7, '7-Piece Stainless Steel Pot Set', 'Upgrade your kitchen with this premium 7-piece stainless steel pot set. Made from high-grade stainless steel for durability and a polished finish, each pot in this set is designed for maximum heat distribution and even cooking. The set includes a variety of pot sizes to suit all your cooking needs, and each piece comes with a matching lid for easy storage and cooking. The ergonomic, heat-resistant handles provide a secure and comfortable grip, making this set perfect for preparing large family meals, soups, and stews.', 2999.00, 12, 0, 3, 5, 1, '2025-09-08 16:59:40', '2025-10-03 17:53:35'),
(8, 'Induction-Compatible Cookware Set', 'Cook like a pro with this induction-compatible cookware set. Designed with a multi-layer base, this set works on all types of stovetops, including induction, gas, and electric, ensuring efficient and even heat conduction. The non-stick surface reduces oil usage and prevents food residue, while the sturdy, ergonomic handles provide excellent control while cooking. Whether you’re preparing everyday meals or gourmet dishes, this cookware set offers the perfect blend of performance and style for your kitchen.', 3499.00, 3, 7, 3, 5, 1, '2025-09-08 16:59:40', '2025-10-27 18:47:09'),
(9, '4-Piece Granite Pan Set', 'Bring style and function to your kitchen with this sleek 4-piece granite pan set. Featuring a durable granite coating, these pans offer enhanced non-stick performance and superior scratch resistance, ensuring long-lasting durability. The pans heat evenly, allowing you to achieve perfect browning and cooking results every time. The ergonomic handles provide a secure and comfortable grip, and the set is easy to clean and maintain. Perfect for frying, searing, and sautéing, this set is a kitchen essential for those who demand both style and performance.', 2699.00, 16, 2, 5, 5, 1, '2025-09-08 16:59:40', '2025-10-27 18:47:09'),
(10, 'Basic Cooking Starter Set', 'This affordable Basic Cooking Starter Set is perfect for anyone setting up their first kitchen or looking for essential cookware. Featuring a non-stick interior for easy food release and cleaning, this set includes the most commonly used kitchen items for frying, sautéing, and boiling. The lightweight construction ensures easy handling, while the durable base ensures even heat distribution. Whether you’re a beginner or simply need to refresh your kitchen essentials, this set is both practical and convenient.', 1999.00, 19, 1, 5, 5, 1, '2025-09-08 16:59:40', '2025-10-15 11:07:38'),
(11, 'Tamago Egg Pan (Japanese Style)', 'This specialized Japanese-style Tamago egg pan is designed for making perfectly layered tamagoyaki (rolled omelet). The pan’s rectangular shape allows you to create the authentic, thin layers of tamago with ease. Made with a high-quality non-stick coating, this pan ensures smooth flipping and rolling of the egg without it sticking or breaking. The ergonomic handle provides a secure and comfortable grip for added control. Perfect for breakfast dishes, sushi toppings, or anyone who wants to perfect their Japanese-style omelets.', 499.00, 35, 0, 10, 6, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(12, 'Double-Sided Grill Pan', 'Take grilling indoors with this versatile double-sided grill pan. Featuring a durable, non-stick surface, this pan allows you to grill, fry, or bake with ease on both sides, saving you time and effort. The magnetic locking system helps seal in heat for faster and juicier cooking, while the even heat distribution ensures your food is cooked perfectly. Ideal for grilling meats, fish, or vegetables, this pan is a great way to enjoy outdoor-style grilling all year round, even in your kitchen.', 1299.00, 22, 0, 5, 6, 1, '2025-09-08 16:59:40', '2025-10-23 16:26:04'),
(13, 'Clay Pot for Traditional Dishes', 'Handcrafted from natural clay, this traditional clay pot is perfect for slow-cooked dishes. Known for its excellent heat retention and distribution, it helps to simmer soups, stews, rice, and other dishes to perfection. The porous nature of the clay enhances the flavor and aroma of food, while maintaining moisture and tenderness. Ideal for Filipino, Korean, or Japanese dishes that require slow cooking, this clay pot is a must-have for anyone looking to create rich, flavorful meals with an authentic touch.', 699.00, 28, 0, 8, 6, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(14, 'Mini Pancake Pan – 7 Circles', 'This mini pancake pan features 7 molds to make perfectly round, bite-sized pancakes all at once. The non-stick surface ensures easy food release and quick cleanup, while the even heating ensures your pancakes cook evenly every time. Great for making multiple pancakes, eggs, or small treats, this fun and functional pan is perfect for breakfast, snacks, or party servings. Easy to use and clean, this is a must-have tool for any home cook looking to make pancakes more efficiently.', 899.00, 25, 0, 5, 6, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(15, 'Stainless Steel Steamer Pot', 'Steaming has never been easier with this high-quality stainless steel steamer pot. The multi-layer design allows you to steam multiple dishes simultaneously, preserving the nutrients and flavors of your food. The tight-fitting lid traps steam for even cooking, ensuring your food is moist and tender. Ideal for cooking dim sum, vegetables, seafood, or dumplings, this durable steamer is a healthy and convenient addition to any kitchen, making it perfect for anyone who loves healthy cooking.', 1599.00, 15, 3, 5, 6, 1, '2025-09-08 16:59:40', '2025-10-27 18:47:09'),
(16, 'Chef’s Knife – 8 inch', 'This professional 8-inch chef’s knife is designed for precision and balance in the kitchen. Crafted from high-quality stainless steel, the razor-sharp blade makes quick work of cutting meat, vegetables, fruits, and herbs. The full-tang construction offers superior durability and control, while the ergonomic handle ensures a secure and comfortable grip, even during extended use. Perfect for chefs and home cooks alike, this versatile knife can tackle a wide range of tasks with ease and efficiency.', 799.00, 35, 5, 10, 7, 1, '2025-09-08 16:59:40', '2025-10-10 16:37:30'),
(17, 'Multi-Purpose Kitchen Scissors', 'These heavy-duty kitchen scissors are built for strength and versatility. Whether you need to cut through poultry, herbs, packaging, or even small bones, these sharp stainless steel blades make quick work of the task. The non-slip handles ensure a comfortable and safe grip, and the built-in bottle opener and nutcracker add even more functionality. Whether you’re prepping ingredients or opening bottles, these scissors are a must-have in any kitchen for everyday tasks.', 399.00, 58, 2, 15, 7, 1, '2025-09-08 16:59:40', '2025-11-13 00:11:21'),
(18, 'Heavy-Duty Meat Knife', 'Durable heavy-duty meat knife with a thick, sharp stainless steel blade, specifically designed for cutting through large cuts of meat or breaking down poultry. This knife excels in heavy-duty tasks, ensuring precise slices and superior control. The ergonomic, well-balanced handle reduces hand fatigue, providing a secure, comfortable grip, making it ideal for both professional chefs and home cooks. Its rugged construction guarantees long-lasting durability, perfect for both commercial kitchens and home butchering needs.', 899.00, 35, 0, 10, 7, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(19, '3-Piece Knife Set with Cover', 'This 3-piece knife set includes essential kitchen knives: a chef’s knife, a utility knife, and a paring knife, each made from high-quality stainless steel for exceptional sharpness and long-lasting durability. Each knife comes with a protective cover for safe and hygienic storage, ensuring your knives stay in pristine condition. The ergonomic, non-slip handles are designed for comfort and precision, offering excellent control and reducing hand strain during meal preparation. A must-have set for everyday kitchen tasks.', 1299.00, 29, -1, 8, 7, 1, '2025-09-08 16:59:40', '2025-10-01 08:56:56'),
(20, 'Manual Knife Sharpener – 2 Stage', 'This 2-stage manual knife sharpener is designed to quickly and effectively restore your dull kitchen knives to their original sharpness. The first slot is for coarse sharpening, and the second is for fine honing, ensuring your blades stay in peak performance. With an ergonomic handle for comfort and a non-slip base for stability, it guarantees safe and precise sharpening. Suitable for most kitchen knives, this sharpener is an essential tool for maintaining your cutting tools, ensuring consistent and efficient meal prep.', 499.00, 50, 0, 15, 7, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(21, '5-Piece Silicone Spatula Set', 'This 5-piece silicone spatula set includes various spatula types perfect for all your cooking and baking needs. Made from premium heat-resistant silicone, these spatulas offer superior flexibility and durability, making them ideal for mixing, scraping, flipping, and spreading. Each spatula is gentle on non-stick cookware, preventing scratches while maintaining excellent control. The ergonomic, non-slip handles provide a comfortable grip, ensuring a secure hold. Easy to clean and available in vibrant colors, this set brings both practicality and style to your kitchen.', 699.00, 45, 0, 10, 8, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(22, 'Wooden Cooking Spoon Set', 'This wooden cooking spoon set is crafted from high-quality, eco-friendly wood, offering a classic and rustic addition to any kitchen. The set includes various spoons designed for stirring, mixing, and serving your favorite dishes. The smooth finish ensures the spoons won’t scratch cookware surfaces, making them safe for non-stick pots and pans. Naturally heat-resistant and long-lasting, these spoons are both durable and easy to maintain, offering a perfect balance of practicality and aesthetics for your everyday cooking.', 499.00, 50, 0, 10, 8, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(23, 'Stainless Steel Soup Ladle', 'A durable stainless steel soup ladle with a deep bowl for easy serving of soups, stews, sauces, and other liquids. The high-quality stainless steel construction ensures long-term durability, resistance to rust, and a shiny, polished finish. Its long handle keeps your hands safely away from heat while offering a comfortable grip. The hanging loop allows for convenient storage when not in use, making this ladle a timeless, essential tool for both home and professional kitchens.', 299.00, 55, 0, 12, 8, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(24, '12-Inch Food Tongs with Silicone Tips', 'These 12-inch food tongs feature heat-resistant silicone tips, making them ideal for grilling, frying, and salad tossing. The durable stainless steel arms ensure long-lasting strength, while the non-slip grip offers maximum control. The spring-loaded mechanism ensures effortless operation, and the locking feature allows for compact storage. Whether you are flipping, turning, or serving food, these versatile tongs provide excellent performance and are gentle on cookware, preventing scratches.', 399.00, 48, 0, 12, 8, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(25, 'Whisk and Turner Set', 'This kitchen whisk and turner set includes two essential tools for every cook: a sturdy stainless steel whisk for blending and whipping, and a durable turner for flipping pancakes, eggs, burgers, and more. Both tools are designed with ergonomic handles for maximum comfort and precision, allowing you to complete tasks with ease. Heat-resistant and easy to clean, this set is perfect for beginner cooks or seasoned chefs looking for reliable, everyday utensils.', 399.00, 45, 0, 10, 8, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(26, 'Manual Garlic Crusher', 'This compact manual garlic crusher is the perfect tool for quickly crushing garlic cloves, releasing their full flavor and aroma for your dishes. The ergonomic handle ensures a comfortable grip, giving you better control as you crush garlic with minimal effort. The durable, food-safe materials are designed to withstand everyday use, and the compact size makes it easy to store. Ideal for sauces, marinades, stir-fries, and more, this garlic crusher is a must-have for every kitchen.', 299.00, 61, 0, 15, 9, 1, '2025-09-08 16:59:40', '2025-10-03 18:14:51'),
(27, '6-Piece Measuring Spoon Set', 'This 6-piece measuring spoon set offers six accurately sized spoons to ensure precise ingredient measurements for all your cooking and baking needs. Made from food-grade plastic or stainless steel, the spoons are durable and easy to clean. Each spoon is clearly labeled and connected with a detachable ring for easy storage and organization, ensuring your kitchen stays tidy and your recipes come out perfect every time.', 249.00, 70, 0, 15, 9, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(28, 'Vegetable Peeler', 'This high-quality vegetable peeler features a precision stainless steel blade that glides effortlessly through fruits and vegetables, making peeling a breeze. The ergonomic handle provides a secure, comfortable grip, minimizing hand strain during repetitive tasks. Lightweight, rust-resistant, and compact, this peeler is designed for easy storage and long-lasting use. Perfect for peeling potatoes, carrots, apples, and more, it’s an essential tool for any kitchen.', 199.00, 65, 0, 15, 9, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(29, 'Grater with Container', 'This versatile kitchen grater features a fine stainless steel grating surface and a built-in storage container to catch and store grated ingredients. Whether you’re grating cheese, vegetables, garlic, or chocolate, this 2-in-1 tool minimizes mess while providing maximum convenience. The non-slip base ensures stability during use, and the compact design makes it easy to store. Dishwasher-safe for easy cleaning, this grater is an essential addition to any kitchen.', 349.00, 55, 0, 12, 9, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(30, 'Digital Kitchen Scale – up to 5kg', 'This digital kitchen scale is designed for precision, with a capacity of up to 5kg. Equipped with a high-precision sensor system, it provides accurate measurements in grams, ounces, or pounds, making it ideal for baking, meal prepping, and portion control. The sleek, easy-to-clean surface and clear LCD display make it simple to use, and the automatic shut-off feature helps conserve battery life. A must-have tool for anyone looking to measure ingredients with accuracy and efficiency.', 699.00, 39, 1, 8, 9, 1, '2025-09-08 16:59:40', '2025-10-27 19:31:47'),
(31, 'Ceramic Dinner Plate – 10 inch', 'This elegant 10-inch ceramic dinner plate is crafted from high-quality ceramic, offering a smooth, glossy finish that adds a touch of sophistication to any dining experience. The plate features a durable, chip-resistant design that guarantees long-lasting use, while the wide surface area provides ample space for main dishes and sides. Microwave and dishwasher safe, making it convenient for both everyday meals and special occasions. Its timeless style and functionality make it a perfect addition to any table setting.', 349.00, 50, 0, 15, 10, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(32, '4-Piece Plate Set', 'This durable 4-piece ceramic plate set is perfect for family meals, small gatherings, or casual dining. Made from premium ceramic, the set features four matching plates that showcase a sleek, minimalist design. Built to withstand daily use, these plates are microwave and dishwasher safe for easy reheating and cleaning. Ideal for serving breakfast, lunch, or dinner, this set combines both style and practicality for any meal.', 899.00, 35, 0, 10, 10, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(33, 'Bamboo Fiber Bowl Set', 'Made from eco-friendly bamboo fibers, this bamboo fiber bowl set offers a lightweight, durable, and biodegradable option for those looking to reduce their environmental footprint. The set features a smooth matte finish and is perfect for serving salads, soups, snacks, or rice dishes. BPA-free and easy to clean, these bowls are a sustainable yet stylish solution for everyday dining needs, combining natural elegance with modern functionality.', 599.00, 40, 0, 10, 10, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(34, 'Glass Salad Bowl – 1.5L', 'This elegant 1.5-liter glass salad bowl is made from thick, high-quality glass, ensuring both durability and clarity. The wide opening and smooth finish make mixing and serving your favorite salads or side dishes a breeze. Its crystal-clear construction showcases the vibrant colors of your food, while the bowl resists stains and odors, keeping it looking pristine over time. Dishwasher safe for easy cleaning, this salad bowl is perfect for family meals, parties, or buffets.', 499.00, 45, 0, 12, 10, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(35, 'Rice Bowl with Local Designs', 'This rice bowl features traditional local designs that celebrate Filipino culture, with intricate handcrafted patterns adding an artistic touch to any meal. Made from durable ceramic, it’s perfect for serving rice, soup, or desserts. The smooth glaze finish not only enhances the visual appeal but also makes the bowl easy to clean. Whether for functional dining or as a decorative display piece, this bowl offers both beauty and practicality.', 299.00, 45, 15, 15, 10, 1, '2025-09-08 16:59:40', '2025-10-03 06:17:53'),
(36, 'Double-Walled Glass Mug – 350ml', 'This heat-resistant double-walled glass mug is designed to keep your beverages hot or cold for longer periods. With a 350ml capacity, the double-wall construction prevents condensation and keeps your hands protected from heat. Made from high-quality borosilicate glass, the mug is both lightweight and durable, offering a crystal-clear view of your drink. Whether youre enjoying a hot cup of coffee, tea, or an iced beverage, this mug adds elegance and functionality to your drinkware collection.', 399.00, 53, 2, 15, 11, 1, '2025-09-08 16:59:40', '2025-10-25 16:10:57'),
(37, 'Stainless Steel Travel Mug – 500ml', 'This portable 500ml stainless steel travel mug is perfect for people on the go. The insulated design ensures your drinks stay hot or cold for hours, making it ideal for commuting, travel, or outdoor adventures. The leak-proof lid and anti-spill design provide peace of mind, while the double-walled stainless steel body offers durability, rust resistance, and easy cleaning. Sleek and modern, this travel mug is a must-have for coffee and tea lovers who are always on the move.', 599.00, 150, 0, 12, 11, 1, '2025-09-08 16:59:40', '2025-09-27 13:43:47'),
(38, 'Ceramic Coffee Mug with Lid', 'This elegant ceramic coffee mug combines both style and functionality. The smooth ceramic finish offers a classic look, while the matching lid helps maintain your beverage’s temperature. The wide handle ensures a comfortable grip, and the sturdy construction makes it suitable for both hot and cold beverages. Ideal for coffee, tea, or hot chocolate, this mug is perfect for enjoying your favorite drinks at home or in the office.', 449.00, 45, 0, 12, 11, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(39, '4-Piece Reusable Bamboo Cups', 'These eco-friendly reusable bamboo cups come in a set of four, offering a sustainable alternative to plastic cups. Made from bamboo fiber, they are lightweight, durable, and BPA-free, making them perfect for daily use, outdoor gatherings, or picnics. The smooth finish and natural texture add a touch of style, while being easy to clean and biodegradable. These cups are the perfect way to enjoy your beverages responsibly, combining environmental consciousness with modern practicality.', 699.00, 40, 0, 10, 11, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(40, '1L Glass Pitcher with Lid', 'This 1-liter glass pitcher with lid is perfect for serving water, juice, iced tea, or other beverages. Made from thick, heat-resistant glass, the pitcher is durable and resistant to cracks, while the secure lid helps prevent spills and keeps your drinks fresh for longer. Its clear, minimalist design adds a touch of elegance to any dining table, and the wide handle ensures a steady, comfortable pour. Easy to clean and versatile, it’s an ideal addition to your kitchen for everyday use.', 799.00, 35, 0, 8, 11, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(41, 'Serving Tray with Handles', 'This wooden serving tray with handles is crafted from high-quality, polished wood that combines rustic elegance with functionality. The built-in handles allow for easy carrying of food, drinks, or tableware, making it perfect for serving breakfast in bed, snacks during gatherings, or as a decorative display piece. The smooth finish and natural wood grain add a touch of warmth and sophistication to any setting, making this tray both practical and stylish.', 799.00, 0, 1, 8, 12, 1, '2025-09-08 16:59:40', '2025-11-13 00:22:27'),
(42, 'Gravy Server with Ceramic Base', 'This elegant gravy server features a ceramic base designed to keep sauces warm and easy to pour. The high-quality ceramic base provides stability and insulation, while the sleek spout ensures smooth, drip-free serving. Perfect for gravies, dressings, or sauces during family dinners or special occasions, this server adds a refined touch to your dining table, making it a great choice for both practical use and style.', 699.00, 28, 0, 8, 12, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(43, '3-Piece Serving Spoon Set', 'This 3-piece stainless steel serving spoon set is perfect for serving main dishes, sides, and desserts. Made from high-grade stainless steel, the spoons resist rust, tarnish, and corrosion, ensuring long-lasting durability. The ergonomic handles provide a comfortable grip, while the polished finish adds a professional touch to any dining setup. Whether for daily meals or special events, this set is both elegant and functional, ideal for any occasion.', 499.00, 35, 0, 8, 12, 1, '2025-09-08 16:59:40', '2025-09-08 16:59:40'),
(44, 'Cake Cutter and Server', 'This stylish cake cutter and server set allows you to easily slice and serve cakes, pies, and pastries with precision. Made from sturdy stainless steel, the set ensures clean cuts without crumbling or breaking delicate desserts. The comfortable handle provides excellent control, and the elegant design makes this tool set perfect for birthdays, weddings, and other celebrations. Ideal for anyone who loves to entertain in style.', 399.00, 115, 37, 8, 12, 1, '2025-09-08 16:59:40', '2025-11-13 00:21:42'),
(45, 'Wooden Serving Board', 'Made from premium, food-safe hardwood, this multipurpose wooden serving board serves as both a chopping surface and a stylish platter for cheeses, cold cuts, or appetizers. The smooth finish and natural wood pattern make it a perfect piece for both kitchen prep and table presentation. Durable, easy to clean, and resistant to knife marks, this board is an essential tool for cooking and entertaining, combining beauty with practicality.', 699.00, 99, 26, 5, 12, 1, '2025-09-08 16:59:40', '2025-10-03 06:17:53'),
(81, 'sample', 'sample only', 100.00, 140, 0, 20, 4, 0, '2025-11-12 19:48:32', '2025-11-13 00:22:11'),
(82, 'SAMLE INACTIVE', 'sample', 100.00, 10, 0, 20, 4, 0, '2025-11-12 20:11:22', '2025-11-13 00:22:00');

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
(150, 81, 'products/6914e49012fb2_heroPlate.png', 1, '2025-11-12 19:48:32', '2025-11-12 19:48:32'),
(151, 81, 'products/6914e490147c7_google_logo.webp', 0, '2025-11-12 19:48:32', '2025-11-12 19:48:32'),
(152, 82, 'products/6914e9ea4f51b_heroPlate.png', 1, '2025-11-12 20:11:22', '2025-11-12 20:11:22');

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
(6, 3, 14, 4, 'I like it. Slow delivery though.', '2025-10-03 06:47:15', '2025-10-03 06:47:15'),
(7, 26, 1, 5, 'Very Nice', '2025-10-03 18:15:32', '2025-10-03 18:15:32'),
(8, 17, 26, 5, 'This is very good!', '2025-11-13 00:12:55', '2025-11-13 00:12:55');

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
('0dXW6VoavzuQc2p4QcTd8cBb48L3WocGSJPvVEPp', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYm1EaUFCTEw3V293bERPTHZDM1VGR0JGYmVUWHdLcldMR3VEUHJydCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaWduaW4iO319', 1763174629),
('jhvudLLPD223R1Wk51vjAr4LDVh3K4jGkpx8Hpf4', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:156.0) Gecko/20100101 Firefox/156.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidFVrNElra2dqWGM1SEE0UGI2bDRFODB3cXFEQnpOam9NSTh4cTFVaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaWduaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjU6InN0YXRlIjtzOjQwOiJNNzVOcU02d3hXWHVzSkxHVGczc2RobXZHNnZVSzdzRGlPcnU4dEI1Ijt9', 1790049336),
('qaQpKqend0kPxegVfex6Gwjupw5OT33kg0wSKU3j', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidk0yY0NCMWswb3lsNklxSTN2cEZxNFZmRnR5RkM0N3djREx1M0tiOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC93aXNobGlzdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NToic3RhdGUiO3M6NDA6ImpFekRaZnhWNHdDWHdPeFdadjBvVTdIbnNSMDA5V0JkT1FHUmZSVnMiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1764077916),
('ZV2nTB9Nmjje0dhKfA8LhtsxS7wJjRNodfornxxb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.137.0 Chrome/148.0.7778.280 Electron/42.10.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0dsRVVMcG5wMzJ5cmxiQmJwM1hmZFcybUZ6OWFEcmRXQ1I0NkJwMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790049260);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'currency', 'PHP', '2025-10-24 05:33:11', '2025-10-25 21:04:02'),
(2, 'shipping_rate', '[{\"name\":\"Standard\",\"fee\":150}]', '2025-10-24 05:33:11', '2025-10-24 05:54:18'),
(3, 'payment_methods', '[\"Gcash\"]', '2025-10-24 05:33:11', '2025-10-24 05:55:13'),
(4, 'store_email', 'contact@timplato.shop', '2025-10-24 05:33:11', '2025-11-13 00:28:18');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transactions`
--

CREATE TABLE `stock_transactions` (
  `stock_transaction_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `performed_by` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transactions`
--

INSERT INTO `stock_transactions` (`stock_transaction_id`, `product_id`, `type`, `quantity`, `performed_by`, `created_at`, `updated_at`) VALUES
(1, 5, 'add', 100, 'Ralph Gacusan', '2025-09-27 13:02:07', '2025-09-27 13:02:07'),
(2, 1, 'add', 250, 'Ralph Gacusan', '2025-09-27 13:21:40', '2025-09-27 13:21:40'),
(3, 2, 'add', 100, 'Ralph Gacusan', '2025-09-27 13:30:30', '2025-09-27 13:30:30'),
(4, 37, 'add', 100, 'Ralph Gacusan', '2025-09-27 13:43:47', '2025-09-27 13:43:47'),
(5, 45, 'add', 100, 'Ralph Gacusan', '2025-09-27 22:40:11', '2025-09-27 22:40:11'),
(6, 44, 'add', 100, 'Ralph Gacusan', '2025-10-03 15:20:54', '2025-10-03 15:20:54'),
(7, 5, 'add', 100, 'Ralph Gacusan', '2025-10-03 15:21:32', '2025-10-03 15:21:32'),
(8, 44, 'deduct', 100, 'Ralph Gacusan', '2025-10-10 17:24:54', '2025-10-10 17:24:54'),
(9, 44, 'add', 112, 'Ralph Gacusan', '2025-11-13 00:21:42', '2025-11-13 00:21:42'),
(10, 82, 'deduct', 110, 'Ralph Gacusan', '2025-11-13 00:22:00', '2025-11-13 00:22:00'),
(11, 81, 'add', 20, 'Ralph Gacusan', '2025-11-13 00:22:11', '2025-11-13 00:22:11'),
(12, 41, 'deduct', 29, 'Ralph Gacusan', '2025-11-13 00:22:27', '2025-11-13 00:22:27');

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
(2, 1, 'sample', 'puyat again hahahahaaha', 'open', '2025-09-09 10:41:49', '2025-09-09 10:41:49'),
(3, 14, 'Slow Delivery', 'Slow Delivery', 'open', '2025-10-03 15:02:29', '2025-10-03 15:02:29');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `title`, `image`, `created_at`, `updated_at`) VALUES
(3, 'Costales, Jirah Denisse', 'Chief Executive Officer (CEO)', 'team_members/1763154234_COSTALES.jpg', '2025-11-14 21:03:54', '2025-11-14 21:03:54'),
(4, 'Bayucan, Juztine Miguel Z.', 'Chief Operations Officer (COO)', 'team_members/1763154257_BAYUCAN.jpg', '2025-11-14 21:04:17', '2025-11-14 21:04:17'),
(5, 'Gacusan, Ralph Jayrell', 'Lead Full-Stack Developer', 'team_members/1763154277_GACUSAN.jpg', '2025-11-14 21:04:37', '2025-11-14 21:04:37'),
(6, 'Obillo, Cyriel Alden F.', 'Product & Inventory Manager', 'team_members/1763154740_OBILLO.jpg', '2025-11-14 21:04:56', '2025-11-14 21:12:20'),
(7, 'Saberon Roid Joemar Z.', 'Marketing & Customer Experience Manager', 'team_members/1763154334_SABERON.jpg', '2025-11-14 21:05:34', '2025-11-14 21:05:34');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `profile_picture_path` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL,
  `gender` enum('male','female','prefer_not_to_say') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_logout_at` timestamp NULL DEFAULT NULL,
  `suspended_until` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `phone`, `profile_picture_path`, `role`, `gender`, `date_of_birth`, `last_login_at`, `last_logout_at`, `suspended_until`, `created_at`, `updated_at`) VALUES
(1, 'Eron', 'Alden', 'Bayucan', 'test@only.fans', '$2y$12$w3PTRaxvKFNIWwPXC/rSw.codKOahX/dSVEwXtUugpcf0TVfOLD.a', '09123456789', NULL, 'user', 'male', '2001-09-17', '2025-11-25 13:36:19', '2025-11-12 23:48:20', NULL, '2025-09-08 09:08:20', '2025-11-25 13:36:19'),
(3, 'Ralph', NULL, 'Gacusan', 'gacusan.admin@timplato.shop', '$2y$12$o535E8FX6qKn82VAmjLxmeZdc2ZOe7UNfXKY0yFz8y315vaT8nuBK', '09123456789', NULL, 'admin', 'male', '2001-01-09', '2025-11-15 02:39:48', '2025-11-15 02:43:10', NULL, '2025-09-24 12:16:00', '2025-11-15 02:43:10'),
(4, 'RALPH JAYRELL', NULL, 'GACUSAN', 'qrjegacusan@tip.edu.ph', '$2y$12$c2H8AvE7vIko1SuRp39KvuQh403Nb/5ZPk89sLYlRSyx1ANmMPBMG', '09123456789', NULL, 'user', 'male', NULL, NULL, NULL, '2025-11-16 09:53:10', '2025-09-25 08:25:43', '2025-10-17 09:53:10'),
(6, 'Ralph', NULL, 'Gacusan', 'gacusanralph@gmail.com', '$2y$12$HhZA9iuIPQCLuQTVb2peL.8M5nKZkzjBp0d90.Fkozw3yudL/CC0m', NULL, NULL, 'user', NULL, NULL, NULL, NULL, NULL, '2025-09-27 22:20:21', '2025-09-27 22:20:21'),
(7, 'AVEN DAROLD', NULL, 'BUENA', 'qadbuena@tip.edu.ph', '$2y$12$d42FOPLJHJovebNM7PR6ceEKLHy9ao.JdvxrP/IHgB28YzMtjrt1i', NULL, NULL, 'user', NULL, NULL, NULL, NULL, NULL, '2025-09-28 08:23:05', '2025-09-28 08:23:05'),
(8, 'Denver Axel', NULL, 'Marbida', 'denver0504.marbida@gmail.com', '$2y$12$K4lhV4qAdx09hOCfyB.eyugvr2txJ50TokkgO.uphB70qzUSU1NI6', '09218346260', NULL, 'user', 'male', NULL, NULL, NULL, NULL, '2025-10-01 03:51:42', '2025-10-01 03:53:37'),
(9, 'Karl Andre', NULL, 'Porcal', 'qkaporcal@tip.edu.ph', '$2y$12$dnzPo3ZvqlIiloEifKJer.oWV7bWLIH3vxRYfAHjIVurtFNaNSnry', '09949640695', NULL, 'user', 'male', '2005-01-13', NULL, NULL, NULL, '2025-10-01 07:50:46', '2025-10-01 07:50:46'),
(10, 'Joemar', NULL, 'Saberon', 'joemar.saberon13@gmail.com', '$2y$12$XqwUw3OhZWy7HxKyfvwQn.305P62YkmEG1HbTGDrG7b5XuRP2ptHu', '09765069043', NULL, 'user', 'male', '2005-01-13', NULL, NULL, NULL, '2025-10-01 08:44:37', '2025-10-01 08:48:40'),
(11, 'Genevieve Moriezen', NULL, 'Saberon', 'qgmsaberon@tip.edu.ph', '$2y$12$xYZURbrs/iYvOBgZwmFWw.OdAegVhi6VHkkXlSVXq6BRAXyc3xPiy', '09096064516', NULL, 'user', 'female', '2005-04-05', '2025-10-01 09:22:50', NULL, NULL, '2025-10-01 09:21:42', '2025-10-01 09:22:50'),
(12, 'Joemar', NULL, 'Saberon', 'strbubbakush13@gmail.com', '$2y$12$.x8PoU.mmV47Eib88M7n7uR9sInkbg4EbfQVKsPHyzsM51MzvcYHO', '09765069043', NULL, 'user', 'male', '2005-01-13', NULL, NULL, NULL, '2025-10-01 09:23:11', '2025-10-01 09:24:27'),
(13, 'ROID JOEMAR', NULL, 'SABERON', 'qrjsaberon@tip.edu.ph', '$2y$12$knESRO0Lhs/M2uTxAgfD5eNLihsnna.2B3iJMYpCWgnD8UgwFWnZG', NULL, NULL, 'user', NULL, NULL, NULL, NULL, NULL, '2025-10-01 14:21:50', '2025-10-01 14:21:50'),
(14, 'Denise Jirah', NULL, 'COSTALES', 'qjd-costales@tip.edu.ph', '$2y$12$TYCM.UswnNOO.zpS/7MjqeQG097hg0h.dPpu7Y7RMLtMgi5r7DiC6', '09369287571', NULL, 'user', 'female', '2004-09-11', NULL, NULL, NULL, '2025-10-03 06:35:20', '2025-10-10 17:10:57'),
(15, 'Juztine', NULL, 'Bayucan', 'qjmzbayucan@tip.edu.ph', '$2y$12$ADIqpr0zlFWz2nyHBIjKy.KuDuT/vo90KQR7S3IoT.PKO.wK.4GBC', '098765467832', NULL, 'user', 'male', '2004-09-01', NULL, NULL, NULL, '2025-10-03 17:47:35', '2025-10-03 17:47:35'),
(16, 'CYRIEL ALDEN', 'Alden', 'OBILLO', 'qcaobillo@tip.edu.ph', '$2y$12$.Z4mmpVtyLJesbhk5KQCieDXm8Xc1NVD4MrJvNfhoKW8UWQoIb05y', '09458614673', NULL, 'user', 'male', '2001-01-09', NULL, NULL, '2025-11-21 17:03:03', '2025-10-03 17:48:49', '2025-10-22 17:03:48'),
(22, 'Sample', NULL, 'Only', 'sample@only.fans', '$2y$12$wlkEL5WUw90.lXFgTpyNjOfapT.C.YflwrIb7FqoiYRj6e7X0C96i', '09123456789', NULL, 'user', 'male', '2005-04-06', NULL, '2025-10-22 19:29:22', NULL, '2025-10-22 18:23:14', '2025-10-22 19:35:59'),
(23, 'Jay', NULL, 'Rel', 'jayrell@gmail.com', '$2y$12$DPRL5uxbf0OdND17Rujd7OrryZ6fG0Fa/qqbGrtMhkh3IHl5kJWsm', '09123456789', NULL, 'user', 'male', '2001-04-05', NULL, NULL, NULL, '2025-10-22 18:52:20', '2025-10-22 18:52:20'),
(24, 'Joemar', NULL, 'Saberon', 'saberon.admin@timplato.shop', '$2y$12$mO3Ts53O5Si/JNiapgP7K.50RbaPmL.jCOguhVCgk62nZcEgvqp02', '09123456789', NULL, 'admin', 'male', '2001-01-09', '2025-10-22 19:23:17', '2025-10-22 19:23:33', NULL, '2025-10-22 18:57:26', '2025-10-22 19:23:33'),
(25, 'Migi', NULL, 'Bayucan', 'bayucan.admin@timplato.shop', '$2y$12$vb2L/lu5g4VzVid0liczXeEMEWAWVzBAWElyMnjQxWwguzqvFWLk6', '09123456789', NULL, 'user', 'male', '2001-01-09', NULL, NULL, NULL, '2025-10-22 19:08:38', '2025-10-24 10:19:29'),
(26, 'Ralph Jayrell', 'Escalona', 'Gacusan', 'gacusan@gmail.com', '$2y$12$ySM.VnxRqGBAxgCVaCZYEOZ4Dfj3W4hk7spi9C059fhOedSF4UWKC', '09333804710', NULL, 'user', 'male', '2005-04-14', '2025-11-15 02:19:33', '2025-11-15 02:38:55', NULL, '2025-11-12 23:49:33', '2025-11-15 02:38:55');

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
  `lat` decimal(10,7) DEFAULT NULL,
  `lng` decimal(10,7) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`address_id`, `user_id`, `label`, `address`, `city`, `state`, `zip_code`, `country`, `lat`, `lng`, `is_default`, `created_at`, `updated_at`) VALUES
(3, 4, 'Home', '321 Pasong Tamo East Avenue', 'Quezon City', 'Metro Manila', '2013', 'Philippines', NULL, NULL, 1, '2025-09-25 10:26:13', '2025-09-25 10:26:13'),
(4, 1, 'Home', '123 Happy Street', 'Quezon City', 'Metro Manila', '2013', 'Philippines', NULL, NULL, 1, '2025-09-25 21:56:54', '2025-09-25 21:56:59'),
(5, 8, 'Home', 'Int. M. H. Del Pilar St. Brgy. Kay Buto, Tanay, Rizal', 'Tanay', 'Rizal', '1980', 'Philippines', NULL, NULL, 1, '2025-10-01 03:52:51', '2025-10-01 03:52:51'),
(6, 10, 'Home', '270 Narra Street', 'Rodriguez', 'Rizal', '1860', 'Philippines', NULL, NULL, 1, '2025-10-01 08:48:07', '2025-10-01 08:48:07'),
(7, 12, 'Home', '270 Narra Street', 'Rodriguez', 'Rizal', '1860', 'Philippines', NULL, NULL, 1, '2025-10-01 09:24:02', '2025-10-01 09:24:02'),
(8, 14, 'Home', 'One Spatial Condominium Victoria Bldg.', 'Pasig City', 'NCR', '1610', 'Philippines', NULL, NULL, 1, '2025-10-03 06:39:29', '2025-10-03 06:39:40'),
(9, 16, 'Home', 'luzon avenue haahhahaha', 'quezon city', 'metro manila', '1154', 'Philippines', NULL, NULL, 1, '2025-10-10 16:34:40', '2025-10-22 17:35:13'),
(12, 22, 'Home', 'Pasong Tamo', 'Quezon City', 'Metro Manila', '2013', 'Philippines', NULL, NULL, 1, '2025-10-22 18:23:35', '2025-10-22 18:23:35'),
(13, 1, 'Home', 'Sample', 'Sample', 'Sample', '1234', 'Sample', NULL, NULL, 0, '2025-11-04 19:14:00', '2025-11-04 19:14:00'),
(14, 26, 'Home', '27 Sample Street', 'Quezon City', 'Metro Manila', '2013', 'Philippines', NULL, NULL, 1, '2025-11-12 23:52:08', '2025-11-12 23:52:08');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `discount_type` enum('fixed','percentage') NOT NULL,
  `discount_value` decimal(8,2) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `discount_type`, `discount_value`, `description`, `created_at`, `updated_at`) VALUES
(6, 'ALDEN50', 'fixed', 50.00, '₱50 off total purchase', '2025-10-25 19:42:26', '2025-10-25 19:42:26'),
(7, 'DEENICE10P', 'percentage', 0.10, '10% off total + shipping', '2025-10-25 19:42:41', '2025-10-25 19:42:41'),
(8, 'JOMSPOGI100', 'fixed', 100.00, '₱100 off total purchase', '2025-10-25 19:42:54', '2025-10-25 19:42:54'),
(9, 'BAYUCAN20P', 'percentage', 0.20, '20% off total + shipping', '2025-10-25 19:43:16', '2025-10-25 19:43:16'),
(10, 'GACUSAN30', 'percentage', 0.30, '30% off total + shipping', '2025-10-25 19:43:30', '2025-10-25 19:43:30'),
(19, 'SAMPLE10P', 'percentage', 0.10, '10% off total + shipping', '2025-10-27 11:30:59', '2025-10-27 11:30:59'),
(20, 'WELCOME100', 'fixed', 100.00, 'Applies to all orders products.', '2025-10-27 11:34:17', '2025-10-27 11:34:17');

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
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`wishlist_id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(14, 4, 1, '2025-10-03 17:32:41', '2025-10-03 17:32:41'),
(15, 4, 5, '2025-10-03 17:32:43', '2025-10-03 17:32:43'),
(16, 4, 6, '2025-10-03 17:32:45', '2025-10-03 17:32:45'),
(17, 4, 8, '2025-10-03 17:32:46', '2025-10-03 17:32:46'),
(18, 14, 3, '2025-10-03 17:45:56', '2025-10-03 17:45:56'),
(19, 14, 4, '2025-10-03 17:46:26', '2025-10-03 17:46:26'),
(20, 14, 2, '2025-10-03 18:18:08', '2025-10-03 18:18:08'),
(21, 26, 4, '2025-11-12 23:56:59', '2025-11-12 23:56:59'),
(22, 26, 5, '2025-11-12 23:57:01', '2025-11-12 23:57:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_logs_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `banners_page_id_foreign` (`page_id`);

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
-- Indexes for table `delivery_methods`
--
ALTER TABLE `delivery_methods`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `notification_settings_key_unique` (`key`);

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
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD PRIMARY KEY (`stock_transaction_id`),
  ADD KEY `stock_transactions_product_id_foreign` (`product_id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `support_tickets_user_id_foreign` (`user_id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vouchers_code_unique` (`code`);

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
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

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
-- AUTO_INCREMENT for table `delivery_methods`
--
ALTER TABLE `delivery_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `notification_settings`
--
ALTER TABLE `notification_settings`
  MODIFY `setting_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `history_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `riders`
--
ALTER TABLE `riders`
  MODIFY `rider_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  MODIFY `stock_transaction_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `ticket_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `address_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `wishlist_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD CONSTRAINT `admin_logs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `banners`
--
ALTER TABLE `banners`
  ADD CONSTRAINT `banners_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

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
-- Constraints for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD CONSTRAINT `stock_transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;

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
