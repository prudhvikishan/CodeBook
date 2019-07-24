
CREATE TABLE GoldCoinTransactions (
	transaction_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	user_id INTEGER REFERENCES Users(user_id),
	transaction_amount INTEGER DEFAULT 0,
	explanation TEXT,
	transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE VIEW View_UserGoldCoins AS (
	SELECT u.user_id, IFNULL(SUM(transaction_amount), 0) as coins
	FROM Users u 
	LEFT JOIN GoldCoinTransactions g 
	ON u.user_id = g.user_id
	GROUP BY u.user_id
);

ALTER TABLE GoldCoinTransactions ADD COLUMN `entity_type` VARCHAR(32) NULL;
ALTER TABLE GoldCoinTransactions ADD COLUMN `entity_id` INTEGER NULL;

CREATE TABLE Rewards (
	reward_id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name TEXT,
	description TEXT,
	cost INTEGER,
	active INTEGER(1)
);
ALTER TABLE Rewards ADD COLUMN image VARCHAR(256);

INSERT INTO Rewards (name, description, cost, image, active) VALUES (
	'Codebook Journal', 
	'Boast your first Codebook victory with a fabulous personal journal.', 
	6,
	'images/reward-journal.jpg',
	1
);