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
  `status` enum('Pending','Shortlisted','Interviewed','Hired','Rejected','Selected for Interview','Document Submission','Background Check') DEFAULT 'Pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `interview_date` date DEFAULT NULL,
  `interview_time` time DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `job_id` (`job_id`),
  KEY `FK_Applicants_DepartmentID` (`DepartmentID`),
  CONSTRAINT `FK_Applicants_DepartmentID` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`DepartmentID`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `applicants_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `job_postings` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `applicants` */

insert  into `applicants`(`id`,`job_id`,`applicant_name`,`email`,`resume_path`,`status`,`applied_at`,`interview_date`,`interview_time`,`DepartmentID`) values 
(43,59,'SAWADA','apundarjeremy@gmail.com','uploads/resume/jere.txt','Hired','2024-11-14 02:51:07',NULL,NULL,9),
(44,57,'QWERTY','apundarjeremy@gmail.com','uploads/resume/jere.txt','Hired','2024-11-14 02:51:31','2024-11-13','22:15:00',8),
(49,60,'Kevin Durant','apundarjeremy@gmail.com','uploads/resume/jere.txt','Hired','2024-11-14 05:58:16',NULL,NULL,9),
(50,58,'LeBron James','apundarjeremy@gmail.com','uploads/resume/jere.txt','Hired','2024-11-14 05:58:39','2025-03-30','17:39:00',8),
(51,57,'Steph Curry','apundarjeremy@gmail.com','uploads/resume/jere.txt','Hired','2024-11-14 05:59:12','2025-03-30','15:11:00',8),
(52,62,'John Doe','johndoe@example.com','uploads/resume/johndoe.txt','Rejected','2025-01-26 19:14:16',NULL,NULL,9),
(53,63,'Jane Smith','janesmith@example.com','uploads/resume/janesmith.txt','Rejected','2025-01-26 19:14:16',NULL,NULL,8),
(54,64,'Alice Johnson','alicejohnson@example.com','uploads/resume/alicejohnson.txt','Hired','2025-01-26 19:14:16','2025-03-30','16:19:00',9),
(55,65,'Bob Brown','bobbrown@example.com','uploads/resume/bobbrown.txt','Rejected','2025-01-26 19:14:16','2025-03-30','16:29:00',10),
(56,66,'Charlie Davis','charliedavis@example.com','uploads/resume/charliedavis.txt','Hired','2025-01-26 19:14:16','2025-04-01','22:42:00',9),
(57,67,'Diana Evans','dianaevans@example.com','uploads/resume/dianaevans.txt','Hired','2025-01-26 19:14:16','2025-04-01','22:43:00',11),
(58,68,'Ethan Foster','ethanfoster@example.com','uploads/resume/ethanfoster.txt','Interviewed','2025-01-26 19:14:16','2025-04-27','20:51:00',12),
(59,69,'Fiona Green','fionagreen@example.com','uploads/resume/fionagreen.txt','Hired','2025-01-26 19:14:16','2025-03-30','16:45:00',10),
(60,70,'George Harris','georgeharris@example.com','uploads/resume/georgeharris.txt','Pending','2025-01-26 19:14:16',NULL,NULL,9),
(61,71,'Hannah Ivers','hannahivers@example.com','uploads/resume/hannahivers.txt','Pending','2025-01-26 19:14:16',NULL,NULL,8),
(62,58,'test','test@gmail.com','uploads/resume/dexter-schoolresume.docx','Hired','2025-03-27 04:28:46','2025-04-01','22:45:00',8),
(63,58,'qwe','qwe@masd.com','uploads/resume/internship-memorandum-of-agreement-between-student-and-company.docx','Hired','2025-03-27 04:47:03','2025-03-30','19:38:00',8),
(67,67,'JEREMY','apundarjeremy@gmail.com','uploads/resume/RESUME-FOR-OJT-JA.docx','Hired','2025-03-31 03:20:28','2025-03-30','19:28:00',11),
(68,65,'Jeremy Apundar','apundarjeremy@gmail.com','uploads/resume/RESUME-FOR-OJT-JA.docx','Hired','2025-03-31 07:26:23','2025-03-30','23:27:00',10),
(69,72,'test applicant','apundarjeremy@gmail.com','uploads/resume/GMAIL-ACC.txt','Hired','2025-04-01 19:35:48','2025-04-01','11:36:00',15),
(70,63,'test3','test3@gmail.com','uploads/resume/ACCOUNT-1.txt','Hired','2025-04-02 06:51:18','2025-04-01','23:14:00',8),
(71,62,'applicant1','apundarjeremy@gmail.com','uploads/resume/Aljhon Resume.docx','Hired','2025-04-06 00:33:23','2025-04-27','20:14:00',9),
(72,66,'Penpen ','apundarjeremy@gmail.com','uploads/resume/Aljhon Resume.docx','Hired','2025-04-06 00:43:42','2025-04-06','13:00:00',9),
(74,74,'PENPEN','apundarjeremy@gmail.com','uploads/resume/Aljhon Resume.docx','Hired','2025-04-06 01:14:53','2025-04-06','13:15:00',15),
(80,78,'Apundar, Jeremy','apundarjeremy@gmail.com','uploads/verify/bcp logo.png','Hired','2025-04-27 23:51:34','2025-04-27','21:27:00',10),
(81,62,'Apundar','apundarjeremy@gmail.com','uploads/verify/bcp logo.png','Hired','2025-04-28 05:55:07','2025-04-28','16:47:00',9),
(82,64,'TRYYY','apundarjeremy@gmail.com','uploads/verify/bcp logo.png','Hired','2025-04-28 09:28:47','2025-04-28','09:32:00',9);

/*Table structure for table `attendance` */

DROP TABLE IF EXISTS `attendance`;

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `status` enum('present','absent','late','half-day') DEFAULT 'present',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`attendance_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=184 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `attendance` */

