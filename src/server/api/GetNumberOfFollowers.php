<?php
    require '../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    $result = $db->complexQuery("SELECT count(*) as followers FROM followers WHERE followed=?", [$_GET['username']], ['s'])[0]['followers'];

    $db->disconnect();
            $db = null;

    echo json_encode(['nfollowers'=>$result]);

?>