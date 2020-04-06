-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2020 at 06:59 AM
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

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `comment`, `created`, `modified`, `deleted_date`, `deleted`) VALUES
(1, 10, 219, 'hahahah may baby ka na pala?', '2020-04-06 03:58:56', NULL, NULL, 1);

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

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `created`, `modified`, `date_deleted`, `deleted`) VALUES
(1, 219, 9, '2020-04-06 03:22:57', NULL, NULL, 1),
(2, 214, 9, '2020-04-06 03:22:57', NULL, NULL, 1);

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
(2, 214, NULL, 'Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.', NULL, '2020-04-03 05:28:33', '2020-04-03 05:28:33', NULL, 1),
(3, 219, NULL, 'eto ay niretweet lamang ni loloy', NULL, '2020-04-03 06:42:42', '2020-04-03 06:42:42', NULL, 1),
(4, 214, NULL, 'Tikman ang 2-in-1 sa Laki at Nuot sa Ihaw Sarap Chicken Inasal At Iba Pang Pinoy Meals At Merienda saMang Inasal', NULL, '2020-04-03 06:43:44', '2020-04-03 06:43:44', NULL, 1),
(5, 214, NULL, 'Pope Francis on Saturday asked Catholics to pray for those who are taking advantage of others so that they may be granted with transparent conscience during the COVID-19 pandemic.', NULL, '2020-04-04 17:01:45', '2020-04-04 17:01:45', NULL, 1),
(6, 214, NULL, 'This 10-course, 120-hour coding bundle will take you from absolute novice to a strong foundation from which you can launch a career.', NULL, '2020-04-04 17:02:10', '2020-04-04 17:02:10', NULL, 1),
(7, 214, NULL, 'LOOK: Photos of the Moon over Makati City tonight (60 mins interval). The next Full Moon happens on April 8th at 10:35AM.\r\n\r\n52 years ago today (04 APR 1968): Apollo 6 (AS-502), the final uncrewed test of the Saturn V vehicle, was launched. | via Bob Reyes', NULL, '2020-04-04 17:02:49', '2020-04-04 17:02:49', NULL, 1),
(8, 214, 3, 'laptrip to', NULL, '2020-04-05 06:28:28', '2020-04-05 06:28:28', NULL, 1),
(9, 214, 7, 'Hala ang ganda!!!', NULL, '2020-04-06 02:32:09', '2020-04-06 02:32:09', NULL, 1),
(10, 214, NULL, 'My new Babies', '[\'1.jpg\',\'2.jpg\',\'3.jpg\']', '2020-04-06 02:36:21', '2020-04-06 02:36:21', NULL, 1);

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
(214, 'loloy', '$2a$10$RDpkgpgp86TuXARI6Oc/6./UO/ypuTtys0faThme382cn0B4NNlSG', 'kennethybanez.yns@gmail.com', 'Louisss', 'Baldado', 'Ybanez', '2011-08-31', '214-profilepic.jpg', 'MB-4039981', 1, '2020-03-31 03:09:46', '2020-04-03 09:59:00', NULL, 1),
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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

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
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`);

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
