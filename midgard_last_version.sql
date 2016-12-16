-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Dec 16, 2016 at 10:05 AM
-- Server version: 5.6.28-76.1-log
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `filipp18_midgard`
--

-- --------------------------------------------------------

--
-- Table structure for table `battle`
--

CREATE TABLE IF NOT EXISTS `battle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attacker_id` int(11) DEFAULT NULL,
  `defender_monster_id` int(11) DEFAULT NULL,
  `attacker_hit` int(11) DEFAULT NULL,
  `defender_hit` int(11) DEFAULT NULL,
  `defender_hero_id` int(11) DEFAULT NULL,
  `defender_health_after_attack` int(11) DEFAULT NULL,
  `attacker_health_after_attack` int(11) DEFAULT NULL,
  `dead_status` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='dead_status: 0 - battle continue; 1 - attacker dead; 2 - defender dead ' AUTO_INCREMENT=846 ;

--
-- Dumping data for table `battle`
--

INSERT INTO `battle` (`id`, `attacker_id`, `defender_monster_id`, `attacker_hit`, `defender_hit`, `defender_hero_id`, `defender_health_after_attack`, `attacker_health_after_attack`, `dead_status`) VALUES
(467, 32, 2, 21, 7, 0, 79, 193, 0),
(512, 32, 0, 17, 0, 33, -16, 32, 2),
(795, 38, 0, 36, 0, 32, -3, 137, 2),
(805, 38, 0, 38, 0, 33, -25, 137, 2),
(815, 38, 0, 47, 0, 37, -3, 137, 2),
(829, 38, 0, 36, 0, 36, -30, 137, 2);

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE IF NOT EXISTS `buildings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_buildings_id` int(11) DEFAULT NULL,
  `heroes_id` int(11) DEFAULT NULL,
  `lavel` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buildings_type_of_buildings_id_fk` (`type_of_buildings_id`),
  KEY `buildings_heroes_id_fk` (`heroes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `coordinates_x` int(11) DEFAULT NULL,
  `coordinates_y` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `coordinates_x`, `coordinates_y`) VALUES
(1, 'Scarborough', 1, 10),
(2, 'Whitby', 11, 20),
(3, 'Wetherby', 21, 30),
(4, 'Harrogate', 31, 40),
(5, 'Sheffield', 41, 50),
(6, 'Ragnaros', 51, 60);

-- --------------------------------------------------------

--
-- Table structure for table `heroes`
--

