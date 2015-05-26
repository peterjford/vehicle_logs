-- MySQL dump 10.13  Distrib 5.6.21, for osx10.6 (x86_64)
--
-- Host: localhost    Database: pjs_vehicles
-- ------------------------------------------------------
-- Server version	5.6.21

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
-- Table structure for table `pjs_drivers`
--

DROP TABLE IF EXISTS `pjs_drivers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pjs_drivers` (
  `pjs_drivers_id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`pjs_drivers_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pjs_fuel`
--

DROP TABLE IF EXISTS `pjs_fuel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pjs_fuel` (
  `pjs_fuel_id` int(11) NOT NULL AUTO_INCREMENT,
  `fuel_garage_id` int(11) DEFAULT NULL,
  `fuel_date` datetime DEFAULT NULL,
  `fuel_odo` decimal(8,1) DEFAULT NULL,
  `fuel_type` varchar(15) DEFAULT NULL,
  `fuel_gallons` decimal(6,3) DEFAULT NULL,
  `fuel_cost` decimal(6,2) DEFAULT NULL,
  `fuel_city_percent` tinyint(4) DEFAULT NULL,
  `fuel_notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pjs_fuel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pjs_garage`
--

DROP TABLE IF EXISTS `pjs_garage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pjs_garage` (
  `pjs_garage_id` int(11) NOT NULL AUTO_INCREMENT,
  `veh_year` year(4) DEFAULT NULL,
  `veh_make` varchar(20) DEFAULT NULL,
  `veh_model` varchar(30) DEFAULT NULL,
  `veh_trim` varchar(20) DEFAULT NULL,
  `veh_vin` varchar(17) DEFAULT NULL,
  `veh_lic` varchar(10) DEFAULT NULL,
  `veh_nickname` varchar(30) DEFAULT NULL,
  `veh_primary_driver_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pjs_garage_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pjs_maint`
--

DROP TABLE IF EXISTS `pjs_maint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pjs_maint` (
  `pjs_maint_id` int(11) NOT NULL AUTO_INCREMENT,
  `maint_garage_id` int(11) DEFAULT NULL,
  `maint_date` datetime DEFAULT NULL,
  `maint_odo` int(11) DEFAULT NULL,
  `maint_time` smallint(5) DEFAULT NULL,
  `maint_cost` decimal(6,2) DEFAULT NULL,
  `maint_code_id` int(11) DEFAULT NULL,
  `maint_notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pjs_maint_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pjs_repair`
--

DROP TABLE IF EXISTS `pjs_repair`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pjs_repair` (
  `pjs_repair_id` int(11) NOT NULL AUTO_INCREMENT,
  `repair_garage_id` int(11) DEFAULT NULL,
  `repair_date` datetime DEFAULT NULL,
  `repair_odo` int(11) DEFAULT NULL,
  `repair_time` smallint(5) DEFAULT NULL,
  `repair_cost` decimal(6,2) DEFAULT NULL,
  `repair_code_id` int(11) DEFAULT NULL,
  `repair_notes` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`pjs_repair_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-05-26 15:35:39
