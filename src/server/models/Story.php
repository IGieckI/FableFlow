<?php
    class Post {
        public $story_id, $title;
        
        public function __construct($story_id, $title) {            
            $this->$story_id = $story_id;
            $this->$title = $title;
        }
    }
?>