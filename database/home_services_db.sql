-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2026 at 07:07 PM
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
-- Database: `home_services_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_no` varchar(255) NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `address` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(255) NOT NULL DEFAULT 'unpaid',
  `remarks` text DEFAULT NULL,
  `cancelled_by` bigint(20) UNSIGNED DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancellation_reason` text DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `booking_no`, `customer_id`, `provider_id`, `service_id`, `booking_date`, `booking_time`, `address`, `amount`, `status`, `payment_status`, `remarks`, `cancelled_by`, `cancelled_at`, `cancellation_reason`, `completed_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'BK-UXZHU5XR', 10, 9, 2, '2026-08-03', '06:41:00', 'Voluptatem recusanda', 98.00, 'completed', 'paid', 'Tempore veritatis c', NULL, NULL, NULL, '2026-08-04 08:53:54', '2026-08-04 02:48:50', '2026-08-04 08:53:54', NULL),
(2, 'BK-XCDYDEIC', 10, 9, 1, '2029-08-03', '15:56:00', 'Commodi sit aut dolo', 88.00, 'completed', 'paid', 'Soluta quaerat quis ', NULL, NULL, NULL, '2026-08-04 08:43:50', '2026-08-04 07:59:42', '2026-08-04 08:43:50', NULL),
(3, 'BK-5APTFL16', 10, 9, 2, '2028-07-26', '16:44:00', 'Animi sed voluptate', 98.00, 'completed', 'unpaid', 'Ipsam molestiae veli', NULL, NULL, NULL, '2026-08-04 08:43:40', '2026-08-04 08:37:24', '2026-08-04 08:43:40', NULL);

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
-- Table structure for table `contact_queries`
--

CREATE TABLE `contact_queries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_queries`
--

INSERT INTO `contact_queries` (`id`, `name`, `email`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ali', 'ali@gmail.com', 'to buy services ', 'this is wounderfull website ', 'unread', '2026-08-04 09:07:12', '2026-08-04 09:07:12'),
(2, 'Tanzeela admin', 'tanzeelazahid84@gmail.com', 'to buy services ', 'this is wonderful website', 'unread', '2026-08-04 09:41:47', '2026-08-04 09:41:47'),
(3, 'Tanzeela admin', 'tanzeelazahid84@gmail.com', 'to buy services ', 'this is wounder full websites ', 'unread', '2026-08-04 09:44:25', '2026-08-04 09:44:25'),
(4, 'tanzeela admin', 'tanzeelazahid84@gmail.com', 'to buy services ', 'this wounder full website ', 'unread', '2026-08-04 09:47:32', '2026-08-04 09:47:32'),
(5, 'tanzeela', 'tanzeelazahid84@gmail.com', 'to buy services ', 'this is wounder full website ', 'replied', '2026-08-04 09:58:54', '2026-08-05 11:03:51'),
(6, 'bushra ', 'bushrafareed738@gmail.com', ' friendship day ...........', 'this is my friend ', 'unread', '2026-08-04 10:04:45', '2026-08-04 10:04:45'),
(7, 'bushra ', 'murtasimnoornoor@gmail.com', ' friendship day ...........', 'she is my friends ', 'unread', '2026-08-04 10:06:42', '2026-08-04 10:06:42'),
(8, 'ali', 'tanzeelazahid84@gmail.com', 'frtttttttttttttttttttttttttttttttt', 'rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr', 'replied', '2026-08-04 10:07:38', '2026-08-05 11:07:01'),
(9, 'bushra', 'bushrafareed738@gmail.com', 'friendship day', 'she is my friend. ', 'replied', '2026-08-04 10:17:32', '2026-08-05 16:06:34'),
(10, 'sadia', 'altafsadia460@gmail.com', 'friendship day', 'she is my friend', 'replied', '2026-08-04 10:20:02', '2026-08-05 11:03:20');

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
(4, '2026_07_17_075810_create_service_categories_table', 2),
(5, '2026_07_21_061022_create_subcategories_table', 3),
(6, '2026_07_21_063007_create_service_areas_table', 4),
(7, '2026_07_21_063717_create_services_table', 5),
(8, '2026_07_22_081704_create_provider_services_table', 6),
(9, '2026_07_22_211440_create_provider_availabilities_table', 7),
(10, '2026_08_03_134708_create_bookings_table', 8),
(11, '2026_08_03_202410_create_payments_table', 9),
(12, '2026_08_04_012316_create_reviews_table', 10),
(13, '2026_08_04_020023_create_contact_queries_table', 11);

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
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'cash',
  `transaction_id` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `customer_id`, `amount`, `payment_method`, `transaction_id`, `status`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 2, 10, 88.00, 'stripe', 'pi_3U0fD20BvRHCATb60GBR5Qib', 'completed', '2026-08-04 08:05:55', '2026-08-04 08:05:55', '2026-08-04 08:05:55'),
