CREATE DATABASE  IF NOT EXISTS `autow` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `autow`;
-- MySQL dump 10.13  Distrib 5.5.32, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: autow
-- ------------------------------------------------------
-- Server version	5.5.32-0ubuntu0.12.04.1

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
-- Table structure for table `AuthAssignment`
--

DROP TABLE IF EXISTS `AuthAssignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  CONSTRAINT `AuthAssignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AuthAssignment`
--

LOCK TABLES `AuthAssignment` WRITE;
/*!40000 ALTER TABLE `AuthAssignment` DISABLE KEYS */;
/*!40000 ALTER TABLE `AuthAssignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AuthItem`
--

DROP TABLE IF EXISTS `AuthItem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AuthItem`
--

LOCK TABLES `AuthItem` WRITE;
/*!40000 ALTER TABLE `AuthItem` DISABLE KEYS */;
INSERT INTO `AuthItem` VALUES ('admin',2,'',NULL,'N;'),('createArticle',0,'create a new article',NULL,'N;'),('createCarBrand',0,'create a new car brand',NULL,'N;'),('createCarGeneration',0,'create a new car generation',NULL,'N;'),('createCarModel',0,'create a new car model',NULL,'N;'),('createComment',0,'create a new comment',NULL,'N;'),('createPhoto',0,'create a new photo',NULL,'N;'),('createUser',0,'create a new user',NULL,'N;'),('deleteArticle',0,'remove an article',NULL,'N;'),('deleteCarBrand',0,'remove a car brand',NULL,'N;'),('deleteCarGeneration',0,'remove a car generation',NULL,'N;'),('deleteCarModel',0,'remove a car model',NULL,'N;'),('deleteComment',0,'delete a comment',NULL,'N;'),('deletePhoto',0,'remove a photo',NULL,'N;'),('deleteUser',0,'remove a user',NULL,'N;'),('moderator',2,'',NULL,'N;'),('publisher',2,'',NULL,'N;'),('readArticle',0,'read article information',NULL,'N;'),('readCarBrand',0,'read car brand information',NULL,'N;'),('readCarGeneration',0,'read car generation information',NULL,'N;'),('readCarModel',0,'read car model information',NULL,'N;'),('readComment',0,'read comment',NULL,'N;'),('readPhoto',0,'read a photo',NULL,'N;'),('readUser',0,'read user profile information',NULL,'N;'),('updateArticle',0,'update article information',NULL,'N;'),('updateCarBrand',0,'update a car brand information',NULL,'N;'),('updateCarGeneration',0,'update a car generation information',NULL,'N;'),('updateCarModel',0,'update a car model information',NULL,'N;'),('updateComment',0,'update comment',NULL,'N;'),('updatePhoto',0,'update a photo',NULL,'N;'),('updateUser',0,'update a users information',NULL,'N;'),('user',2,'',NULL,'N;');
/*!40000 ALTER TABLE `AuthItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AuthItemChild`
--

DROP TABLE IF EXISTS `AuthItemChild`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AuthItemChild`
--

