<?php
    require '../utilities/DbHelper.php';
    require '../models/Notification.php';

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    // Check for the API parameter correctness
    if (isset($_GET['username'])) {
        $username = $_GET['username'];
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Username is required']);
        exit();
    }

    // Retrieve all the notifications for the user
    try {
        $notifications = $db->findBy(['username' => $username], null, null, Tables::Notifications);
        foreach ($notifications as $notification) {
            $result[] = new Notification($notification['notification_id'], $notification['username'], $notification['notification_datetime'], $notification['content']);
        }
        $db->disconnect();
        header('Content-Type: application/json');
        
        echo json_encode($result);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>