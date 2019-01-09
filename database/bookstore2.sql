-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2019 at 05:46 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '1' COMMENT '1:super admin; 2:admin',
  `status` int(11) NOT NULL COMMENT '0:not active; 1:active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `warehouse_id`, `role`, `status`) VALUES
(1, 'superadmin', '202cb962ac59075b964b07152d234b70', 0, 1, 1),
(2, 'dc_admin', '202cb962ac59075b964b07152d234b70', 1, 2, 1),
(3, 'botania_admin', '202cb962ac59075b964b07152d234b70', 2, 2, 1),
(4, 'nagoya_admin', '202cb962ac59075b964b07152d234b70', 3, 2, 1),
(5, 'btc_admin', '202cb962ac59075b964b07152d234b70', 4, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `book_code` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0:not active; 1:active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `book_code`, `category`, `name`, `publisher`, `price`, `status`) VALUES
(1, 'A001001', 1, 'Lupus', '6', 25000, 1),
(2, 'B001002', 3, 'AADC', '4', 20000, 1),
(3, 'C001001', 4, 'How to be a good cook', '5', 50000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0:not active; 1:active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `status`) VALUES
(1, 'Novel', 1),
(2, 'Comic', 1),
(3, 'Literature', 1),
(4, 'Cooks', 1),
(5, 'Fiction', 1);

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0:not active; 1:active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`id`, `name`, `status`) VALUES
(1, 'Erlangga', 1),
(4, 'Intan Pariwara', 1),
(5, 'Grafika', 1),
(6, 'Elex Media Komputindo', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales_transaction`
--

CREATE TABLE `sales_transaction` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `warehouse_id`, `book_id`, `qty`) VALUES
(4, 1, 2, 20),
(5, 1, 1, 1),
(6, 4, 2, 10),
(7, 3, 1, 1),
(8, 2, 1, 1),
(9, 1, 3, 22),
(10, 4, 3, 33),
(11, 4, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `stockcard`
--

CREATE TABLE `stockcard` (
  `id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `qty_in` int(11) NOT NULL DEFAULT '0',
  `qty_out` int(11) NOT NULL DEFAULT '0',
  `note` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stockcard`
--

INSERT INTO `stockcard` (`id`, `warehouse_id`, `qty_in`, `qty_out`, `note`, `user_id`, `book_id`, `date`) VALUES
(7, 1, 25, 0, 'inventory in from publisher', 2, 2, '2018-12-27 22:33:12'),
(8, 1, 5, 0, 'inventory in from publisher', 2, 2, '2018-12-27 22:33:30'),
(9, 1, 3, 0, 'inventory in from publisher', 2, 1, '2018-12-27 22:34:36'),
(10, 1, 2, 0, 'inventory in from publisher', 2, 1, '2018-12-27 22:34:44'),
(11, 1, 0, 10, 'send stock to Batam Centre', 2, 2, '2018-12-28 04:57:50'),
(12, 4, 10, 0, 'accept stock from distribution centre', 2, 2, '2018-12-28 04:57:50'),
(13, 1, 0, 1, 'send stock to Nagoya', 2, 1, '2018-12-28 22:29:32'),
(14, 3, 1, 0, 'accept stock from distribution centre', NULL, 1, '2018-12-28 22:29:32'),
(15, 1, 0, 1, 'send stock to Botania', 2, 1, '2018-12-28 22:33:33'),
(16, 2, 1, 0, 'accept stock from distribution centre', NULL, 1, '2018-12-28 22:33:33'),
(17, 1, 55, 0, 'inventory in from publisher', 2, 3, '2019-01-01 09:06:07'),
(18, 1, 0, 33, 'send stock to Batam Centre', 2, 3, '2019-01-01 09:06:18'),
(19, 4, 33, 0, 'accept stock from distribution centre', NULL, 3, '2019-01-01 09:06:18'),
(20, 1, 0, 2, 'send stock to Batam Centre', 2, 1, '2019-01-01 09:06:34'),
(21, 4, 2, 0, 'accept stock from distribution centre', NULL, 1, '2019-01-01 09:06:34');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0:not active; 1:active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`id`, `name`, `status`) VALUES
(1, 'Distribution Centre', 1),
(2, 'Botania', 1),
(3, 'Nagoya', 1),
(4, 'Batam Centre', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `book_code` (`book_code`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_transaction`
--
ALTER TABLE `sales_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stockcard`
--
ALTER TABLE `stockcard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales_transaction`
--
ALTER TABLE `sales_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `stockcard`
--
ALTER TABLE `stockcard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
