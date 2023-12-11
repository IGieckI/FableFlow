CREATE TABLE users (
    username VARCHAR(255) PRIMARY KEY,
    password VARCHAR(100) NOT NULL,
    icon GUID,
    description VARCHAR(50) DEFAULT ''
);