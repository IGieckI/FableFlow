<?php

/* API to get all user's usernames and icons */

require __DIR__ . '/../utilities/DbHelper.php';
    
$db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

echo json_encode($db->findBy([],[], null, null, Tables::Users, null, ['username', 'icon']));

$db->disconnect();

?>