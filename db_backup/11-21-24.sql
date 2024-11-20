-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2024 at 05:42 PM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_contact_number_unique` (`contact_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
