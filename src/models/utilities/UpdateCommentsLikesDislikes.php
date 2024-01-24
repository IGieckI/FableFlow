<?php
    require './DbHelper.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $comment_id = $_POST['comment_id'];
        $action = $_POST['action'];

        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
        $db->updateLikesDislikes($username, $comment_id, $action);
        $db->disconnect();

        echo 'Database updated successfully';
    } else {
        echo 'Invalid request method';
    }
?>
