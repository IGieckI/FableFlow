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
    ('jane_smith', 'pass456', '8A2B1C0D-3E4F-5A6B-9C8D-76543210FEDC'),
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
