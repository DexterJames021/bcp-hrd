-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2024 at 05:23 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

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
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `DepartmentID` int(11) NOT NULL,
  `DepartmentName` varchar(100) NOT NULL,
  `ManagerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `DepartmentID` int(11) DEFAULT NULL,
  `JobRoleID` int(11) DEFAULT NULL,
  `Salary` decimal(10,2) DEFAULT NULL,
  `ManagerID` int(11) DEFAULT NULL,
  `Status` enum('Active','Inactive','Terminated') DEFAULT 'Active',
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `usertype` varchar(255) NOT NULL DEFAULT 'admin',
  `email` varchar(100) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastLogin` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `usertype`, `email`, `createdAt`, `lastLogin`) VALUES
(1, 'jdoe', 'hashed_password1', 'admin', 'johndoe@example.com', '2024-09-24 15:23:39', NULL),
(2, 'jsmith', 'hashed_password2', 'employee', 'janesmith@example.com', '2024-09-24 15:23:39', NULL),
(3, 'mjohnson', 'hashed_password3', 'admin', 'mikejohnson@example.com', '2024-09-24 15:23:39', NULL),
(4, 'employee', 'employee123', 'employee', 'saralee@example.com', '2024-09-24 15:23:39', NULL),
(5, 'admin', 'admin123', 'admin', 'admin@gmail.com', '0000-00-00 00:00:00', '0000-00-00');

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `TaskID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(255) NOT NULL,
  `Description` text DEFAULT NULL,
  `UserID` int(11) NOT NULL,
  `Status` enum('Pending','In Progress','Completed') NOT NULL DEFAULT 'Pending',
  `CreatedDate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`TaskID`),
  KEY `FK_Tasks_UserID` (`UserID`),
  CONSTRAINT `FK_Tasks_UserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`)
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
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`EmployeeID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `FK_Employees_DepartmentID` (`DepartmentID`),
  ADD KEY `FK_Employees_JobRoleID` (`JobRoleID`),
  ADD KEY `FK_Employees_ManagerID` (`ManagerID`),
  ADD KEY `FK_Employees_UserID` (`UserID`);

--
-- Indexes for table `jobroles`
--
ALTER TABLE `jobroles`
  ADD PRIMARY KEY (`JobRoleID`),
  ADD KEY `FK_JobRoles_DepartmentID` (`DepartmentID`);

--
-- Indexes for table `performanceevaluations`
--
ALTER TABLE `performanceevaluations`
  ADD PRIMARY KEY (`EvaluationID`),
  ADD KEY `FK_PerformanceEvaluations_EmployeeID` (`EmployeeID`),
  ADD KEY `FK_PerformanceEvaluations_EvaluatorID` (`EvaluatorID`);

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
  ADD UNIQUE KEY `Email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analyticsreports`
--
ALTER TABLE `analyticsreports`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendanceleave`
--
ALTER TABLE `attendanceleave`
  MODIFY `AttendanceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compensationbenefits`
--
ALTER TABLE `compensationbenefits`
  MODIFY `CompensationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `DepartmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `EmployeeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobroles`
--
ALTER TABLE `jobroles`
  MODIFY `JobRoleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performanceevaluations`
--
ALTER TABLE `performanceevaluations`
  MODIFY `EvaluationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recruitment`
--
ALTER TABLE `recruitment`
  MODIFY `RecruitmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trainingprograms`
--
ALTER TABLE `trainingprograms`
  MODIFY `TrainingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

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
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `FK_Employees_DepartmentID` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`DepartmentID`),
  ADD CONSTRAINT `FK_Employees_JobRoleID` FOREIGN KEY (`JobRoleID`) REFERENCES `jobroles` (`JobRoleID`),
  ADD CONSTRAINT `FK_Employees_ManagerID` FOREIGN KEY (`ManagerID`) REFERENCES `employees` (`EmployeeID`),
  ADD CONSTRAINT `FK_Employees_UserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`);

--
-- Constraints for table `jobroles`
--
ALTER TABLE `jobroles`
  ADD CONSTRAINT `FK_JobRoles_DepartmentID` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`DepartmentID`);

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
-- Constraints for table `trainingprograms`
--
ALTER TABLE `trainingprograms`
  ADD CONSTRAINT `FK_TrainingPrograms_EmployeeID` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
