-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 12, 2025 at 02:20 AM
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
-- Table structure for table `analyticsreports`
--

DROP TABLE IF EXISTS `analyticsreports`;
CREATE TABLE `analyticsreports` (
  `ReportID` int(11) NOT NULL,
  `ReportName` varchar(100) NOT NULL,
  `GeneratedDate` date DEFAULT NULL,
  `ReportType` enum('Turnover','Compensation','Performance','Training') DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `FilePath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

DROP TABLE IF EXISTS `applicants`;
CREATE TABLE `applicants` (
  `id` int(11) NOT NULL,
  `job_id` int(11) DEFAULT NULL,
  `applicant_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Shortlisted','Interviewed','Hired','Rejected','Selected for Interview') DEFAULT 'Pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `interview_date` date DEFAULT NULL,
  `interview_time` time DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`id`, `job_id`, `applicant_name`, `email`, `resume_path`, `status`, `applied_at`, `interview_date`, `interview_time`, `DepartmentID`) VALUES
(43, 59, 'SAWADA', 'apundarjeremy@gmail.com', 'uploads/resume/jere.txt', 'Hired', '2024-11-13 10:51:07', NULL, NULL, 9),
(44, 57, 'QWERTY', 'apundarjeremy@gmail.com', 'uploads/resume/jere.txt', 'Hired', '2024-11-13 10:51:31', '2024-11-13', '22:15:00', 8),
(49, 60, 'Kevin Durant', 'apundarjeremy@gmail.com', 'uploads/resume/jere.txt', 'Hired', '2024-11-13 13:58:16', NULL, NULL, 9),
(50, 58, 'LeBron James', 'apundarjeremy@gmail.com', 'uploads/resume/jere.txt', 'Hired', '2024-11-13 13:58:39', '2025-03-30', '17:39:00', 8),
(51, 57, 'Steph Curry', 'apundarjeremy@gmail.com', 'uploads/resume/jere.txt', 'Hired', '2024-11-13 13:59:12', '2025-03-30', '15:11:00', 8),
(52, 62, 'John Doe', 'johndoe@example.com', 'uploads/resume/johndoe.txt', 'Rejected', '2025-01-26 03:14:16', NULL, NULL, 9),
(53, 63, 'Jane Smith', 'janesmith@example.com', 'uploads/resume/janesmith.txt', 'Rejected', '2025-01-26 03:14:16', NULL, NULL, 8),
(54, 64, 'Alice Johnson', 'alicejohnson@example.com', 'uploads/resume/alicejohnson.txt', 'Hired', '2025-01-26 03:14:16', '2025-03-30', '16:19:00', 9),
(55, 65, 'Bob Brown', 'bobbrown@example.com', 'uploads/resume/bobbrown.txt', 'Rejected', '2025-01-26 03:14:16', '2025-03-30', '16:29:00', 10),
(56, 66, 'Charlie Davis', 'charliedavis@example.com', 'uploads/resume/charliedavis.txt', 'Hired', '2025-01-26 03:14:16', '2025-04-01', '22:42:00', 9),
(57, 67, 'Diana Evans', 'dianaevans@example.com', 'uploads/resume/dianaevans.txt', 'Hired', '2025-01-26 03:14:16', '2025-04-01', '22:43:00', 11),
(58, 68, 'Ethan Foster', 'ethanfoster@example.com', 'uploads/resume/ethanfoster.txt', 'Pending', '2025-01-26 03:14:16', NULL, NULL, 12),
(59, 69, 'Fiona Green', 'fionagreen@example.com', 'uploads/resume/fionagreen.txt', 'Hired', '2025-01-26 03:14:16', '2025-03-30', '16:45:00', 10),
(60, 70, 'George Harris', 'georgeharris@example.com', 'uploads/resume/georgeharris.txt', 'Pending', '2025-01-26 03:14:16', NULL, NULL, 9),
(61, 71, 'Hannah Ivers', 'hannahivers@example.com', 'uploads/resume/hannahivers.txt', 'Pending', '2025-01-26 03:14:16', NULL, NULL, 8),
(62, 58, 'test', 'test@gmail.com', 'uploads/resume/dexter-schoolresume.docx', 'Hired', '2025-03-26 12:28:46', '2025-04-01', '22:45:00', 8),
(63, 58, 'qwe', 'qwe@masd.com', 'uploads/resume/internship-memorandum-of-agreement-between-student-and-company.docx', 'Hired', '2025-03-26 12:47:03', '2025-03-30', '19:38:00', 8),
(67, 67, 'JEREMY', 'apundarjeremy@gmail.com', 'uploads/resume/RESUME-FOR-OJT-JA.docx', 'Hired', '2025-03-30 11:20:28', '2025-03-30', '19:28:00', 11),
(68, 65, 'Jeremy Apundar', 'apundarjeremy@gmail.com', 'uploads/resume/RESUME-FOR-OJT-JA.docx', 'Hired', '2025-03-30 15:26:23', '2025-03-30', '23:27:00', 10),
(69, 72, 'test applicant', 'apundarjeremy@gmail.com', 'uploads/resume/GMAIL-ACC.txt', 'Hired', '2025-04-01 03:35:48', '2025-04-01', '11:36:00', 15),
(70, 63, 'test3', 'test3@gmail.com', 'uploads/resume/ACCOUNT-1.txt', 'Hired', '2025-04-01 14:51:18', '2025-04-01', '23:14:00', 8),
(71, 62, 'applicant1', 'apundarjeremy@gmail.com', 'uploads/resume/Aljhon Resume.docx', 'Pending', '2025-04-05 08:33:23', NULL, NULL, 9),
(72, 66, 'Penpen ', 'apundarjeremy@gmail.com', 'uploads/resume/Aljhon Resume.docx', 'Hired', '2025-04-05 08:43:42', '2025-04-06', '13:00:00', 9),
(73, 73, 'PENPEN', 'apundarjeremy@gmail.com', 'uploads/resume/Aljhon Resume.docx', 'Hired', '2025-04-05 09:08:32', '2025-04-06', '13:10:00', 15),
(74, 74, 'PENPEN', 'apundarjeremy@gmail.com', 'uploads/resume/Aljhon Resume.docx', 'Hired', '2025-04-05 09:14:53', '2025-04-06', '13:15:00', 15);

-- --------------------------------------------------------

--
-- Table structure for table `attendanceleave`
--

