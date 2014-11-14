-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Wersja serwera:               5.5.37-0ubuntu0.12.04.1 - (Ubuntu)
-- Serwer OS:                    debian-linux-gnu
-- HeidiSQL Wersja:              8.1.0.4545
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Zrzut struktury tabela imav.banner_ad
CREATE TABLE IF NOT EXISTS `banner_ad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publish` tinyint(1) DEFAULT '1',
  `metatag_id` int(11) DEFAULT NULL,
  `video_root_id` int(11) DEFAULT NULL,
  `allow_skip` tinyint(1) NOT NULL DEFAULT '0',
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  `target_href` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.banner_ad: 5 rows
DELETE FROM `banner_ad`;
/*!40000 ALTER TABLE `banner_ad` DISABLE KEYS */;
INSERT INTO `banner_ad` (`id`, `publish`, `metatag_id`, `video_root_id`, `allow_skip`, `date_from`, `date_to`, `target_href`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, NULL, 65, 0, '2014-10-05 00:00:00', '2014-10-31 00:00:00', NULL, '2014-10-06 12:44:02', '2014-10-24 14:15:07', NULL),
	(2, 1, NULL, 48, 0, '2014-10-05 00:00:00', '2014-12-31 00:00:00', NULL, '2014-10-06 12:52:06', '2014-10-06 12:52:06', NULL),
	(3, 1, NULL, 49, 0, '2014-10-05 00:00:00', '2014-10-15 00:00:00', 'http://www.onet.pl', '2014-10-06 13:00:16', '2014-10-09 14:23:48', NULL),
	(4, 0, NULL, 4, 0, '2014-10-01 00:00:00', '2014-10-10 00:00:00', NULL, '2014-10-09 14:06:10', '2014-10-14 13:08:45', NULL),
	(5, 1, NULL, NULL, 0, NULL, NULL, NULL, '2014-10-09 15:38:26', '2014-10-09 15:47:45', '2014-10-09 15:47:45');
/*!40000 ALTER TABLE `banner_ad` ENABLE KEYS */;


-- Zrzut struktury tabela imav.banner_ad_translation
CREATE TABLE IF NOT EXISTS `banner_ad_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.banner_ad_translation: 4 rows
DELETE FROM `banner_ad_translation`;
/*!40000 ALTER TABLE `banner_ad_translation` DISABLE KEYS */;
INSERT INTO `banner_ad_translation` (`id`, `title`, `slug`, `content`, `lang`) VALUES
	(1, 'Reklama nowa', 'reklama-nowa', NULL, 'pl'),
	(2, 'Reklama googla', 'reklama-googla', NULL, 'pl'),
	(3, 'Reklama googla dobra 359', 'reklama-googla-dobra-359', NULL, 'pl'),
	(4, 'Reklama tenis', 'reklama-tenis', NULL, 'pl');
/*!40000 ALTER TABLE `banner_ad_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.banner_banner
CREATE TABLE IF NOT EXISTS `banner_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_editor_id` int(11) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `photo_root_id` int(11) DEFAULT NULL,
  `attachment_root_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `date_from` datetime DEFAULT NULL,
  `date_to` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `banner_banner_photo_root_id_media_photo_id` (`photo_root_id`),
  KEY `banner_banner_metatag_id_default_metatag_id` (`metatag_id`),
  KEY `banner_banner_last_editor_id_user_user_id` (`last_editor_id`),
  KEY `banner_banner_attachment_root_id_media_attachment_id` (`attachment_root_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.banner_banner: 12 rows
DELETE FROM `banner_banner`;
/*!40000 ALTER TABLE `banner_banner` DISABLE KEYS */;
INSERT INTO `banner_banner` (`id`, `last_editor_id`, `website`, `position`, `status`, `photo_root_id`, `attachment_root_id`, `metatag_id`, `created_at`, `updated_at`, `deleted_at`, `date_from`, `date_to`) VALUES
	(1, NULL, 'http://www.onet.pl', NULL, 0, 115, NULL, 1644, '2014-04-30 13:11:57', '2014-09-01 15:05:41', '2014-09-01 15:05:41', NULL, NULL),
	(2, NULL, 'http://www.onet.pl', 'Gora', 1, NULL, 2, 1645, '2014-09-01 13:31:32', '2014-10-14 14:33:07', '2014-10-14 14:33:07', '2014-09-01 14:58:00', '2014-09-04 00:00:00'),
	(3, NULL, 'http://www.wp.pl', 'Gora', 1, NULL, NULL, 1646, '2014-09-01 15:06:27', '2014-10-14 14:33:04', '2014-10-14 14:33:04', '2014-09-01 15:06:00', '2014-09-19 00:00:00'),
	(4, NULL, NULL, 'Glowna', 1, NULL, 3, 1647, '2014-09-01 15:10:42', '2014-10-14 14:33:12', '2014-10-14 14:33:12', '2014-09-01 15:12:00', '2014-09-25 00:00:00'),
	(5, NULL, NULL, 'Sidebar1', 1, NULL, 8, 1648, '2014-09-01 15:13:01', '2014-10-14 14:33:51', NULL, '2014-09-01 00:00:00', '2014-12-20 00:00:00'),
	(6, NULL, NULL, 'Sidebar2', 1, NULL, 5, 1649, '2014-09-01 15:13:47', '2014-10-14 14:33:47', '2014-10-14 14:33:47', '2014-09-01 15:13:00', '2014-09-30 00:00:00'),
	(7, NULL, NULL, 'MainFirst', 1, NULL, 12, 1650, '2014-09-01 15:14:22', '2014-10-15 12:37:57', '2014-10-15 12:37:57', '2014-09-01 00:00:00', '2014-11-21 00:00:00'),
	(8, NULL, NULL, 'Sidebar2', 1, NULL, 7, 1651, '2014-09-01 15:14:44', '2014-10-14 14:32:58', '2014-10-14 14:32:58', '2014-09-18 00:00:00', '2014-09-26 00:00:00'),
	(9, NULL, 'http://www.onet.pl', 'UnderNews', 1, NULL, 9, 1662, '2014-10-14 14:27:13', '2014-10-15 12:36:59', '2014-10-15 12:36:59', '2014-10-14 14:26:00', '2014-10-31 00:00:00'),
	(10, NULL, NULL, 'UnderNews', 1, NULL, NULL, 1663, '2014-10-14 14:28:45', '2014-10-15 12:36:41', NULL, '2014-10-14 14:28:00', '2014-11-08 00:00:00'),
	(11, NULL, NULL, 'MainSecond', 1, NULL, 13, 1680, '2014-10-15 12:36:22', '2014-10-15 12:36:22', NULL, '2014-10-15 12:36:00', '2014-12-19 00:00:00'),
	(12, NULL, NULL, 'MainFirst', 1, NULL, 14, 1681, '2014-10-15 12:37:24', '2014-10-15 12:37:24', NULL, '2014-10-15 12:37:00', '2014-12-27 00:00:00');
/*!40000 ALTER TABLE `banner_banner` ENABLE KEYS */;


-- Zrzut struktury tabela imav.banner_banner_translation
CREATE TABLE IF NOT EXISTS `banner_banner_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.banner_banner_translation: 13 rows
DELETE FROM `banner_banner_translation`;
/*!40000 ALTER TABLE `banner_banner_translation` DISABLE KEYS */;
INSERT INTO `banner_banner_translation` (`id`, `name`, `slug`, `description`, `lang`) VALUES
	(1, 'Testowy banner', 'testowy-banner', NULL, 'pl'),
	(1, NULL, NULL, NULL, 'en'),
	(2, 'Baner pierw', 'baner-pierw', NULL, 'pl'),
	(3, 'Baner gora 2', 'baner-gora-2', NULL, 'pl'),
	(4, 'Baner główny', 'baner-glowny', NULL, 'pl'),
	(5, 'Prawo top', 'prawo-top', NULL, 'pl'),
	(6, 'Sidebar dol', 'sidebar-dol', NULL, 'pl'),
	(7, 'Pod kategoria 1', 'pod-kategoria-1', NULL, 'pl'),
	(8, 'Sidebar 3', 'sidebar-3', NULL, 'pl'),
	(9, 'Banner pod newsem', 'banner-pod-newsem', NULL, 'pl'),
	(10, 'Banner pod newsem 2', 'banner-pod-newsem-2', NULL, 'pl'),
	(11, 'Pod kategoria 2', 'pod-kategoria-2', NULL, 'pl'),
	(12, 'Pod kategoria 1', 'pod-kategoria-1-1', NULL, 'pl');
/*!40000 ALTER TABLE `banner_banner_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.censor_censor
CREATE TABLE IF NOT EXISTS `censor_censor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.censor_censor: 2 rows
DELETE FROM `censor_censor`;
/*!40000 ALTER TABLE `censor_censor` DISABLE KEYS */;
INSERT INTO `censor_censor` (`id`, `type`) VALUES
	(2, NULL),
	(3, NULL);
/*!40000 ALTER TABLE `censor_censor` ENABLE KEYS */;


-- Zrzut struktury tabela imav.censor_censor_translation
CREATE TABLE IF NOT EXISTS `censor_censor_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.censor_censor_translation: 2 rows
DELETE FROM `censor_censor_translation`;
/*!40000 ALTER TABLE `censor_censor_translation` DISABLE KEYS */;
INSERT INTO `censor_censor_translation` (`id`, `title`, `slug`, `lang`) VALUES
	(2, 'Głupek', 'glupek', 'pl'),
	(3, 'Janek', 'janek', 'pl');
/*!40000 ALTER TABLE `censor_censor_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.censor_ip
CREATE TABLE IF NOT EXISTS `censor_ip` (
  `ip` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.censor_ip: 2 rows
DELETE FROM `censor_ip`;
/*!40000 ALTER TABLE `censor_ip` DISABLE KEYS */;
INSERT INTO `censor_ip` (`ip`, `created_at`, `updated_at`) VALUES
	('200.5000.111', '2014-10-14 14:54:42', '2014-10-14 14:54:42'),
	('3151', '2014-10-14 14:54:53', '2014-10-14 14:54:53');
/*!40000 ALTER TABLE `censor_ip` ENABLE KEYS */;


