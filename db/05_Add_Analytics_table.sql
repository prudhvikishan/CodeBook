
CREATE TABLE TrackingEvents (
	event_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	event_type VARCHAR(64),
	entity_type VARCHAR(64),
	entity_id INTEGER,
	page_url VARCHAR(255),
	other_data TEXT,
	user_id INTEGER REFERENCES Users(user_id),
	created TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);