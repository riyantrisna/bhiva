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

/*Table structure for table `cms_aboutus` */

DROP TABLE IF EXISTS `cms_aboutus`;

CREATE TABLE `cms_aboutus` (
  `aboutus_id` tinyint(1) NOT NULL AUTO_INCREMENT COMMENT 'id harus selalu 1',
  `aboutus_img` text,
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`aboutus_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `cms_aboutus` */

insert  into `cms_aboutus`(`aboutus_id`,`aboutus_img`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,'e84c1d66f141ff94b32d01800b669997.png',1,'2019-09-20 22:00:19',5,'2019-12-07 11:38:39');

/*Table structure for table `cms_aboutus_text` */

DROP TABLE IF EXISTS `cms_aboutus_text`;

CREATE TABLE `cms_aboutus_text` (
  `aboutustext_aboutus_id` tinyint(1) NOT NULL,
  `aboutustext_lang` varchar(5) NOT NULL,
  `aboutustext_text` text,
  PRIMARY KEY (`aboutustext_aboutus_id`,`aboutustext_lang`),
  KEY `whowearetext_whoweare_id` (`aboutustext_aboutus_id`),
  KEY `whowearetext_lang` (`aboutustext_lang`),
  CONSTRAINT `cms_aboutus_text_ibfk_1` FOREIGN KEY (`aboutustext_aboutus_id`) REFERENCES `cms_aboutus` (`aboutus_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_aboutus_text` */

insert  into `cms_aboutus_text`(`aboutustext_aboutus_id`,`aboutustext_lang`,`aboutustext_text`) values (1,'en','<p xss=\"removed\"><b>PT. BHUMI VISATANDA</b></p><p xss=\"removed\"><b><br></b></p><div style=\"text-align: justify;\"><b><span style=\"font-size: 1rem; font-weight: 400;\">PT Bhumi Visatanda atau dikenal sebagai BHIVA merupakan anak perusahaan PT Taman Wisata Candi Borobudur, Prambanan & Ratu Boko (Persero) yang berdiri sejak tahun 1996.  Berpusat di kota pariwisata Yogyakarta, nama perusahaan ini diambil dari bahasa Sansekerta yang berarti Kunjungi Bumi Kita Sendiri. </span></b></div><p></p><p xss=\"removed\" style=\"text-align: justify;\">Dengan layanan global yang berpusat dari kota budaya Yogyakarta, Indonesia, BHIVA memiliki empat aktifitas utama yaitu: MICE & Event, Tour & Travel, Transportasi, & Reservasi.</p><p xss=\"removed\" style=\"text-align: justify;\"><span style=\"font-size: 1rem;\">Berbagai perusahaan nasional dan multinasional telah mempercayakan eventnya pada BHIVA, seperti, Kementerian Keuangan, Kementerian BUMN, Kantor Kedutaan, Angkasa Pura, Gramedia, UGM, Atmajaya, UII, Yayasan Santa Maria, PT Telekomunikasi Indonesia, Bank Indonesia hingga Coca Cola, JP Morgan dan lain sebagainya.</span><br></p>'),(1,'id','<p xss=\"removed\"><span style=\"font-weight: bolder;\">PT. BHUMI VISATANDA</span></p><p xss=\"removed\"><br></p><p xss=\"removed\" style=\"text-align: justify; \">PT Bhumi Visatanda atau dikenal sebagai BHIVA merupakan anak perusahaan PT Taman Wisata Candi Borobudur, Prambanan & Ratu Boko (Persero) yang berdiri sejak tahun 1996.  Berpusat di kota pariwisata Yogyakarta, nama perusahaan ini diambil dari bahasa Sansekerta yang berarti Kunjungi Bumi Kita Sendiri. </p><p xss=\"removed\" style=\"text-align: justify;\">Dengan layanan global yang berpusat dari kota budaya Yogyakarta, Indonesia, BHIVA memiliki empat aktifitas utama yaitu: MICE & Event, Tour & Travel, Transportasi, & Reservasi.</p><p xss=\"removed\" style=\"text-align: justify; \"><span style=\"font-size: 1rem;\">Berbagai perusahaan nasional dan multinasional telah mempercayakan eventnya pada BHIVA, seperti, Kementerian Keuangan, Kementerian BUMN, Kantor Kedutaan, Angkasa Pura, Gramedia, UGM, Atmajaya, UII, Yayasan Santa Maria, PT Telekomunikasi Indonesia, Bank Indonesia hingga Coca Cola, JP Morgan dan lain sebagainya.</span><br></p>');

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

insert  into `cms_contact`(`contact_id`,`contact_address`,`contact_email`,`contact_phone`,`contact_wa`,`contact_fb`,`contact_ig`,`contact_twitter`,`contact_img_maps`,`contact_link_maps`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,'<p><span xss=\"removed\">Jl. Ringroad Utara 66, Nayan, Maguwoharjo, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281</span><br></p>','info@bhiva.id','622744333870','6282323600093','https://facebook.com/bhivatours','https://instagram.com/bhivatours','https://twitter.com/bhivatours','d97e6e68329b7d9e108d73ba5039deae.png','https://www.google.com/maps/place/Bhiva+Tour+&+Travel/@-7.7784834,110.4301161,15z/data=!4m5!3m4!1s0x2e7a5a1f1946139f:0x15c4a0a33aefd5f!8m2!3d-7.77446!4d110.430379?hl=id',1,'2019-09-20 18:11:59',5,'2019-12-06 16:44:20');

/*Table structure for table `cms_gallery` */

DROP TABLE IF EXISTS `cms_gallery`;

CREATE TABLE `cms_gallery` (
  `gallery_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gallery_parent_id` bigint(20) DEFAULT NULL COMMENT 'terisi hanya untuk tipe gambar yg link ke id gallery',
  `gallery_type` tinyint(1) DEFAULT NULL COMMENT '1=gallery, 2=image',
  `gallery_img` text,
  `gallery_link` text,
  `gallery_order` int(11) DEFAULT NULL,
  `gallery_status` tinyint(1) DEFAULT NULL COMMENT '0=not active, 1=active',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

/*Data for the table `cms_gallery` */

insert  into `cms_gallery`(`gallery_id`,`gallery_parent_id`,`gallery_type`,`gallery_img`,`gallery_link`,`gallery_order`,`gallery_status`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,NULL,1,'ca0a3a74733c501f6b9b116372bac936.jpeg',NULL,1,1,5,'2019-09-22 11:56:09',6,'2019-11-19 14:30:07'),(5,NULL,1,'6dac7f8d4ca254021b49503ccf9e9d24.jpeg',NULL,2,1,5,'2019-09-22 19:59:12',6,'2019-11-19 15:35:28'),(6,1,2,'d2c09991a396cb6a1792ff7e3bc4f061.jpeg','https://www.youtube.com/watch?v=k8lD0whQfP8',1,1,5,'2019-09-22 20:06:32',6,'2019-11-19 14:31:00'),(14,1,2,'09322999265ebf394a8fa4699613564b.jpeg',NULL,2,1,5,'2019-11-10 22:48:11',6,'2019-11-19 14:31:24'),(15,1,2,'130348f3a2a3cf2e7bafa1583797f810.jpeg',NULL,3,1,5,'2019-11-10 22:48:38',6,'2019-11-19 14:31:45'),(16,1,2,'f86b4e00d47eaf95c336013ff9e4cec5.jpeg',NULL,4,1,5,'2019-11-10 22:48:54',6,'2019-11-19 14:32:22'),(20,5,2,'600aa6f99c63ba2621da1e91fd7f0d66.jpeg',NULL,1,1,6,'2019-11-19 15:41:09',NULL,NULL),(21,5,2,'dd5ea57597e97aa8b0e5f3808ba2d14b.jpeg',NULL,2,1,6,'2019-11-19 15:41:23',NULL,NULL);

/*Table structure for table `cms_gallery_text` */

DROP TABLE IF EXISTS `cms_gallery_text`;

CREATE TABLE `cms_gallery_text` (
  `gallerytext_gallery_id` bigint(20) NOT NULL,
  `gallerytext_lang` varchar(5) NOT NULL,
  `gallerytext_title` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`gallerytext_gallery_id`,`gallerytext_lang`),
  KEY `gallerytext_lang` (`gallerytext_lang`),
  KEY `gallerytext_gallery_id` (`gallerytext_gallery_id`),
  CONSTRAINT `cms_gallery_text_ibfk_1` FOREIGN KEY (`gallerytext_gallery_id`) REFERENCES `cms_gallery` (`gallery_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_gallery_text` */

insert  into `cms_gallery_text`(`gallerytext_gallery_id`,`gallerytext_lang`,`gallerytext_title`) values (1,'en','Jeepventure'),(1,'id','Jeepventure'),(5,'en','Event'),(5,'id','Event'),(6,'en',''),(6,'id',''),(14,'en',''),(14,'id',''),(15,'en',''),(15,'id',''),(16,'en',''),(16,'id',''),(20,'en',''),(20,'id',''),(21,'en',''),(21,'id','');

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

insert  into `cms_greeting`(`greeting_id`,`greeting_img`,`greeting_link_img`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,'6b36d94f4639ff284da88db3645cdb76.jpeg',NULL,1,'2019-11-03 18:47:05',6,'2019-12-06 16:48:37');

/*Table structure for table `cms_greeting_text` */

DROP TABLE IF EXISTS `cms_greeting_text`;

CREATE TABLE `cms_greeting_text` (
  `greetingtext_greeting_id` tinyint(1) NOT NULL,
  `greetingtext_lang` varchar(5) NOT NULL,
  `greetingtext_text` text,
  PRIMARY KEY (`greetingtext_greeting_id`,`greetingtext_lang`),
  KEY `whowearetext_whoweare_id` (`greetingtext_greeting_id`),
  KEY `whowearetext_lang` (`greetingtext_lang`),
  CONSTRAINT `cms_greeting_text_ibfk_1` FOREIGN KEY (`greetingtext_greeting_id`) REFERENCES `cms_greeting` (`greeting_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_greeting_text` */

insert  into `cms_greeting_text`(`greetingtext_greeting_id`,`greetingtext_lang`,`greetingtext_text`) values (1,'en','<h5 style=\"text-align: left; font-family: \" source=\"\" sans=\"\" pro\",=\"\" -apple-system,=\"\" blinkmacsystemfont,=\"\" \"segoe=\"\" ui\",=\"\" roboto,=\"\" \"helvetica=\"\" neue\",=\"\" arial,=\"\" sans-serif,=\"\" \"apple=\"\" color=\"\" emoji\",=\"\" ui=\"\" symbol\";=\"\" color:=\"\" rgb(0,=\"\" 0,=\"\" 0);\"=\"\"><span style=\"font-weight: bolder;\">Greetings from </span></h5><h5 style=\"text-align: left; font-family: \" source=\"\" sans=\"\" pro\",=\"\" -apple-system,=\"\" blinkmacsystemfont,=\"\" \"segoe=\"\" ui\",=\"\" roboto,=\"\" \"helvetica=\"\" neue\",=\"\" arial,=\"\" sans-serif,=\"\" \"apple=\"\" color=\"\" emoji\",=\"\" ui=\"\" symbol\";=\"\" color:=\"\" rgb(0,=\"\" 0,=\"\" 0);\"=\"\"><span style=\"font-weight: bolder;\">Bhumi Visatanda !</span></h5><h5 style=\"text-align: left; font-family: \" source=\"\" sans=\"\" pro\",=\"\" -apple-system,=\"\" blinkmacsystemfont,=\"\" \"segoe=\"\" ui\",=\"\" roboto,=\"\" \"helvetica=\"\" neue\",=\"\" arial,=\"\" sans-serif,=\"\" \"apple=\"\" color=\"\" emoji\",=\"\" ui=\"\" symbol\";=\"\" color:=\"\" rgb(0,=\"\" 0,=\"\" 0);\"=\"\"><br></h5><p>Welcome to the website of PT Bhumi Visatanda or better known as BHIVA. This website is a small window that we hope can give an overview of our company profile and activities.&nbsp;</p><p><br></p><p>From this window, we can get a whole glimpse of BHIVA, a more thorough&nbsp; experience you can actually feel after trying one of our travel packages and at the time we help you to make your event become true.</p><p>We will truly enhance your experience!</p>'),(1,'id','<h5 style=\"text-align: left; font-family: \" source=\"\" sans=\"\" pro\",=\"\" -apple-system,=\"\" blinkmacsystemfont,=\"\" \"segoe=\"\" ui\",=\"\" roboto,=\"\" \"helvetica=\"\" neue\",=\"\" arial,=\"\" sans-serif,=\"\" \"apple=\"\" color=\"\" emoji\",=\"\" ui=\"\" symbol\";=\"\" color:=\"\" rgb(0,=\"\" 0,=\"\" 0);\"=\"\"><span style=\"font-weight: bolder;\">Greetings from </span></h5><h5 style=\"text-align: left; font-family: \" source=\"\" sans=\"\" pro\",=\"\" -apple-system,=\"\" blinkmacsystemfont,=\"\" \"segoe=\"\" ui\",=\"\" roboto,=\"\" \"helvetica=\"\" neue\",=\"\" arial,=\"\" sans-serif,=\"\" \"apple=\"\" color=\"\" emoji\",=\"\" ui=\"\" symbol\";=\"\" color:=\"\" rgb(0,=\"\" 0,=\"\" 0);\"=\"\"><span style=\"font-weight: bolder;\">Bhumi Visatanda !</span></h5><p><br></p><p>Selamat datang di situs web PT Bhumi Visatanda atau yang lebih dikenal dengan nama BHIVA. Situs web ini merupakan jendela kecil yang kami harapkan dapat memberikan gambaran tentang profil dan kegiatan perusahaan kami. </p><p>Dari jendela ini, kita baru bisa mendapat sekelumit gambaran tentang BHIVA, gambaran lebih menyeluruh dan pengalaman yang sesungguhnya bisa Anda rasakan setelah mencoba salah satu paket perjalanan kami dan pada waktu kami membantu Anda mewujudkan event-event penting impian Anda.</p><p>We will truly enhance your experience!</p>');

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

insert  into `cms_privacypolicy`(`privacypolicy_id`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,1,'2019-09-21 22:55:34',6,'2019-12-06 16:34:03');

/*Table structure for table `cms_privacypolicy_text` */

DROP TABLE IF EXISTS `cms_privacypolicy_text`;

CREATE TABLE `cms_privacypolicy_text` (
  `privacypolicytext_privacypolicy_id` tinyint(1) NOT NULL,
  `privacypolicytext_lang` varchar(5) NOT NULL,
  `privacypolicytext_text` text,
  PRIMARY KEY (`privacypolicytext_privacypolicy_id`,`privacypolicytext_lang`),
  KEY `privacypolicytext_privacypolicy_id` (`privacypolicytext_privacypolicy_id`),
  KEY `privacypolicytext_lang` (`privacypolicytext_lang`),
  CONSTRAINT `cms_privacypolicy_text_ibfk_1` FOREIGN KEY (`privacypolicytext_privacypolicy_id`) REFERENCES `cms_privacypolicy` (`privacypolicy_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_privacypolicy_text` */

insert  into `cms_privacypolicy_text`(`privacypolicytext_privacypolicy_id`,`privacypolicytext_lang`,`privacypolicytext_text`) values (1,'en','<p>BHIVA</p>'),(1,'id','<p>BHIVA</p>');

/*Table structure for table `cms_service` */

DROP TABLE IF EXISTS `cms_service`;

CREATE TABLE `cms_service` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_order` int(11) DEFAULT NULL,
  `service_status` tinyint(1) DEFAULT NULL COMMENT '0=not active, 1=active',
  `service_type` tinyint(1) DEFAULT '0' COMMENT '0=info, 1=paket wisata, 2=tiket, 3=venue',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `cms_service` */

insert  into `cms_service`(`service_id`,`service_order`,`service_status`,`service_type`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (3,5,1,1,5,'2019-09-19 01:05:57',5,'2019-11-24 07:14:25'),(4,2,1,3,5,'2019-10-22 17:25:31',5,'2019-11-24 07:15:55'),(5,3,1,0,5,'2019-11-14 06:47:52',5,'2019-11-19 09:32:00'),(6,4,1,0,5,'2019-11-19 09:31:23',6,'2019-12-06 17:23:20'),(7,1,1,0,5,'2019-11-19 09:34:01',6,'2019-12-06 16:37:26'),(8,6,1,2,5,'2019-11-24 07:22:54',6,'2019-12-06 16:39:12');

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

insert  into `cms_service_img`(`serviceimg_service_id`,`serviceimg_order`,`serviceimg_img`) values (6,1,'1234973d52a206a0cc0a4459648a19f4.jpeg'),(6,2,NULL),(6,3,NULL),(6,4,NULL),(5,1,'3880d287b0e3d19cb24e38cd546104eb.jpeg'),(5,2,NULL),(5,3,NULL),(5,4,NULL),(7,1,'a982536a6d9ee46c2c68cc7e9745c6c6.jpeg'),(7,2,NULL),(7,3,NULL),(7,4,NULL),(3,1,'a5177f97bb998d1449b0a24b840ffe1f.jpeg'),(3,2,NULL),(3,3,'9e7a50c214c1dcc618f71b0fca4b35a8.jpeg'),(3,4,NULL),(4,1,'086a41dc7e005698cd80e648cf257dbb.jpeg'),(4,2,NULL),(4,3,NULL),(4,4,NULL),(8,1,'fd50da053a69756ff0326ef7174da7b3.jpeg'),(8,2,NULL),(8,3,NULL),(8,4,NULL);

/*Table structure for table `cms_service_text` */

DROP TABLE IF EXISTS `cms_service_text`;

CREATE TABLE `cms_service_text` (
  `servicetext_service_id` int(11) NOT NULL,
  `servicetext_lang` varchar(5) NOT NULL,
  `servicetext_name` varchar(250) DEFAULT NULL,
  `servicetext_text` text,
  PRIMARY KEY (`servicetext_service_id`,`servicetext_lang`),
  KEY `servicetext_service_id` (`servicetext_service_id`),
  KEY `servicetext_lang` (`servicetext_lang`),
  CONSTRAINT `cms_service_text_ibfk_2` FOREIGN KEY (`servicetext_service_id`) REFERENCES `cms_service` (`service_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_service_text` */

insert  into `cms_service_text`(`servicetext_service_id`,`servicetext_lang`,`servicetext_name`,`servicetext_text`) values (3,'en','Tour Packages',NULL),(3,'id','Paket Wisata',NULL),(4,'en','Venues','<p xss=\"removed\">Lorem ipsum dolor sit amet, sit id duis quisque nunc pulvinar nulla, donec sem morbi, elit quis ipsum nunc, metus veritatis quisque pede nunc morbi. Lorem primis lobortis semper fames cras vel, viverra posuere congue erat. Ac nibh eros elit dolor, molestie ac eget a ante ex, massa tortor sapien, per vivamus luctus scelerisque, urna lorem urna a consequat ut sit. Sed proin laoreet lacus, vel penatibus, sit libero urna ligula vestibulum, et molestiae donec. Nunc vitae arcu, ipsum et phasellus. Rhoncus curabitur in donec metus, eget blandit magna ante phasellus mauris, porttitor quam nec tempus mattis, eu dictumst velit varius a. Odio lacus in. Per ligula suscipit. Purus eget lobortis pellentesque, elit pulvinar euismod in nulla nulla sed, velit mi ac, eu autem sit, quae erat phasellus nam dictum.</p><p xss=\"removed\"><br></p><p xss=\"removed\">Amet et in ac, non turpis auctor vulputate etiam, diam duis sed, eros in vitae sem elementum fermentum. Incidunt egestas fringilla amet, in at sollicitudin egestas posuere sapien volutpat, taciti blandit. Et enim, ante et vitae risus omnis interdum sed, tenetur congue tortor justo ipsum. Morbi viverra nisl, ultricies tristique curabitur per cursus, tellus nam id nibh fermentum ipsum vitae. At ullamcorper tellus nec vel pariatur congue, pretium quisque, massa a amet ut wisi, cubilia porttitor, sagittis dui tincidunt faucibus. Mattis sollicitudin phasellus fermentum est elit aliquam, et torquent aliquam volutpat per vehicula dignissim, mattis risus, mi in maecenas nunc, porta pellentesque massa. In eros in, lorem non erat sapien eros, penatibus sit elementum, malesuada vehicula.</p><p xss=\"removed\"><br></p><p xss=\"removed\">Tempor praesent tellus mattis ac nibh turpis. At rutrum rutrum. Nec habitasse pretium dignissim morbi amet eget, vitae metus nulla ipsum, faucibus mauris nibh mattis lectus tristique donec, lacus fames nam orci maecenas at egestas, vestibulum lacus vestibulum. Tortor euismod ut praesent dignissim. Vel lectus ac. Nibh proin rutrum imperdiet tempor mauris dolor, vestibulum rhoncus elit vel diam. Taciti dui sociis vestibulum. Suscipit nullam nec risus, sem arcu consequat etiam proin consectetuer feugiat, magna amet dignissim, dapibus dolor semper turpis morbi donec, repellat mauris tristique proin. Pede in neque semper sed cursus id. Augue dolor convallis, arcu arcu, consectetuer aenean et id. Sed interdum elit, non tortor sollicitudin vel sapien. Turpis et ornare, a lectus, consequatur tellus augue pretium interdum suspendisse cumque.</p><p xss=\"removed\"><br></p><p xss=\"removed\">Convallis hendrerit. Morbi mollis in etiam, eiusmod sed phasellus tempus non sed orci, luctus morbi tortor maecenas integer nunc vel, suscipit amet nascetur. Lacinia nam vel volutpat lectus laboriosam in. Pellentesque nulla malesuada urna proin ac. Pretium wisi pellentesque, amet in, vitae ac. Wisi sed sed maecenas.</p><p xss=\"removed\"><br></p>'),(4,'id','Venues','<p xss=\"removed\">Lorem ipsum dolor sit amet, sit id duis quisque nunc pulvinar nulla, donec sem morbi, elit quis ipsum nunc, metus veritatis quisque pede nunc morbi. Lorem primis lobortis semper fames cras vel, viverra posuere congue erat. Ac nibh eros elit dolor, molestie ac eget a ante ex, massa tortor sapien, per vivamus luctus scelerisque, urna lorem urna a consequat ut sit. Sed proin laoreet lacus, vel penatibus, sit libero urna ligula vestibulum, et molestiae donec. Nunc vitae arcu, ipsum et phasellus. Rhoncus curabitur in donec metus, eget blandit magna ante phasellus mauris, porttitor quam nec tempus mattis, eu dictumst velit varius a. Odio lacus in. Per ligula suscipit. Purus eget lobortis pellentesque, elit pulvinar euismod in nulla nulla sed, velit mi ac, eu autem sit, quae erat phasellus nam dictum.</p><p xss=\"removed\"><br></p><p xss=\"removed\">Amet et in ac, non turpis auctor vulputate etiam, diam duis sed, eros in vitae sem elementum fermentum. Incidunt egestas fringilla amet, in at sollicitudin egestas posuere sapien volutpat, taciti blandit. Et enim, ante et vitae risus omnis interdum sed, tenetur congue tortor justo ipsum. Morbi viverra nisl, ultricies tristique curabitur per cursus, tellus nam id nibh fermentum ipsum vitae. At ullamcorper tellus nec vel pariatur congue, pretium quisque, massa a amet ut wisi, cubilia porttitor, sagittis dui tincidunt faucibus. Mattis sollicitudin phasellus fermentum est elit aliquam, et torquent aliquam volutpat per vehicula dignissim, mattis risus, mi in maecenas nunc, porta pellentesque massa. In eros in, lorem non erat sapien eros, penatibus sit elementum, malesuada vehicula.</p><p xss=\"removed\"><br></p><p xss=\"removed\">Tempor praesent tellus mattis ac nibh turpis. At rutrum rutrum. Nec habitasse pretium dignissim morbi amet eget, vitae metus nulla ipsum, faucibus mauris nibh mattis lectus tristique donec, lacus fames nam orci maecenas at egestas, vestibulum lacus vestibulum. Tortor euismod ut praesent dignissim. Vel lectus ac. Nibh proin rutrum imperdiet tempor mauris dolor, vestibulum rhoncus elit vel diam. Taciti dui sociis vestibulum. Suscipit nullam nec risus, sem arcu consequat etiam proin consectetuer feugiat, magna amet dignissim, dapibus dolor semper turpis morbi donec, repellat mauris tristique proin. Pede in neque semper sed cursus id. Augue dolor convallis, arcu arcu, consectetuer aenean et id. Sed interdum elit, non tortor sollicitudin vel sapien. Turpis et ornare, a lectus, consequatur tellus augue pretium interdum suspendisse cumque.</p><p xss=\"removed\"><br></p><p xss=\"removed\">Convallis hendrerit. Morbi mollis in etiam, eiusmod sed phasellus tempus non sed orci, luctus morbi tortor maecenas integer nunc vel, suscipit amet nascetur. Lacinia nam vel volutpat lectus laboriosam in. Pellentesque nulla malesuada urna proin ac. Pretium wisi pellentesque, amet in, vitae ac. Wisi sed sed maecenas.</p><p xss=\"removed\"><br></p>'),(5,'en','Transport','<p xss=removed>Lorem ipsum dolor sit amet, sit id duis quisque nunc pulvinar nulla, donec sem morbi, elit quis ipsum nunc, metus veritatis quisque pede nunc morbi. Lorem primis lobortis semper fames cras vel, viverra posuere congue erat. Ac nibh eros elit dolor, molestie ac eget a ante ex, massa tortor sapien, per vivamus luctus scelerisque, urna lorem urna a consequat ut sit. Sed proin laoreet lacus, vel penatibus, sit libero urna ligula vestibulum, et molestiae donec. Nunc vitae arcu, ipsum et phasellus. Rhoncus curabitur in donec metus, eget blandit magna ante phasellus mauris, porttitor quam nec tempus mattis, eu dictumst velit varius a. Odio lacus in. Per ligula suscipit. Purus eget lobortis pellentesque, elit pulvinar euismod in nulla nulla sed, velit mi ac, eu autem sit, quae erat phasellus nam dictum.</p><p xss=removed><br></p><p xss=removed>Amet et in ac, non turpis auctor vulputate etiam, diam duis sed, eros in vitae sem elementum fermentum. Incidunt egestas fringilla amet, in at sollicitudin egestas posuere sapien volutpat, taciti blandit. Et enim, ante et vitae risus omnis interdum sed, tenetur congue tortor justo ipsum. Morbi viverra nisl, ultricies tristique curabitur per cursus, tellus nam id nibh fermentum ipsum vitae. At ullamcorper tellus nec vel pariatur congue, pretium quisque, massa a amet ut wisi, cubilia porttitor, sagittis dui tincidunt faucibus. Mattis sollicitudin phasellus fermentum est elit aliquam, et torquent aliquam volutpat per vehicula dignissim, mattis risus, mi in maecenas nunc, porta pellentesque massa. In eros in, lorem non erat sapien eros, penatibus sit elementum, malesuada vehicula.</p><p xss=removed><br></p><p xss=removed>Tempor praesent tellus mattis ac nibh turpis. At rutrum rutrum. Nec habitasse pretium dignissim morbi amet eget, vitae metus nulla ipsum, faucibus mauris nibh mattis lectus tristique donec, lacus fames nam orci maecenas at egestas, vestibulum lacus vestibulum. Tortor euismod ut praesent dignissim. Vel lectus ac. Nibh proin rutrum imperdiet tempor mauris dolor, vestibulum rhoncus elit vel diam. Taciti dui sociis vestibulum. Suscipit nullam nec risus, sem arcu consequat etiam proin consectetuer feugiat, magna amet dignissim, dapibus dolor semper turpis morbi donec, repellat mauris tristique proin. Pede in neque semper sed cursus id. Augue dolor convallis, arcu arcu, consectetuer aenean et id. Sed interdum elit, non tortor sollicitudin vel sapien. Turpis et ornare, a lectus, consequatur tellus augue pretium interdum suspendisse cumque.</p><p xss=removed><br></p><p xss=removed>Convallis hendrerit. Morbi mollis in etiam, eiusmod sed phasellus tempus non sed orci, luctus morbi tortor maecenas integer nunc vel, suscipit amet nascetur. Lacinia nam vel volutpat lectus laboriosam in. Pellentesque nulla malesuada urna proin ac. Pretium wisi pellentesque, amet in, vitae ac. Wisi sed sed maecenas.</p><p xss=removed><br></p>'),(5,'id','Transport','<p xss=removed>Lorem ipsum dolor sit amet, sit id duis quisque nunc pulvinar nulla, donec sem morbi, elit quis ipsum nunc, metus veritatis quisque pede nunc morbi. Lorem primis lobortis semper fames cras vel, viverra posuere congue erat. Ac nibh eros elit dolor, molestie ac eget a ante ex, massa tortor sapien, per vivamus luctus scelerisque, urna lorem urna a consequat ut sit. Sed proin laoreet lacus, vel penatibus, sit libero urna ligula vestibulum, et molestiae donec. Nunc vitae arcu, ipsum et phasellus. Rhoncus curabitur in donec metus, eget blandit magna ante phasellus mauris, porttitor quam nec tempus mattis, eu dictumst velit varius a. Odio lacus in. Per ligula suscipit. Purus eget lobortis pellentesque, elit pulvinar euismod in nulla nulla sed, velit mi ac, eu autem sit, quae erat phasellus nam dictum.</p><p xss=removed><br></p><p xss=removed>Amet et in ac, non turpis auctor vulputate etiam, diam duis sed, eros in vitae sem elementum fermentum. Incidunt egestas fringilla amet, in at sollicitudin egestas posuere sapien volutpat, taciti blandit. Et enim, ante et vitae risus omnis interdum sed, tenetur congue tortor justo ipsum. Morbi viverra nisl, ultricies tristique curabitur per cursus, tellus nam id nibh fermentum ipsum vitae. At ullamcorper tellus nec vel pariatur congue, pretium quisque, massa a amet ut wisi, cubilia porttitor, sagittis dui tincidunt faucibus. Mattis sollicitudin phasellus fermentum est elit aliquam, et torquent aliquam volutpat per vehicula dignissim, mattis risus, mi in maecenas nunc, porta pellentesque massa. In eros in, lorem non erat sapien eros, penatibus sit elementum, malesuada vehicula.</p><p xss=removed><br></p><p xss=removed>Tempor praesent tellus mattis ac nibh turpis. At rutrum rutrum. Nec habitasse pretium dignissim morbi amet eget, vitae metus nulla ipsum, faucibus mauris nibh mattis lectus tristique donec, lacus fames nam orci maecenas at egestas, vestibulum lacus vestibulum. Tortor euismod ut praesent dignissim. Vel lectus ac. Nibh proin rutrum imperdiet tempor mauris dolor, vestibulum rhoncus elit vel diam. Taciti dui sociis vestibulum. Suscipit nullam nec risus, sem arcu consequat etiam proin consectetuer feugiat, magna amet dignissim, dapibus dolor semper turpis morbi donec, repellat mauris tristique proin. Pede in neque semper sed cursus id. Augue dolor convallis, arcu arcu, consectetuer aenean et id. Sed interdum elit, non tortor sollicitudin vel sapien. Turpis et ornare, a lectus, consequatur tellus augue pretium interdum suspendisse cumque.</p><p xss=removed><br></p><p xss=removed>Convallis hendrerit. Morbi mollis in etiam, eiusmod sed phasellus tempus non sed orci, luctus morbi tortor maecenas integer nunc vel, suscipit amet nascetur. Lacinia nam vel volutpat lectus laboriosam in. Pellentesque nulla malesuada urna proin ac. Pretium wisi pellentesque, amet in, vitae ac. Wisi sed sed maecenas.</p><p xss=removed><br></p>'),(6,'en','MICE & Events','<ol><li>Events</li><li>Meeting</li><li>Incentive</li><li>Conference</li><li>Exhibition</li></ol>'),(6,'id','MICE & Events','<ol><li>Events</li><li>Meeting</li><li>Incentive</li><li>Conference</li><li>Exhibition</li></ol>'),(7,'en','Reservation','<ol><li>Flight Ticket</li><li>Train Ticket</li><li>Hotel Voucher</li></ol>'),(7,'id','Reservasi','<ol><li>Tiket Pesawat</li><li>Tiket Kereta Api</li><li>Voucher Hotel</li></ol>'),(8,'en','Entrance Ticket',NULL),(8,'id','Tiket Masuk Destinasi',NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

/*Data for the table `cms_slider` */

insert  into `cms_slider`(`slider_id`,`slider_link`,`slider_order`,`slider_img`,`slider_status`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (7,'',2,'8432a4d5767e2ab9042b4434b774b5e3.jpeg',1,5,'2019-09-19 21:55:39',6,'2019-11-19 15:58:11'),(8,'',3,'07d64be5d524d735559415294263ed7d.jpeg',1,5,'2019-10-22 22:36:34',6,'2019-11-19 16:00:02'),(9,'',1,'145e46ebc43ade119dabd286cb59a1f3.jpeg',1,6,'2019-11-19 15:54:47',6,'2019-11-19 15:56:27'),(10,'',1,'de364a6d2356850de9a7b39566f4d379.png',1,6,'2019-12-06 20:25:23',6,'2019-12-06 20:41:30'),(11,'',1,'ec27f814d6ed640992b6616902f8c124.png',1,6,'2019-12-06 20:44:50',6,'2019-12-06 21:08:28'),(13,'',1,'ddb389da67be6ce97862f31f5dc0ad0c.png',1,6,'2019-12-06 21:15:58',NULL,NULL),(14,'',1,'b707bed3a287a18e501f9373a690c8f3.png',1,6,'2019-12-06 21:21:34',6,'2019-12-06 21:23:08');

/*Table structure for table `cms_slider_text` */

DROP TABLE IF EXISTS `cms_slider_text`;

CREATE TABLE `cms_slider_text` (
  `slidertext_slider_id` int(11) NOT NULL,
  `slidertext_lang` varchar(5) NOT NULL,
  `slidertext_title_link` varchar(250) DEFAULT NULL,
  `slidertext_title` varchar(250) DEFAULT NULL,
  `slidertext_text` text,
  PRIMARY KEY (`slidertext_slider_id`,`slidertext_lang`),
  KEY `slidertext_slider_id` (`slidertext_slider_id`),
  KEY `slidertext_lang` (`slidertext_lang`),
  CONSTRAINT `cms_slider_text_ibfk_2` FOREIGN KEY (`slidertext_slider_id`) REFERENCES `cms_slider` (`slider_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_slider_text` */

insert  into `cms_slider_text`(`slidertext_slider_id`,`slidertext_lang`,`slidertext_title_link`,`slidertext_title`,`slidertext_text`) values (7,'en','More Info','BHIVA',''),(7,'id','Info Lebih lanjut','BHIVA',''),(8,'en','','INDONESIA',''),(8,'id','','INDONESIA',''),(9,'en','','Bhumi Visatanda',''),(9,'id','','Bhumi Visatanda',''),(10,'en','','',''),(10,'id','','',''),(11,'en','','',''),(11,'id','','',''),(13,'en','','',''),(13,'id','','',''),(14,'en','','',''),(14,'id','','','');

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

insert  into `cms_termcondition`(`termcondition_id`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,1,'2019-09-21 23:11:54',6,'2019-12-06 16:34:29');

/*Table structure for table `cms_termcondition_text` */

DROP TABLE IF EXISTS `cms_termcondition_text`;

CREATE TABLE `cms_termcondition_text` (
  `termconditiontext_termcondition_id` tinyint(1) NOT NULL,
  `termconditiontext_lang` varchar(5) NOT NULL,
  `termconditiontext_text` text,
  PRIMARY KEY (`termconditiontext_termcondition_id`,`termconditiontext_lang`),
  KEY `termconditiontext_termcondition_id` (`termconditiontext_termcondition_id`),
  KEY `termconditiontext_lang` (`termconditiontext_lang`),
  CONSTRAINT `cms_termcondition_text_ibfk_1` FOREIGN KEY (`termconditiontext_termcondition_id`) REFERENCES `cms_termcondition` (`termcondition_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_termcondition_text` */

insert  into `cms_termcondition_text`(`termconditiontext_termcondition_id`,`termconditiontext_lang`,`termconditiontext_text`) values (1,'en','<p>BHIVA<br></p>'),(1,'id','<p>BHIVA</p>');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `cms_travelpost` */

insert  into `cms_travelpost`(`travelpost_id`,`travelpost_status`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,1,5,'2019-11-16 11:20:59',6,'2019-12-06 17:52:16'),(15,1,6,'2019-12-06 17:51:38',6,'2019-12-06 18:16:36');

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

insert  into `cms_travelpost_img`(`travelpostimg_travelpost_id`,`travelpostimg_order`,`travelpostimg_img`) values (1,1,'a3ba24dffa239573a305f85d94260afa.jpeg'),(1,2,NULL),(1,3,NULL),(1,4,NULL);

/*Table structure for table `cms_travelpost_text` */

DROP TABLE IF EXISTS `cms_travelpost_text`;

CREATE TABLE `cms_travelpost_text` (
  `travelposttext_travelpost_id` int(11) NOT NULL,
  `travelposttext_lang` varchar(5) NOT NULL,
  `travelposttext_name` varchar(250) DEFAULT NULL,
  `travelposttext_text` text,
  PRIMARY KEY (`travelposttext_travelpost_id`,`travelposttext_lang`),
  KEY `desttext_destination_id` (`travelposttext_travelpost_id`),
  KEY `desttext_lang` (`travelposttext_lang`),
  CONSTRAINT `cms_travelpost_text_ibfk_1` FOREIGN KEY (`travelposttext_travelpost_id`) REFERENCES `cms_travelpost` (`travelpost_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cms_travelpost_text` */

insert  into `cms_travelpost_text`(`travelposttext_travelpost_id`,`travelposttext_lang`,`travelposttext_name`,`travelposttext_text`) values (1,'en','Wisata Halal','<p style=\"text-align: justify; \">Halal tourism, one of the tourist products that are currently not familiar to the community. The trend of halal tourism is due to increasing Muslim tourists who travel to various parts of the world. But not many understand the true meaning of halal tourism. Halal refers to food, but halal tourism does not mean the tour to enjoy halal food even though it is one component of this tourism product. As with any other tourism product, halal tourism products also include a range of services such as transportation, accommodation (if more than 1 day), services to visit tourist attractions, and others.</p><p style=\"text-align: justify; \">President Islamic Nutrition Council of America, Muhammad Munir Caudry, on the activities of Indonesia Halal Expo (Indhex) 2013 and Global Halal Forum in 2013 in central Jakarta, said that Halal tourism is a new concept of tourism. This tour is different from religious tourism such as Umrah and Hajj. Halal tourism is a tourism that serves the holiday, by adjusting the holiday style according to the needs and requests of Muslim travelers. </p><p style=\"text-align: justify; \">Components that belong to a series of halal tourism products is a tourist site that can increase the spiritual values of tourists, consumption which certainly has a value of halal seen from the source and processing. Then the transportation that divides the seating of male and female tourists so that there is no mixing of tourists. Furthermore, the hotel provides facilities with sharia principles by not providing alcoholic beverages and has a variety of facilities or common spaces that are separated between men and women such as swimming pool, gym, spa, etc. </p><p style=\"text-align: justify; \">Halal tourism can not only be enjoyed by Muslim tourists only, this tour is a kind of alternative for Muslim tourists who want to get not only tourist needs, but also needs spiritual. Non-Muslim tourists can certainly enjoy this tour because halal tourism is a combination of the public travel package by visiting various places of recreation and spiritual improvement or knowledge of Islamic history. The purpose of this halal tourism is to entertain, give pleasure and cultivate religious consciousness.  </p><p style=\"text-align: justify; \">Lombok was awarded The World Halal Travel Summit & Exhibition 2015 in Abu Dhabi, United Arab Emirates beating Malaysia, Abu Dhabi, Turkey, Qatar, and several other nominated countries. Other destinations as well as a favorite halal destination in Indonesia that belongs to Indonesia Muslim Travel Index (IMTI) 2019 : Aceh, Jakarta, West Sumatera, Yogyakarta, West Java, Riau Islands, Malang Raya in East Java, Java Central, and Makassar in South Sulawesi. This is a proof that Indonesia is ready to develop another halal tourism so that it is better known and become a major destination for Muslim travelers around the world. Indonesia has the largest Muslim population of the world, so for the application of halal tourism concept that tends to Muslim & Family Friendly has a great potential to be developed.</p><div style=\"text-align: justify;\"><br></div>'),(1,'id','Halal Tourism','<p style=\"text-align: justify; \">Wisata halal, salah satu wisata yang saat ini tidak asing ditelinga masyarakat. Tren wisata halal disebabkan meningkatnya jumah wisatawan muslim yang melakukan perjalanan wisata ke berbagai belahan dunia. Namun tidak banyak yang benar – benar mengerti arti sesungguhnya wisata halal. Halal merujuk kepada makanan, namun wisata halal bukan berarti wisata untuk menikmati makanan – makanan halal walaupun itu termasuk salah satu komponen produk wisata ini. Seperti halnya produk wisata yang lain, produk wisata halal juga mencakup rangkaian pelayanan seperti transportasi, akomodasi (jika lebih dari 1 hari), pelayanan mengunjungi objek wisata, dan lain sebagainya. </p><p style=\"text-align: justify; \">President Islamic Nutrition Council of America, Muhammad Munir Caudry, pada kegiatan Indonesia Halal Expo (Indhex) 2013 dan Global Halal Forum pada tahun 2013 di Jakarta Pusat, mengatakan bahwa wisata halal merupakan konsep baru pariwisata. Wisata ini berbeda dengan wisata religi seperti umroh dan ibadah haji. Wisata halal adalah pariwisata yang melayani liburan, dengan menyesuaikan gaya liburan sesuai dengan kebutuhan dan permintaan traveler muslim. </p><p style=\"text-align: justify; \">Komponen-komponen yang termasuk ke dalam satu rangkaian produk pariwisata halal adalah lokasi wisata yang dapat meningkatkan nilai-nilai spiritual wisatawan, konsumsi yang tentunya memiliki nilai halal dilihat dari sumber dan pengolahannya. Kemudian transportasi yang membagi tempat duduk wisatawan pria dan wanita sehingga tidak adanya pencampurbauran wisatawan. Selanjutnya hotel yang tentunya menyediakan fasilitas dengan prinsip syariah dengan tidak menyediakan minuman beralkohol serta memiliki berbagai fasilitas atau ruang umum yang terpisah antara pria dan wanita seperti kolam renang, gym, spa, dll. </p><p style=\"text-align: justify; \">Wisata halal tidak hanya dapat dinikmati oleh wisatawan muslim saja, wisata ini  semacam alternatif bagi wisatawan muslim yang ingin mendapatkan tidak hanya kebutuhan wisata, tetapi juga kebutuhan spritual. Wisatawan non-muslim tentunya dapat menikmati wisata ini dikarenakan wisata halal merupakan kombinasi dari paket perjalanan umum dengan mengunjungi berbagai tempat rekreasi dan tempat peningkatan spiritual ataupun pengetahuan sejarah Islam. Tujuan dari wisata halal ini adalah menghibur, memberikan kesenangan serta menumbuhkan kesadaran beragama.  </p><p style=\"text-align: justify; \">Lombok meraih penghargaan The World Halal Travel Summit & Exhibition 2015 di Abu Dhabi, Uni Emirat Arab mengalahkan Malaysia, Abu Dhabi, Turki, Qatar, dan beberapa negara nominasi lainnya. Beberapa destinasi lain juga menjadi destinasi wisata halal favorit di Indonesia yang termasuk ke dalam Indonesia Muslim Travel Index (IMTI) 2019 yaitu Aceh, Jakarta, Sumatera Barat, Yogyakarta, Jawa Barat, Kepulauan Riau, Malang Raya di Jawa Timur, Jawa Tengah, dan Makassar di Sulawesi Selatan</p><p style=\"text-align: justify; \"><span style=\"font-size: 1rem;\">Ini merupakan bukti bahwa Indonesia siap untuk mengembangkan lagi wisata halal sehingga lebih dikenal dan menjadi destinasi utama bagi wisatawan muslim di seluruh dunia. Indonesia memiliki penduduk Muslim terbesar dunia, sehingga untuk penerapan konsep wisata halal yang cenderung ke Muslim & Family Friendly memiliki potensi yang besar untuk dikembangkan.</span></p>'),(15,'en','Dark Tourism','<p>The trend of \"night tours\" with its relation to past or dark history of a place has its attraction. Dark Tourism with the activity of visiting historical buildings or tombs with a dark nuance with mystical things certainly characterizes this tour with fans both domestic and international. The term dark tourism refers to unusual spots visited in general such as the former location of disasters, tombs of prominent figures, places of \"bloody\" where there has been a massacre, or a spot that is \"supposedly\" said to save a lot of stories Mythical or mystical. Dark tourism is usually done at night, but some of these activities are also done during the day. </p><p>One of the famous dark tourism destinations in Yogyakarta is the Sisa Hartaku Museum in Cangkringan, Sleman, Yogyakarta. Emotions of sadness can be felt by the visitors when viewing various properties of the former Merapi eruption in 2010 in a house belonging to the people named Riyanto. The items are in the form of kitchen utensils, television, bicycles, motorcycles, and even cars, etc. Empathy for visitors to victims of the eruption can be felt coupled with the story at the time of the incident told by the local guide. Another tourist destination is the mud area Sidoarjo in East Java. To commemorate the victims were made several statues by Dadang Chistanto with hands looking up. In addition to these destinations, Indonesia also has other dark tourism destinations such as Gondang Klaten Central Java sugar Factory, Bukit Batu Cemetery in Toraja, Tomb of the Kings in Imogiri, Trunyan Village in Bali, etc. </p><p>Although it felt creepy this tour concept has a great opportunity to be developed. The relation between objects visited with the emotions of visitors in the form of sadness even anger to the tragic events caused by nature or human cruelty becomes a distinct advantage of this tour</p>'),(15,'id','Dark Tourism','<p>Tren “wisata malam” dengan keterkaitannya terhadap masa lalu atau sejarah kelam dari suatu tempat memiliki daya tarik tersendiri. Dark Tourism dengan kegiatan mengunjungi bangunan bersejarah ataupun makam dengan nuansa kelam dengan hal mistis tentunya menjadi ciri khas wisata ini dengan peminat baik domestik maupun internasional. Istilah dark tourism merujuk kepada spot-spot tidak lazim yang dikunjungi pada umumnya seperti bekas lokasi bencana, makam-makam tokoh ternama, tempat “berdarah” dimana pernah terjadi pembantaian, ataupun spot yang “konon” katanya menyimpan banyak cerita mitos atau mistis. Dark tourism umumnya dilakukan pada malam hari, namun beberapa kegiatan wisata ini juga dilakukan pada siang hari. </p><p>Salah satu destinasi dark tourism yang terkenal di Yogyakarta adalah Museum Sisa Hartaku di Cangkringan, Sleman, Yogyakarta. Emosi berupa kesedihan dapat dirasakan oleh para pengunjung ketika melihat berbagai properti bekas letusan Gunung Merapi tahun 2010 di sebuah rumah milik warga bernama Riyanto. Benda-benda tersebut berupa peralatan dapur, televisi, sepeda, sepeda motor, bahkan mobil, dan sebagainya. Empati pengunjung terhadap korban dari letusan tersebut dapat dirasakan ditambah dengan kisah pada saat kejadian yang diceritakan oleh guide setempat. Destinasi wisata lainnya yaitu kawasan Lumpur Sidoarjo di Jawa Timur. Untuk mengenang para korban dibuatlah beberapa patung oleh Dadang Chistanto dengan tangan menengadah ke atas. Selain destinasi tersebut Indonesia juga memiliki destinasi dark tourism lain seperti Pabrik Gula Gondang Klaten Jawa Tengah, Pemakaman Bukit Batu di Toraja, Makam Para Raja di Imogiri, Desa Trunyan di Bali, dll. </p><p>Walaupun dirasa menyeramkan konsep wisata ini memiliki peluang besar untuk dikembangkan. Adanya keterkaitan antara objek yang dikunjungi dengan emosi pengunjung berupa kesedihan bahkan kemarahan terhadap peristiwa tragis baik yang disebabkan oleh alam ataupun kekejaman manusia menjadi keunggulan tersendiri dari wisata ini.</p>');

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
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=latin1;

/*Data for the table `core_key` */

insert  into `core_key`(`key_id`,`key_code`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,'login',1,'2019-09-07 19:25:07',NULL,NULL),(2,'username_must_fielld',1,'2019-09-07 21:04:03',NULL,NULL),(3,'password_must_fielld',1,'2019-09-07 21:04:03',NULL,NULL),(4,'username_password_must_fielld',1,'2019-09-07 21:04:03',NULL,NULL),(5,'username_or_password_wrong',1,'2019-09-07 21:44:12',NULL,NULL),(6,'setting',1,'2019-09-08 08:58:29',NULL,NULL),(7,'logout',1,'2019-09-08 09:01:33',NULL,NULL),(8,'dashboard',1,'2019-09-08 09:02:49',NULL,NULL),(9,'master_data',1,'2019-09-08 09:19:06',NULL,NULL),(10,'user',1,'2019-09-08 09:21:27',NULL,NULL),(11,'change_password',1,'2019-09-08 09:26:41',NULL,NULL),(12,'close',1,'2019-09-08 09:36:39',NULL,NULL),(13,'save',1,'2019-09-08 09:36:40',NULL,NULL),(14,'old_password',1,'2019-09-08 09:57:46',NULL,NULL),(15,'new_password',1,'2019-09-08 09:57:46',NULL,NULL),(16,'retype_new_password',1,'2019-09-08 09:57:46',NULL,NULL),(17,'old_password_must_fielld',1,'2019-09-08 09:57:46',NULL,NULL),(18,'new_password_must_fielld',1,'2019-09-08 09:57:46',NULL,NULL),(19,'retype_new_password_must_fielld',1,'2019-09-08 09:57:46',NULL,NULL),(20,'new_password_and_retype_new_password_not_match',1,'2019-09-08 09:57:46',NULL,NULL),(21,'old_password_wrong',1,'2019-09-08 09:57:46',NULL,NULL),(22,'success_change_password',1,'2019-09-08 09:57:46',NULL,NULL),(23,'failed_change_password',1,'2019-09-08 09:57:46',NULL,NULL),(24,'translation',1,'2019-09-08 09:57:46',NULL,NULL),(25,'language',1,'2019-09-09 18:58:45',NULL,NULL),(26,'number',1,'2019-09-09 21:22:09',NULL,NULL),(27,'action',1,'2019-09-09 21:22:57',5,'2019-09-15 20:38:39'),(28,'code',1,'2019-09-09 21:23:42',NULL,NULL),(29,'add',1,'2019-09-09 21:28:25',NULL,NULL),(30,'detail',1,'2019-09-09 21:47:01',NULL,NULL),(31,'edit',1,'2019-09-09 21:47:01',NULL,NULL),(32,'delete',1,'2019-09-09 21:47:01',NULL,NULL),(33,'icon',1,'2019-09-09 21:47:01',NULL,NULL),(34,'choose_image',1,'2019-09-10 06:43:23',NULL,NULL),(35,'process',1,'2019-09-10 19:09:20',NULL,NULL),(36,'msg_add_success',1,'2019-09-10 19:39:42',NULL,NULL),(37,'msg_add_failed',1,'2019-09-10 19:39:42',NULL,NULL),(38,'required',1,'2019-09-10 19:52:01',NULL,NULL),(39,'msg_update_success',1,'2019-09-10 23:41:21',NULL,NULL),(40,'msg_update_failed',1,'2019-09-10 23:41:21',NULL,NULL),(41,'existed',1,'2019-09-11 00:15:38',NULL,NULL),(42,'success_upload',1,'2019-09-11 00:30:19',NULL,NULL),(43,'failed_upload',1,'2019-09-11 00:30:19',NULL,NULL),(44,'allowed_file_is',1,'2019-09-11 00:30:19',NULL,NULL),(45,'max_file_is',1,'2019-09-11 00:30:19',NULL,NULL),(46,'msg_delete_success',1,'2019-09-11 00:32:51',NULL,NULL),(47,'msg_delete_failed',1,'2019-09-11 00:32:51',NULL,NULL),(48,'name',1,'2019-09-12 22:12:08',NULL,NULL),(49,'email',1,'2019-09-12 22:12:24',NULL,NULL),(50,'phone',1,'2019-09-12 22:13:22',NULL,NULL),(51,'admin',1,'2019-09-12 22:13:34',NULL,NULL),(52,'yes',1,'2019-09-12 22:13:47',NULL,NULL),(53,'no',1,'2019-09-12 22:13:55',NULL,NULL),(54,'gender',1,'2019-09-13 07:02:43',NULL,NULL),(55,'birthday',1,'2019-09-13 07:03:01',NULL,NULL),(56,'nationality',1,'2019-09-13 07:03:41',NULL,NULL),(57,'address',1,'2019-09-13 07:03:54',NULL,NULL),(58,'is_admin',1,'2019-09-13 07:04:22',NULL,NULL),(59,'male',1,'2019-09-13 07:05:00',NULL,NULL),(60,'female',1,'2019-09-13 07:05:21',NULL,NULL),(61,'status',1,'2019-09-13 07:05:35',NULL,NULL),(62,'desc',1,'2019-09-13 07:06:03',NULL,NULL),(63,'password',1,'2019-09-13 07:06:22',NULL,NULL),(64,'retype_password',1,'2019-09-13 07:07:10',NULL,NULL),(65,'wni',1,'2019-09-13 07:09:40',NULL,NULL),(66,'wna',1,'2019-09-13 07:10:48',NULL,NULL),(67,'active',1,'2019-09-13 07:15:31',NULL,NULL),(68,'not_active',1,'2019-09-13 07:15:46',NULL,NULL),(69,'select',1,'2019-09-13 07:19:28',NULL,NULL),(70,'note',1,'2019-09-13 17:41:55',NULL,NULL),(71,'password_and_retype_password_not_match',1,'2019-09-14 13:22:45',NULL,NULL),(72,'inserted',1,'2019-09-14 16:23:07',NULL,NULL),(73,'updated',1,'2019-09-14 16:23:32',NULL,NULL),(74,'photo',1,'2019-09-15 00:06:20',NULL,NULL),(75,'cms',1,'2019-09-15 11:57:07',NULL,NULL),(76,'slider',1,'2019-09-15 11:57:37',NULL,NULL),(77,'service',1,'2019-09-15 12:04:28',5,'2019-11-19 09:29:55'),(78,'about_us',1,'2019-09-15 12:06:10',NULL,NULL),(79,'contact',1,'2019-09-15 12:41:40',NULL,NULL),(80,'gallery',1,'2019-09-15 12:54:19',NULL,NULL),(81,'destination',1,'2019-09-15 13:31:48',NULL,NULL),(82,'title',1,'2019-09-15 14:00:56',NULL,NULL),(83,'link',1,'2019-09-15 14:01:19',NULL,NULL),(84,'order',1,'2019-09-15 14:02:01',NULL,NULL),(85,'image',1,'2019-09-15 14:19:10',NULL,NULL),(86,'content',1,'2019-09-15 14:23:41',NULL,NULL),(87,'title_link',1,'2019-09-15 14:47:19',1,'2019-09-15 14:47:41'),(88,'is_top',5,'2019-09-17 06:12:23',NULL,NULL),(89,'type',5,'2019-09-17 06:12:47',NULL,NULL),(90,'information',5,'2019-09-17 07:12:55',NULL,NULL),(91,'tour_packages',5,'2019-09-17 20:36:33',NULL,NULL),(92,'ticket',5,'2019-09-17 20:36:52',NULL,NULL),(93,'venue',5,'2019-09-17 20:37:23',NULL,NULL),(94,'alert',5,'2019-09-18 09:06:19',NULL,NULL),(95,'ok',5,'2019-09-18 09:09:40',NULL,NULL),(96,'term_and_condition',5,'2019-09-19 01:11:26',5,'2019-09-19 01:12:11'),(97,'privacy_policy',5,'2019-09-19 18:42:16',NULL,NULL),(98,'whatsapp',5,'2019-09-21 16:57:11',NULL,NULL),(99,'facebook',5,'2019-09-21 16:57:24',NULL,NULL),(100,'instagram',5,'2019-09-21 16:57:48',NULL,NULL),(101,'twitter',5,'2019-09-21 16:57:57',NULL,NULL),(102,'link_maps',5,'2019-09-21 16:58:31',5,'2019-09-22 09:09:12'),(103,'image_maps',5,'2019-09-21 16:58:46',NULL,NULL),(104,'galleryimages',5,'2019-09-22 12:23:47',5,'2019-09-22 12:24:13'),(105,'tourpackages',5,'2019-09-23 18:28:51',NULL,NULL),(106,'default_price_local',5,'2019-09-24 19:07:39',NULL,NULL),(107,'default_price_foreign',5,'2019-09-24 19:08:21',5,'2019-12-05 21:47:50'),(108,'price_period',5,'2019-09-24 22:06:04',NULL,NULL),(109,'local_tourist_price',5,'2019-09-24 22:12:17',NULL,NULL),(110,'foreign_tourist_price',5,'2019-09-24 22:12:49',5,'2019-12-05 21:47:54'),(111,'start',5,'2019-09-24 22:14:22',NULL,NULL),(112,'end',5,'2019-09-24 22:14:30',NULL,NULL),(113,'empty_data',5,'2019-09-26 09:40:13',NULL,NULL),(114,'visitor_type',5,'2019-09-27 21:49:26',NULL,NULL),(116,'is_rating_manual',5,'2019-09-28 16:06:20',NULL,NULL),(117,'rating_manual_value',5,'2019-09-28 16:10:42',5,'2019-11-30 20:11:25'),(118,'total_rater_manual',5,'2019-09-28 16:12:23',NULL,NULL),(119,'day',5,'2019-09-28 23:01:41',NULL,NULL),(120,'is_night',5,'2019-09-28 23:02:32',NULL,NULL),(121,'testimony',5,'2019-10-09 12:24:57',NULL,NULL),(122,'tourpackagestestimony',5,'2019-10-09 13:46:19',NULL,NULL),(123,'rating',5,'2019-10-09 13:59:30',NULL,NULL),(124,'is_process',5,'2019-10-09 14:01:40',5,'2019-10-09 14:02:51'),(125,'is_publish',5,'2019-10-09 14:02:38',NULL,NULL),(126,'date',5,'2019-10-09 16:02:41',NULL,NULL),(127,'publish',5,'2019-10-09 18:28:35',5,'2019-10-09 18:28:51'),(128,'unpublish',5,'2019-10-09 18:29:33',NULL,NULL),(129,'transaction',5,'2019-10-09 19:48:40',NULL,NULL),(130,'venue_schedule',5,'2019-10-09 22:12:25',NULL,NULL),(131,'home',5,'2019-10-22 20:33:52',NULL,NULL),(132,'adult',5,'2019-10-23 02:18:42',NULL,NULL),(133,'child',5,'2019-10-23 02:19:52',NULL,NULL),(134,'student',5,'2019-10-23 02:20:54',NULL,NULL),(135,'tourist_type',5,'2019-10-23 02:29:08',NULL,NULL),(136,'search',5,'2019-10-23 02:31:26',NULL,NULL),(137,'other_packages',5,'2019-10-23 04:01:44',5,'2019-11-24 07:40:54'),(138,'subscribe',5,'2019-10-23 04:27:10',NULL,NULL),(139,'enter_your_email',5,'2019-10-23 04:30:25',NULL,NULL),(140,'text_subscribe',5,'2019-10-25 17:41:43',NULL,NULL),(141,'text_form_ticket',5,'2019-10-25 17:44:16',NULL,NULL),(142,'text_from_ticket_title',5,'2019-10-25 17:46:38',NULL,NULL),(143,'text_most_popular_package',5,'2019-10-25 17:56:22',NULL,NULL),(144,'text_most_popular_package_title',5,'2019-10-25 17:57:06',NULL,NULL),(145,'company',5,'2019-10-26 20:10:37',NULL,NULL),(146,'support',5,'2019-10-27 06:27:10',NULL,NULL),(147,'follow_us_on',5,'2019-10-27 06:28:32',NULL,NULL),(148,'register',5,'2019-10-27 12:59:49',NULL,NULL),(149,'forget_password',5,'2019-10-27 17:06:46',NULL,NULL),(150,'is_type_visitor',5,'2019-10-28 05:30:54',5,'2019-10-28 05:41:11'),(151,'greeting',5,'2019-11-03 18:21:46',NULL,NULL),(152,'link_img',5,'2019-11-03 19:06:39',NULL,NULL),(153,'bhiva',5,'2019-11-03 19:11:05',NULL,NULL),(154,'travel_post',5,'2019-11-03 19:11:35',6,'2019-12-06 17:37:55'),(155,'location',5,'2019-11-03 20:36:56',NULL,NULL),(156,'destination_location',5,'2019-11-03 21:27:20',NULL,NULL),(157,'is_show_home',5,'2019-11-03 22:43:43',5,'2019-11-03 22:43:58'),(158,'text_home_destination',5,'2019-11-04 05:34:41',NULL,NULL),(159,'other_destination',5,'2019-11-04 05:50:20',NULL,NULL),(160,'our_photo_gallery',5,'2019-11-10 13:23:01',NULL,NULL),(161,'text_our_photo_gallery',5,'2019-11-10 18:08:29',NULL,NULL),(162,'photo_gallery',5,'2019-11-10 18:34:08',NULL,NULL),(163,'blank_photo_data',5,'2019-11-11 01:47:53',NULL,NULL),(164,'travelpost',5,'2019-11-16 11:17:24',NULL,NULL),(165,'latest_posts',5,'2019-11-18 06:09:13',NULL,NULL),(166,'share_on',5,'2019-11-18 07:26:46',NULL,NULL),(167,'text_travel_post',5,'2019-11-19 05:16:48',NULL,NULL),(168,'load_more',5,'2019-11-19 05:25:38',NULL,NULL),(169,'loading',5,'2019-11-19 05:54:07',NULL,NULL),(170,'more_travel_post',5,'2019-11-21 08:40:06',NULL,NULL),(171,'tour_packages_related',5,'2019-11-21 10:37:40',NULL,NULL),(172,'there_are_no_tour_packages',5,'2019-11-21 10:49:29',NULL,NULL),(173,'filter',5,'2019-11-24 12:13:02',NULL,NULL),(174,'price',5,'2019-11-24 12:25:04',NULL,NULL),(175,'minimum',5,'2019-11-24 14:25:28',NULL,NULL),(176,'maximum',5,'2019-11-24 14:25:43',5,'2019-11-30 20:06:38'),(177,'time',5,'2019-11-24 14:32:06',NULL,NULL),(178,'total_day',5,'2019-11-24 18:51:48',NULL,NULL),(179,'total_night',5,'2019-11-24 18:53:11',NULL,NULL),(180,'total_night_total_day_text',5,'2019-11-24 22:42:49',NULL,NULL),(181,'night',5,'2019-11-25 04:16:06',NULL,NULL),(182,'all',5,'2019-11-25 04:22:24',NULL,NULL),(183,'latest',5,'2019-11-25 09:05:54',NULL,NULL),(184,'most_popular',5,'2019-11-25 09:07:05',NULL,NULL),(185,'lowest_price',5,'2019-11-25 09:08:18',NULL,NULL),(186,'highest_price',5,'2019-11-25 09:09:47',NULL,NULL),(187,'sort',5,'2019-11-25 09:13:42',NULL,NULL),(188,'show',5,'2019-11-25 10:34:08',NULL,NULL),(189,'data',5,'2019-11-25 10:34:22',NULL,NULL),(190,'tour_packages_not_found',5,'2019-12-01 19:14:10',NULL,NULL),(191,'text_testimony_tourpackage',5,'2019-12-05 21:23:44',NULL,NULL),(192,'foreign_tourists',5,'2019-12-05 21:48:55',NULL,NULL),(193,'local_tourists',5,'2019-12-05 21:50:24',5,'2019-12-05 22:09:50'),(194,'quantity',5,'2019-12-05 22:13:49',NULL,NULL),(195,'min_order',5,'2019-12-05 22:32:24',NULL,NULL),(196,'max_order',5,'2019-12-05 22:32:54',NULL,NULL),(197,'book_tour_package',5,'2019-12-06 07:25:01',NULL,NULL),(198,'must_be_more_than',5,'2019-12-07 23:54:26',5,'2019-12-07 23:56:13'),(199,'there_are_no_testimonials_yet',5,'2019-12-08 00:41:43',NULL,NULL),(200,'travel_date',5,'2019-12-08 12:39:37',NULL,NULL),(201,'registration_successful',5,'2019-12-14 18:45:28',NULL,NULL),(202,'registration_failed',5,'2019-12-14 18:46:21',5,'2019-12-14 19:02:04'),(203,'email_must_fielld',5,'2019-12-14 22:55:11',NULL,NULL),(204,'email_password_must_fielld',5,'2019-12-14 23:36:24',5,'2019-12-14 23:36:57'),(205,'profile',5,'2019-12-16 06:37:59',NULL,NULL),(206,'my_order',5,'2019-12-16 06:40:31',NULL,NULL);

/*Table structure for table `core_key_text` */

DROP TABLE IF EXISTS `core_key_text`;

CREATE TABLE `core_key_text` (
  `keytext_key_id` bigint(20) NOT NULL,
  `keytext_lang_code` varchar(5) NOT NULL,
  `keytext_text` text,
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`keytext_key_id`,`keytext_lang_code`),
  KEY `keytext_lang_code` (`keytext_lang_code`),
  KEY `keytext_key_id` (`keytext_key_id`),
  CONSTRAINT `core_key_text_ibfk_1` FOREIGN KEY (`keytext_key_id`) REFERENCES `core_key` (`key_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `core_key_text_ibfk_2` FOREIGN KEY (`keytext_lang_code`) REFERENCES `core_lang` (`lang_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `core_key_text` */

insert  into `core_key_text`(`keytext_key_id`,`keytext_lang_code`,`keytext_text`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (1,'en','Login',1,'2019-09-07 19:29:48',NULL,NULL),(1,'id','Login',1,'2019-09-07 19:29:48',NULL,NULL),(2,'en','Username must be fielld',1,'2019-09-07 21:06:44',NULL,NULL),(2,'id','Username harus diisi',1,'2019-09-07 21:06:44',NULL,NULL),(3,'en','Password must be fielld',1,'2019-09-07 21:06:44',NULL,NULL),(3,'id','Password harus diisi',1,'2019-09-07 21:06:44',NULL,NULL),(4,'en','Username and Password must be fielld',1,'2019-09-07 21:06:44',NULL,NULL),(4,'id','Username dan Password harus diisi',1,'2019-09-07 21:06:44',NULL,NULL),(5,'en','Username or Password is wrong',1,'2019-09-07 21:45:05',NULL,NULL),(5,'id','Username atau Password salah',1,'2019-09-07 21:45:04',NULL,NULL),(6,'en','Setting',1,'2019-09-08 08:58:56',NULL,NULL),(6,'id','Setting',1,'2019-09-08 08:58:53',NULL,NULL),(7,'en','Logout',1,'2019-09-08 09:02:02',NULL,NULL),(7,'id','Logout',1,'2019-09-08 09:02:01',NULL,NULL),(8,'en','Dashboard',1,'2019-09-08 09:03:11',NULL,NULL),(8,'id','Dashboard',1,'2019-09-08 09:03:10',NULL,NULL),(9,'en','Master Data',1,'2019-09-08 09:19:42',NULL,NULL),(9,'id','Data Master',1,'2019-09-08 09:19:40',NULL,NULL),(10,'en','User',1,'2019-09-08 09:21:52',NULL,NULL),(10,'id','User',1,'2019-09-08 09:21:50',NULL,NULL),(11,'en','Change Password',1,'2019-09-08 09:27:29',NULL,NULL),(11,'id','Ubah Password',1,'2019-09-08 09:27:29',NULL,NULL),(12,'en','Close',1,'2019-09-08 09:37:46',NULL,NULL),(12,'id','Tutup',1,'2019-09-08 09:37:46',NULL,NULL),(13,'en','Save',1,'2019-09-08 09:37:46',NULL,NULL),(13,'id','Simpan',1,'2019-09-08 09:37:46',NULL,NULL),(14,'en','Old Password',1,'2019-09-08 09:58:22',NULL,NULL),(14,'id','Password Lama',1,'2019-09-08 09:58:22',NULL,NULL),(15,'en','New Password',1,'2019-09-08 09:58:22',NULL,NULL),(15,'id','Password Baru',1,'2019-09-08 09:58:22',NULL,NULL),(16,'en','Retype New Password',1,'2019-09-08 09:58:22',NULL,NULL),(16,'id','Ketik Ulang Password Baru',1,'2019-09-08 09:58:22',NULL,NULL),(17,'en','Old Password must be fielld',1,'2019-09-08 09:58:22',NULL,NULL),(17,'id','Password lama harus diisi',1,'2019-09-08 09:58:22',NULL,NULL),(18,'en','New Password must be fielld',1,'2019-09-08 09:58:22',NULL,NULL),(18,'id','Password Baru harus diisi',1,'2019-09-08 09:58:22',NULL,NULL),(19,'en','Retype New Password must be fielld',1,'2019-09-08 09:58:22',NULL,NULL),(19,'id','Ketik Ulang Password Baru harus diisi',1,'2019-09-08 09:58:22',NULL,NULL),(20,'en','New Password and Retype New Password not match',1,'2019-09-08 09:58:22',NULL,NULL),(20,'id','Password Baru dan Ketik Ulang Password Baru tidak cocok',1,'2019-09-08 09:58:22',NULL,NULL),(21,'en','Old Password wrong',1,'2019-09-08 09:58:22',NULL,NULL),(21,'id','Password Lama salah',1,'2019-09-08 09:58:22',NULL,NULL),(22,'en','Success change password',1,'2019-09-08 09:58:22',NULL,NULL),(22,'id','Berhasil merubah password',1,'2019-09-08 09:58:22',NULL,NULL),(23,'en','Failed change password',1,'2019-09-08 09:58:22',NULL,NULL),(23,'id','Gagal merubah password',1,'2019-09-08 09:58:22',NULL,NULL),(24,'en','Translation',1,'2019-09-08 09:58:22',NULL,NULL),(24,'id','Terjemahan',1,'2019-09-08 09:58:22',NULL,NULL),(25,'en','Language',1,'2019-09-09 18:59:18',NULL,NULL),(25,'id','Bahasa',1,'2019-09-09 18:59:17',NULL,NULL),(26,'en','No',1,'2019-09-09 21:22:38',NULL,NULL),(26,'id','No',1,'2019-09-09 21:22:38',NULL,NULL),(27,'en','Action',1,'2019-09-09 21:23:23',1,'2019-09-13 07:35:19'),(27,'id','Aksi',1,'2019-09-09 21:23:23',1,'2019-09-13 07:35:19'),(28,'en','Code',1,'2019-09-09 21:24:11',NULL,NULL),(28,'id',' Kode',1,'2019-09-09 21:24:08',NULL,NULL),(29,'en','Add',1,'2019-09-09 21:28:48',NULL,NULL),(29,'id','Tambah',1,'2019-09-09 21:28:48',NULL,NULL),(30,'en','Detail',1,'2019-09-09 21:49:03',NULL,NULL),(30,'id','Detail',1,'2019-09-09 21:49:03',NULL,NULL),(31,'en','Edit',1,'2019-09-09 21:49:03',NULL,NULL),(31,'id','Ubah',1,'2019-09-09 21:49:03',NULL,NULL),(32,'en','Delete',1,'2019-09-09 21:49:03',NULL,NULL),(32,'id','Hapus',1,'2019-09-09 21:49:03',NULL,NULL),(33,'en','Icon',1,'2019-09-09 21:49:03',NULL,NULL),(33,'id','Icon',1,'2019-09-09 21:49:03',NULL,NULL),(34,'en','Choose Image',1,'2019-09-10 06:43:54',NULL,NULL),(34,'id','Pilih Gambar',1,'2019-09-10 06:43:53',NULL,NULL),(35,'en','Process',1,'2019-09-10 19:09:51',NULL,NULL),(35,'id','Proses',1,'2019-09-10 19:09:51',NULL,NULL),(36,'en','Add Data Successfully',1,'2019-09-10 19:41:33',NULL,NULL),(36,'id','Berhasil Menambah Data',1,'2019-09-10 19:41:31',NULL,NULL),(37,'en','Add Data Failed',1,'2019-09-10 19:42:50',NULL,NULL),(37,'id','Gagal Menambah Data',1,'2019-09-10 19:42:45',NULL,NULL),(38,'en','Required',1,'2019-09-10 19:52:33',NULL,NULL),(38,'id','Dibutuhkan',1,'2019-09-10 19:52:33',NULL,NULL),(39,'en','Edit Data Successfully',1,'2019-09-10 23:43:28',NULL,NULL),(39,'id','Berhasil Merubah Data',1,'2019-09-10 23:43:28',NULL,NULL),(40,'en','Edit Data Failed',1,'2019-09-10 23:43:28',NULL,NULL),(40,'id','Gagal Merubah Data',1,'2019-09-10 23:43:28',NULL,NULL),(41,'en','Already Exists',1,'2019-09-11 00:13:26',NULL,NULL),(41,'id','Sudah Ada',1,'2019-09-11 00:13:26',NULL,NULL),(42,'en','Success Upload',1,'2019-09-11 00:17:44',NULL,NULL),(42,'id','Berhasil Upload',1,'2019-09-11 00:17:44',NULL,NULL),(43,'en','Failed Upload',1,'2019-09-11 00:17:44',NULL,NULL),(43,'id','Gagal Upload',1,'2019-09-11 00:17:44',NULL,NULL),(44,'en','Allowed file is',1,'2019-09-11 00:17:44',NULL,NULL),(44,'id','File yang diperbolehkan adalah',1,'2019-09-11 00:17:44',NULL,NULL),(45,'en','Max file size is',1,'2019-09-11 00:18:47',NULL,NULL),(45,'id','Ukuran file maksimal adalah',1,'2019-09-11 00:18:47',NULL,NULL),(46,'en','Delete Data Successfully',1,'2019-09-11 00:32:37',NULL,NULL),(46,'id','Berhasil Menghapus Data',1,'2019-09-11 00:32:37',NULL,NULL),(47,'en','Delete Data Failed',1,'2019-09-11 00:32:37',NULL,NULL),(47,'id','Gagal Menghapus Data',1,'2019-09-11 00:32:37',NULL,NULL),(48,'en','Name',1,'2019-09-12 22:12:08',NULL,NULL),(48,'id','Nama',1,'2019-09-12 22:12:08',NULL,NULL),(49,'en','Email',1,'2019-09-12 22:12:24',NULL,NULL),(49,'id','Email',1,'2019-09-12 22:12:24',NULL,NULL),(50,'en','Phone',1,'2019-09-12 22:13:22',NULL,NULL),(50,'id','Telepon',1,'2019-09-12 22:13:22',NULL,NULL),(51,'en','Admin',1,'2019-09-12 22:13:34',NULL,NULL),(51,'id','Admin',1,'2019-09-12 22:13:34',NULL,NULL),(52,'en','Yes',1,'2019-09-12 22:13:47',NULL,NULL),(52,'id','Ya',1,'2019-09-12 22:13:47',NULL,NULL),(53,'en','No',1,'2019-09-12 22:13:55',NULL,NULL),(53,'id','Tidak',1,'2019-09-12 22:13:55',NULL,NULL),(54,'en','Gender',1,'2019-09-13 07:02:43',NULL,NULL),(54,'id','Jenis Kelamin',1,'2019-09-13 07:02:43',NULL,NULL),(55,'en','Birthday',1,'2019-09-13 07:03:01',NULL,NULL),(55,'id','Tanggal Lahir',1,'2019-09-13 07:03:01',NULL,NULL),(56,'en','Nationality',1,'2019-09-13 07:03:41',NULL,NULL),(56,'id','Kewarganegaraan',1,'2019-09-13 07:03:41',NULL,NULL),(57,'en','Address',1,'2019-09-13 07:03:54',NULL,NULL),(57,'id','Alamat',1,'2019-09-13 07:03:54',NULL,NULL),(58,'en','Is Admin',1,'2019-09-13 07:04:22',NULL,NULL),(58,'id','Apakah Admin',1,'2019-09-13 07:04:22',NULL,NULL),(59,'en','Male',1,'2019-09-13 07:05:00',NULL,NULL),(59,'id','Pria',1,'2019-09-13 07:05:00',NULL,NULL),(60,'en','Female',1,'2019-09-13 07:05:21',NULL,NULL),(60,'id','Wanita',1,'2019-09-13 07:05:21',NULL,NULL),(61,'en','Status',1,'2019-09-13 07:05:35',NULL,NULL),(61,'id','Status',1,'2019-09-13 07:05:35',NULL,NULL),(62,'en','Description',1,'2019-09-13 07:06:03',NULL,NULL),(62,'id','Deskripsi',1,'2019-09-13 07:06:03',NULL,NULL),(63,'en','Password',1,'2019-09-13 07:06:22',NULL,NULL),(63,'id','Password',1,'2019-09-13 07:06:22',NULL,NULL),(64,'en','Retype Password',1,'2019-09-13 07:07:10',NULL,NULL),(64,'id','Ulang Password',1,'2019-09-13 07:07:10',NULL,NULL),(65,'en','Indonesian Citizens',1,'2019-09-13 07:09:40',NULL,NULL),(65,'id','Warga Negara Indonesia',1,'2019-09-13 07:09:40',NULL,NULL),(66,'en','Other Citizens',1,'2019-09-13 07:10:48',NULL,NULL),(66,'id','Warga Negara Asing',1,'2019-09-13 07:10:48',NULL,NULL),(67,'en','Active',1,'2019-09-13 07:15:31',NULL,NULL),(67,'id','Aktif',1,'2019-09-13 07:15:31',NULL,NULL),(68,'en','Not Active',1,'2019-09-13 07:15:46',NULL,NULL),(68,'id','Tidak Aktif',1,'2019-09-13 07:15:46',NULL,NULL),(69,'en','Select',1,'2019-09-13 07:19:28',NULL,NULL),(69,'id','Pilih',1,'2019-09-13 07:19:28',NULL,NULL),(70,'en','Note',1,'2019-09-13 17:41:55',NULL,NULL),(70,'id','Catatan',1,'2019-09-13 17:41:55',NULL,NULL),(71,'en','Password and Retype Password Not Match',1,'2019-09-14 13:22:45',NULL,NULL),(71,'id','Password dan Ulang Password Tidak Cocok',1,'2019-09-14 13:22:45',NULL,NULL),(72,'en','Inserted',1,'2019-09-14 16:23:07',NULL,NULL),(72,'id','Dimasukan',1,'2019-09-14 16:23:07',NULL,NULL),(73,'en','Updated',1,'2019-09-14 16:23:32',NULL,NULL),(73,'id','Diupdate',1,'2019-09-14 16:23:32',NULL,NULL),(74,'en','Photo',1,'2019-09-15 00:06:20',NULL,NULL),(74,'id','Foto',1,'2019-09-15 00:06:20',NULL,NULL),(75,'en','CMS',1,'2019-09-15 11:57:07',NULL,NULL),(75,'id','CMS',1,'2019-09-15 11:57:07',NULL,NULL),(76,'en','Slider',1,'2019-09-15 11:57:37',NULL,NULL),(76,'id','Slider',1,'2019-09-15 11:57:37',NULL,NULL),(77,'en','Services',1,'2019-09-15 12:04:28',5,'2019-11-19 09:29:55'),(77,'id','Layanan',1,'2019-09-15 12:04:28',5,'2019-11-19 09:29:55'),(78,'en','About Us',1,'2019-09-15 12:06:10',NULL,NULL),(78,'id','Tentang Kami',1,'2019-09-15 12:06:10',NULL,NULL),(79,'en','Contact',1,'2019-09-15 12:41:40',NULL,NULL),(79,'id','Kontak',1,'2019-09-15 12:41:40',NULL,NULL),(80,'en','Gallery',1,'2019-09-15 12:54:19',NULL,NULL),(80,'id','Galeri',1,'2019-09-15 12:54:19',NULL,NULL),(81,'en','Destination',1,'2019-09-15 13:31:48',NULL,NULL),(81,'id','Destinasi',1,'2019-09-15 13:31:48',NULL,NULL),(82,'en','Title',1,'2019-09-15 14:00:56',NULL,NULL),(82,'id','Judul',1,'2019-09-15 14:00:56',NULL,NULL),(83,'en','Link',1,'2019-09-15 14:01:19',NULL,NULL),(83,'id','Tautan',1,'2019-09-15 14:01:19',NULL,NULL),(84,'en','Order',1,'2019-09-15 14:02:01',NULL,NULL),(84,'id','Urutan',1,'2019-09-15 14:02:01',NULL,NULL),(85,'en','Image',1,'2019-09-15 14:19:10',NULL,NULL),(85,'id','Gambar',1,'2019-09-15 14:19:10',NULL,NULL),(86,'en','Content',1,'2019-09-15 14:23:41',NULL,NULL),(86,'id','Konten',1,'2019-09-15 14:23:41',NULL,NULL),(87,'en','Title Link',1,'2019-09-15 14:47:19',1,'2019-09-15 14:47:41'),(87,'id','Judul Tautan',1,'2019-09-15 14:47:19',1,'2019-09-15 14:47:41'),(88,'en','Top Position',5,'2019-09-17 06:12:23',NULL,NULL),(88,'id','Posisi Atas',5,'2019-09-17 06:12:23',NULL,NULL),(89,'en','Type',5,'2019-09-17 06:12:47',NULL,NULL),(89,'id','Jenis',5,'2019-09-17 06:12:47',NULL,NULL),(90,'en','Information',5,'2019-09-17 07:12:55',NULL,NULL),(90,'id','Informasi',5,'2019-09-17 07:12:55',NULL,NULL),(91,'en','Tour Packages',5,'2019-09-17 20:36:33',NULL,NULL),(91,'id','Paket Wisata',5,'2019-09-17 20:36:33',NULL,NULL),(92,'en','Ticket',5,'2019-09-17 20:36:52',NULL,NULL),(92,'id','Tiket',5,'2019-09-17 20:36:52',NULL,NULL),(93,'en','Venue',5,'2019-09-17 20:37:23',NULL,NULL),(93,'id','Venue',5,'2019-09-17 20:37:23',NULL,NULL),(94,'en','Alert',5,'2019-09-18 09:06:19',NULL,NULL),(94,'id','Peringatan',5,'2019-09-18 09:06:19',NULL,NULL),(95,'en','Ok',5,'2019-09-18 09:09:40',NULL,NULL),(95,'id','Ok',5,'2019-09-18 09:09:40',NULL,NULL),(96,'en','Term & Condition',5,'2019-09-19 01:11:26',5,'2019-09-19 01:12:11'),(96,'id','Syarat & Ketentuan',5,'2019-09-19 01:11:26',5,'2019-09-19 01:12:11'),(97,'en','Privacy Policy',5,'2019-09-19 18:42:16',NULL,NULL),(97,'id','Kebijakan Privasi',5,'2019-09-19 18:42:16',NULL,NULL),(98,'en','Whatsapp',5,'2019-09-21 16:57:11',NULL,NULL),(98,'id','Whatsapp',5,'2019-09-21 16:57:11',NULL,NULL),(99,'en','Facebook',5,'2019-09-21 16:57:24',NULL,NULL),(99,'id','Facebook',5,'2019-09-21 16:57:24',NULL,NULL),(100,'en','Instagram',5,'2019-09-21 16:57:48',NULL,NULL),(100,'id','Instagram',5,'2019-09-21 16:57:48',NULL,NULL),(101,'en','Twitter',5,'2019-09-21 16:57:57',NULL,NULL),(101,'id','Twitter',5,'2019-09-21 16:57:57',NULL,NULL),(102,'en','Link Maps',5,'2019-09-21 16:58:31',5,'2019-09-22 09:09:12'),(102,'id','Tautan Peta',5,'2019-09-21 16:58:31',5,'2019-09-22 09:09:12'),(103,'en','Image Maps',5,'2019-09-21 16:58:46',NULL,NULL),(103,'id','Gambar Peta',5,'2019-09-21 16:58:46',NULL,NULL),(104,'en','Gallery Images',5,'2019-09-22 12:23:47',5,'2019-09-22 12:24:13'),(104,'id','Gambar Galeri',5,'2019-09-22 12:23:47',5,'2019-09-22 12:24:13'),(105,'en','Tour Packages',5,'2019-09-23 18:28:51',NULL,NULL),(105,'id','Paket Wisata',5,'2019-09-23 18:28:51',NULL,NULL),(106,'en','Default Local Tourist Prices',5,'2019-09-24 19:07:39',NULL,NULL),(106,'id','Harga Default Wisatawan Lokal',5,'2019-09-24 19:07:39',NULL,NULL),(107,'en','Default Foreign Tourist Prices',5,'2019-09-24 19:08:21',5,'2019-12-05 21:47:50'),(107,'id','Harga Default Wisatawan Mancanegawa',5,'2019-09-24 19:08:21',5,'2019-12-05 21:47:50'),(108,'en','Price Period',5,'2019-09-24 22:06:04',NULL,NULL),(108,'id','Periode Harga',5,'2019-09-24 22:06:04',NULL,NULL),(109,'en','Local Tourist Price',5,'2019-09-24 22:12:17',NULL,NULL),(109,'id','Harga Wisatawan Lokal',5,'2019-09-24 22:12:17',NULL,NULL),(110,'en','Foreign Tourist Price',5,'2019-09-24 22:12:49',5,'2019-12-05 21:47:54'),(110,'id','Harga Wisatawan Mancanegawa',5,'2019-09-24 22:12:49',5,'2019-12-05 21:47:54'),(111,'en','Start',5,'2019-09-24 22:14:22',NULL,NULL),(111,'id','Mulai',5,'2019-09-24 22:14:22',NULL,NULL),(112,'en','End',5,'2019-09-24 22:14:30',NULL,NULL),(112,'id','Selesai',5,'2019-09-24 22:14:30',NULL,NULL),(113,'en','Empty Data',5,'2019-09-26 09:40:13',NULL,NULL),(113,'id','Data Kosong',5,'2019-09-26 09:40:13',NULL,NULL),(114,'en','Visitor Type',5,'2019-09-27 21:49:26',NULL,NULL),(114,'id','Jenis Pengunjung',5,'2019-09-27 21:49:26',NULL,NULL),(116,'en','Manual Rating',5,'2019-09-28 16:06:20',NULL,NULL),(116,'id','Penilaian Manual',5,'2019-09-28 16:06:20',NULL,NULL),(117,'en','Value of Rating Manual',5,'2019-09-28 16:10:42',5,'2019-11-30 20:11:25'),(117,'id','Nilai Penilaian Manual',5,'2019-09-28 16:10:42',5,'2019-11-30 20:11:25'),(118,'en','Rater Manual Total',5,'2019-09-28 16:12:23',NULL,NULL),(118,'id','Jumlah Penilai Manual',5,'2019-09-28 16:12:23',NULL,NULL),(119,'en','Day',5,'2019-09-28 23:01:41',NULL,NULL),(119,'id','Hari',5,'2019-09-28 23:01:41',NULL,NULL),(120,'en','Until Night',5,'2019-09-28 23:02:32',NULL,NULL),(120,'id','Sampai Malam',5,'2019-09-28 23:02:32',NULL,NULL),(121,'en','Testimony',5,'2019-10-09 12:24:57',NULL,NULL),(121,'id','Testimoni',5,'2019-10-09 12:24:57',NULL,NULL),(122,'en','Tour Packages Testimony',5,'2019-10-09 13:46:19',NULL,NULL),(122,'id','Testimoni Paket Wisata',5,'2019-10-09 13:46:19',NULL,NULL),(123,'en','Rating',5,'2019-10-09 13:59:30',NULL,NULL),(123,'id','Penilaian',5,'2019-10-09 13:59:30',NULL,NULL),(124,'en','Processed?',5,'2019-10-09 14:01:40',5,'2019-10-09 14:02:51'),(124,'id','Diproses?',5,'2019-10-09 14:01:40',5,'2019-10-09 14:02:51'),(125,'en','Published?',5,'2019-10-09 14:02:38',NULL,NULL),(125,'id','Dipublikasi?',5,'2019-10-09 14:02:38',NULL,NULL),(126,'en','Date',5,'2019-10-09 16:02:41',NULL,NULL),(126,'id','Tanggal',5,'2019-10-09 16:02:41',NULL,NULL),(127,'en','Publish',5,'2019-10-09 18:28:35',5,'2019-10-09 18:28:51'),(127,'id','Publikasi',5,'2019-10-09 18:28:35',5,'2019-10-09 18:28:51'),(128,'en','Unpublish',5,'2019-10-09 18:29:33',NULL,NULL),(128,'id','Batalkan Publikasi',5,'2019-10-09 18:29:33',NULL,NULL),(129,'en','Transaction',5,'2019-10-09 19:48:40',NULL,NULL),(129,'id','Transaksi',5,'2019-10-09 19:48:40',NULL,NULL),(130,'en','Venue Schedule',5,'2019-10-09 22:12:25',NULL,NULL),(130,'id','Jadwal Venue',5,'2019-10-09 22:12:25',NULL,NULL),(131,'en','Home',5,'2019-10-22 20:33:52',NULL,NULL),(131,'id','Beranda',5,'2019-10-22 20:33:52',NULL,NULL),(132,'en','Adult',5,'2019-10-23 02:18:42',NULL,NULL),(132,'id','Dewasa',5,'2019-10-23 02:18:42',NULL,NULL),(133,'en','Child',5,'2019-10-23 02:19:52',NULL,NULL),(133,'id','Anak',5,'2019-10-23 02:19:52',NULL,NULL),(134,'en','Student',5,'2019-10-23 02:20:54',NULL,NULL),(134,'id','Pelajar',5,'2019-10-23 02:20:54',NULL,NULL),(135,'en','Tourist Type',5,'2019-10-23 02:29:08',NULL,NULL),(135,'id','Jenis Wisatawan',5,'2019-10-23 02:29:08',NULL,NULL),(136,'en','Search',5,'2019-10-23 02:31:26',NULL,NULL),(136,'id','Cari',5,'2019-10-23 02:31:26',NULL,NULL),(137,'en','Other Travel Packages',5,'2019-10-23 04:01:44',5,'2019-11-24 07:40:54'),(137,'id','Paket Wisata Lainnya',5,'2019-10-23 04:01:44',5,'2019-11-24 07:40:54'),(138,'en','Subscribe',5,'2019-10-23 04:27:10',NULL,NULL),(138,'id','Langganan',5,'2019-10-23 04:27:10',NULL,NULL),(139,'en','Enter Your email',5,'2019-10-23 04:30:25',NULL,NULL),(139,'id','Masukan email Anda',5,'2019-10-23 04:30:25',NULL,NULL),(140,'en','Subscribe to our newsletter now and be the first to know about BHIVA\'s latest promos!',5,'2019-10-25 17:41:43',NULL,NULL),(140,'id','Berlangganan newsletter kami sekarang dan jadilah yang pertama tahu tentang promo terbaru BHIVA!',5,'2019-10-25 17:41:43',NULL,NULL),(141,'en','Choose your own entrance ticket to the temple',5,'2019-10-25 17:44:16',NULL,NULL),(141,'id','Pilih tiket masuk Anda sendiri ke candi',5,'2019-10-25 17:44:16',NULL,NULL),(142,'en','Temple Entrance Ticket',5,'2019-10-25 17:46:38',NULL,NULL),(142,'id','Tiket Masuk Candi',5,'2019-10-25 17:46:38',NULL,NULL),(143,'en','Choose your own choice of attractive tour packages that we provide',5,'2019-10-25 17:56:22',NULL,NULL),(143,'id','Pilih sendiri pilihan paket wisata menarik yang kami sediakan',5,'2019-10-25 17:56:22',NULL,NULL),(144,'en','Most Popular Travel Packages',5,'2019-10-25 17:57:06',NULL,NULL),(144,'id','Paket Perjalanan Paling Populer',5,'2019-10-25 17:57:06',NULL,NULL),(145,'en','Company',5,'2019-10-26 20:10:37',NULL,NULL),(145,'id','Perusahaan',5,'2019-10-26 20:10:37',NULL,NULL),(146,'en','Support',5,'2019-10-27 06:27:10',NULL,NULL),(146,'id','Dukungan',5,'2019-10-27 06:27:10',NULL,NULL),(147,'en','Follow Us',5,'2019-10-27 06:28:32',NULL,NULL),(147,'id','Ikuti Kami',5,'2019-10-27 06:28:32',NULL,NULL),(148,'en','Register',5,'2019-10-27 12:59:49',NULL,NULL),(148,'id','Daftar',5,'2019-10-27 12:59:49',NULL,NULL),(149,'en','Forget Password',5,'2019-10-27 17:06:46',NULL,NULL),(149,'id','Lupa Password',5,'2019-10-27 17:06:46',NULL,NULL),(150,'en','There are Visitor Types',5,'2019-10-28 05:30:54',5,'2019-10-28 05:41:11'),(150,'id','Ada Jenis Pengunjung',5,'2019-10-28 05:30:54',5,'2019-10-28 05:41:11'),(151,'en','Greeting',5,'2019-11-03 18:21:46',NULL,NULL),(151,'id','Sambutan',5,'2019-11-03 18:21:46',NULL,NULL),(152,'en','Image Link',5,'2019-11-03 19:06:39',NULL,NULL),(152,'id','Tautan Gambar',5,'2019-11-03 19:06:39',NULL,NULL),(153,'en','Bhiva',5,'2019-11-03 19:11:05',NULL,NULL),(153,'id','Bhiva',5,'2019-11-03 19:11:05',NULL,NULL),(154,'en','Travel Corner',5,'2019-11-03 19:11:35',6,'2019-12-06 17:37:55'),(154,'id','Pojok Perjalanan',5,'2019-11-03 19:11:35',6,'2019-12-06 17:37:55'),(155,'en','Location',5,'2019-11-03 20:36:56',NULL,NULL),(155,'id','Lokasi',5,'2019-11-03 20:36:56',NULL,NULL),(156,'en','Destination Location',5,'2019-11-03 21:27:20',NULL,NULL),(156,'id','Lokasi Destinasi',5,'2019-11-03 21:27:20',NULL,NULL),(157,'en','Show Home?',5,'2019-11-03 22:43:43',5,'2019-11-03 22:43:58'),(157,'id','Tampil Dihome?',5,'2019-11-03 22:43:43',5,'2019-11-03 22:43:58'),(158,'en','Choose your own choice of attractive destinations that we provide',5,'2019-11-04 05:34:41',NULL,NULL),(158,'id','Pilih sendiri pilihan destinasi menarik yang kami sediakan',5,'2019-11-04 05:34:41',NULL,NULL),(159,'en','Other Destination',5,'2019-11-04 05:50:20',NULL,NULL),(159,'id','Destinasi Lainnya',5,'2019-11-04 05:50:20',NULL,NULL),(160,'en','Our Photo Gallery',5,'2019-11-10 13:23:01',NULL,NULL),(160,'id','Galeri Foto Kami',5,'2019-11-10 13:23:01',NULL,NULL),(161,'en','Let\'s see photos of our activities and business',5,'2019-11-10 18:08:29',NULL,NULL),(161,'id','Ayo lihat foto foto kegiatan dan bisnis kami',5,'2019-11-10 18:08:29',NULL,NULL),(162,'en','Photo Gallery',5,'2019-11-10 18:34:08',NULL,NULL),(162,'id','Galeri Foto',5,'2019-11-10 18:34:08',NULL,NULL),(163,'en','Blank Photo Data',5,'2019-11-11 01:47:53',NULL,NULL),(163,'id','Data Foto Kosong',5,'2019-11-11 01:47:53',NULL,NULL),(164,'en','Travel Post',5,'2019-11-16 11:17:24',NULL,NULL),(164,'id','Travel Post',5,'2019-11-16 11:17:24',NULL,NULL),(165,'en','Latest Posts',5,'2019-11-18 06:09:13',NULL,NULL),(165,'id','Postingan Terbaru',5,'2019-11-18 06:09:13',NULL,NULL),(166,'en','Share on',5,'2019-11-18 07:26:46',NULL,NULL),(166,'id','Bagikan di',5,'2019-11-18 07:26:46',NULL,NULL),(167,'en','Blogs and Travel Articles',5,'2019-11-19 05:16:48',NULL,NULL),(167,'id','Blog dan Artikel Perjalanan',5,'2019-11-19 05:16:48',NULL,NULL),(168,'en','Load More',5,'2019-11-19 05:25:38',NULL,NULL),(168,'id','Muat Lebih',5,'2019-11-19 05:25:38',NULL,NULL),(169,'en','Loading',5,'2019-11-19 05:54:07',NULL,NULL),(169,'id','Memuat',5,'2019-11-19 05:54:07',NULL,NULL),(170,'en','More Travel Post',5,'2019-11-21 08:40:06',NULL,NULL),(170,'id','Travel Post Lainnya',5,'2019-11-21 08:40:06',NULL,NULL),(171,'en','Related Tour Packages',5,'2019-11-21 10:37:40',NULL,NULL),(171,'id','Paket Wisata Terkait',5,'2019-11-21 10:37:40',NULL,NULL),(172,'en','There are no tour packages',5,'2019-11-21 10:49:29',NULL,NULL),(172,'id','Belum ada paket wisata',5,'2019-11-21 10:49:29',NULL,NULL),(173,'en','Filter',5,'2019-11-24 12:13:02',NULL,NULL),(173,'id','Filter',5,'2019-11-24 12:13:02',NULL,NULL),(174,'en','Price',5,'2019-11-24 12:25:04',NULL,NULL),(174,'id','Harga',5,'2019-11-24 12:25:04',NULL,NULL),(175,'en','Minimum',5,'2019-11-24 14:25:28',NULL,NULL),(175,'id','Minimum',5,'2019-11-24 14:25:28',NULL,NULL),(176,'en','Maximum',5,'2019-11-24 14:25:43',5,'2019-11-30 20:06:38'),(176,'id','Maksimal',5,'2019-11-24 14:25:43',5,'2019-11-30 20:06:38'),(177,'en','Time',5,'2019-11-24 14:32:06',NULL,NULL),(177,'id','Waktu',5,'2019-11-24 14:32:06',NULL,NULL),(178,'en','Day Total',5,'2019-11-24 18:51:48',NULL,NULL),(178,'id','Total Hari',5,'2019-11-24 18:51:48',NULL,NULL),(179,'en','Night Total',5,'2019-11-24 18:53:11',NULL,NULL),(179,'id','Totall Malam',5,'2019-11-24 18:53:11',NULL,NULL),(180,'en','Total night cannot be more than total day',5,'2019-11-24 22:42:49',NULL,NULL),(180,'id','Total malam tidak boleh lebih dari total hari',5,'2019-11-24 22:42:49',NULL,NULL),(181,'en','Night',5,'2019-11-25 04:16:06',NULL,NULL),(181,'id','Malam',5,'2019-11-25 04:16:06',NULL,NULL),(182,'en','All',5,'2019-11-25 04:22:24',NULL,NULL),(182,'id','Semua',5,'2019-11-25 04:22:24',NULL,NULL),(183,'en','Latest',5,'2019-11-25 09:05:54',NULL,NULL),(183,'id','Terbaru',5,'2019-11-25 09:05:54',NULL,NULL),(184,'en','Most Popular',5,'2019-11-25 09:07:05',NULL,NULL),(184,'id','Paling Populer',5,'2019-11-25 09:07:05',NULL,NULL),(185,'en','Lowest Price',5,'2019-11-25 09:08:18',NULL,NULL),(185,'id','Harga Terendah',5,'2019-11-25 09:08:18',NULL,NULL),(186,'en','Highest Price',5,'2019-11-25 09:09:47',NULL,NULL),(186,'id','Harga Tertinggi',5,'2019-11-25 09:09:47',NULL,NULL),(187,'en','Sort',5,'2019-11-25 09:13:42',NULL,NULL),(187,'id','Urutkan',5,'2019-11-25 09:13:42',NULL,NULL),(188,'en','Show',5,'2019-11-25 10:34:08',NULL,NULL),(188,'id','Menampilkan',5,'2019-11-25 10:34:08',NULL,NULL),(189,'en','Data',5,'2019-11-25 10:34:22',NULL,NULL),(189,'id','Data',5,'2019-11-25 10:34:22',NULL,NULL),(190,'en','Tour Packages Not Found',5,'2019-12-01 19:14:10',NULL,NULL),(190,'id','Paket Wisata Tidak Ditemukan',5,'2019-12-01 19:14:10',NULL,NULL),(191,'en','The response of those who have felt this tour package',5,'2019-12-05 21:23:44',NULL,NULL),(191,'id','Tanggapan mereka yang telah merasakan paket wisata ini',5,'2019-12-05 21:23:44',NULL,NULL),(192,'en','Foreign Tourists',5,'2019-12-05 21:48:55',NULL,NULL),(192,'id','Wisatawan Mancanegara',5,'2019-12-05 21:48:55',NULL,NULL),(193,'en','Local Tourists',5,'2019-12-05 21:50:24',5,'2019-12-05 22:09:50'),(193,'id','Wisatawan Local',5,'2019-12-05 21:50:24',5,'2019-12-05 22:09:50'),(194,'en','Quantity',5,'2019-12-05 22:13:49',NULL,NULL),(194,'id','Jumlah',5,'2019-12-05 22:13:49',NULL,NULL),(195,'en','Order Minimum',5,'2019-12-05 22:32:24',NULL,NULL),(195,'id','Minimal Pemesanan',5,'2019-12-05 22:32:24',NULL,NULL),(196,'en','Order Maximum',5,'2019-12-05 22:32:54',NULL,NULL),(196,'id','Maksimal Pemesanan',5,'2019-12-05 22:32:54',NULL,NULL),(197,'en','Book Tour Package',5,'2019-12-06 07:25:01',NULL,NULL),(197,'id','Pesan Paket Wisata',5,'2019-12-06 07:25:01',NULL,NULL),(198,'en','must be more than',5,'2019-12-07 23:54:26',5,'2019-12-07 23:56:13'),(198,'id','harus lebih banyak dari',5,'2019-12-07 23:54:26',5,'2019-12-07 23:56:13'),(199,'en','There are no testimonials yet',5,'2019-12-08 00:41:43',NULL,NULL),(199,'id','Belum ada Testimoni',5,'2019-12-08 00:41:43',NULL,NULL),(200,'en','Travel Date',5,'2019-12-08 12:39:37',NULL,NULL),(200,'id','Tanggal Perjalanan',5,'2019-12-08 12:39:37',NULL,NULL),(201,'en','Registration Successful',5,'2019-12-14 18:45:28',NULL,NULL),(201,'id','Pendaftaran Berhasil',5,'2019-12-14 18:45:28',NULL,NULL),(202,'en','Registration failed, please try again later',5,'2019-12-14 18:46:21',5,'2019-12-14 19:02:04'),(202,'id','Pendaftaran gagal, coba beberapa saat lagi',5,'2019-12-14 18:46:21',5,'2019-12-14 19:02:04'),(203,'en','Email must be filled',5,'2019-12-14 22:55:11',NULL,NULL),(203,'id','Email harus diisi',5,'2019-12-14 22:55:11',NULL,NULL),(204,'en','Email and Password must be fielld',5,'2019-12-14 23:36:24',5,'2019-12-14 23:36:57'),(204,'id','Email dan Password harus diisi',5,'2019-12-14 23:36:24',5,'2019-12-14 23:36:57'),(205,'en','Profile',5,'2019-12-16 06:37:59',NULL,NULL),(205,'id','Profil',5,'2019-12-16 06:37:59',NULL,NULL),(206,'en','My Order',5,'2019-12-16 06:40:31',NULL,NULL),(206,'id','Pesanan Saya',5,'2019-12-16 06:40:31',NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `core_user` */

insert  into `core_user`(`user_id`,`user_real_name`,`user_password`,`user_email`,`user_phone`,`user_gender`,`user_birthday`,`user_is_admin`,`user_lang`,`user_last_login`,`user_status`,`user_photo`,`user_desc`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (5,'Riyan Trisna Wibowo','ba4e586503b7cb15e2b54b9729c066ed','riyantrisnawibowo@gmail.com','085729331231','male','2019-09-19',1,'en',NULL,1,'b8b00d86c6bbca1d1a1c20a9499b4051.jpeg','',1,'2019-09-15 18:29:07',5,'2019-12-14 18:42:03'),(6,'Admin','aba0abde803b937400181f5372aeb750','bhiva@bhiva.id','','male','2019-11-04',1,'id',NULL,1,'cedff0e45c2a56709672436a97883c16.png','',5,'2019-11-19 10:35:38',5,'2019-12-14 18:41:44'),(7,'Wahyu Astiani','29c65f781a1068a41f735e1b092546de','wahyuastiani@gmail.com','085729331231','female','2019-12-24',0,'id',NULL,1,'4d66f9fe72a9b3c2ee382fdf5ed02a43.png','',NULL,'2019-12-14 19:45:35',7,'2019-12-17 00:30:45');

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

/*Data for the table `mst_destination` */

insert  into `mst_destination`(`destination_id`,`destination_desloc_id`,`destination_status`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (2,3,1,6,'2019-11-19 10:59:52',6,'2019-12-02 11:09:28'),(3,3,1,6,'2019-11-19 12:35:07',5,'2019-11-21 00:18:18'),(4,3,1,6,'2019-11-19 12:36:29',5,'2019-11-21 00:18:33'),(5,3,1,6,'2019-11-19 12:37:57',5,'2019-11-21 00:16:25'),(6,3,1,6,'2019-11-19 12:38:57',5,'2019-11-21 00:18:52'),(7,3,1,6,'2019-11-19 12:40:01',5,'2019-11-21 00:17:33'),(8,3,1,6,'2019-11-19 12:41:27',5,'2019-11-21 00:19:18'),(9,3,1,6,'2019-11-19 12:43:26',5,'2019-11-21 00:16:37'),(10,3,1,6,'2019-11-19 12:45:43',5,'2019-11-21 00:17:08'),(11,3,1,6,'2019-11-19 13:54:57',6,'2019-12-02 11:08:47'),(12,3,1,6,'2019-11-19 13:56:44',6,'2019-12-06 16:44:50'),(13,3,1,6,'2019-11-19 13:58:12',5,'2019-11-21 00:16:11'),(14,3,1,6,'2019-11-19 13:59:07',6,'2019-12-06 16:14:59'),(15,3,1,6,'2019-11-19 14:00:42',5,'2019-11-25 07:52:36'),(16,3,1,6,'2019-11-19 14:02:19',6,'2019-12-02 11:08:37'),(17,3,1,6,'2019-11-19 14:03:23',5,'2019-11-21 00:16:50'),(18,3,1,6,'2019-11-19 14:04:19',5,'2019-11-21 00:17:46'),(19,3,1,6,'2019-11-19 14:05:08',6,'2019-12-02 11:08:11'),(20,2,1,6,'2019-12-02 13:23:04',5,'2019-12-03 11:42:38'),(21,2,1,6,'2019-12-02 13:24:43',5,'2019-12-03 11:41:49'),(22,2,1,6,'2019-12-02 13:27:12',5,'2019-12-03 11:42:55'),(23,2,1,6,'2019-12-02 13:28:05',6,'2019-12-06 16:44:10'),(24,2,1,6,'2019-12-02 13:29:29',5,'2019-12-12 07:05:31'),(25,2,1,6,'2019-12-02 13:30:12',5,'2019-12-03 11:42:00'),(26,4,1,6,'2019-12-02 13:30:52',6,'2019-12-06 16:43:48'),(27,4,1,6,'2019-12-02 13:31:54',6,'2019-12-06 16:45:41'),(28,4,1,6,'2019-12-02 13:33:21',5,'2019-12-11 23:20:33'),(29,4,1,6,'2019-12-02 13:34:02',6,'2019-12-06 16:45:59');

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

insert  into `mst_destination_img`(`destinationimg_destination_id`,`destinationimg_order`,`destinationimg_img`) values (13,1,'42282e2e23c88b23b26928cce66741b6.jpeg'),(13,2,NULL),(13,3,NULL),(13,4,NULL),(5,1,'1fe502727bafe1c53c27c78e14ac1d49.jpeg'),(5,2,NULL),(5,3,NULL),(5,4,NULL),(9,1,'0f45604339243342d905d9b887e281ab.jpeg'),(9,2,NULL),(9,3,NULL),(9,4,NULL),(17,1,'6f169d370fea4ff9543c9ef9b8432e98.jpeg'),(17,2,NULL),(17,3,NULL),(17,4,NULL),(10,1,'dc4d93853ae5deca1f6037a61c9c2f6e.jpeg'),(10,2,NULL),(10,3,NULL),(10,4,NULL),(7,1,'6a8beea9e450101d67a9c86dc774221a.jpeg'),(7,2,NULL),(7,3,NULL),(7,4,NULL),(18,1,'777f9e08cd19d8ee38bf44d7f1efc639.jpeg'),(18,2,NULL),(18,3,NULL),(18,4,NULL),(3,1,'3371ef2b3c6033fbd36ab54edb77a748.jpeg'),(3,2,NULL),(3,3,NULL),(3,4,NULL),(4,1,'268dbcd79a4acb5a8b1556026bdf7ea6.jpeg'),(4,2,NULL),(4,3,NULL),(4,4,NULL),(6,1,'dba495bbf4d5d14d1fd56b297e7dd1e8.jpeg'),(6,2,NULL),(6,3,NULL),(6,4,NULL),(14,1,'97486a2b8d930787fbb52dcefdc4baf5.jpeg'),(14,2,NULL),(14,3,NULL),(14,4,NULL),(8,1,'40af5052732323781b8371b4fa30e8ad.jpeg'),(8,2,NULL),(8,3,NULL),(8,4,NULL),(12,1,'90034d2b3929b569c5921fe3c26ae149.jpeg'),(12,2,NULL),(12,3,NULL),(12,4,NULL),(15,1,'46826077d2ee16911e49fa590d0725bc.jpeg'),(15,2,NULL),(15,3,NULL),(15,4,NULL),(19,1,'3527df5ce349a4ffc00e4b5b1fec44f0.jpeg'),(19,2,NULL),(19,3,NULL),(19,4,NULL),(16,1,'21adb4f0a4494f8671749bd7c2d91a68.jpeg'),(16,2,NULL),(16,3,NULL),(16,4,NULL),(11,1,'8e68a8214e36b97bf89d6c63d2413902.jpeg'),(11,2,NULL),(11,3,NULL),(11,4,NULL),(2,1,'5789b545177bb863019a39967e8efd6b.jpeg'),(2,2,NULL),(2,3,NULL),(2,4,NULL),(21,1,'f93f7d9048f19ef0841754590542c860.png'),(21,2,NULL),(21,3,NULL),(21,4,NULL),(25,1,'a649ecf56201c07c1688775d7232103a.png'),(25,2,NULL),(25,3,NULL),(25,4,NULL),(23,1,'0d0946bd9adea404324175300bbc098a.png'),(23,2,NULL),(23,3,NULL),(23,4,NULL),(20,1,'9446d03ef373bf5fc6663ab7a7fab534.png'),(20,2,NULL),(20,3,NULL),(20,4,NULL),(22,1,'07b8e12d585028f549ed8a76f61cddaf.png'),(22,2,NULL),(22,3,NULL),(22,4,NULL),(29,1,'662a55a1c9e0b5092a4eebbf1fd247f3.png'),(29,2,NULL),(29,3,NULL),(29,4,NULL),(26,1,'73352fceb749d2375b28abd54dc81900.png'),(26,2,NULL),(26,3,NULL),(26,4,NULL),(27,1,'60175b34cf8cc210b8d79df392dd71d0.png'),(27,2,NULL),(27,3,NULL),(27,4,NULL),(28,1,'8bc668dc6f5f2fe6f68b9a65bffb7476.jpeg'),(28,2,NULL),(28,3,NULL),(28,4,NULL),(24,1,'6e378e5297f816bda73211cccb495088.jpeg'),(24,2,NULL),(24,3,NULL),(24,4,NULL);

/*Table structure for table `mst_destination_text` */

DROP TABLE IF EXISTS `mst_destination_text`;

CREATE TABLE `mst_destination_text` (
  `destinationtext_destination_id` int(11) NOT NULL,
  `destinationtext_lang` varchar(5) NOT NULL,
  `destinationtext_name` varchar(250) DEFAULT NULL,
  `destinationtext_text` text,
  PRIMARY KEY (`destinationtext_destination_id`,`destinationtext_lang`),
  KEY `desttext_destination_id` (`destinationtext_destination_id`),
  KEY `desttext_lang` (`destinationtext_lang`),
  CONSTRAINT `mst_destination_text_ibfk_1` FOREIGN KEY (`destinationtext_destination_id`) REFERENCES `mst_destination` (`destination_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_destination_text` */

insert  into `mst_destination_text`(`destinationtext_destination_id`,`destinationtext_lang`,`destinationtext_name`,`destinationtext_text`) values (2,'en','Borobudur Temple','<p><i>Borobudur temple is located in Borobudur village, Magelang Regency. This temple is a remarkable relic of Buddhism. The shape of Borobudur temple resembles a lotus flower, based on local legends around Borobudur used to be a lake so the temple itself looks like a lotus flower amid the lake. In Borobudur temple there are 32 lion statues, functioning as a temple gate, but now the number is incomplete because many of them are damaged. In Buddhism, the lion is a symbol of the Buddha. Lions are emblems of the strength, courage, victory, and patron of Buddhists. The lion also became a symbol of strength to expel evil influences and become guardian of the Holiness of Borobudur Temple.</i></p>'),(2,'id','Candi Borobudur','<p>Candi Borobudur terletak di Desa Borobudur, Kabupaten Magelang. Candi ini merupakan peninggalan agama Buddha yang luar biasa besar dan megah. Bentuk Candi Borobudur menyerupai bunga teratai, bberdasarkan legenda setempat disekeliling Borobudurb duluny adalah danau sehingga candi itu sendiri terlihat seperti bunga teratai ditengah danau. Di Candi Borobudur terdapat 32 buah arca singa, berfungsi sebagai pebjaga gerbang candi, akan tetapi kini jumlahnya tidak lengkap lagi dikarenakan banyak diantaranya yang rusak. Dalam agama Buddha, singa adalah simbol dari Sang Buddha. Singa adalah lambang kekuatan, keberanian, kemenangan, dan pelindung umat Buddha. Singa juga menjadi lambang kekuatan untuk mengusir pengaruh jahat sekaligus menjadi penjaga kesucian Candi Borobudur.</p>'),(3,'en','Prambanan Temple','<p class=\"MsoListParagraphCxSpFirst\" style=\"text-align:justify;line-height:150%\"><i>Candi Prambanan is the largest Hindu temple in the island of Java located in the village of Karangasem, Sleman Regency. This temple is called Prambanan Temple because it is located in the Prambanan area, while the other name of this temple is Loro Jonggrang temple. The name Loro Jonggrang was taken from the local legend about a princess named Loro Jonggrang, the daughter of Prabu Boko who rejected the pinning of Bandung Bondowoso. Durga Mahisasuramardhini statue found in the temple is known as Loro Jonggrang. According to the Siwagrha inscription found in the west of the temple that reads in 856 A.D., issued by Rakai Pikatan, it is known that the original name of Prambanan temple is Shiva Grha temple which means \"Shiva\'s house\".</i></p>'),(3,'id','Candi Prambanan','<p>Candi Prambanan merupakan candi Hindu terbesar di pulau Jawa yang terletak di Desa Karangasem, Kabupaten Sleman. Candi ini dinamakan Candi Prambanan karena letaknya di daerah Prambanan, sedangkan nama lain dari candi ini adalah Candi Loro Jonggrang. Nama Loro Jonggrang diambil dari legenda setempat tentang seorang putri yang bernama Loro Jonggrang, putri Prabu Boko yang menolak pinangan Bandung Bondowoso. Arca Durga Mahisasuramardhini yang terdapat dalam candi tersebut dikenal dengan nama Loro Jonggrang. Menurut Prasasti Siwagrha yang ditemukan disebelah barat candi yang bertuliskan tahun 856 M, dikeluarkan oelh Rakai Pikatan, diketahui bahwa nama asli Candi Prambanan adalah Candi Siwa Grha yang artinya “Rumah Dewa Siwa”.</p>'),(4,'en','Ratu Boko Temple','<p><i>Ratu Boko Temple is an archaeological site in the area of Dawung (Bokoharjo village) and Sumberwatu (Sambirejo village), Sleman Regency. Based on the placement patterns of the site is the former keratin or King\'s Palace. Judging from the layout, the building on the Ratu Boko site is grouped into 3 groups: the Western Group consisting of the main gate group, the combustion temple, the white Stone Temple, the water shelter, Paseban, the rest of the structure of the building, Talud and Fence. The Eastern group consists of Lanang caves, Wadon caves, ponds, stairs, and ruins of the stupa. While the southeast group consists of Batur Pendopo and Batur Pringgitan surrounded by stone fence with three gates as an entrance, miniature temple, and bathing pond.</i></p>'),(4,'id','Candi Ratu Boko','<p>Candi Ratu Boko adalah situs purbakala yang berada di wilayah Dusun Dawung (Desa Bokoharjo) dan Dusun Sumberwatu (Desa Sambirejo), Kabupaten Sleman. Berdasarkan pola peletakan sisa – sisa bangunan situs ini merupakan bekas keratin atau istana raja. Dilihat dari tata letaknya, bangunan di situs Ratu Boko dikelompokkan menjadi 3 kelompok : Kelompok Barat yang terdiri dari kelompok Gapura Utama, Candi Pembakaran, Candi Batu Putih, kolam penampungan air, Paseban, sisa struktur bangunan berumpak, talud dan pagar. Kelompok Timur yang terdiri dari Goa Lanang, Goa Wadon, kolam, tangga, dan reruntuhan stupa. Sedangkan kelompok tenggara terdiri dari Batur Pendopo dan batur pringgitan yang dikelilingi pagar batu dengan tiga gapura sebagai pintu masuk, candi miniatur, dan kolam pemandian.</p>'),(5,'en','Ijo Temple','<p><i>Ijo temple is located in Groyokan, Sleman regency. It is located on the west slope of Gumuk Ijo Hill, south of Ratu Boko Temple. Ijo temple is the most popular temple in Prambanan temple-other temples in the area. Based on the shape of the building it is estimated built around the century VIII – X M. Overall the temple has two types of buildings, namely the roof building and the building is not roofed.</i></p>'),(5,'id','Candi Ijo','<p class=\"MsoListParagraph\" style=\"text-align:justify;line-height:150%\">Candi Ijo terletak di Dusun Groyokan, Kabupaten Sleman. Letaknya di lereng barat bukit Gumuk Ijo, sebelah selatan Candi Ratu Boko. Candi Ijo merupakan candi yang letaknya paling tinggi dinatara candi – candi lain di daerah Prambanan. Berdasarkan bentuk bangunannya candi ini perkirakan dibangun sekitar abad VIII – X M. Secara keseluruhan candi ini memiliki dua jenis bangunan, yaitu bangunan beratap dan bangunan tidak beratap.</p>'),(6,'en','Sambisari Temple','<p><i>Sambisari Temple is a Hindu temple located in Sambisari village, Purwomartani subdistrict, Kalasan District, Sleman Regency. This temple was originally buried in the soil of 6.5 meters thick which was predicted to be due to the eruption of Mount Merapi in the early XI century and was accidentally discovered by farmers while the rice paddies in the year 1966.</i></p>'),(6,'id','Candi Sambisari','<p>Candi Sambisari merupakan candi Hindu yang terletak di Desa Sambisari, Kelurahan Purwomartani, Kecamatan Kalasan, Kabupaten Sleman. Candi ini awalnya terkubur didalam tanah setebal 6,5 meter yang diperkirakan akibat letusan gunung merapi pada awal abad XI dan secara tidak sengaja ditemukan oleh petani ketika sedang mencangkul sawah pada tahun 1966.</p>'),(7,'en','Parangtritis Beach','<p><i>Parangtritis Beach is famous amongst tourists because it has the legend of Ratu Kidul as The queen of the South Sea, besides the beauty of the beach that is the most widespread in Yogyakarta can’t be doubtful. Activities that can be done at Parangtritis Beach surround the beach using an ATV or Delman motorcycle, play at the edge of the waves, play kites, or just sit back and enjoy the atmosphere of the enchanting Parangtritis beach accompanied by snack corn roasted or heavy food such as seafood.</i></p>'),(7,'id','Pantai Parangtritis','<p>Pantai Parangtritis terkenal diantara para wisatawan karena memiliki legenda Ratu Kidul sebagai ratu laut selatan, selain itu keindahan pantai yang merupakan pantai paling luas di Yogyakarta ini tidak bisa bisa diragukan lagi. Kegiatan yang dapat dilakukan di Pantai Parangtritis yaitu mengelilingi pantai dengan menggunakan motor ATV ataupun Delman, bermain di pinggir ombak, bermain layangan, atau sekedar duduk-duduk sambil menikmati suasana Pantai Parangtritis yang mempesona ditemani cemilan Jagung Bakar atau makanan berat seperti seafood.</p>'),(8,'en','Wediombo Beach','<p><i><span style=\"font-size: 12pt; line-height: 115%; font-family: \"Times New Roman\", serif;\">Wediombo Beach is one of the popular beaches for beach\r\ntourism lovers because of its beautiful coastal structure coupled with a\r\nnatural pool with a depth of 1.5 meters that attracts tourists. Wediombo Beach\r\nis also known as a snorkeling spot with a variety of beautiful sea creatures\r\nand attracts visitors.</span></i><br></p>'),(8,'id','Pantai Wediombo','<p><span style=\"font-size: 12pt; line-height: 115%; font-family: \"Times New Roman\", serif;\">Pantai Wediombo\r\nmerupakan salah satu pantai yang populoer bagi para pecinta wisata pantai\r\ndikarenakan struktur pantainya yang cantik dan apik ditambah dengan adanya\r\nkolam alami  dengan kedalaman 1,5 meter\r\nyang semakin menarik wisatawan. Selain itu Pantai Wediombo juga dikjenal\r\nsebagai spot snorkeling dengan berbagai biota laut yang cantik dan memikat\r\npengunjung.</span><br></p>'),(9,'en','Indrayanti Beach','<p><i>The name of Indrayanti Beach is taken from the name of Indrayanti restaurant located not far from the beach. This restaurant is quite known to visitors, and seems to be a landmark of this place. Along the coast, there is a series of beach gazebos and umbrellas that can be used for rest and enjoy the atmosphere and scenery. Other facilities such as toilets and bathrooms are pretty much available. The beach also offers a waterskiing jetskiing rental and a children\'s playground. The organizer here actively maintains and does not hesitate to sanction the visitors who dispose of garbage.</i></p>'),(9,'id','Pantai Indrayanti','<p>Nama Pantai Indrayanti ini di ambil dari nama restoran Indrayanti yang berada tidak jauh dari pantai. Restoran ini cukup dikenal pengunjung, dan seolah menjadi landmark tempat ini. Di sepanjang pantai terdapat rangkaian gazebo dan payung pantai yang bisa digunakan untuk istirahat dan menikmati suasana dan pemandangan sekitar. Fasilitas lainnya seperti toilet dan kamar mandi cukup banyak tersedia. Pantai ini juga menawarkan penyewaan jetski dan juga tempat bermain anak. Pengelola disini aktif memelihara dan tidak segan memberikan sanksi pada pengunjung yang membuang sampah sembarangan.</p>'),(10,'en','Malioboro ','<p><font face=\"Times New Roman, serif\"><i><br></i></font></p><p><font face=\"Times New Roman, serif\"><i>Malioboro is a mandatory tourist attraction for every visitor who comes to Yogyakarta city. This place is also called as a shopping center because of all the food, souvenirs, or daily necessities in the area. In Malioboro, there is a famous traditional market namely the Beringharjo market. Malioboro is where the street art and art addicts gather every day, various attractions are offered along the area such as traditional music games such as Angklung combined with modern music. Not only that, currently the local government has set every Tuesday wage in the Javanese calendar of Malioboro area is forbidden to be passed by motor vehicles, adding a plus value for tourists. The viscosity of the past atmosphere is more pronounced with vehicles passing by only pedicab or bicycles that are certainly also rented to visitors who come.</i></font></p><p><font face=\"Times New Roman, serif\"><i><br></i></font></p><p><font face=\"Times New Roman, serif\"><i>Malioboro is a mandatory tourist attraction for every visitor who comes to Yogyakarta city. This place is also called as a shopping center because of all the food, souvenirs, or daily necessities in the area. In Malioboro, there is a famous traditional market namely the Beringharjo market. Malioboro is where the street art and art addicts gather every day, various attractions are offered along the area such as traditional music games such as Angklung combined with modern music. Not only that, currently the local government has set every Tuesday wage in the Javanese calendar of Malioboro area is forbidden to be passed by motor vehicles, adding a plus value for tourists. The viscosity of the past atmosphere is more pronounced with vehicles passing by only pedicab or bicycles that are certainly also rented to visitors who come.</i></font></p>'),(10,'id','Malioboro','<p><font face=\"Times New Roman, serif\">Malioboro adalah atraksi wisata wajib bagi setiap pengunjung yang datang ke kota Yogyakarta. Tempat ini disebut juga sebagai shopping center karena semua makanan, oleh – oleh ataupun kebutuhan sehari – hari ada di kawasan ini. Di malioboro terdapat sebuah pasar tradisional yang terkenal yaitu Pasar Beringharjo. Malioboro adalah tempat para street art dan pecandu seni berkumpul setiap harinya, beragam atraksi ditawarkan di sepanjang kawasan ini seperti permainan musik tradisonal seperti angklung yang dipadukan dengan musik modern. Tak hanya itu, saat ini pemerintah setempat telah menetapkan setiap selasa wage dalam penanggalan jawa kawasan Malioboro dilarang dilewati oleh kendaraan bermotor, semakin menambah nilai plus bagi wisatawan. Kekentalan suasana masa lampau semakin terasa dengan kendaraan yang lewat hanya becak ataupun sepeda yang tentunya juga disewakan kepada pengunjung yang datang. </font><br></p>'),(11,'en','Fort Vredeburg Museum','<p>Fort Vredeburg Museum was established in 1760 by Sri Sultan Hamengku Buwono I at the request of the Dutch. After the construction of the fortress named \"Rustenberg\" which means the fortress of rest. In the year 1967 in Yogyakarta, there was a devastating natural disaster of earthquakes that made some of the fortress became badly damaged. Finally, the fortress was repaired and renamed to \"Vredeburg\" meaning Fortress of peace, so that the relationship between the Netherlands and the palace did not attack each other.</p>'),(11,'id','Museum Benteng Vrederburgh','<p>Museum Benteng Vredeburg didirikan pada tahun 1760 oleh Sri Sultan Hamengku Buwono I atas permintaan Belanda. Setelah selesainya pembangunan Benteng yang diberi nama “Rustenberg” yang artinya benteng peristirahatan. Pada tahun ke 1967 di Yogyakarta terjadi bencana alam gempa bumi yang sangat dahsyat sehingga menjadikan sebagian benteng tersebut menjadi rusak parah. Akhirnya benteng tersebut diperbaiki dan diubah namanya menjadi “Vredeburg” yang artinya benteng perdamaian, agar hubungan antara Belanda dan Keraton tidak saling menyerang.</p>'),(12,'en','Yogyakarta Sultan Palace','<p>The palace which is the symbol of Yogyakarta city still stands firmly in the heart of the city with its traditions and culture. Bangsal Pagelaran which is the main building of Keraton that the entrance is near the North Square of Yogyakarta. Pagelaran is the front-most area in the past as a place for courtiers facing the Sultan when royal ceremonies and buildings where there are gates are waiting for guests to overlook Sri Sultan.</p>'),(12,'id','Keraton Yogyakarta','<p>Keraton yang menjadi simbol kota Yogyakarta ini masih berdiri kokoh di jantung kota dengan tradisi dan budayanya. Bangsal Pagelaran yang merupakan bangunan utama Keraton yang pintu masuknya berada di dekat alun – alun utara Yoyakarta. Pagelaran merupakan area paling depan yang pada masa lalu sebagai tempat para abdi dalem menghadap Sultan ketika upacara-upacara Kerajaan dan bangunan di mana terdapat gerbang-gerbang tersebut merupakan tempat menunggu tamu-tamu untuk menghadap Sri Sultan.</p>'),(13,'en','Gedhe Kauman Mosque','<p>Masjid Gedhe is located close to Keraton which is more than 200 years old and has a strong palace nuance. In 1867 there was a major earthquake that brought down the original building of the porch of Gedhe Kauman Mosque which was later remodeled with special material one of the ground floor mosque made of stone today has been replaced by marble from Italy. On the left behind Mihrab there is a maksura made of square teak wood with a higher marble floor and equipped with a spear. Maksura served as a place of security of the king when Sri Sultan was praying in congregation in Masjid Gedhe Kauman. </p>'),(13,'id','Masjid Gedhe Kauman','<p>Masjid Gedhe terletak tidak jauh dari Keraton yang berumur lebih dari 200 tahun serta memilikii nuansa keratin yang kental. Pada tahun 1867 terjadi gempa besar yang meruntuhkan bangunan asli serambi Masjid Gedhe Kauman yang kemudian direnovasi kembali dengan material khusus salah satunya lantai dasar masjid yang terbuat dari batu kali kini telah diganti dengan marmer dari Italia. Di samping kiri belakang mihrab terdapat maksura yang terbuat dari kayu jati bujur sangkar dengan lantai marmer yang lebih tinggi serta dilengkapi dengan tombak. Maksura difungsikan sebagai tempat pengamanan raja apabila Sri Sultan berkenan sholat berjamaah di Masjid Gedhe Kauman. </p>'),(14,'en','Taman Sari Watercastle','<p>Taman Sari is a Portuguese-Javanese building that was used by the Sultan as a bathing place and the private place of the king can be seen a pot used by the king\'s wife to reflect and the closet store King\'s clothes. Besides, there is a mosque built underground and used as a protection bunker for the Sultanate elite, when the Sultanate suffered a dangerous attack. The mosque is shaped in two circular levels up to 360 degrees, the central part is perforated and the design produces artistic arrangement. When the priest leads prayers, the voice of the Muslim priest is heard all over the room. The thickness of the walls of the underground mosque that is approximately 1.25 meters is made of whitewashed which is glued using natural materials such as egg whites.</p>'),(14,'id','Istana Air Taman Sari','<p>Taman sari merupakan bangunan bernuansa Portugis –Jawa yang dulunya digunakan oleh sultan sebagai tempat pemandian dan tempat pribadi raja bisa dilihat sebuah periuk yang digunakan oleh istri raja untuk bercermin dan lemari menyimpan pakaian raja. Selain itu terdapat mesjid yang dibangun di bawah tanah sekaligus digunakan sebagai bungker perlindungan bagi kesultanan, ketika kesultanan mengalami serangan yang membahayakan. Masjid tersebut berbentuk dua tingkat melingkar hingga 360 derajat, bagian tengah berlubang dan desain menghasilkan tata artistik. Ketika imam memimpin sholat, suara imam bakalterdengar ke seluruh penjuru ruangan. Ketebalan dari tembok masjid bawah tanah yang kurang lebih sekitar 1,25 meter ini terbuat dari batubata yang direkatkan dengan menggunakan bahan alami seperti putih telur.</p>'),(15,'en','Alun - Alun Yogyakarta','<p>Yogyakarta has 2 Alun-Alun, North alun - alun (Lor) and South alun - alun (Kidul). At night the Alun-Alun Kidul offers an interesting night tour. Surrounded by colorful colorful light vehichles and street food vendors in the square is a unique attraction for visitors. The most popular activity is the masangin that runs between the two Banyan and closed eyes. According to a myth believed to be hereditary, for anyone who manages to do Masangin, the person is clean and his petition will be granted. Although many people do not believe but still many visit this place to try it.</p>'),(15,'id','Alun - Alun Yogyakarta','<p>Yogyakarta memiliki 2 alun – alun, alun – alun utara (Lor) dan alun – alun selatan (Kidul). Pada malam hari alun – alun Kidul menawarkan wisata malam yang menarik. Dikelilingi oleh kereta hias dengan lampu warna – warni serta pedagang makanan kaki lima yang ada di alun – alun ini menjadi daya tarik tersendiri bagi pengunjung. Aktivitas yang paling populer adalah masangin yaitu berjalan di antara dua beringin dengan mata tertutup. Menurut mitos yang dipercaya turun temurun, bagi siapa saja yang berhasil melakukan masangin maka orang tersebut hatinya bersih dan permohonannya akan terkabul. Walaupun sudah banyak orang yang tidak percaya namun tetap saja banyak yang mengunjungi tempat ini untuk mencobanya.</p>'),(16,'en','Merapi Volcano Museum','<p>Merapi volcano Museum is used as a means of education that is recreative and educative about Mount Merapi and other sources of disaster. The shape of the building is unique, trapezoid-shaped with one side of the summit to form a triangle. Visitors will be greeted by a replica of Merapi volcano with sound that rumbles right when entering the museum. In this museum, there are volcano eruption type display, rock from Mount Merapi since 1930, collection of remnants of the eruption from 2006 to the collection of photos of Mount Merapi from time to time.</p>'),(16,'id','Museum Gunung Merapi','<p>Museum Gunung Merapi ini dijadikan sebagai sarana pendidikan yang bersifat rekreatif dan edukatif tentang Gunung Merapi dan sumber bencana lainnya. Bentuk bangunannya unik, berbentuk trapesium dengan salah satu sisi puncaknya mengerucut membentuk segitiga. Pengunjung akan disambut oleh replika gunung merapi dengan suara yang bergemuruh tepat ketika memasuki museum. Di museum ini terdapat display tipe letusan gunung api, batuan dari Gunung Merapi sejak tahun 1930, koleksi benda-benda sisa letusan tahun 2006 hingga koleksi foto-foto Gunung Merapi dari zaman ke zaman. </p>'),(17,'en','Jomblang Cave','<p>Jomblang Cave, in Pacarejo village, Semanu District. Single Rope Technique (SRT) is required to enter this cave. SRT is a technique that is used to descend the vertical cave by using one rope as the path used for the road up and down the vertical place. In this cave, there is a gap from the sun above that add to the beauty of the cave.</p>'),(17,'id','Goa Jomblang','<p>Goa Jomblang, di Desa Pacarejo, Kecamatan Semanu. Dibutuhkan kemampuan melakukan Single Rope Technique ( SRT ) untuk memasuki goa ini. SRT merupakan teknik yang baku digunakan untuk menuruni goa vertikal dengan memakai satu tali sebagai lintasan yang dipakai untuk jalan menaiki dan menuruni tempat yang vertikal.di goa ini terdapat celah dari sinar matahari diatasnya yang menambah keindahan goa.</p>'),(18,'en','Pindul Cave','<p>Pindul Cave, one of the caves which is a series of 7 caves with an underground river that exists in the village of Bejiharjo, Karangmojo, offers activities to walk the cave through a river flowing inside. For approximately 45-60 minutes The tourists will be invited to the river using buoy tires. The adventure that combines body rafting and caving activities is known as cave tubing. The equipment needed is only a life vest and headlamp, which is already provided by the organizer. Very quiet river streams make this activity safe by anyone, from children to adults. A guide tells the origin of the naming of Pindul Cave. According to legend, a man named Joko Singlulung sought his father. After exploring dense forests, mountains, and rivers, Joko Singlulung entered the caves in Bejiharjo. When entering one of the last cave Joko Singlulung bumped rocks, so the cave is called Pindul Cave which is derived from the word “pipi gebendul” or cheek bump.</p>'),(18,'id','Goa Pindul','<p>Goa Pindul, salah satu goa yang merupakan rangkaian dari 7 goa dengan aliran sungai bawah tanah yang ada di Desa Bejiharjo, Karangmojo, menawarkan kegiatan menyusuri goa melalui sungai yang mengalir didalamnya. Selama kurang lebih 45 - 60 menit wisatawan akan diajak menyusuri sungai menggunakan ban pelampung. Petualangan yang memadukan aktivitas body rafting dan caving ini dikenal dengan istilah cave tubing. Peralatan yang dibutuhkan hanyalah ban pelampung, life vest, serta head lamp yang semuanya sudah disediakan oleh pengelola. Aliran sungai yang sangat tenang menjadikan aktivitas ini aman dilakukan oleh siapapun, mulai dari anak-anak hingga orang dewasa. seorang pemandu bercerita tentang asal-usul penamaan Goa Pindul. Menurut legenda ada seorang yang bernama Joko Singlulung mencari ayahnya. Setelah menjelajahi hutan lebat, gunung, dan sungai, Joko Singlulung pun memasuki goa-goa yang ada di Bejiharjo. Saat masuk ke salah satu goa mendadak Joko Singlulung terbentur batu, sehingga goa tersebut dinamakan Goa Pindul yang berasal dari kata “pipi gebendul” atau pipi terbentur.<br></p>'),(19,'en','Fruit Garden Mangunan','<p>Fruit Garden Mangunan is located in Mangunan, Dlingo Sub-district, Bantul Regency. This location is about 15 km from the capital of Bantul Regency and 35 km from the city center of Yogyakarta. At a height of approximately 200 MDPL, this place is also dubbed as the land above the clouds. The orchard was built in 2003 on a land area of 23 hectares. With this vast land, the fruit Garden of Mangunan farm is planted with many trees such as mango, rambutan, oranges, Durian, mangosteen and many more.</p>'),(19,'id','Kebun Buah Mangunan','<p>Kebun Buah mangunan terletak di Mangunan, Kecamatan Dlingo, Kabupaten Bantul. Lokasi ini berjarak sekitar 15 km dari ibukota Kabupaten Bantul dan 35 km dari pusat kota Yogyakarta. Berada di ketinggian kurang lebih 200 mdpl, membuat tempat ini pun dijuluki sebagai negeri diatas awan. Kebun buah ini dibangun pada tahun 2003 di atas tanah seluas 23 hektar. Dengan tanah seluas ini membuat kebun buah mangunan ditanami banyak sekali pohon seperti mangga, rambutan, jeruk, durian, manggis dan masih banyak lagi. </p>'),(20,'en','Lawang Sewu','<p><span style=\"font-size: 1rem;\">Lawang Sewu, located in Tugu Muda Roundabout was the office of the Nederlands-Indische Spoorweg Maatschappij (NIS), one of the railroad companies in the Dutch East Indies which was built in 1904 – 1907, then the headquarters of PT KAI. The architecture is tailored to the tropical climate in Indonesia, so this building has many large doors that aim for the circulation and air conditioning of natural air. The number of the door blocks itself is not 1000 but 429, with a doorway numbering more than 1200 because some doors have two door leaves, even four doors.</span><br></p><p>In addition to the magnificent architecture of the building, another thing that can spoil the tourists is the wall decoration stained glass that is under the dome of the main building, when tourists come during the day, the sunlight rays from outside the building will be Embellish this glass ornament with a touch of ornament colorful. This beautiful stained glass ornament has a height of more than 2 meters and divided into 4 large panels, each has its own story and meaning that focuses on the prosperity and natural beauty of Semarang and Java.</p><p>Not only known as historical or mystical tourism, lawang Sewu is also one of the popular places for couples for pre-wedding photographs.</p><div><br></div>'),(20,'id','Lawang Sewu','<p>Lawang Sewu yang terletak di bundaran Tugu Muda dulunya adalah kantor Nederlands-Indische Spoorweg Maatschappij (NIS), salah satu perusahaan kereta api di Hindia Belanda yang dibangun pada tahun 1904 – 1907, kemudian pernah menjadi markas PT KAI. Arsitekturnya disesuaikan dengan iklim tropis di Indonesia, oleh sebab itu bangunan ini memiliki banyak pintu berukuran besar yang bertujuan untuk sirkulasi dan penyejuk udara alami. Jumlah blok pintunya sendiri sebenarnya tak mencapai seribu tapi 429, dengan daun pintu yang berjumlah lebih dari 1200 dikarenakan beberapa pintu memiliki dua daun pintu, bahkan empat daun pintu.</p><p>Selain arsitektur bangunannya yang megah, hal lain yang dapat memanjakan mata wisatawan adalah hiasan dinding kaca patri yang berada di bawah kubah gedung utama, apabila wisatawan datang pada siang hari, semburat cahaya matahari dari luar bangunan akan memperindah hiasan kaca ini dengan sentuhan ornamen warna - warni. Hiasan kaca patri yang cantik ini memiliki tinggi lebih dari 2 meter dan terbagi dalam 4 panel besar, Masing-masing memiliki cerita dan makna tersendiri yang berfokus kepada kemakmuran dan keindahan alam Semarang dan Jawa.</p><p>Tidak hanya dikenal sebagai wisata sejarah atau mistis saja, lawang sewu juga menjadi salah satu tempat popular bagi pasangan untuk foto pra-wedding.</p><div><br></div>'),(21,'en',' Sam Poo Kong','<p>Sam Poo Kong is a temple dominated by red color located in Gedong Batu, Simongan, Semarang. This temple is a witness on the journey of the Islamic Admiral of China with the name Haji Mahmud Shams or better known as Admiral Cheng Ho. He is a very famous Chinese sailor and explorer, and is exploring the began by being sent in 1405 by the Ming dynasty as the Ambassador of Peace to all the kingdoms of the world and ending the voyage in the year 1433. </p><p>Cheng Ho anchored in the Simongan beach of Semarang due to one of the ship\'s agents, Ong Keng Ho, has a hard illness. Admiral Cheng Ho resumed his travels while several crew members including his clerks remained in the area known today as Sam Poo Kong Temple. The story of Cheng Ho is found in reliefs that are divided into 10 parts of the story with a prescription consisting of three languages: Bahasa Indonesia, English and Chinese. According to the inscription, Admiral Cheng Ho has visited Semarang twice, 1401 and 1416 BCE. The core building of Sam Poo Kong temple in Batu Cave which is believed to be the landing place of Admiral Cheng Ho and his troops when visited Java island in the 1400 \'s. The original cave covered in a landslide in the 1700 \'s was later rebuilt by the locals in tribute to Cheng Ho. One of the charms of this temple in addition to its history of magnificent buildings is the presence of trees located on the left and right side of the main shrine known as the chain tree because its roots are like a chain of vessels. The root shape of this tree holes like chains. According to the recognition of the tour guide around this tree is only found in Sam Poo Kong Shrine. It is said that the tree was brought from mainland China as an alternative to the vessel mine which signifies the root of this tree has a good enough power to be used on a vessel.</p><p>Sam Poo Kong Temple is not only known as a pilgrimage or historical tour, but also as a cultural tour. One of the famous attractions is the Sam Poo Kong Festival which is held regularly every year in August to recall the history of Admiral Cheng Ho with various events such as the Cheng Ho Night Fest is an evening of art performance, a ritual, the procession of Dewa statue as the highlight of Cheng Ho Festival, and the culinary bazaar typical of Semarang. In addition to the ordinary day, this temple also rents out Chinese clothes for visitors.</p><div><br></div>'),(21,'id',' Sam Poo Kong','<p>Sam Poo Kong adalah sebuah kuil yang di dominasi oleh warna merah yang terletak di Gedong Batu, Simongan Semarang. Kuil ini merupakan saksi atas perjalanan Laksamana Tiongkok beragama Islam ber nama Haji Mahmud Shams atau lebih dikenal dengan Laksamana Cheng Ho. Beliau adalah seorang pelaut dan penjelajah dari Tiongkok yang sangat terkenal, dan melakukan penjelajahan yang bermula dengan diutus pada tahun 1405 oleh Dinasti Ming sebagai duta perdamaian ke semua kerajaan di dunia dan mengakhiri pelayaran pada tahun 1433. </p><p>Cheng Ho berlabuh di Pantai Simongan Semarang dikarenakan salah satu juru mudi kapal, Ong Keng Ho, sakit keras. Laksamana Cheng Ho kembali melanjutkan perjalanan sedangkan beberapa awak kapal termasuk juru mudinya tetap tinggal di kawasan yang saat ini dikenal dengan nama Kelenteng Sam Poo Kong. Kisah Cheng Ho terdapat pada relief – relief yang terbagi menjadi 10 bagian cerita dengan isnkripsi yang terdiri dari tiga bahasa, yaitu bahasa Indonesia, Inggris dan Cina.  Menurut inskripsi tersebut, Laksamana Cheng Ho telah mengunjungi Semarang sebanyak dua kali, 1401 dan 1416 SM. Bangunan inti dari kelenteng Sam Poo Kong adalah Goa Batu yang dipercaya sebagai tempat mendarat Laksamana Cheng Ho beserta pasukannya ketika mengunjungi Pulau Jawa di tahun 1400-an. Goa asli tertutup longsor pada tahun 1700-an kemudian dibangun kembali oleh penduduk setempat sebagai penghormatan kepada Cheng Ho. Salah satu daya tarik dari Kelenteng ini selain sejarahserta bangunannya yang megah adalah adanya pohon yang terletak di sisi kiri dan kanan dari klenteng utama yang dikenal dengan Pohon Rantai dikarenakan akarnya mirip rantai kapal. Bentuk akar pohon ini berlubang-lubang seperti rantai. Mmenurut pengakuan pemandu wisata sekitar pohon ini hanya terdapat di klenteng Sam Poo Kong. Kabarnya pohon ini dibawa dari daratan China sebagai alternatif pengganti tambang kapal yang menandakan akar pohon ini memiliki kekuatan yang cukup bagus untuk digunakan pada sebuah kapal.</p><p>Klenteng Sam Poo Kong tidak hanya dikenal sebagai wisata ziarah atau sejarah saja, tapi juga sebagai wisata budaya. Salah satu atraksi yang terkenal adalah Festival Sam Poo Kong yang diadakan rutin setiap tahun pada bulan agustus untuk mengingat kembali sejarah perjalanan Laksama Cheng Ho dengan berbagai macam acara seperti Cheng Ho Night Fest yang merupakan malam pagelaran kesenian, ritual, arak-arakan Patung Dewa sebagai Puncak acara Festival Cheng Ho, , dan bazar kuliner khas Semarang. Selain itu pada hari biasa kelenteng ini juga menyewakan pakaian khas China untuk para pengunjung</p><div><br></div>'),(22,'en','Simpang Lima Semarang','<p>Pancasila Field Semarang or better known as Simpang Lima Semarang is one of the favorite places of Semarang people spend time in the evening. Equipped with colorful- light trains that decorate every corner and mouth-watering food vendors and vast expanses of grass are an attraction of its own. Places to gather together spend time telling stories or places to ponder and release thoughts after the bustle of the day.</p>'),(22,'id','Simpang Lima Semarang','<p>Lapangan Pancasila Semarang atau lebih dikenal dengan nama Simpang Lima Semarang merupakan salah satu tempat favorit masyarakat Semarang menghabiskan waktu di malam hari. Dilengkapi dengan kereta–kereta dengan lampu warna–warni yang menghiasi setiap sudut dan para penjual makanan yang menggugah selera serta hamparan lapangan rumput yang luas menjadi daya tarik tersendiri. Tempat untuk berkumpul bersama menghabiskan waktu bercerita atau tempat untuk merenung dan merileksasikan pikiran setelah hiruk pikuk seharian. </p><div><br></div>'),(23,'en','Blenduk Church','<p>GPIB Immanuel Semarang is the oldest Christian church in Central Java, located in the Old City area of Semarang. The church was built in 1753 by Dutch people living in the city of Semarang and became one of the old city landmarks. The name Blenduk is the nickname of the local community for the dome of the Church which in Javanese language means to swell. The neo-Gothic architecture with a European twist is an attraction of this church coupled with its unique dome-like shape with bronze-lined and hexagonal or octagon-shaped buildings. </p><p>At the beginning of the establishment of this church has traditional Javanese architecture with the form of house stage. After several attempts were last performed in 1894 by W. Westmas and H.PA. De Wilde Blenduk Church stood firmly until now with the addition of 2 towers, the overhaul that does not change the characteristics of the building is characteristic of European architecture. The reshuffle done against this church is documented by writing on marble stone under the Altar church. In this church, there are organ (Orgel) relics of the Dutch era that are hundreds of years old but can not be used anymore.</p><p>In addition to enjoying the enchanting or religious architectural elegance of the church, tourists can also take a break at the Pleret Park while enjoying the typical culinary of Semarang such as Pisang Planet, Lumpia, and others. Now Blenduk church building is not only used to worship, but also as one of pre-wedding photo spot with elegant photos with the background of the Church of the aesthetic European architecture.</p><div><br></div>'),(23,'id','Gereja Blenduk','<p>GPIB Immanuel Semarang merupakan gereja Kristen tertua di Jawa Tengah yang terletak di kawasan Kota Lama Semarang. Gereja ini dibangun pada tahun 1753  oleh masyarakat Belanda yang tinggal di kota Semarang dan menjadi salah satu landark kota lama. Nama Blenduk adalah julukan dari masyarakat setempat untuk kubah gereja tersebut yang dalam bahasa jawa berarti menggembung. Arsitektur neo-gothik dengan sentuhan Eropa menjadi daya tarik dari gereja ini ditambah dengan keunikan kubahnya yang berbentuk seperti dome dengan dilapisi perunggu dan bangunan yang berbentuk heksagonal atau segi delapan. </p><p>Pada awal berdirinya gereja ini memiliki arsitektur tradisional Jawa dengan bentuk rumah panggung. Setelah beberapa kali perombakan yang terakhir kali dilakukan pada tahun 1894 oleh W. Westmas dan H.PA.De Wilde gereja Blenduk berdiri kokoh hingga saat ini dengan penambahan 2 menara, perombakan yang dilakukan tidak merubah karakteristik bangunan memiliki ciri khas arsitektur Eropa. Perombakan yang dilakukan terhadap gereja ini didokumentasikan dengan tulisan di atas batu marmer di bawah altar gereja. Di gereja ini terdapat organ (orgel) peninggalan jaman Belanda yang sudah berusia ratusan tahun namun sudah tidak bisa digunakan lagi.</p><p>Selain menikmati keanggunan arsitektur gereja yang mempesona atau beribadah, wisatawan juga dapat beristirahat sejenak di Taman Pleret sambil menikmati kuliner khas Semarang seperti pisang planet, lumpia, dan lain – lain. Saat ini bangunan gereja Blenduk tidak hanya digunakan untuk beribadah saja, tapi juga sebagai salah satu spot foto pra-wedding dengan hasil foto yang elegan dengan latar gereja berarsitektur Eropa yang estetik.</p>'),(24,'en','Ambarawa Railway Museum ','<p>Ambarawa Railway Museum Semarang is a class I train station which is the function of the Railway Museum in Indonesia. The Ambarawa Railway Museum has several train stops of tens to hundreds of years old which are imported from various regions. In this museum, tourists can learn about the history of train and its path in Indonesia, see various train stops as well as the replica of the railway plus car train player on steam train. Tourists can try to ride a steam train with the route Ambarawa-Bedono or Ambarawa-Tuntang. The departure schedule is divided into three at 10.00 WIB, 12.00 WIB, and 14.00 WIB.</p>'),(24,'id','Museum Kereta Api Ambarawa','<p>Museum Kereta Api Ambarawa Semarang merupakan sebuah stasiun kereta api kelas I yang beralihfungsi menjadi museum perkeretaapian di Indonesia. Museum Kereta Api Ambarawa memiliki beberapa halte kereta api berusia puluhan hingga ratusan tahun yang didatangkan dari berbagai wilayah. Di museum ini wisatawan bisa belajar mengenai sejarah kereta api beserta jalurnya di Indonesia, melihat beragam halte kereta api serta replika bagian kereta api ditambah dengan alat pemutar gerbong kereta naik kereta api uap. Wisatawan bisa mencoba menaiki kereta uap dengan rute Ambarawa-Bedono atau Ambarawa-Tuntang. Jadwal keberangkatannya terbagi menjadi tiga yaitu pukul 10.00 WIB, 12.00 WIB, dan 14.00 WIB. </p>'),(25,'en','Cimory on the Valley','<p>Cimory stands for Cisarua Mountain Dairy which was founded by Budi Sutantio to accommodate cow\'s dairy products from the cattle farmer Cisarua. Cimory Valley View on the path to Semarang is one of the biggest outlets. Overall Cimory presents several zones such as: A store that provides several products Cimory processed milk from yogurt, milk and typical snacks of Semarang and a cute doll shaped cow and other objects with labels Cimory. Besides, there is a playground zone as a playground for children, farms that can be said as a mini-zoo because tourists can find various animals as well as feeding animals, factory, and Instagram-able restaurants that offer food and Drinks with natural scenery. Based on the zones provided it can be concluded that Cimory is suitable as a tourist destination for family.</p>'),(25,'id','Cimory on the Valley','<p>Cimory merupakan singkatan dari Cisarua Mountain Dairy yang didirikan oleh Budi Sutantio dengan tujuan menampung produk susu sapi dari peternak Cisarua. Cimory Valley View di jalur menuju Semarang ini merupakan salah satu outlet terbesar. Secara keseluruhan Cimory menyuguhkan beberapa zona seperti : toko yang menyediakan beberapa produk Cimory olahan susu mulai dari yoghurt, susu hingga snack khas Semarang dan boneka lucu berbentuk sapi serta barang-barang lain dengan label Cimory. Selain itu terdapat zona playground sebagai wahana bermain anak – anak, farm yang bisa dikatakan sebagai mini zoo karena wisatawan dapat menjumpai berbagai binatang serta memberi makan binatang, factory, dan restoran instagrammable yang menawarkan makanan dan minuman dengan suguhan pemandangan alam. Berdasarkan zona – zona yang disediakan dapat diambil kesimpulan bahwa Cimory ini cocok sebagai destinasi wisata untuk keluarga.</p>'),(26,'en','Candi Cetho','<p>Cetho temple is located in Cetho Hamlet, Gumeng village, Ngargoyoso District of Karanganyar, Central Java province. According to the history of the Hindu temple, Cetho is thought to have been built during the Majapahit Empire around the 15th century, and it did not quarrel far with the construction of Sukuh temple. Cetho temple is at an altitude of 1496 MASL so it is named as one of the tallest temples in Indonesia along with the Ijo temple in Jogjakarta, Gedong Songo temple in Semarang and Arjuna temple in Dieng Plateau. In Javanese language, cetho means obvious because tourists can see the view of Mount Merbabu, Mount Lawu, and Mount Merapi plus the peak of Mount Sindoro and Mount Sumbing and the view of Surakarta and Karanganyar while in The area. This Hindu temple is a little different from other Hindu temples seen in terms of its architecture in the form of Punden Berundak-undak. This is because the temple was built when the Majapahit kingdom suffered a collapse so that the architecture is a representation of the culture of the local community that emerged after the end of the heyday of Majapahit. Seen from the top some rocks shaped like an eagle and turtle in Hindu mythology Garuda Bird is a vehicle of God Vishnu and give an overview of the world of the sky and turtles that symbolize the world on land. Before finding Cetho Temple tourists will be presented with a wide view of tea plantations so that tourists can enjoy the beauty of the ancient site and the beauty of the natural panorama at the same time. </p><p>The uniqueness of Cetho temple is the similarity of temple building with Mayan buildings in Central America and the Inca tribe of Peru. Various ornaments and statues in this temple are similar to those of the Sumerians or Romans. Therefore this resemblance to a large question mark that is not answered until now. </p><p>This temple becomes one of the spiritual destinations for tourists who are Hindu, here tourists can pray with guided local people and provided incense as a completeness to pray.</p><div><br></div>'),(26,'id','Candi Cetho','<p>Candi Cetho terletak di Dusun Cetho, Desa Gumeng, Kecamatan Ngargoyoso Kabupaten Karanganyar Provinsi Jawa Tengah. Menurut ahli sejarah Candi Cetho yang bercorak agama Hindu ini diperkirakan dibangun pada masa kerajaan Majapahit sekitar abad ke 15, tidak berselisih jauh dengan pembangunan Candi Sukuh. Candi Cetho berada di ketinggian 1496 mdpl sehingga dinobatkan sebagai salah satu candi tertinggi di Indonesia bersama dengan Candi Ijo di Jogjakarta, Candi Gedong Songo di Semarang dan Candi Arjuna di Dataran Tinggi Dieng. Dalam bahasa Jawa, cetho berarti jelas karena wisatawan bisa dengan jelas melihat pemandangan Gunung Merbabu, Gunung Lawu dan Gunung Merapi ditambah puncak Gunung Sindoro dan Gunung Sumbing serta pemandangan kota Surakarta dan Karanganyar ketika berada di kawasan ini. Candi Hindu ini sedikit berbeda dengan candi Hindu lainnya dilihat dari segi arsitekturnya yang berbentuk punden berundak-undak. Hal ini dikarenakan candi ini dibangun saat Kerajaan Majapahit mengalami keruntuhan sehingga arsitekturnya merupakan representasi kebudayaan dari masyarakat setempat yang muncul setelah akhir masa kejayaan Majapahit. Dilihat dari atas terdapat bebatuan yang berbentuk seperti burung garuda dan kura - kura yang dalam mitologi Hindu burung garuda merupakan kendaraan Dewa Wisnu serta memberikan gambaran tentang dunia langit dan kura-kura yang melambangkan dunia di daratan.Sebelum menjumpai Candi Cetho wisatawan akan disuguhkan pemandangan perkebunan teh yang luas sehingga wisatawan dapat menikmati keindahan perpaduan situs purbakala serta keindahan panorama alam dalam waktu yang bersamaan.  </p><p>Keunikan Candi Cetho adalah kemiripan bangunan candi dengan bangunan suku Maya di Amerika Tengah dan Suku Inca di Peru. Berbagai ornamen dan patung di Candi ini mirip dengan orang Sumeria atau Romawi. Oleh karena itu kemiripan ini menjadi tanda tanya besar yang belum terjawab hingga saat ini. </p><p>Candi ini menjadi salah satu destinasi rohani bagi wisatawan yang beragama Hindu, disini wisatawan bisa berdoa dengan dipandu masyarakat setempat serta disediakan dupa sebagai kelengkapan untuk berdoa. </p><div><br></div>'),(27,'en','Sangiran Museum ','<p>Sangiran is located in Sragen Regency, Central Java and is the most complete ancient human archaeological site in Asia with an area of 56 km² at the foot of Mount Lawu, Central Java, or about 15 km north of Surakarta in the valley of Bengawan Solo River. This site is the most important site of various research in anthropology, archaeology, biology, paleoanthropology, geology, and tourism. Sragen district is dubbed as Fossil City due to the many fossil-ancient fossils found in this area. At first, a local farmer named Setu Wiryorejo discovered the skull in 1930. After that, research was held by G.H. R Von Koenigswad, a Dutchman, in the vicinity of the area. Von Koenigswad with the locals managed to find many fossils which were then gathered until 1975 in one of the resident houses. Because many people flock to see this invention so that the establishment of a museum contains the collection of fossils. The Sangiran site has been found more than 100 individuals of ancient human fossils, representing more than 50% of the world\'s ancient human fossil findings. </p><p><br></p><p>In 1977, the Sangiran Museum was designated as one of the world\'s heritage by UNESCO. In the year 1980, the museum area began to expand with an area of 16,675 square meters. The building is Joglo-style and consists of exhibition halls, halls, laboratories, libraries, audio-visual room (where movie plays about prehistoric human life), storage shed, mosque, toilets, parking area, and kiosks. Currently, Sangiran archaeological site is one of the important sites to study human fossils as well as the Zhoukoudian site in China, the Willandra Lake site in Australia, the Olduvai Gorge site in Tanzania and the Sterkfontein site in South Africa. </p><p><br></p><p>Sangiran Museum is suitable as a historical and educational tourism for tourists because the site is equipped with ancient human fossils, the results of ancient human cultures, fossils of ancient flora and fauna and the description of its stratigraphy. Facilities and infrastructures that are provided for visitors are also adequate. In addition to the main museum, Sangiran also has other museums such as the Ngedude Museum, Bukuran Cluster, Dayu Museum, and the Sangarian archaeological Museum which is still located in one complex with easy access.</p>'),(27,'id','Museum  Sangiran ','<p>Sangiran terletak di Kabupaten Sragen, Jawa Tengah dan merupakan situs arkeologi manusia purba terlengkap di Asia dengan luas  56 km² berada di kaki Gunung Lawu, Jawa Tengah, atau sekitar 15 km utara Surakarta di lembah Sungai Bengawan Solo. Situs ini merupakan situs terpenting dari berbagai penelitian di bidang antropologi, arkeologi, biologi, paleoantropologi, geologi, dan kepariwisataan. Kabupaten Sragen dijuluki sebagai Kota Fosil karena banyaknya fosil – fosil purbakala yang ditemukan di daerah ini. Pada awalnya seorang warga setempat yang berprofesi sebagai petani bernama Setu Wiryorejo menemukan tengkorak pada tahun 1930. Setelah itu diadakan penelitian oleh G.H.R Von Koenigswad, seorang berkebangsaan Belanda, di sekitar wilayah tersebut. Von Koenigswad bersama warga setempat berhasil menemukan banyak fosil yang kemudian dikumpulkan hingga tahun 1975 di salah satu rumah penduduk. Dikarenakan banyaknya orang berdatangan untuk melihat penemuan ini sehingga didirikanlah sebuah museum berisi koleksi fosil tersebut. Pada Situs Sangiran ini telah ditemukan lebih dari 100 individu fosil manusia purba, yang mewakili lebih dari 50% temuan fosil manusia purba dunia. </p><p>Pada tahun 1977, Museum Sangiran ditetapkan sebagai salah satu warisan dunia oleh UNESCO. Pada tahun 1980, area museum mulai diperluas dengan luas tanah 16.675 meter persegi. Bangunan ini bergaya joglo dan terdiri dari ruang pameran, aula, laboratorium, perpustakaan, ruang audio visual (tempat pemutaran film tentang kehidupan manusia prasejarah), gudang penyimpanan, mushola, toilet, area parkir, dan kios. Saat ini situs purbakala Sangiran menjadi salah satu situs penting untuk mempelajari fosil manusia sama halnya dengan Situs Zhoukoudian di China, Situs Danau Willandra di Australia, Situs Olduvai Gorge di Tanzania dan Situs Sterkfontein di Afrika Selatan. </p><p><br></p><p>Museum Sangiran ini cocok sebagai wisata sejarah dan edukasi bagi wisatawan karena situs ini dilengkapi dengan fosil manusia purba, hasil-hasil budaya manusia purba, fosil flora dan fauna purba beserta gambaran stratigrafinya. Sarana dan prasarana yang disediakaan bagi pengunjung juga memadai. Selain museum induk, Sangiran juga memiliki museum lain seperti museum Ngebung, Kluster Bukuran, Museum Dayu, dan Museum Purbakala Sangarian yang masih terletak dalam satu komplek yang sama dengan akses yang mudah.</p>'),(28,'en','Tjolomadoe  Museum ','<p>Tjolomadoe Museum is a sugar factory built in the year 1861 by Mangkunegaran IV. This factory has a variety of sugar production machines with very good quality in its era, this factory is also the largest sugar factory in Asia. The factory has a magnificent design with a towering roof as well as a spacious courtyard with a classic design and European-style garden lamps. 20 years ago, this factory has not been used because of the high production costs and old equipment. Today this factory has been revitalized without losing the impression of sugar production in the past. Machinery-production still stands dashing and presented a variety of collections and miniature factories. In this factory, there are various stations such as grind, carbonation, swallowing and evaporation stations. The naming of the station follows the machines in these locations. Some of the machines in the paint are re-colored in silver, some are retained with the original color coupled with rust spots indicating the plant\'s lifespan has been long enough. This factory does not only consist of historical goods or old machines such as the Ketelan station used as a place for food and beverage, Carbonatation station that serves as the center of the crafts, stations the evaporation inside is Besali Café.</p><p>In addition, there is Tjolomadoe Hall or concert hall that can accommodate a maximum of 3,000 visitors has staged various concerts from famous artists like Tulus.</p><p> This Museum has many good spots for photo that supported by magnificent building architecture as well as Instagram-able interior.</p>'),(28,'id','Museum Tjolomadoe  ','<p>Museum Tjolomadoe merupakan pabrik gula yang dibangun pada tahun 1861 oleh Mangkunegaran IV. Pabrik ini memiliki berbagai mesin produksi gula dengan kualitas yang sangat bagus pada jamannya, pabrik ini juga merupakan pabrik gula terbesar se – Asia. Pabrik ini memiliki desain megah dengan atap yang menjulang tinggi serta halaman yang luas dengan desain klasik dan lampu taman bergaya Eropa. Sejak 20 tahun yang lalu pabrik ini pun sudah tidak digunakan karena biaya produksi yang terlalu tinggi dan peralatan yang sudah tua. Saat ini Pabrik ini sudah direvitalisasi tanpa menghilangkan kesan produksi gula pada masa lalu. Mesin produksi masih berdiri gagah serta disajikan berbagai koleksi serta miniatur pabrik. Di dalam pabrik ini terdapat berbagai stasiun yaitu Stasiun Gilingan, Karbonatasi, Ketelan dan Penguapan. Penamaan stasiun tersebut mengikuti mesin yang terdapat di lokasi – lokasi tersebut. Beberapa mesin di cat kembali berwarna silver, beberapa tetap dipertahankan dengan warna aslinya ditambah dengan bercak karat yang menandakan umur pabrik tersebut yang sudah cukup lama.Pabrik ini tidak hanya terdiri dari barang bersejarah ataupun mesin tua seperti di stasiun Ketelan yang digunakan sebagai tempat jajanan makanan dan minuman, stasiun Karbonatasi yang berfungsi sebagai pusat kerajinan, stasiun Penguapan yang didalamnya terdapat Besali Café.</p><p>Selain itu ada Tjolomadoe Hall atau concert hall yang mampu menampung maksimal 3.000 pengunjung dan sudan Sarkara Hall sebagai multi-function kedai kopi serta Concert Hall yang megah yang mampu menampung maksimal 3.000 pengunjung dan  sudah menggelar berbagai konser dari artis ternama seperti Tulus.</p><p>Museum ini memiliki banyak spot bagus untuk berfoto yang di dukung oleh arsitektur bangunan yang megah serta interior yang instagrammable.</p><div><br></div>'),(29,'en','Solo Sultan Palace ','<p>According to the Giyanti treaty where the Mataram Sultanate which is the last Kingdom in power in Java is divided into 2 areas namely Yogyakarta and Surakarta, therefore in both areas, there are 2 similar buildings but not similar The Keraton Kasunanan Surakarta and Yogyakarta Sultanate. The palace is the dwelling place of the king and becomes a sacred place in each region. Currently, the palace is the best example of traditional Javanese palace architecture as well as cultural heritage objects. Keraton is also still functioning as the residence of the king who still runs the tradition of the kingdom. </p><p>Surakarta Hadiningrat Palace or better known as Keraton Solo is one of the popular destinations for tourists visiting Solo City. The architect of Solo Palace was Hamengkubuwono I who also became the designer for the palace of Yogjakarta, therefore there are several elements of the same building between the two. Major reshuffle – magnitudes occurred at the time of Pakubuwono X (1893-1939) in the domination of the blue-white by adopting the European architecture and ethnic Javanese in the spatial. The palace building consists of several complex, namely the Plaza Lor-square complex, Sasana Sumewa complex, Siti Hinggil Lor Complex, Kamandungan Lor complex, Sri Manganti complex, Kedhaton complex, Magangan complex, Sri Manganti complex and Kamandungan Kidul, Siti Hinggil Kidul complex and South Square. All the inside of Keraton Solo is open for tourists, except Sasana Pustaka, Sasana Sewaka and Maligi, for the reason of privacy because until now, Keraton Solo still inhabited by Sri Sunan Surakarta Pakubuwono XIII family. </p><p>Keraton Kasunanan Surakarta has a museum with a distinctive collection of royal palaces such as everyday keratin trinkets, a variety of gifts from the kings of Europe, a set of traditional gamelan instruments and also replicas of keraton inheritance. Keraton Solo has 13 halls that showcase different collections. In the museum building, there is a garden. In the garden area with several statues of angels and a large wood called Teak wood of Kyai Dhanalayayang is a tree that is felled by Pakubuwono V when he will create a statue of Rojomolo. Not far from this tree there is a source of water that is the place Pakubuwono IX. Tourists usually wash their face in the spring, hoping to get a blessing or get youthfulness.</p>'),(29,'id','Keraton Solo','<p>Berdasarkan perjanjian Giyanti dimana Kesultanan Mataram yang merupakan kerajaan terakhir yang berkuasa di tanah Jawa dibagi menjadi 2 wilayah yaitu Yogyakarta dan Surakarta, oleh karena itu di kedua wilayah ini terdapat 2 bangunan yang sama tapi tidak serupa yaitu Keraton Kasunanan Surakarta dan Kasultanan Yogyakarta. Keraton merupakan tempat kediaman raja dan menjadi tempat sakral di wilayah masing – masing. Saat ini keraton menjadi contoh arsitektur istana Jawa tradisional terbaik sekaligus benda cagar budaya. Keraton juga masih difungsikan sebagai tempat tinggal raja yang masih menjalankan tradisi kerajaan. </p><p>Keraton Surakarta Hadiningrat atau lebih dikenal dengan nama Keraton Solo merupakan salah satu destinasi populer bagi wisatawan yang berkunjung ke Kota Solo. Arsitek keraton Solo adalah Hamengkubuwono I yang juga menjadi perancang untuk istana Yogjakarta, oleh karena itu terdapat beberapa unsur bangunan yang sama antara keduanya. Perombakan besar – besaran terjadi pada masa Susuhan Pakubuwono X (1893-1939) yang di dominasi warna putih biru dengan mengadopsi arsitektur Eropa dan etnik Jawa dalam tata ruang. Bangunan keraton ini terdiri dari beberapa kompleks, yaitu Kompleks Alun-alun Lor, Kompleks Sasana Sumewa, Kompleks Siti Hinggil Lor, Kompleks Kamandungan Lor, Kompleks Sri Manganti, Kompleks Kedhaton, Kompleks Magangan, Kompleks Sri Manganti dan Kamandungan Kidul, Kompleks Siti Hinggil Kidul dan Alun-alun Kidul. Semua bagian dalam Keraton Solo terbuka buat wisatawan, kecuali Sasana Pustaka, Sasana Sewaka dan Maligi, dengan alasan privasi karena sampai saat ini Keraton Solo masih didiami oleh keluarga Sri Sunan Surakarta Pakubuwana XIII. </p><p>Keraton Kasunanan Surakarta memiliki museum dengan koleksi peninggalan khas keraton seperti pernak-pernik keseharian keraton, berbagai macam hadiah dari raja-raja di Eropa, seperangkat alat musik tradisional gamelan dan juga replika pusaka keratin. Keraton Solo memiliki 13 ruang yang memamerkan koleksi yang berbeda – beda. Di tengah bangunan museum, terdapat sebuah taman dengan beberapa patung malaikat dan sebuah kayu besar yang dinamakan Kayu Jati Kyai Dhanalayayang merupakan pohon yang ditebang Pakubuwono V saat akan membuat patung Rojomolo. Tidak jauh dari pohon ini ada sumber mata air yang merupakan tempat Pakubuwono IX. Wisatawan biasanya mencuci muka di sumber mata air ini, berharap mendapat berkah atau mendapat kemudaan. </p>');

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

insert  into `mst_ticket_price`(`ticketprice_ticket_id`,`ticketprice_visitortype_id`,`ticketprice_start`,`ticketprice_end`,`ticketprice_price_local`,`ticketprice_price_foreign`) values (2,NULL,'2019-11-01','2019-11-09','1.00','2.00'),(2,NULL,'2019-11-01','2019-11-09','1.00','2.00'),(2,NULL,'2019-11-01','2019-11-09','1.00','2.00'),(1,1,'2019-08-01','2019-09-01','80000.00','200000.00'),(1,1,'2019-10-01','2019-10-31','70000.00','170000.00'),(1,1,'2019-11-01','2019-11-09','75000.00','175000.00'),(3,NULL,'2019-11-01','2019-11-09','10000.00','20000.00'),(3,NULL,'2019-11-10','2019-11-16','20000.00','30000.00');

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

insert  into `mst_ticket_pricedefault`(`ticketpricedef_ticket_id`,`ticketpricedef_visitortype_id`,`ticketpricedef_price_local`,`ticketpricedef_price_foreign`) values (2,NULL,'1.00','2.00'),(1,1,'1500000.00','15000000.00'),(1,2,'1200000.00','12000000.00'),(1,3,'1100000.00','11000000.00'),(3,NULL,'20000.00','30000.00');

/*Table structure for table `mst_ticket_text` */

DROP TABLE IF EXISTS `mst_ticket_text`;

CREATE TABLE `mst_ticket_text` (
  `tickettext_ticket_id` int(11) NOT NULL,
  `tickettext_lang` varchar(5) NOT NULL,
  `tickettext_name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`tickettext_ticket_id`,`tickettext_lang`),
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
  `tourpackages_total_day` tinyint(2) DEFAULT NULL COMMENT 'jumlah hari',
  `tourpackages_total_night` tinyint(2) DEFAULT NULL COMMENT 'jumlah malam',
  `tourpackages_base_price_local` decimal(20,2) DEFAULT NULL COMMENT 'harga (perorang) jika tiidak ada harga terjadwal yg di set',
  `tourpackages_base_price_foreign` decimal(20,2) DEFAULT NULL COMMENT 'harga (perorang) jika tiidak ada harga terjadwal yg di set',
  `tourpackages_min_order` int(11) DEFAULT '0',
  `tourpackages_max_order` int(11) DEFAULT '0',
  `tourpackages_is_rating_manual` tinyint(1) DEFAULT NULL COMMENT '0=no, 1=yes',
  `tourpackages_rating_manual` decimal(2,1) DEFAULT NULL COMMENT '1,2,3,4,5 (bintang) manual',
  `tourpackages_total_rater_manual` tinyint(11) DEFAULT NULL COMMENT 'jumlah penilai manual',
  `tourpackages_status` tinyint(1) DEFAULT NULL COMMENT '0=not active, 1=active',
  `insert_user_id` bigint(20) DEFAULT NULL,
  `insert_datetime` datetime DEFAULT NULL,
  `update_user_id` bigint(20) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`tourpackages_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `mst_tourpackages` */

insert  into `mst_tourpackages`(`tourpackages_id`,`tourpackages_total_day`,`tourpackages_total_night`,`tourpackages_base_price_local`,`tourpackages_base_price_foreign`,`tourpackages_min_order`,`tourpackages_max_order`,`tourpackages_is_rating_manual`,`tourpackages_rating_manual`,`tourpackages_total_rater_manual`,`tourpackages_status`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (5,5,5,'1330000000.00','1500000000.00',2,5,0,'3.5',NULL,1,5,'2019-09-28 21:44:38',5,'2019-12-14 14:22:29'),(6,3,3,'2.00','22.00',1,5,1,'4.9',NULL,1,5,'2019-10-09 11:53:03',5,'2019-12-05 22:45:36'),(7,2,2,'350000.00','1000000.00',1,10,1,'5.0',NULL,1,5,'2019-10-23 03:41:44',6,'2019-12-06 17:20:34'),(8,4,4,'1000000.00','2000000.00',1,2,1,'2.5',NULL,1,5,'2019-10-23 03:57:12',5,'2019-12-07 23:57:15');

/*Table structure for table `mst_tourpackages_destination` */

DROP TABLE IF EXISTS `mst_tourpackages_destination`;

CREATE TABLE `mst_tourpackages_destination` (
  `tourpackagesdest_tourpackages_id` int(11) DEFAULT NULL,
  `tourpackagesdest_destination_id` int(11) DEFAULT NULL,
  `tourpackagesdest_day` int(11) DEFAULT NULL COMMENT 'urutan hari',
  `tourpackagesdest_order` int(11) DEFAULT NULL COMMENT 'urutan perhari',
  KEY `tourpackagesdest_tourpackages_id` (`tourpackagesdest_tourpackages_id`),
  KEY `tourpackagesdest_destination_id` (`tourpackagesdest_destination_id`),
  CONSTRAINT `mst_tourpackages_destination_ibfk_1` FOREIGN KEY (`tourpackagesdest_tourpackages_id`) REFERENCES `mst_tourpackages` (`tourpackages_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `mst_tourpackages_destination_ibfk_2` FOREIGN KEY (`tourpackagesdest_destination_id`) REFERENCES `mst_destination` (`destination_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_tourpackages_destination` */

insert  into `mst_tourpackages_destination`(`tourpackagesdest_tourpackages_id`,`tourpackagesdest_destination_id`,`tourpackagesdest_day`,`tourpackagesdest_order`) values (6,16,1,1),(7,23,1,1),(8,17,1,1),(5,28,1,1),(5,16,1,2),(5,15,2,1),(5,24,2,2),(5,13,3,1),(5,5,3,2),(5,9,4,1),(5,17,4,2),(5,3,5,1),(5,18,5,2);

/*Table structure for table `mst_tourpackages_img` */

DROP TABLE IF EXISTS `mst_tourpackages_img`;

CREATE TABLE `mst_tourpackages_img` (
  `tourpackagesimg_tourpackages_id` int(11) DEFAULT NULL,
  `tourpackagesimg_order` int(11) DEFAULT NULL,
  `tourpackagesimg_img` text,
  KEY `destimg_destination_id` (`tourpackagesimg_tourpackages_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_tourpackages_img` */

insert  into `mst_tourpackages_img`(`tourpackagesimg_tourpackages_id`,`tourpackagesimg_order`,`tourpackagesimg_img`) values (6,1,'82eb8ddb9310ecebd8b21c309fe2871c.jpeg'),(6,2,NULL),(6,3,NULL),(6,4,NULL),(7,1,'45da7e019d5ff16f30f8e5253d4a18e0.jpeg'),(7,2,NULL),(7,3,NULL),(7,4,NULL),(8,1,'d03084acfbf352ccaaf5bd5471f4bedf.jpeg'),(8,2,NULL),(8,3,NULL),(8,4,NULL),(5,1,'eed607ca4461552933788cf9e3f0274f.jpeg'),(5,2,NULL),(5,3,NULL),(5,4,NULL);

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

insert  into `mst_tourpackages_price`(`tourpackagesprice_tourpackages_id`,`tourpackagesprice_start`,`tourpackagesprice_end`,`tourpackagesprice_price_local`,`tourpackagesprice_price_foreign`) values (6,'2019-10-30','2019-10-31','22.00','222.00'),(6,'2019-11-01','2019-11-08','2222.00','2222.00'),(8,'2019-12-01','2019-12-08','1500000.00','3000000.00'),(5,'2019-11-24','2019-12-07','1200000000.00','2000000000.00');

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

insert  into `mst_tourpackages_testimony`(`tourpackagestesti_tourpackages_id`,`tourpackagestesti_user_id`,`tourpackagestesti_user_real_name`,`tourpackagestesti_date`,`tourpackagestesti_testimony`,`tourpackagestesti_rating`,`tourpackagestesti_token`,`tourpackagestesti_is_process`,`tourpackagestesti_is_publish`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (5,5,'Riyan Trisna Wibowo','2019-10-09 13:53:00','Lorem ipsum dolor sit amet, laoreet enim, in mi tincidunt diam pulvinar sodales, proin sit magna vitae vitae hendrerit diam. Sed morbi vestibulum vulputate mi lorem neque, erat porttitor vel ante. Et nonummy. Tempor phasellus id nascetur tellus massa, dolor feugiat feugiat ut blandit,',4,'12345678909876fghjkjhgfdfgh',1,1,5,'2019-10-09 13:56:31',5,'2019-10-09 19:45:11'),(5,5,'Riyan Trisna Wibowo','2019-10-09 13:55:00','Lorem ipsum dolor sit amet, laoreet enim, in mi tincidunt diam pulvinar sodales, proin sit magna vitae vitae hendrerit diam. Sed morbi vestibulum vulputate mi lorem neque, erat porttitor vel ante. Et nonummy. Tempor phasellus id nascetur tellus massa, dolor feugiat feugiat ut blandit,',4,'12345678909876fghjkjhgfdfgh',1,1,5,'2019-10-09 13:56:31',5,'2019-10-09 19:45:11'),(5,6,'Riyan Trisna Wibowo','2019-10-09 13:58:00','Lorem ipsum dolor sit amet, laoreet enim, in mi tincidunt diam pulvinar sodales, proin sit magna vitae vitae hendrerit diam. Sed morbi vestibulum vulputate mi lorem neque, erat porttitor vel ante. Et nonummy.',4,'12345678909876fghjkjhgfdfgh',1,1,5,'2019-10-09 13:56:31',5,'2019-10-09 19:45:11'),(5,6,'Riyan Trisna Wibowo','2019-10-09 13:52:00','Lorem ipsum dolor sit amet, laoreet enim, in mi tincidunt diam pulvinar sodales, proin sit magna vitae vitae hendrerit diam. Sed morbi vestibulum vulputate mi lorem neque, erat porttitor vel ante. Et nonummy. Tempor phasellus id nascetur tellus massa, dolor feugiat feugiat ut blandit,',4,'12345678909876fghjkjhgfdfgh',1,1,5,'2019-10-09 13:56:31',5,'2019-10-09 19:45:11'),(5,6,'Riyan Trisna Wibowo','2019-10-09 13:52:00','Lorem ipsum dolor sit amet, laoreet enim, in mi tincidunt diam pulvinar sodales, proin sit magna vitae vitae hendrerit diam. Sed morbi vestibulum vulputate mi lorem neque, erat porttitor vel ante. Et nonummy. Tempor phasellus id nascetur tellus massa, dolor feugiat feugiat ut blandit,',4,'12345678909876fghjkjhgfdfgh',1,1,5,'2019-10-09 13:56:31',5,'2019-10-09 19:45:11');

/*Table structure for table `mst_tourpackages_text` */

DROP TABLE IF EXISTS `mst_tourpackages_text`;

CREATE TABLE `mst_tourpackages_text` (
  `tourpackagestext_tourpackages_id` int(11) NOT NULL,
  `tourpackagestext_lang` varchar(5) NOT NULL,
  `tourpackagestext_name` varchar(250) DEFAULT NULL,
  `tourpackagestext_text` text,
  PRIMARY KEY (`tourpackagestext_tourpackages_id`,`tourpackagestext_lang`),
  KEY `tourpackagestext_tourpackages_id` (`tourpackagestext_tourpackages_id`),
  KEY `tourpackagestext_lang` (`tourpackagestext_lang`),
  CONSTRAINT `mst_tourpackages_text_ibfk_1` FOREIGN KEY (`tourpackagestext_tourpackages_id`) REFERENCES `mst_tourpackages` (`tourpackages_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mst_tourpackages_text` */

insert  into `mst_tourpackages_text`(`tourpackagestext_tourpackages_id`,`tourpackagestext_lang`,`tourpackagestext_name`,`tourpackagestext_text`) values (5,'en','Paket Cinta Budaya Borobudur','<p>Paket Cinta Budaya meba<br></p>'),(5,'id','Love the Heritage of Borobudur Package','<p>Paket Cinta Budaya membawa kita lebih mengenal Candi Borobudur secara lebih dekat, dikhususkan untuk pelajar mulai dari SD sampai dengan SMA sederajat. Pelajar diajak untuk menyaksikan pemutaran film tentang Candi Borobudur di Ruang Audio Visual. Pelajar juga diajak berkeliling Candi Borobudur menggunakan kereta taman. Diharapkan, pelajar dapat memahami secara langsung arti pentingnya pelestarian cagar budaya.</p><p><br></p><p>Paket ini termasuk :</p><p>1. Transportasi Mobil</p><p>2. Snack</p><p>3. Tiket masuk Candi Borobudur & Museum Borobudur</p><p>4. Tiket Audio Visual</p><p>5. Tiket kereta</p><p>6. Pemandu</p><p>7. Air Mineral</p>'),(6,'en','Paket Wisata Candi','<p>Paket Wisata Candi<br></p>'),(6,'id','Paket Wisata Candi','<p>Paket Wisata Candi<br></p>'),(7,'en','Wisata Candi & Jogja','<p>Wisata Candi & Jogja<br></p>'),(7,'id','Wisata Candi & Jogja','<p>Wisata Candi & Jogja<br></p>'),(8,'en','Wisata Keliling Candi','<p>Wisata Keliling Candi<br></p>'),(8,'id','Wisata Keliling Candi','<p>Wisata Keliling Candi<br></p>');

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
  `venuetext_venue_id` int(11) NOT NULL,
  `venuetext_lang` varchar(5) NOT NULL,
  `venuetext_name` varchar(250) DEFAULT NULL,
  `venuetext_text` text,
  PRIMARY KEY (`venuetext_venue_id`,`venuetext_lang`),
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `ref_destination_location` */

insert  into `ref_destination_location`(`desloc_id`,`desloc_name`,`desloc_order`,`desloc_is_show_home`,`insert_user_id`,`insert_datetime`,`update_user_id`,`update_datetime`) values (2,'Semarang',3,1,1,'2019-11-03 20:30:31',6,'2019-12-06 16:05:52'),(3,'Jogja',1,1,1,'2019-11-03 20:30:33',6,'2019-12-06 16:06:07'),(4,'Solo',2,1,5,'2019-12-03 11:41:05',6,'2019-12-06 16:05:45');

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
  `visitortypetext_visitortype_id` int(11) NOT NULL,
  `visitortypetext_lang` varchar(5) NOT NULL,
  `visitortypetext_name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`visitortypetext_visitortype_id`,`visitortypetext_lang`),
  KEY `persontypetext_persontype_id` (`visitortypetext_visitortype_id`),
  KEY `persontypetext_lang` (`visitortypetext_lang`),
  CONSTRAINT `ref_visitortype_text_ibfk_1` FOREIGN KEY (`visitortypetext_visitortype_id`) REFERENCES `ref_visitortype` (`visitortype_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ref_visitortype_text` */

insert  into `ref_visitortype_text`(`visitortypetext_visitortype_id`,`visitortypetext_lang`,`visitortypetext_name`) values (1,'en','Adult'),(1,'id','Dewasa'),(2,'en','Child'),(2,'id','Anak'),(3,'en','Student'),(3,'id','Pelajar');

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
