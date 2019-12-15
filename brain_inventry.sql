-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 15, 2019 at 12:53 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brain_inventry`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userId` bigint(20) NOT NULL,
  `first_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `social_id` varchar(255) NOT NULL,
  `social_type` varchar(20) CHARACTER SET utf16 NOT NULL COMMENT 'facebook, google',
  `profile_photo` text CHARACTER SET utf8 NOT NULL,
  `is_profile_url` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1: url, 0: name',
  `contact_detail` varchar(255) CHARACTER SET utf8 NOT NULL,
  `country` varchar(100) NOT NULL,
  `gender` tinyint(4) NOT NULL COMMENT '1:male,0:female',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1:Active,0:Inactive ',
  `crd` datetime NOT NULL,
  `upd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `first_name`, `last_name`, `email`, `password`, `social_id`, `social_type`, `profile_photo`, `is_profile_url`, `contact_detail`, `country`, `gender`, `status`, `crd`, `upd`) VALUES
(1, 'dfsdfsdfsdfsf', 'asdfsdfasdfa', 'mca.tushar@yahoo.in', '$2y$10$2KG5lSSLDYJ8Vu0D/z9Kw.DE.8aF6G3qzg2ZILD5Ouqd7.0gg.JDi', '', '', '', 0, 'gsgsdgsdf', 'fgsdfgsdfg', 1, 1, '2019-12-15 11:36:11', '2019-12-15 11:36:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userId` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
