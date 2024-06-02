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

        public function __construct($host, $user, $password, $dbname, $port, $socket) {
            
            $this->db = new \mysqli($host, $user, $password, $dbname, $port, $socket)
            or die ('Could not connect to the database server' . mysqli_connect_error());
            
            if ($this->db->connect_error) {
                error_log('$this->db->connect_error');
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

        public function findBy(array $criteria, $limit = null, $offset = null, Tables $table, $join = null, $selectwhat = null) {
            
            $query = "SELECT";

            if (null !== $selectwhat) {
                $query .= " " . implode(',', $selectwhat);
            } else {
                $query .= " *";
            }

            if (null !== $join) {
                $query .= " FROM $join";
            } else {
                $query .= " FROM $table->value";
            }
        
            if (!empty($criteria)) {
                $conditions = [];
                foreach ($criteria as $col => $value) {
                    $conditions[] = "$col = '$value'";
                }
                $query .= " WHERE " . implode(' AND ', $conditions);
            }
        
            if (null !== $limit) {
                $query .= " LIMIT $limit";
            }
        
            if (null !== $offset) {
                $query .= " OFFSET $offset";
            }
            
            $result = $this->db->query($query);
        
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }

        public function deleteBy(array $criteria, Tables $table) {
            $query = "DELETE FROM $table->value";
            $params = [];
            
            if (!empty($criteria)) {
                $conditions = [];
                foreach ($criteria as $col => $value) {
                    $conditions[] = "$col = ?";
                    $params[] = $value;
                }
                $query .= " WHERE " . implode(' AND ', $conditions);
            }
            
            $statement = $this->db->prepare($query);
            if (!$statement) {
                throw new Exception("Failed to prepare statement: " . $this->db->error);
            }
            
            if (!empty($params)) {
                $types = str_repeat('s', count($params));
                $statement->bind_param($types, ...$params);
            }
            
            $statement->execute();
            
            return $statement->affected_rows > 0;
        }
        
        

        public function count(array $criteria, Tables $table) {
            $query = "SELECT COUNT(*) FROM $table->value";
        
            if (!empty($criteria)) {
                $conditions = [];
                foreach ($criteria as $col => $value) {
                    $conditions[] = "$col = '$value'";
                }
                $query .= " WHERE " . implode(' AND ', $conditions);
            }
        
            $result = $this->db->query($query);
        
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        
            return $data;
        }

        public function complexQuery($query) {
            $result = $this->db->query($query);
        
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        
            return $data;
        }

        public function getStory($story_id) {
            return $this->findBy(['story_id' => $story_id], 1, 0, Tables::Stories);
        }

        public function getChapter($chapter_id) {
            return $this->findBy(['chapter_id' => $chapter_id], 1, 0, Tables::Chapters);
        }
        
        public function getUser($username) {
            return $this->findBy(['username' => $username], 1, 0, Tables::Users);
        }

        public function updateLikesDislikes($username, $comment_id, $action) {
            $query = "";
        
            if ($action === 'like') {
                $query .= "INSERT INTO " . Tables::Likes->value . " (username, is_dislike, comment_id) VALUES ('$username', 0, $comment_id);";
            } elseif ($action === 'dislike') {
                $query .= "INSERT INTO " . Tables::Likes->value . " (username, is_dislike, comment_id) VALUES ('$username', 1, '$comment_id');";
            } elseif ($action === 'remove') {
                $query .= "DELETE FROM " . Tables::Likes->value . " WHERE username = '$username' AND comment_id = '$comment_id';";
            }

            return $this->db->query($query);
        }

        public function postComment($username, $chapter_id, $content, $datetime) {
            $query = "INSERT INTO " . Tables::Comments->value . " (username, chapter_id, content, comment_datetime) VALUES ('$username', '$chapter_id', '$content', '$datetime');";
            return $this->db->query($query);
        }
        
        public function insertUser($username, $password) {
            $query = "INSERT INTO " . Tables::Users->value . " (username, password, icon, description) VALUES ('$username', '$password', 'NULL', 'NULL')";
            return $this->db->query($query);
        }

        public function insertInto($values, Tables $table) {
            $query = "INSERT INTO " . $table->value . " VALUES (";
            $this->db->query($query . implode(',', $values). ')');
        }

        public function update($updates, $conditions, Tables $table) {
            $query = "UPDATE " . $table->value;

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
            $this->db->query($query);
        }
    }
?>