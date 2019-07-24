
DROP TABLE IF EXISTS `LevelPointCutoff`;
CREATE TABLE LevelPointCutoff (
	min_points INTEGER,
	PRIMARY KEY(min_points)
);

INSERT INTO LevelPointCutoff (min_points) VALUES 
	(10), (25), (50), (100), (250), (500), (1000), (2000), (4000), (10000);

DROP VIEW IF EXISTS `View_UserPoints`;
CREATE VIEW `View_UserPoints` AS (
	SELECT u.user_id, IFNULL(SUM(pa.point_value), 0) as points
	FROM Users u 
	LEFT JOIN UserPointAwards pa 
	ON u.user_id = pa.user_id
	GROUP BY u.user_id
);

DROP VIEW IF EXISTS `View_UserLevel`;
CREATE VIEW `View_UserLevel` AS (
	SELECT up.user_id, up.points, COUNT(*)+LEAST(1, up.points) as level
	FROM `View_UserPoints` up 
	LEFT JOIN `LevelPointCutoff` c 
	ON up.points >= c.min_points
	GROUP BY up.user_id, up.points
);

-- Update the broken subtopics in coursetopics
UPDATE CourseTopics ct1 
INNER JOIN CourseTopics ct2
ON ct1.parent_topic_id = ct2.topic_id
AND ct1.parent_topic_id IS NOT NULL
SET ct1.course_id = ct2.course_id;

DROP VIEW IF EXISTS `View_UserPointsForCourseId`;
CREATE VIEW `View_UserPointsForCourseId` AS (
	-- Currently only questions award points
	SELECT pa.user_id, ct.course_id, SUM(pa.point_value) as points
	FROM UserPointAwards pa 
	JOIN QuestionTopics qt 
	ON pa.entity_id = qt.question_id
	AND pa.event_entity_type = "Question"
	JOIN CourseTopics ct 
	ON qt.topic_id = ct.topic_id
	GROUP BY pa.user_id, ct.course_id
);