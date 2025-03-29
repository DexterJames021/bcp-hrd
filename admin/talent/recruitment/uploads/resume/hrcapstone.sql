/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.27-MariaDB : Database - hrcapstone
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`hrcapstone` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `hrcapstone`;

/*Table structure for table `rc_tbl_applicant` */

DROP TABLE IF EXISTS `rc_tbl_applicant`;

CREATE TABLE `rc_tbl_applicant` (
  `applicant_id` int(11) NOT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `job_id` int(6) DEFAULT NULL,
  `app_date` date DEFAULT NULL,
  `app_stage` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `rc_tbl_applicant` */

insert  into `rc_tbl_applicant`(`applicant_id`,`candidate_id`,`job_id`,`app_date`,`app_stage`,`username`,`password`) values 
(1,1,6,'2024-05-28','for screening','biancyasis0101@gmail.com','61AGUILAR0915185485'),
(3,4,7,'2024-05-28','PASS INTERVIEW/ASSESMENT',' biancyasis0101@gmail.com',' 74AGUILAR09851854985');

/*Table structure for table `rc_tbl_applications` */

DROP TABLE IF EXISTS `rc_tbl_applications`;

CREATE TABLE `rc_tbl_applications` (
  `application_id` int(15) NOT NULL,
  `jobposting_id` int(15) NOT NULL,
  `candidate_id` int(15) NOT NULL,
  `application_date` date NOT NULL,
  `application_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `rc_tbl_applications` */

/*Table structure for table `rc_tbl_candidate` */

DROP TABLE IF EXISTS `rc_tbl_candidate`;

CREATE TABLE `rc_tbl_candidate` (
  `candidate_id` int(11) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `mi` varchar(20) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `ptn` varchar(30) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `resume` varchar(300) DEFAULT NULL,
  `job_source` varchar(50) DEFAULT NULL,
  `job_id` int(5) DEFAULT NULL,
  `Qualification` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `rc_tbl_candidate` */

insert  into `rc_tbl_candidate`(`candidate_id`,`firstname`,`mi`,`lastname`,`ptn`,`email`,`resume`,`job_source`,`job_id`,`Qualification`) values 
(1,'BIANCA MARIE','ASIS','AGUILAR','0915185485','biancyasis0101@gmail.com','GVD-CHAPTER-1-TO-5 (1) (1).pdf','SOCIAL MEDIA',6,''),
(2,'BIANCA MARIE','ASIS','AGUILAR','09305595660','biancyasis0101@gmail.com','GVD-CHAPTER-1-TO-5 (1) (1).pdf','STREAMING SERVICE AD',7,''),
(3,'BIANCA MARIE','ASIS','AGUILAR','09635595660','biancyasis0101@gmail.com','GVD-CHAPTER-1-TO-5 (1) (1).pdf','WORD OF MOUTH',7,'pending'),
(4,'BIANCA MARIE','ASIS','AGUILAR','09851854985','biancyasis0101@gmail.com','GVD-CHAPTER-1-TO-5 (1) (1).pdf','SOCIAL MEDIA',7,'pending'),
(5,'BIANCA MARIE','ASIS','AGUILAR','09305595660','biancyasis0101@gmail.com','GVD-CHAPTER-1-TO-5 (1) (1) (2).pdf','JOB FAIR',6,'pending');

/*Table structure for table `rc_tbl_interview` */

DROP TABLE IF EXISTS `rc_tbl_interview`;

CREATE TABLE `rc_tbl_interview` (
  `applicant_id` int(11) NOT NULL,
  `interview_id` int(11) NOT NULL,
  `interview_date` date NOT NULL,
  `comments` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `rc_tbl_interview` */

insert  into `rc_tbl_interview`(`applicant_id`,`interview_id`,`interview_date`,`comments`) values 
(3,1,'2024-05-28','langange asssesment and communication skills are good');

/*Table structure for table `rc_tbl_joboffer` */

DROP TABLE IF EXISTS `rc_tbl_joboffer`;

CREATE TABLE `rc_tbl_joboffer` (
  `applicant_id` int(11) NOT NULL,
  `joboffer_id` int(11) NOT NULL,
  `joboffer_date` date DEFAULT NULL,
  `file` varchar(300) DEFAULT NULL,
  `joboffer_status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `rc_tbl_joboffer` */

/*Table structure for table `rc_tbl_jobpostings` */

DROP TABLE IF EXISTS `rc_tbl_jobpostings`;

CREATE TABLE `rc_tbl_jobpostings` (
  `jobposting_id` int(15) NOT NULL,
  `job_id` int(15) NOT NULL,
  `posting_date` date NOT NULL,
  `exp_date` date NOT NULL,
  `job_source` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `rc_tbl_jobpostings` */

/*Table structure for table `rc_tbl_jobs` */

DROP TABLE IF EXISTS `rc_tbl_jobs`;

CREATE TABLE `rc_tbl_jobs` (
  `job_id` int(15) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `job_description` varchar(255) NOT NULL,
  `job_req` varchar(255) NOT NULL,
  `job_status` varchar(255) NOT NULL,
  `posting_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `rc_tbl_jobs` */

insert  into `rc_tbl_jobs`(`job_id`,`job_title`,`job_description`,`job_req`,`job_status`,`posting_date`) values 
(6,'Janitor','A Janitor, or Cleaner, is responsible for maintaining a cleanly facility by completing a variety of cleaning tasks. Their duties include mopping and vacuuming floors, cleaning surfaces with disinfectant and emptying trash cans or recycling bins.','A Janitor is in charge of keeping the workplace clean, organized and disinfected.','open','2024-05-26'),
(7,'Secretary','A Secretary is a professional who provides behind-the-scenes work for an office. Their tasks include organizing files, preparing documents, managing office supply inventory and scheduling appointments.','Answering phone calls and redirect them when necessary Managing the daily/weekly/monthly agenda and arrange new meetings and appointments Preparing and disseminating correspondence, memos and forms','open','2024-05-26');

/*Table structure for table `rc_tbl_screening` */

DROP TABLE IF EXISTS `rc_tbl_screening`;

CREATE TABLE `rc_tbl_screening` (
  `screening_id` int(11) NOT NULL,
  `applicant_id` int(11) DEFAULT NULL,
  `screening_date` date DEFAULT NULL,
  `comments` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `rc_tbl_screening` */

insert  into `rc_tbl_screening`(`screening_id`,`applicant_id`,`screening_date`,`comments`) values 
(1,1,'2024-05-28','sssss');

/*Table structure for table `rc_tbl_users` */

DROP TABLE IF EXISTS `rc_tbl_users`;

CREATE TABLE `rc_tbl_users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `rc_tbl_users` */

/*Table structure for table `rc_tblevents` */

DROP TABLE IF EXISTS `rc_tblevents`;

CREATE TABLE `rc_tblevents` (
  `event_id` int(5) NOT NULL,
  `title` varchar(100) NOT NULL,
  `file` varchar(300) NOT NULL,
  `description` varchar(200) NOT NULL,
  `link` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `rc_tblevents` */

insert  into `rc_tblevents`(`event_id`,`title`,`file`,`description`,`link`) values 
(2,'Event Title','healthy_lotion_lifestyle_1 (8).jpg','sample description','none');

/*Table structure for table `tm_department_it` */

DROP TABLE IF EXISTS `tm_department_it`;

CREATE TABLE `tm_department_it` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `it_task_id` int(10) NOT NULL,
  `it_task` varchar(200) NOT NULL,
  `it_task_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tm_department_it` */

/*Table structure for table `tm_department_list` */

DROP TABLE IF EXISTS `tm_department_list`;

CREATE TABLE `tm_department_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `department_id` int(10) NOT NULL,
  `department` varchar(200) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tm_department_list` */

insert  into `tm_department_list`(`id`,`department_id`,`department`,`description`) values 
(1,0,'Sales Department','The department comprises a sales team that works together to make sales, increase profitability and build and maintain relationships with customers to encourage repeat purchases and brand loyalty'),
(2,0,'Marketing Department','This department aims to sell as many products as possible in a sustainable manner. The team designs marketing strategies and combines the right marketing mix to satisfy customer needs and wants.'),
(3,0,'IT Department','The IT department has three major areas of concern, which include governance of the company\'s technological systems, maintenance of the infrastructure and functionality of the systems overall.');

/*Table structure for table `tm_department_marketing` */

DROP TABLE IF EXISTS `tm_department_marketing`;

CREATE TABLE `tm_department_marketing` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `marketing_task_id` int(10) NOT NULL,
  `marketing_task` varchar(200) NOT NULL,
  `marketing_task_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tm_department_marketing` */

/*Table structure for table `tm_department_sales` */

DROP TABLE IF EXISTS `tm_department_sales`;

CREATE TABLE `tm_department_sales` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sales_task_id` int(10) NOT NULL,
  `sales_task` varchar(200) NOT NULL,
  `sales_task_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tm_department_sales` */

/*Table structure for table `tm_designation_list` */

DROP TABLE IF EXISTS `tm_designation_list`;

CREATE TABLE `tm_designation_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `designation` varchar(200) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tm_designation_list` */

insert  into `tm_designation_list`(`id`,`designation`,`description`) values 
(1,'Sr. Programmer','Senior Programmer'),
(2,'Jr. Programmer','Junior Programmer'),
(3,'Project Manager','Project Manager'),
(4,'QA/QC Analyst','Quality Assurance and Quality Control Analyst');

/*Table structure for table `tm_employee_list` */

DROP TABLE IF EXISTS `tm_employee_list`;

CREATE TABLE `tm_employee_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(50) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `middlename` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `department_id` int(30) NOT NULL,
  `designation_id` int(30) NOT NULL,
  `evaluator_id` int(30) NOT NULL,
  `avatar` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tm_employee_list` */

insert  into `tm_employee_list`(`id`,`employee_id`,`firstname`,`middlename`,`lastname`,`email`,`password`,`department_id`,`designation_id`,`evaluator_id`,`avatar`,`date_created`,`reset_token_hash`,`reset_token_expires_at`) values 
(10,'','Alani','','Davila','alani@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:37:10',NULL,NULL),
(11,'','Ryker','','Carson','ryker@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:38:00',NULL,NULL),
(12,'','Fisher','','Montoya','fisher@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:38:37',NULL,NULL),
(13,'','Sage','','Luna','Sage@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:39:26',NULL,NULL),
(14,'','Aryan','','Bauer','Aryan@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:40:35',NULL,NULL),
(15,'','Ignacio','','Cross','Ignacio@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:41:07',NULL,NULL),
(16,'','Kody','','Flowers','Kody@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:41:34',NULL,NULL),
(17,'','Lana ','','Gutierrez','Lana@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:42:21',NULL,NULL),
(18,'','Maryjane ','','Davila','Maryjane@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:43:05',NULL,NULL),
(19,'','Aydin ','','Gamble','Aydin@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:43:38',NULL,NULL),
(20,'','Destiny ','','Mcclure','Destiny@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:44:11',NULL,NULL),
(21,'','Kenyon','','Bond','Kenyon@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:44:49',NULL,NULL),
(22,'','Gary','','Davidson','Gary@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:46:20',NULL,NULL),
(23,'','Darryl','','Duncan','Darryl@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:46:54',NULL,NULL),
(24,'','Finn','','Goodman','Finn@tms.com','202cb962ac59075b964b07152d234b70',0,0,0,'no-image-available.png','2024-05-28 12:47:33',NULL,NULL);

/*Table structure for table `tm_evaluator_list` */

DROP TABLE IF EXISTS `tm_evaluator_list`;

CREATE TABLE `tm_evaluator_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(50) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `middlename` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tm_evaluator_list` */

insert  into `tm_evaluator_list`(`id`,`employee_id`,`firstname`,`middlename`,`lastname`,`email`,`password`,`avatar`,`date_created`) values 
(3,'','Tony','','Stark','tony@tony.com','202cb962ac59075b964b07152d234b70','1716027480_1716021840_tonystark.jpg','2024-05-18 17:04:03'),
(4,'','Steve','','Roger','steve@steve.com','202cb962ac59075b964b07152d234b70','1716024000_steverogers.jpg','2024-05-18 17:20:35'),
(5,'','Carol','','Danvers','carol@carol.com','202cb962ac59075b964b07152d234b70','1716106620_caroldanvers.jpg','2024-05-19 16:17:56');

/*Table structure for table `tm_position` */

DROP TABLE IF EXISTS `tm_position`;

CREATE TABLE `tm_position` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `position_id` int(10) NOT NULL,
  `department_id` int(10) NOT NULL,
  `position` varchar(200) NOT NULL,
  `position_monthly_rate` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tm_position` */

insert  into `tm_position`(`id`,`position_id`,`department_id`,`position`,`position_monthly_rate`) values 
(1,0,0,'IT support specialist',25000),
(2,0,0,'Customer service representative',25000),
(3,0,0,'Data analyst',25000);

/*Table structure for table `tm_ratings` */

DROP TABLE IF EXISTS `tm_ratings`;

CREATE TABLE `tm_ratings` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `employee_id` int(30) NOT NULL,
  `task_id` int(30) NOT NULL,
  `evaluator_id` int(30) NOT NULL,
  `efficiency` int(11) NOT NULL,
  `timeliness` int(11) NOT NULL,
  `quality` int(11) NOT NULL,
  `accuracy` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tm_ratings` */

/*Table structure for table `tm_recruitment_list` */

DROP TABLE IF EXISTS `tm_recruitment_list`;

CREATE TABLE `tm_recruitment_list` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `birthdate` datetime NOT NULL,
  `contactnum` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `resume` varchar(200) NOT NULL,
  `date_applied` datetime NOT NULL DEFAULT current_timestamp(),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tm_recruitment_list` */

/*Table structure for table `tm_task_list` */

DROP TABLE IF EXISTS `tm_task_list`;

CREATE TABLE `tm_task_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `task` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `employee_id` int(30) NOT NULL,
  `due_date` date NOT NULL,
  `completed` date NOT NULL,
  `status` int(1) NOT NULL COMMENT '0=pending, 1=on-progress,3=Completed',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tm_task_list` */

/*Table structure for table `tm_task_progress` */

DROP TABLE IF EXISTS `tm_task_progress`;

CREATE TABLE `tm_task_progress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(30) NOT NULL,
  `progress` text NOT NULL,
  `is_complete` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=no,1=Yes',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tm_task_progress` */

/*Table structure for table `tm_users` */

DROP TABLE IF EXISTS `tm_users`;

CREATE TABLE `tm_users` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tm_users` */

insert  into `tm_users`(`id`,`firstname`,`lastname`,`email`,`password`,`avatar`,`date_created`) values 
(1,'Peter','Parker','admin@admin.com','202cb962ac59075b964b07152d234b70','1716816360_1716123000_peterparker.jpg','2020-11-26 10:57:04');

/*Table structure for table `trn_appraisals` */

DROP TABLE IF EXISTS `trn_appraisals`;

CREATE TABLE `trn_appraisals` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `sales` varchar(255) NOT NULL,
  `inventory_count` varchar(255) NOT NULL,
  `drive` varchar(255) NOT NULL,
  `enthusiasm` varchar(255) NOT NULL,
  `leadership` varchar(255) NOT NULL,
  `integrity` varchar(255) NOT NULL,
  `teamwork` varchar(255) NOT NULL,
  `entrepreneurship` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `trn_appraisals` */

/*Table structure for table `trn_assessment_answers` */

DROP TABLE IF EXISTS `trn_assessment_answers`;

CREATE TABLE `trn_assessment_answers` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `assessment_id` varchar(20) DEFAULT NULL,
  `choices_id` varchar(20) DEFAULT NULL,
  `answer` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `trn_assessment_answers` */

/*Table structure for table `trn_assessment_questions` */

DROP TABLE IF EXISTS `trn_assessment_questions`;

CREATE TABLE `trn_assessment_questions` (
  `id` int(11) NOT NULL,
  `assessment_id` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `a` varchar(255) NOT NULL,
  `b` varchar(255) NOT NULL,
  `c` varchar(255) NOT NULL,
  `d` varchar(255) NOT NULL,
  `correct_answer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `trn_assessment_questions` */

insert  into `trn_assessment_questions`(`id`,`assessment_id`,`question`,`a`,`b`,`c`,`d`,`correct_answer`) values 
(22,9,'What is React primarily used for?','Building User Interfaces','Handling Database Queries','Managing Server Infrastructure','Creating CSS Styles','a'),
(23,9,'Which method is used to create components in React?','render()','createComponent()','constructor()','useState()','b'),
(24,9,'What is the purpose of the useState hook in React?','To fetch data from APIs','To handle side effects','To add state to functional components','To manage routing','b'),
(25,9,'In React',' what does JSX stand for?','JavaScript XML','JavaScript Extra','JavaScript Execution','d'),
(26,9,'Which of the following is NOT a feature of React?','Virtual DOM','One-way Data Binding','Component-based Architecture','Two-way Data Binding','b'),
(27,9,'What is React primarily used for?','Building User Interfaces','Handling Database Queries','Managing Server Infrastructure','Creating CSS Styles','a'),
(28,9,'Which method is used to create components in React?','render()','createComponent()','constructor()','useState()','b'),
(29,9,'What is the purpose of the useState hook in React?','To fetch data from APIs','To handle side effects','To add state to functional components','To manage routing','b'),
(30,9,'In React',' what does JSX stand for?','JavaScript XML','JavaScript Extra','JavaScript Execution','d'),
(31,9,'Which of the following is NOT a feature of React?','Virtual DOM','One-way Data Binding','Component-based Architecture','Two-way Data Binding','b'),
(32,10,'What is the capital of France?','Paris','London','Berlin','Madrid','a'),
(33,10,'What is 2 + 2?','3','4','5','6','b'),
(34,10,'Who wrote \'Hamlet\'?','Dickens','Shakespeare','Austen','Tolkien','b');

/*Table structure for table `trn_assessments` */

DROP TABLE IF EXISTS `trn_assessments`;

CREATE TABLE `trn_assessments` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `assessment_duration` varchar(255) NOT NULL,
  `duration_type` varchar(20) NOT NULL,
  `passing_grade` varchar(20) DEFAULT NULL,
  `max_attempt` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `trn_assessments` */

insert  into `trn_assessments`(`id`,`course_id`,`assessment_duration`,`duration_type`,`passing_grade`,`max_attempt`) values 
(9,9,'30','minutes','70','3'),
(10,12,'30','minutes','90','3');

/*Table structure for table `trn_courses` */

DROP TABLE IF EXISTS `trn_courses`;

CREATE TABLE `trn_courses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `duration` varchar(255) NOT NULL,
  `duration_type` varchar(20) NOT NULL,
  `date_created` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `trn_courses` */

insert  into `trn_courses`(`id`,`name`,`description`,`duration`,`duration_type`,`date_created`,`designation`,`department`) values 
(9,'ReactJs','','1','hours','','Frontend','Information Technology'),
(12,'Vue Js','','1','hours','May 20, 2024','Frontend','Information Technology');

/*Table structure for table `trn_departments` */

DROP TABLE IF EXISTS `trn_departments`;

CREATE TABLE `trn_departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `trn_departments` */

insert  into `trn_departments`(`id`,`name`,`active`) values 
(6,'Information Technology','1'),
(7,'marketing','1');

/*Table structure for table `trn_designation` */

DROP TABLE IF EXISTS `trn_designation`;

CREATE TABLE `trn_designation` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department_id` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `trn_designation` */

/*Table structure for table `trn_groups` */

DROP TABLE IF EXISTS `trn_groups`;

CREATE TABLE `trn_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `permission` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `trn_groups` */

insert  into `trn_groups`(`id`,`group_name`,`permission`) values 
(1,'Administrator','a:48:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:16:\"createDepartment\";i:9;s:16:\"updateDepartment\";i:10;s:14:\"viewDepartment\";i:11;s:16:\"deleteDepartment\";i:12;s:17:\"createDesignation\";i:13;s:17:\"updateDesignation\";i:14;s:15:\"viewDesignation\";i:15;s:17:\"deleteDesignation\";i:16;s:14:\"createEmployee\";i:17;s:14:\"updateEmployee\";i:18;s:12:\"viewEmployee\";i:19;s:14:\"deleteEmployee\";i:20;s:12:\"createCourse\";i:21;s:12:\"updateCourse\";i:22;s:10:\"viewCourse\";i:23;s:12:\"deleteCourse\";i:24;s:14:\"createMaterial\";i:25;s:14:\"updateMaterial\";i:26;s:12:\"viewMaterial\";i:27;s:14:\"deleteMaterial\";i:28;s:16:\"createAssessment\";i:29;s:16:\"updateAssessment\";i:30;s:14:\"viewAssessment\";i:31;s:16:\"deleteAssessment\";i:32;s:14:\"createTraining\";i:33;s:14:\"updateTraining\";i:34;s:12:\"viewTraining\";i:35;s:14:\"deleteTraining\";i:36;s:13:\"createTrainer\";i:37;s:13:\"updateTrainer\";i:38;s:11:\"viewTrainer\";i:39;s:13:\"deleteTrainer\";i:40;s:12:\"createEvents\";i:41;s:12:\"updateEvents\";i:42;s:10:\"viewEvents\";i:43;s:12:\"deleteEvents\";i:44;s:11:\"viewReports\";i:45;s:13:\"updateCompany\";i:46;s:11:\"viewProfile\";i:47;s:13:\"updateSetting\";}'),
(11,'Manager','a:48:{i:0;s:10:\"createUser\";i:1;s:10:\"updateUser\";i:2;s:8:\"viewUser\";i:3;s:10:\"deleteUser\";i:4;s:11:\"createGroup\";i:5;s:11:\"updateGroup\";i:6;s:9:\"viewGroup\";i:7;s:11:\"deleteGroup\";i:8;s:16:\"createDepartment\";i:9;s:16:\"updateDepartment\";i:10;s:14:\"viewDepartment\";i:11;s:16:\"deleteDepartment\";i:12;s:17:\"createDesignation\";i:13;s:17:\"updateDesignation\";i:14;s:15:\"viewDesignation\";i:15;s:17:\"deleteDesignation\";i:16;s:14:\"createEmployee\";i:17;s:14:\"updateEmployee\";i:18;s:12:\"viewEmployee\";i:19;s:14:\"deleteEmployee\";i:20;s:12:\"createCourse\";i:21;s:12:\"updateCourse\";i:22;s:10:\"viewCourse\";i:23;s:12:\"deleteCourse\";i:24;s:14:\"createMaterial\";i:25;s:14:\"updateMaterial\";i:26;s:12:\"viewMaterial\";i:27;s:14:\"deleteMaterial\";i:28;s:16:\"createAssessment\";i:29;s:16:\"updateAssessment\";i:30;s:14:\"viewAssessment\";i:31;s:16:\"deleteAssessment\";i:32;s:14:\"createTraining\";i:33;s:14:\"updateTraining\";i:34;s:12:\"viewTraining\";i:35;s:14:\"deleteTraining\";i:36;s:13:\"createTrainer\";i:37;s:13:\"updateTrainer\";i:38;s:11:\"viewTrainer\";i:39;s:13:\"deleteTrainer\";i:40;s:12:\"createEvents\";i:41;s:12:\"updateEvents\";i:42;s:10:\"viewEvents\";i:43;s:12:\"deleteEvents\";i:44;s:11:\"viewReports\";i:45;s:13:\"updateCompany\";i:46;s:11:\"viewProfile\";i:47;s:13:\"updateSetting\";}'),
(13,'employee','a:2:{i:0;s:14:\"viewDepartment\";i:1;s:15:\"viewDesignation\";}');

/*Table structure for table `trn_indicators` */

DROP TABLE IF EXISTS `trn_indicators`;

CREATE TABLE `trn_indicators` (
  `id` int(11) NOT NULL,
  `department_id` varchar(255) NOT NULL,
  `designation_id` varchar(255) DEFAULT NULL,
  `sales` varchar(255) NOT NULL,
  `inventory_count` varchar(255) NOT NULL,
  `drive` varchar(255) NOT NULL,
  `enthusiasm` varchar(255) NOT NULL,
  `leadership` varchar(255) NOT NULL,
  `integrity` varchar(255) NOT NULL,
  `teamwork` varchar(255) NOT NULL,
  `entrepreneurship` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `trn_indicators` */

insert  into `trn_indicators`(`id`,`department_id`,`designation_id`,`sales`,`inventory_count`,`drive`,`enthusiasm`,`leadership`,`integrity`,`teamwork`,`entrepreneurship`,`created_at`,`updated_at`,`active`) values 
(9,'6','10','3','','','4','4','5','4','',NULL,NULL,'1');

/*Table structure for table `trn_key_indicators` */

DROP TABLE IF EXISTS `trn_key_indicators`;

CREATE TABLE `trn_key_indicators` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `trn_key_indicators` */

insert  into `trn_key_indicators`(`id`,`name`,`value`,`created_at`,`updated_at`) values 
(1,'None',1,NULL,NULL),
(2,'Poor',2,NULL,NULL),
(3,'Average',3,NULL,NULL),
(4,'Satisfactory',4,NULL,NULL),
(5,'Excellent',5,NULL,NULL);

/*Table structure for table `trn_training_materials` */

DROP TABLE IF EXISTS `trn_training_materials`;

CREATE TABLE `trn_training_materials` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `material_type` varchar(20) DEFAULT NULL,
  `material_name` varchar(100) DEFAULT NULL,
  `material_url` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `trn_training_materials` */

insert  into `trn_training_materials`(`id`,`course_id`,`material_type`,`material_name`,`material_url`,`description`) values 
(4,9,'video','React Crash Course','https://youtu.be/LDB4uaJ87e0','Learn the basics of React, such as components, props, state, data fetching, and more, while building a job listing frontend.\r\n'),
(5,12,'video','Frontend tutorial','https://youtu.be/LDB4uaJ87e0','Learn the basics of React, such as components, props, state, data fetching, and more, while building a job listing frontend.');

/*Table structure for table `trn_training_type` */

DROP TABLE IF EXISTS `trn_training_type`;

CREATE TABLE `trn_training_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `trn_training_type` */

insert  into `trn_training_type`(`id`,`name`,`active`) values 
(9,'CSS',1);

/*Table structure for table `trn_trainings` */

DROP TABLE IF EXISTS `trn_trainings`;

CREATE TABLE `trn_trainings` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `assessment_id` varchar(20) NOT NULL,
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  `startdate` varchar(255) NOT NULL,
  `enddate` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `grade` varchar(255) NOT NULL,
  `assessment_duration` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `trn_trainings` */

insert  into `trn_trainings`(`id`,`employee_id`,`course_id`,`assessment_id`,`date_created`,`startdate`,`enddate`,`date`,`grade`,`assessment_duration`,`description`,`remarks`,`status`) values 
(44,'21','9','','2024-05-20','','','','','','learn react','','');

/*Table structure for table `trn_user_group` */

DROP TABLE IF EXISTS `trn_user_group`;

CREATE TABLE `trn_user_group` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `trn_user_group` */

insert  into `trn_user_group`(`id`,`user_id`,`group_id`) values 
(1,1,1),
(21,21,13),
(22,22,11),
(23,23,13);

/*Table structure for table `trn_users` */

DROP TABLE IF EXISTS `trn_users`;

CREATE TABLE `trn_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL,
  `role_id` varchar(255) NOT NULL,
  `department_id` varchar(255) NOT NULL,
  `designation_id` varchar(255) NOT NULL,
  `dateofjoining` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `trn_users` */

insert  into `trn_users`(`id`,`username`,`password`,`email`,`firstname`,`lastname`,`phone`,`gender`,`role_id`,`department_id`,`designation_id`,`dateofjoining`) values 
(1,'adminknst','$2y$10$yfi5nUQGXUZtMdl27dWAyOd/jMOmATBpiUvJDmUu9hJ5Ro6BE5wsK','admin@admin.com','john','doe','80789998',1,'','','',''),
(21,'wendel','$2y$10$W.nTb/ySYK.CxegjStFVZu5hsv8fHCCddh.p6d2X5Wq.jo8Iuo/cC','wendel@gmail.com','wendel','maghinang','',0,'13','6','10','Mar 25, 2024'),
(22,'_wendel','$2y$10$XDCZb1kLY8Gu4nJDOkOwHuI0hImLBm60pZcW3gf38AUXiqitbO/HG','janwendelmaghinang@gmail.com','jan wendel','maghinang','09345623784',1,'','','','');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