-- Zrzut struktury tabela imav.default_available_route
CREATE TABLE IF NOT EXISTS `default_available_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.default_available_route: 5 rows
DELETE FROM `default_available_route`;
/*!40000 ALTER TABLE `default_available_route` DISABLE KEYS */;
INSERT INTO `default_available_route` (`id`, `route`, `name`) VALUES
	(3, 'domain-list-gallery', 'Galeria'),
	(11, 'domain-news-student', 'Studenckie aktualności'),
	(8, 'domain-news-category', 'Kategoria aktualności'),
	(9, 'domain-news-group', 'Grupa aktualności'),
	(12, 'domain-contact', 'Kontakt');
/*!40000 ALTER TABLE `default_available_route` ENABLE KEYS */;


-- Zrzut struktury tabela imav.default_city
CREATE TABLE IF NOT EXISTS `default_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `province_id_idx` (`province_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2329 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.default_city: 2 328 rows
DELETE FROM `default_city`;
/*!40000 ALTER TABLE `default_city` DISABLE KEYS */;
INSERT INTO `default_city` (`id`, `name`, `province_id`) VALUES
	(1, 'BolesĹawiec', 1),
	(2, 'Gromadka', 1),
	(3, 'Nowogrodziec', 1),
	(4, 'Osiecznica', 1),
	(5, 'Warta BolesĹawiecka', 1),
	(6, 'Jawor', 1),
	(7, 'BolkĂłw', 1),
	(8, 'MÄcinka', 1),
	(9, 'MĹciwojĂłw', 1),
	(10, 'Paszowice', 1),
	(11, 'WÄdroĹźe Wielkie', 1),
	(12, 'Karpacz', 1),
	(13, 'Kowary', 1),
	(14, 'Piechowice', 1),
	(15, 'Szklarska PorÄba', 1),
	(16, 'Janowice Wielkie', 1),
	(17, 'JeĹźĂłw Sudecki', 1),
	(18, 'MysĹakowice', 1),
	(19, 'PodgĂłrzyn', 1),
	(20, 'Stara Kamienica', 1),
	(21, 'Kamienna GĂłra', 1),
	(22, 'Lubawka', 1),
	(23, 'MarciszĂłw', 1),
	(24, 'LubaĹ', 1),
	(25, 'ĹwieradĂłw-ZdrĂłj', 1),
	(26, 'LeĹna', 1),
	(27, 'Olszyna', 1),
	(28, 'PlaterĂłwka', 1),
	(29, 'Siekierczyn', 1),
	(30, 'GryfĂłw ĹlÄski', 1),
	(31, 'Lubomierz', 1),
	(32, 'LwĂłwek ĹlÄski', 1),
	(33, 'Mirsk', 1),
	(34, 'WleĹ', 1),
	(35, 'ZawidĂłw', 1),
	(36, 'Zgorzelec', 1),
	(37, 'Bogatynia', 1),
	(38, 'PieĹsk', 1),
	(39, 'SulikĂłw', 1),
	(40, 'WÄgliniec', 1),
	(41, 'WojcieszĂłw', 1),
	(42, 'ZĹotoryja', 1),
	(43, 'Pielgrzymka', 1),
	(44, 'Ĺwierzawa', 1),
	(45, 'Zagrodno', 1),
	(46, 'Jelenia GĂłra', 1),
	(47, 'GĹogĂłw', 1),
	(48, 'Jerzmanowa', 1),
	(49, 'Kotla', 1),
	(50, 'PÄcĹaw', 1),
	(51, 'Ĺťukowice', 1),
	(52, 'GĂłra', 1),
	(53, 'Jemielno', 1),
	(54, 'NiechlĂłw', 1),
	(55, 'WÄsosz', 1),
	(56, 'ChojnĂłw', 1),
	(57, 'Krotoszyce', 1),
	(58, 'Kunice', 1),
	(59, 'Legnickie Pole', 1),
	(60, 'MiĹkowice', 1),
	(61, 'Prochowice', 1),
	(62, 'Ruja', 1),
	(63, 'Lubin', 1),
	(64, 'Rudna', 1),
	(65, 'Ĺcinawa', 1),
	(66, 'ChocianĂłw', 1),
	(67, 'Gaworzyce', 1),
	(68, 'GrÄbocice', 1),
	(69, 'Polkowice', 1),
	(70, 'PrzemkĂłw', 1),
	(71, 'Radwanice', 1),
	(72, 'Legnica', 1),
	(73, 'Bielawa', 1),
	(74, 'DzierĹźoniĂłw', 1),
	(75, 'Pieszyce', 1),
	(76, 'PiĹawa GĂłrna', 1),
	(77, 'Ĺagiewniki', 1),
	(78, 'Niemcza', 1),
	(79, 'Duszniki', 1),
	(80, 'KĹodzko', 1),
	(81, 'Kudowa-ZdrĂłj', 1),
	(82, 'Nowa Ruda', 1),
	(83, 'Polanica-ZdrĂłj', 1),
	(84, 'Bystrzyca KĹodzka', 1),
	(85, 'LÄdek-ZdrĂłj', 1),
	(86, 'Lewin KĹodzki', 1),
	(87, 'MiÄdzylesie', 1),
	(88, 'RadkĂłw', 1),
	(89, 'Stronie ĹlÄskie', 1),
	(90, 'Szczytna', 1),
	(91, 'Ĺwidnica', 1),
	(92, 'Ĺwiebodzice', 1),
	(93, 'Dobromierz', 1),
	(94, 'Jaworzyna ĹlÄska', 1),
	(95, 'Marcinowice', 1),
	(96, 'Strzegom', 1),
	(97, 'ĹťarĂłw', 1),
	(98, 'BoguszĂłw-Gorce', 1),
	(99, 'Jedlina-ZdrĂłj', 1),
	(100, 'Szczawno', 1),
	(101, 'Czarny BĂłr', 1),
	(102, 'GĹuszyca', 1),
	(103, 'MieroszĂłw', 1),
	(104, 'Stare Bogaczowice', 1),
	(105, 'Walim', 1),
	(106, 'WaĹbrzych', 1),
	(107, 'Bardo', 1),
	(108, 'CiepĹowody', 1),
	(109, 'Kamieniec ZÄbkowicki', 1),
	(110, 'Stoszowice', 1),
	(111, 'ZÄbkowice ĹlÄskie', 1),
	(112, 'ZiÄbice', 1),
	(113, 'ZĹoty Stok', 1),
	(114, 'CieszkĂłw', 1),
	(115, 'KroĹnice', 1),
	(116, 'Milicz', 1),
	(117, 'OleĹnica', 1),
	(118, 'BierutĂłw', 1),
	(119, 'Dobroszyce', 1),
	(120, 'Dziadowa KĹoda', 1),
	(121, 'MiÄdzybĂłrz', 1),
	(122, 'SycĂłw', 1),
	(123, 'TwardogĂłra', 1),
	(124, 'OĹawa', 1),
	(125, 'DomaniĂłw', 1),
	(126, 'Jelcz-Laskowice', 1),
	(127, 'BorĂłw', 1),
	(128, 'Kondratowice', 1),
	(129, 'Przeworno', 1),
	(130, 'Strzelin', 1),
	(131, 'WiÄzĂłw', 1),
	(132, 'KostomĹoty', 1),
	(133, 'Malczyce', 1),
	(134, 'MiÄkinia', 1),
	(135, 'Ĺroda ĹlÄska', 1),
	(136, 'Udanin', 1),
	(137, 'Oborniki ĹlÄskie', 1),
	(138, 'Prusice', 1),
	(139, 'Trzebnica', 1),
	(140, 'Wisznia MaĹa', 1),
	(141, 'Zawonia', 1),
	(142, 'ĹťmigrĂłd', 1),
	(143, 'Brzeg Dolny', 1),
	(144, 'WiĹsko', 1),
	(145, 'WoĹĂłw', 1),
	(146, 'Czernica', 1),
	(147, 'DĹugoĹÄka', 1),
	(148, 'JordanĂłw ĹlÄski', 1),
	(149, 'KÄty WrocĹawskie', 1),
	(150, 'Kobierzyce', 1),
	(151, 'MietkĂłw', 1),
	(152, 'SobĂłtka', 1),
	(153, 'ĹwiÄta Katarzyna', 1),
	(154, 'Siechnice', 1),
	(155, 'ĹťĂłrawina', 1),
	(156, 'WrocĹaw', 1),
	(157, 'BiaĹe BĹota', 2),
	(158, 'DÄbrowa CheĹmiĹska', 2),
	(159, 'Dobrcz', 2),
	(160, 'Koronowo', 2),
	(161, 'Nowa WieĹ Wielka', 2),
	(162, 'Osielsko', 2),
	(163, 'Sicienko', 2),
	(164, 'Solec Kujawski', 2),
	(165, 'CheĹmĹźa', 2),
	(166, 'Czernikowo', 2),
	(167, 'Lubicz', 2),
	(168, 'Ĺubianka', 2),
	(169, 'Ĺysomice', 2),
	(170, 'Obrowo', 2),
	(171, 'Wielka Nieszawka', 2),
	(172, 'ZĹawieĹ Wielka', 2),
	(173, 'Bydgoszcz', 2),
	(174, 'ToruĹ', 2),
	(175, 'Brodnica', 2),
	(176, 'Bobrowo', 2),
	(177, 'Brzozie', 2),
	(178, 'GĂłrzno', 2),
	(179, 'Bartniczka', 2),
	(180, 'JabĹonowo Pomorskie', 2),
	(181, 'Osiek', 2),
	(182, 'Ĺwiedziebnia', 2),
	(183, 'Zbiczno', 2),
	(184, 'CheĹmno', 2),
	(185, 'Kijewo KrĂłlewskie', 2),
	(186, 'Lisewo', 2),
	(187, 'Papowo Biskupie', 2),
	(188, 'Stolno', 2),
	(189, 'UnisĹaw', 2),
	(190, 'Golub-DobrzyĹ', 2),
	(191, 'Ciechocin', 2),
	(192, 'Kowalewo Pomorskie', 2),
	(193, 'Radomin', 2),
	(194, 'ZbĂłjno', 2),
	(195, 'GrudziÄdz', 2),
	(196, 'Gruta', 2),
	(197, 'Ĺasin', 2),
	(198, 'RadzyĹ CheĹmiĹski', 2),
	(199, 'RogĂłĹşno', 2),
	(200, 'Ĺwiecie nad OsÄ', 2),
	(201, 'KamieĹ KrajeĹski', 2),
	(202, 'SÄpĂłlno KrajeĹskie', 2),
	(203, 'SoĹno', 2),
	(204, 'WiÄcbork', 2),
	(205, 'Bukowiec', 2),
	(206, 'Dragacz', 2),
	(207, 'Drzycim', 2),
	(208, 'JeĹźewo', 2),
	(209, 'Lniano', 2),
	(210, 'Nowe', 2),
	(211, 'Osie', 2),
	(212, 'Pruszcz', 2),
	(213, 'Ĺwiecie', 2),
	(214, 'Ĺwiekatowo', 2),
	(215, 'Warlubie', 2),
	(216, 'Cekcyn', 2),
	(217, 'Gostycyn', 2),
	(218, 'KÄsowo', 2),
	(219, 'Lubiewo', 2),
	(220, 'Ĺliwice', 2),
	(221, 'Tuchola', 2),
	(222, 'WÄbrzeĹşno', 2),
	(223, 'DÄbowa ĹÄka', 2),
	(224, 'KsiÄĹźki', 2),
	(225, 'PĹuĹźnica', 2),
	(226, 'AleksandrĂłw Kujawski', 2),
	(227, 'Ciechocinek', 2),
	(228, 'Nieszawa', 2),
	(229, 'BÄdkowo', 2),
	(230, 'Koneck', 2),
	(231, 'RaciÄĹźek', 2),
	(232, 'Waganiec', 2),
	(233, 'Zakrzewo', 2),
	(234, 'InowrocĹaw', 2),
	(235, 'DÄbrowa Biskupia', 2),
	(236, 'Gniewkowo', 2),
	(237, 'Janikowo', 2),
	(238, 'Kruszwica', 2),
	(239, 'PakoĹÄ', 2),
	(240, 'Rojewo', 2),
	(241, 'ZĹotniki Kujawskie', 2),
	(242, 'Lipno', 2),
	(243, 'Bobrowniki', 2),
	(244, 'Chrostkowo', 2),
	(245, 'DobrzyĹ nad WisĹÄ', 2),
	(246, 'KikĂłĹ', 2),
	(247, 'SkÄpe', 2),
	(248, 'TĹuchowo', 2),
	(249, 'Wielgie', 2),
	(250, 'DÄbrowa', 2),
	(251, 'Jeziora Wielkie', 2),
	(252, 'Mogilno', 2),
	(253, 'Strzelno', 2),
	(254, 'Kcynia', 2),
	(255, 'Mrocza', 2),
	(256, 'NakĹo nad NoteciÄ', 2),
	(257, 'Sadki', 2),
	(258, 'Szubin', 2),
	(259, 'RadziejĂłw', 2),
	(260, 'BytoĹ', 2),
	(261, 'Dobre', 2),
	(262, 'OsiÄciny', 2),
	(263, 'PiotrkĂłw Kujawski', 2),
	(264, 'TopĂłlka', 2),
	(265, 'Rypin', 2),
	(266, 'Brzuze', 2),
	(267, 'Rogowo', 2),
	(268, 'Skrwilno', 2),
	(269, 'WÄpielsk', 2),
	(270, 'Kowal', 2),
	(271, 'Baruchowo', 2),
	(272, 'Boniewo', 2),
	(273, 'BrzeĹÄ Kujawski', 2),
	(274, 'ChoceĹ', 2),
	(275, 'Chodecz', 2),
	(276, 'Fabianki', 2),
	(277, 'Izbica Kujawska', 2),
	(278, 'Lubanie', 2),
	(279, 'LubieĹ Kujawski', 2),
	(280, 'Lubraniec', 2),
	(281, 'WĹocĹawek', 2),
	(282, 'Barcin', 2),
	(283, 'GÄsawa', 2),
	(284, 'Janowiec Wielkopolski', 2),
	(285, 'Ĺabiszyn', 2),
	(286, 'Ĺťnin', 2),
	(287, 'MiÄdzyrzec Podlaski', 3),
	(288, 'Terespol', 3),
	(289, 'BiaĹa Podlaska', 3),
	(290, 'DrelĂłw', 3),
	(291, 'JanĂłw Podlaski', 3),
	(292, 'KodeĹ', 3),
	(293, 'KonstantynĂłw', 3),
	(294, 'LeĹna Podlaska', 3),
	(295, 'Ĺomazy', 3),
	(296, 'Piszczac', 3),
	(297, 'Rokitno', 3),
	(298, 'Rossosz', 3),
	(299, 'SĹawatycze', 3),
	(300, 'SosnĂłwka', 3),
	(301, 'Tuczna', 3),
	(302, 'Wisznice', 3),
	(303, 'Zalesie', 3),
	(304, 'DÄbowa KĹoda', 3),
	(305, 'JabĹoĹ', 3),
	(306, 'MilanĂłw', 3),
	(307, 'Parczew', 3),
	(308, 'PodedwĂłrze', 3),
	(309, 'SiemieĹ', 3),
	(310, 'Sosnowica', 3),
	(311, 'RadzyĹ Podlaski', 3),
	(312, 'Borki', 3),
	(313, 'Czemierniki', 3),
	(314, 'KÄkolewnica Wschodnia', 3),
	(315, 'KomarĂłwka Podlaska', 3),
	(316, 'Ulan', 3),
	(317, 'WohyĹ', 3),
	(318, 'WĹodawa', 3),
	(319, 'Hanna', 3),
	(320, 'HaĹsk', 3),
	(321, 'Stary Brus', 3),
	(322, 'Urszulin', 3),
	(323, 'Wola Uhruska', 3),
	(324, 'Wyryki', 3),
	(325, 'BiĹgoraj', 3),
	(326, 'AleksandrĂłw', 3),
	(327, 'Biszcza', 3),
	(328, 'Frampol', 3),
	(329, 'Goraj', 3),
	(330, 'JĂłzefĂłw', 3),
	(331, 'KsiÄĹźpol', 3),
	(332, 'Ĺukowa', 3),
	(333, 'Obsza', 3),
	(334, 'Potok GĂłrny', 3),
	(335, 'TarnogrĂłd', 3),
	(336, 'Tereszpol', 3),
	(337, 'Turobin', 3),
	(338, 'Rejowiec Fabryczny', 3),
	(339, 'BiaĹopole', 3),
	(340, 'CheĹm', 3),
	(341, 'Dorohusk', 3),
	(342, 'Dubienka', 3),
	(343, 'KamieĹ', 3),
	(344, 'LeĹniowice', 3),
	(345, 'Ruda', 3),
	(346, 'Sawin', 3),
	(347, 'Siedliszcze', 3),
	(348, 'Wierzbica', 3),
	(349, 'WojsĹawice', 3),
	(350, 'ĹťmudĹş', 3),
	(351, 'Rejowiec', 3),
	(352, 'HrubieszĂłw', 3),
	(353, 'DoĹhobyczĂłw', 3),
	(354, 'HorodĹo', 3),
	(355, 'Mircze', 3),
	(356, 'Trzeszczany', 3),
	(357, 'Uchanie', 3),
	(358, 'Werbkowice', 3),
	(359, 'Krasnystaw', 3),
	(360, 'FajsĹawice', 3),
	(361, 'GorzkĂłw', 3),
	(362, 'Izbica', 3),
	(363, 'KraĹniczyn', 3),
	(364, 'Ĺopiennik GĂłrny', 3),
	(365, 'Rudnik', 3),
	(366, 'Siennica RĂłĹźana', 3),
	(367, 'ĹťĂłĹkiewka', 3),
	(368, 'TomaszĂłw Lubelski', 3),
	(369, 'BeĹĹźec', 3),
	(370, 'JarczĂłw', 3),
	(371, 'Krynice', 3),
	(372, 'Lubycza KrĂłlewska', 3),
	(373, 'ĹaszczĂłw', 3),
	(374, 'Rachanie', 3),
	(375, 'Susiec', 3),
	(376, 'Tarnawatka', 3),
	(377, 'Telatyn', 3),
	(378, 'Tyszowce', 3),
	(379, 'UlhĂłwek', 3),
	(380, 'AdamĂłw', 3),
	(381, 'Grabowiec', 3),
	(382, 'KomarĂłw', 3),
	(383, 'KrasnobrĂłd', 3),
	(384, 'Ĺabunie', 3),
	(385, 'MiÄczyn', 3),
	(386, 'Nielisz', 3),
	(387, 'Radecznica', 3),
	(388, 'Sitno', 3),
	(389, 'SkierbieszĂłw', 3),
	(390, 'Stary ZamoĹÄ', 3),
	(391, 'SuĹĂłw', 3),
	(392, 'Szczebrzeszyn', 3),
	(393, 'ZamoĹÄ', 3),
	(394, 'Zwierzyniec', 3),
	(395, 'LubartĂłw', 3),
	(396, 'AbramĂłw', 3),
	(397, 'Firlej', 3),
	(398, 'Jeziorzany', 3),
	(399, 'Kamionka', 3),
	(400, 'Kock', 3),
	(401, 'MichĂłw', 3),
	(402, 'NiedĹşwiada', 3),
	(403, 'OstrĂłw Lubelski', 3),
	(404, 'OstrĂłwek', 3),
	(405, 'Serniki', 3),
	(406, 'UĹcimĂłw', 3),
	(407, 'BeĹĹźyce', 3),
	(408, 'BorzechĂłw', 3),
	(409, 'Bychawa', 3),
	(410, 'GarbĂłw', 3),
	(411, 'GĹusk', 3),
	(412, 'JabĹonna', 3),
	(413, 'JastkĂłw', 3),
	(414, 'Konopnica', 3),
	(415, 'KrzczonĂłw', 3),
	(416, 'Niedrzwica DuĹźa', 3),
	(417, 'Niemce', 3),
	(418, 'StrzyĹźewice', 3),
	(419, 'WojciechĂłw', 3),
	(420, 'WĂłlka', 3),
	(421, 'Wysokie', 3),
	(422, 'Zakrzew', 3),
	(423, 'CycĂłw', 3),
	(424, 'Ludwin', 3),
	(425, 'ĹÄczna', 3),
	(426, 'MilejĂłw', 3),
	(427, 'PuchaczĂłw', 3),
	(428, 'Spiczyn', 3),
	(429, 'Ĺwidnik', 3),
	(430, 'MeĹgiew', 3),
	(431, 'Piaski', 3),
	(432, 'Rybczewice', 3),
	(433, 'Trawniki', 3),
	(434, 'Lublin', 3),
	(435, 'Batorz', 3),
	(436, 'ChrzanĂłw', 3),
	(437, 'Dzwola', 3),
	(438, 'GodziszĂłw', 3),
	(439, 'JanĂłw Lubelski', 3),
	(440, 'Modliborzyce', 3),
	(441, 'Potok Wielki', 3),
	(442, 'KraĹnik', 3),
	(443, 'Annopol', 3),
	(444, 'Dzierzkowice', 3),
	(445, 'GoĹcieradĂłw', 3),
	(446, 'Szastarka', 3),
	(447, 'Trzydnik DuĹźy', 3),
	(448, 'UrzÄdĂłw', 3),
	(449, 'WilkoĹaz', 3),
	(450, 'ZakrzĂłwek', 3),
	(451, 'ĹukĂłw', 3),
	(452, 'Stoczek Ĺukowski', 3),
	(453, 'Krzywda', 3),
	(454, 'Serokomla', 3),
	(455, 'Stanin', 3),
	(456, 'TrzebieszĂłw', 3),
	(457, 'WojcieszkĂłw', 3),
	(458, 'Wola MysĹowska', 3),
	(459, 'Chodel', 3),
	(460, 'JĂłzefĂłw nad WisĹÄ', 3),
	(461, 'Karczmiska', 3),
	(462, 'Ĺaziska', 3),
	(463, 'Opole Lubelskie', 3),
	(464, 'Poniatowa', 3),
	(465, 'WilkĂłw', 3),
	(466, 'PuĹawy', 3),
	(467, 'BaranĂłw', 3),
	(468, 'Janowiec', 3),
	(469, 'Kazimierz Dolny', 3),
	(470, 'KoĹskowola', 3),
	(471, 'KurĂłw', 3),
	(472, 'MarkuszĂłw', 3),
	(473, 'NaĹÄczĂłw', 3),
	(474, 'WÄwolnica', 3),
	(475, 'Ĺťyrzyn', 3),
	(476, 'DÄblin', 3),
	(477, 'KĹoczew', 3),
	(478, 'NowodwĂłr', 3),
	(479, 'Ryki', 3),
	(480, 'StÄĹźyca', 3),
	(481, 'UĹÄĹź', 3),
	(482, 'Kostrzyn nad OdrÄ', 4),
	(483, 'Bogdaniec', 4),
	(484, 'Deszczno', 4),
	(485, 'KĹodawa', 4),
	(486, 'Lubiszyn', 4),
	(487, 'Santok', 4),
	(488, 'Witnica', 4),
	(489, 'Bledzew', 4),
	(490, 'MiÄdzyrzecz', 4),
	(491, 'Przytoczna', 4),
	(492, 'Pszczew', 4),
	(493, 'Skwierzyna', 4),
	(494, 'Trzciel', 4),
	(495, 'Cybinka', 4),
	(496, 'GĂłrzyca', 4),
	(497, 'OĹno Lubuskie', 4),
	(498, 'Rzepin', 4),
	(499, 'SĹubice', 4),
	(500, 'Dobiegniew', 4),
	(501, 'Drezdenko', 4),
	(502, 'Stare Kurowo', 4),
	(503, 'Strzelce KrajeĹskie', 4),
	(504, 'Zwierzyn', 4),
	(505, 'Krzeszyce', 4),
	(506, 'Lubniewice', 4),
	(507, 'SĹoĹsk', 4),
	(508, 'SulÄcin', 4),
	(509, 'Torzym', 4),
	(510, 'GorzĂłw Wielkopolski', 4),
	(511, 'Gubin', 4),
	(512, 'Bobrowice', 4),
	(513, 'Bytnica', 4),
	(514, 'DÄbie', 4),
	(515, 'Krosno OdrzaĹskie', 4),
	(516, 'Maszewo', 4),
	(517, 'Nowa SĂłl', 4),
	(518, 'Bytom OdrzaĹski', 4),
	(519, 'Kolsko', 4),
	(520, 'KoĹźuchĂłw', 4),
	(521, 'Nowe Miasteczko', 4),
	(522, 'OtyĹ', 4),
	(523, 'Siedlisko', 4),
	(524, 'SĹawa', 4),
	(525, 'Szlichtyngowa', 4),
	(526, 'Wschowa', 4),
	(527, 'Lubrza', 4),
	(528, 'ĹagĂłw', 4),
	(529, 'SkÄpe', 4),
	(530, 'Szczaniec', 4),
	(531, 'Ĺwiebodzin', 4),
	(532, 'ZbÄszynek', 4),
	(533, 'Babimost', 4),
	(534, 'BojadĹa', 4),
	(535, 'CzerwieĹsk', 4),
	(536, 'Kargowa', 4),
	(537, 'NowogrĂłd BobrzaĹski', 4),
	(538, 'SulechĂłw', 4),
	(539, 'Ĺwidnica', 4),
	(540, 'TrzebiechĂłw', 4),
	(541, 'ZabĂłr', 4),
	(542, 'Zielona GĂłra', 4),
	(543, 'Gozdnica', 4),
	(544, 'ĹťagaĹ', 4),
	(545, 'BrzeĹşnica', 4),
	(546, 'IĹowa', 4),
	(547, 'MaĹomice', 4),
	(548, 'NiegosĹawice', 4),
	(549, 'Szprotawa', 4),
	(550, 'Wymiarki', 4),
	(551, 'ĹÄknica', 4),
	(552, 'Ĺťary', 4),
	(553, 'Brody', 4),
	(554, 'JasieĹ', 4),
	(555, 'Lipinki ĹuĹźyckie', 4),
	(556, 'Lubsko', 4),
	(557, 'PrzewĂłz', 4),
	(558, 'Trzebiel', 4),
	(559, 'Tuplice', 4),
	(560, 'Brzeziny', 5),
	(561, 'Andrespol', 5),
	(562, 'BrĂłjce', 5),
	(563, 'Dmosin', 5),
	(564, 'JeĹźĂłw', 5),
	(565, 'Koluszki', 5),
	(566, 'Nowosolna', 5),
	(567, 'RogĂłw', 5),
	(568, 'RzgĂłw', 5),
	(569, 'Tuszyn', 5),
	(570, 'KonstantynĂłw ĹĂłdzki', 5),
	(571, 'Pabianice', 5),
	(572, 'DĹutĂłw', 5),
	(573, 'DobroĹ', 5),
	(574, 'KsawerĂłw', 5),
	(575, 'Lutomiersk', 5),
	(576, 'GĹowno', 5),
	(577, 'OzorkĂłw', 5),
	(578, 'Zgierz', 5),
	(579, 'AleksandrĂłw ĹĂłdzki', 5),
	(580, 'ParzÄczew', 5),
	(581, 'StrykĂłw', 5),
	(582, 'ĹĂłdĹş', 5),
	(583, 'BeĹchatĂłw', 5),
	(584, 'DruĹźbice', 5),
	(585, 'KleszczĂłw', 5),
	(586, 'Kluki', 5),
	(587, 'Rusiec', 5),
	(588, 'SzczercĂłw', 5),
	(589, 'ZelĂłw', 5),
	(590, 'BiaĹaczĂłw', 5),
	(591, 'Drzewica', 5),
	(592, 'MniszkĂłw', 5),
	(593, 'Opoczno', 5),
	(594, 'ParadyĹź', 5),
	(595, 'PoĹwiÄtne', 5),
	(596, 'SĹawno', 5),
	(597, 'ĹťarnĂłw', 5),
	(598, 'AleksandrĂłw', 5),
	(599, 'Czarnocin', 5),
	(600, 'Gorzkowice', 5),
	(601, 'Grabica', 5),
	(602, 'ĹÄki Szlacheckie', 5),
	(603, 'Moszczenica', 5),
	(604, 'RÄczno', 5),
	(605, 'Rozprza', 5),
	(606, 'SulejĂłw', 5),
	(607, 'Wola Krzysztoporska', 5),
	(608, 'WolbĂłrz', 5),
	(609, 'Radomsko', 5),
	(610, 'Dobryszyce', 5),
	(611, 'Gidle', 5),
	(612, 'Gomunice', 5),
	(613, 'KamieĹsk', 5),
	(614, 'Kobiele Wielkie', 5),
	(615, 'KodrÄb', 5),
	(616, 'Lgota Wielka', 5),
	(617, 'Ĺadzice', 5),
	(618, 'MasĹowice', 5),
	(619, 'PrzedbĂłrz', 5),
	(620, 'WielgomĹyny', 5),
	(621, 'Ĺťytno', 5),
	(622, 'TomaszĂłw Mazowiecki', 5),
	(623, 'BÄdkĂłw', 5),
	(624, 'Budziszewice', 5),
	(625, 'Czerniewice', 5),
	(626, 'InowĹĂłdz', 5),
	(627, 'Lubochnia', 5),
	(628, 'Rokiciny', 5),
	(629, 'Rzeczyca', 5),
	(630, 'Ujazd', 5),
	(631, 'Ĺťelechlinek', 5),
	(632, 'PiotrkĂłw Trybunalski', 5),
	(633, 'Buczek', 5),
	(634, 'Ĺask', 5),
	(635, 'SÄdziejowice', 5),
	(636, 'Widawa', 5),
	(637, 'Wodzierady', 5),
	(638, 'DziaĹoszyn', 5),
	(639, 'KieĹczygĹĂłw', 5),
	(640, 'Nowa BrzeĹşnica', 5),
	(641, 'PajÄczno', 5),
	(642, 'RzÄĹnia', 5),
	(643, 'Siemkowice', 5),
	(644, 'Strzelce Wielkie', 5),
	(645, 'Sulmierzyce', 5),
	(646, 'DalikĂłw', 5),
	(647, 'PÄczniew', 5),
	(648, 'PoddÄbice', 5),
	(649, 'UniejĂłw', 5),
	(650, 'Wartkowice', 5),
	(651, 'Zadzim', 5),
	(652, 'Sieradz', 5),
	(653, 'BĹaszki', 5),
	(654, 'BrÄszewice', 5),
	(655, 'BrzeĹşnio', 5),
	(656, 'Burzenin', 5),
	(657, 'GoszczanĂłw', 5),
	(658, 'Klonowa', 5),
	(659, 'Warta', 5),
	(660, 'WrĂłblew', 5),
	(661, 'ZĹoczew', 5),
	(662, 'BiaĹa', 5),
	(663, 'CzarnoĹźyĹy', 5),
	(664, 'Konopnica', 5),
	(665, 'Mokrsko', 5),
	(666, 'OsjakĂłw', 5),
	(667, 'OstrĂłwek', 5),
	(668, 'PÄtnĂłw', 5),
	(669, 'Skomlin', 5),
	(670, 'WieluĹ', 5),
	(671, 'Wierzchlas', 5),
	(672, 'BolesĹawiec', 5),
	(673, 'Czastary', 5),
	(674, 'Galewice', 5),
	(675, 'LututĂłw', 5),
	(676, 'Ĺubnice', 5),
	(677, 'Sokolniki', 5),
	(678, 'WieruszĂłw', 5),
	(679, 'ZduĹska Wola', 5),
	(680, 'Szadek', 5),
	(681, 'Zapolice', 5),
	(682, 'Kutno', 5),
	(683, 'Bedlno', 5),
	(684, 'DÄbrowice', 5),
	(685, 'KroĹniewice', 5),
	(686, 'KrzyĹźanĂłw', 5),
	(687, 'ĹaniÄta', 5),
	(688, 'Nowe Ostrowy', 5),
	(689, 'OporĂłw', 5),
	(690, 'Strzelce', 5),
	(691, 'Ĺťychlin', 5),
	(692, 'ĹÄczyca', 5),
	(693, 'Daszyna', 5),
	(694, 'GĂłra ĹwiÄtej MaĹgorzaty', 5),
	(695, 'GrabĂłw', 5),
	(696, 'PiÄtek', 5),
	(697, 'Ĺwinice Warckie', 5),
	(698, 'Witonia', 5),
	(699, 'Ĺowicz', 5),
	(700, 'Bielawy', 5),
	(701, 'ChÄĹno', 5),
	(702, 'Domaniewice', 5),
	(703, 'Kiernozia', 5),
	(704, 'Kocierzew PoĹudniowy', 5),
	(705, 'Ĺyszkowice', 5),
	(706, 'NieborĂłw', 5),
	(707, 'Zduny', 5),
	(708, 'Rawa Mazowiecka', 5),
	(709, 'BiaĹa Rawska', 5),
	(710, 'CielÄdz', 5),
	(711, 'RegnĂłw', 5),
	(712, 'Sadkowice', 5),
	(713, 'BolimĂłw', 5),
	(714, 'GĹuchĂłw', 5),
	(715, 'GodzianĂłw', 5),
	(716, 'Kowiesy', 5),
	(717, 'Lipce Reymontowskie', 5),
	(718, 'MakĂłw', 5),
	(719, 'Nowy KawÄczyn', 5),
	(720, 'Skierniewice', 5),
	(721, 'SĹupia', 5),
	(722, 'Bochnia', 6),
	(723, 'Drwinia', 6),
	(724, 'Lipnica Murowana', 6),
	(725, 'ĹapanĂłw', 6),
	(726, 'Nowy WiĹnicz', 6),
	(727, 'Rzezawa', 6),
	(728, 'Trzciana', 6),
	(729, 'Ĺťegocina', 6),
	(730, 'CzernichĂłw', 6),
	(731, 'IgoĹomia', 6),
	(732, 'Iwanowice', 6),
	(733, 'Jerzmanowice', 6),
	(734, 'KocmyrzĂłw', 6),
	(735, 'Krzeszowice', 6),
	(736, 'Liszki', 6),
	(737, 'MichaĹowice', 6),
	(738, 'Mogilany', 6),
	(739, 'SkaĹa', 6),
	(740, 'Skawina', 6),
	(741, 'SĹomniki', 6),
	(742, 'SuĹoszowa', 6),
	(743, 'ĹwiÄtniki GĂłrne', 6),
	(744, 'Wielka WieĹ', 6),
	(745, 'ZabierzĂłw', 6),
	(746, 'Zielonki', 6),
	(747, 'Charsznica', 6),
	(748, 'GoĹcza', 6),
	(749, 'KozĹĂłw', 6),
	(750, 'KsiÄĹź Wielki', 6),
	(751, 'MiechĂłw', 6),
	(752, 'RacĹawice', 6),
	(753, 'SĹaboszĂłw', 6),
	(754, 'Dobczyce', 6),
	(755, 'LubieĹ', 6),
	(756, 'MyĹlenice', 6),
	(757, 'Pcim', 6),
	(758, 'Raciechowice', 6),
	(759, 'Siepraw', 6),
	(760, 'SuĹkowice', 6),
	(761, 'Tokarnia', 6),
	(762, 'WiĹniowa', 6),
	(763, 'Koniusza', 6),
	(764, 'Koszyce', 6),
	(765, 'Nowe Brzesko', 6),
	(766, 'PaĹecznica', 6),
	(767, 'Proszowice', 6),
	(768, 'Radziemice', 6),
	(769, 'Biskupice', 6),
	(770, 'GdĂłw', 6),
	(771, 'KĹaj', 6),
	(772, 'NiepoĹomice', 6),
	(773, 'Wieliczka', 6),
	(774, 'KrakĂłw', 6),
	(775, 'Gorlice', 6),
	(776, 'Biecz', 6),
	(777, 'Bobowa', 6),
	(778, 'Lipinki', 6),
	(779, 'ĹuĹźna', 6),
	(780, 'Moszczenica', 6),
	(781, 'Ropa', 6),
	(782, 'SÄkowa', 6),
	(783, 'UĹcie Gorlickie', 6),
	(784, 'Limanowa', 6),
	(785, 'Mszana Dolna', 6),
	(786, 'Dobra', 6),
	(787, 'JodĹownik', 6),
	(788, 'Kamienica', 6),
	(789, 'Laskowa', 6),
	(790, 'Ĺukowica', 6),
	(791, 'NiedĹşwiedĹş', 6),
	(792, 'SĹopnice', 6),
	(793, 'Tymbark', 6),
	(794, 'GrybĂłw', 6),
	(795, 'CheĹmiec', 6),
	(796, 'GrĂłdek nad Dunajcem', 6),
	(797, 'Kamionka Wielka', 6),
	(798, 'Korzenna', 6),
	(799, 'Krynica-ZdrĂłj', 6),
	(800, 'Ĺabowa', 6),
	(801, 'ĹÄcko', 6),
	(802, 'Ĺososina Dolna', 6),
	(803, 'Muszyna', 6),
	(804, 'Nawojowa', 6),
	(805, 'Piwniczna-ZdrĂłj', 6),
	(806, 'Podegrodzie', 6),
	(807, 'Rytro', 6),
	(808, 'Stary SÄcz', 6),
	(809, 'Nowy Targ', 6),
	(810, 'Szczawnica', 6),
	(811, 'Czarny Dunajec', 6),
	(812, 'Czorsztyn', 6),
	(813, 'JabĹonka', 6),
	(814, 'KroĹcienko nad Dunajcem', 6),
	(815, 'Lipnica Wielka', 6),
	(816, 'Ĺapsze NiĹźne', 6),
	(817, 'Ochotnica Dolna', 6),
	(818, 'Raba WyĹźna', 6),
	(819, 'Rabka-ZdrĂłj', 6),
	(820, 'Spytkowice', 6),
	(821, 'Szaflary', 6),
	(822, 'Zakopane', 6),
	(823, 'BiaĹy Dunajec', 6),
	(824, 'Bukowina TatrzaĹska', 6),
	(825, 'KoĹcielisko', 6),
	(826, 'Poronin', 6),
	(827, 'Nowy SÄcz', 6),
	(828, 'Alwernia', 6),
	(829, 'Babice', 6),
	(830, 'ChrzanĂłw', 6),
	(831, 'LibiÄĹź', 6),
	(832, 'Trzebinia', 6),
	(833, 'Bukowno', 6),
	(834, 'SĹawkĂłw', 6),
	(835, 'BolesĹaw', 6),
	(836, 'Klucze', 6),
	(837, 'Olkusz', 6),
	(838, 'TrzyciÄĹź', 6),
	(839, 'Wolbrom', 6),
	(840, 'OĹwiÄcim', 6),
	(841, 'Brzeszcze', 6),
	(842, 'CheĹmek', 6),
	(843, 'KÄty', 6),
	(844, 'Osiek', 6),
	(845, 'Polanka Wielka', 6),
	(846, 'PrzeciszĂłw', 6),
	(847, 'Zator', 6),
	(848, 'JordanĂłw', 6),
	(849, 'Sucha Beskidzka', 6),
	(850, 'BudzĂłw', 6),
	(851, 'Bystra', 6),
	(852, 'MakĂłw PodhalaĹski', 6),
	(853, 'Stryszawa', 6),
	(854, 'Zawoja', 6),
	(855, 'Zembrzyce', 6),
	(856, 'AndrychĂłw', 6),
	(857, 'BrzeĹşnica', 6),
	(858, 'Kalwaria Zebrzydowska', 6),
	(859, 'Lanckorona', 6),
	(860, 'Mucharz', 6),
	(861, 'StryszĂłw', 6),
	(862, 'Tomice', 6),
	(863, 'Wadowice', 6),
	(864, 'Wieprz', 6),
	(865, 'BorzÄcin', 6),
	(866, 'Brzesko', 6),
	(867, 'CzchĂłw', 6),
	(868, 'DÄbno', 6),
	(869, 'Gnojnik', 6),
	(870, 'Iwkowa', 6),
	(871, 'Szczurowa', 6),
	(872, 'DÄbrowa Tarnowska', 6),
	(873, 'GrÄboszĂłw', 6),
	(874, 'MÄdrzechĂłw', 6),
	(875, 'Olesno', 6),
	(876, 'Radgoszcz', 6),
	(877, 'Szczucin', 6),
	(878, 'CiÄĹźkowice', 6),
	(879, 'Gromnik', 6),
	(880, 'Lisia GĂłra', 6),
	(881, 'PleĹna', 6),
	(882, 'RadĹĂłw', 6),
	(883, 'Ryglice', 6),
	(884, 'Rzepiennik StrzyĹźewski', 6),
	(885, 'SkrzyszĂłw', 6),
	(886, 'TarnĂłw', 6),
	(887, 'TuchĂłw', 6),
	(888, 'WierzchosĹawice', 6),
	(889, 'Wietrzychowice', 6),
	(890, 'Wojnicz', 6),
	(891, 'Zakliczyn', 6),
	(892, 'Ĺťabno', 6),
	(893, 'Szerzyny', 6),
	(894, 'CiechanĂłw', 7),
	(895, 'Glinojeck', 7),
	(896, 'GoĹymin', 7),
	(897, 'Grudusk', 7),
	(898, 'OjrzeĹ', 7),
	(899, 'OpinogĂłra GĂłrna', 7),
	(900, 'Regimin', 7),
	(901, 'SoĹsk', 7),
	(902, 'Gostynin', 7),
	(903, 'Pacyna', 7),
	(904, 'Sanniki', 7),
	(905, 'Szczawin KoĹcielny', 7),
	(906, 'MĹawa', 7),
	(907, 'Dzierzgowo', 7),
	(908, 'Lipowiec KoĹcielny', 7),
	(909, 'RadzanĂłw', 7),
	(910, 'Strzegowo', 7),
	(911, 'Stupsk', 7),
	(912, 'SzreĹsk', 7),
	(913, 'SzydĹowo', 7),
	(914, 'Wieczfnia KoĹcielna', 7),
	(915, 'WiĹniewo', 7),
	(916, 'Bielsk', 7),
	(917, 'BodzanĂłw', 7),
	(918, 'BrudzeĹ DuĹźy', 7),
	(919, 'Bulkowo', 7),
	(920, 'Drobin', 7),
	(921, 'GÄbin', 7),
	(922, 'ĹÄck', 7),
	(923, 'MaĹa WieĹ', 7),
	(924, 'Nowy DuninĂłw', 7),
	(925, 'Radzanowo', 7),
	(926, 'SĹubice', 7),
	(927, 'SĹupno', 7),
	(928, 'Stara BiaĹa', 7),
	(929, 'StaroĹşreby', 7),
	(930, 'WyszogrĂłd', 7),
	(931, 'PĹoĹsk', 7),
	(932, 'RaciÄĹź', 7),
	(933, 'Baboszewo', 7),
	(934, 'CzerwiĹsk nad WisĹÄ', 7),
	(935, 'DzierzÄĹźnia', 7),
	(936, 'Joniec', 7),
	(937, 'Naruszewo', 7),
	(938, 'Nowe Miasto', 7),
	(939, 'Sochocin', 7),
	(940, 'ZaĹuski', 7),
	(941, 'Sierpc', 7),
	(942, 'Gozdowo', 7),
	(943, 'Mochowo', 7),
	(944, 'RoĹciszewo', 7),
	(945, 'Szczutowo', 7),
	(946, 'Zawidz', 7),
	(947, 'BieĹźuĹ', 7),
	(948, 'Kuczbork', 7),
	(949, 'Lubowidz', 7),
	(950, 'Lutocin', 7),
	(951, 'SiemiÄtkowo', 7),
	(952, 'Ĺťuromin', 7),
	(953, 'PĹock', 7),
	(954, 'Huszlew', 7),
	(955, 'Ĺosice', 7),
	(956, 'Olszanka', 7),
	(957, 'PlaterĂłw', 7),
	(958, 'Sarnaki', 7),
	(959, 'Stara Kornica', 7),
	(960, 'MakĂłw Mazowiecki', 7),
	(961, 'Czerwonka', 7),
	(962, 'Karniewo', 7),
	(963, 'Krasnosielc', 7),
	(964, 'MĹynarze', 7),
	(965, 'PĹoniawy', 7),
	(966, 'RĂłĹźan', 7),
	(967, 'Rzewnie', 7),
	(968, 'Sypniewo', 7),
	(969, 'SzelkĂłw', 7),
	(970, 'Baranowo', 7),
	(971, 'Czarnia', 7),
	(972, 'Czerwin', 7),
	(973, 'Goworowo', 7),
	(974, 'KadzidĹo', 7),
	(975, 'Lelis', 7),
	(976, 'Ĺyse', 7),
	(977, 'Myszyniec', 7),
	(978, 'Olszewo', 7),
	(979, 'RzekuĹ', 7),
	(980, 'Troszyn', 7),
	(981, 'OstrĂłw Mazowiecka', 7),
	(982, 'Andrzejewo', 7),
	(983, 'Boguty', 7),
	(984, 'Brok', 7),
	(985, 'MaĹkinia GĂłrna', 7),
	(986, 'Nur', 7),
	(987, 'Stary LubotyĹ', 7),
	(988, 'Szulborze Wielkie', 7),
	(989, 'WÄsewo', 7),
	(990, 'ZarÄby KoĹcielne', 7),
	(991, 'Przasnysz', 7),
	(992, 'Chorzele', 7),
	(993, 'Czernice Borowe', 7),
	(994, 'JednoroĹźec', 7),
	(995, 'Krasne', 7),
	(996, 'KrzynowĹoga MaĹa', 7),
	(997, 'Gzy', 7),
	(998, 'Obryte', 7),
	(999, 'Pokrzywnica', 7),
	(1000, 'PuĹtusk', 7),
	(1001, 'Ĺwiercze', 7),
	(1002, 'Winnica', 7),
	(1003, 'Zatory', 7),
	(1004, 'Domanice', 7),
	(1005, 'Korczew', 7),
	(1006, 'KotuĹ', 7),
	(1007, 'Mokobody', 7),
	(1008, 'Mordy', 7),
	(1009, 'Paprotnia', 7),
	(1010, 'Przesmyki', 7),
	(1011, 'Siedlce', 7),
	(1012, 'SkĂłrzec', 7),
	(1013, 'SuchoĹźebry', 7),
	(1014, 'WiĹniew', 7),
	(1015, 'Wodynie', 7),
	(1016, 'Zbuczyn', 7),
	(1017, 'SokoĹĂłw Podlaski', 7),
	(1018, 'Bielany', 7),
	(1019, 'CeranĂłw', 7),
	(1020, 'JabĹonna Lacka', 7),
	(1021, 'KosĂłw Lacki', 7),
	(1022, 'Repki', 7),
	(1023, 'Sabnie', 7),
	(1024, 'SterdyĹ', 7),
	(1025, 'WÄgrĂłw', 7),
	(1026, 'GrÄbkĂłw', 7),
	(1027, 'Korytnica', 7),
	(1028, 'Liw', 7),
	(1029, 'ĹochĂłw', 7),
	(1030, 'Miedzna', 7),
	(1031, 'Sadowne', 7),
	(1032, 'Stoczek', 7),
	(1033, 'Wierzbno', 7),
	(1034, 'BraĹszczyk', 7),
	(1035, 'DĹugosiodĹo', 7),
	(1036, 'RzÄĹnik', 7),
	(1037, 'Somianka', 7),
	(1038, 'WyszkĂłw', 7),
	(1039, 'Zabrodzie', 7),
	(1040, 'OstroĹÄka', 7),
	(1041, 'BiaĹobrzegi', 7),
	(1042, 'Promna', 7),
	(1043, 'Stara BĹotnica', 7),
	(1044, 'Stromiec', 7),
	(1045, 'WyĹmierzyce', 7),
	(1046, 'Garbatka', 7),
	(1047, 'GĹowaczĂłw', 7),
	(1048, 'GniewoszĂłw', 7),
	(1049, 'GrabĂłw nad PilicÄ', 7),
	(1050, 'Kozienice', 7),
	(1051, 'Magnuszew', 7),
	(1052, 'SieciechĂłw', 7),
	(1053, 'Chotcza', 7),
	(1054, 'CiepielĂłw', 7),
	(1055, 'Lipsko', 7),
	(1056, 'RzeczniĂłw', 7),
	(1057, 'Sienno', 7),
	(1058, 'Solec nad WisĹÄ', 7),
	(1059, 'Borkowice', 7),
	(1060, 'GielniĂłw', 7),
	(1061, 'KlwĂłw', 7),
	(1062, 'OdrzywĂłĹ', 7),
	(1063, 'PotworĂłw', 7),
	(1064, 'Przysucha', 7),
	(1065, 'RusinĂłw', 7),
	(1066, 'Wieniawa', 7),
	(1067, 'Pionki', 7),
	(1068, 'GĂłzd', 7),
	(1069, 'IĹĹźa', 7),
	(1070, 'JastrzÄbia', 7),
	(1071, 'JedliĹsk', 7),
	(1072, 'Jedlnia', 7),
	(1073, 'Kowala', 7),
	(1074, 'Przytyk', 7),
	(1075, 'Skaryszew', 7),
	(1076, 'Wierzbica', 7),
	(1077, 'WolanĂłw', 7),
	(1078, 'Zakrzew', 7),
	(1079, 'Chlewiska', 7),
	(1080, 'JastrzÄb', 7),
	(1081, 'MirĂłw', 7),
	(1082, 'OroĹsko', 7),
	(1083, 'SzydĹowiec', 7),
	(1084, 'KazanĂłw', 7),
	(1085, 'Policzna', 7),
	(1086, 'PrzyĹÄk', 7),
	(1087, 'TczĂłw', 7),
	(1088, 'ZwoleĹ', 7),
	(1089, 'Radom', 7),
	(1090, 'Warszawa', 7),
	(1091, 'Bemowo', 7),
	(1092, 'BiaĹoĹÄka', 7),
	(1093, 'MokotĂłw', 7),
	(1094, 'Ochota', 7),
	(1095, 'Praga', 7),
	(1096, 'RembertĂłw', 7),
	(1097, 'ĹrĂłdmieĹcie', 7),
	(1098, 'TargĂłwek', 7),
	(1099, 'Ursus', 7),
	(1100, 'UrsynĂłw', 7),
	(1101, 'Wawer', 7),
	(1102, 'WesoĹa', 7),
	(1103, 'WilanĂłw', 7),
	(1104, 'WĹochy', 7),
	(1105, 'Wola', 7),
	(1106, 'Ĺťoliborz', 7),
	(1107, 'Garwolin', 7),
	(1108, 'Ĺaskarzew', 7),
	(1109, 'Borowie', 7),
	(1110, 'GĂłrzno', 7),
	(1111, 'Maciejowice', 7),
	(1112, 'MiastkĂłw KoĹcielny', 7),
	(1113, 'ParysĂłw', 7),
	(1114, 'Pilawa', 7),
	(1115, 'Sobolew', 7),
	(1116, 'TrojanĂłw', 7),
	(1117, 'Wilga', 7),
	(1118, 'ĹťelechĂłw', 7),
	(1119, 'Legionowo', 7),
	(1120, 'JabĹonna', 7),
	(1121, 'NieporÄt', 7),
	(1122, 'Serock', 7),
	(1123, 'Wieliszew', 7),
	(1124, 'MiĹsk Mazowiecki', 7),
	(1125, 'SulejĂłwek', 7),
	(1126, 'CegĹĂłw', 7),
	(1127, 'DÄbe Wielkie', 7),
	(1128, 'Dobre', 7),
	(1129, 'HalinĂłw', 7),
	(1130, 'JakubĂłw', 7),
	(1131, 'KaĹuszyn', 7),
	(1132, 'Latowicz', 7),
	(1133, 'Mrozy', 7),
	(1134, 'Siennica', 7),
	(1135, 'StanisĹawĂłw', 7),
	(1136, 'Nowy DwĂłr Mazowiecki', 7),
	(1137, 'CzosnĂłw', 7),
	(1138, 'Leoncin', 7),
	(1139, 'Nasielsk', 7),
	(1140, 'PomiechĂłwek', 7),
	(1141, 'Zakroczym', 7),
	(1142, 'JĂłzefĂłw', 7),
	(1143, 'Otwock', 7),
	(1144, 'CelestynĂłw', 7),
	(1145, 'Karczew', 7),
	(1146, 'KoĹbiel', 7),
	(1147, 'Osieck', 7),
	(1148, 'Sobienie', 7),
	(1149, 'WiÄzowna', 7),
	(1150, 'KobyĹka', 7),
	(1151, 'Marki', 7),
	(1152, 'ZÄbki', 7),
	(1153, 'Zielonka', 7),
	(1154, 'DÄbrĂłwka', 7),
	(1155, 'JadĂłw', 7),
	(1156, 'KlembĂłw', 7),
	(1157, 'PoĹwiÄtne', 7),
	(1158, 'Radzymin', 7),
	(1159, 'StrachĂłwka', 7),
	(1160, 'TĹuszcz', 7),
	(1161, 'WoĹomin', 7),
	(1162, 'MilanĂłwek', 7),
	(1163, 'Podkowa LeĹna', 7),
	(1164, 'BaranĂłw', 7),
	(1165, 'Grodzisk Mazowiecki', 7),
	(1166, 'JaktorĂłw', 7),
	(1167, 'Ĺťabia Wola', 7),
	(1168, 'Belsk DuĹźy', 7),
	(1169, 'BĹÄdĂłw', 7),
	(1170, 'ChynĂłw', 7),
	(1171, 'Goszczyn', 7),
	(1172, 'GrĂłjec', 7),
	(1173, 'Jasieniec', 7),
	(1174, 'Mogielnica', 7),
	(1175, 'Nowe Miasto nad PilicÄ', 7),
	(1176, 'Pniewy', 7),
	(1177, 'Tarczyn', 7),
	(1178, 'Warka', 7),
	(1179, 'GĂłra Kalwaria', 7),
	(1180, 'Konstancin-Jeziorna', 7),
	(1181, 'Lesznowola', 7),
	(1182, 'Piaseczno', 7),
	(1183, 'PraĹźmĂłw', 7),
	(1184, 'PiastĂłw', 7),
	(1185, 'PruszkĂłw', 7),
	(1186, 'BrwinĂłw', 7),
	(1187, 'MichaĹowice', 7),
	(1188, 'Nadarzyn', 7),
	(1189, 'Raszyn', 7),
	(1190, 'Sochaczew', 7),
	(1191, 'BrochĂłw', 7),
	(1192, 'IĹĂłw', 7),
	(1193, 'MĹodzieszyn', 7),
	(1194, 'Nowa Sucha', 7),
	(1195, 'Rybno', 7),
	(1196, 'Teresin', 7),
	(1197, 'BĹonie', 7),
	(1198, 'Izabelin', 7),
	(1199, 'Kampinos', 7),
	(1200, 'Leszno', 7),
	(1201, 'Ĺomianki', 7),
	(1202, 'OĹźarĂłw Mazowiecki', 7),
	(1203, 'Stare Babice', 7),
	(1204, 'ĹťyrardĂłw', 7),
	(1205, 'MszczonĂłw', 7),
	(1206, 'Puszcza MariaĹska', 7),
	(1207, 'Radziejowice', 7),
	(1208, 'Wiskitki', 7),
	(1209, 'Brzeg', 8),
	(1210, 'Skarbimierz', 8),
	(1211, 'GrodkĂłw', 8),
	(1212, 'Lewin Brzeski', 8),
	(1213, 'Lubsza', 8),
	(1214, 'Olszanka', 8),
	(1215, 'Byczyna', 8),
	(1216, 'Kluczbork', 8),
	(1217, 'Lasowice Wielkie', 8),
	(1218, 'WoĹczyn', 8),
	(1219, 'Domaszowice', 8),
	(1220, 'NamysĹĂłw', 8),
	(1221, 'PokĂłj', 8),
	(1222, 'ĹwierczĂłw', 8),
	(1223, 'WilkĂłw', 8),
	(1224, 'GĹuchoĹazy', 8),
	(1225, 'Kamiennik', 8),
	(1226, 'KorfantĂłw', 8),
	(1227, 'Ĺambinowice', 8),
	(1228, 'Nysa', 8),
	(1229, 'OtmuchĂłw', 8),
	(1230, 'PaczkĂłw', 8),
	(1231, 'PakosĹawice', 8),
	(1232, 'Skoroszyce', 8),
	(1233, 'BiaĹa', 8),
	(1234, 'GĹogĂłwek', 8),
	(1235, 'Lubrza', 8),
	(1236, 'Prudnik', 8),
	(1237, 'BaborĂłw', 8),
	(1238, 'Branice', 8),
	(1239, 'GĹubczyce', 8),
	(1240, 'Kietrz', 8),
	(1241, 'KÄdzierzyn-KoĹşle', 8),
	(1242, 'Bierawa', 8),
	(1243, 'Cisek', 8),
	(1244, 'PawĹowiczki', 8),
	(1245, 'Polska Cerekiew', 8),
	(1246, 'ReĹska WieĹ', 8),
	(1247, 'Gogolin', 8),
	(1248, 'Krapkowice', 8),
	(1249, 'Strzeleczki', 8),
	(1250, 'Walce', 8),
	(1251, 'Zdzieszowice', 8),
	(1252, 'DobrodzieĹ', 8),
	(1253, 'GorzĂłw ĹlÄski', 8),
	(1254, 'Olesno', 8),
	(1255, 'Praszka', 8),
	(1256, 'RadĹĂłw', 8),
	(1257, 'Rudniki', 8),
	(1258, 'ZÄbowice', 8),
	(1259, 'ChrzÄstowice', 8),
	(1260, 'DÄbrowa', 8),
	(1261, 'DobrzeĹ Wielki', 8),
	(1262, 'Komprachcice', 8),
	(1263, 'Ĺubniany', 8),
	(1264, 'MurĂłw', 8),
	(1265, 'Niemodlin', 8),
	(1266, 'Ozimek', 8),
	(1267, 'PopielĂłw', 8),
	(1268, 'PrĂłszkĂłw', 8),
	(1269, 'TarnĂłw Opolski', 8),
	(1270, 'TuĹowice', 8),
	(1271, 'Turawa', 8),
	(1272, 'Izbicko', 8),
	(1273, 'Jemielnica', 8),
	(1274, 'Kolonowskie', 8),
	(1275, 'LeĹnica', 8),
	(1276, 'Strzelce Opolskie', 8),
	(1277, 'Ujazd', 8),
	(1278, 'Zawadzkie', 8),
	(1279, 'Opole', 8),
	(1280, 'BaligrĂłd', 9),
	(1281, 'Cisna', 9),
	(1282, 'Czarna', 9),
	(1283, 'Lesko', 9),
	(1284, 'Lutowiska', 9),
	(1285, 'Olszanica', 9),
	(1286, 'Solina', 9),
	(1287, 'Ustrzyki Dolne', 9),
	(1288, 'BrzozĂłw', 9),
	(1289, 'Domaradz', 9),
	(1290, 'Dydnia', 9),
	(1291, 'HaczĂłw', 9),
	(1292, 'Jasienica Rosielna', 9),
	(1293, 'Nozdrzec', 9),
	(1294, 'JasĹo', 9),
	(1295, 'Brzyska', 9),
	(1296, 'DÄbowiec', 9),
	(1297, 'KoĹaczyce', 9),
	(1298, 'Krempna', 9),
	(1299, 'Nowy ĹťmigrĂłd', 9),
	(1300, 'Osiek Jasielski', 9),
	(1301, 'SkoĹyszyn', 9),
	(1302, 'Szerzyny', 9),
	(1303, 'Tarnowiec', 9),
	(1304, 'ChorkĂłwka', 9),
	(1305, 'Dukla', 9),
	(1306, 'Iwonicz-ZdrĂłj', 9),
	(1307, 'Jedlicze', 9),
	(1308, 'Korczyna', 9),
	(1309, 'KroĹcienko WyĹźne', 9),
	(1310, 'Miejsce Piastowe', 9),
	(1311, 'RymanĂłw', 9),
	(1312, 'WojaszĂłwka', 9),
	(1313, 'Sanok', 9),
	(1314, 'Besko', 9),
	(1315, 'Bukowsko', 9),
	(1316, 'KomaĹcza', 9),
	(1317, 'Tyrawa WoĹoska', 9),
	(1318, 'ZagĂłrz', 9),
	(1319, 'Zarszyn', 9),
	(1320, 'Krosno', 9),
	(1321, 'JarosĹaw', 9),
	(1322, 'Radymno', 9),
	(1323, 'ChĹopice', 9),
	(1324, 'Laszki', 9),
	(1325, 'PawĹosiĂłw', 9),
	(1326, 'Pruchnik', 9),
	(1327, 'Rokietnica', 9),
	(1328, 'RoĹşwienica', 9),
	(1329, 'WiÄzownica', 9),
	(1330, 'LubaczĂłw', 9),
	(1331, 'CieszanĂłw', 9),
	(1332, 'Horyniec', 9),
	(1333, 'Narol', 9),
	(1334, 'Oleszyce', 9),
	(1335, 'Stary DzikĂłw', 9),
	(1336, 'Wielkie Oczy', 9),
	(1337, 'Bircza', 9),
	(1338, 'Dubiecko', 9),
	(1339, 'Fredropol', 9),
	(1340, 'Krasiczyn', 9),
	(1341, 'Krzywcza', 9),
	(1342, 'Medyka', 9),
	(1343, 'OrĹy', 9),
	(1344, 'PrzemyĹl', 9),
	(1345, 'Stubno', 9),
	(1346, 'Ĺťurawica', 9),
	(1347, 'Przeworsk', 9),
	(1348, 'AdamĂłwka', 9),
	(1349, 'GaÄ', 9),
	(1350, 'Jawornik Polski', 9),
	(1351, 'KaĹczuga', 9),
	(1352, 'Sieniawa', 9),
	(1353, 'TryĹcza', 9),
	(1354, 'Zarzecze', 9),
	(1355, 'Cmolas', 9),
	(1356, 'Kolbuszowa', 9),
	(1357, 'Majdan KrĂłlewski', 9),
	(1358, 'Niwiska', 9),
	(1359, 'RaniĹźĂłw', 9),
	(1360, 'Dzikowiec', 9),
	(1361, 'ĹaĹcut', 9),
	(1362, 'BiaĹobrzegi', 9),
	(1363, 'Markowa', 9),
	(1364, 'Rakszawa', 9),
	(1365, 'ĹťoĹynia', 9),
	(1366, 'Iwierzyce', 9),
	(1367, 'OstrĂłw', 9),
	(1368, 'Ropczyce', 9),
	(1369, 'SÄdziszĂłw MaĹopolski', 9),
	(1370, 'Wielopole SkrzyĹskie', 9),
	(1371, 'DynĂłw', 9),
	(1372, 'BĹaĹźowa', 9),
	(1373, 'BoguchwaĹa', 9),
	(1374, 'Chmielnik', 9),
	(1375, 'GĹogĂłw MaĹopolski', 9),
	(1376, 'HyĹźne', 9),
	(1377, 'KamieĹ', 9),
	(1378, 'Krasne', 9),
	(1379, 'Lubenia', 9),
	(1380, 'SokoĹĂłw MaĹopolski', 9),
	(1381, 'Ĺwilcza', 9),
	(1382, 'Trzebownisko', 9),
	(1383, 'Tyczyn', 9),
	(1384, 'Czudec', 9),
	(1385, 'Frysztak', 9),
	(1386, 'Niebylec', 9),
	(1387, 'StrzyĹźĂłw', 9),
	(1388, 'WiĹniowa', 9),
	(1389, 'RzeszĂłw', 9),
	(1390, 'DÄbica', 9),
	(1391, 'Brzostek', 9),
	(1392, 'JodĹowa', 9),
	(1393, 'Pilzno', 9),
	(1394, 'ĹťyrakĂłw', 9),
	(1395, 'LeĹźajsk', 9),
	(1396, 'Grodzisko Dolne', 9),
	(1397, 'KuryĹĂłwka', 9),
	(1398, 'Nowa Sarzyna', 9),
	(1399, 'Mielec', 9),
	(1400, 'Borowa', 9),
	(1401, 'Czermin', 9),
	(1402, 'GawĹuszowice', 9),
	(1403, 'Padew Narodowa', 9),
	(1404, 'PrzecĹaw', 9),
	(1405, 'RadomyĹl Wielki', 9),
	(1406, 'TuszĂłw Narodowy', 9),
	(1407, 'Wadowice GĂłrne', 9),
	(1408, 'Harasiuki', 9),
	(1409, 'Jarocin', 9),
	(1410, 'JeĹźowe', 9),
	(1411, 'KrzeszĂłw', 9),
	(1412, 'Nisko', 9),
	(1413, 'Rudnik nad Sanem', 9),
	(1414, 'UlanĂłw', 9),
	(1415, 'Stalowa Wola', 9),
	(1416, 'BojanĂłw', 9),
	(1417, 'Pysznica', 9),
	(1418, 'RadomyĹl nad Sanem', 9),
	(1419, 'ZaklikĂłw', 9),
	(1420, 'Zaleszany', 9),
	(1421, 'BaranĂłw Sandomierski', 9),
	(1422, 'Gorzyce', 9),
	(1423, 'GrÄbĂłw', 9),
	(1424, 'Nowa DÄba', 9),
	(1425, 'Tarnobrzeg', 9),
	(1426, 'Choroszcz', 10),
	(1427, 'Czarna BiaĹostocka', 10),
	(1428, 'Dobrzyniewo DuĹźe', 10),
	(1429, 'GrĂłdek', 10),
	(1430, 'Juchnowiec KoĹcielny', 10),
	(1431, 'Ĺapy', 10),
	(1432, 'MichaĹowo', 10),
	(1433, 'PoĹwiÄtne', 10),
	(1434, 'SupraĹl', 10),
	(1435, 'SuraĹź', 10),
	(1436, 'TuroĹĹ KoĹcielna', 10),
	(1437, 'Tykocin', 10),
	(1438, 'WasilkĂłw', 10),
	(1439, 'ZabĹudĂłw', 10),
	(1440, 'Zawady', 10),
	(1441, 'DÄbrowa BiaĹostocka', 10),
	(1442, 'JanĂłw', 10),
	(1443, 'Korycin', 10),
	(1444, 'Krynki', 10),
	(1445, 'KuĹşnica', 10),
	(1446, 'Nowy DwĂłr', 10),
	(1447, 'Sidra', 10),
	(1448, 'SokĂłĹka', 10),
	(1449, 'Suchowola', 10),
	(1450, 'SzudziaĹowo', 10),
	(1451, 'BiaĹystok', 10),
	(1452, 'Bielsk Podlaski', 10),
	(1453, 'BraĹsk', 10),
	(1454, 'BoÄki', 10),
	(1455, 'Orla', 10),
	(1456, 'Rudka', 10),
	(1457, 'Wyszki', 10),
	(1458, 'HajnĂłwka', 10),
	(1459, 'BiaĹowieĹźa', 10),
	(1460, 'Czeremcha', 10),
	(1461, 'CzyĹźe', 10),
	(1462, 'Dubicze Cerkiewne', 10),
	(1463, 'Kleszczele', 10),
	(1464, 'Narew', 10),
	(1465, 'Narewka', 10),
	(1466, 'Kolno', 10),
	(1467, 'Grabowo', 10),
	(1468, 'MaĹy PĹock', 10),
	(1469, 'Stawiski', 10),
	(1470, 'TuroĹl', 10),
	(1471, 'Jedwabne', 10),
	(1472, 'ĹomĹźa', 10),
	(1473, 'Miastkowo', 10),
	(1474, 'NowogrĂłd', 10),
	(1475, 'PiÄtnica', 10),
	(1476, 'PrzytuĹy', 10),
	(1477, 'Ĺniadowo', 10),
	(1478, 'Wizna', 10),
	(1479, 'ZbĂłjna', 10),
	(1480, 'Siemiatycze', 10),
	(1481, 'Drohiczyn', 10),
	(1482, 'Dziadkowice', 10),
	(1483, 'Grodzisk', 10),
	(1484, 'Mielnik', 10),
	(1485, 'Milejczyce', 10),
	(1486, 'Nurzec', 10),
	(1487, 'Perlejewo', 10),
	(1488, 'Wysokie Mazowieckie', 10),
	(1489, 'Ciechanowiec', 10),
	(1490, 'CzyĹźew', 10),
	(1491, 'Klukowo', 10),
	(1492, 'Kobylin', 10),
	(1493, 'Kulesze KoĹcielne', 10),
	(1494, 'Nowe Piekuty', 10),
	(1495, 'SokoĹy', 10),
	(1496, 'Szepietowo', 10),
	(1497, 'ZambrĂłw', 10),
	(1498, 'KoĹaki KoĹcielne', 10),
	(1499, 'Rutki', 10),
	(1500, 'Szumowo', 10),
	(1501, 'AugustĂłw', 10),
	(1502, 'BargĹĂłw KoĹcielny', 10),
	(1503, 'Lipsk', 10),
	(1504, 'Nowinka', 10),
	(1505, 'PĹaska', 10),
	(1506, 'Sztabin', 10),
	(1507, 'Grajewo', 10),
	(1508, 'RadziĹĂłw', 10),
	(1509, 'RajgrĂłd', 10),
	(1510, 'Szczuczyn', 10),
	(1511, 'WÄsosz', 10),
	(1512, 'GoniÄdz', 10),
	(1513, 'JasionĂłwka', 10),
	(1514, 'JaĹwiĹy', 10),
	(1515, 'Knyszyn', 10),
	(1516, 'Krypno', 10),
	(1517, 'MoĹki', 10),
	(1518, 'Trzcianne', 10),
	(1519, 'Sejny', 10),
	(1520, 'Giby', 10),
	(1521, 'Krasnopol', 10),
	(1522, 'PuĹsk', 10),
	(1523, 'BakaĹarzewo', 10),
	(1524, 'FilipĂłw', 10),
	(1525, 'Jeleniewo', 10),
	(1526, 'PrzeroĹl', 10),
	(1527, 'Raczki', 10),
	(1528, 'Rutka', 10),
	(1529, 'SuwaĹki', 10),
	(1530, 'Szypliszki', 10),
	(1531, 'WiĹźajny', 10),
	(1532, 'Pruszcz GdaĹski', 11),
	(1533, 'Cedry Wielkie', 11),
	(1534, 'Kolbudy', 11),
	(1535, 'Przywidz', 11),
	(1536, 'PszczĂłĹki', 11),
	(1537, 'Suchy DÄb', 11),
	(1538, 'TrÄbki Wielkie', 11),
	(1539, 'Chmielno', 11),
	(1540, 'Kartuzy', 11),
	(1541, 'Przodkowo', 11),
	(1542, 'Sierakowice', 11),
	(1543, 'Somonino', 11),
	(1544, 'StÄĹźyca', 11),
	(1545, 'SulÄczyno', 11),
	(1546, 'Ĺťukowo', 11),
	(1547, 'Krynica Morska', 11),
	(1548, 'Nowy DwĂłr GdaĹski', 11),
	(1549, 'Ostaszewo', 11),
	(1550, 'Stegna', 11),
	(1551, 'Sztutowo', 11),
	(1552, 'Hel', 11),
	(1553, 'Jastarnia', 11),
	(1554, 'Puck', 11),
	(1555, 'WĹadysĹawowo', 11),
	(1556, 'Kosakowo', 11),
	(1557, 'Krokowa', 11),
	(1558, 'Reda', 11),
	(1559, 'Rumia', 11),
	(1560, 'Wejherowo', 11),
	(1561, 'Choczewo', 11),
	(1562, 'Gniewino', 11),
	(1563, 'Linia', 11),
	(1564, 'Luzino', 11),
	(1565, 'ĹÄczyce', 11),
	(1566, 'Szemud', 11),
	(1567, 'Borzytuchom', 11),
	(1568, 'BytĂłw', 11),
	(1569, 'Czarna DÄbrĂłwka', 11),
	(1570, 'KoĹczygĹowy', 11),
	(1571, 'Lipnica', 11),
	(1572, 'Miastko', 11),
	(1573, 'Parchowo', 11),
	(1574, 'Studzienice', 11),
	(1575, 'Trzebielino', 11),
	(1576, 'Tuchomie', 11),
	(1577, 'Chojnice', 11),
	(1578, 'Brusy', 11),
	(1579, 'Czersk', 11),
	(1580, 'Konarzyny', 11),
	(1581, 'CzĹuchĂłw', 11),
	(1582, 'Czarne', 11),
	(1583, 'Debrzno', 11),
	(1584, 'KoczaĹa', 11),
	(1585, 'Przechlewo', 11),
	(1586, 'Rzeczenica', 11),
	(1587, 'LÄbork', 11),
	(1588, 'Ĺeba', 11),
	(1589, 'Cewice', 11),
	(1590, 'Nowa WieĹ LÄborska', 11),
	(1591, 'Wicko', 11),
	(1592, 'Ustka', 11),
	(1593, 'Damnica', 11),
	(1594, 'DÄbnica Kaszubska', 11),
	(1595, 'GĹĂłwczyce', 11),
	(1596, 'KÄpice', 11),
	(1597, 'Kobylnica', 11),
	(1598, 'PotÄgowo', 11),
	(1599, 'SĹupsk', 11),
	(1600, 'SmoĹdzino', 11),
	(1601, 'KoĹcierzyna', 11),
	(1602, 'Dziemiany', 11),
	(1603, 'Karsin', 11),
	(1604, 'Liniewo', 11),
	(1605, 'Lipusz', 11),
	(1606, 'Nowa Karczma', 11),
	(1607, 'Stara Kiszewa', 11),
	(1608, 'Kwidzyn', 11),
	(1609, 'Gardeja', 11),
	(1610, 'Prabuty', 11),
	(1611, 'Ryjewo', 11),
	(1612, 'Sadlinki', 11),
	(1613, 'Malbork', 11),
	(1614, 'DzierzgoĹ', 11),
	(1615, 'Lichnowy', 11),
	(1616, 'MikoĹajki Pomorskie', 11),
	(1617, 'MiĹoradz', 11),
	(1618, 'Nowy Staw', 11),
	(1619, 'Stare Pole', 11),
	(1620, 'Stary DzierzgoĹ', 11),
	(1621, 'Stary Targ', 11),
	(1622, 'Sztum', 11),
	(1623, 'Czarna Woda', 11),
	(1624, 'SkĂłrcz', 11),
	(1625, 'Starogard GdaĹski', 11),
	(1626, 'Bobowo', 11),
	(1627, 'Kaliska', 11),
	(1628, 'Lubichowo', 11),
	(1629, 'Osieczna', 11),
	(1630, 'Osiek', 11),
	(1631, 'Skarszewy', 11),
	(1632, 'SmÄtowo Graniczne', 11),
	(1633, 'Zblewo', 11),
	(1634, 'Tczew', 11),
	(1635, 'Gniew', 11),
	(1636, 'Morzeszczyn', 11),
	(1637, 'Pelplin', 11),
	(1638, 'Subkowy', 11),
	(1639, 'GdaĹsk', 11),
	(1640, 'Gdynia', 11),
	(1641, 'Sopot', 11),
	(1642, 'Szczyrk', 12),
	(1643, 'Bestwina', 12),
	(1644, 'Buczkowice', 12),
	(1645, 'Czechowice-Dziedzice', 12),
	(1646, 'Jasienica', 12),
	(1647, 'Jaworze', 12),
	(1648, 'Kozy', 12),
	(1649, 'PorÄbka', 12),
	(1650, 'Wilamowice', 12),
	(1651, 'Wilkowice', 12),
	(1652, 'Cieszyn', 12),
	(1653, 'UstroĹ', 12),
	(1654, 'WisĹa', 12),
	(1655, 'Brenna', 12),
	(1656, 'Chybie', 12),
	(1657, 'DÄbowiec', 12),
	(1658, 'GoleszĂłw', 12),
	(1659, 'HaĹźlach', 12),
	(1660, 'Istebna', 12),
	(1661, 'SkoczĂłw', 12),
	(1662, 'StrumieĹ', 12),
	(1663, 'Zebrzydowice', 12),
	(1664, 'Ĺťywiec', 12),
	(1665, 'CzernichĂłw', 12),
	(1666, 'Gilowice', 12),
	(1667, 'JeleĹnia', 12),
	(1668, 'Koszarawa', 12),
	(1669, 'Lipowa', 12),
	(1670, 'ĹÄkawica', 12),
	(1671, 'Ĺodygowice', 12),
	(1672, 'MilĂłwka', 12),
	(1673, 'Radziechowy', 12),
	(1674, 'Rajcza', 12),
	(1675, 'ĹlemieĹ', 12),
	(1676, 'Ĺwinna', 12),
	(1677, 'UjsoĹy', 12),
	(1678, 'WÄgierska GĂłrka', 12),
	(1679, 'Bielsko-BiaĹa', 12),
	(1680, 'Lubliniec', 12),
	(1681, 'BoronĂłw', 12),
	(1682, 'Ciasna', 12),
	(1683, 'Herby', 12),
	(1684, 'Kochanowice', 12),
	(1685, 'KoszÄcin', 12),
	(1686, 'PawonkĂłw', 12),
	(1687, 'WoĹşniki', 12),
	(1688, 'Kalety', 12),
	(1689, 'Miasteczko ĹlÄskie', 12),
	(1690, 'RadzionkĂłw', 12),
	(1691, 'Tarnowskie GĂłry', 12),
	(1692, 'Krupski MĹyn', 12),
	(1693, 'OĹźarowice', 12),
	(1694, 'Ĺwierklaniec', 12),
	(1695, 'TworĂłg', 12),
	(1696, 'ZbrosĹawice', 12),
	(1697, 'Bytom', 12),
	(1698, 'Piekary ĹlÄskie', 12),
	(1699, 'Blachownia', 12),
	(1700, 'DÄbrowa Zielona', 12),
	(1701, 'JanĂłw', 12),
	(1702, 'Kamienica Polska', 12),
	(1703, 'KĹomnice', 12),
	(1704, 'Koniecpol', 12),
	(1705, 'Konopiska', 12),
	(1706, 'Kruszyna', 12),
	(1707, 'LelĂłw', 12),
	(1708, 'MstĂłw', 12),
	(1709, 'MykanĂłw', 12),
	(1710, 'Olsztyn', 12),
	(1711, 'Poczesna', 12),
	(1712, 'PrzyrĂłw', 12),
	(1713, 'RÄdziny', 12),
	(1714, 'Starcza', 12),
	(1715, 'KĹobuck', 12),
	(1716, 'Krzepice', 12),
	(1717, 'Lipie', 12),
	(1718, 'MiedĹşno', 12),
	(1719, 'OpatĂłw', 12),
	(1720, 'Panki', 12),
	(1721, 'PopĂłw', 12),
	(1722, 'PrzystajĹ', 12),
	(1723, 'WrÄczyca Wielka', 12),
	(1724, 'MyszkĂłw', 12),
	(1725, 'KoziegĹowy', 12),
	(1726, 'Niegowa', 12),
	(1727, 'Poraj', 12),
	(1728, 'Ĺťarki', 12),
	(1729, 'CzÄstochowa', 12),
	(1730, 'KnurĂłw', 12),
	(1731, 'Pyskowice', 12),
	(1732, 'GieraĹtowice', 12),
	(1733, 'Pilchowice', 12),
	(1734, 'Rudziniec', 12),
	(1735, 'SoĹnicowice', 12),
	(1736, 'Toszek', 12),
	(1737, 'WielowieĹ', 12),
	(1738, 'Gliwice', 12),
	(1739, 'Zabrze', 12),
	(1740, 'ChorzĂłw', 12),
	(1741, 'Katowice', 12),
	(1742, 'MysĹowice', 12),
	(1743, 'Ruda ĹlÄska', 12),
	(1744, 'Siemianowice ĹlÄskie', 12),
	(1745, 'ĹwiÄtochĹowice', 12),
	(1746, 'RacibĂłrz', 12),
	(1747, 'Kornowac', 12),
	(1748, 'Krzanowice', 12),
	(1749, 'KrzyĹźanowice', 12),
	(1750, 'KuĹşnia Raciborska', 12),
	(1751, 'NÄdza', 12),
	(1752, 'Pietrowice Wielkie', 12),
	(1753, 'Rudnik', 12),
	(1754, 'Czerwionka-Leszczyny', 12),
	(1755, 'Gaszowice', 12),
	(1756, 'Jejkowice', 12),
	(1757, 'Lyski', 12),
	(1758, 'Ĺwierklany', 12),
	(1759, 'PszĂłw', 12),
	(1760, 'Radlin', 12),
	(1761, 'RyduĹtowy', 12),
	(1762, 'WodzisĹaw ĹlÄski', 12),
	(1763, 'GodĂłw', 12),
	(1764, 'Gorzyce', 12),
	(1765, 'Lubomia', 12),
	(1766, 'Marklowice', 12),
	(1767, 'Mszana', 12),
	(1768, 'JastrzÄbie-ZdrĂłj', 12),
	(1769, 'Rybnik', 12),
	(1770, 'Ĺťory', 12),
	(1771, 'BÄdzin', 12),
	(1772, 'CzeladĹş', 12),
	(1773, 'Wojkowice', 12),
	(1774, 'Bobrowniki', 12),
	(1775, 'MierzÄcice', 12),
	(1776, 'Psary', 12),
	(1777, 'Siewierz', 12),
	(1778, 'SĹawkĂłw', 12),
	(1779, 'PorÄba', 12),
	(1780, 'Zawiercie', 12),
	(1781, 'IrzÄdze', 12),
	(1782, 'Kroczyce', 12),
	(1783, 'Ĺazy', 12),
	(1784, 'Ogrodzieniec', 12),
	(1785, 'Pilica', 12),
	(1786, 'Szczekociny', 12),
	(1787, 'WĹodowice', 12),
	(1788, 'Ĺťarnowiec', 12),
	(1789, 'DÄbrowa GĂłrnicza', 12),
	(1790, 'Jaworzno', 12),
	(1791, 'Sosnowiec', 12),
	(1792, 'Ĺaziska GĂłrne', 12),
	(1793, 'MikoĹĂłw', 12),
	(1794, 'Orzesze', 12),
	(1795, 'Ornontowice', 12),
	(1796, 'Wyry', 12),
	(1797, 'GoczaĹkowice', 12),
	(1798, 'KobiĂłr', 12),
	(1799, 'MiedĹşna', 12),
	(1800, 'PawĹowice', 12),
	(1801, 'Pszczyna', 12),
	(1802, 'Suszec', 12),
	(1803, 'BieruĹ', 12),
	(1804, 'Imielin', 12),
	(1805, 'LÄdziny', 12),
	(1806, 'Bojszowy', 12),
	(1807, 'CheĹm ĹlÄski', 12),
	(1808, 'Tychy', 12),
	(1809, 'Bieliny', 13),
	(1810, 'Bodzentyn', 13),
	(1811, 'ChÄciny', 13),
	(1812, 'Chmielnik', 13),
	(1813, 'Daleszyce', 13),
	(1814, 'GĂłrno', 13),
	(1815, 'ĹagĂłw', 13),
	(1816, 'Ĺopuszno', 13),
	(1817, 'MasĹĂłw', 13),
	(1818, 'Miedziana GĂłra', 13),
	(1819, 'MniĂłw', 13),
	(1820, 'Morawica', 13),
	(1821, 'Nowa SĹupia', 13),
	(1822, 'PiekoszĂłw', 13),
	(1823, 'Pierzchnica', 13),
	(1824, 'RakĂłw', 13),
	(1825, 'SitkĂłwka', 13),
	(1826, 'Strawczyn', 13),
	(1827, 'ZagnaĹsk', 13),
	(1828, 'FaĹkĂłw', 13),
	(1829, 'GowarczĂłw', 13),
	(1830, 'KoĹskie', 13),
	(1831, 'Radoszyce', 13),
	(1832, 'Ruda Maleniecka', 13),
	(1833, 'SĹupia', 13),
	(1834, 'SmykĂłw', 13),
	(1835, 'StÄporkĂłw', 13),
	(1836, 'Ostrowiec ĹwiÄtokrzyski', 13),
	(1837, 'BaĹtĂłw', 13),
	(1838, 'BodzechĂłw', 13),
	(1839, 'ÄmielĂłw', 13),
	(1840, 'KunĂłw', 13),
	(1841, 'WaĹniĂłw', 13),
	(1842, 'SkarĹźysko-Kamienna', 13),
	(1843, 'BliĹźyn', 13),
	(1844, 'ĹÄczna', 13),
	(1845, 'SkarĹźysko KoĹcielne', 13),
	(1846, 'SuchedniĂłw', 13),
	(1847, 'Starachowice', 13),
	(1848, 'Brody', 13),
	(1849, 'Mirzec', 13),
	(1850, 'PawĹĂłw', 13),
	(1851, 'WÄchock', 13),
	(1852, 'Kielce', 13),
	(1853, 'Busko-ZdrĂłj', 13),
	(1854, 'Gnojno', 13),
	(1855, 'Nowy Korczyn', 13),
	(1856, 'PacanĂłw', 13),
	(1857, 'Solec', 13),
	(1858, 'Stopnica', 13),
	(1859, 'TuczÄpy', 13),
	(1860, 'WiĹlica', 13),
	(1861, 'Imielno', 13),
	(1862, 'JÄdrzejĂłw', 13),
	(1863, 'MaĹogoszcz', 13),
	(1864, 'NagĹowice', 13),
	(1865, 'Oksa', 13),
	(1866, 'SÄdziszĂłw', 13),
	(1867, 'SobkĂłw', 13),
	(1868, 'WodzisĹaw', 13),
	(1869, 'Bejsce', 13),
	(1870, 'Czarnocin', 13),
	(1871, 'Kazimierza Wielka', 13),
	(1872, 'Opatowiec', 13),
	(1873, 'Skalbmierz', 13),
	(1874, 'BaÄkowice', 13),
	(1875, 'Iwaniska', 13),
	(1876, 'Lipnik', 13),
	(1877, 'OpatĂłw', 13),
	(1878, 'OĹźarĂłw', 13),
	(1879, 'Sadowie', 13),
	(1880, 'TarĹĂłw', 13),
	(1881, 'Wojciechowice', 13),
	(1882, 'DziaĹoszyce', 13),
	(1883, 'Kije', 13),
	(1884, 'MichaĹĂłw', 13),
	(1885, 'PiĹczĂłw', 13),
	(1886, 'ZĹota', 13),
	(1887, 'Sandomierz', 13),
	(1888, 'Dwikozy', 13),
	(1889, 'KlimontĂłw', 13),
	(1890, 'Koprzywnica', 13),
	(1891, 'ĹoniĂłw', 13),
	(1892, 'ObrazĂłw', 13),
	(1893, 'Samborzec', 13),
	(1894, 'Wilczyce', 13),
	(1895, 'Zawichost', 13),
	(1896, 'Bogoria', 13),
	(1897, 'Ĺubnice', 13),
	(1898, 'OleĹnica', 13),
	(1899, 'Osiek', 13),
	(1900, 'PoĹaniec', 13),
	(1901, 'Rytwiany', 13),
	(1902, 'StaszĂłw', 13),
	(1903, 'SzydĹĂłw', 13),
	(1904, 'Kluczewsko', 13),
	(1905, 'Krasocin', 13),
	(1906, 'Moskorzew', 13),
	(1907, 'RadkĂłw', 13),
	(1908, 'Secemin', 13),
	(1909, 'WĹoszczowa', 13),
	(1910, 'Braniewo', 14),
	(1911, 'Frombork', 14),
	(1912, 'Lelkowo', 14),
	(1913, 'PieniÄĹźno', 14),
	(1914, 'PĹoskinia', 14),
	(1915, 'WilczÄta', 14),
	(1916, 'DziaĹdowo', 14),
	(1917, 'IĹowo', 14),
	(1918, 'Lidzbark', 14),
	(1919, 'PĹoĹnica', 14),
	(1920, 'Rybno', 14),
	(1921, 'ElblÄg', 14),
	(1922, 'Godkowo', 14),
	(1923, 'Gronowo ElblÄskie', 14),
	(1924, 'Markusy', 14),
	(1925, 'Milejewo', 14),
	(1926, 'MĹynary', 14),
	(1927, 'PasĹÄk', 14),
	(1928, 'Rychliki', 14),
	(1929, 'Tolkmicko', 14),
	(1930, 'IĹawa', 14),
	(1931, 'Lubawa', 14),
	(1932, 'Kisielice', 14),
	(1933, 'Susz', 14),
	(1934, 'Zalewo', 14),
	(1935, 'Nowe Miasto Lubawskie', 14),
	(1936, 'Biskupiec', 14),
	(1937, 'Grodziczno', 14),
	(1938, 'KurzÄtnik', 14),
	(1939, 'OstrĂłda', 14),
	(1940, 'DÄbrĂłwno', 14),
	(1941, 'Grunwald', 14),
	(1942, 'Ĺukta', 14),
	(1943, 'MaĹdyty', 14),
	(1944, 'MiĹakowo', 14),
	(1945, 'MiĹomĹyn', 14),
	(1946, 'MorÄg', 14),
	(1947, 'EĹk', 14),
	(1948, 'Kalinowo', 14),
	(1949, 'Prostki', 14),
	(1950, 'Stare Juchy', 14),
	(1951, 'GiĹźycko', 14),
	(1952, 'Banie Mazurskie', 14),
	(1953, 'Budry', 14),
	(1954, 'Kruklanki', 14),
	(1955, 'MiĹki', 14),
	(1956, 'Pozezdrze', 14),
	(1957, 'Ryn', 14),
	(1958, 'WÄgorzewo', 14),
	(1959, 'Wydminy', 14),
	(1960, 'Dubeninki', 14),
	(1961, 'GoĹdap', 14),
	(1962, 'Kowale Oleckie', 14),
	(1963, 'Olecko', 14),
	(1964, 'ĹwiÄtajno', 14),
	(1965, 'Wieliczki', 14),
	(1966, 'BiaĹa Piska', 14),
	(1967, 'Orzysz', 14),
	(1968, 'Pisz', 14),
	(1969, 'Ruciane-Nida', 14),
	(1970, 'Bartoszyce', 14),
	(1971, 'GĂłrowo IĹaweckie', 14),
	(1972, 'Bisztynek', 14),
	(1973, 'SÄpopol', 14),
	(1974, 'KÄtrzyn', 14),
	(1975, 'Barciany', 14),
	(1976, 'Korsze', 14),
	(1977, 'Reszel', 14),
	(1978, 'Srokowo', 14),
	(1979, 'Lidzbark WarmiĹski', 14),
	(1980, 'Kiwity', 14),
	(1981, 'Lubomino', 14),
	(1982, 'Orneta', 14),
	(1983, 'MrÄgowo', 14),
	(1984, 'MikoĹajki', 14),
	(1985, 'Piecki', 14),
	(1986, 'Sorkwity', 14),
	(1987, 'Janowiec KoĹcielny', 14),
	(1988, 'Janowo', 14),
	(1989, 'KozĹowo', 14),
	(1990, 'Nidzica', 14),
	(1991, 'Barczewo', 14),
	(1992, 'Dobre Miasto', 14),
	(1993, 'Dywity', 14),
	(1994, 'GietrzwaĹd', 14),
	(1995, 'Jeziorany', 14),
	(1996, 'Jonkowo', 14),
	(1997, 'Kolno', 14),
	(1998, 'Olsztynek', 14),
	(1999, 'Purda', 14),
	(2000, 'Stawiguda', 14),
	(2001, 'ĹwiÄtki', 14),
	(2002, 'Szczytno', 14),
	(2003, 'DĹşwierzuty', 14),
	(2004, 'Jedwabno', 14),
	(2005, 'Pasym', 14),
	(2006, 'Rozogi', 14),
	(2007, 'Wielbark', 14),
	(2008, 'Olsztyn', 14),
	(2009, 'Jaraczewo', 15),
	(2010, 'Jarocin', 15),
	(2011, 'Kotlin', 15),
	(2012, 'ĹťerkĂłw', 15),
	(2013, 'BlizanĂłw', 15),
	(2014, 'Brzeziny', 15),
	(2015, 'CekĂłw', 15),
	(2016, 'Godziesze Wielkie', 15),
	(2017, 'KoĹşminek', 15),
	(2018, 'LiskĂłw', 15),
	(2019, 'Mycielin', 15),
	(2020, 'OpatĂłwek', 15),
	(2021, 'Stawiszyn', 15),
	(2022, 'Szczytniki', 15),
	(2023, 'ĹťelazkĂłw', 15),
	(2024, 'BaranĂłw', 15),
	(2025, 'Bralin', 15),
	(2026, 'KÄpno', 15),
	(2027, 'ĹÄka Opatowska', 15),
	(2028, 'PerzĂłw', 15),
	(2029, 'Rychtal', 15),
	(2030, 'Trzcinica', 15),
	(2031, 'Sulmierzyce', 15),
	(2032, 'Kobylin', 15),
	(2033, 'KoĹşmin Wielkopolski', 15),
	(2034, 'Krotoszyn', 15),
	(2035, 'RozdraĹźew', 15),
	(2036, 'Zduny', 15),
	(2037, 'OstrĂłw Wielkopolski', 15),
	(2038, 'Nowe Skalmierzyce', 15),
	(2039, 'OdolanĂłw', 15),
	(2040, 'Przygodzice', 15),
	(2041, 'RaszkĂłw', 15),
	(2042, 'Sieroszewice', 15),
	(2043, 'SoĹnie', 15),
	(2044, 'CzajkĂłw', 15),
	(2045, 'DoruchĂłw', 15),
	(2046, 'GrabĂłw nad ProsnÄ', 15),
	(2047, 'Kobyla GĂłra', 15),
	(2048, 'Kraszewice', 15),
	(2049, 'Mikstat', 15),
	(2050, 'OstrzeszĂłw', 15),
	(2051, 'Chocz', 15),
	(2052, 'Czermin', 15),
	(2053, 'Dobrzyca', 15),
	(2054, 'GizaĹki', 15),
	(2055, 'GoĹuchĂłw', 15),
	(2056, 'Pleszew', 15),
	(2057, 'Kalisz', 15),
	(2058, 'Gniezno', 15),
	(2059, 'Czerniejewo', 15),
	(2060, 'Kiszkowo', 15),
	(2061, 'KĹecko', 15),
	(2062, 'Ĺubowo', 15),
	(2063, 'Mieleszyn', 15),
	(2064, 'Niechanowo', 15),
	(2065, 'Trzemeszno', 15),
	(2066, 'Witkowo', 15),
	(2067, 'KoĹo', 15),
	(2068, 'Babiak', 15),
	(2069, 'ChodĂłw', 15),
	(2070, 'DÄbie', 15),
	(2071, 'Grzegorzew', 15),
	(2072, 'KĹodawa', 15),
	(2073, 'KoĹcielec', 15),
	(2074, 'OlszĂłwka', 15),
	(2075, 'Osiek MaĹy', 15),
	(2076, 'Przedecz', 15),
	(2077, 'Golina', 15),
	(2078, 'Grodziec', 15),
	(2079, 'Kazimierz Biskupi', 15),
	(2080, 'Kleczew', 15),
	(2081, 'Kramsk', 15),
	(2082, 'KrzymĂłw', 15),
	(2083, 'RychwaĹ', 15),
	(2084, 'RzgĂłw', 15),
	(2085, 'Skulsk', 15),
	(2086, 'Sompolno', 15),
	(2087, 'Stare Miasto', 15),
	(2088, 'Ĺlesin', 15),
	(2089, 'Wierzbinek', 15),
	(2090, 'Wilczyn', 15),
	(2091, 'SĹupca', 15),
	(2092, 'LÄdek', 15),
	(2093, 'Orchowo', 15),
	(2094, 'Ostrowite', 15),
	(2095, 'Powidz', 15),
	(2096, 'StrzaĹkowo', 15),
	(2097, 'ZagĂłrĂłw', 15),
	(2098, 'Turek', 15),
	(2099, 'Brudzew', 15),
	(2100, 'Dobra', 15),
	(2101, 'KawÄczyn', 15),
	(2102, 'MalanĂłw', 15),
	(2103, 'Przykona', 15),
	(2104, 'TuliszkĂłw', 15),
	(2105, 'WĹadysĹawĂłw', 15),
	(2106, 'KoĹaczkowo', 15),
	(2107, 'MiĹosĹaw', 15),
	(2108, 'Nekla', 15),
	(2109, 'Pyzdry', 15),
	(2110, 'WrzeĹnia', 15),
	(2111, 'Konin', 15),
	(2112, 'Borek Wielkopolski', 15),
	(2113, 'GostyĹ', 15),
	(2114, 'Krobia', 15),
	(2115, 'PÄpowo', 15),
	(2116, 'Piaski', 15),
	(2117, 'Pogorzela', 15),
	(2118, 'Poniec', 15),
	(2119, 'Granowo', 15),
	(2120, 'Grodzisk Wielkopolski', 15),
	(2121, 'Kamieniec', 15),
	(2122, 'Rakoniewice', 15),
	(2123, 'Wielichowo', 15),
	(2124, 'KoĹcian', 15),
	(2125, 'CzempiĹ', 15),
	(2126, 'KrzywiĹ', 15),
	(2127, 'Ĺmigiel', 15),
	(2128, 'Krzemieniewo', 15),
	(2129, 'Lipno', 15),
	(2130, 'Osieczna', 15),
	(2131, 'Rydzyna', 15),
	(2132, 'ĹwiÄciechowa', 15),
	(2133, 'Wijewo', 15),
	(2134, 'WĹoszakowice', 15),
	(2135, 'Chrzypsko Wielkie', 15),
	(2136, 'Kwilcz', 15),
	(2137, 'MiÄdzychĂłd', 15),
	(2138, 'SierakĂłw', 15),
	(2139, 'KuĹlin', 15),
	(2140, 'LwĂłwek', 15),
	(2141, 'Miedzichowo', 15),
	(2142, 'Nowy TomyĹl', 15),
	(2143, 'Opalenica', 15),
	(2144, 'ZbÄszyĹ', 15),
	(2145, 'Bojanowo', 15),
	(2146, 'Jutrosin', 15),
	(2147, 'Miejska GĂłrka', 15),
	(2148, 'PakosĹaw', 15),
	(2149, 'Rawicz', 15),
	(2150, 'PrzemÄt', 15),
	(2151, 'Siedlec', 15),
	(2152, 'Wolsztyn', 15),
	(2153, 'Leszno', 15),
	(2154, 'ChodzieĹź', 15),
	(2155, 'BudzyĹ', 15),
	(2156, 'Margonin', 15),
	(2157, 'Szamocin', 15),
	(2158, 'CzarnkĂłw', 15),
	(2159, 'Drawsko', 15),
	(2160, 'KrzyĹź Wielkopolski', 15),
	(2161, 'Lubasz', 15),
	(2162, 'PoĹajewo', 15),
	(2163, 'Trzcianka', 15),
	(2164, 'WieleĹ', 15),
	(2165, 'PiĹa', 15),
	(2166, 'BiaĹoĹliwie', 15),
	(2167, 'Kaczory', 15),
	(2168, 'ĹobĹźenica', 15),
	(2169, 'Miasteczko KrajeĹskie', 15),
	(2170, 'SzydĹowo', 15),
	(2171, 'UjĹcie', 15),
	(2172, 'Wyrzysk', 15),
	(2173, 'Wysoka', 15),
	(2174, 'WÄgrowiec', 15),
	(2175, 'DamasĹawek', 15),
	(2176, 'GoĹaĹcz', 15),
	(2177, 'MieĹcisko', 15),
	(2178, 'Skoki', 15),
	(2179, 'Wapno', 15),
	(2180, 'ZĹotĂłw', 15),
	(2181, 'Jastrowie', 15),
	(2182, 'Krajenka', 15),
	(2183, 'Lipka', 15),
	(2184, 'Okonek', 15),
	(2185, 'TarnĂłwka', 15),
	(2186, 'Zakrzewo', 15),
	(2187, 'Oborniki', 15),
	(2188, 'RogoĹşno', 15),
	(2189, 'RyczywĂłĹ', 15),
	(2190, 'LuboĹ', 15),
	(2191, 'Puszczykowo', 15),
	(2192, 'Buk', 15),
	(2193, 'Czerwonak', 15),
	(2194, 'Dopiewo', 15),
	(2195, 'Kleszczewo', 15),
	(2196, 'Komorniki', 15),
	(2197, 'Kostrzyn', 15),
	(2198, 'KĂłrnik', 15),
	(2199, 'Mosina', 15),
	(2200, 'Murowana GoĹlina', 15),
	(2201, 'Pobiedziska', 15),
	(2202, 'Rokietnica', 15),
	(2203, 'StÄszew', 15),
	(2204, 'Suchy Las', 15),
	(2205, 'SwarzÄdz', 15),
	(2206, 'Tarnowo PodgĂłrne', 15),
	(2207, 'Obrzycko', 15),
	(2208, 'Duszniki-ZdrĂłj', 15),
	(2209, 'KaĹşmierz', 15),
	(2210, 'OstrorĂłg', 15),
	(2211, 'Pniewy', 15),
	(2212, 'SzamotuĹy', 15),
	(2213, 'Wronki', 15),
	(2214, 'Dominowo', 15),
	(2215, 'Krzykosy', 15),
	(2216, 'Nowe Miasto nad WartÄ', 15),
	(2217, 'Ĺroda Wielkopolska', 15),
	(2218, 'ZaniemyĹl', 15),
	(2219, 'Brodnica', 15),
	(2220, 'Dolsk', 15),
	(2221, 'KsiÄĹź Wielkopolski', 15),
	(2222, 'Ĺrem', 15),
	(2223, 'PoznaĹ', 15),
	(2224, 'BiaĹogard', 16),
	(2225, 'Karlino', 16),
	(2226, 'Tychowo', 16),
	(2227, 'Czaplinek', 16),
	(2228, 'Drawsko Pomorskie', 16),
	(2229, 'Kalisz Pomorski', 16),
	(2230, 'Ostrowice', 16),
	(2231, 'Wierzchowo', 16),
	(2232, 'ZĹocieniec', 16),
	(2233, 'KoĹobrzeg', 16),
	(2234, 'Dygowo', 16),
	(2235, 'GoĹcino', 16),
	(2236, 'RymaĹ', 16),
	(2237, 'SiemyĹl', 16),
	(2238, 'Ustronie Morskie', 16),
	(2239, 'BÄdzino', 16),
	(2240, 'Biesiekierz', 16),
	(2241, 'Bobolice', 16),
	(2242, 'Manowo', 16),
	(2243, 'Mielno', 16),
	(2244, 'PolanĂłw', 16),
	(2245, 'SianĂłw', 16),
	(2246, 'Ĺwieszyno', 16),
	(2247, 'DarĹowo', 16),
	(2248, 'SĹawno', 16),
	(2249, 'Malechowo', 16),
	(2250, 'Postomino', 16),
	(2251, 'Szczecinek', 16),
	(2252, 'Barwice', 16),
	(2253, 'BiaĹy BĂłr', 16),
	(2254, 'Borne Sulinowo', 16),
	(2255, 'GrzmiÄca', 16),
	(2256, 'Ĺwidwin', 16),
	(2257, 'BrzeĹźno', 16),
	(2258, 'PoĹczyn-ZdrĂłj', 16),
	(2259, 'RÄbino', 16),
	(2260, 'SĹawoborze', 16),
	(2261, 'WaĹcz', 16),
	(2262, 'CzĹopa', 16),
	(2263, 'MirosĹawiec', 16),
	(2264, 'Tuczno', 16),
	(2265, 'Koszalin', 16),
	(2266, 'Bierzwnik', 16),
	(2267, 'Choszczno', 16),
	(2268, 'Drawno', 16),
	(2269, 'KrzÄcin', 16),
	(2270, 'PeĹczyce', 16),
	(2271, 'Recz', 16),
	(2272, 'Brojce', 16),
	(2273, 'Gryfice', 16),
	(2274, 'Karnice', 16),
	(2275, 'PĹoty', 16),
	(2276, 'Radowo MaĹe', 16),
	(2277, 'Resko', 16),
	(2278, 'Rewal', 16),
	(2279, 'TrzebiatĂłw', 16),
	(2280, 'Barlinek', 16),
	(2281, 'Boleszkowice', 16),
	(2282, 'DÄbno', 16),
	(2283, 'MyĹlibĂłrz', 16),
	(2284, 'NowogrĂłdek Pomorski', 16),
	(2285, 'Bielice', 16),
	(2286, 'Kozielice', 16),
	(2287, 'Lipiany', 16),
	(2288, 'Przelewice', 16),
	(2289, 'Pyrzyce', 16),
	(2290, 'Warnice', 16),
	(2291, 'Stargard SzczeciĹski', 16),
	(2292, 'Chociwel', 16),
	(2293, 'Dobrzany', 16),
	(2294, 'Dolice', 16),
	(2295, 'IĹsko', 16),
	(2296, 'Kobylanka', 16),
	(2297, 'Ĺobez', 16),
	(2298, 'Marianowo', 16),
	(2299, 'Stara DÄbrowa', 16),
	(2300, 'SuchaĹ', 16),
	(2301, 'WÄgorzyno', 16),
	(2302, 'Dobra', 16),
	(2303, 'Szczecin', 16),
	(2304, 'GoleniĂłw', 16),
	(2305, 'Maszewo', 16),
	(2306, 'Nowogard', 16),
	(2307, 'Osina', 16),
	(2308, 'PrzybiernĂłw', 16),
	(2309, 'Stepnica', 16),
	(2310, 'Banie', 16),
	(2311, 'Cedynia', 16),
	(2312, 'Chojna', 16),
	(2313, 'Gryfino', 16),
	(2314, 'Mieszkowice', 16),
	(2315, 'MoryĹ', 16),
	(2316, 'Stare Czarnowo', 16),
	(2317, 'TrzciĹsko-ZdrĂłj', 16),
	(2318, 'Widuchowa', 16),
	(2319, 'DziwnĂłw', 16),
	(2320, 'Golczewo', 16),
	(2321, 'KamieĹ Pomorski', 16),
	(2322, 'MiÄdzyzdroje', 16),
	(2323, 'Ĺwierzno', 16),
	(2324, 'Wolin', 16),
	(2325, 'KoĹbaskowo', 16),
	(2326, 'Nowe Warpno', 16),
	(2327, 'Police', 16),
	(2328, 'ĹwinoujĹcie', 16);
/*!40000 ALTER TABLE `default_city` ENABLE KEYS */;


-- Zrzut struktury tabela imav.default_language
CREATE TABLE IF NOT EXISTS `default_language` (
  `id` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `default` tinyint(1) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.default_language: 2 rows
DELETE FROM `default_language`;
/*!40000 ALTER TABLE `default_language` DISABLE KEYS */;
INSERT INTO `default_language` (`id`, `name`, `active`, `default`, `admin`) VALUES
	('pl', 'Polski', 1, 1, 1),
	('en', 'English', 0, 0, 0);
/*!40000 ALTER TABLE `default_language` ENABLE KEYS */;


-- Zrzut struktury tabela imav.default_metatag
CREATE TABLE IF NOT EXISTS `default_metatag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` longtext,
  `keywords` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1689 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.default_metatag: 152 rows
DELETE FROM `default_metatag`;
/*!40000 ALTER TABLE `default_metatag` DISABLE KEYS */;
INSERT INTO `default_metatag` (`id`, `title`, `description`, `keywords`) VALUES
	(1524, NULL, NULL, NULL),
	(1525, NULL, NULL, NULL),
	(1526, NULL, NULL, NULL),
	(1527, NULL, NULL, NULL),
	(1528, NULL, NULL, NULL),
	(1529, NULL, NULL, NULL),
	(1530, NULL, NULL, NULL),
	(1531, NULL, NULL, NULL),
	(1532, NULL, NULL, NULL),
	(1533, NULL, NULL, NULL),
	(1534, NULL, NULL, NULL),
	(1535, NULL, NULL, NULL),
	(1536, NULL, NULL, NULL),
	(1537, NULL, NULL, NULL),
	(1538, NULL, NULL, NULL),
	(1539, NULL, NULL, NULL),
	(1540, NULL, NULL, NULL),
	(1541, NULL, NULL, NULL),
	(1542, NULL, NULL, NULL),
	(1543, NULL, NULL, NULL),
	(1544, NULL, NULL, NULL),
	(1545, NULL, NULL, NULL),
	(1546, NULL, NULL, NULL),
	(1547, NULL, NULL, NULL),
	(1548, NULL, NULL, NULL),
	(1549, NULL, NULL, NULL),
	(1550, NULL, NULL, NULL),
	(1551, NULL, NULL, NULL),
	(1552, NULL, NULL, NULL),
	(1553, NULL, NULL, NULL),
	(1554, NULL, NULL, NULL),
	(1555, NULL, NULL, NULL),
	(1556, NULL, NULL, NULL),
	(1557, NULL, NULL, NULL),
	(1558, NULL, NULL, NULL),
	(1559, NULL, NULL, NULL),
	(1560, NULL, NULL, NULL),
	(1561, NULL, NULL, NULL),
	(1562, NULL, NULL, NULL),
	(1563, NULL, NULL, NULL),
	(1564, NULL, NULL, NULL),
	(1565, NULL, NULL, NULL),
	(1566, NULL, NULL, NULL),
	(1567, NULL, NULL, NULL),
	(1568, NULL, NULL, NULL),
	(1569, NULL, NULL, NULL),
	(1570, NULL, NULL, NULL),
	(1571, NULL, NULL, NULL),
	(1572, NULL, NULL, NULL),
	(1573, NULL, NULL, NULL),
	(1574, NULL, NULL, NULL),
	(1575, NULL, NULL, NULL),
	(1576, NULL, NULL, NULL),
	(1577, NULL, NULL, NULL),
	(1578, NULL, NULL, NULL),
	(1579, NULL, NULL, NULL),
	(1580, NULL, NULL, NULL),
	(1581, NULL, NULL, NULL),
	(1582, NULL, NULL, NULL),
	(1583, NULL, NULL, NULL),
	(1584, NULL, NULL, NULL),
	(1585, NULL, NULL, NULL),
	(1586, NULL, NULL, NULL),
	(1587, NULL, NULL, NULL),
	(1588, NULL, NULL, NULL),
	(1590, NULL, NULL, NULL),
	(1591, NULL, NULL, NULL),
	(1592, NULL, NULL, NULL),
	(1593, NULL, NULL, NULL),
	(1594, NULL, NULL, NULL),
	(1595, NULL, NULL, NULL),
	(1596, NULL, NULL, NULL),
	(1597, NULL, NULL, NULL),
	(1598, NULL, NULL, NULL),
	(1599, NULL, NULL, NULL),
	(1600, NULL, NULL, NULL),
	(1601, NULL, NULL, NULL),
	(1602, NULL, NULL, NULL),
	(1603, NULL, NULL, NULL),
	(1605, NULL, NULL, NULL),
	(1606, NULL, NULL, NULL),
	(1607, NULL, NULL, NULL),
	(1608, NULL, NULL, NULL),
	(1609, NULL, NULL, NULL),
	(1610, NULL, NULL, NULL),
	(1611, NULL, NULL, NULL),
	(1612, NULL, NULL, NULL),
	(1613, NULL, NULL, NULL),
	(1614, NULL, NULL, NULL),
	(1615, NULL, NULL, NULL),
	(1616, NULL, NULL, NULL),
	(1617, NULL, NULL, NULL),
	(1618, NULL, NULL, NULL),
	(1619, NULL, NULL, NULL),
	(1620, NULL, NULL, NULL),
	(1621, NULL, NULL, NULL),
	(1622, NULL, NULL, NULL),
	(1623, NULL, NULL, NULL),
	(1624, NULL, NULL, NULL),
	(1625, NULL, NULL, NULL),
	(1626, NULL, NULL, NULL),
	(1627, NULL, NULL, NULL),
	(1628, NULL, NULL, NULL),
	(1629, NULL, NULL, NULL),
	(1630, NULL, NULL, NULL),
	(1631, NULL, NULL, NULL),
	(1632, NULL, NULL, NULL),
	(1633, NULL, NULL, NULL),
	(1634, NULL, NULL, NULL),
	(1635, NULL, NULL, NULL),
	(1636, NULL, NULL, NULL),
	(1637, NULL, NULL, NULL),
	(1638, NULL, NULL, NULL),
	(1639, NULL, NULL, NULL),
	(1640, NULL, NULL, NULL),
	(1641, NULL, NULL, NULL),
	(1642, NULL, NULL, NULL),
	(1643, NULL, NULL, NULL),
	(1669, NULL, NULL, NULL),
	(1666, NULL, NULL, NULL),
	(1665, NULL, NULL, NULL),
	(1648, NULL, NULL, NULL),
	(1664, NULL, NULL, NULL),
	(1682, NULL, NULL, NULL),
	(1670, NULL, NULL, NULL),
	(1652, NULL, NULL, NULL),
	(1653, NULL, NULL, NULL),
	(1654, NULL, NULL, NULL),
	(1655, NULL, NULL, NULL),
	(1656, NULL, NULL, NULL),
	(1657, NULL, NULL, NULL),
	(1658, NULL, NULL, NULL),
	(1661, NULL, NULL, NULL),
	(1660, NULL, NULL, NULL),
	(1681, NULL, NULL, NULL),
	(1663, NULL, NULL, NULL),
	(1671, NULL, NULL, NULL),
	(1672, NULL, NULL, NULL),
	(1673, NULL, NULL, NULL),
	(1674, NULL, NULL, NULL),
	(1675, NULL, NULL, NULL),
	(1676, NULL, NULL, NULL),
	(1677, NULL, NULL, NULL),
	(1678, NULL, NULL, NULL),
	(1679, NULL, NULL, NULL),
	(1680, NULL, NULL, NULL),
	(1683, NULL, NULL, NULL),
	(1684, NULL, NULL, NULL),
	(1685, NULL, NULL, NULL),
	(1686, NULL, NULL, NULL),
	(1687, NULL, NULL, NULL),
	(1688, NULL, NULL, NULL);
/*!40000 ALTER TABLE `default_metatag` ENABLE KEYS */;


-- Zrzut struktury tabela imav.default_metatag_translation
CREATE TABLE IF NOT EXISTS `default_metatag_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(64) NOT NULL DEFAULT '',
  `title` varchar(255) DEFAULT NULL,
  `description` longtext,
  `keywords` longtext,
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=1689 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.default_metatag_translation: 153 rows
DELETE FROM `default_metatag_translation`;
/*!40000 ALTER TABLE `default_metatag_translation` DISABLE KEYS */;
INSERT INTO `default_metatag_translation` (`id`, `lang`, `title`, `description`, `keywords`) VALUES
	(1524, 'pl', 'Okleiniarka', '', ''),
	(1525, 'pl', 'Pilarka', '', ''),
	(1526, 'pl', 'Strugarka czterostronna', '', ''),
	(1527, 'pl', 'Szlifierka', '', ''),
	(1528, 'pl', 'Prasa', '', ''),
	(1529, 'pl', 'Spajarka', '', ''),
	(1530, 'pl', 'Frezarka', '', ''),
	(1531, 'pl', 'Tokarka', '', ''),
	(1532, 'pl', 'Strugarka', '', ''),
	(1533, 'pl', 'Kompresor', '', ''),
	(1534, 'pl', 'Rębak brykieciarka', '', ''),
	(1535, 'pl', 'Wiertarka', '', ''),
	(1536, 'pl', 'Dłutarka', '', ''),
	(1537, 'pl', 'Ostrzarka', '', ''),
	(1538, 'pl', 'Ogrzewanie hali - piece', '', ''),
	(1539, 'pl', 'Obrabiarka wieloczynnościowa', '', ''),
	(1540, 'pl', 'Ściana lakiernicza', '', ''),
	(1541, 'pl', 'Odciąg', '', ''),
	(1542, 'pl', 'Czopiarka', '', ''),
	(1543, 'pl', 'Walce klejowe', '', ''),
	(1544, 'pl', 'Gilotyna', '', ''),
	(1545, 'pl', 'Urządzenia do malowania', '', ''),
	(1546, 'pl', 'Pozostałe maszyny', '', ''),
	(1547, 'pl', 'Maszyny do metalu', '', ''),
	(1548, 'pl', 'Maszyny do PCV', '', ''),
	(1549, 'pl', 'Prostoliniowa', '', ''),
	(1550, 'pl', 'Krzywoliniowa', '', ''),
	(1551, 'pl', 'Formatowa', '', ''),
	(1552, 'pl', 'Radialna', '', ''),
	(1553, 'pl', 'Taśmowa', '', ''),
	(1554, 'pl', 'Wielopiła', '', ''),
	(1555, 'pl', 'Poprzeczna', '', ''),
	(1556, 'pl', 'Piła do drewna', '', ''),
	(1557, 'pl', 'Piła pionowa', '', ''),
	(1558, 'pl', 'Piła do forniru', '', ''),
	(1559, 'pl', 'Radialna', '', ''),
	(1560, 'pl', 'Taśmowa', '', ''),
	(1561, 'pl', 'Wielopiła', '', ''),
	(1562, 'pl', 'Poprzeczna', '', ''),
	(1563, 'pl', 'Piła do drewna', '', ''),
	(1564, 'pl', 'Piła pionowa', '', ''),
	(1565, 'pl', 'Piła do forniru', '', ''),
	(1566, 'pl', 'Wielopiła', '', ''),
	(1567, 'pl', 'Szerokotaśmowa', '', ''),
	(1568, 'pl', 'Długotaśmowa', '', ''),
	(1569, 'pl', 'Pionowa', '', ''),
	(1570, 'pl', 'Inne', '', ''),
	(1571, 'pl', 'Dolnowrzecionowa', '', ''),
	(1572, 'pl', 'Górnowrzecionowa', '', ''),
	(1573, 'pl', 'Wzorcarka', '', ''),
	(1574, 'pl', 'Wielowrzecionowa', '', ''),
	(1575, 'pl', 'Pozioma', '', ''),
	(1576, 'pl', 'Pionowa kolumnowa', '', ''),
	(1577, 'pl', 'Inne', '', ''),
	(1578, 'pl', 'Grubościówka', '', ''),
	(1579, 'pl', 'Wyrówniarka', '', ''),
	(1580, 'pl', 'Wyrówniarko grubościówka', '', ''),
	(1581, 'pl', 'test', '', ''),
	(1582, 'pl', 'Magic', '', ''),
	(1583, 'pl', 'Lora', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'consectetur, adipisicing, eiusmod, tempor, incididunt, labore, dolore, aliqua, veniam, nostrud, exercitation, ullamco, laboris, aliquip, commodo, consequat, reprehenderit, voluptate, cillum, dolore, fugiat, pariatur, Excepteur, occaecat, cupidatat, proident, officia, deserunt, mollit, laborum'),
	(1584, 'pl', 'Florenz', '', ''),
	(1585, 'pl', 'Ława_2', 'Ława -\r\n\r\nw dowolnym wymiarze\r\nw dowolnej kolorystyce\r\nze szkłem lub z gładkim blatem\r\n', 'dowolnym, wymiarze\r\nw, dowolnej, kolorystyce\r\nze, szkłem, gładkim, blatem\r\n'),
	(1586, 'pl', 'Ława_1', 'Ława -\r\n\r\nw dowolnym wymiarze\r\nw dowolnej kolorystyce\r\nze szkłem lub z gładkim blatem\r\n', 'dowolnym, wymiarze\r\nw, dowolnej, kolorystyce\r\nze, szkłem, gładkim, blatem\r\n'),
	(1587, 'pl', 'Adriana', '', ''),
	(1588, 'pl', 'Brianzolo Ovale', '', ''),
	(1589, 'pl', 'Nowa dostawa', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 'consectetur, adipisicing, eiusmod, tempor, incididunt, labore, dolore, aliqua, veniam, nostrud, exercitation, ullamco, laboris, aliquip, commodo, consequat, reprehenderit, voluptate, cillum, dolore, fugiat, pariatur, Excepteur, occaecat, cupidatat, proident, officia, deserunt, mollit, laborum'),
	(1590, 'pl', 'Nowa dostawa', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 'consectetur, adipisicing, eiusmod, tempor, incididunt, labore, dolore, aliqua, veniam, nostrud, exercitation, ullamco, laboris, aliquip, commodo, consequat, reprehenderit, voluptate, cillum, dolore, fugiat, pariatur, Excepteur, occaecat, cupidatat, proident, officia, deserunt, mollit, laborum'),
	(1591, 'pl', 'Promocje', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'consectetur, adipisicing, eiusmod, tempor, incididunt, labore, dolore, aliqua, veniam, nostrud, exercitation, ullamco, laboris, aliquip, commodo, consequat, reprehenderit, voluptate, cillum, dolore, fugiat, pariatur, Excepteur, occaecat, cupidatat, proident, officia, deserunt, mollit, laborum'),
	(1592, 'pl', 'Newsletter', 'Zapisz się na nasz newsletter aby otrzymywać na bieżąco informacje o nowych produktach z danej kategorii', 'Zapisz, newsletter, otrzymywać, bieżąco, informacje, nowych, produktach, kategorii'),
	(1593, 'pl', 'Testowy produkt', '', ''),
	(1594, 'pl', 'Testowy produkt', '', ''),
	(1595, 'pl', 'Testowy produkt', '', ''),
	(1596, 'pl', 'Testowy produkt', '', ''),
	(1597, 'pl', 'Testowy produkt', '', ''),
	(1598, 'pl', 'Testowy produkt', '', ''),
	(1599, 'pl', 'fasfa', 'fsafafsa', 'fsafafsa'),
	(1600, 'pl', 'fasfa', 'fsafafsa', 'fsafafsa'),
	(1601, 'pl', 'Muzyka, kino, teatr', '', ''),
	(1602, 'pl', 'Muzyka, kino, teatr', '', ''),
	(1603, 'pl', 'Literatura', '', ''),
	(1605, 'pl', 'Testowe wydarzenie', 'fasfa', ''),
	(1606, 'pl', 'Testowe wydarzenie', 'fasfa', ''),
	(1607, 'pl', 'Testowe wydarzenie', 'fasfa', ''),
	(1608, 'pl', 'Testowa atrakcja', 'dasda', ''),
	(1609, 'pl', 'Testowa atrakcja', 'dasda', ''),
	(1610, 'pl', 'Testowa atrakcja', 'dasda', 'dasda\r\nfafafa'),
	(1611, 'pl', 'Jan Kowalski', 'dasdsa', 'dasdsa'),
	(1612, 'pl', 'Jan Kowalski', 'dasdsa', 'dasdsa'),
	(1613, 'pl', 'Wydarzenie', 'fsafaf', 'fsafaf'),
	(1614, 'pl', 'Impreza w ciechocinku', 'dsadada', 'dsadada'),
	(1615, 'pl', 'Jerzy Nowak', 'Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem ', 'Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem Lorem '),
	(1616, 'pl', 'Testowa galeria 1', '', ''),
	(1617, 'pl', 'News z galeria', 'To jest news z galeria', 'galeria'),
	(1618, 'pl', 'Dobra galeria z newsem', 'dobra galeria z nesem', 'galeria'),
	(1619, 'pl', 'Dobra galeria z newsem', 'dobra galeria z nesem', 'galeria'),
	(1620, 'pl', 'Dobra galeria z newsem', 'dobra galeria z nesem', 'galeria'),
	(1621, 'pl', 'Dobra galeria z newsem', 'dobra galeria z nesem', 'galeria'),
	(1622, 'pl', 'Druga galeria z newsem', 'dsadasdsa', 'dsadasdsa'),
	(1623, 'pl', 'sdada', 'cxzczcz', 'cxzczcz'),
	(1624, 'pl', 'sdada', 'cxzczcz', 'cxzczcz'),
	(1625, 'pl', 'sdada', 'cxzczcz', 'cxzczcz'),
	(1626, 'pl', 'sdada', 'cxzczcz', 'cxzczcz'),
	(1627, 'pl', 'sdada', 'cxzczcz', 'cxzczcz'),
	(1628, 'pl', 'Tytulik', 'terescsaa', 'terescsaa'),
	(1629, 'pl', 'fasfa', 'fafafa', 'fafafa'),
	(1630, 'pl', 'fasfa', 'fafafa', 'fafafa'),
	(1631, 'pl', 'News z galeria', 'News z galeria', 'galeria'),
	(1632, 'pl', 'Testowy news z nowym edytorem', 'Testowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\n\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem\r\nTestowy news z nowym edytorem', 'Testowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem\r\n\r\nTestowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem\r\nTestowy, edytorem'),
	(1633, 'pl', 'Zamek w Szczebrzeszynie', 'To jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w SzczebrzeszynieTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w SzczebrzeszynieTo jest opis zamku w Szczebrzeszyniev\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w SzczebrzeszynieTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\nv\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\n', 'Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\nTo, SzczebrzeszynieTo, Szczebrzeszynie\r\nTo, SzczebrzeszynieTo, Szczebrzeszyniev\r\nTo, Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\nTo, SzczebrzeszynieTo, Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\nv\r\nTo, Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\n'),
	(1634, 'pl', 'Hans Kloss', 'Hans kloss osoba\r\nHans kloss osobaHans kloss osobaHans kloss osoba\r\n\r\nHans kloss osoba\r\nHans kloss osoba\r\nHans kloss osoba\r\nHans kloss osoba\r\nHans kloss osoba\r\nHans kloss osoba\r\nHans kloss osoba\r\nHans kloss osobaHans kloss osoba\r\nHans kloss osoba', 'osoba\r\nHans, osobaHans, osobaHans, osoba\r\n\r\nHans, osoba\r\nHans, osoba\r\nHans, osoba\r\nHans, osoba\r\nHans, osoba\r\nHans, osoba\r\nHans, osoba\r\nHans, osobaHans, osoba\r\nHans'),
	(1635, 'pl', 'Zamek w Szczebrzeszynie', 'To jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w SzczebrzeszynieTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w SzczebrzeszynieTo jest opis zamku w Szczebrzeszyniev\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w SzczebrzeszynieTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\nv\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\n', 'Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\nTo, SzczebrzeszynieTo, Szczebrzeszynie\r\nTo, SzczebrzeszynieTo, Szczebrzeszyniev\r\nTo, Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\nTo, SzczebrzeszynieTo, Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\nv\r\nTo, Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\n'),
	(1636, 'pl', 'Zamek w Szczebrzeszynie', 'To jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w SzczebrzeszynieTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w SzczebrzeszynieTo jest opis zamku w Szczebrzeszyniev\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w SzczebrzeszynieTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\nv\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\nTo jest opis zamku w Szczebrzeszynie\r\n', 'Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\nTo, SzczebrzeszynieTo, Szczebrzeszynie\r\nTo, SzczebrzeszynieTo, Szczebrzeszyniev\r\nTo, Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\nTo, SzczebrzeszynieTo, Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\nv\r\nTo, Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\nTo, Szczebrzeszynie\r\n'),
	(1637, 'pl', 'Add gallery test', 'Add gallery testAdd gallery testAdd gallery test\r\nAdd gallery test\r\nAdd gallery test\r\nAdd gallery test\r\nAdd gallery test\r\nv\r\nAdd gallery test\r\nAdd gallery testAdd gallery test', 'gallery, testAdd, gallery, testAdd, gallery, test\r\nAdd, gallery, test\r\nAdd, gallery, test\r\nAdd, gallery, test\r\nAdd, gallery, test\r\nv\r\nAdd, gallery, test\r\nAdd, gallery, testAdd, gallery'),
	(1638, 'pl', 'Rysunki', '', ''),
	(1639, 'pl', 'Malarstwo', '', ''),
	(1640, 'pl', 'Malarstwo', '', ''),
	(1641, 'pl', 'Rysunek', '', ''),
	(1642, 'pl', 'Testowy obraze', '', ''),
	(1643, 'pl', 'Testowy obraze', '', ''),
	(1648, 'pl', 'Prawo top', '', ''),
	(1664, 'pl', 'Testowa druga galeria', 'Testowa druga galeria', 'Testowa, galeria'),
	(1682, 'pl', 'Inne', '', ''),
	(1652, 'pl', 'Miasto Tarnów', '', ''),
	(1653, 'pl', 'Miasto Tarnów', '', ''),
	(1654, 'pl', 'Starostwo Powiatowe', '', ''),
	(1655, 'pl', 'Testowy news miasto tarnów', 'dsadada', 'dsadada'),
	(1656, 'pl', 'Studencki news', 'dsadadada', 'dsadadada'),
	(1657, 'pl', 'KONcert w Szczebrzeszynie', 'To jes tekst o koncercie w szczebrzeszynie', 'koncercie, szczebrzeszynie'),
	(1658, 'pl', 'KONcert w Szczebrzeszynie', 'To jes tekst o koncercie w szczebrzeszynie', 'koncercie, szczebrzeszynie'),
	(1661, 'pl', 'Banner pod newsem', '', ''),
	(1660, 'pl', 'jakis news', '', ''),
	(1681, 'pl', 'Banner pod newsem', '', ''),
	(1663, 'pl', 'Banner pod newsem 2', '', ''),
	(1665, 'pl', 'Grupa testowa', 'Grupa testowa', 'testowa'),
	(1666, 'pl', 'Grupa testowa', 'Grupa testowa', 'testowa'),
	(1669, 'pl', 'Wianki 2014 Kraków', 'Wianki w krakowie', 'Wianki, krakowie'),
	(1670, 'pl', 'Galeria', '', ''),
	(1671, 'pl', 'Reportaże', '', ''),
	(1672, 'pl', 'Wiadomości', '', ''),
	(1673, 'pl', 'Sport', '', ''),
	(1674, 'pl', 'Kultura', '', ''),
	(1675, 'pl', 'Rozrywka', '', ''),
	(1676, 'pl', 'Miasto Tarnów', '', ''),
	(1677, 'pl', 'Starostwo powiatowe', '', ''),
	(1678, 'pl', 'Studencka twórczość', '', ''),
	(1679, 'pl', 'Strona główna', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'consectetur, adipisicing, eiusmod, tempor, incididunt, labore, dolore, aliqua, veniam, nostrud, exercitation, ullamco, laboris, aliquip, commodo, consequat, reprehenderit, voluptate, cillum, dolore, fugiat, pariatur, Excepteur, occaecat, cupidatat, proident, officia, deserunt, mollit, laborum'),
	(1680, 'pl', 'Pod kategoria 2', '', ''),
	(1683, 'pl', 'Inne', '', ''),
	(1684, 'pl', 'Kontakt', 'Tekst kontakt\r\n', 'kontakt\r\n'),
	(1685, 'pl', 'Koszykówka', '', ''),
	(1686, 'pl', 'Koszykówka', '', ''),
	(1687, 'pl', 'Rowery', '', ''),
	(1688, 'pl', 'News z tagami', 'news z tagami', 'tagami');
/*!40000 ALTER TABLE `default_metatag_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.default_photo_dimensions
CREATE TABLE IF NOT EXISTS `default_photo_dimensions` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `width` bigint(20) DEFAULT NULL,
  `height` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.default_photo_dimensions: 11 rows
DELETE FROM `default_photo_dimensions`;
/*!40000 ALTER TABLE `default_photo_dimensions` DISABLE KEYS */;
INSERT INTO `default_photo_dimensions` (`id`, `width`, `height`) VALUES
	('category', NULL, NULL),
	('productmain', 175, 175),
	('product', 175, 175),
	('producer', 150, 100),
	('news', 160, 100),
	('newsmain', 100, 120),
	('banner', 300, 300),
	('slider', 390, NULL),
	('page', 160, 100),
	('gallery', 160, 100),
	('slidersmall', 390, NULL);
/*!40000 ALTER TABLE `default_photo_dimensions` ENABLE KEYS */;


-- Zrzut struktury tabela imav.default_province
CREATE TABLE IF NOT EXISTS `default_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.default_province: 16 rows
DELETE FROM `default_province`;
/*!40000 ALTER TABLE `default_province` DISABLE KEYS */;
INSERT INTO `default_province` (`id`, `name`) VALUES
	(1, 'dolnoĹlÄskie'),
	(2, 'kujawsko-pomorskie'),
	(3, 'lubelskie'),
	(4, 'lubuskie'),
	(5, 'ĹĂłdzkie'),
	(6, 'maĹopolskie'),
	(7, 'mazowieckie'),
	(8, 'opolskie'),
	(9, 'podkarpackie'),
	(10, 'podlaskie'),
	(11, 'pomorskie'),
	(12, 'ĹlÄskie'),
	(13, 'ĹwiÄtokrzyskie'),
	(14, 'warmiĹsko-mazurskie'),
	(15, 'wielkopolskie'),
	(16, 'zachodniopomorskie');
/*!40000 ALTER TABLE `default_province` ENABLE KEYS */;


-- Zrzut struktury tabela imav.default_service
CREATE TABLE IF NOT EXISTS `default_service` (
  `id` int(11) DEFAULT NULL,
  `name` char(50) COLLATE utf8_bin DEFAULT NULL,
  `email` char(50) COLLATE utf8_bin DEFAULT NULL,
  `phone` char(50) COLLATE utf8_bin DEFAULT NULL,
  `address` char(50) COLLATE utf8_bin DEFAULT NULL,
  `opening` char(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Zrzucanie danych dla tabeli imav.default_service: ~1 rows (około)
DELETE FROM `default_service`;
/*!40000 ALTER TABLE `default_service` DISABLE KEYS */;
INSERT INTO `default_service` (`id`, `name`, `email`, `phone`, `address`, `opening`) VALUES
	(1, 'Lucoa', 'pomoc@lucoa.pl', '+48 33 876 49 75', 'Ul. Krótka 5 Poland 34-130 Kalwaria Zebrzydowska', 'pn - pt 8.00 - 20.00');
/*!40000 ALTER TABLE `default_service` ENABLE KEYS */;


-- Zrzut struktury tabela imav.default_setting
CREATE TABLE IF NOT EXISTS `default_setting` (
  `id` varchar(255) NOT NULL DEFAULT '',
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.default_setting: 16 rows
DELETE FROM `default_setting`;
/*!40000 ALTER TABLE `default_setting` DISABLE KEYS */;
INSERT INTO `default_setting` (`id`, `value`) VALUES
	('contact_email', 'tomekvarts@o2.pl'),
	('ga_profile_id', ''),
	('company_name', 'F.H.U. "Dodus"'),
	('company_address', 'Brody 377'),
	('company_city', 'Kalwaria Zebrzydowska'),
	('company_province', ''),
	('company_postal_code', '34-130'),
	('company_phone', '+48 33 876 62 50'),
	('company_fax', ''),
	('facebook_url', 'http://facebook.com/307849886046563'),
	('youtube_url', 'http://youtube.com/nazwa.konta'),
	('twitter_url', 'http://twitter.com/DodusMaszyny'),
	('googleplus_url', 'http://googleplus.com/nazwa.konta'),
	('google_analytics', '<script>  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)  })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');  ga(\'create\', \'UA-50640000-1\', \'nottinghamanalogue.pl\');  ga(\'send\', \'pageview\');</script>'),
	('pin_url', 'http://pinterest.com/nazwa.konta'),
	('server', '1');
/*!40000 ALTER TABLE `default_setting` ENABLE KEYS */;


-- Zrzut struktury tabela imav.default_tag
CREATE TABLE IF NOT EXISTS `default_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.default_tag: 0 rows
DELETE FROM `default_tag`;
/*!40000 ALTER TABLE `default_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_tag` ENABLE KEYS */;


-- Zrzut struktury tabela imav.default_tag_translation
CREATE TABLE IF NOT EXISTS `default_tag_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.default_tag_translation: 0 rows
DELETE FROM `default_tag_translation`;
/*!40000 ALTER TABLE `default_tag_translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `default_tag_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.district_attraction
CREATE TABLE IF NOT EXISTS `district_attraction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '1',
  `gallery` tinyint(1) NOT NULL DEFAULT '0',
  `publish_date` datetime DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `video_root_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.district_attraction: 2 rows
DELETE FROM `district_attraction`;
/*!40000 ALTER TABLE `district_attraction` DISABLE KEYS */;
INSERT INTO `district_attraction` (`id`, `user_id`, `last_user_id`, `publish`, `gallery`, `publish_date`, `photo_root_id`, `metatag_id`, `video_root_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 1, 1, 0, '2014-08-07 12:05:00', 7, 1610, 4, '2014-08-07 12:05:03', '2014-08-07 12:14:22', NULL),
	(2, 1, 1, 1, 1, '2014-08-18 00:00:00', 72, 1633, 25, '2014-08-20 11:43:09', '2014-08-20 11:50:41', NULL);
