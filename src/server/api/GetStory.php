<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try{
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
    
        $storyContent = $db->findBy(['chapter_id' => $_GET['chapterId']], ['chapter_id' => 'i'], null, null, Tables::Chapters)[0]['content'];

        $db->disconnect();
    
        header('Content-Type: application/json');

        echo json_encode($storyContent);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>