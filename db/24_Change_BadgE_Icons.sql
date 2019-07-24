UPDATE  `Badges` SET  `icon_path` =  'fa fa-fw fa-star bronze' WHERE  `Badges`.`badge_id` = 1;
UPDATE  `Badges` SET  `icon_path` =  'fa fa-fw fa-star silver' WHERE  `Badges`.`badge_id` = 2;
UPDATE  `Badges` SET  `icon_path` =  'fa fa-fw fa-star gold' WHERE  `Badges`.`badge_id` = 3;
UPDATE  `Badges` SET  `icon_path` =  'fa fa-fw fa-star complete100' WHERE  `Badges`.`badge_id` = 4;

UPDATE  `BadgeCriteria` SET  `badge_id` =  '1' WHERE  `BadgeCriteria`.`badge_criteria_id` =3;
UPDATE  `BadgeCriteria` SET  `badge_id` =  '2' WHERE  `BadgeCriteria`.`badge_criteria_id` =2;
UPDATE  `BadgeCriteria` SET  `badge_id` =  '3' WHERE  `BadgeCriteria`.`badge_criteria_id` =1;