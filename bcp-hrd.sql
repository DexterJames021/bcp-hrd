CREATE DATABASE /*!32312 IF NOT EXISTS*/`bcp-hrd` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `bcp-hrd`;

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

DROP TABLE IF EXISTS `leave_requests`;

CREATE TABLE `leave_requests` (
  `employee_id` int(20) NOT NULL,
  `employee_name` varchar(50) DEFAULT NULL,
  `leave_type` varchar(50) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

insert  into `leave_requests`(`employee_id`,`employee_name`,`leave_type`,`start_date`,`end_date`,`reason`,`status`) values 

(101,'Shekynah Bernabe','Birthday Leave','2024-12-01','2024-12-01','my birthday','Pending'),

(102,'Leira Domingo','Vacation Leave','2024-12-15','2024-12-18','family trip','Pending'),

(103,'Glen Magat','Leave without Pay','2024-12-23','2024-12-28','take a break','Pending'),

(104,'Dareal Mosquito','Sick Leave','2024-12-09','2024-12-10','flu','Pending');

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `RoleID` int(11) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(50) NOT NULL,
  `Description` text DEFAULT NULL,
  PRIMARY KEY (`RoleID`),
  UNIQUE KEY `RoleName` (`RoleName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(255) NOT NULL DEFAULT 'admin',
  `email` varchar(100) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastLogin` date DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `Username` (`username`),
  UNIQUE KEY `Email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

insert  into `users`(`id`,`username`,`password`,`usertype`,`email`,`createdAt`,`lastLogin`) values 

(1,'jdoe','hashed_password1','admin','johndoe@example.com','2024-09-24 23:23:39',NULL),

(2,'jsmith','hashed_password2','employee','janesmith@example.com','2024-09-24 23:23:39',NULL),

(3,'mjohnson','hashed_password3','admin','mikejohnson@example.com','2024-09-24 23:23:39',NULL),

(4,'employee','employee123','employee','saralee@example.com','2024-09-24 23:23:39',NULL),

(5,'admin','admin123','admin','admin@gmail.com','0000-00-00 00:00:00','0000-00-00');
