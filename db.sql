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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `applicants` */

insert  into `applicants`(`id`,`job_id`,`applicant_name`,`email`,`resume_path`,`status`,`applied_at`,`interview_date`,`interview_time`,`DepartmentID`) values 
(12,44,'JEREMY APUNDAR','sawda@gmail.com','uploads/resume/hrcapstone.sql','Hired','2024-10-27 03:04:43','2024-10-28','03:06:00',NULL),
(13,44,'JEREMY APUNDAR','jeremy@gmail.com','uploads/resume/module.txt','Selected for Interview','2024-10-27 03:12:58',NULL,NULL,NULL),
(14,44,'JEREMY APUNDAR','jeremy2@gmail.com','uploads/resume/front end.txt','Pending','2024-10-27 03:13:06',NULL,NULL,NULL),
(15,46,'YEO REUM','yeoreum@gmail.com','uploads/resume/front end.txt','Hired','2024-10-30 00:12:11','2024-10-30','00:12:00',NULL),
(16,45,'fawadawdw','qwerty@AA','uploads/resume/human resource.pptx','Hired','2024-10-30 01:09:43','2024-11-03','02:10:00',NULL),
(17,46,'dep','dep@gmail.com','uploads/resume/front end.txt','Hired','2024-10-30 02:34:48','2024-10-30','02:37:00',3),
(18,46,'ENGKANTO','ENGKANTO@GMAIL.COM','uploads/resume/front end.txt','Pending','2024-10-30 02:35:05',NULL,NULL,3),
(19,46,'ENGKANTO','ENGKANTO@GMAIL.COM','uploads/resume/front end.txt','Pending','2024-10-30 02:35:17',NULL,NULL,3),
(20,46,'ENGKANTO','ENGKANTO@GMAIL.COM','uploads/resume/front end.txt','Pending','2024-10-30 02:35:20',NULL,NULL,3),
(21,46,'ENGKANTO','ENGKANTO@GMAIL.COM','uploads/resume/front end.txt','Pending','2024-10-30 02:36:30',NULL,NULL,3),
(22,46,'QWQWQ','QWQWQ@GMIAL.COM','uploads/resume/module.txt','Pending','2024-10-30 02:36:46',NULL,NULL,3);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `departments` */

insert  into `departments`(`DepartmentID`,`DepartmentName`,`ManagerID`) values 
(3,'IT DEPARTMENT',NULL),
(4,'jeremy dep',NULL),
(5,'ML DEPARTMENT',NULL),
(6,'MPL DEPARTMENT',NULL);

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
  `DepartmentID` int(11) NOT NULL,
  `Salary` decimal(10,2) DEFAULT NULL,
  `Status` enum('Active','Inactive','Terminated') DEFAULT 'Active',
  `UserID` int(11) DEFAULT NULL,
  `job_posting_id` int(11) NOT NULL,
  PRIMARY KEY (`EmployeeID`),
  UNIQUE KEY `Email` (`Email`),
  KEY `FK_Employees_DepartmentID` (`DepartmentID`),
  KEY `FK_Employees_UserID` (`UserID`),
  KEY `fk_job_posting` (`job_posting_id`),
  CONSTRAINT `FK_Employees_UserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `employees` */

insert  into `employees`(`EmployeeID`,`FirstName`,`LastName`,`Email`,`Phone`,`Address`,`DOB`,`HireDate`,`DepartmentID`,`Salary`,`Status`,`UserID`,`job_posting_id`) values 
(18,'Jeremy','Apundar','apundarjeremy@gmail.com','0987654321','fafasfasfa','2024-10-30','2024-10-30',0,NULL,'Active',24,0);

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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `job_postings` */

insert  into `job_postings`(`id`,`job_title`,`job_description`,`requirements`,`location`,`salary_range`,`status`,`created_at`,`DepartmentID`,`EmployeeID`) values 
(44,'DepartmentID','DepartmentID','DepartmentID','DepartmentID','₱25,000 - ₱30,000','Open','2024-10-27 00:53:07',3,NULL),
(45,'JEREMY','JEREMY','JEREMY','JEREMY','₱25,000 - ₱30,000','Open','2024-10-27 01:01:22',4,NULL),
(46,'SAWASAda','SAWASAda SAWASAda SAWASAda SAWASAda SAWASAda SAWASAda SAWASAda SAWASAdaSAWASAda V','SAWASAda SAWASAda','SAWASAda','2000-1000','Open','2024-10-27 01:01:47',3,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`usertype`,`createdAt`,`lastLogin`,`applicant_id`) values 
(1,'jdoe','hashed_password1','admin','2024-09-24 23:23:39',NULL,NULL),
(2,'jsmith','hashed_password2','employee','2024-09-24 23:23:39',NULL,NULL),
(3,'mjohnson','hashed_password3','admin','2024-09-24 23:23:39',NULL,NULL),
(4,'employee','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','employee','2024-09-24 23:23:39',NULL,NULL),
(5,'admin','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','admin','0000-00-00 00:00:00','0000-00-00',NULL),
(7,'Apundar','$2y$10$SG1Fqttxyp5c44F7GzPeXOuQZ0ExMV4qQrj5r4EU3Rh0KrQv7RSuO','','2024-10-27 04:29:09','2024-10-27',NULL),
(9,'jeremy','$2y$10$8tklV3XazwRV0JM4/u0zWOEtjL79pubMj2VvzKeFyaT3VUclmNV4a','New Hire','2024-10-27 04:30:36','2024-10-27',NULL),
(11,'s21020053','$2y$10$Qrh5rBD2FGtHSAu.i7qgLuOlobQrEUntyqXioiRKZtd7DjSiljTVa','admin','2024-10-27 04:41:48','2024-10-27',NULL),
(13,'12345','$2y$10$kvXTZOorbc9Pxo1Cc8CPUu3ERwvnnLQ0Rnxx8M/vIbT07.Q3dD4.e','New Hire','2024-10-27 04:43:29','2024-10-27',NULL),
(14,'123456','$2y$10$XC98hLQN5K5Pcflnrh5Ojulgii5pwXDVUnpMDe3CyV9XCQh70PmXG','New Hire','2024-10-27 04:55:46','2024-10-27',NULL),
(15,'admin1234','$2y$10$p4ol.3yxpk7KQKbr6IYLtO50hZFTIqlzl6RxvUwhjTb03dcquF3nC','admin','2024-10-27 04:57:38','2024-10-27',NULL),
(16,'yeoreum','$2y$10$Z/RM.mkY9BZhBw7lsbUJtOpAQOODUHc.G0HyOZlJdJ7MnrD2vkpXi','New Hire','2024-10-30 00:13:06','2024-10-30',15),
(17,'admin31','$2y$10$mZFN0aKNooHH3ByLVhFHD.cjSjtloDjzNPMEUg113sooz6RV0K9w6','New Hire','2024-10-30 00:20:32','2024-10-30',15),
(22,'jj','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','New Hire','2024-10-30 01:01:09','2024-10-30',12),
(23,'qwerty','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','admin','2024-10-30 01:10:32','2024-10-30',16),
(24,'rere','$2y$10$aHoRmcHn3jQOMku6AWqhOecOjuHPkf0WZyABsC6/BXYaK5mwMz37a','New Hire','2024-10-30 02:38:34','2024-10-30',17);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
