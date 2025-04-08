/*
SQLyog Community v12.4.0 (64 bit)
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

/*Table structure for table `complaints` */

DROP TABLE IF EXISTS `complaints`;

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `against_employee` int(11) NOT NULL,
  `complaint_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `submitted_by` int(11) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Resolved') DEFAULT 'Pending',
  `admin_response` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `submitted_by` (`submitted_by`),
  KEY `against_employee` (`against_employee`),
  CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`submitted_by`) REFERENCES `users` (`id`),
  CONSTRAINT `complaints_ibfk_2` FOREIGN KEY (`against_employee`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `complaints` */

/*Table structure for table `contracts` */

DROP TABLE IF EXISTS `contracts`;

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `contract_type` varchar(255) NOT NULL,
  `contract_file` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` enum('Active','Expired') DEFAULT 'Active',
  `reminder_date` date DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `contracts_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `contracts` */

/*Table structure for table `employees_manual` */

DROP TABLE IF EXISTS `employees_manual`;

CREATE TABLE `employees_manual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `employees_manual_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `employees_manual` */

/*Table structure for table `letter_of_intent` */

DROP TABLE IF EXISTS `letter_of_intent`;

CREATE TABLE `letter_of_intent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loi_type` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Pending','Reviewed','Approved','Rejected') DEFAULT 'Pending',
  `submitted_by` int(11) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `admin_response` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `letter_of_intent_ibfk_1` (`submitted_by`),
  CONSTRAINT `letter_of_intent_ibfk_1` FOREIGN KEY (`submitted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `letter_of_intent` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` enum('superadmin','admin','staff','employee') NOT NULL DEFAULT 'employee',
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `lastLogin` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_unique` (`username`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`usertype`,`email`,`first_name`,`last_name`,`phone`,`address`,`createdAt`,`lastLogin`) values 

(1,'s_admin','sadmin123','superadmin','sadmin123','Super','Admin','9277022002','Norzagaray, Bulacan','2025-04-08 12:28:19','2025-04-08 12:28:19'),

(2,'admin','admin123','admin','admin123','Admin','','9762241995','QC','2025-04-08 12:30:24','2025-04-08 12:30:29'),

(3,'employee','employee123','employee','employee123','Employee','','9162421902','CSJDM','2025-04-08 12:31:13','2025-04-08 12:31:15'),

(4,'staff','staff123','staff','staff123','Staff','','9212095224','CSJDM','2025-04-08 12:32:11','2025-04-08 12:31:35'),

(5,'jdoe','jdoe123','employee','jdoe123','John','Doe','9457775619','Caloocan','2025-04-08 16:30:18','2025-04-08 16:30:21'),

(6,'jclark','jclark123','staff','jclark123','Joseph','Clark','9356841532','Pampanga','2025-04-08 16:31:30','2025-04-08 16:31:32');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
