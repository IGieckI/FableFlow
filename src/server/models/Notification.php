<?php 
    class Notification {
        public $notification_id;
        public $username;
        public $content;
        public $datetime;
        
        public function __construct($notification_id, $username, $datetime, $content) {
            $this->notification_id = $notification_id;
            $this->username = $username;
            $this->datetime = $datetime;
            $this->content = $content;
        }
    }
?>