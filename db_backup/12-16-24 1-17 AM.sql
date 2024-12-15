-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 06:17 PM
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
(4, 6, 'door_to_door', 2, NULL, 'Drop Off to Trece Martires Cavite', 200, '2024-12-10 09:16:32', '2024-11-26 13:18:30', '2024-12-10 09:16:32'),
(5, 5, 'rental', NULL, 1, 'Delivery to Mogpog', 300, NULL, '2024-11-29 08:09:28', '2024-11-29 08:10:05'),
(6, 6, 'door_to_door', 5, NULL, 'Additional Rate', 200, NULL, '2024-12-10 09:20:39', '2024-12-10 09:20:39'),
(7, 6, 'door_to_door', 6, NULL, 'Additional Rate', 200, NULL, '2024-12-10 09:21:11', '2024-12-10 09:21:11'),
(8, 6, 'door_to_door', 7, NULL, 'Additional Rate', 200, NULL, '2024-12-10 09:21:28', '2024-12-10 09:21:28'),
(9, 6, 'door_to_door', 8, NULL, 'Additional Rate', 200, NULL, '2024-12-10 09:22:47', '2024-12-10 09:22:47'),
(10, 6, 'door_to_door', 9, NULL, 'Additional Rate', 600, NULL, '2024-12-10 09:23:06', '2024-12-10 09:24:36'),
(11, 6, 'door_to_door', 10, NULL, 'Additional Rate', 600, NULL, '2024-12-10 09:23:21', '2024-12-10 09:24:20'),
(12, 6, 'door_to_door', 11, NULL, 'Additional Rate', 600, NULL, '2024-12-10 09:23:41', '2024-12-10 09:23:41'),
(13, 5, 'rental', NULL, 1, 'Delivery to Balanacan', 300, NULL, '2024-12-10 09:49:30', '2024-12-10 09:49:30'),
(14, 5, 'rental', NULL, 1, 'Delivery to Santa Cruz', 500, NULL, '2024-12-10 09:49:47', '2024-12-10 09:49:47'),
(15, 5, 'rental', NULL, 1, 'Delivery to Torrijos', 700, NULL, '2024-12-10 09:50:02', '2024-12-10 09:50:02'),
(16, 5, 'rental', NULL, 1, 'Delivery to Buenavisata', 500, NULL, '2024-12-10 09:50:23', '2024-12-10 09:50:23');

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
  `discount` double NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `cancelled_by` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `transaction_number`, `user_id`, `contact_number`, `name`, `booking_type`, `package_id`, `vehicle_id`, `d2d_schedule_id`, `computed_price`, `discount`, `status`, `cancelled_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(17, '17332241263', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 4, NULL, 18000.00, 0, 'Cancelled', NULL, NULL, '2024-12-03 11:08:46', '2024-12-04 03:01:46'),
(18, '17332824043', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 4, NULL, 14000.00, 0, 'Completed', NULL, NULL, '2024-12-04 03:20:04', '2024-12-09 08:29:10'),
(19, '17336723813', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 4, NULL, 24000.00, 0, 'Cancelled', NULL, NULL, '2024-12-08 15:39:41', '2024-12-09 08:25:32'),
(20, '17337324983', 3, '09270067834', 'Marrite Mutya', 'Package', 2, NULL, NULL, 9500.00, 1500, 'Cancelled', NULL, NULL, '2024-12-09 08:21:38', '2024-12-10 00:14:00'),
(21, '173379211311', 11, '09172536482', 'Rochelle Manggol', 'Package', 2, NULL, NULL, 19734.00, 0, 'Booked', NULL, NULL, '2024-12-10 00:55:13', '2024-12-10 00:57:30'),
(22, '173379902411', 11, '09172536482', 'Rochelle Manggol', 'Vehicle', NULL, 8, NULL, 500.00, 100, 'To Pay', NULL, NULL, '2024-12-10 02:50:24', '2024-12-10 03:05:06'),
(23, '17338085723', 3, '09563256897', 'Steve Rogers', 'Vehicle', NULL, 12, NULL, 1200.00, 0, 'Booked', NULL, NULL, '2024-12-10 05:29:32', '2024-12-10 05:35:32');

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
  `valid_until` date DEFAULT NULL,
  `front_id` varchar(255) DEFAULT NULL,
  `back_id` varchar(255) DEFAULT NULL,
  `pickup_location` varchar(255) DEFAULT NULL,
  `drop_off_location` varchar(500) DEFAULT NULL,
  `rent_out_time` datetime DEFAULT NULL,
  `return_in_time` datetime DEFAULT NULL,
  `rent_out_location` varchar(1000) DEFAULT NULL,
  `route_id` bigint(20) DEFAULT NULL,
  `additional_rate_id` bigint(20) DEFAULT NULL,
  `return_reason` varchar(5000) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`id`, `booking_id`, `start_datetime`, `number_of_days`, `number_of_persons`, `with_driver`, `license_no`, `valid_until`, `front_id`, `back_id`, `pickup_location`, `drop_off_location`, `rent_out_time`, `return_in_time`, `rent_out_location`, `route_id`, `additional_rate_id`, `return_reason`, `deleted_at`, `created_at`, `updated_at`) VALUES
(16, 17, '2024-12-05 19:08:00', 3, NULL, 0, '256489', '2024-12-26', '17332241261.jpg', '17332241262.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-03 11:08:46', '2024-12-03 11:14:01'),
(17, 18, '2024-12-07 11:19:00', 2, NULL, 1, NULL, NULL, NULL, NULL, 'Test Location', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-04 03:20:04', '2024-12-04 03:20:04'),
(18, 19, '2024-12-10 23:38:00', 4, NULL, 0, '256489', '2024-12-17', '17336723811.jpg', '17336723812.jpg', NULL, NULL, '2024-12-10 11:39:00', '2024-12-13 13:12:52', 'test rent out location', NULL, NULL, NULL, NULL, '2024-12-08 15:39:41', '2024-12-09 08:18:12'),
(19, 20, '2024-12-12 07:00:00', 1, 11, NULL, NULL, NULL, NULL, NULL, 'Balimbing, Boac', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-09 08:21:38', '2024-12-09 08:21:38'),
(20, 21, '2024-12-12 07:00:00', 1, 11, NULL, NULL, NULL, NULL, NULL, 'Ino Mogpog', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-12-10 00:55:13', '2024-12-10 00:55:13'),
(21, 22, '2024-12-11 14:48:00', 2, NULL, 0, '093727', '2027-06-23', '17337990241.png', '17337990242.png', NULL, NULL, '2024-12-10 15:50:00', '2024-12-12 13:12:45', 'tanza Boac', NULL, NULL, NULL, NULL, '2024-12-10 02:50:24', '2024-12-10 02:50:24'),
(22, 23, '2024-12-12 13:19:00', 2, NULL, 0, '256489', '2025-06-10', '17338085721.jpg', '17338085722.jpg', NULL, NULL, '2024-12-12 13:24:00', '2024-12-17 00:24:00', 'test loation', NULL, NULL, NULL, NULL, '2024-12-10 05:29:32', '2024-12-15 16:30:20');

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
(43, 17, 'Steve Rogers Created the booking', NULL, NULL, '2024-12-03 11:08:46', '2024-12-03 11:08:46'),
(44, 17, 'Booking was approved by Saul Goodman', NULL, NULL, '2024-12-03 11:09:33', '2024-12-03 11:09:33'),
(45, 17, 'Steve RogersClient cancels the booking', 'Incorrect dates of booking', NULL, '2024-12-03 15:32:19', '2024-12-03 15:32:19'),
(46, 18, 'Steve Rogers Created the booking', NULL, NULL, '2024-12-04 03:20:04', '2024-12-04 03:20:04'),
(47, 18, 'Booking was approved by Saul Goodman', NULL, NULL, '2024-12-04 03:23:06', '2024-12-04 03:23:06'),
(48, 18, 'Steve RogersClient cancels the booking', 'Work or business  commitment', NULL, '2024-12-04 03:27:56', '2024-12-04 03:27:56'),
(49, 19, 'Steve Rogers Created the booking', NULL, NULL, '2024-12-08 15:39:41', '2024-12-08 15:39:41'),
(50, 19, 'Booking was approved by Saul Goodman', NULL, NULL, '2024-12-08 16:09:24', '2024-12-08 16:09:24'),
(51, 20, 'Steve Rogers Created the booking', NULL, NULL, '2024-12-09 08:21:38', '2024-12-09 08:21:38'),
(52, 20, 'Booking was approved by Saul Goodman', NULL, NULL, '2024-12-09 08:22:15', '2024-12-09 08:22:15'),
(53, 19, 'Steve RogersClient cancels the booking', 'Personal Emergency', NULL, '2024-12-09 08:24:12', '2024-12-09 08:24:12'),
(54, 20, 'Steve RogersClient cancels the booking', 'Personal Emergency', NULL, '2024-12-10 00:14:00', '2024-12-10 00:14:00'),
(55, 21, 'Rochelle Manggol Created the booking', NULL, NULL, '2024-12-10 00:55:13', '2024-12-10 00:55:13'),
(56, 21, 'Booking was approved by Susan Nace', NULL, NULL, '2024-12-10 00:55:40', '2024-12-10 00:55:40'),
(57, 22, 'Rochelle Manggol Created the booking', NULL, NULL, '2024-12-10 02:50:24', '2024-12-10 02:50:24'),
(58, 22, 'Booking was approved by Jean Worth', NULL, NULL, '2024-12-10 03:05:06', '2024-12-10 03:05:06'),
(59, 23, 'Steve Rogers Created the booking', NULL, NULL, '2024-12-10 05:29:32', '2024-12-10 05:29:32'),
(60, 23, 'Booking was approved by Jean Worth', NULL, NULL, '2024-12-10 05:34:04', '2024-12-10 05:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `cancellation_details`
--

CREATE TABLE `cancellation_details` (
  `id` bigint(20) NOT NULL,
  `booking_id` bigint(20) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `by_client` tinyint(4) NOT NULL,
  `refund_amount` double DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cancellation_details`
