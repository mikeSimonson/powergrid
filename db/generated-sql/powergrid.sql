
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(254) NOT NULL,
    `username` VARCHAR(64),
    `password` VARCHAR(64) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- player
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `player`;

CREATE TABLE `player`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `turn_number` INTEGER NOT NULL,
    `step_number` INTEGER NOT NULL,
    `card_limit` INTEGER NOT NULL,
    `user_id` INTEGER NOT NULL,
    `game_id` INTEGER NOT NULL,
    `wallet_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `player_fi_29554a` (`user_id`),
    INDEX `player_fi_3cbcd5` (`game_id`),
    INDEX `player_fi_cf0de7` (`wallet_id`),
    CONSTRAINT `player_fk_29554a`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`id`),
    CONSTRAINT `player_fk_3cbcd5`
        FOREIGN KEY (`game_id`)
        REFERENCES `game` (`id`),
    CONSTRAINT `player_fk_cf0de7`
        FOREIGN KEY (`wallet_id`)
        REFERENCES `wallet` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- game
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `game`;

CREATE TABLE `game`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `turn_number` INTEGER NOT NULL,
    `step_number` INTEGER NOT NULL,
    `owner_id` INTEGER NOT NULL,
    `bank_id` INTEGER NOT NULL,
    `map_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `game_fi_ac5b84` (`owner_id`),
    INDEX `game_fi_4fe2a0` (`bank_id`),
    INDEX `game_fi_5b07f3` (`map_id`),
    CONSTRAINT `game_fk_ac5b84`
        FOREIGN KEY (`owner_id`)
        REFERENCES `user` (`id`),
    CONSTRAINT `game_fk_4fe2a0`
        FOREIGN KEY (`bank_id`)
        REFERENCES `bank` (`id`),
    CONSTRAINT `game_fk_5b07f3`
        FOREIGN KEY (`map_id`)
        REFERENCES `map` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- bank
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `bank`;

CREATE TABLE `bank`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `balance` INTEGER NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- wallet
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `wallet`;

CREATE TABLE `wallet`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `balance` INTEGER NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- card
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `card`;

CREATE TABLE `card`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `resource_cost` INTEGER NOT NULL,
    `resource_type_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `card_fi_1dbfab` (`resource_type_id`),
    CONSTRAINT `card_fk_1dbfab`
        FOREIGN KEY (`resource_type_id`)
        REFERENCES `resource_type` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- resource_type
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `resource_type`;

CREATE TABLE `resource_type`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(64),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- resource_store
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `resource_store`;

CREATE TABLE `resource_store`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `minimum_price` INTEGER NOT NULL,
    `quantity` INTEGER NOT NULL,
    `game_id` INTEGER NOT NULL,
    `resource_type_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `resource_store_fi_3cbcd5` (`game_id`),
    INDEX `resource_store_fi_1dbfab` (`resource_type_id`),
    CONSTRAINT `resource_store_fk_3cbcd5`
        FOREIGN KEY (`game_id`)
        REFERENCES `game` (`id`),
    CONSTRAINT `resource_store_fk_1dbfab`
        FOREIGN KEY (`resource_type_id`)
        REFERENCES `resource_type` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- map
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `map`;

CREATE TABLE `map`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(64),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- city
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(128),
    `map_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `city_fi_5b07f3` (`map_id`),
    CONSTRAINT `city_fk_5b07f3`
        FOREIGN KEY (`map_id`)
        REFERENCES `map` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- card_status
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `card_status`;

CREATE TABLE `card_status`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(64),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- turn_order
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `turn_order`;

CREATE TABLE `turn_order`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `rank` INTEGER NOT NULL,
    `game_id` INTEGER NOT NULL,
    `player_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `turn_order_fi_3cbcd5` (`game_id`),
    INDEX `turn_order_fi_97a1b7` (`player_id`),
    CONSTRAINT `turn_order_fk_3cbcd5`
        FOREIGN KEY (`game_id`)
        REFERENCES `game` (`id`),
    CONSTRAINT `turn_order_fk_97a1b7`
        FOREIGN KEY (`player_id`)
        REFERENCES `player` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- game_card
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `game_card`;

CREATE TABLE `game_card`
(
    `game_id` INTEGER NOT NULL,
    `card_id` INTEGER NOT NULL,
    `card_status_id` INTEGER NOT NULL,
    PRIMARY KEY (`game_id`,`card_id`,`card_status_id`),
    INDEX `game_card_fi_acfa40` (`card_id`),
    INDEX `game_card_fi_75e1e3` (`card_status_id`),
    CONSTRAINT `game_card_fk_3cbcd5`
        FOREIGN KEY (`game_id`)
        REFERENCES `game` (`id`),
    CONSTRAINT `game_card_fk_acfa40`
        FOREIGN KEY (`card_id`)
        REFERENCES `card` (`id`),
    CONSTRAINT `game_card_fk_75e1e3`
        FOREIGN KEY (`card_status_id`)
        REFERENCES `card_status` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- player_resource
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `player_resource`;

CREATE TABLE `player_resource`
(
    `player_id` INTEGER NOT NULL,
    `resource_type_id` INTEGER NOT NULL,
    `quantity` INTEGER NOT NULL,
    PRIMARY KEY (`player_id`,`resource_type_id`),
    INDEX `player_resource_fi_1dbfab` (`resource_type_id`),
    CONSTRAINT `player_resource_fk_1dbfab`
        FOREIGN KEY (`resource_type_id`)
        REFERENCES `resource_type` (`id`),
    CONSTRAINT `player_resource_fk_97a1b7`
        FOREIGN KEY (`player_id`)
        REFERENCES `player` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- player_city
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `player_city`;

CREATE TABLE `player_city`
(
    `player_id` INTEGER NOT NULL,
    `city_id` INTEGER NOT NULL,
    PRIMARY KEY (`player_id`,`city_id`),
    INDEX `player_city_fi_48ce03` (`city_id`),
    CONSTRAINT `player_city_fk_97a1b7`
        FOREIGN KEY (`player_id`)
        REFERENCES `player` (`id`),
    CONSTRAINT `player_city_fk_48ce03`
        FOREIGN KEY (`city_id`)
        REFERENCES `city` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- player_card
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `player_card`;

CREATE TABLE `player_card`
(
    `player_id` INTEGER NOT NULL,
    `card_id` INTEGER NOT NULL,
    PRIMARY KEY (`player_id`,`card_id`),
    INDEX `player_card_fi_acfa40` (`card_id`),
    CONSTRAINT `player_card_fk_97a1b7`
        FOREIGN KEY (`player_id`)
        REFERENCES `player` (`id`),
    CONSTRAINT `player_card_fk_acfa40`
        FOREIGN KEY (`card_id`)
        REFERENCES `card` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- game_city
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `game_city`;

CREATE TABLE `game_city`
(
    `game_id` INTEGER NOT NULL,
    `city_id` INTEGER NOT NULL,
    PRIMARY KEY (`game_id`,`city_id`),
    INDEX `game_city_fi_48ce03` (`city_id`),
    CONSTRAINT `game_city_fk_3cbcd5`
        FOREIGN KEY (`game_id`)
        REFERENCES `game` (`id`),
    CONSTRAINT `game_city_fk_48ce03`
        FOREIGN KEY (`city_id`)
        REFERENCES `city` (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
