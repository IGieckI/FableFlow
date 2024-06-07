<?php
    class Post {
        public $chapter_id;
        public $user_icon, $username, $time;
        public $picture;
        public $post_title, $story_title, $num_comments, $num_likes;
        public $post_content;
        public $liked;
        
        public function __construct($chapter_id, $user_icon, $username, $time, $post_title, $story_title, $num_comments, $picture, $num_likes, $post_content, $liked) {
            $this->chapter_id = $chapter_id;
            $this->user_icon = $user_icon;
            $this->username = $username;
            $this->time = $time;
            $this->post_title = $post_title;
            $this->story_title = $story_title;
            $this->num_comments = $num_comments;
            $this->picture = $picture;
            $this->num_likes = $num_likes;
            $this->post_content = $post_content;
            $this->liked = $liked;
        }
    }
?>