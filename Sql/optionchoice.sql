CREATE TABLE option_choice {
    option_id INT PRIMARY KEY IDENTITY (1,1),
    username VARCHAR(255) REFERENCES users(username)
}