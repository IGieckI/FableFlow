CREATE TABLE stories_tag (
    name VARCHAR(255),
    story_id INT,
    FOREIGN KEY (name) REFERENCES tag(name),
    FOREIGN KEY (story_id) REFERENCES stories(story_id)
);