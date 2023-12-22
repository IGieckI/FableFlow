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
    date_time DATE,
    CONSTRAINT messages PRIMARY KEY(message_id, sender, receiver)
);

CREATE TABLE option_choices (
    option_id INT AUTO_INCREMENT
    username VARCHAR(255) REFERENCES users(username),
    CONSTRAINT option_choices PRIMARY KEY (option_id, username)
);

CREATE TABLE options (
    option_id INT AUTO_INCREMENT,
    pool_id INT REFERENCES pools(pool_id),
    content VARCHAR(200),
    CONSTRAINT options PRIMARY KEY(option_id, pool_id)
);

CREATE TABLE pools (
    pool_id INT PRIMARY KEY AUTO_INCREMENT,
    story_id INT REFERENCES stories(story_id),
    title VARCHAR (50), 
    content VARCHAR (500),
    expire_date_time DATE
);