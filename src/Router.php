<?php
    
    session_start();

    $cookie_name = "request";
    $cookie_value = "ok";
    
    $request = $_GET['url'];
    $ip = $_SESSION['REMOTE_ADDR'];

    /* Set up objects needed everywhere */

    switch ($request) {
        case '/FableFlow/src/Index.php':
            /*
            Set up session's obejcts needed for Main page.
            */
            setcookie($cookie_name, $cookie_value, time() + (10), "/"); 
            header('Location: '. $ip . $request);
            exit;
            break;
        default:
            include '404.php';
            break;
    }

?>