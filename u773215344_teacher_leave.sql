-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2025 at 06:05 AM
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
-- Database: `u773215344_teacher_leave`
--

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `leave_type` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `leave_details` varchar(255) NOT NULL,
  `commutation` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `specify_abroad` varchar(255) DEFAULT NULL,
  `specify_illness_hospital` varchar(255) DEFAULT NULL,
  `specify_illness_outpatient` varchar(255) DEFAULT NULL,
  `specify_special_leave_women` varchar(255) DEFAULT NULL,
  `date_submitted` datetime DEFAULT current_timestamp(),
  `rejection_remarks` text DEFAULT NULL,
  `approved_personnel` varchar(3) DEFAULT 'No',
  `approved_head` varchar(3) DEFAULT 'No',
  `approved_asds` varchar(3) DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `user_id`, `leave_type`, `start_date`, `end_date`, `leave_details`, `commutation`, `status`, `specify_abroad`, `specify_illness_hospital`, `specify_illness_outpatient`, `specify_special_leave_women`, `date_submitted`, `rejection_remarks`, `approved_personnel`, `approved_head`, `approved_asds`) VALUES
(24, 'ST0001', 'Vacation Leave', '2024-12-30', '2025-01-06', 'Abroad', 'Not Requested', 'Approved', 'Thailand', '', '', '', '2024-12-12 02:15:08', '', 'Yes', 'Yes', 'Yes'),
(25, 'ST0002', 'Sick Leave', '2024-12-12', '2024-12-13', 'Within the Philippines', 'Not Requested', 'Approved by ASDS', '', '', '', '', '2024-12-12 02:15:52', '', 'Yes', 'Yes', 'Yes'),
(26, 'ST0005', 'Sick Leave', '2024-12-12', '2024-12-18', 'Within the Philippines', 'Not Requested', 'Approved by ASDS', '', '', '', '', '2024-12-12 02:16:39', '', 'Yes', 'Yes', 'Yes'),
(27, 'ST0006', 'Maternity Leave', '2024-12-12', '2025-01-06', 'Within the Philippines', 'Not Requested', 'Approved by ASDS', '', '', '', '', '2024-12-12 02:19:22', '', 'Yes', 'Yes', 'Yes'),
(28, 'TRY1234', 'Vacation Leave', '2024-12-13', '2024-12-28', 'Abroad', 'Requested', 'Approved', 'Vietnam', '', '', '', '2024-12-12 04:28:52', '', 'Yes', 'Yes', 'Yes'),
(29, 'ST1234', 'Vacation Leave', '2024-12-12', '2024-12-20', 'Within the Philippines', 'Requested', 'Approved by ASDS', '', '', '', '', '2024-12-12 09:33:14', '', 'Yes', 'Yes', 'Yes'),
(30, 'ST1234', 'Special Leave', '2024-12-13', '2024-12-24', 'Within the Philippines', 'Requested', 'Approved', '', '', '', '', '2024-12-12 09:35:06', '', 'Yes', 'Yes', 'Yes'),
(31, 'ST1234', 'Sick Leave', '2024-12-14', '2024-12-24', 'Within the Philippines', 'Requested', 'Rejected by Personnel Head', '', '', '', '', '2024-12-12 09:37:04', 'Outdated Documents', 'Yes', 'No', 'No'),
(32, 'ST1234', 'Paternity Leave', '2024-12-15', '2024-12-28', 'Within the Philippines', 'Not Requested', 'Rejected by Personnel', '', '', '', '', '2024-12-12 09:37:34', 'Outdated Documents', 'No', 'No', 'No'),
(33, 'ST1234', 'Vacation Leave', '2024-12-20', '2024-12-20', 'Abroad', 'Not Requested', 'Canceled', 'Thailand', '', '', '', '2024-12-12 09:39:25', NULL, 'No', 'No', 'No'),
(34, 'JOR1234', 'Vacation Leave', '2024-12-21', '2024-12-28', 'Within the Philippines', 'Not Requested', 'Approved', '', '', '', '', '2024-12-21 11:13:53', '', 'Yes', 'Yes', 'Yes'),
(35, 'TE0128', 'Vacation Leave', '2025-02-11', '2025-02-20', 'Abroad', 'Not Requested', 'Rejected by Personnel', 'Vietnam', '', '', '', '2025-02-10 08:49:31', 'nothing\r\n', 'No', 'No', 'No'),
(36, 'TE0128', 'Vacation Leave', '2025-02-15', '2025-02-25', 'In Hospital', 'Requested', 'Approved by ASDS', '', ' ', '', '', '2025-02-12 00:14:25', '', 'Yes', 'Yes', 'Yes'),
(37, 'ST000', 'Special Leave Benefits for Women', '2025-02-19', '2025-02-28', 'Terminal Leave', 'Requested', 'Rejected by Personnel Head', '', '', '', '', '2025-02-19 02:31:49', 'nthng', 'Yes', 'No', 'No'),
(38, 'ST0022', 'Vacation Leave', '2025-02-28', '2025-03-26', 'Within the Philippines', 'Requested', 'Approved by Personnel', '', '', '', '', '2025-03-28 12:46:27', '', 'Yes', 'No', 'No'),
(39, 'TEC0406', 'Vacation Leave', '2025-04-02', '2025-04-15', 'Within the Philippines', 'Requested', 'Pending', '', '', '', '', '2025-04-03 09:26:59', NULL, 'No', 'No', 'No'),
(40, 'TEC0406', 'Vacation Leave', '2025-04-07', '2025-04-21', 'Within the Philippines', 'Not Requested', 'Pending', '', '', '', '', '2025-04-03 09:27:12', NULL, 'No', 'No', 'No'),
(41, 'TEC0406', 'Special Privilege', '2025-04-14', '2025-04-28', 'Within the Philippines', 'Not Requested', 'Pending', '', '', '', '', '2025-04-03 09:27:19', NULL, 'No', 'No', 'No'),
(42, 'TEC0406', 'Vacation Leave', '2025-04-28', '2025-05-05', 'Within the Philippines', 'Requested', 'Pending', '', '', '', '', '2025-04-03 09:27:23', NULL, 'No', 'No', 'No'),
(43, 'TEC0406', 'Vacation Leave', '2025-04-11', '2025-04-17', 'Within the Philippines', 'Requested', 'Pending', '', '', '', '', '2025-04-03 09:44:45', NULL, 'No', 'No', 'No'),
(44, 'TEC0406', 'Vacation Leave', '2025-04-01', '2025-04-14', 'Within the Philippines', 'Requested', 'Pending', '', '', '', '', '2025-04-03 09:45:01', NULL, 'No', 'No', 'No'),
(45, 'TEC0406', 'Vacation Leave', '2025-04-02', '2025-04-25', 'Within the Philippines', 'Requested', 'Pending', '', '', '', '', '2025-04-03 09:45:16', NULL, 'No', 'No', 'No'),
(46, 'TEC0406', 'Vacation Leave', '2025-05-01', '2025-04-25', 'Within the Philippines', 'Requested', 'Pending', '', '', '', '', '2025-04-03 09:45:26', NULL, 'No', 'No', 'No'),
(47, 'TEC0406', 'Vacation Leave', '2025-04-10', '2025-04-15', 'Within the Philippines', 'Requested', 'Pending', '', '', '', '', '2025-04-03 09:45:38', NULL, 'No', 'No', 'No'),
(48, 'TEC0406', 'Vacation Leave', '2025-03-31', '2025-04-21', 'Within the Philippines', 'Requested', 'Pending', '', '', '', '', '2025-04-03 09:45:47', NULL, 'No', 'No', 'No'),
(49, 'TEC0406', 'Vacation Leave', '2025-04-15', '2025-04-23', 'Within the Philippines', 'Requested', 'Pending', '', '', '', '', '2025-04-03 09:46:05', NULL, 'No', 'No', 'No'),
(50, 'TEC0406', 'Vacation Leave', '2025-04-04', '2025-04-25', 'Within the Philippines', 'Requested', 'Pending', '', '', '', '', '2025-04-03 09:58:40', NULL, 'No', 'No', 'No'),
(51, 'TEC0406', 'Vacation Leave', '2025-04-02', '2025-04-24', 'Within the Philippines', 'Requested', 'Pending', '', '', '', '', '2025-04-03 10:00:02', NULL, 'No', 'No', 'No'),
(52, 'TEC0406', 'Vacation Leave', '2025-04-11', '2025-04-14', 'Within the Philippines', 'Requested', 'Pending', '', '', '', '', '2025-04-03 10:05:48', NULL, 'No', 'No', 'No'),
(53, 'TEC0406', 'Vacation Leave', '2025-04-02', '2025-04-24', 'Within the Philippines', 'Requested', 'Pending', '', '', '', '', '2025-04-03 10:06:04', NULL, 'No', 'No', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `pending_teachers`
--

CREATE TABLE `pending_teachers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Pending','Approved') DEFAULT 'Pending',
  `user_id` varchar(50) NOT NULL,
  `district_section` varchar(50) NOT NULL,
  `emailaddress` varchar(100) NOT NULL,
  `contactnumber` varchar(15) NOT NULL,
  `date_submitted` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_teachers`
--

INSERT INTO `pending_teachers` (`id`, `firstname`, `middlename`, `lastname`, `password`, `status`, `user_id`, `district_section`, `emailaddress`, `contactnumber`, `date_submitted`) VALUES
(80, 'Jackson', 'Patayon', 'Pasana', '$2y$10$FhZUU8rBPndAienbfvcsB.M.ernJcwlxvA5OpWoSgM2JuvYEP3drK', '', 'ST5678', 'II', 'jackson@gmail.com', '09123456789', '2024-12-12 09:00:38'),
(81, 'Samuel', 'Hernandez ', 'Dela Cruz', '$2y$10$6i/IcAtMR1avdndmwuhQiumJra1rErDPn50.5yq96yt/0fh4CLxr.', '', 'ST12345', 'I', 'sammdelacruz3025@gmail.com', '09169374170', '2024-12-12 09:43:04'),
(89, 'Samantha', 'S.', 'Santos', '$2y$10$4GRg1mGjpgqzQCj25Mn/e.R0205KpLtRa0wzDw1/XMz7EXdzyByTK', '', 'ST456', 'I', 'car@mail.com', '09171836034', '2025-03-17 07:43:10'),
(93, 'Miguela ', 'S.', 'iubfwfi', '$2y$10$R/8P4xNf.UDi5DGnTcw44ev4DfaDbx3/WNXU2PgOmIA4nyTt7yfl6', 'Pending', 'ST0033', 'III', 'dni@mail.com', '09171836034', '2025-03-28 11:26:02'),
(94, 'Carla', 'M.', 'Inocencio', '$2y$10$qr/WLCJPY3nEWDpndHfQ3u.1GAUpjQ/74nGw0VL38hk9M4gXu0hY.', 'Pending', 'CM0406', 'I', 'miguelacarla0@gmail.com', '09171836034', '2025-03-29 10:37:35'),
(96, 'Carla', 'G.', 'Inocencio', '$2y$10$y7ckRjrcyd68d1ZaGFwo6.iJzbgktm2GE5DDtEsY6EBCfeStAwD5a', 'Pending', 'TECM0406', 'I', 'miguelacarla0@gmail.com', '09171836034', '2025-04-03 09:26:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Teacher','Personnel','Personnel Head','ASDS','Admin') NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `district_section` varchar(50) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `emailaddress` varchar(100) NOT NULL,
  `contactnumber` varchar(15) NOT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `role`, `firstname`, `middlename`, `lastname`, `district_section`, `user_id`, `emailaddress`, `contactnumber`, `otp`, `otp_expiry`) VALUES
