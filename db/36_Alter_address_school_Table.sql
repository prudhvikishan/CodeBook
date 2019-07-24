ALTER TABLE `Addresses` ADD COLUMN `address1` VARCHAR(200), ADD COLUMN `address2` VARCHAR(200);

ALTER TABLE `Addresses` DROP COLUMN street_address;

ALTER TABLE Schools ADD column is_school_verified VARCHAR(1);
