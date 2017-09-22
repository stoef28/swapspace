-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 22. Sep 2017 um 18:00
-- Server Version: 5.6.17
-- PHP-Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `swapspace`
--
CREATE DATABASE IF NOT EXISTS `swapspace` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `swapspace`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `damage_case`
--

DROP TABLE IF EXISTS `damage_case`;
CREATE TABLE IF NOT EXISTS `damage_case` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dc_nr` text NOT NULL,
  `password` varchar(256) NOT NULL,
  `phone` varchar(256) NOT NULL,
  `first_name` varchar(256) NOT NULL,
  `last_name` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `state` int(11) NOT NULL,
  `responsible_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `altered` datetime NOT NULL,
  `deleted` datetime NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `damage_case`
--

INSERT INTO `damage_case` (`id`, `dc_nr`, `password`, `phone`, `first_name`, `last_name`, `email`, `state`, `responsible_id`, `survey_id`, `created`, `altered`, `deleted`) VALUES
(1, '001', 'testpw', '0123456789', '', '', 'test@test.com', 0, 1, 1, '2017-09-22 16:46:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `e_nr` int(11) NOT NULL,
  `phone` varchar(256) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime NOT NULL,
  `deleted` datetime NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `employee`
--

INSERT INTO `employee` (`id`, `first_name`, `last_name`, `e_nr`, `phone`, `created`, `last_login`, `deleted`) VALUES
(1, 'max', 'muster', 1, '0123456789', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `employee_id` int(11) NOT NULL,
  `damage_case_id` int(11) NOT NULL,
  `is_inbox` tinyint(1) NOT NULL,
  `text` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `my_doc`
--

DROP TABLE IF EXISTS `my_doc`;
CREATE TABLE IF NOT EXISTS `my_doc` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `type` varchar(256) NOT NULL,
  `damage_case_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` datetime NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `survey`
--

DROP TABLE IF EXISTS `survey`;
CREATE TABLE IF NOT EXISTS `survey` (
  `id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `damage_case_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `submitted` datetime NOT NULL,
  `deleted` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `survey`
--

INSERT INTO `survey` (`id`, `status_id`, `survey_id`, `name`, `damage_case_id`, `created`, `submitted`, `deleted`) VALUES
(1, 0, 0, 'treppensturz', 1, '2017-09-22 16:44:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
