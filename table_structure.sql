-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 26, 2012 at 05:32 PM
-- Server version: 5.1.58
-- PHP Version: 5.3.6-13ubuntu3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sexsurvey`
--

-- --------------------------------------------------------

--
-- Table structure for table `sexsurvey_completers`
--

CREATE TABLE IF NOT EXISTS `sexsurvey_completers` (
  `uname` varchar(45) NOT NULL,
  UNIQUE KEY `uname_UNIQUE` (`uname`),
  KEY `uname_key` (`uname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sexsurvey_completers`
--

INSERT INTO `sexsurvey_completers` (`uname`) VALUES
('2636bd61ef64f149d991bff50ce7f99425f96f15'),
('70c881d4a26984ddce795f6f71817c9cf4480e79'),
('7e240de74fb1ed08fa08d38063f6a6a91462a815'),
('8e7dd3505df1a3aeccefc4f6670e0586b0c07207'),
('9c969ddf454079e3d439973bbab63ea6233e4087'),
('a3f60445f2031b5cd83534130eeba64cf4a0887b'),
('aaa'),
('bbbdc83d182e25b8eed22c23f261b771a2c212db'),
('dcbc8f63b06c899b9db957f0e03466860fce8056');

-- --------------------------------------------------------

--
-- Table structure for table `sexsurvey_responses`
--

CREATE TABLE IF NOT EXISTS `sexsurvey_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` longtext,
  `deptcheck` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `sexsurvey_responses`
--

INSERT INTO `sexsurvey_responses` (`id`, `data`, `deptcheck`) VALUES
(1, '{"sex":"male","age":"17","<br_\\/>\\r\\n<font_size=''1''><table_class=''xdebug-error''_dir=''ltr''_border=''1''_cellspacing=''0''_cellpadding=''1''>\\r\\n<tr><th_align=''left''_bgcolor=''#f57900''_colspan=":"hello","textbox":"aaaa","response":"Submit"}', NULL),
(2, '{"sex":"male","age":"17","<br_\\/>\\r\\n<font_size=''1''><table_class=''xdebug-error''_dir=''ltr''_border=''1''_cellspacing=''0''_cellpadding=''1''>\\r\\n<tr><th_align=''left''_bgcolor=''#f57900''_colspan=":"hello","textbox":"aaa","response":"Submit"}', NULL),
(3, '{"sex":"male","age":"17","<br_\\/>\\r\\n<font_size=''1''><table_class=''xdebug-error''_dir=''ltr''_border=''1''_cellspacing=''0''_cellpadding=''1''>\\r\\n<tr><th_align=''left''_bgcolor=''#f57900''_colspan=":"hello","textbox":"fds","response":"Submit"}', NULL),
(4, '{"sex":"male","age":"17","<br_\\/>\\r\\n<font_size=''1''><table_class=''xdebug-error''_dir=''ltr''_border=''1''_cellspacing=''0''_cellpadding=''1''>\\r\\n<tr><th_align=''left''_bgcolor=''#f57900''_colspan=":"hello","textbox":"fsd","response":"Submit"}', NULL),
(5, '{"sex":"male","age":"17","dep":"hello","textbox":"sdadasdsadsad","response":"Submit"}', NULL),
(6, '{"age":"17","dep":"hello","textbox":"","response":"Submit"}', NULL),
(7, '{"age":"17","dep":"hello","textbox":"","response":"Yes"}', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
