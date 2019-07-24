ALTER TABLE Content ADD COLUMN `compiled_content` TEXT;

UPDATE Content SET compiled_content = content_path;

CREATE TABLE compiled_html_elements (
	description TEXT,
	text TEXT,
	replacement TEXT
);

INSERT INTO compiled_html_elements (description, `text`, replacement) VALUES
("Test topic alert open", "{{testtopic}}", "<div class='testtopic'>"),
("Test topic alert close", "{{/testtopic}}", "</div>");