CREATE TABLE chapters(
	chapterid INT AUTO_INCREMENT PRIMARY KEY,
    storyid INT NOT NULL,
   	content TEXT,
    publicationdatetime DATETIME NOT NULL
);