insert  into `attendance`(`attendance_id`,`employee_id`,`date`,`time_in`,`time_out`,`status`,`created_at`) values 
(1,47,'2025-04-22','22:37:53','35:37:53','present','2025-04-22 23:38:12'),
(2,47,'2025-04-23','21:05:42','00:54:58','half-day','2025-04-23 00:05:55'),
(74,45,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 01:34:01'),
(75,45,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 01:34:01'),
(76,45,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 01:34:01'),
(77,45,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 01:34:01'),
(78,45,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 01:34:01'),
(79,45,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 01:34:45'),
(80,45,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 01:34:45'),
(81,45,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 01:34:45'),
(82,45,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 01:34:45'),
(83,45,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 01:34:45'),
(84,45,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 01:35:00'),
(85,45,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 01:35:00'),
(86,45,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 01:35:00'),
(87,45,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 01:35:00'),
(88,45,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 01:35:00'),
(89,48,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 14:06:43'),
(90,48,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 14:06:43'),
(91,48,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 14:06:43'),
(92,48,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 14:06:43'),
(93,48,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 14:06:43'),
(94,48,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 14:22:27'),
(95,48,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 14:22:27'),
(96,48,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 14:22:27'),
(97,48,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 14:22:27'),
(98,48,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 14:22:27'),
(99,50,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 14:27:30'),
(100,50,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 14:27:30'),
(101,50,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 14:27:30'),
(102,50,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 14:27:30'),
(103,50,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 14:27:30'),
(104,50,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 14:28:38'),
(105,50,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 14:28:38'),
(106,50,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 14:28:38'),
(107,50,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 14:28:38'),
(108,50,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 14:28:38'),
(109,50,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 14:31:58'),
(110,50,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 14:31:58'),
(111,50,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 14:31:58'),
(112,50,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 14:31:58'),
(113,50,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 14:31:58'),
(114,50,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 14:36:09'),
(115,50,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 14:36:09'),
(116,50,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 14:36:09'),
(117,50,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 14:36:09'),
(118,50,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 14:36:09'),
(119,51,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 14:59:03'),
(120,51,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 14:59:03'),
(121,51,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 14:59:03'),
(122,51,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 14:59:03'),
(123,51,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 14:59:03'),
(124,51,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 15:11:28'),
(125,51,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 15:11:28'),
(126,51,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 15:11:28'),
(127,51,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 15:11:28'),
(128,51,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 15:11:28'),
(129,51,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 15:12:31'),
(130,51,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 15:12:31'),
(131,51,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 15:12:31'),
(132,51,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 15:12:31'),
(133,51,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 15:12:31'),
(134,51,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 17:30:58'),
(135,51,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 17:30:58'),
(136,51,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 17:30:58'),
(137,51,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 17:30:58'),
(138,51,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 17:30:58'),
(139,51,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 17:39:07'),
(140,51,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 17:39:07'),
(141,51,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 17:39:07'),
(142,51,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 17:39:07'),
(143,51,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 17:39:07'),
(144,51,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 19:28:56'),
(145,51,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 19:28:56'),
(146,51,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 19:28:56'),
(147,51,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 19:28:56'),
(148,51,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 19:28:56'),
(149,51,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 20:03:37'),
(150,51,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 20:03:37'),
(151,51,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 20:03:37'),
(152,51,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 20:03:37'),
(153,51,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 20:03:37'),
(154,51,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 20:05:08'),
(155,51,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 20:05:08'),
(156,51,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 20:05:08'),
(157,51,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 20:05:08'),
(158,51,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 20:05:08'),
(159,51,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 20:05:22'),
(160,51,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 20:05:22'),
(161,51,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 20:05:22'),
(162,51,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 20:05:22'),
(163,51,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 20:05:22'),
(164,52,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 20:06:57'),
(165,52,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 20:06:57'),
(166,52,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 20:06:57'),
(167,52,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 20:06:57'),
(168,52,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 20:06:57'),
(169,52,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 20:07:46'),
(170,52,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 20:07:46'),
(171,52,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 20:07:46'),
(172,52,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 20:07:46'),
(173,52,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 20:07:46'),
(174,53,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 20:10:50'),
(175,53,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 20:10:50'),
(176,53,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 20:10:50'),
(177,53,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 20:10:50'),
(178,53,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 20:10:50'),
(179,53,'2025-04-22','22:37:53','01:00:00','present','2025-04-24 20:24:24'),
(180,53,'2025-04-23','22:37:53','01:00:00','present','2025-04-24 20:24:24'),
(181,53,'2025-04-24','22:37:53','01:00:00','present','2025-04-24 20:24:24'),
(182,53,'2025-04-25','22:37:53','01:00:00','present','2025-04-24 20:24:24'),
(183,53,'2025-04-26','22:37:53','01:00:00','present','2025-04-24 20:24:24');

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
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `attendanceleave` */

insert  into `attendanceleave`(`AttendanceID`,`EmployeeID`,`Date`,`Status`,`LeaveType`) values 
(1,44,'2023-07-01','Present',NULL),
(2,45,'2023-07-02','Leave','Vacation'),
(3,46,'2023-07-01','Present',NULL),
(4,47,'2023-07-02','Present',NULL),
(5,48,'2023-07-01','Absent',NULL),
(6,49,'2023-07-02','Present',NULL),
(7,50,'2023-07-01','Present',NULL),
(8,51,'2023-07-02','Leave','Sick'),
(9,52,'2023-07-01','Present',NULL),
(10,53,'2023-07-02','Present',NULL),
(11,44,'2023-07-03','Present',NULL),
(12,45,'2023-07-03','Leave','Vacation'),
(13,46,'2023-07-03','Present',NULL),
(14,47,'2023-07-03','Present',NULL),
(15,48,'2023-07-03','Absent',NULL),
(16,49,'2023-07-03','Present',NULL),
(17,50,'2023-07-03','Present',NULL),
(18,51,'2023-07-03','Leave','Sick'),
(19,52,'2023-07-03','Present',NULL),
(20,53,'2023-07-03','Present',NULL),
(21,54,'2023-07-03','Present',NULL),
(22,44,'2023-07-04','Present',NULL),
(23,45,'2023-07-04','Leave','Vacation'),
(24,46,'2023-07-04','Present',NULL),
(25,47,'2023-07-04','Present',NULL),
(26,48,'2023-07-04','Absent',NULL),
(27,49,'2023-07-04','Present',NULL),
(28,50,'2023-07-04','Present',NULL),
(29,51,'2023-07-04','Leave','Sick'),
(30,52,'2023-07-04','Present',NULL),
(31,53,'2023-07-04','Present',NULL),
(32,54,'2023-07-04','Present',NULL),
(33,44,'2023-07-05','Present',NULL),
(34,45,'2023-07-05','Leave','Vacation'),
(35,46,'2023-07-05','Present',NULL),
(36,47,'2023-07-05','Present',NULL),
(37,48,'2023-07-05','Absent',NULL),
(38,49,'2023-07-05','Present',NULL),
(39,50,'2023-07-05','Present',NULL),
(40,51,'2023-07-05','Leave','Sick'),
(41,52,'2023-07-05','Present',NULL),
(42,53,'2023-07-05','Present',NULL),
(43,54,'2023-07-05','Present',NULL),
(44,44,'2023-07-06','Present',NULL),
(45,45,'2023-07-06','Leave','Vacation'),
(46,46,'2023-07-06','Present',NULL),
(47,47,'2023-07-06','Present',NULL),
(48,48,'2023-07-06','Absent',NULL),
(49,49,'2023-07-06','Present',NULL),
(50,50,'2023-07-06','Present',NULL),
(51,51,'2023-07-06','Leave','Sick'),
(52,52,'2023-07-06','Present',NULL),
(53,53,'2023-07-06','Present',NULL),
(54,54,'2023-07-06','Present',NULL),
(55,44,'2023-07-07','Present',NULL),
(56,45,'2023-07-07','Leave','Vacation'),
(57,46,'2023-07-07','Present',NULL),
(58,47,'2023-07-07','Present',NULL),
(59,48,'2023-07-07','Absent',NULL),
(60,49,'2023-07-07','Present',NULL),
(61,50,'2023-07-07','Present',NULL),
(62,51,'2023-07-07','Leave','Sick'),
(63,52,'2023-07-07','Present',NULL),
(64,53,'2023-07-07','Present',NULL),
(65,54,'2023-07-07','Present',NULL),
(66,44,'2023-07-06','Leave',NULL),
(67,45,'2023-07-06','Present','Vacation'),
(68,46,'2023-07-06','Leave',NULL),
(69,47,'2023-07-06','Present',NULL),
(70,48,'2023-07-06','Present',NULL),
(71,49,'2023-07-06','Present',NULL),
(72,50,'2023-07-06','Present',NULL),
(73,51,'2023-07-06','Leave','Sick'),
(74,52,'2023-07-06','Present',NULL),
(75,53,'2023-07-06','Present',NULL),
(76,54,'2023-07-06','Leave',NULL);

/*Table structure for table `average_rates` */

DROP TABLE IF EXISTS `average_rates`;

CREATE TABLE `average_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `min_salary` decimal(10,2) NOT NULL,
  `max_salary` decimal(10,2) NOT NULL,
  `position` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `average_rates` */

insert  into `average_rates`(`id`,`date`,`min_salary`,`max_salary`,`position`) values 
(1,'2024-01-01',50000.00,70000.00,'ASD'),
(2,'2024-01-01',60000.00,85000.00,'Associate Professor'),
(3,'2024-01-01',80000.00,120000.00,'Professor'),
(4,'2024-01-01',45000.00,65000.00,'Lecturer'),
(5,'2024-01-01',55000.00,75000.00,'Senior Lecturer'),
(6,'2024-01-01',50000.00,72000.00,'Research Fellow'),
(7,'2024-01-01',62000.00,88000.00,'Assistant Dean'),
(8,'2024-01-01',70000.00,100000.00,'Dean'),
(9,'2024-01-01',52000.00,77000.00,'Postdoctoral Researcher'),
(10,'2024-01-01',40000.00,60000.00,'Teaching Assistant'),
(11,'2025-04-05',50000.00,80000.00,'Professor'),
(12,'2025-04-04',52000.00,85000.00,'Professor'),
(13,'2025-04-03',48000.00,78000.00,'Professor'),
(14,'2025-04-02',51000.00,82000.00,'Professor'),
(15,'2025-04-01',49500.00,80500.00,'Professor'),
(16,'2025-04-04',8000.00,11000.00,'Professor');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `compensationbenefits` */

insert  into `compensationbenefits`(`CompensationID`,`EmployeeID`,`BaseSalary`,`Bonus`,`BenefitType`,`BenefitValue`,`EffectiveDate`) values 
(1,44,60000.00,5000.00,'Health',2000.00,'2023-01-01'),
(2,45,60000.00,5000.00,'Retirement',3000.00,'2023-01-01'),
(3,46,75000.00,7000.00,'Health',2500.00,'2023-01-01'),
(4,47,75000.00,7000.00,'Stock Options',5000.00,'2023-01-01'),
(5,48,55000.00,3000.00,'Health',1500.00,'2023-01-01'),
(6,49,55000.00,3000.00,'Retirement',2000.00,'2023-01-01'),
(7,50,80000.00,10000.00,'Health',3000.00,'2023-01-01'),
(8,51,80000.00,10000.00,'Stock Options',7000.00,'2023-01-01'),
(9,52,48000.00,2000.00,'Health',1000.00,'2023-01-01'),
(10,53,48000.00,2000.00,'Retirement',1500.00,'2023-01-01'),
(11,54,47000.00,2000.00,'Retirement',1500.00,'2023-01-01');

/*Table structure for table `deduction` */

DROP TABLE IF EXISTS `deduction`;

CREATE TABLE `deduction` (
  `id` int(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` decimal(50,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `deduction` */

insert  into `deduction`(`id`,`type`,`amount`) values 
(1,'SSS',4),
(2,'Pag-ibig',2),
(3,'Philhealth',5);

/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `DepartmentID` int(11) NOT NULL AUTO_INCREMENT,
  `DepartmentName` varchar(100) NOT NULL,
  `ManagerID` int(11) DEFAULT NULL,
  PRIMARY KEY (`DepartmentID`),
  KEY `FK_Departments_ManagerID` (`ManagerID`),
  CONSTRAINT `FK_Departments_ManagerID` FOREIGN KEY (`ManagerID`) REFERENCES `employees` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `departments` */

insert  into `departments`(`DepartmentID`,`DepartmentName`,`ManagerID`) values 
(8,'HR Department',NULL),
(9,'IT Department',NULL),
(10,'Finance and Accounting',NULL),
(11,'Facilities Management',NULL),
(12,'Teacher Department',NULL),
(15,'Test department',NULL);

/*Table structure for table `document_submissions` */

DROP TABLE IF EXISTS `document_submissions`;

CREATE TABLE `document_submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL,
  `document` varchar(255) DEFAULT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `applicant_id` (`applicant_id`),
  CONSTRAINT `document_submissions_ibfk_1` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `document_submissions` */

insert  into `document_submissions`(`id`,`applicant_id`,`document`,`submission_date`) values 
(12,82,'bcp3 (1).jpg','2025-04-28 10:20:59'),
(13,82,'bcp1.jpg','2025-04-28 10:43:57'),
(14,82,'Aljhon Resume (1).docx','2025-04-28 10:54:28'),
(17,81,'bcp logo.png','2025-04-28 16:51:32'),
(19,81,'ang.jpg','2025-04-28 16:51:38'),
(20,81,'bcp2.jpg','2025-04-28 16:54:58'),
(21,81,'bcp3 (1).jpg','2025-04-28 16:56:44');

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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `documents` */

insert  into `documents`(`id`,`user_id`,`document_name`,`file_path`,`uploaded_at`) values 
(19,39,'BOSS Q 1.txt','uploads/documents/BOSS Q 1.txt','2024-11-14 00:03:36'),
(20,44,'BOSS Q 1.txt','uploads/documents/BOSS Q 1.txt','2025-03-22 19:33:00'),
(21,45,'BOSS Q 1.txt','uploads/documents/BOSS Q 1.txt','2025-03-22 19:33:24'),
(22,46,'BOSS Q 1.txt','uploads/documents/BOSS Q 1.txt','2025-03-22 19:33:51'),
(23,47,'BOSS Q 1.txt','uploads/documents/BOSS Q 1.txt','2025-03-22 19:33:51'),
(24,48,'BOSS Q 1.txt','uploads/documents/BOSS Q 1.txt','2025-03-22 19:36:05'),
(25,49,'BOSS Q 1.txt','uploads/documents/BOSS Q 1.txt','2025-03-22 19:36:05'),
(26,4,'BOSS Q 1.txt','uploads/documents/BOSS Q 1.txt','2025-03-22 19:36:05'),
(27,36,'BOSS Q 1.txt','uploads/documents/BOSS Q 1.txt','2025-03-22 19:36:05'),
(28,36,'BOSS Q 2.txt','uploads/documents/BOSS Q 1.txt','2025-03-22 19:36:05'),
(29,36,'BOSS Q 3.txt','uploads/documents/BOSS Q 1.txt','2025-03-22 19:36:05'),
(36,53,'bootstrap.txt','uploads/bootstrap.txt','2025-03-31 15:43:34'),
(38,54,'Aljhon Resume.docx','uploads/Aljhon Resume.docx','2025-03-31 15:45:46'),
(39,55,'GMAIL-ACC.txt','uploads/GMAIL-ACC.txt','2025-04-01 11:39:27'),
(42,60,'1-INDORSEMENT-FOR-INTERNSHIP.docx','uploads/1-INDORSEMENT-FOR-INTERNSHIP.docx','2025-04-05 17:18:16');

/*Table structure for table `email_verifications` */

DROP TABLE IF EXISTS `email_verifications`;

CREATE TABLE `email_verifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `applicant_name` varchar(255) NOT NULL,
  `resume_path` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `verification_token` varchar(64) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`,`job_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `email_verifications` */

insert  into `email_verifications`(`id`,`email`,`applicant_name`,`resume_path`,`department_id`,`job_id`,`verification_token`,`is_verified`,`created_at`) values 
(9,'apundarjeremy@gmail.com','Apundar, Jeremy','uploads/verify/bcp logo.png',10,78,'879b9be681221e30ef48a3efdc9d719b65edde0618875f7628ae8d6a55b11f5a',1,'2025-04-27 23:50:54'),
(10,'apundarjeremy@gmail.com','Apundar','uploads/verify/bcp logo.png',9,62,'61d9c0929671ba1d41b4867131f14a2258efff3a80c4b8464f625aad60d13291',1,'2025-04-28 05:54:19'),
(11,'apundarjeremy@gmail.com','TRYYY','uploads/verify/bcp logo.png',9,64,'b2c79422703b750a18778bf95196dfc3b76068834aef38c6076de8ceeb12c8e8',1,'2025-04-28 09:28:22');

/*Table structure for table `employee_awards` */

DROP TABLE IF EXISTS `employee_awards`;

CREATE TABLE `employee_awards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `award_date` date NOT NULL,
  `status` enum('Pending','Awarded') DEFAULT 'Pending',
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `program_id` (`program_id`),
  CONSTRAINT `employee_awards_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`EmployeeID`),
  CONSTRAINT `employee_awards_ibfk_2` FOREIGN KEY (`program_id`) REFERENCES `retention_programs` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `employee_awards` */

insert  into `employee_awards`(`id`,`employee_id`,`program_id`,`description`,`award_date`,`status`) values 
(1,54,4,'aweawda','2025-04-26','Awarded'),
(2,54,4,'asdasdfa','2025-04-26','Awarded');

/*Table structure for table `employee_profile_pictures` */

DROP TABLE IF EXISTS `employee_profile_pictures`;

CREATE TABLE `employee_profile_pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeID` int(11) NOT NULL,
  `profile_picture_path` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `EmployeeID` (`EmployeeID`),
  CONSTRAINT `employee_profile_pictures_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employees` (`EmployeeID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `employee_profile_pictures` */

insert  into `employee_profile_pictures`(`id`,`EmployeeID`,`profile_picture_path`,`uploaded_at`) values 
(1,54,'uploads/profile_pictures/1745159252_student1.jpg','2025-04-20 20:08:32'),
(2,54,'uploads/profile_pictures/1745161537_student1.jpg','2025-04-20 22:03:42'),
(3,88,'uploads/profile_pictures/1745588065_bcp-olp-logo-mini2.png','2025-04-25 21:34:25');

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
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `employees` */

insert  into `employees`(`EmployeeID`,`FirstName`,`LastName`,`Email`,`Phone`,`Address`,`DOB`,`HireDate`,`Salary`,`Status`,`UserID`,`PolicyAgreed`) values 
(44,'Lukese','Francio','luefrancio@gmail.com','09485234501','Silicon Valley','2004-11-14','2020-11-13',30000.00,'Active',39,1),
(45,'John','Doe','johndoe@example.com','09123456789','123 Main St','1990-01-01','2024-01-26',50000.00,'Active',40,1),
(46,'Jane','Smith','janesmith@example.com','09123456780','124 Main St','1991-02-02','2025-01-26',60000.00,'Active',41,1),
(47,'Alice','Johnson','alicejohnson@example.com','09123456781','125 Main St','1992-03-03','2025-01-26',55000.00,'Active',42,1),
(48,'Bob','Brown','bobbrown@example.com','09123456782','126 Main St','1993-04-04','2025-01-26',52000.00,'Active',43,1),
(49,'Charlie','Davis','charliedavis@example.com','09123456783','127 Main St','1994-05-05','2025-01-26',48000.00,'Active',44,1),
(50,'Diana','Evans','dianaevans@example.com','09123456784','128 Main St','1995-06-06','2025-01-26',47000.00,'Active',45,1),
(51,'Ethan','Foster','ethanfoster@example.com','09123456785','129 Main St','1996-07-07','2025-01-26',46000.00,'Active',46,1),
(52,'Fiona','Green','fionagreen@example.com','09123456786','130 Main St','1997-08-08','2025-01-26',45000.00,'Active',47,1),
(53,'George','Harris','georgeharris@example.com','09123456787','131 Main St','1998-09-09','2025-01-26',44000.00,'Active',48,1),
(54,'Hannahs','Ivers','hannahivers@example.com','09123456788','132 Main St','1999-10-10','2025-01-26',43000.00,'Active',49,1),
(55,'STEPH','CURRY','curry@gmail.com','0931203129','Golden State','2025-03-30','2025-03-30',10.00,'Active',50,1),
(56,'jeremy','apundar','apundar@gmail.com','129047812409','S PALAY','2025-03-30','2025-03-30',1.00,'Active',51,1),
(57,'qwe','qwe','qwe@gmail.com','12381249','ccsss','2025-03-30','2025-03-30',1.00,'Active',52,1),
(76,'TEST','WATER','TESTWATER@GMAIL.COM','1234567890','SAPANG PALAY PROPER','2002-07-31','2025-04-01',10.00,'Active',54,1),
(78,'Jeremy','Apundar','apundarjeremy@gmail.com','09485234501','SAPANG PALAY PROPER','2002-07-31','2025-04-01',10.00,'Active',53,1),
(81,'test','applicant','apundar1jeremy@gmail.com','09485234501','Sapang Palay','2002-07-31','2025-04-01',10.00,'Active',55,1),
(87,'Penpen','DelaFuente','penpen@gmail.com','09485234501','Citrus','2002-07-31','2025-04-05',0.00,'Active',60,1),
(88,'Jeremy','Apundar','jeremyapundar@gmail.com','09485234501','los angeles','2002-07-31','2025-04-09',0.00,'Active',36,0),
(89,'Super','a','superadmin@gmail.com','09093642460','los angeles','2002-07-31','2025-04-09',0.00,'Active',40,0),
(90,'penpen1','delafuente','penpen1delafuente@gmail.com','09485234501','CITRUS','2002-03-07','2025-04-20',0.00,'Active',61,1),
(91,'Jeremy','Apundar','apundar666jeremy@gmail.com','09093642460','Sapang Palay Proper','2002-07-31','2025-04-20',0.00,'Active',4,0),
(94,'Jeremy','Apundar','apundar555jeremy@gmail.com','09485234501','Sapang Palay','0000-00-00','2025-04-28',0.00,'Active',63,0);

/*Table structure for table `fm_bookings` */

DROP TABLE IF EXISTS `fm_bookings`;

CREATE TABLE `fm_bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `status` enum('Pending','Approved','Rejected','Cancelled') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `fm_bookings` */

insert  into `fm_bookings`(`id`,`employee_id`,`room_id`,`booking_date`,`start_time`,`end_time`,`purpose`,`status`,`created_at`,`updated_at`,`is_active`) values 
(1,36,3,'2024-12-20','11:01:00','11:22:00','das','Approved','2024-12-13 22:30:51','2024-12-21 19:13:19',0),
(2,36,1,'2024-12-09','22:22:00','22:44:00','222','Rejected','2024-12-14 12:00:56','2024-12-16 22:45:24',0),
(3,36,1,'2024-12-12','23:11:00','01:33:00','dwed','Rejected','2024-12-14 16:08:20','2024-12-17 22:43:10',0),
(4,36,8,'2024-12-04','12:02:00','03:03:00','dex','Approved','2024-12-14 16:09:43','2024-12-21 16:53:38',0),
(5,36,3,'2222-12-22','21:02:00','12:21:00','adsd','Cancelled','2024-12-14 16:10:18','2024-12-27 00:40:58',0),
(6,39,2,'2024-12-10','23:02:00','23:02:00','asdads','Approved','2024-12-14 18:49:47','2024-12-21 18:57:01',0),
(7,39,1,'2024-12-16','12:02:00','12:34:00','asd','Rejected','2024-12-15 16:23:20','2024-12-26 22:48:50',0),
(8,4,4,'2024-12-16','12:00:00','13:01:00','may event','Rejected','2024-12-15 16:39:38','2024-12-26 22:48:55',0),
(9,39,5,'2024-12-16','12:02:00','03:03:00','asda','Cancelled','2024-12-15 16:50:37','2024-12-26 23:37:20',0),
(10,39,6,'2024-12-16','12:02:00','11:11:00','asd','Rejected','2024-12-15 17:26:06','2024-12-26 22:50:01',0),
(11,39,6,'2024-12-16','12:02:00','11:11:00','asd','Approved','2024-12-15 17:26:06','2024-12-25 00:18:48',0),
(12,4,1,'2024-12-16','05:05:00','07:55:00','May gagawin lang\r\n','Approved','2024-12-15 19:34:40','2024-12-21 19:13:19',0),
(13,4,2,'2024-12-16','12:02:00','04:04:00','asd','Approved','2024-12-15 19:37:44','2024-12-25 00:17:12',0),
(14,39,7,'2024-12-17','21:22:00','23:33:00','wqweqwe','Rejected','2024-12-16 22:46:30','2024-12-26 22:50:01',0),
(15,39,8,'2024-12-17','10:00:00','11:00:00','mnb nbjvk jyfkuyr uyrkvgk tcu vbj kguvtjyg','Approved','2024-12-17 21:40:39','2024-12-21 19:11:34',0),
(16,39,9,'2024-12-17','12:12:00','22:22:00','dasdasd','Rejected','2024-12-17 21:42:19','2024-12-26 22:50:01',0),
(17,39,4,'2024-12-22','23:33:00','03:33:00','sdasd','Approved','2024-12-21 21:10:48','2024-12-25 00:17:07',0),
(18,39,4,'2024-12-22','12:02:00','03:04:00','deade','Approved','2024-12-21 21:12:39','2024-12-23 23:15:00',0),
(19,39,8,'2024-12-22','03:44:00','03:06:00','dsfsdf','Approved','2024-12-21 21:56:36','2024-12-22 19:53:21',0),
(20,0,11,'2024-12-23','23:33:00','23:03:00','admin','Pending','2024-12-22 11:24:41','2024-12-22 11:24:41',1),
(21,36,10,'2024-12-23','23:03:00','05:06:00','sdfsf','Rejected','2024-12-22 17:15:01','2024-12-24 12:25:32',1),
(22,36,13,'2024-12-23','23:33:00','23:44:00','admin','Approved','2024-12-22 17:15:39','2024-12-25 00:14:52',0),
(23,36,21,'2024-12-22','18:25:00','05:06:00','naguupdate ba','Approved','2024-12-22 18:24:48','2024-12-24 12:34:28',0),
(24,36,1,'2024-12-24','23:33:00','03:03:00','awdawdawd','Approved','2024-12-23 23:33:47','2024-12-24 16:41:24',0),
(25,39,15,'2024-12-25','23:03:00','04:04:00','dasd','Approved','2024-12-24 13:02:59','2024-12-27 01:00:41',0),
(26,39,19,'2025-12-05','03:04:00','04:57:00','padawd','Approved','2024-12-24 14:32:20','2024-12-25 00:19:04',1),
(27,4,20,'2024-12-25','12:43:00','03:44:00','sdfsdf','Approved','2024-12-24 16:15:01','2024-12-25 11:31:00',0),
(28,4,17,'2024-12-24','17:18:00','06:07:00','TESTTTTTTTTTT','Approved','2024-12-24 17:17:36','2024-12-24 17:46:14',0),
(29,36,11,'2024-12-31','23:33:00','03:34:00','New YEars Party','Cancelled','2024-12-25 11:30:49','2025-01-27 00:36:15',1),
(30,4,1,'2024-12-26','23:03:00','04:05:00','sdfsdf','Rejected','2024-12-25 22:14:57','2024-12-27 13:41:53',1),
(31,4,2,'2024-12-27','23:03:00','04:55:00','sdfsdf','Approved','2024-12-26 21:33:19','2025-04-13 11:22:51',0),
(32,4,4,'0006-01-06','03:44:00','04:05:00','dfgdfg','Approved','2024-12-26 21:47:48','2025-04-13 11:22:51',0),
(33,4,5,'2025-01-30','23:03:00','04:05:00','dfgdfg','Approved','2024-12-26 21:49:06','2025-03-29 17:42:30',0),
(34,4,6,'2025-02-18','23:03:00','04:05:00','sdff','Approved','2024-12-26 21:51:40','2025-02-20 21:08:55',0),
(35,4,7,'2025-01-04','23:03:00','03:44:00','fsdsdf','Cancelled','2024-12-26 21:58:55','2024-12-27 00:26:06',1),
(36,4,8,'2025-01-02','03:33:00','03:44:00','sdfsdf','Cancelled','2024-12-26 21:59:11','2024-12-26 23:52:59',1),
(37,4,9,'2025-01-03','23:03:00','04:05:00','sdfsdf','Cancelled','2024-12-27 00:13:34','2024-12-27 00:30:22',1),
(38,4,10,'2025-01-10','04:55:00','05:06:00','dfgdfg','Cancelled','2024-12-27 00:14:01','2024-12-27 00:22:44',1),
(39,4,13,'2024-12-06','12:02:00','04:55:00','sdfsdf','Cancelled','2024-12-27 00:25:02','2024-12-27 00:25:10',1),
(40,4,12,'2025-01-11','23:45:00','04:05:00','dfdfg','Cancelled','2024-12-27 00:32:14','2024-12-27 00:32:19',1),
(41,4,14,'2025-01-09','23:04:00','04:05:00','dfgdfg','Cancelled','2024-12-27 00:32:57','2024-12-27 00:33:06',1),
(42,4,17,'2025-01-08','23:03:00','04:55:00','dfgdfg','Cancelled','2024-12-27 00:36:02','2024-12-27 00:36:07',1),
(43,4,16,'2025-01-07','03:44:00','04:05:00','sfsdf','Cancelled','2024-12-27 00:37:02','2024-12-27 00:37:28',1),
(44,4,18,'2025-01-01','23:33:00','04:55:00','dfdfg','Cancelled','2024-12-27 00:53:14','2024-12-27 00:53:19',0),
(45,4,18,'2025-01-06','04:44:00','05:55:00','4455','Cancelled','2024-12-27 00:54:25','2024-12-27 00:54:33',0),
(46,4,18,'2025-01-07','01:05:00','01:06:00','dfdfg','Cancelled','2024-12-27 00:55:15','2024-12-27 00:55:20',0),
(47,4,15,'2024-12-30','22:22:00','04:44:00','adad','Cancelled','2025-01-26 12:31:56','2025-01-26 12:32:04',0),
(48,36,18,'2025-02-20','21:02:00','23:03:00','asdasd','Approved','2025-02-20 20:53:17','2025-03-27 20:49:31',0),
(49,4,23,'2025-02-21','12:02:00','03:44:00','testing feb 20','Cancelled','2025-02-20 21:12:25','2025-02-20 21:12:52',0),
(50,4,23,'2025-02-21','12:22:00','12:02:00','testing feb 20','Approved','2025-02-20 21:13:14','2025-03-16 22:54:31',0),
(51,4,6,'2025-03-26','12:22:00','12:22:00','sSSsdf','Cancelled','2025-03-26 22:26:30','2025-03-26 22:26:40',0),
(52,4,20,'2025-03-26','23:33:00','04:55:00','sfsdfsdf','Approved','2025-03-26 22:27:24','2025-04-13 11:22:50',0),
(53,4,23,'2025-03-26','12:22:00','03:44:00','rwar','Approved','2025-03-26 22:29:14','2025-03-28 21:21:52',0),
(54,4,6,'2025-03-06','12:22:00','04:44:00','sdfsdf','Approved','2025-03-28 21:17:11','2025-04-13 11:22:50',0),
(55,4,9,'2025-04-14','12:02:00','23:23:00','fsdfsdf','Approved','2025-04-13 08:34:26','2025-04-19 00:24:00',0),
(56,4,16,'2025-04-14','12:22:00','23:23:00','asasda','Approved','2025-04-13 08:39:44','2025-04-19 00:24:00',0),
(57,4,17,'2025-06-13','12:02:00','23:03:00','asdasda','Approved','2025-04-13 08:43:09','2025-04-13 12:51:59',1),
(58,4,2,'2025-04-14','23:23:00','23:02:00','dadasd','Approved','2025-04-13 11:27:11','2025-04-19 00:24:01',0),
(59,41,3,'2025-04-14','23:03:00','04:55:00','qwewqe','Approved','2025-04-13 11:28:10','2025-04-23 19:54:35',0),
(60,4,4,'2025-04-14','12:22:00','03:34:00','aasdasd\r\n','Approved','2025-04-13 13:24:39','2025-04-19 00:24:02',0),
(61,4,7,'2025-04-14','23:33:00','03:04:00','sdfsdfsdfsdf','Approved','2025-04-13 13:24:46','2025-04-19 00:24:03',0),
(62,4,6,'2025-04-14','23:03:00','04:33:00','sfsdfdsf','Approved','2025-04-13 13:24:55','2025-04-19 00:24:04',0),
(63,4,5,'2025-04-21','23:33:00','04:55:00','sdfsdf','Approved','2025-04-13 13:41:48','2025-04-23 19:54:37',0),
(64,4,8,'2025-04-17','23:06:00','04:54:00','sdfsdfsdf','Approved','2025-04-13 13:41:57','2025-04-19 00:24:05',0),
(65,4,10,'2025-04-16','23:03:00','04:55:00','fdfgdfg','Approved','2025-04-13 19:51:28','2025-04-23 19:54:36',0),
(66,4,10,'2025-04-16','23:03:00','04:55:00','fdfgdfg','Approved','2025-04-13 19:51:38','2025-04-23 19:54:37',0),
(67,4,11,'2025-04-30','12:22:00','03:44:00','testing\r\n','Approved','2025-04-13 19:52:52','2025-04-14 20:11:23',1),
(68,4,12,'2025-04-16','23:32:00','04:55:00','fsdfsdf','Rejected','2025-04-13 19:53:50','2025-04-14 19:37:50',1),
(69,4,13,'2025-12-12','23:03:00','04:55:00','Hello Sir,<br><br>test test test test test test test test test <br>test test test test test test test test test test test <br><br>best regards','Rejected','2025-04-13 20:17:21','2025-04-14 19:37:51',1),
(70,4,14,'2025-04-16','12:22:00','17:06:00','<p>hello, <br><br>I want to this room for this testing defenceI want to this room for this testing defenc I want to this room for this testing defence, I want to this room for this testing defence<br><br>best regards</p><hr><p><br></p>','Approved','2025-04-14 20:27:39','2025-04-23 19:20:54',0),
(71,4,17,'2025-04-16','23:03:00','03:44:00','<p>DFSFSFSDFSDFSDFSDF</p>','Approved','2025-04-14 20:31:27','2025-04-23 19:07:42',0),
(72,4,18,'2025-04-23','23:03:00','12:22:00','ADASDSADASDASDASDADA','Approved','2025-04-14 20:32:39','2025-04-24 00:48:13',0),
(73,4,2,'2025-05-01','23:03:00','04:55:00','<b>Hello edit,<br></b><br><i>dasdadasdad adasdasdasd</i><br><br>best regrards','Approved','2025-04-23 19:09:11','2025-04-23 19:14:16',1),
(74,4,4,'2025-04-25','13:04:00','05:55:00','hello , <br>asdad<br>dasdasd<br>asd <br><br>sdfsdf','Approved','2025-04-23 19:12:56','2025-04-23 19:14:20',1),
(75,4,6,'2025-04-24','23:33:00','04:54:00','april 23 19 23','Approved','2025-04-23 19:23:44','2025-04-24 10:15:34',0),
(76,4,7,'2025-04-24','23:33:00','04:55:00','dfgdfg','Approved','2025-04-23 19:52:10','2025-04-24 10:15:33',0),
(77,4,8,'2025-04-24','03:33:00','04:55:00','sdfsdfdsf','Approved','2025-04-23 19:53:26','2025-04-24 20:15:53',0),
(78,4,3,'2025-04-24','12:22:00','03:44:00','sfsdfds','Approved','2025-04-23 20:12:12','2025-04-24 13:29:23',0),
(79,4,5,'2025-04-24','12:22:00','03:44:00','sdfsdfsdf','Approved','2025-04-23 20:13:46','2025-04-24 10:15:32',0),
(80,4,9,'2025-04-24','23:33:00','04:34:00','adasdasd','Approved','2025-04-23 21:22:57','2025-04-24 10:15:32',0),
(81,4,10,'2025-04-24','23:03:00','04:04:00','dasdsadasd','Approved','2025-04-23 21:23:50','2025-04-24 10:15:31',0),
(82,4,14,'2025-04-25','12:22:00','13:23:00','<p>Hello sir.</p><p>testing mesage<br><br>best regards</p>','Approved','2025-04-24 00:46:37','2025-04-25 22:40:10',0),
(83,4,3,'2025-04-28','23:33:00','19:09:00','bukas or today?','Approved','2025-04-24 13:47:43','2025-04-24 20:15:50',1),
(84,4,5,'2025-04-28','12:22:00','04:04:00','asdasdasd','Approved','2025-04-25 20:01:20','2025-04-25 22:40:07',1),
(85,4,20,'2025-04-30','23:03:00','04:55:00','ddfsfsfsdf','Pending','2025-04-25 22:39:50','2025-04-25 22:39:50',1),
(86,4,7,'2025-05-03','23:03:00','04:05:00','sdfsdfdffsd','Pending','2025-04-28 07:34:22','2025-04-28 07:34:22',1),
(87,4,8,'2025-05-06','23:03:00','06:06:00','sdfsdsdfsdf','Pending','2025-04-28 07:34:30','2025-04-28 07:34:30',1),
(88,4,6,'2025-05-06','23:33:00','03:03:00','sdfsfsdf','Pending','2025-04-28 07:34:43','2025-04-28 07:34:43',1),
(89,4,9,'2025-05-06','23:03:00','05:55:00','sdfsdfsdf','Pending','2025-04-28 07:34:52','2025-04-28 07:34:52',1);

/*Table structure for table `fm_resource_allocations` */

DROP TABLE IF EXISTS `fm_resource_allocations`;

CREATE TABLE `fm_resource_allocations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `allocation_start` datetime NOT NULL,
  `allocation_end` datetime DEFAULT NULL,
  `status` enum('Allocated','Returned','Rejected') DEFAULT 'Allocated',
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `resource_id` (`resource_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `fm_resource_allocations_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `fm_resources` (`id`),
  CONSTRAINT `fm_resource_allocations_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `fm_resource_allocations` */

insert  into `fm_resource_allocations`(`id`,`resource_id`,`employee_id`,`quantity`,`allocation_start`,`allocation_end`,`status`,`notes`,`created_at`) values 
(1,81,36,23,'2024-12-31 03:33:00','2025-01-01 23:03:00','Allocated','fsdsdf','2024-12-30 23:35:09'),
(2,87,36,5,'2025-01-26 05:55:00','2032-01-27 05:55:00','Returned','new commers','2025-01-26 17:04:36'),
(3,90,36,5,'2025-01-26 12:02:00','2038-01-26 12:02:00','Allocated','new commers','2025-01-26 17:06:27'),
(4,90,36,5,'2025-01-14 05:55:00','2045-01-26 11:01:00','Allocated','new commers','2025-01-26 17:14:04'),
(5,87,36,2,'2025-02-20 12:22:00','2025-05-29 12:02:00','Returned','test','2025-02-20 20:51:36'),
(6,81,36,12,'2025-03-28 23:33:00','2025-03-28 23:33:00','Allocated','qweqw','2025-03-27 20:49:16'),
(7,87,36,1,'2025-03-30 11:49:00','2025-03-30 11:49:00','Returned','hey','2025-03-30 11:49:40'),
(8,98,36,5,'2025-03-30 11:50:00','2025-04-02 11:50:00','Returned','hey','2025-03-30 11:50:48'),
(9,81,44,1,'2025-04-23 23:33:00','2025-04-30 03:44:00','Allocated','werwer','2025-04-24 13:16:03');

/*Table structure for table `fm_resource_requests` */

DROP TABLE IF EXISTS `fm_resource_requests`;

CREATE TABLE `fm_resource_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `purpose` text NOT NULL,
  `status` enum('Pending','Approved','Rejected','Returned') DEFAULT 'Pending',
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resource_id` (`resource_id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `fm_resource_requests_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `fm_resources` (`id`),
  CONSTRAINT `fm_resource_requests_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `fm_resource_requests` */

insert  into `fm_resource_requests`(`id`,`resource_id`,`employee_id`,`quantity`,`purpose`,`status`,`requested_at`,`approved_by`,`approved_at`,`return_date`) values 
(1,81,36,2,'wer','Returned','2024-12-29 09:08:00',NULL,NULL,'2025-04-12'),
(2,81,36,34,'qweqwe','Returned','2024-12-29 09:33:56',NULL,NULL,'2025-04-12'),
(3,90,36,2,'Pupose Testing','Returned','2024-12-29 12:38:04',NULL,NULL,'2025-04-12'),
(4,81,4,3,'e','Returned','2025-01-26 10:38:38',NULL,NULL,'2025-04-12'),
(5,82,4,5,'HIRAM','Returned','2025-01-26 10:48:32',NULL,NULL,'2025-04-12'),
(6,82,4,33,'33','Rejected','2025-01-26 10:49:06',NULL,NULL,NULL),
(7,82,4,1,'Client Meeting','Returned','2024-12-29 08:45:00',NULL,NULL,'2025-04-12'),
(8,97,36,4,'Training Session','Returned','2024-12-29 09:00:00',2,'2024-12-30 10:00:00','2025-04-12'),
(9,98,36,2,'Equipment Maintenance','Returned','2024-12-29 10:15:00',NULL,NULL,'2025-04-12'),
(10,90,4,6,'Research Materials','Returned','2024-12-29 11:30:00',3,'2024-12-30 12:00:00','2025-04-12'),
(11,90,39,8,'Conference Attendance','Rejected','2024-12-29 12:45:00',NULL,NULL,NULL),
(12,97,4,7,'Software License','Returned','2024-12-29 13:00:00',NULL,NULL,'2025-04-12'),
(13,98,39,9,'Hardware Upgrade','Returned','2024-12-29 14:15:00',4,'2024-12-30 15:00:00','2025-04-17'),
(14,81,36,5,'Office Supplies','Returned','2024-12-29 05:00:00',NULL,NULL,'2025-04-12'),
(15,81,39,10,'Project A Materials','Returned','2024-12-29 06:15:00',1,'2024-12-30 07:00:00','2025-04-12'),
(16,82,36,3,'Team Building Event','Rejected','2024-12-29 07:30:00',NULL,NULL,NULL),
(17,81,36,4,'Office Renovation','Returned','2024-11-01 10:00:00',NULL,NULL,'2025-04-12'),
(18,82,39,2,'New Software Installation','Returned','2024-11-01 11:15:00',1,'2024-11-06 12:00:00','2025-04-12'),
(19,97,36,3,'Team Outing','Rejected','2024-11-10 09:30:00',NULL,NULL,NULL),
(20,98,4,1,'Client Presentation','Returned','2024-11-01 14:45:00',NULL,NULL,'2025-04-12'),
(21,90,36,5,'Training Materials','Returned','2024-11-26 08:00:00',2,'2024-11-21 09:00:00','2025-04-12'),
(22,90,39,6,'Equipment Purchase','Returned','2024-11-25 13:15:00',NULL,NULL,'2025-04-12'),
(23,97,36,8,'Conference Registration','Returned','2024-11-26 15:30:00',3,'2024-11-27 16:00:00','2025-04-12'),
(24,90,4,7,'Research Project','Returned','2024-11-26 17:45:00',NULL,NULL,'2025-04-12'),
(25,90,36,9,'Marketing Materials','Returned','2024-11-29 18:00:00',NULL,NULL,'2025-04-12'),
(26,81,36,10,'IT Support','Returned','2024-11-30 19:15:00',4,'2024-12-01 20:00:00','2025-04-12'),
(27,99,36,10,'test','Returned','2025-02-20 20:50:15',NULL,NULL,'2025-04-12'),
(28,82,4,90,'testing feb 20','Rejected','2025-02-20 21:17:03',NULL,NULL,NULL),
(29,81,4,23,'asdasdasd','Returned','2025-03-26 22:27:34',NULL,NULL,'2025-04-12'),
(30,100,4,1,'adasdasd','Returned','2025-03-26 22:29:27',NULL,NULL,'2025-04-12'),
(31,81,4,5,'wrwere','Returned','2025-03-28 21:18:59',NULL,NULL,'2025-04-12'),
(32,81,4,2,'<p><b>Hello Sir/Maam,</b><br><br>ishefihfijcsefs flisef<i>li lisfiljsefl lisjflise</i><br><u><br>best regards,</u></p>','Returned','2025-04-13 20:20:31',NULL,'2025-04-13 21:27:17','2025-04-21'),
(33,81,4,3,'<p><b>adadasasda sdfs<i>fsdf d</i></b><i>fsfsdfsdfsdf</i></p>','Returned','2025-04-13 20:22:06',NULL,'2025-04-14 19:42:23','2025-04-21'),
(34,81,4,2,'<p>fadaw<i>d adawda aw</i> da<b>wd awd a daw d</b></p>','Returned','2025-04-13 20:24:16',NULL,'2025-04-14 19:42:45','2025-04-19'),
(35,81,4,2,'asdas<b>dasdasd</b>','Returned','2025-04-13 20:26:46',NULL,'2025-04-14 19:56:00','2025-04-19'),
(36,81,4,2,'dadasd','Returned','2025-04-13 21:10:01',NULL,'2025-04-17 11:36:45','2025-04-19'),
(37,81,4,2,'dadasd','Returned','2025-04-13 21:10:17',NULL,'2025-04-17 11:36:32','2025-04-19'),
(38,81,4,1,'adaasd','Returned','2025-04-13 21:11:33',NULL,'2025-04-17 11:48:03','2025-04-19'),
(39,97,4,1,'asdasd','Returned','2025-04-13 21:12:08',NULL,'2025-04-17 11:55:43','2025-04-19'),
(40,81,41,2,'adsad','Returned','2025-04-13 21:18:21',NULL,'2025-04-24 13:02:10','2025-04-24'),
(41,81,4,2,'hello <br><br>sdfsdfsdfsdf&nbsp; sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf <br>SDFdsfsdfsdfsdfsdsdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf <br>sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf <br>sdfsdfsdfsdf sdfsdfsdfsdf sdfsdfsdfsdf <br><br>best regards','Returned','2025-04-14 19:41:01',NULL,'2025-04-17 11:59:04','2025-04-19'),
(42,81,4,1,'sdasdasd','Returned','2025-04-17 11:47:03',NULL,'2025-04-23 19:25:32','2025-04-23'),
(43,82,4,2,'<p>asdasdasdasdasdas<b>dasdasdasdsadasd</b></p>','Returned','2025-04-17 11:47:21',NULL,'2025-04-17 12:04:26','2025-04-21'),
(44,99,4,21,'asdasdasdasd','Returned','2025-04-17 11:47:32',NULL,'2025-04-17 12:04:25','2025-04-24'),
(45,99,4,23,'asdsadasdasd','Rejected','2025-04-17 11:47:44',NULL,'2025-04-24 13:02:09',NULL),
(46,81,4,23,'esfesfse <br><br>sdfsdfdsf<br>SDFSDFSDFSDFDSFsdf<br>sfsdfsdfsdf','Returned','2025-04-23 19:13:40',NULL,'2025-04-24 00:51:49','2025-04-24'),
(47,81,4,12,'<p><b>hello sir,</b></p><p>testinfg messsage <br><br>best regards,</p>','Returned','2025-04-24 00:50:54',NULL,'2025-04-24 10:15:24','2025-04-24'),
(48,81,4,5,'rwerere','Returned','2025-04-24 13:48:19',NULL,'2025-04-24 20:15:26','2025-04-24'),
(49,98,4,5,'is deducted?','Returned','2025-04-24 13:49:30',NULL,'2025-04-24 13:49:50','2025-04-24'),
(50,102,4,122,'is validated?','Returned','2025-04-24 13:50:33',NULL,'2025-04-24 13:50:50','2025-04-24'),
(51,100,4,12,'asdasdasd','Rejected','2025-04-25 20:01:40',NULL,'2025-04-25 22:40:38',NULL),
(52,98,4,5,'fsdfsdf','Returned','2025-04-25 22:34:59',NULL,'2025-04-25 22:36:36','2025-04-25'),
(53,82,4,22,'adasdsad','Rejected','2025-04-28 07:35:00',NULL,'2025-04-28 09:04:25',NULL),
(54,88,4,2,'sdfsdfsdf','Rejected','2025-04-28 07:35:06',NULL,'2025-04-28 09:06:11',NULL),
(55,97,4,32,'sdfsdfsdf','Pending','2025-04-28 07:35:12',NULL,NULL,NULL);

/*Table structure for table `fm_resources` */

DROP TABLE IF EXISTS `fm_resources`;

CREATE TABLE `fm_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('Available','In Maintenance','Damaged') DEFAULT 'Available',
  `last_maintenance` date DEFAULT NULL,
  `next_maintenance` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `fm_resources` */

insert  into `fm_resources`(`id`,`name`,`category`,`quantity`,`location`,`status`,`last_maintenance`,`next_maintenance`,`created_at`) values 
(81,'Impact Tool','Hardware',112,'Storage room','Available','2025-01-01','2024-12-26','2024-12-10 00:44:08'),
(82,'RJ45','Hardware',102,'2nd Floor','Available','2025-01-01','2025-01-03','2024-12-10 00:44:37'),
(87,'System Unit','Hardware',12,'2nd Floor','Available','2024-12-17','2024-12-25','2024-12-11 04:16:42'),
(88,'Cable','Hardware',1000,'IT Department','Available','3232-02-12','0222-12-21','2024-12-11 17:59:19'),
(90,'Computer Monitor','Hardware',125,'IT Department','Available','2121-02-12','2222-02-12','2024-12-15 18:40:44'),
(97,'Volleyball','Sports',112,'PEH Depertment','Available','2025-01-26','2025-01-26','2025-01-26 19:46:08'),
(98,'Basketball','Sports',96,'PEH Depertment','Available','2025-01-26','2025-01-26','2025-01-26 19:46:54'),
(99,'Chalk','Utilities',600,'Dean','Available','2025-01-26','2025-01-26','2025-01-27 02:10:58'),
(100,'Pentel Pen','Utilities',12,'test','Available','2025-02-20','2025-02-21','2025-02-21 04:52:34'),
(102,'test','Utilities',122,'test','Available','2025-03-28','2025-03-28','2025-03-28 04:47:51');

/*Table structure for table `fm_rooms` */

DROP TABLE IF EXISTS `fm_rooms`;

CREATE TABLE `fm_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `status` enum('Available','Booked') DEFAULT 'Available',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `fm_rooms` */

insert  into `fm_rooms`(`id`,`name`,`location`,`capacity`,`status`) values 
(2,'Room 2','Ground floor',50,'Booked'),
(3,'IT Room','BCP 2nd floor',50,'Booked'),
(4,'Room 1','Ground floor',50,'Booked'),
(5,'Room 3','1st floor main building',50,'Booked'),
(6,'Room 5','1st floor main building',50,'Booked'),
(7,'Room 6','1st floor main building',50,'Booked'),
(8,'Room 5','3rd floor main building',30,'Booked'),
(9,'Room 13','3rd floor main building',4,'Booked'),
(10,'AVR ','2rd floor main building',233,'Available'),
(11,'Computer Laborary','2nd Floor',200,'Booked'),
(12,'Computer Laborary 3','4th floor main building',50,'Booked'),
(13,'Computer Laborary 2','3rd floor main building',50,'Booked'),
(14,'Auditory Room ','2rd floor main building',100,'Available'),
(16,'Covered Court','Ground floor',500,'Available'),
(17,'GYM','Ground floor',100,'Available'),
(18,'Room 6','4th floor main building',30,'Available'),
(20,'Room 4','Ground floor',30,'Booked');

/*Table structure for table `holiday` */

DROP TABLE IF EXISTS `holiday`;

CREATE TABLE `holiday` (
  `id` int(11) NOT NULL,
  `holiday` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `holiday` */

insert  into `holiday`(`id`,`holiday`,`type`,`date`) values 
(2,'Maundy Thursday','Regular','2025-04-17'),
(3,'Good Friday','Regular','2025-04-18'),
(4,'Araw ng Kagitingan','Regular','2025-04-09'),
(5,'Labor Day','Regular','2025-05-01'),
(6,'Independence Day','Regular','2025-06-12'),
(7,'National Heroes Day','Regular','2025-08-25'),
(8,'Bonifacio Day','Regular','2025-11-30'),
(9,'Christmas Day','Regular','2025-12-25'),
(10,'Rizal Day','Regular','2025-12-30'),
(11,'Chinese New Year','Non-working','2025-01-29'),
(12,'EDSA People Power Revolution Anniversary','Non-working','2025-02-25'),
(13,'Black Saturday','Non-working','2025-04-19'),
(14,'Ninoy Aquino Day','Non-working','2025-08-21'),
(15,'All Saints\' Day','Non-working','2025-11-01'),
(16,'Feast of the Immaculate Conception of Mary','Non-working','2025-12-08'),
(17,'Christmas Eve','Non-working','2025-12-24'),
(18,'New Year\'s Eve','Non-working','2025-12-31'),
(19,'New Year','Regular','2025-01-01');

/*Table structure for table `incentives` */

DROP TABLE IF EXISTS `incentives`;

CREATE TABLE `incentives` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `amount` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `incentives` */

insert  into `incentives`(`id`,`type`,`amount`) values 
(1,'Bonus',2000);

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
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `job_postings` */

insert  into `job_postings`(`id`,`job_title`,`job_description`,`requirements`,`location`,`salary_range`,`status`,`created_at`,`DepartmentID`,`EmployeeID`) values 
(57,'HR Manager','Oversee the HR department and manage all HR functions, including recruitment, employee relations, training, and compliance.','Bachelor’s degree in Human Resources, Business Administration, or related field\r\n5+ years of HR experience, with at least 2 years in a management role\r\nStrong knowledge of labor laws and regulations.','Bestlink College of the Philippines','PHP 60,000 - PHP 100,000 per month.','Open','2024-11-03 03:05:54',8,44),
(58,'HR Coordinator','Assist in recruitment activities, onboarding of new hires, and maintaining employee records.\r\nSupport HR projects and initiatives, including training and employee engagement programs.','Bachelor’s degree in Human Resource Management or related field.\r\n1-3 years of HR experience.\r\nGood communication and organizational skills.','Bestlink College of the Philippines','PHP 25,000 - PHP 45,000 per month.','Open','2024-11-03 04:30:44',8,47),
(59,'Systems Administrator','Manage and maintain school servers, networks, and computer systems.\r\nEnsure system availability, security, and performance.','Bachelor’s degree in Computer Science, Information Technology, or related field.\r\n3-5 years of experience in systems administration.\r\nFamiliarity with server management and network protocols.','Bestlink College of the Philippines','PHP 30,000 - PHP 60,000 per month.','Open','2024-11-03 04:31:56',9,48),
(60,'Network Administrator','Configure, maintain, and troubleshoot the school\'s network infrastructure.\r\nMonitor network performance and security.','Bachelor’s degree in Information Technology, Network Engineering, or related field.\r\n3+ years of experience in network administration.\r\nKnowledge of network protocols, routers, and firewalls.','Bestlink College of the Philippines','PHP 30,000 - PHP 55,000 per month.','Open','2024-11-03 04:32:31',9,49),
(61,'Maintenance Supervisor','Supervise maintenance staff and coordinate repair and maintenance activities for the school.\r\nEnsure that all facilities are safe and comply with relevant regulations.','Diploma or Bachelor’s degree in Engineering, Facilities Management, or related field.\r\n3-5 years of experience in facilities maintenance.\r\nKnowledge of building systems (HVAC, electrical, plumbing).','Bestlink College of the Philippines','PHP 30,000 - PHP 60,000 per month.','Closed','2024-11-03 04:34:00',11,50),
(62,'Software Engineer','Develop and maintain software applications.','Bachelor’s degree in Computer Science or related field.','Bestlink College of the Philippines','PHP 40,000 - PHP 70,000 per month.','Open','2025-01-26 19:14:16',9,51),
(63,'HR Manager','Oversee the HR department and manage all HR functions.','Bachelor’s degree in Human Resources.','Bestlink College of the Philippines','PHP 60,000 - PHP 100,000 per month.','Open','2025-01-26 19:14:16',8,52),
(64,'Network Administrator','Manage and maintain network infrastructure.','Bachelor’s degree in IT.','Bestlink College of the Philippines','PHP 30,000 - PHP 55,000 per month.','Open','2025-01-26 19:14:16',9,53),
(65,'Data Analyst','Analyze data and provide insights.','Bachelor’s degree in Statistics or related field.','Bestlink College of the Philippines','PHP 35,000 - PHP 60,000 per month.','Open','2025-01-26 19:14:16',10,46),
(66,'Web Developer','Develop and maintain websites.','Bachelor’s degree in Computer Science.','Bestlink College of the Philippines','PHP 40,000 - PHP 70,000 per month.','Open','2025-01-26 19:14:16',9,45),
(67,'Graphic Designer','Create visual concepts.','Bachelor’s degree in Design.','Bestlink College of the Philippines','PHP 25,000 - PHP 50,000 per month.','Open','2025-01-26 19:14:16',11,45),
(68,'Sales Executive','Drive sales and manage client relationships.','Bachelor’s degree in Business.','Bestlink College of the Philippines','PHP 30,000 - PHP 55,000 per month.','Open','2025-01-26 19:14:16',12,NULL),
(69,'Content Writer','Create content for various platforms.','Bachelor’s degree in Communications.','Bestlink College of the Philippines','PHP 25,000 - PHP 45,000 per month.','Closed','2025-01-26 19:14:16',10,NULL),
(70,'IT Support','Provide technical support to users.','Bachelor’s degree in IT.','Bestlink College of the Philippines','PHP 20,000 - PHP 40,000 per month.','Open','2025-01-26 19:14:16',9,NULL),
(71,'Project Manager','Manage projects from initiation to closure.','Bachelor’s degree in Management.','Bestlink College of the Philippines','PHP 50,000 - PHP 90,000 per month.','Open','2025-01-26 19:14:16',8,NULL),
(72,'TEST JOB','TEST JOB','TEST JOB','TEST JOB LOCATION','3000','Open','2025-04-01 19:34:57',15,NULL),
(73,'TESTING JOBS','TESTING JOBS','TESTING JOBS','BESTLINK','30000 - 50000','Open','2025-04-06 01:07:40',15,NULL),
(74,'JOB TESTING','JOB TESTING','JOB TESTING','BESTLINK','30000 - 50000','Open','2025-04-06 01:14:10',15,NULL),
(77,'IT Specialist','ASDASD','SADASDAS','Bestlink College of the Philippines','₱25,000 - ₱30,000','Open','2025-04-27 19:17:33',9,NULL),
(78,'Operations Manager','asdfas','dasdasdas','Bestlink College of the Philippines','₱30,000 - ₱50,000','Open','2025-04-27 19:19:52',10,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `jobroles` */

insert  into `jobroles`(`JobRoleID`,`JobTitle`,`JobDescription`,`DepartmentID`,`SalaryRangeMin`,`SalaryRangeMax`) values 
(1,'HR Manager','Oversees HR operations.',8,50000.00,80000.00),
(2,'IT Specialist','Manages IT infrastructure.',9,45000.00,70000.00),
(3,'Financial Analyst','Analyzes financial data.',10,55000.00,85000.00),
(4,'Marketing Coordinator','Coordinates marketing campaigns.',11,40000.00,60000.00),
(5,'Operations Manager','Manages daily operations.',12,60000.00,90000.00);

/*Table structure for table `leave_requests` */

DROP TABLE IF EXISTS `leave_requests`;

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employeeId` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `department` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `head` varchar(100) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `leave_requests` */

insert  into `leave_requests`(`id`,`employeeId`,`name`,`leave_type`,`date`,`department`,`message`,`head`,`status`) values 
(1,7,'Lebron James','Annual Leave','2025-04-11','','asd','Lebron James','pending'),
(2,7,'Lebron James','Annual Leave','2025-04-11','','asd','Lebron James','pending'),
(3,7,'Lebron James','Maternity Leave','2025-04-25','Computer Studies','dsasd','Lebron James','pending'),
(4,7,'Lebron James','Bereavement Leave','2025-04-25','Computer Studies','das','Lebron James','pending'),
(5,2,'jsmith','Medical Leave','2025-04-12','Computer Studies','dasads','jsmith','pending'),
(6,2,'jsmith','Annual Leave','2025-04-23','Computer Studies','1234556','jsmith','pending'),
(7,2,'jsmith','Study Leave','2025-04-11','Computer Studies','lkjklhkjgj','Lebron James','pending'),
(8,4,'SAWADA','Casual Leave','2025-04-04','IT Department','123333','SAWADA','approved'),
(9,4,'SAWADA','Bereavement Leave','2025-04-05','IT Department','09090909','SAWADA',''),
(10,4,'SAWADA','Annual Leave','2025-04-24','IT Department','\\]\\]\\\\]\\]\\','SAWADA',''),
(11,4,'SAWADA','Unpaid Leave','2025-04-30','IT Department','LEAVE','SAWADA','pending'),
(12,44,'QWERTY','Annual Leave','2025-04-04','IT Department','leave123','QWERTY','pending'),
(13,4,'SAWADA','Annual Leave','2025-04-18','IT Department','1','manager','pending'),
(14,4,'SAWADA','Bereavement Leave','2025-04-25','IT Department','2','QWERTY','pending');

/*Table structure for table `leaveapplication` */

DROP TABLE IF EXISTS `leaveapplication`;

CREATE TABLE `leaveapplication` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `employeeId` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `department` varchar(50) NOT NULL,
  `message` varchar(250) NOT NULL,
  `status` varchar(255) DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `leaveapplication` */

insert  into `leaveapplication`(`id`,`employeeId`,`name`,`leave_type`,`date`,`department`,`message`,`status`) values 
(1,4,'employee','Maternity Leave','2025-04-16','','asdas','pending'),
(2,4,'employee','Casual Leave','2025-04-29','','asdasdas','pending'),
(3,4,'employee','Casual Leave','2025-04-18','','dasd','pending'),
(4,2,'jsmith','Paternity Leave','2025-04-26','Computer Studies','asdasdas','accepted'),
(5,4,'employee','Maternity Leave','2025-04-18','','poiuy','pending'),
(9,2,'jsmith','Unpaid Leave','2025-05-01','Computer Studies','tydfhjshg','pending'),
(16,4,'SAWADA','Study Leave','2025-04-23','IT Department','3','pending'),
(17,4,'SAWADA','Bereavement Leave','2025-04-26','IT Department','4','pending'),
(18,4,'SAWADA','Medical Leave','2025-04-13','IT Department','5','pending');

/*Table structure for table `leavetype` */

DROP TABLE IF EXISTS `leavetype`;

CREATE TABLE `leavetype` (
  `id` int(50) NOT NULL,
  `leave_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `leavetype` */

insert  into `leavetype`(`id`,`leave_type`) values 
(1,'Sick Leave'),
(2,'Casual Leave'),
(3,'Annual Leave'),
(4,'Maternity Leave'),
(5,'Paternity Leave'),
(6,'Unpaid Leave'),
(7,'Bereavement Leave'),
(8,'Study Leave'),
(9,'Compensatory Leave'),
(10,'Medical Leave');

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` varchar(50) DEFAULT 'general',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `notifications` */

insert  into `notifications`(`id`,`user_id`,`message`,`status`,`created_at`,`type`) values 
(1,4,'New booking request for Room.2','unread','2025-04-13 11:27:11','booking'),
(2,41,'New booking request for Room.3','unread','2025-04-13 11:28:10','booking'),
(3,4,'New booking request for Room.4','unread','2025-04-13 13:24:39','booking'),
(4,4,'New booking request for Room.7','unread','2025-04-13 13:24:46','booking'),
(5,4,'New booking request for Room.6','unread','2025-04-13 13:24:55','booking'),
(6,36,'Your booking #58 has been rejected. Please contact support for more information.','unread','2025-04-13 13:36:06','booking_status'),
(7,36,'Your booking #60 has been rejected. Please contact support for more information.','unread','2025-04-13 13:36:31','booking_status'),
(8,36,'Your booking #61 has been rejected. Please contact support for more information.','unread','2025-04-13 13:39:08','booking_status'),
(9,36,'Your booking #62 has been rejected. Please contact support for more information.','unread','2025-04-13 13:40:03','booking_status'),
(10,36,'Your booking #59 has been rejected. Please contact support for more information.','unread','2025-04-13 13:40:24','booking_status'),
(11,4,'New booking request for Room.5','unread','2025-04-13 13:41:48','booking'),
(12,4,'New booking request for Room.8','unread','2025-04-13 13:41:57','booking'),
(13,36,'Your booking #63 has been approved. Thank you for using our service!','unread','2025-04-13 13:42:10','booking_status'),
(14,4,'New booking request for Room.12','unread','2025-04-13 19:53:50','booking'),
(15,4,'New booking request for Room.13','unread','2025-04-13 20:17:21','booking'),
(16,4,'New Resource/s request for asset. ','unread','2025-04-13 21:11:33','resource'),
(17,4,'New Resource/s request for asset. 97','unread','2025-04-13 21:12:08','resource'),
(18,41,'New Resource/s request for asset. ID:81','unread','2025-04-13 21:18:21','resource'),
(19,36,'Your booking #64 has been approved. Thank you for using our service!','unread','2025-04-14 19:37:48','booking_status'),
(20,36,'Your booking #65 has been approved. Thank you for using our service!','unread','2025-04-14 19:37:48','booking_status'),
(21,36,'Your booking #66 has been approved. Thank you for using our service!','unread','2025-04-14 19:37:49','booking_status'),
(22,36,'Your booking #68 has been rejected. Please contact support for more information.','unread','2025-04-14 19:37:50','booking_status'),
(23,36,'Your booking #69 has been rejected. Please contact support for more information.','unread','2025-04-14 19:37:51','booking_status'),
(24,4,'New Resource/s request for asset. ID:81','unread','2025-04-14 19:41:01','resource'),
(25,4,'New booking request for Room. ID:14','unread','2025-04-14 20:27:39','booking'),
(26,4,'New booking request for Room. ID:17','unread','2025-04-14 20:31:27','booking'),
(27,4,'New booking request for Room. ID:18','unread','2025-04-14 20:32:39','booking'),
(28,4,'New Resource/s request for asset. ID:81','unread','2025-04-17 11:47:03','resource'),
(29,4,'New Resource/s request for asset. ID:82','unread','2025-04-17 11:47:21','resource'),
(30,4,'New Resource/s request for asset. ID:99','unread','2025-04-17 11:47:32','resource'),
(31,4,'New Resource/s request for asset. ID:99','unread','2025-04-17 11:47:44','resource'),
(32,36,'Your request #41 has been approved. Thank you for using our service!','unread','2025-04-17 11:59:04','resource_status'),
(33,36,'Your request #44 has been approved. Thank you for using our service!','unread','2025-04-17 12:04:25','resource_status'),
(34,36,'Your request #43 has been approved. Thank you for using our service!','unread','2025-04-17 12:04:26','resource_status'),
(35,4,'New booking request for Room. ID:2','unread','2025-04-23 19:09:11','booking'),
(36,4,'New booking request for Room. ID:4','unread','2025-04-23 19:12:56','booking'),
(37,4,'New Resource/s request for asset. ID:81','unread','2025-04-23 19:13:40','resource'),
(38,4,'New booking request for Room. ID:6','unread','2025-04-23 19:23:44','booking'),
(39,36,'Your request #42 has been approved. Thank you for using our service!','unread','2025-04-23 19:25:32','resource_status'),
(40,4,'New booking request for Room. ID:7','unread','2025-04-23 19:52:10','booking'),
(41,4,'New booking request for Room. ID:8','unread','2025-04-23 19:53:26','booking'),
(42,4,'New booking request for Room. ID:3','unread','2025-04-23 20:12:12','booking'),
(43,4,'New booking request for Room. ID:5','unread','2025-04-23 20:13:46','booking'),
(44,4,'New booking request for Room. ID:9','unread','2025-04-23 21:22:57','booking'),
(45,4,'New booking request for Room. ID:10','unread','2025-04-23 21:23:50','booking'),
(46,4,'New booking request for Room. ID:14','unread','2025-04-24 00:46:37','booking'),
(47,4,'New Resource/s request for asset. ID:81','unread','2025-04-24 00:50:54','resource'),
(48,36,'Your request #46 has been approved. Thank you for using our service!','unread','2025-04-24 00:51:49','resource_status'),
(49,36,'Your request #47 has been approved. Thank you for using our service!','unread','2025-04-24 10:15:24','resource_status'),
(50,36,'Your request #45 has been rejected. Please contact support for more information.','unread','2025-04-24 13:02:09','resource_status'),
(51,36,'Your request #40 has been approved. Thank you for using our service!','unread','2025-04-24 13:02:10','resource_status'),
(52,4,'New booking request for Room. ID:3','unread','2025-04-24 13:47:43','booking'),
(53,4,'New Resource/s request for asset. ID:81','unread','2025-04-24 13:48:19','resource'),
(54,4,'New Resource/s request for asset. ID:98','unread','2025-04-24 13:49:30','resource'),
(55,36,'Your request #49 has been approved. Thank you for using our service!','unread','2025-04-24 13:49:50','resource_status'),
(56,4,'New Resource/s request for asset. ID:102','unread','2025-04-24 13:50:33','resource'),
(57,36,'Your request #50 has been approved. Thank you for using our service!','unread','2025-04-24 13:50:50','resource_status'),
(58,40,'Your request #48 has been approved. Thank you for using our service!','unread','2025-04-24 20:15:26','resource_status'),
(59,4,'New booking request for Room. ID:5','unread','2025-04-25 20:01:20','booking'),
(60,4,'New Resource/s request for asset. ID:100','unread','2025-04-25 20:01:40','resource'),
(61,4,'New Resource/s request for asset. ID:98','unread','2025-04-25 22:34:59','resource'),
(62,44,'Your request #52 has been approved. Thank you for using our service!','unread','2025-04-25 22:36:36','resource_status'),
(63,4,'New booking request for Room. ID:20','unread','2025-04-25 22:39:50','booking'),
(64,36,'Your request #51 has been rejected. Please contact support for more information.','unread','2025-04-25 22:40:38','resource_status'),
(65,4,'New booking request for Room. ID:7','unread','2025-04-28 07:34:22','booking'),
(66,4,'New booking request for Room. ID:8','unread','2025-04-28 07:34:30','booking'),
(67,4,'New booking request for Room. ID:6','unread','2025-04-28 07:34:43','booking'),
(68,4,'New booking request for Room. ID:9','unread','2025-04-28 07:34:52','booking'),
(69,4,'New Resource/s request for asset. ID:82','unread','2025-04-28 07:35:00','resource'),
(70,4,'New Resource/s request for asset. ID:88','unread','2025-04-28 07:35:06','resource'),
(71,4,'New Resource/s request for asset. ID:97','unread','2025-04-28 07:35:12','resource'),
(72,44,'Your request #53 has been rejected. Please contact support for more information.','unread','2025-04-28 09:04:25','resource_status'),
(73,44,'Your request #54 has been rejected. Please contact support for more information.','unread','2025-04-28 09:06:11','resource_status');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `performanceevaluations` */

insert  into `performanceevaluations`(`EvaluationID`,`EmployeeID`,`EvaluationDate`,`EvaluatorID`,`Score`,`Comments`,`EvaluationType`) values 
(1,45,'2025-01-26',NULL,85,'Good performance in the first quarter.','Quarterly'),
(2,46,'2025-01-26',NULL,90,'Excellent performance in the first quarter.','Quarterly'),
(3,47,'2025-01-26',NULL,78,'Satisfactory performance in the first quarter.','Quarterly'),
(4,48,'2025-01-26',NULL,82,'Good performance in the first quarter.','Quarterly'),
(5,49,'2025-01-26',NULL,88,'Very good performance in the first quarter.','Quarterly'),
(6,50,'2025-01-26',NULL,80,'Good performance in the first quarter.','Quarterly'),
(7,51,'2025-01-26',NULL,75,'Needs improvement in the first quarter.','Quarterly'),
(8,52,'2025-01-26',NULL,92,'Outstanding performance in the first quarter.','Quarterly'),
(9,53,'2025-01-26',NULL,70,'Satisfactory performance in the first quarter.','Quarterly'),
(10,54,'2025-01-26',NULL,85,'Good performance in the first quarter.','Quarterly'),
(11,44,'2025-03-22',47,87,'Good performance in the first quarter.','Quarterly');

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`description`) values 
(1,'CREATE',NULL),
(2,'EDIT',NULL),
(3,'DELETE',NULL),
(4,'VIEW',NULL);

/*Table structure for table `rate` */

DROP TABLE IF EXISTS `rate`;

CREATE TABLE `rate` (
  `id` int(50) NOT NULL,
  `employeeId` int(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `rate` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `rate` */

insert  into `rate`(`id`,`employeeId`,`name`,`department`,`rate`) values 
(1,1,'John Doe','Faculty',150),
(2,2,'Jane Smith','Faculty',130),
(3,3,'Michael Johnson','Faculty',180),
(4,4,'Emily Davis','Faculty',140),
(5,5,'Chris Lee','Faculty',160),
(6,6,'Sara Wilson','Faculty',170),
(7,7,'James Brown','Faculty',120),
(8,8,'Laura White','Faculty',175),
(9,9,'Kevin Harris','Faculty',145),
(10,10,'Olivia Moore','Faculty',180);

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

/*Table structure for table `retention_programs` */

DROP TABLE IF EXISTS `retention_programs`;

CREATE TABLE `retention_programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `program_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `frequency` enum('Monthly','Yearly','Ongoing') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `eligibility` varchar(255) DEFAULT NULL,
  `reward` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `retention_programs` */

insert  into `retention_programs`(`id`,`program_name`,`description`,`frequency`,`start_date`,`end_date`,`eligibility`,`reward`,`status`) values 
(4,'Employee of the Month1','Employee of the Month','Monthly','2025-04-20','0000-00-00','All Employee','CERTIFICATE AND BONUS','Active'),
(6,'awdawd','awdawd','Yearly','2025-04-20',NULL,'All Employee','CERTIFICATE AND BONUS','Active'),
(7,'rwerer','ewrwer','Monthly','2025-04-25','2025-04-28','erer','erwer','Active');

/*Table structure for table `role_permissions` */

DROP TABLE IF EXISTS `role_permissions`;

CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `role_permissions` */

insert  into `role_permissions`(`role_id`,`permission_id`) values 
(1,1),
(1,2),
(1,3),
(1,4),
(2,1),
(2,2),
(2,3),
(2,4),
(3,1),
(3,2),
(3,4),
(4,1),
(4,2),
(4,4),
(5,4),
(6,4),
(7,1),
(7,4),
(8,1),
(8,4),
(9,1),
(9,2),
(9,3),
(9,4),
(10,1),
(10,2);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `RoleID` int(11) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(50) NOT NULL,
  `Description` text DEFAULT NULL,
  PRIMARY KEY (`RoleID`),
  UNIQUE KEY `RoleName` (`RoleName`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `roles` */

insert  into `roles`(`RoleID`,`RoleName`,`Description`) values 
(1,'admin',''),
(2,'superadmin',''),
(3,'manager',''),
(4,'employee',''),
(5,'staff',''),
(6,'applicant','');

/*Table structure for table `succession_candidates` */

DROP TABLE IF EXISTS `succession_candidates`;

CREATE TABLE `succession_candidates` (
  `candidate_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `target_position` varchar(255) NOT NULL,
  `status` enum('In Development','Ready for Promotion','Not Ready') DEFAULT 'In Development',
  `assigned_by` int(11) DEFAULT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`candidate_id`),
  KEY `employee_id` (`employee_id`),
  KEY `assigned_by` (`assigned_by`),
  CONSTRAINT `succession_candidates_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`EmployeeID`),
  CONSTRAINT `succession_candidates_ibfk_2` FOREIGN KEY (`assigned_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `succession_candidates` */

insert  into `succession_candidates`(`candidate_id`,`employee_id`,`target_position`,`status`,`assigned_by`,`assigned_at`) values 
(2,87,'HR Manager','Not Ready',36,'2025-04-19 23:00:00'),
(3,78,'IT Support','In Development',36,'2025-04-19 23:04:11'),
(4,44,'wererwer','In Development',36,'2025-04-24 23:42:40');

/*Table structure for table `survey_responses` */

DROP TABLE IF EXISTS `survey_responses`;

CREATE TABLE `survey_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `survey_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`survey_data`)),
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `survey_responses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `survey_responses` */

insert  into `survey_responses`(`id`,`user_id`,`survey_data`,`submission_date`) values 
(15,46,'{\"workforce\":\"1\",\"performance\":\"5\",\"efficient\":\"2\",\"talent\":\"5\",\"retention\":\"3\",\"question1\":\"4\",\"suggestions\":\"gghfghfhfghfh\"}','2025-04-22 12:47:03'),
(16,39,'{\"workforce\":\"5\",\"performance\":\"5\",\"efficient\":\"5\",\"talent\":\"5\",\"retention\":\"5\",\"question1\":\"5\",\"suggestions\":\"gghfghfhfghfh\"}','2025-04-22 12:47:03'),
(17,46,'{\"workforce\":\"2\",\"performance\":\"1\",\"efficient\":\"4\",\"talent\":\"2\",\"retention\":\"5\",\"question1\":\"5\",\"suggestions\":\"gghfghfhfghfh\"}','2025-04-22 12:48:07'),
(18,39,'{\"workforce\":\"1\",\"performance\":\"2\",\"efficient\":\"3\",\"talent\":\"4\",\"retention\":\"5\",\"question1\":\"5\",\"suggestions\":\"gghfghfhfghfh\"}','2025-04-22 12:48:07'),
(19,46,'{\"workforce\":\"5\",\"performance\":\"5\",\"efficient\":\"5\",\"talent\":\"5\",\"retention\":\"5\",\"question1\":\"5\",\"suggestions\":\"gghfghfhfghfh\"}','2025-04-22 12:48:11'),
(20,39,'{\"workforce\":\"5\",\"performance\":\"5\",\"efficient\":\"5\",\"talent\":\"5\",\"retention\":\"5\",\"question1\":\"5\",\"suggestions\":\"gghfghfhfghfh\"}','2025-04-22 12:48:11'),
(22,4,'{\"workforce\":\"5\",\"performance\":\"5\",\"efficient\":\"5\",\"talent\":\"5\",\"retention\":\"5\",\"question1\":\"5\",\"suggestions\":\"Suggestion testing\"}','2025-04-24 01:01:36'),
(23,50,'{\"workforce\":\"3\",\"performance\":\"4\",\"efficient\":\"4\",\"talent\":\"3\",\"retention\":\"4\",\"question1\":\"4\",\"suggestions\":\"testing\"}','2025-04-24 21:58:01');

/*Table structure for table `training_applications` */

DROP TABLE IF EXISTS `training_applications`;

CREATE TABLE `training_applications` (
  `application_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `training_id` int(11) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `applied_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`application_id`),
  KEY `employee_id` (`employee_id`),
  KEY `training_id` (`training_id`),
  CONSTRAINT `training_applications_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`EmployeeID`),
  CONSTRAINT `training_applications_ibfk_2` FOREIGN KEY (`training_id`) REFERENCES `training_sessions` (`training_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `training_applications` */

insert  into `training_applications`(`application_id`,`employee_id`,`training_id`,`status`,`applied_at`) values 
(27,87,16,'Pending','2025-04-05 23:40:35'),
(28,87,3,'Pending','2025-04-06 00:03:06'),
(29,87,17,'Pending','2025-04-06 00:03:10'),
(30,90,16,'Pending','2025-04-25 00:17:14');

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `training_assignments` */

insert  into `training_assignments`(`assignment_id`,`training_id`,`employee_id`,`status`,`completion_date`) values 
(15,3,87,'Completed','2025-04-09');

/*Table structure for table `training_grades` */

DROP TABLE IF EXISTS `training_grades`;

CREATE TABLE `training_grades` (
  `grade_id` int(11) NOT NULL AUTO_INCREMENT,
  `assignment_id` int(11) DEFAULT NULL,
  `grade` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`grade_id`),
  KEY `assignment_id` (`assignment_id`),
  CONSTRAINT `training_grades_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `training_assignments` (`assignment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `training_grades` */

insert  into `training_grades`(`grade_id`,`assignment_id`,`grade`) values 
(4,15,5.00);

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `training_sessions` */

insert  into `training_sessions`(`training_id`,`training_name`,`training_description`,`trainer`,`department`,`training_materials`,`created_at`) values 
(3,'BASKETBALL','BRING YOUR OWN BALLPEN','LeBron James',12,'SAWADA','2024-11-14 09:18:30'),
(16,'ASDFGH','ASDFGH','ASDFGH',9,'ASDFGH','2025-04-02 01:18:44'),
(17,'TEST TRAINING','TEST TRAINING','TEST TRAINER',15,'TEST TRAINING','2025-04-06 01:19:31');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `trainingprograms` */

insert  into `trainingprograms`(`TrainingID`,`TrainingName`,`Description`,`StartDate`,`EndDate`,`Instructor`,`EmployeeID`) values 
(1,'Leadership Training','Training for developing leadership skills.','2025-01-26','2025-02-25','Jane Smith',45),
(2,'Technical Skills Development','Enhance technical skills for software development.','2025-01-26','2025-02-25','Alice Johnson',46),
(3,'Communication Skills','Improve communication skills for better teamwork.','2025-01-26','2025-02-25','Bob Brown',47),
(4,'Project Management','Training on project management methodologies.','2025-01-26','2025-02-25','Charlie Davis',48),
(5,'Sales Techniques','Training on effective sales techniques.','2025-01-26','2025-02-25','Diana Evans',49),
(6,'Customer Service Excellence','Training on providing excellent customer service.','2025-01-26','2025-02-25','Ethan Foster',50),
(7,'Time Management','Training on effective time management skills.','2025-01-26','2025-02-25','Fiona Green',51),
(8,'Conflict Resolution','Training on resolving workplace conflicts.','2025-01-26','2025-02-25','George Harris',52),
(9,'Creative Thinking','Training on enhancing creative thinking skills.','2025-01-26','2025-02-25','Hannah Ivers',53),
(10,'Team Building','Training on building effective teams.','2025-01-26','2025-02-25','Jane Smith',54),
(11,'Basic Programming Training','Study Basic Programming','2025-03-22','2025-03-31',NULL,44);

/*Table structure for table `user_roles` */

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`RoleID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_roles` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` enum('admin','employee','manager','superadmin','New Hire','staff') NOT NULL DEFAULT 'admin',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastLogin` datetime DEFAULT current_timestamp(),
  `applicant_id` int(11) DEFAULT NULL,
  `onboarding_step` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Username` (`username`),
  KEY `fk_applicant` (`applicant_id`),
  CONSTRAINT `fk_applicant` FOREIGN KEY (`applicant_id`) REFERENCES `applicants` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`usertype`,`createdAt`,`lastLogin`,`applicant_id`,`onboarding_step`) values 
(4,'employee','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','employee','2024-09-25 07:23:39',NULL,43,4),
(36,'admin','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','admin','2024-11-14 07:45:50','2024-11-13 00:00:00',49,4),
(39,'manager','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','manager','2024-11-14 08:02:44','2024-11-14 00:00:00',44,4),
(40,'superadmin','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','superadmin','2025-01-26 19:14:16','2025-01-26 11:14:16',52,4),
(41,'nonteaching','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','employee','2025-01-26 19:14:16','2025-01-26 11:14:16',53,4),
(42,'teaching','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','manager','2025-01-26 19:14:16','2025-01-26 11:14:16',54,4),
(43,'bobbrown','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','employee','2025-01-26 19:14:16','2025-01-26 11:14:16',55,4),
(44,'charliedavis','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','employee','2025-01-26 19:14:16','2025-01-26 11:14:16',56,4),
(45,'dianaevans','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','employee','2025-01-26 19:14:16','2025-01-26 11:14:16',57,4),
(46,'ethanfoster','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','employee','2025-01-26 19:14:16','2025-01-26 11:14:16',58,4),
(47,'fionagreen','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','employee','2025-01-26 19:14:16','2025-01-26 11:14:16',59,4),
(48,'georgeharris','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','employee','2025-01-26 19:14:16','2025-01-26 11:14:16',60,4),
(49,'hannahivers','$2y$10$IO1z7hhGf8TlAOvl6G6KDuaUagMhYU10fhmDc1DV8h8ahMe25dGMq','employee','2025-01-26 19:14:16','2025-01-26 11:14:16',61,4),
(50,'curry','$2y$10$G2d9nlh.vONhotSaKED9t.7jQ7LKENxYEQDGuYJGmi6tvQUweveRe','employee','2025-03-30 23:15:46','2025-03-30 15:15:46',51,4),
(51,'jeremy','$2y$10$4p8IAOQXo3Vs9iL2Iqt4/uI/67YEK8JpN3Hl32efwJHG2UUhJ/yG2','employee','2025-03-31 03:29:55','2025-03-30 19:29:55',67,4),
(52,'qwe','$2y$10$pS3HTrwvopNbcGVQyML03.yJ9IFpn2Gpn9qOJVbD1.7IzBwuZiw4q','employee','2025-03-31 03:38:56','2025-03-30 19:38:56',63,4),
(53,'@Ap8080','$2y$10$jfhjrRwAj/iV5m/FCC7RZOI1kg/6P6xGhH.e/naQntETMjb.wMRoW','employee','2025-03-31 07:28:13','2025-03-30 23:28:13',68,4),
(54,'test','$2y$10$f0fGjn9Dp5tPN/R4rTum8On18JYrqBxmcSGZQ7GIkFAvpMs/SMILW','employee','2025-03-31 18:55:17','2025-03-31 10:55:17',50,4),
(55,'testapplicant','$2y$10$8IL60mGl5.Jg9/881xDX2.9VxvuoXBeEHXtQhHuef7mCXQiRX7mce','employee','2025-04-01 19:37:50','2025-04-01 11:37:50',69,4),
(59,'test3','$2y$10$BPFqQOUSxltXeK7K.cqwh.gZd2XHtEFz3UUCOcRnyjxwzgQWrcZPu','employee','2025-04-06 00:55:40','2025-04-05 16:55:40',70,4),
(60,'penpen','$2y$10$SClvv0Bd9VAcEktm9pNps.AsZvcnB1MtbBvypSGm0g5iv1cy5/r8q','admin','2025-04-06 01:16:57','2025-04-05 17:16:57',74,4),
(61,'penpen1','$2y$10$pKkAdb3G3FikrnLrDbv4..klBuTkSwrTC4YahwOsHomAXQsJslp6O','manager','2025-04-20 19:21:00','2025-04-20 11:21:00',72,4),
(62,'try','$2y$10$Mih5nr8Bp1Tjc2E6DTxgO.jE4eqJ2jNUrf3AizOGo/T4OE9mMecL6','staff','2025-04-28 11:51:01','2025-04-28 11:51:01',82,1),
(63,'apundar','$2y$10$uMcDJHZw3H7kItisEXEYeumxukykx1Zs9GEmzMq0sLtnR8mIZX49S','superadmin','2025-04-28 16:37:13','2025-04-28 16:37:13',80,4);

/*Table structure for table `daily_attendance_summary` */

DROP TABLE IF EXISTS `daily_attendance_summary`;

/*!50001 DROP VIEW IF EXISTS `daily_attendance_summary` */;
/*!50001 DROP TABLE IF EXISTS `daily_attendance_summary` */;

/*!50001 CREATE TABLE  `daily_attendance_summary`(
 `date` date ,
 `total_employees` bigint(21) ,
 `present_count` decimal(22,0) ,
 `absent_count` decimal(22,0) ,
 `late_count` decimal(22,0) ,
 `half_day_count` decimal(22,0) ,
 `total_hours` time 
)*/;

/*Table structure for table `employee_monthly_summary` */

DROP TABLE IF EXISTS `employee_monthly_summary`;

/*!50001 DROP VIEW IF EXISTS `employee_monthly_summary` */;
/*!50001 DROP TABLE IF EXISTS `employee_monthly_summary` */;

/*!50001 CREATE TABLE  `employee_monthly_summary`(
 `employee_id` int(11) ,
 `month_year` varchar(10) ,
 `total_days` bigint(21) ,
 `days_present` decimal(22,0) ,
 `days_absent` decimal(22,0) ,
 `days_late` decimal(22,0) ,
 `days_half_day` decimal(22,0) ,
 `total_working_hours` decimal(42,4) 
)*/;

/*View structure for view daily_attendance_summary */

/*!50001 DROP TABLE IF EXISTS `daily_attendance_summary` */;
/*!50001 DROP VIEW IF EXISTS `daily_attendance_summary` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `daily_attendance_summary` AS select `attendance`.`date` AS `date`,count(0) AS `total_employees`,sum(case when `attendance`.`status` = 'present' then 1 else 0 end) AS `present_count`,sum(case when `attendance`.`status` = 'absent' then 1 else 0 end) AS `absent_count`,sum(case when `attendance`.`status` = 'late' then 1 else 0 end) AS `late_count`,sum(case when `attendance`.`status` = 'half-day' then 1 else 0 end) AS `half_day_count`,sec_to_time(sum(time_to_sec(timediff(`attendance`.`time_out`,`attendance`.`time_in`)))) AS `total_hours` from `attendance` group by `attendance`.`date` */;

/*View structure for view employee_monthly_summary */

/*!50001 DROP TABLE IF EXISTS `employee_monthly_summary` */;
/*!50001 DROP VIEW IF EXISTS `employee_monthly_summary` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `employee_monthly_summary` AS select `attendance`.`employee_id` AS `employee_id`,date_format(`attendance`.`date`,'%Y-%m-01') AS `month_year`,count(0) AS `total_days`,sum(case when `attendance`.`status` = 'present' then 1 else 0 end) AS `days_present`,sum(case when `attendance`.`status` = 'absent' then 1 else 0 end) AS `days_absent`,sum(case when `attendance`.`status` = 'late' then 1 else 0 end) AS `days_late`,sum(case when `attendance`.`status` = 'half-day' then 1 else 0 end) AS `days_half_day`,sum(time_to_sec(timediff(`attendance`.`time_out`,`attendance`.`time_in`))) / 3600 AS `total_working_hours` from `attendance` group by `attendance`.`employee_id`,date_format(`attendance`.`date`,'%Y-%m-01') */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
