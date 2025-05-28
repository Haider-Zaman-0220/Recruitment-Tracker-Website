-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 03:09 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recruitment_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `target_type` varchar(50) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `target_type`, `target_id`, `timestamp`) VALUES
(1, 1, 'Logged Out', NULL, NULL, '2025-05-22 23:11:40'),
(2, 4, 'Logged In', NULL, NULL, '2025-05-22 23:14:20'),
(3, 4, 'Added Candidate', NULL, NULL, '2025-05-22 23:15:27'),
(4, 4, 'Logged Out', NULL, NULL, '2025-05-22 23:15:41'),
(5, 4, 'Logged In', NULL, NULL, '2025-05-22 23:17:50'),
(6, 4, 'Updated Candidate', NULL, NULL, '2025-05-22 23:18:10'),
(7, 4, 'Deleted Candidate', NULL, NULL, '2025-05-22 23:18:24'),
(8, 4, 'Logged Out', NULL, NULL, '2025-05-22 23:18:34'),
(9, 6, 'Logged In', NULL, NULL, '2025-05-22 23:23:16'),
(10, 6, 'Logged Out', NULL, NULL, '2025-05-22 23:23:32'),
(11, 4, 'Logged In', NULL, NULL, '2025-05-23 00:42:51'),
(12, 4, 'Updated Job', NULL, NULL, '2025-05-23 00:43:31'),
(13, 4, 'Updated Job', NULL, NULL, '2025-05-23 00:43:49'),
(14, 4, 'Added Candidate', NULL, NULL, '2025-05-23 00:45:01'),
(15, 4, 'Added Job', NULL, NULL, '2025-05-23 00:53:57'),
(16, 4, 'Logged Out', NULL, NULL, '2025-05-23 00:54:09'),
(17, 4, 'Logged In', NULL, NULL, '2025-05-23 05:50:38'),
(18, 4, 'Added Job', NULL, NULL, '2025-05-23 05:52:05'),
(19, 4, 'Updated Job', NULL, NULL, '2025-05-23 05:52:42'),
(20, 4, 'Logged Out', NULL, NULL, '2025-05-23 05:54:32'),
(21, 4, 'Logged In', NULL, NULL, '2025-05-23 05:54:57'),
(22, 4, 'Logged Out', NULL, NULL, '2025-05-23 05:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `status` enum('Applied','Interviewed','Hired','Rejected') DEFAULT 'Applied',
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `name`, `email`, `phone`, `position`, `status`, `department_id`) VALUES
(1, 'Muhmmad Anas', 'm.anas34@gmail.com', '034720845355', 'Software Engineer', 'Hired', 1),
(3, 'Haris Ali', 'ha32@gmail.com', '03472085778', 'UI/UX Designer', 'Hired', 1),
(4, 'Fawad Alam', 'fa030@gmail.com', '03241213211', 'Data Analyst', 'Interviewed', 1),
(5, 'Owais Khan', 'Ok21@gmail.com', '03901231221', 'ML Engineer', 'Applied', 1),
(6, 'Hammid Ali Khan', 'ha109@gmail.com', '0321339483', 'Computer Operator', 'Rejected', 1),
(7, 'Abid Ali', 'Aali28@gmail.com', '03214234234', 'UI/UX Designer', 'Rejected', 1),
(8, 'Tahir Mehmood', 'tm330@gmail.com', '03213424232', 'ML Engineer', 'Hired', 1),
(10, 'Ahmed Rajput', 'ar90@gmail.com', '0342324242', 'QA Engineer', 'Applied', 1),
(11, 'Muhammad Huzaifa', 'hk89@gmail.com', '0323424534', 'Data Scientist', 'Hired', 1),
(12, 'Ahmed Mujtaba', 'am567@gamil.com', '0342512341', 'Data Scientist', 'Applied', 1),
(13, 'Ehsan Mir', 'em90@gmail.com', '032167564564', 'Radiologist', 'Interviewed', 3);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`) VALUES
(1, 'IT Department', 'A place for all the brilliant and innovative minds in the field of Technology'),
(2, 'Management Department', 'The Management Department focuses on the principles of leadership, strategy, and organizational effectiveness. We equip individuals with the skills to lead teams and drive organizational success.'),
(3, 'Medical Department', 'The Medical Department is dedicated to the health and well-being of individuals through expert clinical care and medical knowledge. We strive to provide compassionate and effective treatment.');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `description`, `location`, `salary`, `department_id`) VALUES
(1, 'Software Engineer', 'Need an Experienced Software Engineer.', 'Peshawar', '60000.00', 1),
(2, 'UI/UX designer', 'Need a UI/UX designer with 5 years of experience', 'Rawalpindi', '69000.00', 1),
(4, 'Computer Opeartor', 'Need a Dedicated Computer Operator with 1 year of Experience', 'Kohat', '45000.00', 1),
(5, 'ML Engineer ', 'Looking for an experienced ML engineer that is proficient in Python.', 'Peshawar', '98000.00', 1),
(6, 'Android App Developer', 'Need An App Developer for Android with 2 years of experience', 'Rawalpindi', '50000.00', 1),
(7, 'Quality Assurance Engineer ', 'Need a highly experienced QA Engineer.', 'Peshawar', '60000.00', 1),
(8, 'Data Scientist', 'Need a highly experienced Data Scientist.', 'Peshawar', '100000.00', 1),
(9, 'Project Manager ', 'Need a Project Manager with 12 years of experience.', 'Peshawar', '130000.00', 1),
(10, 'Radiologist', 'Need a Radiologist with 5 years of experience', 'Peshawar', '70000.00', 3),
(11, 'Dentist', 'Looking for a Dentist with 7 years of experience', 'Rawalpindi', '85000.00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `role`) VALUES
(1, 'Admin User', 'admin@example.com', 'admin', '$2y$10$aGHu/8TRdSK2q6YYkvMdGO6L83R.hvhznR.PH3mHuY2bnwWmvx.hK', 'admin'),
(4, 'Haider Zaman', 'haider.zaman230@gmail.com', 'haider', '$2y$10$XEcEJ1206DA5rrcuo.05GOf5O8E1VxZnhFAdkxQPkNZm2dgwpVJA2', 'user'),
(6, 'Abdullah Azib', 'az44@gmail.com', 'azib', '$2y$10$i3iSnd3IZk2SQCcAnqi2.umPr8S5Okv.JjkLM63TMTpXsnmRMqPMG', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dept_cand` (`department_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dept_job` (`department_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `fk_dept_cand` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `fk_dept_job` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
