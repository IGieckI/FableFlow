<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $chapter_id = $_POST['chapter_id'];
        $content = $_POST['content'];
        
        // Validate and sanitize
        $content = htmlspecialchars($content);

        try {
            $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
            $db->postComment($username, $chapter_id, $content, date('Y-m-d H:i:s'));
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        $db->disconnect();
    }
?>
