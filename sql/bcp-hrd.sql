-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 11:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

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
(44, 57, 'QWERTY', 'apundarjeremy@gmail.com', 'uploads/resume/jere.txt', 'Hired', '2024-11-13 10:51:31', '2024-11-13', '22:15:00', 9),
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
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(50) NOT NULL,
  `employeeId` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `day` varchar(50) NOT NULL,
  `timeIn` time(3) NOT NULL,
  `timeOut` time(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employeeId`, `name`, `department`, `date`, `day`, `timeIn`, `timeOut`) VALUES
(1, '1', 'John Doe', 'Faculty', '2024-10-01', 'Tuesday', '08:00:00.000', '17:00:00.000'),
(2, '2', 'Jane Smith', 'Faculty', '2024-10-02', 'Wednesday', '08:15:00.000', '17:15:00.000'),
(3, '3', 'Michael Johnson', 'Faculty', '2024-10-03', 'Thursday', '09:00:00.000', '18:00:00.000'),
(4, '4', 'Emily Davis', 'Faculty', '2024-10-04', 'Friday', '08:30:00.000', '17:30:00.000'),
(5, '5', 'Chris Lee', 'Faculty', '2024-10-05', 'Saturday', '08:45:00.000', '17:45:00.000'),
(6, '6', 'Sara Wilson', 'Faculty', '2024-10-06', 'Sunday', '08:50:00.000', '17:50:00.000'),
(7, '7', 'James Brown', 'Faculty', '2024-10-07', 'Monday', '09:10:00.000', '18:10:00.000'),
(8, '8', 'Laura White', 'Faculty', '2024-10-08', 'Tuesday', '08:20:00.000', '17:20:00.000'),
(9, '9', 'Kevin Harris', 'Faculty', '2024-10-09', 'Wednesday', '08:05:00.000', '17:05:00.000'),
(10, '10', 'Olivia Moore', 'Faculty', '2024-10-10', 'Thursday', '08:40:00.000', '17:40:00.000'),
(11, '1', 'John Doe', 'Faculty', '2024-10-11', 'Friday', '08:05:00.000', '17:05:00.000'),
(12, '2', 'Jane Smith', 'Faculty', '2024-10-12', 'Saturday', '08:20:00.000', '17:20:00.000'),
(13, '3', 'Michael Johnson', 'Faculty', '2024-10-13', 'Sunday', '09:10:00.000', '18:10:00.000'),
(14, '4', 'Emily Davis', 'Faculty', '2024-10-14', 'Monday', '08:35:00.000', '17:35:00.000'),
(15, '5', 'Chris Lee', 'Faculty', '2024-10-15', 'Tuesday', '08:50:00.000', '17:50:00.000'),
(16, '6', 'Sara Wilson', 'Faculty', '2024-10-16', 'Wednesday', '09:00:00.000', '18:00:00.000'),
(17, '7', 'James Brown', 'Faculty', '2024-10-17', 'Thursday', '08:45:00.000', '17:45:00.000'),
(18, '8', 'Laura White', 'Faculty', '2024-10-18', 'Friday', '08:30:00.000', '17:30:00.000'),
(19, '9', 'Kevin Harris', 'Faculty', '2024-10-19', 'Saturday', '08:15:00.000', '17:15:00.000'),
(20, '10', 'Olivia Moore', 'Faculty', '2024-10-20', 'Sunday', '08:40:00.000', '17:40:00.000'),
(21, '1', 'John Doe', 'Faculty', '2024-10-21', 'Monday', '08:10:00.000', '17:10:00.000'),
(22, '2', 'Jane Smith', 'Faculty', '2024-10-22', 'Tuesday', '08:25:00.000', '17:25:00.000'),
(23, '3', 'Michael Johnson', 'Faculty', '2024-10-23', 'Wednesday', '09:05:00.000', '18:05:00.000'),
(24, '4', 'Emily Davis', 'Faculty', '2024-10-24', 'Thursday', '08:40:00.000', '17:40:00.000'),
(25, '5', 'Chris Lee', 'Faculty', '2024-10-25', 'Friday', '08:55:00.000', '17:55:00.000'),
(26, '6', 'Sara Wilson', 'Faculty', '2024-10-26', 'Saturday', '09:05:00.000', '18:05:00.000'),
(27, '7', 'James Brown', 'Faculty', '2024-10-27', 'Sunday', '08:35:00.000', '17:35:00.000'),
(28, '8', 'Laura White', 'Faculty', '2024-10-28', 'Monday', '08:15:00.000', '17:15:00.000'),
(29, '9', 'Kevin Harris', 'Faculty', '2024-10-29', 'Tuesday', '08:50:00.000', '17:50:00.000'),
(30, '10', 'Olivia Moore', 'Faculty', '2024-10-30', 'Wednesday', '08:25:00.000', '17:25:00.000');

-- --------------------------------------------------------

--
-- Table structure for table `attendanceleave`
--

CREATE TABLE `attendanceleave` (
  `AttendanceID` int(11) NOT NULL,
  `EmployeeID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Status` enum('Present','Absent','Leave') DEFAULT NULL,
  `LeaveType` enum('Sick','Vacation','Personal','Unpaid') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `average_rates`
--

CREATE TABLE `average_rates` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `min_salary` decimal(10,2) NOT NULL,
  `max_salary` decimal(10,2) NOT NULL,
  `position` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `average_rates`
--

INSERT INTO `average_rates` (`id`, `date`, `min_salary`, `max_salary`, `position`) VALUES
(1, '2024-01-01', 50000.00, 70000.00, 'ASD'),
(2, '2024-01-01', 60000.00, 85000.00, 'Associate Professor'),
(3, '2024-01-01', 80000.00, 120000.00, 'Professor'),
(4, '2024-01-01', 45000.00, 65000.00, 'Lecturer'),
(5, '2024-01-01', 55000.00, 75000.00, 'Senior Lecturer'),
(6, '2024-01-01', 50000.00, 72000.00, 'Research Fellow'),
(7, '2024-01-01', 62000.00, 88000.00, 'Assistant Dean'),
(8, '2024-01-01', 70000.00, 100000.00, 'Dean'),
(9, '2024-01-01', 52000.00, 77000.00, 'Postdoctoral Researcher'),
(10, '2024-01-01', 40000.00, 60000.00, 'Teaching Assistant'),
(11, '2025-04-05', 50000.00, 80000.00, 'Professor'),
(12, '2025-04-04', 52000.00, 85000.00, 'Professor'),
(13, '2025-04-03', 48000.00, 78000.00, 'Professor'),
(14, '2025-04-02', 51000.00, 82000.00, 'Professor'),
(15, '2025-04-01', 49500.00, 80500.00, 'Professor'),
(16, '2025-04-04', 8000.00, 11000.00, 'Professor');

-- --------------------------------------------------------

--
-- Table structure for table `compensationbenefits`
--

CREATE TABLE `compensationbenefits` (
  `CompensationID` int(11) NOT NULL,
  `EmployeeID` int(11) DEFAULT NULL,
  `BaseSalary` decimal(10,2) DEFAULT NULL,
  `Bonus` decimal(10,2) DEFAULT NULL,
  `BenefitType` enum('Health','Retirement','Stock Options','Other') DEFAULT NULL,
  `BenefitValue` decimal(10,2) DEFAULT NULL,
  `EffectiveDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deduction`
--

CREATE TABLE `deduction` (
  `id` int(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` decimal(50,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deduction`
--

INSERT INTO `deduction` (`id`, `type`, `amount`) VALUES
(1, 'SSS', 4),
(2, 'Pag-ibig', 2),
(3, 'Philhealth', 5);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

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
-- Table structure for table `employees`
--

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
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `id` int(11) NOT NULL,
  `holiday` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`id`, `holiday`, `type`, `date`) VALUES
(2, 'Maundy Thursday', 'Regular', '2025-04-17'),
(3, 'Good Friday', 'Regular', '2025-04-18'),
(4, 'Araw ng Kagitingan', 'Regular', '2025-04-09'),
(5, 'Labor Day', 'Regular', '2025-05-01'),
(6, 'Independence Day', 'Regular', '2025-06-12'),
(7, 'National Heroes Day', 'Regular', '2025-08-25'),
(8, 'Bonifacio Day', 'Regular', '2025-11-30'),
(9, 'Christmas Day', 'Regular', '2025-12-25'),
(10, 'Rizal Day', 'Regular', '2025-12-30'),
(11, 'Chinese New Year', 'Non-working', '2025-01-29'),
(12, 'EDSA People Power Revolution Anniversary', 'Non-working', '2025-02-25'),
(13, 'Black Saturday', 'Non-working', '2025-04-19'),
(14, 'Ninoy Aquino Day', 'Non-working', '2025-08-21'),
(15, 'All Saints\' Day', 'Non-working', '2025-11-01'),
(16, 'Feast of the Immaculate Conception of Mary', 'Non-working', '2025-12-08'),
(17, 'Christmas Eve', 'Non-working', '2025-12-24'),
(18, 'New Year\'s Eve', 'Non-working', '2025-12-31'),
(19, 'New Year', 'Regular', '2025-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `incentives`
--

CREATE TABLE `incentives` (
  `id` int(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incentives`
--

INSERT INTO `incentives` (`id`, `type`, `amount`) VALUES
(1, 'Bonus', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `jobroles`
--

CREATE TABLE `jobroles` (
  `JobRoleID` int(11) NOT NULL,
  `JobTitle` varchar(100) NOT NULL,
  `JobDescription` text DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `SalaryRangeMin` decimal(10,2) DEFAULT NULL,
  `SalaryRangeMax` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

CREATE TABLE `job_postings` (
  `id` int(11) NOT NULL,
  `job_title` varchar(255) NOT NULL,
  `job_description` text NOT NULL,
  `requirements` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `salary_range` varchar(255) DEFAULT NULL,
  `status` enum('Open','Closed') DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`id`, `job_title`, `job_description`, `requirements`, `location`, `salary_range`, `status`, `created_at`) VALUES
(31, 'HR Coordinator', 'jeremy', 'awdw', 'asdsadsa', '122312asdsad', 'Open', '2024-10-19 13:35:50'),
(38, 'sadwada', 'da', 'adw', 'awdwada', 'wdwda', 'Open', '2024-10-20 16:51:53'),
(39, 'awd12312', '123', '12321312', '3213', '213123123', 'Open', '2024-10-20 16:52:42');

-- --------------------------------------------------------

--
-- Table structure for table `leaveapplication`
--

CREATE TABLE `leaveapplication` (
  `id` int(50) NOT NULL,
  `employeeId` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `department` varchar(50) NOT NULL,
  `message` varchar(250) NOT NULL,
  `status` varchar(255) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaveapplication`
--

INSERT INTO `leaveapplication` (`id`, `employeeId`, `name`, `leave_type`, `date`, `department`, `message`, `status`) VALUES
(1, 4, 'employee', 'Maternity Leave', '2025-04-16', '', 'asdas', 'pending'),
(2, 4, 'employee', 'Casual Leave', '2025-04-29', '', 'asdasdas', 'pending'),
(3, 4, 'employee', 'Casual Leave', '2025-04-18', '', 'dasd', 'pending'),
(4, 2, 'jsmith', 'Paternity Leave', '2025-04-26', 'Computer Studies', 'asdasdas', 'accepted'),
(5, 4, 'employee', 'Maternity Leave', '2025-04-18', '', 'poiuy', 'pending'),
(9, 2, 'jsmith', 'Unpaid Leave', '2025-05-01', 'Computer Studies', 'tydfhjshg', 'pending'),
(16, 4, 'SAWADA', 'Study Leave', '2025-04-23', 'IT Department', '3', 'pending'),
(17, 4, 'SAWADA', 'Bereavement Leave', '2025-04-26', 'IT Department', '4', 'pending'),
(18, 4, 'SAWADA', 'Medical Leave', '2025-04-13', 'IT Department', '5', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `leavetype`
--

CREATE TABLE `leavetype` (
  `id` int(50) NOT NULL,
  `leave_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leavetype`
--

INSERT INTO `leavetype` (`id`, `leave_type`) VALUES
(1, 'Sick Leave'),
(2, 'Casual Leave'),
(3, 'Annual Leave'),
(4, 'Maternity Leave'),
(5, 'Paternity Leave'),
(6, 'Unpaid Leave'),
(7, 'Bereavement Leave'),
(8, 'Study Leave'),
(9, 'Compensatory Leave'),
(10, 'Medical Leave');

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL,
  `employeeId` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `department` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `head` varchar(100) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `employeeId`, `name`, `leave_type`, `date`, `department`, `message`, `head`, `status`) VALUES
(1, 7, 'Lebron James', 'Annual Leave', '2025-04-11', '', 'asd', 'Lebron James', 'pending'),
(2, 7, 'Lebron James', 'Annual Leave', '2025-04-11', '', 'asd', 'Lebron James', 'pending'),
(3, 7, 'Lebron James', 'Maternity Leave', '2025-04-25', 'Computer Studies', 'dsasd', 'Lebron James', 'pending'),
(4, 7, 'Lebron James', 'Bereavement Leave', '2025-04-25', 'Computer Studies', 'das', 'Lebron James', 'pending'),
(5, 2, 'jsmith', 'Medical Leave', '2025-04-12', 'Computer Studies', 'dasads', 'jsmith', 'pending'),
(6, 2, 'jsmith', 'Annual Leave', '2025-04-23', 'Computer Studies', '1234556', 'jsmith', 'pending'),
(7, 2, 'jsmith', 'Study Leave', '2025-04-11', 'Computer Studies', 'lkjklhkjgj', 'Lebron James', 'pending'),
(8, 4, 'SAWADA', 'Casual Leave', '2025-04-04', 'IT Department', '123333', 'SAWADA', 'approved'),
(9, 4, 'SAWADA', 'Bereavement Leave', '2025-04-05', 'IT Department', '09090909', 'SAWADA', ''),
(10, 4, 'SAWADA', 'Annual Leave', '2025-04-24', 'IT Department', '\\]\\]\\\\]\\]\\', 'SAWADA', ''),
(11, 4, 'SAWADA', 'Unpaid Leave', '2025-04-30', 'IT Department', 'LEAVE', 'SAWADA', 'pending'),
(12, 44, 'QWERTY', 'Annual Leave', '2025-04-04', 'IT Department', 'leave123', 'QWERTY', 'pending'),
(13, 4, 'SAWADA', 'Annual Leave', '2025-04-18', 'IT Department', '1', 'manager', 'pending'),
(14, 4, 'SAWADA', 'Bereavement Leave', '2025-04-25', 'IT Department', '2', 'QWERTY', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `performanceevaluations`
--

CREATE TABLE `performanceevaluations` (
  `EvaluationID` int(11) NOT NULL,
  `EmployeeID` int(11) DEFAULT NULL,
  `EvaluationDate` date DEFAULT NULL,
  `EvaluatorID` int(11) DEFAULT NULL,
  `Score` int(11) DEFAULT NULL,
  `Comments` text DEFAULT NULL,
  `EvaluationType` enum('Annual','Quarterly','Monthly') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE `rate` (
  `id` int(50) NOT NULL,
  `employeeId` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `rate` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rate`
--

INSERT INTO `rate` (`id`, `employeeId`, `name`, `department`, `rate`) VALUES
(1, 1, 'John Doe', 'Faculty', 150),
(2, 2, 'Jane Smith', 'Faculty', 130),
(3, 3, 'Michael Johnson', 'Faculty', 180),
(4, 4, 'Emily Davis', 'Faculty', 140),
(5, 5, 'Chris Lee', 'Faculty', 160),
(6, 6, 'Sara Wilson', 'Faculty', 170),
(7, 7, 'James Brown', 'Faculty', 120),
(8, 8, 'Laura White', 'Faculty', 175),
(9, 9, 'Kevin Harris', 'Faculty', 145),
(10, 10, 'Olivia Moore', 'Faculty', 180);

-- --------------------------------------------------------

--
-- Table structure for table `recruitment`
--

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

CREATE TABLE `roles` (
  `RoleID` int(11) NOT NULL,
  `RoleName` varchar(50) NOT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trainingprograms`
--

CREATE TABLE `trainingprograms` (
  `TrainingID` int(11) NOT NULL,
  `TrainingName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `Instructor` varchar(100) DEFAULT NULL,
  `EmployeeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

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
(4, 'employee', 'employee123', 'employee', '2024-09-24 15:23:39', NULL, 43, 4),
(36, 'admin', 'admin123', 'admin', '2024-11-13 15:45:50', '2024-11-13 00:00:00', 49, 4),
(39, 'manager', 'manager123', 'manager', '2024-11-13 16:02:44', '2024-11-14 00:00:00', 44, 4),
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
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendanceleave`
--
ALTER TABLE `attendanceleave`
  ADD PRIMARY KEY (`AttendanceID`),
  ADD KEY `FK_AttendanceLeave_EmployeeID` (`EmployeeID`);

--
-- Indexes for table `average_rates`
--
ALTER TABLE `average_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `compensationbenefits`
--
ALTER TABLE `compensationbenefits`
  ADD PRIMARY KEY (`CompensationID`),
  ADD KEY `FK_CompensationBenefits_EmployeeID` (`EmployeeID`);

--
-- Indexes for table `deduction`
--
ALTER TABLE `deduction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`DepartmentID`),
  ADD KEY `FK_Departments_ManagerID` (`ManagerID`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `FK_Employees_UserID` (`UserID`);

--
-- Indexes for table `incentives`
--
ALTER TABLE `incentives`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `performanceevaluations`
--
ALTER TABLE `performanceevaluations`
  ADD PRIMARY KEY (`EvaluationID`),
  ADD KEY `FK_PerformanceEvaluations_EmployeeID` (`EmployeeID`),
  ADD KEY `FK_PerformanceEvaluations_EvaluatorID` (`EvaluatorID`);

--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `trainingprograms`
--
ALTER TABLE `trainingprograms`
  ADD PRIMARY KEY (`TrainingID`),
  ADD KEY `FK_TrainingPrograms_EmployeeID` (`EmployeeID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Username` (`username`),
  ADD KEY `fk_applicant` (`applicant_id`);

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
-- AUTO_INCREMENT for table `average_rates`
--
ALTER TABLE `average_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `DepartmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `incentives`
--
ALTER TABLE `incentives`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `FK_Departments_ManagerID` FOREIGN KEY (`ManagerID`) REFERENCES `employees` (`EmployeeID`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `FK_Employees_UserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_applicant` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
