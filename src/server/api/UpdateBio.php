<?php

require __DIR__ . '/../utilities/DbHelper.php';

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

$db->update(['description'=>"'".$_POST['newbio']."'"], [], Tables::Users);

$db->disconnect();
        $db = null;

?>