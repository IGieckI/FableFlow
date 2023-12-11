CREATE TABLE pools {
    pool_id INT PRIMARY KEY IDENTITY (1,1),
    story_id INT REFERENCES stories(story_id),
    title VARCHAR (50), 
    content VARCHAR (500),
    expire_date_time DATE
};