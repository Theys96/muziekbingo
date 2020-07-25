-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 25, 2020 at 06:04 PM
-- Server version: 10.3.23-MariaDB
-- PHP Version: 5.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bingo`
--

-- --------------------------------------------------------

--
-- Table structure for table `codes`
--

CREATE TABLE IF NOT EXISTS `codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` char(6) NOT NULL,
  `admin` char(12) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin` (`admin`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `examples`
--

CREATE TABLE IF NOT EXISTS `examples` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` char(6) NOT NULL,
  `description_en` text NOT NULL,
  `description_nl` text NOT NULL,
  `spotify` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `exceptions`
--

CREATE TABLE IF NOT EXISTS `exceptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `remote_addr` text NOT NULL,
  `http_user_agent` text NOT NULL,
  `type` varchar(5) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=91 ;

-- --------------------------------------------------------

--
-- Table structure for table `lijst`
--

CREATE TABLE IF NOT EXISTS `lijst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `song` text CHARACTER SET latin1 NOT NULL,
  `artist` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1271 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
