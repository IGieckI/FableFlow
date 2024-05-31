<?php
    require __DIR__ . '/../utilities/DbHelper.php';
    require __DIR__ . '/../models/Post.php';

    $db = new DbHelper(HOST, USER, PASS, DB, PORT, SOCKET);

    // Define the number of posts to load at a time
    define('POSTS_PER_LOAD', 10);

    // Number of page to retrieve
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = max(1, $page);

    // Calculate the starting point for retrieving posts
    $start = ($page - 1) * POSTS_PER_LOAD;

    try {
        if (isset($_GET['user'])) {
            $chapters = $db->complexQuery('SELECT' . ' ' .
                                            'c.story_id as story_id,
                                            c.chapter_id as chapter_id,
                                            c.content as content,
                                            c.publication_datetime as publication_datetime' . ' ' . 
                                            'FROM chapters as c JOIN stories as s ON c.story_id = s.story_id' . ' ' .
                                            'JOIN users as u ON s.username = u.username' . ' ' .
                                            "WHERE s.username='". $_GET['user'] . "'");
            //error_log($_GET['username']);
        } else {
            $chapters = $db->findBy([], POSTS_PER_LOAD, $start, Tables::Chapters);
        }
        //print_r($chapters);
        foreach ($chapters as $chapter) {
            $story = $db->findBy(['story_id' => $chapter['story_id']], null, null, Tables::Stories);
            $story = $story[0];
            $user = $db->findBy(['username' => $story['username']], null, null, Tables::Users);
            $user = $user[0];
            $likes = $db->count(['chapter_id' => $chapter['chapter_id']], Tables::Likes);
            $likes = $likes[0]['COUNT(*)'];
            $comments = $db->count(['comment_id' => $chapter['chapter_id']], Tables::Comments);
            $comments = $comments[0]['COUNT(*)'];

            $result[] = new Post($chapter['chapter_id'],$user['icon'], $user['username'], $chapter['publication_datetime'], $story['title'], $comments, $likes, $chapter['content']);
        }
        $db->disconnect();
        header('Content-Type: application/json');

        echo json_encode($result);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
?>