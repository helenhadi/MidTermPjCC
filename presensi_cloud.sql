-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 16, 2021 at 10:26 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.27

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
-- Table structure for table `metadatas`
--

CREATE TABLE `metadatas` (
  `id` int(11) NOT NULL,
  `entity` varchar(45) NOT NULL,
  `custom_field` varchar(45) NOT NULL,
  `universitass_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `metadatas`
--

INSERT INTO `metadatas` (`id`, `entity`, `custom_field`, `universitass_id`) VALUES
(1, 'fakultass', 'custom1', 1),
(2, 'mahasiswas', 'customo2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `universitass`
--

CREATE TABLE `universitass` (
  `id` int(11) NOT NULL,
  `nama` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `universitass`
--

INSERT INTO `universitass` (`id`, `nama`) VALUES
(1, 'universitasnya');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `metadatas`
--
ALTER TABLE `metadatas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_metadatas_universitass1_idx` (`universitass_id`);

--
-- Indexes for table `universitass`
--
ALTER TABLE `universitass`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `metadatas`
--
ALTER TABLE `metadatas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `universitass`
--
ALTER TABLE `universitass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `metadatas`
--
ALTER TABLE `metadatas`
  ADD CONSTRAINT `fk_metadatas_universitass1` FOREIGN KEY (`universitass_id`) REFERENCES `universitass` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