(55, '$2y$10$UtRe7OM/XHfcFzx4QXmnBeCzWU.IhqdMvk3ESbd3C0x76L7nBMb76', 'Admin', 'Jackson', 'Patayon', 'Pasana', 'II', 'AD0128', 'Jacksonpasana17@gmail.com', '09675994851', '139670', '2025-03-27 09:00:36'),
(56, '$2y$10$ksqKbwT/cDqF.msxNj/AJe6Kl59MBlk6oyp.GvEtWL51QvEgWZe92', 'Teacher', 'Jackson', 'Patayon', 'Pasana', 'I', 'TE0128', 'Jacksonpasana17@gmail.com', '09675994851', '139670', '2025-03-27 09:00:36'),
(57, '$2y$10$OkPLsz5kN./NJnRnLOUGeO7vlf6papAf0bEfwsMLIiPPJs7CQe08m', 'Personnel', 'Jackson', 'Patayon', 'Pasana', 'II', 'PE0128', 'Jacksonpasana17@gmail.com', '09675994851', '139670', '2025-03-27 09:00:36'),
(58, '$2y$10$H3rvTsLX01S9RFPizlNOZu4GxGNH4c7Ojo3k5KZli.7ublHH25o4C', 'Personnel Head', 'Jackson', 'Patayon', 'Pasana', 'I', 'PH0128', 'Jacksonpasana17@gmail.com', '09675994851', '139670', '2025-03-27 09:00:36'),
(59, '$2y$10$c5WEWwPu8k3Ox.pNTkH3fOm0YF1.N57FEGm.2RAsp/3BCUxKkga2m', 'ASDS', 'Jackson', 'Patayon', 'Pasana', 'I', 'AS0128', 'Jacksonpasana17@gmail.com', '09675994851', '139670', '2025-03-27 09:00:36'),
(91, '$2y$10$yxC1ErGYTiADTwrvzFgaqexQIba3shm5hmgnezBxsGIOJFRHwRsem', 'Teacher', 'Anna Marie', 'Evangelista', 'Garcia', 'I', 'ST0001', 'annamariegarcia@gmail.com', '09435578901', NULL, NULL),
(92, '$2y$10$RsO8e/kJ97pEUcVGE4CpGemHymD5ySRRsVVZ6D6ZiXurpcpGtmmt6', 'Personnel', 'Angelica', 'Cruz', 'Arnaiz', 'II', 'ST0002', 'angelicarnaiz@gmail.com', '09987765543', NULL, NULL),
(93, '$2y$10$B1mUNqVqeHATGwNytmPjc.5dI7JixJ21zNW5V1paRRa2wpO3aDJtO', 'Teacher', 'Marvin', 'Ferrer', 'Dela Cruz', 'III', 'ST0003', 'marvindelacruz@gmail.com', '09756678899', NULL, NULL),
(94, '$2y$10$lrj6/zHoumuwWp6SLhaes.h9aJFrzgO8zI5rdbDST/qxW9X3URlKu', 'Teacher', 'Gianne', 'Sta Anna', 'Mariano', 'IV', 'ST0004', 'giannemariano@gmail.com', '09564433221', NULL, NULL),
(95, '$2y$10$nzctrPQV1Ze0XdSRJibngekLySRdVc0fZpSiCu63VucHHABcFB5YC', 'Teacher', 'Richard', 'Fajardo', 'Ferreras', 'V', 'ST0005', 'richardferreras@gmail.com', '09985521133', NULL, NULL),
(96, '$2y$10$NDClixGojjiuOplrqix/4uvrTYdHlkj32VQwBe8yPRRpMLZqLy8Oq', 'Teacher', 'Mark Angelo', 'Dela Torres', 'Peres', 'VI', 'ST0006', 'markperes@gmail.com', '09764455090', NULL, NULL),
(97, '$2y$10$x8KCI7d3xDf/CygqqjPS.eTrs97J7BRrm8cGvupDiICld/r0SRUPe', 'Teacher', 'Dominic', 'Castillo', 'Ventura', 'I', 'TRY1234', 'domventura@gmail.com', '09851122457', NULL, NULL),
(98, '$2y$10$XI09aF2nPPk7LTI2ZXXinOddPvi/LYrAU.wqunE6p4E.PhbZnIBUu', 'Teacher', 'Carla Miguela', 'Gardila', 'Inocencio', 'I', 'ST1234', 'carla@gmail.com', '0998234543', NULL, NULL),
(100, '$2y$10$yqdcySKzbOYdq1d1C7SWL.H2/8YBe.URZOW7Ed1Wea60UZ/UnlK7O', 'Teacher', 'Me', 'M.', 'Myself', 'I', 'ST000', 'me@mail.com', '0999999999', NULL, NULL),
(101, '$2y$10$.RKd/L3MoeWYW3fabnF70OyGE9Bx8oMtqUCaaV.lqAkk6aZ9plaxS', 'Teacher', 'Carla Miguela', 'G.', 'Inocencio', 'I', 'ST0123', 'migu@mail.com', '09171836034', NULL, NULL),
(104, '$2y$10$BQNJVx.fYFURIlEn9HDQGejrwH7CvS5pB1hizBl42xYZVZbfTTkh2', 'Teacher', 'Carla', 'fgsfygia', 'afag', 'I', 'ST0022', 'afgbi@mail.com', '09171836034', NULL, NULL),
(105, '$2y$10$ger3/59/Lts64aXlqRr.8u0Xc90wiGSd5Pu3QuNoYGt9vEXfVag8i', 'Teacher', 'Carla', 'G.', 'Inocencio', 'I', 'TEC0406', 'mig@mail.com', '09171836034', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_teachers`
--
ALTER TABLE `pending_teachers`
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
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `pending_teachers`
--
ALTER TABLE `pending_teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
