-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2025 at 08:59 AM
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

CREATE TABLE `candidates` (
  `candidate_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `department` varchar(25) NOT NULL,
  `photo_url` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `elections` (
  `election_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `election_date` date NOT NULL,
  `status` enum('upcoming','open','closed') NOT NULL DEFAULT 'upcoming',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `department` varchar(25) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `role` enum('voter','admin') DEFAULT 'voter',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `reg_no`, `full_name`, `email`, `department`, `status`, `role`, `created_at`) VALUES
(1, '2024-04-26244', 'Sserunjogi Abdul Swabul', 'swabul.sserunjogi@studmc.kiu.ac.ug', 'Information Technology', '0', 'admin', '2025-09-07 05:33:16'),
(2, '2024-04-26245', 'Brian Mugisha', 'brian.mugisha@example.ug', '', '0', 'voter', '2025-09-07 05:33:16'),
(3, '2024-04-26246', 'Catherine Kintu', 'catherine.kintu@example.com', '', '0', 'voter', '2025-09-07 05:33:16'),
(4, '2024-04-00001', 'David Smith', 'davidsmith@example.com', 'Economics', '0', 'voter', '2025-10-04 17:24:40'),
(5, '2024-04-00002', 'Emily Miller', 'emilymiller@example.com', 'Chemistry', '0', 'voter', '2025-10-04 17:24:40'),
(6, '2024-04-00003', 'Michael Brown', 'michaelbrown@example.com', 'Economics', '0', 'voter', '2025-10-04 17:24:40'),
(7, '2024-04-00004', 'Olivia Anderson', 'oliviaanderson@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:24:40'),
(8, '2024-04-00005', 'James Brown', 'jamesbrown@example.com', 'Biology', '0', 'voter', '2025-10-04 17:24:40'),
(9, '2024-04-00006', 'Jane Moore', 'janemoore@example.com', 'Economics', '0', 'voter', '2025-10-04 17:24:40'),
(10, '2024-04-00007', 'David Doe', 'daviddoe@example.com', 'Biology', '0', 'voter', '2025-10-04 17:24:40'),
(11, '2024-04-00008', 'Jane Wilson', 'janewilson@example.com', 'Chemistry', '0', 'voter', '2025-10-04 17:24:40'),
(12, '2024-04-00009', 'Michael Davis', 'michaeldavis@example.com', 'Business Admin', '0', 'voter', '2025-10-04 17:24:40'),
(13, '2024-04-00010', 'David Johnson', 'davidjohnson@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:24:40'),
(14, '2024-04-00011', 'Laura Wilson', 'laurawilson@example.com', 'Business Admin', '0', 'voter', '2025-10-04 17:24:40'),
(15, '2024-04-00012', 'Laura Brown', 'laurabrown@example.com', 'Chemistry', '0', 'voter', '2025-10-04 17:24:40'),
(16, '2024-04-00013', 'Sarah Davis', 'sarahdavis@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:24:40'),
(17, '2024-04-00014', 'Sarah Doe', 'sarahdoe@example.com', 'Business Admin', '0', 'voter', '2025-10-04 17:24:40'),
(35, '2024-04-00016', 'Olivia Taylor', 'oliviataylor@example.com', 'Business Admin', '0', 'voter', '2025-10-04 17:27:27'),
(36, '2024-04-00017', 'Sarah Wilson', 'sarahwilson@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:27:27'),
(38, '2024-04-00019', 'Michael Wilson', 'michaelwilson@example.com', 'Computer Science', '0', 'voter', '2025-10-04 17:27:27'),
(39, '2024-04-00020', 'Laura Anderson', 'lauraanderson@example.com', 'Chemistry', '0', 'voter', '2025-10-04 17:27:27'),
(40, '2024-04-00021', 'Daniel Davis', 'danieldavis@example.com', 'Business Admin', '0', 'voter', '2025-10-04 17:27:27'),
(41, '2024-04-00022', 'John Davis', 'johndavis@example.com', 'Computer Science', '0', 'voter', '2025-10-04 17:27:27'),
(42, '2024-04-00023', 'Daniel Anderson', 'danielanderson@example.com', 'Economics', '0', 'voter', '2025-10-04 17:27:27'),
(43, '2024-04-00024', 'Laura Davis', 'lauradavis@example.com', 'Chemistry', '0', 'voter', '2025-10-04 17:27:27'),
(44, '2024-04-00025', 'Emily Johnson', 'emilyjohnson@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:27:27'),
(45, '2024-04-00026', 'Jane Johnson', 'janejohnson@example.com', 'Computer Science', '0', 'voter', '2025-10-04 17:27:27'),
(46, '2024-04-00027', 'Emily Doe', 'emilydoe@example.com', 'Chemistry', '0', 'voter', '2025-10-04 17:27:27'),
(47, '2024-04-00028', 'Olivia Davis', 'oliviadavis@example.com', 'Business Admin', '0', 'voter', '2025-10-04 17:27:27'),
(48, '2024-04-00029', 'Laura Miller', 'lauramiller@example.com', 'Economics', '0', 'voter', '2025-10-04 17:27:27'),
(49, '2024-04-00030', 'Olivia Johnson', 'oliviajohnson@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:27:27'),
(50, '2024-04-00031', 'Emily Davis', 'emilydavis@example.com', 'Chemistry', '0', 'voter', '2025-10-04 17:27:27'),
(52, '2024-04-00033', 'Jane Anderson', 'janeanderson@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:27:27'),
(53, '2024-04-00034', 'Laura Taylor', 'laurataylor@example.com', 'Chemistry', '0', 'voter', '2025-10-04 17:27:27'),
(55, '2024-04-00036', 'James Taylor', 'jamestaylor@example.com', 'Computer Science', '0', 'voter', '2025-10-04 17:27:27'),
(56, '2024-04-00037', 'John Miller', 'johnmiller@example.com', 'Computer Science', '0', 'voter', '2025-10-04 17:27:27'),
(59, '2024-04-00040', 'Daniel Smith', 'danielsmith@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:27:27'),
(60, '2024-04-00041', 'Daniel Johnson', 'danieljohnson@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:27:27'),
(61, '2024-04-00042', 'Daniel Doe', 'danieldoe@example.com', 'Engineering', '0', 'voter', '2025-10-04 17:27:27'),
(62, '2024-04-00043', 'Jane Brown', 'janebrown@example.com', 'Physics', '0', 'voter', '2025-10-04 17:27:27'),
(63, '2024-04-00044', 'Emily Brown', 'emilybrown@example.com', 'Chemistry', '0', 'voter', '2025-10-04 17:27:27'),
(64, '2024-04-00045', 'Sarah Smith', 'sarahsmith@example.com', 'Computer Science', '0', 'voter', '2025-10-04 17:27:27'),
(65, '2024-04-00046', 'Michael Taylor', 'michaeltaylor@example.com', 'Business Admin', '0', 'voter', '2025-10-04 17:27:27'),
(66, '2024-04-00047', 'Emily Moore', 'emilymoore@example.com', 'Business Admin', '0', 'voter', '2025-10-04 17:27:27'),
(67, '2024-04-00048', 'Daniel Wilson', 'danielwilson@example.com', 'Biology', '0', 'voter', '2025-10-04 17:27:27'),
(68, '2024-04-00049', 'Olivia Miller', 'oliviamiller@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:27:27'),
(70, '2024-04-00051', 'John Taylor', 'johntaylor@example.com', 'Business Admin', '0', 'voter', '2025-10-04 17:27:27'),
(73, '2024-04-00054', 'Emily Wilson', 'emilywilson@example.com', 'Engineering', '0', 'voter', '2025-10-04 17:27:27'),
(74, '2024-04-00055', 'Jane Taylor', 'janetaylor@example.com', 'Computer Science', '0', 'voter', '2025-10-04 17:27:27'),
(79, '2024-04-00060', 'Michael Miller', 'michaelmiller@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:27:27'),
(80, '2024-04-00061', 'John Moore', 'johnmoore@example.com', 'Engineering', '0', 'voter', '2025-10-04 17:27:27'),
(83, '2024-04-00064', 'James Anderson', 'jamesanderson@example.com', 'Business Admin', '0', 'voter', '2025-10-04 17:27:27'),
(84, '2024-04-00065', 'John Smith', 'johnsmith@example.com', 'Biology', '0', 'voter', '2025-10-04 17:27:27'),
(87, '2024-04-00068', 'James Smith', 'jamessmith@example.com', 'Physics', '0', 'voter', '2025-10-04 17:27:27'),
(89, '2024-04-00070', 'Michael Doe', 'michaeldoe@example.com', 'Computer Science', '0', 'voter', '2025-10-04 17:27:27'),
(90, '2024-04-00071', 'Laura Smith', 'laurasmith@example.com', 'Business Admin', '0', 'voter', '2025-10-04 17:27:27'),
(91, '2024-04-00072', 'James Miller', 'jamesmiller@example.com', 'Engineering', '0', 'voter', '2025-10-04 17:27:27'),
(92, '2024-04-00073', 'John Brown', 'johnbrown@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:27:27'),
(93, '2024-04-00074', 'David Anderson', 'davidanderson@example.com', 'Chemistry', '0', 'voter', '2025-10-04 17:27:27'),
(95, '2024-04-00076', 'James Davis', 'jamesdavis@example.com', 'Business Admin', '0', 'voter', '2025-10-04 17:27:27'),
(97, '2024-04-00078', 'Jane Doe', 'janedoe@example.com', 'Biology', '0', 'voter', '2025-10-04 17:27:27'),
(100, '2024-04-00081', 'John Johnson', 'johnjohnson@example.com', 'Biology', '0', 'voter', '2025-10-04 17:27:27'),
(106, '2024-04-00087', 'David Miller', 'davidmiller@example.com', 'Biology', '0', 'voter', '2025-10-04 17:27:27'),
(107, '2024-04-00088', 'Daniel Miller', 'danielmiller@example.com', 'Computer Science', '0', 'voter', '2025-10-04 17:27:27'),
(109, '2024-04-00090', 'Olivia Moore', 'oliviamoore@example.com', 'Biology', '0', 'voter', '2025-10-04 17:27:27'),
(110, '2024-04-00091', 'David Taylor', 'davidtaylor@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:27:27'),
(114, '2024-04-00095', 'David Wilson', 'davidwilson@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:27:27'),
(116, '2024-04-00097', 'David Moore', 'davidmoore@example.com', 'Mathematics', '0', 'voter', '2025-10-04 17:27:27'),
(117, '2024-04-00098', 'John Doe', 'johndoe@example.com', 'Engineering', '0', 'voter', '2025-10-04 17:27:27'),
(118, '2024-04-00099', 'Daniel Moore', 'danielmoore@example.com', 'Chemistry', '0', 'voter', '2025-10-04 17:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `user_otps`
--

CREATE TABLE `user_otps` (
  `otp_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp_code` varchar(10) NOT NULL,
  `expires_at` datetime NOT NULL,
  `is_used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `votes` (
  `vote_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `voted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`vote_id`, `user_id`, `candidate_id`, `voted_at`) VALUES
(17, 3, 11, '2025-10-07 01:49:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`candidate_id`),
  ADD UNIQUE KEY `reg_no` (`reg_no`);

--
-- Indexes for table `elections`
--
ALTER TABLE `elections`
  ADD PRIMARY KEY (`election_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `reg_no` (`reg_no`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_otps`
--
ALTER TABLE `user_otps`
  ADD PRIMARY KEY (`otp_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`vote_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `candidate_id` (`candidate_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `candidate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `elections`
--
ALTER TABLE `elections`
  MODIFY `election_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `user_otps`
--
ALTER TABLE `user_otps`
  MODIFY `otp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
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
