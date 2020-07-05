-- MySQL dump 10.13  Distrib 5.7.24, for Win64 (x86_64)
--
-- Host: 134.122.107.73    Database: drivencook
-- ------------------------------------------------------
-- Server version	5.7.30-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `breakdown`
--

DROP TABLE IF EXISTS `breakdown`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `breakdown` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('Batterie','Moteur','Alternateur','Freins','Refroidissement','Autre') DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` enum('Signalée','Réparation en cours','Réparée') DEFAULT NULL,
  `truck_id` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `breakdown_truck_id_fk` (`truck_id`),
  CONSTRAINT `breakdown_truck_id_fk` FOREIGN KEY (`truck_id`) REFERENCES `truck` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `breakdown`
--

LOCK TABLES `breakdown` WRITE;
/*!40000 ALTER TABLE `breakdown` DISABLE KEYS */;
INSERT INTO `breakdown` (`id`, `type`, `description`, `cost`, `date`, `status`, `truck_id`, `updated_at`) VALUES (1,'Batterie','blabla',100.01,'2020-03-03','Réparée',2,'2020-05-13 13:44:59'),(2,'Moteur','blabloutoutou',260.9,'2020-05-01','Signalée',2,'2020-07-05 15:59:32'),(4,'Batterie',NULL,5,'2020-07-05','Signalée',2,NULL);
/*!40000 ALTER TABLE `breakdown` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dish`
--

DROP TABLE IF EXISTS `dish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `category` enum('hot_dish','cold_dish','salty_snack','sweet_snack','drink') DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `diet` enum('none','vegetarian','vegan') DEFAULT 'none',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dish`
--

