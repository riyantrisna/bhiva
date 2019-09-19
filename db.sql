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
  CONSTRAINT `_cms_infocontact_emp_ibfk_1` FOREIGN KEY (`infocontactemp_infocontact_id`) REFERENCES `cms_infocontact` (`infocontact_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `_cms_infocontact_emp` */

/*Table structure for table `cms_gallery` */

DROP TABLE IF EXISTS `cms_gallery`;

CREATE TABLE `cms_gallery` (
  `galery_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `galery_parent_id` bigint(20) DEFAULT NULL COMMENT 'terisi hanya untuk tipe gambar yg link ke id gallery',
  `galery_type` tinyint(1) DEFAULT NULL COMMENT '1=album, 2=image',
  `galery_img` text,
  `galery_order` int(11) DEFAULT NULL,
  `galery_status` tinyint(1) DEFAULT NULL COMMENT '0=not active, 1=active',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`galery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_gallery` */

/*Table structure for table `cms_gallery_text` */

DROP TABLE IF EXISTS `cms_gallery_text`;

CREATE TABLE `cms_gallery_text` (
  `gallerytext_gallery_id` bigint(20) DEFAULT NULL,
  `gallerytext_lang` varchar(5) DEFAULT NULL,
  `gallerytext_title` varchar(250) DEFAULT NULL,
  KEY `gallerytext_lang` (`gallerytext_lang`),
  KEY `gallerytext_gallery_id` (`gallerytext_gallery_id`),
  CONSTRAINT `cms_gallery_text_ibfk_1` FOREIGN KEY (`gallerytext_gallery_id`) REFERENCES `cms_gallery` (`galery_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_gallery_text` */

/*Table structure for table `cms_infocontact` */

DROP TABLE IF EXISTS `cms_infocontact`;

CREATE TABLE `cms_infocontact` (
  `infocontact_id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'id harus selalu 1',
  `infocontact_whoweare_img` text,
  `infocontact_contact_address` text,
  `infocontact_contact_email` varchar(250) DEFAULT NULL,
  `infocontact_contact_phone` varchar(16) DEFAULT NULL,
  `infocontact_contact_wa` varchar(16) DEFAULT NULL,
  `infocontact_contact_fb` varchar(250) DEFAULT NULL,
  `infocontact_contact_ig` varchar(250) DEFAULT NULL,
  `infocontact_contact_twitter` varchar(250) DEFAULT NULL,
  `infocontact_contact_img_maps` text,
  `infocontact_contact_link_maps` text,
  `infocontact_tac_date` datetime DEFAULT NULL COMMENT 'T&C date update',
  `infocontact_pp_date` datetime DEFAULT NULL COMMENT 'Privacy Policy date update',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`infocontact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_infocontact` */

/*Table structure for table `cms_infocontact_text` */

DROP TABLE IF EXISTS `cms_infocontact_text`;

CREATE TABLE `cms_infocontact_text` (
  `infocontacttext_infocontact_id` tinyint(1) DEFAULT NULL,
  `infocontacttext_lang` varchar(5) DEFAULT NULL,
  `infocontacttext_whoweare_text` text,
  `infocontacttext_tac_text` text,
  `infocontacttext_pp_text` text,
  KEY `infocontacttext_infocontact_id` (`infocontacttext_infocontact_id`),
  KEY `infocontacttext_lang` (`infocontacttext_lang`),
  CONSTRAINT `cms_infocontact_text_ibfk_1` FOREIGN KEY (`infocontacttext_infocontact_id`) REFERENCES `cms_infocontact` (`infocontact_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_infocontact_text` */

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `cms_service` */

insert  into `cms_service`(`service_id`,`service_order`,`service_is_top`,`service_status`,`service_type`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (3,1,1,1,1,5,'2019-09-19 01:05:57',5,'2019-09-19 01:06:12');

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

insert  into `cms_service_img`(`serviceimg_service_id`,`serviceimg_order`,`serviceimg_img`) values (3,1,'eb0a9f3a2bd3bfbe4c530632999507c2.jpeg'),(3,2,NULL),(3,3,'bf5ea940c6d4493652c42ae32a05b6ca.jpeg'),(3,4,NULL);

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

insert  into `cms_service_text`(`servicetext_service_id`,`servicetext_lang`,`servicetext_name`,`servicetext_text`) values (3,'en','Tour Packages','<p>Tour PackagesTour PackagesTour PackagesTour PackagesTour PackagesTour PackagesTour Packages</p>'),(3,'id','Paket Wisata','<p>Paket WisataPaket WisataPaket WisataPaket WisataPaket WisataPaket WisataPaket WisataPaket Wisata</p>');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `cms_slider` */

insert  into `cms_slider`(`slider_id`,`slider_link`,`slider_order`,`slider_img`,`slider_status`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (7,'ss',2,'dc3d70f144a70150408f1c61224cf35b.jpeg',1,5,'2019-09-19 21:55:39',5,'2019-09-19 23:42:35');

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

insert  into `cms_slider_text`(`slidertext_slider_id`,`slidertext_lang`,`slidertext_title_link`,`slidertext_title`,`slidertext_text`) values (7,'en','ss','ss','ss'),(7,'id','ss','ss','ss');

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
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;

/*Data for the table `core_key` */

insert  into `core_key`(`key_id`,`key_code`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,'login',1,'2019-09-07 19:25:07',NULL,NULL),(2,'username_must_fielld',1,'2019-09-07 21:04:03',NULL,NULL),(3,'password_must_fielld',1,'2019-09-07 21:04:03',NULL,NULL),(4,'username_password_must_fielld',1,'2019-09-07 21:04:03',NULL,NULL),(5,'username_or_password_wrong',1,'2019-09-07 21:44:12',NULL,NULL),(6,'setting',1,'2019-09-08 08:58:29',NULL,NULL),(7,'logout',1,'2019-09-08 09:01:33',NULL,NULL),(8,'dashboard',1,'2019-09-08 09:02:49',NULL,NULL),(9,'master_data',1,'2019-09-08 09:19:06',NULL,NULL),(10,'user',1,'2019-09-08 09:21:27',NULL,NULL),(11,'change_password',1,'2019-09-08 09:26:41',NULL,NULL),(12,'close',1,'2019-09-08 09:36:39',NULL,NULL),(13,'save',1,'2019-09-08 09:36:40',NULL,NULL),(14,'old_password',1,'2019-09-08 09:57:46',NULL,NULL),(15,'new_password',1,'2019-09-08 09:57:46',NULL,NULL),(16,'retype_new_password',1,'2019-09-08 09:57:46',NULL,NULL),(17,'old_password_must_fielld',1,'2019-09-08 09:57:46',NULL,NULL),(18,'new_password_must_fielld',1,'2019-09-08 09:57:46',NULL,NULL),(19,'retype_new_password_must_fielld',1,'2019-09-08 09:57:46',NULL,NULL),(20,'new_password_and_retype_new_password_not_match',1,'2019-09-08 09:57:46',NULL,NULL),(21,'old_password_wrong',1,'2019-09-08 09:57:46',NULL,NULL),(22,'success_change_password',1,'2019-09-08 09:57:46',NULL,NULL),(23,'failed_change_password',1,'2019-09-08 09:57:46',NULL,NULL),(24,'translation',1,'2019-09-08 09:57:46',NULL,NULL),(25,'language',1,'2019-09-09 18:58:45',NULL,NULL),(26,'number',1,'2019-09-09 21:22:09',NULL,NULL),(27,'action',1,'2019-09-09 21:22:57',5,'2019-09-15 20:38:39'),(28,'code',1,'2019-09-09 21:23:42',NULL,NULL),(29,'add',1,'2019-09-09 21:28:25',NULL,NULL),(30,'detail',1,'2019-09-09 21:47:01',NULL,NULL),(31,'edit',1,'2019-09-09 21:47:01',NULL,NULL),(32,'delete',1,'2019-09-09 21:47:01',NULL,NULL),(33,'icon',1,'2019-09-09 21:47:01',NULL,NULL),(34,'choose_image',1,'2019-09-10 06:43:23',NULL,NULL),(35,'process',1,'2019-09-10 19:09:20',NULL,NULL),(36,'msg_add_success',1,'2019-09-10 19:39:42',NULL,NULL),(37,'msg_add_failed',1,'2019-09-10 19:39:42',NULL,NULL),(38,'required',1,'2019-09-10 19:52:01',NULL,NULL),(39,'msg_update_success',1,'2019-09-10 23:41:21',NULL,NULL),(40,'msg_update_failed',1,'2019-09-10 23:41:21',NULL,NULL),(41,'existed',1,'2019-09-11 00:15:38',NULL,NULL),(42,'success_upload',1,'2019-09-11 00:30:19',NULL,NULL),(43,'failed_upload',1,'2019-09-11 00:30:19',NULL,NULL),(44,'allowed_file_is',1,'2019-09-11 00:30:19',NULL,NULL),(45,'max_file_is',1,'2019-09-11 00:30:19',NULL,NULL),(46,'msg_delete_success',1,'2019-09-11 00:32:51',NULL,NULL),(47,'msg_delete_failed',1,'2019-09-11 00:32:51',NULL,NULL),(48,'name',1,'2019-09-12 22:12:08',NULL,NULL),(49,'email',1,'2019-09-12 22:12:24',NULL,NULL),(50,'phone',1,'2019-09-12 22:13:22',NULL,NULL),(51,'admin',1,'2019-09-12 22:13:34',NULL,NULL),(52,'yes',1,'2019-09-12 22:13:47',NULL,NULL),(53,'no',1,'2019-09-12 22:13:55',NULL,NULL),(54,'gender',1,'2019-09-13 07:02:43',NULL,NULL),(55,'birthday',1,'2019-09-13 07:03:01',NULL,NULL),(56,'nationality',1,'2019-09-13 07:03:41',NULL,NULL),(57,'address',1,'2019-09-13 07:03:54',NULL,NULL),(58,'is_admin',1,'2019-09-13 07:04:22',NULL,NULL),(59,'male',1,'2019-09-13 07:05:00',NULL,NULL),(60,'female',1,'2019-09-13 07:05:21',NULL,NULL),(61,'status',1,'2019-09-13 07:05:35',NULL,NULL),(62,'desc',1,'2019-09-13 07:06:03',NULL,NULL),(63,'password',1,'2019-09-13 07:06:22',NULL,NULL),(64,'retype_password',1,'2019-09-13 07:07:10',NULL,NULL),(65,'wni',1,'2019-09-13 07:09:40',NULL,NULL),(66,'wna',1,'2019-09-13 07:10:48',NULL,NULL),(67,'active',1,'2019-09-13 07:15:31',NULL,NULL),(68,'not_active',1,'2019-09-13 07:15:46',NULL,NULL),(69,'select',1,'2019-09-13 07:19:28',NULL,NULL),(70,'note',1,'2019-09-13 17:41:55',NULL,NULL),(71,'password_and_retype_password_not_match',1,'2019-09-14 13:22:45',NULL,NULL),(72,'inserted',1,'2019-09-14 16:23:07',NULL,NULL),(73,'updated',1,'2019-09-14 16:23:32',NULL,NULL),(74,'photo',1,'2019-09-15 00:06:20',NULL,NULL),(75,'cms',1,'2019-09-15 11:57:07',NULL,NULL),(76,'slider',1,'2019-09-15 11:57:37',NULL,NULL),(77,'service',1,'2019-09-15 12:04:28',NULL,NULL),(78,'who_we_are',1,'2019-09-15 12:06:10',NULL,NULL),(79,'contact',1,'2019-09-15 12:41:40',NULL,NULL),(80,'gallery',1,'2019-09-15 12:54:19',NULL,NULL),(81,'destination',1,'2019-09-15 13:31:48',NULL,NULL),(82,'title',1,'2019-09-15 14:00:56',NULL,NULL),(83,'link',1,'2019-09-15 14:01:19',NULL,NULL),(84,'order',1,'2019-09-15 14:02:01',NULL,NULL),(85,'image',1,'2019-09-15 14:19:10',NULL,NULL),(86,'content',1,'2019-09-15 14:23:41',NULL,NULL),(87,'title_link',1,'2019-09-15 14:47:19',1,'2019-09-15 14:47:41'),(88,'is_top',5,'2019-09-17 06:12:23',NULL,NULL),(89,'type',5,'2019-09-17 06:12:47',NULL,NULL),(90,'information',5,'2019-09-17 07:12:55',NULL,NULL),(91,'tour_packages',5,'2019-09-17 20:36:33',NULL,NULL),(92,'ticket',5,'2019-09-17 20:36:52',NULL,NULL),(93,'venue',5,'2019-09-17 20:37:23',NULL,NULL),(94,'alert',5,'2019-09-18 09:06:19',NULL,NULL),(95,'ok',5,'2019-09-18 09:09:40',NULL,NULL),(96,'term_and_condition',5,'2019-09-19 01:11:26',5,'2019-09-19 01:12:11'),(97,'privacy_policy',5,'2019-09-19 18:42:16',NULL,NULL);

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

insert  into `core_key_text`(`keytext_key_id`,`keytext_lang_code`,`keytext_text`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,'id','Login',1,'2019-09-07 19:29:48',NULL,NULL),(1,'en','Login',1,'2019-09-07 19:29:48',NULL,NULL),(2,'id','Username harus diisi',1,'2019-09-07 21:06:44',NULL,NULL),(2,'en','Username must be fielld',1,'2019-09-07 21:06:44',NULL,NULL),(3,'id','Password harus diisi',1,'2019-09-07 21:06:44',NULL,NULL),(3,'en','Password must be fielld',1,'2019-09-07 21:06:44',NULL,NULL),(4,'id','Username dan Password harus diisi',1,'2019-09-07 21:06:44',NULL,NULL),(4,'en','Username and Password must be fielld',1,'2019-09-07 21:06:44',NULL,NULL),(5,'id','Username atau Password salah',1,'2019-09-07 21:45:04',NULL,NULL),(5,'en','Username or Password is wrong',1,'2019-09-07 21:45:05',NULL,NULL),(6,'id','Setting',1,'2019-09-08 08:58:53',NULL,NULL),(6,'en','Setting',1,'2019-09-08 08:58:56',NULL,NULL),(7,'id','Logout',1,'2019-09-08 09:02:01',NULL,NULL),(7,'en','Logout',1,'2019-09-08 09:02:02',NULL,NULL),(8,'id','Dashboard',1,'2019-09-08 09:03:10',NULL,NULL),(8,'en','Dashboard',1,'2019-09-08 09:03:11',NULL,NULL),(9,'id','Data Master',1,'2019-09-08 09:19:40',NULL,NULL),(9,'en','Master Data',1,'2019-09-08 09:19:42',NULL,NULL),(10,'id','User',1,'2019-09-08 09:21:50',NULL,NULL),(10,'en','User',1,'2019-09-08 09:21:52',NULL,NULL),(11,'id','Ubah Password',1,'2019-09-08 09:27:29',NULL,NULL),(11,'en','Change Password',1,'2019-09-08 09:27:29',NULL,NULL),(12,'id','Tutup',1,'2019-09-08 09:37:46',NULL,NULL),(12,'en','Close',1,'2019-09-08 09:37:46',NULL,NULL),(13,'id','Simpan',1,'2019-09-08 09:37:46',NULL,NULL),(13,'en','Save',1,'2019-09-08 09:37:46',NULL,NULL),(14,'id','Password Lama',1,'2019-09-08 09:58:22',NULL,NULL),(14,'en','Old Password',1,'2019-09-08 09:58:22',NULL,NULL),(15,'id','Password Baru',1,'2019-09-08 09:58:22',NULL,NULL),(15,'en','New Password',1,'2019-09-08 09:58:22',NULL,NULL),(16,'id','Ketik Ulang Password Baru',1,'2019-09-08 09:58:22',NULL,NULL),(16,'en','Retype New Password',1,'2019-09-08 09:58:22',NULL,NULL),(17,'id','Password lama harus diisi',1,'2019-09-08 09:58:22',NULL,NULL),(17,'en','Old Password must be fielld',1,'2019-09-08 09:58:22',NULL,NULL),(18,'id','Password Baru harus diisi',1,'2019-09-08 09:58:22',NULL,NULL),(18,'en','New Password must be fielld',1,'2019-09-08 09:58:22',NULL,NULL),(19,'id','Ketik Ulang Password Baru harus diisi',1,'2019-09-08 09:58:22',NULL,NULL),(19,'en','Retype New Password must be fielld',1,'2019-09-08 09:58:22',NULL,NULL),(20,'id','Password Baru dan Ketik Ulang Password Baru tidak cocok',1,'2019-09-08 09:58:22',NULL,NULL),(20,'en','New Password and Retype New Password not match',1,'2019-09-08 09:58:22',NULL,NULL),(21,'id','Password Lama salah',1,'2019-09-08 09:58:22',NULL,NULL),(21,'en','Old Password wrong',1,'2019-09-08 09:58:22',NULL,NULL),(22,'id','Berhasil merubah password',1,'2019-09-08 09:58:22',NULL,NULL),(22,'en','Success change password',1,'2019-09-08 09:58:22',NULL,NULL),(23,'id','Gagal merubah password',1,'2019-09-08 09:58:22',NULL,NULL),(23,'en','Failed change password',1,'2019-09-08 09:58:22',NULL,NULL),(24,'id','Terjemahan',1,'2019-09-08 09:58:22',NULL,NULL),(24,'en','Translation',1,'2019-09-08 09:58:22',NULL,NULL),(25,'id','Bahasa',1,'2019-09-09 18:59:17',NULL,NULL),(25,'en','Language',1,'2019-09-09 18:59:18',NULL,NULL),(26,'id','No',1,'2019-09-09 21:22:38',NULL,NULL),(26,'en','No',1,'2019-09-09 21:22:38',NULL,NULL),(27,'id','Aksi',1,'2019-09-09 21:23:23',1,'2019-09-13 07:35:19'),(27,'en','Action',1,'2019-09-09 21:23:23',1,'2019-09-13 07:35:19'),(28,'id',' Kode',1,'2019-09-09 21:24:08',NULL,NULL),(28,'en','Code',1,'2019-09-09 21:24:11',NULL,NULL),(29,'id','Tambah',1,'2019-09-09 21:28:48',NULL,NULL),(29,'en','Add',1,'2019-09-09 21:28:48',NULL,NULL),(30,'id','Detail',1,'2019-09-09 21:49:03',NULL,NULL),(30,'en','Detail',1,'2019-09-09 21:49:03',NULL,NULL),(31,'id','Ubah',1,'2019-09-09 21:49:03',NULL,NULL),(31,'en','Edit',1,'2019-09-09 21:49:03',NULL,NULL),(32,'id','Hapus',1,'2019-09-09 21:49:03',NULL,NULL),(32,'en','Delete',1,'2019-09-09 21:49:03',NULL,NULL),(33,'id','Icon',1,'2019-09-09 21:49:03',NULL,NULL),(33,'en','Icon',1,'2019-09-09 21:49:03',NULL,NULL),(34,'id','Pilih Gambar',1,'2019-09-10 06:43:53',NULL,NULL),(34,'en','Choose Image',1,'2019-09-10 06:43:54',NULL,NULL),(35,'id','Proses',1,'2019-09-10 19:09:51',NULL,NULL),(35,'en','Process',1,'2019-09-10 19:09:51',NULL,NULL),(36,'id','Berhasil Menambah Data',1,'2019-09-10 19:41:31',NULL,NULL),(36,'en','Add Data Successfully',1,'2019-09-10 19:41:33',NULL,NULL),(37,'id','Gagal Menambah Data',1,'2019-09-10 19:42:45',NULL,NULL),(37,'en','Add Data Failed',1,'2019-09-10 19:42:50',NULL,NULL),(38,'id','Dibutuhkan',1,'2019-09-10 19:52:33',NULL,NULL),(38,'en','Required',1,'2019-09-10 19:52:33',NULL,NULL),(39,'id','Berhasil Merubah Data',1,'2019-09-10 23:43:28',NULL,NULL),(39,'en','Edit Data Successfully',1,'2019-09-10 23:43:28',NULL,NULL),(40,'id','Gagal Merubah Data',1,'2019-09-10 23:43:28',NULL,NULL),(40,'en','Edit Data Failed',1,'2019-09-10 23:43:28',NULL,NULL),(41,'id','Sudah Ada',1,'2019-09-11 00:13:26',NULL,NULL),(41,'en','Already Exists',1,'2019-09-11 00:13:26',NULL,NULL),(42,'id','Berhasil Upload',1,'2019-09-11 00:17:44',NULL,NULL),(42,'en','Success Upload',1,'2019-09-11 00:17:44',NULL,NULL),(43,'id','Gagal Upload',1,'2019-09-11 00:17:44',NULL,NULL),(43,'en','Failed Upload',1,'2019-09-11 00:17:44',NULL,NULL),(44,'id','File yang diperbolehkan adalah',1,'2019-09-11 00:17:44',NULL,NULL),(44,'en','Allowed file is',1,'2019-09-11 00:17:44',NULL,NULL),(45,'id','Ukuran file maksimal adalah',1,'2019-09-11 00:18:47',NULL,NULL),(45,'en','Max file size is',1,'2019-09-11 00:18:47',NULL,NULL),(46,'id','Berhasil Menghapus Data',1,'2019-09-11 00:32:37',NULL,NULL),(46,'en','Delete Data Successfully',1,'2019-09-11 00:32:37',NULL,NULL),(47,'id','Gagal Menghapus Data',1,'2019-09-11 00:32:37',NULL,NULL),(47,'en','Delete Data Failed',1,'2019-09-11 00:32:37',NULL,NULL),(48,'en','Name',1,'2019-09-12 22:12:08',NULL,NULL),(48,'id','Nama',1,'2019-09-12 22:12:08',NULL,NULL),(49,'en','Email',1,'2019-09-12 22:12:24',NULL,NULL),(49,'id','Email',1,'2019-09-12 22:12:24',NULL,NULL),(50,'en','Phone',1,'2019-09-12 22:13:22',NULL,NULL),(50,'id','Telepon',1,'2019-09-12 22:13:22',NULL,NULL),(51,'en','Admin',1,'2019-09-12 22:13:34',NULL,NULL),(51,'id','Admin',1,'2019-09-12 22:13:34',NULL,NULL),(52,'en','Yes',1,'2019-09-12 22:13:47',NULL,NULL),(52,'id','Ya',1,'2019-09-12 22:13:47',NULL,NULL),(53,'en','No',1,'2019-09-12 22:13:55',NULL,NULL),(53,'id','Tidak',1,'2019-09-12 22:13:55',NULL,NULL),(54,'en','Gender',1,'2019-09-13 07:02:43',NULL,NULL),(54,'id','Jenis Kelamin',1,'2019-09-13 07:02:43',NULL,NULL),(55,'en','Birthday',1,'2019-09-13 07:03:01',NULL,NULL),(55,'id','Tanggal Lahir',1,'2019-09-13 07:03:01',NULL,NULL),(56,'en','Nationality',1,'2019-09-13 07:03:41',NULL,NULL),(56,'id','Kewarganegaraan',1,'2019-09-13 07:03:41',NULL,NULL),(57,'en','Address',1,'2019-09-13 07:03:54',NULL,NULL),(57,'id','Alamat',1,'2019-09-13 07:03:54',NULL,NULL),(58,'en','Is Admin',1,'2019-09-13 07:04:22',NULL,NULL),(58,'id','Apakah Admin',1,'2019-09-13 07:04:22',NULL,NULL),(59,'en','Male',1,'2019-09-13 07:05:00',NULL,NULL),(59,'id','Pria',1,'2019-09-13 07:05:00',NULL,NULL),(60,'en','Female',1,'2019-09-13 07:05:21',NULL,NULL),(60,'id','Wanita',1,'2019-09-13 07:05:21',NULL,NULL),(61,'en','Status',1,'2019-09-13 07:05:35',NULL,NULL),(61,'id','Status',1,'2019-09-13 07:05:35',NULL,NULL),(62,'en','Description',1,'2019-09-13 07:06:03',NULL,NULL),(62,'id','Deskripsi',1,'2019-09-13 07:06:03',NULL,NULL),(63,'en','Password',1,'2019-09-13 07:06:22',NULL,NULL),(63,'id','Password',1,'2019-09-13 07:06:22',NULL,NULL),(64,'en','Retype Password',1,'2019-09-13 07:07:10',NULL,NULL),(64,'id','Ulang Password',1,'2019-09-13 07:07:10',NULL,NULL),(65,'en','Indonesian Citizens',1,'2019-09-13 07:09:40',NULL,NULL),(65,'id','Warga Negara Indonesia',1,'2019-09-13 07:09:40',NULL,NULL),(66,'en','Other Citizens',1,'2019-09-13 07:10:48',NULL,NULL),(66,'id','Warga Negara Asing',1,'2019-09-13 07:10:48',NULL,NULL),(67,'en','Active',1,'2019-09-13 07:15:31',NULL,NULL),(67,'id','Aktif',1,'2019-09-13 07:15:31',NULL,NULL),(68,'en','Not Active',1,'2019-09-13 07:15:46',NULL,NULL),(68,'id','Tidak Aktif',1,'2019-09-13 07:15:46',NULL,NULL),(69,'en','Select',1,'2019-09-13 07:19:28',NULL,NULL),(69,'id','Pilih',1,'2019-09-13 07:19:28',NULL,NULL),(70,'en','Note',1,'2019-09-13 17:41:55',NULL,NULL),(70,'id','Catatan',1,'2019-09-13 17:41:55',NULL,NULL),(71,'en','Password and Retype Password Not Match',1,'2019-09-14 13:22:45',NULL,NULL),(71,'id','Password dan Ulang Password Tidak Cocok',1,'2019-09-14 13:22:45',NULL,NULL),(72,'en','Inserted',1,'2019-09-14 16:23:07',NULL,NULL),(72,'id','Dimasukan',1,'2019-09-14 16:23:07',NULL,NULL),(73,'en','Updated',1,'2019-09-14 16:23:32',NULL,NULL),(73,'id','Diupdate',1,'2019-09-14 16:23:32',NULL,NULL),(74,'en','Photo',1,'2019-09-15 00:06:20',NULL,NULL),(74,'id','Foto',1,'2019-09-15 00:06:20',NULL,NULL),(75,'en','CMS',1,'2019-09-15 11:57:07',NULL,NULL),(75,'id','CMS',1,'2019-09-15 11:57:07',NULL,NULL),(76,'en','Slider',1,'2019-09-15 11:57:37',NULL,NULL),(76,'id','Slider',1,'2019-09-15 11:57:37',NULL,NULL),(77,'en','Service',1,'2019-09-15 12:04:28',NULL,NULL),(77,'id','Layanan',1,'2019-09-15 12:04:28',NULL,NULL),(78,'en','Who We Are',1,'2019-09-15 12:06:10',NULL,NULL),(78,'id','Tentang Kami',1,'2019-09-15 12:06:10',NULL,NULL),(79,'en','Contact',1,'2019-09-15 12:41:40',NULL,NULL),(79,'id','Kontak',1,'2019-09-15 12:41:40',NULL,NULL),(80,'en','Gallery',1,'2019-09-15 12:54:19',NULL,NULL),(80,'id','Galeri',1,'2019-09-15 12:54:19',NULL,NULL),(81,'en','Destination',1,'2019-09-15 13:31:48',NULL,NULL),(81,'id','Destinasi',1,'2019-09-15 13:31:48',NULL,NULL),(82,'en','Title',1,'2019-09-15 14:00:56',NULL,NULL),(82,'id','Judul',1,'2019-09-15 14:00:56',NULL,NULL),(83,'en','Link',1,'2019-09-15 14:01:19',NULL,NULL),(83,'id','Tautan',1,'2019-09-15 14:01:19',NULL,NULL),(84,'en','Order',1,'2019-09-15 14:02:01',NULL,NULL),(84,'id','Urutan',1,'2019-09-15 14:02:01',NULL,NULL),(85,'en','Image',1,'2019-09-15 14:19:10',NULL,NULL),(85,'id','Gambar',1,'2019-09-15 14:19:10',NULL,NULL),(86,'en','Content',1,'2019-09-15 14:23:41',NULL,NULL),(86,'id','Konten',1,'2019-09-15 14:23:41',NULL,NULL),(87,'en','Title Link',1,'2019-09-15 14:47:19',1,'2019-09-15 14:47:41'),(87,'id','Judul Tautan',1,'2019-09-15 14:47:19',1,'2019-09-15 14:47:41'),(88,'en','Top Position',5,'2019-09-17 06:12:23',NULL,NULL),(88,'id','Posisi Atas',5,'2019-09-17 06:12:23',NULL,NULL),(89,'en','Type',5,'2019-09-17 06:12:47',NULL,NULL),(89,'id','Jenis',5,'2019-09-17 06:12:47',NULL,NULL),(90,'en','Information',5,'2019-09-17 07:12:55',NULL,NULL),(90,'id','Informasi',5,'2019-09-17 07:12:55',NULL,NULL),(91,'en','Tour Packages',5,'2019-09-17 20:36:33',NULL,NULL),(91,'id','Paket Wisata',5,'2019-09-17 20:36:33',NULL,NULL),(92,'en','Ticket',5,'2019-09-17 20:36:52',NULL,NULL),(92,'id','Tiket',5,'2019-09-17 20:36:52',NULL,NULL),(93,'en','Venue',5,'2019-09-17 20:37:23',NULL,NULL),(93,'id','Venue',5,'2019-09-17 20:37:23',NULL,NULL),(94,'en','Alert',5,'2019-09-18 09:06:19',NULL,NULL),(94,'id','Peringatan',5,'2019-09-18 09:06:19',NULL,NULL),(95,'en','Ok',5,'2019-09-18 09:09:40',NULL,NULL),(95,'id','Ok',5,'2019-09-18 09:09:40',NULL,NULL),(96,'en','Term & Condition',5,'2019-09-19 01:11:26',5,'2019-09-19 01:12:11'),(96,'id','Syarat & Ketentuan',5,'2019-09-19 01:11:26',5,'2019-09-19 01:12:11'),(97,'en','Privacy Policy',5,'2019-09-19 18:42:16',NULL,NULL),(97,'id','Kebijakan Privasi',5,'2019-09-19 18:42:16',NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `core_user` */

insert  into `core_user`(`user_id`,`user_real_name`,`user_password`,`user_email`,`user_phone`,`user_gender`,`user_birthday`,`user_address`,`user_is_admin`,`user_lang`,`user_last_login`,`user_status`,`user_photo`,`user_desc`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (5,'Riyan Trisna Wibowo','ba4e586503b7cb15e2b54b9729c066ed','riyantrisnawibowo@gmail.com','085729331231','male','2019-09-19','',1,'id',NULL,1,'1888af1f244cb9323b73c16d26d4ff72.jpeg','',1,'2019-09-15 18:29:07',5,'2019-09-15 18:34:17');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
