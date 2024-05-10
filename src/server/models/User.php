<?php 
    class User {
        public $username;
        public $pic_uri;
        public $description;
        
        public function __construct($username, $pic_uri, $description) {
            $this->username = $username;
            $this->pic_uri = $pic_uri;
            $this->description = $description;
        }
    }
?>