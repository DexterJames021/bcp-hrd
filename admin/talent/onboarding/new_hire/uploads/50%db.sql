/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 10.4.32-MariaDB : Database - bcp-hrd
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bcp-hrd` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `bcp-hrd`;

/*Table structure for table `analyticsreports` */

DROP TABLE IF EXISTS `analyticsreports`;

CREATE TABLE `analyticsreports` (
  `ReportID` int(11) NOT NULL AUTO_INCREMENT,
  `ReportName` varchar(100) NOT NULL,
  `GeneratedDate` date DEFAULT NULL,
  `ReportType` enum('Turnover','Compensation','Performance','Training') DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `FilePath` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ReportID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `analyticsreports` */

/*Table structure for table `applicants` */

DROP TABLE IF EXISTS `applicants`;

CREATE TABLE `applicants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `applicant_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Shortlisted','Interviewed','Hired','Rejected','Selected for Interview') DEFAULT 'Pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `interview_date` date DEFAULT NULL,
  `interview_time` time DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `job_id` (`job_id`),
  KEY `FK_Applicants_DepartmentID` (`DepartmentID`),
  CONSTRAINT `FK_Applicants_DepartmentID` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`DepartmentID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `applicants_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job_postings` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `applicants` */

insert  into `applicants`(`id`,`job_id`,`applicant_name`,`email`,`resume_path`,`status`,`applied_at`,`interview_date`,`interview_time`,`DepartmentID`) values 
(43,59,'SAWADA','apundarjeremy@gmail.com','uploads/resume/jere.txt','Pending','2024-11-13 18:51:07',NULL,NULL,9),
(44,57,'QWERTY','apundarjeremy@gmail.com','uploads/resume/jere.txt','Hired','2024-11-13 18:51:31','2024-11-13','22:15:00',8),
(48,59,'John Doe','apundarjeremy@gmail.com','uploads/resume/jere.txt','Pending','2024-11-13 21:57:58',NULL,NULL,9),
(49,60,'Kevin Durant','apundarjeremy@gmail.com','uploads/resume/jere.txt','Pending','2024-11-13 21:58:16',NULL,NULL,9),
(50,58,'LeBron James','apundarjeremy@gmail.com','uploads/resume/jere.txt','Pending','2024-11-13 21:58:39',NULL,NULL,8),
(51,57,'Steph Curry','apundarjeremy@gmail.com','uploads/resume/jere.txt','Pending','2024-11-13 21:59:12',NULL,NULL,8);

/*Table structure for table `attendanceleave` */

DROP TABLE IF EXISTS `attendanceleave`;

CREATE TABLE `attendanceleave` (
  `AttendanceID` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Status` enum('Present','Absent','Leave') DEFAULT NULL,
  `LeaveType` enum('Sick','Vacation','Personal','Unpaid') DEFAULT NULL,
  PRIMARY KEY (`AttendanceID`),
  KEY `FK_AttendanceLeave_EmployeeID` (`EmployeeID`),
  CONSTRAINT `FK_AttendanceLeave_EmployeeID` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `attendanceleave` */

/*Table structure for table `compensationbenefits` */

DROP TABLE IF EXISTS `compensationbenefits`;

CREATE TABLE `compensationbenefits` (
  `CompensationID` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeID` int(11) DEFAULT NULL,
  `BaseSalary` decimal(10,2) DEFAULT NULL,
  `Bonus` decimal(10,2) DEFAULT NULL,
  `BenefitType` enum('Health','Retirement','Stock Options','Other') DEFAULT NULL,
  `BenefitValue` decimal(10,2) DEFAULT NULL,
  `EffectiveDate` date DEFAULT NULL,
  PRIMARY KEY (`CompensationID`),
  KEY `FK_CompensationBenefits_EmployeeID` (`EmployeeID`),
  CONSTRAINT `FK_CompensationBenefits_EmployeeID` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `compensationbenefits` */

/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `DepartmentID` int(11) NOT NULL AUTO_INCREMENT,
  `DepartmentName` varchar(100) NOT NULL,
  `ManagerID` int(11) DEFAULT NULL,
  PRIMARY KEY (`DepartmentID`),
  KEY `FK_Departments_ManagerID` (`ManagerID`),
  CONSTRAINT `FK_Departments_ManagerID` FOREIGN KEY (`ManagerID`) REFERENCES `employees` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `departments` */

insert  into `departments`(`DepartmentID`,`DepartmentName`,`ManagerID`) values 
(8,'HR Department',NULL),
(9,'IT Department',NULL),
(10,'Finance and Accounting',NULL),
(11,'Facilities Management',NULL),
(12,'SAWADA',NULL);

/*Table structure for table `documents` */

DROP TABLE IF EXISTS `documents`;

CREATE TABLE `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `document_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `documents` */

insert  into `documents`(`id`,`user_id`,`document_name`,`file_path`,`uploaded_at`) values 
(19,39,'BOSS Q 1.txt','uploads/documents/BOSS Q 1.txt','2024-11-14 00:03:36');

/*Table structure for table `employees` */

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `employees` (
  `EmployeeID` int(11) NOT NULL AUTO_INCREMENT,
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
  `PolicyAgreed` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`EmployeeID`),
  UNIQUE KEY `Email` (`Email`),
  KEY `FK_Employees_UserID` (`UserID`),
  CONSTRAINT `FK_Employees_UserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `employees` */

insert  into `employees`(`EmployeeID`,`FirstName`,`LastName`,`Email`,`Phone`,`Address`,`DOB`,`HireDate`,`Salary`,`Status`,`UserID`,`PolicyAgreed`) values 
(44,'Jeremy','Apundar','apundarjeremy@gmail.com','09485234501','CSJDM','2024-11-14','2024-11-13',NULL,'Active',39,1);

/*Table structure for table `job_postings` */

DROP TABLE IF EXISTS `job_postings`;

CREATE TABLE `job_postings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(255) NOT NULL,
  `job_description` text NOT NULL,
  `requirements` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `salary_range` varchar(255) DEFAULT NULL,
  `status` enum('Open','Closed') DEFAULT 'Open',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `DepartmentID` int(11) DEFAULT NULL,
  `EmployeeID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_JobPostings_DepartmentID` (`DepartmentID`),
  KEY `fk_employee` (`EmployeeID`),
  CONSTRAINT `FK_JobPostings_DepartmentID` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`DepartmentID`),
  CONSTRAINT `fk_employee` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `job_postings` */

