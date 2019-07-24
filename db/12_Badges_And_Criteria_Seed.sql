INSERT INTO `Badges` (`badge_id`, `badge_name`, `badge_description`, `icon_path`) VALUES ('2', 'senior', 'senior', 'images/badges/Silver_badge.png');
INSERT INTO `Badges` (`badge_id`, `badge_name`, `badge_description`, `icon_path`) VALUES ('3', 'master', 'master', 'images/badges/Gold_badge.png');
INSERT INTO `Badges` (`badge_id`, `badge_name`, `badge_description`, `icon_path`) VALUES ('1', 'apprentice', 'apprentice', 'images/badges/Bronze_badge.png');

INSERT INTO `BadgeCriteria` (`badge_criteria_id`, `badge_id`, `threshold_min`, `threshold_max`, `entity_type`) VALUES ('1', '1', '85', '100', 'exam');
INSERT INTO `BadgeCriteria` (`badge_criteria_id`, `badge_id`, `threshold_min`, `threshold_max`, `entity_type`) VALUES ('2', '2', '70', '85', 'exam');
INSERT INTO `BadgeCriteria` (`badge_criteria_id`, `badge_id`, `threshold_min`, `threshold_max`, `entity_type`) VALUES ('3', '3', '35', '70', 'exam');

