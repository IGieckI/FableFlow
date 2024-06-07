<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
try{
    $_SESSION['username'] = "";
    $_SESSION['LOGGED'] = false;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>