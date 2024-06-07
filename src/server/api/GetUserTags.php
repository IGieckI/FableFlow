<?php
    require '../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try{
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

        $result = $db->complexQuery("SELECT ut.name as tag FROM user_tag as ut WHERE ut.username=?", [$_GET['username']], ['s']);

        $db->disconnect();
        $db = null;

        echo json_encode(["tags"=>$result]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>