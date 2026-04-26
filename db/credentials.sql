-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2026 at 09:21 AM
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
-- Database: `credentials`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) UNSIGNED NOT NULL,
  `client_name` varchar(191) NOT NULL,
  `encrypted_client_data` mediumtext NOT NULL,
  `iv` text NOT NULL,
  `salt` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_name`, `encrypted_client_data`, `iv`, `salt`, `created_at`, `updated_at`) VALUES
(1, 'Sample Client', 'xq/OJ8y9nnHrqH+gVyb0tbNC3JMranoZnvzzRvvS92KynZXNuzgVYhEUEJAs4DjX', 'UrcdEoPn9Rty2W/R7bX2Aw==', 'czBGNw99E3ahUcLjPg7uSMRDslgUnlu3JxkblMKknoU=', NULL, NULL),
(2, 'Test client one', 'cAapzG5pk+zdsMHzXDD7iUtiLQu4hdQt4UDEfQ8a6z47lvK8nx3QDVJzWkP3Cyf3mTOh6BkxyorBN3kn0iEIPQLRp5kWXJNefw+bCnebkYASDBNONGEzkVTH1FoHtD3iH+EtJBrMl6y57PYG4KMK/rsj03lRb1Dbf92+ExWsnJbELftSspsRjefzyaYyD8Oy2b/cmnIA7vt7HL/b0FIFx/24vsrH/r2osM1hq0Uy0ad4aL6ZCsSPavQIIvfXGUvv7yRmIedTh6J2br2gF9y+YVqT4tLQzRxgI68HTkN8s5cgKzHggO2FX4FKF/3djLZSf+VsUDyhBY5O8v/Uk1/uF03WUaNpvCWALftlyrKHDheWt1XoTflGVFR6M+6JA/YmECA7GxbaosLqpcHW5Rc59YGC51YeoTXZJIIHbinz1eE4/6CMZocv0+z3dEHZp1llzktrSN4FUYnaZhonun5Mar9psRE9AlSqErfjKfoc4huULc1qy5beeTHzGwO7BI3u5s7b8AXbRYmslAUxIbsQ287tUZQn+uNDeh4PMEFX1ATrKB581kXXBGGMVkTEV0DH', 'PK9qaO1nwwFjlkpYqbbo9Q==', 'pXAnzpH/1Ev7EuuMTLYJDEFMTfTDwijEXWw2hHjWrZA=', '2026-04-25 19:16:07', '2026-04-25 19:46:13');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-04-26-000001', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1777142791, 1),
(2, '2026-04-26-000002', 'App\\Database\\Migrations\\CreateClientsTable', 'default', 'App', 1777142791, 1),
(3, '2026-04-26-000003', 'App\\Database\\Migrations\\CreateUserClientAccessTable', 'default', 'App', 1777142791, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `role`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', '$2y$10$kS/Br26oDv17D7o/USF3neJ17/iaPIGEVWJzRph0jkYkOu7fwGIFe', 'super_admin', 1, NULL, '2026-04-25 19:38:17'),
(2, 'viewer', '$2y$10$3yDtNb0TRXKb6362ke2Bs.DLa8ZWVlsaAV7tQDh8UBGB8NAZxGqtm', 'viewer_user', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_client_access`
--

CREATE TABLE `user_client_access` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `client_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_client_access`
--

INSERT INTO `user_client_access` (`id`, `user_id`, `client_id`) VALUES
(1, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_name` (`client_name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `user_client_access`
--
ALTER TABLE `user_client_access`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_client_id` (`user_id`,`client_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `client_id` (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_client_access`
--
ALTER TABLE `user_client_access`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_client_access`
--
ALTER TABLE `user_client_access`
  ADD CONSTRAINT `user_client_access_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_client_access_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