insert  into `job_postings`(`id`,`job_title`,`job_description`,`requirements`,`location`,`salary_range`,`status`,`created_at`,`DepartmentID`,`EmployeeID`) values 
(57,'HR Manager','Oversee the HR department and manage all HR functions, including recruitment, employee relations, training, and compliance.','Bachelor’s degree in Human Resources, Business Administration, or related field\r\n5+ years of HR experience, with at least 2 years in a management role\r\nStrong knowledge of labor laws and regulations.','Bestlink College of the Philippines','PHP 60,000 - PHP 100,000 per month.','Open','2024-11-02 19:05:54',8,NULL),
(58,'HR Coordinator','Assist in recruitment activities, onboarding of new hires, and maintaining employee records.\r\nSupport HR projects and initiatives, including training and employee engagement programs.','Bachelor’s degree in Human Resource Management or related field.\r\n1-3 years of HR experience.\r\nGood communication and organizational skills.','Bestlink College of the Philippines','PHP 25,000 - PHP 45,000 per month.','Open','2024-11-02 20:30:44',8,NULL),
(59,'Systems Administrator','Manage and maintain school servers, networks, and computer systems.\r\nEnsure system availability, security, and performance.','Bachelor’s degree in Computer Science, Information Technology, or related field.\r\n3-5 years of experience in systems administration.\r\nFamiliarity with server management and network protocols.','Bestlink College of the Philippines','PHP 30,000 - PHP 60,000 per month.','Open','2024-11-02 20:31:56',9,NULL),
(60,'Network Administrator','Configure, maintain, and troubleshoot the school\'s network infrastructure.\r\nMonitor network performance and security.','Bachelor’s degree in Information Technology, Network Engineering, or related field.\r\n3+ years of experience in network administration.\r\nKnowledge of network protocols, routers, and firewalls.','Bestlink College of the Philippines','PHP 30,000 - PHP 55,000 per month.','Open','2024-11-02 20:32:31',9,NULL),
(61,'Maintenance Supervisor','Supervise maintenance staff and coordinate repair and maintenance activities for the school.\r\nEnsure that all facilities are safe and comply with relevant regulations.','Diploma or Bachelor’s degree in Engineering, Facilities Management, or related field.\r\n3-5 years of experience in facilities maintenance.\r\nKnowledge of building systems (HVAC, electrical, plumbing).','Bestlink College of the Philippines','PHP 30,000 - PHP 60,000 per month.','Open','2024-11-02 20:34:00',11,NULL);

/*Table structure for table `jobroles` */

DROP TABLE IF EXISTS `jobroles`;