DROP TABLE IF EXISTS `attendanceleave`;
CREATE TABLE `attendanceleave` (
  `AttendanceID` int(11) NOT NULL,
  `EmployeeID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Status` enum('Present','Absent','Leave') DEFAULT NULL,
  `LeaveType` enum('Sick','Vacation','Personal','Unpaid') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendanceleave`
--

INSERT INTO `attendanceleave` (`AttendanceID`, `EmployeeID`, `Date`, `Status`, `LeaveType`) VALUES
(1, 44, '2023-07-01', 'Present', NULL),
(2, 45, '2023-07-02', 'Leave', 'Vacation'),
(3, 46, '2023-07-01', 'Present', NULL),
(4, 47, '2023-07-02', 'Present', NULL),
(5, 48, '2023-07-01', 'Absent', NULL),
(6, 49, '2023-07-02', 'Present', NULL),
(7, 50, '2023-07-01', 'Present', NULL),
(8, 51, '2023-07-02', 'Leave', 'Sick'),
(9, 52, '2023-07-01', 'Present', NULL),
(10, 53, '2023-07-02', 'Present', NULL),
(11, 44, '2023-07-03', 'Present', NULL),
(12, 45, '2023-07-03', 'Leave', 'Vacation'),
(13, 46, '2023-07-03', 'Present', NULL),
(14, 47, '2023-07-03', 'Present', NULL),
(15, 48, '2023-07-03', 'Absent', NULL),
(16, 49, '2023-07-03', 'Present', NULL),
(17, 50, '2023-07-03', 'Present', NULL),
(18, 51, '2023-07-03', 'Leave', 'Sick'),
(19, 52, '2023-07-03', 'Present', NULL),
(20, 53, '2023-07-03', 'Present', NULL),
(21, 54, '2023-07-03', 'Present', NULL),
(22, 44, '2023-07-04', 'Present', NULL),
(23, 45, '2023-07-04', 'Leave', 'Vacation'),
(24, 46, '2023-07-04', 'Present', NULL),
(25, 47, '2023-07-04', 'Present', NULL),
(26, 48, '2023-07-04', 'Absent', NULL),
(27, 49, '2023-07-04', 'Present', NULL),
(28, 50, '2023-07-04', 'Present', NULL),
(29, 51, '2023-07-04', 'Leave', 'Sick'),
(30, 52, '2023-07-04', 'Present', NULL),
(31, 53, '2023-07-04', 'Present', NULL),
(32, 54, '2023-07-04', 'Present', NULL),
(33, 44, '2023-07-05', 'Present', NULL),
(34, 45, '2023-07-05', 'Leave', 'Vacation'),
(35, 46, '2023-07-05', 'Present', NULL),
(36, 47, '2023-07-05', 'Present', NULL),
(37, 48, '2023-07-05', 'Absent', NULL),
(38, 49, '2023-07-05', 'Present', NULL),
(39, 50, '2023-07-05', 'Present', NULL),
(40, 51, '2023-07-05', 'Leave', 'Sick'),
(41, 52, '2023-07-05', 'Present', NULL),
(42, 53, '2023-07-05', 'Present', NULL),
(43, 54, '2023-07-05', 'Present', NULL),
(44, 44, '2023-07-06', 'Present', NULL),
(45, 45, '2023-07-06', 'Leave', 'Vacation'),
(46, 46, '2023-07-06', 'Present', NULL),
(47, 47, '2023-07-06', 'Present', NULL),
(48, 48, '2023-07-06', 'Absent', NULL),
(49, 49, '2023-07-06', 'Present', NULL),
(50, 50, '2023-07-06', 'Present', NULL),
(51, 51, '2023-07-06', 'Leave', 'Sick'),
(52, 52, '2023-07-06', 'Present', NULL),
(53, 53, '2023-07-06', 'Present', NULL),
(54, 54, '2023-07-06', 'Present', NULL),
(55, 44, '2023-07-07', 'Present', NULL),
(56, 45, '2023-07-07', 'Leave', 'Vacation'),
(57, 46, '2023-07-07', 'Present', NULL),
(58, 47, '2023-07-07', 'Present', NULL),
(59, 48, '2023-07-07', 'Absent', NULL),
(60, 49, '2023-07-07', 'Present', NULL),
(61, 50, '2023-07-07', 'Present', NULL),
(62, 51, '2023-07-07', 'Leave', 'Sick'),
(63, 52, '2023-07-07', 'Present', NULL),
(64, 53, '2023-07-07', 'Present', NULL),
(65, 54, '2023-07-07', 'Present', NULL),
(66, 44, '2023-07-06', 'Leave', NULL),
(67, 45, '2023-07-06', 'Present', 'Vacation'),
(68, 46, '2023-07-06', 'Leave', NULL),
(69, 47, '2023-07-06', 'Present', NULL),
(70, 48, '2023-07-06', 'Present', NULL),
(71, 49, '2023-07-06', 'Present', NULL),
(72, 50, '2023-07-06', 'Present', NULL),
(73, 51, '2023-07-06', 'Leave', 'Sick'),
(74, 52, '2023-07-06', 'Present', NULL),
(75, 53, '2023-07-06', 'Present', NULL),
(76, 54, '2023-07-06', 'Leave', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `compensationbenefits`
--

DROP TABLE IF EXISTS `compensationbenefits`;
CREATE TABLE `compensationbenefits` (
  `CompensationID` int(11) NOT NULL,
  `EmployeeID` int(11) DEFAULT NULL,
  `BaseSalary` decimal(10,2) DEFAULT NULL,
  `Bonus` decimal(10,2) DEFAULT NULL,
  `BenefitType` enum('Health','Retirement','Stock Options','Other') DEFAULT NULL,
  `BenefitValue` decimal(10,2) DEFAULT NULL,
  `EffectiveDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compensationbenefits`
--

INSERT INTO `compensationbenefits` (`CompensationID`, `EmployeeID`, `BaseSalary`, `Bonus`, `BenefitType`, `BenefitValue`, `EffectiveDate`) VALUES
(1, 44, 60000.00, 5000.00, 'Health', 2000.00, '2023-01-01'),
(2, 45, 60000.00, 5000.00, 'Retirement', 3000.00, '2023-01-01'),
(3, 46, 75000.00, 7000.00, 'Health', 2500.00, '2023-01-01'),
(4, 47, 75000.00, 7000.00, 'Stock Options', 5000.00, '2023-01-01'),
(5, 48, 55000.00, 3000.00, 'Health', 1500.00, '2023-01-01'),
(6, 49, 55000.00, 3000.00, 'Retirement', 2000.00, '2023-01-01'),
(7, 50, 80000.00, 10000.00, 'Health', 3000.00, '2023-01-01'),
(8, 51, 80000.00, 10000.00, 'Stock Options', 7000.00, '2023-01-01'),
(9, 52, 48000.00, 2000.00, 'Health', 1000.00, '2023-01-01'),
(10, 53, 48000.00, 2000.00, 'Retirement', 1500.00, '2023-01-01'),
(11, 54, 47000.00, 2000.00, 'Retirement', 1500.00, '2023-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE `departments` (
  `DepartmentID` int(11) NOT NULL,
  `DepartmentName` varchar(100) NOT NULL,
  `ManagerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`DepartmentID`, `DepartmentName`, `ManagerID`) VALUES
