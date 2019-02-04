-- phpMyAdmin SQL Dump
-- version 4.6.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 01, 2018 at 09:50 AM
-- Server version: 5.6.32
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `matcha`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `username`, `msg`) VALUES
(1, 'Blayze', 'Dance damage.'),
(2, 'sdafasd', 'asdfasdf'),
(3, 'Luke', 'Drean'),
(4, 'Luke', 'Repeat'),
(5, 'Raven', 'Remember me...'),
(6, 'Bruce', 'Hello Gotham.'),
(7, 'Joker', 'Hi Batman.'),
(8, 'Joker', 'Cat got your tongue?'),
(9, 'Bruce', 'Wait'),
(10, 'Joker', 'Cat got your tongue?'),
(11, 'Joker', 'Cat got your tongue?'),
(12, 'Joker', 'Cat got your tongue?'),
(13, 'Clark', 'The daily mail...'),
(14, 'Joker', 'Who is this?'),
(15, 'Clark', 'This is Clark.'),
(16, 'Clark', 'This is Clark.'),
(17, 'Clark', 'This is Clark.'),
(18, 'Clark', 'This is Clark.'),
(19, 'Clark', 'This is Clark.'),
(20, 'Joker', 'Who???'),
(21, 'Clark', 'Clark.Clark Kent.'),
(22, 'Larry', 'This is my message.'),
(23, 'Username', 'fasdfasf');

-- --------------------------------------------------------

--
-- Table structure for table `chat_log`
--

CREATE TABLE `chat_log` (
  `id` int(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `user_id`, `title`) VALUES
(1, 5, '1527523315.jpg'),
(2, 5, '1527581136.jpg'),
(3, 5, '1527583299.jpg'),
(4, 5, '1527583311.jpg'),
(5, 5, '1527583323.jpg'),
(6, 2, '1527581136.jpg'),
(7, 2, '1527583311.jpg'),
(8, 4, '1527581136.jpg'),
(13, 2, '1527765547.jpg'),
(15, 2, '1527766275.jpg'),
(16, 2, '1527766751.jpg'),
(17, 2, '1527766951.jpg'),
(18, 2, '1527767665.jpg'),
(19, 2, '1527767739.jpg'),
(20, 2, '1527768085.jpg'),
(21, 2, '1527768089.jpg'),
(22, 2, '1527768751.jpg'),
(23, 2, '1527768980.jpg'),
(24, 2, '1527769097.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `time` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `user_id`, `time`) VALUES
(1, 1, '1527269827'),
(2, 1, '1527269871'),
(3, 1, '1527269939'),
(4, 1, '1527490035'),
(5, 1, '1527490195'),
(6, 1, '1527490251'),
(7, 1, '1527490378'),
(8, 5, '1527492840'),
(9, 5, '1527492986'),
(10, 5, '1527493021'),
(11, 5, '1527580984'),
(12, 5, '1527580994'),
(13, 5, '1527675131');

-- --------------------------------------------------------

--
-- Table structure for table `matching`
--

CREATE TABLE `matching` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matching`
--

INSERT INTO `matching` (`id`, `user_id`, `contact_id`) VALUES
(1, 2, 5),
(2, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `profile_pic`
--

CREATE TABLE `profile_pic` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `vegan` int(1) NOT NULL DEFAULT '0',
  `geek` int(1) NOT NULL DEFAULT '0',
  `sporty` int(1) NOT NULL DEFAULT '0',
  `thot` int(1) NOT NULL DEFAULT '0',
  `kufc_boy` int(1) NOT NULL DEFAULT '0',
  `drama_queen` int(1) NOT NULL DEFAULT '0',
  `angel` int(1) NOT NULL DEFAULT '0',
  `devil` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dob_year` int(4) NOT NULL,
  `dob_month` int(2) NOT NULL,
  `dob_day` int(2) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fame_rating` int(3) NOT NULL DEFAULT '50',
  `sex` varchar(20) DEFAULT NULL,
  `sex_pref` varchar(20) NOT NULL DEFAULT 'bisexual',
  `bio` text,
  `forgot_pass` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `geo_lat` float DEFAULT NULL,
  `geo_long` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `dob_year`, `dob_month`, `dob_day`, `password`, `fame_rating`, `sex`, `sex_pref`, `bio`, `forgot_pass`, `status`, `geo_lat`, `geo_long`) VALUES
(2, 'Another', 'User', 'Username', 'user@user.com', 1988, 3, 18, '$2y$10$d50eqTaVnizrk7g.mGGncuP1Yh0FlsR7hQV/HxIJQsDmvcSEx2V6S', 50, 'Male', 'Bisexual', ' This is my story... ', NULL, 1, NULL, NULL),
(3, 'Another', 'User', 'Username1', 'user1@user.com', 0, 0, 0, '$2y$10$d50eqTaVnizrk7g.mGGncuP1Yh0FlsR7hQV/HxIJQsDmvcSEx2V6S', 50, NULL, '0', NULL, NULL, 1, NULL, NULL),
(4, 'Another', 'User', 'Username2', 'user2@user.com', 0, 0, 0, '$2y$10$tN0DYRvy.MtcQvvL0iY0e.XZBr2MC1iDlR/HVtD1.6l/augj1Ddu.', 50, NULL, '0', NULL, NULL, 0, NULL, NULL),
(5, 'Axel', 'Bukasa', 'BlackPanther', 'axe.618@gmail.com', 1932, 3, 15, '$2y$10$d50eqTaVnizrk7g.mGGncuP1Yh0FlsR7hQV/HxIJQsDmvcSEx2V6S', 50, 'Male', 'Heterosexual', '  ', NULL, 1, NULL, NULL),
(6, 'Clark', 'Kent', 'Superman', 'clark@dailyplanet.com', 0, 0, 0, '$2y$10$wDijlsR8IJKmFi3zPWFhNua89iYA.s8MpFbzO5BeZQTnbStFLv1Dm', 50, NULL, '0', NULL, NULL, 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_log`
--
ALTER TABLE `chat_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `matching`
--
ALTER TABLE `matching`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile_pic`
--
ALTER TABLE `profile_pic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
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
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `chat_log`
--
ALTER TABLE `chat_log`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `matching`
--
ALTER TABLE `matching`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `profile_pic`
--
ALTER TABLE `profile_pic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
