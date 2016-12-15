-- Adminer 4.2.4 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `sprzatando`;
CREATE DATABASE `sprzatando` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `sprzatando`;

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('d08dfd1354a9c11f8359f1e98a6e37d853cbdfc3',	'::1',	1481812645,	'__ci_last_regenerate|i:1481812354;'),
('73b2fcb25fd033261b42f37bc45e9855183faf96',	'::1',	1481812918,	'__ci_last_regenerate|i:1481812662;zalogowany|s:1:\"4\";'),
('729cc73c77ee1df4618f44a22e52ba859e54865e',	'::1',	1481813399,	'__ci_last_regenerate|i:1481813099;zalogowany|s:1:\"4\";'),
('879776a240041c2d1b5f39a6e7d05c5f6afc0098',	'::1',	1481813629,	'__ci_last_regenerate|i:1481813400;'),
('b5837cf8fbee4052e6aa78c80b4cbe0b2d214b2f',	'::1',	1481814330,	'__ci_last_regenerate|i:1481814083;'),
('6c9a2d4e1084c80506b02a38e3e3daa263313cea',	'::1',	1481814735,	'__ci_last_regenerate|i:1481814437;'),
('bcc4602a74ca37ec7a2ff7f6cb52d9f1993210e3',	'::1',	1481814962,	'__ci_last_regenerate|i:1481814743;zalogowany|s:1:\"1\";'),
('8ca93e60c10e3849c0ea5701fb2e42109f5bf92c',	'::1',	1481815270,	'__ci_last_regenerate|i:1481815066;'),
('de4f8ff2e6991a738fe06634b4489319e2835c60',	'::1',	1481815835,	'__ci_last_regenerate|i:1481815535;zalogowany|s:1:\"3\";'),
('47365c59e550cac66be2e0a126afe41e9f4fef40',	'::1',	1481816137,	'__ci_last_regenerate|i:1481815838;zalogowany|s:1:\"4\";'),
('5e3eba0be435f230c65a2a2d18d6c46ad89c3d7c',	'::1',	1481816463,	'__ci_last_regenerate|i:1481816168;'),
('c033efeed3497958d55597588718e966042fd4fb',	'::1',	1481816707,	'__ci_last_regenerate|i:1481816470;'),
('07b1b13a845d7db1db1ca709333ae02ff6f4f2a8',	'::1',	1481817061,	'__ci_last_regenerate|i:1481816827;');

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

INSERT INTO `ocena` (`id_ocena`, `zlecenie_id`, `uzytkownik_id`, `ocena`, `komentarz`, `data`) VALUES
(1,	1,	3,	5,	'bardzo dobrze',	'2016-12-13'),
(2,	3,	3,	2,	'dwa na dziesiec',	'2016-12-15'),
(3,	5,	3,	6,	'wspaniale',	'2016-12-15'),
(4,	2,	2,	1,	'niestety źle wyszorowany piekarnik',	'2016-12-15');

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

INSERT INTO `uzytkownik` (`id_uzytkownik`, `email`, `haslo`, `nick`, `data_rejestracji`) VALUES
(1,	'daquan.goldbaum@o2.pl',	'rampampam',	'Dosia',	'2016-12-11'),
(2,	'daquan.goldbaum@onet.pl',	'abc',	'Czyścioszek',	'2016-12-11'),
(3,	'dildoschwagoons@gmail.com',	'abc123',	'Meister Proper',	'2016-12-08'),
(4,	'ktos@cos.pl',	'ktoscos',	'Pan Miotełka',	'2016-12-15');

