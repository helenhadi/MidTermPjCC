-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema master_schema
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema master_schema
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `master_schema` DEFAULT CHARACTER SET utf8mb4 ;
-- -----------------------------------------------------
-- Schema presensi_cloud
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema presensi_cloud
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `presensi_cloud` DEFAULT CHARACTER SET utf8mb4 ;
USE `master_schema` ;

-- -----------------------------------------------------
-- Table `master_schema`.`mahasiswas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`mahasiswas` (
  `id` INT(11) NOT NULL,
  `nrp` VARCHAR(255) NULL DEFAULT NULL,
  `user_id` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `master_schema`.`matakuliahs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`matakuliahs` (
  `id` INT(11) NOT NULL,
  `nama` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `master_schema`.`matakuliahs_buka`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`matakuliahs_buka` (
  `id` INT(11) NOT NULL,
  `kp` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `master_schema`.`matakuliahs_kp`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`matakuliahs_kp` (
  `matakuliahs_id` INT(11) NOT NULL,
  `matakuliahs_buka_id` INT(11) NOT NULL,
  `kapasitas` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`matakuliahs_id`, `matakuliahs_buka_id`),
  INDEX `fk_matakuliahs_has_matakuliahs_buka_matakuliahs_buka1_idx` (`matakuliahs_buka_id` ASC),
  INDEX `fk_matakuliahs_has_matakuliahs_buka_matakuliahs1_idx` (`matakuliahs_id` ASC),
  CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_matakuliahs1`
    FOREIGN KEY (`matakuliahs_id`)
    REFERENCES `master_schema`.`matakuliahs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_matakuliahs_buka1`
    FOREIGN KEY (`matakuliahs_buka_id`)
    REFERENCES `master_schema`.`matakuliahs_buka` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `master_schema`.`ambil_matakuliahs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`ambil_matakuliahs` (
  `mahasiswas_id` INT(11) NOT NULL,
  `matakuliahs_id` INT(11) NOT NULL,
  `matakuliahs_buka_id` INT(11) NOT NULL,
  PRIMARY KEY (`mahasiswas_id`, `matakuliahs_id`, `matakuliahs_buka_id`),
  INDEX `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_matakuli_idx` (`matakuliahs_id` ASC, `matakuliahs_buka_id` ASC),
  INDEX `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_mahasisw_idx` (`mahasiswas_id` ASC),
  CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_mahasiswas1`
    FOREIGN KEY (`mahasiswas_id`)
    REFERENCES `master_schema`.`mahasiswas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_matakuliah1`
    FOREIGN KEY (`matakuliahs_id` , `matakuliahs_buka_id`)
    REFERENCES `master_schema`.`matakuliahs_kp` (`matakuliahs_id` , `matakuliahs_buka_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `master_schema`.`jadwals`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`jadwals` (
  `id` INT(11) NOT NULL,
  `hari` VARCHAR(45) NOT NULL,
  `jam_mulai` VARCHAR(45) NOT NULL,
  `jam_selesai` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `master_schema`.`jadwal_matakuliahs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`jadwal_matakuliahs` (
  `matakuliahs_id` INT(11) NOT NULL,
  `matakuliahs_buka_id` INT(11) NOT NULL,
  `jadwals_id` INT(11) NOT NULL,
  PRIMARY KEY (`matakuliahs_id`, `matakuliahs_buka_id`, `jadwals_id`),
  INDEX `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_jadwals1_idx` (`jadwals_id` ASC),
  INDEX `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_matakuliahs_idx` (`matakuliahs_id` ASC, `matakuliahs_buka_id` ASC),
  CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_jadwals1`
    FOREIGN KEY (`jadwals_id`)
    REFERENCES `master_schema`.`jadwals` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_matakuliahs_has_matakuliahs_buka_has_jadwals_matakuliahs_h1`
    FOREIGN KEY (`matakuliahs_id` , `matakuliahs_buka_id`)
    REFERENCES `master_schema`.`matakuliahs_kp` (`matakuliahs_id` , `matakuliahs_buka_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `master_schema`.`kehadirans`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`kehadirans` (
  `mahasiswas_id` INT(11) NOT NULL,
  `matakuliahs_id` INT(11) NOT NULL,
  `matakuliahs_buka_id` INT(11) NOT NULL,
  `jadwals_id` INT(11) NOT NULL,
  `tanggal` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`mahasiswas_id`, `matakuliahs_id`, `matakuliahs_buka_id`, `jadwals_id`),
  INDEX `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadw_idx` (`matakuliahs_id` ASC, `matakuliahs_buka_id` ASC, `jadwals_id` ASC),
  INDEX `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadw_idx1` (`mahasiswas_id` ASC),
  CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadwal1`
    FOREIGN KEY (`mahasiswas_id`)
    REFERENCES `master_schema`.`mahasiswas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mahasiswas_has_matakuliahs_has_matakuliahs_buka_has_jadwal2`
    FOREIGN KEY (`matakuliahs_id` , `matakuliahs_buka_id` , `jadwals_id`)
    REFERENCES `master_schema`.`jadwal_matakuliahs` (`matakuliahs_id` , `matakuliahs_buka_id` , `jadwals_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `master_schema`.`karyawans`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`karyawans` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `npk` VARCHAR(255) NULL,
  `jabatan` ENUM('dekan', 'wadek', 'kajur', 'kalab', 'dosen') NULL,
  `user_id` VARCHAR(255) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `master_schema`.`dac_rules`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`dac_rules` (
  `id` INT NOT NULL,
  `kode` VARCHAR(45) NULL,
  `fakultas_id` INT(11) NOT NULL,
  `entity` VARCHAR(45) NULL,
  `field` VARCHAR(45) NULL,
  `operator` ENUM('=', '!=', '<', '>', '<=', '>=') NULL,
  `value` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_dac_rules_fakultass1_idx` (`fakultas_id` ASC),
  CONSTRAINT `fk_dac_rules_fakultass1`
    FOREIGN KEY (`fakultas_id`)
    REFERENCES `presensi_cloud`.`fakultass` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `master_schema`.`dac_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`dac_roles` (
  `id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `dac_rule_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_dac_roles_users1_idx` (`user_id` ASC),
  INDEX `fk_dac_roles_dac_rules2_idx` (`dac_rule_id` ASC),
  CONSTRAINT `fk_dac_roles_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `master_schema`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dac_roles_dac_rules2`
    FOREIGN KEY (`dac_rule_id`)
    REFERENCES `master_schema`.`dac_rules` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `master_schema`.`dac_rule`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`dac_rule` (
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `presensi_cloud`.`fakultass`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `presensi_cloud`.`fakultass` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `master_schema`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`users` (
  `id` INT NOT NULL,
  `username` VARCHAR(255) NULL,
  `password` VARCHAR(255) NULL,
  `nama` VARCHAR(255) NULL,
  `jabatan` ENUM('admin', 'rektor', 'warek', 'karuniversitas', 'karfakultas') NULL,
  `fakultas_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_fakultass1_idx` (`fakultas_id` ASC),
  CONSTRAINT `fk_users_fakultass1`
    FOREIGN KEY (`fakultas_id`)
    REFERENCES `presensi_cloud`.`fakultass` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `master_schema`.`dac_rules`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`dac_rules` (
  `id` INT NOT NULL,
  `kode` VARCHAR(45) NULL,
  `fakultas_id` INT(11) NOT NULL,
  `entity` VARCHAR(45) NULL,
  `field` VARCHAR(45) NULL,
  `operator` ENUM('=', '!=', '<', '>', '<=', '>=') NULL,
  `value` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_dac_rules_fakultass1_idx` (`fakultas_id` ASC),
  CONSTRAINT `fk_dac_rules_fakultass1`
    FOREIGN KEY (`fakultas_id`)
    REFERENCES `presensi_cloud`.`fakultass` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `master_schema`.`dac_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `master_schema`.`dac_roles` (
  `id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `dac_rule_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_dac_roles_users1_idx` (`user_id` ASC),
  INDEX `fk_dac_roles_dac_rules2_idx` (`dac_rule_id` ASC),
  CONSTRAINT `fk_dac_roles_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `master_schema`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dac_roles_dac_rules2`
    FOREIGN KEY (`dac_rule_id`)
    REFERENCES `master_schema`.`dac_rules` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `presensi_cloud` ;

-- -----------------------------------------------------
-- Table `presensi_cloud`.`metadatas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `presensi_cloud`.`metadatas` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `entity` VARCHAR(45) NOT NULL,
  `custom_field` VARCHAR(45) NOT NULL,
  `fakultas_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_metadatas_universitass1_idx` (`fakultas_id` ASC),
  CONSTRAINT `fk_metadatas_universitass1`
    FOREIGN KEY (`fakultas_id`)
    REFERENCES `presensi_cloud`.`fakultass` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
