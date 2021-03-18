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
-- Database: `master_schema`
--

-- --------------------------------------------------------

--
-- Table structure for table `ambil_matakuliahs`
--

CREATE TABLE `ambil_matakuliahs` (
  `mahasiswas_id` int(11) NOT NULL,
  `matakuliahs_id` int(11) NOT NULL,
  `matakuliahs_buka_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dac_roles`
--

CREATE TABLE `dac_roles` (
  `id` int(11) NOT NULL,
  `karyawan_id` int(11) NOT NULL,
  `dac_rule_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dac_rules`
--

CREATE TABLE `dac_rules` (
  `id` int(11) NOT NULL,
  `kode` varchar(45) DEFAULT NULL,
  `entity` varchar(45) DEFAULT NULL,
  `field` varchar(45) DEFAULT NULL,
  `operator` enum('=','!=','<','>','<=','>=') DEFAULT NULL,
  `value` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jadwals`
--

CREATE TABLE `jadwals` (
  `id` int(11) NOT NULL,
  `hari` varchar(45) NOT NULL,
  `jam_mulai` varchar(45) NOT NULL,
  `jam_selesai` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_matakuliahs`
--

CREATE TABLE `jadwal_matakuliahs` (
  `matakuliahs_id` int(11) NOT NULL,
  `matakuliahs_buka_id` int(11) NOT NULL,
  `jadwals_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jurusans`
--

CREATE TABLE `jurusans` (
  `id` int(11) NOT NULL,
  `kode` varchar(45) NOT NULL,
  `nama` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `karyawans`
--

CREATE TABLE `karyawans` (
  `id` int(11) NOT NULL,
  `npk` varchar(255) DEFAULT NULL,
  `jabatan` enum('dekan','wadek','kajur','kalab','dosen') DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kehadirans`
--

CREATE TABLE `kehadirans` (
  `mahasiswas_id` int(11) NOT NULL,
  `matakuliahs_id` int(11) NOT NULL,
  `matakuliahs_buka_id` int(11) NOT NULL,
  `jadwals_id` int(11) NOT NULL,
  `tanggal` datetime DEFAULT NULL,
  `e_code` varchar(45) DEFAULT NULL,
  `status` enum('HADIR','TIDAK HADIR','IZIN') DEFAULT 'HADIR',
  `aktif_to` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswas`
--

CREATE TABLE `mahasiswas` (
  `id` int(11) NOT NULL,
  `nrp` varchar(255) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `matakuliahs`
--

CREATE TABLE `matakuliahs` (
  `id` int(11) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `jurusans_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `matakuliahs_buka`
--

CREATE TABLE `matakuliahs_buka` (
  `id` int(11) NOT NULL,
  `kp` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `matakuliahs_kp`
--

CREATE TABLE `matakuliahs_kp` (
  `matakuliahs_id` int(11) NOT NULL,
  `matakuliahs_buka_id` int(11) NOT NULL,
  `kapasitas` varchar(45) NOT NULL
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
  `jabatan` enum('admin','rektor','warek','karuniversitas','karfakultas') DEFAULT NULL,
  `fakultas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `jabatan`, `fakultas_id`) VALUES
(0, 'a802784', 'f984429a66a22f53b0b7df53af6504d65ab786f9', 'Admin', 'admin', 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ambil_matakuliahs`
--
ALTER TABLE `ambil_matakuliahs`
  ADD PRIMARY KEY (`mahasiswas_id`,`matakuliahs_id`,`matakuliahs_buka_id`),
  ADD KEY `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_matakuli_idx` (`matakuliahs_id`,`matakuliahs_buka_id`),
  ADD KEY `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_mahasisw_idx` (`mahasiswas_id`);

--
-- Indexes for table `dac_roles`
--
ALTER TABLE `dac_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_dac_roles_dac_rules1_idx` (`dac_rule_id`),
  ADD KEY `fk_dac_roles_karyawan1_idx` (`karyawan_id`);

--
-- Indexes for table `dac_rules`
--
ALTER TABLE `dac_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_matakuliahs`
--
ALTER TABLE `jadwal_matakuliahs`
  ADD PRIMARY KEY (`matakuliahs_id`,`matakuliahs_buka_id`,`jadwals_id`),
  ADD KEY `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_jadwals1_idx` (`jadwals_id`),
  ADD KEY `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_matakuliahs_idx` (`matakuliahs_id`,`matakuliahs_buka_id`);

--
-- Indexes for table `jurusans`
--
ALTER TABLE `jurusans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawans`
--
ALTER TABLE `karyawans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kehadirans`
--
ALTER TABLE `kehadirans`
  ADD PRIMARY KEY (`mahasiswas_id`,`matakuliahs_id`,`matakuliahs_buka_id`,`jadwals_id`),
  ADD KEY `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadw_idx` (`matakuliahs_id`,`matakuliahs_buka_id`,`jadwals_id`),
  ADD KEY `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadw_idx1` (`mahasiswas_id`);

--
-- Indexes for table `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `matakuliahs`
--
ALTER TABLE `matakuliahs`
  ADD PRIMARY KEY (`id`,`jurusans_id`),
  ADD KEY `fk_matakuliahs_jurusans1_idx` (`jurusans_id`);

--
-- Indexes for table `matakuliahs_buka`
--
ALTER TABLE `matakuliahs_buka`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `matakuliahs_kp`
--
ALTER TABLE `matakuliahs_kp`
  ADD PRIMARY KEY (`matakuliahs_id`,`matakuliahs_buka_id`),
  ADD KEY `fk_matakuliahs_has_matakuliahs_buka_matakuliahs_buka1_idx` (`matakuliahs_buka_id`),
  ADD KEY `fk_matakuliahs_has_matakuliahs_buka_matakuliahs1_idx` (`matakuliahs_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_fakultass1_idx` (`fakultas_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jurusans`
--
ALTER TABLE `jurusans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karyawans`
--
ALTER TABLE `karyawans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ambil_matakuliahs`
--
ALTER TABLE `ambil_matakuliahs`
  ADD CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_mahasiswas1` FOREIGN KEY (`mahasiswas_id`) REFERENCES `mahasiswas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_matakuliah1` FOREIGN KEY (`matakuliahs_id`,`matakuliahs_buka_id`) REFERENCES `matakuliahs_kp` (`matakuliahs_id`, `matakuliahs_buka_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `dac_roles`
--
ALTER TABLE `dac_roles`
  ADD CONSTRAINT `fk_dac_roles_dac_rules1` FOREIGN KEY (`dac_rule_id`) REFERENCES `dac_rules` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dac_roles_karyawan1` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawans` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `jadwal_matakuliahs`
--
ALTER TABLE `jadwal_matakuliahs`
  ADD CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_jadwals1` FOREIGN KEY (`jadwals_id`) REFERENCES `jadwals` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_matakuliahs_h1` FOREIGN KEY (`matakuliahs_id`,`matakuliahs_buka_id`) REFERENCES `matakuliahs_kp` (`matakuliahs_id`, `matakuliahs_buka_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `kehadirans`
--
ALTER TABLE `kehadirans`
  ADD CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadwal1` FOREIGN KEY (`mahasiswas_id`) REFERENCES `mahasiswas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadwal2` FOREIGN KEY (`matakuliahs_id`,`matakuliahs_buka_id`,`jadwals_id`) REFERENCES `jadwal_matakuliahs` (`matakuliahs_id`, `matakuliahs_buka_id`, `jadwals_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `matakuliahs`
--
ALTER TABLE `matakuliahs`
  ADD CONSTRAINT `fk_matakuliahs_jurusans1` FOREIGN KEY (`jurusans_id`) REFERENCES `jurusans` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `matakuliahs_kp`
--
ALTER TABLE `matakuliahs_kp`
  ADD CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_matakuliahs1` FOREIGN KEY (`matakuliahs_id`) REFERENCES `matakuliahs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_matakuliahs_buka1` FOREIGN KEY (`matakuliahs_buka_id`) REFERENCES `matakuliahs_buka` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_fakultass1` FOREIGN KEY (`fakultas_id`) REFERENCES `presensi_cloud`.`fakultass` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
