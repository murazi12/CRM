/*
SQLyog Enterprise v12.4.3 (64 bit)
MySQL - 10.3.16-MariaDB : Database - armv2
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`armv2` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `armv2`;

/*Table structure for table `tbl_access` */

DROP TABLE IF EXISTS `tbl_access`;

CREATE TABLE `tbl_access` (
  `ACACCSIY` int(11) NOT NULL AUTO_INCREMENT,
  `ACMENUIY` int(11) NOT NULL,
  `ACUSERIY` int(11) NOT NULL,
  `ACAADD` char(1) DEFAULT NULL,
  `ACAEDT` char(1) DEFAULT NULL,
  `ACADLT` char(1) DEFAULT NULL,
  `ACAVIW` char(1) DEFAULT NULL,
  `ACACTV` char(1) NOT NULL DEFAULT '1',
  `ACREMK` text NOT NULL,
  `ACADON` datetime NOT NULL,
  `ACADBY` char(30) NOT NULL,
  `ACCHON` datetime DEFAULT NULL,
  `ACCHBY` char(30) DEFAULT NULL,
  PRIMARY KEY (`ACACCSIY`),
  UNIQUE KEY `ACMENUIY` (`ACMENUIY`,`ACUSERIY`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_access` */

insert  into `tbl_access`(`ACACCSIY`,`ACMENUIY`,`ACUSERIY`,`ACAADD`,`ACAEDT`,`ACADLT`,`ACAVIW`,`ACACTV`,`ACREMK`,`ACADON`,`ACADBY`,`ACCHON`,`ACCHBY`) values 
(1,1,3,NULL,NULL,NULL,NULL,'1','','2020-01-24 22:13:41','system','2020-02-10 14:32:50','Muhammad.Abiyuramzi'),
(2,2,3,'0','1','1','1','1','','2020-01-24 22:13:41','system','2020-02-10 15:10:31','Muhammad.Abiyuramzi'),
(3,3,3,'1','1','0','1','1','','2020-01-24 22:25:54','system','2020-02-10 10:45:58','Muhammad.Abiyuramzi'),
(4,4,3,NULL,NULL,NULL,NULL,'1','','2020-01-24 23:30:28','system','2020-02-27 12:08:01','Muhammad.Abiyuramzi'),
(5,5,3,'1','1','1','1','1','','2020-01-27 16:31:05','system','2020-02-25 10:01:17','Muhammad.Abiyuramzi'),
(6,6,3,'1','1','1','1','1','','2020-01-27 16:33:04','system','2020-02-25 11:46:57','Muhammad.Abiyuramzi'),
(7,7,3,'1','1','1','0','1','','2020-01-27 16:33:04','system','2020-02-27 12:08:01','Muhammad.Abiyuramzi'),
(10,1,4,NULL,NULL,NULL,NULL,'1','','2020-02-10 14:45:28','Muhammad.Abiyuramzi',NULL,NULL),
(11,2,4,'0','1','1','1','1','','2020-02-10 14:45:28','Muhammad.Abiyuramzi','2020-02-10 15:12:16','Idham.Fahrian'),
(12,4,4,NULL,NULL,NULL,NULL,'1','','2020-02-10 15:09:03','Muhammad.Abiyuramzi',NULL,NULL),
(13,5,4,'1','1','0','1','1','','2020-02-10 15:09:03','Muhammad.Abiyuramzi',NULL,NULL),
(14,6,4,'0','0','0','1','0','','2020-02-10 15:09:40','Muhammad.Abiyuramzi','2020-02-10 15:10:47','Muhammad.Abiyuramzi'),
(15,3,4,'0','0','0','1','1','','2020-02-11 10:16:47','Muhammad.Abiyuramzi',NULL,NULL),
(16,8,3,'1','1','1','1','1','','2020-02-13 16:52:05','Muhammad.Abiyuramzi',NULL,NULL),
(17,9,3,'1','1','1','1','1','','2020-02-13 16:52:16','Muhammad.Abiyuramzi',NULL,NULL),
(18,10,3,'1','1','1','1','1','','2020-02-13 16:52:26','Muhammad.Abiyuramzi',NULL,NULL),
(19,1,5,NULL,NULL,NULL,NULL,'1','','2020-02-21 19:32:25','Muhammad.Abiyuramzi',NULL,NULL),
(20,8,5,'1','1','0','1','1','','2020-02-21 19:32:25','Muhammad.Abiyuramzi',NULL,NULL);

/*Table structure for table `tbl_dept` */

DROP TABLE IF EXISTS `tbl_dept`;

CREATE TABLE `tbl_dept` (
  `DEDEPTIY` int(11) NOT NULL AUTO_INCREMENT,
  `DECODE` char(6) NOT NULL,
  `DENAME` char(50) NOT NULL,
  `DEACTV` char(1) NOT NULL DEFAULT '1',
  `DEDLTE` char(1) NOT NULL DEFAULT '0',
  `DEREMK` text DEFAULT NULL,
  `DEADON` datetime NOT NULL,
  `DEADBY` char(50) NOT NULL,
  `DECHON` datetime DEFAULT NULL,
  `DECHBY` char(50) DEFAULT NULL,
  PRIMARY KEY (`DEDEPTIY`),
  UNIQUE KEY `DECODE` (`DECODE`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_dept` */

insert  into `tbl_dept`(`DEDEPTIY`,`DECODE`,`DENAME`,`DEACTV`,`DEDLTE`,`DEREMK`,`DEADON`,`DEADBY`,`DECHON`,`DECHBY`) values 
(1,'DEP001','Finance','1','0',NULL,'2020-02-05 11:42:25','system',NULL,NULL),
(2,'DEP002','Human Capital & Business Support','1','1',NULL,'2020-02-05 11:42:25','system','2020-02-14 14:24:34','Muhammad.Abiyuramzi'),
(3,'DEP003','Application Support','1','0',NULL,'2020-02-05 11:42:25','system',NULL,NULL),
(4,'DEP004','Development','1','0',NULL,'2020-02-05 11:42:25','system',NULL,NULL),
(5,'DEP005','Engineering','1','1',NULL,'2020-02-05 11:42:25','system','2020-02-14 17:06:22','Muhammad.Abiyuramzi'),
(6,'DEP006','Dept Test','1','0','Test edit dept lagi','2020-02-14 17:33:30','Muhammad.Abiyuramzi','2020-02-14 18:48:08','Muhammad.Abiyuramzi');

/*Table structure for table `tbl_jabatan` */

DROP TABLE IF EXISTS `tbl_jabatan`;

CREATE TABLE `tbl_jabatan` (
  `JAJABTIY` int(11) NOT NULL AUTO_INCREMENT,
  `JACODE` char(6) NOT NULL,
  `JANAME` char(30) NOT NULL,
  `JAACTV` char(1) NOT NULL DEFAULT '1',
  `JADLTE` char(1) NOT NULL DEFAULT '0',
  `JAREMK` text DEFAULT NULL,
  `JAADON` datetime NOT NULL,
  `JAADBY` char(50) NOT NULL,
  `JACHON` datetime DEFAULT NULL,
  `JACHBY` char(50) DEFAULT NULL,
  PRIMARY KEY (`JAJABTIY`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_jabatan` */

insert  into `tbl_jabatan`(`JAJABTIY`,`JACODE`,`JANAME`,`JAACTV`,`JADLTE`,`JAREMK`,`JAADON`,`JAADBY`,`JACHON`,`JACHBY`) values 
(1,'JAB001','CEO','1','0',NULL,'2020-02-05 18:26:58','system',NULL,NULL),
(2,'JAB002','COO','0','1',NULL,'2020-02-05 18:26:58','system','2020-02-18 16:53:21','Muhammad.Abiyuramzi'),
(3,'JAB003','General Manager','1','0',NULL,'2020-02-05 18:26:58','system',NULL,NULL),
(4,'JAB004','Manager','1','0',NULL,'2020-02-05 18:26:58','system',NULL,NULL),
(5,'JAB005','Senior Staff','1','0',NULL,'2020-02-05 18:26:58','system',NULL,NULL),
(6,'JAB006','Staff','1','0',NULL,'2020-02-05 18:26:58','system',NULL,NULL),
(7,'JAB007','Test add','0','0','Test Edit','2020-02-18 17:42:21','Muhammad.Abiyuramzi','2020-02-18 17:42:51','Muhammad.Abiyuramzi');

/*Table structure for table `tbl_menu` */

DROP TABLE IF EXISTS `tbl_menu`;

CREATE TABLE `tbl_menu` (
  `MEMENUIY` int(11) NOT NULL AUTO_INCREMENT,
  `MEMNPRIY` int(11) NOT NULL DEFAULT 0,
  `MECODE` char(6) NOT NULL,
  `MENAME` char(30) NOT NULL,
  `MELINK` char(20) NOT NULL,
  `METYPE` char(10) NOT NULL,
  `MESORT` int(11) NOT NULL,
  `MEACTV` char(1) NOT NULL DEFAULT '1',
  `MEDLTE` char(1) NOT NULL DEFAULT '0',
  `MEREMK` text DEFAULT NULL,
  `MEADON` datetime NOT NULL,
  `MEADBY` char(30) NOT NULL,
  `MECHON` datetime DEFAULT NULL,
  `MECHBY` char(30) DEFAULT NULL,
  PRIMARY KEY (`MEMENUIY`),
  UNIQUE KEY `MEMNPRIY` (`MEMNPRIY`,`MESORT`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_menu` */

insert  into `tbl_menu`(`MEMENUIY`,`MEMNPRIY`,`MECODE`,`MENAME`,`MELINK`,`METYPE`,`MESORT`,`MEACTV`,`MEDLTE`,`MEREMK`,`MEADON`,`MEADBY`,`MECHON`,`MECHBY`) values 
(1,0,'MEN001','Master','','parent',1,'1','0','','2020-01-23 13:42:09','system',NULL,NULL),
(2,1,'MEN002','Master User','mst_profile','child',1,'1','0','','2020-01-23 13:44:54','system',NULL,NULL),
(3,1,'MEN003','Master Menu','mst_menu','child',2,'1','0','','2020-01-24 22:23:35','system',NULL,NULL),
(4,0,'MEN004','Sales Configuration','','parent',2,'1','0','','2020-01-24 23:28:35','system',NULL,NULL),
(5,4,'MEN005','Sales Stage','sls_stage','child',1,'1','0','Test','2020-01-27 16:29:38','system','2020-02-13 16:46:03','Muhammad.Abiyuramzi'),
(6,4,'MEN006','Opportunity Type','sls_oppo_type','child',2,'1','0','','2020-01-27 16:32:35','system',NULL,NULL),
(7,4,'MEN007','Account Manager','sls_am','child',3,'1','0','','2020-01-27 16:32:35','system',NULL,NULL),
(8,1,'MEN008','Master Department','mst_dept','child',3,'1','0','','2020-02-13 16:51:19','system',NULL,NULL),
(9,1,'MEN009','Master Sub Department','mst_subdept','child',4,'1','0','','2020-02-13 16:51:19','system',NULL,NULL),
(10,1,'MEN010','Master Jabatan','mst_jabt','child',5,'1','0','','2020-02-13 16:51:19','system',NULL,NULL);

/*Table structure for table `tbl_oppo_type` */

DROP TABLE IF EXISTS `tbl_oppo_type`;

CREATE TABLE `tbl_oppo_type` (
  `OTOPTYIY` int(11) NOT NULL AUTO_INCREMENT,
  `OTCODE` char(6) NOT NULL,
  `OTNAME` char(30) DEFAULT NULL,
  `OTACTV` char(1) DEFAULT '1',
  `OTDLTE` char(1) DEFAULT '0',
  `OTREMK` text DEFAULT NULL,
  `OTADON` datetime NOT NULL,
  `OTADBY` char(50) NOT NULL,
  `OTCHON` datetime DEFAULT NULL,
  `OTCHBY` char(50) DEFAULT 'null',
  PRIMARY KEY (`OTOPTYIY`),
  UNIQUE KEY `UNIQUE` (`OTCODE`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_oppo_type` */

insert  into `tbl_oppo_type`(`OTOPTYIY`,`OTCODE`,`OTNAME`,`OTACTV`,`OTDLTE`,`OTREMK`,`OTADON`,`OTADBY`,`OTCHON`,`OTCHBY`) values 
(1,'OTY001','New Opportunity','1','0','Test edit','2020-02-27 11:18:12','Muhammad.Abiyuramzi','2020-02-27 11:35:08','Muhammad.Abiyuramzi'),
(2,'OTY002','Renewal Contract','0','1','Test add','2020-02-27 11:21:15','Muhammad.Abiyuramzi','2020-02-27 11:28:23','Muhammad.Abiyuramzi');

/*Table structure for table `tbl_sales_stage` */

DROP TABLE IF EXISTS `tbl_sales_stage`;

CREATE TABLE `tbl_sales_stage` (
  `SSSLTGIY` int(11) NOT NULL AUTO_INCREMENT,
  `SSCODE` char(6) NOT NULL,
  `SSNAME` char(30) NOT NULL,
  `SSACTV` char(1) DEFAULT '1',
  `SSDLTE` char(1) DEFAULT '0',
  `SSREMK` text DEFAULT NULL,
  `SSADON` datetime NOT NULL,
  `SSADBY` char(50) NOT NULL,
  `SSCHON` datetime DEFAULT NULL,
  `SSCHBY` char(50) DEFAULT 'null',
  PRIMARY KEY (`SSSLTGIY`),
  UNIQUE KEY `UNIQUE` (`SSCODE`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_sales_stage` */

insert  into `tbl_sales_stage`(`SSSLTGIY`,`SSCODE`,`SSNAME`,`SSACTV`,`SSDLTE`,`SSREMK`,`SSADON`,`SSADBY`,`SSCHON`,`SSCHBY`) values 
(1,'STG001','Closed Won','0','0','Test add','2020-02-25 09:56:36','Muhammad.Abiyuramzi','2020-02-25 10:00:08','Muhammad.Abiyuramzi'),
(2,'STG002','Negotiation','0','1','','2020-02-25 10:21:48','Muhammad.Abiyuramzi','2020-02-25 10:54:25','Muhammad.Abiyuramzi'),
(3,'STG003','Closes Lost','1','0','Test','2020-02-25 10:31:01','Muhammad.Abiyuramzi',NULL,'null');

/*Table structure for table `tbl_subdept` */

DROP TABLE IF EXISTS `tbl_subdept`;

CREATE TABLE `tbl_subdept` (
  `SDSDPTIY` int(11) NOT NULL AUTO_INCREMENT,
  `SDDEPTIY` int(11) NOT NULL,
  `SDCODE` char(6) NOT NULL,
  `SDNAME` char(50) NOT NULL,
  `SDACTV` char(1) NOT NULL DEFAULT '1',
  `SDDLTE` char(1) NOT NULL DEFAULT '0',
  `SDREMK` text DEFAULT NULL,
  `SDADON` datetime NOT NULL,
  `SDADBY` char(50) NOT NULL,
  `SDCHON` datetime DEFAULT NULL,
  `SDCHBY` char(50) DEFAULT NULL,
  PRIMARY KEY (`SDSDPTIY`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_subdept` */

insert  into `tbl_subdept`(`SDSDPTIY`,`SDDEPTIY`,`SDCODE`,`SDNAME`,`SDACTV`,`SDDLTE`,`SDREMK`,`SDADON`,`SDADBY`,`SDCHON`,`SDCHBY`) values 
(1,1,'SDP001','Accounting','1','0','','2020-02-05 16:46:34','system','2020-02-18 11:46:27','Muhammad.Abiyuramzi'),
(2,1,'SDP002','Tax','1','0',NULL,'2020-02-05 16:46:34','system',NULL,NULL),
(3,1,'SDP003','Budget & Project Control','1','0',NULL,'2020-02-05 16:46:34','system',NULL,NULL),
(4,1,'SDP004','Treasury','1','0',NULL,'2020-02-05 16:46:34','system',NULL,NULL),
(5,1,'SDP005','Collection','1','0',NULL,'2020-02-05 16:46:34','system',NULL,NULL),
(6,2,'SDP006','Talent Acquisition & Development','0','1',NULL,'2020-02-05 16:50:53','system','2020-02-17 11:36:01','Muhammad.Abiyuramzi'),
(7,2,'SDP007','Reward & Employee Serives','1','0',NULL,'2020-02-05 16:50:53','system',NULL,NULL),
(8,2,'SDP008','Procurement & Vendor Management','1','0',NULL,'2020-02-05 16:50:53','system',NULL,NULL),
(9,2,'SDP009','General Affairs & Asset Management','1','0',NULL,'2020-02-05 16:50:53','system',NULL,NULL);

/*Table structure for table `tbl_user` */

DROP TABLE IF EXISTS `tbl_user`;

CREATE TABLE `tbl_user` (
  `USUSERIY` int(11) NOT NULL AUTO_INCREMENT,
  `USUNIK` char(6) DEFAULT NULL,
  `USUSNM` char(30) NOT NULL,
  `USPASS` text DEFAULT NULL,
  `USMAIL` char(50) NOT NULL,
  `USFLNM` char(50) NOT NULL,
  `USACTV` char(1) NOT NULL DEFAULT '1',
  `USDLTE` char(1) NOT NULL DEFAULT '0',
  `USREMK` text DEFAULT NULL,
  `USADON` datetime NOT NULL,
  `USADBY` char(30) NOT NULL,
  `USCHON` datetime DEFAULT NULL,
  `USCHBY` char(30) DEFAULT NULL,
  PRIMARY KEY (`USUSERIY`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_user` */

insert  into `tbl_user`(`USUSERIY`,`USUNIK`,`USUSNM`,`USPASS`,`USMAIL`,`USFLNM`,`USACTV`,`USDLTE`,`USREMK`,`USADON`,`USADBY`,`USCHON`,`USCHBY`) values 
(1,'000000','admin','$2y$10$km4R2s0lwfaXNcscqnTzG.9stwfsu2Qc9qmbqtprvXwTBAbsgKi9W','muhammad.abiyuramzi@asyst.co.id','Administrator','1','0','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','2020-01-23 16:45:50','system','2020-01-28 00:00:00','system'),
(2,NULL,'guest','$2y$10$Lw70g60eoHA.iXxr7JOwHenc6xdzsmZ9kKVL4LmNYgGnvVsqNpK8e','','','1','0','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','2020-01-23 16:54:49','system','2020-01-23 00:00:00','system'),
(3,'900694','Muhammad.Abiyuramzi','$2y$10$KWCai2Cm7elvucE/VH0gduyJ1pQvNyhPcLggFaQwuj9gA5IHKHO5C','Muhammad.Abiyuramzi@asyst.co.id','Muhammad Raehan Abiyuramzi','1','0','Test edit','2020-01-24 14:25:55','system','2020-02-27 12:08:08','Muhammad.Abiyuramzi'),
(4,'','Idham.Fahrian','$2y$10$msofaIVOyz84Qf5ScRpgZ.Y/TVUehrLc9DSLnLu9G7kFRqp7QUR6a','Idham.Fahrian@asyst.co.id','Idham Fahrian','1','0','Lorem ipsum dolor sit amet, consectetur adipisicing elit.','2020-01-24 15:24:39','system','2020-02-11 10:16:52','Muhammad.Abiyuramzi'),
(5,'','Anggit.Pratama','$2y$10$13Tw2HoMJFovdTLiH3NtweatvaJiDdtMR9RKW8AoWwysEXCxWtM8q','anggit.pratama@asyst.co.id','Anggit Pratama','1','0','','2020-02-21 19:31:25','system','2020-02-21 19:32:57','system');

/*Table structure for table `tbl_user_biodata` */

DROP TABLE IF EXISTS `tbl_user_biodata`;

CREATE TABLE `tbl_user_biodata` (
  `UBBIODIY` int(11) NOT NULL AUTO_INCREMENT,
  `UBUSERIY` int(11) NOT NULL,
  `UBDEPTIY` int(11) DEFAULT NULL,
  `UBSDPTIY` int(11) DEFAULT NULL,
  `UBJABTIY` int(11) DEFAULT NULL,
  `UBACTV` char(1) NOT NULL DEFAULT '1',
  `UBREMK` text DEFAULT NULL,
  `UBADON` datetime NOT NULL,
  `UBADBY` char(50) NOT NULL,
  `UBCHON` datetime DEFAULT NULL,
  `UBCHBY` char(50) DEFAULT NULL,
  PRIMARY KEY (`UBBIODIY`),
  UNIQUE KEY `UBUSERIY` (`UBUSERIY`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_user_biodata` */

insert  into `tbl_user_biodata`(`UBBIODIY`,`UBUSERIY`,`UBDEPTIY`,`UBSDPTIY`,`UBJABTIY`,`UBACTV`,`UBREMK`,`UBADON`,`UBADBY`,`UBCHON`,`UBCHBY`) values 
(1,3,NULL,NULL,NULL,'1',NULL,'2020-02-11 10:10:24','Muhammad.Abiyuramzi','2020-02-27 12:08:08','Muhammad.Abiyuramzi'),
(2,4,NULL,NULL,NULL,'1',NULL,'2020-02-11 10:16:52','Muhammad.Abiyuramzi',NULL,NULL),
(3,5,NULL,NULL,NULL,'1',NULL,'2020-02-21 19:32:29','Muhammad.Abiyuramzi',NULL,NULL);

/*Table structure for table `tbl_user_log` */

DROP TABLE IF EXISTS `tbl_user_log`;

CREATE TABLE `tbl_user_log` (
  `ULULOGIY` int(11) NOT NULL AUTO_INCREMENT,
  `ULUSERIY` int(6) NOT NULL,
  `ULDATE` datetime NOT NULL,
  `ULOPSY` char(50) NOT NULL,
  `ULAGNT` char(100) NOT NULL,
  `ULIPAD` char(20) NOT NULL,
  PRIMARY KEY (`ULULOGIY`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;

/*Data for the table `tbl_user_log` */

insert  into `tbl_user_log`(`ULULOGIY`,`ULUSERIY`,`ULDATE`,`ULOPSY`,`ULAGNT`,`ULIPAD`) values 
(1,1,'2020-01-23 16:20:58','Windows 10','Chrome 79.0.3945.117','::1'),
(2,1,'2020-01-23 16:38:10','Windows 10','Chrome 79.0.3945.117','::1'),
(3,1,'2020-01-23 16:39:18','Windows 10','Chrome 79.0.3945.117','::1'),
(4,1,'2020-01-23 16:46:12','Windows 10','Chrome 79.0.3945.117','::1'),
(5,2,'2020-01-23 16:54:49','Windows 10','Chrome 79.0.3945.117','::1'),
(6,2,'2020-01-23 17:02:16','Windows 10','Chrome 79.0.3945.117','::1'),
(7,2,'2020-01-23 17:02:19','Windows 10','Chrome 79.0.3945.117','::1'),
(8,2,'2020-01-23 17:03:18','Windows 10','Chrome 79.0.3945.117','::1'),
(9,2,'2020-01-23 17:04:44','Windows 10','Chrome 79.0.3945.117','::1'),
(10,1,'2020-01-24 14:15:27','Windows 10','Chrome 79.0.3945.130','::1'),
(11,3,'2020-01-24 14:25:55','Windows 10','Chrome 79.0.3945.130','::1'),
(12,1,'2020-01-24 14:26:38','Windows 10','Chrome 79.0.3945.130','::1'),
(13,3,'2020-01-24 14:26:46','Windows 10','Chrome 79.0.3945.130','::1'),
(14,3,'2020-01-24 14:28:38','Windows 10','Chrome 79.0.3945.130','::1'),
(15,3,'2020-01-24 14:29:06','Windows 10','Chrome 79.0.3945.130','::1'),
(16,3,'2020-01-24 14:30:59','Windows 10','Chrome 79.0.3945.130','::1'),
(17,3,'2020-01-24 14:32:44','Windows 10','Chrome 79.0.3945.130','::1'),
(18,3,'2020-01-24 14:33:02','Windows 10','Chrome 79.0.3945.130','::1'),
(19,4,'2020-01-24 15:24:39','Windows 7','Firefox 72.0','172.25.130.83'),
(20,4,'2020-01-24 15:25:23','Windows 7','Firefox 72.0','172.25.130.83'),
(21,3,'2020-01-24 15:28:25','Windows 10','Chrome 79.0.3945.130','::1'),
(22,3,'2020-01-24 15:39:19','Windows 10','Chrome 79.0.3945.130','::1'),
(23,3,'2020-01-24 15:39:42','Windows 10','Chrome 79.0.3945.130','::1'),
(24,3,'2020-01-24 15:39:51','Windows 10','Chrome 79.0.3945.130','::1'),
(25,3,'2020-01-24 20:27:44','Windows 10','Chrome 79.0.3945.130','::1'),
(26,3,'2020-01-24 20:31:23','Android','Chrome 51.0.2704.106','192.168.100.37'),
(27,3,'2020-01-24 20:32:30','Windows 10','Chrome 79.0.3945.130','::1'),
(28,3,'2020-01-24 20:33:40','Windows 10','Chrome 79.0.3945.130','::1'),
(29,3,'2020-01-24 20:35:21','Windows 10','Chrome 79.0.3945.130','192.168.100.181'),
(30,3,'2020-01-24 20:43:39','Windows 10','Chrome 79.0.3945.130','192.168.100.181'),
(31,3,'2020-01-24 20:44:06','Windows 10','Chrome 79.0.3945.130','::1'),
(32,3,'2020-01-24 20:46:47','Windows 10','Chrome 79.0.3945.130','::1'),
(33,3,'2020-01-24 20:47:10','Windows 10','Chrome 79.0.3945.130','::1'),
(34,3,'2020-01-24 20:48:54','Windows 10','Chrome 79.0.3945.130','::1'),
(35,3,'2020-01-24 20:50:48','Windows 10','Chrome 79.0.3945.130','::1'),
(36,3,'2020-01-27 13:41:46','Windows 10','Chrome 79.0.3945.130','::1'),
(37,1,'2020-01-28 09:09:03','Windows 10','Chrome 79.0.3945.130','::1'),
(38,1,'2020-01-28 09:13:25','Windows 10','Chrome 79.0.3945.130','::1'),
(39,3,'2020-01-28 09:15:30','Windows 10','Chrome 79.0.3945.130','::1'),
(40,3,'2020-01-28 09:37:12','Windows 10','Chrome 79.0.3945.130','::1'),
(41,3,'2020-01-28 09:38:12','Windows 10','Chrome 79.0.3945.130','::1'),
(42,3,'2020-01-28 09:38:28','Windows 10','Chrome 79.0.3945.130','::1'),
(43,3,'2020-01-28 11:38:06','Windows 10','Chrome 79.0.3945.130','::1'),
(44,3,'2020-01-28 11:38:22','Windows 10','Chrome 79.0.3945.130','::1'),
(45,3,'2020-01-28 11:38:42','Windows 10','Chrome 79.0.3945.130','::1'),
(46,3,'2020-01-28 13:52:59','Windows 10','Chrome 79.0.3945.130','::1'),
(47,3,'2020-01-28 13:53:40','Windows 10','Chrome 79.0.3945.130','::1'),
(48,3,'2020-01-28 13:54:08','Windows 10','Chrome 79.0.3945.130','::1'),
(49,3,'2020-01-28 13:54:53','Windows 10','Chrome 79.0.3945.130','::1'),
(50,3,'2020-01-28 13:55:06','Windows 10','Chrome 79.0.3945.130','::1'),
(51,3,'2020-01-29 09:51:46','Windows 10','Chrome 79.0.3945.130','::1'),
(52,3,'2020-01-29 10:04:38','Windows 10','Chrome 79.0.3945.130','::1'),
(53,3,'2020-01-29 15:28:16','Windows 10','Chrome 79.0.3945.130','::1'),
(54,3,'2020-01-30 21:39:01','Windows 10','Chrome 79.0.3945.130','::1'),
(55,3,'2020-01-31 04:51:25','Windows 10','Chrome 79.0.3945.130','::1'),
(56,3,'2020-01-31 09:52:19','Windows 10','Chrome 79.0.3945.130','::1'),
(57,3,'2020-01-31 17:36:49','Windows 10','Chrome 79.0.3945.130','::1'),
(58,3,'2020-02-02 09:35:48','Windows 10','Chrome 79.0.3945.130','::1'),
(59,3,'2020-02-02 20:54:08','Windows 10','Chrome 79.0.3945.130','::1'),
(60,3,'2020-02-03 01:05:07','Windows 10','Chrome 79.0.3945.130','::1'),
(61,3,'2020-02-03 05:17:10','Windows 10','Chrome 79.0.3945.130','::1'),
(62,3,'2020-02-03 09:20:20','Windows 10','Chrome 79.0.3945.130','::1'),
(63,3,'2020-02-03 09:53:03','Windows 10','Chrome 79.0.3945.130','::1'),
(64,3,'2020-02-03 10:00:12','Windows 10','Chrome 79.0.3945.130','::1'),
(65,3,'2020-02-05 07:57:42','Windows 10','Chrome 79.0.3945.130','::1'),
(66,3,'2020-02-05 10:06:31','Windows 10','Chrome 79.0.3945.130','::1'),
(67,3,'2020-02-05 11:16:24','Windows 10','Chrome 79.0.3945.130','::1'),
(68,3,'2020-02-05 11:55:27','Windows 10','Chrome 79.0.3945.130','::1'),
(69,3,'2020-02-06 09:41:04','Windows 10','Chrome 80.0.3987.87','::1'),
(70,3,'2020-02-06 15:32:07','Windows 10','Chrome 80.0.3987.87','::1'),
(71,3,'2020-02-07 09:36:44','Windows 10','Chrome 80.0.3987.87','::1'),
(72,3,'2020-02-07 14:06:25','Windows 10','Chrome 80.0.3987.87','::1'),
(73,3,'2020-02-10 09:25:14','Windows 10','Chrome 80.0.3987.87','::1'),
(74,3,'2020-02-10 13:56:22','Windows 10','Chrome 80.0.3987.87','::1'),
(75,4,'2020-02-10 15:11:42','Windows 10','Chrome 80.0.3987.87','::1'),
(76,3,'2020-02-11 09:36:13','Windows 10','Chrome 80.0.3987.87','::1'),
(77,3,'2020-02-11 14:00:42','Windows 10','Chrome 80.0.3987.87','::1'),
(78,3,'2020-02-13 10:13:52','Windows 10','Chrome 80.0.3987.87','::1'),
(79,3,'2020-02-13 14:10:20','Windows 10','Chrome 80.0.3987.87','::1'),
(80,3,'2020-02-14 10:48:43','Windows 10','Chrome 80.0.3987.100','::1'),
(81,3,'2020-02-14 14:17:30','Windows 10','Chrome 80.0.3987.100','::1'),
(82,3,'2020-02-17 10:07:25','Windows 10','Chrome 80.0.3987.106','::1'),
(83,3,'2020-02-18 09:33:00','Windows 10','Chrome 80.0.3987.106','::1'),
(84,3,'2020-02-18 16:35:06','Windows 10','Chrome 80.0.3987.106','::1'),
(85,5,'2020-02-21 19:31:25','Windows 10','Chrome 80.0.3987.116','::1'),
(86,3,'2020-02-21 19:31:43','Windows 10','Chrome 80.0.3987.116','::1'),
(87,5,'2020-02-21 19:32:57','Windows 10','Chrome 80.0.3987.116','::1'),
(88,3,'2020-02-24 10:23:34','Windows 10','Chrome 80.0.3987.116','::1'),
(89,3,'2020-02-25 09:03:05','Windows 10','Chrome 80.0.3987.122','::1'),
(90,3,'2020-02-27 09:55:11','Windows 10','Chrome 80.0.3987.122','::1');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
