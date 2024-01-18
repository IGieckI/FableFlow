<?php
    class Post {

        private $user_icon, $username, $time;
        private $post_title, $num_comments, $num_likes;
        private $post_content;
        
        public function __construct($user_icon, $username, $time, $post_title, $num_comments, $num_likes, $post_content) {) {            
            $this->user_icon = $user_icon;
            $this->username = $username;
            $this->time = $time;
            $this->post_title = $post_title;
            $this->num_comments = $num_comments;
            $this->num_likes = $num_likes;
            $this->post_content = $post_content;
        }

        public function get_user_icon() {
            return $this->user_icon;
        }

        public function get_username() {
            return $this->username;
        }

        public function get_time() {
            return $this->time;
        }

        public function get_post_title() {
            return $this->post_title;
        }

        public function get_num_comments() {
            return $this->num_comments;
        }

        public function get_num_likes() {
            return $this->num_likes;
        }

        public function get_post_content() {
            return $this->post_content;
        }
    }
?>