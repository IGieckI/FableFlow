<?php
    require '../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    $result = $db->complexQuery("SELECT count(*) as followed FROM followers WHERE follower='".$_GET['username']."'")[0]['followed'];

    $db->disconnect();
            $db = null;

    echo json_encode(['nfollowed'=>$result]);

?>