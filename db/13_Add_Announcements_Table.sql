
CREATE TABLE Announcements (
	announcement_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
	title VARCHAR(255),
	content TEXT,
	posted_by INTEGER REFERENCES Users(user_id),
	posted_on TIMESTAMP
);