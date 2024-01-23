<?php
    require './DbHelper.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $comment_id = $_POST['comment_id'];
        $quantity = $_POST['action'];

        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
        $dbHelper->updateLikesDislikes($username, $comment_id, $action);
        $dbHelper->disconnect();

        echo 'Database updated successfully';
    } else {
        echo 'Invalid request method';
    }
?>
