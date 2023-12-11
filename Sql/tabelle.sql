CREATE TABLE followers (
    followed VARCHAR(255) REFERENCES users(username),
    follower VARCHAR(255) REFERENCES users(username),
    CONSTRAINT follow PRIMARY KEY(followed, follower)
);

CREATE TABLE messages (
    message_id INT AUTO_INCREMENT,
    sender VARCHAR(255) REFERENCES users(username),
    receiver VARCHAR(255) REFERENCES users(username),
    content VARCHAR(500),
    date_time DATE,
    CONSTRAINT messaggio PRIMARY KEY(message_id, sender, receiver)
);

CREATE TABLE option_choice (
    option_id INT PRIMARY KEY AUTO_INCREMENT
    username VARCHAR(255) REFERENCES users(username)
);

CREATE TABLE option (
    option_id INT PRIMARY KEY AUTO_INCREMENT,
    pool_id INT REFERENCES pools(pool_id),
    content VARCHAR(200)
);

CREATE TABLE pools (
    pool_id INT PRIMARY KEY AUTO_INCREMENT,
    story_id INT REFERENCES stories(story_id),
    title VARCHAR (50), 
    content VARCHAR (500),
    expire_date_time DATE
);