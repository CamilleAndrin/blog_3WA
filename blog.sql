-- MySQL Script generated by MySQL Workbench
-- ven. 08 mars 2019 14:48:06 CET
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `b_categorie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b_categorie` (
  `c_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `c_title` VARCHAR(255) NOT NULL,
  `c_parent` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`c_id`),
  INDEX `fk_b_categorie_b_categorie1_idx` (`c_parent` ASC),
  CONSTRAINT `fk_b_categorie_b_categorie1`
    FOREIGN KEY (`c_parent`)
    REFERENCES `b_categorie` (`c_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b_user` (
  `u_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `u_firstname` VARCHAR(150) NULL,
  `u_lastname` VARCHAR(150) NULL,
  `u_email` VARCHAR(150) NULL,
  `u_password` VARCHAR(150) NULL,
  `u_valide` TINYINT NULL DEFAULT 1,
  `u_role` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`u_id`),
  UNIQUE INDEX `u_email_UNIQUE` (`u_email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b_article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b_article` (
  `a_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `a_title` VARCHAR(255) NOT NULL,
  `a_date_published` DATETIME NULL,
  `a_content` MEDIUMTEXT NULL,
  `a_picture` VARCHAR(255) NULL,
  `a_categorie` INT UNSIGNED NOT NULL,
  `a_author` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`a_id`),
  INDEX `fk_b_article_b_categorie_idx` (`a_categorie` ASC),
  INDEX `fk_b_article_b_user1_idx` (`a_author` ASC),
  CONSTRAINT `fk_b_article_b_categorie`
    FOREIGN KEY (`a_categorie`)
    REFERENCES `b_categorie` (`c_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_b_article_b_user1`
    FOREIGN KEY (`a_author`)
    REFERENCES `b_user` (`u_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `b_comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `b_comment` (
  `c_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `c_content` VARCHAR(45) NOT NULL,
  `c_pseudo` VARCHAR(45) NOT NULL,
  `c_email` VARCHAR(150) NOT NULL,
  `c_date_posted` DATETIME NOT NULL,
  `c_valide` TINYINT UNSIGNED NULL DEFAULT 1,
  `b_article_a_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`c_id`),
  INDEX `fk_b_comment_b_article1_idx` (`b_article_a_id` ASC),
  CONSTRAINT `fk_b_comment_b_article1`
    FOREIGN KEY (`b_article_a_id`)
    REFERENCES `b_article` (`a_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
