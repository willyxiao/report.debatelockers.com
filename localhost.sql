-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 08, 2012 at 09:54 PM
-- Server version: 5.5.28
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `final`
--
CREATE DATABASE `final` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `final`;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `school_id` int(10) unsigned NOT NULL,
  `tournament_id` int(10) unsigned NOT NULL,
  `attend_on` int(11) DEFAULT '1',
  `attend_del` int(11) DEFAULT '0',
  PRIMARY KEY (`school_id`,`tournament_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`school_id`, `tournament_id`, `attend_on`, `attend_del`) VALUES
(1, 1, 1, 0),
(1, 7, 1, 1),
(3, 0, 1, 0),
(3, 1, 1, 0),
(3, 6, 0, 0),
(3, 7, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `email_updates`
--

CREATE TABLE IF NOT EXISTS `email_updates` (
  `school_id` int(10) unsigned NOT NULL,
  `email_email` char(30) NOT NULL,
  `email_on` int(11) DEFAULT '1',
  `team_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_updates`
--

INSERT INTO `email_updates` (`school_id`, `email_email`, `email_on`, `team_id`) VALUES
(3, 'willy@chenxiao.us', 0, 0),
(3, 'willyxiao.debate@gmail.com', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

CREATE TABLE IF NOT EXISTS `judges` (
  `judge_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `judge_first` varchar(20) NOT NULL,
  `judge_last` varchar(20) NOT NULL,
  PRIMARY KEY (`judge_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`judge_id`, `judge_first`, `judge_last`) VALUES
(1, 'SARA', 'KIRSCH'),
(2, 'JENNY', 'HEIDT'),
(3, 'DAVID', 'HEIDT'),
(4, 'ELLI', 'KUENZEL'),
(5, 'DAVID', 'HERMAN'),
(6, 'DAVID', 'NEUSTADT'),
(7, 'ANDREW', 'BAKER'),
(8, 'CALUM', 'MATHESON'),
(9, 'MAGGIE', 'DAVIS'),
(10, 'SHERRY', 'HALL'),
(11, 'DALLAS', 'PERKINS'),
(13, 'SAM', 'SHORE'),
(14, 'DANIEL', 'XIAO'),
(15, 'DANA', 'RANDALL'),
(16, 'JEREMY', 'HAMMOND');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `report_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(10) unsigned NOT NULL,
  `team_id` int(10) unsigned NOT NULL,
  `tournament_id` int(10) unsigned NOT NULL,
  `round_num` int(10) unsigned NOT NULL,
  `report_side` int(11) NOT NULL,
  `report_opp` varchar(40) NOT NULL,
  `report_result` int(11) NOT NULL,
  `judge_id` int(10) unsigned NOT NULL,
  `judge1_id` int(10) unsigned DEFAULT NULL,
  `judge2_id` int(10) unsigned DEFAULT NULL,
  `judge3_id` int(10) unsigned DEFAULT NULL,
  `judge4_id` int(10) unsigned DEFAULT NULL,
  `report_aff` text NOT NULL,
  `report_1nc` text NOT NULL,
  `report_2nc` text NOT NULL,
  `report_1nr` text NOT NULL,
  `report_2nr` text NOT NULL,
  `report_aff_strat` text NOT NULL,
  `report_comments` text NOT NULL,
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `school_id`, `team_id`, `tournament_id`, `round_num`, `report_side`, `report_opp`, `report_result`, `judge_id`, `judge1_id`, `judge2_id`, `judge3_id`, `judge4_id`, `report_aff`, `report_1nc`, `report_2nc`, `report_1nr`, `report_2nr`, `report_aff_strat`, `report_comments`) VALUES
(4, 3, 7, 7, 2, 1, 'WESTMINSTER HX', 2, 4, NULL, NULL, NULL, NULL, 'lakjsd;lkjf', 'lkajsdl;jf', 'kajlfdjflkj', 'dlkadflkajf', 'lkjladkjf', 'lakjdsflj', 'alkjdlkfj'),
(7, 3, 7, 7, 1, 1, 'TEST TEST', 2, 3, NULL, NULL, NULL, NULL, 'd', 'd', 'd', 'd', 'd', 'd', 'd'),
(10, 3, 6, 6, 3, 1, 'TEST1 TEST1', 1, 3, NULL, NULL, NULL, NULL, 'd', 'd', 'd', 'd', 'd', 'testing', 'd\r\n'),
(11, 3, 8, 6, 2, 1, 'TEST TEST', 1, 7, NULL, NULL, NULL, NULL, 'd', 'd', 'd', 'd', 'testing!', 'd', 'd'),
(29, 3, 5, 7, 102, 1, 'TOM TOM', 1, 3, NULL, NULL, NULL, NULL, 'd', 'd', 'd', 'd', 'd', 'd', 'ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd\r\naaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),
(30, 3, 13, 7, 8, 1, 'WILLY XIAO', 1, 11, NULL, NULL, NULL, NULL, 'd', 'd', 'd', 'd', 'd', 'd', 'd'),
(31, 3, 7, 7, 7, 1, 'TOM TOM', 1, 2, NULL, NULL, NULL, NULL, 'this is, a test to see if ''it'' works ', 'd', 'd', 'd', 'd', 'd', 'd'),
(32, 3, 14, 1, 6, 1, 'KEVIN ESKICI', 1, 10, 3, NULL, NULL, NULL, 'd', 'd', 'd', 'd', 'd', 'd', 'd'),
(33, 3, 7, 7, 5, 1, 'DORA AVIVA', 1, 3, 2, NULL, NULL, NULL, 'd', 'd', 'd', 'd', 'd', 'd', 'd'),
(34, 3, 7, 7, 116, 2, 'WILLY XIAO', 2, 14, NULL, NULL, NULL, NULL, 'd', 'f', 'f', 'f', 'f', 'f', 'f'),
(35, 3, 5, 7, 132, 2, 'TOM HANKS', 2, 15, 16, 13, NULL, NULL, 'env monitoring', 'consult russia cp; esa cp; jobs bill ptx w/ econ impact; t-commercial; mil da\r\n', 'esa cp; warming; conflicts\r\n', 'ptx', 'ptx; case defense', 'none', '3-0. \r\nHammond: how do we get republicans on board, the ev that the neg reads says payroll taxes/infrastructure bank. Democrats gave them cover for the job blockage rather than give them power for future blockage. Most of the impact calculus wasnâ€™t in the 1ar. \r\nThey went for Obama wonâ€™t take action?\r\nWhat did the 1ar need to answer?\r\nDana Randall: large risk of the disad, they have infrastructure pass and a payroll impact, your uniqueness evidence is about jobs. Our uniqueness evidence isnâ€™t responsive to this. Elections thumper wasnâ€™t in the 2ar â€“ that wouldâ€™ve been a good uniqueness argument. \r\nTo Robel: need doesnâ€™t solve econ, also need to do quick author extensions. \r\nSam Shore: DA messes in a game-changer kind of way and itâ€™s jacked, so you canâ€™t win a larger risk of the advantage as theyâ€™re winning the DA. They read two specific disads and youâ€™re caught in the 1nc tangle w/o getting into the payroll tax and infrastructure bank debate. '),
(36, 3, 15, 7, 6, 2, 'KEVIN ESKICI', 1, 3, 2, NULL, NULL, NULL, 'd', 'd', 'd', 'd', 'd', 'd', 'd');

-- --------------------------------------------------------

--
-- Table structure for table `sms_providers`
--

CREATE TABLE IF NOT EXISTS `sms_providers` (
  `sms_provider_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sms_provider_name` char(20) NOT NULL,
  `sms_provider_email` char(25) NOT NULL,
  PRIMARY KEY (`sms_provider_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sms_providers`
--

INSERT INTO `sms_providers` (`sms_provider_id`, `sms_provider_name`, `sms_provider_email`) VALUES
(1, 'Verizon', '@vtext.com'),
(2, 'AT&T', '@text.att.net');

-- --------------------------------------------------------

--
-- Table structure for table `sms_updates`
--

CREATE TABLE IF NOT EXISTS `sms_updates` (
  `school_id` int(10) unsigned NOT NULL,
  `sms_number` bigint(20) NOT NULL,
  `sms_provider_id` int(10) unsigned DEFAULT NULL,
  `sms_on` int(11) DEFAULT '1',
  `team_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms_updates`
--

INSERT INTO `sms_updates` (`school_id`, `sms_number`, `sms_provider_id`, `sms_on`, `team_id`) VALUES
(3, 6785514386, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `team_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_id` int(10) unsigned NOT NULL,
  `team_name1` varchar(20) NOT NULL,
  `team_name2` varchar(20) NOT NULL,
  `team_on` int(10) unsigned DEFAULT '1',
  `team_del` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`team_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`team_id`, `school_id`, `team_name1`, `team_name2`, `team_on`, `team_del`) VALUES
(1, 1, 'BASCO', 'PATEL', 1, 0),
(3, 1, 'LI', 'PAVUR', 1, 1),
(4, 1, 'GALYARDT', 'YU', 1, 1),
(5, 3, 'WILLY', 'XIAO', 0, 0),
(6, 3, 'CHEN', 'YINGLIANG', 0, 1),
(7, 3, 'KAREN', 'XIAO', 0, 0),
(8, 3, 'CHEN', 'MEGAN', 1, 0),
(9, 3, 'JOHN', 'PATRICK-FINNEGAN', 0, 1),
(10, 3, 'ESKICI', 'XIAO', 1, 1),
(11, 3, 'JESUS', 'MORAN', 0, 1),
(12, 3, 'XIAO', 'YALE', 0, 0),
(13, 3, 'ANNA', 'ZHONG', 1, 1),
(14, 3, 'FINNEGAN', 'XIAO', 1, 0),
(15, 3, 'TONY', 'WINNIE', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

CREATE TABLE IF NOT EXISTS `tournaments` (
  `tournament_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tournament_name` varchar(50) NOT NULL,
  `tournament_year` year(4) NOT NULL,
  PRIMARY KEY (`tournament_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tournaments`
--

INSERT INTO `tournaments` (`tournament_id`, `tournament_name`, `tournament_year`) VALUES
(1, 'LEXINGTON', 2013),
(5, 'TOC', 2013),
(6, 'MBA', 2013),
(7, 'HARVARD_HS', 2013),
(8, 'NDT', 2013);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `school_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_name` varchar(255) NOT NULL,
  `school_hash` char(255) NOT NULL,
  PRIMARY KEY (`school_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`school_id`, `school_name`, `school_hash`) VALUES
(1, 'westminster', '$1$JFSneRCG$ktuJPDziG0U6cuoACOt8Z0'),
(3, 'test', '$1$Eog2iN5m$WY4IM7.tbfO9QsuLhQA0n.');
--
-- Database: `pset7`
--
CREATE DATABASE `pset7` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pset7`;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(10) unsigned NOT NULL,
  `symbol` varchar(7) NOT NULL,
  `shares` int(10) unsigned NOT NULL,
  `price` decimal(65,4) unsigned NOT NULL,
  `act` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `symbol`, `shares`, `price`, `act`, `time`) VALUES
(18, 'ABC', 10, '40.3300', 'Buy', '2012-11-09 02:58:36'),
(18, 'ABC', 10, '40.3300', 'Sell', '2012-11-09 02:58:47'),
(18, 'ANR', 150, '8.1500', 'Sell', '2012-11-09 02:58:54'),
(18, 'FSLR', 150, '24.1500', 'Sell', '2012-11-09 03:00:59'),
(19, 'FIO', 100, '22.9500', 'Buy', '2012-11-09 03:15:38');

-- --------------------------------------------------------

--
-- Table structure for table `holdings`
--

CREATE TABLE IF NOT EXISTS `holdings` (
  `id` int(11) NOT NULL,
  `symbol` char(6) NOT NULL,
  `shares` int(11) NOT NULL,
  PRIMARY KEY (`id`,`symbol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `holdings`
--

INSERT INTO `holdings` (`id`, `symbol`, `shares`) VALUES
(7, 'ANR', 100),
(7, 'FSLR', 100),
(19, 'FIO', 100);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `cash` decimal(65,4) unsigned NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `hash`, `cash`) VALUES
(1, 'caesar', '$1$50$GHABNWBNE/o4VL7QjmQ6x0', '10000.0000'),
(2, 'cs50', '$1$50$ceNa7BV5AoVQqilACNLuC1', '10000.0000'),
(3, 'jharvard', '$1$50$RX3wnAMNrGIbgzbRYrxM1/', '10000.0000'),
(4, 'malan', '$1$HA$azTGIMVlmPi9W9Y12cYSj/', '10000.0000'),
(5, 'nate', '$1$50$sUyTaTbiSKVPZCpjJckan0', '10000.0000'),
(6, 'rbowden', '$1$50$lJS9HiGK6sphej8c4bnbX.', '10000.0000'),
(7, 'skroob', '$1$50$euBi4ugiJmbpIbvTTfmfI.', '10000.0000'),
(8, 'tmacwilliam', '$1$50$91ya4AroFPepdLpiX.bdP1', '10000.0000'),
(9, 'zamyla', '$1$50$Suq.MOtQj51maavfKvFsW1', '10000.0000'),
(18, 'Willy', '$1$cIIzJ9bs$DtHa3CLP6X1pmqZ1Mwghu0', '10000000023381.0000'),
(19, 'Bob', '$1$EQloOBrG$6rMyy.x8x.QXaCa5BYSOL/', '7705.0000');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
