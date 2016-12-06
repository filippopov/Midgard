-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2016 at 09:52 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `midgard`
--

-- --------------------------------------------------------

--
-- Table structure for table `buildings`
--

CREATE TABLE `buildings` (
  `id` int(11) NOT NULL,
  `type_of_buildings_id` int(11) DEFAULT NULL,
  `heroes_id` int(11) DEFAULT NULL,
  `lavel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `coordinates_x` int(11) DEFAULT NULL,
  `coordinates_y` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `heroes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type_of_heroes_id` int(11) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `real_health` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `experience_to_next_level` int(11) DEFAULT NULL,
  `real_mana` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `damage` int(11) DEFAULT NULL,
  `armor` int(11) DEFAULT NULL,
  `strength` int(11) DEFAULT NULL,
  `vitality` int(11) DEFAULT NULL,
  `megic` int(11) DEFAULT NULL,
  `dexterity` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL,
  `mana` int(11) DEFAULT NULL,
  `type_of_item_id` int(11) DEFAULT NULL,
  `hero_id` int(11) DEFAULT NULL,
  `item_lave` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `monsters`
--

CREATE TABLE `monsters` (
  `id` int(11) NOT NULL,
  `type_monsters_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `damage` int(11) DEFAULT NULL,
  `armor` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `type_of_resources_id` int(11) DEFAULT NULL,
  `heroes_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `skils` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type_of_heroes_id` int(11) DEFAULT NULL,
  `lavel` int(11) DEFAULT NULL,
  `is_active` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `type_monsters`
--

CREATE TABLE `type_monsters` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE `type_of_buildings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type_of_buildings`
--

INSERT INTO `type_of_buildings` (`id`, `name`) VALUES
(1, 'gold mine');

-- --------------------------------------------------------

--
-- Table structure for table `type_of_heroes`
--

CREATE TABLE `type_of_heroes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `strength` int(11) DEFAULT NULL,
  `vitality` int(11) DEFAULT NULL,
  `megic` int(11) DEFAULT NULL,
  `dexterity` int(11) DEFAULT NULL,
  `health` int(11) DEFAULT NULL,
  `mana` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type_of_heroes`
--

INSERT INTO `type_of_heroes` (`id`, `name`, `strength`, `vitality`, `megic`, `dexterity`, `health`, `mana`) VALUES
(1, 'Warrior', 30, 30, 10, 15, 100, 20),
(2, 'Marksman', 20, 20, 15, 30, 80, 40),
(4, 'Wizard', 15, 20, 30, 20, 50, 70);

-- --------------------------------------------------------

--
-- Table structure for table `type_of_items`
--

CREATE TABLE `type_of_items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type_of_items`
--

INSERT INTO `type_of_items` (`id`, `name`) VALUES
(1, 'axe'),
(2, 'armor'),
(3, 'helm'),
(4, 'gloves'),
(5, 'boots'),
(6, 'ring'),
(7, 'necklace'),
(8, 'sword'),
(9, 'dagger'),
(10, 'staff'),
(11, 'bow');

-- --------------------------------------------------------

--
-- Table structure for table `type_of_resources`
--

CREATE TABLE `type_of_resources` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type_of_resources`
--

INSERT INTO `type_of_resources` (`id`, `name`) VALUES
(2, 'gold'),
(1, 'honur');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='is_active (1-true, 0-false)';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first_name`, `last_name`, `full_name`, `birthday`, `is_active`) VALUES
(3, 'Biskata', '$2y$10$c7uQfln7aRc8MGHazcXXyujD1lijMRihYjQbi/GaK2Fs3Xak9cUjm', NULL, NULL, NULL, NULL, NULL, 1),
(4, 'Filip', '$2y$10$qltTLucZWs9BZmZNJZSnNuEb5N79U53hhimG8Q8t1R3bdwEsC3UiK', NULL, NULL, NULL, NULL, NULL, 1),
(5, 'Sasho', '$2y$10$RvdJTJvIEtOhOlhiahYArundAqvuelcoNj3HhgH7gYBpqE9a7DLiu', NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `user_id`, `role_id`) VALUES
(1, 3, 2),
(2, 4, 1),
(3, 5, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buildings`
--
ALTER TABLE `buildings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buildings_type_of_buildings_id_fk` (`type_of_buildings_id`),
  ADD KEY `buildings_heroes_id_fk` (`heroes_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `heroes`
--
ALTER TABLE `heroes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `heroes_users_id_fk` (`user_id`),
  ADD KEY `heroes_type_of_heroes_id_fk` (`type_of_heroes_id`),
  ADD KEY `heroes_city_id_fk` (`city_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `items_type_of_items_id_fk` (`type_of_item_id`),
  ADD KEY `items_heroes_id_fk` (`hero_id`);

--
-- Indexes for table `monsters`
--
ALTER TABLE `monsters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `monsters_type_monsters_id_fk` (`type_monsters_id`),
  ADD KEY `monsters_city_id_fk` (`city_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resources_type_of_resources_id_fk` (`type_of_resources_id`),
  ADD KEY `resources_heroes_id_fk` (`heroes_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name_uindex` (`name`);

--
-- Indexes for table `skils`
--
ALTER TABLE `skils`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skils_type_of_heroes_id_fk` (`type_of_heroes_id`);

--
-- Indexes for table `type_monsters`
--
ALTER TABLE `type_monsters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_of_buildings`
--
ALTER TABLE `type_of_buildings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_of_heroes`
--
ALTER TABLE `type_of_heroes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_of_heroes_name_uindex` (`name`);

--
-- Indexes for table `type_of_items`
--
ALTER TABLE `type_of_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_of_resources`
--
ALTER TABLE `type_of_resources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_of_resources_name_uindex` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_uindex` (`username`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_role_user_id_role_id_uindex` (`user_id`,`role_id`),
  ADD KEY `user_role_roles_id_fk` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buildings`
--
ALTER TABLE `buildings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `heroes`
--
ALTER TABLE `heroes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `monsters`
--
ALTER TABLE `monsters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `skils`
--
ALTER TABLE `skils`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `type_monsters`
--
ALTER TABLE `type_monsters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `type_of_buildings`
--
ALTER TABLE `type_of_buildings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `type_of_heroes`
--
ALTER TABLE `type_of_heroes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `type_of_items`
--
ALTER TABLE `type_of_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `type_of_resources`
--
ALTER TABLE `type_of_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
