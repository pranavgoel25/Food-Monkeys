-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: test_db
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

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
-- Table structure for table `omitraresponse`
--

DROP TABLE IF EXISTS `omitraresponse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `omitraresponse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `requestid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `omitraresponse`
--

LOCK TABLES `omitraresponse` WRITE;
/*!40000 ALTER TABLE `omitraresponse` DISABLE KEYS */;
/*!40000 ALTER TABLE `omitraresponse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `omitratest`
--

DROP TABLE IF EXISTS `omitratest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `omitratest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `train` varchar(255) DEFAULT NULL,
  `sdate` date DEFAULT NULL,
  `edate` date DEFAULT NULL,
  `reason` varchar(500) DEFAULT NULL,
  `sdes` varchar(255) DEFAULT NULL,
  `edes` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  CONSTRAINT `omitratest_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `omitrausers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `omitratest`
--

LOCK TABLES `omitratest` WRITE;
/*!40000 ALTER TABLE `omitratest` DISABLE KEYS */;
/*!40000 ALTER TABLE `omitratest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `omitratravellertest`
--

DROP TABLE IF EXISTS `omitratravellertest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `omitratravellertest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `train` varchar(255) DEFAULT NULL,
  `sdes` varchar(255) DEFAULT NULL,
  `edes` varchar(255) DEFAULT NULL,
  `sdate` date DEFAULT NULL,
  `edate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`),
  CONSTRAINT `omitratravellertest_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `omitrausers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `omitratravellertest`
--

LOCK TABLES `omitratravellertest` WRITE;
/*!40000 ALTER TABLE `omitratravellertest` DISABLE KEYS */;
/*!40000 ALTER TABLE `omitratravellertest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `omitrausers`
--

DROP TABLE IF EXISTS `omitrausers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `omitrausers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `omitrausers`
--

LOCK TABLES `omitrausers` WRITE;
/*!40000 ALTER TABLE `omitrausers` DISABLE KEYS */;
INSERT INTO `omitrausers` VALUES (4,'Saiteja Reddy','9999999999','saiteja0317@gmail.com','d8578edf8458ce06fbc5bb76a58c5ca4'),(5,'Vineeth','9898989898','crvineeth99@gmail.com','d8578edf8458ce06fbc5bb76a58c5ca4');
/*!40000 ALTER TABLE `omitrausers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-10 16:49:31
