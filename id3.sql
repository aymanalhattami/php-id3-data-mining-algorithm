-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2017 at 07:41 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id3`
--

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `weathers`
--

DROP TABLE IF EXISTS `weathers`;
CREATE TABLE IF NOT EXISTS `weathers` (
  `Day` varchar(4) NOT NULL,
  `Outlook` varchar(10) NOT NULL,
  `Temperature` varchar(10) NOT NULL,
  `Humidity` varchar(10) NOT NULL,
  `Wind` varchar(10) NOT NULL,
  `Play` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `weathers`
--

INSERT INTO `weathers` (`Day`, `Outlook`, `Temperature`, `Humidity`, `Wind`, `Play`) VALUES
('D1', 'sunny', 'hot', 'high', 'weak', 'no'),
('D2', 'sunny', 'hot', 'high', 'strong', 'no'),
('D3', 'overcast', 'hot', 'high', 'weak', 'yes'),
('D4', 'rain', 'mild', 'high', 'weak', 'yes'),
('D5', 'rain', 'cool', 'normal', 'weak', 'yes'),
('D6', 'rain', 'cool', 'normal', 'strong', 'no'),
('D7', 'overcast', 'cool', 'normal', 'strong', 'yes'),
('D8', 'sunny', 'mild', 'high', 'weak', 'no'),
('D9', 'sunny', 'cool', 'normal', 'weak', 'yes'),
('D10', 'rain', 'mild', 'normal', 'weak', 'yes'),
('D11', 'sunny', 'mild', 'normal', 'strong', 'yes'),
('D12', 'overcast', 'mild', 'high', 'strong', 'yes'),
('D13', 'overcast', 'hot', 'normal', 'weak', 'yes'),
('D14', 'rain', 'mild', 'high', 'strong', 'no');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
