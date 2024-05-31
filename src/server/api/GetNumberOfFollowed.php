<?php

include '../utilities/DbHelper.php';

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

$result = $db->complexQuery("SELECT count(*) as followed FROM followers WHERE follower='".$_GET['username']."'")[0]['followed'];

$db->disconnect();

echo json_encode(['nfollowed'=>$result]);

?>