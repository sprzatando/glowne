-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `ocena`;
CREATE TABLE `ocena` (
  `id_ocena` int(11) NOT NULL AUTO_INCREMENT,
  `zlecenie_id` int(11) NOT NULL,
  `uzytkownik_id` int(11) NOT NULL,
  `ocena` int(11) NOT NULL,
  `komentarz` text NOT NULL,
  PRIMARY KEY (`id_ocena`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `rejestracja`;
CREATE TABLE `rejestracja` (
  `id_rejestracja` int(11) NOT NULL AUTO_INCREMENT,
  `email` int(11) NOT NULL,
  `haslo` int(11) NOT NULL,
  `kod_aktywacyjny` int(11) NOT NULL,
  `data_rejestracji` date NOT NULL,
  PRIMARY KEY (`id_rejestracja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `uzytkownik`;
CREATE TABLE `uzytkownik` (
  `id_uzytkownik` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(40) NOT NULL,
  `haslo` varchar(40) NOT NULL,
  `nick` varchar(15) NOT NULL,
  `data_rejestracji` date NOT NULL,
  PRIMARY KEY (`id_uzytkownik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `zgloszenie`;
CREATE TABLE `zgloszenie` (
  `id_zgloszenie` int(11) NOT NULL AUTO_INCREMENT,
  `zlecenie_id` int(11) NOT NULL,
  `zglaszajacy_id` int(11) NOT NULL,
  `czas` datetime NOT NULL,
  PRIMARY KEY (`id_zgloszenie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `zlecenie`;
CREATE TABLE `zlecenie` (
  `id_zlecenie` int(11) NOT NULL AUTO_INCREMENT,
  `zlecajacy_id` int(11) NOT NULL,
  `miejsce` varchar(50) NOT NULL,
  `czas` varchar(50) NOT NULL,
  `telefon` varchar(12) NOT NULL,
  `mail_kontaktowy` varchar(40) NOT NULL,
  `cena` float NOT NULL,
  `pokoje_i_prace` text NOT NULL,
  PRIMARY KEY (`id_zlecenie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `zwyciezca`;
CREATE TABLE `zwyciezca` (
  `id_zwyciezca` int(11) NOT NULL AUTO_INCREMENT,
  `zlecenie_id` int(11) NOT NULL,
  `zgloszenie_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_zwyciezca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2016-12-07 17:26:16
