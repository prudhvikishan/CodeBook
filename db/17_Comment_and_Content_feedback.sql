
CREATE TABLE ContentComment (
	content_comment_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	comment TEXT,
	content_id INTEGER REFERENCES Content(content_id),
	posted_by INTEGER REFERENCES Users(user_id),
	posted_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);