<?php 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

json_encode(['result'=>isset($_SESSION['LOGGED'])]);
    
?>