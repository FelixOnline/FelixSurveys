CREATE DATABASE  IF NOT EXISTS `sexsurvey` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `sexsurvey`;
-- MySQL dump 10.13  Distrib 5.5.16, for osx10.5 (i386)
--
-- Host: localhost    Database: sexsurvey
-- ------------------------------------------------------
-- Server version	5.5.19

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
-- Table structure for table `sexsurvey_responses`
--

DROP TABLE IF EXISTS `sexsurvey_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sexsurvey_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` longtext,
  `deptcheck` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sexsurvey_responses`
--

LOCK TABLES `sexsurvey_responses` WRITE;
/*!40000 ALTER TABLE `sexsurvey_responses` DISABLE KEYS */;
INSERT INTO `sexsurvey_responses` VALUES (1,'{\"sex\":\"male\",\"age\":\"17\",\"<br_\\/>\\r\\n<font_size=\'1\'><table_class=\'xdebug-error\'_dir=\'ltr\'_border=\'1\'_cellspacing=\'0\'_cellpadding=\'1\'>\\r\\n<tr><th_align=\'left\'_bgcolor=\'#f57900\'_colspan=\":\"hello\",\"textbox\":\"aaaa\",\"response\":\"Submit\"}',NULL),(2,'{\"sex\":\"male\",\"age\":\"17\",\"<br_\\/>\\r\\n<font_size=\'1\'><table_class=\'xdebug-error\'_dir=\'ltr\'_border=\'1\'_cellspacing=\'0\'_cellpadding=\'1\'>\\r\\n<tr><th_align=\'left\'_bgcolor=\'#f57900\'_colspan=\":\"hello\",\"textbox\":\"aaa\",\"response\":\"Submit\"}',NULL),(3,'{\"sex\":\"male\",\"age\":\"17\",\"<br_\\/>\\r\\n<font_size=\'1\'><table_class=\'xdebug-error\'_dir=\'ltr\'_border=\'1\'_cellspacing=\'0\'_cellpadding=\'1\'>\\r\\n<tr><th_align=\'left\'_bgcolor=\'#f57900\'_colspan=\":\"hello\",\"textbox\":\"fds\",\"response\":\"Submit\"}',NULL),(4,'{\"sex\":\"male\",\"age\":\"17\",\"<br_\\/>\\r\\n<font_size=\'1\'><table_class=\'xdebug-error\'_dir=\'ltr\'_border=\'1\'_cellspacing=\'0\'_cellpadding=\'1\'>\\r\\n<tr><th_align=\'left\'_bgcolor=\'#f57900\'_colspan=\":\"hello\",\"textbox\":\"fsd\",\"response\":\"Submit\"}',NULL),(5,'{\"sex\":\"male\",\"age\":\"17\",\"dep\":\"hello\",\"textbox\":\"sdadasdsadsad\",\"response\":\"Submit\"}',NULL),(6,'{\"age\":\"17\",\"dep\":\"hello\",\"textbox\":\"\",\"response\":\"Submit\"}',NULL),(7,'{\"age\":\"17\",\"dep\":\"hello\",\"textbox\":\"\",\"response\":\"Yes\"}',NULL);
/*!40000 ALTER TABLE `sexsurvey_responses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sexsurvey_completers`
--

DROP TABLE IF EXISTS `sexsurvey_completers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sexsurvey_completers` (
  `uname` varchar(45) NOT NULL,
  UNIQUE KEY `uname_UNIQUE` (`uname`),
  KEY `uname_key` (`uname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sexsurvey_completers`
--

LOCK TABLES `sexsurvey_completers` WRITE;
/*!40000 ALTER TABLE `sexsurvey_completers` DISABLE KEYS */;
INSERT INTO `sexsurvey_completers` VALUES ('2636bd61ef64f149d991bff50ce7f99425f96f15'),('70c881d4a26984ddce795f6f71817c9cf4480e79'),('7e240de74fb1ed08fa08d38063f6a6a91462a815'),('8e7dd3505df1a3aeccefc4f6670e0586b0c07207'),('9c969ddf454079e3d439973bbab63ea6233e4087'),('a3f60445f2031b5cd83534130eeba64cf4a0887b'),('aaa'),('bbbdc83d182e25b8eed22c23f261b771a2c212db'),('dcbc8f63b06c899b9db957f0e03466860fce8056');
/*!40000 ALTER TABLE `sexsurvey_completers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-01-26 15:46:43
CREATE DATABASE  IF NOT EXISTS `thebuggenie` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `thebuggenie`;
-- MySQL dump 10.13  Distrib 5.5.16, for osx10.5 (i386)
--
-- Host: localhost    Database: thebuggenie
-- ------------------------------------------------------
-- Server version	5.5.19

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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-01-26 15:46:44
