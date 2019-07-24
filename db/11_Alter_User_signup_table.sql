ALTER TABLE `akshara`.`UserSignup` 
DROP COLUMN `last_name`,
CHANGE COLUMN `first_name` `name` VARCHAR(255) NULL DEFAULT NULL ;