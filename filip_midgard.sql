-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Dec 08, 2016 at 04:01 PM
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
  PRIMARY KEY (`id`),
  KEY `heroes_users_id_fk` (`user_id`),
  KEY `heroes_type_of_heroes_id_fk` (`type_of_heroes_id`),
  KEY `heroes_city_id_fk` (`city_id`),
  KEY `heroes_level_id_fk` (`level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='hero_status : Create - 0; Delete - 10; Play - 1; In Battle - 2' AUTO_INCREMENT=29 ;

--
-- Dumping data for table `heroes`
--

INSERT INTO `heroes` (`id`, `user_id`, `type_of_heroes_id`, `level_id`, `city_id`, `real_health`, `experience`, `real_mana`, `name`, `hero_status`, `damage_low_value`, `damage_high_value`, `armor`, `strength`, `magic`, `vitality`, `dexterity`, `health`, `mana`, `critical`) VALUES
(16, 4, 1, 1, 1, 400, 0, 120, 'DjinHa', 0, 15, 15, 30, 30, 10, 30, 15, 400, 120, 0.15),
(17, 4, 1, 1, 1, 400, 0, 120, 'SolLi', 0, 15, 15, 30, 30, 10, 30, 15, 400, 120, 0.15),
(18, 4, 4, 1, 1, 250, 0, 370, 'Test1', 0, 8, 8, 40, 15, 30, 20, 20, 250, 370, 0.2),
(19, 4, 1, 1, 1, 400, 0, 120, 'Warrior', 0, 15, 15, 30, 30, 10, 30, 15, 400, 120, 0.15),
(20, 4, 2, 1, 1, 280, 0, 190, 'Marksman', 0, 10, 10, 60, 20, 15, 20, 30, 280, 190, 0.3),
(21, 4, 4, 1, 1, 250, 0, 370, 'Wizard', 0, 8, 8, 40, 15, 30, 20, 20, 250, 370, 0.2),
(22, 4, 4, 1, 1, 250, 0, 370, 'Wizard1', 0, 8, 8, 40, 15, 30, 20, 20, 250, 370, 0.2),
(23, 4, 4, 1, 1, 250, 0, 370, 'Wizard3', 0, 8, 8, 40, 15, 30, 20, 20, 250, 370, 0.2),
(24, 4, 1, 1, 1, 400, 0, 120, 'War', 0, 15, 15, 30, 30, 10, 30, 15, 400, 120, 0.15),
(25, 4, 2, 1, 1, 280, 0, 190, 'Mark', 0, 10, 10, 60, 20, 15, 20, 30, 280, 190, 0.3),
(26, 4, 4, 1, 1, 250, 0, 370, 'wiz', 0, 8, 8, 40, 15, 30, 20, 20, 250, 370, 0.2),
(27, 4, 4, 1, 1, 250, 0, 370, 'w', 0, 8, 8, 40, 15, 30, 20, 20, 250, 370, 0.2),
(28, 4, 4, 1, 1, 250, 0, 370, 'Wili', 1, 8, 8, 40, 15, 30, 20, 20, 250, 370, 0.2);

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
  PRIMARY KEY (`id`),
  KEY `items_type_of_items_id_fk` (`type_of_item_id`),
  KEY `items_heroes_id_fk` (`hero_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='is_equiped : 1 - true; 0 - false; ' AUTO_INCREMENT=23 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `damage_low_value`, `armor`, `strength`, `vitality`, `magic`, `dexterity`, `health`, `mana`, `type_of_item_id`, `hero_id`, `item_level`, `is_equiped`, `damage_high_value`, `critical`) VALUES
