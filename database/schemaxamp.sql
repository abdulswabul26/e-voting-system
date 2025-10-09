-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2025 at 10:25 AM
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
-- Database: `evotingdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE IF NOT EXISTS `candidates` (
  `candidate_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `department` varchar(25) NOT NULL,
  `photo_url` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`candidate_id`),
  UNIQUE KEY `reg_no` (`reg_no`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`candidate_id`, `full_name`, `reg_no`, `department`, `photo_url`, `created_at`) VALUES
(2, 'Esther Nakato', '2024-04-26248', 'Computer Science', '', '2025-09-07 05:33:16'),
(11, 'Kato Lubwama', '2024-04-54545', 'Law', '../public/assets/uploads/candidates/candidate_68e45bb5f20a60.51778484.jpg', '2025-10-07 00:15:49'),
(12, 'Alice Namanya', 'CS2025001', 'Computer Science', 'https://randomuser.me/api/portraits/women/21.jpg', '2025-10-01 06:30:00'),
(13, 'Brian Okello', 'LAW2025002', 'Law', 'https://randomuser.me/api/portraits/men/32.jpg', '2025-10-01 07:00:00'),
(14, 'Clara Nakitende', 'IT2025003', 'Information Technology', 'https://randomuser.me/api/portraits/women/45.jpg', '2025-10-01 07:30:00'),
(15, 'David Kiggundu', 'ENG2025004', 'Engineering', 'https://randomuser.me/api/portraits/men/54.jpg', '2025-10-01 08:00:00'),
(16, 'Evelyn Ssali', 'MED2025005', 'Medicine', 'https://randomuser.me/api/portraits/women/67.jpg', '2025-10-01 08:30:00'),
(17, 'John Doe', '2024-06-26255', 'BSTAT', '../public/assets/uploads/candidates/candidate_68e474e11b1ad8.02834696.jpg', '2025-10-07 02:03:13');

-- --------------------------------------------------------

--
-- Table structure for table `elections`
--

CREATE TABLE IF NOT EXISTS `elections` (
  `election_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `election_date` date NOT NULL,
  `status` enum('upcoming','open','closed') NOT NULL DEFAULT 'upcoming',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`election_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `department` varchar(25) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `role` enum('voter','admin') DEFAULT 'voter',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `reg_no` (`reg_no`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_otps`
--

CREATE TABLE IF NOT EXISTS `user_otps` (
  `otp_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `otp_code` varchar(10) NOT NULL,
  `expires_at` datetime NOT NULL,
  `is_used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`otp_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_otps`
--

INSERT INTO `user_otps` (`otp_id`, `user_id`, `otp_code`, `expires_at`, `is_used`, `created_at`) VALUES
(168, 2, '625302', '2025-09-15 20:49:59', 0, '2025-09-15 18:44:59'),
(171, 3, '585389', '2025-09-17 11:40:06', 1, '2025-09-17 09:35:06');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `vote_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `voted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`vote_id`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `candidate_id` (`candidate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Constraints for dumped tables
--

--
-- Constraints for table `user_otps`
--
ALTER TABLE `user_otps`
  ADD CONSTRAINT `user_otps_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`candidate_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