--

INSERT INTO `cancellation_details` (`id`, `booking_id`, `reason`, `status`, `by_client`, `refund_amount`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 16, 'Ayaw na po', 'Cancel Approved', 1, 1140, NULL, '2024-12-02 19:47:13', '2024-12-02 19:47:55'),
(4, 14, 'Accidentally made a double booking', 'Cancel Rejected', 1, 3500, NULL, '2024-12-02 20:08:07', '2024-12-02 20:10:16'),
(8, 17, 'Incorrect dates of booking', 'Cancel Completed', 1, 5000, NULL, '2024-12-03 23:32:19', '2024-12-04 11:01:46'),
(9, 18, 'Work or business  commitment', 'Cancel Approved', 1, 13000, '2024-12-04 11:29:25', '2024-12-04 11:27:56', '2024-12-04 11:29:25'),
(10, 19, 'Personal Emergency', 'Cancel Completed', 1, 10000, NULL, '2024-12-09 16:24:12', '2024-12-09 16:26:24');

-- --------------------------------------------------------

--
-- Table structure for table `cancellation_rates`
--

CREATE TABLE `cancellation_rates` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `remaining_days` int(11) NOT NULL,
  `percent` double NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cancellation_rates`
--

INSERT INTO `cancellation_rates` (`id`, `user_id`, `remaining_days`, `percent`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 5, 2, 50, '2024-12-02 15:33:41', '2024-12-02 15:21:07', '2024-12-02 15:33:41'),
(2, 5, 1, 50, NULL, '2024-12-02 15:33:51', '2024-12-02 15:33:51'),
(3, 5, 7, 30, NULL, '2024-12-02 15:34:44', '2024-12-02 15:34:44'),
(4, 2, 7, 0, NULL, '2024-12-02 16:10:26', '2024-12-10 08:51:42'),
(5, 2, 14, 50, NULL, '2024-12-02 16:10:34', '2024-12-10 08:51:15'),
(6, 2, 30, 100, NULL, '2024-12-02 16:10:42', '2024-12-10 08:50:38'),
(7, 2, 1, 0, NULL, '2024-12-10 08:52:19', '2024-12-10 08:52:19'),
(8, 6, 7, 20, NULL, '2024-12-10 09:25:27', '2024-12-10 09:27:13'),
(9, 6, 1, 0, NULL, '2024-12-10 09:25:41', '2024-12-10 09:25:41'),
(10, 6, 14, 50, NULL, '2024-12-10 09:27:05', '2024-12-10 09:27:05');

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
(1, 6, 'Toyota Hi-Ace Commuter', '1733793328.png', 10, NULL, '2024-11-26 19:20:01', '2024-12-10 09:15:28'),
(2, 6, 'Toyota Hi-Ace 2', '1732620385.png', 10, '2024-11-26 20:00:39', '2024-11-26 19:26:25', '2024-11-26 20:00:39'),
(3, 6, 'Toyota Hi Ace - Grandia', '1733793293.png', 12, NULL, '2024-11-26 20:01:25', '2024-12-10 09:14:53');

-- --------------------------------------------------------

--
-- Table structure for table `extension_requests`
--

CREATE TABLE `extension_requests` (
  `id` bigint(20) NOT NULL,
  `booking_id` bigint(20) NOT NULL,
  `extend_days` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `extension_requests`
--

INSERT INTO `extension_requests` (`id`, `booking_id`, `extend_days`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 14, 1, 'approved', NULL, '2024-12-03 18:31:43', '2024-12-03 19:04:06'),
(2, 17, 1, 'approved', NULL, '2024-12-03 19:12:15', '2024-12-03 19:14:01'),
(3, 17, 1, 'rejected', NULL, '2024-12-03 19:25:55', '2024-12-03 19:26:35'),
(4, 19, 5, 'rejected', NULL, '2024-12-09 16:14:32', '2024-12-09 16:16:06'),
(5, 19, 2, 'approved', NULL, '2024-12-09 16:16:30', '2024-12-09 16:18:12');

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
(3, 12, 4, 'asdasd', NULL, '2024-11-27 00:54:59', '2024-11-27 00:54:59'),
(4, 18, 4, 'test review', NULL, '2024-12-15 18:37:06', '2024-12-15 18:37:06');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
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

INSERT INTO `galleries` (`id`, `title`, `image`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'test gallery', '1732723767.jpg', 'Some exceptions describe HTTP error codes from the server. For example, this may be a &quot;page not found&quot; error (404), an &quot;unauthorized error&quot; (401) or even a developer generated 500 error. In order to generate such a response from anywhere in your application, you may use the abort helper:\r\n\r\ncredits Test Credit', '2024-12-10 01:51:30', '2024-11-27 16:08:51', '2024-12-10 01:51:30'),
(3, 'Test Spot', '1732801259.jpg', 'adasdasdad', '2024-12-10 01:51:25', '2024-11-28 13:41:00', '2024-12-10 01:51:25'),
(4, 'Luzon Datum', '1733795605.png', 'This rock marker was established in 1911 by the US Coast and Geodetic Survey as the Geodetic Center of the country. It is a hole drilled inside an etched triangle in a cubic meter of diorite rock outcrop at the top of the highest hill (272.42 MASL) in Brgy. Hinanggayon.', NULL, '2024-12-10 01:53:25', '2024-12-10 01:53:25'),
(5, 'Paadjao Falls', '1733795670.png', 'Paadjao Falls is a 100 plus feet cascading falls which pours into a 6 feet deep natural swimming pool at its foot surrounded by tall forest trees and coco groves.', NULL, '2024-12-10 01:54:30', '2024-12-10 01:54:30'),
(6, 'Balanacan View Deck', '1733795800.png', 'It is located near the boundary of Brgy. Ino. The present view deck, which offers a 270-degree view of the northwestern portion of Mogpog, was reconstructed from a single storeygalvanized ironroofing into a two-storey concretes lab view area.\r\n\r\n© Department of Tourism', NULL, '2024-12-10 01:56:40', '2024-12-10 01:56:40'),
(7, 'Kawa-kawa Falls', '1733795933.png', 'This site of multi-pool waterfalls is located in Brgy. Bancuangan, named after some large kettle-like pools that are excellent for family picnics and refreshing dips.', NULL, '2024-12-10 01:58:54', '2024-12-10 01:58:54');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_feedbacks`
--

