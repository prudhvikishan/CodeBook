

CREATE TABLE Users (
	user_id  INTEGER PRIMARY KEY AUTO_INCREMENT,
	firstname VARCHAR(128),
	lastname VARCHAR(128),
	email VARCHAR(255),
	address_id INTEGER REFERENCES Addresses(address_id),
	password VARCHAR(512)
);

CREATE TABLE UserRoles (
	user_id INTEGER REFERENCES Users(user_id), 
	type VARCHAR(1),
	PRIMARY KEY (user_id, type)
);

CREATE TABLE Addresses (
	address_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	street_address VARCHAR(255),
	city VARCHAR(255),
	state VARCHAR(255),
	country VARCHAR(255)
);

CREATE TABLE UserParents (
	user_id INTEGER REFERENCES Users(user_id),
	parent_user_id INTEGER REFERENCES Users(user_id),
	PRIMARY KEY (user_id, parent_user_id)
);


CREATE TABLE Classes (
	class_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	description TEXT,
	school_id INTEGER REFERENCES Schools(school_id)
);

CREATE TABLE Clients (
	client_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	client_name VARCHAR(255)
);

CREATE TABLE ClientUsers (
	client_id INTEGER REFERENCES Clients(client_id),
	user_id INTEGER REFERENCES Users(user_id),
	PRIMARY KEY (client_id, user_id)
);

CREATE TABLE UserPermission (
	entity_type VARCHAR(32),
	entity_id INTEGER,
	permitted_entity_type VARCHAR(32),
	permitted_enttiy_id INTEGER,
	PRIMARY KEY(entity_type, entity_id, permitted_entity_type, permitted_enttiy_id)
);

CREATE TABLE Schools (
	school_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	description TEXT,
	address_id INTEGER REFERENCES Addresses(address_id)
);

CREATE TABLE SchoolUsers (
	user_id INTEGER REFERENCES Users(user_id),
	school_id INTEGER REFERENCES Schools(school_id),
	PRIMARY KEY (user_id, school_id)
);

CREATE TABLE Courses (
	course_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	description TEXT
);

CREATE TABLE CourseClassUsers (
	user_id INTEGER REFERENCES Users(user_id),
	course_id INTEGER REFERENCES Courses(course_id),
	class_id INTEGER REFERENCES Classes(class_id),
	PRIMARY KEY (user_id, course_id, class_id)
);

CREATE TABLE Topics (
	topic_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	description TEXT
);

CREATE TABLE CourseTopics (
	topic_id INTEGER REFERENCES Topics(topic_id),
	course_id INTEGER REFERENCES Courses(course_id),
	parent_topic_id INTEGER REFERENCES Topics(topic_id),
	PRIMARY KEY (topic_id, course_id)
);

-- Exams, questions etc..
CREATE TABLE Questions (
	question_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	question_text TEXT,
	explanation TEXT,
	difficulty INT(2) DEFAULT 0,
	practice_question INT(1) DEFAULT 0,
	exam_question INT(1) DEFAULT 0,
	sort_order INTEGER DEFAULT 0,
	question_type VARCHAR(1)
);

CREATE TABLE QuestionTopics (
	question_id INTEGER REFERENCES Questions(question_id),
	topic_id INTEGER REFERENCES Topics(topic_id),
	PRIMARY KEY (question_id, topic_id)
);

CREATE TABLE QuestionCourseRelevance (
	question_id INTEGER REFERENCES Questions(question_id),
	course_id INTEGER REFERENCES Courses(course_id),
	PRIMARY KEY (question_id, course_id)
);


CREATE TABLE QuestionAnswers (
	question_answer_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	question_id INTEGER REFERENCES Questions(question_id),
	answer_text TEXT,
	is_correct INT(1) DEFAULT 0
);

CREATE TABLE Exams (
	exam_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255),
	description TEXT,
	time_limit_minutes INTEGER,
	exam_type VARCHAR(1)
);

