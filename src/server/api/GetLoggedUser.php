<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__ . '/../models/User.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
    $user = $db->getUser($_SESSION['username']);
    $db->disconnect();

    $user = new User($user[0]['username'], $user[0]['icon'], $user[0]['description']); 
    header('Content-Type: application/json');
    echo json_encode(array($user));
?>