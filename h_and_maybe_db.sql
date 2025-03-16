-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2025 at 08:06 PM
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
  `address_id` char(5) NOT NULL,
  `user_id` char(5) NOT NULL,
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
('A0001', 'U0005', '69, Jalan 1, Ampang Jaya', 'Ampang', 'Selangor', 68000, 'Malaysia'),
('A0002', 'U0003', '37, Jalan Beberek, Kepong Baru', 'Kuala Lumpur', 'Kuala Lumpur', 52100, 'Malaysia'),
('A0003', 'U0004', '123, Main Street, Apt 4B', 'Springfield', 'Illinois', 62704, 'USA'),
('A0004', 'U0005', '12, Ocean Avenue', 'Sydney', 'New South Wales', 2000, 'Australia'),
('A0005', 'U0004', '23, Solok Relau 2, Sentral Greens', 'Bayan Lepas', 'Pulau Pinang', 11900, 'Malaysia');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` char(5) NOT NULL,
  `user_id` char(5) NOT NULL,
  `created_at` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` char(5) NOT NULL,
  `cart_id` char(5) NOT NULL,
  `product_id` char(5) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `order_id` char(5) NOT NULL,
  `user_id` char(5) NOT NULL,
  `created_at` datetime(6) NOT NULL,
  `status` varchar(10) NOT NULL,
  `shipping_fee` int(10) NOT NULL,
  `total_amount` int(10) NOT NULL,
  `address_id` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` char(5) NOT NULL,
  `order_id` char(5) NOT NULL,
  `product_id` char(5) NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` char(5) NOT NULL,
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
('P0001', 'Classic Crew T-Shirt', 'Men', 'Timeless and versatile, this soft cotton crewneck tee is perfect for everyday wear.', 24.9, '2025-03-16 01:35:00.000000'),
('P0002', 'V-Neck Essential Tee', 'Men', 'A sleek V-neck t-shirt made from a soft cotton blend, ideal for casual or layered looks.', 29.9, '2025-03-16 02:16:00.000000'),
('P0003', 'Slim Fit Jeans', 'Men', 'Classic slim-fit jeans crafted from durable denim for everyday comfort. Available in light, medium, and dark washes.', 99.9, '2025-03-16 02:16:00.000000'),
('P0004', 'Cargo Pants', 'Men', 'Stylish cargo pants featuring multiple pockets for functionality. Perfect for casual and outdoor wear.', 79.9, '2025-03-16 01:12:00.000000'),
('P0005', 'High-Waisted Skirt', 'Women', 'Chic high-waisted skirt with a sleek silhouette, ideal for both office and casual looks.', 79.9, '2025-03-16 04:56:00.000000'),
('P0006', 'Athletic Joggers', 'Women', 'Comfortable athletic joggers made from soft, stretchable fabric. Ideal for workouts or lounging.', 69.9, '2025-03-16 00:16:00.000000'),
('P0007', 'Graphic Print Tee', 'Women', 'Stand out with a bold graphic print, crafted from breathable fabric for all-day comfort.', 54.9, '2025-03-16 01:16:00.000000'),
('P0008', 'Cropped V-Neck T-Shirt', 'Women', 'Minimalist cropped V-neck T-shirt made from soft cotton, perfect for a casual, everyday look.', 27.9, '2025-03-16 00:38:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `product_variation`
--

CREATE TABLE `product_variation` (
  `variation_id` char(5) NOT NULL,
  `product_id` char(5) NOT NULL,
  `size` varchar(5) NOT NULL,
  `color` varchar(20) NOT NULL,
  `stock_quantity` int(10) NOT NULL,
  `product_photo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variation`
--

INSERT INTO `product_variation` (`variation_id`, `product_id`, `size`, `color`, `stock_quantity`, `product_photo`) VALUES
('V0001', 'P0001', 'XS', 'Light Beige', 23, '../images/crew-t-beige.avif'),
('V0002', 'P0001', 'S', 'Light Beige', 12, '../images/crew-t-beige.avif'),
('V0003', 'P0001', 'M', 'Light Beige', 45, '../images/crew-t-beige.avif'),
('V0004', 'P0001', 'L', 'Light Beige', 6, '../images/crew-t-beige.avif'),
('V0005', 'P0001', 'XL', 'Light Beige', 37, '../images/crew-t-beige.avif'),
('V0006', 'P0001', 'XS', 'White', 50, '../images/crew-t-white.avif'),
('V0007', 'P0001', 'S', 'White', 19, '../images/crew-t-white.avif'),
('V0008', 'P0001', 'M', 'White', 0, '../images/crew-t-white.avif'),
('V0009', 'P0001', 'L', 'White', 8, '../images/crew-t-white.avif'),
('V0010', 'P0001', 'XL', 'White', 32, '../images/crew-t-white.avif'),
('V0011', 'P0001', 'XS', 'Black', 28, '../images/crew-t-black.avif'),
('V0012', 'P0001', 'S', 'Black', 14, '../images/crew-t-black.avif'),
('V0013', 'P0001', 'M', 'Black', 46, '../images/crew-t-black.avif'),
('V0014', 'P0001', 'L', 'Black', 41, '../images/crew-t-black.avif'),
('V0015', 'P0001', 'XL', 'Black', 25, '../images/crew-t-black.avif'),
('V0016', 'P0002', 'XS', 'Pink', 9, '../images/vneck-pink.avif'),
('V0017', 'P0002', 'S', 'Pink', 33, '../images/vneck-pink.avif'),
('V0018', 'P0002', 'M', 'Pink', 11, '../images/vneck-pink.avif'),
('V0019', 'P0002', 'L', 'Pink', 5, '../images/vneck-pink.avif'),
('V0020', 'P0002', 'XL', 'Pink', 39, '../images/vneck-pink.avif'),
('V0021', 'P0002', 'XS', 'Navy Blue', 26, '../images/vneck-navy.avif'),
('V0022', 'P0002', 'S', 'Navy Blue', 0, '../images/vneck-navy.avif'),
('V0023', 'P0002', 'M', 'Navy Blue', 44, '../images/vneck-navy.avif'),
('V0024', 'P0002', 'L', 'Navy Blue', 3, '../images/vneck-navy.avif'),
('V0025', 'P0002', 'XL', 'Navy Blue', 18, '../images/vneck-navy.avif'),
('V0026', 'P0003', 'XS', 'Dark Grey', 36, '../images/slim-jeans-grey.avif'),
('V0027', 'P0003', 'S', 'Dark Grey', 48, '../images/slim-jeans-grey.avif'),
('V0028', 'P0003', 'M', 'Dark Grey', 2, '../images/slim-jeans-grey.avif'),
('V0029', 'P0003', 'L', 'Dark Grey', 40, '../images/slim-jeans-grey.avif'),
('V0030', 'P0003', 'XL', 'Dark Grey', 7, '../images/slim-jeans-grey.avif'),
('V0031', 'P0003', 'XS', 'Black', 22, '../images/slim-jeans-black.avif'),
('V0032', 'P0003', 'S', 'Black', 0, '../images/slim-jeans-black.avif'),
('V0033', 'P0003', 'M', 'Black', 31, '../images/slim-jeans-black.avif'),
('V0034', 'P0003', 'L', 'Black', 4, '../images/slim-jeans-black.avif'),
('V0035', 'P0003', 'XL', 'Black', 47, '../images/slim-jeans-black.avif'),
('V0036', 'P0003', 'XS', 'Pale Blue', 29, '../images/slim-jeans-pale.avif'),
('V0037', 'P0003', 'S', 'Pale Blue', 16, '../images/slim-jeans-pale.avif'),
('V0038', 'P0003', 'M', 'Pale Blue', 43, '../images/slim-jeans-pale.avif'),
('V0039', 'P0003', 'L', 'Pale Blue', 27, '../images/slim-jeans-pale.avif'),
('V0040', 'P0003', 'XL', 'Pale Blue', 20, '../images/slim-jeans-pale.avif'),
('V0041', 'P0004', 'XS', 'Light Beige', 30, '../images/cargo-pants-beige.avif'),
('V0042', 'P0004', 'S', 'Light Beige', 38, '../images/cargo-pants-beige.avif'),
('V0043', 'P0004', 'M', 'Light Beige', 13, '../images/cargo-pants-beige.avif'),
('V0044', 'P0004', 'L', 'Light Beige', 21, '../images/cargo-pants-beige.avif'),
('V0045', 'P0004', 'XL', 'Light Beige', 24, '../images/cargo-pants-beige.avif'),
('V0046', 'P0004', 'XS', 'Dark Khaki Green', 34, '../images/cargo-pants-khaki.avif'),
('V0047', 'P0004', 'S', 'Dark Khaki Green', 49, '../images/cargo-pants-khaki.avif'),
('V0048', 'P0004', 'M', 'Dark Khaki Green', 10, '../images/cargo-pants-khaki.avif'),
('V0049', 'P0004', 'L', 'Dark Khaki Green', 15, '../images/cargo-pants-khaki.avif'),
('V0050', 'P0004', 'XL', 'Dark Khaki Green', 1, '../images/cargo-pants-khaki.avif'),
('V0051', 'P0005', 'XS', 'Black', 42, '../images/high-skirt-black.avif'),
('V0052', 'P0005', 'S', 'Black', 25, '../images/high-skirt-black.avif'),
('V0053', 'P0005', 'M', 'Black', 12, '../images/high-skirt-black.avif'),
('V0054', 'P0005', 'L', 'Black', 37, '../images/high-skirt-black.avif'),
('V0055', 'P0005', 'XL', 'Black', 19, '../images/high-skirt-black.avif'),
('V0056', 'P0005', 'XS', 'Dark Brown', 50, '../images/high-skirt-brown.avif'),
('V0057', 'P0005', 'S', 'Dark Brown', 6, '../images/high-skirt-brown.avif'),
('V0058', 'P0005', 'M', 'Dark Brown', 33, '../images/high-skirt-brown.avif'),
('V0059', 'P0005', 'L', 'Dark Brown', 0, '../images/high-skirt-brown.avif'),
('V0060', 'P0005', 'XL', 'Dark Brown', 5, '../images/high-skirt-brown.avif'),
('V0061', 'P0005', 'XS', 'White', 32, '../images/high-skirt-white.avif'),
('V0062', 'P0005', 'S', 'White', 8, '../images/high-skirt-white.avif'),
('V0063', 'P0005', 'M', 'White', 28, '../images/high-skirt-white.avif'),
('V0064', 'P0005', 'L', 'White', 23, '../images/high-skirt-white.avif'),
('V0065', 'P0005', 'XL', 'White', 46, '../images/high-skirt-white.avif'),
('V0066', 'P0006', 'XS', 'Pink', 41, '../images/jogger-pink.avif'),
('V0067', 'P0006', 'S', 'Pink', 11, '../images/jogger-pink.avif'),
('V0068', 'P0006', 'M', 'Pink', 45, '../images/jogger-pink.avif'),
('V0069', 'P0006', 'L', 'Pink', 14, '../images/jogger-pink.avif'),
('V0070', 'P0006', 'XL', 'Pink', 9, '../images/jogger-pink.avif'),
('V0071', 'P0006', 'XS', 'Light Blue', 39, '../images/jogger-blue.avif'),
('V0072', 'P0006', 'S', 'Light Blue', 0, '../images/jogger-blue.avif'),
('V0073', 'P0006', 'M', 'Light Blue', 26, '../images/jogger-blue.avif'),
('V0074', 'P0006', 'L', 'Light Blue', 3, '../images/jogger-blue.avif'),
('V0075', 'P0006', 'XL', 'Light Blue', 36, '../images/jogger-blue.avif'),
('V0076', 'P0006', 'XS', 'Dark Grey', 18, '../images/jogger-grey.avif'),
('V0077', 'P0006', 'S', 'Dark Grey', 48, '../images/jogger-grey.avif'),
('V0078', 'P0006', 'M', 'Dark Grey', 2, '../images/jogger-grey.avif'),
('V0079', 'P0006', 'L', 'Dark Grey', 40, '../images/jogger-grey.avif'),
('V0080', 'P0006', 'XL', 'Dark Grey', 7, '../images/jogger-grey.avif'),
('V0081', 'P0007', 'XS', 'Cream', 22, '../images/graphics-tee-cream.avif'),
('V0082', 'P0007', 'S', 'Cream', 47, '../images/graphics-tee-cream.avif'),
('V0083', 'P0007', 'M', 'Cream', 0, '../images/graphics-tee-cream.avif'),
('V0084', 'P0007', 'L', 'Cream', 31, '../images/graphics-tee-cream.avif'),
('V0085', 'P0007', 'XL', 'Cream', 4, '../images/graphics-tee-cream.avif'),
('V0086', 'P0007', 'XS', 'Dark Grey', 29, '../images/graphics-tee-grey.avif'),
('V0087', 'P0007', 'S', 'Dark Grey', 43, '../images/graphics-tee-grey.avif'),
('V0088', 'P0007', 'M', 'Dark Grey', 16, '../images/graphics-tee-grey.avif'),
('V0089', 'P0007', 'L', 'Dark Grey', 27, '../images/graphics-tee-grey.avif'),
('V0090', 'P0007', 'XL', 'Dark Grey', 20, '../images/graphics-tee-grey.avif'),
('V0091', 'P0008', 'XS', 'Black', 30, '../images/v-neck-black.avif'),
('V0092', 'P0008', 'S', 'Black', 38, '../images/v-neck-black.avif'),
('V0093', 'P0008', 'M', 'Black', 13, '../images/v-neck-black.avif'),
('V0094', 'P0008', 'L', 'Black', 21, '../images/v-neck-black.avif'),
('V0095', 'P0008', 'XL', 'Black', 24, '../images/v-neck-black.avif'),
('V0096', 'P0008', 'XS', 'White', 34, '../images/v-neck-white.avif'),
('V0097', 'P0008', 'S', 'White', 49, '../images/v-neck-white.avif'),
('V0098', 'P0008', 'M', 'White', 10, '../images/v-neck-white.avif'),
('V0099', 'P0008', 'L', 'White', 15, '../images/v-neck-white.avif'),
('V0100', 'P0008', 'XL', 'White', 1, '../images/v-neck-white.avif');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` char(5) NOT NULL,
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
('U0001', 'admin', 'Chea Ming Shen', '12345', 21, 'male', 123456789, 'cms@gmail.com', '../images/cms_pfp'),
('U0002', 'admin', 'Chong Ming Li', '12345', 21, 'male', 141047104, 'cml@gmail.com', '../images/cml_pfp'),
('U0003', 'member', 'Elaine Pang', '12345', 21, 'female', 184012398, 'ep@gmail.com', '../images/ep_pfp'),
('U0004', 'member', 'Sum Ting Wong', '12345', 30, 'male', 175419326, 'stw@gmail.com', '../images/stw_pfp'),
('U0005', 'member', 'Ho Lee Fuk', '12345', 25, 'female', 190213092, 'hlf@gmail.com', '../images/hlf_pfp');

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
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `address_id` (`address_id`);

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
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`);

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