CREATE TABLE ExamQuestions (
	exam_id INTEGER REFERENCES Exams(exam_id),
	question_id INTEGER REFERENCES Questions(question_id),
	sort_order INTEGER DEFAULT 0,
	PRIMARY KEY (exam_id, question_id)
);

CREATE TABLE ClassExams (
	class_exam_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	class_id INTEGER REFERENCES Classes(class_id),
	exam_id INTEGER REFERENCES Exams(exam_id),
	start_date DATETIME DEFAULT NULL
);

CREATE TABLE ExamCourseRelevance (
	exam_id INTEGER REFERENCES Exams(exam_id),
	course_id INTEGER REFERENCES Courses(course_id),
	PRIMARY KEY (exam_id, course_id)
);


CREATE TABLE ExamTopics (
	exam_id INTEGER REFERENCES Exams(exam_id),
	topic_id INTEGER REFERENCES Topics(topic_id),
	PRIMARY KEY (exam_id, topic_id)
);

CREATE TABLE UserExamAttempt (
	user_exam_attempt_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	user_id INTEGER REFERENCES Users(user_id),
	exam_id INTEGER REFERENCES Exams(exam_id),
	score FLOAT,
	correct INTEGER,
	possible INTEGER,
	status VARCHAR(1), -- "S"=saved, "C"=submitted
	started TIMESTAMP,
	finished TIMESTAMP
);

CREATE TABLE UserExamAttemptQuestionState (
	user_exam_attempt_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	question_id INTEGER REFERENCES Questions(question_id),
	chosen_answer_id INTEGER REFERENCES QuestionAnswers(question_answer_id)
);

CREATE TABLE UserPracticeSession (
	user_practice_session_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	user_id INTEGER REFERENCES Users(user_id),
	started TIMESTAMP,
	ended TIMESTAMP
);

CREATE TABLE UserPracticeSessionQuestionState (
	user_practice_session_id INTEGER REFERENCES UserPracticeSession(user_practice_session_id),
	question_id INTEGER REFERENCES Questions(question_answer_id),
	chosen_answer_id INTEGER REFERENCES QuestionAnswers(question_answer_id),
	submitted TIMESTAMP
);

-- Content
CREATE TABLE Content (
	content_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	content_type VARCHAR(64),
	content_path TEXT,
	name VARCHAR(255),
	description TEXT
);

CREATE TABLE UserContentInteraction (
	user_content_interaction_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	user_id INTEGER REFERENCES Users(user_id),
	content_id INTEGER REFERENCES Content(content_id),
	interaction_type VARCHAR(1), -- "S"=started, "C"=completed
	timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE TopicContent (
	topic_id INTEGER REFERENCES Topics(topic_id),
	content_id INTEGER REFERENCES Content(content_id),
	PRIMARY KEY (topic_id, content_id)
);


-- Gamification
CREATE TABLE Badges (
	badge_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	badge_name VARCHAR(255),
	badge_description TEXT,
	icon_path VARCHAR(255),
	point_value INTEGER
);

CREATE TABLE BadgeCriteria (
	badge_criteria_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	badge_id INTEGER REFERENCES Badges(badge_id),
	criteria_type VARCHAR(1),
	threshold_min FLOAT DEFAULT NULL,
	threshold_max FLOAT DEFAULT NULL,
	entity_type VARCHAR(32),
	entity_id INTEGER,
	other_data TEXT
);

CREATE TABLE UserBadgeAward (
	user_badge_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	user_id INTEGER REFERENCES Users(user_id),
	badge_id INTEGER REFERENCES Badges(badge_id),
	date_awarded TIMESTAMP
);

CREATE TABLE UserPointAwards (
	user_point_award_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	user_id INTEGER REFERENCES Users(user_id),
	point_value INTEGER,
	event_type VARCHAR(1),
	event_entity_type VARCHAR(32),
	entity_id INTEGER DEFAULT NULL
);

