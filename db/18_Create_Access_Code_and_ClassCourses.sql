CREATE TABLE ClassCourses (
	class_id INTEGER REFERENCES Classes(class_id),
	course_id INTEGER REFERENCES Courses(course_id),
	PRIMARY KEY (class_id, course_id)
);

ALTER TABLE `Users` ADD COLUMN expiration_date datetime ;

CREATE TABLE AccessCodes (
	access_code_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	access_code VARCHAR(20),
	user_id INTEGER REFERENCES Users(user_id),
	expiration_date datetime,
	used_on datetime ,
	created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
