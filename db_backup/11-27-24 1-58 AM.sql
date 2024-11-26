-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 06:58 PM
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
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `type` varchar(100) NOT NULL,
  `route_id` bigint(20) DEFAULT NULL,
  `vehicle_category_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `rate` double NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `additional_rates`
--

INSERT INTO `additional_rates` (`id`, `user_id`, `type`, `route_id`, `vehicle_category_id`, `name`, `rate`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 5, 'rental', NULL, 1, 'Delivery to Mogpog', 150, '2024-11-23 23:20:01', '2024-11-23 23:15:54', '2024-11-23 23:20:01'),
(2, 5, 'rental', NULL, 1, 'Delivery to Boac', 300, NULL, '2024-11-23 23:20:41', '2024-11-23 23:20:41'),
(3, 5, 'rental', NULL, 2, 'test', 200, '2024-11-23 23:25:59', '2024-11-23 23:23:10', '2024-11-23 23:25:59'),
(4, 6, 'door_to_door', 2, NULL, 'Drop Off to Trece Martires Cavite', 200, NULL, '2024-11-26 13:18:30', '2024-11-26 13:28:34');

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
  `booking_type` enum('Package','Vehicle','Door to Door') NOT NULL DEFAULT 'Vehicle',
  `package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `d2d_schedule_id` bigint(20) DEFAULT NULL,
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

INSERT INTO `bookings` (`id`, `transaction_number`, `user_id`, `contact_number`, `name`, `booking_type`, `package_id`, `vehicle_id`, `d2d_schedule_id`, `computed_price`, `status`, `cancelled_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, '17324550813', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 3, NULL, 900.00, 'Completed', NULL, NULL, '2024-11-24 13:31:21', '2024-11-24 14:00:36'),
(4, '17324562763', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 3, NULL, 4500.00, 'Completed', NULL, NULL, '2024-11-24 13:51:16', '2024-11-24 14:21:57'),
(5, '17325454573', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 4, NULL, 12000.00, 'Booked', NULL, NULL, '2024-11-25 14:37:37', '2024-11-25 17:09:00'),
(10, '17326382003', 3, '09563256897', 'Steve Rogers', 'Door to Door', NULL, NULL, 2, 1500.00, 'Cancelled', NULL, NULL, '2024-11-26 16:23:20', '2024-11-26 16:44:09'),
(11, '17326395223', 3, '09563256897', 'Steve Rogers', 'Door to Door', NULL, NULL, 2, 1500.00, 'Cancelled', NULL, NULL, '2024-11-26 16:45:22', '2024-11-26 16:46:54'),
(12, '17326398523', 3, '09563256897', 'Steve Rogers', 'Door to Door', NULL, NULL, 2, 1300.00, 'Completed', NULL, NULL, '2024-11-26 16:50:52', '2024-11-26 16:54:45');

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `number_of_days` int(11) DEFAULT NULL,
  `number_of_persons` int(11) DEFAULT NULL,
  `with_driver` tinyint(1) DEFAULT NULL,
  `license_no` varchar(100) DEFAULT NULL,
  `pickup_location` varchar(255) DEFAULT NULL,
  `drop_off_location` varchar(500) DEFAULT NULL,
  `route_id` bigint(20) DEFAULT NULL,
  `additional_rate_id` bigint(20) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`id`, `booking_id`, `start_datetime`, `number_of_days`, `number_of_persons`, `with_driver`, `license_no`, `pickup_location`, `drop_off_location`, `route_id`, `additional_rate_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 3, '2024-11-26 09:29:00', 1, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, '2024-11-24 13:31:21', '2024-11-24 13:31:21'),
