INSERT INTO followers (followed, follower) VALUES
    ('john_doe', 'jane_smith'),
    ('jane_smith', 'bob_jones'),
    ('bob_jones', 'john_doe'),
    ('alice_doe', 'john_doe');

INSERT INTO messages (sender, receiver, content, date_time) VALUES
    ('john_doe', 'jane_smith', 'Hello Jane!', '2023-01-01 08:00:00'),
    ('jane_smith', 'bob_jones', 'Hi Bob!', '2023-01-02 12:30:00'),
    ('bob_jones', 'john_doe', 'Hey John!', '2023-01-03 15:45:00'),
    ('alice_doe', 'john_doe', 'Hi John, how are you?', '2023-01-04 10:15:00');

INSERT INTO pools (story_id, title, content, expire_date_time) VALUES
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



