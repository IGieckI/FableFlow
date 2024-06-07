<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try{
        echo json_encode(['result'=>(isset($_SESSION['LOGGED']) &&
                            isset($_SESSION['username']))?$_SESSION['username']:'']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>