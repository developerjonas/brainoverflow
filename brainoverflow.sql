-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 07:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brainoverflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `sno` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `pass` varchar(256) NOT NULL,
  `dt` int(11) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`sno`, `name`, `email`, `pass`, `dt`) VALUES
(1, 'helloaashika', 'hello@aashika.com', '$2y$10$hmZM/Y3C0.vALzobCBO8def3mREAF9ja51HMfDLGrY04lEVkgghRa', 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ct_id` int(8) NOT NULL,
  `ct_name` varchar(256) NOT NULL,
  `ct_desc` varchar(256) NOT NULL,
  `ct_dt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ct_id`, `ct_name`, `ct_desc`, `ct_dt`) VALUES
(3, 'php', 'php is a good language', '2024-10-17 08:04:35'),
(4, 'python', 'Python is a high-level, general-purpose programming language', '2024-10-17 08:05:27'),
(5, 'javascript', 'JavaScript, often abbreviated as JS, is a programming language and core technology of the Web, alongside HTML and CSS. 99% of websites use JavaScript on the client side for webpage behavior.', '2024-10-17 08:05:45'),
(6, 'C++ / CPP', 'C++ ( pronounced \"C plus plus\" and sometimes abbreviated as CPP) is a high-level, general-purpose programming language created by Danish computer scientist Bjarne Stroustrup.', '2024-10-17 18:53:22'),
(7, 'MySQL', 'MySQL is an open-source relational database management system. Its name is a combination of \'My\', the name of co-founder Michael Widenius\'s daughter My, and \'SQL\', the initialism for Structured Query Language.', '2024-10-23 21:27:36');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `cmt_id` int(12) NOT NULL,
  `cmt_cnt` varchar(256) NOT NULL,
  `th_id` int(12) NOT NULL,
  `cmt_user_id` int(11) NOT NULL,
  `cmt_dt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`cmt_id`, `cmt_cnt`, `th_id`, `cmt_user_id`, `cmt_dt`) VALUES
(1, '', 1, 1, '2024-10-18 15:41:26'),
(2, 'hi\r\n', 1, 1, '2024-10-18 15:41:47'),
(3, 'cmt', 1, 1, '2024-10-18 15:41:55'),
(4, 'hi this is a test comment for this thread id 01 by jonas the greatest developer out there in planet earth', 1, 1, '2024-10-18 15:52:03'),
(5, 'hi this is a test comment for this thread id 01 by jonas the greatest developer out there in planet earth', 1, 1, '2024-10-18 15:53:37'),
(6, 'by jonas', 1, 1, '2024-10-19 06:40:15');

-- --------------------------------------------------------

--
-- Table structure for table `threads`
--

CREATE TABLE `threads` (
  `th_id` int(12) NOT NULL,
  `th_name` varchar(256) NOT NULL,
  `th_desc` varchar(4098) NOT NULL,
  `th_ct_id` int(12) NOT NULL,
  `th_user_id` int(12) NOT NULL,
  `th_dt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `threads`
--

INSERT INTO `threads` (`th_id`, `th_name`, `th_desc`, `th_ct_id`, `th_user_id`, `th_dt`) VALUES
(1, 'first thread', 'this is the first thread of this site related to the category php', 3, 1, '2024-10-17 22:31:38'),
(2, 'this is second thread for the ', 'this is a second thread', 3, 1, '2024-10-17 22:37:47'),
(3, '', '', 3, 1, '2024-10-18 10:16:49'),
(4, 'hello this my problem', 'kindly help me', 3, 1, '2024-10-18 10:16:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `sno` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `user_email` varchar(64) NOT NULL,
  `user_pass` varchar(256) NOT NULL,
  `user_dt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`sno`, `username`, `user_email`, `user_pass`, `user_dt`) VALUES
(1, 'helloaashika', 'hello@jonas.com', '$2y$10$8BWB6o9Jc7858gDt6uQUcuVlmVFRh9FBxnTUaFfGh9GTXOzVN3NNu', '2024-10-18 19:41:04'),
(2, 'hellojonas', 'hello@aashika.com', '$2y$10$hC9zWXiO5DTvgM4/OCVsSeR94pGTabnIelOvglULwXdVP6CtQU.xC', '2024-10-23 19:12:18'),
(3, 'hellojonas', 'hello@jonas.com', '$2y$10$fg2Wa3ichHX4kV2NGupFEON3hkRLbeJBwieA1ikrgyyFtEIFI50AK', '2024-10-23 19:14:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`sno`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ct_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`cmt_id`);

--
-- Indexes for table `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`th_id`);
ALTER TABLE `threads` ADD FULLTEXT KEY `th_name` (`th_name`,`th_desc`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ct_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `cmt_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `threads`
--
ALTER TABLE `threads`
  MODIFY `th_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
