-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2021 at 08:47 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensi_cloud`
--

-- --------------------------------------------------------

--
-- Table structure for table `dac_roles`
--

CREATE TABLE `dac_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dac_rule_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dac_rules`
--

CREATE TABLE `dac_rules` (
  `id` int(11) NOT NULL,
  `kode` varchar(45) DEFAULT NULL,
  `jurusans_id` int(11) NOT NULL,
  `entity` varchar(45) DEFAULT NULL,
  `field` varchar(45) DEFAULT NULL,
  `operator` enum('=','!=','<','>','<=','>=') DEFAULT NULL,
  `value` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fakultass`
--

CREATE TABLE `fakultass` (
  `id` int(11) NOT NULL,
  `nama` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fakultass`
--

INSERT INTO `fakultass` (`id`, `nama`) VALUES
(2, 'Kedokteran'),
(3, 'Industri Kreatif'),
(4, 'Hukum'),
(5, 'Psikologi'),
(6, 'Bisnis dan Ekonomika'),
(7, 'Teknik'),
(8, 'Teknobio'),
(9, 'Farmasi');

-- --------------------------------------------------------

--
-- Table structure for table `jurusans`
--

CREATE TABLE `jurusans` (
  `id` int(11) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `fakultass_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `metadatas`
--

CREATE TABLE `metadatas` (
  `id` int(11) NOT NULL,
  `entity` varchar(45) NOT NULL,
  `custom_field` varchar(45) NOT NULL,
  `jurusans_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `jabatan` enum('admin','dekan','wadek','kajur','kalab','dosen','mhs') DEFAULT NULL,
  `fakultass_id` int(11) NOT NULL,
  `jurusans_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `jabatan`, `fakultass_id`, `jurusans_id`) VALUES
(1, 'a802784', 'f984429a66a22f53b0b7df53af6504d65ab786f9', 'Administrator', 'admin', 2, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dac_roles`
--
ALTER TABLE `dac_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dac_roles_users1_idx` (`user_id`),
  ADD KEY `fk_dac_roles_dac_rules2_idx` (`dac_rule_id`);

--
-- Indexes for table `dac_rules`
--
ALTER TABLE `dac_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dac_rules_fakultass1_idx` (`jurusans_id`);

--
-- Indexes for table `fakultass`
--
ALTER TABLE `fakultass`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jurusans`
--
ALTER TABLE `jurusans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jurusans_fakultass1_idx` (`fakultass_id`);

--
-- Indexes for table `metadatas`
--
ALTER TABLE `metadatas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_metadatas_universitass1_idx` (`jurusans_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_fakultass2_idx` (`fakultass_id`),
  ADD KEY `fk_users_jurusans1_idx` (`jurusans_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dac_roles`
--
ALTER TABLE `dac_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dac_rules`
--
ALTER TABLE `dac_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fakultass`
--
ALTER TABLE `fakultass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jurusans`
--
ALTER TABLE `jurusans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `metadatas`
--
ALTER TABLE `metadatas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dac_roles`
--
ALTER TABLE `dac_roles`
  ADD CONSTRAINT `fk_dac_roles_dac_rules2` FOREIGN KEY (`dac_rule_id`) REFERENCES `dac_rules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dac_roles_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `dac_rules`
--
ALTER TABLE `dac_rules`
  ADD CONSTRAINT `fk_dac_rules_fakultass1` FOREIGN KEY (`jurusans_id`) REFERENCES `jurusans` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jurusans`
--
ALTER TABLE `jurusans`
  ADD CONSTRAINT `fk_jurusans_fakultass1` FOREIGN KEY (`fakultass_id`) REFERENCES `fakultass` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `metadatas`
--
ALTER TABLE `metadatas`
  ADD CONSTRAINT `fk_metadatas_universitass1` FOREIGN KEY (`jurusans_id`) REFERENCES `jurusans` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_fakultass2` FOREIGN KEY (`fakultass_id`) REFERENCES `fakultass` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_jurusans1` FOREIGN KEY (`jurusans_id`) REFERENCES `jurusans` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
