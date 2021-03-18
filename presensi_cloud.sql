-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2021 at 11:41 AM
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
-- Table structure for table `metadatas`
--

CREATE TABLE `metadatas` (
  `id` int(11) NOT NULL,
  `entity` varchar(45) NOT NULL,
  `custom_field` varchar(45) NOT NULL,
  `fakultas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fakultass`
--
ALTER TABLE `fakultass`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metadatas`
--
ALTER TABLE `metadatas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_metadatas_universitass1_idx` (`fakultas_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fakultass`
--
ALTER TABLE `fakultass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `metadatas`
--
ALTER TABLE `metadatas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `metadatas`
--
ALTER TABLE `metadatas`
  ADD CONSTRAINT `fk_metadatas_universitass1` FOREIGN KEY (`fakultas_id`) REFERENCES `fakultass` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
