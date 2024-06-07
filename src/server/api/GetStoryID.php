<?php
require __DIR__ . '/../utilities/DbHelper.php';

function getStoryID($db, $username, $title){
    $query = "SELECT story_id FROM stories WHERE username = ? AND title = ?";
    
    if ($stmt = $db->prepare($query)) {
        
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
    } else {
        throw new Exception("Errore nella preparazione della query: " . $db->error);
    }
}
?>