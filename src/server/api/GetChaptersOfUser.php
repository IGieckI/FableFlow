<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__ . '/../models/Post.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    try {
    
        $chapters = $db->complexQuery('SELECT' . ' ' .
                                        'c.story_id as story_id,
                                        c.chapter_id as chapter_id,
                                        c.content as content,
                                        c.publication_datetime as publication_datetime' . ' ' . 
                                        'FROM chapters as c JOIN stories as s ON c.story_id = s.story_id' . ' ' .
                                        'JOIN users as u ON s.username = u.username' . ' ' .
                                        "WHERE s.username='". $_GET['user'] . "'");

        foreach ($chapters as $chapter) {
            $story = $db->findBy(['story_id' => $chapter['story_id']], null, null, Tables::Stories);
            $story = $story[0];
            $user = $db->findBy(['username' => $story['username']], null, null, Tables::Users);
            $user = $user[0];
            $likes = $db->count(['chapter_id' => $chapter['chapter_id']], Tables::Likes);
            $likes = $likes[0]['COUNT(*)'];
            $comments = $db->count(['comment_id' => $chapter['chapter_id']], Tables::Comments);
            $comments = $comments[0]['COUNT(*)'];
            $liked = $db->chapterStatus($chapter['chapter_id'], $_SESSION['username']);
            $result[] = new Post($chapter['chapter_id'],$user['icon'], $user['username'], $chapter['publication_datetime'], $story['title'], $comments, $chapter['picture'], $likes, $chapter['content'], $liked);
        }
        $db->disconnect();
        $db = null;
        header('Content-Type: application/json');
        error_log("aaaaaaaaaaaaaaaaaaaaaaaaaa");
        echo json_encode($result);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>