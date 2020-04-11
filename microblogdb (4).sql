-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2020 at 10:26 AM
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
  `modified` timestamp NULL DEFAULT current_timestamp(),
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

--
-- Dumping data for table `followers`
--

INSERT INTO `followers` (`id`, `user_id`, `following_id`, `created`, `modified`, `deleted_date`, `deleted`) VALUES
(18, 224, 214, '2020-04-10 17:44:37', NULL, NULL, 1),
(19, 214, 224, '2020-04-10 17:45:02', '2020-04-10 17:45:19', NULL, 0),
(20, 214, 224, '2020-04-11 04:39:54', '2020-04-11 04:48:43', NULL, 0),
(21, 214, 224, '2020-04-11 04:52:07', '2020-04-11 08:13:19', NULL, 0),
(22, 214, 218, '2020-04-11 06:25:08', NULL, NULL, 1),
(23, 214, 224, '2020-04-11 08:14:14', '2020-04-11 08:14:14', NULL, 1);

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
(88, 214, NULL, 'blog 1 haha', '[\"72140-postpic.png\"]', '2020-04-11 06:57:52', '2020-04-11 07:22:55', NULL, 1),
(89, 224, NULL, 'blog 2', NULL, '2020-04-11 06:58:02', '2020-04-11 06:58:02', NULL, 1),
(90, 214, NULL, 'blog 3', NULL, '2020-04-11 06:58:17', '2020-04-11 07:19:28', '2020-04-11 07:19:28', 0),
(91, 224, NULL, 'blog 4', NULL, '2020-04-11 06:58:21', '2020-04-11 06:58:21', NULL, 1),
(92, 214, NULL, 'blog 5', NULL, '2020-04-11 06:58:27', '2020-04-11 06:58:27', NULL, 1),
(93, 224, NULL, 'blog 6', NULL, '2020-04-11 06:58:34', '2020-04-11 06:58:34', NULL, 1),
(94, 214, NULL, 'blog 777', '[\"72140-postpic.jpg\"]', '2020-04-11 07:05:18', '2020-04-11 08:10:20', NULL, 1),
(95, 214, NULL, 'blog 888', '[]', '2020-04-11 07:05:26', '2020-04-11 08:07:14', NULL, 1),
(96, 214, NULL, 'blog 9', NULL, '2020-04-11 07:05:35', '2020-04-11 07:55:55', '2020-04-11 07:55:55', 0),
(97, 224, 89, '', NULL, '2020-04-11 07:38:26', '2020-04-11 07:38:26', NULL, 1);

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
(214, 'loloy', '$2a$10$Qx7Ud4prBkCE/wdurpsCj.gRipeHK3ndGQGSR.UhOWymk35X2RZm.', 'kennethybanez.yns@gmail.com', 'Louis', 'Baldado', 'Ybanez', '2011-08-31', '214-profilepic.jpg', 'MB-4039981', 1, '2020-03-31 03:09:46', '2020-04-11 04:45:38', NULL, 1),
(215, 'xxx', '$2a$10$w9O0izgFpPSJ/AvXW0eGTu0gN8LPX0bryX9p79c2lCjmxj6Bo/vcC', 'kennethybanez.yns@gmail.com', 'xxx', 'xxx', 'xxx', '2020-03-18', 'user.png', 'MB-8020532', 1, '2020-03-31 10:26:11', '2020-03-31 10:27:13', NULL, 1),
(216, 'bbb', '$2a$10$laD0DZZiokl0jJmfrjg7lOzcR0zDSoh.e8OfKFmH13QDx6qaH4VSe', 'kennethybanez.yns@gmail.com', 'bbb', 'bbb', 'bbb', '2020-03-17', 'user.png', 'MB-6676593', 1, '2020-03-31 10:28:07', '2020-03-31 10:29:21', NULL, 1),
(217, 'ccc', '$2a$10$CNqJ6xYAiDY43ELt.L0YoODS9q8Y2LgqGfIEOr8BsfIfqVLEYDMVu', 'kennethybanez.yns@gmail.com', 'ccc', 'ccc', 'ccc', '2020-03-27', 'user.png', 'MB-3771704', 1, '2020-03-31 10:32:38', '2020-03-31 10:36:03', NULL, 1),
(218, 'venny', '$2a$10$uG2OnRWr6j4RpBl5U6zbx.pqnXflLkK7fObu2n3h6Ic2Jt9zt1H9G', 'kennethybanez.yns@gmail.com', 'venny', 'puquiz', 'benitez', '1997-03-24', 'user.png', 'MB-9193145', 0, '2020-04-02 06:14:34', '2020-04-02 06:14:34', NULL, 1),
(219, 'venny1', '$2a$10$FMvXKgCFkwms834DoSFf..ZDA4ZGNhsD4xFbPl.a0rilDWXCdp64q', 'kennethybanez.yns@gmail.com', 'venny', 'puquiz', 'benitez', '1997-03-24', 'user.png', 'MB-4513366', 0, '2020-04-02 06:16:19', '2020-04-02 06:16:19', NULL, 1),
(220, 'venny2', '$2a$10$RIXMXmQy7/v1QT2Fzc/qrOYktMZLAwGKgfSOU4APDxZ7KNltJFo22', 'kennethybanez.yns@gmail.com', 'venny', 'puquiz', 'benitez', '1997-03-24', 'user.png', 'MB-1744227', 1, '2020-04-02 06:19:10', '2020-04-02 06:21:53', NULL, 1),
(221, 'venny3', '$2a$10$umEwANs2.OfNb9VA.pZvmuWCVDHLjYK5anpQ.QZt9j5fP3.uUMrNG', 'kennethybanez.yns@gmail.com', 'venny', 'puquiz', 'benitez', '1997-03-24', 'user.png', 'MB-1371488', 0, '2020-04-02 06:20:04', '2020-04-02 06:20:04', NULL, 1),
(222, 'kenneth', '$2a$10$Zslro6Zuk0ZHfcEkh3FooO4zQ4kh/rBEIlKEYdrsBHdeK8Iab5BeW', 'kennethybanez.yns@gmail.com', 'kenneth', 'baldado', 'ybanez', '1997-07-13', 'user.png', 'MB-5384449', 1, '2020-04-07 01:48:06', '2020-04-07 01:49:00', NULL, 1),
(223, 'popo', '$2a$10$OFs.8XghZG4UUgguQqgVKOC6Jz2QSYnLKkkZGusJdGHZ9rYtCDBJe', 'kennethybanez.yns@gmail.com', 'popo', 'popo', 'popo', '1990-01-01', '223-profilepic.jpg', 'MB-4354310', 1, '2020-04-07 01:50:05', '2020-04-07 01:58:53', NULL, 1),
(224, 'koko', '$2a$10$vuccpKgu.Z3zPs.3TabCduhOYepAALWvlOOuDWHZ14UJg53VYhkQq', 'kennethybanez.yns@gmail.com', 'Koko', 'koko', 'Crunch', '1890-01-13', '224-profilepic.jpg', 'MB-76571311', 1, '2020-04-07 17:30:55', '2020-04-11 04:48:30', NULL, 1),
(225, 'aaa', '$2a$10$SwQONAD2pypncxZI4ufXG.S1FNSbIeCiXUmVC/syWf78Azpp/b8SK', 'kennethybanezs.yns@gmail.com', 'aaa', 'aaa', 'aaa', '2020-04-08', 'user.png', 'MB-86985812', 0, '2020-04-09 05:40:06', '2020-04-09 05:40:06', NULL, 1),
(226, 'sad', '$2a$10$d1QkbAufTMv0kxEv/IVsZebokHqWsrg304UOIsh8nofSYmflKrh6q', 'kennethybanez.yn3s@gmail.com', '\"a\"', 's', 'aa', '2020-04-08', 'user.png', 'MB-64380113', 0, '2020-04-09 07:00:15', '2020-04-09 07:00:15', NULL, 1),
(227, '\"<script>alert(\"hacked\")</script>\"', '$2a$10$/I8PNbD9HlHJzmSzmi97sOaijEQKmzFFNzaVRAqGSPLtQ319ijEya', 'y@yahoo.com', '\"alert(\"hacked\")\"', '\"alert(\"hacked\")\"', '\"alert(\"hacked\")\"', '2020-04-14', 'user.png', 'MB-40745514', 0, '2020-04-09 07:15:11', '2020-04-09 07:15:11', NULL, 1),
(228, 'ad!@#$%^&*()_+=', '$2a$10$fF8/cZ.Tb0WrOuUTG85YsOJF5CaUywpaUPzLNLVFoOsC1I/HBOiki', 'asd@asd.com', 'ad', '\"ad\"', '\"ad\"', '2020-04-23', 'user.png', 'MB-48586915', 0, '2020-04-09 07:19:50', '2020-04-09 07:19:50', NULL, 1);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `following_id` (`following_id`);

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `followers`
--
ALTER TABLE `followers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

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
-- Constraints for table `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
