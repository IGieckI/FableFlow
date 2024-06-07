<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try{
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

        if ($_POST['isAlreadyFollowing']=='true') {
            $db->follow($_POST['followed'], $_POST['follower']);        
            $db->generateNotification($_POST['followed'], $_POST['follower'] . " now follows you!");
        } else {
            $db->follow($_POST['followed'], $_POST['follower']);
        }

        $db->disconnect();
        $db = null;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>