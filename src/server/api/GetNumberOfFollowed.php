<?php

include '../utilities/DbHelper.php';

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

$result = $db->complexQuery("SELECT count(*) as followed FROM followers WHERE follower='".$_POST['username']."'")[0]['followed'];

echo json_encode(['nfollowed'=>$result]);

?>