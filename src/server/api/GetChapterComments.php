<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__ . '/../models/Comment.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

        $chapter_id = (int)$_GET['chapter_id'];

        $comments = $db->findBy(['chapter_id' => $chapter_id], ['chapter_id' => 'i'], null, null, Tables::Comments);        
        foreach ($comments as $comment) {
            $user = $db->findBy(['username' => $comment['username']], ['username' => 's'], null, null, Tables::Users);            
            $likes = $db->count(['comment_id' => $comment['comment_id'], 'is_dislike' => 0], ['comment_id' => 'i', 'is_dislike' => 'i'], Tables::Likes);
            $dislikes = $db->count(['comment_id' => $comment['comment_id'], 'is_dislike' => 1], ['comment_id' => 'i', 'is_dislike' => 'i'], Tables::Likes);
            $commentStatus = $db->commentStatus($comment['comment_id'], $_SESSION['username']);
            $result[] = new Comment($comment['comment_id'], $user[0]['icon'], $user[0]['username'], $comment['comment_datetime'], $comment['content'], $likes, $dislikes, $commentStatus);
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