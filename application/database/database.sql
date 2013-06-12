SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `shoplimpeza` DEFAULT CHARACTER SET latin1 ;
USE `shoplimpeza` ;

-- -----------------------------------------------------
-- Table `shoplimpeza`.`categories`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `shoplimpeza`.`categories` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `parent_id` INT(11) NOT NULL ,
  `name` VARCHAR(60) NOT NULL ,
  `created_at` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `shoplimpeza`.`products`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `shoplimpeza`.`products` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `category_id` INT(11) NOT NULL ,
  `name` VARCHAR(80) NOT NULL ,
  `description_short` VARCHAR(120) NULL DEFAULT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `image` VARCHAR(120) NULL DEFAULT NULL ,
  `created_at` DATETIME NOT NULL ,
  `main` TINYINT(1) NULL DEFAULT '0' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_products_category_id_1` (`category_id` ASC) ,
  CONSTRAINT `fk_products_category_id_1`
    FOREIGN KEY (`category_id` )
    REFERENCES `shoplimpeza`.`categories` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `shoplimpeza`.`products_character`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `shoplimpeza`.`products_character` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `product_id` INT(11) NOT NULL ,
  `description` TEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_products_character_products` (`product_id` ASC) ,
  CONSTRAINT `fk_products_character_products_id_1`
    FOREIGN KEY (`product_id` )
    REFERENCES `shoplimpeza`.`products` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `shoplimpeza`.`products_version`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `shoplimpeza`.`products_version` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `product_id` INT(11) NOT NULL ,
  `name` VARCHAR(60) NOT NULL ,
  `fragrance` VARCHAR(45) NULL DEFAULT NULL ,
  `color` VARCHAR(20) NULL DEFAULT NULL ,
  `dilution` VARCHAR(80) NULL DEFAULT NULL ,
  `packing` VARCHAR(80) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_products_version_producta_id_1` (`product_id` ASC) ,
  CONSTRAINT `products_version_ibfk_1`
    FOREIGN KEY (`product_id` )
    REFERENCES `shoplimpeza`.`products` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `shoplimpeza`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `shoplimpeza`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `user` VARCHAR(20) NOT NULL ,
  `password` VARCHAR(128) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;

USE `shoplimpeza` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `shoplimpeza`.`users`
-- -----------------------------------------------------
START TRANSACTION;
USE `shoplimpeza`;
INSERT INTO `shoplimpeza`.`users` (`id`, `user`, `password`) VALUES (1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055');

COMMIT;
