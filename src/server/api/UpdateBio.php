<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

if (isset($_SESSION['LOGGED'])) {
        $db->update(['description'=>"'".$_POST['newbio']."'"], ['username'=>"'".$_SESSION['username']."'"], Tables::Users);
}


    $db->disconnect();
    $db = null;
?>