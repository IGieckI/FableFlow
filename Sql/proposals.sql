CREATE TABLE proposals(
	proposalid INT AUTO_INCREMENT PRIMARY KEY,
    chapterid INT NOT NULL,
    usernameproposing VARCHAR(255) NOT NULL,
    publicationdatetime DATETIME NOT NULL,
    content TEXT NOT NULL,
    FOREIGN KEY (chapterid) REFERENCES chapters(chapterid),
    FOREIGN KEY (usernameproposing) REFERENCES users(username)
);