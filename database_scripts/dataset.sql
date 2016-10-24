-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Φιλοξενητής: localhost
-- Χρόνος δημιουργίας: 24 Οκτ 2016 στις 12:58:53
-- Έκδοση διακομιστή: 5.6.31-0ubuntu0.15.10.1
-- Έκδοση PHP: 5.6.11-1ubuntu3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `dataset`
--
CREATE DATABASE IF NOT EXISTS `dataset` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dataset`;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `logging`
--

DROP TABLE IF EXISTS `logging`;
CREATE TABLE IF NOT EXISTS `logging` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `operation` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `measurements`
--

DROP TABLE IF EXISTS `measurements`;
CREATE TABLE IF NOT EXISTS `measurements` (
  `id` int(11) NOT NULL,
  `node_name` varchar(255) NOT NULL,
  `resource_name` varchar(255) NOT NULL,
  `value` float NOT NULL,
  `unit` varchar(64) NOT NULL,
  `pos_x` float NOT NULL,
  `pos_y` float NOT NULL,
  `pos_z` float NOT NULL,
  `timestamp` datetime NOT NULL,
  `time_of_collection` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seconds_in_day` int(11) NOT NULL,
  `timestamp_unix` bigint(20) NOT NULL,
  `time_of_collection_unix` bigint(20) NOT NULL,
  `relative_position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Δείκτες `measurements`
--
DROP TRIGGER IF EXISTS `timestamp_insert_trigger`;
DELIMITER $$
CREATE TRIGGER `timestamp_insert_trigger` BEFORE INSERT ON `measurements`
 FOR EACH ROW BEGIN
        
            SET NEW.timestamp_unix = UNIX_TIMESTAMP(NEW.timestamp);
            SET NEW.`time_of_collection_unix` = UNIX_TIMESTAMP(NEW.`time_of_collection`);
        
    END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `timestamp_update_trigger`;
DELIMITER $$
CREATE TRIGGER `timestamp_update_trigger` BEFORE UPDATE ON `measurements`
 FOR EACH ROW BEGIN
        
            SET NEW.timestamp_unix = UNIX_TIMESTAMP(OLD.timestamp);
            SET NEW.`time_of_collection_unix` = UNIX_TIMESTAMP(OLD.`time_of_collection`);
        
    END
$$
DELIMITER ;

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `logging`
--
ALTER TABLE `logging`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `measurements`
--
ALTER TABLE `measurements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `node_name` (`node_name`,`resource_name`,`timestamp`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `logging`
--
ALTER TABLE `logging`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `measurements`
--
ALTER TABLE `measurements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
