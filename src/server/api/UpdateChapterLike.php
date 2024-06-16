<?php
    require __DIR__ . '/../utilities/DbHelper.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try{
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_SESSION['username'];
            $chapterId = $_POST['chapterId'];


            $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
            
            $chapterStatus = $db->chapterStatus($chapterId, $username);
            
            $author = $db->complexQuery("SELECT s.username as username
                                    FROM chapters as c JOIN stories as s ON c.story_id = s.story_id
                                    WHERE (c.chapter_id=?)", [$chapterId], ['i'])[0]['username'];
            if ($chapterStatus == 0) {
                $db->updateChapterLikes($username, $chapterId, "like");
                $db->generateNotification($author, $username . " liked your story!");
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
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>
