<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    if ($_POST['isAlreadyFollowing']=='true') {
        $db->deleteBy(['followed'=>$_POST['followed'], 'follower'=>$_POST['follower']], Tables::Followers);
    } else {
        $db->insertInto(["'".$_POST['followed']."'", "'".$_POST['follower']."'"], Tables::Followers);
    }

    $db->disconnect();
    $db = null;
?>