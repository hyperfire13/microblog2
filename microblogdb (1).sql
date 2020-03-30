-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2020 at 06:06 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `microblogdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) NOT NULL,
  `post_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `followers`
--

CREATE TABLE `followers` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `following_id` bigint(20) DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `post_id` bigint(20) DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `date_deleted` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `post_id` bigint(20) DEFAULT NULL,
  `post` text NOT NULL,
  `images` varchar(255) DEFAULT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT NULL,
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `image` varchar(255) DEFAULT 'user.png',
  `code` varchar(255) DEFAULT NULL,
  `activation_status` tinyint(1) NOT NULL DEFAULT 0,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp(),
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `middle_name`, `last_name`, `date_of_birth`, `image`, `code`, `activation_status`, `created`, `modified`, `deleted_date`, `deleted`) VALUES
(171, 'hyper', '$2a$10$.WoUK2iM.oOyU.14FHllS.tJQM0Vpp0YJVha35Ggmtah/hf1H1VdS', 'kennethybanez.yns@gmail.com', 'kenneth', 'baldado', 'ybanez', '1997-07-13', 'user.png', 'MB-5704', 1, '2020-03-28 15:15:37', '2020-03-30 07:09:12', NULL, 1),
(199, 'popo', '$2a$10$87PAYVWqWW1FhaD5JXBJX.aOSpnM4npjucQ82ll8eNtwBh5Sh1RiO', 'kennethybanez.yns@gmail.com', 'pogi', 'pogi', 'pogi', '1892-02-02', 'user.png', 'MB-7727', 1, '2020-03-30 01:44:48', '2020-03-30 07:24:18', NULL, 1),
(200, 'adi94fdfgrsdfsdfdsdfgt8fssdssd', '$2a$10$Nm.Luj8kovgpZSjfxcpqLOv9Dua2ZqCpMG1w.T4etggvtHfELFfnG', 'kennethybanez.yns@gmail.com', 'kenneth', 'baldado', 'ybanez', '1997-07-13', 'user.png', 'MB-7316', 0, '2020-03-30 03:09:12', '2020-03-30 03:09:12', NULL, 1),
(201, 'adi9t4fdfgrsdfsdfdsdfgt8fssdssd', '$2a$10$5X8zqg9NclyguodsNv5KveJECRn8gjYa7KbzOPz5riy2jEIyik4WK', 'kennethybanez.yns@gmail.com', 'kenneth', 'baldado', 'ybanez', '1997-07-13', 'user.png', 'MB-2141', 0, '2020-03-30 03:12:18', '2020-03-30 03:12:18', NULL, 1),
(202, 'adi9t4fdfgssrsdfsdfdsdfgt8fssdssd', '$2a$10$1OqxlwkvHZcenF69AK74Keu7rhDVC/ibYYmRJc0R2pg1mZ4rSBOT6', 'kennethybanez.yns@gmail.com', 'kenneth', 'baldado', 'ybanez', '1997-07-13', 'user.png', 'MB-1879', 0, '2020-03-30 03:13:37', '2020-03-30 03:13:37', NULL, 1),
(203, 'a', '$2a$10$4djlHs5d6C17y2isKmdvgugAMwn9uqjjtMlj65FTs/A4BTNl0h.z2', 'kennethybanez.yns@gmail.com', 'kenneth', 'baldado', 'ybanez', '1997-07-13', 'user.png', 'MB-7494', 0, '2020-03-30 03:26:35', '2020-03-30 03:26:35', NULL, 1),
(204, 'ba', '$2a$10$cYTcHceZCptiGrTXMWY1uuaQjjSklZ9rtkHOuW3boop36JEd7sp1O', 'kennethybanez.yns@gmail.com', 'kenneth', 'baldado', 'ybanez', '1997-07-13', 'user.png', 'MB-7358', 0, '2020-03-30 03:26:58', '2020-03-30 03:26:58', NULL, 1),
(205, 'bda', '$2a$10$DYS6nomIEglRE6M7fhzVVeiJFxJGS0lVUKViPekNcUvGGikuZwJEG', 'kennethybanez.yns@gmail.com', 'kenneth', 'baldado', 'ybanez', '1997-07-13', 'user.png', 'MB-9963', 0, '2020-03-30 03:35:34', '2020-03-30 03:35:34', NULL, 1),
(206, 'bdsa', '$2a$10$nC2VCFIfOHkqsshsK.wBuuQIhSEtFqMlsYsk2wdXmOop9g//a8Ble', 'kennethybanez.yns@gmail.com', 'kenneth', 'baldado', 'ybanez', '1997-07-13', 'user.png', 'MB-7798488', 1, '2020-03-30 04:02:49', '2020-03-30 04:02:49', NULL, 1),
(207, 'dbdsa', '$2a$10$bgta/qBmGCcwUQNgeuNYEOmfEn9uM7bqOH6lDLqJm3NMMkt/sQN.a', 'kennethybanez.yns@gmail.com', 'kenneth', 'baldado', 'ybanez', '1997-07-13', 'user.png', 'MB-8596410', 1, '2020-03-30 04:05:10', '2020-03-30 04:05:10', NULL, 1),
(208, 'popopo', '$2a$10$RcK0nIeBQRasLE.aXMkhsevXR7HNTOReU4W2/NS2YlmmlAUJ/dXxy', 'kennethybanez.yns@gmail.com', 'popo', 'popo', 'popo', '2020-04-02', 'user.png', 'MB-21659311', 0, '2020-03-30 14:35:08', '2020-03-30 14:35:08', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
