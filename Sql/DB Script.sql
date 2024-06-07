-- FOR DEBUG: DROP DATABASE fableflow;

CREATE DATABASE fableflow;

USE fableflow;

CREATE TABLE users (
    username VARCHAR(20) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    icon VARCHAR(36), /*uuid()*/
    description VARCHAR(50) DEFAULT ''
);

CREATE TABLE stories (
    story_id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    title VARCHAR(30) NOT NULL,
    username VARCHAR(255) NOT NULL,
    FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE tag (
    name VARCHAR(255) PRIMARY KEY
);

CREATE TABLE stories_tag (
    name VARCHAR(255),
    story_id INT,
    FOREIGN KEY (name) REFERENCES tag(name),
    FOREIGN KEY (story_id) REFERENCES stories(story_id)
);

CREATE TABLE user_tag (
    name VARCHAR(255),
    username VARCHAR(255),
    FOREIGN KEY (name) REFERENCES tag(name),
    FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE followers (
    followed VARCHAR(255) REFERENCES users(username),
    follower VARCHAR(255) REFERENCES users(username),
    CONSTRAINT followers PRIMARY KEY(followed, follower)
);

CREATE TABLE messages (
    message_id INT AUTO_INCREMENT,
    sender VARCHAR(255) REFERENCES users(username),
    receiver VARCHAR(255) REFERENCES users(username),
    content VARCHAR(500),
    message_datetime DATE DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT messages PRIMARY KEY(message_id, sender, receiver)
);

CREATE TABLE option_choices (
    option_id INT AUTO_INCREMENT,
    username VARCHAR(255) REFERENCES users(username),
    CONSTRAINT option_choices PRIMARY KEY (option_id, username)
);

CREATE TABLE options (
    option_id INT AUTO_INCREMENT,
    pool_id INT REFERENCES pools(pool_id),
    content VARCHAR(200),
    PRIMARY KEY (option_id, pool_id)
);

CREATE TABLE pools (
    pool_id INT PRIMARY KEY AUTO_INCREMENT,
    chapter_id INT REFERENCES chapters(chapter_id),
    title VARCHAR (50), 
    content VARCHAR (500),
    expire_datetime DATETIME NOT NULL
);

CREATE TABLE chapters(
    chapter_id INT AUTO_INCREMENT PRIMARY KEY,
    story_id INT NOT NULL,
    chapter_title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    picture VARCHAR(36) DEFAULT NULL, /*uuid()*/
    publication_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE proposals(
    proposal_id INT AUTO_INCREMENT PRIMARY KEY,
    chapter_id INT NOT NULL,
    username_proposing VARCHAR(255) NOT NULL,
    publication_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    title VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    FOREIGN KEY (chapter_id) REFERENCES chapters(chapter_id),
    FOREIGN KEY (username_proposing) REFERENCES users(username)
);

CREATE TABLE comments(
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    chapter_id INT,
    proposal_id INT,
    comment_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    content TEXT NOT NULL,
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (chapter_id) REFERENCES chapters(chapter_id),
    FOREIGN KEY (proposal_id) REFERENCES proposals(proposal_id)
);

CREATE TABLE likes(
    likeid INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    is_dislike BOOLEAN,
    chapter_id INT NULL,
    proposal_id INT NULL,
    comment_id INT NULL,
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (chapter_id) REFERENCES chapters(chapter_id),
    FOREIGN KEY (proposal_id) REFERENCES proposals(proposal_id),
    FOREIGN KEY (comment_id) REFERENCES comments(comment_id)
);

CREATE TABLE notifications(
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    content VARCHAR(255) NOT NULL,
    notification_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (username) REFERENCES users(username)
);

-- Insert into tag
INSERT INTO tag (name) 
VALUES ('Adventure'),
('Mystery'),
('Sci-Fi'),
('Fantasy'),
('Mythology');

-- Insert into users
INSERT INTO users (username, password, icon, description) VALUES
    ('john_doe', '$2y$10$NfU6MhtZw6ONGpPmz2QV7eG6MUMZHJUJo0QYZ1v/heKhY0GfPGF/e', NULL, 'Adventure enthusiast and writer'),
    ('jane_smith', '$2y$10$bH0hnwVncXh1Qmlz5HTR3u5CiHeuLXgiLBn2SSCUFJMT/aTwpqkDi', NULL, 'Mystery lover and budding author'),
    ('bob_jones', '$2y$10$MsA7mFS.MPqmZFa5zQzKVO4necIDYR14h6Xb5JILWgcEPFvWTIDP6', NULL, 'Fantasy and sci-fi writer');

-- Insert into stories
INSERT INTO stories (story_id, title, username) VALUES
    (1, 'The Lost Expedition', 'john_doe'),
    (2, 'The Enigma of Ravenwood Manor', 'jane_smith'),
    (3, 'The Cosmic Voyage', 'bob_jones'),
    (4, 'Whispers of the Ancients', 'john_doe'),
    (5, 'Secrets of the Arcane', 'jane_smith');

-- Insert into stories_tag
INSERT INTO stories_tag (name, story_id) VALUES
    ('Adventure', 1),
    ('Mystery', 2),
    ('Sci-Fi', 3),
    ('Mystery', 4);

-- Insert into user_tag
INSERT INTO user_tag (name, username) VALUES
    ('Adventure', 'john_doe'),
    ('Mystery', 'jane_smith'),
    ('Sci-Fi', 'bob_jones'),
    ('Fantasy', 'john_doe'),
    ('Mythology', 'jane_smith');

-- Insert into chapters
INSERT INTO chapters (story_id, chapter_title, content, picture, publication_datetime) VALUES
    (1, 'The Unexpected Journey', 'As the sun set behind the mountains, the adventurers prepared for their unexpected journey.', '66636e19702c8.jpg', '2023-01-01 12:00:00'),
    (1, 'Into the Unknown', 'Venturing deeper into the forest, they faced challenges they never imagined.', NULL, '2023-01-02 14:30:00'),
    (2, 'The Haunting Begins', 'Strange occurrences began to plague the residents of Ravenwood Manor.', '66636e11b2b57.png', '2023-02-15 15:30:00'),
    (3, 'A New World', 'The spaceship touched down on an unknown planet, full of mysteries waiting to be discovered.', '66636e15b6f3c.jpg', '2023-03-20 10:45:00');

-- Insert into proposals
INSERT INTO proposals (chapter_id, username_proposing, publication_datetime, title, content) VALUES
    (1, 'john_doe', '2023-01-01 12:00:00', 'A Dangerous Path', 'The adventurers must choose between a perilous path through the mountains or a safer route along the river.'),
    (2, 'jane_smith', '2023-01-02 14:30:00', 'The Hidden Room', 'While exploring the manor, they discover a hidden room filled with secrets.'),
    (3, 'bob_jones', '2023-02-15 15:30:00', 'The Alien Encounter', 'An alien species approaches with unknown intentions.');

-- Insert into comments
INSERT INTO comments (username, chapter_id, proposal_id, comment_datetime, content) VALUES
    ('john_doe', 1, NULL, '2023-01-02 14:10:00', 'Exciting start! Can’t wait to see what happens next.'),
    ('jane_smith', NULL, 1, '2023-01-03 09:20:00', 'Great proposal! The mountain path sounds thrilling.'),
    ('bob_jones', 2, NULL, '2023-02-16 18:05:00', 'Ravenwood Manor is getting creepier by the chapter!'),
    ('john_doe', NULL, 3, '2023-03-21 11:30:00', 'An alien encounter could take this story in an amazing direction!');

-- Insert into likes
INSERT INTO likes (username, chapter_id, proposal_id, comment_id, is_dislike) VALUES
    ('jane_smith', 1, NULL, NULL, 0),
    ('bob_jones', NULL, 2, NULL, 1),
    ('john_doe', NULL, NULL, 2, 0),
    ('jane_smith', 2, NULL, NULL, 1),
    ('bob_jones', NULL, 3, NULL, 0),
    ('john_doe', NULL, NULL, 3, 0),
    ('jane_smith', 3, NULL, NULL, 0),
    ('bob_jones', NULL, NULL, 4, 1);

-- Insert into followers
INSERT INTO followers (followed, follower) VALUES
    ('john_doe', 'jane_smith'),
    ('jane_smith', 'bob_jones'),
    ('bob_jones', 'john_doe'),
    ('jane_smith', 'john_doe');

-- Insert into messages
INSERT INTO messages (sender, receiver, content, message_datetime) VALUES
    ('john_doe', 'jane_smith', 'Loved your latest chapter!', '2023-01-01 08:00:00'),
    ('jane_smith', 'bob_jones', 'Can’t wait to see where your story goes next!', '2023-01-02 12:30:00'),
    ('bob_jones', 'john_doe', 'Your new proposal is intriguing!', '2023-01-03 15:45:00'),
    ('jane_smith', 'john_doe', 'Great plot twist in the latest chapter!', '2023-01-04 10:15:00');

-- Insert into pools
INSERT INTO pools (chapter_id, title, content, expire_datetime) VALUES
    (1, 'The Path Ahead', 'Which path should the adventurers take? The dangerous mountain trail or the safe river route?', '2023-02-28 08:00:00'),
    (2, 'The Wish Coin', 'Should the characters accept the mysterious coin that grants wishes with a price?', '2023-03-15 08:00:00'),
    (3, 'The Riddle of the Lake', 'Will the characters solve the ancient riddle to gain the power of the magical lake?', '2023-04-10 08:00:00');

-- Insert into options
INSERT INTO options (pool_id, content) VALUES
    (1, 'Take the mountain trail'),
    (1, 'Follow the river route'),
    (2, 'Accept the coin'),
    (2, 'Reject the coin'),
    (3, 'Solve the riddle'),
    (3, 'Ignore the lake');

-- Insert into option_choices
INSERT INTO option_choices (option_id, username) VALUES
    (1, 'john_doe'),
    (2, 'jane_smith'),
    (3, 'bob_jones'),
    (4, 'john_doe'),
    (5, 'jane_smith'),
    (6, 'bob_jones');

-- Insert into notifications
INSERT INTO notifications (username, content, notification_datetime) VALUES
    ('john_doe', 'A new chapter has been added to your story.', '2024-05-05 10:30:00'),
    ('jane_smith', 'You have a new follower!', '2024-05-05 14:00:00'),
    ('bob_jones', 'Someone liked your proposal.', '2024-05-05 18:00:00'),
    ('john_doe', 'Your story has received new comments.', '2024-05-05 11:45:00');
