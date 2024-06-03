<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    error_log('UpdateCommentsLikesDislikes.php' . $_SERVER['REQUEST_METHOD']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $comment_id = $_POST['comment_id'];
        $action = $_POST['action'];

        error_log('username: ' . $username . ', comment_id: ' . $comment_id . ', action: ' . $action);

        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
        $db->updateLikesDislikes($username, $comment_id, $action);
        $db->disconnect();
        $db = null;
    } else {
        echo 'Invalid request method';
    }
?>
