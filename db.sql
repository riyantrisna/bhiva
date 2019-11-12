/*
SQLyog Ultimate v11.3 (64 bit)
MySQL - 10.1.37-MariaDB : Database - dev_bhiva
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dev_bhiva` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `dev_bhiva`;

/*Table structure for table `_cms_infocontact_emp` */

DROP TABLE IF EXISTS `_cms_infocontact_emp`;

CREATE TABLE `_cms_infocontact_emp` (
  `infocontactemp_id` bigint(20) NOT NULL,
  `infocontactemp_infocontact_id` tinyint(1) DEFAULT NULL,
  `infocontactemp_name` varchar(250) DEFAULT NULL,
  `infocontactemp_as` varchar(250) DEFAULT NULL,
  `infocontactemp_img` text,
  `infocontactemp_order` int(11) DEFAULT NULL,
  `infocontactemp_status` tinyint(1) DEFAULT NULL COMMENT '0=not active, 1=active',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`infocontactemp_id`),
  KEY `infocontactemp_infocontact_id` (`infocontactemp_infocontact_id`),
  CONSTRAINT `_cms_infocontact_emp_ibfk_1` FOREIGN KEY (`infocontactemp_infocontact_id`) REFERENCES `cms_contact` (`contact_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `_cms_infocontact_emp` */

/*Table structure for table `cms_contact` */

DROP TABLE IF EXISTS `cms_contact`;

CREATE TABLE `cms_contact` (
  `contact_id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'id harus selalu 1',
  `contact_address` text,
  `contact_email` varchar(250) DEFAULT NULL,
  `contact_phone` varchar(16) DEFAULT NULL,
  `contact_wa` varchar(16) DEFAULT NULL,
  `contact_fb` varchar(250) DEFAULT NULL,
  `contact_ig` varchar(250) DEFAULT NULL,
  `contact_twitter` varchar(250) DEFAULT NULL,
  `contact_img_maps` text,
  `contact_link_maps` text,
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `cms_contact` */

insert  into `cms_contact`(`contact_id`,`contact_address`,`contact_email`,`contact_phone`,`contact_wa`,`contact_fb`,`contact_ig`,`contact_twitter`,`contact_img_maps`,`contact_link_maps`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,'<p><span xss=removed>Jl. Ringroad Utara 66, Nayan, Nayan, Maguwoharjo, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281</span><br></p>','support@bhiva.id','0274484273','085787654654','https://facebook.com/bhiva','https://instagram.com/bhiva','https://twitter.com/bhiva','124906cabd1452b3207e5723a4b1ce05.png','https://www.google.com/maps/place/Bhiva+Tour+&+Travel/@-7.7784834,110.4301161,15z/data=!4m5!3m4!1s0x2e7a5a1f1946139f:0x15c4a0a33aefd5f!8m2!3d-7.77446!4d110.430379?hl=id',1,'2019-09-20 18:11:59',5,'2019-11-06 12:52:38');

/*Table structure for table `cms_gallery` */

DROP TABLE IF EXISTS `cms_gallery`;

CREATE TABLE `cms_gallery` (
  `gallery_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gallery_parent_id` bigint(20) DEFAULT NULL COMMENT 'terisi hanya untuk tipe gambar yg link ke id gallery',
  `gallery_type` tinyint(1) DEFAULT NULL COMMENT '1=gallery, 2=image',
  `gallery_img` text,
  `gallery_order` int(11) DEFAULT NULL,
  `gallery_status` tinyint(1) DEFAULT NULL COMMENT '0=not active, 1=active',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `cms_gallery` */

insert  into `cms_gallery`(`gallery_id`,`gallery_parent_id`,`gallery_type`,`gallery_img`,`gallery_order`,`gallery_status`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,NULL,1,'eb6b2f927c9203494cfdced0fadf39c2.jpeg',1,1,5,'2019-09-22 11:56:09',5,'2019-11-10 16:55:49'),(5,NULL,1,'e7929bff7018ab4c866ce0a47c4eeb9d.jpeg',2,1,5,'2019-09-22 19:59:12',5,'2019-11-10 16:55:38'),(6,1,2,'8b227b1588e88e315b2c7660b25198e5.jpeg',1,1,5,'2019-09-22 20:06:32',5,'2019-11-10 22:48:21'),(7,NULL,1,'0440e7bacbdb24e7c0d3969afaac4d8b.jpeg',3,1,5,'2019-11-10 16:56:01',NULL,NULL),(8,NULL,1,'c096b2ea1eee97737fc9542096f8ec3d.jpeg',4,1,5,'2019-11-10 16:56:24',NULL,NULL),(9,NULL,1,'b6bba1eb27743f2ab5b26e1b6562cb6a.jpeg',5,1,5,'2019-11-10 16:56:41',NULL,NULL),(10,NULL,1,'c6a90e11d3f6c06458a93398071b0421.jpeg',6,1,5,'2019-11-10 16:56:54',NULL,NULL),(11,NULL,1,'2ec1af9527a7eb924c7b9713db8bdf5a.jpeg',7,1,5,'2019-11-10 16:57:10',NULL,NULL),(12,NULL,1,'b86f978f72f838880af9b077af9ae0dc.jpeg',8,1,5,'2019-11-10 16:57:22',NULL,NULL),(13,NULL,1,'fd45540e324d8673d2c226713c023b80.jpeg',9,1,5,'2019-11-10 16:57:34',NULL,NULL),(14,1,2,'e1705008484fae4c8d4edc1f63ae8cca.jpeg',2,1,5,'2019-11-10 22:48:11',NULL,NULL),(15,1,2,'d4d8771640c3843737ec0ac1b0e7c2d1.jpeg',3,1,5,'2019-11-10 22:48:38',NULL,NULL),(16,1,2,'856e64826ab203f27b662ce23e6a7222.jpeg',4,1,5,'2019-11-10 22:48:54',NULL,NULL),(17,1,2,'05198696257727a62e340f7d5336045b.jpeg',5,1,5,'2019-11-10 22:49:16',NULL,NULL),(18,1,2,'05884f762722ce5d236da28604867013.jpeg',6,1,5,'2019-11-10 22:49:31',NULL,NULL);

/*Table structure for table `cms_gallery_text` */

DROP TABLE IF EXISTS `cms_gallery_text`;

CREATE TABLE `cms_gallery_text` (
  `gallerytext_gallery_id` bigint(20) DEFAULT NULL,
  `gallerytext_lang` varchar(5) DEFAULT NULL,
  `gallerytext_title` varchar(250) DEFAULT NULL,
  KEY `gallerytext_lang` (`gallerytext_lang`),
  KEY `gallerytext_gallery_id` (`gallerytext_gallery_id`),
  CONSTRAINT `cms_gallery_text_ibfk_1` FOREIGN KEY (`gallerytext_gallery_id`) REFERENCES `cms_gallery` (`gallery_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_gallery_text` */

insert  into `cms_gallery_text`(`gallerytext_gallery_id`,`gallerytext_lang`,`gallerytext_title`) values (5,'en','Gallery 2'),(5,'id','Gallery 2'),(1,'en','Gallery 1'),(1,'id','Gallery 1'),(7,'en','Gallery 3'),(7,'id','Gallery 3'),(8,'en','Gallery 4'),(8,'id','Gallery 4'),(9,'en','Gallery 5'),(9,'id','Gallery 5'),(10,'en','Gallery 6'),(10,'id','Gallery 6'),(11,'en','Gallery 7'),(11,'id','Gallery 7'),(12,'en','Gallery 8'),(12,'id','Gallery 8'),(13,'en','Gallery 9'),(13,'id','Gallery 9'),(14,'en','Gallery 1 Gambar 2'),(14,'id','Gallery 1 Gambar 2'),(6,'en','Gallery 1 Gambar 1'),(6,'id','Gallery 1 Gambar 1'),(15,'en','Gallery 1 Gambar 3'),(15,'id','Gallery 1 Gambar 3'),(16,'en','Gallery 1 Gambar 4'),(16,'id','Gallery 1 Gambar 4'),(17,'en','Gallery 1 Gambar 5'),(17,'id','Gallery 1 Gambar 5'),(18,'en','Gallery 1 Gambar 6'),(18,'id','Gallery 1 Gambar 6');

/*Table structure for table `cms_greeting` */

DROP TABLE IF EXISTS `cms_greeting`;

CREATE TABLE `cms_greeting` (
  `greeting_id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'id harus selalu 1',
  `greeting_img` text,
  `greeting_link_img` text,
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`greeting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `cms_greeting` */

insert  into `cms_greeting`(`greeting_id`,`greeting_img`,`greeting_link_img`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,'52188292d937afa50ad7c8e9d191f88b.png','https://www.google.com/maps/place/Bhiva+Tour+&+Travel/@-7.7784834,110.4301161,15z/data=!4m5!3m4!1s0x2e7a5a1f1946139f:0x15c4a0a33aefd5f!8m2!3d-7.77446!4d110.430379?hl=id',1,'2019-11-03 18:47:05',5,'2019-11-03 19:25:22');

/*Table structure for table `cms_greeting_text` */

DROP TABLE IF EXISTS `cms_greeting_text`;

CREATE TABLE `cms_greeting_text` (
  `greetingtext_greeting_id` tinyint(1) DEFAULT NULL,
  `greetingtext_lang` varchar(5) DEFAULT NULL,
  `greetingtext_text` text,
  KEY `whowearetext_whoweare_id` (`greetingtext_greeting_id`),
  KEY `whowearetext_lang` (`greetingtext_lang`),
  CONSTRAINT `cms_greeting_text_ibfk_1` FOREIGN KEY (`greetingtext_greeting_id`) REFERENCES `cms_greeting` (`greeting_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_greeting_text` */

insert  into `cms_greeting_text`(`greetingtext_greeting_id`,`greetingtext_lang`,`greetingtext_text`) values (1,'en','<p><span xss=removed>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span><br></p>'),(1,'id','<p><span xss=removed>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span><br></p>');

/*Table structure for table `cms_privacypolicy` */

DROP TABLE IF EXISTS `cms_privacypolicy`;

CREATE TABLE `cms_privacypolicy` (
  `privacypolicy_id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'id harus selalu 1',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`privacypolicy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `cms_privacypolicy` */

insert  into `cms_privacypolicy`(`privacypolicy_id`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,1,'2019-09-21 22:55:34',5,'2019-09-21 23:06:26');

/*Table structure for table `cms_privacypolicy_text` */

DROP TABLE IF EXISTS `cms_privacypolicy_text`;

CREATE TABLE `cms_privacypolicy_text` (
  `privacypolicytext_privacypolicy_id` tinyint(1) DEFAULT NULL,
  `privacypolicytext_lang` varchar(5) DEFAULT NULL,
  `privacypolicytext_text` text,
  KEY `privacypolicytext_privacypolicy_id` (`privacypolicytext_privacypolicy_id`),
  KEY `privacypolicytext_lang` (`privacypolicytext_lang`),
  CONSTRAINT `cms_privacypolicy_text_ibfk_1` FOREIGN KEY (`privacypolicytext_privacypolicy_id`) REFERENCES `cms_privacypolicy` (`privacypolicy_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_privacypolicy_text` */

insert  into `cms_privacypolicy_text`(`privacypolicytext_privacypolicy_id`,`privacypolicytext_lang`,`privacypolicytext_text`) values (1,'en','<p>Privacy Policy<br></p>'),(1,'id','<p>Kebijakan Privasi</p>');

/*Table structure for table `cms_service` */

DROP TABLE IF EXISTS `cms_service`;

CREATE TABLE `cms_service` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_order` int(11) DEFAULT NULL,
  `service_is_top` tinyint(1) DEFAULT NULL COMMENT '0=no, 1=yes',
  `service_status` tinyint(1) DEFAULT NULL COMMENT '0=not active, 1=active',
  `service_type` tinyint(1) DEFAULT '0' COMMENT '0=info, 1=paket wisata, 2=tiket, 3=venue',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `cms_service` */

insert  into `cms_service`(`service_id`,`service_order`,`service_is_top`,`service_status`,`service_type`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (3,1,1,1,1,5,'2019-09-19 01:05:57',5,'2019-09-20 07:12:36'),(4,2,1,1,0,5,'2019-10-22 17:25:31',NULL,NULL);

/*Table structure for table `cms_service_img` */

DROP TABLE IF EXISTS `cms_service_img`;

CREATE TABLE `cms_service_img` (
  `serviceimg_service_id` int(11) DEFAULT NULL,
  `serviceimg_order` int(11) DEFAULT NULL,
  `serviceimg_img` text,
  KEY `serviceimg_service_id` (`serviceimg_service_id`),
  CONSTRAINT `cms_service_img_ibfk_1` FOREIGN KEY (`serviceimg_service_id`) REFERENCES `cms_service` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_service_img` */

insert  into `cms_service_img`(`serviceimg_service_id`,`serviceimg_order`,`serviceimg_img`) values (3,1,'c3022992aa92b2b750b7fd2baddd9ec4.jpeg'),(3,2,NULL),(3,3,'315ccff64f147c9275f2d7fe21ac7695.jpeg'),(3,4,NULL),(4,1,'7d01e64f3180ca3ad73e6684479c6632.png'),(4,2,NULL),(4,3,NULL),(4,4,NULL);

/*Table structure for table `cms_service_text` */

DROP TABLE IF EXISTS `cms_service_text`;

CREATE TABLE `cms_service_text` (
  `servicetext_service_id` int(11) DEFAULT NULL,
  `servicetext_lang` varchar(5) DEFAULT NULL,
  `servicetext_name` varchar(250) DEFAULT NULL,
  `servicetext_text` text,
  KEY `servicetext_service_id` (`servicetext_service_id`),
  KEY `servicetext_lang` (`servicetext_lang`),
  CONSTRAINT `cms_service_text_ibfk_1` FOREIGN KEY (`servicetext_service_id`) REFERENCES `cms_service` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_service_text` */

insert  into `cms_service_text`(`servicetext_service_id`,`servicetext_lang`,`servicetext_name`,`servicetext_text`) values (3,'en','Tour Packages','<p>Tour PackagesTour PackagesTour PackagesTour PackagesTour PackagesTour PackagesTour Packages</p>'),(3,'id','Paket Wisata','<p>Paket WisataPaket WisataPaket WisataPaket WisataPaket WisataPaket WisataPaket WisataPaket Wisata</p>'),(4,'en','Venue','<p>Venue<br></p>'),(4,'id','Venue','<p>Venue<br></p>');

/*Table structure for table `cms_slider` */

DROP TABLE IF EXISTS `cms_slider`;

CREATE TABLE `cms_slider` (
  `slider_id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_link` text,
  `slider_order` int(11) DEFAULT NULL,
  `slider_img` text,
  `slider_status` tinyint(1) DEFAULT NULL COMMENT '0=not active, 1=active',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`slider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `cms_slider` */

insert  into `cms_slider`(`slider_id`,`slider_link`,`slider_order`,`slider_img`,`slider_status`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (7,'sss',1,'0d7f566bea3b79cad6b46c3de3193552.png',1,5,'2019-09-19 21:55:39',5,'2019-10-25 17:34:03'),(8,'Perambanan',2,'b209711afce4a58c4004702a5695a359.jpeg',1,5,'2019-10-22 22:36:34',5,'2019-10-25 17:34:19');

/*Table structure for table `cms_slider_text` */

DROP TABLE IF EXISTS `cms_slider_text`;

CREATE TABLE `cms_slider_text` (
  `slidertext_slider_id` int(11) DEFAULT NULL,
  `slidertext_lang` varchar(5) DEFAULT NULL,
  `slidertext_title_link` varchar(250) DEFAULT NULL,
  `slidertext_title` varchar(250) DEFAULT NULL,
  `slidertext_text` text,
  KEY `slidertext_slider_id` (`slidertext_slider_id`),
  KEY `slidertext_lang` (`slidertext_lang`),
  CONSTRAINT `cms_slider_text_ibfk_1` FOREIGN KEY (`slidertext_slider_id`) REFERENCES `cms_slider` (`slider_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_slider_text` */

insert  into `cms_slider_text`(`slidertext_slider_id`,`slidertext_lang`,`slidertext_title_link`,`slidertext_title`,`slidertext_text`) values (7,'en','More Info','BOROBUDUR','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),(7,'id','Info Lebih lanjut','BOROBUDUR','Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'),(8,'en','More Info','PRAMBANAN','Perambanan'),(8,'id','Info Lebih lanjut','PRAMBANAN','Perambanan');

/*Table structure for table `cms_termcondition` */

DROP TABLE IF EXISTS `cms_termcondition`;

CREATE TABLE `cms_termcondition` (
  `termcondition_id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'id harus selalu 1',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`termcondition_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `cms_termcondition` */

insert  into `cms_termcondition`(`termcondition_id`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,1,'2019-09-21 23:11:54',5,'2019-09-21 23:19:28');

/*Table structure for table `cms_termcondition_text` */

DROP TABLE IF EXISTS `cms_termcondition_text`;

CREATE TABLE `cms_termcondition_text` (
  `termconditiontext_termcondition_id` tinyint(1) DEFAULT NULL,
  `termconditiontext_lang` varchar(5) DEFAULT NULL,
  `termconditiontext_text` text,
  KEY `termconditiontext_termcondition_id` (`termconditiontext_termcondition_id`),
  KEY `termconditiontext_lang` (`termconditiontext_lang`),
  CONSTRAINT `cms_termcondition_text_ibfk_1` FOREIGN KEY (`termconditiontext_termcondition_id`) REFERENCES `cms_termcondition` (`termcondition_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_termcondition_text` */

insert  into `cms_termcondition_text`(`termconditiontext_termcondition_id`,`termconditiontext_lang`,`termconditiontext_text`) values (1,'en','<p>Term & Condition</p>'),(1,'id','<p>Syarat & Ketentuan</p>');

/*Table structure for table `cms_travelpost` */

DROP TABLE IF EXISTS `cms_travelpost`;

CREATE TABLE `cms_travelpost` (
  `travelpost_id` int(11) NOT NULL AUTO_INCREMENT,
  `travelpost_status` tinyint(1) DEFAULT NULL COMMENT '0=not active, 1=active',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`travelpost_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_travelpost` */

/*Table structure for table `cms_travelpost_img` */

DROP TABLE IF EXISTS `cms_travelpost_img`;

CREATE TABLE `cms_travelpost_img` (
  `travelpostimg_travelpost_id` int(11) DEFAULT NULL,
  `travelpostimg_order` int(11) DEFAULT NULL,
  `travelpostimg_img` text,
  KEY `destimg_destination_id` (`travelpostimg_travelpost_id`),
  CONSTRAINT `cms_travelpost_img_ibfk_1` FOREIGN KEY (`travelpostimg_travelpost_id`) REFERENCES `cms_travelpost` (`travelpost_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_travelpost_img` */

/*Table structure for table `cms_travelpost_text` */

DROP TABLE IF EXISTS `cms_travelpost_text`;

CREATE TABLE `cms_travelpost_text` (
  `travelposttext_travelpost_id` int(11) DEFAULT NULL,
  `travelposttext_lang` varchar(5) DEFAULT NULL,
  `travelposttext_name` varchar(250) DEFAULT NULL,
  `travelposttext_text` text,
  KEY `desttext_destination_id` (`travelposttext_travelpost_id`),
  KEY `desttext_lang` (`travelposttext_lang`),
  CONSTRAINT `cms_travelpost_text_ibfk_1` FOREIGN KEY (`travelposttext_travelpost_id`) REFERENCES `cms_travelpost` (`travelpost_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_travelpost_text` */

/*Table structure for table `cms_whoweare` */

DROP TABLE IF EXISTS `cms_whoweare`;

CREATE TABLE `cms_whoweare` (
  `whoweare_id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'id harus selalu 1',
  `whoweare_img` text,
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`whoweare_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `cms_whoweare` */

insert  into `cms_whoweare`(`whoweare_id`,`whoweare_img`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,'ad3eb0ce922f8aa0770ce28f6f9f0db6.jpeg',1,'2019-09-20 22:00:19',5,'2019-11-05 05:07:33');

/*Table structure for table `cms_whoweare_text` */

DROP TABLE IF EXISTS `cms_whoweare_text`;

CREATE TABLE `cms_whoweare_text` (
  `whowearetext_whoweare_id` tinyint(1) DEFAULT NULL,
  `whowearetext_lang` varchar(5) DEFAULT NULL,
  `whowearetext_text` text,
  KEY `whowearetext_whoweare_id` (`whowearetext_whoweare_id`),
  KEY `whowearetext_lang` (`whowearetext_lang`),
  CONSTRAINT `cms_whoweare_text_ibfk_1` FOREIGN KEY (`whowearetext_whoweare_id`) REFERENCES `cms_whoweare` (`whoweare_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_whoweare_text` */

insert  into `cms_whoweare_text`(`whowearetext_whoweare_id`,`whowearetext_lang`,`whowearetext_text`) values (1,'en','<p xss=removed><b>PT. BHUMI VISATANDA</b></p><p xss=\"removed\" xss=removed>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>'),(1,'id','<p xss=removed><span xss=\"removed\">PT. BHUMI VISATANDA</span><br></p><p xss=\"removed\" xss=removed>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br></p>');

/*Table structure for table `core_key` */

DROP TABLE IF EXISTS `core_key`;

CREATE TABLE `core_key` (
  `key_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `key_code` varchar(250) DEFAULT NULL,
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`key_id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=latin1;

/*Data for the table `core_key` */

insert  into `core_key`(`key_id`,`key_code`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,'login',1,'2019-09-07 19:25:07',NULL,NULL),(2,'username_must_fielld',1,'2019-09-07 21:04:03',NULL,NULL),(3,'password_must_fielld',1,'2019-09-07 21:04:03',NULL,NULL),(4,'username_password_must_fielld',1,'2019-09-07 21:04:03',NULL,NULL),(5,'username_or_password_wrong',1,'2019-09-07 21:44:12',NULL,NULL),(6,'setting',1,'2019-09-08 08:58:29',NULL,NULL),(7,'logout',1,'2019-09-08 09:01:33',NULL,NULL),(8,'dashboard',1,'2019-09-08 09:02:49',NULL,NULL),(9,'master_data',1,'2019-09-08 09:19:06',NULL,NULL),(10,'user',1,'2019-09-08 09:21:27',NULL,NULL),(11,'change_password',1,'2019-09-08 09:26:41',NULL,NULL),(12,'close',1,'2019-09-08 09:36:39',NULL,NULL),(13,'save',1,'2019-09-08 09:36:40',NULL,NULL),(14,'old_password',1,'2019-09-08 09:57:46',NULL,NULL),(15,'new_password',1,'2019-09-08 09:57:46',NULL,NULL),(16,'retype_new_password',1,'2019-09-08 09:57:46',NULL,NULL),(17,'old_password_must_fielld',1,'2019-09-08 09:57:46',NULL,NULL),(18,'new_password_must_fielld',1,'2019-09-08 09:57:46',NULL,NULL),(19,'retype_new_password_must_fielld',1,'2019-09-08 09:57:46',NULL,NULL),(20,'new_password_and_retype_new_password_not_match',1,'2019-09-08 09:57:46',NULL,NULL),(21,'old_password_wrong',1,'2019-09-08 09:57:46',NULL,NULL),(22,'success_change_password',1,'2019-09-08 09:57:46',NULL,NULL),(23,'failed_change_password',1,'2019-09-08 09:57:46',NULL,NULL),(24,'translation',1,'2019-09-08 09:57:46',NULL,NULL),(25,'language',1,'2019-09-09 18:58:45',NULL,NULL),(26,'number',1,'2019-09-09 21:22:09',NULL,NULL),(27,'action',1,'2019-09-09 21:22:57',5,'2019-09-15 20:38:39'),(28,'code',1,'2019-09-09 21:23:42',NULL,NULL),(29,'add',1,'2019-09-09 21:28:25',NULL,NULL),(30,'detail',1,'2019-09-09 21:47:01',NULL,NULL),(31,'edit',1,'2019-09-09 21:47:01',NULL,NULL),(32,'delete',1,'2019-09-09 21:47:01',NULL,NULL),(33,'icon',1,'2019-09-09 21:47:01',NULL,NULL),(34,'choose_image',1,'2019-09-10 06:43:23',NULL,NULL),(35,'process',1,'2019-09-10 19:09:20',NULL,NULL),(36,'msg_add_success',1,'2019-09-10 19:39:42',NULL,NULL),(37,'msg_add_failed',1,'2019-09-10 19:39:42',NULL,NULL),(38,'required',1,'2019-09-10 19:52:01',NULL,NULL),(39,'msg_update_success',1,'2019-09-10 23:41:21',NULL,NULL),(40,'msg_update_failed',1,'2019-09-10 23:41:21',NULL,NULL),(41,'existed',1,'2019-09-11 00:15:38',NULL,NULL),(42,'success_upload',1,'2019-09-11 00:30:19',NULL,NULL),(43,'failed_upload',1,'2019-09-11 00:30:19',NULL,NULL),(44,'allowed_file_is',1,'2019-09-11 00:30:19',NULL,NULL),(45,'max_file_is',1,'2019-09-11 00:30:19',NULL,NULL),(46,'msg_delete_success',1,'2019-09-11 00:32:51',NULL,NULL),(47,'msg_delete_failed',1,'2019-09-11 00:32:51',NULL,NULL),(48,'name',1,'2019-09-12 22:12:08',NULL,NULL),(49,'email',1,'2019-09-12 22:12:24',NULL,NULL),(50,'phone',1,'2019-09-12 22:13:22',NULL,NULL),(51,'admin',1,'2019-09-12 22:13:34',NULL,NULL),(52,'yes',1,'2019-09-12 22:13:47',NULL,NULL),(53,'no',1,'2019-09-12 22:13:55',NULL,NULL),(54,'gender',1,'2019-09-13 07:02:43',NULL,NULL),(55,'birthday',1,'2019-09-13 07:03:01',NULL,NULL),(56,'nationality',1,'2019-09-13 07:03:41',NULL,NULL),(57,'address',1,'2019-09-13 07:03:54',NULL,NULL),(58,'is_admin',1,'2019-09-13 07:04:22',NULL,NULL),(59,'male',1,'2019-09-13 07:05:00',NULL,NULL),(60,'female',1,'2019-09-13 07:05:21',NULL,NULL),(61,'status',1,'2019-09-13 07:05:35',NULL,NULL),(62,'desc',1,'2019-09-13 07:06:03',NULL,NULL),(63,'password',1,'2019-09-13 07:06:22',NULL,NULL),(64,'retype_password',1,'2019-09-13 07:07:10',NULL,NULL),(65,'wni',1,'2019-09-13 07:09:40',NULL,NULL),(66,'wna',1,'2019-09-13 07:10:48',NULL,NULL),(67,'active',1,'2019-09-13 07:15:31',NULL,NULL),(68,'not_active',1,'2019-09-13 07:15:46',NULL,NULL),(69,'select',1,'2019-09-13 07:19:28',NULL,NULL),(70,'note',1,'2019-09-13 17:41:55',NULL,NULL),(71,'password_and_retype_password_not_match',1,'2019-09-14 13:22:45',NULL,NULL),(72,'inserted',1,'2019-09-14 16:23:07',NULL,NULL),(73,'updated',1,'2019-09-14 16:23:32',NULL,NULL),(74,'photo',1,'2019-09-15 00:06:20',NULL,NULL),(75,'cms',1,'2019-09-15 11:57:07',NULL,NULL),(76,'slider',1,'2019-09-15 11:57:37',NULL,NULL),(77,'service',1,'2019-09-15 12:04:28',NULL,NULL),(78,'who_we_are',1,'2019-09-15 12:06:10',NULL,NULL),(79,'contact',1,'2019-09-15 12:41:40',NULL,NULL),(80,'gallery',1,'2019-09-15 12:54:19',NULL,NULL),(81,'destination',1,'2019-09-15 13:31:48',NULL,NULL),(82,'title',1,'2019-09-15 14:00:56',NULL,NULL),(83,'link',1,'2019-09-15 14:01:19',NULL,NULL),(84,'order',1,'2019-09-15 14:02:01',NULL,NULL),(85,'image',1,'2019-09-15 14:19:10',NULL,NULL),(86,'content',1,'2019-09-15 14:23:41',NULL,NULL),(87,'title_link',1,'2019-09-15 14:47:19',1,'2019-09-15 14:47:41'),(88,'is_top',5,'2019-09-17 06:12:23',NULL,NULL),(89,'type',5,'2019-09-17 06:12:47',NULL,NULL),(90,'information',5,'2019-09-17 07:12:55',NULL,NULL),(91,'tour_packages',5,'2019-09-17 20:36:33',NULL,NULL),(92,'ticket',5,'2019-09-17 20:36:52',NULL,NULL),(93,'venue',5,'2019-09-17 20:37:23',NULL,NULL),(94,'alert',5,'2019-09-18 09:06:19',NULL,NULL),(95,'ok',5,'2019-09-18 09:09:40',NULL,NULL),(96,'term_and_condition',5,'2019-09-19 01:11:26',5,'2019-09-19 01:12:11'),(97,'privacy_policy',5,'2019-09-19 18:42:16',NULL,NULL),(98,'whatsapp',5,'2019-09-21 16:57:11',NULL,NULL),(99,'facebook',5,'2019-09-21 16:57:24',NULL,NULL),(100,'instagram',5,'2019-09-21 16:57:48',NULL,NULL),(101,'twitter',5,'2019-09-21 16:57:57',NULL,NULL),(102,'link_maps',5,'2019-09-21 16:58:31',5,'2019-09-22 09:09:12'),(103,'image_maps',5,'2019-09-21 16:58:46',NULL,NULL),(104,'galleryimages',5,'2019-09-22 12:23:47',5,'2019-09-22 12:24:13'),(105,'tourpackages',5,'2019-09-23 18:28:51',NULL,NULL),(106,'default_price_local',5,'2019-09-24 19:07:39',NULL,NULL),(107,'default_price_foreign',5,'2019-09-24 19:08:21',NULL,NULL),(108,'price_period',5,'2019-09-24 22:06:04',NULL,NULL),(109,'local_tourist_price',5,'2019-09-24 22:12:17',NULL,NULL),(110,'foreign_tourist_price',5,'2019-09-24 22:12:49',NULL,NULL),(111,'start',5,'2019-09-24 22:14:22',NULL,NULL),(112,'end',5,'2019-09-24 22:14:30',NULL,NULL),(113,'empty_data',5,'2019-09-26 09:40:13',NULL,NULL),(114,'visitor_type',5,'2019-09-27 21:49:26',NULL,NULL),(116,'is_rating_manual',5,'2019-09-28 16:06:20',NULL,NULL),(117,'rating_manual_value',5,'2019-09-28 16:10:42',NULL,NULL),(118,'total_rater_manual',5,'2019-09-28 16:12:23',NULL,NULL),(119,'day',5,'2019-09-28 23:01:41',NULL,NULL),(120,'is_night',5,'2019-09-28 23:02:32',NULL,NULL),(121,'testimony',5,'2019-10-09 12:24:57',NULL,NULL),(122,'tourpackagestestimony',5,'2019-10-09 13:46:19',NULL,NULL),(123,'rating',5,'2019-10-09 13:59:30',NULL,NULL),(124,'is_process',5,'2019-10-09 14:01:40',5,'2019-10-09 14:02:51'),(125,'is_publish',5,'2019-10-09 14:02:38',NULL,NULL),(126,'date',5,'2019-10-09 16:02:41',NULL,NULL),(127,'publish',5,'2019-10-09 18:28:35',5,'2019-10-09 18:28:51'),(128,'unpublish',5,'2019-10-09 18:29:33',NULL,NULL),(129,'transaction',5,'2019-10-09 19:48:40',NULL,NULL),(130,'venue_schedule',5,'2019-10-09 22:12:25',NULL,NULL),(131,'home',5,'2019-10-22 20:33:52',NULL,NULL),(132,'adult',5,'2019-10-23 02:18:42',NULL,NULL),(133,'child',5,'2019-10-23 02:19:52',NULL,NULL),(134,'student',5,'2019-10-23 02:20:54',NULL,NULL),(135,'tourist_type',5,'2019-10-23 02:29:08',NULL,NULL),(136,'search',5,'2019-10-23 02:31:26',NULL,NULL),(137,'other_packages',5,'2019-10-23 04:01:44',NULL,NULL),(138,'subscribe',5,'2019-10-23 04:27:10',NULL,NULL),(139,'enter_your_email',5,'2019-10-23 04:30:25',NULL,NULL),(140,'text_subscribe',5,'2019-10-25 17:41:43',NULL,NULL),(141,'text_form_ticket',5,'2019-10-25 17:44:16',NULL,NULL),(142,'text_from_ticket_title',5,'2019-10-25 17:46:38',NULL,NULL),(143,'text_most_popular_package',5,'2019-10-25 17:56:22',NULL,NULL),(144,'text_most_popular_package_title',5,'2019-10-25 17:57:06',NULL,NULL),(145,'company',5,'2019-10-26 20:10:37',NULL,NULL),(146,'support',5,'2019-10-27 06:27:10',NULL,NULL),(147,'follow_us_on',5,'2019-10-27 06:28:32',NULL,NULL),(148,'register',5,'2019-10-27 12:59:49',NULL,NULL),(149,'forget_password',5,'2019-10-27 17:06:46',NULL,NULL),(150,'is_type_visitor',5,'2019-10-28 05:30:54',5,'2019-10-28 05:41:11'),(151,'greeting',5,'2019-11-03 18:21:46',NULL,NULL),(152,'link_img',5,'2019-11-03 19:06:39',NULL,NULL),(153,'bhiva',5,'2019-11-03 19:11:05',NULL,NULL),(154,'travel_post',5,'2019-11-03 19:11:35',NULL,NULL),(155,'location',5,'2019-11-03 20:36:56',NULL,NULL),(156,'destination_location',5,'2019-11-03 21:27:20',NULL,NULL),(157,'is_show_home',5,'2019-11-03 22:43:43',5,'2019-11-03 22:43:58'),(158,'text_home_destination',5,'2019-11-04 05:34:41',NULL,NULL),(159,'other_destination',5,'2019-11-04 05:50:20',NULL,NULL),(160,'our_photo_gallery',5,'2019-11-10 13:23:01',NULL,NULL),(161,'text_our_photo_gallery',5,'2019-11-10 18:08:29',NULL,NULL),(162,'photo_gallery',5,'2019-11-10 18:34:08',NULL,NULL),(163,'blank_photo_data',5,'2019-11-11 01:47:53',NULL,NULL);

/*Table structure for table `core_key_text` */

DROP TABLE IF EXISTS `core_key_text`;

CREATE TABLE `core_key_text` (
  `keytext_key_id` bigint(20) DEFAULT NULL,
  `keytext_lang_code` varchar(5) DEFAULT NULL,
  `keytext_text` text,
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  KEY `keytext_lang_code` (`keytext_lang_code`),
  KEY `keytext_key_id` (`keytext_key_id`),
  CONSTRAINT `core_key_text_ibfk_2` FOREIGN KEY (`keytext_lang_code`) REFERENCES `core_lang` (`lang_code`),
  CONSTRAINT `core_key_text_ibfk_3` FOREIGN KEY (`keytext_key_id`) REFERENCES `core_key` (`key_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `core_key_text` */

insert  into `core_key_text`(`keytext_key_id`,`keytext_lang_code`,`keytext_text`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,'id','Login',1,'2019-09-07 19:29:48',NULL,NULL),(1,'en','Login',1,'2019-09-07 19:29:48',NULL,NULL),(2,'id','Username harus diisi',1,'2019-09-07 21:06:44',NULL,NULL),(2,'en','Username must be fielld',1,'2019-09-07 21:06:44',NULL,NULL),(3,'id','Password harus diisi',1,'2019-09-07 21:06:44',NULL,NULL),(3,'en','Password must be fielld',1,'2019-09-07 21:06:44',NULL,NULL),(4,'id','Username dan Password harus diisi',1,'2019-09-07 21:06:44',NULL,NULL),(4,'en','Username and Password must be fielld',1,'2019-09-07 21:06:44',NULL,NULL),(5,'id','Username atau Password salah',1,'2019-09-07 21:45:04',NULL,NULL),(5,'en','Username or Password is wrong',1,'2019-09-07 21:45:05',NULL,NULL),(6,'id','Setting',1,'2019-09-08 08:58:53',NULL,NULL),(6,'en','Setting',1,'2019-09-08 08:58:56',NULL,NULL),(7,'id','Logout',1,'2019-09-08 09:02:01',NULL,NULL),(7,'en','Logout',1,'2019-09-08 09:02:02',NULL,NULL),(8,'id','Dashboard',1,'2019-09-08 09:03:10',NULL,NULL),(8,'en','Dashboard',1,'2019-09-08 09:03:11',NULL,NULL),(9,'id','Data Master',1,'2019-09-08 09:19:40',NULL,NULL),(9,'en','Master Data',1,'2019-09-08 09:19:42',NULL,NULL),(10,'id','User',1,'2019-09-08 09:21:50',NULL,NULL),(10,'en','User',1,'2019-09-08 09:21:52',NULL,NULL),(11,'id','Ubah Password',1,'2019-09-08 09:27:29',NULL,NULL),(11,'en','Change Password',1,'2019-09-08 09:27:29',NULL,NULL),(12,'id','Tutup',1,'2019-09-08 09:37:46',NULL,NULL),(12,'en','Close',1,'2019-09-08 09:37:46',NULL,NULL),(13,'id','Simpan',1,'2019-09-08 09:37:46',NULL,NULL),(13,'en','Save',1,'2019-09-08 09:37:46',NULL,NULL),(14,'id','Password Lama',1,'2019-09-08 09:58:22',NULL,NULL),(14,'en','Old Password',1,'2019-09-08 09:58:22',NULL,NULL),(15,'id','Password Baru',1,'2019-09-08 09:58:22',NULL,NULL),(15,'en','New Password',1,'2019-09-08 09:58:22',NULL,NULL),(16,'id','Ketik Ulang Password Baru',1,'2019-09-08 09:58:22',NULL,NULL),(16,'en','Retype New Password',1,'2019-09-08 09:58:22',NULL,NULL),(17,'id','Password lama harus diisi',1,'2019-09-08 09:58:22',NULL,NULL),(17,'en','Old Password must be fielld',1,'2019-09-08 09:58:22',NULL,NULL),(18,'id','Password Baru harus diisi',1,'2019-09-08 09:58:22',NULL,NULL),(18,'en','New Password must be fielld',1,'2019-09-08 09:58:22',NULL,NULL),(19,'id','Ketik Ulang Password Baru harus diisi',1,'2019-09-08 09:58:22',NULL,NULL),(19,'en','Retype New Password must be fielld',1,'2019-09-08 09:58:22',NULL,NULL),(20,'id','Password Baru dan Ketik Ulang Password Baru tidak cocok',1,'2019-09-08 09:58:22',NULL,NULL),(20,'en','New Password and Retype New Password not match',1,'2019-09-08 09:58:22',NULL,NULL),(21,'id','Password Lama salah',1,'2019-09-08 09:58:22',NULL,NULL),(21,'en','Old Password wrong',1,'2019-09-08 09:58:22',NULL,NULL),(22,'id','Berhasil merubah password',1,'2019-09-08 09:58:22',NULL,NULL),(22,'en','Success change password',1,'2019-09-08 09:58:22',NULL,NULL),(23,'id','Gagal merubah password',1,'2019-09-08 09:58:22',NULL,NULL),(23,'en','Failed change password',1,'2019-09-08 09:58:22',NULL,NULL),(24,'id','Terjemahan',1,'2019-09-08 09:58:22',NULL,NULL),(24,'en','Translation',1,'2019-09-08 09:58:22',NULL,NULL),(25,'id','Bahasa',1,'2019-09-09 18:59:17',NULL,NULL),(25,'en','Language',1,'2019-09-09 18:59:18',NULL,NULL),(26,'id','No',1,'2019-09-09 21:22:38',NULL,NULL),(26,'en','No',1,'2019-09-09 21:22:38',NULL,NULL),(27,'id','Aksi',1,'2019-09-09 21:23:23',1,'2019-09-13 07:35:19'),(27,'en','Action',1,'2019-09-09 21:23:23',1,'2019-09-13 07:35:19'),(28,'id',' Kode',1,'2019-09-09 21:24:08',NULL,NULL),(28,'en','Code',1,'2019-09-09 21:24:11',NULL,NULL),(29,'id','Tambah',1,'2019-09-09 21:28:48',NULL,NULL),(29,'en','Add',1,'2019-09-09 21:28:48',NULL,NULL),(30,'id','Detail',1,'2019-09-09 21:49:03',NULL,NULL),(30,'en','Detail',1,'2019-09-09 21:49:03',NULL,NULL),(31,'id','Ubah',1,'2019-09-09 21:49:03',NULL,NULL),(31,'en','Edit',1,'2019-09-09 21:49:03',NULL,NULL),(32,'id','Hapus',1,'2019-09-09 21:49:03',NULL,NULL),(32,'en','Delete',1,'2019-09-09 21:49:03',NULL,NULL),(33,'id','Icon',1,'2019-09-09 21:49:03',NULL,NULL),(33,'en','Icon',1,'2019-09-09 21:49:03',NULL,NULL),(34,'id','Pilih Gambar',1,'2019-09-10 06:43:53',NULL,NULL),(34,'en','Choose Image',1,'2019-09-10 06:43:54',NULL,NULL),(35,'id','Proses',1,'2019-09-10 19:09:51',NULL,NULL),(35,'en','Process',1,'2019-09-10 19:09:51',NULL,NULL),(36,'id','Berhasil Menambah Data',1,'2019-09-10 19:41:31',NULL,NULL),(36,'en','Add Data Successfully',1,'2019-09-10 19:41:33',NULL,NULL),(37,'id','Gagal Menambah Data',1,'2019-09-10 19:42:45',NULL,NULL),(37,'en','Add Data Failed',1,'2019-09-10 19:42:50',NULL,NULL),(38,'id','Dibutuhkan',1,'2019-09-10 19:52:33',NULL,NULL),(38,'en','Required',1,'2019-09-10 19:52:33',NULL,NULL),(39,'id','Berhasil Merubah Data',1,'2019-09-10 23:43:28',NULL,NULL),(39,'en','Edit Data Successfully',1,'2019-09-10 23:43:28',NULL,NULL),(40,'id','Gagal Merubah Data',1,'2019-09-10 23:43:28',NULL,NULL),(40,'en','Edit Data Failed',1,'2019-09-10 23:43:28',NULL,NULL),(41,'id','Sudah Ada',1,'2019-09-11 00:13:26',NULL,NULL),(41,'en','Already Exists',1,'2019-09-11 00:13:26',NULL,NULL),(42,'id','Berhasil Upload',1,'2019-09-11 00:17:44',NULL,NULL),(42,'en','Success Upload',1,'2019-09-11 00:17:44',NULL,NULL),(43,'id','Gagal Upload',1,'2019-09-11 00:17:44',NULL,NULL),(43,'en','Failed Upload',1,'2019-09-11 00:17:44',NULL,NULL),(44,'id','File yang diperbolehkan adalah',1,'2019-09-11 00:17:44',NULL,NULL),(44,'en','Allowed file is',1,'2019-09-11 00:17:44',NULL,NULL),(45,'id','Ukuran file maksimal adalah',1,'2019-09-11 00:18:47',NULL,NULL),(45,'en','Max file size is',1,'2019-09-11 00:18:47',NULL,NULL),(46,'id','Berhasil Menghapus Data',1,'2019-09-11 00:32:37',NULL,NULL),(46,'en','Delete Data Successfully',1,'2019-09-11 00:32:37',NULL,NULL),(47,'id','Gagal Menghapus Data',1,'2019-09-11 00:32:37',NULL,NULL),(47,'en','Delete Data Failed',1,'2019-09-11 00:32:37',NULL,NULL),(48,'en','Name',1,'2019-09-12 22:12:08',NULL,NULL),(48,'id','Nama',1,'2019-09-12 22:12:08',NULL,NULL),(49,'en','Email',1,'2019-09-12 22:12:24',NULL,NULL),(49,'id','Email',1,'2019-09-12 22:12:24',NULL,NULL),(50,'en','Phone',1,'2019-09-12 22:13:22',NULL,NULL),(50,'id','Telepon',1,'2019-09-12 22:13:22',NULL,NULL),(51,'en','Admin',1,'2019-09-12 22:13:34',NULL,NULL),(51,'id','Admin',1,'2019-09-12 22:13:34',NULL,NULL),(52,'en','Yes',1,'2019-09-12 22:13:47',NULL,NULL),(52,'id','Ya',1,'2019-09-12 22:13:47',NULL,NULL),(53,'en','No',1,'2019-09-12 22:13:55',NULL,NULL),(53,'id','Tidak',1,'2019-09-12 22:13:55',NULL,NULL),(54,'en','Gender',1,'2019-09-13 07:02:43',NULL,NULL),(54,'id','Jenis Kelamin',1,'2019-09-13 07:02:43',NULL,NULL),(55,'en','Birthday',1,'2019-09-13 07:03:01',NULL,NULL),(55,'id','Tanggal Lahir',1,'2019-09-13 07:03:01',NULL,NULL),(56,'en','Nationality',1,'2019-09-13 07:03:41',NULL,NULL),(56,'id','Kewarganegaraan',1,'2019-09-13 07:03:41',NULL,NULL),(57,'en','Address',1,'2019-09-13 07:03:54',NULL,NULL),(57,'id','Alamat',1,'2019-09-13 07:03:54',NULL,NULL),(58,'en','Is Admin',1,'2019-09-13 07:04:22',NULL,NULL),(58,'id','Apakah Admin',1,'2019-09-13 07:04:22',NULL,NULL),(59,'en','Male',1,'2019-09-13 07:05:00',NULL,NULL),(59,'id','Pria',1,'2019-09-13 07:05:00',NULL,NULL),(60,'en','Female',1,'2019-09-13 07:05:21',NULL,NULL),(60,'id','Wanita',1,'2019-09-13 07:05:21',NULL,NULL),(61,'en','Status',1,'2019-09-13 07:05:35',NULL,NULL),(61,'id','Status',1,'2019-09-13 07:05:35',NULL,NULL),(62,'en','Description',1,'2019-09-13 07:06:03',NULL,NULL),(62,'id','Deskripsi',1,'2019-09-13 07:06:03',NULL,NULL),(63,'en','Password',1,'2019-09-13 07:06:22',NULL,NULL),(63,'id','Password',1,'2019-09-13 07:06:22',NULL,NULL),(64,'en','Retype Password',1,'2019-09-13 07:07:10',NULL,NULL),(64,'id','Ulang Password',1,'2019-09-13 07:07:10',NULL,NULL),(65,'en','Indonesian Citizens',1,'2019-09-13 07:09:40',NULL,NULL),(65,'id','Warga Negara Indonesia',1,'2019-09-13 07:09:40',NULL,NULL),(66,'en','Other Citizens',1,'2019-09-13 07:10:48',NULL,NULL),(66,'id','Warga Negara Asing',1,'2019-09-13 07:10:48',NULL,NULL),(67,'en','Active',1,'2019-09-13 07:15:31',NULL,NULL),(67,'id','Aktif',1,'2019-09-13 07:15:31',NULL,NULL),(68,'en','Not Active',1,'2019-09-13 07:15:46',NULL,NULL),(68,'id','Tidak Aktif',1,'2019-09-13 07:15:46',NULL,NULL),(69,'en','Select',1,'2019-09-13 07:19:28',NULL,NULL),(69,'id','Pilih',1,'2019-09-13 07:19:28',NULL,NULL),(70,'en','Note',1,'2019-09-13 17:41:55',NULL,NULL),(70,'id','Catatan',1,'2019-09-13 17:41:55',NULL,NULL),(71,'en','Password and Retype Password Not Match',1,'2019-09-14 13:22:45',NULL,NULL),(71,'id','Password dan Ulang Password Tidak Cocok',1,'2019-09-14 13:22:45',NULL,NULL),(72,'en','Inserted',1,'2019-09-14 16:23:07',NULL,NULL),(72,'id','Dimasukan',1,'2019-09-14 16:23:07',NULL,NULL),(73,'en','Updated',1,'2019-09-14 16:23:32',NULL,NULL),(73,'id','Diupdate',1,'2019-09-14 16:23:32',NULL,NULL),(74,'en','Photo',1,'2019-09-15 00:06:20',NULL,NULL),(74,'id','Foto',1,'2019-09-15 00:06:20',NULL,NULL),(75,'en','CMS',1,'2019-09-15 11:57:07',NULL,NULL),(75,'id','CMS',1,'2019-09-15 11:57:07',NULL,NULL),(76,'en','Slider',1,'2019-09-15 11:57:37',NULL,NULL),(76,'id','Slider',1,'2019-09-15 11:57:37',NULL,NULL),(77,'en','Service',1,'2019-09-15 12:04:28',NULL,NULL),(77,'id','Layanan',1,'2019-09-15 12:04:28',NULL,NULL),(78,'en','Who We Are',1,'2019-09-15 12:06:10',NULL,NULL),(78,'id','Tentang Kami',1,'2019-09-15 12:06:10',NULL,NULL),(79,'en','Contact',1,'2019-09-15 12:41:40',NULL,NULL),(79,'id','Kontak',1,'2019-09-15 12:41:40',NULL,NULL),(80,'en','Gallery',1,'2019-09-15 12:54:19',NULL,NULL),(80,'id','Galeri',1,'2019-09-15 12:54:19',NULL,NULL),(81,'en','Destination',1,'2019-09-15 13:31:48',NULL,NULL),(81,'id','Destinasi',1,'2019-09-15 13:31:48',NULL,NULL),(82,'en','Title',1,'2019-09-15 14:00:56',NULL,NULL),(82,'id','Judul',1,'2019-09-15 14:00:56',NULL,NULL),(83,'en','Link',1,'2019-09-15 14:01:19',NULL,NULL),(83,'id','Tautan',1,'2019-09-15 14:01:19',NULL,NULL),(84,'en','Order',1,'2019-09-15 14:02:01',NULL,NULL),(84,'id','Urutan',1,'2019-09-15 14:02:01',NULL,NULL),(85,'en','Image',1,'2019-09-15 14:19:10',NULL,NULL),(85,'id','Gambar',1,'2019-09-15 14:19:10',NULL,NULL),(86,'en','Content',1,'2019-09-15 14:23:41',NULL,NULL),(86,'id','Konten',1,'2019-09-15 14:23:41',NULL,NULL),(87,'en','Title Link',1,'2019-09-15 14:47:19',1,'2019-09-15 14:47:41'),(87,'id','Judul Tautan',1,'2019-09-15 14:47:19',1,'2019-09-15 14:47:41'),(88,'en','Top Position',5,'2019-09-17 06:12:23',NULL,NULL),(88,'id','Posisi Atas',5,'2019-09-17 06:12:23',NULL,NULL),(89,'en','Type',5,'2019-09-17 06:12:47',NULL,NULL),(89,'id','Jenis',5,'2019-09-17 06:12:47',NULL,NULL),(90,'en','Information',5,'2019-09-17 07:12:55',NULL,NULL),(90,'id','Informasi',5,'2019-09-17 07:12:55',NULL,NULL),(91,'en','Tour Packages',5,'2019-09-17 20:36:33',NULL,NULL),(91,'id','Paket Wisata',5,'2019-09-17 20:36:33',NULL,NULL),(92,'en','Ticket',5,'2019-09-17 20:36:52',NULL,NULL),(92,'id','Tiket',5,'2019-09-17 20:36:52',NULL,NULL),(93,'en','Venue',5,'2019-09-17 20:37:23',NULL,NULL),(93,'id','Venue',5,'2019-09-17 20:37:23',NULL,NULL),(94,'en','Alert',5,'2019-09-18 09:06:19',NULL,NULL),(94,'id','Peringatan',5,'2019-09-18 09:06:19',NULL,NULL),(95,'en','Ok',5,'2019-09-18 09:09:40',NULL,NULL),(95,'id','Ok',5,'2019-09-18 09:09:40',NULL,NULL),(96,'en','Term & Condition',5,'2019-09-19 01:11:26',5,'2019-09-19 01:12:11'),(96,'id','Syarat & Ketentuan',5,'2019-09-19 01:11:26',5,'2019-09-19 01:12:11'),(97,'en','Privacy Policy',5,'2019-09-19 18:42:16',NULL,NULL),(97,'id','Kebijakan Privasi',5,'2019-09-19 18:42:16',NULL,NULL),(98,'en','Whatsapp',5,'2019-09-21 16:57:11',NULL,NULL),(98,'id','Whatsapp',5,'2019-09-21 16:57:11',NULL,NULL),(99,'en','Facebook',5,'2019-09-21 16:57:24',NULL,NULL),(99,'id','Facebook',5,'2019-09-21 16:57:24',NULL,NULL),(100,'en','Instagram',5,'2019-09-21 16:57:48',NULL,NULL),(100,'id','Instagram',5,'2019-09-21 16:57:48',NULL,NULL),(101,'en','Twitter',5,'2019-09-21 16:57:57',NULL,NULL),(101,'id','Twitter',5,'2019-09-21 16:57:57',NULL,NULL),(102,'en','Link Maps',5,'2019-09-21 16:58:31',5,'2019-09-22 09:09:12'),(102,'id','Tautan Peta',5,'2019-09-21 16:58:31',5,'2019-09-22 09:09:12'),(103,'en','Image Maps',5,'2019-09-21 16:58:46',NULL,NULL),(103,'id','Gambar Peta',5,'2019-09-21 16:58:46',NULL,NULL),(104,'en','Gallery Images',5,'2019-09-22 12:23:47',5,'2019-09-22 12:24:13'),(104,'id','Gambar Galeri',5,'2019-09-22 12:23:47',5,'2019-09-22 12:24:13'),(105,'en','Tour Packages',5,'2019-09-23 18:28:51',NULL,NULL),(105,'id','Paket Wisata',5,'2019-09-23 18:28:51',NULL,NULL),(106,'en','Default Local Tourist Prices',5,'2019-09-24 19:07:39',NULL,NULL),(106,'id','Harga Default Wisatawan Lokal',5,'2019-09-24 19:07:39',NULL,NULL),(107,'en','Default Foreign Tourist Prices',5,'2019-09-24 19:08:21',NULL,NULL),(107,'id','Harga Default Wisatawan Asing',5,'2019-09-24 19:08:21',NULL,NULL),(108,'en','Price Period',5,'2019-09-24 22:06:04',NULL,NULL),(108,'id','Periode Harga',5,'2019-09-24 22:06:04',NULL,NULL),(109,'en','Local Tourist Price',5,'2019-09-24 22:12:17',NULL,NULL),(109,'id','Harga Wisatawan Lokal',5,'2019-09-24 22:12:17',NULL,NULL),(110,'en','Foreign Tourist Price',5,'2019-09-24 22:12:49',NULL,NULL),(110,'id','Harga Wisatawan Asing',5,'2019-09-24 22:12:49',NULL,NULL),(111,'en','Start',5,'2019-09-24 22:14:22',NULL,NULL),(111,'id','Mulai',5,'2019-09-24 22:14:22',NULL,NULL),(112,'en','End',5,'2019-09-24 22:14:30',NULL,NULL),(112,'id','Selesai',5,'2019-09-24 22:14:30',NULL,NULL),(113,'en','Empty Data',5,'2019-09-26 09:40:13',NULL,NULL),(113,'id','Data Kosong',5,'2019-09-26 09:40:13',NULL,NULL),(114,'en','Visitor Type',5,'2019-09-27 21:49:26',NULL,NULL),(114,'id','Jenis Pengunjung',5,'2019-09-27 21:49:26',NULL,NULL),(116,'en','Manual Rating',5,'2019-09-28 16:06:20',NULL,NULL),(116,'id','Penilaian Manual',5,'2019-09-28 16:06:20',NULL,NULL),(117,'en','Value of Rating Manual (1-5)',5,'2019-09-28 16:10:42',NULL,NULL),(117,'id','Nilai Penilaian Manual (1-5)',5,'2019-09-28 16:10:42',NULL,NULL),(118,'en','Rater Manual Total',5,'2019-09-28 16:12:23',NULL,NULL),(118,'id','Jumlah Penilai Manual',5,'2019-09-28 16:12:23',NULL,NULL),(119,'en','Day',5,'2019-09-28 23:01:41',NULL,NULL),(119,'id','Hari',5,'2019-09-28 23:01:41',NULL,NULL),(120,'en','Until Night',5,'2019-09-28 23:02:32',NULL,NULL),(120,'id','Sampai Malam',5,'2019-09-28 23:02:32',NULL,NULL),(121,'en','Testimony',5,'2019-10-09 12:24:57',NULL,NULL),(121,'id','Testimoni',5,'2019-10-09 12:24:57',NULL,NULL),(122,'en','Tour Packages Testimony',5,'2019-10-09 13:46:19',NULL,NULL),(122,'id','Testimoni Paket Wisata',5,'2019-10-09 13:46:19',NULL,NULL),(123,'en','Rating',5,'2019-10-09 13:59:30',NULL,NULL),(123,'id','Penilaian',5,'2019-10-09 13:59:30',NULL,NULL),(124,'en','Processed?',5,'2019-10-09 14:01:40',5,'2019-10-09 14:02:51'),(124,'id','Diproses?',5,'2019-10-09 14:01:40',5,'2019-10-09 14:02:51'),(125,'en','Published?',5,'2019-10-09 14:02:38',NULL,NULL),(125,'id','Dipublikasi?',5,'2019-10-09 14:02:38',NULL,NULL),(126,'en','Date',5,'2019-10-09 16:02:41',NULL,NULL),(126,'id','Tanggal',5,'2019-10-09 16:02:41',NULL,NULL),(127,'en','Publish',5,'2019-10-09 18:28:35',5,'2019-10-09 18:28:51'),(127,'id','Publikasi',5,'2019-10-09 18:28:35',5,'2019-10-09 18:28:51'),(128,'en','Unpublish',5,'2019-10-09 18:29:33',NULL,NULL),(128,'id','Batalkan Publikasi',5,'2019-10-09 18:29:33',NULL,NULL),(129,'en','Transaction',5,'2019-10-09 19:48:40',NULL,NULL),(129,'id','Transaksi',5,'2019-10-09 19:48:40',NULL,NULL),(130,'en','Venue Schedule',5,'2019-10-09 22:12:25',NULL,NULL),(130,'id','Jadwal Venue',5,'2019-10-09 22:12:25',NULL,NULL),(131,'en','Home',5,'2019-10-22 20:33:52',NULL,NULL),(131,'id','Beranda',5,'2019-10-22 20:33:52',NULL,NULL),(132,'en','Adult',5,'2019-10-23 02:18:42',NULL,NULL),(132,'id','Dewasa',5,'2019-10-23 02:18:42',NULL,NULL),(133,'en','Child',5,'2019-10-23 02:19:52',NULL,NULL),(133,'id','Anak',5,'2019-10-23 02:19:52',NULL,NULL),(134,'en','Student',5,'2019-10-23 02:20:54',NULL,NULL),(134,'id','Pelajar',5,'2019-10-23 02:20:54',NULL,NULL),(135,'en','Tourist Type',5,'2019-10-23 02:29:08',NULL,NULL),(135,'id','Jenis Wisatawan',5,'2019-10-23 02:29:08',NULL,NULL),(136,'en','Search',5,'2019-10-23 02:31:26',NULL,NULL),(136,'id','Cari',5,'2019-10-23 02:31:26',NULL,NULL),(137,'en','Other Packages',5,'2019-10-23 04:01:44',NULL,NULL),(137,'id','Paket Lainnya',5,'2019-10-23 04:01:44',NULL,NULL),(138,'en','Subscribe',5,'2019-10-23 04:27:10',NULL,NULL),(138,'id','Langganan',5,'2019-10-23 04:27:10',NULL,NULL),(139,'en','Enter Your email',5,'2019-10-23 04:30:25',NULL,NULL),(139,'id','Masukan email Anda',5,'2019-10-23 04:30:25',NULL,NULL),(140,'en','Subscribe to our newsletter now and be the first to know about BHIVA\'s latest promos!',5,'2019-10-25 17:41:43',NULL,NULL),(140,'id','Berlangganan newsletter kami sekarang dan jadilah yang pertama tahu tentang promo terbaru BHIVA!',5,'2019-10-25 17:41:43',NULL,NULL),(141,'en','Choose your own entrance ticket to the temple',5,'2019-10-25 17:44:16',NULL,NULL),(141,'id','Pilih tiket masuk Anda sendiri ke candi',5,'2019-10-25 17:44:16',NULL,NULL),(142,'en','Temple Entrance Ticket',5,'2019-10-25 17:46:38',NULL,NULL),(142,'id','Tiket Masuk Candi',5,'2019-10-25 17:46:38',NULL,NULL),(143,'en','Choose your own choice of attractive tour packages that we provide',5,'2019-10-25 17:56:22',NULL,NULL),(143,'id','Pilih sendiri pilihan paket wisata menarik yang kami sediakan',5,'2019-10-25 17:56:22',NULL,NULL),(144,'en','Most Popular Travel Packages',5,'2019-10-25 17:57:06',NULL,NULL),(144,'id','Paket Perjalanan Paling Populer',5,'2019-10-25 17:57:06',NULL,NULL),(145,'en','Company',5,'2019-10-26 20:10:37',NULL,NULL),(145,'id','Perusahaan',5,'2019-10-26 20:10:37',NULL,NULL),(146,'en','Support',5,'2019-10-27 06:27:10',NULL,NULL),(146,'id','Dukungan',5,'2019-10-27 06:27:10',NULL,NULL),(147,'en','Follow Us',5,'2019-10-27 06:28:32',NULL,NULL),(147,'id','Ikuti Kami',5,'2019-10-27 06:28:32',NULL,NULL),(148,'en','Register',5,'2019-10-27 12:59:49',NULL,NULL),(148,'id','Daftar',5,'2019-10-27 12:59:49',NULL,NULL),(149,'en','Forget Password',5,'2019-10-27 17:06:46',NULL,NULL),(149,'id','Lupa Password',5,'2019-10-27 17:06:46',NULL,NULL),(150,'en','There are Visitor Types',5,'2019-10-28 05:30:54',5,'2019-10-28 05:41:11'),(150,'id','Ada Jenis Pengunjung',5,'2019-10-28 05:30:54',5,'2019-10-28 05:41:11'),(151,'en','Greeting',5,'2019-11-03 18:21:46',NULL,NULL),(151,'id','Sambutan',5,'2019-11-03 18:21:46',NULL,NULL),(152,'en','Image Link',5,'2019-11-03 19:06:39',NULL,NULL),(152,'id','Tautan Gambar',5,'2019-11-03 19:06:39',NULL,NULL),(153,'en','Bhiva',5,'2019-11-03 19:11:05',NULL,NULL),(153,'id','Bhiva',5,'2019-11-03 19:11:05',NULL,NULL),(154,'en','Travel Post',5,'2019-11-03 19:11:35',NULL,NULL),(154,'id','Pos Perjalanan',5,'2019-11-03 19:11:35',NULL,NULL),(155,'en','Location',5,'2019-11-03 20:36:56',NULL,NULL),(155,'id','Lokasi',5,'2019-11-03 20:36:56',NULL,NULL),(156,'en','Destination Location',5,'2019-11-03 21:27:20',NULL,NULL),(156,'id','Lokasi Destinasi',5,'2019-11-03 21:27:20',NULL,NULL),(157,'en','Show Home?',5,'2019-11-03 22:43:43',5,'2019-11-03 22:43:58'),(157,'id','Tampil Dihome?',5,'2019-11-03 22:43:43',5,'2019-11-03 22:43:58'),(158,'en','Choose your own choice of attractive destinations that we provide',5,'2019-11-04 05:34:41',NULL,NULL),(158,'id','Pilih sendiri pilihan destinasi menarik yang kami sediakan',5,'2019-11-04 05:34:41',NULL,NULL),(159,'en','Other Destination',5,'2019-11-04 05:50:20',NULL,NULL),(159,'id','Destinasi Lainnya',5,'2019-11-04 05:50:20',NULL,NULL),(160,'en','Our Photo Gallery',5,'2019-11-10 13:23:01',NULL,NULL),(160,'id','Galeri Foto Kami',5,'2019-11-10 13:23:01',NULL,NULL),(161,'en','Let\'s see photos of our activities and business',5,'2019-11-10 18:08:29',NULL,NULL),(161,'id','Ayo lihat foto foto kegiatan dan bisnis kami',5,'2019-11-10 18:08:29',NULL,NULL),(162,'en','Photo Gallery',5,'2019-11-10 18:34:08',NULL,NULL),(162,'id','Galeri Foto',5,'2019-11-10 18:34:08',NULL,NULL),(163,'en','Blank Photo Data',5,'2019-11-11 01:47:53',NULL,NULL),(163,'id','Data Foto Kosong',5,'2019-11-11 01:47:53',NULL,NULL);

/*Table structure for table `core_lang` */

DROP TABLE IF EXISTS `core_lang`;

CREATE TABLE `core_lang` (
  `lang_code` varchar(5) NOT NULL,
  `lang_name` varchar(250) DEFAULT NULL,
  `lang_icon` text COMMENT 'file upload',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`lang_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `core_lang` */

insert  into `core_lang`(`lang_code`,`lang_name`,`lang_icon`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values ('en','English','e734a123ef3d64f10fb58bebd800dc77.png',1,'2019-09-07 19:26:03',1,'2019-09-15 15:02:37'),('id','Indonesia','4501677096c46ab34fd40f633b831e5d.png',1,'2019-09-07 19:26:01',1,'2019-09-11 05:44:13');

/*Table structure for table `core_user` */

DROP TABLE IF EXISTS `core_user`;

CREATE TABLE `core_user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_real_name` varchar(250) DEFAULT NULL,
  `user_password` varchar(150) DEFAULT NULL,
  `user_email` varchar(250) DEFAULT NULL,
  `user_phone` varchar(16) DEFAULT NULL,
  `user_gender` enum('male','female') DEFAULT NULL,
  `user_birthday` date DEFAULT NULL,
  `user_address` text,
  `user_is_admin` tinyint(1) DEFAULT NULL COMMENT '0 = no, 1 = yes',
  `user_lang` varchar(5) DEFAULT NULL,
  `user_last_login` datetime DEFAULT NULL,
  `user_status` tinyint(1) DEFAULT NULL COMMENT '0=not active, 1=active',
  `user_photo` text,
  `user_desc` text,
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `core_user` */

insert  into `core_user`(`user_id`,`user_real_name`,`user_password`,`user_email`,`user_phone`,`user_gender`,`user_birthday`,`user_address`,`user_is_admin`,`user_lang`,`user_last_login`,`user_status`,`user_photo`,`user_desc`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (5,'Riyan Trisna Wibowo','ba4e586503b7cb15e2b54b9729c066ed','riyantrisnawibowo@gmail.com','085729331231','male','2019-09-19','',1,'en',NULL,1,'1888af1f244cb9323b73c16d26d4ff72.jpeg','',1,'2019-09-15 18:29:07',5,'2019-09-15 18:34:17');

/*Table structure for table `mst_destination` */

DROP TABLE IF EXISTS `mst_destination`;

CREATE TABLE `mst_destination` (
  `destination_id` int(11) NOT NULL AUTO_INCREMENT,
  `destination_desloc_id` int(11) DEFAULT NULL,
  `destination_status` tinyint(1) DEFAULT NULL COMMENT '0=not active, 1=active',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`destination_id`),
  KEY `destination_desloc_id` (`destination_desloc_id`),
  CONSTRAINT `mst_destination_ibfk_1` FOREIGN KEY (`destination_desloc_id`) REFERENCES `ref_destination_location` (`desloc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `mst_destination` */

insert  into `mst_destination`(`destination_id`,`destination_desloc_id`,`destination_status`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,1,1,5,'2019-09-22 23:37:16',5,'2019-11-04 05:53:38');

/*Table structure for table `mst_destination_img` */

DROP TABLE IF EXISTS `mst_destination_img`;

CREATE TABLE `mst_destination_img` (
  `destinationimg_destination_id` int(11) DEFAULT NULL,
  `destinationimg_order` int(11) DEFAULT NULL,
  `destinationimg_img` text,
  KEY `destimg_destination_id` (`destinationimg_destination_id`),
  CONSTRAINT `mst_destination_img_ibfk_1` FOREIGN KEY (`destinationimg_destination_id`) REFERENCES `mst_destination` (`destination_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_destination_img` */

insert  into `mst_destination_img`(`destinationimg_destination_id`,`destinationimg_order`,`destinationimg_img`) values (1,1,'7b6180188312ed63811c0544f76e9394.jpeg'),(1,2,NULL),(1,3,NULL),(1,4,NULL);

/*Table structure for table `mst_destination_text` */

DROP TABLE IF EXISTS `mst_destination_text`;

CREATE TABLE `mst_destination_text` (
  `destinationtext_destination_id` int(11) DEFAULT NULL,
  `destinationtext_lang` varchar(5) DEFAULT NULL,
  `destinationtext_name` varchar(250) DEFAULT NULL,
  `destinationtext_text` text,
  KEY `desttext_destination_id` (`destinationtext_destination_id`),
  KEY `desttext_lang` (`destinationtext_lang`),
  CONSTRAINT `mst_destination_text_ibfk_1` FOREIGN KEY (`destinationtext_destination_id`) REFERENCES `mst_destination` (`destination_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_destination_text` */

insert  into `mst_destination_text`(`destinationtext_destination_id`,`destinationtext_lang`,`destinationtext_name`,`destinationtext_text`) values (1,'en','Borobudur Temple','<p>Borobudur Temple<br></p>'),(1,'id','Candi Borobudur','<p>Candi Borobudur<br></p>');

/*Table structure for table `mst_ticket` */

DROP TABLE IF EXISTS `mst_ticket`;

CREATE TABLE `mst_ticket` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_is_type_visitor` tinyint(1) DEFAULT NULL COMMENT '0=no, 1=yes',
  `ticket_status` tinyint(1) DEFAULT NULL COMMENT '0=not active, 1=active',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `mst_ticket` */

insert  into `mst_ticket`(`ticket_id`,`ticket_is_type_visitor`,`ticket_status`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,1,1,5,'2019-09-24 21:42:30',5,'2019-10-28 07:15:08'),(2,0,1,5,'2019-10-30 10:35:05',5,'2019-10-30 10:45:01'),(3,0,1,5,'2019-10-30 10:45:40',NULL,NULL);

/*Table structure for table `mst_ticket_price` */

DROP TABLE IF EXISTS `mst_ticket_price`;

CREATE TABLE `mst_ticket_price` (
  `ticketprice_ticket_id` int(11) DEFAULT NULL,
  `ticketprice_visitortype_id` int(11) DEFAULT NULL,
  `ticketprice_start` date DEFAULT NULL,
  `ticketprice_end` date DEFAULT NULL,
  `ticketprice_price_local` decimal(20,2) DEFAULT NULL COMMENT 'dalam rupiah',
  `ticketprice_price_foreign` decimal(20,2) DEFAULT NULL COMMENT 'dalam rupiah',
  KEY `ticketprice_ticket_id` (`ticketprice_ticket_id`),
  KEY `ticketprice_persontype_id` (`ticketprice_visitortype_id`),
  CONSTRAINT `mst_ticket_price_ibfk_1` FOREIGN KEY (`ticketprice_ticket_id`) REFERENCES `mst_ticket` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mst_ticket_price_ibfk_2` FOREIGN KEY (`ticketprice_visitortype_id`) REFERENCES `ref_visitortype` (`visitortype_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_ticket_price` */

insert  into `mst_ticket_price`(`ticketprice_ticket_id`,`ticketprice_visitortype_id`,`ticketprice_start`,`ticketprice_end`,`ticketprice_price_local`,`ticketprice_price_foreign`) values (1,1,'2019-08-01','2019-09-01','80000.00','200000.00'),(1,1,'2019-10-01','2019-10-31','70000.00','170000.00'),(1,1,'2019-11-01','2019-11-09','75000.00','175000.00'),(2,NULL,'2019-11-01','2019-11-09','1.00','2.00'),(2,NULL,'2019-11-01','2019-11-09','1.00','2.00'),(2,NULL,'2019-11-01','2019-11-09','1.00','2.00'),(3,NULL,'2019-11-01','2019-11-09','1.00','2.00'),(3,NULL,'2019-11-10','2019-11-16','2.00','3.00');

/*Table structure for table `mst_ticket_pricedefault` */

DROP TABLE IF EXISTS `mst_ticket_pricedefault`;

CREATE TABLE `mst_ticket_pricedefault` (
  `ticketpricedef_ticket_id` int(11) DEFAULT NULL,
  `ticketpricedef_visitortype_id` int(11) DEFAULT NULL,
  `ticketpricedef_price_local` decimal(20,2) DEFAULT NULL,
  `ticketpricedef_price_foreign` decimal(20,2) DEFAULT NULL,
  KEY `ticketpricedef_ticket_id` (`ticketpricedef_ticket_id`),
  KEY `ticketpricedef_persontype_id` (`ticketpricedef_visitortype_id`),
  CONSTRAINT `mst_ticket_pricedefault_ibfk_1` FOREIGN KEY (`ticketpricedef_ticket_id`) REFERENCES `mst_ticket` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mst_ticket_pricedefault_ibfk_2` FOREIGN KEY (`ticketpricedef_visitortype_id`) REFERENCES `ref_visitortype` (`visitortype_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_ticket_pricedefault` */

insert  into `mst_ticket_pricedefault`(`ticketpricedef_ticket_id`,`ticketpricedef_visitortype_id`,`ticketpricedef_price_local`,`ticketpricedef_price_foreign`) values (1,1,'15000.00','150000.00'),(1,2,'12000.00','120000.00'),(1,3,'11000.00','110000.00'),(2,NULL,'1.00','2.00'),(3,NULL,'2.00','3.00');

/*Table structure for table `mst_ticket_text` */

DROP TABLE IF EXISTS `mst_ticket_text`;

CREATE TABLE `mst_ticket_text` (
  `tickettext_ticket_id` int(11) DEFAULT NULL,
  `tickettext_lang` varchar(5) DEFAULT NULL,
  `tickettext_name` varchar(250) DEFAULT NULL,
  KEY `tickettext_ticket_id` (`tickettext_ticket_id`),
  KEY `tickettext_lang` (`tickettext_lang`),
  CONSTRAINT `mst_ticket_text_ibfk_1` FOREIGN KEY (`tickettext_ticket_id`) REFERENCES `mst_ticket` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_ticket_text` */

insert  into `mst_ticket_text`(`tickettext_ticket_id`,`tickettext_lang`,`tickettext_name`) values (1,'en','Borobudur Temple'),(1,'id','Candi Borobudur'),(2,'en','sss'),(2,'id','sss'),(3,'en','aaa'),(3,'id','aaa');

/*Table structure for table `mst_tourpackages` */

DROP TABLE IF EXISTS `mst_tourpackages`;

CREATE TABLE `mst_tourpackages` (
  `tourpackages_id` int(11) NOT NULL AUTO_INCREMENT,
  `tourpackages_base_price_local` decimal(20,2) DEFAULT NULL COMMENT 'harga (perorang) jika tiidak ada harga terjadwal yg di set',
  `tourpackages_base_price_foreign` decimal(20,2) DEFAULT NULL COMMENT 'harga (perorang) jika tiidak ada harga terjadwal yg di set',
  `tourpackages_is_rating_manual` tinyint(1) DEFAULT NULL COMMENT '0=no, 1=yes',
  `tourpackages_rating_manual` varchar(4) DEFAULT NULL COMMENT '1,2,3,4,5 (bintang) manual',
  `tourpackages_total_rater_manual` tinyint(11) DEFAULT NULL COMMENT 'jumlah penilai manual',
  `tourpackages_status` tinyint(1) DEFAULT NULL COMMENT '0=not active, 1=active',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`tourpackages_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `mst_tourpackages` */

insert  into `mst_tourpackages`(`tourpackages_id`,`tourpackages_base_price_local`,`tourpackages_base_price_foreign`,`tourpackages_is_rating_manual`,`tourpackages_rating_manual`,`tourpackages_total_rater_manual`,`tourpackages_status`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (5,'2000000.00','3000000.00',0,'4.9',15,1,5,'2019-09-28 21:44:38',5,'2019-10-23 03:43:36'),(6,'2.00','22.00',1,'4,56',100,1,5,'2019-10-09 11:53:03',5,'2019-10-23 03:40:09'),(7,'100000.00','200000.00',1,'4',5,1,5,'2019-10-23 03:41:44',5,'2019-10-23 03:45:05'),(8,'100000.00','200000.00',1,'5',4,1,5,'2019-10-23 03:57:12',5,'2019-10-23 03:58:07');

/*Table structure for table `mst_tourpackages_destination` */

DROP TABLE IF EXISTS `mst_tourpackages_destination`;

CREATE TABLE `mst_tourpackages_destination` (
  `tourpackagesdest_tourpackages_id` int(11) DEFAULT NULL,
  `tourpackagesdest_destination_id` int(11) DEFAULT NULL,
  `tourpackagesdest_day` int(11) DEFAULT NULL COMMENT 'urutan hari',
  `tourpackagesdest_order` int(11) DEFAULT NULL COMMENT 'urutan perhari',
  `tourpackagesdest_is_night` tinyint(1) DEFAULT NULL COMMENT '0=no, 1=yes (untuk menentukan apakah sampai malam)',
  KEY `tourpackagesdest_tourpackages_id` (`tourpackagesdest_tourpackages_id`),
  KEY `tourpackagesdest_destination_id` (`tourpackagesdest_destination_id`),
  CONSTRAINT `mst_tourpackages_destination_ibfk_1` FOREIGN KEY (`tourpackagesdest_tourpackages_id`) REFERENCES `mst_tourpackages` (`tourpackages_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mst_tourpackages_destination_ibfk_2` FOREIGN KEY (`tourpackagesdest_destination_id`) REFERENCES `mst_destination` (`destination_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_tourpackages_destination` */

insert  into `mst_tourpackages_destination`(`tourpackagesdest_tourpackages_id`,`tourpackagesdest_destination_id`,`tourpackagesdest_day`,`tourpackagesdest_order`,`tourpackagesdest_is_night`) values (5,1,1,1,1);

/*Table structure for table `mst_tourpackages_img` */

DROP TABLE IF EXISTS `mst_tourpackages_img`;

CREATE TABLE `mst_tourpackages_img` (
  `tourpackagesimg_tourpackages_id` int(11) DEFAULT NULL,
  `tourpackagesimg_order` int(11) DEFAULT NULL,
  `tourpackagesimg_img` text,
  KEY `destimg_destination_id` (`tourpackagesimg_tourpackages_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_tourpackages_img` */

insert  into `mst_tourpackages_img`(`tourpackagesimg_tourpackages_id`,`tourpackagesimg_order`,`tourpackagesimg_img`) values (6,1,'d08f6d39379e0cf211cec70bf67d60b9.jpeg'),(6,2,NULL),(6,3,NULL),(6,4,NULL),(5,1,'570c57f5a008c294582003be2f695450.jpeg'),(5,2,NULL),(5,3,NULL),(5,4,NULL),(7,1,'032f1746b2ffc1964ff6abb825757c78.jpeg'),(7,2,NULL),(7,3,NULL),(7,4,NULL),(8,1,'6391b023444c84d2ea7376629aef3510.jpeg'),(8,2,NULL),(8,3,NULL),(8,4,NULL);

/*Table structure for table `mst_tourpackages_price` */

DROP TABLE IF EXISTS `mst_tourpackages_price`;

CREATE TABLE `mst_tourpackages_price` (
  `tourpackagesprice_tourpackages_id` int(11) DEFAULT NULL,
  `tourpackagesprice_start` date DEFAULT NULL,
  `tourpackagesprice_end` date DEFAULT NULL,
  `tourpackagesprice_price_local` decimal(20,2) DEFAULT NULL COMMENT 'dalam rupiah / orang',
  `tourpackagesprice_price_foreign` decimal(20,2) DEFAULT NULL COMMENT 'dalam rupiah / orang',
  KEY `ticketprice_ticket_id` (`tourpackagesprice_tourpackages_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_tourpackages_price` */

insert  into `mst_tourpackages_price`(`tourpackagesprice_tourpackages_id`,`tourpackagesprice_start`,`tourpackagesprice_end`,`tourpackagesprice_price_local`,`tourpackagesprice_price_foreign`) values (6,'2019-10-30','2019-10-31','22.00','222.00'),(6,'2019-11-01','2019-11-08','2222.00','2222.00'),(5,'2019-09-01','2019-09-30','1800000.00','2800000.00'),(5,'2019-10-01','2019-10-31','1900000.00','2900000.00'),(5,'2019-11-01','2019-11-30','1700000.00','2700000.00');

/*Table structure for table `mst_tourpackages_testimony` */

DROP TABLE IF EXISTS `mst_tourpackages_testimony`;

CREATE TABLE `mst_tourpackages_testimony` (
  `tourpackagestesti_tourpackages_id` int(11) DEFAULT NULL,
  `tourpackagestesti_user_id` bigint(20) DEFAULT NULL,
  `tourpackagestesti_user_real_name` varchar(250) DEFAULT NULL,
  `tourpackagestesti_date` datetime DEFAULT NULL,
  `tourpackagestesti_testimony` text,
  `tourpackagestesti_rating` tinyint(1) DEFAULT NULL COMMENT '1,2,3,4,5 (bintang)',
  `tourpackagestesti_token` text,
  `tourpackagestesti_is_process` tinyint(1) DEFAULT '0' COMMENT '0=no,1=yes',
  `tourpackagestesti_is_publish` tinyint(1) DEFAULT '0' COMMENT '0=no,1=yes',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  KEY `tourpackagestesti_tourpackages_id` (`tourpackagestesti_tourpackages_id`),
  KEY `tourpackagestesti_user_id` (`tourpackagestesti_user_id`),
  CONSTRAINT `mst_tourpackages_testimony_ibfk_1` FOREIGN KEY (`tourpackagestesti_tourpackages_id`) REFERENCES `mst_tourpackages` (`tourpackages_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mst_tourpackages_testimony_ibfk_2` FOREIGN KEY (`tourpackagestesti_user_id`) REFERENCES `core_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_tourpackages_testimony` */

insert  into `mst_tourpackages_testimony`(`tourpackagestesti_tourpackages_id`,`tourpackagestesti_user_id`,`tourpackagestesti_user_real_name`,`tourpackagestesti_date`,`tourpackagestesti_testimony`,`tourpackagestesti_rating`,`tourpackagestesti_token`,`tourpackagestesti_is_process`,`tourpackagestesti_is_publish`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (5,5,'Riyan Trisna Wibowo','2019-10-09 13:56:00',' Mantul Mantul  Mantul Mantul  Mantul Mantul  Mantul Mantul  Mantul Mantul  Mantul Mantul  Mantul Mantul  Mantul Mantul  Mantul Mantul  Mantul Mantul ',4,'12345678909876fghjkjhgfdfgh',1,1,5,'2019-10-09 13:56:31',5,'2019-10-09 19:45:11');

/*Table structure for table `mst_tourpackages_text` */

DROP TABLE IF EXISTS `mst_tourpackages_text`;

CREATE TABLE `mst_tourpackages_text` (
  `tourpackagestext_tourpackages_id` int(11) DEFAULT NULL,
  `tourpackagestext_lang` varchar(5) DEFAULT NULL,
  `tourpackagestext_name` varchar(250) DEFAULT NULL,
  `tourpackagestext_text` text,
  KEY `tourpackagestext_tourpackages_id` (`tourpackagestext_tourpackages_id`),
  KEY `tourpackagestext_lang` (`tourpackagestext_lang`),
  CONSTRAINT `mst_tourpackages_text_ibfk_1` FOREIGN KEY (`tourpackagestext_tourpackages_id`) REFERENCES `mst_tourpackages` (`tourpackages_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_tourpackages_text` */

insert  into `mst_tourpackages_text`(`tourpackagestext_tourpackages_id`,`tourpackagestext_lang`,`tourpackagestext_name`,`tourpackagestext_text`) values (6,'en','Paket Wisata Candi','<p>Paket Wisata Candi<br></p>'),(6,'id','Paket Wisata Candi','<p>Paket Wisata Candi<br></p>'),(5,'en','Paket Keliling Jogja','<p>Paket Keliling Jogja Paket Keliling Jogja Paket Keliling Jogja<br></p>'),(5,'id','Paket Keliling Jogja','<p>Paket Keliling Jogja Paket Keliling Jogja Paket Keliling Jogja<br></p>'),(7,'en','Wisata Candi & Jogja','<p>Wisata Candi & Jogja<br></p>'),(7,'id','Wisata Candi & Jogja','<p>Wisata Candi & Jogja<br></p>'),(8,'en','Wisata Keliling Candi','<p>Wisata Keliling Candi<br></p>'),(8,'id','Wisata Keliling Candi','<p>Wisata Keliling Candi<br></p>');

/*Table structure for table `mst_venue` */

DROP TABLE IF EXISTS `mst_venue`;

CREATE TABLE `mst_venue` (
  `venue_id` int(11) NOT NULL AUTO_INCREMENT,
  `venue_status` tinyint(1) DEFAULT NULL COMMENT '0=not active, 1=active',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`venue_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `mst_venue` */

insert  into `mst_venue`(`venue_id`,`venue_status`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,1,5,'2019-09-23 21:30:46',5,'2019-09-23 21:30:55');

/*Table structure for table `mst_venue_img` */

DROP TABLE IF EXISTS `mst_venue_img`;

CREATE TABLE `mst_venue_img` (
  `venueimg_venue_id` int(11) DEFAULT NULL,
  `venueimg_order` int(11) DEFAULT NULL,
  `venueimg_img` text,
  KEY `destimg_destination_id` (`venueimg_venue_id`),
  CONSTRAINT `mst_venue_img_ibfk_1` FOREIGN KEY (`venueimg_venue_id`) REFERENCES `mst_venue` (`venue_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_venue_img` */

insert  into `mst_venue_img`(`venueimg_venue_id`,`venueimg_order`,`venueimg_img`) values (1,1,'f0c5e5d30d56f627dedf938e53bcbbb0.png'),(1,2,NULL),(1,3,NULL),(1,4,NULL);

/*Table structure for table `mst_venue_text` */

DROP TABLE IF EXISTS `mst_venue_text`;

CREATE TABLE `mst_venue_text` (
  `venuetext_venue_id` int(11) DEFAULT NULL,
  `venuetext_lang` varchar(5) DEFAULT NULL,
  `venuetext_name` varchar(250) DEFAULT NULL,
  `venuetext_text` text,
  KEY `desttext_destination_id` (`venuetext_venue_id`),
  KEY `desttext_lang` (`venuetext_lang`),
  CONSTRAINT `mst_venue_text_ibfk_1` FOREIGN KEY (`venuetext_venue_id`) REFERENCES `mst_venue` (`venue_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_venue_text` */

insert  into `mst_venue_text`(`venuetext_venue_id`,`venuetext_lang`,`venuetext_name`,`venuetext_text`) values (1,'en','Borobudur','<p>Borobudur Borobudur Borobudur<br></p>'),(1,'id','Borobudur','<p>Borobudur Borobudur Borobudur<br></p>');

/*Table structure for table `ref_destination_location` */

DROP TABLE IF EXISTS `ref_destination_location`;

CREATE TABLE `ref_destination_location` (
  `desloc_id` int(11) NOT NULL AUTO_INCREMENT,
  `desloc_name` varchar(250) DEFAULT NULL,
  `desloc_order` int(11) DEFAULT NULL,
  `desloc_is_show_home` tinyint(1) DEFAULT NULL COMMENT '0=no, 1=yes',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`desloc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `ref_destination_location` */

insert  into `ref_destination_location`(`desloc_id`,`desloc_name`,`desloc_order`,`desloc_is_show_home`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,'Joglosemar',1,1,1,'2019-11-03 20:30:29',NULL,NULL),(2,'Malang',2,1,1,'2019-11-03 20:30:31',NULL,NULL),(3,'Jogja',3,1,1,'2019-11-03 20:30:33',5,'2019-11-03 22:58:13');

/*Table structure for table `ref_visitortype` */

DROP TABLE IF EXISTS `ref_visitortype`;

CREATE TABLE `ref_visitortype` (
  `visitortype_id` int(11) NOT NULL AUTO_INCREMENT,
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`visitortype_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `ref_visitortype` */

insert  into `ref_visitortype`(`visitortype_id`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,1,'2019-09-27 20:42:38',NULL,NULL),(2,1,'2019-09-27 20:44:09',NULL,NULL),(3,1,'2019-09-27 20:44:13',NULL,NULL);

/*Table structure for table `ref_visitortype_text` */

DROP TABLE IF EXISTS `ref_visitortype_text`;

CREATE TABLE `ref_visitortype_text` (
  `visitortypetext_visitortype_id` int(11) DEFAULT NULL,
  `visitortypetext_lang` varchar(5) DEFAULT NULL,
  `visitortypetext_name` varchar(250) DEFAULT NULL,
  KEY `persontypetext_persontype_id` (`visitortypetext_visitortype_id`),
  KEY `persontypetext_lang` (`visitortypetext_lang`),
  CONSTRAINT `ref_visitortype_text_ibfk_1` FOREIGN KEY (`visitortypetext_visitortype_id`) REFERENCES `ref_visitortype` (`visitortype_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ref_visitortype_text` */

insert  into `ref_visitortype_text`(`visitortypetext_visitortype_id`,`visitortypetext_lang`,`visitortypetext_name`) values (1,'id','Dewasa'),(1,'en','Adult'),(2,'id','Anak'),(2,'en','Child'),(3,'id','Pelajar'),(3,'en','Student');

/*Table structure for table `trx_transaction` */

DROP TABLE IF EXISTS `trx_transaction`;

CREATE TABLE `trx_transaction` (
  `transaction_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `transaction_code` varchar(50) DEFAULT NULL COMMENT 'PW.09102019.000001, T.09102019.000002, V.09102019.000003',
  `transaction_date` datetime DEFAULT NULL,
  `transaction_type` tinyint(1) DEFAULT NULL COMMENT '1=paket wisata, 2=tiket, 3=venue',
  `transaction_user_id` bigint(20) DEFAULT NULL,
  `transaction_user_real_name` varchar(250) DEFAULT NULL,
  `transaction_total` decimal(20,2) DEFAULT NULL,
  `transaction_midtrans_transaction_id` varchar(250) DEFAULT NULL,
  `transaction_midtrans_response` text,
  `transaction_status` tinyint(1) DEFAULT NULL COMMENT '1=waiting, 2=paid, 3=canceled, 4=expired',
  `transaction_desc` text,
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `transaction_user_id` (`transaction_user_id`),
  CONSTRAINT `trx_transaction_ibfk_1` FOREIGN KEY (`transaction_user_id`) REFERENCES `core_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `trx_transaction` */

insert  into `trx_transaction`(`transaction_id`,`transaction_code`,`transaction_date`,`transaction_type`,`transaction_user_id`,`transaction_user_real_name`,`transaction_total`,`transaction_midtrans_transaction_id`,`transaction_midtrans_response`,`transaction_status`,`transaction_desc`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `trx_transaction_tourpackages` */

DROP TABLE IF EXISTS `trx_transaction_tourpackages`;

CREATE TABLE `trx_transaction_tourpackages` (
  `transactiontourpackages_transaction_id` bigint(20) DEFAULT NULL,
  `transactiontourpackages_tourpackages_id` int(11) DEFAULT NULL,
  `transactiontourpackages_start` date DEFAULT NULL,
  `transactiontourpackages_total_persons` int(11) DEFAULT NULL,
  `transactiontourpackages_total_day` int(11) DEFAULT NULL COMMENT '3 hari',
  `transactiontourpackages_total_night` int(11) DEFAULT NULL COMMENT '2 malam',
  KEY `transactionvenue_transaction_id` (`transactiontourpackages_transaction_id`),
  KEY `transactionvenue_venue_id` (`transactiontourpackages_tourpackages_id`),
  CONSTRAINT `trx_transaction_tourpackages_ibfk_1` FOREIGN KEY (`transactiontourpackages_transaction_id`) REFERENCES `trx_transaction` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `trx_transaction_tourpackages_ibfk_2` FOREIGN KEY (`transactiontourpackages_tourpackages_id`) REFERENCES `mst_tourpackages` (`tourpackages_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `trx_transaction_tourpackages` */

/*Table structure for table `trx_transaction_venue` */

DROP TABLE IF EXISTS `trx_transaction_venue`;

CREATE TABLE `trx_transaction_venue` (
  `transactionvenue_transaction_id` bigint(20) DEFAULT NULL,
  `transactionvenue_venue_id` int(11) DEFAULT NULL,
  `transactionvenue_date` date DEFAULT NULL,
  KEY `transactionvenue_transaction_id` (`transactionvenue_transaction_id`),
  KEY `transactionvenue_venue_id` (`transactionvenue_venue_id`),
  CONSTRAINT `trx_transaction_venue_ibfk_1` FOREIGN KEY (`transactionvenue_transaction_id`) REFERENCES `trx_transaction` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `trx_transaction_venue_ibfk_2` FOREIGN KEY (`transactionvenue_venue_id`) REFERENCES `mst_venue` (`venue_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `trx_transaction_venue` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
