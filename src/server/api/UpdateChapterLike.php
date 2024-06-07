<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_SESSION['username'];
        $chapterId = $_POST['chapterId'];

        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
        
        $chapterStatus = $db->chapterStatus($chapterId, $username);

        if ($chapterStatus == 0) {
            $db->updateChapterLikes($username, $chapterId, "like");
        } else {
            $db->updateChapterLikes($username, $chapterId, "unlike");
        }

        $chapterStatus = $db->chapterStatus($chapterId, $username);

        // Use the count function to get the number of likes of the chapter
        $likes = $db->count(['chapter_id' => $chapterId], ['chapter_id' => 'i'], Tables::Likes);

        $db->disconnect();
        $db = null;

        echo json_encode(['likes' => $likes, 'status' => $chapterStatus]);
    } else {
        echo 'Invalid request method';
    }
?>
