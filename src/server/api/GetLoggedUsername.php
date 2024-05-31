<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    echo json_encode(['result'=>(isset($_SESSION['LOGGED']) &&
                            isset($_SESSION['username']))?$_SESSION['username']:'']);
?>