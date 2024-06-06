<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_SESSION['username'];
        $chapter_id = $_POST['chapter_id'];
        $content = $_POST['content'];
        
        // Validate and sanitize
        $content = htmlspecialchars($content);

        try {
            $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
            $db->postComment($username, $chapter_id, $content);

            // Notify the author of the chapter
            $chapter = $db->findBy(['id' => $chapter_id], null, null, Tables::Chapters)[0];
            $story = $db->findBy(['id' => $chapter['story_id']], null, null, Tables::Stories)[0];
            $author = $db->findBy(['username' => $story['username']], null, null, Tables::Users)[0];
            $db->generateNotification($author['username'], $username . ' commented on your chapter: ' . $chapter['title']);
            
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
        $db->disconnect();
        $db = null;
    }
?>
