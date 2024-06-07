<?php

require '../utilities/DbHelper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try{
    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    /* the r stands for record */
    $pools_r = $db->findBy(['chapter_id'=>$_GET['chapterId']],['chapter_id'=>'i'], null, null, Tables::Pools);


    $db->disconnect();

    echo json_encode(['pools'=>$pools_r]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>