LOCK TABLES `dish` WRITE;
/*!40000 ALTER TABLE `dish` DISABLE KEYS */;
INSERT INTO `dish` (`id`, `name`, `category`, `description`, `diet`, `created_at`, `updated_at`) VALUES (1,'Frites','hot_dish','On est pas chez McDo en tout cas.','none',NULL,'2020-05-02 20:47:40'),(3,'Salade','cold_dish','Attention aux escargots !','vegan',NULL,NULL),(4,'Coca','drink','C\'est du coca sans le cola','vegan',NULL,'2020-05-13 12:02:11'),(8,'Coca3','drink','C\'est pas le vrai mais...','none',NULL,'2020-05-04 13:49:19'),(10,'Coca1000','drink','C\'est du coca mais 1000 fois mieux','none',NULL,NULL),(42,'Coca Cola','drink','Rien que le vrai','vegetarian',NULL,'2020-05-12 21:48:20'),(45,'Lasagnes','hot_dish','Le bon plat de ta maman','none','2020-05-12 22:15:37','2020-05-12 22:29:48'),(47,'Test','hot_dish','Ceci n\'est pas un plat','vegetarian','2020-05-12 22:21:46','2020-05-12 22:21:46'),(48,'Sprite','drink','De la limonade, mais en mieux.','vegetarian','2020-05-12 22:30:17','2020-05-12 22:30:17'),(49,'OrangeBleue22','salty_snack','OrangeBleue mais nouvelle version','vegan',NULL,'2020-07-05 00:52:31'),(50,'OrangeBleue1','cold_dish','OrangeBleue','none',NULL,NULL),(51,'OrangeBleue2','cold_dish','OrangeBleue','none',NULL,NULL),(52,'OrangeBleue3','cold_dish','OrangeBleue','none',NULL,NULL),(53,'OrangeBleue4','cold_dish','OrangeBleue','none',NULL,NULL),(54,'OrangeBleue5','cold_dish','OrangeBleue','none',NULL,NULL),(55,'OrangeBleue6','cold_dish','OrangeBleue','none',NULL,NULL),(56,'OrangeBleue7','cold_dish','OrangeBleue','none',NULL,NULL),(57,'OrangeBleue8','cold_dish','OrangeBleue','none',NULL,NULL),(58,'OrangeBleue9','cold_dish','OrangeBleue','none',NULL,NULL),(60,'Bim boum','sweet_snack','Wouhou','none','2020-07-05 00:52:54','2020-07-05 00:52:54'),(61,'Miam','hot_dish','Miam miam','none','2020-07-05 02:34:57','2020-07-05 02:34:57'),(62,'plop','hot_dish',NULL,'none','2020-07-05 02:37:45','2020-07-05 02:37:45'),(64,'bbbbC','cold_dish',NULL,'none','2020-07-05 02:38:47','2020-07-05 02:40:13'),(65,'cc','salty_snack',NULL,'vegan','2020-07-05 02:39:21','2020-07-05 02:39:21');
/*!40000 ALTER TABLE `dish` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('news','public','private') NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_location_id_fk` (`location_id`),
  KEY `event_user_id_fk` (`user_id`),
  CONSTRAINT `event_location_id_fk` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  CONSTRAINT `event_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` (`id`, `type`, `date_start`, `date_end`, `title`, `description`, `location_id`, `user_id`, `updated_at`) VALUES (1,'public','2020-06-20','2020-06-30','Publique','Nous le savons, Le Petit Larousse et Le Robert ont progressivement intégré un certain nombre de modifications issues de la « réforme » orthographique de 1990. Cependant, la graphie « évènement » n’est pas apparue en 1990. Elle a été admise par l’Académie française dès 1979, ce qui suppose un emploi bien antérieur, en particulier dans la littérature. La « réforme » orthographique de 1990 n’a fait qu’entériner une modification en usage depuis (au moins !) dix ans…\r\n\r\nMais revenons à nos dictionnaires dans lesquels on peut lire, à l’entrée événement : « événement ou évènement ». Comme le souligne malicieusement Bruno Dewaele, Le Robert n’a intégré « évènement » que dans l’édition de 2009, alors que Larousse cautionnait l’accent grave depuis plusieurs années déjà.\r\n\r\nQuoi qu’il en soit, nos deux bibles de la langue française ne se mouillent pas : « évènement » est présenté comme variante orthographique d’événement. Le lecteur a donc le choix d’employer l’un ou l’autre… sans risquer de commettre une faute !',1,3,NULL),(6,'private','2020-07-10','2020-07-10','Soutenance PA','Et ouais c\'est bientôt déjà ...\r\n:\'-(',47,3,'2020-06-22 20:02:50'),(7,'news','2020-06-22','2020-06-24','news 1','Nous le savons, Le Petit Larousse et Le Robert ont progressivement intégré un certain nombre de modifications issues de la « réforme » orthographique de 1990. Cependant, la graphie « évènement » n’est pas apparue en 1990. Elle a été admise par l’Académie française dès 1979, ce qui suppose un emploi bien antérieur, en particulier dans la littérature. La « réforme » orthographique de 1990 n’a fait qu’entériner une modification en usage depuis (au moins !) dix ans…\r\n\r\nMais revenons à nos dictionnaires dans lesquels on peut lire, à l’entrée événement : « événement ou évènement ». Comme le souligne malicieusement Bruno Dewaele, Le Robert n’a intégré « évènement » que dans l’édition de 2009, alors que Larousse cautionnait l’accent grave depuis plusieurs années déjà.\r\n\r\nQuoi qu’il en soit, nos deux bibles de la langue française ne se mouillent pas : « évènement » est présenté comme variante orthographique d’événement. Le lecteur a donc le choix d’employer l’un ou l’autre… sans risquer de commettre une faute !',47,3,NULL),(8,'news','2020-06-23','2020-06-28','news 2','Nous le savons, Le Petit Larousse et Le Robert ont progressivement intégré un certain nombre de modifications issues de la « réforme » orthographique de 1990. Cependant, la graphie « évènement » n’est pas apparue en 1990. Elle a été admise par l’Académie française dès 1979, ce qui suppose un emploi bien antérieur, en particulier dans la littérature. La « réforme » orthographique de 1990 n’a fait qu’entériner une modification en usage depuis (au moins !) dix ans…\r\n\r\nMais revenons à nos dictionnaires dans lesquels on peut lire, à l’entrée événement : « événement ou évènement ». Comme le souligne malicieusement Bruno Dewaele, Le Robert n’a intégré « évènement » que dans l’édition de 2009, alors que Larousse cautionnait l’accent grave depuis plusieurs années déjà.\r\n\r\nQuoi qu’il en soit, nos deux bibles de la langue française ne se mouillent pas : « évènement » est présenté comme variante orthographique d’événement. Le lecteur a donc le choix d’employer l’un ou l’autre… sans risquer de commettre une faute !',4,3,'2020-06-24 15:19:53'),(9,'private','2020-07-05','2020-07-05','Rendu PA','Rendu du projet PA à cette date là :-\'(',47,3,'2020-07-05 16:38:16');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_invited`
--

DROP TABLE IF EXISTS `event_invited`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_invited` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`event_id`,`user_id`),
  KEY `event_invited_user_id_fk` (`user_id`),
  CONSTRAINT `event_invited_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  CONSTRAINT `event_invited_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_invited`
--

LOCK TABLES `event_invited` WRITE;
/*!40000 ALTER TABLE `event_invited` DISABLE KEYS */;
INSERT INTO `event_invited` (`event_id`, `user_id`) VALUES (9,2),(6,7),(9,7),(6,503),(9,503),(6,507),(9,507);
/*!40000 ALTER TABLE `event_invited` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fidelity_step`
--

DROP TABLE IF EXISTS `fidelity_step`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fidelity_step` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `step` int(11) NOT NULL,
  `reduction` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fidelity_step_user_id_fk` (`user_id`),
  CONSTRAINT `fidelity_step_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fidelity_step`
--

LOCK TABLES `fidelity_step` WRITE;
/*!40000 ALTER TABLE `fidelity_step` DISABLE KEYS */;
INSERT INTO `fidelity_step` (`id`, `step`, `reduction`, `user_id`) VALUES (19,50,10,7),(20,100,25,7),(21,150,40,7),(22,200,60,7),(24,5,5,3),(28,10,7,3);
/*!40000 ALTER TABLE `fidelity_step` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `franchise_obligation`
--

DROP TABLE IF EXISTS `franchise_obligation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `franchise_obligation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_updated` date DEFAULT NULL,
  `entrance_fee` float DEFAULT NULL,
  `revenue_percentage` float DEFAULT NULL,
  `warehouse_percentage` float DEFAULT NULL,
  `billing_day` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `franchise_obligation_user_id_fk` (`user_id`),
  CONSTRAINT `franchise_obligation_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `franchise_obligation`
--

LOCK TABLES `franchise_obligation` WRITE;
/*!40000 ALTER TABLE `franchise_obligation` DISABLE KEYS */;
INSERT INTO `franchise_obligation` (`id`, `date_updated`, `entrance_fee`, `revenue_percentage`, `warehouse_percentage`, `billing_day`, `user_id`) VALUES (13,'2020-05-08',25000,50,25,5,475),(14,'2020-05-09',50.5,50,25,5,475),(15,'2020-05-09',10.11,50,25,5,503),(16,'2020-05-09',50000,4.3,2.5,5,503),(17,'2020-05-09',100.1,5.5,2.2,5,503),(18,'2020-05-09',200.2,4.4,8.8,5,503),(19,'2020-05-09',200.21,4.4,8.8,5,503),(20,'2020-05-09',50000,4,20,5,503),(21,'2020-06-06',50000,4,20,5,503),(22,'2020-06-06',50000,4,20,5,503),(23,'2020-06-06',50000,4,20,5,503),(24,'2020-06-06',50000,4,20,5,475),(25,'2020-06-06',50000,4,20,5,503),(26,'2020-06-06',50000,4,20,5,475),(27,'2020-06-06',50000,4,20,5,503),(28,'2020-06-06',50000,4,20,5,475),(29,'2020-06-06',50000,4,20,5,475),(30,'2020-06-06',50000,28,20,5,475),(31,'2020-07-05',50000,28,20,5,475),(32,'2020-07-05',50000.1,28.09,20.01,5,475);
/*!40000 ALTER TABLE `franchise_obligation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `franchisee_stock`
--

DROP TABLE IF EXISTS `franchisee_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `franchisee_stock` (
  `user_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` float DEFAULT NULL,
  `menu` tinyint(1) NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`dish_id`),
  KEY `stock_dish_id_fk` (`dish_id`),
  CONSTRAINT `stock_dish_id_fk` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`id`),
  CONSTRAINT `stock_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `franchisee_stock`
--

LOCK TABLES `franchisee_stock` WRITE;
/*!40000 ALTER TABLE `franchisee_stock` DISABLE KEYS */;
INSERT INTO `franchisee_stock` (`user_id`, `dish_id`, `quantity`, `unit_price`, `menu`, `updated_at`) VALUES (7,1,5983,4.99,1,'2020-07-04 21:25:19'),(7,3,199,7.99,1,'2020-07-04 18:44:49'),(7,50,59,2,1,'2020-07-04 18:44:49'),(7,51,80,2,1,'2020-07-03 16:45:42'),(7,52,100,2,0,NULL),(7,53,100,2,0,NULL),(7,54,10,2,0,NULL),(7,55,500,2,1,'2020-07-02 17:42:54'),(7,56,10,2,0,NULL),(7,57,10,2,0,NULL),(7,58,10,2,0,NULL),(503,1,487,5.02,1,'2020-07-05 00:36:43');
/*!40000 ALTER TABLE `franchisee_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` float DEFAULT NULL,
  `discount_amount` int(11) DEFAULT NULL,
  `date_emitted` date DEFAULT NULL,
  `date_paid` date DEFAULT NULL,
  `reference` varchar(15) DEFAULT NULL,
  `monthly_fee` tinyint(1) DEFAULT NULL,
  `initial_fee` tinyint(1) DEFAULT NULL,
  `franchisee_order` int(11) DEFAULT NULL,
  `client_order` int(11) DEFAULT NULL,
  `status` enum('to_pay','paid','cancelled') DEFAULT 'to_pay',
  `user_id` int(11) NOT NULL,
  `purchase_order_id` int(11) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_user_id_fk` (`user_id`),
  KEY `invoice_purchase_order_id_fk` (`purchase_order_id`),
  KEY `invoice_sale_id_fk` (`sale_id`),
  CONSTRAINT `invoice_purchase_order_id_fk` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_order` (`id`),
  CONSTRAINT `invoice_sale_id_fk` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`),
  CONSTRAINT `invoice_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
INSERT INTO `invoice` (`id`, `amount`, `discount_amount`, `date_emitted`, `date_paid`, `reference`, `monthly_fee`, `initial_fee`, `franchisee_order`, `client_order`, `status`, `user_id`, `purchase_order_id`, `sale_id`, `created_at`, `updated_at`) VALUES (29,25,NULL,'2020-05-08',NULL,'MF-7-29        ',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-08 22:35:17','2020-05-08 22:35:17'),(30,25,NULL,'2020-05-08',NULL,'MF-7-0000000030',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-08 22:36:01','2020-05-08 22:36:01'),(31,25000,NULL,'2020-05-08',NULL,'IF-486-00000031',0,1,0,NULL,'to_pay',486,NULL,NULL,'2020-05-08 22:38:39','2020-05-08 22:38:39'),(32,25,NULL,'2020-05-08',NULL,'MF-7-0000000032',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-08 22:47:16','2020-05-08 22:47:16'),(33,25,NULL,'2020-05-08',NULL,'MF-7-0000000033',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-08 22:47:31','2020-05-08 22:47:31'),(34,25,NULL,'2020-05-08',NULL,'MF-7-0000000034',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-08 22:48:19','2020-05-08 22:48:19'),(35,25,NULL,'2020-05-08',NULL,'MF-7-0000000035',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-08 22:48:39','2020-05-08 22:48:39'),(36,25,NULL,'2020-05-08',NULL,'MF-7-0000000036',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-08 22:48:54','2020-05-08 22:48:54'),(37,25,NULL,'2020-05-08',NULL,'MF-7-0000000037',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-08 22:51:03','2020-05-08 22:51:03'),(38,25,NULL,'2020-05-08',NULL,'MF-7-0000000038',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-08 22:51:30','2020-05-08 22:51:31'),(39,25,NULL,'2020-05-08',NULL,'MF-7-0000000039',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-08 22:53:07','2020-05-08 22:53:07'),(40,25,NULL,'2020-05-08',NULL,'MF-7-0000000040',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-08 22:57:37','2020-05-08 22:57:37'),(41,25,NULL,'2020-05-08',NULL,'MF-7-0000000041',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-08 22:58:21','2020-05-08 22:58:21'),(42,25,NULL,'2020-05-08',NULL,'MF-7-0000000042',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-08 22:58:51','2020-05-08 22:58:51'),(43,25,NULL,'2020-05-08',NULL,'MF-7-0000000043',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-08 22:59:44','2020-05-08 22:59:44'),(44,25000,NULL,'2020-05-08',NULL,'IF-487-00000044',0,1,0,NULL,'to_pay',487,NULL,NULL,'2020-05-08 23:13:21','2020-05-08 23:13:21'),(45,25000,NULL,'2020-05-09',NULL,'IF-488-00000045',0,1,0,NULL,'to_pay',488,NULL,NULL,'2020-05-09 12:21:50','2020-05-09 12:21:50'),(47,25000,NULL,'2020-05-09',NULL,'IF-490-00000047',0,1,0,NULL,'to_pay',490,NULL,NULL,'2020-05-09 12:31:40','2020-05-09 12:31:40'),(48,25000,NULL,'2020-05-09',NULL,'IF-491-00000048',0,1,0,NULL,'to_pay',491,NULL,NULL,'2020-05-09 12:36:16','2020-05-09 12:36:16'),(49,25000,NULL,'2020-05-09',NULL,'IF-492-00000049',0,1,0,NULL,'to_pay',492,NULL,NULL,'2020-05-09 12:37:53','2020-05-09 12:37:53'),(50,25,NULL,'2020-05-09',NULL,'MF-7-0000000050',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-09 12:38:51','2020-05-09 12:38:51'),(51,25000,NULL,'2020-05-09',NULL,'IF-493-00000051',0,1,0,NULL,'to_pay',493,NULL,NULL,'2020-05-09 12:53:27','2020-05-09 12:53:27'),(52,200.21,NULL,'2020-05-09',NULL,'IF-494-00000052',0,1,0,NULL,'to_pay',494,NULL,NULL,'2020-05-09 13:17:04','2020-05-09 13:17:04'),(53,50000,NULL,'2020-05-09',NULL,'IF-495-00000053',0,1,0,NULL,'to_pay',495,NULL,NULL,'2020-05-09 13:23:43','2020-05-09 13:23:43'),(55,50000,NULL,'2020-05-09',NULL,'IF-497-00000055',0,1,0,NULL,'to_pay',497,NULL,NULL,'2020-05-09 13:50:00','2020-05-09 13:50:00'),(56,2,NULL,'2020-05-09',NULL,'MF-7-0000000056',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-09 13:52:29','2020-05-09 13:52:29'),(62,7.32,NULL,'2020-05-09',NULL,'MF-7-0000000062',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-09 20:55:31','2020-05-09 20:55:32'),(63,21.52,NULL,'2020-05-09',NULL,'MF-9-0000000063',1,0,0,NULL,'to_pay',9,NULL,NULL,'2020-05-09 20:55:32','2020-05-09 20:55:32'),(64,7.32,NULL,'2020-05-09',NULL,'MF-7-0000000064',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-09 20:58:11','2020-05-09 20:58:11'),(65,21.52,NULL,'2020-05-09',NULL,'MF-9-0000000065',1,0,0,NULL,'to_pay',9,NULL,NULL,'2020-05-09 20:58:11','2020-05-09 20:58:11'),(66,50000,NULL,'2020-05-12',NULL,'IF-498-00000066',0,1,0,NULL,'cancelled',498,NULL,NULL,'2020-05-12 22:11:39','2020-07-05 12:15:11'),(67,50000,NULL,'2020-05-12',NULL,'IF-499-00000067',0,1,0,NULL,'to_pay',499,NULL,NULL,'2020-05-12 23:14:33','2020-05-12 23:14:33'),(68,50000,NULL,'2020-05-12',NULL,'IF-500-00000068',0,1,0,NULL,'to_pay',500,NULL,NULL,'2020-05-12 23:15:55','2020-05-12 23:15:55'),(69,50000,NULL,'2020-05-14','2020-06-05','IF-503-00000069',0,1,0,NULL,'paid',503,NULL,NULL,'2020-05-14 19:34:25','2020-05-14 19:34:25'),(70,24,NULL,'2020-05-24',NULL,'RS-503-00000070',0,0,1,NULL,'to_pay',503,NULL,NULL,'2020-05-24 21:51:08','2020-05-24 21:51:08'),(71,9,NULL,'2020-05-24',NULL,'RS-503-00000071',0,0,1,NULL,'to_pay',503,NULL,NULL,'2020-05-24 21:55:27','2020-05-24 21:55:27'),(72,24,NULL,'2020-05-24',NULL,'RS-503-00000072',0,0,1,NULL,'to_pay',503,NULL,NULL,'2020-05-24 22:02:18','2020-05-24 22:02:18'),(75,50000,NULL,'2020-05-25',NULL,'IF-508-00000075',0,1,0,NULL,'to_pay',508,NULL,NULL,'2020-05-25 20:33:50','2020-05-25 20:33:50'),(76,50000,NULL,'2020-05-25',NULL,'IF-509-00000076',0,1,0,NULL,'to_pay',509,NULL,NULL,'2020-05-25 20:35:17','2020-05-25 20:35:17'),(77,50000,NULL,'2020-05-25',NULL,'IF-510-00000077',0,1,0,NULL,'to_pay',510,NULL,NULL,'2020-05-25 20:36:14','2020-05-25 20:36:14'),(78,50000,NULL,'2020-05-25',NULL,'IF-511-00000078',0,1,0,NULL,'to_pay',511,NULL,NULL,'2020-05-25 20:37:05','2020-05-25 20:37:05'),(79,50000,NULL,'2020-05-25',NULL,'IF-512-00000079',0,1,0,NULL,'to_pay',512,NULL,NULL,'2020-05-25 20:38:35','2020-05-25 20:38:35'),(80,50000,NULL,'2020-05-25',NULL,'IF-513-00000080',0,1,0,NULL,'to_pay',513,NULL,NULL,'2020-05-25 20:39:19','2020-05-25 20:39:19'),(83,1.2,NULL,'2020-05-25',NULL,'MF-7-0000000083',1,0,0,NULL,'to_pay',7,NULL,NULL,'2020-05-25 20:45:17','2020-05-25 20:45:17'),(84,22.48,NULL,'2020-05-25',NULL,'MF-9-0000000084',1,0,0,NULL,'to_pay',9,NULL,NULL,'2020-05-25 20:45:18','2020-05-25 20:45:18'),(85,50000,NULL,'2020-05-25',NULL,'IF-514-00000085',0,1,0,NULL,'to_pay',514,NULL,NULL,'2020-05-25 21:34:19','2020-05-25 21:34:19'),(87,50000,NULL,'2020-05-26',NULL,'IF-515-00000087',0,1,0,NULL,'to_pay',515,NULL,NULL,'2020-05-26 22:32:43','2020-05-26 22:32:44'),(88,50000,NULL,'2020-06-07',NULL,'IF-516-00000088',0,1,0,NULL,'to_pay',516,NULL,NULL,'2020-06-07 15:36:49','2020-06-07 15:36:49'),(89,65,NULL,'2020-07-01',NULL,'RS-503-00000089',0,0,1,NULL,'paid',503,37,NULL,'2020-07-01 20:16:49','2020-07-03 18:12:18'),(90,2,NULL,'2020-07-02',NULL,'CL-475-00000090',0,0,0,NULL,'to_pay',7,NULL,85,'2020-07-02 17:40:15','2020-07-02 17:40:15'),(91,14,NULL,'2020-07-02',NULL,'CL-475-00000091',0,0,0,NULL,'to_pay',7,NULL,87,'2020-07-02 17:42:54','2020-07-02 17:42:55'),(92,9.98,NULL,'2020-07-02',NULL,'CL-475-00000092',0,0,0,NULL,'to_pay',7,NULL,88,'2020-07-02 17:52:55','2020-07-02 17:52:55'),(93,9.98,NULL,'2020-07-02',NULL,'CL-475-00000093',0,0,0,NULL,'to_pay',7,NULL,89,'2020-07-02 17:58:24','2020-07-02 17:58:24'),(94,4.99,NULL,'2020-07-02',NULL,'CL-475-00000094',0,0,0,NULL,'to_pay',7,NULL,90,'2020-07-02 17:59:26','2020-07-02 17:59:26'),(95,4.99,NULL,'2020-07-02',NULL,'CL-475-00000095',0,0,0,1,'to_pay',7,NULL,91,'2020-07-02 18:00:11','2020-07-02 18:00:11'),(96,4.99,NULL,'2020-07-02',NULL,'CL-475-00000096',0,0,0,1,'to_pay',7,NULL,92,'2020-07-02 18:00:46','2020-07-02 18:00:46'),(98,2,NULL,'2020-07-02',NULL,'CL-475-00000098',0,0,0,1,'to_pay',7,NULL,94,'2020-07-02 18:04:57','2020-07-02 18:04:57'),(100,22.96,NULL,'2020-07-03',NULL,'CL-475-00000100',0,0,0,1,'to_pay',475,NULL,96,'2020-07-03 16:32:54','2020-07-03 16:32:54'),(101,4.99,NULL,'2020-07-03',NULL,'CL-475-00000101',0,0,0,1,'to_pay',475,NULL,97,'2020-07-03 16:44:36','2020-07-03 16:44:36'),(102,9.98,NULL,'2020-07-04',NULL,'CL-507-00000102',0,0,0,1,'to_pay',507,NULL,106,'2020-07-04 13:00:08','2020-07-04 13:00:08'),(107,9.98,NULL,'2020-07-04',NULL,'CL-507-00000107',0,0,0,1,'to_pay',507,NULL,112,'2020-07-04 16:36:21','2020-07-04 16:36:21'),(110,9.98,NULL,'2020-07-04',NULL,'CL-507-00000110',0,0,0,1,'to_pay',507,NULL,115,'2020-07-04 16:41:56','2020-07-04 16:41:56'),(111,9.98,NULL,'2020-07-04',NULL,'CL-507-00000111',0,0,0,1,'to_pay',507,NULL,116,'2020-07-04 16:52:34','2020-07-04 16:52:34'),(114,9.98,NULL,'2020-07-04',NULL,'CL-507-00000114',0,0,0,1,'to_pay',507,NULL,119,'2020-07-04 18:06:13','2020-07-04 18:06:13'),(115,9.98,NULL,'2020-07-04',NULL,'CL-507-00000115',0,0,0,1,'to_pay',507,NULL,120,'2020-07-04 18:44:12','2020-07-04 18:44:12'),(116,9.99,NULL,'2020-07-04',NULL,'CL-507-00000116',0,0,0,1,'to_pay',507,NULL,121,'2020-07-04 18:44:49','2020-07-04 18:44:49'),(117,9.98,NULL,'2020-07-04',NULL,'CL-507-00000117',0,0,0,1,'to_pay',507,NULL,122,'2020-07-04 20:09:46','2020-07-04 20:09:46'),(120,10.04,NULL,'2020-07-05',NULL,'CL-475-00000120',0,0,0,1,'to_pay',475,NULL,125,'2020-07-05 00:10:15','2020-07-05 00:10:15'),(121,15.06,NULL,'2020-07-05',NULL,'CL-475-00000121',0,0,0,1,'to_pay',475,NULL,126,'2020-07-05 00:31:56','2020-07-05 00:31:57'),(122,50.2,10,'2020-07-05',NULL,'CL-475-00000122',0,0,0,1,'to_pay',475,NULL,128,'2020-07-05 00:35:16','2020-07-05 00:35:16'),(123,15.06,0,'2020-07-05',NULL,'CL-475-00000123',0,0,0,1,'to_pay',475,NULL,129,'2020-07-05 00:36:43','2020-07-05 00:36:43');
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `postcode` varchar(7) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` (`id`, `name`, `address`, `latitude`, `longitude`, `city`, `postcode`, `country`, `updated_at`) VALUES (1,'PARIS_LOUVRES_TUILERIES','Place de la Concorde',48.865658,2.321232,'Paris','75001','France','2020-05-05 15:55:30'),(4,'VANVES ENTREPOT','73 Rue Sadi Carnot',48.82420219999999,2.2936952,'Vanves','92170','France','2020-06-24 12:22:50'),(26,'Coucou','852 Avenue de la Mer-Raymond Dugrand',43.59856414794922,3.9025771617889404,'Montpellier','34000','France','2020-06-11 17:29:45'),(29,'Salut les potes','678 Avenue de Provence',43.42717361450195,6.7444682121276855,'Fréjus','83600','France','2020-06-11 17:30:45'),(30,'Test corrigé (nom + adresse)','165 Avenue Henri Barbusse',48.911460876464844,2.4330480098724365,'Bobigny','93000','France','2020-06-11 17:30:02'),(31,'WUP','99 Avenue du Général Leclerc',48.81105422973633,2.431460380554199,'Maisons-Alfort','94700','France','2020-06-11 17:30:16'),(32,'Paris 16','34 Avenue du Général Sarrail',48.84326934814453,2.254103899002075,'Paris','75016','France','2020-06-24 12:22:29'),(33,'Llkqsd','69 Rue de Clichy',48.88193130493164,2.3280797004699707,'Paris','75009','France',NULL),(34,'Pypyy','22 Avenue Foch',48.87403106689453,2.289492130279541,'Paris','75116','France',NULL),(35,'Fyiyf','28 Rue Velpeau',48.75593185424805,2.3023838996887207,'Antony','92160','France',NULL),(36,'Rrrr','27 Rue Velpeau',48.762882232666016,2.305565595626831,'Antony','92160','France',NULL),(37,'Jj','66 Rue de Seine',48.79716491699219,2.410292863845825,'Vitry-sur-Seine','94400','France',NULL),(41,'Rue du Dauphiné','64 Rue du Dauphiné',45.7524609,4.8675131,'Lyon','69003','France','2020-06-24 12:22:14'),(42,'Xfhfxgh','97 Rue du Moulin de Cage',48.9293585,2.3152727,'Gennevilliers','92230','France',NULL),(43,'Blip bloup','66 Rue Edouard Vaillant',48.85422459999999,2.4317906,'Montreuil','93100','France',NULL),(44,'Sdfsd','66 Avenue d\'Ivry',48.8243228,2.3640551,'Paris','75013','France',NULL),(45,'PLDOIDKJHD','27 Rue Velpeau',48.76288339999999,2.305565699999999,'Antony','92160','France',NULL),(46,'GFHDDRRRR','66 Rue du Dauphiné',45.75241509999999,4.867751399999999,'Lyon','69003','France',NULL),(47,'ESGI','242 Rue du Faubourg Saint-Antoine',48.849202,2.389749,'Paris','75012','France',NULL),(49,'Nouveau warehouse 2','67 Cours Gambetta',43.5192608,5.4632224,'Aix-en-Provence','13100','France',NULL),(50,'piou','852 Avenue de la Mer-Raymond Dugrand',43.5985625,3.9025771,'Montpellier','34000','France',NULL);
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pseudo`
--

DROP TABLE IF EXISTS `pseudo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pseudo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pseudo`
--

LOCK TABLES `pseudo` WRITE;
/*!40000 ALTER TABLE `pseudo` DISABLE KEYS */;
INSERT INTO `pseudo` (`id`, `name`, `updated_at`) VALUES (1,'Poney orange','2020-05-07 02:49:12'),(2,'Souris épicée','2020-07-05 01:03:53'),(4,'Poulpe',NULL),(5,'Abeille des alpes2','2020-07-05 02:59:54'),(6,'Mangue',NULL),(8,'Yack des collines aa','2020-07-05 01:02:55'),(14,'Bulbe',NULL),(15,'Bambou',NULL),(16,'Piou',NULL),(17,'wouhou',NULL);
/*!40000 ALTER TABLE `pseudo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_order`
--

DROP TABLE IF EXISTS `purchase_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) NOT NULL,
  `status` enum('created','in_progress','sent','received') DEFAULT 'created',
  `date` date DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_order_user_id_fk` (`user_id`),
  KEY `purchase_order_warehouse_id_fk` (`warehouse_id`),
  CONSTRAINT `purchase_order_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `purchase_order_warehouse_id_fk` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouse` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order`
--

LOCK TABLES `purchase_order` WRITE;
/*!40000 ALTER TABLE `purchase_order` DISABLE KEYS */;
INSERT INTO `purchase_order` (`id`, `user_id`, `warehouse_id`, `status`, `date`, `updated_at`) VALUES (37,503,7,'in_progress','2020-07-01','2020-07-04 21:49:12'),(41,498,7,'received','2020-07-01','2020-07-05 11:55:09');
/*!40000 ALTER TABLE `purchase_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchased_dish`
--

DROP TABLE IF EXISTS `purchased_dish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchased_dish` (
  `purchase_order_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` float DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `quantity_sent` int(11) DEFAULT '0',
  PRIMARY KEY (`purchase_order_id`,`dish_id`),
  KEY `purchased_dish_dish_id_fk` (`dish_id`),
  CONSTRAINT `purchased_dish_dish_id_fk` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`id`),
  CONSTRAINT `purchased_dish_purchase_order_id_fk` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_order` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchased_dish`
--

LOCK TABLES `purchased_dish` WRITE;
/*!40000 ALTER TABLE `purchased_dish` DISABLE KEYS */;
INSERT INTO `purchased_dish` (`purchase_order_id`, `dish_id`, `quantity`, `unit_price`, `updated_at`, `quantity_sent`) VALUES (37,3,13,5,'2020-07-04 21:49:12',5),(41,3,13,5,'2020-07-04 21:49:12',5);
/*!40000 ALTER TABLE `purchased_dish` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `safety_inspection`
--

DROP TABLE IF EXISTS `safety_inspection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `safety_inspection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `truck_age` int(11) DEFAULT NULL,
  `truck_mileage` int(11) DEFAULT NULL,
  `replaced_parts` varchar(150) DEFAULT NULL,
  `drained_fluids` varchar(150) DEFAULT NULL,
  `truck_id` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `safety_inspection_truck_id_fk` (`truck_id`),
  CONSTRAINT `safety_inspection_truck_id_fk` FOREIGN KEY (`truck_id`) REFERENCES `truck` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `safety_inspection`
--

LOCK TABLES `safety_inspection` WRITE;
/*!40000 ALTER TABLE `safety_inspection` DISABLE KEYS */;
INSERT INTO `safety_inspection` (`id`, `date`, `truck_age`, `truck_mileage`, `replaced_parts`, `drained_fluids`, `truck_id`, `updated_at`) VALUES (1,'2020-04-21',1,1001,'Aucunes','ggg',2,'2020-07-05 16:00:20'),(5,'2020-05-02',2,3001,'aucune',NULL,2,'2020-05-13 13:44:13'),(6,'2020-05-08',2,1200,'Aucunes','Liquide frein',2,NULL);
/*!40000 ALTER TABLE `safety_inspection` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale`
--

DROP TABLE IF EXISTS `sale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method` enum('Carte bancaire','Liquide') DEFAULT NULL,
  `online_order` tinyint(1) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `user_franchised` int(11) NOT NULL,
  `user_client` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','done') DEFAULT 'done',
  `discount_amount` int(11) DEFAULT '0',
  `points_to_return` int(11) DEFAULT '0',
  `payment_id` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_user_id_fk` (`user_franchised`),
  KEY `sale_user_id_fk_2` (`user_client`),
  CONSTRAINT `sale_user_id_fk` FOREIGN KEY (`user_franchised`) REFERENCES `user` (`id`),
  CONSTRAINT `sale_user_id_fk_2` FOREIGN KEY (`user_client`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale`
--

LOCK TABLES `sale` WRITE;
/*!40000 ALTER TABLE `sale` DISABLE KEYS */;
INSERT INTO `sale` (`id`, `payment_method`, `online_order`, `date`, `user_franchised`, `user_client`, `updated_at`, `status`, `discount_amount`, `points_to_return`, `payment_id`) VALUES (38,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(48,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(49,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(50,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(51,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(52,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(53,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(54,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(55,'Liquide',1,'2020-06-22',7,507,'2020-07-04 16:31:12','pending',0,0,NULL),(56,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(57,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(58,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(59,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(60,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(61,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(62,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(63,'Liquide',1,'2020-06-22',7,507,NULL,'pending',0,0,NULL),(65,'Carte bancaire',1,'2020-06-22',503,507,NULL,'pending',0,0,NULL),(66,'Carte bancaire',1,'2020-06-22',503,507,NULL,'pending',0,0,NULL),(67,'Carte bancaire',1,'2020-06-22',503,507,NULL,'pending',0,0,NULL),(68,'Carte bancaire',1,'2020-06-22',503,507,NULL,'pending',0,0,NULL),(69,'Carte bancaire',1,'2020-06-22',503,507,NULL,'pending',0,0,NULL),(70,'Carte bancaire',1,'2020-06-22',503,507,NULL,'pending',0,0,NULL),(71,'Carte bancaire',1,'2020-06-22',503,507,NULL,'pending',0,0,NULL),(72,'Carte bancaire',1,'2020-06-22',503,507,NULL,'pending',0,0,NULL),(77,'Carte bancaire',1,'2020-06-22',503,507,NULL,'pending',0,0,NULL),(78,'Liquide',1,'2020-07-01',503,507,NULL,'pending',0,0,NULL),(80,'Liquide',1,'2020-07-01',503,7,NULL,'pending',0,0,NULL),(81,'Carte bancaire',1,'2020-07-01',503,507,NULL,'pending',0,0,NULL),(82,'Carte bancaire',1,'2020-07-01',503,507,NULL,'pending',0,0,NULL),(84,'Carte bancaire',1,'2020-07-02',7,475,NULL,'pending',0,0,NULL),(85,'Carte bancaire',1,'2020-07-02',503,475,NULL,'pending',0,0,NULL),(86,'Carte bancaire',1,'2020-07-02',503,475,NULL,'pending',0,0,NULL),(87,'Carte bancaire',1,'2020-07-02',503,475,NULL,'pending',0,0,NULL),(88,'Carte bancaire',1,'2020-07-02',503,475,NULL,'pending',0,0,NULL),(89,'Carte bancaire',1,'2020-07-02',7,475,NULL,'pending',0,0,NULL),(90,'Carte bancaire',1,'2020-07-02',503,475,NULL,'pending',0,0,NULL),(91,'Carte bancaire',1,'2020-07-02',503,475,NULL,'pending',0,0,NULL),(92,'Carte bancaire',1,'2020-07-02',503,475,NULL,'pending',0,0,NULL),(94,'Carte bancaire',1,'2020-07-02',503,475,NULL,'pending',0,0,NULL),(96,'Carte bancaire',1,'2020-07-03',7,475,NULL,'pending',0,0,NULL),(97,'Carte bancaire',1,'2020-07-03',7,475,NULL,'pending',0,0,NULL),(102,'Carte bancaire',1,'2020-07-03',7,507,NULL,'pending',0,0,NULL),(103,'Carte bancaire',1,'2020-07-03',7,7,NULL,'pending',0,0,NULL),(106,'Carte bancaire',1,'2020-07-04',7,507,'2020-07-04 13:00:08','pending',5,0,NULL),(112,'Carte bancaire',1,'2020-07-04',7,507,'2020-07-04 16:36:21','pending',0,0,NULL),(115,'Carte bancaire',1,'2020-07-04',7,507,'2020-07-04 16:48:23','done',0,0,NULL),(116,'Carte bancaire',1,'2020-07-04',7,507,'2020-07-04 17:01:24','pending',0,0,NULL),(119,'Carte bancaire',1,'2020-07-04',7,507,'2020-07-04 18:06:12','pending',0,1,NULL),(120,'Liquide',1,'2020-07-04',7,507,'2020-07-04 18:44:12','pending',0,1,NULL),(121,'Liquide',1,'2020-07-04',7,507,'2020-07-04 18:44:49','pending',0,1,NULL),(122,'Carte bancaire',1,'2020-07-04',7,507,'2020-07-04 20:09:46','pending',0,1,NULL),(125,'Carte bancaire',1,'2020-07-05',503,475,'2020-07-05 00:10:15','pending',7,-8,'ch_1H1JYpD45YXLbuEz4Ft1kAfN'),(126,'Carte bancaire',1,'2020-07-05',503,475,'2020-07-05 00:31:56','pending',5,-3,'ch_1H1JtoD45YXLbuEzlVn6PK90'),(127,'Carte bancaire',1,'2020-07-05',503,475,'2020-07-05 00:33:20','pending',7,-7,'ch_1H1JvAD45YXLbuEziVSCtNgs'),(128,'Carte bancaire',1,'2020-07-05',503,473,'2020-07-05 00:35:16','pending',10,-44,'ch_1H1Jx2D45YXLbuEzqMVVkX5T'),(129,'Liquide',1,'2020-07-05',503,473,'2020-07-05 00:36:43','pending',0,2,NULL);
/*!40000 ALTER TABLE `sale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sold_dish`
--

DROP TABLE IF EXISTS `sold_dish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sold_dish` (
  `dish_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `unit_price` float DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`dish_id`,`sale_id`),
  KEY `sold_dish_sale_id_fk` (`sale_id`),
  CONSTRAINT `sold_dish_dish_id_fk` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`id`),
  CONSTRAINT `sold_dish_sale_id_fk` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sold_dish`
--

LOCK TABLES `sold_dish` WRITE;
/*!40000 ALTER TABLE `sold_dish` DISABLE KEYS */;
INSERT INTO `sold_dish` (`dish_id`, `sale_id`, `unit_price`, `quantity`, `updated_at`) VALUES (1,38,4.99,4,NULL),(1,48,4.99,22,NULL),(1,49,4.99,22,NULL),(1,50,4.99,22,NULL),(1,51,4.99,22,NULL),(1,52,4.99,22,NULL),(1,53,4.99,22,NULL),(1,54,4.99,22,NULL),(1,55,4.99,22,NULL),(1,56,4.99,22,NULL),(1,57,4.99,22,NULL),(1,58,4.99,22,NULL),(1,59,4.99,22,NULL),(1,60,4.99,22,NULL),(1,61,4.99,22,NULL),(1,62,4.99,22,NULL),(1,63,4.99,22,NULL),(1,65,4.99,11,NULL),(1,66,4.99,11,NULL),(1,67,4.99,11,NULL),(1,68,4.99,11,NULL),(1,69,4.99,22,NULL),(1,70,4.99,22,NULL),(1,71,4.99,3,NULL),(1,72,4.99,2,NULL),(1,77,4.99,1,NULL),(1,78,4.99,2,NULL),(1,81,4.99,1,NULL),(1,82,4.99,1,NULL),(1,84,4.99,3,NULL),(1,88,4.99,2,NULL),(1,89,4.99,2,NULL),(1,90,4.99,1,NULL),(1,91,4.99,1,NULL),(1,92,4.99,1,NULL),(1,96,4.99,3,NULL),(1,97,4.99,1,NULL),(1,102,4.99,20,NULL),(1,103,4.99,30,NULL),(1,106,4.99,2,NULL),(1,112,4.99,2,NULL),(1,115,4.99,2,NULL),(1,116,4.99,2,NULL),(1,119,4.99,2,NULL),(1,120,4.99,2,NULL),(1,122,4.99,2,NULL),(1,125,5.02,2,NULL),(1,126,5.02,3,NULL),(1,127,5.02,4,NULL),(1,128,5.02,10,NULL),(1,129,5.02,3,NULL),(3,38,8,3,NULL),(3,48,8,12,NULL),(3,49,8,12,NULL),(3,50,8,12,NULL),(3,51,8,12,NULL),(3,52,8,12,NULL),(3,53,8,12,NULL),(3,54,8,12,NULL),(3,55,8,12,NULL),(3,56,8,12,NULL),(3,57,8,12,NULL),(3,58,8,12,NULL),(3,59,8,12,NULL),(3,60,8,12,NULL),(3,61,8,12,NULL),(3,62,8,12,NULL),(3,63,8,12,NULL),(3,65,8,12,NULL),(3,66,8,12,NULL),(3,67,8,12,NULL),(3,68,8,12,NULL),(3,69,8,12,NULL),(3,70,8,12,NULL),(3,80,7.99,1,NULL),(3,82,7.99,1,NULL),(3,96,7.99,1,NULL),(3,121,7.99,1,NULL),(49,48,2,10,NULL),(49,49,2,10,NULL),(49,50,2,10,NULL),(49,51,2,10,NULL),(49,52,2,10,NULL),(49,53,2,10,NULL),(49,54,2,10,NULL),(49,55,2,10,NULL),(49,56,2,10,NULL),(49,57,2,10,NULL),(49,58,2,10,NULL),(49,59,2,10,NULL),(49,60,2,10,NULL),(49,61,2,10,NULL),(49,62,2,10,NULL),(49,63,2,10,NULL),(49,65,2,10,NULL),(49,66,2,10,NULL),(49,67,2,10,NULL),(49,68,2,10,NULL),(49,69,2,10,NULL),(49,70,2,10,NULL),(50,82,2,1,NULL),(50,85,2,1,NULL),(50,94,2,1,NULL),(50,121,2,1,NULL),(51,82,2,1,NULL),(55,82,2,1,NULL),(55,86,2,2,NULL),(55,87,2000,7,NULL);
/*!40000 ALTER TABLE `sold_dish` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `truck`
--

DROP TABLE IF EXISTS `truck`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `truck` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(30) DEFAULT NULL,
  `model` varchar(30) DEFAULT NULL,
  `functional` tinyint(1) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `license_plate` varchar(10) DEFAULT NULL,
  `registration_document` varchar(15) DEFAULT NULL,
  `insurance_number` varchar(20) DEFAULT NULL,
  `fuel_type` enum('B7','B10','XTL','E10','E5','E85','LNG','H2','CNG','LPG','Electric') DEFAULT NULL,
  `chassis_number` varchar(20) DEFAULT NULL,
  `engine_number` varchar(20) DEFAULT NULL,
  `horsepower` int(11) DEFAULT NULL,
  `weight_empty` int(11) DEFAULT NULL,
  `payload` int(11) DEFAULT NULL,
  `general_state` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  `location_date_start` date DEFAULT NULL,
  `location_date_end` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `truck_location_id_fk` (`location_id`),
  KEY `truck_user_id_fk` (`user_id`),
  CONSTRAINT `truck_location_id_fk` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`),
  CONSTRAINT `truck_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `truck`
--

LOCK TABLES `truck` WRITE;
/*!40000 ALTER TABLE `truck` DISABLE KEYS */;
INSERT INTO `truck` (`id`, `brand`, `model`, `functional`, `purchase_date`, `license_plate`, `registration_document`, `insurance_number`, `fuel_type`, `chassis_number`, `engine_number`, `horsepower`, `weight_empty`, `payload`, `general_state`, `user_id`, `location_id`, `location_date_start`, `location_date_end`, `created_at`, `updated_at`) VALUES (2,'TRUCK','TRUCK',1,'2020-04-07','AA-000-AA','AAAAAAAAAAAAAAA','AAAAAAAAAAAAAAAAAAAA','B7','00000000000000000000','00000000000000000000',100,100,100,'Neuf',7,29,'2020-04-26',NULL,NULL,'2020-07-01 11:51:18'),(4,'TRUCK2','TRUCK2',1,'2020-04-01','AA-000-AB','AAAAAAAAAAAAAAB','AAAAAAAAAAAAAAAAAAAB','XTL','00000000000000000001','00000000000000000001',10,10,10,'Correct, quelques rayures',503,42,'2020-04-24','2020-06-04',NULL,'2020-07-01 16:02:47'),(5,'TRUCK3','TRUCK3',1,'2020-06-06','AA-000-AC','AAAAAAAAAAAAAAC','AAAAAAAAAAAAAAAAAAAC','XTL','00000000000000000002','00000000000000000002',10,10,10,'Correct, quelques rayures',9,1,'2020-04-24','2020-06-04',NULL,'2020-06-05 23:51:59'),(6,'TESLA2','TESLOU',1,'2020-07-01','DD-000-DD','AAAAAAAAAAAAAAD','AAAAAAAAAAAAAAAAAAAD','Electric','00000000000000000003','00000000000000000003',50,50,50,'Neuf',NULL,46,'2020-07-01',NULL,NULL,'2020-07-05 15:58:18');
/*!40000 ALTER TABLE `truck` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `firstname` varchar(30) DEFAULT NULL,
  `lastname` varchar(30) DEFAULT NULL,
  `role` enum('Administrateur','Corporate','Client','Franchisé') DEFAULT 'Franchisé',
  `password` varchar(100) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `pseudo_id` int(11) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `driving_licence` varchar(15) DEFAULT NULL,
  `social_security` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `loyalty_point` int(11) DEFAULT '0',
  `password_token` varchar(255) DEFAULT NULL,
  `opt_in` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_api_token_uindex` (`remember_token`),
  KEY `user_pseudo_id_fk` (`pseudo_id`),
  CONSTRAINT `user_pseudo_id_fk` FOREIGN KEY (`pseudo_id`) REFERENCES `pseudo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=557 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `email`, `firstname`, `lastname`, `role`, `password`, `remember_token`, `birthdate`, `pseudo_id`, `telephone`, `driving_licence`, `social_security`, `created_at`, `updated_at`, `loyalty_point`, `password_token`, `opt_in`) VALUES (2,'a@b.com','se','osbhs','Corporate',NULL,NULL,NULL,NULL,'0606060606',NULL,NULL,'2020-04-20 17:11:09','2020-04-20 17:11:13',0,NULL,0),(3,'noelarrieulacoste@yahoo.fr','Noé','Larrieu','Corporate','1ecffe7455f2e2c5c07fc9b431c0aab88a0fa436aa448beb56d3e16fd02ae21b','xZ1EO8Qj8skXeNLwBeHOeU49yok2i3FfqIl9SwMUKQ8XzjSX7zAdb2gPpj4y','1997-02-02',2,'0679575093','',NULL,'2020-04-20 17:11:10','2020-06-15 20:31:45',0,'5d5486fcb6c65801fc17d698e0e3caff2859553076550f1105',1),(5,'nino.m.perna@gmail.com','gegegege','gegegeg','Client','0555feceb007fa5fcb7f3d646096c234229c4ee4e007b59531624831d5173ca8',NULL,NULL,NULL,'0606060609',NULL,NULL,'2020-04-20 17:11:11','2020-05-09 15:24:28',100,NULL,0),(7,'noelarrieulacoste@gmail.com','Noé','LARRIEU-LACOSTE','Franchisé','1ecffe7455f2e2c5c07fc9b431c0aab88a0fa436aa448beb56d3e16fd02ae21b','3olhhLxsjrgsl30hJ8u9s6bfxyyWSiDjomM6OgvtTbimwZ38NBhRmJx4WnSk','1997-02-02',5,'0679575093','FAIUGF','123456789123456','2020-05-05 16:01:48','2020-07-03 19:32:16',14,NULL,1),(8,'nlarrieulacoste@myges.fr','Noé','LARRIEU-LACOSTE','Client','',NULL,NULL,6,'','',NULL,'2020-05-05 16:01:51','2020-05-01 17:14:55',100,NULL,1),(9,'antoine@a.a','Antoine','ANTOINE','Franchisé','ed02457b5c41d964dbd2f2a609d63fe1bb7528dbe55e1abf5b52c249cd735797',NULL,NULL,15,'','','','2020-05-05 16:01:52','2020-07-05 11:25:07',0,NULL,0),(473,'antoine222','antoine','antoine','Client',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-05 16:01:52',NULL,309,NULL,0),(474,'fsananes@gmail.com','Frédéric','SANANES','Franchisé',NULL,NULL,'1967-10-26',NULL,'','',NULL,'2020-05-05 16:01:53','2020-04-23 12:13:49',0,NULL,0),(475,'admin@admin.com','admin','admin','Administrateur','d82494f05d6917ba02f7aaa29689ccb444bb73f20380876cb05d1f37537b7892','nM11MCikPYOqETK5KEIzVNLQXMx8ba1JAzQ6mznreY1FeJhMS7NhuENdupDU','1981-06-16',NULL,'0600000000','ABCDEF','111111111111111','2020-04-29 17:10:40','2020-07-05 01:02:35',640,NULL,0),(480,'marionleo45@gmail.com','Noé','LARRIEU-LACOSTE','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-05 16:01:54',NULL,0,NULL,0),(485,'a@b.com','Zerzer','ZAERZER','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-08 17:54:23','2020-05-08 17:54:23',0,NULL,0),(486,'vu@va.fr','Vava','VUVU','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-08 22:38:39','2020-05-08 22:38:39',0,NULL,0),(487,'mama@mimi.fr','Mimi','MAMA','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-08 23:13:21','2020-05-08 23:13:21',0,NULL,0),(488,'lara@fabian.com','Lara','FABIAN','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-09 12:21:50','2020-05-09 12:21:50',0,NULL,0),(490,'keke@laglisse.fr','Keke','LAGLISSE','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-09 12:31:40','2020-05-09 12:31:40',0,NULL,0),(491,'gege@depardieu.fr','Gérard','DEPARDIEU','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-09 12:36:15','2020-05-09 12:36:15',0,NULL,0),(492,'raf@nadal.fr','Rafael','NADAL','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-09 12:37:53','2020-05-09 12:37:53',0,NULL,0),(493,'n@sarko.fr','Nicolas','SARKOZY','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-09 12:53:26','2020-05-09 12:53:26',0,NULL,0),(494,'t@shakur.org','Tupac','SHAKUR','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-09 13:17:04','2020-05-09 13:17:04',0,NULL,0),(495,'lady@gaga.fr','Lady','GAGA','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-09 13:23:43','2020-05-09 13:23:43',0,NULL,0),(496,'b@k.com','Beyoncé','KNOWLES','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-09 13:47:04','2020-05-09 13:47:04',0,NULL,0),(497,'j@d.com','Johnny','DEPP','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-09 13:50:00','2020-05-09 13:50:00',0,NULL,0),(498,'blo@blu.com','Bloblo','BLIBLI','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-12 22:11:38','2020-05-12 22:11:38',0,NULL,0),(499,'l@p.fr','Laura','PAUSINI','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-12 23:14:33','2020-05-12 23:14:33',0,NULL,0),(500,'p@balkany.org','Balkany','PATRICK','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-12 23:15:55','2020-05-12 23:15:55',0,NULL,0),(503,'castelli.jo@gmail.com','Joëlle','CASTELLI','Franchisé','279d5362613cc7b0da21e55ea1372faa8f2dd4fa2df9c5317e8a78df711cedc6','rCiOi9RhnO5Mnbrx6BIfVrSbKDyVTeoFyQ4MHCROCLXcEsJezluRPhB2540v',NULL,14,'0676760331','aaaaaa','aaaa','2017-04-14 19:34:25','2020-06-15 20:32:35',1,'77a5b5cefb7fc803c86fab860ce5268a51e690970291a819b1',1),(507,'afevre@myges.fr','Antoine','FEVRE','Client','ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb','A1XnVq2oCtJvFllVH7iQOlNKreLqajHYMOSV4CVLKoXe7K0koXCd7LfMAmnO','2000-03-22',4,'0600000002',NULL,NULL,'2020-05-21 19:25:10','2020-07-05 14:23:12',111,NULL,1),(508,'b@spears.com','Britney','SPEARS','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-25 20:33:50','2020-05-25 20:33:50',0,NULL,0),(509,'azeaze@azeaz.fr','Sazezae','SDE','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-25 20:35:17','2020-05-25 20:35:17',0,NULL,0),(510,'azeaze@azeaaaaz.fr','Sazezaeaaaaa','SDEAAAA','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-25 20:36:14','2020-05-25 20:36:14',0,NULL,0),(511,'sqdqsdze@azeaaaaz.fr','Qsdsq','SDEAAQSDSQFAA','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-25 20:37:04','2020-05-25 20:37:04',0,NULL,0),(512,'mlkmlklmj@azeaaaaz.fr','Qsdssdfsdg','MLDKFMLKGDSQFAA','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-25 20:38:35','2020-05-25 20:38:35',0,NULL,0),(513,'k@m.com','Katherine','MOENNIG','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-25 20:39:19','2020-05-25 20:39:19',0,NULL,0),(514,'leo@dv.com','Léonard','DE VINCI','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-25 21:34:19','2020-05-25 21:34:19',0,NULL,0),(515,'a@g.org','Ariana','GRANDE','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-05-26 22:32:43','2020-05-26 22:32:43',0,NULL,0),(516,'test@test.com','Test','TEST','Franchisé',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-07 15:36:49','2020-06-07 15:36:49',0,NULL,0),(517,'m@c.org','Mariah','CAREY','Client','ed02457b5c41d964dbd2f2a609d63fe1bb7528dbe55e1abf5b52c249cd735797',NULL,'2020-07-17',NULL,NULL,NULL,NULL,'2020-06-09 10:17:42','2020-07-05 14:24:12',0,NULL,0),(518,'m@s.fr','Michel','SARDOU','Client','279d5362613cc7b0da21e55ea1372faa8f2dd4fa2df9c5317e8a78df711cedc6',NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-09 10:20:52',NULL,0,NULL,0),(523,'wouhou@wouhou.com','Yeah','YO','Client','279d5362613cc7b0da21e55ea1372faa8f2dd4fa2df9c5317e8a78df711cedc6',NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-10 14:10:05',NULL,0,NULL,0),(524,'sdfsdfd@sdfs.ffr','Qdfsd','SDFSDF','Client','279d5362613cc7b0da21e55ea1372faa8f2dd4fa2df9c5317e8a78df711cedc6',NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-10 14:23:51',NULL,0,NULL,0),(525,'shakira@shakira.fr','Shakira','SHAKIRA','Client','279d5362613cc7b0da21e55ea1372faa8f2dd4fa2df9c5317e8a78df711cedc6',NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-10 14:38:50',NULL,0,NULL,0),(526,'test@test.com','Test','TEST','Administrateur','3eb3fe66b31e3b4d10fa70b5cad49c7112294af6ae4e476a1c405155d45aa121',NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-11 15:39:21',NULL,0,NULL,0),(539,'fevre.pasquet@gmail.com','Antoine','FEVRE','Administrateur','7c6e7672bea48a784e4d9704a1fef41bb13f165b63f473b659219f9576f7ea53',NULL,NULL,NULL,NULL,NULL,NULL,'2020-06-15 21:58:41','2020-06-15 23:58:40',0,'b2db2c739c47d3d42b984a9dac4ea389234510b4d6f59c3d06',1),(540,'m@p.org','Monsieur','PATATE','Client','0fadf52a4580cfebb99e61162139af3d3a6403c1d36b83e4962b721d1c8cbd0b',NULL,NULL,NULL,NULL,NULL,NULL,'2020-07-03 14:39:44',NULL,0,NULL,1),(545,'n@a.org','Admin','NOUVEL','Administrateur','034e1e9c516ccb6b0c37685ae69397168e2516a5b8128e095dc087204d03047d',NULL,NULL,NULL,NULL,NULL,NULL,'2020-07-04 18:34:55','2020-07-04 20:34:55',0,'345454336b679d0d323660359f2d69508aabbb9c190e151a2a',1),(546,'b@b.bb','Antoine','FEVRE','Administrateur','50f5a80c79dfae9c398fdeed1072c1a5c7c0e7c23c14f7567e8e9ae99636aabf',NULL,NULL,NULL,NULL,NULL,NULL,'2020-07-04 18:38:39','2020-07-04 20:38:38',0,'8bb0acc606596ef0eff879cf77c87f040d5ec443e860dd7f7a',1),(547,'boum@boum.fr','Bam','BIM','Administrateur','0fa4070b0c49a81950f33ba5b13de744ddcbb8fc86c70cb84bffc43e5fd2fc2e',NULL,NULL,NULL,NULL,NULL,NULL,'2020-07-04 18:40:23','2020-07-04 20:40:22',0,'78837687b0a5591fdd01913961575a8950cdeba1ef7406bdee',1),(548,'s@lut.fr','Salut','SALUT','Administrateur','9c40d0b1d01c3058c6a20074c819ed14a4fc78aa105b0db8bcec43eae31c672c',NULL,NULL,NULL,NULL,NULL,NULL,'2020-07-04 18:43:43','2020-07-04 20:43:43',0,'5140fe5abc87775899afe6250b582d613fa33dbd6a471a32bb',1),(549,'antoine','antoine','antoine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-07-04 22:06:56',NULL,0,NULL,1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warehouse`
--

DROP TABLE IF EXISTS `warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `warehouse_location_id_fk` (`location_id`),
  CONSTRAINT `warehouse_location_id_fk` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warehouse`
--

LOCK TABLES `warehouse` WRITE;
/*!40000 ALTER TABLE `warehouse` DISABLE KEYS */;
INSERT INTO `warehouse` (`id`, `name`, `location_id`, `created_at`, `updated_at`) VALUES (2,'TEST',26,NULL,'2020-05-05 18:55:13'),(7,'DFD',33,'2020-06-12 22:05:13','2020-06-12 22:05:13'),(8,'PLDOIDKJHD',45,'2020-06-12 22:40:35','2020-06-12 22:40:35'),(12,'piou2',29,'2020-07-04 20:52:53','2020-07-04 21:39:40');
/*!40000 ALTER TABLE `warehouse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `warehouse_stock`
--

DROP TABLE IF EXISTS `warehouse_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warehouse_stock` (
  `warehouse_id` int(11) NOT NULL,
  `dish_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `warehouse_price` float DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`warehouse_id`,`dish_id`),
  KEY `warehouse_stock_dish_id_fk` (`dish_id`),
  CONSTRAINT `warehouse_stock_dish_id_fk` FOREIGN KEY (`dish_id`) REFERENCES `dish` (`id`),
  CONSTRAINT `warehouse_stock_warehouse_id_fk` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouse` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `warehouse_stock`
--

LOCK TABLES `warehouse_stock` WRITE;
/*!40000 ALTER TABLE `warehouse_stock` DISABLE KEYS */;
INSERT INTO `warehouse_stock` (`warehouse_id`, `dish_id`, `quantity`, `warehouse_price`, `updated_at`) VALUES (2,1,50,10,NULL),(7,42,20,50,NULL);
/*!40000 ALTER TABLE `warehouse_stock` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-05 16:39:49