(2, 1, 10, 98.00, 'stripe', 'pi_3U0fQ30BvRHCATb60juxCvsp', 'completed', '2026-08-04 08:19:21', '2026-08-04 08:19:21', '2026-08-04 08:19:21');

-- --------------------------------------------------------

--
-- Table structure for table `provider_availabilities`
--

CREATE TABLE `provider_availabilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provider_availabilities`
--

INSERT INTO `provider_availabilities` (`id`, `provider_id`, `day`, `start_time`, `end_time`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 'Tuesday', '18:22:00', '19:08:00', 'active', '2026-07-23 04:19:44', '2026-07-23 04:20:19'),
(2, 9, 'Friday', '06:42:00', '08:45:00', 'active', '2026-08-03 20:39:31', '2026-08-03 20:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `provider_services`
--

CREATE TABLE `provider_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `provider_services`
--

INSERT INTO `provider_services` (`id`, `provider_id`, `service_id`, `price`, `duration`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 1, 88.00, '6 hour ', 'active', '2026-07-22 18:26:54', '2026-07-22 18:27:16'),
(3, 9, 5, 47.00, 'Magni deserunt labor', 'active', '2026-07-22 22:03:21', '2026-07-22 22:03:21'),
(4, 9, 2, 98.00, '5 hour', 'active', '2026-07-22 22:03:30', '2026-07-22 22:03:49'),
(5, 9, 4, 8980.00, 'Placeat neque possi', 'active', '2026-07-22 22:04:23', '2026-08-03 20:38:47');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `comment` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `booking_id`, `customer_id`, `provider_id`, `service_id`, `rating`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 10, 9, 2, 4, ' doing good job and fulfill their responsibilities', 'active', '2026-08-04 08:52:27', '2026-08-04 08:52:27');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category_id`, `subcategory_id`, `service_name`, `slug`, `description`, `price`, `duration`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 9, 4, 'Aliquid excepturi mi', 'aliquid-excepturi-mi', 'Adipisci quo adipisc', 96.00, 'Autem dicta impedit', 'services/1uNDT447Hd96lvYQIGEqjbcK9FWYUE6s7nx1QNRl.jpg', 'active', '2026-07-22 13:48:36', '2026-07-22 13:48:58'),
(2, 9, 4, 'Et vero incididunt e', 'et-vero-incididunt-e', 'In nisi sit anim sap', 2.00, 'Sit ex qui itaque c', 'services/gfvLIRRsQblKR9KHwzFxwMxcStUOuXt2PDQ5XdiT.jpg', 'active', '2026-07-22 13:49:56', '2026-07-22 22:02:18'),
(4, 3, 5, 'Inventore vitae faci', 'inventore-vitae-faci', 'Voluptatem Ut repre', 98.00, 'Impedit saepe paria', 'services/tQ2BtSI4LCqHLAYdDz62eUxWCNhUOYF54xHit6sS.png', 'active', '2026-07-22 21:39:52', '2026-07-22 21:39:52'),
(5, 5, 7, 'Voluptate vitae amet', 'voluptate-vitae-amet', 'A aut ea et commodi ', 17.00, 'Cupidatat culpa aliq', 'services/VO9x5KadIqbFgaQCJjwHpvOZB2IeQYDfs2VhVhl2.jpg', 'active', '2026-07-22 21:41:34', '2026-07-22 22:02:10');

