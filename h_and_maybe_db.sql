-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2025 at 12:26 PM
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
-- Database: `h_and_maybe_db`
--
CREATE DATABASE IF NOT EXISTS `h_and_maybe_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `h_and_maybe_db`;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `address_line1` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postal_code` int(10) NOT NULL,
  `country` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `user_id`, `address_line1`, `city`, `state`, `postal_code`, `country`) VALUES
(1, 1, '69, Jalan 1, Ampang Jaya', 'Ampang', 'Selangor', 68000, 'Malaysia'),
(2, 2, '37, Jalan Beberek, Kepong Baru', 'Kuala Lumpur', 'Kuala Lumpur', 52100, 'Malaysia'),
(3, 3, '123, Main Street, Apt 4B', 'Springfield', 'Illinois', 62704, 'USA'),
(4, 4, '12, Ocean Avenue', 'Sydney', 'New South Wales', 2000, 'Australia'),
(5, 5, '23, Solok Relau 2, Sentral Greens', 'Bayan Lepas', 'Pulau Pinang', 11900, 'Malaysia');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `created_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `created_at`) VALUES
(6, 6, '2025-05-01 15:37:05.000000');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(5) NOT NULL,
  `cart_id` int(5) NOT NULL,
  `variation_id` int(5) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(5) NOT NULL,
  `category` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category`) VALUES
(1, 'Women'),
(2, 'Men');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `created_at` datetime(6) NOT NULL,
  `status` varchar(10) NOT NULL,
  `shipping_fee` int(10) NOT NULL,
  `total_amount` int(10) NOT NULL,
  `address_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(5) NOT NULL,
  `order_id` int(5) NOT NULL,
  `variation_id` int(5) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `token` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category_id` int(5) NOT NULL,
  `description` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `created_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `category_id`, `description`, `price`, `created_at`) VALUES
(1, 'Classic Crew T-Shirt', 2, 'Timeless and versatile, this soft cotton crewneck tee is perfect for everyday wear.', 24.9, '2025-03-16 01:35:00.000000'),
(2, 'V-Neck Essential Tee', 2, 'A sleek V-neck t-shirt made from a soft cotton blend, ideal for casual or layered looks.', 29.9, '2025-03-16 02:16:00.000000'),
(3, 'Slim Fit Jeans', 2, 'Classic slim-fit jeans crafted from durable denim for everyday comfort. Available in light, medium, and dark washes.', 99.9, '2025-03-16 02:16:00.000000'),
(4, 'Cargo Pants', 2, 'Stylish cargo pants featuring multiple pockets for functionality. Perfect for casual and outdoor wear.', 79.9, '2025-03-16 01:12:00.000000'),
(5, 'High-Waisted Skirt', 1, 'Chic high-waisted skirt with a sleek silhouette, ideal for both office and casual looks.', 79.9, '2025-03-16 04:56:00.000000'),
(6, 'Athletic Joggers', 1, 'Comfortable athletic joggers made from soft, stretchable fabric. Ideal for workouts or lounging.', 69.9, '2025-03-16 00:16:00.000000'),
(7, 'Graphic Print Tee', 1, 'Stand out with a bold graphic print, crafted from breathable fabric for all-day comfort.', 54.9, '2025-03-16 01:16:00.000000'),
(8, 'Cropped V-Neck T-Shirt', 1, 'Minimalist cropped V-neck T-shirt made from soft cotton, perfect for a casual, everyday look.', 27.9, '2025-03-16 00:38:00.000000'),
(9, 'Long Shirt', 2, 'A long shirt.', 39.9, '2025-05-01 02:16:24.000000');

-- --------------------------------------------------------

--
-- Table structure for table `product_variation`
--

CREATE TABLE `product_variation` (
  `variation_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `size` varchar(5) NOT NULL,
  `color` varchar(20) NOT NULL,
  `stock_quantity` int(10) NOT NULL,
  `product_photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variation`
