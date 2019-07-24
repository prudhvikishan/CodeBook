ALTER TABLE Users ADD COLUMN is_premium INT(1) DEFAULT 0;

CREATE TABLE PremiumExams (
	topic_id INTEGER REFERENCES Topics(topic_id),
	exam_type INTEGER,
	is_premium INT(1) DEFAULT 0,
	PRIMARY KEY (topic_id, exam_type)
);