-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2015 at 06:58 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `friend`
--

CREATE TABLE IF NOT EXISTS `friend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `friend` int(11) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `live` tinyint(4) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `live` (`live`),
  KEY `deleted` (`deleted`),
  KEY `friend` (`friend`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `friend`
--

INSERT INTO `friend` (`id`, `friend`, `user`, `live`, `deleted`, `created`, `modified`) VALUES
(8, 5, 2, 1, 0, '2015-04-19 22:08:52', '2015-04-19 22:08:52'),
(9, 7, 2, 1, 0, '2015-04-19 22:25:02', '2015-04-19 22:55:30'),
(10, 2, 7, 1, 0, '2015-04-20 18:55:34', '2015-04-20 18:55:34');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `message` int(11) DEFAULT NULL,
  `body` text,
  `live` tinyint(4) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `live` (`live`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user`, `message`, `body`, `live`, `deleted`, `created`, `modified`) VALUES
(1, 7, 0, 'Hello I am Prakhar', 1, 0, '2015-04-20 00:00:00', '2015-04-20 00:15:00'),
(2, 5, 0, 'Hey this is a test message', 1, 0, '2015-04-20 00:18:05', '2015-04-20 00:18:05'),
(5, 2, 0, 'I am Hemant', 1, 0, '2015-04-20 17:59:37', '2015-04-20 17:59:37'),
(6, 2, 1, 'Ok got it Prakhar', 1, 0, '2015-04-20 18:47:30', '2015-04-20 18:47:30'),
(7, 2, 1, 'This is second comment on Prakhar status', 1, 0, '2015-04-20 18:48:13', '2015-04-20 18:48:13'),
(8, 2, 2, 'This is a test comment on test user''s status', 1, 0, '2015-04-20 18:49:37', '2015-04-20 18:49:37'),
(9, 7, 5, 'Hey It is Prakhar', 1, 0, '2015-04-20 18:56:39', '2015-04-20 18:56:39'),
(10, 7, 6, 'Same Here', 1, 0, '2015-04-20 18:56:50', '2015-04-20 18:56:50');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first` varchar(100) DEFAULT NULL,
  `last` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `notes` text,
  `live` tinyint(4) DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `password` (`password`),
  KEY `live` (`live`),
  KEY `deleted` (`deleted`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first`, `last`, `email`, `password`, `notes`, `live`, `deleted`, `created`, `modified`) VALUES
(2, 'Hemant', 'Mann', 'hemant@gmail.com', 'hemantmann', NULL, 1, 0, '2015-04-18 12:39:40', '2015-04-18 20:11:03'),
(5, 'Test', 'User', 'test@yahoo.in', 'abcdefgh', NULL, 1, 0, '2015-04-18 12:00:04', '2015-04-18 13:35:03'),
(7, 'Prakhar', 'Sandhu', 'prakhar@outlook.com', 'abcdefgh', NULL, 1, 0, '2015-04-18 21:08:21', '2015-04-18 21:08:21');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