--

INSERT INTO `product_variation` (`variation_id`, `product_id`, `size`, `color`, `stock_quantity`, `product_photo`) VALUES
(1, 1, 'XS', 'Light Beige', 20, 'crew-t-beige.avif'),
(2, 1, 'S', 'Light Beige', 12, 'crew-t-beige.avif'),
(3, 1, 'M', 'Light Beige', 45, 'crew-t-beige.avif'),
(4, 1, 'L', 'Light Beige', 6, 'crew-t-beige.avif'),
(5, 1, 'XL', 'Light Beige', 37, 'crew-t-beige.avif'),
(6, 1, 'XS', 'White', 50, 'crew-t-white.avif'),
(7, 1, 'S', 'White', 19, 'crew-t-white.avif'),
(8, 1, 'M', 'White', 0, 'crew-t-white.avif'),
(9, 1, 'L', 'White', 8, 'crew-t-white.avif'),
(10, 1, 'XL', 'White', 32, 'crew-t-white.avif'),
(11, 1, 'XS', 'Black', 28, 'crew-t-black.avif'),
(12, 1, 'S', 'Black', 14, 'crew-t-black.avif'),
(13, 1, 'M', 'Black', 46, 'crew-t-black.avif'),
(14, 1, 'L', 'Black', 41, 'crew-t-black.avif'),
(15, 1, 'XL', 'Black', 25, 'crew-t-black.avif'),
(16, 2, 'XS', 'Pink', 9, 'vneck-pink.avif'),
(17, 2, 'S', 'Pink', 33, 'vneck-pink.avif'),
(18, 2, 'M', 'Pink', 11, 'vneck-pink.avif'),
(19, 2, 'L', 'Pink', 5, 'vneck-pink.avif'),
(20, 2, 'XL', 'Pink', 39, 'vneck-pink.avif'),
(21, 2, 'XS', 'Navy Blue', 26, 'vneck-navy.avif'),
(22, 2, 'S', 'Navy Blue', 0, 'vneck-navy.avif'),
(23, 2, 'M', 'Navy Blue', 44, 'vneck-navy.avif'),
(24, 2, 'L', 'Navy Blue', 3, 'vneck-navy.avif'),
(25, 2, 'XL', 'Navy Blue', 18, 'vneck-navy.avif'),
(26, 3, 'XS', 'Dark Grey', 36, 'slim-jeans-grey.avif'),
(27, 3, 'S', 'Dark Grey', 48, 'slim-jeans-grey.avif'),
(28, 3, 'M', 'Dark Grey', 2, 'slim-jeans-grey.avif'),
(29, 3, 'L', 'Dark Grey', 40, 'slim-jeans-grey.avif'),
(30, 3, 'XL', 'Dark Grey', 7, 'slim-jeans-grey.avif'),
(31, 3, 'XS', 'Black', 22, 'slim-jeans-black.avif'),
(32, 3, 'S', 'Black', 0, 'slim-jeans-black.avif'),
(33, 3, 'M', 'Black', 31, 'slim-jeans-black.avif'),
(34, 3, 'L', 'Black', 4, 'slim-jeans-black.avif'),
(35, 3, 'XL', 'Black', 47, 'slim-jeans-black.avif'),
(36, 3, 'XS', 'Pale Blue', 29, 'slim-jeans-pale.avif'),
(37, 3, 'S', 'Pale Blue', 16, 'slim-jeans-pale.avif'),
(38, 3, 'M', 'Pale Blue', 43, 'slim-jeans-pale.avif'),
(39, 3, 'L', 'Pale Blue', 27, 'slim-jeans-pale.avif'),
(40, 3, 'XL', 'Pale Blue', 20, 'slim-jeans-pale.avif'),
(41, 4, 'XS', 'Light Beige', 30, 'cargo-pants-beige.avif'),
(42, 4, 'S', 'Light Beige', 38, 'cargo-pants-beige.avif'),
(43, 4, 'M', 'Light Beige', 13, 'cargo-pants-beige.avif'),
(44, 4, 'L', 'Light Beige', 21, 'cargo-pants-beige.avif'),
(45, 4, 'XL', 'Light Beige', 24, 'cargo-pants-beige.avif'),
(46, 4, 'XS', 'Dark Khaki Green', 34, 'cargo-pants-khaki.avif'),
(47, 4, 'S', 'Dark Khaki Green', 49, 'cargo-pants-khaki.avif'),
(48, 4, 'M', 'Dark Khaki Green', 10, 'cargo-pants-khaki.avif'),
(49, 4, 'L', 'Dark Khaki Green', 15, 'cargo-pants-khaki.avif'),
(50, 4, 'XL', 'Dark Khaki Green', 1, 'cargo-pants-khaki.avif'),
(51, 5, 'XS', 'Black', 42, 'high-skirt-black.avif'),
(52, 5, 'S', 'Black', 25, 'high-skirt-black.avif'),
(53, 5, 'M', 'Black', 12, 'high-skirt-black.avif'),
(54, 5, 'L', 'Black', 37, 'high-skirt-black.avif'),
(55, 5, 'XL', 'Black', 19, 'high-skirt-black.avif'),
(56, 5, 'XS', 'Dark Brown', 50, 'high-skirt-brown.avif'),
(57, 5, 'S', 'Dark Brown', 6, 'high-skirt-brown.avif'),
(58, 5, 'M', 'Dark Brown', 33, 'high-skirt-brown.avif'),
(59, 5, 'L', 'Dark Brown', 0, 'high-skirt-brown.avif'),
(60, 5, 'XL', 'Dark Brown', 5, 'high-skirt-brown.avif'),
(61, 5, 'XS', 'White', 32, 'high-skirt-white.avif'),
(62, 5, 'S', 'White', 8, 'high-skirt-white.avif'),
(63, 5, 'M', 'White', 28, 'high-skirt-white.avif'),
(64, 5, 'L', 'White', 23, 'high-skirt-white.avif'),
(65, 5, 'XL', 'White', 46, 'high-skirt-white.avif'),
(66, 6, 'XS', 'Pink', 41, 'jogger-pink.avif'),
(67, 6, 'S', 'Pink', 11, 'jogger-pink.avif'),
(68, 6, 'M', 'Pink', 45, 'jogger-pink.avif'),
(69, 6, 'L', 'Pink', 14, 'jogger-pink.avif'),
(70, 6, 'XL', 'Pink', 9, 'jogger-pink.avif'),
(71, 6, 'XS', 'Light Blue', 39, 'jogger-blue.avif'),
(72, 6, 'S', 'Light Blue', 0, 'jogger-blue.avif'),
(73, 6, 'M', 'Light Blue', 26, 'jogger-blue.avif'),
(74, 6, 'L', 'Light Blue', 3, 'jogger-blue.avif'),
(75, 6, 'XL', 'Light Blue', 36, 'jogger-blue.avif'),
(76, 6, 'XS', 'Dark Grey', 18, 'jogger-grey.avif'),
(77, 6, 'S', 'Dark Grey', 48, 'jogger-grey.avif'),
(78, 6, 'M', 'Dark Grey', 2, 'jogger-grey.avif'),
(79, 6, 'L', 'Dark Grey', 40, 'jogger-grey.avif'),
(80, 6, 'XL', 'Dark Grey', 7, 'jogger-grey.avif'),
(81, 7, 'XS', 'Cream', 22, 'graphics-tee-cream.avif'),
(82, 7, 'S', 'Cream', 47, 'graphics-tee-cream.avif'),
(83, 7, 'M', 'Cream', 0, 'graphics-tee-cream.avif'),
(84, 7, 'L', 'Cream', 31, 'graphics-tee-cream.avif'),
(85, 7, 'XL', 'Cream', 4, 'graphics-tee-cream.avif'),
(86, 7, 'XS', 'Dark Grey', 29, 'graphics-tee-grey.avif'),
(87, 7, 'S', 'Dark Grey', 43, 'graphics-tee-grey.avif'),
(88, 7, 'M', 'Dark Grey', 16, 'graphics-tee-grey.avif'),
(89, 7, 'L', 'Dark Grey', 27, 'graphics-tee-grey.avif'),
(90, 7, 'XL', 'Dark Grey', 20, 'graphics-tee-grey.avif'),
(91, 8, 'XS', 'Black', 30, 'v-neck-black.avif'),
(92, 8, 'S', 'Black', 38, 'v-neck-black.avif'),
(93, 8, 'M', 'Black', 13, 'v-neck-black.avif'),
(94, 8, 'L', 'Black', 21, 'v-neck-black.avif'),
(95, 8, 'XL', 'Black', 24, 'v-neck-black.avif'),
(96, 8, 'XS', 'White', 34, 'v-neck-white.avif'),
(97, 8, 'S', 'White', 49, 'v-neck-white.avif'),
(98, 8, 'M', 'White', 10, 'v-neck-white.avif'),
(99, 8, 'L', 'White', 15, 'v-neck-white.avif'),
(100, 8, 'XL', 'White', 1, 'v-neck-white.avif');

