<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__ . '/../models/Post.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
        $chapters = $db->complexQuery('SELECT '.
                                        'c.story_id as story_id,
                                        c.chapter_id as chapter_id,
                                        c.chapter_title AS chapter_title,
                                        c.content as content,
                                        c.picture as picture,
                                        c.publication_datetime as publication_datetime' . ' ' . 
                                        'FROM chapters as c JOIN stories as s ON c.story_id = s.story_id' . ' ' .
                                        'JOIN users as u ON s.username = u.username' . ' ' .
                                        "WHERE s.username=?", [$_GET['user']], ['s']);

        foreach ($chapters as $chapter) {
            $story = $db->findBy(['story_id' => $chapter['story_id']], ['story_id' => 'i'], null, null, Tables::Stories);
            $story = $story[0];
            $user = $db->findBy(['username' => $story['username']], ['username' => 's'], null, null, Tables::Users);
            $user = $user[0];
            $likes = $db->count(['chapter_id' => $chapter['chapter_id']], ['chapter_id' => 'i'], Tables::Likes);
            $comments = $db->count(['chapter_id' => $chapter['chapter_id']], ['chapter_id' => 'i'], Tables::Comments);
            $liked = $db->chapterStatus($chapter['chapter_id'], $_SESSION['username']);
            $result[] = new Post($chapter['chapter_id'],$user['icon'], $user['username'], $chapter['publication_datetime'], $story['title'], $chapter['chapter_title'], $comments, $chapter['picture'], $likes, $chapter['content'], $liked);
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