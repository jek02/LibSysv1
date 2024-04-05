-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 05, 2024 at 07:54 AM
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
-- Database: `file_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE `Comments` (
  `comment_id` int(11) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`comment_id`, `file_id`, `comment`, `timestamp`, `user`) VALUES
(9, 18, 'heyyy', '2024-04-05 02:27:07', 'admin'),
(10, 16, 'asdwg', '2024-04-05 02:28:25', 'aldrin'),
(11, 16, 'erherh', '2024-04-05 02:28:29', 'aldrin'),
(12, 15, 'rweherh', '2024-04-05 02:28:32', 'aldrin'),
(13, 18, 'revise mo iyan ampangitt\r\n', '2024-04-05 02:28:45', 'aldrin'),
(14, 15, 'heyyy \'yarnn\r\n', '2024-04-05 02:30:37', 'aldrin'),
(15, 23, 'okitnana\r\n', '2024-04-05 04:09:35', 'aldrin');

-- --------------------------------------------------------

--
-- Table structure for table `Files`
--

CREATE TABLE `Files` (
  `bid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `type_of_publication` varchar(100) NOT NULL,
  `files` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Files`
--

INSERT INTO `Files` (`bid`, `name`, `author`, `year`, `type_of_publication`, `files`, `updated_at`) VALUES
(15, 'annual report', 'jekk', '2023', 'report ni jekk', '../uploads/pdfcoffee.com_bryan-ferryamproxy-music-pdf-free.pdf', '2024-04-05 03:12:57'),
(16, 'monthly newsletter daww', 'Riangssssss', '2025', 'Newsletterssreee', '../uploads/660e11ed25487.pdf', '2024-04-05 03:13:21'),
(17, 'moli', 'riangs', '2024', 'edi', '../uploads/Waiver-New (1).pdf', '2024-04-05 03:12:57'),
(18, 'asd21241', 'admin', '2020', 'newsletter', 'uploads/pdfcoffee.com_bryan-ferryamproxy-music-pdf-free.pdf', '2024-04-05 03:15:38'),
(21, 'annual reportss', 'aldrin', '2024', 'report', 'uploads/pdfcoffee.com_bryan-ferryamproxy-music-pdf-free.pdf', '2024-04-05 03:12:57'),
(22, 'test2112532', 'aldrin', '2351235', 'erh', 'uploads/pdfcoffee.com_bryan-ferryamproxy-music-pdf-free.pdf', '2024-04-05 04:00:48'),
(23, 'heyyyyyyyyyyyyyy', 'dfb3erer3', '1211', 'repor', '../uploads/pdfcoffee.com_bryan-ferryamproxy-music-pdf-free.pdf', '2024-04-05 04:01:27'),
(24, 'heyyyyyyyyyyyyyy', 'dfb3erer3', '1211', 'repor', '../uploads/pdfcoffee.com_bryan-ferryamproxy-music-pdf-free.pdf', '2024-04-05 05:48:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('ADMIN','EMPLOYEE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'socd', 'ADMIN'),
(2, 'Emz', 'Litlit', 'EMPLOYEE'),
(3, 'Aeron', 'Bahug', 'EMPLOYEE'),
(7, 'riangs', 'moli', 'EMPLOYEE'),
(11, 'eyyy111asdw', 'asdw', 'ADMIN'),
(12, 'shhh', 'sh', 'EMPLOYEE'),
(13, 'sg', 'sgg', 'ADMIN'),
(14, 'aldrin', 'bahit', 'ADMIN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `file_id` (`file_id`);

--
-- Indexes for table `Files`
--
ALTER TABLE `Files`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Files`
--
ALTER TABLE `Files`
  MODIFY `bid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `Files` (`bid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
