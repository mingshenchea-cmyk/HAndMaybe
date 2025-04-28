-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2025 at 07:21 PM
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
(1, 1, '2025-04-28 00:30:10.000000');

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

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `variation_id`, `quantity`) VALUES
(1, 1, 1, 2),
(2, 1, 2, 2),
(3, 1, 3, 2);

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
  `product_id` int(5) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(10) NOT NULL,
  `description` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `created_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `category`, `description`, `price`, `created_at`) VALUES
(1, 'Classic Crew T-Shirt', 'Men', 'Timeless and versatile, this soft cotton crewneck tee is perfect for everyday wear.', 24.9, '2025-03-16 01:35:00.000000'),
(2, 'V-Neck Essential Tee', 'Men', 'A sleek V-neck t-shirt made from a soft cotton blend, ideal for casual or layered looks.', 29.9, '2025-03-16 02:16:00.000000'),
(3, 'Slim Fit Jeans', 'Men', 'Classic slim-fit jeans crafted from durable denim for everyday comfort. Available in light, medium, and dark washes.', 99.9, '2025-03-16 02:16:00.000000'),
(4, 'Cargo Pants', 'Men', 'Stylish cargo pants featuring multiple pockets for functionality. Perfect for casual and outdoor wear.', 79.9, '2025-03-16 01:12:00.000000'),
(5, 'High-Waisted Skirt', 'Women', 'Chic high-waisted skirt with a sleek silhouette, ideal for both office and casual looks.', 79.9, '2025-03-16 04:56:00.000000'),
(6, 'Athletic Joggers', 'Women', 'Comfortable athletic joggers made from soft, stretchable fabric. Ideal for workouts or lounging.', 69.9, '2025-03-16 00:16:00.000000'),
(7, 'Graphic Print Tee', 'Women', 'Stand out with a bold graphic print, crafted from breathable fabric for all-day comfort.', 54.9, '2025-03-16 01:16:00.000000'),
(8, 'Cropped V-Neck T-Shirt', 'Women', 'Minimalist cropped V-neck T-shirt made from soft cotton, perfect for a casual, everyday look.', 27.9, '2025-03-16 00:38:00.000000');

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
(1, 1, 'XS', 'Light Beige', 23, '../images/crew-t-beige.avif'),
(2, 1, 'S', 'Light Beige', 12, '../images/crew-t-beige.avif'),
(3, 1, 'M', 'Light Beige', 45, '../images/crew-t-beige.avif'),
(4, 1, 'L', 'Light Beige', 6, '../images/crew-t-beige.avif'),
(5, 1, 'XL', 'Light Beige', 37, '../images/crew-t-beige.avif'),
(6, 1, 'XS', 'White', 50, '../images/crew-t-white.avif'),
(7, 1, 'S', 'White', 19, '../images/crew-t-white.avif'),
(8, 1, 'M', 'White', 0, '../images/crew-t-white.avif'),
(9, 1, 'L', 'White', 8, '../images/crew-t-white.avif'),
(10, 1, 'XL', 'White', 32, '../images/crew-t-white.avif'),
(11, 1, 'XS', 'Black', 28, '../images/crew-t-black.avif'),
(12, 1, 'S', 'Black', 14, '../images/crew-t-black.avif'),
(13, 1, 'M', 'Black', 46, '../images/crew-t-black.avif'),
(14, 1, 'L', 'Black', 41, '../images/crew-t-black.avif'),
(15, 1, 'XL', 'Black', 25, '../images/crew-t-black.avif'),
(16, 2, 'XS', 'Pink', 9, '../images/vneck-pink.avif'),
(17, 2, 'S', 'Pink', 33, '../images/vneck-pink.avif'),
(18, 2, 'M', 'Pink', 11, '../images/vneck-pink.avif'),
(19, 2, 'L', 'Pink', 5, '../images/vneck-pink.avif'),
(20, 2, 'XL', 'Pink', 39, '../images/vneck-pink.avif'),
(21, 2, 'XS', 'Navy Blue', 26, '../images/vneck-navy.avif'),
(22, 2, 'S', 'Navy Blue', 0, '../images/vneck-navy.avif'),
(23, 2, 'M', 'Navy Blue', 44, '../images/vneck-navy.avif'),
(24, 2, 'L', 'Navy Blue', 3, '../images/vneck-navy.avif'),
(25, 2, 'XL', 'Navy Blue', 18, '../images/vneck-navy.avif'),
(26, 3, 'XS', 'Dark Grey', 36, '../images/slim-jeans-grey.avif'),
(27, 3, 'S', 'Dark Grey', 48, '../images/slim-jeans-grey.avif'),
(28, 3, 'M', 'Dark Grey', 2, '../images/slim-jeans-grey.avif'),
(29, 3, 'L', 'Dark Grey', 40, '../images/slim-jeans-grey.avif'),
(30, 3, 'XL', 'Dark Grey', 7, '../images/slim-jeans-grey.avif'),
(31, 3, 'XS', 'Black', 22, '../images/slim-jeans-black.avif'),
(32, 3, 'S', 'Black', 0, '../images/slim-jeans-black.avif'),
(33, 3, 'M', 'Black', 31, '../images/slim-jeans-black.avif'),
(34, 3, 'L', 'Black', 4, '../images/slim-jeans-black.avif'),
(35, 3, 'XL', 'Black', 47, '../images/slim-jeans-black.avif'),
(36, 3, 'XS', 'Pale Blue', 29, '../images/slim-jeans-pale.avif'),
(37, 3, 'S', 'Pale Blue', 16, '../images/slim-jeans-pale.avif'),
(38, 3, 'M', 'Pale Blue', 43, '../images/slim-jeans-pale.avif'),
(39, 3, 'L', 'Pale Blue', 27, '../images/slim-jeans-pale.avif'),
(40, 3, 'XL', 'Pale Blue', 20, '../images/slim-jeans-pale.avif'),
(41, 4, 'XS', 'Light Beige', 30, '../images/cargo-pants-beige.avif'),
(42, 4, 'S', 'Light Beige', 38, '../images/cargo-pants-beige.avif'),
(43, 4, 'M', 'Light Beige', 13, '../images/cargo-pants-beige.avif'),
(44, 4, 'L', 'Light Beige', 21, '../images/cargo-pants-beige.avif'),
(45, 4, 'XL', 'Light Beige', 24, '../images/cargo-pants-beige.avif'),
(46, 4, 'XS', 'Dark Khaki Green', 34, '../images/cargo-pants-khaki.avif'),
(47, 4, 'S', 'Dark Khaki Green', 49, '../images/cargo-pants-khaki.avif'),
(48, 4, 'M', 'Dark Khaki Green', 10, '../images/cargo-pants-khaki.avif'),
(49, 4, 'L', 'Dark Khaki Green', 15, '../images/cargo-pants-khaki.avif'),
(50, 4, 'XL', 'Dark Khaki Green', 1, '../images/cargo-pants-khaki.avif'),
(51, 5, 'XS', 'Black', 42, '../images/high-skirt-black.avif'),
(52, 5, 'S', 'Black', 25, '../images/high-skirt-black.avif'),
(53, 5, 'M', 'Black', 12, '../images/high-skirt-black.avif'),
(54, 5, 'L', 'Black', 37, '../images/high-skirt-black.avif'),
(55, 5, 'XL', 'Black', 19, '../images/high-skirt-black.avif'),
(56, 5, 'XS', 'Dark Brown', 50, '../images/high-skirt-brown.avif'),
(57, 5, 'S', 'Dark Brown', 6, '../images/high-skirt-brown.avif'),
(58, 5, 'M', 'Dark Brown', 33, '../images/high-skirt-brown.avif'),
(59, 5, 'L', 'Dark Brown', 0, '../images/high-skirt-brown.avif'),
(60, 5, 'XL', 'Dark Brown', 5, '../images/high-skirt-brown.avif'),
(61, 5, 'XS', 'White', 32, '../images/high-skirt-white.avif'),
(62, 5, 'S', 'White', 8, '../images/high-skirt-white.avif'),
(63, 5, 'M', 'White', 28, '../images/high-skirt-white.avif'),
(64, 5, 'L', 'White', 23, '../images/high-skirt-white.avif'),
(65, 5, 'XL', 'White', 46, '../images/high-skirt-white.avif'),
(66, 6, 'XS', 'Pink', 41, '../images/jogger-pink.avif'),
(67, 6, 'S', 'Pink', 11, '../images/jogger-pink.avif'),
(68, 6, 'M', 'Pink', 45, '../images/jogger-pink.avif'),
(69, 6, 'L', 'Pink', 14, '../images/jogger-pink.avif'),
(70, 6, 'XL', 'Pink', 9, '../images/jogger-pink.avif'),
(71, 6, 'XS', 'Light Blue', 39, '../images/jogger-blue.avif'),
(72, 6, 'S', 'Light Blue', 0, '../images/jogger-blue.avif'),
(73, 6, 'M', 'Light Blue', 26, '../images/jogger-blue.avif'),
(74, 6, 'L', 'Light Blue', 3, '../images/jogger-blue.avif'),
(75, 6, 'XL', 'Light Blue', 36, '../images/jogger-blue.avif'),
(76, 6, 'XS', 'Dark Grey', 18, '../images/jogger-grey.avif'),
(77, 6, 'S', 'Dark Grey', 48, '../images/jogger-grey.avif'),
(78, 6, 'M', 'Dark Grey', 2, '../images/jogger-grey.avif'),
(79, 6, 'L', 'Dark Grey', 40, '../images/jogger-grey.avif'),
(80, 6, 'XL', 'Dark Grey', 7, '../images/jogger-grey.avif'),
(81, 7, 'XS', 'Cream', 22, '../images/graphics-tee-cream.avif'),
(82, 7, 'S', 'Cream', 47, '../images/graphics-tee-cream.avif'),
(83, 7, 'M', 'Cream', 0, '../images/graphics-tee-cream.avif'),
(84, 7, 'L', 'Cream', 31, '../images/graphics-tee-cream.avif'),
(85, 7, 'XL', 'Cream', 4, '../images/graphics-tee-cream.avif'),
(86, 7, 'XS', 'Dark Grey', 29, '../images/graphics-tee-grey.avif'),
(87, 7, 'S', 'Dark Grey', 43, '../images/graphics-tee-grey.avif'),
(88, 7, 'M', 'Dark Grey', 16, '../images/graphics-tee-grey.avif'),
(89, 7, 'L', 'Dark Grey', 27, '../images/graphics-tee-grey.avif'),
(90, 7, 'XL', 'Dark Grey', 20, '../images/graphics-tee-grey.avif'),
(91, 8, 'XS', 'Black', 30, '../images/v-neck-black.avif'),
(92, 8, 'S', 'Black', 38, '../images/v-neck-black.avif'),
(93, 8, 'M', 'Black', 13, '../images/v-neck-black.avif'),
(94, 8, 'L', 'Black', 21, '../images/v-neck-black.avif'),
(95, 8, 'XL', 'Black', 24, '../images/v-neck-black.avif'),
(96, 8, 'XS', 'White', 34, '../images/v-neck-white.avif'),
(97, 8, 'S', 'White', 49, '../images/v-neck-white.avif'),
(98, 8, 'M', 'White', 10, '../images/v-neck-white.avif'),
(99, 8, 'L', 'White', 15, '../images/v-neck-white.avif'),
(100, 8, 'XL', 'White', 1, '../images/v-neck-white.avif');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(5) NOT NULL,
  `role` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password_hashed` char(5) NOT NULL,
  `age` int(10) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone_no` int(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `profile_photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `role`, `name`, `password_hashed`, `age`, `gender`, `phone_no`, `email`, `profile_photo`) VALUES
(1, 'admin', 'Chea Ming Shen', '12345', 21, 'male', 123456789, 'cms@gmail.com', '../images/cms_pfp'),
(2, 'admin', 'Chong Ming Li', '12345', 21, 'male', 141047104, 'cml@gmail.com', '../images/cml_pfp'),
(3, 'member', 'Elaine Pang', '12345', 21, 'female', 184012398, 'ep@gmail.com', '../images/ep_pfp'),
(4, 'member', 'Sum Ting Wong', '12345', 30, 'male', 175419326, 'stw@gmail.com', '../images/stw_pfp'),
(5, 'member', 'Ho Lee Fuk', '12345', 25, 'female', 190213092, 'hlf@gmail.com', '../images/hlf_pfp');

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
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_variation`
--
ALTER TABLE `product_variation`
  ADD PRIMARY KEY (`variation_id`),
  ADD KEY `product_id` (`product_id`);

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
  MODIFY `cart_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `product_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_variation`
--
ALTER TABLE `product_variation`
  MODIFY `variation_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `product_variation`
--
ALTER TABLE `product_variation`
  ADD CONSTRAINT `product_variation_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
