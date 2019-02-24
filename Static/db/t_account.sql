# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.18)
# Database: PeopleSoft
# Generation Time: 2019-02-24 02:40:33 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table t_account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `t_account`;

CREATE TABLE `t_account` (
  `Fid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Faccount` varchar(200) NOT NULL DEFAULT '',
  `Fpassword` varchar(200) NOT NULL DEFAULT '',
  `Fnickname` varchar(100) DEFAULT ' ',
  `Fverify` int(100) NOT NULL,
  `FlastLoginTime` varchar(60) DEFAULT ' ',
  `FloginCount` int(11) DEFAULT '0',
  `FlastLoginIp` varchar(200) DEFAULT ' ',
  `FcreateTime` int(11) DEFAULT '0',
  PRIMARY KEY (`Fid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `t_account` WRITE;
/*!40000 ALTER TABLE `t_account` DISABLE KEYS */;

INSERT INTO `t_account` (`Fid`, `Faccount`, `Fpassword`, `Fnickname`, `Fverify`, `FlastLoginTime`, `FloginCount`, `FlastLoginIp`, `FcreateTime`)
VALUES
	(1,'admin','demo','超级管理员',123456,'1502777809',47,' ',0),
	(2,'test','test','风清扬',123456,'1502803018',6,' ',0);

/*!40000 ALTER TABLE `t_account` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