-- --------------------------------------------------------

--
-- Table structure for table `service_areas`
--

CREATE TABLE `service_areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_areas`
--

INSERT INTO `service_areas` (`id`, `city_name`, `state`, `zipcode`, `status`, `created_at`, `updated_at`) VALUES
(2, 'karachi', 'pakistan ', 'Voluptas corrupti d', 'active', '2026-07-21 13:34:37', '2026-07-21 13:34:37');

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `category_name`, `slug`, `description`, `image`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Dolore aut dolores s', 'dolore-aut-dolores-s', 'Dolore consectetgggggur ', 'categories/oirPRsth7rHRRZi3EcAvjM2WnSoVYd0DtItPKp5f.jpg', 'active', '2026-07-18 22:16:25', '2026-07-19 01:32:00'),
(5, 'plzzzzzzz', 'plzzzzzzz', 'Ca l', 'categories/9qlDsWZVMVQ1tbPFAuu3acplQlTDyFmPo6Swz98c.jpg', 'active', '2026-07-18 22:17:40', '2026-07-19 01:48:25'),
(6, 'Nobis duis quo incid', 'nobis-duis-quo-incid', 'Incidunt enim culpa', 'categories/TkV2IiDztivNSDje5T7rqkZW6DO8EdPtQiNPVMBt.jpg', 'active', '2026-07-18 23:22:49', '2026-07-19 01:07:55'),
(7, 'Fuga Et aliquam aut', 'fuga-et-aliquam-aut', 'Sint aliquip modi ad', 'categories/xFi5VNhD7K6PCJHbB3PBKpLfuuhFBEbsfiU2vXOS.jpg', 'active', '2026-07-18 23:24:46', '2026-07-18 23:48:44'),
(8, 'Sunt eveniet conse', 'sunt-eveniet-conse', 'Delectus soluta odi', 'categories/L2oxHIXW9oW43uIm1ge45LLGl67jKZOrQrovwSRy.png', 'active', '2026-07-18 23:48:26', '2026-07-19 01:07:42'),
(9, 'Quos omnis quia sit ', 'quos-omnis-quia-sit', 'bbbbbbb', 'categories/wzmiexqNqhF31zGgRbOjTrcnnZF5VBW3HiKYIUka.png', 'active', '2026-07-18 23:52:12', '2026-07-19 01:05:05'),
(10, 'Illo lorem error mai', 'illo-lorem-error-mai', 'Ipsum enim omnis di', 'categories/xoTH9oPgcgRmwr9ScKihLrWozGVq0S3QdgWh5dbH.png', 'active', '2026-07-18 23:58:15', '2026-07-19 01:32:58'),
(11, 'yyyy', 'yyyy', 'nnnnnnnn', 'categories/2Br1TBg23S5LvLuSLHi0OVu4VaMZURyL96eFfieA.jpg', 'active', '2026-07-19 01:00:05', '2026-07-19 01:00:05'),
(12, 'Sunt ut fugiat sed ', 'sunt-ut-fugiat-sed', 'Dolorem dolohhhhhhhhhh', 'categories/O2JFIabUaoTAEqK31tavQOJHB8kFN4J9ELSp7RaP.png', 'active', '2026-07-19 01:30:15', '2026-07-19 01:33:13');

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
('3guAM9PPbCWbtp2cu1tq522GjdBFt9F7ZMy3Vy1T', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiWGxWa29ucFFlczNjcjFFN2VWbGlpQXFnSTIwRFl2ajJka0RxckRJZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6NDM6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9jb250YWN0LXF1ZXJpZXMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO30=', 1785985584),
('7ZS9bQU55sfuJuLEcb9OjDy0dGcWE13ukbtBecnq', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36 Edg/151.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMnV3Q1NiSXhObjlDekgzOVplbFp0U1N5b0o4ZFlFdnI1anBBYW1sWSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2FkbWluL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjMzOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvbXktYm9va2luZ3MiO3M6NToicm91dGUiO3M6MjA6ImN1c3RvbWVyLm15LWJvb2tpbmdzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA7fQ==', 1785926688),
('m7tUXGjS9lobkYl3WqKJWY87vKZWeA40G6SXs8Gg', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOXhQUDNNZGVGeEFjOTVJcUhESmpmbkJrUnIzZXdOaFJoeG1wbGVldiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7czoxODoiY3VzdG9tZXIuZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTA7fQ==', 1785927082);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `subcategory_name`, `slug`, `description`, `image`, `status`, `created_at`, `updated_at`) VALUES
(3, 8, 'Hic rem temporibus d', 'hic-rem-temporibus-d', 'Excepteur adipisci s', 'subcategories/uFIaAaxAyCpxvWACebafHiJWU9ICeeRntEB8dYcy.png', 'active', '2026-07-21 13:21:32', '2026-07-21 13:21:32'),
(4, 9, 'Tempore minim corpo', 'tempore-minim-corpo', 'Ea exercitation omni', 'subcategories/IG4ZjyeNk6GvMRbR6xw3KUX3DUGRx05nZ2vTV4sI.jpg', 'active', '2026-07-21 13:42:00', '2026-07-21 13:42:00'),
(5, 3, 'Eos aut sit provide', 'eos-aut-sit-provide', 'Quibusdam voluptatem', 'subcategories/EnPGi6BDXlDkMegRYPj87R5vTxNI7JyjVo0LoNDE.png', 'active', '2026-07-22 18:29:55', '2026-07-22 18:29:55'),
(6, 8, 'Quisquam optio mole', 'quisquam-optio-mole', 'Nisi aperiam cillum ', 'subcategories/NpMfNVJlOqubiluETNo2jTRq3fNpEEKerUJzD3R2.jpg', 'active', '2026-07-22 18:30:19', '2026-07-22 18:30:19'),
(7, 5, 'Aut sint excepteur n', 'aut-sint-excepteur-n', 'Eum harum saepe volu', 'subcategories/7jAwVQuXieFP5UzpcqFCDhdIOdx841HqDBEOdERf.jpg', 'active', '2026-07-22 21:41:04', '2026-07-22 21:41:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `address`, `city`, `profile_image`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'admin', 'admin@gmail.com', NULL, '$2y$12$a0oTi6VjCFBEqeMM.MjXB..uWKlF0BN4XMvJKXx1p6zDv5esFznA2', 'admin', 'Perferendis vitae su', 'Saepe non porro eu m', 'Perferendis in et hi', NULL, 'active', NULL, '2026-07-17 11:42:31', '2026-07-17 14:11:40'),
(4, 'Magna reiciendis sun', 'qozeta@mailinator.com', NULL, '$2y$12$mv48bCo.LzBk8cDSebsp8uIq/rwfsAQM57USH8C9pYZmo5OZW7dne', 'provider', 'Corrupti adipisicin', 'Aspernatur voluptate', 'Proident error prae', NULL, 'suspended', NULL, '2026-07-17 14:14:54', '2026-07-17 14:14:54'),
(5, 'ali', 'ali@gmail.com', NULL, '$2y$12$ZD2xWDOKYFq8p3DzQw.TzOQCo5vCi3g6Y2pMaVnf.2TABHJ8wECcO', 'admin', 'Voluptas adipisicing', 'Velit doloribus exce', 'Deserunt ad ut velit', NULL, 'active', NULL, '2026-07-17 14:42:11', '2026-07-17 14:42:11'),
(6, 'fozia', 'fozia@gmail.com', NULL, '$2y$12$AsPtzUlkEqyBWRHTQJfg9ejLlZTjiVBEglT3l4g/OfpV4EU2MuYuq', 'provider', 'Dolores voluptate ut', 'Quia ab reprehenderi', 'Ipsum veritatis Nam', NULL, 'suspended', NULL, '2026-07-17 14:43:14', '2026-07-22 18:20:09'),
(7, 'user', 'user@gmail.com', NULL, '$2y$12$KCRvvveqixbFizwaaXiwFeQJMASYSSPEJKAq4IvSEBlfepkjlX.qu', 'customer', 'Illo laboris tempore', 'Quod consectetur asp', 'Sit quia a iste esse', NULL, 'active', NULL, '2026-07-17 14:51:02', '2026-08-03 21:01:28'),
(8, 'Consectetur vel qui', 'tanuqudyfi@mailinator.com', NULL, '$2y$12$aTrCfrb7KXi9g9RJdGyklOiC2RvsDVTD6B/qVQGRMW7oEdnXnHE9W', 'provider', '34567890', 'Neque aliquid proide', 'Quo reiciendis cupid', NULL, 'suspended', NULL, '2026-07-22 18:23:28', '2026-07-22 18:23:28'),
(9, 'arfa', 'arfa@gmail.com', NULL, '$2y$12$lhSDJl8UMuzpaBLIcglGy.olWIz4XJkVJEGLjndysd7/zWz1PmbiW', 'provider', '1234567890', 'sdfghjkl', 'cjghm', NULL, 'active', NULL, '2026-07-22 18:24:22', '2026-07-22 18:24:22'),
(10, 'customer', 'customer@gmail.com', NULL, '$2y$12$FXX02L8MMN/shBwsoMgC0uFWH1OZfxl8bEZuinmAzCIRukmx6vD7W', 'customer', '043758939875', 'fsd block 1', 'karachi', NULL, 'active', NULL, '2026-08-03 21:06:21', '2026-08-03 21:06:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_booking_no_unique` (`booking_no`),
  ADD KEY `bookings_customer_id_foreign` (`customer_id`),
  ADD KEY `bookings_provider_id_foreign` (`provider_id`),
  ADD KEY `bookings_service_id_foreign` (`service_id`),
  ADD KEY `bookings_cancelled_by_foreign` (`cancelled_by`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `contact_queries`
--
ALTER TABLE `contact_queries`
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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_booking_id_foreign` (`booking_id`),
  ADD KEY `payments_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `provider_availabilities`
--
ALTER TABLE `provider_availabilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provider_availabilities_provider_id_day_unique` (`provider_id`,`day`);

--
-- Indexes for table `provider_services`
--
ALTER TABLE `provider_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `provider_services_provider_id_service_id_unique` (`provider_id`,`service_id`),
  ADD KEY `provider_services_service_id_foreign` (`service_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_booking_id_unique` (`booking_id`),
  ADD KEY `reviews_customer_id_foreign` (`customer_id`),
  ADD KEY `reviews_provider_id_foreign` (`provider_id`),
  ADD KEY `reviews_service_id_foreign` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_slug_unique` (`slug`),
  ADD KEY `services_category_id_foreign` (`category_id`),
  ADD KEY `services_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `service_areas`
--
ALTER TABLE `service_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_categories_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subcategories_slug_unique` (`slug`),
  ADD KEY `subcategories_category_id_foreign` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_queries`
--
ALTER TABLE `contact_queries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `provider_availabilities`
--
ALTER TABLE `provider_availabilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `provider_services`
--
ALTER TABLE `provider_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `service_areas`
--
ALTER TABLE `service_areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_cancelled_by_foreign` FOREIGN KEY (`cancelled_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `provider_availabilities`
--
ALTER TABLE `provider_availabilities`
  ADD CONSTRAINT `provider_availabilities_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `provider_services`
--
ALTER TABLE `provider_services`
  ADD CONSTRAINT `provider_services_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `provider_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
