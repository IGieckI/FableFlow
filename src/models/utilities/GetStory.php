<?php
    require './DbHelper.php';
    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
    
    $data = $db.findBy(['chapter_id' => $_GET['id']], null, null, Tables::Chapters);
    $data = $data[0]['content'];

    header('Content-Type: application/json');

    echo json_encode($data);
?>