CREATE DATABASE  IF NOT EXISTS `gymplan` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `gymplan`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: gymplan
-- ------------------------------------------------------
-- Server version	5.6.20

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
-- Table structure for table `t_einheit`
--

DROP TABLE IF EXISTS `t_einheit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_einheit` (
  `EinheitID` int(11) NOT NULL AUTO_INCREMENT,
  `EinheitTrinID_FK` int(11) NOT NULL,
  `EinheitDatum` datetime NOT NULL,
  PRIMARY KEY (`EinheitID`),
  KEY `EinheitToTrainPlan_idx` (`EinheitTrinID_FK`),
  CONSTRAINT `EinheitToTrainPlan` FOREIGN KEY (`EinheitTrinID_FK`) REFERENCES `t_trainingsplaene` (`TrainID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_einheit`
--

LOCK TABLES `t_einheit` WRITE;
/*!40000 ALTER TABLE `t_einheit` DISABLE KEYS */;
INSERT INTO `t_einheit` VALUES (1,1,'2014-10-30 15:18:54'),(2,1,'2014-11-01 15:25:33'),(5,1,'2014-10-31 12:00:00');
/*!40000 ALTER TABLE `t_einheit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_geraete`
--

DROP TABLE IF EXISTS `t_geraete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_geraete` (
  `GeraeteID` int(11) NOT NULL AUTO_INCREMENT,
  `GeraeteUsrID_FK` int(11) NOT NULL,
  `GeraeteName` varchar(100) NOT NULL,
  `GeraeteBez` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`GeraeteID`),
  KEY `GerateToUser_idx` (`GeraeteUsrID_FK`),
  CONSTRAINT `GerateToUser` FOREIGN KEY (`GeraeteUsrID_FK`) REFERENCES `t_users` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_geraete`
--

LOCK TABLES `t_geraete` WRITE;
/*!40000 ALTER TABLE `t_geraete` DISABLE KEYS */;
INSERT INTO `t_geraete` VALUES (1,1,'A11','Arme'),(2,1,'B10','Beine');
/*!40000 ALTER TABLE `t_geraete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_trainingsplaene`
--

DROP TABLE IF EXISTS `t_trainingsplaene`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_trainingsplaene` (
  `TrainID` int(11) NOT NULL AUTO_INCREMENT,
  `TrainUserID_FK` int(11) NOT NULL,
  `TrainName` varchar(200) NOT NULL,
  PRIMARY KEY (`TrainID`),
  KEY `UserToTrain` (`TrainUserID_FK`),
  CONSTRAINT `UserToTrain` FOREIGN KEY (`TrainUserID_FK`) REFERENCES `t_users` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_trainingsplaene`
--

LOCK TABLES `t_trainingsplaene` WRITE;
/*!40000 ALTER TABLE `t_trainingsplaene` DISABLE KEYS */;
INSERT INTO `t_trainingsplaene` VALUES (1,1,'Trainplan'),(2,1,'Testplan');
/*!40000 ALTER TABLE `t_trainingsplaene` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_uebungen`
--

DROP TABLE IF EXISTS `t_uebungen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_uebungen` (
  `UebID` int(11) NOT NULL AUTO_INCREMENT,
  `UebTrainID_FK` int(11) DEFAULT NULL,
  `UebEinheitID_FK` int(11) DEFAULT NULL,
  `UebGeraeteID_FK` int(11) NOT NULL,
  `UebGewicht` int(11) DEFAULT NULL,
  `UebSaetze` int(11) DEFAULT NULL,
  `UebWiederholungen` int(11) DEFAULT NULL,
  `UebSkipped` bit(1) DEFAULT NULL,
  PRIMARY KEY (`UebID`),
  KEY `UebungToTrainPlan_idx` (`UebTrainID_FK`),
  KEY `UebungToEinheit_idx` (`UebEinheitID_FK`),
  KEY `UebungToGeraete_idx` (`UebGeraeteID_FK`),
  CONSTRAINT `UebungToEinheit` FOREIGN KEY (`UebEinheitID_FK`) REFERENCES `t_einheit` (`EinheitID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `UebungToGeraete` FOREIGN KEY (`UebGeraeteID_FK`) REFERENCES `t_geraete` (`GeraeteID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `UebungToTrainPlan` FOREIGN KEY (`UebTrainID_FK`) REFERENCES `t_trainingsplaene` (`TrainID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_uebungen`
--

LOCK TABLES `t_uebungen` WRITE;
/*!40000 ALTER TABLE `t_uebungen` DISABLE KEYS */;
INSERT INTO `t_uebungen` VALUES (1,1,NULL,1,10,10,10,NULL),(2,1,NULL,2,15,15,15,NULL),(3,NULL,1,1,12,12,12,NULL),(4,NULL,1,2,16,16,16,NULL),(5,NULL,2,1,13,13,13,NULL),(6,NULL,2,2,17,17,17,NULL),(8,NULL,5,1,15,13,13,NULL),(9,NULL,5,2,18,17,17,NULL),(10,2,NULL,1,17,17,13,NULL),(11,2,NULL,2,25,25,25,NULL);
/*!40000 ALTER TABLE `t_uebungen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_users`
--

DROP TABLE IF EXISTS `t_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `UserVorname` varchar(100) NOT NULL,
  `UserNachname` varchar(100) NOT NULL,
  `UserEmail` varchar(255) NOT NULL,
  `UserNickname` varchar(50) NOT NULL,
  `UserPasswort` varchar(50) NOT NULL,
  `UserLastLogin` datetime DEFAULT NULL,
  `UserIsInaktiv` bit(1) DEFAULT NULL,
  `UserIcon` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_users`
--

LOCK TABLES `t_users` WRITE;
/*!40000 ALTER TABLE `t_users` DISABLE KEYS */;
INSERT INTO `t_users` VALUES (1,'Michael','Huber','michael-13@live.de','michael','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','2014-10-20 14:00:00','\0',''),(2,'Andy','Abderhalden','andy.abderhalden@gmx.com','andy','7110eda4d09e062aa5e4a390b0a572ac0d2c0220','2014-10-27 00:00:00','\0',NULL);
/*!40000 ALTER TABLE `t_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-31 14:54:51
