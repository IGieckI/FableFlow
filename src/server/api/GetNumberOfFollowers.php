<?php

include '../utilities/DbHelper.php';


$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

$result = $db->complexQuery("SELECT count(*) as followers FROM followers WHERE followed='".$_POST['username']."'")[0]['followers'];

echo json_encode(['nfollowers'=>$result]);

?>