CREATE TABLE `gallery_feedbacks` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `gallery_id` bigint(20) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` varchar(1000) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_feedbacks`
--

INSERT INTO `gallery_feedbacks` (`id`, `user_id`, `gallery_id`, `rating`, `review`, `deleted_at`, `created_at`, `updated_at`) VALUES
(10, 3, 2, 5, 'Updated Feedback', NULL, '2024-12-08 21:30:37', '2024-12-08 21:35:00'),
(11, 7, 2, 4, 'Fair Enough', NULL, '2024-12-08 21:35:54', '2024-12-08 21:35:54'),
(12, 2, 3, 5, 'adasd', NULL, '2024-12-08 22:17:59', '2024-12-08 22:17:59');

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
  `penalty` double NOT NULL DEFAULT 100,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organisations`
--

INSERT INTO `organisations` (`id`, `user_id`, `org_name`, `gcash_number`, `address`, `stripe_secret_key`, `penalty`, `created_at`, `updated_at`) VALUES
(1, 2, 'Dream Favor', '0949313146', 'asd', 'sk_test_51QNZYKKKTnnzOx7OGuhBYrNtoxmjL01TCrBG8x0HTqgPu0NEt7oTVIUpLnCjuAyVi8SROylkP1xI3GWdr96v13Pq009Geg8akC', 100, '2024-11-19 13:59:46', '2024-11-19 13:59:46'),
(3, 5, 'Marinduque Vehicle Rental', '09121212565', 'Boac Marinduque', 'sk_test_51QO9fsLTdpwYWhe3yMw0DNRiFUarxFpYquXeGEjrtMOAgmhivCXN95ySYuOVJiy8N2uH92AnZDPxdbih0TpjK7pX00oaTahzfD', 100, '2024-11-23 13:17:33', '2024-11-23 13:17:33'),
(4, 6, 'Luzon Datum Transport Cooperative', '09121212565', 'Mogpog Marinduque', 'sk_test_51QO9fsLTdpwYWhe3yMw0DNRiFUarxFpYquXeGEjrtMOAgmhivCXN95ySYuOVJiy8N2uH92AnZDPxdbih0TpjK7pX00oaTahzfD', 100, '2024-11-23 13:19:29', '2024-11-23 13:19:29'),
(5, 8, 'CRJ', '09562314587', 'Gasan, Marinduque', 'sk_test_51QO9fsLTdpwYWhe3yMw0DNRiFUarxFpYquXeGEjrtMOAgmhivCXN95ySYuOVJiy8N2uH92AnZDPxdbih0TpjK7pX00oaTahzfD', 100, '2024-12-10 00:00:30', '2024-12-10 00:00:30'),
(6, 9, 'Malinao Rents', '09883492748', 'Boac, Marinduque', 'sk_test_51QO9fsLTdpwYWhe3yMw0DNRiFUarxFpYquXeGEjrtMOAgmhivCXN95ySYuOVJiy8N2uH92AnZDPxdbih0TpjK7pX00oaTahzfD', 100, '2024-12-10 00:05:24', '2024-12-10 00:05:24'),
(7, 10, 'Logmao Rental', '09834725135', 'Boac, Marinduque', 'sk_test_51QO9fsLTdpwYWhe3yMw0DNRiFUarxFpYquXeGEjrtMOAgmhivCXN95ySYuOVJiy8N2uH92AnZDPxdbih0TpjK7pX00oaTahzfD', 100, '2024-12-10 00:07:54', '2024-12-10 00:07:54');

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
(1, 2, 'Day Tour', 10, 2, 1, 'Test Description', '1732463613.jpg', 1, NULL, '2024-11-24 16:13:35', '2024-11-24 15:53:33', '2024-11-24 16:13:35'),
(2, 2, 'Boac Culture & Heritage Town Tour', 10, 1794, 1, 'Discover the cultural and heritage treasures of Boac! Learn about its traditions; visit historical and religious sites that shaped the town. And have a taste of its local delicacies.\r\n\r\nTour Highlights:\r\nThe Boac Cathedral\r\nButterfly Farm\r\nCasa De Don Emilio\r\nBantayog ng Wika\r\nBoac Historical Sites\r\n\r\nInclusions:\r\nAirport/Seaport Pick-up and Drop off\r\nVan Transport Service\r\nTour Guide\r\nEntrance Fees\r\nEnvironmental Fees\r\nCottages\r\nLunch\r\nLight PM Snack\r\nBottled Water', '1733790435.png', 1, NULL, NULL, '2024-12-01 13:44:58', '2024-12-10 00:57:15'),
(3, 2, 'Round Marinduque', 10, 2082, 1, 'Visit historical and religious places that plays significant role in the province. Get to see some of its remarkable tourist attractions.\r\n\r\nTour Highlights:\r\nCircumferential Road\r\nSix Municipalities of Marinduque\r\nHistorical and Religious Sites\r\nLand and Sea Scapes\r\nKnown Tourist Destinations\r\n\r\nInclusions:\r\nAirport/Seaport Pick-up and Drop off\r\nVan Transport Service\r\nTour Guide\r\nEntrance Fees\r\nEnvironmental Fees\r\nCottages\r\nLunch\r\nLight PM Snack\r\nBottled Water', '1733790814.png', 1, NULL, NULL, '2024-12-10 00:33:34', '2024-12-10 00:34:05'),
(4, 2, 'Journey to the Center of the Philippines', 10, 1886, 1, 'Climb 400+ steps up the geodetic center of the Philippines. Catch of a view of the breathtaking Northwestern seascape of Marinduque.\r\n\r\nTOUR HIGHLIGHTS:\r\nLuzon Datum of 1911\r\nBalanacan Seascape\r\nBalanacan View Deck\r\nMorion Mask Makers\r\nUlong Bay/Paadjao Falls\r\nInclusions:\r\nAirport/Seaport Pick-up and Drop off\r\nVan Transport Service\r\nTour Guide\r\nEntrance Fees\r\nEnvironmental Fees\r\nCottages\r\nLunch\r\nLight PM Snack\r\nBottled Water', '1733791010.png', 1, NULL, NULL, '2024-12-10 00:36:50', '2024-12-10 00:36:58'),
(5, 2, 'Roadtrip to Poctoy White Beach', 10, 2059, 1, 'Ride on an exciting road trip going to the peaceful bays of Poctoy White Beach. With some stop-overs to catch a view of Marinduque\'s majestic land and sea scape.\r\n\r\nInclusions:\r\nAirport/Seaport Pick-up and Drop off\r\nVan Transport Service\r\nTour Guide\r\nEntrance Fees\r\nEnvironmental Fees\r\nCottages\r\nLunch\r\nLight PM Snack\r\nBottled Water', '1733791177.png', 1, NULL, NULL, '2024-12-10 00:39:37', '2024-12-10 00:39:48'),
(6, 2, 'Tres Reyes Island Escape', 10, 2289, 1, 'Make your island dreams come true and be blown by the beauty of Tres Reyes Islands. Complete your beach escape with its soft sands, blue waters, and teeming marine life.\r\n\r\nInclusions:\r\nAirport/Seaport Pick-up and Drop off\r\nVan Transport Service\r\nTour Guide\r\nEntrance Fees\r\nEnvironmental Fees\r\nCottages\r\nLunch\r\nLight PM Snack\r\nBottled Water', '1733791499.png', 1, NULL, NULL, '2024-12-10 00:44:59', '2024-12-10 00:45:04'),
(7, 2, 'Santa Cruz Island Hopping', 10, 2772, 1, 'Set sail to the majestic islands in Santa Cruz and discover the wonders of its ocean! Swim, Dive, Snorkel in pristine blue waters or have fun taking photos on the disappearing sand bar.\r\n\r\nInclusions:\r\nAirport/Seaport Pick-up and Drop off\r\nVan Transport Service\r\nTour Guide\r\nEntrance Fees\r\nEnvironmental Fees\r\nCottages\r\nLunch\r\nLight PM Snack\r\nBottled Water', '1733791663.png', 1, NULL, NULL, '2024-12-10 00:47:43', '2024-12-10 00:47:47');

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
(23, 17, 6000.00, 1, 'Paid', 'Debit', '2024-12-04 19:08:46', 1, NULL, '2024-12-03 19:10:32', NULL, '2024-12-03 11:08:46', '2024-12-03 11:10:32'),
(24, 17, 6000.00, 0, 'Pending', NULL, '2024-12-05 19:08:00', 0, NULL, NULL, NULL, '2024-12-03 11:08:46', '2024-12-03 11:08:46'),
(25, 17, 6000.00, 0, 'Pending', NULL, '2024-12-04 19:14:01', 0, NULL, NULL, NULL, '2024-12-03 11:14:01', '2024-12-03 11:14:01'),
(26, 18, 14000.00, 0, 'Paid', 'Debit', '2024-12-05 11:20:04', 1, NULL, '2024-12-04 11:25:10', NULL, '2024-12-04 03:20:04', '2024-12-04 03:25:10'),
(27, 19, 12000.00, 0, 'Paid', 'Debit', '2024-12-09 23:39:41', 1, NULL, '2024-12-09 00:14:41', NULL, '2024-12-08 15:39:41', '2024-12-08 16:14:41'),
(28, 19, 12000.00, 0, 'For Approval', 'GCash', '2024-12-10 16:18:12', 1, 'asdasfasd', NULL, NULL, '2024-12-09 08:18:12', '2024-12-09 08:19:52'),
(29, 20, 11000.00, 0, 'Pending', NULL, '2024-12-10 16:21:38', 0, NULL, NULL, NULL, '2024-12-09 08:21:38', '2024-12-09 08:21:38'),
(30, 21, 19734.00, 0, 'Paid', 'GCash', '2024-12-11 08:55:13', 1, '0938274', '2024-12-10 08:57:25', NULL, '2024-12-10 00:55:13', '2024-12-10 00:57:25'),
(31, 22, 600.00, 0, 'For Approval', 'GCash', '2024-12-11 10:50:24', 1, '0938274', NULL, NULL, '2024-12-10 02:50:24', '2024-12-10 03:05:39'),
(32, 23, 1200.00, 0, 'Paid', 'Debit', '2024-12-11 13:29:32', 1, NULL, '2024-12-10 13:35:27', NULL, '2024-12-10 05:29:32', '2024-12-10 05:35:27');

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
(4, 17, 5000.00, '09121212565', 'Steve Rogers', 'steverogers@hulas.co', '156454654564', 'refunded', '2024-12-04 11:09:19', NULL, '2024-12-04 03:08:30', '2024-12-04 03:09:19'),
(5, 19, 10000.00, '09562314587', 'Rochelle Manggol', 'admin_irenthub@hulas.co', 'sgdsd', 'refunded', '2024-12-09 16:27:23', NULL, '2024-12-09 08:26:49', '2024-12-09 08:27:23');

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
(2, 6, 'Metro Manila', 'District 2-Marinduque', 1300, NULL, '2024-11-26 12:53:09', '2024-12-10 09:21:51'),
(3, 6, 'Marinduque', 'Metro Manila', 1300, NULL, '2024-12-10 09:17:03', '2024-12-10 09:17:03'),
(4, 6, 'Marinduque', 'Imus Cavite', 1300, NULL, '2024-12-10 09:17:25', '2024-12-10 09:17:25'),
(5, 6, 'Marinduque', 'General Trias Cavite', 1300, NULL, '2024-12-10 09:17:38', '2024-12-10 09:17:38'),
(6, 6, 'Marinduque', 'Trece Cavite', 1300, NULL, '2024-12-10 09:17:53', '2024-12-10 09:17:53'),
(7, 6, 'Marinduque', 'Bulacan', 1300, NULL, '2024-12-10 09:18:09', '2024-12-10 09:18:09'),
(8, 6, 'Imus Cavite', 'District 2-Marinduque', 1300, NULL, '2024-12-10 09:18:26', '2024-12-10 09:18:26'),
(9, 6, 'General Trias Cavite', 'District 1-Marinduque', 1300, NULL, '2024-12-10 09:18:43', '2024-12-10 09:18:43'),
(10, 6, 'Trece Cavite', 'District 1-Marinduque', 1300, NULL, '2024-12-10 09:19:04', '2024-12-10 09:19:04'),
(11, 6, 'Bulacan', 'District 1-Marinduque', 1300, NULL, '2024-12-10 09:19:14', '2024-12-10 09:19:14');

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
(2, 'Susan Nace', 'dreamfavor@hulas.co', NULL, '2024-11-19 14:00:34', '$2y$10$3merddI6HGzgnmaq1lSl6.UejR6eqZzDWhkx27bhBNwGtD8TmVMYG', NULL, 'org', NULL, 0, '2024-11-19 13:59:46', '2024-11-20 13:29:51'),
(3, 'Steve Rogers', 'steverogers@hulas.co', NULL, '2024-11-19 14:29:37', '$2y$10$n9blxnfouKlpKo..nBCjyu7X0ahncXeprb0Qm51jWTQJOFp2zaiCK', '1732035070.jpg', 'client', 'tajBcNt6mPXEqt8T87CTKkIpaF6E5fZnpl5dd8tV6M4FnM41yll4GBPNa8Nm', 0, '2024-11-19 14:29:05', '2024-11-20 14:52:41'),
(5, 'Jean Worth', 'marinduquevehiclerental@hulas.co', NULL, '2024-11-23 13:21:23', '$2y$10$YMEJfHHsGiOEGU5swQBbzOC76U6TFjF7qI4X6Z6b2W6Pt7PNJntce', NULL, 'org', NULL, 0, '2024-11-23 13:17:33', '2024-11-23 13:21:23'),
(6, 'Roderick Butardo', 'luzondatumtransportcoop@hulas.co', NULL, '2024-11-23 15:44:14', '$2y$10$CpAxO6g0rQHFxCxJ7GhlPuIxicduH3widSJFH.PCMu3IGpETHS0f2', NULL, 'org', NULL, 0, '2024-11-23 13:19:29', '2024-11-23 15:44:14'),
(7, 'Tony Stark', 'tonystark@hulas.co', NULL, '2024-12-01 13:40:14', '$2y$10$P8wFwEZJqM/DkOnenHdGVOrTwZ5ZJPfOnkPYNETO4KHDsCyJ110jW', NULL, 'client', NULL, 0, '2024-12-01 13:39:35', '2024-12-01 13:40:14'),
(8, 'Christopher Rebistual', 'rebistual@hulas.co', NULL, '2024-12-10 00:03:15', '$2y$10$5y7E8IgTrbLNVdt4lKi4Qu9el9nZ5TGcbyOuz/GDK5FqJEiuXpoci', NULL, 'org', NULL, 0, '2024-12-10 00:00:30', '2024-12-10 00:03:15'),
(9, 'Eunice De Luna-Malinao', 'malinao@hulas.co', NULL, '2024-12-10 00:06:22', '$2y$10$obGYubdi5H.3EqUL8PNjj.an.oIcccuaBtl.kHh.aHuKdB2r3PkFu', NULL, 'org', NULL, 0, '2024-12-10 00:05:24', '2024-12-10 00:06:22'),
(10, 'Beneden Logmao', 'logmao@hulas.co', NULL, '2024-12-10 00:08:44', '$2y$10$rBwjr64QGZcTdgdhDdTo6O6XjVvVyzcEhyjfOb4dLAaUauZjrtP/S', NULL, 'org', NULL, 0, '2024-12-10 00:07:54', '2024-12-10 00:08:44'),
(11, 'Rochelle Manggol', 'manggol.rochelle@marsu.edu.ph', NULL, '2024-12-10 00:54:15', '$2y$10$z5zBLhDi5gPNyPKTFpQtAenhfiJov/wMvjQLmX0aXqY7IPpPxY672', NULL, 'client', NULL, 0, '2024-12-10 00:53:58', '2024-12-10 00:54:15');

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
  `plate_number` varchar(100) NOT NULL,
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

INSERT INTO `vehicles` (`id`, `user_id`, `vehicle_category_id`, `brand`, `model`, `plate_number`, `rent_options`, `image`, `is_available`, `rate`, `rate_w_driver`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 5, 1, 'YAMAHA', 'YAMAHA NMAX155', 'werwer', 'Without Driver', '1732369770.png', 1, 600.00, NULL, '2024-11-23 13:49:30', '2024-12-10 01:42:56', '2024-12-10 01:42:56'),
(2, 5, 1, 'Honda', 'PCX160', 'sdfsdf', 'Without Driver', '1732369944.png', 1, 600.00, NULL, '2024-11-23 13:52:24', '2024-12-10 01:43:01', '2024-12-10 01:43:01'),
(3, 5, 2, 'Toyota', 'Toyota Rush-SUV', 'sdfsdf', 'Both', '1732375764.png', 1, 3500.00, 4500, '2024-11-23 15:29:24', '2024-12-10 01:43:08', '2024-12-10 01:43:08'),
(4, 2, 6, 'Chevrolet', 'Chevy Chevelle 2020', 'grwer', 'Both', '1732542522.jpg', 0, 6000.00, 7000, '2024-11-25 13:48:42', '2024-12-09 23:50:55', NULL),
(5, 5, 4, 'Chevrolet 1 edited', 'Chevy Chevelle 2020', 'CHVY209', 'Both', '1733059919.jpg', 0, 4500.00, 5000, '2024-12-01 13:31:59', '2024-12-10 01:28:12', '2024-12-10 01:28:12'),
(6, 5, 1, 'Honda', 'Beat (Matte Axis Gray Metallic)', '****', 'Without Driver', '1733794484.png', 1, 400.00, NULL, '2024-12-10 01:34:44', '2024-12-10 01:43:12', '2024-12-10 01:43:12'),
(7, 5, 1, 'Honda', 'Beat (Pearl Nightfall Blue)', '*****', 'Without Driver', '1733794541.png', 0, 400.00, NULL, '2024-12-10 01:35:41', '2024-12-10 01:43:17', '2024-12-10 01:43:17'),
(8, 5, 1, 'Rusi', 'RC125', '10VQA', 'Without Driver', '1733794618.png', 1, 300.00, NULL, '2024-12-10 01:36:58', '2024-12-10 01:42:03', NULL),
(9, 5, 3, 'Toyota', 'Innova', '30MVS', 'With Driver', '1733794675.png', 0, NULL, 5000, '2024-12-10 01:37:55', '2024-12-10 01:47:05', '2024-12-10 01:47:05'),
(10, 5, 4, 'Toyota', 'Vios', 'MAD 6273', 'With Driver', '1733794793.png', 1, NULL, 3000, '2024-12-10 01:39:53', '2024-12-10 01:42:00', NULL),
(11, 5, 1, 'YAMAHA', 'NMAX 155', '731 VQF', 'Without Driver', '1733795070.png', 1, 600.00, NULL, '2024-12-10 01:44:30', '2024-12-10 02:45:56', NULL),
(12, 5, 1, 'Honda', 'PCX160', '29MAB', 'Without Driver', '1733795100.png', 1, 600.00, NULL, '2024-12-10 01:45:00', '2024-12-10 02:46:11', NULL),
(13, 5, 1, 'Honda', 'Beat (Matte Axis Gray Metallic)', '921QEY', 'Without Driver', '1733795138.png', 1, 400.00, NULL, '2024-12-10 01:45:38', '2024-12-10 02:46:03', NULL),
(14, 5, 1, 'Honda', 'Beat (Pearl Nightfall Blue)', '128MAI', 'Without Driver', '1733795171.png', 1, 400.00, NULL, '2024-12-10 01:46:11', '2024-12-10 02:46:06', NULL),
(15, 5, 2, 'Toyota', 'Rush', 'BAD 1736', 'With Driver', '1733795301.png', 1, NULL, 4500, '2024-12-10 01:48:21', '2024-12-10 02:46:18', NULL),
(16, 5, 3, 'Toyota', 'Innova', 'MVD 3728', 'With Driver', '1733795336.png', 1, NULL, 5000, '2024-12-10 01:48:56', '2024-12-10 02:46:14', NULL);

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
(6, 2, 'Cars', '2024-11-25 13:47:15', '2024-11-25 13:47:15', NULL),
(7, 6, 'Van', '2024-12-10 01:00:20', '2024-12-10 01:02:26', '2024-12-10 01:02:26'),
(8, 5, 'Boat', '2024-12-10 01:59:26', '2024-12-10 01:59:53', '2024-12-10 01:59:53');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_returns`
--

