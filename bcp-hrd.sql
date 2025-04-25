-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 03:06 AM
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
-- Database: `bcp-hrd`
--

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `approved` tinyint(1) DEFAULT 0,
  `issued_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL,
  `training_course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contract_date` date NOT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course_enrollments`
--

CREATE TABLE `course_enrollments` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_enrollments`
--

INSERT INTO `course_enrollments` (`id`, `course_id`, `employee_id`, `enrolled_at`) VALUES
(33, 14, 3, '2025-04-24 06:01:18'),
(34, 14, 4, '2025-04-24 06:01:20'),
(35, 14, 5, '2025-04-24 06:01:21'),
(36, 14, 14, '2025-04-24 06:01:22'),
(37, 14, 16, '2025-04-24 06:01:24'),
(38, 10, 3, '2025-04-24 06:01:27'),
(39, 10, 4, '2025-04-24 06:01:29'),
(40, 10, 5, '2025-04-24 06:01:30'),
(41, 10, 14, '2025-04-24 06:01:32'),
(42, 10, 16, '2025-04-24 06:01:33'),
(43, 11, 3, '2025-04-24 06:01:37'),
(44, 11, 4, '2025-04-24 06:01:39'),
(45, 11, 5, '2025-04-24 06:01:41'),
(46, 11, 14, '2025-04-24 06:01:42'),
(47, 11, 16, '2025-04-24 06:01:44'),
(48, 16, 3, '2025-04-24 06:01:48'),
(49, 16, 4, '2025-04-24 06:01:49'),
(50, 16, 5, '2025-04-24 06:01:50'),
(51, 16, 14, '2025-04-24 06:01:52'),
(52, 16, 16, '2025-04-24 06:01:53'),
(53, 13, 3, '2025-04-24 06:01:58'),
(54, 13, 4, '2025-04-24 06:02:00'),
(55, 13, 5, '2025-04-24 06:02:02'),
(56, 13, 14, '2025-04-24 06:02:03'),
(57, 13, 16, '2025-04-24 06:02:04'),
(58, 15, 3, '2025-04-24 06:21:22'),
(60, 15, 5, '2025-04-24 06:21:28'),
(61, 15, 8, '2025-04-24 06:21:30'),
(62, 15, 9, '2025-04-24 06:21:32'),
(64, 15, 14, '2025-04-24 06:21:35'),
(65, 15, 16, '2025-04-24 06:21:36');

-- --------------------------------------------------------

--
-- Table structure for table `employee_certifications`
--

CREATE TABLE `employee_certifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `certification_date` date DEFAULT NULL,
  `approval_status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_certifications`
--

