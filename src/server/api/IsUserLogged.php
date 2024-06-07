<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try{
        json_encode(['result'=>isset($_SESSION['LOGGED'])]); 
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]); 
    }
?>