CREATE TABLE IF NOT EXISTS `heroes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `type_of_heroes_id` int(11) NOT NULL,
  `level_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `real_health` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `real_mana` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `hero_status` smallint(6) NOT NULL,
  `damage_low_value` int(11) DEFAULT NULL,
  `damage_high_value` int(11) DEFAULT NULL,
  `armor` int(11) DEFAULT NULL,
  `strength` int(11) DEFAULT NULL,
  `magic` int(11) DEFAULT NULL,
  `vitality` int(11) DEFAULT NULL,
  `dexterity` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL,
  `mana` int(11) DEFAULT NULL,
  `critical` double DEFAULT NULL,
  `level_points` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `heroes_users_id_fk` (`user_id`),
  KEY `heroes_type_of_heroes_id_fk` (`type_of_heroes_id`),
  KEY `heroes_city_id_fk` (`city_id`),
  KEY `heroes_level_id_fk` (`level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='hero_status : Create - 0; Delete - 10; Play - 1; In Battle - 2' AUTO_INCREMENT=41 ;

--
-- Dumping data for table `heroes`
--

INSERT INTO `heroes` (`id`, `user_id`, `type_of_heroes_id`, `level_id`, `city_id`, `real_health`, `experience`, `real_mana`, `name`, `hero_status`, `damage_low_value`, `damage_high_value`, `armor`, `strength`, `magic`, `vitality`, `dexterity`, `health`, `mana`, `critical`, `level_points`) VALUES
(32, 4, 1, 2, 1, 28, 180, 120, 'DjinHa', 0, 15, 15, 30, 30, 10, 30, 15, 400, 120, 0.15, NULL),
(33, 11, 1, 1, 1, 200, 57, 120, 'War', 1, 15, 15, 30, 30, 10, 30, 15, 400, 120, 0.15, NULL),
(34, 11, 2, 1, 1, 280, 0, 190, 'Mark', 0, 10, 10, 60, 20, 15, 20, 30, 280, 190, 0.3, NULL),
(35, 12, 1, 1, 1, 308, 20, 120, 'Djin', 0, 15, 15, 30, 30, 10, 30, 15, 400, 120, 0.15, NULL),
(36, 12, 1, 2, 1, 200, 134, 120, 'Warcho', 1, 15, 15, 30, 37, 11, 31, 18, 400, 120, 0.15, 0),
(37, 4, 1, 1, 1, 366, 32, 120, 'Kemcho', 0, 15, 15, 30, 30, 10, 30, 15, 400, 120, 0.15, 0),
(38, 13, 1, 5, 1, 137, 689, 120, 'Biser', 1, 15, 15, 30, 44, 11, 31, 19, 400, 120, 0.15, 0),
(39, 4, 1, 1, 1, 400, 16, 120, 'Kemura', 0, 15, 15, 30, 30, 10, 30, 15, 400, 120, 0.15, 0),
(40, 4, 1, 1, 1, 400, 0, 120, 'Opaaa', 1, 15, 15, 30, 30, 10, 30, 15, 400, 120, 0.15, 0);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `damage_low_value` int(11) DEFAULT NULL,
  `armor` int(11) DEFAULT NULL,
  `strength` int(11) DEFAULT NULL,
  `vitality` int(11) DEFAULT NULL,
  `magic` int(11) DEFAULT NULL,
  `dexterity` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL,
  `mana` int(11) DEFAULT NULL,
  `type_of_item_id` int(11) DEFAULT NULL,
  `hero_id` int(11) DEFAULT NULL,
  `item_level` int(11) DEFAULT NULL,
  `is_equiped` smallint(6) DEFAULT NULL,
  `damage_high_value` int(11) DEFAULT NULL,
  `critical` double DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `items_type_of_items_id_fk` (`type_of_item_id`),
  KEY `items_heroes_id_fk` (`hero_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='is_equiped : 1 - true; 0 - false; ' AUTO_INCREMENT=181 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `damage_low_value`, `armor`, `strength`, `vitality`, `magic`, `dexterity`, `health`, `mana`, `type_of_item_id`, `hero_id`, `item_level`, `is_equiped`, `damage_high_value`, `critical`, `name`) VALUES
