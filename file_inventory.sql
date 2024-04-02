-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 02, 2024 at 10:06 AM
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
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `type_of_publication` varchar(100) NOT NULL,
  `files` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bid`, `name`, `author`, `year`, `type_of_publication`, `files`) VALUES
(1, 'PSA Annual book', 'EMZ with a \'Z\'', '2022', 'newsletter', ''),
(2, 'PSA monthly report', 'EMS with \'S\'', '2023', 'newsletter', ''),
(3, 'quarterly report', 'Sir', '2012', 'Report', ''),
(4, 'test21', 'test21', '21313', 'newsletter', ''),
(5, 'test21', 'test21', '21313', 'newsletter', ''),
(6, 'test21', 'test21', '21313', 'newsletter', ''),
(7, 'shg', 'erer', '21211', 'report', ''),
(8, 'ef', 'asf', '23222', 'news', ''),
(9, 'test', 'test21', '2133', 'report', 'uploads/pdfcoffee.com_bryan-ferryamproxy-music-pdf-free.pdf'),
(10, 'test', 'test21', '2133', 'report', 'uploads/pdfcoffee.com_bryan-ferryamproxy-music-pdf-free.pdf'),
(11, 'Annuaalll reportt', 'Jek', '21311', 'Report', 'uploads/2IDs.pdf'),
(12, 'test24', 'test24', '21412', 'report letter', '../uploads/picture-a-captivating-scene-of-a-tranquil-lake-at-sunset-ai-generative-photo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `Files`
--

CREATE TABLE `Files` (
  `FileID` int(11) NOT NULL,
  `FileName` varchar(255) NOT NULL,
  `FileType` varchar(50) DEFAULT NULL,
  `FileSize` int(11) DEFAULT NULL,
  `UploadDate` date DEFAULT NULL,
  `UploadedBy` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 'Aeron', 'Bahug', 'EMPLOYEE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bid`);

--
-- Indexes for table `Files`
--
ALTER TABLE `Files`
  ADD PRIMARY KEY (`FileID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Files`
--
ALTER TABLE `Files`
  MODIFY `FileID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