CREATE TABLE `vehicle_returns` (
  `id` int(10) NOT NULL,
  `booking_id` bigint(20) NOT NULL,
  `return_reason` varchar(5000) DEFAULT NULL,
  `penalty` double DEFAULT 0,
  `status` varchar(100) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_returns`
--

INSERT INTO `vehicle_returns` (`id`, `booking_id`, `return_reason`, `penalty`, `status`, `deleted_at`, `updated_at`, `created_at`) VALUES
(1, 23, 'No valid reason', 1475, 'pending', NULL, '2024-12-16 00:30:20', '2024-12-16 00:30:20');

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
-- Indexes for table `cancellation_details`
--
ALTER TABLE `cancellation_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cancellation_rates`
--
ALTER TABLE `cancellation_rates`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `extension_requests`
--
ALTER TABLE `extension_requests`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_feedbacks`
--
ALTER TABLE `gallery_feedbacks`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `vehicle_returns`
--
ALTER TABLE `vehicle_returns`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_rates`
--
ALTER TABLE `additional_rates`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `booking_logs`
--
ALTER TABLE `booking_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `cancellation_details`
--
ALTER TABLE `cancellation_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cancellation_rates`
--
ALTER TABLE `cancellation_rates`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
-- AUTO_INCREMENT for table `extension_requests`
--
ALTER TABLE `extension_requests`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gallery_feedbacks`
--
ALTER TABLE `gallery_feedbacks`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vehicle_categories`
--
ALTER TABLE `vehicle_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vehicle_returns`
--
ALTER TABLE `vehicle_returns`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
