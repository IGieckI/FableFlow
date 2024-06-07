<?php

require '../utilities/DbHelper.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

/* the r stands for record */
$pools_r = $db->findBy(['chapter_id'=>$_GET['chapterId']], null, null, Tables::Pools);

error_log("AAAAAAAAAAAAAAAAAAAAAAA");

$db->disconnect();

echo json_encode(['pools'=>$pools_r]);

?>