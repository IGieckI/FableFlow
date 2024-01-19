<?php
    namespace mvc\models;
    
    class Post {

        public $user_icon, $username, $time;
        public $post_title, $num_comments, $num_likes;
        public $post_content;
        
        public function __construct($user_icon, $username, $time, $post_title, $num_comments, $num_likes, $post_content) {            
            $this->user_icon = $user_icon;
            $this->username = $username;
            $this->time = $time;
            $this->post_title = $post_title;
            $this->num_comments = $num_comments;
            $this->num_likes = $num_likes;
            $this->post_content = $post_content;
        }
    }
?>