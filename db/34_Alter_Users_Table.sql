ALTER TABLE `Users` ADD COLUMN `is_account_verified` VARCHAR(1);
ALTER TABLE `Users` ADD COLUMN `token` VARCHAR(200);
ALTER TABLE `Users` ADD COLUMN `verified_on` datetime ;