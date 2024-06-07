<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try{
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

        if (isset($_SESSION['LOGGED'])) {
            $db->update(['description'=>"'".$_POST['newbio']."'"], ['username'=>"'".$_SESSION['username']."'"], Tables::Users);
        }

        $db->disconnect();
        $db = null;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>