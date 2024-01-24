<?php
    class Comment {
        public $comment_id;
        public $user_icon, $username;
        public $datetime, $content;
        public $nlikes, $ndislikes;
        
        public function __construct($comment_id, $user_icon, $username, $datetime, $content, $nlikes, $ndislikes) {
            $this->comment_id = $comment_id;
            $this->user_icon = $user_icon;
            $this->username = $username;
            $this->datetime = $datetime;
            $this->content = $content;
            $this->nlikes = $nlikes;
            $this->ndislikes = $ndislikes;
        }
    }
?>