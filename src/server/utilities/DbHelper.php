<?php

    require 'Config.php';

    enum Tables: string {
        case Chapters = 'chapters';    
        case Comments = 'comments';
        case Followers = 'followers';
        case Likes = 'likes';
        case Messages = 'messages';
        case Notifications = 'notifications';
        case OptionChoices = 'option_choices';
        case Options = 'options';
        case Pools = 'pools';
        case Proposals = 'proposals';
        case Stories = 'stories';
        case StoriesTag = 'stories_tag';
        case Tag = 'tag';
        case UserTag = 'user_tag';
        case Users = 'users';
    }

    class DbHelper {

        private $db;

        //Function for checking if the DB is doing good
        public function __construct($host, $user, $password, $dbname, $port, $socket) {
            
            $this->db = new \mysqli($host, $user, $password, $dbname, $port, $socket)
            or die ('Could not connect to the database server' . mysqli_connect_error());
            
            if ($this->db->connect_error) {
                die("Error not expected, please contact the administrator. " . $this->db->connect_error);
            }
        }

        public function disconnect() {
            if ($this->db) {
                $this->db->close();
            }
        }

        public function isConnectionAlive() {
            if ($this->db->ping()) {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        // This function is used to find rows in a table based on the given criteria
        public function findBy(array $criteria, array $types, $limit = null, $offset = null, Tables $table = null, $join = null, $selectwhat = null) {
            $query = "SELECT";
        
            if (null !== $selectwhat) {
                $query .= " " . implode(',', $selectwhat);
            } else {
                $query .= " *";
            }
        
            if (null !== $join) {
                $query .= " FROM $join";
            } else {
                $query .= " FROM " . $table->value;
            }
        
            $params = [];
            $param_types = '';
        
            if (!empty($criteria)) {
                $conditions = [];
                foreach ($criteria as $col => $value) {
                    $conditions[] = "$col = ?";
                    $params[] = $value;
                    $param_types .= $types[$col];
                }
                $query .= " WHERE " . implode(' AND ', $conditions);
            }
        
            if (null !== $limit) {
                $query .= " LIMIT ?";
                $params[] = $limit;
                $param_types .= 'i';
            }
        
            if (null !== $offset) {
                $query .= " OFFSET ?";
                $params[] = $offset;
                $param_types .= 'i';
            }
        
            // Manange parameters
            $stmt = $this->db->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param($param_types, ...$params);
            }        
            $stmt->execute();        
            $result = $stmt->get_result();
        
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        
            $stmt->close();        
            return $data;
        }
        
        // This function is used to delete a row from a table based on the given criteria
        public function deleteBy(array $criteria, array $types, Tables $table) {
            $query = "DELETE FROM " . $table->value;
            $params = [];
            $param_types = '';
        
            if (!empty($criteria)) {
                $conditions = [];
                foreach ($criteria as $col => $value) {
                    $conditions[] = "$col = ?";
                    $params[] = $value;
                    $param_types .= $types[$col];
                }
                $query .= " WHERE " . implode(' AND ', $conditions);
            }
        
            $statement = $this->db->prepare($query);
            if (!$statement) {
                throw new Exception("Failed to prepare statement: " . $this->db->error);
            }
        
            if (!empty($params)) {
                $statement->bind_param($param_types, ...$params);
            }
        
            $statement->execute();
        
            $affected_rows = $statement->affected_rows;
        
            $statement->close();
        
            return $affected_rows > 0;
        }

        // This function is used to count the number of rows in a table based on the given criteria
        public function count(array $criteria, array $types, Tables $table) {
            $query = "SELECT COUNT(*) FROM " . $table->value;
            $params = [];
            $param_types = '';
        
            if (!empty($criteria)) {
                $conditions = [];
                foreach ($criteria as $col => $value) {
                    $conditions[] = "$col = ?";
                    $params[] = $value;
                    $param_types .= $types[$col];
                }
                $query .= " WHERE " . implode(' AND ', $conditions);
            }
        
            $statement = $this->db->prepare($query);
            if (!$statement) {
                throw new Exception("Failed to prepare statement: " . $this->db->error);
            }
        
            if (!empty($params)) {
                $statement->bind_param($param_types, ...$params);
            }
        
            $statement->execute();
        
            $result = $statement->get_result();
            $data = $result->fetch_assoc();
        
            $statement->close();
        
            return $data['COUNT(*)'];
        }
        
        // This function is used to execute an arbitrary query
        public function complexQuery($query, array $params, array $types) {
            $statement = $this->db->prepare($query);
            if (!$statement) {
                throw new Exception("Failed to prepare statement: " . $this->db->error);
            }
        
            // Bind the parameters
            if (!empty($params)) {
                $statement->bind_param(implode('', $types), ...$params);
            }
        
            $statement->execute();
            $result = $statement->get_result();
        
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        
            $statement->close();        
            return $data;
        }
        

        public function getStory($story_id) {
            return $this->findBy(['story_id' => $story_id], ['story_id' => 'i'], 1, 0, Tables::Stories);
        }

        // This function is used to get the chapter ID based on the given criteria
        public function getChapter($chapter_id) {
            return $this->findBy(['chapter_id' => $chapter_id], ['chapter_id' => 'i'], 1, 0, Tables::Chapters);
        }
        
        // This function is used to get the username based on the given criteria
        public function getUser($username) {
            return $this->findBy(['username' => $username], ['username' => 's'], 1, 0, Tables::Users);
        }

        // This function is used to get the proposal based on the given criteria
        public function getProposals($chapter_id) {
            return $this->findBy(['chapter_id' => $chapter_id], ['chapter_id' => 'i'], null, null, Tables::Proposals);
        }

        // This function is used to update the comment likes and dislikes based on the given criteria
        public function updateCommentsLikesDislikes($username, $comment_id, $action) {
            $query = "";
        
            if ($action === 'like') {
                $query .= "INSERT INTO " . Tables::Likes->value . " (username, is_dislike, comment_id) VALUES (?, 0, ?);";
            } elseif ($action === 'dislike') {
                $query .= "INSERT INTO " . Tables::Likes->value . " (username, is_dislike, comment_id) VALUES (?, 1, ?);";
            } elseif ($action === 'remove') {
                $query .= "DELETE FROM " . Tables::Likes->value . " WHERE username = ? AND comment_id = ?;";
            }

            $stmt = $this->db->prepare($query);
            $stmt->bind_param("si", $username, $comment_id);
            return $stmt->execute();
            $stmt->close();
        }

        // This function is used to update the chapter likes and dislikes based on the given criteria
        public function updateChapterLikes($username, $chapterId, $action) {
            $query = "";
        
            if ($action === 'like') {
                $query .= "INSERT INTO " . Tables::Likes->value . " (username, is_dislike, chapter_id) VALUES (?, 0, ?);";
            } elseif ($action === 'unlike') {
                $query .= "DELETE FROM " . Tables::Likes->value . " WHERE username = ? AND chapter_id = ?;";
            }

            $stmt = $this->db->prepare($query);
            $stmt->bind_param("si", $username, $chapterId);
            return $stmt->execute();
            $stmt->close();
        }

        // This function is used to update the proposal likes and dislikes based on the given criteria
        public function updateProposalLikes($username, $proposalId, $action) {
            $query = "";
        
            if ($action === 'like') {
                $query .= "INSERT INTO " . Tables::Likes->value . " (username, is_dislike, proposal_id) VALUES (?, 0, ?);";
            } elseif ($action === 'unlike') {
                $query .= "DELETE FROM " . Tables::Likes->value . " WHERE username = ? AND proposal_id = ?;";
            }

            $stmt = $this->db->prepare($query);
            $stmt->bind_param("si", $username, $proposalId);
            return $stmt->execute();
            $stmt->close();
        }

        // This function is used to post a story based on the given criteria
        public function postStory($username, $title) {
            $query = "INSERT INTO " . Tables::Stories->value . " (title, username) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ss", $title, $username);
            return $stmt->execute();
            $stmt->close();
        }

        // This function is used to post a chapter based on the given criteria
        public function postChapter($storyId, $chapterTitle, $content, $picture) {
            $query = "INSERT INTO " . Tables::Chapters->value . " (story_id, chapter_title, content, picture) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("isss", $storyId, $chapterTitle, $content, $picture);
            return $stmt->execute();
            $stmt->close();
        }

        // This function is used to post a comment based on the given criteria
        public function postComment($username, $chapterId, $content) {
            $query = "INSERT INTO " . Tables::Comments->value . " (username, chapter_id, content) VALUES (?, ?, ?);";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sis", $username, $chapterId, $content);
            return $stmt->execute();
            $stmt->close();
        }

        // This function is used to post a proposal comment based on the given criteria
        public function postProposalComment($username, $proposalId, $content) {
            $query = "INSERT INTO " . Tables::Comments->value . " (username, proposal_id, content) VALUES (?, ?, ?);";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("sis", $username, $proposalId, $content);
            return $stmt->execute();
            $stmt->close();
        }

        // This function is used to post a proposal based on the given criteria
        public function postProposal($chapterId, $username, $title, $content) {
            $query = "INSERT INTO " . Tables::Proposals->value . " (chapter_id, username_proposing, title, content) VALUES (?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("isss", $chapterId, $username, $title, $content);
            return $stmt->execute();
            $stmt->close();
        }
        
        // This function is used to insert user in the db based on the given criteria
        public function insertUser($username, $password) {
            $query = "INSERT INTO " . Tables::Users->value . " (username, password) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ss", $username, $password);
            return $stmt->execute();
            $stmt->close();
        }

        public function insertInto($values, Tables $table, $attributes=null) {
            $query = "INSERT INTO " . $table->value . " ";
            if($attributes !== null) {
                $query .= "(".implode(',', $attributes).")";
            }
            $query = $query . " VALUES (".implode(',', $values).')';
            $this->db->query($query);
        }

        // General function for update something in the db
        public function update($updates, $conditions, Tables $table) {
            $query = "UPDATE " . $table->value . " ";

            if (!empty($updates)) {
                $updatesImploded = [];
                foreach ($updates as $col=>$value) {
                    $updatesImploded[] = "$col = $value";
                }
                $query .= " SET " . implode(',', $updatesImploded);
            }
            
            if (!empty($conditions)) {
                $conditionsImploded = [];
                foreach ($conditions as $col => $value) {
                    $conditionsImploded[] = "$col = $value";
                }
                $query .= " WHERE " . implode(' AND ', $conditionsImploded);
            }

            error_log($query);
            $this->db->query($query);
        }

        // This function is used to generate notifications based on the given criteria
        public function generateNotification($username, $content) {
            $query = "INSERT INTO " . Tables::Notifications->value . " (username, content) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ss", $username, $content);
            return $stmt->execute();
            $stmt->close();
        }

        // This function is used to generate notifications based on the given criteria
        public function follow($followed, $follower) {
            $query = "INSERT INTO " . Tables::Followers->value . " (followed, follower) VALUES (?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ss", $followed, $follower);
            return $stmt->execute();
            $stmt->close();
        }

        // This function is used to unfollow someone based on the given criteria
        public function unfollow($followed, $follower) {
            $query = "DELETE FROM " . Tables::Followers->value . " WHERE followed = ? AND follower = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("ss", $followed, $follower);
            return $stmt->execute();
            $stmt->close();
        }

        // This function return 0 if the user has not liked or disliked the comment, 1 if the user has liked the comment, and -1 if the user has disliked the comment
        public function commentStatus($commentId, $username) {
            $query = "SELECT is_dislike FROM " . Tables::Likes->value . " WHERE comment_id = ? AND username = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("is", $commentId, $username);
            $stmt->execute();
            $stmt->bind_result($is_dislike);
            
            if ($stmt->fetch()) {
                return $is_dislike ? -1 : 1;
            } else {
                return 0;
            }
            $stmt->close();
        }

        // This function return 0 if the user has not liked or disliked the proposal, 1 if the user has liked the proposal, and -1 if the user has disliked the proposal
        public function proposalStatus($proposalId, $username) {
            $query = "SELECT is_dislike FROM " . Tables::Likes->value . " WHERE proposal_id = ? AND username = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("is", $proposalId, $username);
            $stmt->execute();
            $stmt->bind_result($is_dislike);
            
            if ($stmt->fetch()) {
                return $is_dislike ? -1 : 1;
            } else {
                return 0;
            }
            $stmt->close();
        }

        // This function return 0 if the user has not liked or disliked the chapter, 1 if the user has liked the chapter, and -1 if the user has disliked the chapter
        public function chapterStatus($chapterId, $username) {
            $query = "SELECT is_dislike FROM " . Tables::Likes->value . " WHERE chapter_id = ? AND username = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("is", $chapterId, $username);
            $stmt->execute();
            $stmt->bind_result($is_dislike);
            
            if ($stmt->fetch()) {
                return $is_dislike ? -1 : 1;
            } else {
                return 0;
            }
            $stmt->close();
        }
        
        function getStoryID($username, $title){
            $query = "SELECT story_id FROM " . Tables::Stories->value . " WHERE username = ? AND title = ?";
            
            $stmt = $this->db->prepare($query);    
            $stmt->bind_param("ss", $username, $title);        
            $stmt->execute();
        
            $result = $stmt->get_result();
        
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['story_id'];
            } else {
                return null;
            }
            $stmt->close();
        }

        function postUserPoolChoice($username, $optionId) {
            $query = "INSERT INTO " . Tables::OptionChoices->value . " (username, option_id) VALUES (?, ?)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("si", $username, $optionId);
            
            return $stmt->execute();
        }
        
        function removeUserPoolChoice($username, $optionId) {
            $query = "REMOVE FROM " . Tables::OptionChoices->value . " WHERE username = ? AND option_id = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("si", $username, $optionId);
            
            return $stmt->execute();
        }
    }

?>