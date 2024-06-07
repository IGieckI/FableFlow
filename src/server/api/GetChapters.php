<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__ . '/../models/Post.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    try {
        $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
        // Define the number of posts to load at a time
        define('POSTS_PER_LOAD', 10);

        // Number of page to retrieve
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page);

        // Calculate the starting point for retrieving posts
        $start = ($page - 1) * POSTS_PER_LOAD;

        $username = $_SESSION['username'];
        $chapters = $db->complexQuery("
        (
            SELECT 
                c.story_id AS story_id,
                c.chapter_id AS chapter_id,
                c.chapter_title AS chapter_title,
                c.content AS content,
                c.picture AS picture,
                c.publication_datetime AS publication_datetime
            FROM chapters AS c
            JOIN stories AS s ON c.story_id = s.story_id
            JOIN users AS u ON s.username = u.username
            WHERE s.username IN (
                SELECT followed 
                FROM followers 
                WHERE follower = ?
            )
            ORDER BY c.publication_datetime DESC 
            LIMIT ?, ?
        )
        UNION ALL
        (
            SELECT 
                c.story_id AS story_id,
                c.chapter_id AS chapter_id,
                c.chapter_title AS chapter_title,
                c.content AS content,
                c.picture AS picture,
                c.publication_datetime AS publication_datetime
            FROM chapters AS c
            JOIN stories AS s ON c.story_id = s.story_id
            JOIN users AS u ON s.username = u.username
            WHERE s.username NOT IN (
                SELECT followed 
                FROM followers 
                WHERE follower = ?
            )
            ORDER BY c.publication_datetime DESC 
            LIMIT ?, ?
        )
        LIMIT ?, ?
        ", [$username, $start, POSTS_PER_LOAD, $username, $start, POSTS_PER_LOAD, $start, POSTS_PER_LOAD], ['s', 'i', 'i', 's', 'i', 'i', 'i', 'i']);
        
        foreach ($chapters as $chapter) {
            $story = $db->findBy(['story_id' => $chapter['story_id']], ['story_id' => 'i'], null, null, Tables::Stories);
            $story = $story[0];
            $user = $db->findBy(['username' => $story['username']], ['username' => 's'], null, null, Tables::Users);
            $user = $user[0];
            $likes = $db->count(['chapter_id' => $chapter['chapter_id']], ['chapter_id' => 'i'], Tables::Likes);
            $comments = $db->count(['chapter_id' => $chapter['chapter_id']], ['chapter_id' => 'i'], Tables::Comments);
            $liked = $db->chapterStatus($chapter['chapter_id'], $_SESSION['username']);
            $result[] = new Post($chapter['chapter_id'], $user['icon'], $user['username'], $chapter['publication_datetime'], $story['title'], $chapter["chapter_title"], $comments, $chapter['picture'], $likes, $chapter['content'], $liked);
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
