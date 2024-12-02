-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 18, 2022 at 10:30 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zi_banke`
--

-- --------------------------------------------------------

--
-- Table structure for table `historic`
--

CREATE TABLE `historic` (
  `historic_id` int(11) NOT NULL,
  `historic_to` int(11) DEFAULT NULL,
  `historic_from` int(11) DEFAULT NULL,
  `historic_amount` float NOT NULL,
  `historic_date` datetime NOT NULL,
  `historic_add` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `users_nom` varchar(100) NOT NULL,
  `users_prenom` varchar(100) NOT NULL,
  `users_pass` varchar(150) NOT NULL,
  `users_mail` varchar(255) NOT NULL,
  `users_solde` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `historic`
--
ALTER TABLE `historic`
  ADD PRIMARY KEY (`historic_id`),
  ADD KEY `Fk_userTo` (`historic_to`),
  ADD KEY `Fk_userFrom` (`historic_from`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `historic`
--
ALTER TABLE `historic`
  MODIFY `historic_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `historic`
--
ALTER TABLE `historic`
  ADD CONSTRAINT `Fk_userFrom` FOREIGN KEY (`historic_from`) REFERENCES `users` (`users_id`),
  ADD CONSTRAINT `Fk_userTo` FOREIGN KEY (`historic_to`) REFERENCES `users` (`users_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
