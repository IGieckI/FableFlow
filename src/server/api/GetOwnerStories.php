<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try{
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
        $username = $_SESSION['username'];
        
        $stories = $db->findBy(['username' => $username], ['username' => 's'], null, null, Tables::Stories);

        $titles = [];
        
        foreach($stories as $story){
            $titles[] = $story["title"];
        }

        echo json_encode(['titles' => $titles]);
    } catch(Exception $e){
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>