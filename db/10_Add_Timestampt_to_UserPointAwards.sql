

ALTER TABLE UserPointAwards ADD COLUMN `timestamp` timestamp DEFAULT CURRENT_TIMESTAMP;

UPDATE UserPointAwards SET `timestamp` = NOW();

DROP VIEW IF EXISTS `View_UserPointsByMonth`;
CREATE VIEW `View_UserPointsByMonth` AS (
	SELECT u.user_id, IFNULL(SUM(pa.point_value), 0) as points, MONTH(pa.timestamp) as month
	FROM Users u 
	JOIN UserPointAwards pa 
	ON u.user_id = pa.user_id
	GROUP BY u.user_id, MONTH(pa.timestamp)
);

DROP VIEW IF EXISTS `View_UserPointsByMonthAndCourse`;
CREATE VIEW `View_UserPointsByMonthAndCourse` AS (
	SELECT pa.user_id, ct.course_id, SUM(pa.point_value) as points, MONTH(pa.timestamp) as month
	FROM UserPointAwards pa 
	JOIN QuestionTopics qt 
	ON pa.entity_id = qt.question_id
	AND pa.event_entity_type = "Question"
	JOIN CourseTopics ct 
	ON qt.topic_id = ct.topic_id
	GROUP BY pa.user_id, ct.course_id, MONTH(pa.timestamp)
);
