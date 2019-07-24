CREATE TABLE UserCourses (
	user_id INTEGER REFERENCES Users(user_id),
	course_id INTEGER REFERENCES Courses(course_id),
	PRIMARY KEY (user_id, course_id)
);

