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

        public function findBy(array $criteria, $limit = null, $offset = null, Tables $table, $join = null) {
            if (null !== $join) {
                $query = "SELECT * FROM $join";
            } else {
                $query = "SELECT * FROM " . $table->value;
            }
        
            $params = [];
            $types = '';
        
            if (!empty($criteria)) {
                $conditions = [];
                foreach ($criteria as $col => $value) {
                    $conditions[] = "$col = ?";
                    $params[] = $value;
                    $types .= 's'; // Assuming all criteria values are strings
                }
                $query .= " WHERE " . implode(' AND ', $conditions);
            }
        
            if (null !== $limit) {
                $query .= " LIMIT ?";
                $params[] = $limit;
                $types .= 'i'; // Assuming limit is an integer
            }
        
            if (null !== $offset) {
                $query .= " OFFSET ?";
                $params[] = $offset;
                $types .= 'i'; // Assuming offset is an integer
            }
        
            $stmt = $this->db->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
        
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
        
        public function deleteBy(array $criteria, Tables $table) {
            $query = "DELETE FROM " . $table->value;
            $params = [];
            $types = '';
        
            if (!empty($criteria)) {
                $conditions = [];
                foreach ($criteria as $col => $value) {
                    $conditions[] = "$col = ?";
                    $params[] = $value;
                    $types .= 's'; // Assuming all criteria values are strings
                }
                $query .= " WHERE " . implode(' AND ', $conditions);
            }
        
            $stmt = $this->db->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
        
            return $stmt->affected_rows > 0;
        }
        
        public function count(array $criteria, Tables $table) {
            $query = "SELECT COUNT(*) FROM " . $table->value;
            $params = [];
            $types = '';
        
            if (!empty($criteria)) {
                $conditions = [];
                foreach ($criteria as $col => $value) {
                    $conditions[] = "$col = ?";
                    $params[] = $value;
                    $types .= 's'; // Assuming all criteria values are strings
                }
                $query .= " WHERE " . implode(' AND ', $conditions);
            }
        
            $stmt = $this->db->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
        
            $data = $result->fetch_assoc();
        
            return $data;
        }
        
        public function complexQuery($query, $params = [], $types = '') {
            $stmt = $this->db->prepare($query);
            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            $result = $stmt->get_result();
        
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
        
        public function getProposals($chapter_id) {
            return $this->findBy(['chapter_id' => $chapter_id], null, null, Tables::Proposals);
        }
        
        public function updateLikesDislikes($username, $comment_id, $action) {
            $query = "";
            $types = 'si';
            $params = [$username, $comment_id];
        
            if ($action === 'like') {
                $query = "INSERT INTO " . Tables::Likes->value . " (username, is_dislike, comment_id) VALUES (?, 0, ?)";
            } elseif ($action === 'dislike') {
                $query = "INSERT INTO " . Tables::Likes->value . " (username, is_dislike, comment_id) VALUES (?, 1, ?)";
            } elseif ($action === 'remove') {
                $query = "DELETE FROM " . Tables::Likes->value . " WHERE username = ? AND comment_id = ?";
            }
        
            $stmt = $this->db->prepare($query);
            $stmt->bind_param($types, ...$params);
            return $stmt->execute();
        }
        
        public function postComment($username, $chapter_id, $content, $datetime) {
            $query = "INSERT INTO " . Tables::Comments->value . " (username, chapter_id, content, comment_datetime) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('siss', $username, $chapter_id, $content, $datetime); // Assuming chapter_id is an integer and the others are strings
            return $stmt->execute();
        }
        
        public function postProposal($chapter_id, $username, $title, $content) {
            $query = "INSERT INTO " . Tables::Proposals->value . " (chapter_id, username_proposing, title, content) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("isss", $chapter_id, $username, $title, $content); // "isss" indicates the types of the parameters: integer, string, string, string
            return $stmt->execute();
        }
        
        public function insertUser($username, $password) {
            $query = "INSERT INTO " . Tables::Users->value . " (username, password, icon, description) VALUES (?, ?, 'NULL', 'NULL')";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $username, $password);
            return $stmt->execute();
        }
        
        public function insertInto($values, Tables $table) {
            $placeholders = implode(',', array_fill(0, count($values), '?'));
            $query = "INSERT INTO " . $table->value . " VALUES ($placeholders)";
            $stmt = $this->db->prepare($query);
            $types = str_repeat('s', count($values)); // Assuming all values are strings
            $stmt->bind_param($types, ...$values);
            return $stmt->execute();
        }
        
        public function update($updates, $conditions, Tables $table) {
            $query = "UPDATE " . $table->value;
            $params = [];
            $types = '';
        
            if (!empty($updates)) {
                $updatesImploded = [];
                foreach ($updates as $col => $value) {
                    $updatesImploded[] = "$col = ?";
                    $params[] = $value;
                    $types .= 's'; // Assuming all update values are strings
                }
                $query .= " SET " . implode(',', $updatesImploded);
            }
        
            if (!empty($conditions)) {
                $conditionsImploded = [];
                foreach ($conditions as $col => $value) {
                    $conditionsImploded[] = "$col = ?";
                    $params[] = $value;
                    $types .= 's'; // Assuming all condition values are strings
                }
                $query .= " WHERE " . implode(' AND ', $conditionsImploded);
            }
        
            $stmt = $this->db->prepare($query);
            $stmt->bind_param($types, ...$params);
            return $stmt->execute();
        }
        
    }
?>