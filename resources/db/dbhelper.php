<?php 

class DbHelper {

    private $db;

    public function __construct($servername, $username, $password,
                                $dbname, $port) {
        
        //ini_set('display_errors', 1);
        
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        
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
        $query = $this->db->createQuery();
        $query->select('*')->from($this->$table);
        
        foreach ($criteria as $col => $value) {
            $query->andWhere($col, $value);
        }

        if (null !== $limit) {
           $query->limit($limit);
        }

        if (null !== $offset) {
           $query->offset($offset);
        }

        return $query->execute();
    }
}

?>