INSERT INTO `employee_certifications` (`id`, `user_id`, `course_id`, `certification_date`, `approval_status`) VALUES
(1, 3, 10, '2025-04-24', 'Approved'),
(2, 3, 10, '2025-04-25', 'Approved'),
(3, 3, 15, '2025-04-25', 'Approved'),
(4, 14, 11, '2025-04-25', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `due_date` date DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `course_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `assigned_to`, `status`, `due_date`, `remarks`, `created_at`, `course_id`) VALUES
(4, 'leadership training', 'u need to undergo this training for the development of your skills', 14, 'Pending', '2025-04-20', NULL, '2025-04-19 03:46:48', NULL),
(5, 'leadership training', 'sadasdas', 3, 'Completed', '2025-04-19', NULL, '2025-04-19 04:55:29', NULL),
(6, 'oritentation training', '------\r\n', 3, 'Completed', '2025-04-21', NULL, '2025-04-21 02:01:47', NULL),
(7, 'Soft skill training', 'asdasd', 3, 'In Progress', '2025-04-30', NULL, '2025-04-24 12:09:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `training_courses`
--

CREATE TABLE `training_courses` (
  `id` int(11) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `schedule_time` time DEFAULT NULL,
  `instructor` varchar(100) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_courses`
--

INSERT INTO `training_courses` (`id`, `course_title`, `description`, `start_date`, `end_date`, `schedule_time`, `instructor`, `designation`, `location`) VALUES
(10, 'Hard skill training', 'Hard skills training focuses on developing technical abilities and knowledge necessary for specific jobs or tasks. This training can be gained through education, training programs, or on-the-job experience.', '2025-04-30', '2025-05-10', '08:00:00', 'sir david jaurigue', 'employee/teaching', 'Quezon City'),
(11, 'Leadership Training', 'focuses on developing the skills and knowledge necessary for effective leadership, encompassing areas like communication, decision-making, motivation, and conflict resolution.', '2025-05-01', '2025-05-07', '10:00:00', 'sir Philip Arevalo', 'Teaching', 'San jose del monte'),
(13, 'Team Building', 'Team building refers to the process of enhancing collaboration, communication, and overall cohesiveness within a group or team, often through activities and events designed to foster these skills. ', '2025-05-10', '2025-05-25', '06:00:00', '', 'officer, staff, employee, teaching & nonteaching', 'Subic'),
(14, 'Orientation Training ', 'Orientation training is a program designed to introduce new employees to their work environment, company culture, and job responsibilities. It aims to help new hires quickly integrate and feel comfortable in their roles by providing essential information and support. ', '2025-04-28', '2025-07-28', '20:00:00', 'Sir Rusty Talento', 'employee', 'Quezon City'),
(15, 'Technical Training', 'Technical training equips individuals with the skills and knowledge needed to perform specific tasks or operate specialized tools and software. It\'s a structured process that focuses on practical, hands-on competencies, helping employees excel in their roles and adapt to technological advancements. ', '2025-04-24', '2025-04-25', '13:10:00', 'Sir John Nove Hadcan', 'employee', 'Caloocan '),
(16, 'Soft skill training', 'Soft skills training focuses on developing interpersonal and social skills like communication, teamwork, and problem-solving, which are crucial for effective workplace interactions and overall success. It complements technical skills (hard skills) by enhancing how individuals interact with others and navigate social situations. ', '2025-05-08', '2025-06-24', '12:00:00', 'Sir Jeremiah Durano', 'non-teaching', 'Norzagaray');

-- --------------------------------------------------------

--
-- Table structure for table `training_evaluations`
--

CREATE TABLE `training_evaluations` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `feedback` text DEFAULT NULL,
  `evaluation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_evaluations`
--

INSERT INTO `training_evaluations` (`id`, `course_id`, `question_id`, `rating`, `feedback`, `evaluation_date`) VALUES
(45, 15, 1, 5, 'testing lang', '2025-04-24 06:03:23'),
(46, 15, 2, 5, NULL, '2025-04-24 06:03:23'),
(47, 15, 3, 5, NULL, '2025-04-24 06:03:23'),
(48, 15, 4, 5, NULL, '2025-04-24 06:03:23'),
(49, 15, 5, 5, NULL, '2025-04-24 06:03:23'),
(50, 15, 6, 5, NULL, '2025-04-24 06:03:23'),
(51, 15, 7, 5, NULL, '2025-04-24 06:03:23'),
(52, 15, 8, 5, NULL, '2025-04-24 06:03:23'),
(53, 15, 9, 5, NULL, '2025-04-24 06:03:23'),
(54, 15, 10, 5, NULL, '2025-04-24 06:03:23');

-- --------------------------------------------------------

--
-- Table structure for table `training_feedbacks`
--

CREATE TABLE `training_feedbacks` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `feedback` text NOT NULL,
  `evaluation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `training_questions`
--

CREATE TABLE `training_questions` (
  `id` int(11) NOT NULL,
  `question_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_questions`
--

INSERT INTO `training_questions` (`id`, `question_text`) VALUES
(1, 'The objectives of the training were clearly communicated to me before the session.'),
(2, 'I felt adequately prepared and equipped to conduct this training.'),
(3, 'The training materials and resources provided were appropriate and sufficient.'),
(4, 'The training venue and environment were suitable for effective delivery.'),
(5, 'Participants were actively engaged and participated throughout the training.'),
(6, 'The allocated time was sufficient to cover all training topics.'),
(7, 'I was able to effectively manage questions and discussions from participants.'),
(8, 'The training successfully achieved its intended learning objectives.'),
(9, 'I am satisfied with the overall outcome of the training session.'),
(10, 'I would be willing to conduct this training or a similar one again in the future.');

-- --------------------------------------------------------

--
-- Table structure for table `training_schedules`
--

CREATE TABLE `training_schedules` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` enum('superadmin','admin','staff','employee','teaching','non-teaching','officer') NOT NULL DEFAULT 'employee',
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastLogin` datetime DEFAULT current_timestamp(),
  `designation` varchar(100) DEFAULT NULL,
  `certificates_earned` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `usertype`, `email`, `first_name`, `last_name`, `phone`, `address`, `createdAt`, `lastLogin`, `designation`, `certificates_earned`) VALUES
(1, 's_admin', 'sadmin123', 'superadmin', 'sadmin123', 'Super', 'Admin', '9277022002', 'Norzagaray, Bulacan', '2025-04-08 04:28:19', '2025-04-08 12:28:19', NULL, 0),
(2, 'admin', 'admin123', 'admin', 'admin123', 'Admin', '', '9762241995', 'QC', '2025-04-08 04:30:24', '2025-04-08 12:30:29', NULL, 0),
(3, 'employee', 'employee123', 'employee', 'employee123', 'Employee', 'surname', '9162421902', 'CSJDM', '2025-04-08 04:31:13', '2025-04-08 12:31:15', NULL, 0),
(4, 'staff', 'staff123', 'staff', 'staff123', 'Staff', '', '9212095224', 'CSJDM', '2025-04-08 04:32:11', '2025-04-08 12:31:35', NULL, 0),
(5, 'jdoe', 'jdoe123', 'employee', 'jdoe123', 'John', 'Doe', '9457775619', 'Caloocan', '2025-04-08 08:30:18', '2025-04-08 16:30:21', NULL, 0),
(8, 'teaching 1', 'teaching123', 'teaching', 'teaching@gmail.com', 'teaching', 'department', '123123123123', 'qc', '2025-04-17 03:03:11', '2025-04-17 11:03:11', NULL, 0),
(9, 'nonteaching', 'nonteaching', 'non-teaching', 'nonteaching@gmail.com', 'nonteaching', 'department', '123123123123', 'bulacan', '2025-04-17 03:05:02', '2025-04-17 11:05:02', NULL, 0),
(14, 'novehadcan', 'johnnove25', 'employee', 'novehadcan@gmail.com', 'nove', 'hadcan', '123123123123', 'norzagaray', '2025-04-17 06:48:04', '2025-04-17 14:48:04', NULL, 0),
(16, 'rusty', 'rusty123', 'employee', 'rusty@gmail.com', 'rusty', 'talento', '12345678910', 'towerville', '2025-04-18 13:26:36', '2025-04-18 21:26:36', NULL, 0),
(18, 'officer', 'officer123', 'officer', 'officer@gmail.com', 'officer', 'one', '213123123123', 'norzagaray', '2025-04-24 07:12:59', '2025-04-24 15:12:59', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `training_course_id` (`training_course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `course_enrollments`
--
ALTER TABLE `course_enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `employee_certifications`
--
ALTER TABLE `employee_certifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_courses`
--
ALTER TABLE `training_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_evaluations`
--
ALTER TABLE `training_evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `training_feedbacks`
--
ALTER TABLE `training_feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_questions`
--
ALTER TABLE `training_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_schedules`
--
ALTER TABLE `training_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_unique` (`username`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_enrollments`
--
ALTER TABLE `course_enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `employee_certifications`
--
ALTER TABLE `employee_certifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `training_courses`
--
ALTER TABLE `training_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `training_evaluations`
--
ALTER TABLE `training_evaluations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `training_feedbacks`
--
ALTER TABLE `training_feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_questions`
--
ALTER TABLE `training_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `training_schedules`
--
ALTER TABLE `training_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `certificates_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `training_courses` (`id`);

--
-- Constraints for table `contracts`
--
ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_ibfk_1` FOREIGN KEY (`training_course_id`) REFERENCES `training_courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `contracts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_enrollments`
--
ALTER TABLE `course_enrollments`
  ADD CONSTRAINT `course_enrollments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `training_courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_enrollments_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employee_certifications`
--
ALTER TABLE `employee_certifications`
  ADD CONSTRAINT `employee_certifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `employee_certifications_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `training_courses` (`id`);

--
-- Constraints for table `training_evaluations`
--
ALTER TABLE `training_evaluations`
  ADD CONSTRAINT `training_evaluations_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `training_courses` (`id`),
  ADD CONSTRAINT `training_evaluations_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `training_questions` (`id`);

--
-- Constraints for table `training_schedules`
--
ALTER TABLE `training_schedules`
  ADD CONSTRAINT `training_schedules_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `training_courses` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
