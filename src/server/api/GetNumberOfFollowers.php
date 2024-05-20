<?php

include '../utilities/DbHelper.php';


$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

$result = $db->complexQuery("SELECT count(*) as followers FROM followers WHERE followed='".$_GET['username']."'")[0]['followers'];

$db->disconnect();

echo json_encode(['nfollowers'=>$result]);

?>