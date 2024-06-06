<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
    
    $storyContent = $db->findBy(['chapter_id' => $_GET['chapterId']], null, null, Tables::Chapters)[0]['content'];

    $db->disconnect();
    
    header('Content-Type: application/json');

    echo json_encode($storyContent);
?>