(8, 'HR Department', NULL),
(9, 'IT Department', NULL),
(10, 'Finance and Accounting', NULL),
(11, 'Facilities Management', NULL),
(12, 'Teacher Department', NULL),
(15, 'Test department', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `user_id`, `document_name`, `file_path`, `uploaded_at`) VALUES
(19, 39, 'BOSS Q 1.txt', 'uploads/documents/BOSS Q 1.txt', '2024-11-13 16:03:36'),
(20, 44, 'BOSS Q 1.txt', 'uploads/documents/BOSS Q 1.txt', '2025-03-22 11:33:00'),
(21, 45, 'BOSS Q 1.txt', 'uploads/documents/BOSS Q 1.txt', '2025-03-22 11:33:24'),
(22, 46, 'BOSS Q 1.txt', 'uploads/documents/BOSS Q 1.txt', '2025-03-22 11:33:51'),
(23, 47, 'BOSS Q 1.txt', 'uploads/documents/BOSS Q 1.txt', '2025-03-22 11:33:51'),
(24, 48, 'BOSS Q 1.txt', 'uploads/documents/BOSS Q 1.txt', '2025-03-22 11:36:05'),
(25, 49, 'BOSS Q 1.txt', 'uploads/documents/BOSS Q 1.txt', '2025-03-22 11:36:05'),
(26, 4, 'BOSS Q 1.txt', 'uploads/documents/BOSS Q 1.txt', '2025-03-22 11:36:05'),
(27, 36, 'BOSS Q 1.txt', 'uploads/documents/BOSS Q 1.txt', '2025-03-22 11:36:05'),
(28, 36, 'BOSS Q 2.txt', 'uploads/documents/BOSS Q 1.txt', '2025-03-22 11:36:05'),
(29, 36, 'BOSS Q 3.txt', 'uploads/documents/BOSS Q 1.txt', '2025-03-22 11:36:05'),
(36, 53, 'bootstrap.txt', 'uploads/bootstrap.txt', '2025-03-31 07:43:34'),
(38, 54, 'Aljhon Resume.docx', 'uploads/Aljhon Resume.docx', '2025-03-31 07:45:46'),
(39, 55, 'GMAIL-ACC.txt', 'uploads/GMAIL-ACC.txt', '2025-04-01 03:39:27'),
(42, 60, '1-INDORSEMENT-FOR-INTERNSHIP.docx', 'uploads/1-INDORSEMENT-FOR-INTERNSHIP.docx', '2025-04-05 09:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `EmployeeID` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `HireDate` date DEFAULT NULL,
  `Salary` decimal(10,2) DEFAULT NULL,
  `Status` enum('Active','Inactive','Terminated') DEFAULT 'Active',
  `UserID` int(11) DEFAULT NULL,
  `PolicyAgreed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`EmployeeID`, `FirstName`, `LastName`, `Email`, `Phone`, `Address`, `DOB`, `HireDate`, `Salary`, `Status`, `UserID`, `PolicyAgreed`) VALUES
(44, 'Lukese', 'Francio', 'luefrancio@gmail.com', '09485234501', 'Silicon Valley', '2004-11-14', '2024-11-13', 30000.00, 'Active', 39, 1),
(45, 'John', 'Doe', 'johndoe@example.com', '09123456789', '123 Main St', '1990-01-01', '2025-01-26', 50000.00, 'Active', 40, 1),
(46, 'Jane', 'Smith', 'janesmith@example.com', '09123456780', '124 Main St', '1991-02-02', '2025-01-26', 60000.00, 'Active', 41, 1),
(47, 'Alice', 'Johnson', 'alicejohnson@example.com', '09123456781', '125 Main St', '1992-03-03', '2025-01-26', 55000.00, 'Active', 42, 1),
(48, 'Bob', 'Brown', 'bobbrown@example.com', '09123456782', '126 Main St', '1993-04-04', '2025-01-26', 52000.00, 'Active', 43, 1),
(49, 'Charlie', 'Davis', 'charliedavis@example.com', '09123456783', '127 Main St', '1994-05-05', '2025-01-26', 48000.00, 'Active', 44, 1),
(50, 'Diana', 'Evans', 'dianaevans@example.com', '09123456784', '128 Main St', '1995-06-06', '2025-01-26', 47000.00, 'Active', 45, 1),
(51, 'Ethan', 'Foster', 'ethanfoster@example.com', '09123456785', '129 Main St', '1996-07-07', '2025-01-26', 46000.00, 'Active', 46, 1),
(52, 'Fiona', 'Green', 'fionagreen@example.com', '09123456786', '130 Main St', '1997-08-08', '2025-01-26', 45000.00, 'Active', 47, 1),
(53, 'George', 'Harris', 'georgeharris@example.com', '09123456787', '131 Main St', '1998-09-09', '2025-01-26', 44000.00, 'Active', 48, 1),
(54, 'Hannahs', 'Ivers', 'hannahivers@example.com', '09123456788', '132 Main St', '1999-10-10', '2025-01-26', 43000.00, 'Active', 49, 1),
(55, 'STEPH', 'CURRY', 'curry@gmail.com', '0931203129', 'Golden State', '2025-03-30', '2025-03-30', 10.00, 'Active', 50, 1),
(56, 'jeremy', 'apundar', 'apundar@gmail.com', '129047812409', 'S PALAY', '2025-03-30', '2025-03-30', 1.00, 'Active', 51, 1),
(57, 'qwe', 'qwe', 'qwe@gmail.com', '12381249', 'ccsss', '2025-03-30', '2025-03-30', 1.00, 'Active', 52, 1),
(76, 'TEST', 'WATER', 'TESTWATER@GMAIL.COM', '1234567890', 'SAPANG PALAY PROPER', '2002-07-31', '2025-04-01', 10.00, 'Active', 54, 1),
(78, 'Jeremy', 'Apundar', 'apundarjeremy@gmail.com', '09485234501', 'SAPANG PALAY PROPER', '2002-07-31', '2025-04-01', 10.00, 'Active', 53, 1),
(79, 'qwerty', 'qwerty', 'qwertyaa@gmail.com', '09485234501', 'SAPANG PALAY PROPER', '2002-07-31', '2025-04-01', 10.00, 'Active', 54, 1),
(81, 'test', 'applicant', 'apundar1jeremy@gmail.com', '09485234501', 'Sapang Palay', '2002-07-31', '2025-04-01', 10.00, 'Active', 55, 1),
(87, 'Penpen', 'DelaFuente', 'penpen@gmail.com', '09485234501', 'Citrus', '2002-07-31', '2025-04-05', 0.00, 'Active', 60, 1),
(88, 'Jeremy', 'apundar', 'jeremy12w32131@gmai.com', '09222222222', 'los angeles', '2002-07-31', '2025-04-09', 0.00, 'Active', 36, 0),
(89, 'Super', 'a', 'superadmin@gmail.com', '09093642460', 'los angeles', '2002-07-31', '2025-04-09', 0.00, 'Active', 40, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fm_bookings`
--

DROP TABLE IF EXISTS `fm_bookings`;
CREATE TABLE `fm_bookings` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `status` enum('Pending','Approved','Rejected','Cancelled') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fm_bookings`
--

INSERT INTO `fm_bookings` (`id`, `employee_id`, `room_id`, `booking_date`, `start_time`, `end_time`, `purpose`, `status`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 36, 3, '2024-12-20', '11:01:00', '11:22:00', 'das', 'Approved', '2024-12-13 14:30:51', '2024-12-21 11:13:19', 0),
(2, 36, 1, '2024-12-09', '22:22:00', '22:44:00', '222', 'Rejected', '2024-12-14 04:00:56', '2024-12-16 14:45:24', 0),
(3, 36, 1, '2024-12-12', '23:11:00', '01:33:00', 'dwed', 'Rejected', '2024-12-14 08:08:20', '2024-12-17 14:43:10', 0),
(4, 36, 8, '2024-12-04', '12:02:00', '03:03:00', 'dex', 'Approved', '2024-12-14 08:09:43', '2024-12-21 08:53:38', 0),
(5, 36, 3, '2222-12-22', '21:02:00', '12:21:00', 'adsd', 'Cancelled', '2024-12-14 08:10:18', '2024-12-26 16:40:58', 0),
(6, 39, 2, '2024-12-10', '23:02:00', '23:02:00', 'asdads', 'Approved', '2024-12-14 10:49:47', '2024-12-21 10:57:01', 0),
(7, 39, 1, '2024-12-16', '12:02:00', '12:34:00', 'asd', 'Rejected', '2024-12-15 08:23:20', '2024-12-26 14:48:50', 0),
(8, 4, 4, '2024-12-16', '12:00:00', '13:01:00', 'may event', 'Rejected', '2024-12-15 08:39:38', '2024-12-26 14:48:55', 0),
(9, 39, 5, '2024-12-16', '12:02:00', '03:03:00', 'asda', 'Cancelled', '2024-12-15 08:50:37', '2024-12-26 15:37:20', 0),
(10, 39, 6, '2024-12-16', '12:02:00', '11:11:00', 'asd', 'Rejected', '2024-12-15 09:26:06', '2024-12-26 14:50:01', 0),
(11, 39, 6, '2024-12-16', '12:02:00', '11:11:00', 'asd', 'Approved', '2024-12-15 09:26:06', '2024-12-24 16:18:48', 0),
(12, 4, 1, '2024-12-16', '05:05:00', '07:55:00', 'May gagawin lang\r\n', 'Approved', '2024-12-15 11:34:40', '2024-12-21 11:13:19', 0),
(13, 4, 2, '2024-12-16', '12:02:00', '04:04:00', 'asd', 'Approved', '2024-12-15 11:37:44', '2024-12-24 16:17:12', 0),
(14, 39, 7, '2024-12-17', '21:22:00', '23:33:00', 'wqweqwe', 'Rejected', '2024-12-16 14:46:30', '2024-12-26 14:50:01', 0),
(15, 39, 8, '2024-12-17', '10:00:00', '11:00:00', 'mnb nbjvk jyfkuyr uyrkvgk tcu vbj kguvtjyg', 'Approved', '2024-12-17 13:40:39', '2024-12-21 11:11:34', 0),
(16, 39, 9, '2024-12-17', '12:12:00', '22:22:00', 'dasdasd', 'Rejected', '2024-12-17 13:42:19', '2024-12-26 14:50:01', 0),
(17, 39, 4, '2024-12-22', '23:33:00', '03:33:00', 'sdasd', 'Approved', '2024-12-21 13:10:48', '2024-12-24 16:17:07', 0),
(18, 39, 4, '2024-12-22', '12:02:00', '03:04:00', 'deade', 'Approved', '2024-12-21 13:12:39', '2024-12-23 15:15:00', 0),
(19, 39, 8, '2024-12-22', '03:44:00', '03:06:00', 'dsfsdf', 'Approved', '2024-12-21 13:56:36', '2024-12-22 11:53:21', 0),
(20, 0, 11, '2024-12-23', '23:33:00', '23:03:00', 'admin', 'Pending', '2024-12-22 03:24:41', '2024-12-22 03:24:41', 1),
(21, 36, 10, '2024-12-23', '23:03:00', '05:06:00', 'sdfsf', 'Rejected', '2024-12-22 09:15:01', '2024-12-24 04:25:32', 1),
(22, 36, 13, '2024-12-23', '23:33:00', '23:44:00', 'admin', 'Approved', '2024-12-22 09:15:39', '2024-12-24 16:14:52', 0),
(23, 36, 21, '2024-12-22', '18:25:00', '05:06:00', 'naguupdate ba', 'Approved', '2024-12-22 10:24:48', '2024-12-24 04:34:28', 0),
(24, 36, 1, '2024-12-24', '23:33:00', '03:03:00', 'awdawdawd', 'Approved', '2024-12-23 15:33:47', '2024-12-24 08:41:24', 0),
(25, 39, 15, '2024-12-25', '23:03:00', '04:04:00', 'dasd', 'Approved', '2024-12-24 05:02:59', '2024-12-26 17:00:41', 0),
(26, 39, 19, '2025-12-05', '03:04:00', '04:57:00', 'padawd', 'Approved', '2024-12-24 06:32:20', '2024-12-24 16:19:04', 1),
(27, 4, 20, '2024-12-25', '12:43:00', '03:44:00', 'sdfsdf', 'Approved', '2024-12-24 08:15:01', '2024-12-25 03:31:00', 0),
(28, 4, 17, '2024-12-24', '17:18:00', '06:07:00', 'TESTTTTTTTTTT', 'Approved', '2024-12-24 09:17:36', '2024-12-24 09:46:14', 0),
(29, 36, 11, '2024-12-31', '23:33:00', '03:34:00', 'New YEars Party', 'Cancelled', '2024-12-25 03:30:49', '2025-01-26 16:36:15', 1),
(30, 4, 1, '2024-12-26', '23:03:00', '04:05:00', 'sdfsdf', 'Rejected', '2024-12-25 14:14:57', '2024-12-27 05:41:53', 1),
(31, 4, 2, '2024-12-27', '23:03:00', '04:55:00', 'sdfsdf', 'Approved', '2024-12-26 13:33:19', '2025-04-09 15:43:17', 0),
(32, 4, 4, '0006-01-06', '03:44:00', '04:05:00', 'dfgdfg', 'Approved', '2024-12-26 13:47:48', '2025-04-09 15:43:17', 0),
(33, 4, 5, '2025-01-30', '23:03:00', '04:05:00', 'dfgdfg', 'Approved', '2024-12-26 13:49:06', '2025-03-29 09:42:30', 0),
(34, 4, 6, '2025-02-18', '23:03:00', '04:05:00', 'sdff', 'Approved', '2024-12-26 13:51:40', '2025-02-20 13:08:55', 0),
(35, 4, 7, '2025-01-04', '23:03:00', '03:44:00', 'fsdsdf', 'Cancelled', '2024-12-26 13:58:55', '2024-12-26 16:26:06', 1),
(36, 4, 8, '2025-01-02', '03:33:00', '03:44:00', 'sdfsdf', 'Cancelled', '2024-12-26 13:59:11', '2024-12-26 15:52:59', 1),
(37, 4, 9, '2025-01-03', '23:03:00', '04:05:00', 'sdfsdf', 'Cancelled', '2024-12-26 16:13:34', '2024-12-26 16:30:22', 1),
(38, 4, 10, '2025-01-10', '04:55:00', '05:06:00', 'dfgdfg', 'Cancelled', '2024-12-26 16:14:01', '2024-12-26 16:22:44', 1),
(39, 4, 13, '2024-12-06', '12:02:00', '04:55:00', 'sdfsdf', 'Cancelled', '2024-12-26 16:25:02', '2024-12-26 16:25:10', 1),
(40, 4, 12, '2025-01-11', '23:45:00', '04:05:00', 'dfdfg', 'Cancelled', '2024-12-26 16:32:14', '2024-12-26 16:32:19', 1),
(41, 4, 14, '2025-01-09', '23:04:00', '04:05:00', 'dfgdfg', 'Cancelled', '2024-12-26 16:32:57', '2024-12-26 16:33:06', 1),
(42, 4, 17, '2025-01-08', '23:03:00', '04:55:00', 'dfgdfg', 'Cancelled', '2024-12-26 16:36:02', '2024-12-26 16:36:07', 1),
(43, 4, 16, '2025-01-07', '03:44:00', '04:05:00', 'sfsdf', 'Cancelled', '2024-12-26 16:37:02', '2024-12-26 16:37:28', 1),
(44, 4, 18, '2025-01-01', '23:33:00', '04:55:00', 'dfdfg', 'Cancelled', '2024-12-26 16:53:14', '2024-12-26 16:53:19', 0),
(45, 4, 18, '2025-01-06', '04:44:00', '05:55:00', '4455', 'Cancelled', '2024-12-26 16:54:25', '2024-12-26 16:54:33', 0),
(46, 4, 18, '2025-01-07', '01:05:00', '01:06:00', 'dfdfg', 'Cancelled', '2024-12-26 16:55:15', '2024-12-26 16:55:20', 0),
(47, 4, 15, '2024-12-30', '22:22:00', '04:44:00', 'adad', 'Cancelled', '2025-01-26 04:31:56', '2025-01-26 04:32:04', 0),
(48, 36, 18, '2025-02-20', '21:02:00', '23:03:00', 'asdasd', 'Approved', '2025-02-20 12:53:17', '2025-03-27 12:49:31', 0),
(49, 4, 23, '2025-02-21', '12:02:00', '03:44:00', 'testing feb 20', 'Cancelled', '2025-02-20 13:12:25', '2025-02-20 13:12:52', 0),
(50, 4, 23, '2025-02-21', '12:22:00', '12:02:00', 'testing feb 20', 'Approved', '2025-02-20 13:13:14', '2025-03-16 14:54:31', 0),
(51, 4, 6, '2025-03-26', '12:22:00', '12:22:00', 'sSSsdf', 'Cancelled', '2025-03-26 14:26:30', '2025-03-26 14:26:40', 0),
(52, 4, 20, '2025-03-26', '23:33:00', '04:55:00', 'sfsdfsdf', 'Approved', '2025-03-26 14:27:24', '2025-04-09 16:41:37', 0),
(53, 4, 23, '2025-03-26', '12:22:00', '03:44:00', 'rwar', 'Approved', '2025-03-26 14:29:14', '2025-03-28 13:21:52', 0),
(54, 4, 6, '2025-03-06', '12:22:00', '04:44:00', 'sdfsdf', 'Pending', '2025-03-28 13:17:11', '2025-03-28 13:17:11', 1),
(55, 4, 5, '2025-04-10', '23:33:00', '04:05:00', 'sdfdsf', 'Cancelled', '2025-04-09 12:55:56', '2025-04-09 13:05:26', 0),
(56, 4, 5, '2025-04-10', '12:02:00', '03:44:00', 'dasdasd', 'Pending', '2025-04-09 13:05:45', '2025-04-09 13:05:45', 1),
(57, 4, 13, '2025-04-11', '03:44:00', '05:06:00', 'HElo \r\nsdfsdfsd\r\nsdfsdf', 'Approved', '2025-04-09 16:43:23', '2025-04-09 16:43:47', 1),
(58, 4, 11, '2025-04-14', '23:33:00', '12:44:00', 'dads', 'Cancelled', '2025-04-09 16:54:39', '2025-04-09 16:54:44', 0),
(59, 4, 16, '2025-04-23', '05:06:00', '04:55:00', 'sdfsdf', 'Cancelled', '2025-04-09 16:54:56', '2025-04-09 16:55:01', 0),
(60, 4, 23, '2025-04-10', '04:55:00', '07:08:00', 'fsefsefe', 'Cancelled', '2025-04-09 16:55:19', '2025-04-09 16:55:42', 0),
(61, 4, 15, '2025-04-10', '03:44:00', '21:02:00', 'sdfsdfdsf', 'Cancelled', '2025-04-09 16:55:32', '2025-04-09 16:55:37', 0),
(62, 4, 15, '2025-04-18', '23:03:00', '05:04:00', 'sdf', 'Approved', '2025-04-09 16:56:02', '2025-04-09 17:20:38', 1),
(63, 4, 12, '2025-04-06', '12:22:00', '12:55:00', 'testing\r\n', 'Approved', '2025-04-05 22:17:54', '2025-04-05 22:46:48', 1),
(64, 4, 16, '2025-04-06', '12:02:00', '12:45:00', 'sfsdfsd', 'Cancelled', '2025-04-05 22:18:31', '2025-04-05 22:45:50', 0),
(65, 4, 9, '2025-04-06', '12:02:00', '12:44:00', 'fsdfsdfsdf', 'Approved', '2025-04-05 22:45:42', '2025-04-06 16:11:01', 0),
(66, 4, 6, '2025-04-07', '12:02:00', '03:04:00', 'Hello', 'Approved', '2025-04-06 16:45:46', '2025-04-06 16:46:06', 1),
(67, 4, 9, '2025-04-07', '04:55:00', '03:04:00', 'testets', 'Approved', '2025-04-06 16:57:44', '2025-04-07 06:56:43', 0),
(68, 4, 13, '2025-03-31', '23:03:00', '04:03:00', 'dfsdf', 'Cancelled', '2025-04-06 19:16:35', '2025-04-06 19:16:41', 0),
(69, 4, 13, '2025-03-31', '23:33:00', '23:33:00', 'fsdf', 'Cancelled', '2025-04-06 19:17:24', '2025-04-06 19:17:28', 0),
(70, 4, 13, '2025-04-05', '03:33:00', '03:44:00', 'sdfsdf', 'Cancelled', '2025-04-06 19:21:57', '2025-04-06 19:23:41', 0),
(71, 4, 13, '2025-04-07', '23:03:00', '23:56:00', 'test', 'Approved', '2025-04-06 19:27:27', '2025-04-06 19:27:41', 1),
(72, 4, 14, '2025-04-08', '23:33:00', '23:03:00', 'dfsdfdf', 'Approved', '2025-04-07 06:54:47', '2025-04-07 06:56:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fm_resources`
--

DROP TABLE IF EXISTS `fm_resources`;
CREATE TABLE `fm_resources` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('Available','In Maintenance','Damaged') DEFAULT 'Available',
  `last_maintenance` date DEFAULT NULL,
  `next_maintenance` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fm_resources`
--

INSERT INTO `fm_resources` (`id`, `name`, `category`, `quantity`, `location`, `status`, `last_maintenance`, `next_maintenance`, `created_at`) VALUES
(81, 'Impact Tool', 'Hardware', 112, 'Storage room', 'Available', '2025-01-01', '2024-12-26', '2024-12-09 08:44:08'),
(82, 'RJ45', 'Hardware', 100, '2nd Floor', 'Available', '2025-01-01', '2025-01-03', '2024-12-09 08:44:37'),
(87, 'System Unit', 'Hardware', 12, '2nd Floor', 'Available', '2024-12-17', '2024-12-25', '2024-12-10 12:16:42'),
(88, 'Cable', 'Hardware', 1000, 'IT Department', 'Available', '3232-02-12', '0222-12-21', '2024-12-11 01:59:19'),
(90, 'Computer Monitor', 'Hardware', 119, 'IT Department', 'Available', '2121-02-12', '2222-02-12', '2024-12-15 02:40:44'),
(97, 'Volleyball', 'Sports', 112, 'PEH Depertment', 'Available', '2025-01-26', '2025-01-26', '2025-01-26 03:46:08'),
(98, 'Basketball', 'Sports', 96, 'PEH Depertment', 'Available', '2025-01-26', '2025-01-26', '2025-01-26 03:46:54'),
(99, 'Chalk', 'Utilities', 600, 'Dean', 'Available', '2025-01-26', '2025-01-26', '2025-01-26 10:10:58'),
(100, 'Pentel Pen', 'Utilities', 12, 'Room 12', 'Available', '2025-02-20', '2025-02-21', '2025-02-20 12:52:34'),
(102, 'Projector', 'Utilities', 20, 'IT Department', 'Available', '2025-03-28', '2025-03-28', '2025-03-27 12:47:51');

-- --------------------------------------------------------

--
-- Table structure for table `fm_resource_allocations`
--

DROP TABLE IF EXISTS `fm_resource_allocations`;
CREATE TABLE `fm_resource_allocations` (
  `id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `allocation_start` datetime NOT NULL,
  `allocation_end` datetime DEFAULT NULL,
  `status` enum('Allocated','Returned','Rejected') DEFAULT 'Allocated',
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fm_resource_allocations`
--

INSERT INTO `fm_resource_allocations` (`id`, `resource_id`, `employee_id`, `quantity`, `allocation_start`, `allocation_end`, `status`, `notes`, `created_at`) VALUES
(1, 81, 36, 23, '2024-12-31 03:33:00', '2025-01-01 23:03:00', 'Returned', 'fsdsdf', '2024-12-30 23:35:09'),
(2, 87, 36, 5, '2025-01-26 05:55:00', '2032-01-27 05:55:00', 'Allocated', 'new commers', '2025-01-26 17:04:36'),
(3, 90, 36, 5, '2025-01-26 12:02:00', '2038-01-26 12:02:00', 'Returned', 'new commers', '2025-01-26 17:06:27'),
(4, 90, 36, 5, '2025-01-14 05:55:00', '2045-01-26 11:01:00', 'Allocated', 'new commers', '2025-01-26 17:14:04'),
(5, 87, 36, 2, '2025-02-20 12:22:00', '2025-05-29 12:02:00', 'Allocated', 'test', '2025-02-20 20:51:36'),
(6, 81, 36, 12, '2025-03-28 23:33:00', '2025-03-28 23:33:00', 'Returned', 'qweqw', '2025-03-27 20:49:16'),
(7, 87, 36, 1, '2025-03-30 11:49:00', '2025-03-30 11:49:00', 'Allocated', 'hey', '2025-03-30 11:49:40'),
(8, 98, 36, 5, '2025-03-30 11:50:00', '2025-04-02 11:50:00', 'Allocated', 'hey', '2025-03-30 11:50:48');

-- --------------------------------------------------------

--
-- Table structure for table `fm_resource_requests`
--

DROP TABLE IF EXISTS `fm_resource_requests`;
CREATE TABLE `fm_resource_requests` (
  `id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `purpose` text NOT NULL,
  `status` enum('Pending','Approved','Rejected','Returned') DEFAULT 'Pending',
  `return_date` date DEFAULT NULL,
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fm_resource_requests`
--

INSERT INTO `fm_resource_requests` (`id`, `resource_id`, `employee_id`, `quantity`, `purpose`, `status`, `return_date`, `requested_at`, `approved_by`, `approved_at`) VALUES
(1, 81, 36, 2, 'wer', 'Returned', '2025-04-09', '2024-12-29 01:08:00', NULL, NULL),
(2, 81, 36, 34, 'qweqwe', 'Returned', '2025-04-09', '2024-12-29 01:33:56', NULL, NULL),
(3, 90, 36, 2, 'Pupose Testing', 'Returned', '2025-04-09', '2024-12-29 04:38:04', NULL, NULL),
(4, 81, 4, 3, 'e', 'Returned', '2025-04-09', '2025-01-26 02:38:38', NULL, NULL),
(5, 82, 4, 5, 'HIRAM', 'Returned', '2025-04-09', '2025-01-26 02:48:32', NULL, NULL),
(6, 82, 4, 33, '33', 'Rejected', NULL, '2025-01-26 02:49:06', NULL, NULL),
(7, 82, 4, 1, 'Client Meeting', 'Returned', '2025-04-09', '2024-12-29 00:45:00', NULL, NULL),
(8, 97, 36, 4, 'Training Session', 'Returned', '2025-04-09', '2024-12-29 01:00:00', 2, '2024-12-30 02:00:00'),
(9, 98, 36, 2, 'Equipment Maintenance', 'Returned', '2025-04-09', '2024-12-29 02:15:00', NULL, NULL),
(10, 90, 4, 6, 'Research Materials', 'Returned', '2025-04-09', '2024-12-29 03:30:00', 3, '2024-12-30 04:00:00'),
(11, 90, 39, 8, 'Conference Attendance', 'Rejected', NULL, '2024-12-29 04:45:00', NULL, NULL),
(12, 97, 4, 7, 'Software License', 'Returned', '2025-04-09', '2024-12-29 05:00:00', NULL, NULL),
(13, 98, 39, 9, 'Hardware Upgrade', 'Approved', NULL, '2024-12-29 06:15:00', 4, '2024-12-30 07:00:00'),
(14, 81, 36, 5, 'Office Supplies', 'Returned', '2025-04-09', '2024-12-28 21:00:00', NULL, NULL),
(15, 81, 39, 10, 'Project A Materials', 'Returned', '2025-04-09', '2024-12-28 22:15:00', 1, '2024-12-29 23:00:00'),
(16, 82, 36, 3, 'Team Building Event', 'Rejected', NULL, '2024-12-28 23:30:00', NULL, NULL),
(17, 81, 36, 4, 'Office Renovation', 'Returned', '2025-04-09', '2024-11-01 02:00:00', NULL, NULL),
(18, 82, 39, 2, 'New Software Installation', 'Approved', NULL, '2024-11-01 03:15:00', 1, '2024-11-06 04:00:00'),
(19, 97, 36, 3, 'Team Outing', 'Rejected', NULL, '2024-11-10 01:30:00', NULL, NULL),
(20, 98, 4, 1, 'Client Presentation', 'Returned', '2025-04-09', '2024-11-01 06:45:00', NULL, NULL),
(21, 90, 36, 5, 'Training Materials', 'Returned', '2025-04-09', '2024-11-26 00:00:00', 2, '2024-11-21 01:00:00'),
(22, 90, 39, 6, 'Equipment Purchase', 'Approved', NULL, '2024-11-25 05:15:00', NULL, NULL),
(23, 97, 36, 8, 'Conference Registration', 'Returned', '2025-04-09', '2024-11-26 07:30:00', 3, '2024-11-27 08:00:00'),
(24, 90, 4, 7, 'Research Project', 'Returned', '2025-04-09', '2024-11-26 09:45:00', NULL, NULL),
(25, 90, 36, 9, 'Marketing Materials', 'Returned', '2025-04-09', '2024-11-29 10:00:00', NULL, NULL),
(26, 81, 36, 10, 'IT Support', 'Returned', '2025-04-09', '2024-11-30 11:15:00', 4, '2024-12-01 12:00:00'),
(27, 99, 36, 10, 'test', 'Returned', '2025-04-09', '2025-02-20 12:50:15', NULL, NULL),
(28, 82, 4, 90, 'testing feb 20', 'Rejected', NULL, '2025-02-20 13:17:03', NULL, NULL),
(29, 81, 4, 23, 'asdasdasd', 'Returned', '2025-04-09', '2025-03-26 14:27:34', NULL, NULL),
(30, 100, 4, 1, 'adasdasd', 'Returned', '2025-04-09', '2025-03-26 14:29:27', NULL, NULL),
(31, 81, 4, 5, 'wrwere', 'Returned', '2025-04-09', '2025-03-28 13:18:59', NULL, NULL),
(32, 82, 4, 1, 'asdasd', 'Returned', '2025-04-09', '2025-04-09 12:55:26', NULL, '2025-04-09 13:01:44'),
(33, 102, 4, 122, 'lahat lahat\r\n', 'Returned', '2025-04-09', '2025-04-09 13:06:05', NULL, '2025-04-09 13:07:12'),
(34, 81, 4, 12, 'ewqewqe', 'Pending', NULL, '2025-04-09 14:24:33', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fm_rooms`
--

DROP TABLE IF EXISTS `fm_rooms`;
CREATE TABLE `fm_rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `status` enum('Available','Booked') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fm_rooms`
--

INSERT INTO `fm_rooms` (`id`, `name`, `location`, `capacity`, `status`) VALUES
(10, 'Computer Laborary 2', '2rd floor main building', 50, 'Available'),
(11, 'Computer Laborary', '2nd Floor', 50, 'Available'),
(12, 'Covered Court', 'Ground floor', 1500, 'Available'),
(13, 'GYM', 'Ground floor', 1000, 'Booked'),
(14, 'Science Laboratory 2', 'Main Building Science Laboratory', 60, 'Available'),
(15, 'Science Laboratory', 'Ground floor Science Laboratory', 40, 'Booked'),
(16, 'Lecture Room 6', 'asasdasd', 21, 'Available'),
(17, 'Lecture Room 7', '3rd floor main building', 50, 'Available'),
(18, 'Lecture Room 5', 'Ground floor', 50, 'Available'),
(20, 'Lecture Room 4', 'Second Floor', 50, 'Available'),
(21, 'Lecture Room 3', 'test-book moto', 50, 'Available'),
(22, 'Lecture Room 2', 'Room 2', 50, 'Available'),
(23, 'Lecture Room 1', 'Location 1', 50, 'Available'),
(24, 'Lecture Room 19', 'Lectiure Science Laboratory', 50, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `jobroles`
--

DROP TABLE IF EXISTS `jobroles`;
CREATE TABLE `jobroles` (
  `JobRoleID` int(11) NOT NULL,
  `JobTitle` varchar(100) NOT NULL,
  `JobDescription` text DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `SalaryRangeMin` decimal(10,2) DEFAULT NULL,
  `SalaryRangeMax` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobroles`
--

INSERT INTO `jobroles` (`JobRoleID`, `JobTitle`, `JobDescription`, `DepartmentID`, `SalaryRangeMin`, `SalaryRangeMax`) VALUES
(1, 'HR Manager', 'Oversees HR operations.', 8, 50000.00, 80000.00),
(2, 'IT Specialist', 'Manages IT infrastructure.', 9, 45000.00, 70000.00),
(3, 'Financial Analyst', 'Analyzes financial data.', 10, 55000.00, 85000.00),
(4, 'Marketing Coordinator', 'Coordinates marketing campaigns.', 11, 40000.00, 60000.00),
(5, 'Operations Manager', 'Manages daily operations.', 12, 60000.00, 90000.00);

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

DROP TABLE IF EXISTS `job_postings`;
CREATE TABLE `job_postings` (
  `id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `job_description` text NOT NULL,
  `requirements` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `salary_range` varchar(255) DEFAULT NULL,
  `status` enum('Open','Closed') DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `DepartmentID` int(11) DEFAULT NULL,
  `EmployeeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`id`, `job_title`, `job_description`, `requirements`, `location`, `salary_range`, `status`, `created_at`, `DepartmentID`, `EmployeeID`) VALUES
(57, 'HR Manager', 'Oversee the HR department and manage all HR functions, including recruitment, employee relations, training, and compliance.', 'Bachelor’s degree in Human Resources, Business Administration, or related field\r\n5+ years of HR experience, with at least 2 years in a management role\r\nStrong knowledge of labor laws and regulations.', 'Bestlink College of the Philippines', 'PHP 60,000 - PHP 100,000 per month.', 'Closed', '2024-11-02 11:05:54', 8, 44),
(58, 'HR Coordinator', 'Assist in recruitment activities, onboarding of new hires, and maintaining employee records.\r\nSupport HR projects and initiatives, including training and employee engagement programs.', 'Bachelor’s degree in Human Resource Management or related field.\r\n1-3 years of HR experience.\r\nGood communication and organizational skills.', 'Bestlink College of the Philippines', 'PHP 25,000 - PHP 45,000 per month.', 'Open', '2024-11-02 12:30:44', 8, 47),
(59, 'Systems Administrator', 'Manage and maintain school servers, networks, and computer systems.\r\nEnsure system availability, security, and performance.', 'Bachelor’s degree in Computer Science, Information Technology, or related field.\r\n3-5 years of experience in systems administration.\r\nFamiliarity with server management and network protocols.', 'Bestlink College of the Philippines', 'PHP 30,000 - PHP 60,000 per month.', 'Open', '2024-11-02 12:31:56', 9, 48),
(60, 'Network Administrator', 'Configure, maintain, and troubleshoot the school\'s network infrastructure.\r\nMonitor network performance and security.', 'Bachelor’s degree in Information Technology, Network Engineering, or related field.\r\n3+ years of experience in network administration.\r\nKnowledge of network protocols, routers, and firewalls.', 'Bestlink College of the Philippines', 'PHP 30,000 - PHP 55,000 per month.', 'Open', '2024-11-02 12:32:31', 9, 49),
(61, 'Maintenance Supervisor', 'Supervise maintenance staff and coordinate repair and maintenance activities for the school.\r\nEnsure that all facilities are safe and comply with relevant regulations.', 'Diploma or Bachelor’s degree in Engineering, Facilities Management, or related field.\r\n3-5 years of experience in facilities maintenance.\r\nKnowledge of building systems (HVAC, electrical, plumbing).', 'Bestlink College of the Philippines', 'PHP 30,000 - PHP 60,000 per month.', 'Closed', '2024-11-02 12:34:00', 11, 50),
(62, 'Software Engineer', 'Develop and maintain software applications.', 'Bachelor’s degree in Computer Science or related field.', 'Bestlink College of the Philippines', 'PHP 40,000 - PHP 70,000 per month.', 'Open', '2025-01-26 03:14:16', 9, 51),
(63, 'HR Manager', 'Oversee the HR department and manage all HR functions.', 'Bachelor’s degree in Human Resources.', 'Bestlink College of the Philippines', 'PHP 60,000 - PHP 100,000 per month.', 'Open', '2025-01-26 03:14:16', 8, 52),
(64, 'Network Administrator', 'Manage and maintain network infrastructure.', 'Bachelor’s degree in IT.', 'Bestlink College of the Philippines', 'PHP 30,000 - PHP 55,000 per month.', 'Open', '2025-01-26 03:14:16', 9, 53),
(65, 'Data Analyst', 'Analyze data and provide insights.', 'Bachelor’s degree in Statistics or related field.', 'Bestlink College of the Philippines', 'PHP 35,000 - PHP 60,000 per month.', 'Open', '2025-01-26 03:14:16', 10, 46),
(66, 'Web Developer', 'Develop and maintain websites.', 'Bachelor’s degree in Computer Science.', 'Bestlink College of the Philippines', 'PHP 40,000 - PHP 70,000 per month.', 'Open', '2025-01-26 03:14:16', 9, 45),
(67, 'Graphic Designer', 'Create visual concepts.', 'Bachelor’s degree in Design.', 'Bestlink College of the Philippines', 'PHP 25,000 - PHP 50,000 per month.', 'Open', '2025-01-26 03:14:16', 11, 45),
(68, 'Sales Executive', 'Drive sales and manage client relationships.', 'Bachelor’s degree in Business.', 'Bestlink College of the Philippines', 'PHP 30,000 - PHP 55,000 per month.', 'Open', '2025-01-26 03:14:16', 12, NULL),
(69, 'Content Writer', 'Create content for various platforms.', 'Bachelor’s degree in Communications.', 'Bestlink College of the Philippines', 'PHP 25,000 - PHP 45,000 per month.', 'Closed', '2025-01-26 03:14:16', 10, NULL),
(70, 'IT Support', 'Provide technical support to users.', 'Bachelor’s degree in IT.', 'Bestlink College of the Philippines', 'PHP 20,000 - PHP 40,000 per month.', 'Open', '2025-01-26 03:14:16', 9, NULL),
(71, 'Project Manager', 'Manage projects from initiation to closure.', 'Bachelor’s degree in Management.', 'Bestlink College of the Philippines', 'PHP 50,000 - PHP 90,000 per month.', 'Open', '2025-01-26 03:14:16', 8, NULL),
(72, 'TEST JOB', 'TEST JOB', 'TEST JOB', 'TEST JOB LOCATION', '3000', 'Open', '2025-04-01 03:34:57', 15, NULL),
(73, 'TESTING JOBS', 'TESTING JOBS', 'TESTING JOBS', 'BESTLINK', '30000 - 50000', 'Open', '2025-04-05 09:07:40', 15, NULL),
(74, 'JOB TESTING', 'JOB TESTING', 'JOB TESTING', 'BESTLINK', '30000 - 50000', 'Open', '2025-04-05 09:14:10', 15, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `performanceevaluations`
--

DROP TABLE IF EXISTS `performanceevaluations`;
CREATE TABLE `performanceevaluations` (
  `EvaluationID` int(11) NOT NULL,
  `EmployeeID` int(11) DEFAULT NULL,
  `EvaluationDate` date DEFAULT NULL,
  `EvaluatorID` int(11) DEFAULT NULL,
  `Score` int(11) DEFAULT NULL,
  `Comments` text DEFAULT NULL,
  `EvaluationType` enum('Annual','Quarterly','Monthly') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `performanceevaluations`
--

INSERT INTO `performanceevaluations` (`EvaluationID`, `EmployeeID`, `EvaluationDate`, `EvaluatorID`, `Score`, `Comments`, `EvaluationType`) VALUES
(1, 45, '2025-01-26', NULL, 85, 'Good performance in the first quarter.', 'Quarterly'),
(2, 46, '2025-01-26', NULL, 90, 'Excellent performance in the first quarter.', 'Quarterly'),
(3, 47, '2025-01-26', NULL, 78, 'Satisfactory performance in the first quarter.', 'Quarterly'),
(4, 48, '2025-01-26', NULL, 82, 'Good performance in the first quarter.', 'Quarterly'),
(5, 49, '2025-01-26', NULL, 88, 'Very good performance in the first quarter.', 'Quarterly'),
(6, 50, '2025-01-26', NULL, 80, 'Good performance in the first quarter.', 'Quarterly'),
(7, 51, '2025-01-26', NULL, 75, 'Needs improvement in the first quarter.', 'Quarterly'),
(8, 52, '2025-01-26', NULL, 92, 'Outstanding performance in the first quarter.', 'Quarterly'),
(9, 53, '2025-01-26', NULL, 70, 'Satisfactory performance in the first quarter.', 'Quarterly'),
(10, 54, '2025-01-26', NULL, 85, 'Good performance in the first quarter.', 'Quarterly'),
(11, 44, '2025-03-22', 47, 87, 'Good performance in the first quarter.', 'Quarterly');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`) VALUES
(1, 'CREATE', NULL),
(2, 'EDIT', NULL),
(3, 'DELETE', NULL),
(4, 'VIEW', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recruitment`
--

DROP TABLE IF EXISTS `recruitment`;
CREATE TABLE `recruitment` (
  `RecruitmentID` int(11) NOT NULL,
  `JobRoleID` int(11) DEFAULT NULL,
  `CandidateName` varchar(100) DEFAULT NULL,
  `InterviewDate` date DEFAULT NULL,
  `Status` enum('Applied','Interviewed','Offered','Rejected','Hired') DEFAULT NULL,
  `HiredEmployeeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(50) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RoleID`, `RoleName`, `Description`) VALUES
(1, 'admin', ''),
(2, 'superadmin', ''),
(3, 'manager', ''),
(4, 'employee', ''),
(5, 'staff', ''),
(6, 'applicant', '');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(3, 1),
(3, 2),
(3, 4),
(4, 1),
(4, 2),
(4, 4),
(5, 4),
(6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `trainingprograms`
--

DROP TABLE IF EXISTS `trainingprograms`;
CREATE TABLE `trainingprograms` (
  `TrainingID` int(11) NOT NULL,
  `TrainingName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `Instructor` varchar(100) DEFAULT NULL,
  `EmployeeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainingprograms`
--

INSERT INTO `trainingprograms` (`TrainingID`, `TrainingName`, `Description`, `StartDate`, `EndDate`, `Instructor`, `EmployeeID`) VALUES
(1, 'Leadership Training', 'Training for developing leadership skills.', '2025-01-26', '2025-02-25', 'Jane Smith', 45),
(2, 'Technical Skills Development', 'Enhance technical skills for software development.', '2025-01-26', '2025-02-25', 'Alice Johnson', 46),
(3, 'Communication Skills', 'Improve communication skills for better teamwork.', '2025-01-26', '2025-02-25', 'Bob Brown', 47),
(4, 'Project Management', 'Training on project management methodologies.', '2025-01-26', '2025-02-25', 'Charlie Davis', 48),
(5, 'Sales Techniques', 'Training on effective sales techniques.', '2025-01-26', '2025-02-25', 'Diana Evans', 49),
(6, 'Customer Service Excellence', 'Training on providing excellent customer service.', '2025-01-26', '2025-02-25', 'Ethan Foster', 50),
(7, 'Time Management', 'Training on effective time management skills.', '2025-01-26', '2025-02-25', 'Fiona Green', 51),
(8, 'Conflict Resolution', 'Training on resolving workplace conflicts.', '2025-01-26', '2025-02-25', 'George Harris', 52),
(9, 'Creative Thinking', 'Training on enhancing creative thinking skills.', '2025-01-26', '2025-02-25', 'Hannah Ivers', 53),
(10, 'Team Building', 'Training on building effective teams.', '2025-01-26', '2025-02-25', 'Jane Smith', 54),
(11, 'Basic Programming Training', 'Study Basic Programming', '2025-03-22', '2025-03-31', NULL, 44);

-- --------------------------------------------------------

--
-- Table structure for table `training_applications`
--

DROP TABLE IF EXISTS `training_applications`;
CREATE TABLE `training_applications` (
  `application_id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `training_id` int(11) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `applied_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_applications`
--

INSERT INTO `training_applications` (`application_id`, `employee_id`, `training_id`, `status`, `applied_at`) VALUES
(27, 87, 16, 'Pending', '2025-04-05 23:40:35'),
(28, 87, 3, 'Pending', '2025-04-06 00:03:06'),
(29, 87, 17, 'Pending', '2025-04-06 00:03:10');

-- --------------------------------------------------------

--
-- Table structure for table `training_assignments`
--

DROP TABLE IF EXISTS `training_assignments`;
CREATE TABLE `training_assignments` (
  `assignment_id` int(11) NOT NULL,
  `training_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `status` enum('Not Started','In Progress','Completed') DEFAULT 'Not Started',
  `completion_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_assignments`
--

INSERT INTO `training_assignments` (`assignment_id`, `training_id`, `employee_id`, `status`, `completion_date`) VALUES
(15, 3, 87, 'Completed', '2025-04-09');

-- --------------------------------------------------------

--
-- Table structure for table `training_grades`
--

DROP TABLE IF EXISTS `training_grades`;
CREATE TABLE `training_grades` (
  `grade_id` int(11) NOT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `grade` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_grades`
--

INSERT INTO `training_grades` (`grade_id`, `assignment_id`, `grade`) VALUES
(4, 15, 5.00);

-- --------------------------------------------------------

--
-- Table structure for table `training_sessions`
--

DROP TABLE IF EXISTS `training_sessions`;
CREATE TABLE `training_sessions` (
  `training_id` int(11) NOT NULL,
  `training_name` varchar(255) NOT NULL,
  `training_description` text NOT NULL,
  `trainer` varchar(255) NOT NULL,
  `department` int(11) DEFAULT NULL,
  `training_materials` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_sessions`
--

INSERT INTO `training_sessions` (`training_id`, `training_name`, `training_description`, `trainer`, `department`, `training_materials`, `created_at`) VALUES
(3, 'BASKETBALL', 'BRING YOUR OWN BALLPEN', 'LeBron James', 12, 'SAWADA', '2024-11-13 17:18:30'),
(4, 'VOLLEYBALL', 'VOLLEYBALL', 'ALYSSA VALDEZ', 11, 'VOLLEYBALL', '2024-11-13 17:41:38'),
(16, 'ASDFGH', 'ASDFGH', 'ASDFGH', 9, 'ASDFGH', '2025-04-01 09:18:44'),
(17, 'TEST TRAINING', 'TEST TRAINING', 'TEST TRAINER', 15, 'TEST TRAINING', '2025-04-05 09:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` enum('admin','employee','manager','superadmin','New Hire') NOT NULL DEFAULT 'admin',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastLogin` datetime DEFAULT current_timestamp(),
  `applicant_id` int(11) DEFAULT NULL,
  `onboarding_step` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `usertype`, `createdAt`, `lastLogin`, `applicant_id`, `onboarding_step`) VALUES
(4, 'employee', '$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq', 'employee', '2024-09-24 15:23:39', NULL, 43, 4),
(36, 'admin', '$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq', 'admin', '2024-11-13 15:45:50', '2024-11-13 00:00:00', 49, 4),
(39, 'manager', '$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq', 'manager', '2024-11-13 16:02:44', '2024-11-14 00:00:00', 44, 4),
(40, 'superadmin', '$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq', 'superadmin', '2025-01-26 03:14:16', '2025-01-26 11:14:16', 52, 4),
(41, 'nonteaching', '$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq', 'employee', '2025-01-26 03:14:16', '2025-01-26 11:14:16', 53, 4),
(42, 'teaching', '$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq', 'employee', '2025-01-26 03:14:16', '2025-01-26 11:14:16', 54, 4),
(43, 'bobbrown', '$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq', 'employee', '2025-01-26 03:14:16', '2025-01-26 11:14:16', 55, 4),
(44, 'charliedavis', '$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq', 'employee', '2025-01-26 03:14:16', '2025-01-26 11:14:16', 56, 4),
(45, 'dianaevans', '$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq', 'employee', '2025-01-26 03:14:16', '2025-01-26 11:14:16', 57, 4),
(46, 'ethanfoster', '$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq', 'employee', '2025-01-26 03:14:16', '2025-01-26 11:14:16', 58, 4),
(47, 'fionagreen', '$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq', 'employee', '2025-01-26 03:14:16', '2025-01-26 11:14:16', 59, 4),
(48, 'georgeharris', '$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq', 'employee', '2025-01-26 03:14:16', '2025-01-26 11:14:16', 60, 4),
(49, 'hannahivers', '$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq', 'employee', '2025-01-26 03:14:16', '2025-01-26 11:14:16', 61, 4),
(50, 'curry', '$2y$10$G2d9nlh.vONhotSaKED9t.7jQ7LKENxYEQDGuYJGmi6tvQUweveRe', 'employee', '2025-03-30 07:15:46', '2025-03-30 15:15:46', 51, 4),
(51, 'jeremy', '$2y$10$4p8IAOQXo3Vs9iL2Iqt4/uI/67YEK8JpN3Hl32efwJHG2UUhJ/yG2', 'employee', '2025-03-30 11:29:55', '2025-03-30 19:29:55', 67, 4),
(52, 'qwe', '$2y$10$pS3HTrwvopNbcGVQyML03.yJ9IFpn2Gpn9qOJVbD1.7IzBwuZiw4q', 'employee', '2025-03-30 11:38:56', '2025-03-30 19:38:56', 63, 4),
(53, '@Ap8080', '$2y$10$jfhjrRwAj/iV5m/FCC7RZOI1kg/6P6xGhH.e/naQntETMjb.wMRoW', 'employee', '2025-03-30 15:28:13', '2025-03-30 23:28:13', 68, 4),
(54, 'test', '$2y$10$f0fGjn9Dp5tPN/R4rTum8On18JYrqBxmcSGZQ7GIkFAvpMs/SMILW', 'employee', '2025-03-31 02:55:17', '2025-03-31 10:55:17', 50, 4),
(55, 'testapplicant', '$2y$10$8IL60mGl5.Jg9/881xDX2.9VxvuoXBeEHXtQhHuef7mCXQiRX7mce', 'employee', '2025-04-01 03:37:50', '2025-04-01 11:37:50', 69, 4),
(59, 'test3', '$2y$10$BPFqQOUSxltXeK7K.cqwh.gZd2XHtEFz3UUCOcRnyjxwzgQWrcZPu', 'employee', '2025-04-05 08:55:40', '2025-04-05 16:55:40', 70, 4),
(60, 'penpen', '$2y$10$SClvv0Bd9VAcEktm9pNps.AsZvcnB1MtbBvypSGm0g5iv1cy5/r8q', 'employee', '2025-04-05 09:16:57', '2025-04-05 17:16:57', 74, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `analyticsreports`
--
ALTER TABLE `analyticsreports`
  ADD PRIMARY KEY (`ReportID`);

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `FK_Applicants_DepartmentID` (`DepartmentID`);

--
-- Indexes for table `attendanceleave`
--
ALTER TABLE `attendanceleave`
  ADD PRIMARY KEY (`AttendanceID`),
  ADD KEY `FK_AttendanceLeave_EmployeeID` (`EmployeeID`);

--
-- Indexes for table `compensationbenefits`
--
ALTER TABLE `compensationbenefits`
  ADD PRIMARY KEY (`CompensationID`),
  ADD KEY `FK_CompensationBenefits_EmployeeID` (`EmployeeID`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`DepartmentID`),
  ADD KEY `FK_Departments_ManagerID` (`ManagerID`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `FK_Employees_UserID` (`UserID`);

--
-- Indexes for table `fm_bookings`
--
ALTER TABLE `fm_bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fm_resources`
--
ALTER TABLE `fm_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fm_resource_allocations`
--
ALTER TABLE `fm_resource_allocations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resource_id` (`resource_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `fm_resource_requests`
--
ALTER TABLE `fm_resource_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resource_id` (`resource_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `fm_rooms`
--
ALTER TABLE `fm_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobroles`
--
ALTER TABLE `jobroles`
  ADD PRIMARY KEY (`JobRoleID`),
  ADD KEY `FK_JobRoles_DepartmentID` (`DepartmentID`);

--
-- Indexes for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_JobPostings_DepartmentID` (`DepartmentID`),
  ADD KEY `fk_employee` (`EmployeeID`);

--
-- Indexes for table `performanceevaluations`
--
ALTER TABLE `performanceevaluations`
  ADD PRIMARY KEY (`EvaluationID`),
  ADD KEY `FK_PerformanceEvaluations_EmployeeID` (`EmployeeID`),
  ADD KEY `FK_PerformanceEvaluations_EvaluatorID` (`EvaluatorID`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `recruitment`
--
ALTER TABLE `recruitment`
  ADD PRIMARY KEY (`RecruitmentID`),
  ADD KEY `FK_Recruitment_JobRoleID` (`JobRoleID`),
  ADD KEY `FK_Recruitment_HiredEmployeeID` (`HiredEmployeeID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`RoleID`),
  ADD UNIQUE KEY `RoleName` (`RoleName`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `trainingprograms`
--
ALTER TABLE `trainingprograms`
  ADD PRIMARY KEY (`TrainingID`),
  ADD KEY `FK_TrainingPrograms_EmployeeID` (`EmployeeID`);

--
-- Indexes for table `training_applications`
--
ALTER TABLE `training_applications`
  ADD PRIMARY KEY (`application_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `training_id` (`training_id`);

--
-- Indexes for table `training_assignments`
--
ALTER TABLE `training_assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `fk_training_id` (`training_id`);

--
-- Indexes for table `training_grades`
--
ALTER TABLE `training_grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- Indexes for table `training_sessions`
--
ALTER TABLE `training_sessions`
  ADD PRIMARY KEY (`training_id`),
  ADD KEY `department` (`department`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Username` (`username`),
  ADD KEY `fk_applicant` (`applicant_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analyticsreports`
--
ALTER TABLE `analyticsreports`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `attendanceleave`
--
ALTER TABLE `attendanceleave`
  MODIFY `AttendanceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `compensationbenefits`
--
ALTER TABLE `compensationbenefits`
  MODIFY `CompensationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `DepartmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `fm_bookings`
--
ALTER TABLE `fm_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `fm_resources`
--
ALTER TABLE `fm_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `fm_resource_allocations`
--
ALTER TABLE `fm_resource_allocations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fm_resource_requests`
--
ALTER TABLE `fm_resource_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `fm_rooms`
--
ALTER TABLE `fm_rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `jobroles`
--
ALTER TABLE `jobroles`
  MODIFY `JobRoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `job_postings`
--
ALTER TABLE `job_postings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `performanceevaluations`
--
ALTER TABLE `performanceevaluations`
  MODIFY `EvaluationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `recruitment`
--
ALTER TABLE `recruitment`
  MODIFY `RecruitmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `trainingprograms`
--
ALTER TABLE `trainingprograms`
  MODIFY `TrainingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `training_applications`
--
ALTER TABLE `training_applications`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `training_assignments`
--
ALTER TABLE `training_assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `training_grades`
--
ALTER TABLE `training_grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `training_sessions`
--
ALTER TABLE `training_sessions`
  MODIFY `training_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `FK_Applicants_DepartmentID` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`DepartmentID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `applicants_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job_postings` (`id`);

--
-- Constraints for table `attendanceleave`
--
ALTER TABLE `attendanceleave`
  ADD CONSTRAINT `FK_AttendanceLeave_EmployeeID` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`);

--
-- Constraints for table `compensationbenefits`
--
ALTER TABLE `compensationbenefits`
  ADD CONSTRAINT `FK_CompensationBenefits_EmployeeID` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`);

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `FK_Departments_ManagerID` FOREIGN KEY (`ManagerID`) REFERENCES `employees` (`EmployeeID`);

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `FK_Employees_UserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`);

--
-- Constraints for table `fm_resource_allocations`
--
ALTER TABLE `fm_resource_allocations`
  ADD CONSTRAINT `fm_resource_allocations_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `fm_resources` (`id`),
  ADD CONSTRAINT `fm_resource_allocations_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `fm_resource_requests`
--
ALTER TABLE `fm_resource_requests`
  ADD CONSTRAINT `fm_resource_requests_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `fm_resources` (`id`),
  ADD CONSTRAINT `fm_resource_requests_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `jobroles`
--
ALTER TABLE `jobroles`
  ADD CONSTRAINT `FK_JobRoles_DepartmentID` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`DepartmentID`);

--
-- Constraints for table `job_postings`
--
ALTER TABLE `job_postings`
  ADD CONSTRAINT `FK_JobPostings_DepartmentID` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`DepartmentID`),
  ADD CONSTRAINT `fk_employee` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`);

--
-- Constraints for table `performanceevaluations`
--
ALTER TABLE `performanceevaluations`
  ADD CONSTRAINT `FK_PerformanceEvaluations_EmployeeID` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`),
  ADD CONSTRAINT `FK_PerformanceEvaluations_EvaluatorID` FOREIGN KEY (`EvaluatorID`) REFERENCES `employees` (`EmployeeID`);

--
-- Constraints for table `recruitment`
--
ALTER TABLE `recruitment`
  ADD CONSTRAINT `FK_Recruitment_HiredEmployeeID` FOREIGN KEY (`HiredEmployeeID`) REFERENCES `employees` (`EmployeeID`),
  ADD CONSTRAINT `FK_Recruitment_JobRoleID` FOREIGN KEY (`JobRoleID`) REFERENCES `jobroles` (`JobRoleID`);

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `fk_role_permissions` FOREIGN KEY (`role_id`) REFERENCES `roles` (`RoleID`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`RoleID`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `trainingprograms`
--
ALTER TABLE `trainingprograms`
  ADD CONSTRAINT `FK_TrainingPrograms_EmployeeID` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`);

--
-- Constraints for table `training_applications`
--
ALTER TABLE `training_applications`
  ADD CONSTRAINT `training_applications_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`EmployeeID`),
  ADD CONSTRAINT `training_applications_ibfk_2` FOREIGN KEY (`training_id`) REFERENCES `training_sessions` (`training_id`);

--
-- Constraints for table `training_assignments`
--
ALTER TABLE `training_assignments`
  ADD CONSTRAINT `fk_training_id` FOREIGN KEY (`training_id`) REFERENCES `training_sessions` (`training_id`),
  ADD CONSTRAINT `training_assignments_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`EmployeeID`);

--
-- Constraints for table `training_grades`
--
ALTER TABLE `training_grades`
  ADD CONSTRAINT `training_grades_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `training_assignments` (`assignment_id`);

--
-- Constraints for table `training_sessions`
--
ALTER TABLE `training_sessions`
  ADD CONSTRAINT `training_sessions_ibfk_1` FOREIGN KEY (`department`) REFERENCES `departments` (`DepartmentID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_applicant` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`RoleID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