DROP TABLE IF EXISTS `zgloszenie`;
CREATE TABLE `zgloszenie` (
  `id_zgloszenie` int(11) NOT NULL AUTO_INCREMENT,
  `zlecenie_id` int(11) NOT NULL,
  `zglaszajacy_id` int(11) NOT NULL,
  `czas` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_zgloszenie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `zgloszenie` (`id_zgloszenie`, `zlecenie_id`, `zglaszajacy_id`, `czas`) VALUES
(1,	1,	3,	'2016-12-13 18:20:22'),
(2,	3,	3,	'2016-12-13 19:16:34'),
(3,	2,	3,	'2016-12-13 19:18:23'),
(4,	5,	3,	'2016-12-13 19:31:19'),
(5,	6,	3,	'2016-12-15 15:36:33'),
(6,	6,	1,	'2016-12-15 15:37:22'),
(7,	6,	2,	'2016-12-15 15:38:02'),
(8,	2,	2,	'2016-12-15 15:38:05'),
(9,	15,	1,	'2016-12-15 16:40:17'),
(10,	12,	1,	'2016-12-15 16:40:24'),
(11,	9,	1,	'2016-12-15 16:40:29'),
(12,	16,	2,	'2016-12-15 16:40:47'),
(13,	12,	2,	'2016-12-15 16:40:54'),
(14,	8,	2,	'2016-12-15 16:40:58'),
(15,	14,	3,	'2016-12-15 16:41:15'),
(16,	11,	3,	'2016-12-15 16:41:21'),
(17,	7,	3,	'2016-12-15 16:41:24'),
(18,	12,	4,	'2016-12-15 16:41:37'),
(19,	10,	4,	'2016-12-15 16:41:39'),
(20,	8,	4,	'2016-12-15 16:41:42'),
(21,	7,	4,	'2016-12-15 16:41:45');

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

INSERT INTO `zlecenie` (`id_zlecenie`, `zlecajacy_id`, `miejsce`, `data`, `godzina`, `telefon`, `mail_kontaktowy`, `cena`, `pokoje_i_prace`) VALUES
(1,	1,	'Opole',	'2016-12-13',	'12:00:00',	'2224444444',	'daquan.goldbaum@o2.pl',	69,	'2_7|2_8|3_9|5_'),
(2,	1,	'Boroszow',	'2016-12-13',	'21:37:00',	'2224444444',	'daquan.goldbaum@o2.pl',	27,	'1_4|4_'),
(3,	1,	'Rozwadza',	'2016-12-15',	'12:00:00',	'2224444444',	'daquan.goldbaum@o2.pl',	55,	'3_6|5_14'),
(4,	3,	'Włochy',	'2016-12-14',	'15:55:00',	'666666666',	'dildoschwagoons@gmail.com',	78,	'2_3|4_12|5_'),
(5,	1,	'Zdzichy',	'2016-12-12',	'09:00:00',	'2224444444',	'daquan.goldbaum@o2.pl',	15,	'3_10'),
(6,	4,	'Nigdzie',	'2016-12-18',	'15:30:00',	'123',	'ktos@cos.pl',	77,	'2_|3_'),
(7,	1,	'Poznań',	'2016-12-24',	'13:55:00',	'567',	'daquan.goldbaum@o2.pl',	100,	'1_1|1_2|1_3|2_3|2_7|2_2|3_10|3_11'),
(8,	1,	'Warszaaw',	'2016-12-22',	'06:00:00',	'674',	'daquan.goldbaum@o2.pl',	44,	'1_2|1_3|2_|4_'),
(9,	2,	'Hogwart',	'2017-02-01',	'23:00:00',	'123123123',	'daquan.goldbaum@onet.pl',	256,	'1_1|1_2|1_3|3_6|3_9|4_6|4_9|4_12|5_13|6_17'),
(10,	2,	'Olsztyn',	'2016-01-12',	'13:34:00',	'5689212',	'daquan.goldbaum@onet.pl',	75,	'1_1|1_2|1_3|2_8|3_10'),
(11,	2,	'Domek',	'2016-12-14',	'07:30:00',	'123123123',	'daquan.goldbaum@onet.pl',	79,	'1_|2_|3_10|3_6'),
(12,	3,	'Paka',	'2016-12-29',	'09:40:00',	'56789234',	'dildoschwagoons@gmail.com',	46,	'2_3|2_7|5_14|6_16'),
(13,	3,	'Szczecin',	'2015-03-12',	'13:34:00',	'56789234',	'dildoschwagoons@gmail.com',	73,	'2_7|2_8|3_6|3_5|5_13'),
(14,	4,	'Rozwadza',	'2016-12-30',	'08:20:00',	'5689212',	'ktos@cos.pl',	15,	'1_3|1_4|2_3|2_7|3_|5_'),
(15,	4,	'Łódź',	'2017-01-22',	'11:02:00',	'123123123',	'ktos@cos.pl',	125,	'1_1|1_2|1_3|2_3|2_7|3_10|4_11|4_9|5_13'),
(16,	4,	'Rzeszów',	'2016-12-02',	'11:11:00',	'141266123',	'ktos@cos.pl',	69,	'2_3|2_8|4_|5_');

DROP TABLE IF EXISTS `zwyciezca`;
CREATE TABLE `zwyciezca` (
  `id_zwyciezca` int(11) NOT NULL AUTO_INCREMENT,
  `zlecenie_id` int(11) NOT NULL,
  `zgloszenie_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_zwyciezca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `zwyciezca` (`id_zwyciezca`, `zlecenie_id`, `zgloszenie_id`, `status`) VALUES
(2,	1,	1,	3),
(3,	3,	2,	3),
(4,	5,	4,	3),
(5,	6,	7,	1),
(6,	7,	17,	1),
(7,	2,	8,	3),
(8,	12,	18,	1),
(9,	9,	11,	1),
(10,	11,	16,	1),
(11,	15,	9,	1),
(12,	16,	12,	1),
(13,	14,	15,	1);

-- 2016-12-15 15:52:08
