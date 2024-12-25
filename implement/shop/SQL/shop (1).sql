-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2024 at 11:11 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `email`, `password`, `full_name`, `created_at`) VALUES
(1, 'mohamed ', 'mohamed@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, '2024-12-10 14:02:18');

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `id` int(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `confirm` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`id`, `username`, `email`, `password`, `confirm`, `phone`, `address`, `photo`) VALUES
(17, 'admin', 'admin@gmail.com', '98741', '98741', '01010752506', 'alex', ''),
(18, 'admin2', 'emo@gmail.com', '8520', '8520', '01114650147', 'menofia', ''),
(19, 'mohamed', 'mohamed@gmail.com', '0000', '0000', '01010752506', 'menofia', ''),
(20, '', 'henish@gmail.com', '1111', '1111', '01010752506', 'wd', 'images/3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(25) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `user_id` int(11) DEFAULT NULL,
  `guest_id` varchar(11) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `product_id`, `product_name`, `image`, `price`, `quantity`, `total_price`, `user_id`, `guest_id`, `date_added`) VALUES
(382, 24, 'samsung', 'latest.jpg', '3500.00', 1, '3500.00', NULL, '218', '2024-12-25 09:14:50'),
(384, 22, 'iPhone', 'iphone13.png', '2500.00', 1, '2500.00', NULL, '222', '2024-12-25 09:19:16'),
(385, 27, 'gfchj', '113.jpg', '9.00', 1, '9.00', NULL, '222', '2024-12-25 09:19:18'),
(386, 22, 'iPhone', 'iphone13.png', '2500.00', 1, '2500.00', NULL, '254', '2024-12-25 09:31:40');

-- --------------------------------------------------------

--
-- Table structure for table `checkout_data`
--

CREATE TABLE `checkout_data` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `visa_card` varchar(19) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkout_data`
--

INSERT INTO `checkout_data` (`id`, `name`, `phone`, `address`, `email`, `visa_card`, `user_id`, `guest_id`, `created_at`) VALUES
(87, 'mohamed ', '01010752506', 'menofia', 'mohamed@gmail.com', 'faa2f4be61332437590', NULL, 70, '2024-12-19 14:08:18'),
(88, 'mohamed ', '01114650147', 'cairo', 'mero@gmail.com', 'bcba62e46b695ccee99', 41, NULL, '2024-12-19 14:12:59'),
(89, 'mohamed ', '01010752506', 'cairo', 'mohamed@gmail.com', 'bcba62e46b695ccee99', 41, NULL, '2024-12-19 14:23:39'),
(90, 'phone', 'wd', 'ujhk', 'emo@gmail.com', '17111dd1e5b53a72130', 41, NULL, '2024-12-19 14:42:58'),
(91, 'mohamed 2', '01010752506', 'alex', 'mohamed@gmail.com', '15a2a347d40ace11866', 40, NULL, '2024-12-19 14:44:38');

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `guest_id` int(11) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guest_product`
--

CREATE TABLE `guest_product` (
  `id` int(11) NOT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `amount` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `price`, `description`, `image`, `amount`) VALUES
(22, 'iPhone', '2500.00', 'nice phone', 'iphone13.png', '6'),
(23, 'camera', '2500.00', 'good camera', '3.jpg', '0'),
(24, 'samsung', '3500.00', 'nice phone it work will', 'latest.jpg', '0'),
(25, 'camera0', '200.00', 'good camera', 'Camera.jpg.jpg', '4'),
(26, 'labtop', '2500.00', 'speed labtop', 'download.jpg', '0'),
(27, 'gfchj', '9.00', 'gxhj', '113.jpg', '5');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `user_id`, `guest_id`, `username`, `phone`, `email`, `review`, `created_at`) VALUES
(13, 41, NULL, 'mohamed ', '01114650147', 'mero@gmail.com', 'hellow', '2024-12-19 14:13:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `full_name`, `address`, `phone`, `created_at`) VALUES
(40, 'hamooooo', 'mohamed@gmail.com', 'e34a8899ef6468b74f8a1048419ccc8b', 'mohamed ali antar', 'alex', '01010752506', '2024-12-18 19:36:28'),
(41, 'mohamed ', 'mero@gmail.com', '3bad6af0fa4b8b330d162e19938ee981', 'mohamed ali hegazy', 'cairo', '01010752506', '2024-12-19 07:11:32'),
(42, 'dxfcgvhbm', 'b@a.com', 'd79c8788088c2193f0244d8f1f36d2db', 'zetxgfchjvbk', 'cairo', '01010752506', '2024-12-22 08:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `user_product`
--

CREATE TABLE `user_product` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_product`
--

INSERT INTO `user_product` (`id`, `user_id`, `product_id`, `product_name`, `price`, `image`, `quantity`, `date_added`) VALUES
(129, 41, 20, 'samsung', '3200.00', 'latest.jpg', 4, '2024-12-19 14:11:59'),
(130, 41, 21, 'labtop', '25000.00', 'gaming.png', 4, '2024-12-19 14:11:59'),
(131, 41, 19, 'phone', '3500.00', 'IMG-20230513-WA0044 (1).jpg', 4, '2024-12-19 14:11:59'),
(132, 41, 18, 'camera', '2500.00', '3.jpg', 4, '2024-12-19 14:11:59'),
(133, 41, 22, 'iPhone', '2500.00', 'iphone13.png', 3, '2024-12-19 14:22:42'),
(134, 41, 23, 'camera', '2500.00', '3.jpg', 1, '2024-12-19 14:42:38'),
(135, 41, 24, 'samsung', '3500.00', 'latest.jpg', 3, '2024-12-19 14:42:38'),
(136, 41, 25, 'camera0', '200.00', 'Camera.jpg.jpg', 3, '2024-12-19 14:42:38'),
(137, 41, 26, 'labtop', '2500.00', 'download.jpg', 3, '2024-12-19 14:42:38'),
(138, 40, 26, 'labtop', '2500.00', 'download.jpg', 1, '2024-12-19 14:44:12'),
(139, 40, 25, 'camera0', '200.00', 'Camera.jpg.jpg', 1, '2024-12-19 14:44:12'),
(140, 40, 24, 'samsung', '3500.00', 'latest.jpg', 1, '2024-12-19 14:44:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `checkout_data`
--
ALTER TABLE `checkout_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`guest_id`),
  ADD UNIQUE KEY `session_id` (`session_id`);

--
-- Indexes for table `guest_product`
--
ALTER TABLE `guest_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_id` (`guest_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_user_fk` (`user_id`),
  ADD KEY `review_guest_fk` (`guest_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_product`
--
ALTER TABLE `user_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=391;

--
-- AUTO_INCREMENT for table `checkout_data`
--
ALTER TABLE `checkout_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `guest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;

--
-- AUTO_INCREMENT for table `guest_product`
--
ALTER TABLE `guest_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `user_product`
--
ALTER TABLE `user_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guest_product`
--
ALTER TABLE `guest_product`
  ADD CONSTRAINT `guest_product_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`guest_id`) ON DELETE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_guest_fk` FOREIGN KEY (`guest_id`) REFERENCES `guests` (`guest_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_product`
--
ALTER TABLE `user_product`
  ADD CONSTRAINT `user_product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
