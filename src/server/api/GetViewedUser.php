<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__ . '/../models/User.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try{
        $myprofile = TRUE;

    if (isset($_GET['user_viewing']) && strcmp($_GET['user_viewing'], $_SESSION['username'])!=0) {
        $username = $_GET['user_viewing'];
        $myprofile = FALSE;
    } else {
        $username = $_SESSION['username'];
    }

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
    $user = $db->getUser($username);
    $db->disconnect();
        $db = null;

    $user = new User($user[0]['username'], $user[0]['icon'], $user[0]['description']); 
    //header('Content-Type: application/json');
    echo json_encode(['user'=>$user, 'myprofile'=>$myprofile]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>