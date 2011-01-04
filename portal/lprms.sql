-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 05, 2011 at 12:22 AM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lprms_yii`
--

-- --------------------------------------------------------

--
-- Table structure for table `area_location`
--

CREATE TABLE IF NOT EXISTS `area_location` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `address1` varchar(32) NOT NULL,
  `address2` varchar(32) NOT NULL,
  `city` varchar(32) NOT NULL,
  `state` varchar(32) NOT NULL,
  `zip` int(5) unsigned zerofill NOT NULL DEFAULT '00000',
  `country` varchar(32) NOT NULL,
  `floor` varchar(32) NOT NULL,
  `room` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `area_location`
--

INSERT INTO `area_location` (`id`, `name`, `address1`, `address2`, `city`, `state`, `zip`, `country`, `floor`, `room`) VALUES
(1, 'SIUC Student Center', '1255 Lincoln Drive', '', 'Carbondale', 'Illinois', 62901, 'USA', '2nd Floor', 'Ballrooms'),
(2, 'SIUC Grinnell Hall', '', '', 'Carbondale', 'Illinois', 62901, 'USA', 'Basement', '');

-- --------------------------------------------------------

--
-- Table structure for table `area_map`
--

CREATE TABLE IF NOT EXISTS `area_map` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `xml` varchar(32) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `area_map`
--

INSERT INTO `area_map` (`id`, `xml`, `type`) VALUES
(1, 'uploads/xml/siucstdctr.xml', 0),
(2, 'uploads/xml/siucgrinnell.xml', 0),
(3, 'content/map/2/floorplan.xml', 0);

-- --------------------------------------------------------

--
-- Table structure for table `event_attendee_type`
--

CREATE TABLE IF NOT EXISTS `event_attendee_type` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `prefix` varchar(2) NOT NULL,
  `description` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `event_attendee_type`
--

INSERT INTO `event_attendee_type` (`id`, `prefix`, `description`) VALUES
(1, 'GM', 'General Manager'),
(2, 'ST', 'Staff'),
(3, 'SP', 'Speaker'),
(4, 'WI', 'Walk-in'),
(5, 'PR', 'Pre-registered'),
(6, 'DS', 'Booth');

-- --------------------------------------------------------

--
-- Table structure for table `event_main`
--

CREATE TABLE IF NOT EXISTS `event_main` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `sanitized` varchar(32) NOT NULL,
  `datetime_start` datetime NOT NULL,
  `datetime_end` datetime NOT NULL,
  `price` decimal(5,2) NOT NULL DEFAULT '0.00',
  `id_location` int(10) unsigned DEFAULT NULL,
  `id_map` int(10) unsigned DEFAULT NULL,
  `capacity` int(10) unsigned NOT NULL DEFAULT '0',
  `information` text NOT NULL,
  `reminder` text NOT NULL,
  `agreement` text NOT NULL,
  `min_age` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sanitized` (`sanitized`),
  KEY `id_location` (`id_location`),
  KEY `id_map` (`id_map`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `event_main`
--

INSERT INTO `event_main` (`id`, `name`, `sanitized`, `datetime_start`, `datetime_end`, `price`, `id_location`, `id_map`, `capacity`, `information`, `reminder`, `agreement`, `min_age`) VALUES
(1, 'SalukiLAN 2009', 'salukilan2009', '2009-10-03 10:00:00', '2009-10-04 17:00:00', '0.00', 2, NULL, 120, '', '', '', 0),
(2, 'SalukiLAN 2010', 'salukilan2010', '2010-05-01 10:00:00', '2010-05-02 17:00:00', '0.00', 1, 3, 180, 'The Venue this year is bigger and better than ever! We''re taking up all the Ballrooms, which gives us enough room for 170 PC gamers, and 50-60 console gamers, with a spacious lounge for movies, sleeping, or just hanging out. We''ve got a lot of room, so be sure to invite all your friends this year!\r\n\r\nIf you would like to participate in the LAN event, please bring the following:\r\n\r\n1. your computer (includes tower, monitor, keyboard, mouse, cables, software, games, headphones, etc...)\r\n2. a great attitude\r\n\r\nPlease do not bring:\r\n- UPS Backups\r\n- powered speakers\r\n\r\nFor console people:\r\n- bringing your personal controller for your Xbox 360 or PS3 is highly recommended.\r\n- if you would like to, you may bring your console system.  Chances are someone may want to play a multi player game as well.\r\n-  you are encouraged to bring your own TV as well, just remember that all your equipment is your responsibility.\r\n\r\nWhat we will provide:\r\n-  Tables and chairs\r\n-  Highspeed Network\r\n-  University security provided by Saluki Patrol and SIUC''s Campus Police', '', '', 16),
(3, 'SalukiLAN 2010 Beta', 'salukilan2010b', '2010-09-04 12:00:00', '2010-09-05 12:00:00', '0.00', NULL, NULL, 180, '', '', '', 16);

-- --------------------------------------------------------

--
-- Table structure for table `event_prize`
--

CREATE TABLE IF NOT EXISTS `event_prize` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_photo` int(10) unsigned DEFAULT NULL,
  `name` varchar(32) NOT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  `id_event` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_photo` (`id_photo`),
  KEY `id_event` (`id_event`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `event_prize`
--


-- --------------------------------------------------------

--
-- Table structure for table `event_status`
--

CREATE TABLE IF NOT EXISTS `event_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_ref` int(10) unsigned DEFAULT NULL,
  `checkin` datetime NOT NULL,
  `checkout` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_ref` (`id_ref`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `event_status`
--


-- --------------------------------------------------------

--
-- Table structure for table `event_team`
--

CREATE TABLE IF NOT EXISTS `event_team` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `sanitized` varchar(32) NOT NULL,
  `id_captain` int(10) unsigned NOT NULL DEFAULT '0',
  `size` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sanitized` (`sanitized`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `event_team`
--

INSERT INTO `event_team` (`id`, `name`, `sanitized`, `id_captain`, `size`) VALUES
(1, 'Scorpion Stingers', 'stingers', 18, 0),
(2, 'Crazy Cuckoos', 'cuckoos', 24, 0);

-- --------------------------------------------------------

--
-- Table structure for table `game_match`
--

CREATE TABLE IF NOT EXISTS `game_match` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tournament` int(10) unsigned DEFAULT NULL,
  `tree_position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `team` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `id_game` int(10) unsigned DEFAULT NULL,
  `id_platform` tinyint(3) unsigned DEFAULT NULL,
  `id_type` int(10) unsigned DEFAULT NULL,
  `id_winner` int(10) unsigned DEFAULT NULL,
  `host` varchar(64) DEFAULT NULL,
  `lobby` int(10) unsigned NOT NULL DEFAULT '10',
  `datetime_start` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `capacity` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `id_owner` int(10) unsigned DEFAULT NULL,
  `hostname` varchar(32) DEFAULT NULL,
  `id_event` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tournament` (`id_tournament`),
  KEY `id_game` (`id_game`),
  KEY `id_type` (`id_type`),
  KEY `id_winner` (`id_winner`),
  KEY `id_owner` (`id_owner`),
  KEY `id_event` (`id_event`),
  KEY `id_platform` (`id_platform`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `game_match`
--

INSERT INTO `game_match` (`id`, `id_tournament`, `tree_position`, `team`, `id_game`, `id_platform`, `id_type`, `id_winner`, `host`, `lobby`, `datetime_start`, `capacity`, `id_owner`, `hostname`, `id_event`) VALUES
(15, 1, 0, 1, NULL, NULL, NULL, NULL, '', 10, '1970-01-01 00:00:00', 2, NULL, '', NULL),
(16, 1, 1, 1, NULL, NULL, NULL, NULL, '', 10, '1970-01-01 00:00:00', 2, NULL, '', NULL),
(17, 1, 2, 1, NULL, NULL, NULL, NULL, '', 10, '1970-01-01 00:00:00', 2, NULL, '', NULL),
(18, 1, 3, 1, NULL, NULL, NULL, NULL, '', 10, '1970-01-01 00:00:00', 2, NULL, '', NULL),
(19, 1, 4, 1, NULL, NULL, NULL, NULL, '', 10, '1970-01-01 00:00:00', 2, NULL, '', NULL),
(20, 1, 5, 1, NULL, NULL, NULL, NULL, '', 10, '1970-01-01 00:00:00', 2, NULL, '', NULL),
(21, 1, 6, 1, NULL, NULL, NULL, NULL, '', 10, '1970-01-01 00:00:00', 2, NULL, '', NULL),
(22, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 10, '1970-01-01 00:00:00', 0, NULL, NULL, NULL),
(23, NULL, 0, 1, NULL, NULL, NULL, NULL, NULL, 10, '1970-01-01 00:00:00', 0, NULL, NULL, NULL),
(24, 2, 0, 0, NULL, NULL, NULL, NULL, '', 10, '1970-01-01 00:00:00', 2, NULL, '', NULL),
(25, 2, 1, 0, NULL, NULL, NULL, NULL, '', 10, '1970-01-01 00:00:00', 2, NULL, '', NULL),
(26, 2, 2, 0, NULL, NULL, NULL, NULL, '', 10, '1970-01-01 00:00:00', 2, NULL, '', NULL),
(27, 2, 3, 0, NULL, NULL, NULL, NULL, '', 10, '1970-01-01 00:00:00', 2, NULL, '', NULL),
(28, 2, 4, 0, NULL, NULL, NULL, NULL, '', 10, '1970-01-01 00:00:00', 2, NULL, '', NULL),
(29, 2, 5, 0, NULL, NULL, NULL, NULL, '', 10, '1970-01-01 00:00:00', 2, NULL, '', NULL),
(30, 2, 6, 0, NULL, NULL, NULL, NULL, '', 10, '1970-01-01 00:00:00', 2, NULL, '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `game_name`
--

CREATE TABLE IF NOT EXISTS `game_name` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `image` varchar(128) NOT NULL,
  `id_steam` int(10) unsigned NOT NULL DEFAULT '0',
  `id_xfire` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `game_name`
--

INSERT INTO `game_name` (`id`, `name`, `image`, `id_steam`, `id_xfire`) VALUES
(1, 'Left 4 Dead', 'common/img/icons/games/l4d.png', 500, 'l4d'),
(2, 'Team Fortress 2', 'common/img/icons/games/tf2.png', 440, 'tf2');

-- --------------------------------------------------------

--
-- Table structure for table `game_platform`
--

CREATE TABLE IF NOT EXISTS `game_platform` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `image` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `game_platform`
--

INSERT INTO `game_platform` (`id`, `name`, `image`) VALUES
(1, 'PC', 'common/img/icons/platforms/pc.png'),
(2, 'Playstation 3', 'common/img/icons/platforms/ps3.png'),
(3, 'XBox 360', 'common/img/icons/platforms/xbox360.png');

-- --------------------------------------------------------

--
-- Table structure for table `game_tournament`
--

CREATE TABLE IF NOT EXISTS `game_tournament` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `sanitized` varchar(32) DEFAULT NULL,
  `rounds` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `id_game` int(10) unsigned DEFAULT NULL,
  `id_type` int(10) unsigned DEFAULT NULL,
  `team` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `id_owner` int(10) unsigned DEFAULT NULL,
  `id_event` int(10) unsigned DEFAULT NULL,
  `started` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sanitized` (`sanitized`),
  KEY `id_game` (`id_game`),
  KEY `id_type` (`id_type`),
  KEY `id_owner` (`id_owner`),
  KEY `id_event` (`id_event`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `game_tournament`
--

INSERT INTO `game_tournament` (`id`, `name`, `sanitized`, `rounds`, `id_game`, `id_type`, `team`, `id_owner`, `id_event`, `started`) VALUES
(1, 'Sample Tournament', 'sample', 3, NULL, NULL, 1, NULL, NULL, 0),
(2, 'test', 'test', 3, NULL, NULL, 0, NULL, NULL, 0),
(3, 'test1', 'test1', 0, NULL, NULL, 1, NULL, NULL, 0),
(4, 'test13', 'test31', 0, NULL, NULL, 1, NULL, NULL, 0),
(5, 'test132', 'test321', 0, NULL, NULL, 1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `game_type`
--

CREATE TABLE IF NOT EXISTS `game_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prefix` varchar(2) DEFAULT NULL,
  `description` varchar(64) DEFAULT NULL,
  `team` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `game_type`
--


-- --------------------------------------------------------

--
-- Table structure for table `profile_role`
--

CREATE TABLE IF NOT EXISTS `profile_role` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_mod` tinyint(1) NOT NULL DEFAULT '0',
  `is_poster` tinyint(1) NOT NULL DEFAULT '0',
  `is_media` tinyint(1) NOT NULL DEFAULT '0',
  `is_events` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `profile_role`
--

INSERT INTO `profile_role` (`id`, `name`, `is_active`, `is_admin`, `is_mod`, `is_poster`, `is_media`, `is_events`) VALUES
(1, 'Administrator', 1, 1, 1, 1, 1, 1),
(2, 'User', 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `profile_steam`
--

CREATE TABLE IF NOT EXISTS `profile_steam` (
  `id_username` varchar(64) NOT NULL,
  `id_numeric` bigint(20) unsigned NOT NULL DEFAULT '0',
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `display` varchar(64) NOT NULL DEFAULT 'Unknown',
  `realname` varchar(64) NOT NULL DEFAULT 'Unknown',
  `online` tinyint(1) NOT NULL,
  `state` varchar(32) NOT NULL DEFAULT 'Offline',
  `iconFull` varchar(512) NOT NULL DEFAULT '',
  `iconMedium` varchar(512) NOT NULL DEFAULT '',
  `icon` varchar(512) NOT NULL DEFAULT '',
  `headline` varchar(512) NOT NULL DEFAULT '',
  `summary` varchar(512) NOT NULL DEFAULT '',
  `rating` float(5,2) NOT NULL DEFAULT '0.00',
  `valid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_numeric` (`id_numeric`),
  UNIQUE KEY `id_username` (`id_username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile_steam`
--

INSERT INTO `profile_steam` (`id_username`, `id_numeric`, `id`, `display`, `realname`, `online`, `state`, `iconFull`, `iconMedium`, `icon`, `headline`, `summary`, `rating`, `valid`) VALUES
('Admin', 76561197978866368, 1, 'Kuzum', '', 0, 'Last Online: 2 hrs 15 mins ago', 'http://media.steampowered.com/steamcommunity/public/images/avatars/16/16b5ababba729e16d3f9009888d80387b7781097_full.jpg', 'http://media.steampowered.com/steamcommunity/public/images/avatars/16/16b5ababba729e16d3f9009888d80387b7781097_medium.jpg', 'http://media.steampowered.com/steamcommunity/public/images/avatars/16/16b5ababba729e16d3f9009888d80387b7781097.jpg', 'Im Teh Awesome', ' Im Awsome :D<br /><br /><br />I clean up my friends list quite often so if you noticed that i deleted you and you still want to have me on ur list re-add me ill always accept', 10.00, 1),
('worldwise001', 76561198005326847, 28, 'Sabriel', 'Sabriel', 0, 'Last Online: 3 days ago', 'http://media.steampowered.com/steamcommunity/public/images/avatars/44/444d6ec7ed7c848ef9189c219444bc81db467203_full.jpg', 'http://media.steampowered.com/steamcommunity/public/images/avatars/44/444d6ec7ed7c848ef9189c219444bc81db467203_medium.jpg', 'http://media.steampowered.com/steamcommunity/public/images/avatars/44/444d6ec7ed7c848ef9189c219444bc81db467203.jpg', '', 'No information given.', 3.10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `profile_user`
--

CREATE TABLE IF NOT EXISTS `profile_user` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(24) NOT NULL,
  `last_name` varchar(24) NOT NULL,
  `email` varchar(64) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `phone` bigint(20) unsigned NOT NULL DEFAULT '0',
  `birthday` date NOT NULL,
  `gamertag` varchar(64) NOT NULL,
  `blurb` text NOT NULL,
  `id_role` tinyint(3) unsigned DEFAULT NULL,
  `datetime_join` datetime NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hash` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `confirm` (`hash`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `profile_user`
--

INSERT INTO `profile_user` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `phone`, `birthday`, `gamertag`, `blurb`, `id_role`, `datetime_join`, `active`, `hash`) VALUES
(1, 'John', 'Doe', 'admin@localhost', 'admin', '6f19be0c391a924c2345dde2dcf3320b', 4806205736, '0000-00-00', 'Admin', 'The Administrator!', 1, '0000-00-00 00:00:00', 1, '748d6b6ed8e13f857ceaa6cfbdca14b8'),
(28, 'Sarah', 'Harvey', 'worldwise001@gmail.com', 'worldwise001', 'd10937264ae407b0ec7358f741188ab1', 4806205736, '1990-06-03', 'Sabriel', '', NULL, '2010-04-02 04:53:54', 1, '80e4db376fd0b96b026c409363e1714d');

-- --------------------------------------------------------

--
-- Table structure for table `profile_xfire`
--

CREATE TABLE IF NOT EXISTS `profile_xfire` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `username` varchar(512) NOT NULL,
  `display` varchar(512) NOT NULL DEFAULT '',
  `realname` varchar(512) NOT NULL DEFAULT '',
  `online` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `icon` varchar(512) NOT NULL DEFAULT '',
  `valid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile_xfire`
--

INSERT INTO `profile_xfire` (`id`, `username`, `display`, `realname`, `online`, `icon`, `valid`) VALUES
(1, 'admin', '', '', 0, 'http://media.xfire.com/xfire/xf/images/avatars/gallery/default/xfire100.jpg', 1),
(28, 'worldwise001', 'Sabriel', 'http://alpha.0x08.org', 0, 'http://screenshot.xfire.com/avatar/worldwise001.jpg?874', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ref_player_match`
--

CREATE TABLE IF NOT EXISTS `ref_player_match` (
  `id_player` int(10) unsigned NOT NULL DEFAULT '0',
  `id_match` int(10) unsigned NOT NULL DEFAULT '0',
  `team` tinyint(1) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `id_player` (`id_player`,`id_match`),
  KEY `id_match` (`id_match`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_player_match`
--

INSERT INTO `ref_player_match` (`id_player`, `id_match`, `team`) VALUES
(1, 24, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ref_user_event`
--

CREATE TABLE IF NOT EXISTS `ref_user_event` (
  `id` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL DEFAULT '0',
  `id_event` int(10) unsigned NOT NULL DEFAULT '0',
  `seat` varchar(4) NOT NULL,
  `id_designation` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_user` (`id_user`,`id_event`),
  KEY `id_designation` (`id_designation`),
  KEY `id_event` (`id_event`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_user_event`
--

INSERT INTO `ref_user_event` (`id`, `id_user`, `id_event`, `seat`, `id_designation`) VALUES
(3, 28, 2, '401', 2),
(59, 1, 2, '', 4);

-- --------------------------------------------------------

--
-- Table structure for table `ref_user_team`
--

CREATE TABLE IF NOT EXISTS `ref_user_team` (
  `id_user` int(10) unsigned NOT NULL DEFAULT '0',
  `id_team` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `id_user` (`id_user`,`id_team`),
  KEY `id_team` (`id_team`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_user_team`
--


-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `cat` varchar(32) NOT NULL DEFAULT 'config',
  `key` varchar(32) NOT NULL,
  `value` varchar(256) DEFAULT NULL,
  UNIQUE KEY `cat` (`cat`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`cat`, `key`, `value`) VALUES
('config', 'name', 'SalukiLAN Portal'),
('config', 'theme', 'default'),
('config', 'timezone', 'America/Chicago'),
('config', 'url', 'http://salukilan.tk'),
('facebook', 'id', '185130289324'),
('facebook', 'name', 'salukilan'),
('myspace', 'username', 'salukilan'),
('steam', 'name', 'salukilan'),
('twitter', 'username', 'salukilan'),
('xfire', 'name', 'salukilan');

-- --------------------------------------------------------

--
-- Table structure for table `web_album`
--

CREATE TABLE IF NOT EXISTS `web_album` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_event` int(10) unsigned DEFAULT NULL,
  `name` varchar(32) NOT NULL,
  `is_slideshow` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `id_user` int(10) unsigned DEFAULT NULL,
  `user_submitted` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_event` (`id_event`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `web_album`
--

INSERT INTO `web_album` (`id`, `id_event`, `name`, `is_slideshow`, `id_user`, `user_submitted`) VALUES
(1, NULL, 'Uncategorized', 0, NULL, 0),
(2, NULL, 'slideshow', 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `web_comments`
--

CREATE TABLE IF NOT EXISTS `web_comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `author` varchar(32) NOT NULL,
  `email` varchar(64) NOT NULL,
  `timestamp` datetime NOT NULL,
  `id_news` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `web_comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `web_image`
--

CREATE TABLE IF NOT EXISTS `web_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_album` int(10) unsigned DEFAULT NULL,
  `file` varchar(128) NOT NULL,
  `title` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_album` (`id_album`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `web_image`
--

INSERT INTO `web_image` (`id`, `id_album`, `file`, `title`) VALUES
(1, NULL, 'uploads/sponsor/nvidia.jpg', 'nVidia Logo'),
(2, NULL, 'uploads/sponsor/intel.jpg', 'Intel Logo'),
(3, NULL, 'uploads/sponsor/acm.jpg', 'ACM Logo'),
(4, 2, 'uploads/gallery/2/SLf09_0044.JPG', NULL),
(5, 2, 'uploads/gallery/2/SLf09_0049.JPG', NULL),
(6, 2, 'uploads/gallery/2/SLf09_0051.JPG', NULL),
(7, 2, 'uploads/gallery/2/SLf09_0062.JPG', NULL),
(8, 2, 'uploads/gallery/2/SLf09_0069.JPG', NULL),
(9, 2, 'uploads/gallery/2/SLf09_0070.JPG', NULL),
(10, 2, 'uploads/gallery/2/SLf09_0074.JPG', NULL),
(11, 2, 'uploads/gallery/2/SLf09_0087.JPG', NULL),
(12, 2, 'uploads/gallery/2/SLf09_0094.JPG', NULL),
(13, NULL, 'uploads/teams/ad93baaaaa4406bcbbbac7bd0342d474.png', NULL),
(14, NULL, 'uploads/teams/ad93be9cbf4406bcb8dac7bd0342d474.png', NULL),
(15, NULL, 'uploads/teams/ce57be9cbf4406bcb8d2e7bd0342d474.png', NULL),
(16, NULL, 'uploads/teams/ce57be9cbf4406bcb8d2e7bd0342d474.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `web_news`
--

CREATE TABLE IF NOT EXISTS `web_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned DEFAULT NULL,
  `title` varchar(64) NOT NULL,
  `content` text NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `web_news`
--

INSERT INTO `web_news` (`id`, `id_user`, `title`, `content`, `timestamp`) VALUES
(1, 1, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget nisl at nisl porta luctus eu et sapien. Nunc arcu diam, tincidunt sed euismod et, ornare non mauris. Pellentesque nulla nisi, mattis a convallis in, vestibulum nec sapien. Integer molestie sollicitudin pharetra. Donec at erat sit amet sem aliquet porta sed non leo. Etiam ut justo a dolor aliquam aliquet sit amet ac arcu. Cras blandit malesuada ipsum nec consectetur. Nam sed quam quam. Pellentesque varius, quam a lobortis pulvinar, nisi lectus sollicitudin nulla, et dignissim nisi tortor sed nunc. Nunc ipsum dui, molestie congue convallis eget, scelerisque posuere lacus. Pellentesque sit amet risus quam. Nullam faucibus placerat felis vel faucibus.\r\n\r\nSed dignissim gravida ultricies. In in egestas nisl. Sed elit libero, convallis feugiat aliquet vel, blandit ut augue. Mauris vel porttitor tellus. Donec mauris eros, blandit vel sagittis non, posuere in nisi. Curabitur quis ante ante, a placerat libero. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed ut lacus magna, vitae vulputate purus. Pellentesque mollis iaculis vulputate. Nullam id viverra augue. Aliquam nisl velit, adipiscing ac egestas nec, tempor ut tellus. Integer quis erat ac risus pulvinar bibendum sed id purus. Quisque ornare pulvinar odio, nec tincidunt ligula faucibus eu. Integer a hendrerit eros. Nulla eget est lectus.\r\n\r\nMaecenas malesuada hendrerit mattis. Nam nibh sapien, lacinia nec vehicula suscipit, venenatis ac purus. Curabitur elit dui, convallis vel sagittis mattis, fringilla ut dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Suspendisse eleifend scelerisque faucibus. Fusce eleifend ultrices mauris et vulputate. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis augue urna, ullamcorper at fermentum et, commodo nec tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla condimentum malesuada commodo. Donec leo est, vestibulum sit amet tincidunt et, dictum vitae tortor. Sed mattis gravida nisl non gravida. Morbi volutpat tincidunt tristique. In mauris justo, blandit id suscipit ac, tempus vel odio. Aliquam id purus nulla, id commodo erat. Quisque vel sapien id augue convallis viverra.', '2010-02-28 17:07:38'),
(2, 1, 'Nullam', 'Suspendisse tellus mauris, mattis sodales tristique semper, suscipit ac leo. Vivamus eget metus nec justo porta tempor. Pellentesque urna lorem, volutpat ut sodales sed, consequat vitae nulla. Nullam nec nibh odio, sit amet fermentum libero. Fusce lectus orci, semper sit amet bibendum ullamcorper, lacinia nec turpis. Fusce varius orci ac odio mattis nec condimentum elit condimentum. Nullam eu quam a nunc congue viverra. Nulla non risus ligula, id sagittis purus. Nullam posuere mauris at diam lobortis eu sodales orci hendrerit. Integer vestibulum dapibus elit, rhoncus venenatis lorem dapibus ut.', '2010-02-28 17:08:16');

-- --------------------------------------------------------

--
-- Table structure for table `web_sponsor`
--

CREATE TABLE IF NOT EXISTS `web_sponsor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `id_photo` int(10) unsigned DEFAULT NULL,
  `website` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_photo` (`id_photo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `web_sponsor`
--

INSERT INTO `web_sponsor` (`id`, `name`, `id_photo`, `website`) VALUES
(1, 'nVidia', 1, 'http://www.nvidia.com'),
(2, 'Intel', 2, 'http://www.intel.com'),
(3, 'Association for Computing Machinery', 3, 'http://acm.rso.siuc.edu');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_main`
--
ALTER TABLE `event_main`
  ADD CONSTRAINT `event_main_ibfk_2` FOREIGN KEY (`id_map`) REFERENCES `area_map` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `event_main_ibfk_1` FOREIGN KEY (`id_location`) REFERENCES `area_location` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `event_prize`
--
ALTER TABLE `event_prize`
  ADD CONSTRAINT `event_prize_ibfk_2` FOREIGN KEY (`id_event`) REFERENCES `event_main` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `event_prize_ibfk_1` FOREIGN KEY (`id_photo`) REFERENCES `web_image` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `event_status`
--
ALTER TABLE `event_status`
  ADD CONSTRAINT `event_status_ibfk_1` FOREIGN KEY (`id_ref`) REFERENCES `ref_user_event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `game_match`
--
ALTER TABLE `game_match`
  ADD CONSTRAINT `game_match_ibfk_7` FOREIGN KEY (`id_platform`) REFERENCES `game_platform` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_match_ibfk_1` FOREIGN KEY (`id_tournament`) REFERENCES `game_tournament` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_match_ibfk_2` FOREIGN KEY (`id_game`) REFERENCES `game_name` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_match_ibfk_3` FOREIGN KEY (`id_type`) REFERENCES `game_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_match_ibfk_4` FOREIGN KEY (`id_winner`) REFERENCES `profile_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_match_ibfk_5` FOREIGN KEY (`id_owner`) REFERENCES `profile_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_match_ibfk_6` FOREIGN KEY (`id_event`) REFERENCES `event_main` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `game_tournament`
--
ALTER TABLE `game_tournament`
  ADD CONSTRAINT `game_tournament_ibfk_4` FOREIGN KEY (`id_event`) REFERENCES `event_main` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_tournament_ibfk_1` FOREIGN KEY (`id_game`) REFERENCES `game_name` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_tournament_ibfk_2` FOREIGN KEY (`id_type`) REFERENCES `game_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `game_tournament_ibfk_3` FOREIGN KEY (`id_owner`) REFERENCES `profile_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `profile_steam`
--
ALTER TABLE `profile_steam`
  ADD CONSTRAINT `profile_steam_ibfk_1` FOREIGN KEY (`id`) REFERENCES `profile_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `profile_user`
--
ALTER TABLE `profile_user`
  ADD CONSTRAINT `profile_user_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `profile_role` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `profile_xfire`
--
ALTER TABLE `profile_xfire`
  ADD CONSTRAINT `profile_xfire_ibfk_1` FOREIGN KEY (`id`) REFERENCES `profile_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ref_player_match`
--
ALTER TABLE `ref_player_match`
  ADD CONSTRAINT `ref_player_match_ibfk_1` FOREIGN KEY (`id_match`) REFERENCES `game_match` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ref_player_match_ibfk_2` FOREIGN KEY (`id_player`) REFERENCES `profile_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ref_user_event`
--
ALTER TABLE `ref_user_event`
  ADD CONSTRAINT `ref_user_event_ibfk_3` FOREIGN KEY (`id_designation`) REFERENCES `event_attendee_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ref_user_event_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `profile_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ref_user_event_ibfk_2` FOREIGN KEY (`id_event`) REFERENCES `event_main` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ref_user_team`
--
ALTER TABLE `ref_user_team`
  ADD CONSTRAINT `ref_user_team_ibfk_2` FOREIGN KEY (`id_team`) REFERENCES `event_team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ref_user_team_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `profile_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `web_album`
--
ALTER TABLE `web_album`
  ADD CONSTRAINT `web_album_ibfk_4` FOREIGN KEY (`id_user`) REFERENCES `profile_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `web_album_ibfk_3` FOREIGN KEY (`id_event`) REFERENCES `event_main` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `web_image`
--
ALTER TABLE `web_image`
  ADD CONSTRAINT `web_image_ibfk_1` FOREIGN KEY (`id_album`) REFERENCES `web_album` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `web_news`
--
ALTER TABLE `web_news`
  ADD CONSTRAINT `web_news_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `profile_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `web_sponsor`
--
ALTER TABLE `web_sponsor`
  ADD CONSTRAINT `web_sponsor_ibfk_1` FOREIGN KEY (`id_photo`) REFERENCES `web_image` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
