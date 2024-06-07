<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    header('Content-Type: application/json');

    $response = array();

    try {
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
        
        $optionId = $_POST['optionId'];
        $username = $_SESSION['username'];
        error_log("PARTE 1");
        $del = $db->complexQuery("DELETE oc
                                FROM option_choices oc
                                INNER JOIN options o ON oc.option_id = o.option_id
                                WHERE oc.username = ?
                                AND o.pool_id = (SELECT pool_id FROM options WHERE option_id = ?)
                                ", [$username, $optionId], ['s', 'i']);
        error_log("PARTE 2" . print_r($del, true));
        $reponse = $db->postUserPoolChoice($username, $optionId);
        error_log("PARTE 3" . print_r($response, true));
        
        echo json_encode($response);
    } catch (Exception $e) {
        error_log($e->getMessage());
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }    

    $db->disconnect();
    $db = null;
?>
