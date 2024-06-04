<?php
    class Proposal {
        public $proposalId, $chapterId;
        public $user;
        public $publicationDatetime;
        public $title, $content;
        public $num_likes, $num_comments;
        
        public function __construct($proposalId, $chapterId, $user, $title, $publicationDatetime, $content, $num_likes, $num_comments) {
            $this->proposalId = $proposalId;
            $this->chapterId = $chapterId;
            $this->user = $user;
            $this->publicationDatetime = $publicationDatetime;
            $this->title = $title;
            $this->content = $content;
            $this->num_likes = $num_likes;
            $this->num_comments = $num_comments;
        }
    }
?>