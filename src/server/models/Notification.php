<?php 
    class Notification {
        public $id;
        public $username;
        public $content;
        public $datetime;
        
        public function __construct($id, $username, $datetime, $content) {
            $this->id = $id;
            $this->username = $username;
            $this->datetime = $datetime;
            $this->content = $content;
        }
    }
?>