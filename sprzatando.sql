-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `sprzatando`;
CREATE DATABASE `sprzatando` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `sprzatando`;

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
        `id` varchar(40) NOT NULL,
        `ip_address` varchar(45) NOT NULL,
        `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
        `data` blob NOT NULL,
        KEY `ci_sessions_timestamp` (`timestamp`)
);

DROP TABLE IF EXISTS `ocena`;
CREATE TABLE `ocena` (
  `id_ocena` int(11) NOT NULL AUTO_INCREMENT,
  `zlecenie_id` int(11) NOT NULL,
  `uzytkownik_id` int(11) NOT NULL,
  `ocena` int(11) NOT NULL,
  `komentarz` text NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id_ocena`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pokoj`;
CREATE TABLE `pokoj` (
  `id_pokoj` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(40) NOT NULL,
  PRIMARY KEY (`id_pokoj`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `pokoj` (`id_pokoj`, `nazwa`) VALUES
(1,	'kuchnia'),
(2,	'łazienka'),
(3,	'salon'),
(4,	'sypialnia'),
(5,	'garaż'),
(6,	'ogród');

DROP TABLE IF EXISTS `praca`;
CREATE TABLE `praca` (
  `id_praca` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(40) NOT NULL,
  PRIMARY KEY (`id_praca`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `praca` (`id_praca`, `nazwa`) VALUES
(1,	'zmywanie naczyń'),
(2,	'mycie podłogi'),
(3,	'czyszczenie kafelek'),
(4,	'szorowanie piekarnika'),
(5,	'ścieranie stołu'),
(6,	'mycie okien'),
(7,	'mycie armatury'),
(8,	'polerowanie lustra'),
(9,	'ścieranie kurzu'),
(10,	'czyszczenie dywanów'),
(11,	'odkurzanie'),
(12,	'ścielenie łóżek'),
(13,	'zamiatanie'),
(14,	'mycie samochodu'),
(15,	'koszenie trawy'),
(16,	'mycie mebli ogrodowych'),
(17,	'czyszczenie kostki brukowej');

DROP TABLE IF EXISTS `praca_pokoj`;
CREATE TABLE `praca_pokoj` (
  `id_pp` int(11) NOT NULL AUTO_INCREMENT,
  `pokoj_id` int(11) NOT NULL,
  `praca_id` int(11) NOT NULL,
  PRIMARY KEY (`id_pp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `praca_pokoj` (`id_pp`, `pokoj_id`, `praca_id`) VALUES
(1,	1,	1),
(2,	1,	2),
(3,	1,	3),
(4,	1,	4),
(5,	1,	5),
(6,	2,	3),
(7,	2,	7),
(8,	2,	8),
(9,	2,	2),
(10,	2,	9),
(11,	3,	10),
(12,	3,	6),
(13,	3,	11),
(14,	3,	9),
(15,	3,	5),
(16,	4,	6),
(17,	4,	11),
(18,	4,	9),
(19,	4,	12),
(20,	5,	13),
(21,	5,	14),
(22,	6,	15),
(23,	6,	16),
(24,	6,	17);

DROP TABLE IF EXISTS `rejestracja`;
CREATE TABLE `rejestracja` (
  `id_rejestracja` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(40) NOT NULL,
  `haslo` varchar(20) NOT NULL,
  `nick` varchar(20) NOT NULL,
  `kod_aktywacyjny` varchar(10) NOT NULL,
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
  `czas` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_zgloszenie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `zlecenie`;
CREATE TABLE `zlecenie` (
  `id_zlecenie` int(11) NOT NULL AUTO_INCREMENT,
  `zlecajacy_id` int(11) NOT NULL,
  `miejsce` varchar(50) NOT NULL,
  `data` date NOT NULL,
  `godzina` time NOT NULL,
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


-- 2016-12-10 13:37:30