(57, 0, 10, 0, 1, 0, 0, 0, 0, 2, 32, 1, 0, 0, 0, NULL),
(58, 5, 0, 1, 0, 0, 0, 0, 0, 8, 32, 1, 1, 8, 0, NULL),
(59, 0, 17, 1, 3, 0, 0, 3, 8, 12, 32, 1, 0, 0, 0, 'Item59'),
(60, 0, 17, 0, 2, 1, 0, 2, 10, 7, 32, 1, 0, 0, 0, 'Item60'),
(61, 0, 19, 2, 1, 2, 1, 4, 4, 8, 32, 1, 0, 0, 0, 'Item61'),
(62, 0, 18, 3, 3, 3, 3, 6, 6, 8, 32, 1, 0, 0, 0, 'Item62'),
(63, 0, 24, 3, 0, 2, 3, 6, 4, 12, 32, 1, 1, 0, 0, 'Item63'),
(64, 0, 16, 0, 0, 3, 3, 5, 6, 12, 32, 1, 0, 0, 0, 'Item64'),
(65, 19, 0, 1, 2, 0, 2, 6, 2, 10, 32, 1, 0, 21, 0, 'Item65'),
(66, 0, 26, 0, 3, 2, 3, 10, 10, 3, 32, 1, 0, 0, 0, 'Item66'),
(67, 0, 15, 3, 2, 1, 3, 2, 8, 4, 32, 1, 1, 0, 0, 'Item67'),
(68, 0, 28, 3, 2, 3, 1, 8, 7, 7, 32, 1, 0, 0, 0, 'Item68'),
(69, 0, 24, 3, 0, 0, 3, 6, 10, 8, 32, 1, 0, 0, 0, 'Item69'),
(70, 0, 22, 1, 2, 1, 3, 7, 3, 7, 32, 1, 0, 0, 0, 'Item70'),
(72, 0, 16, 1, 0, 3, 3, 3, 8, 8, 32, 1, 0, 0, 0, 'Item72'),
(73, 20, 0, 0, 3, 2, 1, 7, 8, 10, 32, 1, 0, 25, 0, 'Item73'),
(74, 0, 10, 0, 1, 0, 0, 0, 0, 2, 33, 1, 1, 0, 0, NULL),
(75, 5, 0, 1, 0, 0, 0, 0, 0, 8, 33, 1, 0, 8, 0, NULL),
(76, 17, 0, 3, 0, 0, 0, 10, 9, 9, 33, 1, 0, 25, 0, 'Item76'),
(79, 0, 20, 2, 0, 0, 0, 5, 1, 4, 32, 1, 0, 0, 0, 'Item79'),
(80, 0, 25, 0, 3, 2, 2, 6, 3, 7, 32, 1, 0, 0, 0, 'Item80'),
(81, 0, 17, 2, 1, 3, 1, 2, 0, 12, 32, 1, 0, 0, 0, 'Item81'),
(82, 0, 10, 0, 1, 0, 0, 0, 0, 2, 34, 1, 1, 0, 0, NULL),
(83, 4, 0, 0, 0, 0, 1, 0, 0, 11, 34, 1, 1, 7, 0, NULL),
(84, 0, 10, 0, 1, 0, 0, 0, 0, 2, 35, 1, 1, 0, 0, NULL),
(85, 5, 0, 1, 0, 0, 0, 0, 0, 8, 35, 1, 1, 8, 0, NULL),
(86, 0, 24, 0, 1, 3, 0, 4, 8, 7, 35, 1, 1, 0, 0, 'Item86'),
(87, 0, 10, 0, 1, 0, 0, 0, 0, 2, 36, 1, 0, 0, 0, NULL),
(88, 5, 0, 1, 0, 0, 0, 0, 0, 8, 36, 1, 0, 8, 0, NULL),
(89, 0, 18, 0, 2, 0, 2, 6, 0, 3, 36, 1, 1, 0, 0, 'Item89'),
(90, 15, 0, 3, 1, 0, 3, 6, 10, 1, 36, 1, 1, 23, 0, 'Item90'),
(91, 0, 30, 3, 3, 3, 1, 3, 7, 3, 36, 1, 0, 0, 0, 'Item91'),
(92, 19, 0, 0, 0, 2, 3, 4, 9, 10, 36, 1, 0, 21, 0, 'Item92'),
(93, 17, 0, 2, 0, 1, 0, 3, 10, 9, 36, 1, 0, 29, 0, 'Item93'),
(94, 16, 0, 1, 3, 0, 1, 2, 1, 10, 36, 1, 0, 25, 0, 'Item94'),
(95, 18, 0, 3, 1, 0, 2, 6, 5, 11, 36, 1, 0, 25, 0, 'Item95'),
(96, 0, 16, 0, 1, 0, 2, 4, 6, 5, 36, 1, 1, 0, 0, 'Item96'),
(97, 0, 23, 0, 0, 0, 0, 4, 5, 2, 36, 1, 0, 0, 0, 'Item97'),
(98, 0, 25, 0, 0, 3, 1, 4, 1, 7, 36, 1, 0, 0, 0, 'Item98'),
(99, 0, 29, 2, 0, 1, 1, 4, 9, 12, 32, 1, 0, 0, 0, 'Item99'),
(100, 15, 0, 0, 2, 3, 0, 1, 9, 9, 32, 1, 0, 21, 0, 'Item100'),
(101, 0, 19, 0, 1, 2, 1, 2, 4, 7, 32, 1, 0, 0, 0, 'Item101'),
(102, 16, 0, 1, 1, 1, 0, 9, 10, 9, 32, 1, 0, 25, 0, 'Item102'),
(103, 20, 0, 2, 3, 0, 0, 0, 2, 9, 32, 1, 0, 21, 0, 'Item103'),
(104, 0, 17, 2, 1, 3, 2, 6, 3, 2, 32, 1, 0, 0, 0, 'Item104'),
(105, 0, 20, 0, 1, 3, 3, 7, 9, 4, 32, 1, 0, 0, 0, 'Item105'),
(106, 18, 0, 3, 2, 1, 3, 6, 1, 10, 32, 1, 0, 29, 0, 'Item106'),
(107, 0, 29, 1, 3, 0, 3, 9, 6, 6, 32, 1, 0, 0, 0, 'Item107'),
(108, 0, 29, 1, 3, 2, 2, 0, 4, 7, 32, 1, 0, 0, 0, 'Item108'),
(109, 0, 10, 0, 1, 0, 0, 0, 0, 2, 37, 1, 1, 0, 0, NULL),
(110, 5, 0, 1, 0, 0, 0, 0, 0, 8, 37, 1, 1, 8, 0, NULL),
(111, 0, 23, 0, 3, 1, 0, 7, 5, 4, 37, 1, 0, 0, 0, 'Item111'),
(116, 0, 29, 3, 3, 3, 1, 9, 6, 12, 38, 1, 1, 0, 0, 'Item116'),
(123, 0, 30, 2, 2, 0, 0, 10, 4, 4, 38, 1, 1, 0, 0, 'Item123'),
(130, 0, 28, 0, 1, 2, 1, 5, 9, 5, 38, 1, 1, 0, 0, 'Item127'),
(132, 0, 29, 2, 1, 3, 0, 1, 8, 3, 38, 1, 1, 0, 0, 'Item131'),
(136, 0, 26, 3, 3, 0, 3, 5, 0, 6, 38, 1, 1, 0, 0, 'Item136'),
(138, 0, 23, 3, 3, 0, 3, 9, 2, 2, 38, 1, 1, 0, 0, 'Item138'),
(142, 19, 0, 1, 3, 1, 1, 1, 5, 8, 38, 1, 1, 30, 0, 'Item142'),
(145, 0, 29, 3, 3, 1, 1, 2, 2, 7, 38, 1, 1, 0, 0, 'Item145'),
(154, 0, 23, 2, 0, 2, 2, 6, 7, 2, 38, 1, 0, 0, 0, 'Item146'),
(156, 0, 100, 5, 5, 5, 5, 5, 5, 2, 32, 1, 1, 0, 0, 'Imperial Armor'),
(157, 0, 17, 2, 3, 0, 2, 10, 7, 5, 32, 1, 0, 0, 0, 'Item157'),
(158, 0, 100, 5, 5, 5, 5, 5, 5, 2, 32, 1, 0, 0, 0, 'Imperial Armor'),
(159, 0, 100, 5, 5, 5, 5, 5, 5, 2, 32, 1, 0, 0, 0, 'Imperial Armor'),
(160, 0, 100, 5, 5, 5, 5, 5, 5, 2, 32, 1, 0, 0, 0, 'Imperial Armor'),
(161, 0, 100, 5, 5, 5, 5, 5, 5, 2, 32, 1, 0, 0, 0, 'Imperial Armor'),
(162, 0, 100, 5, 5, 5, 5, 5, 5, 2, 32, 1, 0, 0, 0, 'Imperial Armor'),
(163, 0, 10, 0, 1, 0, 0, 0, 0, 2, 39, 1, 0, 0, 0, NULL),
(164, 5, 0, 1, 0, 0, 0, 0, 0, 8, 39, 1, 0, 8, 0, NULL),
(165, 0, 100, 5, 5, 5, 5, 5, 5, 2, 39, 1, 0, 0, 0, 'Imperial Armor'),
(168, 0, 80, 3, 3, 3, 3, 3, 3, 2, 37, 1, 0, 0, 0, 'Golden Armor'),
(170, 0, 80, 3, 3, 3, 3, 3, 3, 2, 39, 1, 0, 0, 0, 'Golden Armor'),
(173, 60, 0, 7, 7, 7, 7, 7, 7, 8, 39, 1, 0, 70, 0, 'Sword Of Kings'),
(174, 20, 0, 2, 2, 2, 2, 2, 2, 8, 32, 1, 0, 30, 0, 'Sword'),
(176, 0, 10, 0, 1, 0, 0, 0, 0, 2, 40, 1, 1, 0, 0, NULL),
(177, 5, 0, 1, 0, 0, 0, 0, 0, 8, 40, 1, 1, 8, 0, NULL),
(178, 30, 0, 3, 3, 3, 3, 3, 3, 8, 39, 1, 0, 40, 0, 'Golden Sword'),
(179, 0, 120, 7, 7, 7, 7, 7, 7, 2, 39, 1, 0, 0, 0, 'Armor Of Kings'),
(180, 0, 19, 1, 0, 3, 0, 3, 8, 6, 40, 1, 0, 0, 0, 'Item166');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE IF NOT EXISTS `level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_number` int(11) DEFAULT NULL,
  `from_experience` int(11) DEFAULT NULL,
  `to_experience` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `level_number`, `from_experience`, `to_experience`) VALUES
