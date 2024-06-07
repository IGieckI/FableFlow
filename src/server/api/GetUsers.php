<?php

/* API to get all user's usernames and icons */

require __DIR__ . '/../utilities/DbHelper.php';
    
try{
    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
    echo json_encode($db->findBy([],[], null, null, Tables::Users, null, ['username', 'icon']));

$db->disconnect();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>