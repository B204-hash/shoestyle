-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2025 at 04:18 PM
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
-- Database: `shoestyle`
--

-- --------------------------------------------------------

--
-- Table structure for table `card_details`
--

CREATE TABLE `card_details` (
  `card_id` int(11) NOT NULL,
  `card_holder_name` varchar(100) NOT NULL,
  `card_cvv_enc` varchar(255) NOT NULL,
  `card_exp_date` date NOT NULL,
  `card_nr_enc` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `card_details`
--

INSERT INTO `card_details` (`card_id`, `card_holder_name`, `card_cvv_enc`, `card_exp_date`, `card_nr_enc`, `created_at`, `user_id`) VALUES
(3, 'test klient', 'S618LQcyCQy/OmmlTITr4XNnUVVxbTgvMXo1RmJDL1drYUI1RUE9PQ==', '0000-00-00', 'XeMcd30BWj9Lr42WXXrkFlNXQXFqKzZEVGNUeTBCVzViMlFsRzhlWUl6eWtsK0F2Rjh0SUVtZ3Zka0E9', '2025-07-27 10:26:30', 10),
(4, 'brisild velo', '3nEg60GWdkPEj4QP/cDmO2JQNzdkSHFXaHEySSszOEZJM0w0Qnc9PQ==', '0000-00-00', 'ULXGTFKJQ5hb4Mt3B+NPpGIvNlJMWUVCMEhGRUQvNFM0OUxLOUNWcHkzaThnUG9ObEQvdFZ6dTVtekU9', '2025-07-28 17:25:03', 10),
(5, 'abas velo', '6jB8k+YloT7kPhCsGJl94StZZ3JHeFdiVjdZWElqSndTVFVLVmc9PQ==', '0000-00-00', 'qhPXYKs5JRZISUrydcTqaGFhWS9FREp5TkxsZnRvNklpYnN1T3pBa1k1ZnlSMVFmZ2V6eXdDN3lTL1U9', '2025-07-28 17:36:55', 10),
(6, 'brisild velo', 'szD6I+Se3X9Efz/go7R0HEJVYUJYRVBxbDBuV0FTbGVRYXZ0VkE9PQ==', '0000-00-00', 'Nz/13EVvDXHxediLgEIrJVk3TGpueVYxeiticjFFaUl1ZlRVQ2h1UHpvL01xWmxoaE1Id3pMc2pkak09', '2025-07-30 13:49:25', 10),
(7, 'brisild velo', 'JEMSuA1QhoRBr7ALj2E/EFFzVnV6cjZsSjZ4aENURzFFV1dKL2c9PQ==', '0000-00-00', 'fY+K/XWI55uF2JNVls0IYUdzTWlyc0NTemdBdzVBRndERlJvYitobHV3Skw4NlZ6YkpIYjlVSlk5czg9', '2025-07-30 13:59:37', 10),
(8, 'brisild velo', 'QBXo9yM+hwi1d5nWOnd8/jhlQk5EWEp3aTZLdnJ2MDBsOUdBbVE9PQ==', '0000-00-00', 't5q+WX2MTX3S5dBneQQVymFWcTN4UVNwY0xadURvbjJhMkxvb1NRYlRJSDY0ayt3Unp5amxoL2VtL3M9', '2025-07-31 09:46:54', 10),
(9, 'brisild velo', 'yLZQQxwxD2Aao2MqOxwXgmRXZmEzUjN0czAxZGZPcFNCUWlqQnc9PQ==', '0000-00-00', 'wSJWdagij8DEwsTYbrnKo1pFdzh1MlMzcUREWVA5T2c5U1hEdlRpZU1Dc3ZTdmNuVWZlbDd1NE5RYmM9', '2025-07-31 09:56:19', 10);

-- --------------------------------------------------------

--
-- Table structure for table `payment_info`
--

CREATE TABLE `payment_info` (
  `payment_id` int(11) NOT NULL,
  `final_price` decimal(10,2) NOT NULL,
  `payment_method` enum('card') DEFAULT 'card',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `card_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_info`
--

INSERT INTO `payment_info` (`payment_id`, `final_price`, `payment_method`, `payment_date`, `card_id`) VALUES
(7, 100.00, 'card', '2025-07-27 10:26:30', 3),
(8, 100.00, 'card', '2025-07-28 17:25:03', 4),
(9, 200.00, 'card', '2025-07-28 17:36:55', 5),
(10, 150.00, 'card', '2025-07-30 13:49:25', 6),
(11, 50.00, 'card', '2025-07-30 13:59:37', 7),
(12, 150.00, 'card', '2025-07-31 09:46:54', 8),
(13, 200.00, 'card', '2025-07-31 09:56:19', 9);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` enum('men','women') NOT NULL,
  `stock` int(11) DEFAULT 0,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `image`, `price`, `category`, `stock`, `description`) VALUES
(2, 'shoe', 'uploads/1753809209_sh1.jpg', 100.00, 'men', 19, '.'),
(3, 'shoe2', 'uploads/1753809230_sh2.jpg', 50.00, 'men', 19, '..........'),
(4, 'shoe_women', 'uploads/1753809246_sh5.jpg', 50.00, 'women', 19, 'summer shoe'),
(5, 'shoe_woman_2', 'uploads/1753961124_sh6.jpg', 200.00, 'women', 21, '...');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`purchase_id`, `payment_id`, `product_id`, `quantity`, `unit_price`) VALUES
(1, 7, 2, 1, 100.00),
(2, 8, 2, 1, 100.00),
(3, 9, 2, 1, 100.00),
(4, 9, 3, 2, 50.00),
(5, 10, 4, 3, 50.00),
(6, 11, 3, 1, 50.00),
(7, 12, 4, 3, 50.00),
(8, 13, 4, 4, 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(0, 'Client'),
(1, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `role_id` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `full_name`, `phone_number`, `role_id`, `created_at`, `updated_at`, `city`, `country`, `postal_code`, `password_hash`) VALUES
(5, 'admin2', 'brisild.velo@fti.edu.al', 'Brisild Velo', '0688443927', 1, '2025-07-24 09:02:25', '2025-07-24 09:36:07', NULL, NULL, NULL, '$2y$10$XWsNE8e/11Ruso.W8qsha.jjIKaT/rsDsSlEU0nqEb9Nq7z6F15sC'),
(8, 'brisild', 'brisild.velo17@fti.edu.al', 'Brisild Velo', '0688443927', 1, '2025-07-24 09:03:31', '2025-07-24 09:03:31', NULL, NULL, NULL, '$2y$10$M.8A/8/2MDVlSjEhxJ.df.8ekLhfLeWKR/ksPEMPRewNmnmMhTZSq'),
(10, 'brisild1', 'brisildvelo17@gmail.com', 'Brisild Velo', '0688443927', 0, '2025-07-26 08:10:30', '2025-07-30 11:38:37', 'Tirane', 'Albania', '1015', '$2y$10$E2hpUs5gEUwIxJ4no9NMY.EJiJRo8djUdasdhDjj77zYMN/eVuC1C'),
(11, 'admin', NULL, NULL, NULL, 1, '2025-07-27 08:38:24', '2025-07-27 08:38:24', NULL, NULL, NULL, '$2y$10$VgW.1NmDLRdCipxiEtOihe1TnDh/aGvD6CiCfg0ENr6EgOik7islq'),
(13, 'sildi', NULL, 'brisild velo', '0688443927', 0, '2025-07-28 17:49:04', '2025-07-28 17:49:04', 'Tirane', 'Albania', '1015', ''),
(14, '', 'aleksvelo@gmail.com', NULL, NULL, 0, '2025-07-30 14:13:25', '2025-07-30 14:13:25', NULL, NULL, NULL, '$2y$10$yU6Lna4lhwdii8UVV0VoPOMLkEfgWyi8r/JXXR5i4F20P9N0iqO96');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card_details`
--
ALTER TABLE `card_details`
  ADD PRIMARY KEY (`card_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payment_info`
--
ALTER TABLE `payment_info`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `card_id` (`card_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `card_details`
--
ALTER TABLE `card_details`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment_info`
--
ALTER TABLE `payment_info`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `card_details`
--
ALTER TABLE `card_details`
  ADD CONSTRAINT `card_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `payment_info`
--
ALTER TABLE `payment_info`
  ADD CONSTRAINT `payment_info_ibfk_1` FOREIGN KEY (`card_id`) REFERENCES `card_details` (`card_id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payment_info` (`payment_id`),
  ADD CONSTRAINT `purchases_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
