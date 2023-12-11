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

INSERT INTO users (username, password, icon, description) VALUES
    ('john_doe', 'password123', '4F45C6A3-45D4-2F2B-1C1E-9876543210AB', 'User account for John Doe'),
    ('jane_smith', 'pass456', '8A2B1C0D-3E4F-5A6B-9C8D-76543210FEDC', NULL),
    ('bob_jones', 'secretPass', '1B2C3D4E-5F6A-7B8C-9D0E-123456789ABC', 'User account for Bob Jones');

INSERT INTO stories (story_id, title) VALUES
    (1, 'The Adventure Begins'),
    (2, 'Mystery of the Lost City'),
    (3, 'A Tale of Two Worlds'),
    (4, 'Echoes from the Past'),
    (5, 'Legends of the Hidden Realm');

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
INSERT INTO chapters (storyid, content, publicationdatetime)
VALUES
    (1, 'Chapter 1 content', '2023-01-01 12:00:00'),
    (1, 'Chapter 2 content', '2023-01-02 14:30:00'),
    (2, 'Chapter 1 content', '2023-02-15 15:30:00'),
    (3, 'Chapter 1 content', '2023-03-20 10:45:00');

-- Insert into proposals
INSERT INTO proposals (chapterid, usernameproposing, publicationdatetime, content)
VALUES
    (1, 'john_doe', '2023-01-01 12:00:00', 'This is a proposal content.'),
    (2, 'jane_smith', '2023-01-02 14:30:00', 'Another proposal for a chapter.'),
    (3, 'bob_jones', '2023-02-15 15:30:00', 'A third proposal for a chapter.');

-- Insert into comments
INSERT INTO comments (username_commenting, chapterid, proposalid, commentdatetime, content)
VALUES
    ('john_doe', 1, NULL, '2023-01-02 14:10:00', 'This is a comment on a chapter.'),
    ('jane_smith', NULL, 1, '2023-01-03 09:20:00', 'A comment on the first proposal.'),
    ('bob_jones', 2, NULL, '2023-02-16 18:05:00', 'Commenting on a different chapter.'),
    ('john_doe', NULL, 3, '2023-03-21 11:30:00', 'Comment on the third proposal.');

-- Insert into likes
INSERT INTO likes (username, chapterid, proposalid, commentid)
VALUES
    ('john_doe', 1, NULL, NULL),
    ('jane_smith', NULL, 1, NULL),
    ('bob_jones', 2, NULL, NULL),
    ('john_doe', NULL, NULL, 1);