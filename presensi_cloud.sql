-- MySQL Script generated by MySQL Workbench
-- Sun Mar 21 14:30:04 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema presensi_cloud
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema presensi_cloud
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `presensi_cloud` DEFAULT CHARACTER SET utf8mb4 ;
-- -----------------------------------------------------
-- Schema presensi_cloud
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema presensi_cloud
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `presensi_cloud` DEFAULT CHARACTER SET utf8mb4 ;
USE `presensi_cloud` ;

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
-- Table `presensi_cloud`.`jurusans`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `presensi_cloud`.`jurusans` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nama` VARCHAR(45) NOT NULL,
  `fakultass_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_jurusans_fakultass1_idx` (`fakultass_id` ASC),
  CONSTRAINT `fk_jurusans_fakultass1`
    FOREIGN KEY (`fakultass_id`)
    REFERENCES `presensi_cloud`.`fakultass` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `presensi_cloud`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `presensi_cloud`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NULL,
  `password` VARCHAR(255) NULL,
  `nama` VARCHAR(255) NULL,
  `jabatan` ENUM('admin', 'dekan', 'wadek', 'kajur', 'kalab', 'dosen', 'mhs') NULL,
  `fakultass_id` INT(11) NOT NULL,
  `jurusans_id` INT(11) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_fakultass2_idx` (`fakultass_id` ASC),
  INDEX `fk_users_jurusans1_idx` (`jurusans_id` ASC),
  CONSTRAINT `fk_users_fakultass2`
    FOREIGN KEY (`fakultass_id`)
    REFERENCES `presensi_cloud`.`fakultass` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_jurusans1`
    FOREIGN KEY (`jurusans_id`)
    REFERENCES `presensi_cloud`.`jurusans` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `presensi_cloud`.`dac_rules`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `presensi_cloud`.`dac_rules` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `kode` VARCHAR(45) NULL,
  `jurusans_id` INT(11) NOT NULL,
  `entity` VARCHAR(45) NULL,
  `field` VARCHAR(45) NULL,
  `operator` ENUM('=', '!=', '<', '>', '<=', '>=') NULL,
  `value` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_dac_rules_fakultass1_idx` (`jurusans_id` ASC),
  CONSTRAINT `fk_dac_rules_fakultass1`
    FOREIGN KEY (`jurusans_id`)
    REFERENCES `presensi_cloud`.`jurusans` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `presensi_cloud`.`dac_roles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `presensi_cloud`.`dac_roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `dac_rule_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_dac_roles_users1_idx` (`user_id` ASC),
  INDEX `fk_dac_roles_dac_rules2_idx` (`dac_rule_id` ASC),
  CONSTRAINT `fk_dac_roles_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `presensi_cloud`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dac_roles_dac_rules2`
    FOREIGN KEY (`dac_rule_id`)
    REFERENCES `presensi_cloud`.`dac_rules` (`id`)
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
  `jurusans_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_metadatas_universitass1_idx` (`jurusans_id` ASC),
  CONSTRAINT `fk_metadatas_universitass1`
    FOREIGN KEY (`jurusans_id`)
    REFERENCES `presensi_cloud`.`jurusans` (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
