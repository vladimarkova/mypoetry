SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE DATABASE IF NOT EXISTS `mypoetry` DEFAULT CHARACTER SET UTF8mb4 collate utf8mb4_bin;
USE `mypoetry`;

CREATE TABLE IF NOT EXISTS `topic` (
  `topicID` int(11) NOT NULL AUTO_INCREMENT,
  `topicName` varchar(50) NOT NULL,
  `extraInfo` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`topicID`)
);

CREATE TABLE IF NOT EXISTS `poem` (
  `poemID` int(11) NOT NULL AUTO_INCREMENT,
  `poemContent` varchar(500) NOT NULL,
  `extraInfo` varchar(100) DEFAULT NULL,
  `topicID` int(11),
  PRIMARY KEY (`poemID`),
  FOREIGN KEY (`topicID`) REFERENCES `topic`(`topicID`)
);
