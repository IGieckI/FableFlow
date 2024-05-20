<?php

require __DIR__ . '/../utilities/DbHelper.php';

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

error_log('------------------------------------'.$_GET['followed'].'--------'.$_GET['follower']);

if ($_POST['isAlreadyFollowing']=='true') {
    $db->deleteBy(['followed'=>$_POST['followed'], 'follower'=>$_POST['follower']], Tables::Followers);
} else {
    $db->insertInto(["'".$_POST['followed']."'", "'".$_POST['follower']."'"], Tables::Followers);
}

$db->disconnect();

?>