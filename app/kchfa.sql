/*
SQLyog Ultimate v12.5.1 (32 bit)
MySQL - 10.4.8-MariaDB : Database - kchfa
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`kchfa` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `kchfa`;

/*Table structure for table `currencies` */

DROP TABLE IF EXISTS `currencies`;

CREATE TABLE `currencies` (
  `currencyID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currencyName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currencyCountry` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`currencyID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `currencies` */

insert  into `currencies`(`currencyID`,`currencyName`,`currencyCountry`,`created_at`,`updated_at`) values 
('191127CURRENCY-018791','Rupiah','Indonesia','2019-11-27 01:50:01','2019-11-27 01:50:01'),
('191127CURRENCY-316228','USD','Amerika','2019-11-27 02:28:51','2019-11-27 02:28:51');

/*Table structure for table `directors` */

DROP TABLE IF EXISTS `directors`;

CREATE TABLE `directors` (
  `directorID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emitenDataID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rasioID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `directorName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ownershipEmiten` decimal(14,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`directorID`),
  KEY `directors_emitendataid_foreign` (`emitenDataID`),
  KEY `directors_rasioid_foreign` (`rasioID`),
  CONSTRAINT `directors_emitendataid_foreign` FOREIGN KEY (`emitenDataID`) REFERENCES `emiten_datas` (`emitenDataID`),
  CONSTRAINT `directors_rasioid_foreign` FOREIGN KEY (`rasioID`) REFERENCES `rasioes` (`rasioID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `directors` */

/*Table structure for table `emiten_datas` */

DROP TABLE IF EXISTS `emiten_datas`;

CREATE TABLE `emiten_datas` (
  `emitenDataID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emitenID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quartalID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emitenPrice` decimal(14,2) NOT NULL,
  `yearID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isAktif` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`emitenDataID`),
  KEY `emiten_datas_emitenid_foreign` (`emitenID`),
  KEY `emiten_datas_quartalid_foreign` (`quartalID`),
  KEY `emiten_datas_yearid_foreign` (`yearID`),
  CONSTRAINT `emiten_datas_emitenid_foreign` FOREIGN KEY (`emitenID`) REFERENCES `emitens` (`emitenID`),
  CONSTRAINT `emiten_datas_quartalid_foreign` FOREIGN KEY (`quartalID`) REFERENCES `quartals` (`quartalID`),
  CONSTRAINT `emiten_datas_yearid_foreign` FOREIGN KEY (`yearID`) REFERENCES `years` (`yearID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `emiten_datas` */

/*Table structure for table `emitens` */

DROP TABLE IF EXISTS `emitens`;

CREATE TABLE `emitens` (
  `emitenID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emitenKode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emitenName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emitenAddress` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emitenInfo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subSectorID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amountShare` decimal(14,2) NOT NULL,
  `isBUMN` tinyint(1) DEFAULT 0,
  `isAktif` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`emitenID`),
  KEY `emitens_subsectorid_foreign` (`subSectorID`),
  KEY `emitens_emitenkode_index` (`emitenKode`),
  KEY `emitens_emitenname_index` (`emitenName`),
  CONSTRAINT `emitens_subsectorid_foreign` FOREIGN KEY (`subSectorID`) REFERENCES `sub_sectors` (`subSectorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `emitens` */

insert  into `emitens`(`emitenID`,`emitenKode`,`emitenName`,`emitenAddress`,`emitenInfo`,`subSectorID`,`amountShare`,`isBUMN`,`isAktif`,`created_at`,`updated_at`) values 
('191127EMITEN-013051','BNII','Bank Internasional Indonesia Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:58:21','2019-11-27 14:58:21'),
('191127EMITEN-013257','BMRI','Bank Mandiri (Persero) Tbk.','-','-','191127SUBSECTOR-354838',1.00,1,1,'2019-11-27 14:55:01','2019-11-27 14:55:01'),
('191127EMITEN-025974','AIRJ','PT Aetra Air Jakarta','-','-','191127SUBSECTOR-900529',1.00,0,1,'2019-11-27 03:56:42','2019-11-27 03:56:42'),
('191127EMITEN-028331','AISA','Tiga Pilar Sejahtera Food Tbk.','-','-','191127SUBSECTOR-533935',1.00,0,0,'2019-11-27 03:57:08','2019-11-27 04:04:56'),
('191127EMITEN-042836','ATPK','ATPK Resources Tbk.','-','-','191127SUBSECTOR-636007',1.00,0,1,'2019-11-27 13:31:44','2019-11-27 13:31:44'),
('191127EMITEN-044583','AKRA','AKR Corporindo Tbk.','-','-','191127SUBSECTOR-654064',1.00,0,1,'2019-11-27 03:58:24','2019-11-27 03:58:24'),
('191127EMITEN-051092','BRAU','Berau Coal Energy Tbk.','-','-','191127SUBSECTOR-636007',1.00,0,1,'2019-11-27 15:00:05','2019-11-27 15:00:05'),
('191127EMITEN-056106','BSDE','Bumi Serpong Damai Tbk.','-','-','191127SUBSECTOR-077679',1.00,0,1,'2019-11-27 15:01:45','2019-11-27 15:01:45'),
('191127EMITEN-060141','BEST','Bekasi Fajar Industrial Estate Tbk.','-','-','191127SUBSECTOR-077679',1.00,0,1,'2019-11-27 14:23:26','2019-11-27 14:23:26'),
('191127EMITEN-069607','AGRO','Bank Rakyat Indonesia Agroniaga Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 03:55:06','2019-11-27 03:55:06'),
('191127EMITEN-088213','ALKA','Alakasa Industrindo Tbk.','-','-','191127SUBSECTOR-429831',1.00,0,1,'2019-11-27 04:06:48','2019-11-27 04:06:48'),
('191127EMITEN-089319','ARTA','Arthavest Tbk.','-','-','191127SUBSECTOR-824785',1.00,0,1,'2019-11-27 04:20:08','2019-11-27 04:20:08'),
('191127EMITEN-109982','BCIP','Bumi Citra Permai Tbk.','-','-','191127SUBSECTOR-077679',1.00,0,1,'2019-11-27 14:21:51','2019-11-27 14:21:51'),
('191127EMITEN-122818','BSSR','Baramulti Suksessarana Tbk.','-','-','191127SUBSECTOR-636007',1.00,0,1,'2019-11-27 15:03:32','2019-11-27 15:03:32'),
('191127EMITEN-138979','BKSW','Bank QNB Kesawan Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:28:33','2019-11-27 14:28:33'),
('191127EMITEN-145848','APEX','Apexindo Pratama Duta Tbk.','-','-','191127SUBSECTOR-957417',1.00,0,1,'2019-11-27 04:16:54','2019-11-27 04:16:54'),
('191127EMITEN-155362','BTEL','Bakrie Telecom Tbk.','-','-','191127SUBSECTOR-694493',1.00,0,1,'2019-11-27 15:05:15','2019-11-27 15:05:15'),
('191127EMITEN-176605','ASMI','Asuransi Mitra Maparya Tbk.','-','-','191127SUBSECTOR-391286',1.00,0,1,'2019-11-27 04:26:57','2019-11-27 04:26:57'),
('191127EMITEN-176667','APOL','Arpeni Pratama Ocean Line Tbk.','-','-','191127SUBSECTOR-557134',1.00,0,1,'2019-11-27 04:18:37','2019-11-27 04:18:37'),
('191127EMITEN-182519','BMSR','Bintang Mitra Semestaraya Tbk.','-','-','191127SUBSECTOR-654064',1.00,0,1,'2019-11-27 14:55:18','2019-11-27 14:55:18'),
('191127EMITEN-187906','BISI','Bisi International Tbk.','-','-','191127SUBSECTOR-851392',1.00,0,1,'2019-11-27 14:26:58','2019-11-27 14:26:58'),
('191127EMITEN-191673','BATA','Sepatu Bata Tbk.','-','-','191127SUBSECTOR-500623',1.00,0,1,'2019-11-27 14:13:39','2019-11-27 14:13:39'),
('191127EMITEN-192017','BNLI','Bank Permata Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:58:39','2019-11-27 14:58:39'),
('191127EMITEN-192173','BMLK','PT Bank Pembangunan Daerah Maluku','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:29:52','2019-11-27 14:29:52'),
('191127EMITEN-201084','BCAF','PT BCA Finance','-','-','191127SUBSECTOR-483476',1.00,0,1,'2019-11-27 14:20:20','2019-11-27 14:20:20'),
('191127EMITEN-208335','BABP','Bank ICB Bumiputera Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 13:33:40','2019-11-27 13:33:40'),
('191127EMITEN-210964','BBRK','PT Bank Riau Kepri','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:18:41','2019-11-27 14:19:08'),
('191127EMITEN-215976','BSEC','PT MNC Securities','-','-','191127SUBSECTOR-668677',1.00,0,1,'2019-11-27 15:02:01','2019-11-27 15:02:01'),
('191127EMITEN-216949','BBMI','PT Bank Syariah Muamalat Indonesia Tbk','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:17:01','2019-11-27 14:17:01'),
('191127EMITEN-242036','AKSI','Majapahit Securities Tbk.','-','-','191127SUBSECTOR-668677',1.00,0,1,'2019-11-27 03:58:44','2019-11-27 03:58:44'),
('191127EMITEN-265602','BRMS','Bumi Resources Minerals Tbk.','-','-','191127SUBSECTOR-417066',1.00,0,1,'2019-11-27 15:00:26','2019-11-27 15:00:26'),
('191127EMITEN-268629','ADMF','Adira Dinamika Multi Finance Tbk.','-','-','191127SUBSECTOR-483476',1.00,0,1,'2019-11-27 03:53:46','2019-11-27 03:53:46'),
('191127EMITEN-288993','BEXI','Indonesia Eximbank','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:23:48','2019-11-27 14:23:48'),
('191127EMITEN-299174','APLN','Agung Podomoro Land Tbk.','-','-','191127SUBSECTOR-077679',1.00,0,1,'2019-11-27 04:18:19','2019-11-27 04:18:19'),
('191127EMITEN-302863','BIMA','Primarindo Asia Infrastructure Tbk.','-','-','191127SUBSECTOR-500623',1.00,0,1,'2019-11-27 14:25:30','2019-11-27 14:25:30'),
('191127EMITEN-307473','BBKP','Bank Bukopin Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:15:30','2019-11-27 14:15:30'),
('191127EMITEN-310197','AMFG','Asahimas Flat Glass Tbk.','-','-','191127SUBSECTOR-617823',1.00,0,1,'2019-11-27 04:08:51','2019-11-27 04:08:51'),
('191127EMITEN-316491','BLAM','PT Bank Pembangunan Daerah Lampung','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:28:51','2019-11-27 14:28:51'),
('191127EMITEN-318229','BSWD','Bank of India Indonesia Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 15:03:51','2019-11-27 15:03:51'),
('191127EMITEN-318867','AHAP','Asuransi Harta Aman Pratama Tbk.','-','-','191127SUBSECTOR-391286',1.00,0,1,'2019-11-27 03:55:31','2019-11-27 03:55:31'),
('191127EMITEN-334615','APIC','Pacific Strategic Financial Tbk.','-','-','191127SUBSECTOR-824785',1.00,0,1,'2019-11-27 04:17:13','2019-11-27 04:17:13'),
('191127EMITEN-342873','AUTO','Astra Otoparts Tbk.','-','-','191127SUBSECTOR-541585',1.00,0,1,'2019-11-27 13:32:14','2019-11-27 13:32:14'),
('191127EMITEN-349648','ASDF','PT Astra Sedaya Finance','-','-','191127SUBSECTOR-483476',1.00,0,1,'2019-11-27 04:23:54','2019-11-27 04:23:54'),
('191127EMITEN-349817','BNTT','PT BPD Nusa Tenggara Timur (Bank NTT)','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:58:54','2019-11-27 14:58:54'),
('191127EMITEN-362962','BJBR','BPD Jawa Barat dan Banten Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:27:16','2019-11-27 14:27:16'),
('191127EMITEN-363488','ARTI','Ratu Prabu Energi Tbk.','-','-','191127SUBSECTOR-957417',1.00,0,1,'2019-11-27 04:20:36','2019-11-27 04:20:36'),
('191127EMITEN-371198','BTON','Betonjaya Manunggal Tbk.','-','-','191127SUBSECTOR-429831',1.00,0,1,'2019-11-27 15:05:37','2019-11-27 15:05:37'),
('191127EMITEN-387132','ASRI','Alam Sutera Realty Tbk.','-','-','191127SUBSECTOR-077679',1.00,0,1,'2019-11-27 04:27:18','2019-11-27 12:30:24'),
('191127EMITEN-398056','ALDO','Alkindo Naratama Tbk','-','-','191127SUBSECTOR-349859',1.00,0,1,'2019-11-27 03:58:59','2019-11-27 04:04:50'),
('191127EMITEN-398992','BBMD','Bank Mestika Dharma Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:16:38','2019-11-27 14:16:38'),
('191127EMITEN-400244','AALI','Astra Agro Lestari Tbk.','-','-','191127SUBSECTOR-016061',1.00,0,1,'2019-11-27 03:45:40','2019-11-27 03:45:40'),
('191127EMITEN-428873','BBNI','Bank Negara Indonesia (Persero) Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:17:22','2019-11-27 14:17:22'),
('191127EMITEN-451307','BCAP','MNC Kapital Indonesia Tbk.','-','-','191127SUBSECTOR-824785',1.00,0,1,'2019-11-27 14:20:45','2019-11-27 14:20:45'),
('191127EMITEN-461335','BFIN','BFI Finance Indonesia Tbk.','-','-','191127SUBSECTOR-483476',1.00,0,1,'2019-11-27 14:24:06','2019-11-27 14:24:06'),
('191127EMITEN-462196','ARGO','Argo Pantes Tbk.','-','-','191127SUBSECTOR-190542',1.00,0,1,'2019-11-27 04:19:06','2019-11-27 04:19:06'),
('191127EMITEN-464063','ADMG','Polychem Indonesia Tbk.','-','-','191127SUBSECTOR-190542',1.00,0,1,'2019-11-27 03:54:06','2019-11-27 03:54:06'),
('191127EMITEN-468273','BMTR','Global Mediacom Tbk.','-','-','191127SUBSECTOR-417066',1.00,0,1,'2019-11-27 14:55:46','2019-11-27 14:55:46'),
('191127EMITEN-477089','ALMI','Alumindo Light Metal Industry Tbk.','-','-','191127SUBSECTOR-429831',1.00,0,1,'2019-11-27 04:07:27','2019-11-27 04:07:27'),
('191127EMITEN-477127','BTEK','Bumi Teknokultura Unggul Tbk.','-','-','191127SUBSECTOR-259878',1.00,0,1,'2019-11-27 15:04:07','2019-11-27 15:04:07'),
('191127EMITEN-477754','BIMF','PT Bima Multi Finance','-','-','191127SUBSECTOR-483476',1.00,0,1,'2019-11-27 14:25:47','2019-11-27 14:25:47'),
('191127EMITEN-495467','ABDA','Asuransi Bina Dana Arta Tbk.','-','-','191127SUBSECTOR-391286',1.00,0,1,'2019-11-27 03:47:29','2019-11-27 03:47:29'),
('191127EMITEN-495854','AKKU','Alam Karya Unggul Tbk.','-','-','191127SUBSECTOR-272056',1.00,0,1,'2019-11-27 03:57:29','2019-11-27 03:57:29'),
('191127EMITEN-496325','BBRK','PT Bank Riau Kepri','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:18:16','2019-11-27 14:18:16'),
('191127EMITEN-515781','BACA','Bank Capital Indonesia Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:04:11','2019-11-27 14:04:11'),
('191127EMITEN-519935','BORN','Borneo Lumbung Energi & Metal Tbk.','-','-','191127SUBSECTOR-636007',1.00,0,1,'2019-11-27 14:59:11','2019-11-27 14:59:11'),
('191127EMITEN-520192','AIMS','Akbar Indo Makmur Stimec Tbk.','-','-','191127SUBSECTOR-654064',1.00,0,1,'2019-11-27 03:55:52','2019-11-27 03:55:52'),
('191127EMITEN-533694','BRNA','Berlina Tbk.','-','-','191127SUBSECTOR-272056',1.00,0,1,'2019-11-27 15:00:53','2019-11-27 15:00:53'),
('191127EMITEN-535772','BJTM','BPD Jawa Timur Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:27:33','2019-11-27 14:27:33'),
('191127EMITEN-535979','ANJT','Austindo Nusantara Jaya Tbk.','-','-','191127SUBSECTOR-517685',1.00,0,1,'2019-11-27 04:09:13','2019-11-27 04:09:13'),
('191127EMITEN-536977','BBLD','Buana Finance Tbk.','-','-','191127SUBSECTOR-483476',1.00,0,1,'2019-11-27 14:15:53','2019-11-27 14:15:53'),
('191127EMITEN-541833','ACST','Acset Indonusa Tbk.','-','-','191127SUBSECTOR-975796',1.00,0,1,'2019-11-27 03:52:34','2019-11-27 03:52:34'),
('191127EMITEN-547783','BLTA','Berlian Laju Tanker Tbk.','-','-','191127SUBSECTOR-557134',1.00,0,1,'2019-11-27 14:29:14','2019-11-27 14:29:14'),
('191127EMITEN-551478','APII','Arita Prima Indonesia Tbk.','-','-','191127SUBSECTOR-654064',1.00,0,1,'2019-11-27 04:17:35','2019-11-27 04:17:35'),
('191127EMITEN-555416','BTPN','Bank Tabungan Pensiunan Nasional Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 15:05:55','2019-11-27 15:05:55'),
('191127EMITEN-562388','BSIM','Bank Sinarmas Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 15:02:36','2019-11-27 15:02:36'),
('191127EMITEN-562419','BNGA','Bank CIMB Niaga Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:57:36','2019-11-27 14:57:36'),
('191127EMITEN-570107','BASS','PT Bahtera Adimina Samudera Tbk.','-','-','191127SUBSECTOR-077679',1.00,0,1,'2019-11-27 14:12:37','2019-11-27 14:12:37'),
('191127EMITEN-579976','ASDM','Asuransi Dayin Mitra Tbk.','-','-','191127SUBSECTOR-391286',1.00,0,1,'2019-11-27 04:24:18','2019-11-27 04:24:18'),
('191127EMITEN-599487','BDMN','Bank Danamon Indonesia Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:22:39','2019-11-27 14:22:39'),
('191127EMITEN-635449','BBNP','Bank Nusantara Parahyangan Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:17:43','2019-11-27 14:17:43'),
('191127EMITEN-641426','BNBA','Bank Bumi Arta Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:56:04','2019-11-27 14:56:04'),
('191127EMITEN-649783','ARII','Atlas Resources Tbk','-','-','191127SUBSECTOR-636007',1.00,0,1,'2019-11-27 04:19:24','2019-11-27 04:19:24'),
('191127EMITEN-653485','BINA','Bank Ina Perdana Tbk','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:26:05','2019-11-27 14:26:05'),
('191127EMITEN-655632','ASBI','Asuransi Bintang Tbk.','-','-','191127SUBSECTOR-391286',1.00,0,1,'2019-11-27 04:21:05','2019-11-27 04:21:05'),
('191127EMITEN-675611','BPFI','Batavia Prosperindo Finance Tbk.','-','-','191127SUBSECTOR-483476',1.00,0,1,'2019-11-27 14:59:27','2019-11-27 14:59:27'),
('191127EMITEN-680453','ADRO','Adaro Energy Tbk.','-','-','191127SUBSECTOR-636007',1.00,0,1,'2019-11-27 03:54:28','2019-11-27 03:54:28'),
('191127EMITEN-704563','AMAG','Asuransi Multi Artha Guna Tbk.','-','-','191127SUBSECTOR-391286',1.00,0,1,'2019-11-27 04:08:24','2019-11-27 04:08:24'),
('191127EMITEN-705548','BSLT','PT BPD Sulawesi Utara (Bank Sulut)','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 15:02:50','2019-11-27 15:02:50'),
('191127EMITEN-708827','BAEK','Bank Ekonomi Raharja Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:04:30','2019-11-27 14:04:30'),
('191127EMITEN-713913','ASSA','Adi Sarana Armada Tbk.','-','-','191127SUBSECTOR-557134',1.00,0,1,'2019-11-27 13:31:11','2019-11-27 13:31:11'),
('191127EMITEN-714018','ALTO','Tri Banyan Tirta Tbk.','-','-','191127SUBSECTOR-533935',1.00,0,1,'2019-11-27 04:07:51','2019-11-27 04:07:51'),
('191127EMITEN-719161','BBRM','Pelayaran Nasional Bina Buana Raya Tbk.','-','-','191127SUBSECTOR-557134',1.00,0,1,'2019-11-27 14:19:31','2019-11-27 14:19:31'),
('191127EMITEN-720672','AKPI','Argha Karya Prima Industry Tbk.','-','-','191127SUBSECTOR-272056',1.00,0,1,'2019-11-27 03:57:52','2019-11-27 03:57:52'),
('191127EMITEN-735835','BDKI','PT Bank DKI','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:22:15','2019-11-27 14:22:15'),
('191127EMITEN-744404','BRPT','Barito Pacific Tbk.','-','-','191127SUBSECTOR-830769',1.00,0,1,'2019-11-27 15:01:14','2019-11-27 15:01:14'),
('191127EMITEN-744735','BUDI','Budi Starch & Sweetener Tbk.','-','-','191127SUBSECTOR-830769',1.00,0,1,'2019-11-27 15:06:14','2019-11-27 15:06:14'),
('191127EMITEN-744891','APLI','Asiaplast Industries Tbk.','-','-','191127SUBSECTOR-272056',1.00,0,1,'2019-11-27 04:17:54','2019-11-27 04:17:54'),
('191127EMITEN-752175','BMAS','Bank Maspion Indonesia Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:29:35','2019-11-27 14:29:35'),
('191127EMITEN-752722','BKDP','Bukit Darmo Property Tbk.','-','-','191127SUBSECTOR-077679',1.00,0,1,'2019-11-27 14:27:55','2019-11-27 14:27:55'),
('191127EMITEN-752824','ASIA','Asia Natural Resources Tbk.','-','-','191127SUBSECTOR-654064',1.00,0,1,'2019-11-27 04:25:52','2019-11-27 04:25:52'),
('191127EMITEN-758102','ASII','Astra International Tbk.','-','-','191127SUBSECTOR-541585',1.00,0,1,'2019-11-27 04:26:15','2019-11-27 04:26:15'),
('191127EMITEN-768502','BHIT','MNC Investama Tbk.','-','-','191127SUBSECTOR-417066',1.00,0,1,'2019-11-27 14:24:36','2019-11-27 14:24:36'),
('191127EMITEN-769053','ABBA','Mahaka Media Tbk.','-','-','191127SUBSECTOR-262365',1.00,0,1,'2019-11-27 03:46:16','2019-11-27 03:46:16'),
('191127EMITEN-774023','ADES','Akasha Wira International Tbk.','-','-','191127SUBSECTOR-533935',1.00,0,1,'2019-11-27 03:52:57','2019-11-27 03:52:57'),
('191127EMITEN-775282','ANTM','Aneka Tambang (Persero) Tbk.','-','-','191127SUBSECTOR-707402',1.00,1,1,'2019-11-27 04:09:37','2019-11-27 04:09:37'),
('191127EMITEN-790096','ASGR','Astra Graphia Tbk.','-','-','191127SUBSECTOR-282036',1.00,0,1,'2019-11-27 04:24:39','2019-11-27 04:24:39'),
('191127EMITEN-790823','BNBR','Bakrie & Brothers Tbk.','-','-','191127SUBSECTOR-417066',1.00,0,1,'2019-11-27 14:56:30','2019-11-27 14:56:30'),
('191127EMITEN-797219','BAYU','Bayu Buana Tbk.','-','-','191127SUBSECTOR-430043',1.00,0,1,'2019-11-27 14:14:39','2019-11-27 14:14:39'),
('191127EMITEN-799521','ASJT','Asuransi Jasa Tania Tbk.','-','-','191127SUBSECTOR-391286',1.00,0,1,'2019-11-27 04:26:39','2019-11-27 04:26:39'),
('191127EMITEN-804879','ADHI','Adhi Karya (Persero) Tbk.','-','-','191127SUBSECTOR-975796',1.00,1,1,'2019-11-27 03:53:24','2019-11-27 03:53:24'),
('191127EMITEN-805729','BIPI','Benakat Petroleum Energy Tbk.','-','-','191127SUBSECTOR-957417',1.00,0,1,'2019-11-27 14:26:20','2019-11-27 14:26:20'),
('191127EMITEN-811421','ABMM','ABM Investama Tbk.','-','-','191127SUBSECTOR-417066',1.00,0,1,'2019-11-27 03:48:01','2019-11-27 03:48:01'),
('191127EMITEN-815642','BBRI','Bank Rakyat Indonesia (Persero) Tbk.','-','-','191127SUBSECTOR-354838',1.00,1,1,'2019-11-27 14:18:01','2019-11-27 14:18:01'),
('191127EMITEN-826119','BEKS','Bank Pundi Indonesia Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:23:02','2019-11-27 14:23:02'),
('191127EMITEN-853406','BSMT','PT BPD Sumatera Utara (Bank Sumut)','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 15:03:05','2019-11-27 15:03:05'),
('191127EMITEN-854252','BCIC','Bank Mutiara Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:21:25','2019-11-27 14:21:25'),
('191127EMITEN-866984','AGII','PT Aneka Gas Industri','-','-','191127SUBSECTOR-957417',1.00,0,1,'2019-11-27 03:54:46','2019-11-27 03:54:46'),
('191127EMITEN-875195','ARNA','Arwana Citramulia Tbk.','-','-','191127SUBSECTOR-617823',1.00,0,1,'2019-11-27 04:19:47','2019-11-27 04:19:47'),
('191127EMITEN-897456','BSBR','PT Bank Pembangunan Daerah Sumatera Barat','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 15:01:29','2019-11-27 15:01:29'),
('191127EMITEN-919151','BBTN','Bank Tabungan Negara (Persero) Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:19:51','2019-11-27 14:19:51'),
('191127EMITEN-935442','BKSL','Sentul City Tbk.','-','-','191127SUBSECTOR-077679',1.00,0,1,'2019-11-27 14:28:13','2019-11-27 14:28:13'),
('191127EMITEN-954569','BAJA','Saranacentral Bajatama Tbk.','-','-','191127SUBSECTOR-429831',1.00,0,1,'2019-11-27 14:06:35','2019-11-27 14:06:35'),
('191127EMITEN-958989','BBCA','Bank Central Asia Tbk.','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 14:14:55','2019-11-27 14:14:55'),
('191127EMITEN-960011','ASRM','Asuransi Ramayana Tbk.','-','-','191127SUBSECTOR-391286',1.00,0,1,'2019-11-27 13:29:56','2019-11-27 13:29:56'),
('191127EMITEN-969277','BSSB','PT BPD Sulawesi Selatan Dan Barat (Bank Sulselbar)','-','-','191127SUBSECTOR-354838',1.00,0,1,'2019-11-27 15:03:16','2019-11-27 15:03:16'),
('191127EMITEN-975374','BIPP','Bhuwanatala Indah Permai Tbk.','-','-','191127SUBSECTOR-077679',1.00,0,1,'2019-11-27 14:26:37','2019-11-27 14:26:37'),
('191127EMITEN-978707','BIIF','PT BII Finance Center','-','-','191127SUBSECTOR-483476',1.00,0,1,'2019-11-27 14:24:57','2019-11-27 14:24:57'),
('191127EMITEN-985296','BRAM','Indo Kordsa Tbk.','-','-','191127SUBSECTOR-541585',1.00,0,1,'2019-11-27 14:59:45','2019-11-27 14:59:45'),
('191127EMITEN-998387','ACES','Ace Hardware Indonesia Tbk.','-','-','191127SUBSECTOR-517685',1.00,0,1,'2019-11-27 03:48:19','2019-11-27 03:48:19');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `financials` */

DROP TABLE IF EXISTS `financials`;

CREATE TABLE `financials` (
  `financialID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `emitenDataID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rasioID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currencyID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pricePerUnitCurrency` decimal(14,2) NOT NULL,
  `price` decimal(14,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`financialID`),
  KEY `financials_rasioid_foreign` (`rasioID`),
  KEY `financials_currencyid_foreign` (`currencyID`),
  KEY `financials_emitendataid_index` (`emitenDataID`),
  CONSTRAINT `financials_currencyid_foreign` FOREIGN KEY (`currencyID`) REFERENCES `currencies` (`currencyID`),
  CONSTRAINT `financials_emitendataid_foreign` FOREIGN KEY (`emitenDataID`) REFERENCES `emiten_datas` (`emitenDataID`),
  CONSTRAINT `financials_rasioid_foreign` FOREIGN KEY (`rasioID`) REFERENCES `rasioes` (`rasioID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `financials` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2019_08_19_000000_create_failed_jobs_table',1),
(4,'2019_11_15_124010_create_rasioes_table',1),
(5,'2019_11_15_124038_create_quartals_table',1),
(6,'2019_11_15_124054_create_currencies_table',1),
(7,'2019_11_15_124103_create_years_table',1),
(8,'2019_11_15_124113_create_sectors_table',1),
(9,'2019_11_15_124127_create_sub_sectors_table',1),
(10,'2019_11_15_124136_create_emitens_table',1),
(11,'2019_11_15_124146_create_emiten_datas_table',1),
(12,'2019_11_15_124156_create_financials_table',1),
(13,'2019_11_15_124206_create_directors_table',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `quartals` */

DROP TABLE IF EXISTS `quartals`;

CREATE TABLE `quartals` (
  `quartalID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quartalName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quartalCalculate` double(8,2) NOT NULL DEFAULT 1.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`quartalID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `quartals` */

insert  into `quartals`(`quartalID`,`quartalName`,`quartalCalculate`,`created_at`,`updated_at`) values 
('191127QUARTAL-159604','Q1',4.00,'2019-11-27 01:50:15','2019-11-27 01:50:15'),
('191127QUARTAL-201597','Q2',2.00,'2019-11-27 01:50:20','2019-11-27 01:50:20'),
('191127QUARTAL-272598','Q3',1.30,'2019-11-27 01:50:27','2019-11-27 01:50:27'),
('191127QUARTAL-318457','Q4',1.00,'2019-11-27 01:50:31','2019-11-27 01:50:31');

/*Table structure for table `rasioes` */

DROP TABLE IF EXISTS `rasioes`;

CREATE TABLE `rasioes` (
  `rasioID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rasioName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isFinancial` tinyint(1) NOT NULL DEFAULT 0,
  `isOwner` tinyint(1) NOT NULL DEFAULT 0,
  `isNeraca` tinyint(1) NOT NULL DEFAULT 0,
  `isLabaRugi` tinyint(1) NOT NULL DEFAULT 0,
  `isCashFlow` tinyint(1) NOT NULL DEFAULT 0,
  `isCFO` tinyint(1) NOT NULL DEFAULT 0,
  `isCFI` tinyint(1) NOT NULL DEFAULT 0,
  `isCFF` tinyint(1) NOT NULL DEFAULT 0,
  `isPBV` tinyint(1) NOT NULL DEFAULT 0,
  `isPER` tinyint(1) NOT NULL DEFAULT 0,
  `isEPS` tinyint(1) NOT NULL DEFAULT 0,
  `isROE` tinyint(1) NOT NULL DEFAULT 0,
  `isGPM` tinyint(1) NOT NULL DEFAULT 0,
  `isNPM` tinyint(1) NOT NULL DEFAULT 0,
  `isDER` tinyint(1) NOT NULL DEFAULT 0,
  `isTax` tinyint(1) NOT NULL DEFAULT 0,
  `isBVPS` tinyint(1) NOT NULL DEFAULT 0,
  `isCurrentRatio` tinyint(1) NOT NULL DEFAULT 0,
  `isQuickRatio` tinyint(1) NOT NULL DEFAULT 0,
  `isNWC` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`rasioID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `rasioes` */

/*Table structure for table `sectors` */

DROP TABLE IF EXISTS `sectors`;

CREATE TABLE `sectors` (
  `sectorID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sectorName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`sectorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sectors` */

insert  into `sectors`(`sectorID`,`sectorName`,`created_at`,`updated_at`) values 
('191127SECTOR-179627','Property, Real Estate, and Building Construction','2019-11-27 02:00:17','2019-11-27 02:00:17'),
('191127SECTOR-376098','Trade, Service, and Investment','2019-11-27 02:00:37','2019-11-27 02:00:37'),
('191127SECTOR-468635','Infrastructure, Utilities, and Transportation','2019-11-27 01:59:06','2019-11-27 01:59:06'),
('191127SECTOR-520712','Agriculture','2019-11-27 01:57:32','2019-11-27 01:57:32'),
('191127SECTOR-620909','Mining','2019-11-27 01:59:22','2019-11-27 01:59:22'),
('191127SECTOR-744196','Basic Industry and Chemicals','2019-11-27 01:57:54','2019-11-27 01:57:54'),
('191127SECTOR-879755','Consumer Goods Industry','2019-11-27 01:58:07','2019-11-27 01:58:07'),
('191127SECTOR-908599','Miscellaneous Industry','2019-11-27 01:59:50','2019-11-27 01:59:50'),
('191127SECTOR-971529','Finance','2019-11-27 01:58:17','2019-11-27 01:58:17');

/*Table structure for table `sub_sectors` */

DROP TABLE IF EXISTS `sub_sectors`;

CREATE TABLE `sub_sectors` (
  `subSectorID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subSectorName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sectorID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`subSectorID`),
  KEY `sub_sectors_sectorid_foreign` (`sectorID`),
  CONSTRAINT `sub_sectors_sectorid_foreign` FOREIGN KEY (`sectorID`) REFERENCES `sectors` (`sectorID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sub_sectors` */

insert  into `sub_sectors`(`subSectorID`,`subSectorName`,`sectorID`,`created_at`,`updated_at`) values 
('191127SUBSECTOR-014662','Electronics','191127SECTOR-908599','2019-11-27 03:16:41','2019-11-27 03:16:41'),
('191127SUBSECTOR-016061','Plantation','191127SECTOR-520712','2019-11-27 02:33:21','2019-11-27 02:33:21'),
('191127SUBSECTOR-052959','Others - Consumer Goods Industry','191127SECTOR-879755','2019-11-27 03:38:25','2019-11-27 03:38:25'),
('191127SUBSECTOR-077679','Property And Real Estate','191127SECTOR-179627','2019-11-27 03:13:27','2019-11-27 03:13:27'),
('191127SUBSECTOR-163955','Cosmetics And Household','191127SECTOR-879755','2019-11-27 03:36:56','2019-11-27 03:36:56'),
('191127SUBSECTOR-175421','Cement','191127SECTOR-744196','2019-11-27 03:40:17','2019-11-27 03:40:17'),
('191127SUBSECTOR-190542','Textile, Garment','191127SECTOR-908599','2019-11-27 03:15:19','2019-11-27 03:15:19'),
('191127SUBSECTOR-230385','Healthcare','191127SECTOR-376098','2019-11-27 03:12:03','2019-11-27 03:12:03'),
('191127SUBSECTOR-257615','Investment Fund','191127SECTOR-971529','2019-11-27 03:35:25','2019-11-27 03:35:25'),
('191127SUBSECTOR-259878','Other - Agriculture','191127SECTOR-520712','2019-11-27 02:35:25','2019-11-27 02:35:25'),
('191127SUBSECTOR-262365','Advertising, Printing And Media','191127SECTOR-376098','2019-11-27 03:07:06','2019-11-27 03:07:06'),
('191127SUBSECTOR-264038','Others - Miscellaneous Industry','191127SECTOR-908599','2019-11-27 03:17:06','2019-11-27 03:17:06'),
('191127SUBSECTOR-272056','Plastics & Packaging','191127SECTOR-744196','2019-11-27 03:38:47','2019-11-27 03:38:47'),
('191127SUBSECTOR-282036','Computer And Services','191127SECTOR-376098','2019-11-27 03:08:48','2019-11-27 03:08:48'),
('191127SUBSECTOR-349859','Pulp & Paper','191127SECTOR-744196','2019-11-27 03:38:54','2019-11-27 03:38:54'),
('191127SUBSECTOR-354838','Bank','191127SECTOR-971529','2019-11-27 03:29:14','2019-11-27 03:29:14'),
('191127SUBSECTOR-391286','Insurance','191127SECTOR-971529','2019-11-27 03:28:59','2019-11-27 03:28:59'),
('191127SUBSECTOR-417066','Investment Company','191127SECTOR-376098','2019-11-27 03:07:21','2019-11-27 03:07:21'),
('191127SUBSECTOR-429831','Metal And Allied Products','191127SECTOR-744196','2019-11-27 03:39:02','2019-11-27 03:39:02'),
('191127SUBSECTOR-430043','Tourism, Restaurant And  Hotel','191127SECTOR-376098','2019-11-27 03:09:03','2019-11-27 03:09:03'),
('191127SUBSECTOR-468706','Energy','191127SECTOR-468635','2019-11-27 03:25:46','2019-11-27 03:25:46'),
('191127SUBSECTOR-483476','Financial Institution','191127SECTOR-971529','2019-11-27 03:29:08','2019-11-27 03:29:08'),
('191127SUBSECTOR-500623','Footwear','191127SECTOR-908599','2019-11-27 03:15:50','2019-11-27 03:15:50'),
('191127SUBSECTOR-517685','Retail Trade','191127SECTOR-376098','2019-11-27 03:07:31','2019-11-27 03:07:31'),
('191127SUBSECTOR-525196','Cable','191127SECTOR-908599','2019-11-27 03:15:25','2019-11-27 03:15:25'),
('191127SUBSECTOR-533935','Food And Beverages','191127SECTOR-879755','2019-11-27 03:35:53','2019-11-27 03:35:53'),
('191127SUBSECTOR-541585','Automotive And Components','191127SECTOR-908599','2019-11-27 03:15:41','2019-11-27 03:15:41'),
('191127SUBSECTOR-554895','Animal Husbandry','191127SECTOR-520712','2019-11-27 02:34:15','2019-11-27 02:34:15'),
('191127SUBSECTOR-557134','Transportation','191127SECTOR-468635','2019-11-27 03:24:15','2019-11-27 03:24:15'),
('191127SUBSECTOR-611624','Others - Basic Industry and Chemicals','191127SECTOR-744196','2019-11-27 03:41:56','2019-11-27 03:41:56'),
('191127SUBSECTOR-617823','Ceramics, Glass, Porcelain','191127SECTOR-744196','2019-11-27 03:39:21','2019-11-27 03:39:21'),
('191127SUBSECTOR-636007','Coal Mining','191127SECTOR-620909','2019-11-27 02:43:56','2019-11-27 02:43:56'),
('191127SUBSECTOR-649975','Land / Stone Quarrying','191127SECTOR-620909','2019-11-27 03:04:25','2019-11-27 03:04:25'),
('191127SUBSECTOR-652198','Others - Property, Real Estate, and Building Construction','191127SECTOR-179627','2019-11-27 03:14:25','2019-11-27 03:14:25'),
('191127SUBSECTOR-654064','Wholesale (Durable & Non-Durable Goods)','191127SECTOR-376098','2019-11-27 03:07:45','2019-11-27 03:07:45'),
('191127SUBSECTOR-668677','Securities Company','191127SECTOR-971529','2019-11-27 03:29:26','2019-11-27 03:29:26'),
('191127SUBSECTOR-686701','Wood Industries','191127SECTOR-744196','2019-11-27 03:41:08','2019-11-27 03:41:08'),
('191127SUBSECTOR-694493','Telecommunication','191127SECTOR-468635','2019-11-27 03:24:29','2019-11-27 03:24:29'),
('191127SUBSECTOR-707402','Metal and Mineral Mining','191127SECTOR-620909','2019-11-27 02:59:30','2019-11-27 02:59:30'),
('191127SUBSECTOR-717916','Pharmaceuticals','191127SECTOR-879755','2019-11-27 03:36:11','2019-11-27 03:36:11'),
('191127SUBSECTOR-750814','Fishery','191127SECTOR-520712','2019-11-27 02:34:35','2019-11-27 02:34:35'),
('191127SUBSECTOR-796288','Houseware','191127SECTOR-879755','2019-11-27 03:36:36','2019-11-27 03:36:36'),
('191127SUBSECTOR-798425','Toll Road, Airport, Harbor And Allied Products','191127SECTOR-468635','2019-11-27 03:24:39','2019-11-27 03:24:39'),
('191127SUBSECTOR-810866','Tobacco Manufacturers','191127SECTOR-879755','2019-11-27 03:36:21','2019-11-27 03:36:21'),
('191127SUBSECTOR-824785','Others - Finance','191127SECTOR-971529','2019-11-27 03:29:42','2019-11-27 03:29:42'),
('191127SUBSECTOR-828364','Others - Mining','191127SECTOR-620909','2019-11-27 03:04:42','2019-11-27 03:04:42'),
('191127SUBSECTOR-830769','Chemicals','191127SECTOR-744196','2019-11-27 03:39:43','2019-11-27 03:39:43'),
('191127SUBSECTOR-841382','Machinery And Heavy Equipment','191127SECTOR-908599','2019-11-27 03:16:24','2019-11-27 03:16:24'),
('191127SUBSECTOR-851392','Crops','191127SECTOR-520712','2019-11-27 02:33:05','2019-11-27 02:33:05'),
('191127SUBSECTOR-900529','Others - Infrastructure, Utilities, and Transportation','191127SECTOR-468635','2019-11-27 03:26:30','2019-11-27 03:26:30'),
('191127SUBSECTOR-948507','Non Building Construction','191127SECTOR-468635','2019-11-27 03:24:54','2019-11-27 03:24:54'),
('191127SUBSECTOR-951969','Animal Feed','191127SECTOR-744196','2019-11-27 03:39:55','2019-11-27 03:39:55'),
('191127SUBSECTOR-957417','Crude Petroleum & Natural Gas Production','191127SECTOR-620909','2019-11-27 03:03:15','2019-11-27 03:03:15'),
('191127SUBSECTOR-973641','Others - Trade, Service, and Investment','191127SECTOR-376098','2019-11-27 03:09:57','2019-11-27 03:09:57'),
('191127SUBSECTOR-975796','Building Construction','191127SECTOR-179627','2019-11-27 03:13:17','2019-11-27 03:13:17'),
('191127SUBSECTOR-980357','Forestry','191127SECTOR-520712','2019-11-27 02:34:58','2019-11-27 02:34:58');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `userID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT 0,
  `isMaster` tinyint(1) NOT NULL DEFAULT 0,
  `isFA` tinyint(1) NOT NULL DEFAULT 0,
  `isCreate` tinyint(1) NOT NULL DEFAULT 0,
  `isUpdate` tinyint(1) NOT NULL DEFAULT 0,
  `isDelete` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

/*Table structure for table `years` */

DROP TABLE IF EXISTS `years`;

CREATE TABLE `years` (
  `yearID` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `yearName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`yearID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `years` */

insert  into `years`(`yearID`,`yearName`,`created_at`,`updated_at`) values 
('191127YEAR-406175','2019','2019-11-27 01:50:40','2019-11-27 01:50:40'),
('191127YEAR-444237','2018','2019-11-27 01:50:44','2019-11-27 01:50:44'),
('191127YEAR-496539','2017','2019-11-27 01:50:49','2019-11-27 01:50:49'),
('191127YEAR-532198','2016','2019-11-27 01:50:53','2019-11-27 01:50:53'),
('191127YEAR-581548','2015','2019-11-27 01:50:58','2019-11-27 01:50:58');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