-- --------------------------------------------------------

--
-- Table structure for table `remember_tokens`
--

CREATE TABLE `remember_tokens` (
  `user_id` int(11) NOT NULL,
  `token_hash` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(5) NOT NULL,
  `role` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `age` int(10) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `phone_no` int(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `profile_photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `role`, `name`, `password`, `age`, `gender`, `phone_no`, `email`, `profile_photo`) VALUES
(1, 'Admin', 'Chea Ming Shen', '8cb2237d0679ca88db6464eac60da96345513964', 21, 'M', 123456789, 'cms@gmail.com', 'cms_pfp.png'),
(2, 'Admin', 'Chong Ming Li', '8cb2237d0679ca88db6464eac60da96345513964', 21, 'M', 141047104, 'cml@gmail.com', 'cml_pfp.png'),
(3, 'Member', 'Elaine Pang', '8cb2237d0679ca88db6464eac60da96345513964', 21, 'F', 184012398, 'ep@gmail.com', 'ep_pfp.png'),
(4, 'Member', 'Sum Ting Wong', '8cb2237d0679ca88db6464eac60da96345513964', 30, 'M', 175419326, 'stw@gmail.com', 'stw_pfp.png'),
(5, 'Member', 'Ho Lee Fuk', '8cb2237d0679ca88db6464eac60da96345513964', 25, 'F', 190213092, 'hlf@gmail.com', 'hlf_pfp.png'),
(6, 'Member', 'Ming Li Test', '7c4a8d09ca3762af61e59520943dc26494f8941b', 21, 'F', 123456789, 'minglilau9@gmail.com', '68132d3842f3d.jpg'),
(7, 'Member', 'tung', '7869a357b954e36df60655b17ef3ac09d6e600dd', 12, 'M', 123456789, 'tung@gmail.com', '68126e795d830.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `variation_id` (`variation_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `address_id` (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `variation_id` (`variation_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_variation`
--
ALTER TABLE `product_variation`
  ADD PRIMARY KEY (`variation_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_variation`
--
ALTER TABLE `product_variation`
  MODIFY `variation_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`variation_id`) REFERENCES `product_variation` (`variation_id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`variation_id`) REFERENCES `product_variation` (`variation_id`);

--
-- Constraints for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD CONSTRAINT `password_reset_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `product_variation`
--
ALTER TABLE `product_variation`
  ADD CONSTRAINT `product_variation_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `remember_tokens`
--
ALTER TABLE `remember_tokens`
  ADD CONSTRAINT `remember_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
