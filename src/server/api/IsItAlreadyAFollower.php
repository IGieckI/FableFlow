<?php

require __DIR__ . '/../utilities/DbHelper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

$result = $db->findBy(['followed'=>$_GET['followed'], 'follower'=>$_GET['follower']], 1, 0, Tables::Followers);

$db->disconnect();

echo json_encode(['result'=>(sizeof($result)==0)?FALSE:TRUE]);


?>