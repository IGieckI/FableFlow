CREATE TABLE comments(
	commentid INT AUTO_INCREMENT PRIMARY KEY,
    username_commenting VARCHAR(255) NOT NULL,
    chapterid INT,
    proposalid INT,
    commentdatetime DATETIME NOT NULL,
    content TEXT NOT NULL,
    FOREIGN KEY (username_commenting) REFERENCES users(username),
    FOREIGN KEY (chapterid) REFERENCES chapters(chapterid),
    FOREIGN KEY (proposalid) REFERENCES proposals(proposalid)
);