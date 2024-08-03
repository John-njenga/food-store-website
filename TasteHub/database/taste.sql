-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2024 at 11:03 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taste`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `username`, `product_name`, `price`, `quantity`, `total`, `created_at`) VALUES
(39, 'John22', 'Pizza', 1000.00, 1, 1000.00, '2024-07-24 23:36:59');

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cart_items` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`id`, `first_name`, `last_name`, `email`, `mobile`, `address`, `cart_items`, `username`, `created_at`, `order_number`) VALUES
(6, 'maryl', 'ursula', 'maryursula@gmail.com', '25496887156', 'thika', '[{\"name\":\"Pizza\",\"price\":\"1000.00\",\"quantity\":1,\"total\":\"1000.00\"}]', 'John22', '2024-07-21 08:31:58', NULL),
(7, 'maryl', 'ursula', 'maryursula@gmail.com', '25496887156', 'thika', '[{\"name\":\"french fries\",\"price\":\"199.99\",\"quantity\":1,\"total\":\"199.99\"}]', 'John22', '2024-07-24 20:07:46', 'ORDER-66a15f12dea47'),
(8, 'maryl', 'ursula', 'maryursula@gmail.com', '25496887156', 'thika', '[{\"name\":\"Pasta\",\"price\":\"249.00\",\"quantity\":1,\"total\":\"249.00\"}]', 'John22', '2024-07-24 20:29:47', 'ORDER-66a1643ba4fbc'),
(9, 'maryl', 'ursula', 'maryursula@gmail.com', '25496887156', 'thika', '[{\"name\":\"Pizza\",\"price\":\"1000.00\",\"quantity\":1,\"total\":\"1000.00\"}]', 'John22', '2024-07-24 20:36:59', 'ORDER-66a165ebe9d60');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_list`
--

CREATE TABLE `product_list` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_list`
--

INSERT INTO `product_list` (`product_id`, `product_name`, `category`, `price`, `quantity`, `image`) VALUES
(0, 'Pizza', 'food', 1000.00, 12, 'http://localhost/TasteHub/images/pizza.jpg'),
(1, 'Grilled Pork Chops', 'food', 1049.99, 12, 'http://localhost/TasteHub/images/grilled%20pork%20chops.jpg'),
(2, 'french fries', 'food', 199.99, 21, 'http://localhost/TasteHub/images/french%20fries.jpg'),
(4, 'Pasta', 'food', 249.00, 25, 'http://localhost/TasteHub/images/pasta.jpg'),
(5, 'Mocktail', 'drink', 150.99, 23, 'http://localhost/TasteHub/images/carbonated.jpg'),
(6, 'Tacos', 'food', 399.00, 19, 'http://localhost/TasteHub/images/tacos.jpg'),
(7, 'Biryani', 'food', 299.00, 21, 'http://localhost/TasteHub/images/biryani.jpg'),
(8, 'Chicken stew rice', 'food', 699.99, 18, 'http://localhost/TasteHub/images/Chicken%20Stew%20Rice.jpg'),
(9, 'Cheeseburger', 'food', 399.99, 34, 'http://localhost/TasteHub/images/cheeseburger.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tblogin`
--

CREATE TABLE `tblogin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblogin`
--

INSERT INTO `tblogin` (`id`, `username`, `email`, `password`) VALUES
(1, 'John22', 'jhonjosh5@gmail.com', '$2y$10$e.2wHG5pGvppqxHbH4cBoOq8oWp.CRyvtevMokjUT30pr0qZsfqFq');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tblogin`
--
ALTER TABLE `tblogin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblogin`
--
ALTER TABLE `tblogin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
