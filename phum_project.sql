-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2024 at 05:51 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phum_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `id_student` int(20) NOT NULL,
  `id_professor` int(20) NOT NULL,
  `details_student` text DEFAULT NULL,
  `details_professor` text DEFAULT NULL,
  `date_time` datetime NOT NULL,
  `level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`id`, `name`, `id_student`, `id_professor`, `details_student`, `details_professor`, `date_time`, `level`) VALUES
(4, 'วิทยาการคอมพิวเตอร์', 1, 2, '', '', '2023-04-14 04:48:00', 1),
(5, 'วิทยาการคอมพิวเตอร์', 1, 1, '..', '', '2023-04-21 08:26:00', 2),
(7, 'test', 3, 1, '', '.......', '2023-04-20 13:26:00', 2),
(8, 'วิทยาการคอมพิวเตอร์', 1, 1, '', '', '2023-04-21 03:56:00', 2),
(9, 'ทดสอบ', 2, 2, '', '', '2023-09-21 04:02:00', 1),
(10, 'ทดสอบ', 2, 3, '..', '', '2023-09-23 09:04:00', 1),
(11, '1', 2, 1, '', '', '2023-09-09 03:04:00', 2),
(12, '65+', 2, 1, '456', '', '2024-02-14 11:44:00', 1),
(13, 'คอมพิวเตอร์และเทคโนโลยีสารสนเทศเพื่อชีวิต 1', 2, 1, '', '456456', '2024-02-16 14:45:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `id_professor` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `id_professor`, `year`) VALUES
(2, 'คอมพิวเตอร์และเทคโนโลยีสารสนเทศเพื่อชีวิต ', 2, NULL),
(3, 'ตรรกะดิจิทัล', 2, NULL),
(4, 'หลักด้านวิทยาการคอมพิวเตอร์', 1, NULL),
(5, 'การเขียนโปรแกรมคอมพิวเตอร์ 1', 1, NULL),
(6, 'PHP', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grad`
--

CREATE TABLE `grad` (
  `id` int(11) NOT NULL,
  `id_student` int(20) NOT NULL,
  `id_professor` int(20) DEFAULT 0,
  `id_course` int(11) NOT NULL,
  `grad` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grad`
--

INSERT INTO `grad` (`id`, `id_student`, `id_professor`, `id_course`, `grad`) VALUES
(25, 1, 1, 5, 'F'),
(26, 1, 1, 4, 'F'),
(27, 1, 2, 3, 'I'),
(28, 1, 2, 6, 'I'),
(29, 1, 2, 6, 'F');

-- --------------------------------------------------------

--
-- Table structure for table `user_admin`
--

CREATE TABLE `user_admin` (
  `id` int(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(1) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_admin`
--

INSERT INTO `user_admin` (`id`, `email`, `password`, `level`) VALUES
(1, 'head@gmail.com', '25d55ad283aa400af464c76d713c07ad', 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_professor`
--

CREATE TABLE `user_professor` (
  `id` int(20) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(1) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_professor`
--

INSERT INTO `user_professor` (`id`, `f_name`, `l_name`, `email`, `password`, `level`) VALUES
(1, 'สกรณ์', 'บุษบง', 'ZagonBussabong@bru.ac.th', '25d55ad283aa400af464c76d713c07ad', 2),
(2, 'ชลัท', 'รังสิมา', 'chalath.rw@bru.ac.th', '25d55ad283aa400af464c76d713c07ad', 2),
(3, 'วิชชา', 'ภัทรนิธิคุณากร', 'WICHAPATNITHIKUNAKON@bru.ac.th', '25d55ad283aa400af464c76d713c07ad', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_student`
--

CREATE TABLE `user_student` (
  `id` int(20) NOT NULL,
  `ID_student` varchar(12) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `gender` int(1) NOT NULL,
  `year` int(1) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `grade_1_1` float DEFAULT NULL,
  `grade_1_2` float DEFAULT NULL,
  `grade_2_1` float DEFAULT NULL,
  `grade_2_2` float DEFAULT NULL,
  `grade_3_1` float DEFAULT NULL,
  `grade_3_2` float DEFAULT NULL,
  `grade_4_1` float DEFAULT NULL,
  `grade_4_2` float DEFAULT NULL,
  `level` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_student`
--

INSERT INTO `user_student` (`id`, `ID_student`, `f_name`, `l_name`, `gender`, `year`, `email`, `password`, `grade_1_1`, `grade_1_2`, `grade_2_1`, `grade_2_2`, `grade_3_1`, `grade_3_2`, `grade_4_1`, `grade_4_2`, `level`) VALUES
(1, '630112230018', 'ภาคิน', 'ตาชูชาติ', 1, 5, '630112230018@bru.ac.th', '25d55ad283aa400af464c76d713c07ad', 3, 3.08, 3.35, 3.08, 3, 2.84, 0, 0, 1),
(2, '630112230040', 'สุปวีร์', 'สระบัว', 1, 3, '630112230040@bru.ac.th', '25d55ad283aa400af464c76d713c07ad', 1.75, 2.33, 2.42, 1.83, 2.16, 2.21, 0, 0, 1),
(3, '630112230002', 'กิตติเทพ', 'ที่รัก', 1, 3, '630112230002@bru.ac.th', '25d55ad283aa400af464c76d713c07ad', 2.66, 3.16, 2.85, 2.83, 2.83, 2.73, 0, 0, 1),
(4, '630112230006', 'ชัยมงคล', 'โสภาสุข', 1, 3, '630112230006@bru.ac.th', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(5, '630112230008', 'ธนกร', 'ประสานรัมย์', 1, 3, '630112230008@bru.ac.th', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(6, '630112230009', 'ธนิสร', 'สีเสน', 1, 3, '630112230009@bru.ac.th', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(7, '630112230010', 'ธเรษ์', 'กีรติธร', 1, 3, '630112230010@bru.ac.th', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(8, '630112230012', 'ธีระรัชต์', 'เตชะเวทย์วิเศษ', 1, 3, '630112230012@bru.ac.th', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(9, '630112230013', 'ธีรังกูร', 'เชื้อแก้ว', 1, 3, '630112230013@bru.ac.th', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(10, '630112230014', 'ธีรัตม์', 'โชคทวีเศษฐ์', 1, 3, '630112230014@bru.ac.th', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(11, '630112230015', 'บัณทิต', 'จำเริญดี', 1, 3, '630112230015@bru.ac.th', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_ibfk_1` (`id_professor`),
  ADD KEY `appointment_ibfk_2` (`id_student`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_professor` (`id_professor`);

--
-- Indexes for table `grad`
--
ALTER TABLE `grad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_student` (`id_student`),
  ADD KEY `grad_ibfk_2` (`id_professor`);

--
-- Indexes for table `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_professor`
--
ALTER TABLE `user_professor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_student`
--
ALTER TABLE `user_student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `grad`
--
ALTER TABLE `grad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_professor`
--
ALTER TABLE `user_professor`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_student`
--
ALTER TABLE `user_student`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`id_professor`) REFERENCES `user_professor` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`id_student`) REFERENCES `user_student` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`id_professor`) REFERENCES `user_professor` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `grad`
--
ALTER TABLE `grad`
  ADD CONSTRAINT `grad_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `user_student` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grad_ibfk_2` FOREIGN KEY (`id_professor`) REFERENCES `user_professor` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