/*!40000 ALTER TABLE `district_attraction` ENABLE KEYS */;


-- Zrzut struktury tabela imav.district_attraction_translation
CREATE TABLE IF NOT EXISTS `district_attraction_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.district_attraction_translation: 2 rows
DELETE FROM `district_attraction_translation`;
/*!40000 ALTER TABLE `district_attraction_translation` DISABLE KEYS */;
INSERT INTO `district_attraction_translation` (`id`, `title`, `slug`, `content`, `lang`) VALUES
	(1, 'Testowa atrakcja', 'testowa-atrakcja', '<p>dasda</p>\r\n<p>fafafa</p>', 'pl'),
	(2, 'Zamek w Szczebrzeszynie', 'zamek-w-szczebrzeszynie', '<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span><span>To jest opis zamku w Szczebrzeszyniev</span></span></p>\r\n<p><span><span><span>To jest opis zamku w Szczebrzeszynie</span></span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span>v</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p></p>', 'pl');
/*!40000 ALTER TABLE `district_attraction_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.district_event
CREATE TABLE IF NOT EXISTS `district_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '1',
  `publish_date` datetime DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `video_root_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.district_event: 4 rows
DELETE FROM `district_event`;
/*!40000 ALTER TABLE `district_event` DISABLE KEYS */;
INSERT INTO `district_event` (`id`, `user_id`, `last_user_id`, `publish`, `publish_date`, `photo_root_id`, `metatag_id`, `video_root_id`, `created_at`, `updated_at`, `deleted_at`, `url`) VALUES
	(1, 1, 1, 1, '2014-08-07 14:24:58', 13, 1613, 10, '2014-08-07 14:24:59', '2014-08-07 14:24:59', NULL, NULL),
	(2, 1, 1, 1, '2014-08-29 00:00:00', 26, 1614, 12, '2014-08-18 11:41:21', '2014-08-18 11:41:22', NULL, NULL),
	(3, 1, 1, 1, '2014-10-25 00:00:00', 171, 1658, 60, '2014-10-14 10:43:19', '2014-10-14 10:47:31', NULL, 'http://player.vimeo.com/video/78683505'),
	(4, 1, 1, 1, '2014-10-14 14:57:00', 186, 1669, 63, '2014-10-14 14:57:11', '2014-10-14 14:57:34', NULL, 'http://player.vimeo.com/video/78683505');
