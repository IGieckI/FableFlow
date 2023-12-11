CREATE TABLE messages (
    message_id INT IDENTITY (1,1),
    sender VARCHAR(255) REFERENCES users(username),
    receiver VARCHAR(255) REFERENCES users(username),
    content VARCHAR(500),
    date_time DATE,
    CONSTRAINT messaggio PRIMARY KEY(message_id, sender, receiver)
);