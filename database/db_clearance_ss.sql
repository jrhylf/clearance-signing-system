-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2024 at 04:36 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_clearance_ss`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `displayclearance`
-- (See below for the actual view)
--
CREATE TABLE `displayclearance` (
);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activity`
--

CREATE TABLE `tbl_activity` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `user` varchar(255) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `activity` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_activity`
--

INSERT INTO `tbl_activity` (`id`, `date`, `time`, `user`, `department_name`, `activity`) VALUES
(1, '2024-01-12', '16:33:45', 'John Rhyl Fernandez', 'Registrar', 'Added a new Announcement Defense Schedule.'),
(2, '2024-01-12', '16:35:21', 'John Rhyl Fernandez', 'Registrar', 'Added a new school year and semester (2023-2024, Semester 1).');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_administrator`
--

CREATE TABLE `tbl_administrator` (
  `id` int(11) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_pass` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `admin_firstname` varchar(255) NOT NULL,
  `admin_lastname` varchar(255) NOT NULL,
  `contact` bigint(20) NOT NULL,
  `email` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_administrator`
--

INSERT INTO `tbl_administrator` (`id`, `admin_username`, `admin_pass`, `position`, `admin_firstname`, `admin_lastname`, `contact`, `email`) VALUES
(1, 'systemAdmin', '$2y$10$Lkim9Pv85mqnI8MRGgy9ZuXk2GGj7rj7W2mQu3qnb3xb/L9J9Reaa', 'Main', 'Administrator', 'Administrator', 0, 'main.admin@alabang.sti.edu.ph');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_announcements`
--

CREATE TABLE `tbl_announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `announce_for` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_date` date NOT NULL,
  `end_time` time NOT NULL,
  `image` varchar(999) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_announcements`
--

INSERT INTO `tbl_announcements` (`id`, `title`, `description`, `announce_for`, `start_date`, `start_time`, `end_date`, `end_time`, `image`) VALUES
(1, 'Defense Schedule', 'January 13, 2024', 'Everyone', '2024-01-07', '08:00:00', '2024-01-13', '16:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_archived`
--

CREATE TABLE `tbl_archived` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `section` int(11) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `school_year` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cleared`
--

CREATE TABLE `tbl_cleared` (
  `id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `section` int(11) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `school_year` varchar(255) NOT NULL,
  `semester` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cleared`
--

INSERT INTO `tbl_cleared` (`id`, `status`, `student_id`, `last_name`, `first_name`, `course_code`, `section`, `remarks`, `department`, `type`, `email`, `password`, `school_year`, `semester`) VALUES
(1, 'OK', 2000121448, 'Fernandez', 'John Rhyl', 'BSIT', 711, 'Cleared', 'Registrar', 'Active', 'fernandez.121448@alabang.sti.edu.ph', '$2y$10$cjWRcmTvKt.IKkFt4nbtiOXhy0SdWguymzGkTlXjpR5d/Hh8d5LvG', '2023-2024', '1'),
(2, 'OK', 2000220660, 'Robles', 'Sean Lennard', 'BSIT', 711, 'Cleared', 'Registrar', 'Active', 'robles.220660@alabang.sti.edu.ph', 'sean', '2023-2024', '1'),
(3, 'On-Hold', 2000121459, 'Rajas', 'Kelsey Lois', 'BSIT', 711, 'Form137, 2x2', 'Registrar', 'Active', 'rajas.121459@alabang.sti.edu.ph', 'lois', '2023-2024', '1'),
(4, 'OK', 2000122490, 'Cariaso', 'John Kirby', 'BSIT', 711, 'Cleared', 'Registrar', 'Active', 'cariaso.122490@alabang.sti.edu', '$2y$10$mxMdDGjLyChVebk4VnwPreszP1ldqoFl7jsNxgzXDcU8zyJnjgk.S', '2023-2024', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_courses`
--

CREATE TABLE `tbl_courses` (
  `id` int(11) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `course_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_courses`
--

INSERT INTO `tbl_courses` (`id`, `course_code`, `course_description`) VALUES
(3, 'BSIT', 'Bachelor of Science in Information Technology'),
(4, 'BSHM', 'Bachelor of Science in Hospitality Management'),
(5, 'BSBA', 'Bachelor of Science in Business Administration'),
(7, 'BSTM', 'Bachelor of Science in Tourism');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_departments`
--

CREATE TABLE `tbl_departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `user` varchar(9999) NOT NULL,
  `applicable_course` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_departments`
--

INSERT INTO `tbl_departments` (`id`, `department_name`, `user`, `applicable_course`) VALUES
(1, 'Registrar', 'Fernandez, John Rhyl', 'All Courses'),
(3, 'Proware', 'Rajas, Kelsey Lois', 'All Courses'),
(8, 'Academics', 'Laraga, Jerryfel', 'All Courses'),
(9, 'Accounting', 'Robles, Sean Lennard', 'All Courses');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_section`
--

CREATE TABLE `tbl_section` (
  `id` int(11) NOT NULL,
  `course_code` varchar(255) NOT NULL,
  `section_number` int(11) NOT NULL,
  `section` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_section`
--

INSERT INTO `tbl_section` (`id`, `course_code`, `section_number`, `section`) VALUES
(6, 'BSIT', 711, 'BSIT711'),
(7, 'BSIT', 611, 'BSIT611'),
(8, 'BSHM', 711, 'BSHM211'),
(9, 'BSIT', 111, 'BSIT111'),
(10, 'BSTM', 111, 'BSTM111'),
(11, 'BSIT', 811, 'BSIT811'),
(12, 'BSIT', 211, 'BSIT211'),
(15, 'BSIT', 311, 'BSIT311'),
(16, 'BSIT', 411, 'BSIT411'),
(17, 'BSIT', 511, 'BSIT511'),
(18, 'BSHM', 111, 'BSHM111'),
(19, 'BSHM', 311, 'BSHM311'),
(20, 'BSHM', 411, 'BSHM411'),
(21, 'BSHM', 511, 'BSHM511'),
(22, 'BSHM', 611, 'BSHM611'),
(23, 'BSHM', 711, 'BSHM711'),
(24, 'BSHM', 811, 'BSHM811'),
(25, 'BSBA', 111, 'BSBA111'),
(26, 'BSBA', 211, 'BSBA211'),
(27, 'BSBA', 311, 'BSBA311'),
(28, 'BSBA', 411, 'BSBA411'),
(29, 'BSBA', 511, 'BSBA511'),
(30, 'BSBA', 611, 'BSBA611'),
(31, 'BSBA', 711, 'BSBA711'),
(32, 'BSBA', 811, 'BSBA811'),
(33, 'BSTM', 811, 'BSTM811'),
(34, 'BSTM', 211, 'BSTM211'),
(35, 'BSTM', 311, 'BSTM311'),
(36, 'BSTM', 411, 'BSTM411'),
(37, 'BSTM', 511, 'BSTM511'),
(38, 'BSTM', 611, 'BSTM611'),
(39, 'BSTM', 711, 'BSTM711');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sy_sem`
--

CREATE TABLE `tbl_sy_sem` (
  `id` int(11) NOT NULL,
  `sy_start` varchar(11) NOT NULL,
  `sy_end` varchar(11) NOT NULL,
  `semester` varchar(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sy_sem`
--

INSERT INTO `tbl_sy_sem` (`id`, `sy_start`, `sy_end`, `semester`, `status`) VALUES
(1, '2023', '2024', '1', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `department_assigned` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `last_name`, `first_name`, `middle_name`, `gender`, `department_assigned`, `position`, `user_username`, `user_password`, `email`, `contact`) VALUES
(75, 'Fernandez', 'John Rhyl', 'Raton', 'Prefer not to say', 'Registrar', 'Head', 'jr', '$2y$10$VVTf0Ly5k.cu0ZLgXUYMdumGl51UXCnPvUSjTNIw97cSWF0AVelU.', 'fernandez.121448@alabang.sti.edu.ph', 9297798116),
(77, 'Rajas', 'Kelsey Lois', 'N/A', 'Prefer not to say', 'Proware', 'Head', 'lois', '$2y$10$Fyljlc2zoJYMDqCa2T13RuSHil9Nq/qT4F1RlCaN96AZ6RIivSQme', 'rajas.121459@alabang.sti.edu.ph', 0),
(80, 'Laraga', 'Jerryfel', 'N/A', 'Prefer not to say', 'Academics', 'Head', 'fel', '$2y$10$S9onmbZc39Wk3hRPShlYEOkNoQ9Vk8K0n8r6slvKZ/CdP19wH6BtW', 'jerryfel.laraga@alabang.sti.edu.ph', 0),
(82, 'Robles', 'Sean Lennard', 'Soriano', 'Prefer not to say', 'Accounting', 'Head', 'sean', '$2y$10$nl5oH7Xhj5CgnOzRYy8quuqxT3SyPiNLZA/hdWYOZkSx5WxPo4t9y', 'robles.220660@alabang.sti.edu.ph', 123);

-- --------------------------------------------------------

--
-- Structure for view `displayclearance`
--
DROP TABLE IF EXISTS `displayclearance`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `displayclearance`  AS SELECT `tbl_students`.`student_id` AS `student_id`, `tbl_students`.`first_name` AS `first_name`, `tbl_students`.`middle_name` AS `middle_name`, `tbl_students`.`last_name` AS `last_name`, `tbl_cleared`.`course_code` AS `course_code`, `tbl_cleared`.`section` AS `section`, `tbl_cleared`.`remarks` AS `remarks`, `tbl_cleared`.`department` AS `department` FROM (`tbl_students` join `tbl_cleared` on(`tbl_students`.`student_id` = `tbl_cleared`.`student_id`))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_activity`
--
ALTER TABLE `tbl_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_administrator`
--
ALTER TABLE `tbl_administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_announcements`
--
ALTER TABLE `tbl_announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_archived`
--
ALTER TABLE `tbl_archived`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cleared`
--
ALTER TABLE `tbl_cleared`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_departments`
--
ALTER TABLE `tbl_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_section`
--
ALTER TABLE `tbl_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sy_sem`
--
ALTER TABLE `tbl_sy_sem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_activity`
--
ALTER TABLE `tbl_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_administrator`
--
ALTER TABLE `tbl_administrator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_announcements`
--
ALTER TABLE `tbl_announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_archived`
--
ALTER TABLE `tbl_archived`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_cleared`
--
ALTER TABLE `tbl_cleared`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_departments`
--
ALTER TABLE `tbl_departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_section`
--
ALTER TABLE `tbl_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_sy_sem`
--
ALTER TABLE `tbl_sy_sem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
