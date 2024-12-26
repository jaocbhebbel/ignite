-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 10, 2024 at 04:41 AM
-- Server version: 10.11.8-MariaDB-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ignite`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `major` char(4) DEFAULT NULL,
  `course_number` int(11) DEFAULT NULL,
  `course_name` varchar(50) DEFAULT NULL,
  `crn` int(11) DEFAULT NULL,
  `teacher_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `major`, `course_number`, `course_name`, `crn`, `teacher_name`) VALUES
(1, 'csci', 2500, 'Computer Organization', 68641, 'Masoud Zarifneshat'),
(2, 'csci', 2500, 'Computer Organization', 68641, 'Masoud Zarifneshat'),
(3, 'csci', 2500, 'Computer Organization', 68641, 'Masoud Zarifneshat'),
(4, 'csci', 2500, 'Computer Organization', 68641, 'Masoud Zarifneshat');

-- --------------------------------------------------------

--
-- Table structure for table `dates`
--

CREATE TABLE `dates` (
  `id` int(11) NOT NULL,
  `semester` varchar(6) DEFAULT NULL,
  `school_year` int(11) DEFAULT NULL,
  `exam_number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dates`
--

INSERT INTO `dates` (`id`, `semester`, `school_year`, `exam_number`) VALUES
(1, 'fall', 2023, 3),
(2, 'fall', 2023, 3),
(3, 'fall', 2023, 3),
(4, 'spring', 2024, 3);

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `id_courses` int(11) DEFAULT NULL,
  `id_dates` int(11) DEFAULT NULL,
  `exam_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`id`, `id_courses`, `id_dates`, `exam_name`) VALUES
(1, 1, 1, 'csci-2500-fall-2023-3'),
(2, 2, 2, 'csci-2500-fall-2023-3 (2)'),
(3, 3, 3, 'csci-2500-fall-2023-3 (3)'),
(4, 4, 4, 'csci-2500-spring-2024-3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dates`
--
ALTER TABLE `dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_courses` (`id_courses`),
  ADD KEY `id_dates` (`id_dates`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dates`
--
ALTER TABLE `dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`id_courses`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `exams_ibfk_2` FOREIGN KEY (`id_dates`) REFERENCES `dates` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
