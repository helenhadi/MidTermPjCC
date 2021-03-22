-- MySQL Script generated by MySQL Workbench
-- Sun Mar 21 14:30:34 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema presensi_cloud
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `mahasiswas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mahasiswas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nrp` VARCHAR(255) NULL DEFAULT NULL,
  `user_id` INT(11) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `matakuliahs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `matakuliahs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `matakuliahs_buka`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `matakuliahs_buka` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `kp` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `matakuliahs_kp`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `matakuliahs_kp` (
  `matakuliahs_id` INT(11) NOT NULL,
  `matakuliahs_buka_id` INT(11) NOT NULL,
  `kapasitas` VARCHAR(45) NOT NULL,
  `dosen_id` INT(11) NOT NULL,
  PRIMARY KEY (`matakuliahs_id`, `matakuliahs_buka_id`),
  INDEX `fk_matakuliahs_has_matakuliahs_buka_matakuliahs_buka1_idx` (`matakuliahs_buka_id` ASC),
  INDEX `fk_matakuliahs_has_matakuliahs_buka_matakuliahs1_idx` (`matakuliahs_id` ASC),
  CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_matakuliahs1`
    FOREIGN KEY (`matakuliahs_id`)
    REFERENCES `matakuliahs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_matakuliahs_buka1`
    FOREIGN KEY (`matakuliahs_buka_id`)
    REFERENCES `matakuliahs_buka` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `ambil_matakuliahs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ambil_matakuliahs` (
  `mahasiswas_id` INT(11) NOT NULL,
  `matakuliahs_id` INT(11) NOT NULL,
  `matakuliahs_buka_id` INT(11) NOT NULL,
  PRIMARY KEY (`mahasiswas_id`, `matakuliahs_id`, `matakuliahs_buka_id`),
  INDEX `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_matakuli_idx` (`matakuliahs_id` ASC, `matakuliahs_buka_id` ASC),
  INDEX `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_mahasisw_idx` (`mahasiswas_id` ASC),
  CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_mahasiswas1`
    FOREIGN KEY (`mahasiswas_id`)
    REFERENCES `mahasiswas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_matakuliah1`
    FOREIGN KEY (`matakuliahs_id` , `matakuliahs_buka_id`)
    REFERENCES `matakuliahs_kp` (`matakuliahs_id` , `matakuliahs_buka_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `jadwals`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jadwals` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `hari` VARCHAR(45) NOT NULL,
  `jam_mulai` VARCHAR(45) NOT NULL,
  `jam_selesai` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `jadwal_matakuliahs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `jadwal_matakuliahs` (
  `matakuliahs_id` INT(11) NOT NULL,
  `matakuliahs_buka_id` INT(11) NOT NULL,
  `jadwals_id` INT(11) NOT NULL,
  PRIMARY KEY (`matakuliahs_id`, `matakuliahs_buka_id`, `jadwals_id`),
  INDEX `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_jadwals1_idx` (`jadwals_id` ASC),
  INDEX `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_matakuliahs_idx` (`matakuliahs_id` ASC, `matakuliahs_buka_id` ASC),
  CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_jadwals1`
    FOREIGN KEY (`jadwals_id`)
    REFERENCES `jadwals` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_matakuliahs_h1`
    FOREIGN KEY (`matakuliahs_id` , `matakuliahs_buka_id`)
    REFERENCES `matakuliahs_kp` (`matakuliahs_id` , `matakuliahs_buka_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `kehadirans`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `kehadirans` (
  `mahasiswas_id` INT(11) NOT NULL,
  `matakuliahs_id` INT(11) NOT NULL,
  `matakuliahs_buka_id` INT(11) NOT NULL,
  `jadwals_id` INT(11) NOT NULL,
  `tanggal` DATETIME NULL DEFAULT NULL,
  `e_code` VARCHAR(45) NULL DEFAULT NULL,
  `status` ENUM('HADIR', 'TIDAK HADIR', 'IZIN') NULL DEFAULT 'HADIR',
  `aktif_to` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`mahasiswas_id`, `matakuliahs_id`, `matakuliahs_buka_id`, `jadwals_id`),
  INDEX `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadw_idx` (`matakuliahs_id` ASC, `matakuliahs_buka_id` ASC, `jadwals_id` ASC),
  INDEX `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadw_idx1` (`mahasiswas_id` ASC),
  CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadwal1`
    FOREIGN KEY (`mahasiswas_id`)
    REFERENCES `mahasiswas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadwal2`
    FOREIGN KEY (`matakuliahs_id` , `matakuliahs_buka_id` , `jadwals_id`)
    REFERENCES `jadwal_matakuliahs` (`matakuliahs_id` , `matakuliahs_buka_id` , `jadwals_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `karyawans`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `karyawans` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `npk` VARCHAR(255) NULL,
  `user_id` INT(11) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dac_rules`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dac_rules` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `kode` VARCHAR(45) NULL,
  `entity` VARCHAR(45) NULL,
  `field` VARCHAR(45) NULL,
  `operator` ENUM('=', '!=', '<', '>', '<=', '>=') NULL,
  `value` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dac_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dac_roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `karyawan_id` INT NOT NULL,
  `dac_rule_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_dac_roles_dac_rules1_idx` (`dac_rule_id` ASC),
  INDEX `fk_dac_roles_karyawan1_idx` (`karyawan_id` ASC),
  CONSTRAINT `fk_dac_roles_dac_rules1`
    FOREIGN KEY (`dac_rule_id`)
    REFERENCES `dac_rules` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dac_roles_karyawan1`
    FOREIGN KEY (`karyawan_id`)
    REFERENCES `karyawans` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
