CREATE TABLE user_tag (
    name VARCHAR(255),
    username VARCHAR(255),
    FOREIGN KEY (name) REFERENCES tag(name),
    FOREIGN KEY (username) REFERENCES users(username)
);