<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__ . '/../models/Notification.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    // Check for the API parameter correctness
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    } else {
        $username = "";
        http_response_code(400);
        echo json_encode(['error' => "You must be logged in to view notifications."]);
    }

    // Retrieve all the notifications for the user
    try {
        $notifications = $db->findBy(['username' => $username], null, null, Tables::Notifications);
        $result = [];
        foreach ($notifications as $notification) {
            array_push($result, new Notification($notification['notification_id'], $notification['username'], $notification['notification_datetime'], $notification['content']));
        }
        $db->disconnect();
        $db = null;
        header('Content-Type: application/json');
        
        echo json_encode($result);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>