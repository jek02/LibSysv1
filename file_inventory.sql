-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 04, 2024 at 08:43 AM
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
-- Table structure for table `Files`
--

CREATE TABLE `Files` (
  `bid` int(100) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `author` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `type_of_publication` varchar(100) NOT NULL,
  `files` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Files`
--

INSERT INTO `Files` (`bid`, `name`, `author`, `year`, `type_of_publication`, `files`) VALUES
(1, 'PSA Annual book', 'EMZ with a \'Z\'', '2022', 'newsletter', ''),
(2, 'PSA monthly report', 'EMS with \'S\'', '2023', 'newsletter', ''),
(4, 'test21', 'test21', '21313', 'newsletter', ''),
(6, 'test21', 'test21', '21313', 'newsletter', ''),
(7, 'shg', 'erer', '21211', 'report', ''),
(8, 'ef', 'asf', '23222', 'news', ''),
(9, 'test', 'test21', '2133', 'report', 'uploads/pdfcoffee.com_bryan-ferryamproxy-music-pdf-free.pdf'),
(10, 'test', 'test21', '2133', 'report', 'uploads/pdfcoffee.com_bryan-ferryamproxy-music-pdf-free.pdf'),
(11, 'Annuaalll reportt', 'Jek', '21311', 'Report', 'uploads/2IDs.pdf'),
(12, 'test24', 'test24', '21412', 'report letter', '../uploads/picture-a-captivating-scene-of-a-tranquil-lake-at-sunset-ai-generative-photo.jpg'),
(13, 'sd', 'tyk', '2512', 'newsletters', '../uploads/pdfcoffee.com_bryan-ferryamproxy-music-pdf-free.pdf'),
(14, 'asd', 'asd', '2134', 'report', '../uploads/pdfcoffee.com_bryan-ferryamproxy-music-pdf-free.pdf'),
(16, 'Hakdog', 'jek', '2222', 'hahaq', '../uploads/2022_CAF_logo_Orig.png'),
(18, 'Try lang', 'Katy', '2222', 'sadfas', '../uploads/TAG_socd.docx'),
(19, 'maganda', 'emz', '2024', 'CAF', '../uploads/2022 CAF meeting agenda.pdf'),
(20, 'iSToCk', 'Jakeeelicious', '2212', 'img', '../uploads/istockphoto-183412466-612x612.jpg'),
(21, 'iSToCk1', 'Jakeeelicious1', '2133', 'img1', 'uploads/istockphoto-183412466-612x612 (1).jpg'),
(22, 'FUNDAMENTALS OF ELECTRICAL CIRCUITS IRREGULAR PANGASINAN STATE UNIVERSITY.pdfFUNDAMENTALS OF ELECTRICAL CIRCUITS IRREGULAR PANGASINAN STATE UNIVERSITY.pdfFUNDAMENTALS OF ELECTRICAL CIRCUITS IRREGULAR PANGASINAN STATE UNIVERSITY.pdf', 'Calaguio', '1945', 'PDF', 'uploads/istockphoto-183412466-612x612.jpg'),
(23, '23432r', 'er gre', '34523', 'u6ym fd', 'uploads/OJT_WR_Week6_PARAAN.docx'),
(24, '23423n 5 t htrfhrbdhg tyr', 'r543b ', '4534', '4wtry43', 'uploads/TAG_RD.docx'),
(25, 'w43509byv 4', 'klawejhb', '7098', 'sdf hretgdfvc2', 'uploads/Travel Report 4th Batch SCM for Plantation and Agricultural Sectors in Sandakan, Sabah - final.docx'),
(26, 'mee', 'dsfd', '200', 'sad', '../uploads/2022 CBMS LOGO.png'),
(27, 'hakdoggg', 'ere', '2223', 'ok', '../uploads/CpE Night Consent Form 2024.pdf'),
(28, 'hakdoggg', 'ere', '2223', 'ok', 'uploads/CpE Night Consent Form 2024.pdf'),
(29, 'tuetha', 'erhaeh', '4444', 'fhddfgd', 'uploads/Waiver-New (1).pdf'),
(30, 'emery', 'ganda', '2000', 'leader', 'uploads/Waiver-New (1).docx'),
(31, '23432423', 'asda s dsa dsa', '2322', 'sd sf ', 'uploads/OJT_WR_Week5_PARAAN.docx'),
(32, '1q2b 43re', 'dwrfvsdb', '23424', 'sdf sd', 'uploads/OJT_WR_Week6_PARAAN.docx'),
(33, '34b35643', 'as dsa das das', '213122', 'd wgesdg ', 'uploads/OJT_WR_Week5_PARAAN.docx'),
(34, '43b4234b', 'asd asd as', '2132', 's adas ds', 'uploads/OJT_WR_Week5_PARAAN.docx'),
(35, 'ere', 'eme', '2023', 'song', 'uploads/Waiver-New (1).pdf'),
(36, '234b 234 ', 'w qdqw das', '3241', ' asd fadsf ', 'uploads/Travel Report 4th Batch SCM for Plantation and Agricultural Sectors in Sandakan, Sabah - final.docx'),
(37, '32r 23 ', 'asd asda', '43524', ' dasd asd', 'uploads/Travel Report 4th Batch SCM for Plantation and Agricultural Sectors in Sandakan, Sabah - final.docx'),
(38, 'dasfa', 'fdsgsdv', '4456', 'efadgd', 'uploads/yup.jpg'),
(39, 'jdzgjzbcvbs', 'sdgAFwRGw', '4263', 'egaF', 'uploads/Untitled design.png'),
(40, 'thjtyjfdn', 'stwesfs', '2041', 'rytehdz', 'uploads/yup.jpg'),
(41, 'tjuthxgfn', 'wetrtwg', '5432', 'hysetw', 'uploads/Untitled design.png'),
(42, 'tehtrjhhd', 'szrtreg', '4556', 'tere', 'uploads/2 X 2.png'),
(43, 'reyy35', 'ewtrtr', '5323', 'gdfhtrzs', 'uploads/yup.jpg'),
(44, 'ejtutjhgf', 'aeqr', '4523', 'hdzgge', 'uploads/yup.jpg'),
(45, 'hrthgfb', 'aefd', '3555', 'fgrgd', 'uploads/Untitled design.png'),
(46, 'htjycs', 'rsrgsg', '4566', 'gmghnf', 'uploads/yup.jpg'),
(47, 'rhtjdz', 'eyety', '4445', 'mhdd', 'uploads/yup.jpg'),
(48, 'hmjgkjydzgz', 'srgthdh', '6667', 'kukiy', 'uploads/yup.jpg'),
(49, 'kmhjmt', 'ehzgdf', '5542', 'mjhmtt', 'uploads/CANDY LAND INVITATION (1).png'),
(50, 'hjhgki', 'srtstre', '4677', 'jufhdgsgr', 'uploads/Untitled design.png'),
(51, 'nhrtab', 'werwef', '4567', 'dgfgez', 'uploads/yup.jpg'),
(52, 'ngfnhfn', 'wtrsgsf', '2542', 'hteha', 'uploads/yup.jpg'),
(53, 'fgrg', 'grwr', '6665', 'thjty', 'uploads/Untitled design.png'),
(54, 'fnfbxdf', 'hgdsg', '7664', 'jhvgjx', 'uploads/ICON-2.png'),
(55, 'safsge', 'htrhrth', '5422', 'hdfge', 'uploads/Untitled design.png'),
(56, 'hdhegh', 'wgsgs', '5542', 'hetheh', 'uploads/yup.jpg'),
(57, 'dgfergt', 'fgaaw', '3211', 'gregs', 'uploads/yup.jpg'),
(58, 'wrgwg', 'fgrfs', '4321', 'fghdg', 'uploads/ICPEP LOGO.png'),
(59, 'vfwf', 'erqeq', '3343', 'fdgerge', 'uploads/2 X 2.png'),
(60, 'rgeage', 'gafgaegg', '4232', 'dvsfbfbsf', 'uploads/ICON-4.png'),
(61, 'fbdgb', 'rgvdsv', '3435', 'fgjtdhb', 'uploads/yup.jpg'),
(62, 'gsfgwr', 'grwF', '3431', 'FHATHAE', 'uploads/yup.jpg'),
(63, 'sfgeagea', 'sgewge', '6789', 'dhGEh', 'uploads/yup.jpg'),
(64, 'dfbdfb', 'bdbr', '3431', 'eba', 'uploads/rg.jpg'),
(65, 'hgaban', 'srgwg', '4321', 'hzssr', 'uploads/sf.jpg'),
(66, 'hsfbsfB', 'ffdhdh', '5667', 'fdhdzh', 'uploads/rg.jpg'),
(67, 'hdgnzdghtr', 'dnzdghg', '7899', 'dfgdfghzdfbd', 'uploads/rg.jpg'),
(68, 'dnzdnd', 'ngdzdt', '3521', 'hehaeta', 'uploads/sf.jpg'),
(69, 'zdfnzdn', 'gnzdngz', '2452', 'dhgdh', 'uploads/yup.jpg'),
(70, 'ndngzddhhte', 'dhzdhe', '3211', 'rewgwr', 'uploads/sf.jpg'),
(71, 'iedenceife', 'dvaJKhafjeq', '3113', 'sgwrgwf', 'uploads/rg.jpg'),
(72, 'sfhdzhtHzdgb', 'srtw5sg', '2522', 'rggzsgw', 'uploads/rt.jpg'),
(73, 'jrhsrhryjr', 'rjsryhjr', '6366', 'yeyety', 'uploads/rt.jpg'),
(74, 'hgzdhzdth', 'thtrhzdddt', '3525', 'fdhdhes', 'uploads/rt.jpg'),
(75, 'ndzgnrh', 'zdhyhr', '3452', 'gnzfhz', 'uploads/rg.jpg'),
(76, 'gznxghdgh', 'zfhddghdh', '4677', 'dfhzdh', 'uploads/rg.jpg'),
(77, 'gzhsrthr', 'eteyea', '3525', 'dhdhh', 'uploads/rt.jpg'),
(78, 'jgfjgheh', 'tot', '4322', 'shhth', 'uploads/rg.jpg'),
(79, 'zdhsdfhsiofhrgnjsfgbwryihwphfn dhveohbetb', 'shethdfbshdfh', '3462', 'htrthtrjseye5yeg', 'uploads/rt.jpg'),
(80, 'dsgwpiugwrngreugher ierjgker gheg egiewjwpj wwewt', 'ertwrt', '313', 'querty', 'uploads/rt.jpg'),
(81, 'embedded systems', 'basuel', '3241', 'fablab', 'uploads/rg.jpg'),
(82, 'barats', 'ml', '3234', 'hero', 'uploads/rg.jpg'),
(83, 'pneumonoultramicroscopicsilicovolcanoconiosis', 'english', '2322', 'google', 'uploads/rt.jpg'),
(84, 'The Nile River longest river in the world the Blue Nile, the Atbara, and the White Nile.', 'river', '2112', 'gfaGGSgs', 'uploads/rt.jpg'),
(85, 'The Mississippi River is the second longest river in North America, flowing 2,350 miles from its source at Lake Itasca through the center of the continental United States to the Gulf of Mexico. The Missouri River, a tributary of the Mississippi River, is about 100 miles longer.', 'aefqe', '5252', 'river', 'uploads/rg.jpg'),
(86, 'sgSRGev', 'fshERHew', '3525', 'sfhhhe', 'uploads/rt.jpg'),
(87, 'Pinakanakapagpapabagabag-damdamin ', 'pinoy', '232', 'word', 'uploads/rt.jpg'),
(88, 'fgzdfgzdb', 'gshethdwr', '5221', 'sfdaga', 'uploads/rg.jpg'),
(89, 'nbaDIDND', 'moli', '2024', 'riangs', 'uploads/rt.jpg'),
(90, 'cagfsgsg', 'moli', '34341', 'FafgR', 'uploads/rt.jpg');

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
(2, 'Emz', 'Litilit', 'EMPLOYEE'),
(3, 'Aeron', 'Bahug', 'EMPLOYEE');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `Files`
--
ALTER TABLE `Files`
  MODIFY `bid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
