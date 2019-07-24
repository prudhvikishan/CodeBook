
DROP VIEW IF EXISTS `View_TotalQuestionTimeByUser`;
CREATE VIEW `View_TotalQuestionTimeByUser` AS 
	SELECT `te`.`entity_id` as `question_id`, `te`.`user_id`, SUM(CONVERT(REPLACE(`te`.`other_data`, '"', ''), UNSIGNED)) AS total_time
	FROM `TrackingEvents` te 
	WHERE `te`.`event_type` = "question_time"
	GROUP BY `te`.`entity_id`, `te`.`user_id`;


DROP VIEW IF EXISTS `View_TotalContentTimeByUserAndType`;
CREATE VIEW `View_TotalContentTimeByUserAndType` AS 
	SELECT `te`.`entity_id` as `content_id`, `te`.`user_id`, `te`.`entity_type` as content_type, SUM(CONVERT(REPLACE(`te`.`other_data`, '"', ''), UNSIGNED)) AS total_time
	FROM `TrackingEvents` te 
	WHERE `te`.`event_type` = "content_time"
	GROUP BY `te`.`entity_type`, `te`.`user_id`;


DROP VIEW IF EXISTS `View_TotalQuestionTopicTimeByUserAndDay`;
CREATE VIEW `View_TotalQuestionTopicTimeByUserAndDay` AS 
	SELECT `te`.`created` as `date`, `t`.`topic_id`, `te`.`user_id`, SUM(CONVERT(REPLACE(`te`.`other_data`, '"', ''), UNSIGNED)) AS total_time
	FROM `TrackingEvents` te 
	JOIN `QuestionTopics` t
	ON te.entity_id = t.question_id
	WHERE `te`.`event_type` = "question_time"
	GROUP BY DATE_FORMAT(`te`.`created`, '%Y-%m-%d'), `t`.`topic_id`, `te`.`user_id`;

DROP VIEW IF EXISTS `View_TotalContentTopicTimeByUserAndDayAndType`;
CREATE VIEW `View_TotalContentTopicTimeByUserAndDayAndType` AS 
	SELECT `te`.`created` as `date`, `t`.`topic_id`, `c`.`content_type`, `te`.`user_id`, SUM(CONVERT(REPLACE(`te`.`other_data`, '"', ''), UNSIGNED)) AS total_time
	FROM `TrackingEvents` te 
	JOIN `TopicContent` t
	ON te.entity_id = t.content_id
	JOIN `Content` c 
	ON c.content_id = t.content_id
	WHERE `te`.`event_type` = "content_time"
	GROUP BY DATE_FORMAT(`te`.`created`, '%Y-%m-%d'), `t`.`topic_id`, `c`.`content_type`, `te`.`user_id`;