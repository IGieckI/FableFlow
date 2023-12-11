CREATE TABLE users (
    username VARCHAR(255) PRIMARY KEY,
    password VARCHAR(100) NOT NULL,
    icon VARCHAR(36), /*uuid()*/
    description VARCHAR(50) DEFAULT ''
);