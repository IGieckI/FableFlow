CREATE TABLE option {
    option_id INT PRIMARY KEY IDENTITY (1,1),
    pool_id INT REFERENCES pools(pool_id),
    content VARCHAR(200)
};