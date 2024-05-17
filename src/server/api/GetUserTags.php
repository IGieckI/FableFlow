<?php

include '../utilities/DbHelper.php';

$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

$result = $db->complexQuery("SELECT ut.name as tag FROM user_tag as ut WHERE ut.username='".$_POST['username']."'");

$db->disconnect();

echo json_encode(["tags"=>$result]);

?>