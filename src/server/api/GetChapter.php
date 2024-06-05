<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__ . '/../models/Post.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }


    try {        
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
    
        $chapter = $db->complexQuery('SELECT ' .
                                    'c.story_id as story_id,
                                    c.chapter_id as chapter_id,
                                    c.content as content,
                                    c.picture as picture,
                                    c.publication_datetime as publication_datetime
                                    FROM chapters as c JOIN stories as s ON c.story_id = s.story_id
                                    JOIN users as u ON s.username = u.username
                                    WHERE (c.chapter_id='. $_GET['chapterId'] . ')');
        $chapter = $chapter[0];
        if (count($chapter) == 0) {
            throw new Exception('Chapter not found');
        }
        error_log("Chapter: " . print_r($chapter, true));
        $story = $db->findBy(['story_id' => $chapter['story_id']], null, null, Tables::Stories)[0];
        error_log("Story: " . print_r($story, true));
        $user = $db->findBy(['username' => $story['username']], null, null, Tables::Users)[0];
        error_log("User: " . print_r($user, true));
        $likes = $db->count(['chapter_id' => $chapter['chapter_id']], Tables::Likes)[0]['COUNT(*)'];
        error_log("Likes: " . print_r($likes, true));
        $comments = $db->count(['comment_id' => $chapter['chapter_id']], Tables::Comments)[0]['COUNT(*)'];
        error_log("Comments: " . print_r($comments, true));
        $liked = $db->chapterStatus($chapter['chapter_id'], $_SESSION['username']);
        error_log("Liked: " . print_r($liked, true));
        $result[] = new Post($chapter['chapter_id'],$user['icon'], $user['username'], $chapter['publication_datetime'], $story['title'], $comments, $chapter['picture'], $likes, $chapter['content'], $liked);
        
        $db->disconnect();
        $db = null;
        header('Content-Type: application/json');

        echo json_encode($result);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>