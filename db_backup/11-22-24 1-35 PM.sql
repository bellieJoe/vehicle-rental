-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 06:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `irent_hub_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_rates`
--

CREATE TABLE `additional_rates` (
  `vehicle_id` bigint(20) NOT NULL,
  `location` varchar(255) NOT NULL,
  `rate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `booking_type` enum('Package','Vehicle') NOT NULL DEFAULT 'Vehicle',
  `package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `computed_price` double(8,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `cancelled_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `transaction_number`, `user_id`, `contact_number`, `name`, `booking_type`, `package_id`, `vehicle_id`, `computed_price`, `status`, `cancelled_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '17320267563', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 1, 5600.00, 'To Pay', NULL, NULL, '2024-11-19 14:32:36', '2024-11-19 14:35:40'),
(3, '17320288873', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 1, 5600.00, 'To Pay', NULL, NULL, '2024-11-19 15:08:07', '2024-11-19 15:14:11'),
(4, '17320306683', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 1, 4000.00, 'To Pay', NULL, NULL, '2024-11-19 15:37:48', '2024-11-19 15:38:06'),
(5, '17321594283', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 1, 2000.00, 'Booked', NULL, NULL, '2024-11-21 03:23:48', '2024-11-21 06:58:04'),
(6, '17321726263', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 1, 4000.00, 'Cancelled', NULL, NULL, '2024-11-21 07:03:46', '2024-11-21 07:29:15'),
(7, '17321742893', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 1, 2000.00, 'To Pay', NULL, NULL, '2024-11-21 07:31:29', '2024-11-21 07:31:51'),
(8, '17321743783', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 1, 2000.00, 'Booked', NULL, NULL, '2024-11-21 07:32:58', '2024-11-21 08:02:51'),
(9, '17321875153', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 1, 4000.00, 'Pending', NULL, NULL, '2024-11-21 11:11:55', '2024-11-21 11:11:55'),
(10, '17321878583', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 1, 4000.00, 'Pending', NULL, NULL, '2024-11-21 11:17:38', '2024-11-21 11:17:38'),
(11, '17321878813', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 1, 4000.00, 'Booked', NULL, NULL, '2024-11-21 11:18:01', '2024-11-21 16:39:46'),
(12, '17322087503', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 1, 10000.00, 'Booked', NULL, NULL, '2024-11-21 17:05:50', '2024-11-21 17:09:59');

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `start_datetime` datetime NOT NULL,
  `number_of_days` int(11) NOT NULL,
  `with_driver` tinyint(1) NOT NULL,
  `pickup_location` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`id`, `booking_id`, `start_datetime`, `number_of_days`, `with_driver`, `pickup_location`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-11-21 22:29:00', 2, 1, 'Poras Boac', NULL, '2024-11-19 14:32:36', '2024-11-19 14:32:36'),
(3, 3, '2024-11-28 23:07:00', 2, 1, 'Poras Boac', NULL, '2024-11-19 15:08:07', '2024-11-19 15:08:07'),
(4, 4, '2024-12-02 23:37:00', 2, 0, NULL, NULL, '2024-11-19 15:37:48', '2024-11-19 15:37:48'),
(5, 5, '2024-11-29 11:23:00', 1, 0, NULL, NULL, '2024-11-21 03:23:48', '2024-11-21 03:23:48'),
(6, 6, '2024-11-26 15:03:00', 2, 0, NULL, NULL, '2024-11-21 07:03:47', '2024-11-21 07:03:47'),
(7, 7, '2024-11-22 17:30:00', 1, 0, NULL, NULL, '2024-11-21 07:31:29', '2024-11-21 07:31:29'),
(8, 8, '2024-11-23 15:32:00', 1, 0, NULL, NULL, '2024-11-21 07:32:58', '2024-11-21 07:32:58'),
(9, 9, '2024-11-23 15:09:00', 2, 0, NULL, NULL, '2024-11-21 11:11:55', '2024-11-21 11:11:55'),
(10, 10, '2024-12-07 19:17:00', 2, 0, NULL, NULL, '2024-11-21 11:17:38', '2024-11-21 11:17:38'),
(11, 11, '2024-12-07 19:17:00', 2, 0, NULL, NULL, '2024-11-21 11:18:01', '2024-11-21 11:18:01'),
(12, 12, '2024-12-16 01:04:00', 5, 0, NULL, NULL, '2024-11-21 17:05:50', '2024-11-21 17:05:50');

-- --------------------------------------------------------

--
-- Table structure for table `booking_logs`
--

CREATE TABLE `booking_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `log` varchar(5000) NOT NULL,
  `reason` varchar(5000) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_logs`
--

INSERT INTO `booking_logs` (`id`, `booking_id`, `log`, `reason`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-19 14:32:36', '2024-11-19 14:32:36'),
(2, 1, 'Booking was approved by Saul Goodman', NULL, NULL, '2024-11-19 14:35:40', '2024-11-19 14:35:40'),
(4, 3, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-19 15:08:07', '2024-11-19 15:08:07'),
(5, 3, 'Booking was approved by Saul Goodman', NULL, NULL, '2024-11-19 15:14:11', '2024-11-19 15:14:11'),
(6, 4, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-19 15:37:48', '2024-11-19 15:37:48'),
(7, 4, 'Booking was approved by Saul Goodman', NULL, NULL, '2024-11-19 15:38:06', '2024-11-19 15:38:06'),
(8, 5, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-21 03:23:48', '2024-11-21 03:23:48'),
(9, 5, 'Booking was approved by Saul Goodman', NULL, NULL, '2024-11-21 03:29:14', '2024-11-21 03:29:14'),
(10, 6, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-21 07:03:47', '2024-11-21 07:03:47'),
(11, 6, 'Booking was approved by Saul Goodman', NULL, NULL, '2024-11-21 07:04:09', '2024-11-21 07:04:09'),
(12, 6, 'Steve Rogers Cancelled the booking', 'Unable to pay', NULL, '2024-11-21 07:29:15', '2024-11-21 07:29:15'),
(13, 7, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-21 07:31:29', '2024-11-21 07:31:29'),
(14, 7, 'Booking was approved by Saul Goodman', NULL, NULL, '2024-11-21 07:31:51', '2024-11-21 07:31:51'),
(15, 8, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-21 07:32:58', '2024-11-21 07:32:58'),
(16, 8, 'Booking was approved by Saul Goodman', NULL, NULL, '2024-11-21 07:35:16', '2024-11-21 07:35:16'),
(17, 9, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-21 11:11:55', '2024-11-21 11:11:55'),
(18, 10, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-21 11:17:38', '2024-11-21 11:17:38'),
(19, 11, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-21 11:18:01', '2024-11-21 11:18:01'),
(20, 11, 'Booking was approved by Saul Goodman', NULL, NULL, '2024-11-21 16:10:45', '2024-11-21 16:10:45'),
(21, 12, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-21 17:05:50', '2024-11-21 17:05:50'),
(22, 12, 'Booking was approved by Saul Goodman', NULL, NULL, '2024-11-21 17:08:09', '2024-11-21 17:08:09');

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
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organisation_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(10000) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `organisation_id`, `title`, `image`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'test edited', '1732074796.jpg', 'asdasdad editer', NULL, '2024-11-20 03:33:41', '2024-11-20 03:53:16');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `name`, `email`, `message`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Saul Goodman', 'dreamfavor@hulas.co', 'asd', NULL, '2024-11-20 06:18:14', '2024-11-20 06:18:14'),
(2, 'Bellie Joe Jandusay', 'jandusayjoe14@gmail.com', 'suppp yoww', NULL, '2024-11-20 15:32:03', '2024-11-20 15:32:03');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_16_103716_create_vehicle_categories_table', 1),
(6, '2024_11_16_113148_create_organisations_table', 1),
(7, '2024_11_17_095727_create_vehicles_table', 1),
(8, '2024_11_17_163743_create_packages_table', 1),
(9, '2024_11_18_050412_create_bookings_table', 1),
(10, '2024_11_18_054636_create_booking_logs_table', 1),
(11, '2024_11_18_093746_create_booking_details_table', 1),
(12, '2024_11_19_160037_create_payments_table', 1),
(13, '2024_11_19_183616_create_payment_logs_table', 1),
(14, '2024_11_19_201104_create_refunds_table', 1),
(15, '2024_11_20_104312_create_galleries_table', 2),
(16, '2024_11_20_115926_create_inquiries_table', 3),
(17, '2024_11_20_130033_create_replies_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `organisations`
--

CREATE TABLE `organisations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `org_name` varchar(255) NOT NULL,
  `gcash_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `stripe_secret_key` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organisations`
--

INSERT INTO `organisations` (`id`, `user_id`, `org_name`, `gcash_number`, `address`, `stripe_secret_key`, `created_at`, `updated_at`) VALUES
(1, 2, 'Dream Favor', '0949313146', 'asd', 'sk_test_51QNZYKKKTnnzOx7OGuhBYrNtoxmjL01TCrBG8x0HTqgPu0NEt7oTVIUpLnCjuAyVi8SROylkP1xI3GWdr96v13Pq009Geg8akC', '2024-11-19 13:59:46', '2024-11-19 13:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `minimum_pax` int(11) NOT NULL,
  `price_per_person` double DEFAULT NULL,
  `package_duration` int(11) NOT NULL,
  `package_description` text NOT NULL,
  `package_image` varchar(255) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 0,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `user_id`, `package_name`, `minimum_pax`, `price_per_person`, `package_duration`, `package_description`, `package_image`, `is_available`, `vehicle_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'Road Trip to Torrijos Poctoy White Beach', 10, 2059, 1, '<p>DAY TOUR PACKAGE FOR ONLY PHP 2059</p>', '1732251282.jpg', 0, NULL, NULL, '2024-11-22 04:54:42', '2024-11-22 04:54:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('steverogers@hulas.co', '$2y$10$Pd0NfmDajxfc2UtFFZ7n4eomP9cGsWulf8fr.mBY4f8Soy.9kAb4y', '2024-11-20 14:54:33');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double(8,2) NOT NULL,
  `is_downpayment` tinyint(4) NOT NULL DEFAULT 0,
  `payment_status` varchar(255) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_exp` datetime NOT NULL,
  `attempts` int(11) NOT NULL DEFAULT 0,
  `gcash_transaction_no` varchar(255) DEFAULT NULL,
  `date_paid` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `amount`, `is_downpayment`, `payment_status`, `payment_method`, `payment_exp`, `attempts`, `gcash_transaction_no`, `date_paid`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 3, 2800.00, 1, 'Failed', NULL, '2024-11-20 23:08:07', 0, NULL, '2024-11-19 23:46:37', NULL, '2024-11-19 15:08:07', '2024-11-20 15:17:50'),
(3, 3, 2800.00, 0, 'Pending', NULL, '2024-11-28 23:07:00', 0, NULL, NULL, NULL, '2024-11-19 15:08:07', '2024-11-19 15:08:07'),
(4, 4, 4000.00, 0, 'Failed', NULL, '2024-11-20 23:37:48', 0, NULL, NULL, NULL, '2024-11-19 15:37:48', '2024-11-21 03:22:46'),
(5, 5, 2000.00, 0, 'Paid', 'GCash', '2024-11-22 11:23:48', 1, 'adsad', NULL, NULL, '2024-11-21 03:23:48', '2024-11-21 06:58:00'),
(6, 6, 4000.00, 0, 'Payment Invalid', 'GCash', '2024-11-22 15:03:47', 3, 'asdasd', NULL, NULL, '2024-11-21 07:03:47', '2024-11-21 07:18:07'),
(7, 7, 2000.00, 0, 'Pending', NULL, '2024-11-22 15:31:29', 0, NULL, NULL, NULL, '2024-11-21 07:31:29', '2024-11-21 07:31:29'),
(8, 8, 1000.00, 1, 'Paid', 'GCash', '2024-11-22 15:32:58', 2, 'asd', '2024-11-21 16:02:48', NULL, '2024-11-21 07:32:58', '2024-11-21 08:02:48'),
(9, 8, 1000.00, 0, 'Paid', 'Cash', '2024-11-23 15:32:00', 0, NULL, '2024-11-21 17:55:24', NULL, '2024-11-21 07:32:58', '2024-11-21 09:55:24'),
(10, 9, 4000.00, 0, 'Pending', NULL, '2024-11-22 19:11:55', 0, NULL, NULL, NULL, '2024-11-21 11:11:55', '2024-11-21 11:11:55'),
(11, 10, 2000.00, 1, 'Pending', NULL, '2024-11-22 19:17:38', 0, NULL, NULL, NULL, '2024-11-21 11:17:38', '2024-11-21 11:17:38'),
(12, 10, 2000.00, 0, 'Pending', NULL, '2024-12-07 19:17:00', 0, NULL, NULL, NULL, '2024-11-21 11:17:38', '2024-11-21 11:17:38'),
(13, 11, 2000.00, 1, 'Paid', 'Debit', '2024-11-22 19:18:01', 1, NULL, '2024-11-22 00:39:34', NULL, '2024-11-21 11:18:01', '2024-11-21 16:39:34'),
(14, 11, 2000.00, 0, 'Pending', NULL, '2024-12-07 19:17:00', 0, NULL, NULL, NULL, '2024-11-21 11:18:01', '2024-11-21 11:18:01'),
(15, 12, 5000.00, 1, 'Paid', 'Debit', '2024-11-23 01:05:50', 1, NULL, '2024-11-22 01:09:55', NULL, '2024-11-21 17:05:50', '2024-11-21 17:09:55'),
(16, 12, 5000.00, 0, 'Pending', NULL, '2024-12-16 01:04:00', 0, NULL, NULL, NULL, '2024-11-21 17:05:50', '2024-11-21 17:05:50');

-- --------------------------------------------------------

--
-- Table structure for table `payment_logs`
--

CREATE TABLE `payment_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `log` varchar(5000) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refunds`
--

CREATE TABLE `refunds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double(8,2) NOT NULL,
  `gcash_number` varchar(255) NOT NULL,
  `gcash_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gcash_transaction_number` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inquiry_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `inquiry_id`, `email`, `message`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'dreamfavor@hulas.co', 'This is a test reply', NULL, '2024-11-20 12:21:38', '2024-11-20 12:21:38'),
(2, 1, 'dreamfavor@hulas.co', 'another reply', NULL, '2024-11-20 12:28:05', '2024-11-20 12:28:05'),
(3, 1, 'dreamfavor@hulas.co', 'test reply \r\n\r\nwith \r\n\r\nmany \r\nlines', NULL, '2024-11-20 12:30:58', '2024-11-20 12:30:58'),
(4, 1, 'dreamfavor@hulas.co', 'test reply with new l\r\n\r\nlines htat\r\nis \r\nmultiple', NULL, '2024-11-20 12:33:17', '2024-11-20 12:33:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `role` enum('client','org','admin') NOT NULL DEFAULT 'client',
  `remember_token` varchar(100) DEFAULT NULL,
  `is_banned` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `contact_number`, `email_verified_at`, `password`, `profile_picture`, `role`, `remember_token`, `is_banned`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin_irenthub@hulas.co', NULL, '2024-11-19 13:57:44', '$2y$10$f9Xh30aEJ5YZ.BMWWW44DuGWOTx9l7OwfSh83/f.XsQeeaXja/MJK', NULL, 'admin', NULL, 0, '2024-11-19 13:57:44', '2024-11-19 13:57:44'),
(2, 'Saul Goodman', 'dreamfavor@hulas.co', NULL, '2024-11-19 14:00:34', '$2y$10$3merddI6HGzgnmaq1lSl6.UejR6eqZzDWhkx27bhBNwGtD8TmVMYG', NULL, 'org', NULL, 0, '2024-11-19 13:59:46', '2024-11-20 13:29:51'),
(3, 'Steve Rogers', 'steverogers@hulas.co', NULL, '2024-11-19 14:29:37', '$2y$10$n9blxnfouKlpKo..nBCjyu7X0ahncXeprb0Qm51jWTQJOFp2zaiCK', '1732035070.jpg', 'client', 'VTISee9BBqC45uQ6wiX7Go5SN7LMM5qfZcrT7QLvrB5bYq1u7nfKkiRD7Im8', 0, '2024-11-19 14:29:05', '2024-11-20 14:52:41');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_category_id` bigint(20) UNSIGNED NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `plate_number` varchar(255) NOT NULL,
  `rent_options` enum('With Driver','Without Driver','Both') NOT NULL DEFAULT 'Both',
  `image` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 0,
  `rate` double(8,2) DEFAULT 0.00,
  `rate_w_driver` double(8,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `user_id`, `vehicle_category_id`, `brand`, `model`, `plate_number`, `rent_options`, `image`, `is_available`, `rate`, `rate_w_driver`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 1, 'Chevrolet', 'Chevy Chevelle 2020', 'CHVY209', 'Both', '1732025127.jpg', 1, 2000.00, 2800.00, '2024-11-19 14:05:27', '2024-11-19 14:09:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_categories`
--

CREATE TABLE `vehicle_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_categories`
--

INSERT INTO `vehicle_categories` (`id`, `user_id`, `category_name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'Cars', '2024-11-19 14:05:03', '2024-11-19 14:05:03', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_rates`
--
ALTER TABLE `additional_rates`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_transaction_number_unique` (`transaction_number`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_package_id_foreign` (`package_id`),
  ADD KEY `bookings_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `bookings_cancelled_by_foreign` (`cancelled_by`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_details_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `booking_logs`
--
ALTER TABLE `booking_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_logs_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galleries_organisation_id_foreign` (`organisation_id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organisations`
--
ALTER TABLE `organisations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organisations_user_id_foreign` (`user_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `packages_user_id_foreign` (`user_id`),
  ADD KEY `packages_vehicle_id_foreign` (`vehicle_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_logs_payment_id_foreign` (`payment_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `refunds`
--
ALTER TABLE `refunds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refunds_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `replies_inquiry_id_foreign` (`inquiry_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_contact_number_unique` (`contact_number`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicles_user_id_foreign` (`user_id`),
  ADD KEY `vehicles_vehicle_category_id_foreign` (`vehicle_category_id`);

--
-- Indexes for table `vehicle_categories`
--
ALTER TABLE `vehicle_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_categories_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `booking_logs`
--
ALTER TABLE `booking_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `organisations`
--
ALTER TABLE `organisations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `payment_logs`
--
ALTER TABLE `payment_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refunds`
--
ALTER TABLE `refunds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicle_categories`
--
ALTER TABLE `vehicle_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_cancelled_by_foreign` FOREIGN KEY (`cancelled_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`),
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `booking_logs`
--
ALTER TABLE `booking_logs`
  ADD CONSTRAINT `booking_logs_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `organisations`
--
ALTER TABLE `organisations`
  ADD CONSTRAINT `organisations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `packages_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_logs`
--
ALTER TABLE `payment_logs`
  ADD CONSTRAINT `payment_logs_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`);

--
-- Constraints for table `refunds`
--
ALTER TABLE `refunds`
  ADD CONSTRAINT `refunds_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_inquiry_id_foreign` FOREIGN KEY (`inquiry_id`) REFERENCES `inquiries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicles_vehicle_category_id_foreign` FOREIGN KEY (`vehicle_category_id`) REFERENCES `vehicle_categories` (`id`);

--
-- Constraints for table `vehicle_categories`
--
ALTER TABLE `vehicle_categories`
  ADD CONSTRAINT `vehicle_categories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