LOCK TABLES `AuthItemChild` WRITE;
/*!40000 ALTER TABLE `AuthItemChild` DISABLE KEYS */;
INSERT INTO `AuthItemChild` VALUES ('publisher','createArticle'),('publisher','createCarBrand'),('publisher','createCarGeneration'),('publisher','createCarModel'),('user','createComment'),('publisher','createPhoto'),('moderator','createUser'),('moderator','deleteArticle'),('moderator','deleteCarBrand'),('moderator','deleteCarGeneration'),('moderator','deleteCarModel'),('moderator','deleteComment'),('moderator','deletePhoto'),('admin','deleteUser'),('admin','moderator'),('admin','publisher'),('moderator','publisher'),('user','readCarBrand'),('user','readCarGeneration'),('user','readCarModel'),('user','readComment'),('user','readPhoto'),('user','readUser'),('moderator','updateArticle'),('moderator','updateCarBrand'),('moderator','updateCarGeneration'),('moderator','updateCarModel'),('moderator','updateComment'),('moderator','updatePhoto'),('admin','user'),('moderator','user'),('publisher','user');
/*!40000 ALTER TABLE `AuthItemChild` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_generation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `content` text,
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_car_article_generation` (`car_generation_id`),
  KEY `FK_article_user` (`user_id`),
  CONSTRAINT `FK_article_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_car_article_generation` FOREIGN KEY (`car_generation_id`) REFERENCES `car_generation` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (3,1,1,'E21, First generation, 1975–1983','The first generation was a two-door saloon model only. A factory authorised cabrio version was also built by Baur.\r\nThe cockpit design of the E21 marked the introduction of a new design concept for BMW, with the center console angled towards the driver. This feature has become part of BMW’s interior design philosophy for many years. As a sign of passive safety, all edges and control elements within the interior were rounded off and padded.\r\nInitially, all models used the BMW M10 four-cylinder engine. In 1977, the BMW M20 six-cylinder engine was added to the lineup.',NULL,NULL),(4,2,1,'B5 (Typ 8D, 1994–2001)','The first generation Audi A4 (known internally as the Typ 8D) debuted in October 1994,[4][5] with production starting November 1994 and European sales commencing in January 1995 for the 1995 model year. North American sales later began in September 1995 for the 1996 model year.[6] It was built on the Volkswagen Group B5 (PL45) platform, which it shared with the fourth generation Volkswagen Passat (B5, Typ 3B). It had a front-mounted longitudinal engine and front-wheel drive. Many variations of the A4 were also available with Audi\'s quattro four-wheel drive system. The A4 was initially introduced as a four-door saloon/sedan; the Avant (estate/wagon) was introduced in November 1995 and went on sale in February 1996.\r\nDevelopment began in 1988, with the first design sketches being created later that year. By 1991, an exterior design by Imre Hasanic was chosen and frozen for November 1994 production by 1992. The interior design was later finalized in 1992, with pilot production commencing in the first half of 1994. Development concluded in the third quarter of 1994, preceding November 1994 start of production.[7][8][9][10]\r\nA wide range of internal combustion engines were available in European markets, between 1.6 and 2.8 litres for petrol engines; and a 1.9 litre diesel engine available with Volkswagen Group\'s VE technology, capable of achieving a 90 PS (66 kW; 89 bhp) or 110 PS (81 kW; 108 bhp), although Audi\'s 2.8 litre V6 engine, carried over from the old 80/90 was the only engine option in North America until 1997.\r\nThe Audi A4 was the first model in the Volkswagen Group to feature the new 1.8 litre 20v engine with five valves per cylinder, based on the unit Audi Sport had developed for their Supertouring race car. A turbocharged version produced 150 PS (110 kW; 148 bhp) and 210 newton metres (155 lb·ft) torque. This technology was added to the V6 family of engines in 1996, starting with the 2.8 litre V6 30v, which now produced 193 PS (142 kW; 190 bhp).\r\nAudi also debuted their new tiptronic automatic transmission on the B5 platform, based on the unit Porsche developed for their 964-generation 911. The transmission is a conventional automatic gearbox with a torque converter offering the driver fully automatic operation or manual selection of the gear ratios.',NULL,NULL);
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_brand`
--

DROP TABLE IF EXISTS `car_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `logo` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_brand`
--

LOCK TABLES `car_brand` WRITE;
/*!40000 ALTER TABLE `car_brand` DISABLE KEYS */;
INSERT INTO `car_brand` VALUES (1,'Audi','audi logo'),(2,'BMW','bmw logo');
/*!40000 ALTER TABLE `car_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_generation`
--

DROP TABLE IF EXISTS `car_generation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_generation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_model_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `production_period` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_car_generation_model` (`car_model_id`),
  CONSTRAINT `FK_car_generation_model` FOREIGN KEY (`car_model_id`) REFERENCES `car_model` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_generation`
--

LOCK TABLES `car_generation` WRITE;
/*!40000 ALTER TABLE `car_generation` DISABLE KEYS */;
INSERT INTO `car_generation` VALUES (1,4,'E21','1975-1983'),(2,1,'B5','1994-2001');
/*!40000 ALTER TABLE `car_generation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_model`
--

DROP TABLE IF EXISTS `car_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `car_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_brand_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_car_model_brand` (`car_brand_id`),
  CONSTRAINT `FK_car_model_brand` FOREIGN KEY (`car_brand_id`) REFERENCES `car_brand` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_model`
--

LOCK TABLES `car_model` WRITE;
/*!40000 ALTER TABLE `car_model` DISABLE KEYS */;
INSERT INTO `car_model` VALUES (1,1,'A4'),(3,1,'A6'),(4,2,'3 series');
/*!40000 ALTER TABLE `car_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo`
--

DROP TABLE IF EXISTS `photo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `photo_order_number` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_photo_article` (`article_id`),
  CONSTRAINT `FK_photo_article` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo`
--

LOCK TABLES `photo` WRITE;
/*!40000 ALTER TABLE `photo` DISABLE KEYS */;
/*!40000 ALTER TABLE `photo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `username` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','admin','admin','admin','admin','0000-00-00 00:00:00'),(3,'Radu Pavelco','r.pavelco','r.pavelco@gmail.com','813220e9c07b0824499759e06d71d340','admin','2013-09-17 10:41:36');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-10-01 10:43:05
