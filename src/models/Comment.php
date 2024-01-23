<?php
    class Comment {
        public $user_icon, $username;
        public $datetime, $content;
        public $nlikes, $ndislikes;
        
        public function __construct($user_icon, $username, $datetime, $content, $nlikes, $ndislikes) {
            $this->user_icon = $user_icon;
            $this->username = $username;
            $this->datetime = $datetime;
            $this->content = $content;
            $this->nlikes = $nlikes;
            $this->ndislikes = $ndislikes;
        }
    }
?>