/*!40000 ALTER TABLE `district_event` ENABLE KEYS */;


-- Zrzut struktury tabela imav.district_event_translation
CREATE TABLE IF NOT EXISTS `district_event_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.district_event_translation: 4 rows
DELETE FROM `district_event_translation`;
/*!40000 ALTER TABLE `district_event_translation` DISABLE KEYS */;
INSERT INTO `district_event_translation` (`id`, `title`, `slug`, `content`, `lang`) VALUES
	(1, 'Wydarzenie', 'wydarzenie', '<p>fsafaf</p>', 'pl'),
	(2, 'Impreza w ciechocinku', 'impreza-w-ciechocinku', '<p>dsadada</p>', 'pl'),
	(3, 'KONcert w Szczebrzeszynie', 'koncert-w-szczebrzeszynie', '<p>To jes tekst o koncercie w szczebrzeszynie</p>', 'pl'),
	(4, 'Wianki 2014 Kraków', 'wianki-2014-krakow', '<p>Wianki w krakowie</p>', 'pl');
/*!40000 ALTER TABLE `district_event_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.district_people
CREATE TABLE IF NOT EXISTS `district_people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '1',
  `publish_date` datetime DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `video_root_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.district_people: 3 rows
DELETE FROM `district_people`;
/*!40000 ALTER TABLE `district_people` DISABLE KEYS */;
INSERT INTO `district_people` (`id`, `user_id`, `last_user_id`, `publish`, `publish_date`, `photo_root_id`, `metatag_id`, `video_root_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 1, 1, '2014-08-07 14:09:00', 11, 1612, 8, '2014-08-07 14:09:23', '2014-08-07 14:11:03', NULL),
	(2, 1, 1, 1, '2014-08-18 14:03:00', 27, 1615, 13, '2014-08-18 14:03:23', '2014-08-18 14:09:48', NULL),
	(3, 1, 1, 1, '2014-08-20 12:25:00', 80, 1634, 27, '2014-08-20 12:25:02', '2014-08-20 12:35:27', NULL);
/*!40000 ALTER TABLE `district_people` ENABLE KEYS */;


-- Zrzut struktury tabela imav.district_people_translation
CREATE TABLE IF NOT EXISTS `district_people_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.district_people_translation: 3 rows
DELETE FROM `district_people_translation`;
/*!40000 ALTER TABLE `district_people_translation` DISABLE KEYS */;
INSERT INTO `district_people_translation` (`id`, `title`, `slug`, `content`, `lang`) VALUES
	(1, 'Jan Kowalski', 'jan-kowalski', '<p>dasdsa</p>', 'pl'),
	(2, 'Jerzy Nowak', 'jerzy-nowak', '<p>Lorem Lorem <span>Lorem </span><span>Lorem</span><span>Lorem </span><span>Lorem <span>Lorem </span><span>Lorem <span>Lorem </span><span>Lorem</span></span></span></p>', 'pl'),
	(3, 'Hans Kloss', 'hans-kloss', '<p>Hans kloss osoba</p>\r\n<p><span>Hans kloss osoba</span><span>Hans kloss osoba</span><span>Hans kloss osoba</span></p>\r\n<p><span></span></p>\r\n<p><span><span>Hans kloss osoba</span></span></p>\r\n<p><span>Hans kloss osoba</span></p>\r\n<p><span><span>Hans kloss osoba</span></span></p>\r\n<p><span>Hans kloss osoba</span></p>\r\n<p><span><span>Hans kloss osoba</span></span></p>\r\n<p><span>Hans kloss osoba</span></p>\r\n<p><span><span>Hans kloss osoba</span></span></p>\r\n<p><span>Hans kloss osoba</span><span>Hans kloss osoba</span></p>\r\n<p><span><span>Hans kloss osoba</span></span></p>', 'pl');
/*!40000 ALTER TABLE `district_people_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.gallery_category
CREATE TABLE IF NOT EXISTS `gallery_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metatag_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.gallery_category: 4 rows
DELETE FROM `gallery_category`;
/*!40000 ALTER TABLE `gallery_category` DISABLE KEYS */;
INSERT INTO `gallery_category` (`id`, `metatag_id`, `title`, `slug`, `content`) VALUES
	(1, NULL, 'Informacje', 'informacje', NULL),
	(2, NULL, 'Sport', 'sport', NULL),
	(3, NULL, 'Kultura', 'kultura', NULL),
	(4, NULL, 'Rozrywka', 'rozrywka', NULL);
/*!40000 ALTER TABLE `gallery_category` ENABLE KEYS */;


-- Zrzut struktury tabela imav.gallery_gallery
CREATE TABLE IF NOT EXISTS `gallery_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `metatag_id` int(11) DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `main_page` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id_idx` (`category_id`),
  KEY `metatag_id_idx` (`metatag_id`),
  KEY `photo_root_id_idx` (`photo_root_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.gallery_gallery: 9 rows
DELETE FROM `gallery_gallery`;
/*!40000 ALTER TABLE `gallery_gallery` DISABLE KEYS */;
INSERT INTO `gallery_gallery` (`id`, `metatag_id`, `photo_root_id`, `category_id`, `main_page`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1616, NULL, 2, 0, '2014-08-19 10:46:53', '0000-00-00 00:00:00', NULL),
	(8, NULL, 160, 1, 0, '2014-08-19 10:46:58', '2014-10-03 09:46:44', NULL),
	(9, NULL, 142, 3, 0, '2014-08-20 10:48:49', '2014-10-15 12:42:32', NULL),
	(10, NULL, NULL, 10, 0, '2014-08-20 11:43:09', '2014-08-20 12:47:51', '2014-08-20 12:47:51'),
	(11, NULL, NULL, 10, 0, '2014-08-20 11:45:40', '2014-08-20 11:45:40', NULL),
	(12, 1635, NULL, 10, 0, '2014-08-20 11:47:39', '2014-08-20 13:04:51', NULL),
	(13, 1636, NULL, 10, 0, '2014-08-20 11:50:41', '2014-10-01 15:29:17', NULL),
	(14, 1637, 143, 1, 0, '2014-08-20 13:07:53', '2014-10-15 12:42:29', NULL),
	(15, 1664, 182, NULL, 1, '2014-10-14 14:41:39', '2014-10-14 14:42:13', NULL);
/*!40000 ALTER TABLE `gallery_gallery` ENABLE KEYS */;


-- Zrzut struktury tabela imav.gallery_gallery_translation
CREATE TABLE IF NOT EXISTS `gallery_gallery_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.gallery_gallery_translation: 8 rows
DELETE FROM `gallery_gallery_translation`;
/*!40000 ALTER TABLE `gallery_gallery_translation` DISABLE KEYS */;
INSERT INTO `gallery_gallery_translation` (`id`, `title`, `slug`, `content`, `lang`) VALUES
	(1, 'Testowa galeria 1', 'testowa-galeria-1', '', 'pl'),
	(8, 'News z galeria', 'news-z-galeria', '<p>News z galeria</p>', 'pl'),
	(9, 'Testowy news z nowym edytorem', 'testowy-news-z-nowym-edytorem', '<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p></p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>', 'pl'),
	(11, 'Zamek w Szczebrzeszynie', 'zamek-w-szczebrzeszynie', '<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span><span>To jest opis zamku w Szczebrzeszyniev</span></span></p>\r\n<p><span><span><span>To jest opis zamku w Szczebrzeszynie</span></span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span>v</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p></p>', 'pl'),
	(12, 'Zamek w Szczebrzeszynie', 'zamek-w-szczebrzeszynie-1', '<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span><span>To jest opis zamku w Szczebrzeszyniev</span></span></p>\r\n<p><span><span><span>To jest opis zamku w Szczebrzeszynie</span></span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span>v</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p></p>', 'pl'),
	(13, 'Zamek w Szczebrzeszynie', 'zamek-w-szczebrzeszynie-2', '<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span><span>To jest opis zamku w Szczebrzeszyniev</span></span></p>\r\n<p><span><span><span>To jest opis zamku w Szczebrzeszynie</span></span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span>v</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p><span>To jest opis zamku w Szczebrzeszynie</span></p>\r\n<p><span><span>To jest opis zamku w Szczebrzeszynie</span></span></p>\r\n<p></p>', 'pl'),
	(14, 'Add gallery test', 'add-gallery-test', '<p>Add gallery testAdd gallery testAdd gallery test</p>\r\n<p>Add gallery test</p>\r\n<p>Add gallery test</p>\r\n<p>Add gallery test</p>\r\n<p>Add gallery test</p>\r\n<p>v</p>\r\n<p>Add gallery test</p>\r\n<p>Add gallery testAdd gallery test</p>', 'pl'),
	(15, 'Testowa druga galeria', 'testowa-druga-galeria', '<p>Testowa druga galeria</p>', 'pl');
/*!40000 ALTER TABLE `gallery_gallery_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.media_attachment
CREATE TABLE IF NOT EXISTS `media_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `extension` varchar(255) DEFAULT NULL,
  `offset` varchar(128) DEFAULT NULL,
  `root_id` bigint(20) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.media_attachment: ~14 rows (około)
DELETE FROM `media_attachment`;
/*!40000 ALTER TABLE `media_attachment` DISABLE KEYS */;
INSERT INTO `media_attachment` (`id`, `filename`, `extension`, `offset`, `root_id`, `lft`, `rgt`, `level`) VALUES
	(1, '1307_cennik-serwisu_mediam_wzorpdf-4.html', 'html', NULL, NULL, NULL, NULL, NULL),
	(2, '9_kat-2.jpg', 'jpg', NULL, NULL, NULL, NULL, NULL),
	(3, '9_kat-3.jpg', 'jpg', NULL, NULL, NULL, NULL, NULL),
	(4, 'a_left_disabled.png', 'png', NULL, NULL, NULL, NULL, NULL),
	(5, '12_kat.jpg', 'jpg', NULL, NULL, NULL, NULL, NULL),
	(6, 'atrybuty.jpg', 'jpg', NULL, NULL, NULL, NULL, NULL),
	(7, 'calia__.jpg', 'jpg', NULL, NULL, NULL, NULL, NULL),
	(8, 'no-banner-300x250.jpg', 'jpg', NULL, NULL, NULL, NULL, NULL),
	(9, 'no-banner-728x90 (1).jpg', 'jpg', NULL, NULL, NULL, NULL, NULL),
	(10, 'newspapers-cover_2515843b.jpg', 'jpg', NULL, NULL, NULL, NULL, NULL),
	(11, NULL, NULL, NULL, 11, 1, 2, 0),
	(12, NULL, NULL, NULL, 12, 1, 2, 0),
	(13, 'no-banner-728x90 (1)-1.jpg', 'jpg', NULL, NULL, NULL, NULL, NULL),
	(14, 'no-banner-728x90 (1)-2.jpg', 'jpg', NULL, NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `media_attachment` ENABLE KEYS */;


-- Zrzut struktury tabela imav.media_attachment_translation
CREATE TABLE IF NOT EXISTS `media_attachment_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`),
  CONSTRAINT `media_attachment_translation_id_media_attachment_id` FOREIGN KEY (`id`) REFERENCES `media_attachment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `media_attachment_translation_id_media_attachment_id_1` FOREIGN KEY (`id`) REFERENCES `media_attachment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.media_attachment_translation: ~12 rows (około)
DELETE FROM `media_attachment_translation`;
/*!40000 ALTER TABLE `media_attachment_translation` DISABLE KEYS */;
INSERT INTO `media_attachment_translation` (`id`, `title`, `slug`, `description`, `lang`) VALUES
	(1, '1307_cennik-serwisu_mediam_wzorpdfhtml', '1307_cennik-serwisu_mediam_wzorpdfhtml', NULL, 'pl'),
	(2, '9_kat', '9_kat', NULL, 'pl'),
	(3, '9_kat', '9_kat-1', NULL, 'pl'),
	(4, 'a_left_disabled', 'a_left_disabled', NULL, 'pl'),
	(5, '12_kat', '12_kat', NULL, 'pl'),
	(6, 'atrybuty', 'atrybuty', NULL, 'pl'),
	(7, 'calia__', 'calia__', NULL, 'pl'),
	(8, 'no-banner-300x250', 'no-banner-300x250', NULL, 'pl'),
	(9, 'no-banner-728x90-1-', 'no-banner-728x90-1', NULL, 'pl'),
	(10, 'newspapers-cover_2515843b', 'newspapers-cover_2515843b', NULL, 'pl'),
	(13, 'no-banner-728x90-1-', 'no-banner-728x90-1-1', NULL, 'pl'),
	(14, 'no-banner-728x90-1-', 'no-banner-728x90-1-2', NULL, 'pl');
/*!40000 ALTER TABLE `media_attachment_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.media_photo
CREATE TABLE IF NOT EXISTS `media_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offset` varchar(128) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `crop_data` text,
  `root_id` bigint(20) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.media_photo: ~116 rows (około)
DELETE FROM `media_photo`;
/*!40000 ALTER TABLE `media_photo` DISABLE KEYS */;
INSERT INTO `media_photo` (`id`, `offset`, `filename`, `title`, `crop_data`, `root_id`, `lft`, `rgt`, `level`) VALUES
	(1, '3573809597', 'mid_1681-1.jpg', 'mid_1681', NULL, 1, 1, 4, 0),
	(3, '2972192841', 'choose-file.png', 'choose-file', NULL, 1, 2, 3, 1),
	(6, '3573809597', 'big_1166696891.jpg', 'big_1166696891', NULL, 6, 1, 12, 0),
	(7, '2972192841', '_czerwona_strzalka-1.png', '_czerwona_strzalka', NULL, 7, 1, 8, 0),
	(8, '2972192841', 'a_left_disabled-1.png', 'a_left_disabled', NULL, 7, 6, 7, 1),
	(9, '2972192841', 'choose-file-1.png', 'choose-file', NULL, 7, 4, 5, 1),
	(10, '2972192841', 'close-1.png', 'close', NULL, 7, 2, 3, 1),
	(11, '2972192841', 'uczciwa_scr2-1.png', 'uczciwa_scr2', NULL, 11, 1, 4, 0),
	(12, '2972192841', 'close-2.png', 'close', NULL, 11, 2, 3, 1),
	(13, '3573809597', 'mid_1685.jpg', 'mid_1685', NULL, 13, 1, 2, 0),
	(21, '2972192841', 'uczciwa_scr1.png', 'uczciwa_scr1', NULL, 6, 10, 11, 1),
	(22, '2972192841', 'uczciwa_scr2.png', 'uczciwa_scr2', NULL, 6, 8, 9, 1),
	(23, '2972192841', 'uczciwa_scr3.png', 'uczciwa_scr3', NULL, 6, 6, 7, 1),
	(24, '2972192841', 'uczciwa_scr4.png', 'uczciwa_scr4', NULL, 6, 4, 5, 1),
	(25, '2972192841', 'uczciwa_scr5.png', 'uczciwa_scr5', NULL, 6, 2, 3, 1),
	(26, '3573809597', 'mid_1684.jpg', 'mid_1684', NULL, 26, 1, 2, 0),
	(27, '2972192841', 'obama.jpg', 'obama', 'a:5:{s:7:"126x126";a:6:{s:1:"x";i:30;s:1:"y";i:0;s:2:"x2";i:138;s:2:"y2";i:190;s:1:"w";i:108;s:1:"h";i:190;}s:4:"400x";a:6:{s:1:"x";i:20;s:1:"y";i:0;s:2:"x2";i:182;s:2:"y2";i:251;s:1:"w";i:162;s:1:"h";i:251;}s:7:"236x153";a:6:{s:1:"x";i:2;s:1:"y";i:7;s:2:"x2";i:196;s:2:"y2";i:229;s:1:"w";i:194;s:1:"h";i:221;}s:4:"x210";a:6:{s:1:"x";i:23;s:1:"y";i:0;s:2:"x2";i:171;s:2:"y2";i:247;s:1:"w";i:148;s:1:"h";i:247;}s:7:"130x130";a:6:{s:1:"x";i:26;s:1:"y";i:0;s:2:"x2";i:169;s:2:"y2";i:251;s:1:"w";i:143;s:1:"h";i:251;}}', 27, 1, 10, 0),
	(28, '2972192841', 'uczciwa_scr1-1.png', 'uczciwa_scr1', NULL, 27, 8, 9, 1),
	(29, '2972192841', 'uczciwa_scr2-2.png', 'uczciwa_scr2', NULL, 27, 6, 7, 1),
	(30, '2972192841', 'uczciwa_scr3-1.png', 'uczciwa_scr3', NULL, 27, 4, 5, 1),
	(31, '2972192841', 'uczciwa_scr5-1.png', 'uczciwa_scr5', NULL, 27, 2, 3, 1),
	(32, '2972192841', '3725219-kaaiman-abazur-8103817-3.png', '3725219 - Kaaiman - abażur - 8103817', 'N;', 32, 1, 4, 0),
	(33, '2972192841', 'obama-1.jpg', 'Barack', 'a:1:{s:7:"126x126";a:6:{s:1:"x";i:75;s:1:"y";i:86;s:2:"x2";i:111;s:2:"y2";i:148;s:1:"w";i:35;s:1:"h";i:62;}}', 32, 2, 3, 1),
	(37, NULL, NULL, NULL, NULL, 37, 1, 2, 0),
	(38, '2972192841', '2030219-kaaiman-abazur-8162817.png', '2030219 - Kaaiman - abażur - 8162817', NULL, 38, 1, 10, 0),
	(39, '2972192841', '2035219-kaaiman-abazur-8103017.png', '2035219 - Kaaiman - abażur - 8103017', NULL, 38, 8, 9, 1),
	(40, '2972192841', '2050151-cotton-abazur-8200817.jpg', '2050151 - Cotton - abażur - 8200817', NULL, 38, 6, 7, 1),
	(41, '2972192841', '3725151-cotton-abazur-8103817.png', '3725151 - Cotton - abażur - 8103817', NULL, 38, 2, 3, 1),
	(42, '2972192841', '3725219-kaaiman-abazur-8152717.png', '3725219 - Kaaiman - abażur - 8152717', NULL, 38, 4, 5, 1),
	(43, NULL, NULL, NULL, NULL, 43, 1, 2, 0),
	(48, NULL, NULL, NULL, NULL, 48, 1, 2, 0),
	(49, NULL, NULL, NULL, NULL, 49, 1, 2, 0),
	(51, NULL, NULL, NULL, NULL, 51, 1, 2, 0),
	(52, '3573809597', 'obama.jpg', 'obama', 'N;', 52, 1, 12, 0),
	(68, '3573809597', 'big_1166696872-1.jpg', 'big_1166696872', NULL, 68, 1, 12, 0),
	(72, '2972192841', 'min_112.jpg', 'min_112', 'N;', 72, 1, 10, 0),
	(73, '2972192841', 'big_1171374851.jpg', 'big_1171374851', NULL, 72, 8, 9, 1),
	(74, '2972192841', 'mid_1681.jpg', 'mid_1681', NULL, 72, 6, 7, 1),
	(75, '2972192841', 'mid_1682.jpg', 'mid_1682', NULL, 72, 4, 5, 1),
	(77, '2972192841', 'mid_723.jpg', 'mid_723', NULL, 72, 2, 3, 1),
	(80, '2972192841', 'mid_1681-1.jpg', 'mid_1681', 'a:4:{s:4:"400x";a:6:{s:1:"x";i:59;s:1:"y";i:27;s:2:"x2";i:101;s:2:"y2";i:83;s:1:"w";i:42;s:1:"h";i:56;}s:7:"236x153";a:6:{s:1:"x";i:61;s:1:"y";i:63;s:2:"x2";i:88;s:2:"y2";i:81;s:1:"w";i:28;s:1:"h";i:17;}s:4:"x210";a:6:{s:1:"x";i:75;s:1:"y";i:82;s:2:"x2";i:141;s:2:"y2";i:136;s:1:"w";i:66;s:1:"h";i:54;}s:7:"130x130";a:6:{s:1:"x";i:69;s:1:"y";i:69;s:2:"x2";i:129;s:2:"y2";i:126;s:1:"w";i:59;s:1:"h";i:57;}}', 80, 1, 10, 0),
	(81, '2972192841', 'mid_1681-2.jpg', 'mid_1681', NULL, 80, 8, 9, 1),
	(82, '2972192841', 'mid_1682-1.jpg', 'mid_1682', NULL, 80, 6, 7, 1),
	(83, '2972192841', 'mid_1684-1.jpg', 'mid_1684', NULL, 80, 2, 3, 1),
	(84, '2972192841', 'mid_1685-1.jpg', 'mid_1685', NULL, 80, 4, 5, 1),
	(85, '3573809597', '12_kat-1-.jpg', '12_kat (1)', NULL, 85, 1, 14, 0),
	(93, NULL, NULL, NULL, NULL, 93, 1, 2, 0),
	(94, NULL, NULL, NULL, NULL, 94, 1, 2, 0),
	(95, '2972192841', 'mid_1681-3.jpg', 'mid_1681', 'N;', 95, 1, 12, 0),
	(100, '2972192841', 'mid_723-1.jpg', 'mid_723', NULL, 100, 1, 12, 0),
	(105, '2972192841', 'big_1166696872-2.jpg', 'big_1166696872', NULL, 100, 10, 11, 1),
	(106, '2972192841', 'big_1171374705-1.jpg', 'big_1171374705', NULL, 100, 8, 9, 1),
	(107, '2972192841', 'big_1171374728.jpg', 'big_1171374728', NULL, 100, 6, 7, 1),
	(108, '2972192841', 'big_1171374758.jpg', 'big_1171374758', NULL, 100, 4, 5, 1),
	(109, '2972192841', 'big_1171374782.jpg', 'big_1171374782', NULL, 100, 2, 3, 1),
	(110, '2972192841', '4425151-cotton-abazur-8106717-2.png', '4425151 - Cotton - abażur - 8106717', NULL, 95, 10, 11, 1),
	(111, '2972192841', 'big_1166696744-1.jpg', 'big_1166696744', NULL, 95, 8, 9, 1),
	(112, '2972192841', 'big_1171374679-2.jpg', 'big_1171374679', NULL, 95, 6, 7, 1),
	(113, '2972192841', 'big_1171374705-2.jpg', 'big_1171374705', NULL, 95, 4, 5, 1),
	(114, '2972192841', 'big_1171374813-1-.jpg', 'big_1171374813 (1)', NULL, 95, 2, 3, 1),
	(115, '104190285', '2035151-cotton-abazur-8152717.png', '2035151 - Cotton - abażur - 8152717', NULL, 115, 1, 2, 0),
	(116, '104190285', '2030226-king-abazur-8103117.png', '2030226 - King - abażur - 8103117', NULL, 116, 1, 2, 0),
	(117, '104190285', '2035151-cotton-abazur-8152717-1.png', '2035151 - Cotton - abażur - 8152717', NULL, 117, 1, 2, 0),
	(118, '3573809597', 'big_1171374851.jpg', 'big_1171374851', NULL, 118, 1, 2, 0),
	(119, '3573809597', 'big_1171374876.jpg', 'big_1171374876', NULL, 119, 1, 2, 0),
	(120, '3573809597', 'mid_110.jpg', 'mid_110', NULL, 120, 1, 2, 0),
	(121, '3573809597', 'mid_1681.jpg', 'mid_1681', NULL, 121, 1, 2, 0),
	(122, '3573809597', 'mid_723.jpg', 'mid_723', NULL, 122, 1, 2, 0),
	(123, '3573809597', 'min_111.jpg', 'min_111', NULL, 123, 1, 2, 0),
	(124, '3573809597', 'min_112.jpg', 'min_112', NULL, 124, 1, 2, 0),
	(125, '3573809597', 'uczciwa_scr2.png', 'uczciwa_scr2', NULL, 125, 1, 2, 0),
	(126, '3573809597', '3725219-kaaiman-abazur-8103817.png', '3725219 - Kaaiman - abażur - 8103817', NULL, 52, 10, 11, 1),
	(127, '3573809597', '3725219-kaaiman-abazur-8152717.png', '3725219 - Kaaiman - abażur - 8152717', NULL, 52, 8, 9, 1),
	(128, '3573809597', '3725231-king-abazur-8109917.png', '3725231 - King - abażur - 8109917', NULL, 52, 6, 7, 1),
	(129, '3573809597', 'big_1166696891-1.jpg', 'big_1166696891', NULL, 52, 4, 5, 1),
	(130, '3573809597', 'big_1171374679.jpg', 'big_1171374679', NULL, 52, 2, 3, 1),
	(131, '3573809597', 'mid_1680-1.jpg', 'mid_1680', NULL, 85, 12, 13, 1),
	(132, '3573809597', 'mid_1681-2.jpg', 'mid_1681', NULL, 85, 10, 11, 1),
	(133, '3573809597', 'mid_1682.jpg', 'mid_1682', NULL, 85, 8, 9, 1),
	(134, '3573809597', 'min_111-1.jpg', 'min_111', NULL, 85, 6, 7, 1),
	(135, '3573809597', 'min_112-1.jpg', 'min_112', NULL, 85, 4, 5, 1),
	(136, '3573809597', 'uczciwa_scr1-1.png', 'uczciwa_scr1', NULL, 85, 2, 3, 1),
	(142, '3573809597', '12_kat-1--1.jpg', '12_kat (1)', NULL, 142, 1, 2, 0),
	(143, '3573809597', '2035151-cotton-abazur-8152717.png', '2035151 - Cotton - abażur - 8152717', NULL, 143, 1, 12, 0),
	(160, '3573809597', 'obama-1.jpg', 'obama', NULL, 160, 1, 2, 0),
	(161, '3573809597', 'big_1166696891-3.jpg', 'big_1166696891', NULL, 68, 10, 11, 1),
	(162, '3573809597', 'big_1171374679-1.jpg', 'big_1171374679', NULL, 68, 8, 9, 1),
	(163, '3573809597', 'big_1171374782.jpg', 'big_1171374782', NULL, 68, 6, 7, 1),
	(164, '3573809597', 'big_1171374813-1-.jpg', 'big_1171374813 (1)', NULL, 68, 4, 5, 1),
	(165, '3573809597', 'big_117137481302', 'big_1171374813', NULL, 68, 2, 3, 1),
	(166, NULL, NULL, NULL, NULL, 166, 1, 2, 0),
	(167, NULL, NULL, NULL, NULL, 167, 1, 2, 0),
	(168, NULL, NULL, NULL, NULL, 168, 1, 2, 0),
	(169, '3573809597', 'min_112-2.jpg', 'min_112', NULL, 169, 1, 2, 0),
	(170, '3573809597', '3730151-cotton-abazur-8158217-1.png', '3730151 - Cotton - abażur - 8158217', NULL, 170, 1, 2, 0),
	(171, '3573809597', 'big_1166696891-4.jpg', 'big_1166696891', NULL, 171, 1, 8, 0),
	(172, '3573809597', '4425151-cotton-abazur-8106717.png', '4425151 - Cotton - abażur - 8106717', NULL, 171, 6, 7, 1),
	(173, '3573809597', 'mid_1681-3.jpg', 'mid_1681', NULL, 171, 4, 5, 1),
	(174, '3573809597', 'mid_1685-1.jpg', 'mid_1685', NULL, 171, 2, 3, 1),
	(176, '3573809597', '3725219-kaaiman-abazur-8152717-1.png', '3725219 - Kaaiman - abażur - 8152717', NULL, 176, 1, 2, 0),
	(177, '3573809597', '2030219-kaaiman-abazur-8162817-1.png', '2030219 - Kaaiman - abażur - 8162817', NULL, 143, 10, 11, 1),
	(178, '3573809597', '2030226-king-abazur-8103117.png', '2030226 - King - abażur - 8103117', NULL, 143, 8, 9, 1),
	(179, '3573809597', '3725219-kaaiman-abazur-8152717-2.png', '3725219 - Kaaiman - abażur - 8152717', NULL, 143, 6, 7, 1),
	(180, '3573809597', '3725231-king-abazur-8109917-1.png', '3725231 - King - abażur - 8109917', NULL, 143, 4, 5, 1),
	(181, '3573809597', 'big_1166696872-2.jpg', 'big_1166696872', NULL, 143, 2, 3, 1),
	(182, '3573809597', 'big_1166696744.jpg', 'big_1166696744', NULL, 182, 1, 8, 0),
	(183, '3573809597', 'obama-2.jpg', 'obama', NULL, 182, 6, 7, 1),
	(184, '3573809597', 'uczciwa_scr1-2.png', 'uczciwa_scr1', NULL, 182, 4, 5, 1),
	(185, '3573809597', 'uczciwa_scr2-1.png', 'uczciwa_scr2', NULL, 182, 2, 3, 1),
	(186, '3573809597', 'big_1166696744-1.jpg', 'big_1166696744', NULL, 186, 1, 2, 0),
	(187, '3573809597', 'mid_1685-2.jpg', 'mid_1685', NULL, 187, 1, 2, 0),
	(188, '3573809597', 'obama-3.jpg', 'obama', NULL, 188, 1, 2, 0),
	(189, NULL, NULL, NULL, NULL, 189, 1, 2, 0),
	(190, NULL, NULL, NULL, NULL, 190, 1, 2, 0),
	(191, NULL, NULL, NULL, NULL, 191, 1, 2, 0),
	(192, NULL, NULL, NULL, NULL, 192, 1, 2, 0);
/*!40000 ALTER TABLE `media_photo` ENABLE KEYS */;


-- Zrzut struktury tabela imav.media_video
CREATE TABLE IF NOT EXISTS `media_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offset` varchar(128) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.media_video: ~0 rows (około)
DELETE FROM `media_video`;
/*!40000 ALTER TABLE `media_video` DISABLE KEYS */;
/*!40000 ALTER TABLE `media_video` ENABLE KEYS */;


-- Zrzut struktury tabela imav.media_video_url
CREATE TABLE IF NOT EXISTS `media_video_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `extension` varchar(255) DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `ad_id` int(11) DEFAULT NULL,
  `root_id` bigint(20) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` longtext,
  PRIMARY KEY (`id`),
  KEY `photo_root_id_idx` (`photo_root_id`),
  CONSTRAINT `media_video_url_photo_root_id_media_photo_id` FOREIGN KEY (`photo_root_id`) REFERENCES `media_photo` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.media_video_url: ~53 rows (około)
DELETE FROM `media_video_url`;
/*!40000 ALTER TABLE `media_video_url` DISABLE KEYS */;
INSERT INTO `media_video_url` (`id`, `url`, `extension`, `photo_root_id`, `ad_id`, `root_id`, `lft`, `rgt`, `level`, `title`, `slug`, `description`) VALUES
	(1, NULL, NULL, NULL, NULL, 1, 1, 6, 0, NULL, NULL, NULL),
	(2, 'http://www.youtube.com/embed/lqw3Gd4vGGs', NULL, NULL, NULL, 1, 2, 3, 1, NULL, NULL, NULL),
	(3, NULL, NULL, NULL, NULL, 3, 1, 2, 0, NULL, NULL, NULL),
	(4, 'http://imav.smsy.co.pl/what_love.mp4', NULL, NULL, NULL, 4, 1, 2, 0, NULL, NULL, NULL),
	(7, 'http://www.youtube.com/embed/lqw3Gd4vGGs', NULL, NULL, NULL, 1, 4, 5, 1, NULL, NULL, NULL),
	(8, NULL, NULL, NULL, NULL, 8, 1, 4, 0, NULL, NULL, NULL),
	(9, 'https://www.youtube.com/embed/kRvzjN1kC6Q', NULL, NULL, NULL, 8, 2, 3, 1, NULL, NULL, NULL),
	(10, NULL, NULL, NULL, NULL, 10, 1, 2, 0, NULL, NULL, NULL),
	(11, NULL, NULL, NULL, NULL, 11, 1, 2, 0, NULL, NULL, NULL),
	(12, NULL, NULL, NULL, NULL, 12, 1, 2, 0, NULL, NULL, NULL),
	(13, NULL, NULL, NULL, NULL, 13, 1, 2, 0, NULL, NULL, NULL),
	(14, NULL, NULL, NULL, NULL, 14, 1, 2, 0, NULL, NULL, NULL),
	(15, NULL, NULL, NULL, NULL, 15, 1, 2, 0, NULL, NULL, NULL),
	(16, NULL, NULL, NULL, NULL, 16, 1, 2, 0, NULL, NULL, NULL),
	(17, NULL, NULL, NULL, NULL, 17, 1, 2, 0, NULL, NULL, NULL),
	(18, NULL, NULL, NULL, NULL, 18, 1, 2, 0, NULL, NULL, NULL),
	(19, NULL, NULL, NULL, NULL, 19, 1, 2, 0, NULL, NULL, NULL),
	(20, 'http://stream2.imav.tv/timetoimav/2014/07/10/mm_2014-07-10_amazing720p25.mp4', NULL, NULL, 1, 20, 1, 4, 0, NULL, NULL, NULL),
	(22, 'https://www.youtube.com/embed/L1FmXe-82VY', NULL, NULL, 4, 22, 1, 4, 0, NULL, NULL, NULL),
	(24, 'http://www.youtube.com/embed/kToPJCDFG2c', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(25, NULL, NULL, NULL, NULL, 25, 1, 4, 0, NULL, NULL, NULL),
	(26, 'https://www.youtube.com/embed/UmUoiCUIT8E', NULL, NULL, NULL, 25, 2, 3, 1, NULL, NULL, NULL),
	(27, NULL, NULL, NULL, NULL, 27, 1, 4, 0, NULL, NULL, NULL),
	(28, 'http://www.youtube.com/embed/kToPJCDFG2c', NULL, NULL, NULL, 27, 2, 3, 1, NULL, NULL, NULL),
	(29, 'https://www.youtube.com/embed/avt-AKD3ewM', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL),
	(30, NULL, NULL, NULL, NULL, 30, 1, 6, 0, NULL, NULL, NULL),
	(31, 'http://www.youtube.com/embed/kToPJCDFG2c', NULL, NULL, NULL, 30, 2, 3, 1, NULL, NULL, NULL),
	(32, 'http://player.vimeo.com/video/78683505', NULL, NULL, NULL, 30, 4, 5, 1, NULL, NULL, NULL),
	(33, NULL, NULL, NULL, NULL, 33, 1, 2, 0, NULL, NULL, NULL),
	(34, NULL, NULL, NULL, NULL, 34, 1, 2, 0, NULL, NULL, NULL),
	(35, NULL, NULL, NULL, NULL, 35, 1, 2, 0, NULL, NULL, NULL),
	(36, NULL, NULL, NULL, NULL, 36, 1, 2, 0, NULL, NULL, NULL),
	(37, NULL, NULL, NULL, NULL, 37, 1, 2, 0, NULL, NULL, NULL),
	(45, 'https://www.youtube.com/embed/n3CqrGtsuGk', NULL, NULL, 3, 45, 1, 4, 0, NULL, NULL, NULL),
	(46, 'https://www.youtube.com/embed/n3CqrGtsuGk', NULL, NULL, 3, 45, 2, 3, 1, NULL, NULL, NULL),
	(47, 'https://www.youtube.com/embed/n3CqrGtsuGk', NULL, NULL, 4, 47, 1, 4, 0, NULL, NULL, NULL),
	(48, 'https://www.youtube.com/embed/n3CqrGtsuGk', NULL, NULL, 4, 47, 2, 3, 1, NULL, NULL, NULL),
	(49, 'http://imav.smsy.co.pl/what_love.mp4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(50, 'https://www.youtube.com/embed/wPn8GQoAqIM', NULL, NULL, 3, 20, 2, 3, 1, NULL, NULL, NULL),
	(52, 'https://www.youtube.com/embed/L1FmXe-82VY', NULL, NULL, 4, 22, 2, 3, 1, NULL, NULL, NULL),
	(53, 'https://www.youtube.com/embed/L1FmXe-82VY', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(54, 'https://www.youtube.com/embed/UWytYfascoA', NULL, NULL, 4, 54, 1, 4, 0, NULL, NULL, NULL),
	(55, 'https://www.youtube.com/embed/UWytYfascoA', NULL, NULL, 4, 54, 2, 3, 1, NULL, NULL, NULL),
	(56, 'http://imav.smsy.co.pl/videoplayer/videos/video3.mp4', NULL, NULL, 3, 56, 1, 2, 0, NULL, NULL, NULL),
	(57, NULL, NULL, NULL, 5, 56, NULL, NULL, NULL, NULL, NULL, NULL),
	(58, '', NULL, NULL, 0, 58, 1, 2, 0, NULL, NULL, NULL),
	(59, '', NULL, NULL, 0, 59, 1, 2, 0, NULL, NULL, NULL),
	(60, 'http://player.vimeo.com/video/78683505', NULL, NULL, 3, 60, 1, 2, 0, NULL, NULL, NULL),
	(61, NULL, NULL, NULL, NULL, 61, 1, 2, 0, NULL, NULL, NULL),
	(62, '', NULL, NULL, 0, 62, 1, 2, 0, NULL, NULL, NULL),
	(63, 'http://player.vimeo.com/video/78683505', NULL, NULL, 3, 63, 1, 2, 0, NULL, NULL, NULL),
	(64, NULL, NULL, NULL, NULL, 64, 1, 2, 0, NULL, NULL, NULL),
	(65, 'http://imav.smsy.co.pl/what_love.mp4', NULL, NULL, NULL, 65, 1, 2, 0, NULL, NULL, NULL);
/*!40000 ALTER TABLE `media_video_url` ENABLE KEYS */;


-- Zrzut struktury tabela imav.media_video_url_translation
CREATE TABLE IF NOT EXISTS `media_video_url_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`),
  CONSTRAINT `media_video_url_translation_id_media_video_url_id` FOREIGN KEY (`id`) REFERENCES `media_video_url` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `media_video_url_translation_id_media_video_url_id_1` FOREIGN KEY (`id`) REFERENCES `media_video_url` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.media_video_url_translation: ~18 rows (około)
DELETE FROM `media_video_url_translation`;
/*!40000 ALTER TABLE `media_video_url_translation` DISABLE KEYS */;
INSERT INTO `media_video_url_translation` (`id`, `title`, `slug`, `description`, `lang`) VALUES
	(2, NULL, NULL, NULL, 'pl'),
	(4, 'Reklama tenis', NULL, NULL, 'pl'),
	(20, 'Harcerze na rowerach', NULL, NULL, 'pl'),
	(24, 'Nazwa', NULL, NULL, 'pl'),
	(46, 'Reklama nowa', NULL, NULL, 'pl'),
	(48, 'Reklama googla', NULL, NULL, 'pl'),
	(49, 'Reklama googla dobra', NULL, NULL, 'pl'),
	(50, 'Moje video', NULL, NULL, 'pl'),
	(52, 'test', NULL, NULL, 'pl'),
	(53, 'test', NULL, NULL, 'pl'),
	(55, 'Reklama tenis', NULL, NULL, 'pl'),
	(56, 'dsadsada', NULL, NULL, 'pl'),
	(58, '', NULL, NULL, 'pl'),
	(59, '', NULL, NULL, 'pl'),
	(60, 'Sfera multimedialna', NULL, NULL, 'pl'),
	(62, '', NULL, NULL, 'pl'),
	(63, 'Sfera jakastam', NULL, NULL, 'pl'),
	(65, 'Reklama nowa', NULL, NULL, 'pl');
/*!40000 ALTER TABLE `media_video_url_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.menu_footer
CREATE TABLE IF NOT EXISTS `menu_footer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `root_id` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `root_id_idx` (`root_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.menu_footer: 1 rows
DELETE FROM `menu_footer`;
/*!40000 ALTER TABLE `menu_footer` DISABLE KEYS */;
INSERT INTO `menu_footer` (`id`, `name`, `root_id`, `location`) VALUES
	(1, 'Footer', 1, 'top_menu');
/*!40000 ALTER TABLE `menu_footer` ENABLE KEYS */;


-- Zrzut struktury tabela imav.menu_footer_item
CREATE TABLE IF NOT EXISTS `menu_footer_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `target_type` varchar(128) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `target_id` varchar(128) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `custom_url` varchar(255) DEFAULT NULL,
  `unique_id` varchar(128) DEFAULT NULL,
  `css_class` varchar(128) DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `root_id` bigint(20) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id_idx` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.menu_footer_item: 15 rows
DELETE FROM `menu_footer_item`;
/*!40000 ALTER TABLE `menu_footer_item` DISABLE KEYS */;
INSERT INTO `menu_footer_item` (`id`, `target_type`, `route`, `target_id`, `menu_id`, `custom_url`, `unique_id`, `css_class`, `photo_root_id`, `root_id`, `lft`, `rgt`, `level`) VALUES
	(1, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 1, 1, 30, 0),
	(3, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 1, 2, 15, 1),
	(4, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 1, 3, 4, 2),
	(7, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 1, 5, 6, 2),
	(8, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 1, 7, 8, 2),
	(9, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 1, 9, 10, 2),
	(10, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 1, 11, 12, 2),
	(11, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 1, 13, 14, 2),
	(12, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 1, 16, 23, 1),
	(13, NULL, 'domain-login', NULL, 1, NULL, NULL, NULL, NULL, 1, 17, 18, 2),
	(14, NULL, 'domain-i18n:register', NULL, 1, NULL, NULL, NULL, NULL, 1, 19, 20, 2),
	(15, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 1, 21, 22, 2),
	(16, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 1, 24, 29, 1),
	(17, NULL, '', NULL, 1, NULL, NULL, NULL, NULL, 1, 25, 26, 2),
	(20, NULL, 'domain-contact', NULL, 1, NULL, NULL, NULL, NULL, 1, 27, 28, 2);
/*!40000 ALTER TABLE `menu_footer_item` ENABLE KEYS */;


-- Zrzut struktury tabela imav.menu_footer_item_translation
CREATE TABLE IF NOT EXISTS `menu_footer_item_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `target_href` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title_attr` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.menu_footer_item_translation: 40 rows
DELETE FROM `menu_footer_item_translation`;
/*!40000 ALTER TABLE `menu_footer_item_translation` DISABLE KEYS */;
INSERT INTO `menu_footer_item_translation` (`id`, `target_href`, `title`, `title_attr`, `slug`, `lang`) VALUES
	(2, NULL, 'Footer', NULL, 'footer', 'pl'),
	(2, NULL, 'Footer', NULL, 'footer', 'en'),
	(3, NULL, 'Informacje', NULL, 'informacje', 'pl'),
	(3, NULL, 'Informacje', NULL, 'informacje', 'en'),
	(4, NULL, 'Wymiana,Reklamacje,Zwroty', NULL, 'wymiana-reklamacje-zwroty', 'pl'),
	(4, NULL, 'Wymiana,Reklamacje,Zwroty', NULL, 'wymiana-reklamacje-zwroty', 'en'),
	(5, NULL, 'Dostawa', NULL, 'dostawa', 'pl'),
	(5, NULL, 'Dostawa', NULL, 'dostawa', 'en'),
	(6, NULL, 'Dostawa', NULL, 'dostawa', 'pl'),
	(6, NULL, 'Dostawa', NULL, 'dostawa', 'en'),
	(7, NULL, 'Dostawa', NULL, 'dostawa', 'pl'),
	(7, NULL, 'Dostawa', NULL, 'dostawa', 'en'),
	(8, NULL, 'Dostępność towarów', NULL, 'dostepnosc-towarow', 'pl'),
	(8, NULL, 'Dostępność towarów', NULL, 'dostepnosc-towarow', 'en'),
	(9, NULL, 'Płatności', NULL, 'platnosci', 'pl'),
	(9, NULL, 'Płatności', NULL, 'platnosci', 'en'),
	(10, NULL, 'Regulamin', NULL, 'regulamin', 'pl'),
	(10, NULL, 'Regulamin', NULL, 'regulamin', 'en'),
	(11, NULL, 'Polityka Cookies', NULL, 'polityka-cookies', 'pl'),
	(11, NULL, 'Polityka Cookies', NULL, 'polityka-cookies', 'en'),
	(1, NULL, '', '', '', 'pl'),
	(1, NULL, '', '', '', 'en'),
	(12, NULL, 'Twoje konto', '', 'your-account', 'pl'),
	(12, NULL, 'Your account', '', 'your-account', 'en'),
	(13, NULL, 'Logowanie do konta', NULL, 'logowanie-do-konta', 'pl'),
	(13, NULL, 'Logowanie do konta', NULL, 'logowanie-do-konta', 'en'),
	(14, NULL, 'Zarejestuj się', NULL, 'zarejestuj-sie', 'pl'),
	(14, NULL, 'Zarejestuj się', NULL, 'zarejestuj-sie', 'en'),
	(15, NULL, 'Status zamówienia', NULL, 'status-zamowienia', 'pl'),
	(15, NULL, 'Status zamówienia', NULL, 'status-zamowienia', 'en'),
	(16, NULL, 'O firmie', NULL, 'o-firmie', 'pl'),
	(16, NULL, 'O firmie', NULL, 'o-firmie', 'en'),
	(17, NULL, 'Aktualności', NULL, 'aktualnosci', 'pl'),
	(17, NULL, 'Aktualności', NULL, 'aktualnosci', 'en'),
	(18, NULL, 'Co nas wyróżnia', NULL, 'co-nas-wyroznia', 'pl'),
	(18, NULL, 'Co nas wyróżnia', NULL, 'co-nas-wyroznia', 'en'),
	(19, NULL, 'Sprzedaż hurtowa', NULL, 'sprzedaz-hurtowa', 'pl'),
	(19, NULL, 'Sprzedaż hurtowa', NULL, 'sprzedaz-hurtowa', 'en'),
	(20, NULL, 'Kontakt', '', 'kontakt', 'pl'),
	(20, NULL, 'Kontakt', '', 'kontakt', 'en');
/*!40000 ALTER TABLE `menu_footer_item_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.menu_menu
CREATE TABLE IF NOT EXISTS `menu_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `root_id` int(11) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.menu_menu: 2 rows
DELETE FROM `menu_menu`;
/*!40000 ALTER TABLE `menu_menu` DISABLE KEYS */;
INSERT INTO `menu_menu` (`id`, `name`, `root_id`, `location`) VALUES
	(1, 'Menu', 45, NULL),
	(2, 'Podmenu', 76, NULL);
/*!40000 ALTER TABLE `menu_menu` ENABLE KEYS */;


-- Zrzut struktury tabela imav.menu_menu_item
CREATE TABLE IF NOT EXISTS `menu_menu_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `target_type` varchar(128) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `target_id` varchar(128) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `custom_url` varchar(255) DEFAULT NULL,
  `unique_id` varchar(128) DEFAULT NULL,
  `css_class` varchar(128) DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `root_id` bigint(20) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id_idx` (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.menu_menu_item: 13 rows
DELETE FROM `menu_menu_item`;
/*!40000 ALTER TABLE `menu_menu_item` DISABLE KEYS */;
INSERT INTO `menu_menu_item` (`id`, `target_type`, `route`, `target_id`, `menu_id`, `custom_url`, `unique_id`, `css_class`, `photo_root_id`, `root_id`, `lft`, `rgt`, `level`) VALUES
	(45, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 45, 1, 34, 0),
	(89, NULL, 'domain-news-group', NULL, 2, NULL, NULL, NULL, NULL, 76, 14, 15, 1),
	(87, NULL, 'domain-news-student', NULL, 2, NULL, NULL, NULL, NULL, 76, 12, 13, 1),
	(83, NULL, 'domain-news-category', NULL, 1, NULL, NULL, NULL, NULL, 45, 28, 29, 1),
	(84, NULL, 'domain-news-category', NULL, 1, NULL, NULL, NULL, NULL, 45, 30, 31, 1),
	(88, NULL, 'domain-list-gallery', NULL, 2, NULL, NULL, NULL, NULL, 76, 16, 17, 1),
	(85, NULL, 'domain-news-group', NULL, 2, NULL, NULL, NULL, NULL, 76, 8, 9, 1),
	(86, NULL, 'domain-news-group', NULL, 2, NULL, NULL, NULL, NULL, 76, 10, 11, 1),
	(76, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 76, 1, 18, 0),
	(82, NULL, 'domain-news-category', NULL, 1, NULL, NULL, NULL, NULL, 45, 26, 27, 1),
	(81, NULL, 'domain-news-category', NULL, 1, NULL, NULL, NULL, NULL, 45, 24, 25, 1),
	(80, NULL, 'domain-news-category', NULL, 1, NULL, NULL, NULL, NULL, 45, 22, 23, 1),
	(90, NULL, 'domain-contact', NULL, 1, NULL, NULL, NULL, NULL, 45, 32, 33, 1);
/*!40000 ALTER TABLE `menu_menu_item` ENABLE KEYS */;


-- Zrzut struktury tabela imav.menu_menu_item_translation
CREATE TABLE IF NOT EXISTS `menu_menu_item_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `target_href` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title_attr` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.menu_menu_item_translation: 11 rows
DELETE FROM `menu_menu_item_translation`;
/*!40000 ALTER TABLE `menu_menu_item_translation` DISABLE KEYS */;
INSERT INTO `menu_menu_item_translation` (`id`, `target_href`, `title`, `title_attr`, `slug`, `lang`) VALUES
	(89, NULL, 'Inne media', NULL, 'inne-media', 'pl'),
	(88, NULL, 'Galeria', NULL, 'galeria', 'pl'),
	(87, NULL, 'Studencka twórczość', NULL, 'studencka-tworczosc', 'pl'),
	(86, NULL, 'Starostwo Powiatowe', NULL, 'starostwo-powiatowe', 'pl'),
	(83, NULL, 'Rozrywka', NULL, 'rozrywka', 'pl'),
	(84, NULL, 'Reportaże', NULL, 'reportaze', 'pl'),
	(85, NULL, 'Miasto Tarnów', NULL, 'miasto-tarnow', 'pl'),
	(82, NULL, 'Kultura', NULL, 'kultura', 'pl'),
	(81, NULL, 'Sport', NULL, 'sport', 'pl'),
	(80, NULL, 'Wiadomości', NULL, 'wiadomosci', 'pl'),
	(90, NULL, 'Kontakt', NULL, 'kontakt', 'pl');
/*!40000 ALTER TABLE `menu_menu_item_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.migration_version
CREATE TABLE IF NOT EXISTS `migration_version` (
  `version` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.migration_version: ~1 rows (około)
DELETE FROM `migration_version`;
/*!40000 ALTER TABLE `migration_version` DISABLE KEYS */;
INSERT INTO `migration_version` (`version`) VALUES
	(2);
/*!40000 ALTER TABLE `migration_version` ENABLE KEYS */;


-- Zrzut struktury tabela imav.newsletter_group
CREATE TABLE IF NOT EXISTS `newsletter_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.newsletter_group: 1 rows
DELETE FROM `newsletter_group`;
/*!40000 ALTER TABLE `newsletter_group` DISABLE KEYS */;
INSERT INTO `newsletter_group` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Subs', '2014-10-15 08:34:33', '2014-10-15 08:34:33', NULL);
/*!40000 ALTER TABLE `newsletter_group` ENABLE KEYS */;


-- Zrzut struktury tabela imav.newsletter_group_subscriber
CREATE TABLE IF NOT EXISTS `newsletter_group_subscriber` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `subscriber_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id_idx` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.newsletter_group_subscriber: 2 rows
DELETE FROM `newsletter_group_subscriber`;
/*!40000 ALTER TABLE `newsletter_group_subscriber` DISABLE KEYS */;
INSERT INTO `newsletter_group_subscriber` (`id`, `group_id`, `subscriber_id`) VALUES
	(1, 1, 1),
	(2, 1, 2);
/*!40000 ALTER TABLE `newsletter_group_subscriber` ENABLE KEYS */;


-- Zrzut struktury tabela imav.newsletter_message
CREATE TABLE IF NOT EXISTS `newsletter_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(128) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  `date_to_send` datetime DEFAULT NULL,
  `all_subscribers` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.newsletter_message: 1 rows
DELETE FROM `newsletter_message`;
/*!40000 ALTER TABLE `newsletter_message` DISABLE KEYS */;
INSERT INTO `newsletter_message` (`id`, `type`, `title`, `content`, `date_to_send`, `all_subscribers`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(2, NULL, 'test imav', '<p>dasdada</p>', NULL, 1, '2014-10-15 08:46:52', '2014-10-15 08:47:02', NULL);
/*!40000 ALTER TABLE `newsletter_message` ENABLE KEYS */;


-- Zrzut struktury tabela imav.newsletter_message_company
CREATE TABLE IF NOT EXISTS `newsletter_message_company` (
  `message_id` int(11) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`,`company_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.newsletter_message_company: 0 rows
DELETE FROM `newsletter_message_company`;
/*!40000 ALTER TABLE `newsletter_message_company` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_message_company` ENABLE KEYS */;


-- Zrzut struktury tabela imav.newsletter_message_event
CREATE TABLE IF NOT EXISTS `newsletter_message_event` (
  `message_id` int(11) NOT NULL DEFAULT '0',
  `event_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`,`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.newsletter_message_event: 0 rows
DELETE FROM `newsletter_message_event`;
/*!40000 ALTER TABLE `newsletter_message_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_message_event` ENABLE KEYS */;


-- Zrzut struktury tabela imav.newsletter_message_news
CREATE TABLE IF NOT EXISTS `newsletter_message_news` (
  `message_id` int(11) NOT NULL DEFAULT '0',
  `news_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`,`news_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.newsletter_message_news: 0 rows
DELETE FROM `newsletter_message_news`;
/*!40000 ALTER TABLE `newsletter_message_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_message_news` ENABLE KEYS */;


-- Zrzut struktury tabela imav.newsletter_message_product
CREATE TABLE IF NOT EXISTS `newsletter_message_product` (
  `message_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`message_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.newsletter_message_product: 0 rows
DELETE FROM `newsletter_message_product`;
/*!40000 ALTER TABLE `newsletter_message_product` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_message_product` ENABLE KEYS */;


-- Zrzut struktury tabela imav.newsletter_sent
CREATE TABLE IF NOT EXISTS `newsletter_sent` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) DEFAULT NULL,
  `subscriber_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `send_at` datetime DEFAULT NULL,
  `sent` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `message_id_idx` (`message_id`),
  KEY `subscriber_id_idx` (`subscriber_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.newsletter_sent: 0 rows
DELETE FROM `newsletter_sent`;
/*!40000 ALTER TABLE `newsletter_sent` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_sent` ENABLE KEYS */;


-- Zrzut struktury tabela imav.newsletter_sent_messages
CREATE TABLE IF NOT EXISTS `newsletter_sent_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) DEFAULT NULL,
  `subscriber_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `sent` tinyint(1) DEFAULT '0',
  `error` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `message_id_idx` (`message_id`),
  KEY `subscriber_id_idx` (`subscriber_id`),
  KEY `group_id_idx` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.newsletter_sent_messages: 1 rows
DELETE FROM `newsletter_sent_messages`;
/*!40000 ALTER TABLE `newsletter_sent_messages` DISABLE KEYS */;
INSERT INTO `newsletter_sent_messages` (`id`, `message_id`, `subscriber_id`, `group_id`, `sent_at`, `sent`, `error`, `created_at`, `updated_at`) VALUES
	(4, 2, 2, NULL, NULL, 1, NULL, '2014-10-15 08:47:02', '2014-10-15 08:47:29');
/*!40000 ALTER TABLE `newsletter_sent_messages` ENABLE KEYS */;


-- Zrzut struktury tabela imav.newsletter_subscriber
CREATE TABLE IF NOT EXISTS `newsletter_subscriber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.newsletter_subscriber: 1 rows
DELETE FROM `newsletter_subscriber`;
/*!40000 ALTER TABLE `newsletter_subscriber` DISABLE KEYS */;
INSERT INTO `newsletter_subscriber` (`id`, `username`, `first_name`, `last_name`, `email`, `token`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(2, NULL, NULL, NULL, 'kardi31@o2.pl', 'bf8f19400a6c35f91895ccff345bcd90', 1, '2014-10-15 08:46:22', '2014-10-15 08:46:22', NULL);
/*!40000 ALTER TABLE `newsletter_subscriber` ENABLE KEYS */;


-- Zrzut struktury tabela imav.newsletter_subscriber_group
CREATE TABLE IF NOT EXISTS `newsletter_subscriber_group` (
  `subscriber_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`subscriber_id`,`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.newsletter_subscriber_group: 0 rows
DELETE FROM `newsletter_subscriber_group`;
/*!40000 ALTER TABLE `newsletter_subscriber_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_subscriber_group` ENABLE KEYS */;


-- Zrzut struktury tabela imav.news_article
CREATE TABLE IF NOT EXISTS `news_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `last_editor_id` int(11) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '1',
  `publish_date` datetime DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id_idx` (`category_id`),
  KEY `author_id_idx` (`author_id`),
  KEY `last_editor_id_idx` (`last_editor_id`),
  KEY `photo_root_id_idx` (`photo_root_id`),
  KEY `metatag_id_idx` (`metatag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.news_article: 0 rows
DELETE FROM `news_article`;
/*!40000 ALTER TABLE `news_article` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_article` ENABLE KEYS */;


-- Zrzut struktury tabela imav.news_article_translation
CREATE TABLE IF NOT EXISTS `news_article_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.news_article_translation: 0 rows
DELETE FROM `news_article_translation`;
/*!40000 ALTER TABLE `news_article_translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_article_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.news_category
CREATE TABLE IF NOT EXISTS `news_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`),
  KEY `news_category_metatag_id_default_metatag_id` (`metatag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.news_category: 5 rows
DELETE FROM `news_category`;
/*!40000 ALTER TABLE `news_category` DISABLE KEYS */;
INSERT INTO `news_category` (`id`, `user_id`, `last_user_id`, `metatag_id`, `title`, `slug`, `content`) VALUES
	(1, NULL, NULL, NULL, 'Wiadomości', 'wiadomosci', NULL),
	(2, NULL, NULL, 1603, 'Sport', 'sport', NULL),
	(3, NULL, NULL, NULL, 'Kultura', 'kultura', NULL),
	(4, NULL, NULL, NULL, 'Rozrywka', 'rozrywka', NULL),
	(6, NULL, NULL, NULL, 'Reportaże', 'reportaze', NULL);
/*!40000 ALTER TABLE `news_category` ENABLE KEYS */;


-- Zrzut struktury tabela imav.news_category_translation
CREATE TABLE IF NOT EXISTS `news_category_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(64) NOT NULL DEFAULT '',
  `slug` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.news_category_translation: 0 rows
DELETE FROM `news_category_translation`;
/*!40000 ALTER TABLE `news_category_translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `news_category_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.news_comment
CREATE TABLE IF NOT EXISTS `news_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `content` longtext,
  `user_ip` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id_idx` (`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.news_comment: 3 rows
DELETE FROM `news_comment`;
/*!40000 ALTER TABLE `news_comment` DISABLE KEYS */;
INSERT INTO `news_comment` (`id`, `news_id`, `name`, `content`, `user_ip`, `active`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(28, 3, 'dsada', 'cxzcz', '127.0.0.1', 1, '2014-09-23 11:12:06', '2014-09-23 11:12:06', NULL),
	(29, 3, 'Imie', 'dsadasd', '127.0.0.1', 1, '2014-09-23 11:17:20', '2014-09-23 11:17:20', NULL),
	(30, 23, 'nick', NULL, '127.0.0.1', 1, '2014-10-01 13:36:43', '2014-10-01 13:36:43', NULL);
/*!40000 ALTER TABLE `news_comment` ENABLE KEYS */;


-- Zrzut struktury tabela imav.news_group
CREATE TABLE IF NOT EXISTS `news_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `content` longtext,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_group_metatag_id_default_metatag_id` (`metatag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.news_group: 5 rows
DELETE FROM `news_group`;
/*!40000 ALTER TABLE `news_group` DISABLE KEYS */;
INSERT INTO `news_group` (`id`, `title`, `slug`, `metatag_id`, `content`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Miasto Tarnów', 'miasto-tarnow', NULL, NULL, '2014-10-13 14:30:16', '2014-10-13 14:30:16', NULL),
	(2, 'Starostwo Powiatowe', 'starostwo-powiatowe', NULL, NULL, '2014-10-13 14:30:29', '2014-10-13 14:30:29', NULL),
	(3, 'Grupa testowa', 'grupa-testowa', 1667, '<p>Grupa testowa</p>', '2014-10-14 14:45:48', '2014-10-14 14:49:05', '2014-10-14 14:49:05'),
	(4, 'test', 'test', 1668, '<p>dsada</p>', '2014-10-14 14:48:21', '2014-10-14 14:49:00', '2014-10-14 14:49:00'),
	(5, 'Inne media', 'inne-media', 1682, NULL, '2014-10-15 12:41:08', '2014-10-15 12:41:08', NULL);
/*!40000 ALTER TABLE `news_group` ENABLE KEYS */;


-- Zrzut struktury tabela imav.news_news
CREATE TABLE IF NOT EXISTS `news_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `last_user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `publish` tinyint(1) DEFAULT '1',
  `student` tinyint(1) DEFAULT '0',
  `student_accept` tinyint(1) DEFAULT '0',
  `show_views` tinyint(1) DEFAULT '1',
  `publish_date` datetime DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `video_root_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `views` bigint(20) NOT NULL,
  `gallery` tinyint(4) NOT NULL DEFAULT '0',
  `breaking_news` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `news_news_video_root_id_media_video_url_id` (`video_root_id`),
  KEY `news_news_user_id_user_user_id` (`user_id`),
  KEY `news_news_photo_root_id_media_photo_id` (`photo_root_id`),
  KEY `news_news_metatag_id_default_metatag_id` (`metatag_id`),
  KEY `news_news_last_user_id_user_user_id` (`last_user_id`),
  KEY `news_news_group_id_news_group_id` (`group_id`),
  KEY `news_news_category_id_news_category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.news_news: 16 rows
DELETE FROM `news_news`;
/*!40000 ALTER TABLE `news_news` DISABLE KEYS */;
INSERT INTO `news_news` (`id`, `user_id`, `last_user_id`, `category_id`, `group_id`, `publish`, `student`, `student_accept`, `show_views`, `publish_date`, `photo_root_id`, `metatag_id`, `video_root_id`, `created_at`, `updated_at`, `deleted_at`, `views`, `gallery`, `breaking_news`) VALUES
	(1, 1, 1, 2, NULL, 1, 0, 0, 1, '2014-08-07 10:51:51', 6, 1606, 3, '2014-08-07 10:51:51', '2014-10-24 12:23:50', NULL, 5, 0, 0),
	(2, 1, 1, 1, NULL, 1, 0, 0, 1, '2014-08-07 10:52:00', 1, 1607, 1, '2014-08-07 10:52:03', '2014-08-18 14:13:00', NULL, 1, 0, 0),
	(3, 1, NULL, 3, NULL, 1, 0, 0, 1, '2014-08-14 10:10:36', 6, NULL, 11, '0000-00-00 00:00:00', '2014-10-14 09:22:43', NULL, 45, 0, 0),
	(4, 1, NULL, 4, NULL, 1, 0, 0, 1, '2014-08-14 10:10:39', 1, NULL, 37, '0000-00-00 00:00:00', '2014-10-01 13:19:12', NULL, 0, 0, 0),
	(5, 1, NULL, 1, NULL, 1, 0, 0, 1, '2014-08-14 10:10:44', 6, NULL, 36, '0000-00-00 00:00:00', '2014-10-01 10:07:22', NULL, 0, 0, 0),
	(6, 1, NULL, 2, NULL, 1, 0, 0, 1, '2014-08-14 10:10:41', 1, NULL, 35, '0000-00-00 00:00:00', '2014-10-01 10:07:08', NULL, 0, 0, 0),
	(7, 1, NULL, 3, NULL, 1, 0, 0, 1, '2014-08-14 10:10:48', 6, NULL, 34, '0000-00-00 00:00:00', '2014-10-01 10:06:55', NULL, 0, 0, 0),
	(8, 1, NULL, 4, NULL, 1, 0, 0, 1, '2014-08-14 10:10:52', 1, NULL, 33, '0000-00-00 00:00:00', '2014-10-01 10:06:35', NULL, 0, 0, 0),
	(9, 1, NULL, 4, NULL, 1, 0, 0, 1, '2014-08-14 10:10:55', 6, NULL, 14, '0000-00-00 00:00:00', '2014-10-01 10:49:50', NULL, 0, 0, 1),
	(24, 1, 1, 3, NULL, 1, 0, 0, 1, '2014-08-19 00:00:00', 68, 1632, 56, '2014-08-20 10:48:49', '2014-10-24 12:50:55', NULL, 16, 0, 1),
	(23, 1, 1, 1, NULL, 1, 0, 0, 0, '2014-08-19 10:27:00', 52, 1631, 20, '2014-08-19 10:27:50', '2014-10-24 13:07:28', NULL, 51, 0, 1),
	(25, 1, 1, 1, 1, 1, 0, 0, 1, '2014-10-13 14:34:00', 169, 1655, 58, '2014-10-13 14:34:08', '2014-10-14 14:27:54', NULL, 1, 0, 0),
	(26, 60, 60, 1, 1, 1, 1, 1, 1, '2014-10-13 15:11:00', 170, 1656, 59, '2014-10-13 15:11:55', '2014-10-14 12:32:44', NULL, 2, 0, 0),
	(27, 1, 1, NULL, NULL, 1, 0, 0, 1, '2014-10-14 12:47:48', 175, 1659, 61, '2014-10-14 12:47:49', '2014-10-14 13:42:42', '2014-10-14 13:42:42', 0, 0, 0),
	(28, 1, 1, 6, NULL, 1, 0, 0, 1, '2014-10-14 13:00:00', 176, 1660, 62, '2014-10-14 13:00:36', '2014-10-24 11:54:52', NULL, 4, 0, 0),
	(29, 1, 1, 2, 2, 1, 0, 0, 1, '2014-10-24 11:21:06', 192, 1688, 64, '2014-10-24 11:21:06', '2014-10-24 11:54:57', NULL, 2, 0, 0);
/*!40000 ALTER TABLE `news_news` ENABLE KEYS */;


-- Zrzut struktury tabela imav.news_news_tag
CREATE TABLE IF NOT EXISTS `news_news_tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tag_id` int(11) DEFAULT NULL,
  `news_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_id_idx` (`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.news_news_tag: 2 rows
DELETE FROM `news_news_tag`;
/*!40000 ALTER TABLE `news_news_tag` DISABLE KEYS */;
INSERT INTO `news_news_tag` (`id`, `tag_id`, `news_id`) VALUES
	(1, 1, 29),
	(2, 2, 29);
/*!40000 ALTER TABLE `news_news_tag` ENABLE KEYS */;


-- Zrzut struktury tabela imav.news_news_translation
CREATE TABLE IF NOT EXISTS `news_news_translation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` varchar(64) NOT NULL DEFAULT '',
  `slug` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.news_news_translation: 16 rows
DELETE FROM `news_news_translation`;
/*!40000 ALTER TABLE `news_news_translation` DISABLE KEYS */;
INSERT INTO `news_news_translation` (`id`, `lang`, `slug`, `title`, `content`) VALUES
	(1, 'pl', 'testowe-wydarzenie', 'Testowe wydarzenie', '<p>fasfa</p>'),
	(2, 'pl', 'testowe-wydarzenie-1', 'Testowe wydarzenie', '<p>fasfa</p>'),
	(3, 'pl', 'ssuper-testowy-news-cat', 'Super testowy news cat', 'Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum'),
	(4, 'pl', 'ssuper-testowy-news-cat', 'Super testowy news cat', 'Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum'),
	(5, 'pl', 'ssuper-testowy-news-cat', 'Super testowy news cat', 'Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum'),
	(6, 'pl', 'ssuper-testowy-news-cat', 'Super testowy news cat', 'Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum'),
	(7, 'pl', 'ssuper-testowy-news-cat', 'Super testowy news cat', 'Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum'),
	(8, 'pl', 'ssuper-testowy-news-cat', 'Super testowy news cat', 'Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum'),
	(9, 'pl', 'ssuper-testowy-news-cat', 'Super testowy news cat', 'Lorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsumLorem ipsum'),
	(24, 'pl', 'testowy-news-z-nowym-edytorem', 'Testowy news z nowym edytorem', '<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p></p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>\r\n<p>Testowy news z nowym edytorem</p>'),
	(23, 'pl', 'news-z-galeria', 'News z galeria', '<p>News z galeria</p>'),
	(25, 'pl', 'testowy-news-miasto-tarnow', 'Testowy news miasto tarnów', '<p>dsadada</p>'),
	(26, 'pl', 'studencki-news', 'Studencki news', '<p>dsadadada</p>'),
	(27, 'pl', 'tewtasda', 'tewtasda', '<p>dasdada</p>'),
	(28, 'pl', 'jakis-news', 'jakis news', ''),
	(29, 'pl', 'news-z-tagami', 'News z tagami', '<p>news z tagami</p>');
/*!40000 ALTER TABLE `news_news_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.news_tag
CREATE TABLE IF NOT EXISTS `news_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_tag_metatag_id_default_metatag_id` (`metatag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.news_tag: 2 rows
DELETE FROM `news_tag`;
/*!40000 ALTER TABLE `news_tag` DISABLE KEYS */;
INSERT INTO `news_tag` (`id`, `title`, `slug`, `metatag_id`) VALUES
	(1, 'Koszykówka', 'koszykowka', 1686),
	(2, 'Rowery', 'rowery', 1687);
/*!40000 ALTER TABLE `news_tag` ENABLE KEYS */;


-- Zrzut struktury tabela imav.page_page
CREATE TABLE IF NOT EXISTS `page_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`),
  KEY `metatag_id_idx` (`metatag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.page_page: 12 rows
DELETE FROM `page_page`;
/*!40000 ALTER TABLE `page_page` DISABLE KEYS */;
INSERT INTO `page_page` (`id`, `user_id`, `metatag_id`, `type`, `photo_root_id`) VALUES
	(30, 1, 1675, 'rozrywka', NULL),
	(29, 1, 1674, 'kultura', NULL),
	(28, 1, 1673, 'sport', NULL),
	(17, 1, 1679, 'homepage', 6991),
	(27, 1, 1672, 'wiadomosci', NULL),
	(26, 1, 1671, 'reportaze', NULL),
	(25, 1, 1670, 'gallery', NULL),
	(31, 1, 1676, 'miasto-tarnow', NULL),
	(32, 1, 1677, 'starostwo-powiatowe', NULL),
	(33, 1, 1678, 'studencka-tworczosc', NULL),
	(34, 1, 1683, 'inne-media', NULL),
	(35, 1, 1684, 'contact', NULL);
/*!40000 ALTER TABLE `page_page` ENABLE KEYS */;


-- Zrzut struktury tabela imav.page_page_translation
CREATE TABLE IF NOT EXISTS `page_page_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.page_page_translation: 13 rows
DELETE FROM `page_page_translation`;
/*!40000 ALTER TABLE `page_page_translation` DISABLE KEYS */;
INSERT INTO `page_page_translation` (`id`, `title`, `slug`, `content`, `lang`) VALUES
	(17, 'Strona główna', 'strona-glowna', '<p><span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></p>', 'pl'),
	(17, 'Homepage', 'homepage', '<p>Homepage</p>', 'en'),
	(27, 'Wiadomości', 'wiadomosci', '', 'pl'),
	(28, 'Sport', 'sport', '', 'pl'),
	(29, 'Kultura', 'kultura', '', 'pl'),
	(30, 'Rozrywka', 'rozrywka', '', 'pl'),
	(31, 'Miasto Tarnów', 'miasto-tarnow', '', 'pl'),
	(32, 'Starostwo powiatowe', 'starostwo-powiatowe', '', 'pl'),
	(33, 'Studencka twórczość', 'studencka-tworczosc', '', 'pl'),
	(34, 'Inne media', 'inne-media', '', 'pl'),
	(26, 'Reportaże', 'reportaze', '', 'pl'),
	(25, 'Galeria', 'galeria', '', 'pl'),
	(35, 'Kontakt', 'kontakt', '<p>Tekst kontakt</p>\r\n<p></p>', 'pl');
/*!40000 ALTER TABLE `page_page_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.product_category
CREATE TABLE IF NOT EXISTS `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) DEFAULT '1',
  `metatag_id` int(11) DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_category_photo_root_id_media_photo_id` (`photo_root_id`),
  KEY `product_category_metatag_id_default_metatag_id` (`metatag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.product_category: 2 rows
DELETE FROM `product_category`;
/*!40000 ALTER TABLE `product_category` DISABLE KEYS */;
INSERT INTO `product_category` (`id`, `status`, `metatag_id`, `photo_root_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 1640, 93, '2014-08-21 15:13:21', '2014-08-21 15:13:21', NULL),
	(2, 1, 1641, 94, '2014-08-21 15:20:00', '2014-08-21 15:20:00', NULL);
/*!40000 ALTER TABLE `product_category` ENABLE KEYS */;


-- Zrzut struktury tabela imav.product_category_translation
CREATE TABLE IF NOT EXISTS `product_category_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `description` longtext,
  `slug` varchar(255) DEFAULT NULL,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.product_category_translation: 2 rows
DELETE FROM `product_category_translation`;
/*!40000 ALTER TABLE `product_category_translation` DISABLE KEYS */;
INSERT INTO `product_category_translation` (`id`, `name`, `description`, `slug`, `lang`) VALUES
	(1, 'Malarstwo', '', 'malarstwo', 'pl'),
	(2, 'Rysunek', '', 'rysunek', 'pl');
/*!40000 ALTER TABLE `product_category_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.product_product
CREATE TABLE IF NOT EXISTS `product_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` decimal(18,2) DEFAULT '0.00',
  `code` varchar(255) DEFAULT NULL,
  `promoted` tinyint(1) DEFAULT '0',
  `video_root_id` int(11) DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `metatag_id` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `facebook` tinyint(1) DEFAULT '0',
  `twitter` tinyint(1) DEFAULT '0',
  `pin` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `photo_root_id_idx` (`photo_root_id`),
  KEY `metatag_id_idx` (`metatag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.product_product: 2 rows
DELETE FROM `product_product`;
/*!40000 ALTER TABLE `product_product` DISABLE KEYS */;
INSERT INTO `product_product` (`id`, `price`, `code`, `promoted`, `video_root_id`, `photo_root_id`, `category_id`, `metatag_id`, `active`, `facebook`, `twitter`, `pin`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 0.00, NULL, 0, 30, 100, 1, 1642, 1, 0, 0, 0, '2014-08-21 15:33:56', '2014-08-22 09:29:25', NULL),
	(2, 0.00, NULL, 0, NULL, 95, 1, 1643, 1, 0, 0, 0, '2014-08-21 15:34:10', '2014-08-22 08:24:20', NULL);
/*!40000 ALTER TABLE `product_product` ENABLE KEYS */;


-- Zrzut struktury tabela imav.product_product_category
CREATE TABLE IF NOT EXISTS `product_product_category` (
  `product_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`,`category_id`),
  KEY `product_product_category_category_id_product_category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.product_product_category: 0 rows
DELETE FROM `product_product_category`;
/*!40000 ALTER TABLE `product_product_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_product_category` ENABLE KEYS */;


-- Zrzut struktury tabela imav.product_product_translation
CREATE TABLE IF NOT EXISTS `product_product_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.product_product_translation: 2 rows
DELETE FROM `product_product_translation`;
/*!40000 ALTER TABLE `product_product_translation` DISABLE KEYS */;
INSERT INTO `product_product_translation` (`id`, `name`, `slug`, `description`, `lang`) VALUES
	(1, 'Testowy obraze', 'testowy-obraze', '', 'pl'),
	(2, 'Testowy obraze', 'testowy-obraze-1', '', 'pl');
/*!40000 ALTER TABLE `product_product_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.slider_slide
CREATE TABLE IF NOT EXISTS `slider_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slider_id` bigint(20) DEFAULT NULL,
  `transition` varchar(255) DEFAULT NULL,
  `slot_amount` int(11) DEFAULT NULL,
  `rotation` int(11) DEFAULT NULL,
  `transition_duration` int(11) DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `target_href` varchar(255) DEFAULT NULL,
  `target_type` varchar(255) DEFAULT NULL,
  `news_id` int(11) DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `root_id` bigint(20) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `photo_root_id_idx` (`photo_root_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.slider_slide: 11 rows
DELETE FROM `slider_slide`;
/*!40000 ALTER TABLE `slider_slide` DISABLE KEYS */;
INSERT INTO `slider_slide` (`id`, `slider_id`, `transition`, `slot_amount`, `rotation`, `transition_duration`, `delay`, `target_href`, `target_type`, `news_id`, `photo_root_id`, `root_id`, `lft`, `rgt`, `level`) VALUES
	(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 22, 0),
	(4, 1, NULL, NULL, NULL, NULL, NULL, 'www.onet.pl', 'news_target', 5, 119, 1, 8, 9, 1),
	(3, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'news_target', 1, 118, 1, 6, 7, 1),
	(5, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 120, 1, 10, 11, 1),
	(6, 1, NULL, NULL, NULL, NULL, NULL, 'www.wp.pl', 'custom_target', NULL, 121, 1, 12, 13, 1),
	(7, 1, NULL, NULL, NULL, NULL, NULL, 'www.wp.pl', NULL, NULL, 122, 1, 14, 15, 1),
	(8, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 123, 1, 16, 17, 1),
	(9, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 124, 1, 18, 19, 1),
	(10, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 125, 1, 20, 21, 1),
	(11, 1, NULL, NULL, NULL, NULL, NULL, 'www.onet.pl', 'custom_target', NULL, 187, 1, 2, 3, 1),
	(12, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'news_target', 25, 188, 1, 4, 5, 1);
/*!40000 ALTER TABLE `slider_slide` ENABLE KEYS */;


-- Zrzut struktury tabela imav.slider_slider
CREATE TABLE IF NOT EXISTS `slider_slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `slide_root_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `slide_root_id_idx` (`slide_root_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.slider_slider: 2 rows
DELETE FROM `slider_slider`;
/*!40000 ALTER TABLE `slider_slider` DISABLE KEYS */;
INSERT INTO `slider_slider` (`id`, `name`, `slug`, `slide_root_id`) VALUES
	(1, 'Main slider', 'main', 1),
	(2, 'Second slider', 'second', NULL);
/*!40000 ALTER TABLE `slider_slider` ENABLE KEYS */;


-- Zrzut struktury tabela imav.slider_slide_layer
CREATE TABLE IF NOT EXISTS `slider_slide_layer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slide_id` varchar(128) DEFAULT NULL,
  `type` varchar(128) DEFAULT NULL,
  `text_html` varchar(255) DEFAULT NULL,
  `animation` varchar(255) DEFAULT NULL,
  `easing` varchar(255) DEFAULT NULL,
  `speed` int(11) DEFAULT NULL,
  `target_href` varchar(255) DEFAULT NULL,
  `x_position` int(11) DEFAULT NULL,
  `y_position` int(11) DEFAULT NULL,
  `start` bigint(20) DEFAULT NULL,
  `class` varchar(128) DEFAULT NULL,
  `width_iframe` bigint(20) DEFAULT NULL,
  `height_iframe` bigint(20) DEFAULT NULL,
  `photo_root_id` int(11) DEFAULT NULL,
  `root_id` bigint(20) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rgt` int(11) DEFAULT NULL,
  `level` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `slide_id_idx` (`slide_id`),
  KEY `photo_root_id_idx` (`photo_root_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.slider_slide_layer: 0 rows
DELETE FROM `slider_slide_layer`;
/*!40000 ALTER TABLE `slider_slide_layer` DISABLE KEYS */;
/*!40000 ALTER TABLE `slider_slide_layer` ENABLE KEYS */;


-- Zrzut struktury tabela imav.slider_slide_translation
CREATE TABLE IF NOT EXISTS `slider_slide_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.slider_slide_translation: 6 rows
DELETE FROM `slider_slide_translation`;
/*!40000 ALTER TABLE `slider_slide_translation` DISABLE KEYS */;
INSERT INTO `slider_slide_translation` (`id`, `title`, `slug`, `content`, `lang`) VALUES
	(4, 'Test', 'test', '<p>Ttytulik sli</p>', 'pl'),
	(3, 'Informacje', 'informacje', '<p>dasdada</p>', 'pl'),
	(5, 'dsadada', 'dsadada', '<p>dsadada</p>', 'pl'),
	(6, 'Sport', 'sport', '<p>sdadacxzcxz</p>', 'pl'),
	(11, '', '', '<p>Super link</p>', 'pl'),
	(12, NULL, '-1', '<p>dsadsa</p>', 'pl');
/*!40000 ALTER TABLE `slider_slide_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.user_group
CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_id_idx` (`discount_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.user_group: 0 rows
DELETE FROM `user_group`;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;


-- Zrzut struktury tabela imav.user_group_translation
CREATE TABLE IF NOT EXISTS `user_group_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` longtext,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.user_group_translation: 0 rows
DELETE FROM `user_group_translation`;
/*!40000 ALTER TABLE `user_group_translation` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_group_translation` ENABLE KEYS */;


-- Zrzut struktury tabela imav.user_profile
CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `about` longtext,
  `address` varchar(255) DEFAULT NULL,
  `postal_code` varchar(128) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `proxy_name` varchar(255) DEFAULT NULL,
  `photo_root_id` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `photo_root_id_idx` (`photo_root_id`),
  KEY `province_id_idx` (`province_id`),
  KEY `city_id_idx` (`city_id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.user_profile: 40 rows
DELETE FROM `user_profile`;
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
INSERT INTO `user_profile` (`id`, `user_id`, `about`, `address`, `postal_code`, `phone`, `company_name`, `city`, `province`, `province_id`, `city_id`, `website`, `nip`, `proxy_name`, `photo_root_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 'aa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(3, NULL, NULL, NULL, '55-555', NULL, NULL, 'Miasto', NULL, NULL, NULL, NULL, '12345678912', NULL, NULL, '2013-10-30 12:35:17', '2013-10-30 12:35:17', NULL),
	(4, NULL, NULL, NULL, '55-555', NULL, 'Nazwisko Imie', 'Miasto', NULL, NULL, NULL, NULL, '12345678912', NULL, NULL, '2013-10-30 12:36:08', '2013-10-30 12:36:08', NULL),
	(5, NULL, NULL, 'ulicanowa 1234/12', '11-111', NULL, 'Nazwisko Imie', 'miastonowe', NULL, NULL, NULL, NULL, '12345678912', NULL, NULL, '2013-10-30 12:39:39', '2013-10-30 12:39:39', NULL),
	(6, 29, NULL, 'ulicanowa 1234/12', '11-111', NULL, 'Nazwisko Imie', 'miastonowe', NULL, NULL, NULL, NULL, '12345678912', NULL, NULL, '2013-10-30 12:40:24', '2013-10-30 12:40:24', NULL),
	(7, 30, NULL, NULL, NULL, NULL, 'Nazw Imie', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2013-10-30 14:10:31', '2013-10-30 14:10:31', NULL),
	(8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2013-10-30 14:13:25', '2013-10-30 14:13:25', NULL),
	(9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2013-10-30 14:16:00', '2013-10-30 14:16:00', NULL),
	(10, 33, NULL, NULL, NULL, NULL, 'ostr adam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2013-10-30 14:17:08', '2013-10-30 14:17:08', NULL),
	(11, 34, NULL, NULL, NULL, NULL, 'ostr adam', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2013-10-30 14:19:14', '2013-10-30 14:19:14', NULL),
	(12, 35, NULL, NULL, NULL, NULL, 'test dobry', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2013-10-30 14:25:27', '2013-10-30 14:25:27', NULL),
	(13, NULL, NULL, 'ulica 11/2', '11-111', NULL, 'carm melo', 'misato', NULL, NULL, NULL, NULL, '', NULL, NULL, '2013-10-30 14:26:41', '2013-10-30 14:26:41', NULL),
	(14, 37, NULL, 'sadsa 11/1', '11-111', NULL, 'firma', 'miasto', NULL, NULL, NULL, NULL, '', NULL, NULL, '2013-10-30 14:28:15', '2013-10-30 14:28:15', NULL),
	(15, 38, NULL, 'sadsa 11/1', '11-111', NULL, 'firma', 'miasto', NULL, NULL, NULL, NULL, '', NULL, NULL, '2013-10-30 14:29:23', '2013-10-30 14:29:23', NULL),
	(16, 39, NULL, 'firmaaa 55/5', '11-111', NULL, 'firma', 'miaaa', NULL, NULL, NULL, NULL, '', NULL, NULL, '2013-10-30 14:32:33', '2013-10-30 14:32:33', NULL),
	(17, 40, NULL, 'ulica 11/1', '22-222', NULL, 'fiiaaa', 'miaaa', NULL, NULL, NULL, NULL, '', NULL, NULL, '2013-10-30 14:35:17', '2013-10-30 14:35:17', NULL),
	(18, 41, NULL, 'ulica 11/1', '22-222', NULL, 'fiiaaa', 'miaaa', NULL, NULL, NULL, NULL, '', NULL, NULL, '2013-10-30 14:35:58', '2013-10-30 14:35:58', NULL),
	(19, 42, NULL, 'sadsada 11/1', '22-222', NULL, 'fiii', 'mmsaaa', NULL, NULL, NULL, NULL, '', NULL, NULL, '2013-10-30 14:37:09', '2013-10-30 14:37:09', NULL),
	(20, 43, NULL, 'lucoa 11/1', '22-222', NULL, 'lucoa', 'lucoa', NULL, NULL, NULL, NULL, '', NULL, NULL, '2013-10-31 08:29:19', '2013-10-31 08:29:19', NULL),
	(42, 42, NULL, 'nnuli 77/7', '77-777', NULL, 'nnwfirm', 'nnmias', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2013-10-31 09:06:01', '2013-10-31 09:06:01', NULL),
	(43, 45, NULL, 'niemie 55/5', '55-555', NULL, NULL, 'niemm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2013-10-31 13:21:19', '2013-10-31 13:21:19', NULL),
	(44, 46, NULL, 'niemie 55/5', '55-555', NULL, NULL, 'niemm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2013-10-31 13:21:37', '2013-10-31 13:21:37', NULL),
	(45, 47, NULL, 'ulkica 11/1', '11-111', '12345678', NULL, 'miasto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2013-11-21 08:03:17', '2013-11-21 08:03:17', NULL),
	(46, 48, NULL, 'TeUlica 55/1', '44-444', NULL, '', 'TeMiasto', NULL, NULL, NULL, NULL, '', NULL, NULL, '2013-12-02 11:13:16', '2013-12-02 11:13:16', NULL),
	(47, 49, NULL, 'ull 123/3', '66-111', NULL, '', 'miasto', NULL, NULL, NULL, NULL, '', NULL, NULL, '2013-12-02 11:26:27', '2013-12-02 11:26:27', NULL),
	(48, 50, NULL, 'ulica 55/22', '22-222', NULL, '', 'miasto', NULL, NULL, NULL, NULL, '', NULL, NULL, '2013-12-02 11:27:48', '2013-12-02 11:27:48', NULL),
	(49, 51, NULL, 'aaa 11/1', '11-111', NULL, 'aaaa', 'adsada', NULL, NULL, NULL, NULL, '', NULL, NULL, '2013-12-02 11:28:29', '2013-12-02 11:28:29', NULL),
	(50, 52, NULL, 'dydyd 11/1', '11-111', NULL, 'dydyd', 'dydyd', NULL, NULL, NULL, NULL, '', NULL, NULL, '2013-12-02 11:30:11', '2013-12-02 11:30:11', NULL),
	(51, 53, NULL, 'Mike 11/1', '11-111', NULL, 'Mike', 'mikebrown', NULL, NULL, NULL, NULL, '', NULL, NULL, '2013-12-02 11:58:48', '2013-12-02 11:58:48', NULL),
	(52, 54, NULL, 'lucoa 11/1', '22-222', '111222333', NULL, 'lucoa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2013-12-02 12:36:04', '2013-12-02 12:36:04', NULL),
	(53, 55, NULL, 'lucoa 11/1', '22-222', '99887766', NULL, 'lucoa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2013-12-12 10:56:12', '2013-12-12 10:56:12', NULL),
	(54, 56, NULL, 'lucoa 11/1', '22-222', '99887766', NULL, 'lucoa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2013-12-17 11:31:32', '2013-12-17 11:31:32', NULL),
	(55, 57, NULL, 'Ulica 11/1', '11-111', NULL, '', 'Miasto', NULL, NULL, NULL, NULL, '', NULL, NULL, '2014-01-28 10:05:58', '2014-01-28 10:05:58', NULL),
	(56, 58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-13 13:48:36', '2014-10-13 13:48:36', NULL),
	(57, 59, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-13 13:53:34', '2014-10-13 13:53:34', NULL),
	(58, 60, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-13 13:54:56', '2014-10-13 13:54:56', NULL),
	(59, 61, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-15 13:02:33', '2014-10-15 13:02:33', NULL),
	(60, 62, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-15 13:30:35', '2014-10-15 13:30:35', NULL),
	(61, 63, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-15 13:32:44', '2014-10-15 13:32:44', NULL);
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;


-- Zrzut struktury tabela imav.user_profile_tag
CREATE TABLE IF NOT EXISTS `user_profile_tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.user_profile_tag: 0 rows
DELETE FROM `user_profile_tag`;
/*!40000 ALTER TABLE `user_profile_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_profile_tag` ENABLE KEYS */;


-- Zrzut struktury tabela imav.user_role
CREATE TABLE IF NOT EXISTS `user_role` (
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.user_role: 5 rows
DELETE FROM `user_role`;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` (`name`, `slug`) VALUES
	('Redaktor wiadomości', 'wiadomosci'),
	('Redaktor sport', 'sport'),
	('Redaktor kultura', 'kultura'),
	('Redaktor reportaże', 'reportaze'),
	('Redaktor rozrywka', 'rozrywka');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;


-- Zrzut struktury tabela imav.user_update
CREATE TABLE IF NOT EXISTS `user_update` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.user_update: 0 rows
DELETE FROM `user_update`;
/*!40000 ALTER TABLE `user_update` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_update` ENABLE KEYS */;


-- Zrzut struktury tabela imav.user_user
CREATE TABLE IF NOT EXISTS `user_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fb_id` varchar(128) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `discount_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `discount_id_idx` (`discount_id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.user_user: 6 rows
DELETE FROM `user_user`;
/*!40000 ALTER TABLE `user_user` DISABLE KEYS */;
INSERT INTO `user_user` (`id`, `fb_id`, `first_name`, `last_name`, `email`, `username`, `salt`, `password`, `role`, `token`, `active`, `discount_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, NULL, 'Tomek', 'Kardas', 'admin', NULL, '8a8eabf85a6ccaa4a0da3b7dd4211206', 'cfe56643e5b7702a5d1ba5191c88ad93', 'admin', 'cb19a3defcd6e30798869d11f24986fb', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(2, NULL, 'Tomek', 'Kardas', 'kardi31@o2.pl', NULL, '44495d39979d6f5590a0dc26be19a214', 'b554a5e73e26de6c192e96e7930e578b', 'admin', '2785f99d82c28815512969a14a0857af', 1, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(60, NULL, 'Jan', 'Nowak', 'tomekvarts@o2.pl', NULL, '24dd951b33621c934cf44ddee5441555', 'efd6044d2f1f53465fbdb96bfd4438fe', 'redaktor', 'c38cd886075743dd52658dd55c0621e1', 1, NULL, '2014-10-13 13:54:56', '2014-10-13 13:55:46', NULL),
	(61, NULL, 'Testowy', 'Student', 'tomasz.kardas20@gmail.com', NULL, 'df3c26a4382cc7f0b55f88eb98bf223b', NULL, 'redaktor', '2fd49dc507877891ff6eac35fd5b7548', 0, NULL, '2014-10-15 13:02:31', '2014-10-15 13:28:09', '2014-10-15 13:28:09'),
	(62, NULL, 'Tomasz', 'kardas', 'tomasz.kardas20@gmail.com', NULL, 'f060302dc813843457728f5b09b2b290', NULL, 'redaktor', 'b5165c6210a072b3ef1c68207b953592', 0, NULL, '2014-10-15 13:30:35', '2014-10-15 13:32:32', '2014-10-15 13:32:32'),
	(63, NULL, 'Tomasz', 'kardas', 'tomasz.kardas20@gmail.com', NULL, 'accaad521e56a4af1def1071d083ff93', '0ddbd398c57f0173343e4fe2cce49e71', 'redaktor', '9617552b560749ff7a24cb65df3ea663', 1, NULL, '2014-10-15 13:32:44', '2014-10-15 13:33:15', NULL);
/*!40000 ALTER TABLE `user_user` ENABLE KEYS */;


-- Zrzut struktury tabela imav.user_user_group
CREATE TABLE IF NOT EXISTS `user_user_group` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `user_user_group_group_id_user_group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.user_user_group: 0 rows
DELETE FROM `user_user_group`;
/*!40000 ALTER TABLE `user_user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_user_group` ENABLE KEYS */;


-- Zrzut struktury tabela imav.user_user_role
CREATE TABLE IF NOT EXISTS `user_user_role` (
  `id` int(11) NOT NULL DEFAULT '0',
  `slug` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`slug`),
  KEY `user_user_role_slug_user_role_slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Zrzucanie danych dla tabeli imav.user_user_role: 9 rows
DELETE FROM `user_user_role`;
/*!40000 ALTER TABLE `user_user_role` DISABLE KEYS */;
INSERT INTO `user_user_role` (`id`, `slug`) VALUES
	(58, 'kultura'),
	(58, 'wiadomosci'),
	(59, 'reportaze'),
	(59, 'wiadomosci'),
	(60, 'kultura'),
	(60, 'wiadomosci'),
	(61, 'sport'),
	(62, 'wiadomosci'),
	(63, 'wiadomosci');
/*!40000 ALTER TABLE `user_user_role` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
