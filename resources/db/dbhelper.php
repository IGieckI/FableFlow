<?php 

enum Tables: string {
    case Chapters = 'chapters';    
    case Comments = 'comments';
    case Followers = 'followers';
    case Likes = 'likes';
    case Messages = 'messages';
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
        
        //ini_set('display_errors', 1);
        
        $this->db = new mysqli($host, $user, $password, $dbname, $port, $socket)
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

    public function findBy(array $criteria, $limit = null, $offset = null, Tables $table) {
        $query = "SELECT * FROM $table->value";
    
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
    
        // Handle errors if needed
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    
        return $data;
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
    
        // Handle errors if needed
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    
        return $data;
    }
    
}

?>