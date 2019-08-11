/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


CREATE DATABASE IF NOT EXISTS `dienstplan` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dienstplan`;

CREATE TABLE IF NOT EXISTS `Category` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(128) NOT NULL,
  `Active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Übungsdienst Kategorie';

CREATE TABLE IF NOT EXISTS `City` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Zip` int(11) NOT NULL DEFAULT '0',
  `Name` varchar(128) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `Department` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(128) NOT NULL,
  `CityId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id` (`Id`),
  KEY `FK_City` (`CityId`),
  CONSTRAINT `FK_City` FOREIGN KEY (`CityId`) REFERENCES `City` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `Permission` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(128) NOT NULL DEFAULT '0',
  `Permissionlevel` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Berechtigungslevel';

CREATE TABLE IF NOT EXISTS `Role` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `PermissionId` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `Sector` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Abteilung der jeweiligen Feuerwehr';

CREATE TABLE IF NOT EXISTS `Training` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `DepartmentId` int(11) NOT NULL,
  `CategoryId` int(11) NOT NULL,
  `CityId` int(11) NOT NULL DEFAULT '1',
  `SectorId` int(11) NOT NULL DEFAULT '1',
  `TrainingTypeId` int(11) DEFAULT '1',
  `Creator` int(11) NOT NULL COMMENT 'User, der den Dienst erstellt hat',
  `Start` datetime DEFAULT NULL,
  `End` datetime DEFAULT NULL,
  `Description` varchar(128) DEFAULT NULL,
  `Active` tinyint(4) NOT NULL DEFAULT '1',
  `Interregional` tinyint(4) DEFAULT '1' COMMENT 'Können andere Wehren diesen Dienst sehen?',
  `Public` tinyint(4) DEFAULT '1' COMMENT 'Öffentlich sichtbar',
  `LastChange` datetime DEFAULT CURRENT_TIMESTAMP,
  `IsEvent` bit(1) DEFAULT b'0',
  `Comment` varchar(511) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COMMENT='Tabelle für Übungsdienste';

CREATE TABLE IF NOT EXISTS `TrainingType` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Art der Übung';

CREATE TABLE IF NOT EXISTS `User` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Login` varchar(128) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Role` int(11) NOT NULL,
  `Mail` varchar(255) DEFAULT NULL,
  `Password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `PassMustChange` tinyint(4) NOT NULL DEFAULT '0',
  `HomeDepartmentId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `HomeDepartment` (`HomeDepartmentId`),
  CONSTRAINT `HomeDepartment` FOREIGN KEY (`HomeDepartmentId`) REFERENCES `Department` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `User_Department` (
  `UserId` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL,
  `RoleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
