CREATE DATABASE IF NOT EXISTS `newsportal`;

USE `newsportal`;

CREATE TABLE IF NOT EXISTS `user` (
  `id` BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` INT(1) UNSIGNED NULL,
  `status` INT(1) UNSIGNED NULL DEFAULT 0,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  `created_at` DATETIME NULL,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uk_user_1` (`email` ASC))
ENGINE = InnoDB

CREATE TABLE IF NOT EXISTS `article` (
  `id` BIGINT(21) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_user` BIGINT(21) UNSIGNED NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `text` LONGTEXT NOT NULL,
  `excerpt` VARCHAR(255) NULL,
  `picture` TEXT NOT NULL,
  `status` INT(1) UNSIGNED NULL DEFAULT 0,
  `created_at` DATETIME NULL,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `published_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_article_user_idx` (`id_user` ASC),
  CONSTRAINT `fk_article_user`
    FOREIGN KEY (`id_user`)
    REFERENCES `mydb`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
