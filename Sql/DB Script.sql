-- FOR DEBUG: DROP DATABASE fableflow;

CREATE DATABASE fableflow;

USE fableflow;

CREATE TABLE users (
    username VARCHAR(20) PRIMARY KEY,
    email VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    icon VARCHAR(36), /*uuid()*/
    description VARCHAR(50) DEFAULT ''
);

CREATE TABLE stories (
    story_id INT PRIMARY KEY,
    title VARCHAR(30),
    username VARCHAR(255),
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
    message_datetime DATE,
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
    story_id INT REFERENCES stories(story_id),
    title VARCHAR (50), 
    content VARCHAR (500),
    expire_datetime DATE
);

CREATE TABLE chapters(
	chapter_id INT AUTO_INCREMENT PRIMARY KEY,
    story_id INT NOT NULL,
    chapter_title VARCHAR(255) NOT NULL,
   	content TEXT,
    publication_datetime DATETIME NOT NULL
);

CREATE TABLE proposals(
	proposal_id INT AUTO_INCREMENT PRIMARY KEY,
    chapter_id INT NOT NULL,
    username_proposing VARCHAR(255) NOT NULL,
    publication_datetime DATETIME NOT NULL,
    content TEXT NOT NULL,
    FOREIGN KEY (chapter_id) REFERENCES chapters(chapter_id),
    FOREIGN KEY (username_proposing) REFERENCES users(username)
);

CREATE TABLE comments(
	comment_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    chapter_id INT,
    proposal_id INT,
    comment_datetime DATETIME NOT NULL,
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
    notification_datetime DATETIME NOT NULL,
    FOREIGN KEY (username) REFERENCES users(username)
);
    
INSERT INTO tag (name) 
VALUES ('Drama'),
('Fantasy'),
('Science'),
('Adventure'),
('Crime'),
('Religion'),
('Mystery'),
('Horror'),
('Mythology');

INSERT INTO users (username, email, password, icon, description) VALUES
    ('john_doe', 'password123', 'johndoe69@gmail.com', '4F45C6A3-45D4-2F2B-1C1E-9876543210AB', 'User account for John Doe'),
    ('jane_smith', 'pass456', 'janesmith70@gmail.com', '8A2B1C0D-3E4F-5A6B-9C8D-76543210FEDC',NULL),
    ('bob_jones', 'secretPass', 'jurskills71@gmail.com', '1B2C3D4E-5F6A-7B8C-9D0E-123456789ABC', 'User account for Bob Jones');

INSERT INTO stories (story_id, title, username)
VALUES
    (1, 'The Adventure Begins', 'john_doe'),
    (2, 'Mystery of the Lost City', 'jane_smith'),
    (3, 'A Tale of Two Worlds', 'bob_jones'),
    (4, 'Echoes from the Past', 'john_doe'),
    (5, 'Legends of the Hidden Realm', 'jane_smith');


INSERT INTO stories_tag (name, story_id) VALUES
    ('Adventure', 1),
    ('Mystery', 1),
    ('Fantasy', 3),
    ('Mystery', 4);

INSERT INTO user_tag (name, username) VALUES
    ('Adventure', 'john_doe'),
    ('Mystery', 'jane_smith'),
    ('Fantasy', 'bob_jones'),
    ('Crime', 'john_doe'),
    ('Mythology', 'jane_smith');

-- Insert into chapters
INSERT INTO chapters (story_id, chapter_title, content, publication_datetime)
VALUES
    (1, 'Something Happened', 'Chapter 1 content', '2023-01-01 12:00:00'),
    (1, 'Something Happened 2', 'Chapter 2 content', '2023-01-02 14:30:00'),
    (2, 'Something Happened 3', 'Chapter 1 content', '2023-02-15 15:30:00'),
    (3, 'Something Happened 4', 'Chapter 1 content', '2023-03-20 10:45:00');

