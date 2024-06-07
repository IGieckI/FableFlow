<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try{
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_SESSION['username'];
            $comment_id = $_POST['comment_id'];
            $action = $_POST['action'];
    
            $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
            $db->updateCommentsLikesDislikes($username, $comment_id, $action);
            $db->disconnect();
            $db = null;
        } else {
            echo 'Invalid request method';
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>
