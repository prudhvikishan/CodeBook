
ALTER TABLE `Questions` ADD COLUMN created_by INTEGER REFERENCES `Users`(`user_id`);