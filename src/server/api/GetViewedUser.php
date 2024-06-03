<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__ . '/../models/User.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $myprofile = TRUE;

    if (isset($_GET['user_viewing']) && strcmp($_GET['user_viewing'], $_SESSION['username'])!=0) {
        $username = $_GET['user_viewing'];
        error_log("<--------------------------!!!!: " .$_GET['user_viewing']);
        $myprofile = FALSE;
    } else {
        error_log(">--------------------------????" . $_SESSION['username']);
        $username = $_SESSION['username'];
    }

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
    $user = $db->getUser($username);
    $db->disconnect();

    $user = new User($user[0]['username'], $user[0]['icon'], $user[0]['description']); 
    //header('Content-Type: application/json');
    echo json_encode(['user'=>$user, 'myprofile'=>$myprofile]);
?>