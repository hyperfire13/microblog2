-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2020 at 08:20 PM
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
  `deleted_date` timestamp NULL DEFAULT current_timestamp(),
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
  `modified` timestamp NULL DEFAULT current_timestamp(),
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
  `modified` timestamp NULL DEFAULT current_timestamp(),
  `deleted_date` timestamp NULL DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post_id`, `post`, `images`, `created`, `modified`, `deleted_date`, `deleted`) VALUES
(24, 214, NULL, 'amen', '[\"12140-postpic.png\",\"12141-postpic.jpg\"]', '2020-04-06 16:43:37', '2020-04-06 16:43:37', NULL, 1),
(25, 214, NULL, 'yow', NULL, '2020-04-06 16:44:05', '2020-04-06 16:44:05', NULL, 1),
(26, 214, NULL, 'dd', NULL, '2020-04-06 16:45:32', '2020-04-06 16:45:32', NULL, 1),
(27, 214, NULL, 'bff ko nga pala hehehe', NULL, '2020-04-06 18:08:02', '2020-04-06 18:08:02', NULL, 1),
(28, 214, NULL, 'asd', NULL, '2020-04-06 18:09:22', '2020-04-06 18:09:22', NULL, 1),
(29, 214, NULL, 'hehe', NULL, '2020-04-06 18:10:49', '2020-04-06 18:10:49', NULL, 1),
(30, 214, NULL, 'x', '[\"72140-postpic.jpg\"]', '2020-04-06 18:14:20', '2020-04-06 18:14:20', NULL, 1),
(31, 214, NULL, 'pogi ako', '[\"82140-postpic.jpg\",\"82141-postpic.jpg\"]', '2020-04-06 18:16:23', '2020-04-06 18:16:23', NULL, 1),
(32, 214, NULL, 'mga tropa ko nga pala', '[\"92140-postpic.jpg\",\"92141-postpic.jpg\",\"92142-postpic.jpg\"]', '2020-04-06 18:17:46', '2020-04-06 18:17:46', NULL, 1);

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
(214, 'loloy', '$2a$10$vACxcZTJXG6Nto0kpf9BkepRa6o4DNJY13r5cW2DLI4MCRUWUy366', 'kennethybanez.yns@gmail.com', 'Louis', 'Baldado', 'Ybanez', '2011-08-31', '214-profilepic.png', 'MB-4039981', 1, '2020-03-31 03:09:46', '2020-04-06 15:36:59', NULL, 1),
(215, 'xxx', '$2a$10$w9O0izgFpPSJ/AvXW0eGTu0gN8LPX0bryX9p79c2lCjmxj6Bo/vcC', 'kennethybanez.yns@gmail.com', 'xxx', 'xxx', 'xxx', '2020-03-18', 'user.png', 'MB-8020532', 1, '2020-03-31 10:26:11', '2020-03-31 10:27:13', NULL, 1),
(216, 'bbb', '$2a$10$laD0DZZiokl0jJmfrjg7lOzcR0zDSoh.e8OfKFmH13QDx6qaH4VSe', 'kennethybanez.yns@gmail.com', 'bbb', 'bbb', 'bbb', '2020-03-17', 'user.png', 'MB-6676593', 1, '2020-03-31 10:28:07', '2020-03-31 10:29:21', NULL, 1),
(217, 'ccc', '$2a$10$CNqJ6xYAiDY43ELt.L0YoODS9q8Y2LgqGfIEOr8BsfIfqVLEYDMVu', 'kennethybanez.yns@gmail.com', 'ccc', 'ccc', 'ccc', '2020-03-27', 'user.png', 'MB-3771704', 1, '2020-03-31 10:32:38', '2020-03-31 10:36:03', NULL, 1),
(218, 'venny', '$2a$10$uG2OnRWr6j4RpBl5U6zbx.pqnXflLkK7fObu2n3h6Ic2Jt9zt1H9G', 'kennethybanez.yns@gmail.com', 'venny', 'puquiz', 'benitez', '1997-03-24', 'user.png', 'MB-9193145', 0, '2020-04-02 06:14:34', '2020-04-02 06:14:34', NULL, 1),
(219, 'venny1', '$2a$10$FMvXKgCFkwms834DoSFf..ZDA4ZGNhsD4xFbPl.a0rilDWXCdp64q', 'kennethybanez.yns@gmail.com', 'venny', 'puquiz', 'benitez', '1997-03-24', 'user.png', 'MB-4513366', 0, '2020-04-02 06:16:19', '2020-04-02 06:16:19', NULL, 1),
(220, 'venny2', '$2a$10$RIXMXmQy7/v1QT2Fzc/qrOYktMZLAwGKgfSOU4APDxZ7KNltJFo22', 'kennethybanez.yns@gmail.com', 'venny', 'puquiz', 'benitez', '1997-03-24', 'user.png', 'MB-1744227', 1, '2020-04-02 06:19:10', '2020-04-02 06:21:53', NULL, 1),
(221, 'venny3', '$2a$10$umEwANs2.OfNb9VA.pZvmuWCVDHLjYK5anpQ.QZt9j5fP3.uUMrNG', 'kennethybanez.yns@gmail.com', 'venny', 'puquiz', 'benitez', '1997-03-24', 'user.png', 'MB-1371488', 0, '2020-04-02 06:20:04', '2020-04-02 06:20:04', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_ibfk_1` (`user_id`),
  ADD KEY `comments_ibfk_2` (`post_id`);

--
-- Indexes for table `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `likes_ibfk_1` (`user_id`),
  ADD KEY `likes_ibfk_2` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
