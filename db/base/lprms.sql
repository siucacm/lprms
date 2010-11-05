-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 08, 2010 at 09:17 AM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lprms`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache_xml_steam`
--

CREATE TABLE IF NOT EXISTS `cache_xml_steam` (
  `id` varchar(64) NOT NULL DEFAULT '',
  `id_numeric` bigint(20) unsigned NOT NULL DEFAULT '0',
  `id_user` int(10) unsigned NOT NULL DEFAULT '0',
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
  UNIQUE KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cache_xml_steam`
--

INSERT INTO `cache_xml_steam` (`id`, `id_numeric`, `id_user`, `display`, `realname`, `online`, `state`, `iconFull`, `iconMedium`, `icon`, `headline`, `summary`, `rating`, `valid`) VALUES
('Admin', 76561197978866368, 1, 'Kuzum', '', 0, 'Last Online: 2 hrs 15 mins ago', 'http://media.steampowered.com/steamcommunity/public/images/avatars/16/16b5ababba729e16d3f9009888d80387b7781097_full.jpg', 'http://media.steampowered.com/steamcommunity/public/images/avatars/16/16b5ababba729e16d3f9009888d80387b7781097_medium.jpg', 'http://media.steampowered.com/steamcommunity/public/images/avatars/16/16b5ababba729e16d3f9009888d80387b7781097.jpg', 'Im Teh Awesome', ' Im Awsome :D<br /><br /><br />I clean up my friends list quite often so if you noticed that i deleted you and you still want to have me on ur list re-add me ill always accept', 10.00, 1),
('worldwise001', 76561198005326847, 28, 'Sabriel', 'Sabriel', 0, 'Last Online: 3 days ago', 'http://media.steampowered.com/steamcommunity/public/images/avatars/44/444d6ec7ed7c848ef9189c219444bc81db467203_full.jpg', 'http://media.steampowered.com/steamcommunity/public/images/avatars/44/444d6ec7ed7c848ef9189c219444bc81db467203_medium.jpg', 'http://media.steampowered.com/steamcommunity/public/images/avatars/44/444d6ec7ed7c848ef9189c219444bc81db467203.jpg', '', 'No information given.', 3.10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cache_xml_xfire`
--

CREATE TABLE IF NOT EXISTS `cache_xml_xfire` (
  `id_user` int(10) unsigned NOT NULL DEFAULT '0',
  `id` varchar(512) NOT NULL DEFAULT '',
  `display` varchar(512) NOT NULL DEFAULT '',
  `realname` varchar(512) NOT NULL DEFAULT '',
  `online` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `icon` varchar(512) NOT NULL DEFAULT '',
  `valid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cache_xml_xfire`
--

INSERT INTO `cache_xml_xfire` (`id_user`, `id`, `display`, `realname`, `online`, `icon`, `valid`) VALUES
(1, 'admin', '', '', 0, 'http://media.xfire.com/xfire/xf/images/avatars/gallery/default/xfire100.jpg', 1),
(28, 'worldwise001', 'Sabriel', 'http://alpha.0x08.org', 0, 'http://screenshot.xfire.com/avatar/worldwise001.jpg?874', 1);

-- --------------------------------------------------------

--
-- Table structure for table `core_events`
--

CREATE TABLE IF NOT EXISTS `core_events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `sanitized` varchar(32) NOT NULL,
  `datetime_start` datetime NOT NULL,
  `datetime_end` datetime NOT NULL,
  `price` decimal(5,2) NOT NULL DEFAULT '0.00',
  `id_location` int(10) unsigned NOT NULL DEFAULT '0',
  `id_map` int(10) unsigned NOT NULL DEFAULT '0',
  `capacity` int(10) unsigned NOT NULL DEFAULT '0',
  `information` text NOT NULL,
  `reminder` text NOT NULL,
  `agreement` text NOT NULL,
  `min_age` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sanitized` (`sanitized`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `core_events`
--

INSERT INTO `core_events` (`id`, `name`, `sanitized`, `datetime_start`, `datetime_end`, `price`, `id_location`, `id_map`, `capacity`, `information`, `reminder`, `agreement`, `min_age`) VALUES
(1, 'SalukiLAN 2009', 'salukilan2009', '2009-10-03 10:00:00', '2009-10-04 17:00:00', '0.00', 2, 0, 120, '', '', '', 0),
(2, 'SalukiLAN 2010', 'salukilan2010', '2010-05-01 10:00:00', '2010-05-02 17:00:00', '0.00', 1, 3, 180, 'The Venue this year is bigger and better than ever! We''re taking up all the Ballrooms, which gives us enough room for 170 PC gamers, and 50-60 console gamers, with a spacious lounge for movies, sleeping, or just hanging out. We''ve got a lot of room, so be sure to invite all your friends this year!\r\n\r\nIf you would like to participate in the LAN event, please bring the following:\r\n\r\n1. your computer (includes tower, monitor, keyboard, mouse, cables, software, games, headphones, etc...)\r\n2. a great attitude\r\n\r\nPlease do not bring:\r\n- UPS Backups\r\n- powered speakers\r\n\r\nFor console people:\r\n- bringing your personal controller for your Xbox 360 or PS3 is highly recommended.\r\n- if you would like to, you may bring your console system.  Chances are someone may want to play a multi player game as well.\r\n-  you are encouraged to bring your own TV as well, just remember that all your equipment is your responsibility.\r\n\r\nWhat we will provide:\r\n-  Tables and chairs\r\n-  Highspeed Network\r\n-  University security provided by Saluki Patrol and SIUC''s Campus Police', '', '', 16),
(3, 'SalukiLAN 2010 Beta', 'salukilan2010b', '2010-09-04 12:00:00', '2010-09-05 12:00:00', '0.00', 0, 0, 180, '', '', '', 16);

-- --------------------------------------------------------

--
-- Table structure for table `core_images`
--

CREATE TABLE IF NOT EXISTS `core_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_album` int(10) unsigned NOT NULL DEFAULT '0',
  `file` varchar(128) NOT NULL,
  `title` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `core_images`
--

INSERT INTO `core_images` (`id`, `id_album`, `file`, `title`) VALUES
(1, 0, 'uploads/sponsor/nvidia.jpg', 'nVidia Logo'),
(2, 0, 'uploads/sponsor/intel.jpg', 'Intel Logo'),
(3, 0, 'uploads/sponsor/acm.jpg', 'ACM Logo'),
(4, 2, 'uploads/gallery/2/SLf09_0044.JPG', NULL),
(5, 2, 'uploads/gallery/2/SLf09_0049.JPG', NULL),
(6, 2, 'uploads/gallery/2/SLf09_0051.JPG', NULL),
(7, 2, 'uploads/gallery/2/SLf09_0062.JPG', NULL),
(8, 2, 'uploads/gallery/2/SLf09_0069.JPG', NULL),
(9, 2, 'uploads/gallery/2/SLf09_0070.JPG', NULL),
(10, 2, 'uploads/gallery/2/SLf09_0074.JPG', NULL),
(11, 2, 'uploads/gallery/2/SLf09_0087.JPG', NULL),
(12, 2, 'uploads/gallery/2/SLf09_0094.JPG', NULL),
(13, 0, 'uploads/teams/ad93baaaaa4406bcbbbac7bd0342d474.png', NULL),
(14, 0, 'uploads/teams/ad93be9cbf4406bcb8dac7bd0342d474.png', NULL),
(15, 0, 'uploads/teams/ce57be9cbf4406bcb8d2e7bd0342d474.png', NULL),
(16, 0, 'uploads/teams/ce57be9cbf4406bcb8d2e7bd0342d474.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `core_items`
--

CREATE TABLE IF NOT EXISTS `core_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `id_owner` int(10) unsigned NOT NULL DEFAULT '0',
  `comments` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=238 ;

--
-- Dumping data for table `core_items`
--


-- --------------------------------------------------------

--
-- Table structure for table `core_layouts`
--

CREATE TABLE IF NOT EXISTS `core_layouts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL DEFAULT '0',
  `id_room` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `id_table` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `id_seat` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `id_event` int(10) unsigned NOT NULL DEFAULT '0',
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `core_layouts`
--


-- --------------------------------------------------------

--
-- Table structure for table `core_locations`
--

CREATE TABLE IF NOT EXISTS `core_locations` (
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
-- Dumping data for table `core_locations`
--

INSERT INTO `core_locations` (`id`, `name`, `address1`, `address2`, `city`, `state`, `zip`, `country`, `floor`, `room`) VALUES
(1, 'SIUC Student Center', '1255 Lincoln Drive', '', 'Carbondale', 'Illinois', 62901, 'USA', '2nd Floor', 'Ballrooms'),
(2, 'SIUC Grinnell Hall', '', '', 'Carbondale', 'Illinois', 62901, 'USA', 'Basement', '');

-- --------------------------------------------------------

--
-- Table structure for table `core_maps`
--

CREATE TABLE IF NOT EXISTS `core_maps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `xml` varchar(32) NOT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `core_maps`
--

INSERT INTO `core_maps` (`id`, `xml`, `type`) VALUES
(1, 'uploads/xml/siucstdctr.xml', 0),
(2, 'uploads/xml/siucgrinnell.xml', 0),
(3, 'content/map/2/floorplan.xml', 0);

-- --------------------------------------------------------

--
-- Table structure for table `core_prizes`
--

CREATE TABLE IF NOT EXISTS `core_prizes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_photo` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  `id_event` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `core_prizes`
--


-- --------------------------------------------------------

--
-- Table structure for table `core_settings`
--

CREATE TABLE IF NOT EXISTS `core_settings` (
  `cat` varchar(32) NOT NULL DEFAULT 'config',
  `key` varchar(32) NOT NULL,
  `value` varchar(256) DEFAULT NULL,
  UNIQUE KEY `cat` (`cat`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `core_settings`
--

INSERT INTO `core_settings` (`cat`, `key`, `value`) VALUES
('config', 'name', 'SalukiLAN Portal'),
('config', 'theme', 'default'),
('config', 'url', 'http://localhost/testbed/portal'),
('facebook', 'id', '185130289324'),
('facebook', 'name', 'salukilan'),
('myspace', 'username', 'salukilan'),
('steam', 'name', 'salukilan'),
('twitter', 'username', 'salukilan'),
('xfire', 'name', 'salukilan');

-- --------------------------------------------------------

--
-- Table structure for table `core_sponsors`
--

CREATE TABLE IF NOT EXISTS `core_sponsors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `id_photo` int(10) unsigned NOT NULL DEFAULT '0',
  `website` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `core_sponsors`
--

INSERT INTO `core_sponsors` (`id`, `name`, `id_photo`, `website`) VALUES
(1, 'nVidia', 1, 'http://www.nvidia.com'),
(2, 'Intel', 2, 'http://www.intel.com'),
(3, 'Association for Computing Machinery', 3, 'http://acm.rso.siuc.edu');

-- --------------------------------------------------------

--
-- Table structure for table `core_teams`
--

CREATE TABLE IF NOT EXISTS `core_teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `sanitized` varchar(32) NOT NULL,
  `id_captain` int(10) unsigned NOT NULL DEFAULT '0',
  `size` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sanitized` (`sanitized`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `core_teams`
--

INSERT INTO `core_teams` (`id`, `name`, `sanitized`, `id_captain`, `size`) VALUES
(1, 'Scorpion Stingers', 'stingers', 18, 0),
(2, 'Crazy Cuckoos', 'cuckoos', 24, 0);

-- --------------------------------------------------------

--
-- Table structure for table `core_users`
--

CREATE TABLE IF NOT EXISTS `core_users` (
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
  `id_role` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `id_steam` varchar(64) NOT NULL DEFAULT '',
  `num_steam` bigint(20) NOT NULL DEFAULT '0',
  `id_xfire` varchar(64) NOT NULL DEFAULT '',
  `id_twitter` varchar(64) NOT NULL DEFAULT '',
  `datetime_join` datetime NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `hash` varchar(32) NOT NULL,
  `id_image` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `confirm` (`hash`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=138 ;

--
-- Dumping data for table `core_users`
--

INSERT INTO `core_users` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `phone`, `birthday`, `gamertag`, `blurb`, `id_role`, `id_steam`, `num_steam`, `id_xfire`, `id_twitter`, `datetime_join`, `active`, `hash`, `id_image`) VALUES
(1, 'John', 'Doe', 'admin@localhost', 'admin', '6f19be0c391a924c2345dde2dcf3320b', 4806205736, '0000-00-00', 'Admin', 'The Administrator!', 1, 'admin', 0, 'admin', '', '0000-00-00 00:00:00', 1, '748d6b6ed8e13f857ceaa6cfbdca14b8', 0),
(28, 'Sarah', 'Harvey', 'worldwise001@gmail.com', 'worldwise001', 'd10937264ae407b0ec7358f741188ab1', 4806205736, '1990-06-03', 'Sabriel', '', 0, 'worldwise001', 0, 'worldwise001', '', '2010-04-02 04:53:54', 1, '80e4db376fd0b96b026c409363e1714d', 0);

-- --------------------------------------------------------

--
-- Table structure for table `game_match`
--

CREATE TABLE IF NOT EXISTS `game_match` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_tournament` int(10) unsigned NOT NULL DEFAULT '0',
  `tree_position` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `team` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `id_game` int(10) unsigned NOT NULL DEFAULT '0',
  `id_type` int(10) unsigned NOT NULL DEFAULT '0',
  `id_winner` int(10) unsigned NOT NULL DEFAULT '0',
  `host` varchar(64) DEFAULT NULL,
  `lobby` int(10) unsigned NOT NULL DEFAULT '10',
  `datetime_start` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `capacity` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `id_owner` int(10) unsigned NOT NULL DEFAULT '0',
  `hostname` varchar(32) DEFAULT NULL,
  `id_event` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `game_match`
--

INSERT INTO `game_match` (`id`, `id_tournament`, `tree_position`, `team`, `id_game`, `id_type`, `id_winner`, `host`, `lobby`, `datetime_start`, `capacity`, `id_owner`, `hostname`, `id_event`) VALUES
(15, 1, 0, 1, 0, 0, 0, '', 10, '1970-01-01 00:00:00', 2, 0, '', 0),
(16, 1, 1, 1, 0, 0, 0, '', 10, '1970-01-01 00:00:00', 2, 0, '', 0),
(17, 1, 2, 1, 0, 0, 0, '', 10, '1970-01-01 00:00:00', 2, 0, '', 0),
(18, 1, 3, 1, 0, 0, 0, '', 10, '1970-01-01 00:00:00', 2, 0, '', 0),
(19, 1, 4, 1, 0, 0, 0, '', 10, '1970-01-01 00:00:00', 2, 0, '', 0),
(20, 1, 5, 1, 0, 0, 0, '', 10, '1970-01-01 00:00:00', 2, 0, '', 0),
(21, 1, 6, 1, 0, 0, 0, '', 10, '1970-01-01 00:00:00', 2, 0, '', 0),
(22, 0, 0, 0, 0, 0, 0, NULL, 10, '1970-01-01 00:00:00', 0, 0, NULL, 0),
(23, 0, 0, 1, 0, 0, 0, NULL, 10, '1970-01-01 00:00:00', 0, 0, NULL, 0),
(24, 2, 0, 0, 0, 0, 0, '', 10, '1970-01-01 00:00:00', 2, 0, '', 0),
(25, 2, 1, 0, 0, 0, 0, '', 10, '1970-01-01 00:00:00', 2, 0, '', 0),
(26, 2, 2, 0, 0, 0, 0, '', 10, '1970-01-01 00:00:00', 2, 0, '', 0),
(27, 2, 3, 0, 0, 0, 0, '', 10, '1970-01-01 00:00:00', 2, 0, '', 0),
(28, 2, 4, 0, 0, 0, 0, '', 10, '1970-01-01 00:00:00', 2, 0, '', 0),
(29, 2, 5, 0, 0, 0, 0, '', 10, '1970-01-01 00:00:00', 2, 0, '', 0),
(30, 2, 6, 0, 0, 0, 0, '', 10, '1970-01-01 00:00:00', 2, 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `game_tournament`
--

CREATE TABLE IF NOT EXISTS `game_tournament` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `sanitized` varchar(32) DEFAULT NULL,
  `rounds` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `id_game` int(10) unsigned NOT NULL DEFAULT '0',
  `id_type` int(10) unsigned NOT NULL DEFAULT '0',
  `team` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `id_owner` int(10) unsigned NOT NULL DEFAULT '0',
  `id_event` int(10) unsigned NOT NULL DEFAULT '0',
  `started` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sanitized` (`sanitized`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `game_tournament`
--

INSERT INTO `game_tournament` (`id`, `name`, `sanitized`, `rounds`, `id_game`, `id_type`, `team`, `id_owner`, `id_event`, `started`) VALUES
(1, 'Sample Tournament', 'sample', 3, 0, 0, 1, 0, 0, 0),
(2, 'test', 'test', 3, 0, 0, 0, 0, 0, 0),
(3, 'test1', 'test1', 0, 0, 0, 1, 0, 0, 0),
(4, 'test13', 'test31', 0, 0, 0, 1, 0, 0, 0),
(5, 'test132', 'test321', 0, 0, 0, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ref_player_match`
--

CREATE TABLE IF NOT EXISTS `ref_player_match` (
  `id_player` int(10) unsigned NOT NULL DEFAULT '0',
  `id_match` int(10) unsigned NOT NULL DEFAULT '0',
  `team` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_player`,`id_match`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_player_match`
--

INSERT INTO `ref_player_match` (`id_player`, `id_match`, `team`) VALUES
(3, 24, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ref_user_event`
--

CREATE TABLE IF NOT EXISTS `ref_user_event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL DEFAULT '0',
  `id_event` int(10) unsigned NOT NULL DEFAULT '0',
  `seat` varchar(4) NOT NULL,
  `id_designation` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_user` (`id_user`,`id_event`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

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
  UNIQUE KEY `id_user` (`id_user`,`id_team`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ref_user_team`
--


-- --------------------------------------------------------

--
-- Table structure for table `status_items`
--

CREATE TABLE IF NOT EXISTS `status_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_item` int(10) unsigned NOT NULL DEFAULT '0',
  `checkin` datetime NOT NULL,
  `checkout` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=173 ;

--
-- Dumping data for table `status_items`
--


-- --------------------------------------------------------

--
-- Table structure for table `status_rental`
--

CREATE TABLE IF NOT EXISTS `status_rental` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_item` int(10) unsigned NOT NULL DEFAULT '0',
  `id_borrower` int(10) unsigned NOT NULL DEFAULT '0',
  `checkin` datetime NOT NULL,
  `checkout` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `status_rental`
--


-- --------------------------------------------------------

--
-- Table structure for table `status_users`
--

CREATE TABLE IF NOT EXISTS `status_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_ref` int(10) unsigned NOT NULL DEFAULT '0',
  `checkin` datetime NOT NULL,
  `checkout` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `status_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `type_attendees`
--

CREATE TABLE IF NOT EXISTS `type_attendees` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `prefix` varchar(2) NOT NULL,
  `description` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `type_attendees`
--

INSERT INTO `type_attendees` (`id`, `prefix`, `description`) VALUES
(1, 'GM', 'General Manager'),
(2, 'ST', 'Staff'),
(3, 'SP', 'Speaker'),
(4, 'WI', 'Walk-in'),
(5, 'PR', 'Pre-registered'),
(6, 'DS', 'Booth');

-- --------------------------------------------------------

--
-- Table structure for table `type_games`
--

CREATE TABLE IF NOT EXISTS `type_games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `image` varchar(128) NOT NULL,
  `id_steam` int(10) unsigned NOT NULL DEFAULT '0',
  `id_xfire` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `type_games`
--

INSERT INTO `type_games` (`id`, `name`, `image`, `id_steam`, `id_xfire`) VALUES
(1, 'Left 4 Dead', 'common/img/icons/games/l4d.png', 500, 'l4d'),
(2, 'Team Fortress 2', 'common/img/icons/games/tf2.png', 440, 'tf2');

-- --------------------------------------------------------

--
-- Table structure for table `type_items`
--

CREATE TABLE IF NOT EXISTS `type_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prefix` varchar(2) NOT NULL,
  `description` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `type_items`
--

INSERT INTO `type_items` (`id`, `prefix`, `description`) VALUES
(1, 'PC', 'Desktop Tower'),
(2, 'LP', 'Laptop'),
(3, 'MT', 'Computer Monitor'),
(4, 'TV', 'Television Set'),
(5, 'VG', 'Video Game Console'),
(6, 'VC', 'Controller'),
(7, 'MS', 'Mouse'),
(8, 'KY', 'Keyboard'),
(9, 'SW', 'Network Switch'),
(10, 'PS', 'Power Strip');

-- --------------------------------------------------------

--
-- Table structure for table `type_matches`
--

CREATE TABLE IF NOT EXISTS `type_matches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prefix` varchar(2) DEFAULT NULL,
  `description` varchar(64) DEFAULT NULL,
  `team` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `type_matches`
--


-- --------------------------------------------------------

--
-- Table structure for table `type_platforms`
--

CREATE TABLE IF NOT EXISTS `type_platforms` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `image` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `type_platforms`
--

INSERT INTO `type_platforms` (`id`, `name`, `image`) VALUES
(1, 'PC', 'common/img/icons/platforms/pc.png'),
(2, 'Playstation 3', 'common/img/icons/platforms/ps3.png'),
(3, 'XBox 360', 'common/img/icons/platforms/xbox360.png');

-- --------------------------------------------------------

--
-- Table structure for table `type_roles`
--

CREATE TABLE IF NOT EXISTS `type_roles` (
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
-- Dumping data for table `type_roles`
--

INSERT INTO `type_roles` (`id`, `name`, `is_active`, `is_admin`, `is_mod`, `is_poster`, `is_media`, `is_events`) VALUES
(1, 'Administrator', 1, 1, 1, 1, 1, 1),
(2, 'User', 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `web_albums`
--

CREATE TABLE IF NOT EXISTS `web_albums` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_event` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL,
  `is_slideshow` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `id_user` int(10) unsigned NOT NULL DEFAULT '0',
  `user_submitted` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `web_albums`
--

INSERT INTO `web_albums` (`id`, `id_event`, `name`, `is_slideshow`, `id_user`, `user_submitted`) VALUES
(1, 0, 'Uncategorized', 0, 0, 0),
(2, 0, 'slideshow', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `web_cache`
--

CREATE TABLE IF NOT EXISTS `web_cache` (
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `filename` varchar(128) NOT NULL,
  `width` int(10) unsigned NOT NULL DEFAULT '0',
  `height` int(10) unsigned NOT NULL DEFAULT '0',
  `size` tinyint(3) unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `web_cache`
--


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
-- Table structure for table `web_news`
--

CREATE TABLE IF NOT EXISTS `web_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(64) NOT NULL,
  `content` text NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `web_news`
--

INSERT INTO `web_news` (`id`, `id_user`, `title`, `content`, `timestamp`) VALUES
(1, 3, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget nisl at nisl porta luctus eu et sapien. Nunc arcu diam, tincidunt sed euismod et, ornare non mauris. Pellentesque nulla nisi, mattis a convallis in, vestibulum nec sapien. Integer molestie sollicitudin pharetra. Donec at erat sit amet sem aliquet porta sed non leo. Etiam ut justo a dolor aliquam aliquet sit amet ac arcu. Cras blandit malesuada ipsum nec consectetur. Nam sed quam quam. Pellentesque varius, quam a lobortis pulvinar, nisi lectus sollicitudin nulla, et dignissim nisi tortor sed nunc. Nunc ipsum dui, molestie congue convallis eget, scelerisque posuere lacus. Pellentesque sit amet risus quam. Nullam faucibus placerat felis vel faucibus.\r\n\r\nSed dignissim gravida ultricies. In in egestas nisl. Sed elit libero, convallis feugiat aliquet vel, blandit ut augue. Mauris vel porttitor tellus. Donec mauris eros, blandit vel sagittis non, posuere in nisi. Curabitur quis ante ante, a placerat libero. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed ut lacus magna, vitae vulputate purus. Pellentesque mollis iaculis vulputate. Nullam id viverra augue. Aliquam nisl velit, adipiscing ac egestas nec, tempor ut tellus. Integer quis erat ac risus pulvinar bibendum sed id purus. Quisque ornare pulvinar odio, nec tincidunt ligula faucibus eu. Integer a hendrerit eros. Nulla eget est lectus.\r\n\r\nMaecenas malesuada hendrerit mattis. Nam nibh sapien, lacinia nec vehicula suscipit, venenatis ac purus. Curabitur elit dui, convallis vel sagittis mattis, fringilla ut dolor. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Suspendisse eleifend scelerisque faucibus. Fusce eleifend ultrices mauris et vulputate. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis augue urna, ullamcorper at fermentum et, commodo nec tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla condimentum malesuada commodo. Donec leo est, vestibulum sit amet tincidunt et, dictum vitae tortor. Sed mattis gravida nisl non gravida. Morbi volutpat tincidunt tristique. In mauris justo, blandit id suscipit ac, tempus vel odio. Aliquam id purus nulla, id commodo erat. Quisque vel sapien id augue convallis viverra.', '2010-02-28 17:07:38'),
(2, 3, 'Nullam', 'Suspendisse tellus mauris, mattis sodales tristique semper, suscipit ac leo. Vivamus eget metus nec justo porta tempor. Pellentesque urna lorem, volutpat ut sodales sed, consequat vitae nulla. Nullam nec nibh odio, sit amet fermentum libero. Fusce lectus orci, semper sit amet bibendum ullamcorper, lacinia nec turpis. Fusce varius orci ac odio mattis nec condimentum elit condimentum. Nullam eu quam a nunc congue viverra. Nulla non risus ligula, id sagittis purus. Nullam posuere mauris at diam lobortis eu sodales orci hendrerit. Integer vestibulum dapibus elit, rhoncus venenatis lorem dapibus ut.', '2010-02-28 17:08:16');
