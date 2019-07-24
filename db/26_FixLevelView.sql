DROP VIEW IF EXISTS `View_UserLevel`;
CREATE VIEW `View_UserLevel` AS (
	SELECT up.user_id, up.points, COUNT(*)+LEAST(1, up.points)-1 as level
	FROM `View_UserPoints` up 
	LEFT JOIN `LevelPointCutoff` c 
	ON up.points >= c.min_points
	GROUP BY up.user_id, up.points
);



UPDATE  `Badges` SET  `icon_path` =  'fa fa-fw fa-trophy bronze' WHERE  `Badges`.`badge_id` =1;
UPDATE  `Badges` SET  `icon_path` =  'fa fa-fw fa-trophy silver' WHERE  `Badges`.`badge_id` =2;
UPDATE  `Badges` SET  `icon_path` =  'fa fa-fw fa-trophy gold' WHERE  `Badges`.`badge_id` =3;
UPDATE  `Badges` SET  `icon_path` =  'fa fa-fw fa-trophy complete100' WHERE  `Badges`.`badge_id` =4;