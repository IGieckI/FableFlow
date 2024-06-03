<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    $db->update(['description'=>"'".$_POST['newbio']."'"], [], Tables::Users);

    $db->disconnect();
    $db = null;
?>