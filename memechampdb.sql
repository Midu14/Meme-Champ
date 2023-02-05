-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2022 at 03:41 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memechampdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `reply_to_id` int(11) DEFAULT NULL,
  `post_id` int(11) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0,
  `edited` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `content`, `owner_id`, `reply_to_id`, `post_id`, `deleted`, `edited`, `created_at`) VALUES
(2, 'so what now?', 1, NULL, 1, 1, 0, '2022-03-19'),
(3, 'we need to create more features!', 6, 2, 1, 0, 0, '2022-03-19'),
(4, 'wow this is amazing!!', 3, NULL, 1, 0, 1, '2022-03-19'),
(7, 'hahah', 4, 2, 1, 0, 1, '2022-03-19'),
(8, 'whats so funny', 5, 7, 1, 0, 0, '2022-03-19'),
(10, 'your mom lol', 1, 8, 1, 0, 0, '2022-03-21'),
(11, 'whats sugon', 3, NULL, 1, 0, 0, '2022-03-21'),
(12, 'sugon deez balls lol', 3, 11, 1, 0, 0, '2022-03-21'),
(13, 'yup', 1, 4, 1, 0, 0, '2022-03-21'),
(14, 'how long will it take', 4, NULL, 1, 0, 0, '2022-03-22'),
(15, 'how long will it take', 4, NULL, 1, 1, 1, '2022-03-22'),
(16, 'about 6 minutes ', 4, 14, 1, 0, 0, '2022-03-22'),
(17, 'elden ring just came out', 4, 16, 1, 0, 1, '2022-03-22'),
(18, 'elden ring is dope', 4, 17, 1, 0, 0, '2022-03-22'),
(19, 'more like 10 days', 4, 16, 1, 1, 1, '2022-03-22'),
(20, 'this meme sucks ', 1, NULL, 1, 0, 0, '2022-03-29'),
(21, 'tess1', 20, NULL, 1, 1, 1, '2022-04-08'),
(22, 'hahah32', 1, NULL, 4, 1, 1, '2022-04-08'),
(23, 'true dood', 1, 22, 4, 0, 0, '2022-04-08'),
(24, 'delete this now', 26, 10, 1, 0, 0, '2022-04-08'),
(26, 'dont say that', 26, 2, 1, 0, 0, '2022-04-08'),
(27, 'read again maybe you\'ll get the joke', 26, 8, 1, 0, 0, '2022-04-08');

-- --------------------------------------------------------

--
-- Table structure for table `comment_like`
--

CREATE TABLE `comment_like` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comment_like`
--

INSERT INTO `comment_like` (`id`, `user_id`, `comment_id`) VALUES
(13, 1, 2),
(14, 1, 7),
(15, 1, 11),
(16, 1, 10),
(17, 4, 2),
(18, 4, 3),
(19, 4, 4),
(20, 4, 18),
(21, 1, 17),
(22, 20, 12),
(23, 20, 19),
(24, 20, 17),
(25, 1, 22),
(26, 26, 10),
(27, 26, 27);

-- --------------------------------------------------------

--
-- Table structure for table `competition`
--

CREATE TABLE `competition` (
  `id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `competition`
--

INSERT INTO `competition` (`id`, `is_active`, `created_at`) VALUES
(4, 1, '2022-03-19');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comp_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `user_id`, `comp_id`, `title`, `img`, `created_at`) VALUES
(1, 1, 4, 'welcome to memechamps', 'meme1.jpg', '2022-03-19'),
(4, 20, 4, 'am i right guys', 'meme2.jpg', '2022-04-08');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `pfp` varchar(255) NOT NULL DEFAULT '',
  `max_poggers` int(11) NOT NULL DEFAULT 10,
  `is_banned` tinyint(1) NOT NULL DEFAULT 0,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `pfp`, `max_poggers`, `is_banned`, `is_admin`, `created_at`) VALUES
(1, 'Torrent', 'test@test.com', 'test', '2022-03-21-1647884915-1596195639.jpg', 10, 0, 0, '2022-03-15'),
(3, 'test1', 'test1@test.com', 'test', '', 10, 0, 0, '2022-03-15'),
(4, 'test2', 'test2@test.com', 'test', '', 10, 0, 0, '2022-03-15'),
(5, 'test3', 'test3@test.com', 'test', '', 10, 0, 0, '2022-03-15'),
(6, 'test4', 'test4@test.com', 'test', '', 10, 0, 0, '2022-03-15'),
(7, 'test5', 'test5@test.com', 'test', '', 10, 0, 0, '2022-03-15'),
(8, 'test7', 'test7@test.com', 'test', '', 10, 0, 0, '2022-03-15'),
(9, 'test8', 'test6@test.com', 'test', '', 10, 0, 0, '2022-03-15'),
(10, 'test9', 'test9@test.com', 'test', '', 10, 0, 0, '2022-03-15'),
(11, 'test10', 'test10@gmail.com', 'test', '', 10, 0, 0, '2022-03-15'),
(12, 'ddddd', 'ddd@fdsaf.com', 'fdsaf', '', 10, 0, 0, '2022-03-15'),
(13, 'gdfsgd', 'gdsfgd@gfd', 'dad', '', 10, 0, 0, '2022-03-15'),
(14, 'p1', 'p1@p', 'p', '', 10, 0, 0, '2022-03-15'),
(15, 'p2', 'p2@p', 'p', '', 10, 0, 0, '2022-03-15'),
(16, 'p3', 'p3@p', 'p', '', 10, 0, 0, '2022-03-15'),
(17, 'p4', 'p4@p', 'p', '2022-03-16-1647399482-1323223134.jpg', 10, 0, 0, '2022-03-15'),
(18, 'horde', 'horde@horde', 'horde', '2022-03-17-1647529609-853729986.jpg', 10, 0, 0, '2022-03-17'),
(19, 'changedtest', 'john@gmail.com', 'john', '', 10, 0, 0, '2022-03-19'),
(20, 'test', 'test3333@test.com', 'test', '2022-04-04-1649101357-1624848726.jpg', 10, 0, 0, '2022-03-28'),
(21, 'dave', 'dave@dave.com', 'test', '', 10, 0, 0, '2022-03-29'),
(25, 'birb', 'birb@kip.com', 'test', '', 10, 0, 0, '2022-04-08'),
(26, 'honk', 'honk@gmail.com', 'test', '', 10, 0, 0, '2022-04-08');

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` int(11) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`post_id`, `user_id`, `amount`, `created_at`) VALUES
(1, 1, 9, 2147483647),
(1, 20, 10, 2147483647),
(4, 1, 1, 2147483647);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_fk` (`post_id`),
  ADD KEY `reply_to_id` (`reply_to_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `comment_like`
--
ALTER TABLE `comment_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `competition`
--
ALTER TABLE `competition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_fk` (`user_id`),
  ADD KEY `comp_id` (`comp_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_uq` (`email`),
  ADD UNIQUE KEY `username_uq` (`username`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`post_id`,`user_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `comment_like`
--
ALTER TABLE `comment_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `competition`
--
ALTER TABLE `competition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_owner_fk` FOREIGN KEY (`owner_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_post_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_reply_to_fk` FOREIGN KEY (`reply_to_id`) REFERENCES `comment` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `comment_like`
--
ALTER TABLE `comment_like`
  ADD CONSTRAINT `like_comment_fk` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_comp_fk` FOREIGN KEY (`comp_id`) REFERENCES `competition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_post_fk` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vote_user_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