-- Insert into proposals
INSERT INTO proposals (chapter_id, username_proposing, publication_datetime, content)
VALUES
    (1, 'john_doe', '2023-01-01 12:00:00', 'This is a proposal content.'),
    (2, 'jane_smith', '2023-01-02 14:30:00', 'Another proposal for a chapter.'),
    (3, 'bob_jones', '2023-02-15 15:30:00', 'A third proposal for a chapter.');

-- Insert into comments
INSERT INTO comments (username, chapter_id, proposal_id, comment_datetime, content)
VALUES
    ('john_doe', 1, NULL, '2023-01-02 14:10:00', 'This is a comment on a chapter.'),
    ('jane_smith', NULL, 1, '2023-01-03 09:20:00', 'A comment on the first proposal.'),
    ('bob_jones', 2, NULL, '2023-02-16 18:05:00', 'Commenting on a different chapter.'),
    ('john_doe', NULL, 3, '2023-03-21 11:30:00', 'Comment on the third proposal.');

INSERT INTO likes (username, chapter_id, proposal_id, comment_id, is_dislike)
VALUES
    ('jane_smith', 1, NULL, NULL, 0),
    ('bob_jones', NULL, 2, NULL, 1),
    ('john_doe', NULL, NULL, 2, 0),
    ('jane_smith', 2, NULL, NULL, 1),
    ('bob_jones', NULL, 3, NULL, 0),
    ('john_doe', NULL, NULL, 3, 0),
    ('jane_smith', 3, NULL, NULL, 0),
    ('bob_jones', NULL, NULL, 4, 1);


INSERT INTO followers (followed, follower) VALUES
    ('john_doe', 'jane_smith'),
    ('jane_smith', 'bob_jones'),
    ('bob_jones', 'john_doe'),
    ('alice_doe', 'john_doe');

INSERT INTO messages (sender, receiver, content, message_datetime) VALUES
    ('john_doe', 'jane_smith', 'Hello Jane!', '2023-01-01 08:00:00'),
    ('jane_smith', 'bob_jones', 'Hi Bob!', '2023-01-02 12:30:00'),
    ('bob_jones', 'john_doe', 'Hey John!', '2023-01-03 15:45:00'),
    ('alice_doe', 'john_doe', 'Hi John, how are you?', '2023-01-04 10:15:00');

INSERT INTO pools (story_id, title, content, expire_datetime) VALUES
    (1, 'Adventure Pool', 'Exciting adventures await!', '2023-02-28'),
    (2, 'Mystery Pool', 'Solve the mystery!', '2023-03-15'),
    (3, 'Fantasy Pool', 'Enter a world of magic!', '2023-04-10'),
    (4, 'Mystery Pool 2', 'Another mysterious story', '2023-05-20');

INSERT INTO options (pool_id, content) VALUES
    (1, 'Choose your path in the adventurous journey!'),
    (1, 'Face challenging puzzles and make crucial decisions'),
    (2, 'Unravel the mystery with careful choices'),
    (3, 'Interact with magical creatures and explore enchanted lands'),
    (3, 'Embark on a quest to save the fantasy realm'),
    (4, 'Investigate a new set of mysterious events'),
    (4, 'Decide the fate of the characters in the story');

INSERT INTO option_choices (option_id, username) VALUES
    (1, 'john_doe'),
    (2, 'jane_smith'),
    (3, 'bob_jones'),
    (4, 'john_doe'),
    (5, 'jane_smith'),
    (6, 'bob_jones'),
    (7, 'john_doe');
    
INSERT INTO notifications (notification_id, username, content, notification_datetime) VALUES
    (1, 'john_doe', 'Andrea created a new Story', '2024-05-05 10:30:00'),
    (2, 'john_doe', 'Andrea followed you!', '2024-05-05 14:00:00'),
    (3, 'jane_smith', 'Andrea upvoted your story!', '2024-05-05 18:00:00'),
    (4, 'bob_jones', 'New Pool of "Finding Andrea" has come out', '2024-05-05 11:45:00');