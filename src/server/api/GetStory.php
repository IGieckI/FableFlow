<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    
    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
    
    $data = $db->findBy(['chapter_id' => $_GET['id']], null, null, Tables::Chapters);
    $data = $data[0]['content'];
    $db->disconnect();
    
    header('Content-Type: application/json');

    echo json_encode($data);
?>