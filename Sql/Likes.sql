CREATE TABLE likes(
    likeid INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    chapterid INT NULL,
    proposalid INT NULL,
    commentid INT NULL,
    FOREIGN KEY (username) REFERENCES users(username),
    FOREIGN KEY (chapterid) REFERENCES chapters(chapterid),
    FOREIGN KEY (proposalid) REFERENCES proposals(proposalid),
    FOREIGN KEY (commentid) REFERENCES comments(
        commentid)
    );