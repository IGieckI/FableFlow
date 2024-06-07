<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

        // Check for the API parameter correctness
        if (isset($_POST['notificationId'])) {
        $notificationId = $_POST['notificationId'];
        } else {
        http_response_code(500);
        echo json_encode(['error' => 'Notification ID not provided']);
        exit(0);
        }
        // Delete the notification with the given ID
        $deleted = $db->deleteBy(['notification_id' => $notificationId], ['notification_id' => 'i'], Tables::Notifications);
        
        if ($deleted) {
            echo json_encode(['success' => 'Notification deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Notification not found']);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>
