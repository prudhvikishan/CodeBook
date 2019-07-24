

CREATE TABLE UserAnnouncementView (
	user_id INTEGER REFERENCES Users(user_id),
	announcement_id INTEGER REFERENCES Announcements(announcement_id),
	shown_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (user_id, announcement_id)
);

CREATE VIEW View_UserAnnouncementsToBeShown AS (
	SELECT u.user_id, a.*
	FROM Users u, Announcements a 
	WHERE NOT EXISTS (SELECT 1 FROM UserAnnouncementView av WHERE av.user_id = u.user_id AND av.announcement_id = a.announcement_id)
);

-- Prevent any pop ups from old Announcements
INSERT INTO UserAnnouncementView (user_id, announcement_id) SELECT u.user_id, a.announcement_id FROM Users u, Announcements a;