(1, 1, 0, 100),
(2, 2, 101, 225),
(3, 3, 226, 360),
(4, 4, 361, 600),
(5, 5, 601, 900),
(6, 6, 901, 1400),
(7, 7, 1401, 2000),
(8, 8, 2001, 2900),
(9, 9, 2901, 3900),
(10, 10, 3901, 5200),
(11, 11, 5201, 6700);

-- --------------------------------------------------------

--
-- Table structure for table `monsters`
--

CREATE TABLE IF NOT EXISTS `monsters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_monsters_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `damage_low_value` int(11) DEFAULT NULL,
  `armor` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL,
  `damage_high_value` int(11) DEFAULT NULL,
  `win_experience` int(11) DEFAULT NULL,
  `min_gold` int(11) DEFAULT NULL,
  `max_gold` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `monsters_type_monsters_id_fk` (`type_monsters_id`),
  KEY `monsters_city_id_fk` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `monsters`
--

INSERT INTO `monsters` (`id`, `type_monsters_id`, `city_id`, `damage_low_value`, `armor`, `health`, `damage_high_value`, `win_experience`, `min_gold`, `max_gold`) VALUES
(1, 1, 1, 10, 20, 200, 20, 20, 5, 15),
(2, 2, 1, 14, 15, 100, 21, 18, 6, 18),
(3, 3, 1, 9, 15, 120, 17, 17, 8, 14),
(4, 4, 1, 8, 25, 150, 16, 21, 12, 18),
(5, 5, 1, 10, 10, 80, 16, 16, 14, 17);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE IF NOT EXISTS `recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_recipes_id` int(11) DEFAULT NULL,
  `hero_id` int(11) DEFAULT NULL,
  `start_dt` datetime DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `end_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `recipes_type_of_recipes_id_fk` (`type_of_recipes_id`),
  KEY `recipes_heroes_id_fk` (`hero_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='status : 0 - finish, 1 - in_progres ' AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_resources_id` int(11) DEFAULT NULL,
  `heroes_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resources_type_of_resources_id_fk` (`type_of_resources_id`),
  KEY `resources_heroes_id_fk` (`heroes_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=169 ;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `type_of_resources_id`, `heroes_id`, `amount`) VALUES
(115, 1, 32, 0),
(116, 2, 32, 938),
(117, 3, 32, -15),
(118, 4, 32, 0),
(119, 5, 32, 1),
(120, 6, 32, 3),
(121, 1, 33, 0),
(122, 2, 33, 1036),
(123, 3, 33, 0),
(124, 4, 33, 0),
(125, 5, 33, 0),
(126, 6, 33, 0),
(127, 1, 34, 0),
(128, 2, 34, 1000),
(129, 3, 34, 0),
(130, 4, 34, 0),
(131, 5, 34, 0),
(132, 6, 34, 0),
(133, 1, 35, 0),
(134, 2, 35, 1007),
(135, 3, 35, 0),
(136, 4, 35, 0),
(137, 5, 35, 0),
(138, 6, 35, 0),
(139, 1, 36, 0),
(140, 2, 36, 1156),
(141, 3, 36, -10),
(142, 4, 36, 0),
(143, 5, 36, 0),
(144, 6, 36, 0),
(145, 1, 37, 1),
(146, 2, 37, -170),
(147, 3, 37, -19),
(148, 4, 37, 1),
(149, 5, 37, 6),
(150, 6, 37, 2),
(151, 1, 38, 28),
(152, 2, 38, 1597),
(153, 3, 38, 51),
(154, 4, 38, 38),
(155, 5, 38, 33),
(156, 6, 38, 25),
(157, 1, 39, 3),
(158, 2, 39, 316),
(159, 3, 39, 70),
(160, 4, 39, 0),
(161, 5, 39, 0),
(162, 6, 39, 0),
(163, 1, 40, 1),
(164, 2, 40, 600),
(165, 3, 40, 1),
(166, 4, 40, 1),
(167, 5, 40, 1),
(168, 6, 40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `role_name_uindex` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE IF NOT EXISTS `shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `damage_low_value` int(11) DEFAULT NULL,
  `damage_high_value` int(11) DEFAULT NULL,
  `armor` int(11) DEFAULT NULL,
  `strength` int(11) DEFAULT NULL,
  `vitality` int(11) DEFAULT NULL,
  `magic` int(11) DEFAULT NULL,
  `dexterity` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL,
  `mana` int(11) DEFAULT NULL,
  `type_of_item_id` int(11) DEFAULT NULL,
  `item_level` int(11) DEFAULT NULL,
  `critical` double DEFAULT NULL,
  `shop_status` smallint(6) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `hero_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shop_type_of_items_id_fk` (`type_of_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='shop_status: 0-gold; 1-honor; 2 - auction ' AUTO_INCREMENT=15 ;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`id`, `name`, `damage_low_value`, `damage_high_value`, `armor`, `strength`, `vitality`, `magic`, `dexterity`, `health`, `mana`, `type_of_item_id`, `item_level`, `critical`, `shop_status`, `price`, `hero_id`) VALUES
(1, 'Golden Armor', 0, 0, 80, 3, 3, 3, 3, 3, 3, 2, 1, 0, 0, 300, NULL),
(2, 'Golden Sword', 30, 40, 0, 3, 3, 3, 3, 3, 3, 8, 1, 0, 0, 500, NULL),
(3, 'Golden Bow', 30, 40, 0, 3, 3, 3, 3, 3, 3, 11, 1, 0, 0, 500, NULL),
(4, 'Golden Staff', 30, 40, 0, 3, 3, 3, 3, 3, 3, 10, 1, 0, 0, 500, NULL),
(5, 'Armor Of Kings', 0, 0, 120, 7, 7, 7, 7, 7, 7, 2, 1, 0, 1, 10, NULL),
(6, 'Sword Of Kings', 60, 70, 0, 7, 7, 7, 7, 7, 7, 8, 1, 0, 1, 20, NULL),
(7, 'Bow Of Kings', 60, 70, 0, 7, 7, 7, 7, 7, 7, 11, 1, 0, 1, 20, NULL),
(8, 'Staff Of Kings', 60, 70, 0, 7, 7, 7, 7, 7, 7, 10, 1, 0, 1, 20, NULL),
(12, 'Item71', 0, 0, 21, 2, 1, 3, 0, 7, 7, 4, 1, 0, 2, 400, 32);

-- --------------------------------------------------------

--
-- Table structure for table `skils`
--

CREATE TABLE IF NOT EXISTS `skils` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type_of_heroes_id` int(11) DEFAULT NULL,
  `lavel` int(11) DEFAULT NULL,
  `is_active` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `skils_type_of_heroes_id_fk` (`type_of_heroes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `type_monsters`
--

CREATE TABLE IF NOT EXISTS `type_monsters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `type_monsters`
--

INSERT INTO `type_monsters` (`id`, `name`) VALUES
(1, 'gnome'),
(2, 'troll'),
(3, 'elf'),
(4, 'bandit'),
(5, 'wolf');

-- --------------------------------------------------------

--
-- Table structure for table `type_of_buildings`
--

CREATE TABLE IF NOT EXISTS `type_of_buildings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `type_of_buildings`
--

INSERT INTO `type_of_buildings` (`id`, `name`) VALUES
(1, 'gold mine');

-- --------------------------------------------------------

--
-- Table structure for table `type_of_heroes`
--

CREATE TABLE IF NOT EXISTS `type_of_heroes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `strength` int(11) DEFAULT NULL,
  `vitality` int(11) DEFAULT NULL,
  `magic` int(11) DEFAULT NULL,
  `dexterity` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL,
  `mana` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_of_heroes_name_uindex` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `type_of_heroes`
--

INSERT INTO `type_of_heroes` (`id`, `name`, `strength`, `vitality`, `magic`, `dexterity`, `health`, `mana`) VALUES
(1, 'Warrior', 30, 30, 10, 15, 100, 20),
(2, 'Marksman', 20, 20, 15, 30, 80, 40),
(4, 'Wizard', 15, 20, 30, 20, 50, 70);

-- --------------------------------------------------------

--
-- Table structure for table `type_of_items`
--

CREATE TABLE IF NOT EXISTS `type_of_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `for_type_of_heroes` smallint(6) DEFAULT NULL,
  `weapon_or_armor` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='For_type_of_heroes : 0 - all; 1 - Warrior; 2 - marksman; 3 - wizard ::: weapon_or_armor : 0-armor, 1-weapon' AUTO_INCREMENT=13 ;

--
-- Dumping data for table `type_of_items`
--

INSERT INTO `type_of_items` (`id`, `name`, `for_type_of_heroes`, `weapon_or_armor`) VALUES
(1, 'axe', 1, 1),
(2, 'armor', 0, 0),
(3, 'helm', 0, 0),
(4, 'gloves', 0, 0),
(5, 'boots', 0, 0),
(6, 'ring', 0, 0),
(7, 'necklace', 0, 0),
(8, 'sword', 1, 1),
(9, 'dagger', 1, 1),
(10, 'staff', 3, 1),
(11, 'bow', 2, 1),
(12, 'shield', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `type_of_recipes`
--

CREATE TABLE IF NOT EXISTS `type_of_recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `damage_low_value` int(11) DEFAULT NULL,
  `damage_high_value` int(11) DEFAULT NULL,
  `critical` double DEFAULT NULL,
  `armor` int(11) DEFAULT NULL,
  `strength` int(11) DEFAULT NULL,
  `dexterity` int(11) DEFAULT NULL,
  `vitality` int(11) DEFAULT NULL,
  `magic` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL,
  `mana` int(11) DEFAULT NULL,
  `type_of_item_id` int(11) DEFAULT NULL,
  `item_level` int(11) DEFAULT NULL,
  `gold` int(11) DEFAULT NULL,
  `iron` int(11) DEFAULT NULL,
  `leather` int(11) DEFAULT NULL,
  `silk` int(11) DEFAULT NULL,
  `tree` int(11) DEFAULT NULL,
  `duration` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_of_recipes_type_of_items_id_fk` (`type_of_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `type_of_recipes`
--

INSERT INTO `type_of_recipes` (`id`, `name`, `damage_low_value`, `damage_high_value`, `critical`, `armor`, `strength`, `dexterity`, `vitality`, `magic`, `health`, `mana`, `type_of_item_id`, `item_level`, `gold`, `iron`, `leather`, `silk`, `tree`, `duration`) VALUES
(1, 'Imperial Armor', 0, 0, 0, 100, 5, 5, 5, 5, 5, 5, 2, 1, 100, 1, 1, 1, 1, '00:00:10'),
(2, 'Imperial Sword', 40, 50, 0, 0, 5, 5, 5, 5, 5, 5, 8, 1, 200, 5, 5, 5, 5, '00:00:30'),
(3, 'Imperial Bow', 40, 50, 0, 0, 5, 5, 5, 5, 5, 5, 11, 1, 200, 5, 5, 5, 5, '00:00:30'),
(4, 'Imperial Staff', 40, 50, 0, 0, 5, 5, 5, 5, 5, 5, 10, 1, 200, 5, 5, 5, 5, '00:00:30');

-- --------------------------------------------------------

--
-- Table structure for table `type_of_resources`
--

CREATE TABLE IF NOT EXISTS `type_of_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_of_resources_name_uindex` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `type_of_resources`
--

INSERT INTO `type_of_resources` (`id`, `name`) VALUES
(2, 'gold'),
(3, 'honor'),
(4, 'iron'),
(6, 'leather'),
(1, 'silk'),
(5, 'tree');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_uindex` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='is_active (1-true, 0-false)' AUTO_INCREMENT=14 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `full_name`, `birthday`, `is_active`) VALUES
(3, 'Biskata', '$2y$10$c7uQfln7aRc8MGHazcXXyujD1lijMRihYjQbi/GaK2Fs3Xak9cUjm', NULL, NULL, NULL, NULL, NULL, 1),
(4, 'Filip', '$2y$10$qltTLucZWs9BZmZNJZSnNuEb5N79U53hhimG8Q8t1R3bdwEsC3UiK', NULL, NULL, NULL, NULL, NULL, 1),
(5, 'Sasho', '$2y$10$RvdJTJvIEtOhOlhiahYArundAqvuelcoNj3HhgH7gYBpqE9a7DLiu', NULL, NULL, NULL, NULL, NULL, 1),
(6, 'Ivcho', '$2y$10$dSNM8eJsVQx/mcnOYdzaJe5pnksyOHnmvSFDVSsXfKnJJQlsFcbfW', 'ivaka@mail.bg', NULL, NULL, NULL, '0000-00-00 00:00:00', 1),
(7, 'Mitaka', '$2y$10$UQV3e1vw.MBljdkJDoA0neP8hcZnRMI5knt47MzsJrmF1t6e//FCi', NULL, NULL, NULL, NULL, NULL, 1),
(8, 'Mitaka1', '$2y$10$YTks8sUxiRPdxShB9czhPuiF5FNyTLkjr7uoO9NqdUyAXmmZ6E6YO', NULL, NULL, NULL, NULL, NULL, 1),
(9, 'Test1', '$2y$10$zcjdebjqBQamelvU14P.0uy4qtNMbKavsGDrT6iywBxBjYbD.1a4m', NULL, NULL, NULL, NULL, NULL, 1),
(10, 'Sasho1', '$2y$10$4AEGfkeX7n8eNQeZQCU1bOwg/kviRKkr08kXVgGws.1k2VCKmt4sm', NULL, NULL, NULL, NULL, NULL, 1),
(11, 'Filip1', '$2y$10$5AN4Gjf1Ij.3ee3dD46DYuC7CXvIwE3xltn8Wdv8JKidWlW2UcL/6', NULL, NULL, NULL, NULL, NULL, 1),
(12, 'Filip2', '$2y$10$Wzm26m3KLf6pN9JGqd.gW.hJizRqOQ6YZAWiUbEyR8G.f0OGgj42W', NULL, NULL, NULL, NULL, NULL, 1),
(13, 'Biser Papov', '$2y$10$J/H3NgsGE79rgfhIdEZ22eGZzO9Tqpp.MMReAGkoGmLLG62t3EimS', NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_role_user_id_role_id_uindex` (`user_id`,`role_id`),
  KEY `user_role_roles_id_fk` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `user_id`, `role_id`) VALUES
(1, 3, 2),
(2, 4, 1),
(3, 5, 2),
(4, 6, 2),
(5, 7, 2),
(6, 8, 2),
(7, 9, 2),
(8, 10, 2),
(9, 11, 2),
(10, 12, 2),
(11, 13, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buildings`
--
ALTER TABLE `buildings`
  ADD CONSTRAINT `buildings_heroes_id_fk` FOREIGN KEY (`heroes_id`) REFERENCES `heroes` (`id`),
  ADD CONSTRAINT `buildings_type_of_buildings_id_fk` FOREIGN KEY (`type_of_buildings_id`) REFERENCES `type_of_buildings` (`id`);

--
-- Constraints for table `heroes`
--
ALTER TABLE `heroes`
  ADD CONSTRAINT `heroes_city_id_fk` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  ADD CONSTRAINT `heroes_level_id_fk` FOREIGN KEY (`level_id`) REFERENCES `level` (`id`),
  ADD CONSTRAINT `heroes_type_of_heroes_id_fk` FOREIGN KEY (`type_of_heroes_id`) REFERENCES `type_of_heroes` (`id`),
  ADD CONSTRAINT `heroes_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_heroes_id_fk` FOREIGN KEY (`hero_id`) REFERENCES `heroes` (`id`),
  ADD CONSTRAINT `items_type_of_items_id_fk` FOREIGN KEY (`type_of_item_id`) REFERENCES `type_of_items` (`id`);

--
-- Constraints for table `monsters`
--
ALTER TABLE `monsters`
  ADD CONSTRAINT `monsters_city_id_fk` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  ADD CONSTRAINT `monsters_type_monsters_id_fk` FOREIGN KEY (`type_monsters_id`) REFERENCES `type_monsters` (`id`);

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_heroes_id_fk` FOREIGN KEY (`hero_id`) REFERENCES `heroes` (`id`),
  ADD CONSTRAINT `recipes_type_of_recipes_id_fk` FOREIGN KEY (`type_of_recipes_id`) REFERENCES `type_of_recipes` (`id`);

--
-- Constraints for table `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_heroes_id_fk` FOREIGN KEY (`heroes_id`) REFERENCES `heroes` (`id`),
  ADD CONSTRAINT `resources_type_of_resources_id_fk` FOREIGN KEY (`type_of_resources_id`) REFERENCES `type_of_resources` (`id`);

--
-- Constraints for table `shop`
--
ALTER TABLE `shop`
  ADD CONSTRAINT `shop_type_of_items_id_fk` FOREIGN KEY (`type_of_item_id`) REFERENCES `type_of_items` (`id`);

--
-- Constraints for table `skils`
--
ALTER TABLE `skils`
  ADD CONSTRAINT `skils_type_of_heroes_id_fk` FOREIGN KEY (`type_of_heroes_id`) REFERENCES `type_of_heroes` (`id`);

--
-- Constraints for table `type_of_recipes`
--
ALTER TABLE `type_of_recipes`
  ADD CONSTRAINT `type_of_recipes_type_of_items_id_fk` FOREIGN KEY (`type_of_item_id`) REFERENCES `type_of_items` (`id`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_roles_id_fk` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `user_role_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
