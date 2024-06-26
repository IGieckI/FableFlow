<?php
require __DIR__ . '/../utilities/DbHelper.php';
require __DIR__ . '/../models/Post.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

try {
    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);
    define('POSTS_PER_LOAD', 10);

    // Number of page to retrieve
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max(1, $page);

    $start = ($page - 1) * POSTS_PER_LOAD;

    $username = $_SESSION['username'];

    $result = [];

    // Query for chapters from followed users
    $followedChaptersQuery = "
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
        LIMIT ?, ?";

    $paramsFollowed = [$username, $start, POSTS_PER_LOAD];
    $typesFollowed = ['s', 'i', 'i'];

    $followedChapters = $db->complexQuery($followedChaptersQuery, $paramsFollowed, $typesFollowed);

    // Query for chapters from non-followed users
    $nonFollowedChaptersQuery = "
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
        LIMIT ?, ?";

    $paramsNonFollowed = [$username, $start, POSTS_PER_LOAD];
    $typesNonFollowed = ['s', 'i', 'i'];

    $nonFollowedChapters = $db->complexQuery($nonFollowedChaptersQuery, $paramsNonFollowed, $typesNonFollowed);

    $chapters = array_merge($followedChapters, $nonFollowedChapters);

    // Sort combined chapters by publication datetime in descending order
    usort($chapters, function($a, $b) {
        return strtotime($b['publication_datetime']) - strtotime($a['publication_datetime']);
    });
    $chapters = array_slice($chapters, 0, POSTS_PER_LOAD);

    
    foreach ($chapters as $chapter) {
        $story = $db->findBy(['story_id' => $chapter['story_id']], ['story_id' => 'i'], null, null, Tables::Stories);
        if ($story) {
            $story = $story[0];
            $user = $db->findBy(['username' => $story['username']], ['username' => 's'], null, null, Tables::Users);
            if ($user) {
                $user = $user[0];
                $likes = $db->count(['chapter_id' => $chapter['chapter_id']], ['chapter_id' => 'i'], Tables::Likes);
                $comments = $db->count(['chapter_id' => $chapter['chapter_id']], ['chapter_id' => 'i'], Tables::Comments);
                $liked = $db->chapterStatus($chapter['chapter_id'], $_SESSION['username']);
                $result[] = new Post($chapter['chapter_id'], $user['icon'], $user['username'], $chapter['publication_datetime'], $story['title'], $chapter["chapter_title"], $comments, $chapter['picture'], $likes, $chapter['content'], $liked);
            }
        }
    }

    $db->disconnect();
    $db = null;
    header('Content-Type: application/json');

    echo json_encode($result);
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
