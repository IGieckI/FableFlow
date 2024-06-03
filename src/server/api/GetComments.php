<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__ . '/../models/Comment.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    // Number of comments to retrieve
    $chapter_id = isset($_GET['chapter_id']) ? (int)$_GET['chapter_id'] : 1;
    try {
        $comments = $db->findBy(['chapter_id' => $chapter_id], null, null, Tables::Comments);        
        foreach ($comments as $comment) {
            $user = $db->findBy(['username' => $comment['username']], null, null, Tables::Users);            
            $likes = $db->count(['comment_id' => $comment['comment_id'], 'is_dislike' => 0], Tables::Likes);
            $likes = $likes[0]['COUNT(*)'];
            $dislikes = $db->count(['comment_id' => $comment['comment_id'], 'is_dislike' => 1], Tables::Likes);
            $dislikes = $dislikes[0]['COUNT(*)'];            
            $result[] = new Comment($comment['comment_id'], $user[0]['icon'], $user[0]['username'], $comment['comment_datetime'], $comment['content'], $likes, $dislikes);
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