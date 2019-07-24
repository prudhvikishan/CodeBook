ALTER TABLE `UserBadgeAward` 
ADD COLUMN `entity_id` INT(11) NULL AFTER `badge_id`,
ADD COLUMN `entity_type` VARCHAR(45) NULL AFTER `entity_id`;