(3, 0, 10, 0, 1, 0, 0, 0, 0, 2, 16, 1, 1, 0, 0),
(4, 5, 0, 1, 0, 0, 0, 0, 0, 8, 16, 1, 1, 8, 0),
(5, 0, 10, 0, 1, 0, 0, 0, 0, 2, 17, 1, 1, 0, 0),
(6, 5, 0, 1, 0, 0, 0, 0, 0, 8, 17, 1, 1, 8, 0),
(7, 0, 10, 0, 1, 0, 0, 0, 0, 2, 18, 1, 1, 0, 0),
(8, 0, 10, 0, 1, 0, 0, 0, 0, 2, 19, 1, 1, 0, 0),
(9, 5, 0, 1, 0, 0, 0, 0, 0, 8, 19, 1, 1, 8, 0),
(10, 0, 10, 0, 1, 0, 0, 0, 0, 2, 20, 1, 1, 0, 0),
(11, 4, 0, 0, 0, 0, 1, 0, 0, 11, 20, 1, 1, 7, 0),
(12, 0, 10, 0, 1, 0, 0, 0, 0, 2, 21, 1, 1, 0, 0),
(13, 0, 10, 0, 1, 0, 0, 0, 0, 2, 22, 1, 1, 0, 0),
(14, 0, 10, 0, 1, 0, 0, 0, 0, 2, 23, 1, 1, 0, 0),
(15, 0, 10, 0, 1, 0, 0, 0, 0, 2, 24, 1, 1, 0, 0),
(16, 5, 0, 1, 0, 0, 0, 0, 0, 8, 24, 1, 1, 8, 0),
(17, 0, 10, 0, 1, 0, 0, 0, 0, 2, 25, 1, 1, 0, 0),
(18, 4, 0, 0, 0, 0, 1, 0, 0, 11, 25, 1, 1, 7, 0),
(19, 0, 10, 0, 1, 0, 0, 0, 0, 2, 26, 1, 1, 0, 0),
(20, 0, 10, 0, 1, 0, 0, 0, 0, 2, 27, 1, 1, 0, 0),
(21, 0, 10, 0, 1, 0, 0, 0, 0, 2, 28, 1, 1, 0, 0),
(22, 3, 0, 0, 0, 1, 0, 0, 0, 10, 28, 1, 1, 6, 0);

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
  `damage` int(11) DEFAULT NULL,
  `armor` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `monsters_type_monsters_id_fk` (`type_monsters_id`),
  KEY `monsters_city_id_fk` (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=97 ;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `type_of_resources_id`, `heroes_id`, `amount`) VALUES
(37, 1, 16, 0),
(38, 2, 16, 1000),
(39, 3, 16, 0),
(40, 4, 16, 0),
(41, 5, 16, 0),
(42, 6, 16, 0),
(43, 1, 17, 0),
(44, 2, 17, 1000),
(45, 3, 17, 0),
(46, 4, 17, 0),
(47, 5, 17, 0),
(48, 6, 17, 0),
(49, 1, 18, 0),
(50, 2, 18, 1000),
(51, 3, 18, 0),
(52, 4, 18, 0),
(53, 5, 18, 0),
(54, 6, 18, 0),
(55, 1, 19, 0),
(56, 2, 19, 1000),
(57, 3, 19, 0),
(58, 4, 19, 0),
(59, 5, 19, 0),
(60, 6, 19, 0),
(61, 1, 20, 0),
(62, 2, 20, 1000),
(63, 3, 20, 0),
(64, 4, 20, 0),
(65, 5, 20, 0),
(66, 6, 20, 0),
(67, 1, 21, 0),
(68, 2, 21, 1000),
(69, 3, 21, 0),
(70, 4, 21, 0),
(71, 5, 21, 0),
(72, 6, 21, 0),
(73, 1, 22, 0),
(74, 2, 22, 1000),
(75, 3, 22, 0),
(76, 4, 22, 0),
(77, 5, 22, 0),
(78, 6, 22, 0),
(79, 1, 24, 0),
(80, 2, 24, 1000),
(81, 3, 24, 0),
(82, 4, 24, 0),
(83, 5, 24, 0),
(84, 6, 24, 0),
(85, 1, 25, 0),
(86, 2, 25, 1000),
(87, 3, 25, 0),
(88, 4, 25, 0),
(89, 5, 25, 0),
(90, 6, 25, 0),
(91, 1, 28, 0),
(92, 2, 28, 1000),
(93, 3, 28, 0),
(94, 4, 28, 0),
(95, 5, 28, 0),
(96, 6, 28, 0);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='For_type_of_heroes : 0 - all; 1 - Warrior; 2 - marksman; 3 - wizard' AUTO_INCREMENT=13 ;

--
-- Dumping data for table `type_of_items`
--

INSERT INTO `type_of_items` (`id`, `name`, `for_type_of_heroes`) VALUES
(1, 'axe', 1),
(2, 'armor', 0),
(3, 'helm', 0),
(4, 'gloves', 0),
(5, 'boots', 0),
(6, 'ring', 0),
(7, 'necklace', 0),
(8, 'sword', 1),
(9, 'dagger', 1),
(10, 'staff', 3),
(11, 'bow', 2),
(12, 'shield', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='is_active (1-true, 0-false)' AUTO_INCREMENT=10 ;

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
(9, 'Test1', '$2y$10$zcjdebjqBQamelvU14P.0uy4qtNMbKavsGDrT6iywBxBjYbD.1a4m', NULL, NULL, NULL, NULL, NULL, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

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
(7, 9, 2);

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
-- Constraints for table `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_heroes_id_fk` FOREIGN KEY (`heroes_id`) REFERENCES `heroes` (`id`),
  ADD CONSTRAINT `resources_type_of_resources_id_fk` FOREIGN KEY (`type_of_resources_id`) REFERENCES `type_of_resources` (`id`);

--
-- Constraints for table `skils`
--
ALTER TABLE `skils`
  ADD CONSTRAINT `skils_type_of_heroes_id_fk` FOREIGN KEY (`type_of_heroes_id`) REFERENCES `type_of_heroes` (`id`);

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_roles_id_fk` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `user_role_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
