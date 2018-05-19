-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 11. Okt 2015 um 00:20
-- Server Version: 5.5.44
-- PHP-Version: 5.6.10-1~dotdeb+7.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `main`
--

-- --------------------------------------------------------


--
-- Tabellenstruktur für Tabelle `gallery_images`
--

CREATE TABLE IF NOT EXISTS `gallery_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `source` varchar(255) NOT NULL,
  `image` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Daten für Tabelle `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `name`, `source`, `image`) VALUES
(1, 'Celtic Woman - Fields of Gold', 'http://www.flickr.com/photos/51004283@N04/', 'FieldsofGold.png'),
(2, 'Celtic Woman - Galway Bay', 'http://www.flickr.com/photos/feargal/', 'GalwayBay.png'),
(3, 'Nickelback - Lullaby', 'http://www.flickr.com/photos/diloz/', 'Lullaby.png'),
(4, 'Linkin Park - Powerless', 'http://www.flickr.com/photos/robertfrancis/', 'Powerless.png'),
(8, 'Simple Plan - Summer Paradise', 'http://www.flickr.com/photos/waisian', 'SummerParadise.png'),
(9, 'Bastille - Icarus', 'http://www.flickr.com/photos/senad-63/', 'Icarus.png'),
(10, 'Eros Ramazzotti feat. Tina Turner - Cose Della Vita', 'http://www.flickr.com/photos/70140013@N07', 'CosedellaVita.png'),
(13, 'Marina and the Diamonds - Buy the Stars', 'https://www.dreami.ch', 'BuytheStars.png'),
(14, '3 Doors Down - It''s The Only One You''ve Got', 'https://www.flickr.com/photos/melanchology/', 'ItstheonlyOneYouvegot.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `passwords_password`
--

CREATE TABLE IF NOT EXISTS `passwords_password` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `applicable` varchar(30) DEFAULT NULL,
  `notes` text,
  `vendor_id_fk` int(10) unsigned NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `vendorhatpasswords` (`vendor_id_fk`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `passwords_password`
--

INSERT INTO `passwords_password` (`ID`, `username`, `password`, `applicable`, `notes`, `vendor_id_fk`) VALUES
(1, 'admin', NULL, NULL, NULL, 1),
(2, 'root', 'calvin', '[iD]RAC', NULL, 2),
(3, 'maintainer', 'bcpbSERIALNUMBER', NULL, '14 Sekunden Zeit nach Boot<br>SERIALNUMBER = Seriennummer<br>Beispiel: bcpbFGT60C3G10016011', 1),
(4, 'admin', 'admin', 'BIG-IP Web', NULL, 3),
(5, 'root', 'default', 'BIG-IP Console/SSH', '19200 baud', 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `passwords_vendor`
--

CREATE TABLE IF NOT EXISTS `passwords_vendor` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `passwords_vendor`
--

INSERT INTO `passwords_vendor` (`ID`, `name`) VALUES
(1, 'Fortinet'),
(2, 'Dell'),
(3, 'F5 Networks');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_accesslevel`
--

CREATE TABLE IF NOT EXISTS `user_accesslevel` (
  `id_user_accesslevel` int(11) NOT NULL AUTO_INCREMENT,
  `access_level` varchar(30) NOT NULL,
  `level` enum('0','1','2','3','4') NOT NULL,
  PRIMARY KEY (`id_user_accesslevel`),
  UNIQUE KEY `level` (`level`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Daten für Tabelle `user_accesslevel`
--

INSERT INTO `user_accesslevel` (`id_user_accesslevel`, `access_level`, `level`) VALUES
(10, 'Unregistriert', '0'),
(11, 'Registriert', '1'),
(12, 'Verifiziert', '2'),
(13, 'Vertraut', '3'),
(14, 'Administrator', '4');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_user`
--

CREATE TABLE IF NOT EXISTS `user_user` (
  `id_user_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fk_user_accesslevel` int(11) NOT NULL,
  PRIMARY KEY (`id_user_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `user_user`
--

INSERT INTO `user_user` (`id_user_user`, `name`, `email`, `password`, `fk_user_accesslevel`) VALUES
(0, 'Unregistriert', '', '', 10),
(1, 'admin', 'admin@admin.com', '$2y$10$4pOFAPwvWt1k.u6Yq4LdaeErg0Q5LjngsmvmanhCJOsI0f62s4uoa', 14),
(2, 'user', 'user@user.ch', '$2y$10$/kjiI9KwwtQDkbLBEsBZOuRc/jLSLDLDPThPgw77y8p1ev0vXIFDq', 11)