(4, 4, '2024-11-23 09:50:00', 1, NULL, 1, NULL, 'Poras Boac', NULL, NULL, NULL, NULL, '2024-11-24 13:51:16', '2024-11-24 13:51:16'),
(5, 5, '2024-11-27 10:37:00', 2, NULL, 0, '256489', NULL, NULL, NULL, 2, NULL, '2024-11-25 14:37:37', '2024-11-25 14:37:37'),
(9, 10, NULL, NULL, NULL, NULL, NULL, NULL, 'Mogpog Boac Marinduque', 2, 4, NULL, '2024-11-26 16:23:20', '2024-11-26 16:23:20'),
(10, 11, NULL, NULL, NULL, NULL, NULL, NULL, 'asd', 2, 4, NULL, '2024-11-26 16:45:22', '2024-11-26 16:45:22'),
(11, 12, NULL, NULL, NULL, NULL, NULL, NULL, 'Mogpog Boac Marinduque', 2, NULL, NULL, '2024-11-26 16:50:52', '2024-11-26 16:50:52');

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
(4, 3, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-24 13:31:21', '2024-11-24 13:31:21'),
(5, 3, 'Booking was approved by Walter White', NULL, NULL, '2024-11-24 13:33:40', '2024-11-24 13:33:40'),
(6, 4, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-24 13:51:16', '2024-11-24 13:51:16'),
(7, 4, 'Booking was rejected by Walter White', NULL, NULL, '2024-11-24 13:54:02', '2024-11-24 13:54:02'),
(8, 3, 'Steve Rogers Cancelled the booking', 'Change of mind', NULL, '2024-11-24 14:00:36', '2024-11-24 14:00:36'),
(9, 5, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-25 14:37:37', '2024-11-25 14:37:37'),
(10, 5, 'Booking was approved by Saul Goodman', NULL, NULL, '2024-11-25 15:22:56', '2024-11-25 15:22:56'),
(16, 10, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-26 16:23:20', '2024-11-26 16:23:20'),
(17, 10, 'Booking was approved by Roderick Butardo', NULL, NULL, '2024-11-26 16:23:40', '2024-11-26 16:23:40'),
(19, 10, 'Steve Rogers Cancelled the booking', 'asdasd', NULL, '2024-11-26 16:44:09', '2024-11-26 16:44:09'),
(20, 11, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-26 16:45:22', '2024-11-26 16:45:22'),
(21, 11, 'Booking was approved by Roderick Butardo', NULL, NULL, '2024-11-26 16:45:41', '2024-11-26 16:45:41'),
(22, 11, 'Steve Rogers Cancelled the booking', 'sdfsdf', NULL, '2024-11-26 16:46:54', '2024-11-26 16:46:54'),
(23, 12, 'Steve Rogers Created the booking', NULL, NULL, '2024-11-26 16:50:52', '2024-11-26 16:50:52'),
(24, 12, 'Booking was approved by Roderick Butardo', NULL, NULL, '2024-11-26 16:51:09', '2024-11-26 16:51:09');

-- --------------------------------------------------------

--
-- Table structure for table `d2d_schedules`
--

CREATE TABLE `d2d_schedules` (
  `id` bigint(20) NOT NULL,
  `d2d_vehicle_id` bigint(20) NOT NULL,
  `depart_date` date NOT NULL,
  `route_id` bigint(20) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `d2d_schedules`
--

INSERT INTO `d2d_schedules` (`id`, `d2d_vehicle_id`, `depart_date`, `route_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-11-28', 2, '2024-11-26 21:32:02', '2024-11-26 20:54:18', '2024-11-26 21:32:02'),
(2, 1, '2024-11-29', 2, NULL, '2024-11-26 22:02:46', '2024-11-26 22:02:46');

-- --------------------------------------------------------

--
-- Table structure for table `d2d_vehicles`
--

CREATE TABLE `d2d_vehicles` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `image` varchar(500) NOT NULL,
  `max_cap` int(11) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `d2d_vehicles`
--

INSERT INTO `d2d_vehicles` (`id`, `user_id`, `name`, `image`, `max_cap`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 6, 'Toyota Hi-Ace edited', '1732622462.png', 12, NULL, '2024-11-26 19:20:01', '2024-11-26 20:01:02'),
(2, 6, 'Toyota Hi-Ace 2', '1732620385.png', 10, '2024-11-26 20:00:39', '2024-11-26 19:26:25', '2024-11-26 20:00:39'),
(3, 6, 'Toyota Hi Ace - 1', '1732622485.png', 10, NULL, '2024-11-26 20:01:25', '2024-11-26 20:01:25');

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
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` bigint(20) NOT NULL,
  `booking_id` bigint(20) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` varchar(5000) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `booking_id`, `rating`, `review`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 4, 3, 'hgfhjgdjysyisa', NULL, '2024-11-24 22:22:32', '2024-11-24 22:22:32'),
(2, 3, 2, 'fsdfsdf', NULL, '2024-11-24 23:36:31', '2024-11-24 23:36:31'),
(3, 12, 4, 'asdasd', NULL, '2024-11-27 00:54:59', '2024-11-27 00:54:59');

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
(1, 4, 'asd', '1732596170.png', 'asdasd', '2024-11-26 17:39:29', '2024-11-26 04:42:33', '2024-11-26 17:39:29');

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
(1, 2, 'Dream Favor', '0949313146', 'asd', 'sk_test_51QNZYKKKTnnzOx7OGuhBYrNtoxmjL01TCrBG8x0HTqgPu0NEt7oTVIUpLnCjuAyVi8SROylkP1xI3GWdr96v13Pq009Geg8akC', '2024-11-19 13:59:46', '2024-11-19 13:59:46'),
(3, 5, 'Marinduque Vehicle Rental', '09121212565', 'Boac Marinduque', 'sk_test_51QO9fsLTdpwYWhe3yMw0DNRiFUarxFpYquXeGEjrtMOAgmhivCXN95ySYuOVJiy8N2uH92AnZDPxdbih0TpjK7pX00oaTahzfD', '2024-11-23 13:17:33', '2024-11-23 13:17:33'),
(4, 6, 'Luzon Datum Transport Cooperative', '09121212565', 'Mogpog Marinduque', 'sk_test_51QO9fsLTdpwYWhe3yMw0DNRiFUarxFpYquXeGEjrtMOAgmhivCXN95ySYuOVJiy8N2uH92AnZDPxdbih0TpjK7pX00oaTahzfD', '2024-11-23 13:19:29', '2024-11-23 13:19:29');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `minimum_pax` int(11) DEFAULT NULL,
  `price_per_person` double DEFAULT NULL,
  `package_duration` int(11) DEFAULT NULL,
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
(1, 2, 'Day Tour', 10, 2, 1, 'Test Description', '1732463613.jpg', 1, NULL, '2024-11-24 16:13:35', '2024-11-24 15:53:33', '2024-11-24 16:13:35');

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
(5, 3, 450.00, 1, 'Paid', 'GCash', '2024-11-25 21:31:21', 1, 'ggdfg', '2024-11-24 21:40:08', NULL, '2024-11-24 13:31:21', '2024-11-24 13:40:08'),
(6, 3, 450.00, 0, 'Paid', 'Debit', '2024-11-26 09:29:00', 1, NULL, '2024-11-24 21:43:07', NULL, '2024-11-24 13:31:21', '2024-11-24 13:43:07'),
(7, 4, 2250.00, 1, 'Paid', 'Debit', '2024-11-25 21:51:16', 1, NULL, '2024-11-24 22:06:50', NULL, '2024-11-24 13:51:16', '2024-11-24 14:06:50'),
(8, 4, 2250.00, 0, 'Paid', 'Cash', '2024-11-26 09:50:00', 0, NULL, '2024-11-24 22:07:58', NULL, '2024-11-24 13:51:16', '2024-11-24 14:07:58'),
(9, 5, 12000.00, 0, 'Paid', 'Debit', '2024-11-26 22:37:37', 2, 'fsdf', '2024-11-26 01:08:57', NULL, '2024-11-25 14:37:37', '2024-11-25 17:08:57'),
(10, 10, 1500.00, 0, 'Paid', 'Debit', '2024-11-28 00:00:00', 1, NULL, '2024-11-27 00:38:19', NULL, '2024-11-26 16:23:20', '2024-11-26 16:38:19'),
(11, 11, 1500.00, 0, 'Paid', 'Debit', '2024-11-28 00:00:00', 1, NULL, '2024-11-27 00:46:24', NULL, '2024-11-26 16:45:22', '2024-11-26 16:46:24'),
(12, 12, 650.00, 1, 'Paid', 'Cash', '2024-11-28 00:00:00', 0, NULL, '2024-11-27 00:51:46', NULL, '2024-11-26 16:50:52', '2024-11-26 16:51:46'),
(13, 12, 650.00, 0, 'Paid', 'Cash', '2024-11-28 00:00:00', 0, NULL, '2024-11-27 00:52:25', NULL, '2024-11-26 16:50:52', '2024-11-26 16:52:25');

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
  `gcash_transaction_number` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `refunded_at` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `refunds`
--

INSERT INTO `refunds` (`id`, `booking_id`, `amount`, `gcash_number`, `gcash_name`, `email`, `gcash_transaction_number`, `status`, `refunded_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 3, 877.50, '09121212565', 'Steve Rogers', 'steverogers@hulas.co', 'sadasfasfasf', 'refunded', '2024-11-24 22:03:44', NULL, '2024-11-24 14:01:38', '2024-11-24 14:03:44'),
(2, 11, 1462.50, '09121212565', 'Steve Rogers', 'steverogers@hulas.co', 'dads', 'refunded', '2024-11-27 00:50:16', NULL, '2024-11-26 16:47:11', '2024-11-26 16:50:16');

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
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `from_address` varchar(1000) NOT NULL,
  `to_address` varchar(1000) NOT NULL,
  `rate` double NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `user_id`, `from_address`, `to_address`, `rate`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 6, 'Manila', 'Marinduque', 1400, '2024-11-26 12:26:52', '2024-11-26 12:00:46', '2024-11-26 12:26:52'),
(2, 6, 'Manila', 'Marinduque', 1300, NULL, '2024-11-26 12:53:09', '2024-11-26 21:19:43');

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
(3, 'Steve Rogers', 'steverogers@hulas.co', NULL, '2024-11-19 14:29:37', '$2y$10$n9blxnfouKlpKo..nBCjyu7X0ahncXeprb0Qm51jWTQJOFp2zaiCK', '1732035070.jpg', 'client', 'kbjnfJ04QgjJk0bf1pupw9gcutlsXbFVezeaAsmkNf53qpcHjUdjgrVSz4QY', 0, '2024-11-19 14:29:05', '2024-11-20 14:52:41'),
(5, 'Walter White', 'marinduquevehiclerental@hulas.co', NULL, '2024-11-23 13:21:23', '$2y$10$YMEJfHHsGiOEGU5swQBbzOC76U6TFjF7qI4X6Z6b2W6Pt7PNJntce', NULL, 'org', NULL, 0, '2024-11-23 13:17:33', '2024-11-23 13:21:23'),
(6, 'Roderick Butardo', 'luzondatumtransportcoop@hulas.co', NULL, '2024-11-23 15:44:14', '$2y$10$CpAxO6g0rQHFxCxJ7GhlPuIxicduH3widSJFH.PCMu3IGpETHS0f2', NULL, 'org', NULL, 0, '2024-11-23 13:19:29', '2024-11-23 15:44:14');

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
  `rent_options` enum('With Driver','Without Driver','Both') NOT NULL DEFAULT 'Both',
  `image` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 0,
  `rate` double(8,2) DEFAULT NULL,
  `rate_w_driver` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `user_id`, `vehicle_category_id`, `brand`, `model`, `rent_options`, `image`, `is_available`, `rate`, `rate_w_driver`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 1, 'YAMAHA', 'YAMAHA NMAX155', 'Without Driver', '1732369770.png', 1, 600.00, NULL, '2024-11-23 13:49:30', '2024-11-24 13:49:56', NULL),
(2, 5, 1, 'Honda', 'PCX160', 'Without Driver', '1732369944.png', 1, 600.00, NULL, '2024-11-23 13:52:24', '2024-11-23 15:03:55', NULL),
(3, 5, 2, 'Toyota', 'Toyota Rush', 'Both', '1732375764.png', 1, 3500.00, 4500, '2024-11-23 15:29:24', '2024-11-23 15:41:24', NULL),
(4, 2, 6, 'Chevrolet', 'Chevy Chevelle 2020', 'Both', '1732542522.jpg', 1, 6000.00, 7000, '2024-11-25 13:48:42', '2024-11-25 14:01:10', NULL);

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
(1, 5, 'Scooter', '2024-11-23 13:30:41', '2024-11-23 13:30:41', NULL),
(2, 5, 'SUV', '2024-11-23 13:30:51', '2024-11-23 13:30:51', NULL),
(3, 5, 'MPV', '2024-11-23 13:30:57', '2024-11-23 13:30:57', NULL),
(4, 5, 'Sedan', '2024-11-23 13:31:17', '2024-11-23 13:31:17', NULL),
(5, 6, 'Van', '2024-11-23 15:45:47', '2024-11-26 05:35:26', '2024-11-26 05:35:26'),
(6, 2, 'Cars', '2024-11-25 13:47:15', '2024-11-25 13:47:15', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_rates`
--
ALTER TABLE `additional_rates`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `d2d_schedules`
--
ALTER TABLE `d2d_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `d2d_vehicles`
--
ALTER TABLE `d2d_vehicles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `additional_rates`
--
ALTER TABLE `additional_rates`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `booking_logs`
--
ALTER TABLE `booking_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `d2d_schedules`
--
ALTER TABLE `d2d_schedules`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `d2d_vehicles`
--
ALTER TABLE `d2d_vehicles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicle_categories`
--
ALTER TABLE `vehicle_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