CREATE TABLE `jobroles` (
  `JobRoleID` int(11) NOT NULL AUTO_INCREMENT,
  `JobTitle` varchar(100) NOT NULL,
  `JobDescription` text DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `SalaryRangeMin` decimal(10,2) DEFAULT NULL,
  `SalaryRangeMax` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`JobRoleID`),
  KEY `FK_JobRoles_DepartmentID` (`DepartmentID`),
  CONSTRAINT `FK_JobRoles_DepartmentID` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`DepartmentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `jobroles` */

/*Table structure for table `performanceevaluations` */

DROP TABLE IF EXISTS `performanceevaluations`;

CREATE TABLE `performanceevaluations` (
  `EvaluationID` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeID` int(11) DEFAULT NULL,
  `EvaluationDate` date DEFAULT NULL,
  `EvaluatorID` int(11) DEFAULT NULL,
  `Score` int(11) DEFAULT NULL,
  `Comments` text DEFAULT NULL,
  `EvaluationType` enum('Annual','Quarterly','Monthly') DEFAULT NULL,
  PRIMARY KEY (`EvaluationID`),
  KEY `FK_PerformanceEvaluations_EmployeeID` (`EmployeeID`),
  KEY `FK_PerformanceEvaluations_EvaluatorID` (`EvaluatorID`),
  CONSTRAINT `FK_PerformanceEvaluations_EmployeeID` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`),
  CONSTRAINT `FK_PerformanceEvaluations_EvaluatorID` FOREIGN KEY (`EvaluatorID`) REFERENCES `employees` (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `performanceevaluations` */

/*Table structure for table `recruitment` */

DROP TABLE IF EXISTS `recruitment`;

CREATE TABLE `recruitment` (
  `RecruitmentID` int(11) NOT NULL AUTO_INCREMENT,
  `JobRoleID` int(11) DEFAULT NULL,
  `CandidateName` varchar(100) DEFAULT NULL,
  `InterviewDate` date DEFAULT NULL,
  `Status` enum('Applied','Interviewed','Offered','Rejected','Hired') DEFAULT NULL,
  `HiredEmployeeID` int(11) DEFAULT NULL,
  PRIMARY KEY (`RecruitmentID`),
  KEY `FK_Recruitment_JobRoleID` (`JobRoleID`),
  KEY `FK_Recruitment_HiredEmployeeID` (`HiredEmployeeID`),
  CONSTRAINT `FK_Recruitment_HiredEmployeeID` FOREIGN KEY (`HiredEmployeeID`) REFERENCES `employees` (`EmployeeID`),
  CONSTRAINT `FK_Recruitment_JobRoleID` FOREIGN KEY (`JobRoleID`) REFERENCES `jobroles` (`JobRoleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `recruitment` */

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `RoleID` int(11) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(50) NOT NULL,
  `Description` text DEFAULT NULL,
  PRIMARY KEY (`RoleID`),
  UNIQUE KEY `RoleName` (`RoleName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `roles` */

/*Table structure for table `training_assignments` */

DROP TABLE IF EXISTS `training_assignments`;

CREATE TABLE `training_assignments` (
  `assignment_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `status` enum('Not Started','In Progress','Completed') DEFAULT 'Not Started',
  `completion_date` date DEFAULT NULL,
  PRIMARY KEY (`assignment_id`),
  KEY `employee_id` (`employee_id`),
  KEY `fk_training_id` (`training_id`),
  CONSTRAINT `fk_training_id` FOREIGN KEY (`training_id`) REFERENCES `training_sessions` (`training_id`),
  CONSTRAINT `training_assignments_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `training_assignments` */

insert  into `training_assignments`(`assignment_id`,`training_id`,`employee_id`,`status`,`completion_date`) values 
(4,3,44,'Not Started','2024-11-16'),
(5,4,44,'Not Started','2024-11-16');

/*Table structure for table `training_sessions` */

DROP TABLE IF EXISTS `training_sessions`;

CREATE TABLE `training_sessions` (
  `training_id` int(11) NOT NULL AUTO_INCREMENT,
  `training_name` varchar(255) NOT NULL,
  `training_description` text NOT NULL,
  `trainer` varchar(255) NOT NULL,
  `department` int(11) DEFAULT NULL,
  `training_materials` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`training_id`),
  KEY `department` (`department`),
  CONSTRAINT `training_sessions_ibfk_1` FOREIGN KEY (`department`) REFERENCES `departments` (`DepartmentID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `training_sessions` */

insert  into `training_sessions`(`training_id`,`training_name`,`training_description`,`trainer`,`department`,`training_materials`,`created_at`) values 
(3,'BASKETBALL','BRING YOUR OWN BALLPEN','LeBron James',12,'SAWADA','2024-11-14 01:18:30'),
(4,'VOLLEYBALL','VOLLEYBALL','ALYSSA VALDEZ',11,'VOLLEYBALL','2024-11-14 01:41:38');

/*Table structure for table `trainingprograms` */

DROP TABLE IF EXISTS `trainingprograms`;

CREATE TABLE `trainingprograms` (
  `TrainingID` int(11) NOT NULL AUTO_INCREMENT,
  `TrainingName` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `Instructor` varchar(100) DEFAULT NULL,
  `EmployeeID` int(11) DEFAULT NULL,
  PRIMARY KEY (`TrainingID`),
  KEY `FK_TrainingPrograms_EmployeeID` (`EmployeeID`),
  CONSTRAINT `FK_TrainingPrograms_EmployeeID` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `trainingprograms` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` enum('admin','employee','New Hire') NOT NULL DEFAULT 'admin',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastLogin` date DEFAULT current_timestamp(),
  `applicant_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Username` (`username`),
  KEY `fk_applicant` (`applicant_id`),
  CONSTRAINT `fk_applicant` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`usertype`,`createdAt`,`lastLogin`,`applicant_id`) values 
(4,'employee','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','employee','2024-09-24 23:23:39',NULL,NULL),
(36,'admin','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','admin','2024-11-13 23:45:50','2024-11-13',NULL),
(39,'qwerty','$2y$10$BSgb2WfVAgx3xIKvW/Nb5uzPqbdp6bWtW/FZ5iHTqQUi30N1atNE.','employee','2024-11-14 00:02:44','2024-11-14',44);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
